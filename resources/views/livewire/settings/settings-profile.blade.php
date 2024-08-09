<div>
    <div class="card">
        <h4>{{ t('Language') }}</h4>
        <p class="mt-1" style="color:#aaa;">
            {{ t('Choisissez votre langue') }}
        </p>

        <div class="row">
            <div class="col-11">
                <select wire:model="lang">
                    <option value="ar">{{ t('Arabe') }}</option>
                    <option value="bn">{{ t('Bengali') }}</option>
                    <option value="ch">{{ t('Chinois') }}</option>
                    <option value="en">{{ t('Anglais') }}</option>
                    <option value="es">{{ t('Espagnol') }}</option>
                    <option value="fr">{{ t('Français') }}</option>
                    <option value="hi">{{ t('Hindi') }}</option>
                    <option value="ru">{{ t('Russe') }}</option>
                </select>
            </div>
            <div class="col-1 ">
                <div class="w-auto d-flex flex-right">
                    <div wire:click="changeLang()" class="btn btn-primary ml-3 w-auto">{{ t('Valider') }}</div>
                </div>
            </div>
        </div>


        </div>
    <div class="card">
        <h4>{{ t('Information') }}</h4>
        <p class="mt-1" style="color:#aaa;">
            {{ t('Mettez à jour les informations de profil de votre compte et votre adresse e-mail.') }}
        </p>
        <form method="post" wire:submit="updateAccount()" class="mt-4">
            @csrf
            <input type="hidden" name="_method" value="patch">

            <div class="mb-3">
                <label for="name" class="form-label">{{ t('Nom de compte') }}</label>
                <input wire:model="username" id="name" name="name" type="text"
                       required autofocus autocomplete="name">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ t('Email') }}</label>
                <input wire:model="email" id="email" name="email" type="email"
                        required autocomplete="username">
            </div>

            <div class="d-flex flex-right">
                <div>
                    <button type="submit" class="btn btn-primary">
                        {{ t('Valider') }}
                    </button>
                </div>

            </div>
        </form>
    </div>


    <div class="card">
        <h4>{{ t('Mettre à jour le mot de passe') }}</h4>
        <p class="mt-1" style="color:#aaa;">
            {{ t('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour garantir
            votre sécurité.') }}

        </p>
        <form method="post" wire:submit="changePassword" class="card-body mt-4">
            @csrf
            <input type="hidden" name="_method" value="put">

            <div class="mb-3">
                <label for="current_password" class="form-label">{{ t('Mot de passe actuel') }}</label>
                <input  id="current_password" name="current_password"
                       type="password"  wire:model="currentPassword" autocomplete="current-password">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ t('Nouveau mot de passe') }}</label>
                <input  id="password" name="password" type="password"
                       autocomplete="new-password"  wire:model="password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ t('Confirmez le mot de passe') }}</label>
                <input  id="password_confirmation" name="password_confirmation"
                       type="password" autocomplete="new-password"  wire:model="passwordConfirmation">
            </div>

            <div class="d-flex flex-right">
                <div>
                    <button type="submit" class="btn btn-primary">
                        {{ t('Valider') }}
                    </button>
                </div>

            </div>
        </form>
    </div>






</div>
