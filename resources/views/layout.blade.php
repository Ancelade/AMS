<!doctype html>
<html lang="fr" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/scss/styles_dark.scss'])
    <title>AMS</title>
</head>
<body>
<div class="content">
    <div class="selector">
        <div class="item">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 width="24px" height="24px" viewBox="0,0,256,256">
                <g fill="#adadad" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                   stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                   font-family="none" font-weight="none" font-size="none" text-anchor="none"
                   style="mix-blend-mode: normal">
                    <g transform="scale(10.66667,10.66667)">
                        <path
                            d="M7.5,20.02v0c-0.828,0 -1.5,-0.672 -1.5,-1.5v-14c0,-0.828 0.672,-1.5 1.5,-1.5v0c0.828,0 1.5,0.672 1.5,1.5v14c0,0.828 -0.672,1.5 -1.5,1.5z"></path>
                        <path
                            d="M16.5,20v0c-0.828,0 -1.5,-0.672 -1.5,-1.5v-14c0,-0.828 0.671,-1.5 1.5,-1.5v0c0.828,0 1.5,0.672 1.5,1.5v14c0,0.828 -0.672,1.5 -1.5,1.5z"></path>
                        <rect x="7" y="10" width="10" height="3" opacity="0.35"></rect>
                    </g>
                </g>
            </svg>
        </div>
        <div class="item clickable">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 width="24px" height="24px" viewBox="0,0,256,256">
                <g fill="#adadad" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                   stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                   font-family="none" font-weight="none" font-size="none" text-anchor="none"
                   style="mix-blend-mode: normal">
                    <g transform="scale(10.66667,10.66667)">
                        <path d="M5,7c-1.657,0 -3,1.343 -3,3v4c0,1.657 1.343,3 3,3h4v-10z"></path>
                        <path
                            d="M19.766,2.152c-0.75,-0.311 -1.607,-0.139 -2.18,0.434c-1.228,1.227 -5.164,4.414 -8.586,4.414c-1.104,0 -2,0.896 -2,2v6c0,1.104 0.896,2 2,2c3.4,0 7.352,3.188 8.586,4.414c0.383,0.383 0.893,0.586 1.414,0.586c0.258,0 0.518,-0.05 0.766,-0.152c0.747,-0.31 1.234,-1.039 1.234,-1.848v-16c0,-0.809 -0.487,-1.538 -1.234,-1.848z"
                            opacity="0.35"></path>
                        <path
                            d="M9,13h-4c0,0 1,7.324 1,7.5c0,0.828 0.672,1.5 1.5,1.5c0.828,0 1.5,-0.672 1.5,-1.5c0,-0.176 0,-7.5 0,-7.5z"></path>
                        <path
                            d="M21,9.184v5.633c1.163,-0.413 2,-1.512 2,-2.816c0,-1.304 -0.837,-2.404 -2,-2.817z"></path>
                    </g>
                </g>
            </svg>
        </div>
        <div class="item clickable">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 width="24px" height="24px" viewBox="0,0,256,256">
                <g fill="#adadad" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                   stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                   font-family="none" font-weight="none" font-size="none" text-anchor="none"
                   style="mix-blend-mode: normal">
                    <g transform="scale(10.66667,10.66667)">
                        <circle cx="12" cy="18" r="2"></circle>
                        <path
                            d="M17,22h-10c-1.657,0 -3,-1.343 -3,-3v-14c0,-1.657 1.343,-3 3,-3h10c1.657,0 3,1.343 3,3v14c0,1.657 -1.343,3 -3,3z"
                            opacity="0.35"></path>
                        <path
                            d="M16,8h-8c-0.552,0 -1,-0.448 -1,-1v-1c0,-0.552 0.448,-1 1,-1h8c0.552,0 1,0.448 1,1v1c0,0.552 -0.448,1 -1,1z"></path>
                        <path
                            d="M16,13h-8c-0.552,0 -1,-0.448 -1,-1v-1c0,-0.552 0.448,-1 1,-1h8c0.552,0 1,0.448 1,1v1c0,0.552 -0.448,1 -1,1z"></path>
                    </g>
                </g>
            </svg>
        </div>
    </div>
    <div class="sidebar" id="sidebar">
        <div class="text-center">
            <img src="{{ \App\Models\Setting::asFile('logo.large.light') }}" class="logo" alt="">

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
                <?php $user = Auth::guard("admin")->user(); ?>
                <div class="col-4 h-100 right">
                    <div class="row">
                        <img class="profile_picture"
                             src="{{ $user->getGravatarUrl() }}"
                             alt="">
                        <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="page">
            {{ $slot }}
        </div>
    </div>
</div>
@vite(['resources/js/app.js', 'node_modules/highcharts/highcharts.js?commonjs-entry'])
</body>
</html>
