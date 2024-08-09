<div>
    @if($this->monitor)

        <ul class="breadcrumbs">
            <li>{{ t('Equipement') }}</li>
            <li>{{ t('Configuration') }}</li>
        </ul>

        <div class="d-flex top-title">
            <h1 class="d-flex"><a href="/device/{{ $this->device->id }}"
                                  class="btn btn-primary mr-3">Retour</a> {{ $this->device->name }}</h1>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="tabs">
                    <a wire:click="select('HTTPS')"
                       class="tab @if($type === "HTTPS") active @endif">HTTPS</a>
                    <a wire:click="select('TCP')"
                       class="tab @if($type === "TCP") active @endif">TCP</a>
                </div>
            </div>


            <div class="row w-100">
                <div class="col-12 offset-lg-3">
                    <div class="card p-0">
                        <form class="mt-5" wire:submit.prevent="addMonitor">
                            <div>
                                @if($type === 'HTTPS')
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
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
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('URL') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="host" type="text">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Mot clés') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="keyword" type="text">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Timeout') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="timeout" type="number">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Tentative') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="retry" type="number">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Interval') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="interval" type="number">
                                            </div>

                                        </div>
                                    </div>
                                @endif


                                @if($type === 'TCP')
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
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
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('IP') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="host" type="text">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Port') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="port" type="number">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Timeout') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="timeout" type="number">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Tentative') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="retry" type="number">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row"
                                         style="border-bottom: 1px solid #14141f;border-top: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Interval') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-4">
                                                <input wire:model="interval" type="number">
                                            </div>

                                        </div>
                                    </div>
                                @endif


                                <div class="d-flex flex-right pb-3 pr-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-3">{{ t('Ajouter') }}</button>
                                    </div>

                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>

    @endif

</div>
