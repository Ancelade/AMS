<div>
    <div class="card p-0">
        <h3 class="pt-3 pl-3">{{ t('Ajouter un equipement') }}</h3>
        <form class="mt-5" wire:submit.prevent="addMonitor">
        <div>
            <div class="row" style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                <div class="col-6" style="border-right: 1px solid #14141f">
                    <div class="p-3">

                        <h2>{{ t('Nom') }}</h2>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-4">
                        <input wire:model="name" type="text">
                    </div>

                </div>
            </div>
            <div class="row" style="border-bottom: 1px solid #14141f; height: 80px">
                <div class="col-6" style="border-right: 1px solid #14141f">
                    <div class="p-3">

                        <h2>{{ t('IP') }}</h2>
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="p-4">
                        <input wire:model="host" type="text">
                    </div>

                </div>
            </div>
            <div class="row" style="border-bottom: 1px solid #14141f; height: 80px">
                <div class="col-6" style="border-right: 1px solid #14141f">
                    <div class="p-3">

                        <h2>{{ t('Timeout') }}</h2>
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="p-4">
                        <input wire:model="timeout" type="number">
                    </div>

                </div>
            </div>
            <div class="row" style="border-bottom: 1px solid #14141f; height: 80px">
                <div class="col-6" style="border-right: 1px solid #14141f">
                    <div class="p-3">

                        <h2>{{ t('Tentative') }}</h2>
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="p-4">
                        <input wire:model="retry" type="number">
                    </div>

                </div>
            </div>
            <div class="row" style="border-bottom: 1px solid #14141f; height: 80px">
                <div class="col-6" style="border-right: 1px solid #14141f">
                    <div class="p-3">

                        <h2>{{ t('Interval') }}</h2>
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="p-4">
                        <input wire:model="interval" type="number">
                    </div>

                </div>
            </div>


            <div class="d-flex flex-right pb-3 pr-3">
                <div>
                    <button type="submit" class="btn btn-primary mt-3">{{ t('Ajouter') }}</button>
                </div>

            </div>
        </div>
        </form>
    </div>
</div>
