<div>
    <div class="row">
        <div class="card pt-1">
            <h4>{{ t('Créer une page status') }}</h4>
            <form wire:submit.prevent="addPage" class="d-flex">
                <input type="text" wire:model="pageTitle" placeholder="Page name">
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary ml-3">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256"><g fill-opacity="0.52157" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M5.268,10.732c-0.976,-0.976 -2.559,-0.976 -3.536,0c-0.977,0.976 -0.976,2.559 0,3.536l4.645,4.645c1.449,1.449 3.797,1.449 5.246,0l0.913,-0.913z" opacity="0.35"></path><path d="M22.268,4.732c-0.976,-0.976 -2.559,-0.976 -3.536,0l-9.732,9.732l3.536,3.536l9.732,-9.732c0.976,-0.977 0.976,-2.56 0,-3.536z"></path></g></g></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <h4>Vos pages</h4>
    @foreach(\App\Models\StatusPage::query()->get() as $page)
        <div class="card">
            <div class="d-flex flex-between">
                <h4>{{ $page->name }}</h4>
                <div class="d-flex">
                    <a target="_blank" href="/status/page/{{ $page->id }}"
                       class="btn btn-primary ml-1"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256"><g fill-opacity="0.52157" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M2.269,15.625c-1.675,-2.13 -1.675,-5.121 0,-7.251c1.966,-2.499 5.21,-5.374 9.731,-5.374c4.521,0 7.765,2.875 9.731,5.375c1.675,2.13 1.675,5.121 0,7.251c-1.966,2.499 -5.21,5.374 -9.731,5.374c-4.521,0 -7.765,-2.875 -9.731,-5.375z" opacity="0.35"></path><path d="M12,6c-3.314,0 -6,2.686 -6,6c0,3.314 2.686,6 6,6c3.314,0 6,-2.686 6,-6c0,-3.314 -2.686,-6 -6,-6zM13,13c-1.105,0 -2,-0.895 -2,-2c0,-1.105 0.895,-2 2,-2c1.105,0 2,0.895 2,2c0,1.105 -0.895,2 -2,2z"></path></g></g></svg></a>
                    <a wire:navigate href="/status/edit/{{ $page->id }}" class="btn btn-primary ml-1"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256"><g fill-opacity="0.52157" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M20.011,3.989c-1.318,-1.318 -3.455,-1.318 -4.773,0l-11.03,11.009c-0.302,0.302 -0.503,0.689 -0.576,1.11l-0.615,3.567c-0.133,0.772 0.538,1.442 1.31,1.308l3.525,-0.613c0.418,-0.073 0.804,-0.273 1.104,-0.573l11.055,-11.036c1.319,-1.318 1.319,-3.454 0,-4.772z" opacity="0.35"></path><path d="M13.075,6.144l4.773,4.773l1.984,-1.977l-4.773,-4.773z"></path><path d="M3.392,17.5l-0.375,2.175c-0.133,0.772 0.538,1.442 1.31,1.308l2.171,-0.378z"></path></g></g></svg></a>
                    <a wire:click="remove('{{ $page->id }}')" class="btn btn-danger ml-1"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256"><g fill-opacity="0.52157" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><rect x="5" y="5" width="14" height="14" opacity="0.35"></rect><path d="M18,3h-12c-1.657,0 -3,1.343 -3,3v12c0,1.657 1.343,3 3,3h12c1.657,0 3,-1.343 3,-3v-12c0,-1.657 -1.343,-3 -3,-3zM16.561,16.561c-0.586,0.586 -1.536,0.586 -2.121,0c-0.073,-0.073 -1.152,-1.152 -2.439,-2.439c-1.288,1.288 -2.367,2.367 -2.439,2.439c-0.586,0.586 -1.536,0.586 -2.121,0c-0.586,-0.586 -0.586,-1.536 0,-2.121c0.071,-0.073 1.15,-1.152 2.438,-2.44c-1.288,-1.288 -2.367,-2.367 -2.439,-2.439c-0.586,-0.586 -0.586,-1.536 0,-2.121c0.586,-0.586 1.536,-0.586 2.121,0c0.072,0.072 1.151,1.151 2.439,2.439c1.288,-1.288 2.367,-2.367 2.439,-2.439c0.586,-0.586 1.536,-0.586 2.121,0c0.586,0.586 0.586,1.536 0,2.121c-0.073,0.073 -1.152,1.152 -2.439,2.439c1.288,1.288 2.367,2.367 2.439,2.439c0.586,0.586 0.586,1.536 0.001,2.122z"></path></g></g></svg></a>
                </div>
            </div>
        </div>
    @endforeach
    @if(\App\Models\StatusPage::query()->count() === 0)
        <h6 class="text-center">{{ t('Vous n\'avez aucune page de status') }}</h6>
    @endif
</div>
