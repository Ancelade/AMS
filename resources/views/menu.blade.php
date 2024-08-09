<div class="items">
    <a wire:navigate href="{{ route('dashboard') }}"
       class="item @if(str_contains(url()->current(), '/admin/dashboard')) active @endif">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
             height="24px" viewBox="0,0,256,256">
            <g fill-opacity="0.52941" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1"
               stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray=""
               stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none"
               style="mix-blend-mode: normal">
                <g transform="scale(10.66667,10.66667)">
                    <path
                        d="M21.155,20.101c1.414,-2.118 2.113,-4.755 1.751,-7.564c-0.637,-4.938 -4.679,-8.906 -9.627,-9.464c-6.648,-0.75 -12.279,4.431 -12.279,10.927c0,2.263 0.684,4.367 1.856,6.116c0.371,0.554 0.999,0.884 1.667,0.884h14.953c0.674,0 1.304,-0.339 1.679,-0.899z"
                        opacity="0.35"></path>
                    <circle cx="20" cy="14" r="1"></circle>
                    <path
                        d="M11.25,12.701c-0.717,0.414 -0.963,1.332 -0.549,2.049c0.414,0.717 1.332,0.963 2.049,0.549c0.717,-0.414 7.458,-5.082 7.044,-5.799c-0.414,-0.717 -7.827,2.787 -8.544,3.201z"></path>
                    <circle cx="4" cy="14" r="1"></circle>
                    <circle cx="12" cy="6" r="1"></circle>
                    <circle cx="5.072" cy="18" r="1"></circle>
                    <circle cx="8" cy="7.072" r="1"></circle>
                    <circle cx="16" cy="7.072" r="1"></circle>
                    <circle cx="18.928" cy="18" r="1"></circle>
                    <circle cx="5.072" cy="10" r="1"></circle>
                </g>
            </g>
        </svg>
        <p>{{ t('Dashboard') }}</p>
    </a>

    <a wire:navigate href="{{ route('status') }}"
       class="item @if(str_contains(url()->current(), '/admin/dashboard')) active @endif">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256"><g fill-opacity="0.52157" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M19,18h-14c-1.657,0 -3,-1.343 -3,-3v-8c0,-1.657 1.343,-3 3,-3h14c1.657,0 3,1.343 3,3v8c0,1.657 -1.343,3 -3,3z" opacity="0.35"></path><path d="M15.5,18c-0.176,0 -6.824,0 -7,0c-0.828,0 -1.5,0.672 -1.5,1.5c0,0.828 0.672,1.5 1.5,1.5c0.176,0 6.824,0 7,0c0.828,0 1.5,-0.672 1.5,-1.5c0,-0.828 -0.672,-1.5 -1.5,-1.5z"></path><path d="M11,15c-0.256,0 -0.512,-0.098 -0.707,-0.293l-3,-3c-0.391,-0.391 -0.391,-1.023 0,-1.414c0.391,-0.391 1.023,-0.391 1.414,0l2.293,2.293l4.293,-4.293c0.391,-0.391 1.023,-0.391 1.414,0c0.391,0.391 0.391,1.023 0,1.414l-5,5c-0.195,0.195 -0.451,0.293 -0.707,0.293z"></path></g></g></svg>
        <p>{{ t('Status page') }}</p>
    </a>

    <a wire:navigate href="{{ route('settings') }}"
       class="item @if(str_contains(url()->current(), '/admin/dashboard')) active @endif">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256"><g fill-opacity="0.52157" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M16,18.928c0.678,-0.391 1.459,-0.424 2.135,-0.164c0.564,0.217 1.209,0.037 1.592,-0.43c0.683,-0.833 1.234,-1.778 1.621,-2.805c0.221,-0.587 0.012,-1.232 -0.467,-1.638c-0.539,-0.454 -0.881,-1.13 -0.881,-1.891c0,-0.761 0.342,-1.437 0.88,-1.893c0.479,-0.406 0.689,-1.05 0.467,-1.638c-0.387,-1.026 -0.937,-1.972 -1.621,-2.805c-0.383,-0.467 -1.028,-0.647 -1.592,-0.43c-0.675,0.262 -1.456,0.229 -2.134,-0.162c-0.68,-0.393 -1.1,-1.056 -1.21,-1.775c-0.09,-0.588 -0.556,-1.058 -1.143,-1.158c-0.536,-0.091 -1.086,-0.139 -1.647,-0.139c-0.561,0 -1.111,0.048 -1.647,0.139c-0.587,0.1 -1.052,0.57 -1.143,1.158c-0.11,0.719 -0.53,1.382 -1.21,1.775c-0.678,0.391 -1.459,0.424 -2.135,0.163c-0.564,-0.217 -1.209,-0.037 -1.592,0.43c-0.683,0.833 -1.233,1.778 -1.62,2.805c-0.222,0.587 -0.012,1.232 0.467,1.637c0.538,0.456 0.88,1.132 0.88,1.893c0,0.761 -0.342,1.437 -0.88,1.893c-0.479,0.406 -0.689,1.05 -0.467,1.638c0.387,1.026 0.937,1.972 1.621,2.805c0.383,0.467 1.028,0.647 1.592,0.43c0.675,-0.262 1.456,-0.229 2.134,0.162c0.68,0.393 1.1,1.056 1.21,1.775c0.09,0.588 0.556,1.058 1.143,1.158c0.536,0.091 1.086,0.139 1.647,0.139c0.561,0 1.111,-0.048 1.647,-0.139c0.587,-0.099 1.053,-0.569 1.143,-1.158c0.11,-0.719 0.53,-1.382 1.21,-1.775z" opacity="0.35"></path><path d="M9.055,12.546c-0.033,-0.178 -0.055,-0.359 -0.055,-0.546c0,-1.304 0.837,-2.403 2,-2.816v-3.094c-2.837,0.477 -5,2.938 -5,5.91c0,0.736 0.139,1.438 0.381,2.089z"></path><path d="M13,9.184c1.163,0.413 2,1.512 2,2.816c0,0.187 -0.022,0.368 -0.055,0.546l2.674,1.544c0.242,-0.652 0.381,-1.354 0.381,-2.09c0,-2.972 -2.163,-5.433 -5,-5.91z"></path><path d="M13.937,14.273c-0.524,0.447 -1.194,0.727 -1.937,0.727c-0.743,0 -1.413,-0.28 -1.937,-0.727l-2.686,1.551c1.1,1.329 2.763,2.176 4.623,2.176c1.86,0 3.523,-0.847 4.623,-2.176z"></path></g></g></svg>
        <p>{{ t('Configuration') }}</p>
    </a>

    <?php
    $currentGitVersion = \Illuminate\Support\Facades\Cache::get('app_version', null);
    if(!$currentGitVersion) {
        $currentGitVersion = file_get_contents("https://raw.githubusercontent.com/Ancelade/AMS/master/version");
        \Illuminate\Support\Facades\Cache::set('app_version', $currentGitVersion, 86400);
    }
    $currentVersion = file_get_contents(__DIR__.'/../../../version');
    $needUpdate = false;
    if($currentGitVersion > $currentVersion) {
        $needUpdate = true;
    }

        ?>
    @if($needUpdate)

    <div class="badge badge-danger mt-3">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256"><g fill-opacity="0.52157" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M16.096,22h-8.192c-1.111,0 -2.131,-0.614 -2.651,-1.596l-3.706,-7c-0.465,-0.878 -0.465,-1.929 0,-2.807l3.706,-7c0.519,-0.983 1.539,-1.597 2.651,-1.597h8.193c1.111,0 2.131,0.614 2.651,1.596l3.706,7c0.465,0.878 0.465,1.929 0,2.807l-3.706,7c-0.52,0.983 -1.54,1.597 -2.652,1.597z" opacity="0.35"></path><path d="M13.42,16.489c0,0.425 -0.247,1.511 -1.427,1.511c-1.18,0 -1.412,-1.086 -1.412,-1.511c0,-0.415 0.263,-1.529 1.412,-1.529c1.149,0 1.427,1.114 1.427,1.529zM10.698,12.499v-5.24c0,-0.719 0.583,-1.302 1.302,-1.302v0c0.719,0 1.302,0.583 1.302,1.302v5.241c0,0.719 -0.583,1.302 -1.302,1.302v0c-0.719,-0.001 -1.302,-0.584 -1.302,-1.303z"></path></g></g></svg>
        {{ t('Nouvelle version disponible') }}
    </div>
        @endif


</div>
