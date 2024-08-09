<div wire:poll>

    <div class="row">
        <div class="col-12">
            <div class="tabs">
                <a wire:click="selectMenu('me')" class="tab @if($menu === "me") active @endif">{{ t('Mon compte') }}</a>
                <a wire:click="selectMenu('notificator')" class="tab @if($menu === "notificator") active @endif">{{ t('Notifications') }}</a>
                <a wire:click="selectMenu('users')" class="tab @if($menu === "users") active @endif">{{ t('Utilisateurs') }}</a>
            </div>
        </div>

    </div>



        @if($menu === 'me')
            <livewire:settings.settings-profile></livewire:settings.settings-profile>
        @endif

        @if($menu === 'notificator')
        <div class="card">
            <livewire:settings.settings-notification></livewire:settings.settings-notification>
        </div>
        @endif
        @if($menu === 'users')
        <div class="card">
            <livewire:settings.settings-users></livewire:settings.settings-users>
        </div>
        @endif

</div>
