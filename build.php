<?php
require_once("./vendor/autoload.php");

// poc; will be moved to an environment variable or replaced by server root
define("BASEPATH", "http://localhost/100ducks/my-math-calculator/public");
// define("BASEPATH", "https://machmamathe.de");


function removeLocaleDirectories($dir, $root = true) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object == "." || $object == "..") continue;
            if ($root && strlen($object) != 2) continue;

            if (is_dir($dir . "/" . $object) && !is_link($dir . "/" . $object)) {
                removeLocaleDirectories($dir . "/" . $object, false);
            } else {
                unlink($dir . "/" . $object);
            }
        }
        if (!$root) rmdir($dir);
    }
}


// ====================================================
// LOADERS
// ====================================================
function loadGlobals () {
    $parser = new Mni\FrontYAML\Parser;
    $globals = [];
    $list = @scandir("./config");
    if (empty($list)) return array();

    foreach ($list as $item) {
        if ($item == ".." || $item == ".") continue;
        $globals[str_replace(".yml", "", $item)] = yaml_parse_file("./config/" . $item);
    }

    return $globals;
}


function loadPage ($path) {
    $parser = new Mni\FrontYAML\Parser;
    $document = $parser->parse(file_get_contents($path));

    return array(
        "page" => $document->getYAML(),
        "content" => $document->getContent(),
    );
}


function loadPages ($dir, $path = "", $localeSegments = [], &$pages = [], &$locales = []) {
    $path = $path . $dir;

    $list = @scandir($path);
    if (empty($list)) return;

    $subdirs = [];

    foreach ($list as $item) {
        if ($item == ".." || $item == "." || in_array($item, ["images", "snippets"])) continue;

        if (is_dir($path . "/" . $item)) {
            $subdirs[] = $item;
        } else if (str_ends_with($item, ".md")) {
            $pageData = loadPage($path . "/" . $item);

            $locale = str_replace(".md", "", $item);
            $slug = isset($pageData["page"]["slug"]) ? $pageData["page"]["slug"] : "";
            $localeSegments[$locale] = (isset($localeSegments[$locale]) ? $localeSegments[$locale] : "") . "/" . $slug;

            if (!in_array($locale, $locales)) $locales[] = $locale;

            $pages[] = array_merge([
                "url" => str_replace("//", "/", $localeSegments[$locale] . "/"),
                "locale" => $locale,
                "path" => $path,
            ], $pageData);
        }
    }

    foreach ($subdirs as $subdir) {
        $children = loadPages($subdir, $path . "/", $localeSegments, $pages, $locales);
    }

    return $pages;
}


function loadAssetLocales ($sourcePath, $locale) {
    $filenames = [];

    if (file_exists($sourcePath . "/images/" . $locale . ".yml")) {
        $filenames = yaml_parse_file($sourcePath . "/images/" . $locale . ".yml");
    }

    return $filenames;
}


// ====================================================
// CONTENT FILTERS
// ====================================================
function addHeadlineAnchors ($content) {
    $markupFixer  = new TOC\MarkupFixer();
    $content = $markupFixer->fix($content);
    return $content;
}

function addTableOfContents ($content) {
    $tocGenerator = new TOC\TocGenerator();
    if (strpos("===TOC===",$content) !== false) {
        $content = str_replace('<div id="page">', '<div id="page2">', $content);
    }
    $content = str_replace("===TOC===", '<div id="table-of-contents">' . $tocGenerator->getHtmlMenu($content) . '</div>', $content);
    return $content;
}


function addSnippets ($content, $path) {
    if (is_dir($path . "/snippets")) {
        $list = @scandir($path . "/snippets/");

        foreach ($list as $item) {
            if ($item == ".." || $item == ".") continue;
            $content = str_replace("===" . str_replace(".php", "", $item) . "===", file_get_contents($path . "/snippets/" . $item), $content);
        }
    }
    return $content;
}


function addReferenceLinks ($content, $locale, $pages) {
    foreach ($pages as $page) {
        if ($page["locale"] !== $locale) continue;
        $pathBasename = explode("_", basename($page["path"]));
        $reference = end($pathBasename);

        $linkUrl = BASEPATH . "/" . $page["locale"] . $page["url"];
        $htmlLink = '<a href="' . $linkUrl . '" title="' . $page["page"]["title"] . '">' . $page["page"]["title"] . '</a>';
        $content = str_replace("@@" . $reference . "@@", $htmlLink, $content);
    }
    return $content;
}


