# My Math Calculator

## Project Structure

All pages are located in ```/pages```.
Each page has its own dir, named by the english page slug (default lang in code).
Translations for the slug exist in the locales and will be loaded on deploy, then stored in a sitemap file.

If sub dirs are required, pages can be placed inside a category dir.

The order in navigation listing can be affected by preceding an index before the page slug.
They are separated by an underscore: <index>_<page-slug>.
However, this index is optional if order is not important. In that case the pages get ordered alphabetically after indexed pages.

The ```/templates``` dir contains the site's global layout and error pages.
The page content (```page.php``` from the specific page) is imported into ```main.php```.

In ```/lib``` are all useful libraries, helpers and other scripts.

```/styles``` contains global styles as described in the following sections.

The webserver points to ```/public``` which contains all publicly available assets as well as the main entrypoint ```index.php```.

For the home page, a special page dir named ```home``` is needed.

```
/pages
    /home
        /locales
            de.json
            en.json
            es.json
            ...
        /snippets
            calculator.php
            dataTable.php
            ...
        /images
            image1.jpg
            image2.png
            ...
        styles.sass
        page.php

    /<index>_<001_category-slug>
        de.json
        en.json
        es.json
        ...
        /<index>_<001_page-slug>
            /locales
                de.json
                en.json
                es.json
                ...
            /snippets
                calculator.php
                dataTable.php
                ...
            /images
                image1.jpg
                image2.png
                ...
            styles.sass
            page.php
    sitemap.xml

/templates
    head.php
    header.php
    main.php
    footer.php
    navigation.php
    404.php

/locales
    de.json
    en.json
    es.json
    ...

/styles
    _variables.sass
    _globals.sass
    ...
    styles.sass

/lib
    Pageload.php
    ExternalLink.php
    Sitemap.php
    RichSnippets.php
    ...

/public
    /images
        /<page-slug>
            image1.jpg
            image2.png
            ...
        my-math-calculator.svg
        header-image.jpg
        ...
    /js
        ...
    /styles
        /<page-slug>
            styles.css
        styles.css
    index.php
    robots.txt
    sitemap.xml
    .htaccess
```

## Global Redirects

Via .htaccess, all requests get redirected to ```/public/index.php```.
From there the sitemap is used to load the needed page by ```/lib/Pageload.php```.
If no page can be found, a 404 error page will be returned.


## Templates

The initial page structure is constructed by ```/lib/Pageload.php```, then the page-specific content gets imported.


## Sitemap Creation

The sitemap is generated manually or at least on every deploy.
```/lib/Sitemap.php``` scans the ```/pages``` dir and extracts all page URLs with its slugs respectively in every available language.
The sitemap is then copied (and modified to be used publicly) to ```/public``` dir.


## Locales

Locales contain three main props. "slug" is used in URL for that specific language. If slug is not available in a locale, it defaults to english (dir name).
"body" consists of two props: "headline" which is used for h1 and "content" that provides all unique page content.
"meta" is optional and can be used for any supported meta tags.

```
{
    slug: "",
    navTitle: "",
    meta: {
        ...
        schemaHowTo: {
            ...
        },
        schemaFAQ: {
            ...
        }
    },
    body: {
        headline: "",
        content: ""  <-- markdown content
    }
}
```


## Markdown Content

Basic and extended syntax support (see https://www.markdownguide.org/cheat-sheet/).
Custom snippets can be used like this ```===customSnippet===``` (filename from page's snippets dir).


## Global Styling

Global styles are defined in the ```/styles``` dir. All needed variables are stored in ```_variables.sass```, which can also be loaded into custom stylings.
The compiled ```styles.css``` is placed in ```/public/styles```.


## Custom Styling

Every page can have its own unique styles. For that a ```styles.css``` needs to be added to the page's dir.
The file will be loaded separately.
The compiled ```styles.css``` is placed in ```/public/styles/<page-slug>```.


## Global Images

Global images are available from ```/public/images``` dir.


## Page-related Images

For page content, images can be placed in ```/<page-slug>/images```.
On deploy they will be copied to ```/public/images/<page-slug>```.
That way the source files can be optimized from within the deploy pipeline in the future (scaling, compression etc.).
