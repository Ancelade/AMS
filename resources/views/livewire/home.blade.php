<div wire:poll>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <h3 class="d-flex flex-between h-50">{{ t('Equipements') }}
                    <a href="/device/add" class="btn btn-primary">{{ t('Ajouter un equipement') }}</a>
                </h3>
                @foreach(\App\Models\Devices::all() as $device)
                    <div class="mt-3">
                        <livewire:components.device-monitoring  wire:key="dev-home-{{ $device->id }}" device_id="{{ $device->id }}"></livewire:components.device-monitoring>
                    </div>

                @endforeach

            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <h3>{{ t('Notifications') }}</h3>
                <?php $alerts = \App\Models\Alert::query()->where('state', '!=', 'WARN')->orderBy('created_at', "DESC")->limit(30)->get() ?>
                @foreach($alerts as $alert)
                <div class="card d-flex flex-between">


                            <?php $monit = \App\Models\Monitor::query()->where('id', $alert->monitor_id)->first() ?>
                            <?php $device = \App\Models\Devices::query()->where('id', $monit->device_id)->first() ?>
                    <div class="d-flex " style="align-items: center">
                        <div
                            class="badge  @if($alert->state == "UP") badge-success @endif @if($alert->state == "DOWN") badge-danger @endif">{{ $alert->state }}
                        </div>
                        <div style="color: #fff" class="ml-3">
                            {{ $alert->created_at }}
                        </div>
                    </div>
                    <div  style="margin-left: 10px"><h3
                            class="title">{{ $device->name }}</h3></div>

                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