function addLocalizedAssets ($content, $assets, $sizes) {
    foreach ($assets as $name => $asset) {
        $content = str_replace($name, $asset, $content);
    }

    $dom = new DOMDocument;
    $dom->loadHTML(mb_convert_encoding($content, "HTML-ENTITIES", "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);

    foreach ($xpath->query("//img") as $node) {
        $asset = pathinfo($node->getAttribute("src"));

        $srcset = [];
        foreach ($sizes as $size) {
            $srcset[] = $asset["dirname"] . "/" . $asset["filename"] . "_" . $size . "." . $asset["extension"] . " " . $size . "w";
        }

        $node->setAttribute("srcset", implode(", ", $srcset));
    }

    return $dom->saveHTML();
}


function removeHTMLComments ($content) {
    $content = preg_replace("~<!--(?!<!)[^\[>].*?-->~s", "", $content);
    return $content;
}


// ====================================================
// NAVIGATION
// ====================================================
function renderNavigation ($pages) {
    $navData = prepareNavigation($pages);
    $nav = [];

    foreach ($navData as $locale => $localizedNavData) {
        $nav[$locale] = createNavigationHTML($localizedNavData);
    }

    return $nav;
}

function prepareNavigation ($pages) {
    $nav = [];

    foreach ($pages as $page) {
        if (isset($page["page"]["hide_in_nav"]) && $page["page"]["hide_in_nav"]) continue;
        $segments = array_filter(explode("/", str_replace("./pages", "", $page["path"])));
        $navLink = array(
            "order" => (integer) basename(explode("_", $page["path"])[0]),
            "url" => "/" . $page["locale"] . $page["url"],
            "title" => $page["page"]["nav_title"],
            "locale" => $page["locale"],
        );

        if(!array_key_exists($page["locale"], $nav)) $nav[$page["locale"]] = [];
        $reference = &$nav[$page["locale"]];

        foreach ($segments as $segment) {
            if (!array_key_exists($segment, $reference)) $reference[$segment] = [];
            $reference = &$reference[$segment];
        }

        $reference = $navLink;
    }

    return $nav;
}


function renderLink ($url, $title) {
    return '<li><a href="' . BASEPATH . $url . '" title="' . $title . '">' . $title . '</a></li>';
}
function renderSublist ($html) {
    return "<li><ul>" . $html . "</ul></li>";
}
function renderList ($html) {
    return "<ul>" . $html . "</ul>";
}


function createNavigationHTML ($nav, $root = true) {
    if (empty($nav)) return "";

    $html = "";
    $outerHtml = "";
    foreach ($nav as $item) {
        if (!is_array($item)) continue;
        if (isset($item["title"])) $outerHtml .= renderLink($item["url"], $item["title"]);

        $keys = array_keys($item);
        $innerHtml = "";

        foreach ($keys as $key) {
            if (isset($item[$key]["title"])) $innerHtml .= renderLink($item[$key]["url"], $item[$key]["title"]);
            if (is_array($item[$key]) && !empty($item[$key])) $innerHtml .= createNavigationHTML($item[$key], false);
        }
        if ($innerHtml != "") $outerHtml .= renderSublist($innerHtml);
    }
    if ($outerHtml != "") $html .= $root ? renderList($outerHtml) : renderSublist($outerHtml);

    return $html;
}


// ====================================================
// BUILDERS
// ====================================================
function buildPage ($pageData, $pages) {
    $content = $pageData["content"];
    $snippets = array();
    $basepath = BASEPATH;

    $locales = $pageData["locales"];
    $globals = json_decode(json_encode($pageData["globals"]));
    $nav = json_decode(json_encode($pageData["nav"]));
    $page = json_decode(json_encode(array_merge(
        $pageData["page"],
        [
            "alternates" => $pageData["alternates"],
            "locale" => $pageData["locale"],
            "url" => "https://" . $pageData["globals"]["host_name"] . "/" . $pageData["locale"] . $pageData["url"],
        ]
    )));

    $content = addLocalizedAssets($content, $pageData["assets"], $pageData["assetSizes"]);
    $content = addSnippets($content, $pageData["path"]);
    $content = addReferenceLinks($content, $pageData["locale"], $pages);
    $content = addHeadlineAnchors($content);
    $content = addTableOfContents($content);

    require("./templates/html.php");
}


function imageCreateFromAny ($filepath) {
    switch (getImageSize($filepath)["mime"]) {
        case "image/gif":
            $image = array(
                "content" => imageCreateFromGif($filepath),
                "type" => "gif",
            );
            break;
        case "image/jpeg":
            $image = array(
                "content" => imageCreateFromJpeg($filepath),
                "type" => "jpeg",
            );
            break;
        case "image/png":
            $image = array(
                "content" => imageCreateFromPng($filepath),
                "type" => "png",
            );
            break;
        default:
            $image = null;
    }

    return $image;
}


function createResponsiveImageSizes ($image, $sizes = []) {
    $images = [];

    foreach ($sizes as $size) {
        $images[$size] = imagescale($image, $size);
    }

    return $images;
}


function buildAssets ($sourcePath, $outputPath, $assetFilenames, $imageSizes) {
    $list = @scandir($sourcePath . "/images");
    if (empty($list)) return array();

    umask(0);
    foreach ($list as $item) {
        if ($item == ".." || $item == "." || str_ends_with($item, ".yml")) continue;
        if (!is_dir($outputPath . "/images")) mkdir($outputPath . "/images", 0777, true);

        $info = pathinfo($sourcePath . "/images/" . $item);
        $outputImage = isset($assetFilenames[$info["filename"]]) ? $assetFilenames[$info["filename"]] : $item;
        $outputNameArray = explode(".",$outputImage);
        $outputFile = ".".$outputNameArray[count($outputNameArray)-1];
        $outputName = basename($outputImage,$outputFile);
        $sourceExtension = "." . $info["extension"];

        copy($sourcePath . "/images/" . $item, $outputPath . "/images/" . $outputName . $sourceExtension);

        $asset = imageCreateFromAny($sourcePath . "/images/" . $item);

        if ($asset != null) {
            $responsiveImages = createResponsiveImageSizes($asset["content"], $imageSizes);

            foreach ($responsiveImages as $size => $responsiveImage) {
                imagepalettetotruecolor($responsiveImage);
                imagewebp($responsiveImage, $outputPath . "/images/" . $outputName . ".webp", 30);

                switch ($asset["type"]) {
                    case "gif":
                        imagegif($responsiveImage, $outputPath . "/images/" . $outputName . "_" . $size . ".gif");
                        break;
                    case "jpeg":
                        imagejpeg($responsiveImage, $outputPath . "/images/" . $outputName . "_" . $size . ".jpg");
                        break;
                    case "png":
                        imagepng($responsiveImage, $outputPath . "/images/" . $outputName . "_" . $size . ".png");
                        break;
                }

                imagedestroy($responsiveImage);
            }
        }

    }
}


function buildSitemap ($pages) {
    $sitemap = "<?xml version='1.0' encoding='utf-8'?><urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9' xmlns:xhtml='http://www.w3.org/1999/xhtml'>";

    foreach ($pages as $page) {
        $sitemap .= "<url>\r\n";
        $sitemap .= "<loc>" . BASEPATH . "/" . $page["locale"] . $page["url"] . "</loc>\r\n";
        $sitemap .= "<lastmod>" . date("Y-m-d", substr($page["page"]["create_date"], 0, -3)) . "</lastmod>\r\n";
        $sitemap .= "<changefreq>daily</changefreq>\r\n";
        $sitemap .= "<priority>1.0</priority>\r\n";

        foreach ($page["alternates"] as $locale => $alternate) {
            $sitemap .= "<xhtml:link rel='alternate' hreflang='" . $locale . "' href='" . $alternate . "'></xhtml:link>\r\n";
        }
        $sitemap .= "<xhtml:link rel='alternate' hreflang='x-default' href='" . BASEPATH . '/' . $page["locale"] . $page["url"] . "'></xhtml:link>\r\n";

        $sitemap .= "</url>\r\n";
    }

    $sitemap .= "</urlset>";
    file_put_contents("./public/sitemap.xml", $sitemap);
}


function addAlternates ($pages) {
    foreach ($pages as $index => $page) {
        $pages[$index]["alternates"] = getAlternateLinks($page, $pages);
    }
    return $pages;
}


function getAlternateLinks ($page, $pages) {
    $alternates = array_filter($pages, function ($p) use ($page) {
        return $p["path"] === $page["path"];
    });

    $alternateLinks = [];
    foreach ($alternates as $alternate) {
        $alternateLinks[$alternate["locale"]] = BASEPATH . '/' . $alternate["locale"] . $alternate["url"];
    }
    return $alternateLinks;
}


function build () {
    $outputBaseDir = "./public";
    removeLocaleDirectories($outputBaseDir);

    $imageSizes = [1200, 900, 600, 300];

    $pages = loadPages("./pages");
    $config = loadGlobals();
    $nav = renderNavigation($pages);
    $pages = addAlternates($pages);

    buildSitemap($pages);

    umask(0);
    foreach ($pages as $page) {
        $outputPath = $outputBaseDir . "/" . $page["locale"] . $page["url"];
        echo "creating page: " . str_replace($outputBaseDir, "", $outputPath) . PHP_EOL;

        if (!is_dir($outputPath)) mkdir($outputPath, 0777, true);
        $assetFilenames = loadAssetLocales($page["path"], $page["locale"]);
        buildAssets($page["path"], $outputPath, $assetFilenames, $imageSizes);

        $pageData = array_merge($page, [
            "globals" => $config[$page["locale"]],
            "nav" => $nav[$page["locale"]],
            "assets" => $assetFilenames,
            "assetSizes" => $imageSizes,
            "locales" => array_keys($nav),
        ]);

        ob_start();
        buildPage($pageData, $pages);
        $renderedPage = ob_get_clean();
        $renderedPage = removeHTMLComments($renderedPage);

        file_put_contents($outputPath . "/index.html", $renderedPage);
    }
}

$time_start = microtime(true);

echo PHP_EOL . "start generating static site..." . PHP_EOL;
echo "==============================================================" . PHP_EOL;
build();
echo "==============================================================" . PHP_EOL;

$time_end = microtime(true);
echo "generating static site done in " . round($time_end - $time_start, 3) . " seconds." . PHP_EOL;
