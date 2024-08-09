<div>
    <div class="login">
        <div class="card">
            <div class="text-center">
                <img src="/images/logo.svg" class="logo" alt="">
                <h6>Monitoring System</h6>
            </div>
            <h3 class="text-center">{{ t('Connexion') }}</h3>
            <form wire:submit="login" action="">
                <div>
                    <label>{{ t('Adresse email') }}</label>
                    <input wire:model="email" type="text" class="form-control">
                </div>
                <div class="mt-3">
                    <label>{{ t('Mot de passe') }}</label>
                    <input wire:model="password" type="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success mt-5 flex-center text-center">{{ t('Connexion') }}</button>
            </form>

        </div>
    </div>
</div>
