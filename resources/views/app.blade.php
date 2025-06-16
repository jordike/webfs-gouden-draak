<!DOCTYPE html>

<html lang="nl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title inertia>The Golden Dragon</title>

        @routes
        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>

    <body class="bg-[#8b0000]">
        @inertia
    </body>

</html>
