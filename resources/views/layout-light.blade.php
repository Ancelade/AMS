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

    <div class="sidebar" id="sidebar">
        <div class="text-center">
            <img src="/images/logo.svg" class="logo" alt="">
        </div>
        @include('menu')
    </div>
    <div class="main">
        <div class="top">
            <div class="row">
                <div class="toggle-menu">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                         width="24px" height="24px" viewBox="0,0,256,256">
                        <g fill="#adadad" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                           stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                           font-family="none" font-weight="none" font-size="none" text-anchor="none"
                           style="mix-blend-mode: normal">
                            <g transform="scale(10.66667,10.66667)">
                                <path
                                    d="M20.5,7h-17c-0.829,0 -1.5,-0.671 -1.5,-1.5c0,-0.829 0.671,-1.5 1.5,-1.5h17c0.829,0 1.5,0.671 1.5,1.5c0,0.829 -0.671,1.5 -1.5,1.5z"
                                    opacity="0.35"></path>
                                <path
                                    d="M20.5,14h-17c-0.829,0 -1.5,-0.671 -1.5,-1.5c0,-0.829 0.671,-1.5 1.5,-1.5h17c0.829,0 1.5,0.671 1.5,1.5c0,0.829 -0.671,1.5 -1.5,1.5z"></path>
                                <path
                                    d="M20.5,21h-17c-0.829,0 -1.5,-0.671 -1.5,-1.5c0,-0.829 0.671,-1.5 1.5,-1.5h17c0.829,0 1.5,0.671 1.5,1.5c0,0.829 -0.671,1.5 -1.5,1.5z"
                                    opacity="0.35"></path>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="col-8 h-100">
                    <div class="row w-100 no-wrap">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="24px" height="24px" viewBox="0,0,256,256">
                            <g fill="#d0d0d0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                               stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                               font-family="none" font-weight="none" font-size="none" text-anchor="none"
                               style="mix-blend-mode: normal">
                                <g transform="scale(10.66667,10.66667)">
                                    <path
                                        d="M21.414,18.586c-0.287,-0.287 -1.942,-1.942 -2.801,-2.801c-0.719,1.142 -1.686,2.109 -2.828,2.828c0.859,0.859 2.514,2.514 2.801,2.801c0.781,0.781 2.047,0.781 2.828,0c0.781,-0.781 0.781,-2.047 0,-2.828z"></path>
                                    <circle cx="11" cy="11" r="9" opacity="0.35"></circle>
                                </g>
                            </g>
                        </svg>
                        <input type="text" class="muted" placeholder="{{ t('Recherche') }}">
                    </div>
                </div>
                <?php $user = Auth::user(); ?>
                <div class="col-4 h-100 right">
                    <div class="row">
                        <img class="profile_picture"
                             src="{{ $user->getGravatarUrl() }}"
                             alt="">
                        <p>{{ $user->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-light">
            {{ $slot }}
        </div>
    </div>
</div>
@vite(['resources/js/app.js'])

</body>
</html>
