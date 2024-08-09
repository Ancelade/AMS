<div wire:poll>
    <h4>{{ t('Utilisateurs') }}</h4>
    <h5>{{ t('Liste des utilisateurs') }}</h5>

    @foreach(\App\Models\User::all() as $u)
        <div class="card mt-1">


            <div class="row flex-between" style="align-items: center;color: #fff" >
                <div class="col-lg-3">{{ $u->name }}</div>
                <div class="col-lg-3">{{ $u->email }}</div>
                <div class="col-lg-3"><div wire:click="removeUser('{{ $u->id }}')" class="btn btn-danger">{{ t('Suprimmer') }}</div></div>
            </div>
        </div>

    @endforeach


    <h5 class="mt-2">{{ t('Ajouter un utilisateur') }}</h5>

    <div class="card">
        <form wire:submit.prevent="addUser">






                <div class="row flex-between" style="align-items: center;color: #fff" >
                    <div class="col-lg-3"><input wire:model="username" type="text" class="form-control" placeholder="username"></div>
                    <div class="col-lg-3"><input wire:model="email" type="email" class="form-control" placeholder="email@domain.ext"></div>
                    <div class="col-lg-3"><input wire:model="password" type="password" class="form-control" placeholder="*****"></div>
                    <div class="col-lg-3"><button type="submit" class="btn btn-success">{{ t('Créer un utilisateur') }}</button></div>
                </div>

        </form>
    </div>

</div>
