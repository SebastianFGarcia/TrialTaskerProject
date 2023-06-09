<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="https://res.cloudinary.com/dcvsxucd4/image/upload/v1681155037/trialTasker/favicon_vpj4j0.ico">
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        <script
            src="https://widget.cloudinary.com/v2.0/global/all.js"
            type="text/javascript"
            ></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
