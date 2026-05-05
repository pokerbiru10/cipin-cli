@props([
    'title' => 'CIPIN CLI - Production-ready AI Workflows',
    'description' => 'Power your development with AI agents. CIPIN CLI brings production-ready AI workflows to your terminal.',
    'keywords' => 'AI CLI, AI agents, development tools, AI workflows, terminal AI',
    'image' => null,
    'url' => null,
    'type' => 'website',
    'author' => 'CIPIN CLI',
    'publishedTime' => null,
    'modifiedTime' => null,
])

@php
    $fullUrl = $url ?? url()->current();
    $ogImage = $image ?? asset('images/cipin-cli-64.png');
    $siteName = 'CIPIN CLI';
@endphp

{{-- Primary Meta Tags --}}
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $author }}">
<meta name="robots" content="index, follow">
<meta name="language" content="Indonesian">
<meta name="revisit-after" content="7 days">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $fullUrl }}">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $fullUrl }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="id_ID">

@if($publishedTime)
    <meta property="article:published_time" content="{{ $publishedTime }}">
@endif

@if($modifiedTime)
    <meta property="article:modified_time" content="{{ $modifiedTime }}">
@endif

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $fullUrl }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- Additional SEO --}}
<meta name="theme-color" content="#ec0b62">
<meta name="msapplication-TileColor" content="#ec0b62">
