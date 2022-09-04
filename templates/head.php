<!-- Basic TODO -->
<meta name="revisit-after" content="7 days">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="robots" content="index,follow" />

<!-- Globals -->
<meta name="og:email" content="<?= $globals->email ?>">
<meta name="og:site_name" content="<?= $globals->site_name ?>">
<meta name="application-name" content="<?= $globals->site_name ?>">
<meta name="Classification" content="Business">
<meta name="author" content="<?= $globals->site_name ?>">
<meta name="designer" content="<?= $globals->site_name ?>">
<meta name="copyright" content="<?= $globals->site_name ?>">
<meta name="owner" content="<?= $globals->site_name ?>">

<!-- Page Specific -->
<title><?= $page->title ?></title>
<meta name="subject" content="<?= $page->title ?>">
<meta name="description" content="<?= $page->seo->description ?>">
<meta name="keywords" content="<?= implode(",", $page->keywords) ?>">

<meta name="og:title" content="<?= $page->og->title ?>">
<meta name="og:locale" content="<?= $page->locale ?>">
<meta name="og:type" content="article">
<meta name="og:url" content="<?= $page->url ?>">
<meta name="og:image" content="<?= $page->preview_image ?>">
<meta name="og:description" content="<?= $page->seo->description ?>">
<!-- TODO Images path -->
<meta property="twitter:card" content="summary">
<meta property="twitter:site" content="<?= $globals->twitter_site ?>">
<meta property="twitter:url" content="<?= $page->url ?>">
<meta property="twitter:title" content="<?= $page->twitter->title ?>">
<meta property="twitter:description" content="<?= $page->twitter->description ?>">
<meta property="twitter:image" content="<?= $page->preview_image ?>">

<link rel="canonical" href="<?= $page->url ?>">

<!-- Alternate Links-->
<?php
  foreach ((array) $page->alternates as $altLocale => $alternate) {
    echo "<link rel='alternate' hreflang='" . $altLocale . "' href='" . $alternate . "' />";
  }
  echo "<link rel='alternate' hreflang='x-default' href='https://" . $globals->host_name . "/". $globals->language ."/' />";
?>

<!-- Apple Meta Tags-->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta content="yes" name="apple-touch-fullscreen">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">

<!-- Apple Meta Tags-->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name= "viewport" content = "width=device-width initial-scale=1.0">

<!-- Apple Touch Icons TODO-->
<link rel="apple-touch-icon" type="image/png" href="<?= $basepath ?>/images/favicons/apple-touch-icon.png">

<!-- Shortcut Icon TODO -->
<link rel="shortcut icon" type="image/ico" href="<?= $basepath ?>/images/favicons/favicon.ico">

<link rel="manifest" href="<?= $basepath ?>/manifest.json">
<meta name="theme-color" media="(prefers-color-scheme: light)" content="#CCCCCC">
<meta name="theme-color" media="(prefers-color-scheme: dark)" content="#333333">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= $basepath ?>/styles/styles.css">
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

<!-- TODO: Image URL, Author, Published Date-->
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "headline": "<?= $page->title ?>",
      "image": [
        "<?= $page->preview_image ?>"
       ],
      "datePublished": "<?= date('Y-m-d\TH:i:s', substr($page->create_date, 0, -3)) ?>",
      "dateModified": "<?= date('Y-m-d\TH:i:s', substr($page->publish_date, 0, -3)) ?>",
      "author": [{
          "@type": "Person",
          "name": "Floris John",
          "url": "http://instagram.com/flokoooj"
        },
        {
          "@type": "Person",
          "name": "Dominik Brüchler",
          "url": "http://instagram.com/bruechler"
        }]
    }
</script>
