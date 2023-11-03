<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Xtreme Motors Inc. is a leading used car dealership in Toronto offering an inventory of used cars and SUV&#039;s available for sale in Canada. Buy your choice of car today." />
	    <link rel="canonical" href="https://www.xtrememotorsinc.ca/" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Xtreme Motors Inc. | Toronto&#039;s Trusted &amp; Reliable Used Car Dealership" />
        <meta property="og:description" content="Xtreme Motors Inc. is a leading used car dealership in Toronto offering an inventory of used cars and SUV&#039;s available for sale in Canada. Buy your choice of car today." />
        <meta property="og:url" content="https://www.xtrememotorsinc.ca/" />
        <meta property="og:site_name" content="Xtreme motors Inc" />
        <meta property="article:modified_time" content="2019-07-23T10:24:27+00:00" />
        <meta name="twitter:label1" content="Est. reading time" />
        <meta name="twitter:data1" content="9 minutes" />
        <script type="application/ld+json" class="yoast-schema-graph">{"@context":"https://schema.org","@graph":[{"@type":"WebPage","@id":"https://www.xtrememotorsinc.ca/","url":"https://www.xtrememotorsinc.ca/","name":"Xtreme Motors Inc. | Toronto's Trusted & Reliable Used Car Dealership","isPartOf":{"@id":"https://www.xtrememotorsinc.ca/#website"},"datePublished":"2013-09-23T13:11:58+00:00","dateModified":"2019-07-23T10:24:27+00:00","description":"Xtreme Motors Inc. is a leading used car dealership in Toronto offering an inventory of used cars and SUV's available for sale in Canada. Buy your choice of car today.","breadcrumb":{"@id":"https://www.xtrememotorsinc.ca/#breadcrumb"},"inLanguage":"en-US","potentialAction":[{"@type":"ReadAction","target":["https://www.xtrememotorsinc.ca/"]}]},{"@type":"BreadcrumbList","@id":"https://www.xtrememotorsinc.ca/#breadcrumb","itemListElement":[{"@type":"ListItem","position":1,"name":"Home"}]},{"@type":"WebSite","@id":"https://www.xtrememotorsinc.ca/#website","url":"https://www.xtrememotorsinc.ca/","name":"Xtreme motors Inc","description":"","potentialAction":[{"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://www.xtrememotorsinc.ca/?s={search_term_string}"},"query-input":"required name=search_term_string"}],"inLanguage":"en-US"}]}</script>
        <link rel="icon" href="/fav.png" type="image/png" sizes="16x16">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
