<div wire:poll.1s>
    @if($this->monitor)
        <ul class="breadcrumbs">
            <li>{{ t('Equipement') }}</li>
            <li>{{ t('Configuration') }}</li>
        </ul>

        <div class="d-flex top-title">
            <h1 class="d-flex"><a href="/dashboard" class="btn btn-primary mr-3">{{ t('Retour') }}</a> {{ $this->device->name }}
            </h1>
            <div class="d-flex">
                <a href="/device/edit/{{ $device->id }}" class="btn btn-primary">{{ t('Ajouter') }}</a>
            </div>
        </div>
        <div class="tabs">
            <a wire:click="selectPanel('Monitor')"
               class="tab @if($selected_panel === "Monitor") active @endif">{{ t('Monitoring') }}</a>
            <a wire:click="selectPanel('Latency')"
               class="tab @if($selected_panel === "Latency") active @endif">{{ t('Latence') }}</a>
            @if($this->hasSNMP())
                <a wire:click="selectPanel('Health')"
                   class="tab @if($selected_panel === "Health") active @endif">{{ t('Santé') }}</a>
                <!-- FOR THE FUTURE <a wire:click="selectPanel('Iface')"
                   class="tab @if($selected_panel === "Iface")
                    active

                @endif">Interface</a> -->

            @endif
            <a wire:click="selectPanel('Settings')" class="tab @if($selected_panel === "Settings") active @endif">{{ t('Configuration') }}</a>
        </div>







        @if($selected_panel === "Monitor")
            <div class="row">
                <div class="col-7 d-flex">
                    <h4 class="mb-2 text-muted">{{ t('Monitoring de l\'equipement') }}</h4>
                        <?php $monitors = $device->getMasterMonitor() ?>
                    <div>
                        <livewire:components.device-monitoring
                            device_id="{{ $device->id }}"></livewire:components.device-monitoring>
                    </div>


                </div>
                <div class="col-5">
                    <h4 class=" mb-2 text-muted">{{ t('Monitoring complementaire') }}</h4>
                    <div class="card">
                        @foreach(\App\Models\Monitor::query()->where('device_id', $this->device->id)->whereNotIn('type', ['ICMP', 'SNMP'])->get() as $monitors)

                            <div wire:key="showable-monitor-{{ $monitors->id }}" class="mt-1 mb-1">
                                <div class="row no-wrap">
                                    <div class="col-11">
                                        <livewire:components.monitor-monitoring wire:key="tick-monitor-{{ $monitors->id }}"
                                                                                :monitor_id="$monitors->id"></livewire:components.monitor-monitoring>
                                    </div>

                                    <div class="col-1">
                                        <a href="/monitor/edit/{{  $monitors->id }}"
                                           class="btn btn-primary">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256"><g fill-opacity="0.52157" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M20.011,3.989c-1.318,-1.318 -3.455,-1.318 -4.773,0l-11.03,11.009c-0.302,0.302 -0.503,0.689 -0.576,1.11l-0.615,3.567c-0.133,0.772 0.538,1.442 1.31,1.308l3.525,-0.613c0.418,-0.073 0.804,-0.273 1.104,-0.573l11.055,-11.036c1.319,-1.318 1.319,-3.454 0,-4.772z" opacity="0.35"></path><path d="M13.075,6.144l4.773,4.773l1.984,-1.977l-4.773,-4.773z"></path><path d="M3.392,17.5l-0.375,2.175c-0.133,0.772 0.538,1.442 1.31,1.308l2.171,-0.378z"></path></g></g></svg>
                                        </a>
                                        <div wire:click="deleteMonitor({{ $monitors->id }})"
                                             class="btn btn-danger  mt-1">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0,0,256,256"><g fill-opacity="0.52157" fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><rect x="5" y="5" width="14" height="14" opacity="0.35"></rect><path d="M18,3h-12c-1.657,0 -3,1.343 -3,3v12c0,1.657 1.343,3 3,3h12c1.657,0 3,-1.343 3,-3v-12c0,-1.657 -1.343,-3 -3,-3zM16.561,16.561c-0.586,0.586 -1.536,0.586 -2.121,0c-0.073,-0.073 -1.152,-1.152 -2.439,-2.439c-1.288,1.288 -2.367,2.367 -2.439,2.439c-0.586,0.586 -1.536,0.586 -2.121,0c-0.586,-0.586 -0.586,-1.536 0,-2.121c0.071,-0.073 1.15,-1.152 2.438,-2.44c-1.288,-1.288 -2.367,-2.367 -2.439,-2.439c-0.586,-0.586 -0.586,-1.536 0,-2.121c0.586,-0.586 1.536,-0.586 2.121,0c0.072,0.072 1.151,1.151 2.439,2.439c1.288,-1.288 2.367,-2.367 2.439,-2.439c0.586,-0.586 1.536,-0.586 2.121,0c0.586,0.586 0.586,1.536 0,2.121c-0.073,0.073 -1.152,1.152 -2.439,2.439c1.288,1.288 2.367,2.367 2.439,2.439c0.586,0.586 0.586,1.536 0.001,2.122z"></path></g></g></svg>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
                @endif

                @if($selected_panel === "Latency")

                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card  p-2">
                                <h4>{{ $this->monitor->last_latency }} ms</h4>
                                <span style="font-weight: bold;color: #fff">{{ t('Latence') }}</span>
                            </div>
                        </div>
                    </div>
                    <div onload="" wire:ignore class="card mt-2">
                        <div class="card-body text-center" style="height:300px">
                            <div class="latency" id="latency" style="height: 260px"></div>
                        </div>
                    </div>
                @endif

                @if($selected_panel === "Settings")
                    <div class="row">
                        <div class="card p-0">
                            <h4 class="pt-2 pl-3">{{ t('Configuration basique') }}</h4>
                            <form class="mt-5" wire:submit.prevent="editMasterMonitor">
                                <div>
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
                                            <button type="submit" class="btn btn-primary mt-3">{{ t('Modifier') }}</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card p-0">
                            <h4 class="pt-2 pl-3">{{ t('Configuration SNMP') }}</h4>
                            <form class="mt-5" wire:submit.prevent="editCreateSnmp()">
                                <div>
                                    <div class="row" style="border-bottom: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Username') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6 ">
                                            <div class="p-4">
                                                <input wire:model="username" type="text">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row" style="border-bottom: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Password') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6 ">
                                            <div class="p-4">
                                                <input wire:model="password" type="text">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row" style="border-bottom: 1px solid #14141f; height: 80px">
                                        <div class="col-6" style="border-right: 1px solid #14141f">
                                            <div class="p-3">

                                                <h2>{{ t('Community') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-6 ">
                                            <div class="p-4">
                                                <input wire:model="community" type="text">
                                            </div>

                                        </div>
                                    </div>


                                    <div class="d-flex flex-right pb-3 pr-3">
                                        <div>
                                            <button type="submit" class="btn btn-primary mt-3">{{ t('Modifier') }}</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card p-0">
                            <div class="row" style="border-bottom: 1px solid #14141f; height: 80px">
                                <div class="col-6" style="border-right: 1px solid #14141f">
                                    <div class="p-3">

                                        <h2>{{ t('Voulez vous suprimmer cette equipement') }}</h2>
                                    </div>
                                </div>
                                <div class="col-6 ">
                                    <div class="p-4 d-flex">
                                        <div>
                                            <div wire:click="deleteDevice()" class="btn btn-danger">{{ t('Suprimmer l\'equipement') }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                @endif

                @if($this->hasSNMP())
                    @if($selected_panel === "Health")
                        <div class="row">
                            <div wire:click="showHealth('avg_cpu')" class="col-3 mt-4" style="cursor: pointer">
                                <div class="card  p-2">
                                    <h4>{{ round($this->getLast('avg_cpu'),2) }} %</h4>
                                    <span style="font-weight: bold;color: #fff">{{ t('CPU') }}</span>
                                </div>
                            </div>
                            <div wire:click="showHealth('memory_used')" class="col-3 mt-4" style="cursor: pointer">
                                <div class="card  p-2">
                                    @if($this->getLast('memory_used') != 0 && $this->getLast('memory_total') != 0)
                                        <h4>{{ round($this->getLast('memory_used')/$this->getLast('memory_total')*100,2) }}
                                            %</h4>
                                    @else
                                        <h4>?? %</h4>
                                    @endif
                                    <span style="font-weight: bold;color: #fff">{{ t('RAM') }}</span>
                                </div>
                            </div>
                            <div wire:click="showHealth('loadavg_1m')" class="col mt-4">
                                <div class="card  p-2" style="cursor: pointer">
                                    <h4>{{ round($this->getLast('loadavg_1m'),2) }}</h4>
                                    <span style="font-weight: bold;color: #fff">{{ t('Load 1M') }}</span>
                                </div>
                            </div>
                            <div wire:click="showHealth('loadavg_1m')" class="col mt-4" style="cursor: pointer">
                                <div class="card  p-2">
                                    <h4>{{ round($this->getLast('loadavg_5m'),2) }}</h4>
                                    <span style="font-weight: bold;color: #fff">{{ t('Load 5M') }}</span>
                                </div>
                            </div>
                            <div wire:click="showHealth('loadavg_1m')" class="col mt-4" style="cursor: pointer">
                                <div class="card  p-2">
                                    <h4>{{ round($this->getLast('loadavg_15m'),2) }}</h4>
                                    <span style="font-weight: bold;color: #fff">{{ t('Load 15M') }}</span>
                                </div>
                            </div>
                        </div>


                        @if($this->health === "avg_cpu")

                            <div class="card mt-2">
                                <div class="text-center d-flex" style="height:300px">
                                    <div class="d-flex flex-col">
                                        <div class="btn btn-primary" wire:click="setGraphRange('H')">H</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('D')">D</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('M')">M</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('Y')">Y</div>
                                    </div>
                                    <div style="width: 100%">
                                        <div wire:ignore style="height: 270px;width: 100%" class="avg_cpuGraph"
                                             id="avg_cpuGraph"></div>
                                    </div>

                                </div>
                            </div>

                        @endif
                        @if($this->health === "memory_used")
                            <div class="card mt-2">
                                <div class="text-center d-flex" style="height:300px">
                                    <div class="d-flex flex-col">
                                        <div class="btn btn-primary" wire:click="setGraphRange('H')">H</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('D')">D</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('M')">M</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('Y')">Y</div>
                                    </div>
                                    <div style="width: 100%">
                                        <div wire:ignore style="height: 270px" class="memory_usedGraph"
                                             id="memory_usedGraph"></div>
                                    </div>
                                </div>
                            </div>

                        @endif
                        @if($this->health === "loadavg_1m")
                            <div wire:ignore class="card mt-2">
                                <div class="text-center d-flex" style="height:300px">
                                    <div class="d-flex flex-col">
                                        <div class="btn btn-primary" wire:click="setGraphRange('H')">H</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('D')">D</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('M')">M</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('Y')">Y</div>
                                    </div>
                                    <div style="width: 100%">
                                        <div style="height: 270px" class="loadavg_1mGraph" id="loadavg_1mGraph"></div>
                                    </div>
                                </div>
                            </div>

                        @endif
                    @endif
                @endif
                @endif


                @if($selected_panel === "Iface")
                    <div class="row">
                        <div class="col">
                            <div class="sidebar mt-1" style="border-radius: 10px; border:none; height: auto">
                                <div class="items" data-dashlane-rid="f5cc5a1584e2638e" data-form-type="">

                                    @foreach(collect($this->ifeceList())->sort() as $key => $iface)
                                        <div wire:click="selectIface('{{ $key  }}')" class="item"
                                             style=" white-space: nowrap;text-overflow: ellipsis;overflow: hidden !important;">{{ $iface }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-10">
                            <div wire:ignore class="card">
                                <div class="text-center d-flex" style="height:300px">
                                    <div class="d-flex flex-col">
                                        <div class="btn btn-primary" wire:click="setGraphRange('H')">H</div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('D')">D
                                        </div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('M')">M
                                        </div>
                                        <div class="btn btn-primary mt-1" wire:click="setGraphRange('Y')">Y
                                        </div>
                                    </div>
                                    <div style="width: 100%">
                                        <div style="height: 270px" class="ifaceGraph"
                                             id="ifaceGraph">{{ t('Merci de selectioner une interface') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                @endif


                <script>



                </script>
            </div>

