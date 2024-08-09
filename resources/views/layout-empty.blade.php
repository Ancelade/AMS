<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/scss/styles_dark.scss'])
    <title>AMS</title>
</head>
<body>


<div class="content">

    <div class="main">

        <div class="page">
            {{ $slot }}
        </div>


    </div>
</div>


@vite(['resources/js/app.js'])
</body>
</html>
