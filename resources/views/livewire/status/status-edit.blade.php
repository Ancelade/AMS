<div wire:poll>
    <div class="row">
        <div class="card">
            <h4>{{ t('Ajouter un groupe') }}</h4>
            <form wire:submit.prevent="addGroup" class="d-flex">
                <input type="text" wire:model="groupname"
                       placeholder="Nom de votre groupe">
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary ml-3">{{ t('Ajouter') }}</button>
                </div>
            </form>
        </div>

    </div>

    <div class="row">
        <?php $groups = \App\Models\StatusGroup::query()->where('status_page_id', $id)->get(); ?>
        @foreach($groups as $group)
            <div class="card" wire:key="card-group-{{ $group->id }}">
                <h5 class="d-flex flex-between">{{ $group->name }} <div wire:click="deleteGroup({{ $group->id }})" class="btn btn-danger">{{ t('Suprimmer le groupe') }}</div></h5>
                <div>
                    <div class="d-flex">
                        @foreach(\App\Models\Monitor::where('type','ICMP')->get() as $monitor)
                            @if(!\App\Models\StatusMonitor::where('status_group_id', $group->id)->where('monitor_id',$monitor->id)->exists())
                                <div wire:key="btn-{{$group->id}}"
                                     wire:click="addMonitor('{{ $group->id }}', '{{ $monitor->id }}')"
                                     class="btn btn-primary ml-2">+ {{ $monitor->name }}</div>
                            @endif
                        @endforeach
                    </div>
                    @foreach(\App\Models\StatusMonitor::where('status_group_id', $group->id)->get() as $monit)
                            <?php $monitTotal = \App\Models\Monitor::find($monit->monitor_id) ?>
                        <div class="row" wire:key="group-items-{{ $group->id}}-{{ $monit->monitor_id}}">
                            <div class="card">
                                <div class="row">
                                    <div class="col-7">
                                        <div>
                                            <livewire:components.device-monitoring
                                                :device_id="$monitTotal->device_id"
                                                wire:key="monititem-{{ $group->id }}-{{ $monit->monitor_id}}"></livewire:components.device-monitoring>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="d-flex flex-right">
                                            <div wire:click="deleteMonitor('{{ $monitTotal->id }}','{{ $group->id }}')"
                                                 wire:key="ping-{{$monitTotal->id}}" class="btn btn-danger "
                                                 style="margin-left:10px">x
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</div>
