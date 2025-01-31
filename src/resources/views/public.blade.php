<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        <meta name="description" content="my DESCRIPTION FOR PROJECT 2. Books">
    </head>

    <body>
        <div id="root"></div>

        @viteReactRefresh
        @vite('resources/js/index.jsx')
    </body>
</html>