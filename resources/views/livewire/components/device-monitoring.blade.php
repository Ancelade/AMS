<?php $monitors = $device->getMasterMonitor() ?>
<a @if(\Illuminate\Support\Facades\Auth::check()) href="/device/{{ $device->id }}" @endif wire:navigate>

    <div class="device">
        <livewire:components.monitor-monitoring
            monitor_id="{{ $monitors->id }}"></livewire:components.monitor-monitoring>
        <?php
        /** @var $submonitor \App\Models\Monitor[] */
        $submonitor = \App\Models\Monitor::query()->where('device_id', $device->id)->whereIn('type', ['HTTPS', 'TCP'])->get()

        ?>
        @if($verbosity != 0)
            @if($verbosity == 1)
                <div class="states">
                    @foreach($submonitor as $sm)
                        <div
                            class="state @if($sm->status === 1) down @elseif($sm->status === 2) up @endif">{{ $sm->name }}</div>
                    @endforeach
                </div>

            @endif

            @if($verbosity == 2)
                <div class="states">
                    @foreach($submonitor as $sm)
                        <div class="state @if($sm->status === 1) down @elseif($sm->status === 2) up @endif">
                            {{ $sm->name }}
                            <div class="d-flex flex-center ticker-light">
                                <div>
                                    @foreach($monitors->getTick(10, 3600) as $k => $tick)
                                        <div
                                            title="{{ \Carbon\Carbon::createFromTimestamp($tick['time'])->diffForHumans(\Carbon\Carbon::now(), Carbon\CarbonInterface::DIFF_RELATIVE_AUTO, true,6) }}"
                                            class="monit-tick-light @if($tick['state'] === "UP") success @endif @if($tick['state'] === "DOWN") error @endif @if($tick['state'] === "WARN") warning @endif"></div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            @endif

            @if($verbosity == 3)
                <div class="states ">
                    @foreach($submonitor as $sm)
                        <div class="state @if($sm->status === 1) down @elseif($sm->status === 2) up @endif">
                            <div>
                                <div class="d-flex flex-between" style="align-items: center">
                                    <div>
                                        {{ $sm->name }}
                                    </div>
                                    <div>
                                        <div>
                                            <div class="badge light"> {{ $sm->last_latency  }}ms</div>
                                            <div
                                                class="badge light">@if($sm->n_up_total != 0 && ($sm->n_up_total + $sm->n_down_total) != 0)
                                                    {{ round(( $sm->n_up_total/($sm->n_up_total + $sm->n_down_total))*100,2) }}
                                                    %
                                                @else
                                                    ??
                                                @endif</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="overflower">
                                <div class="d-flex flex-center ticker-light mt-2">

                                    @foreach($sm->getTick(64, $this->range[1]) as $k => $tick)
                                        <div
                                            title="{{ \Carbon\Carbon::createFromTimestamp($tick['time'])->diffForHumans(\Carbon\Carbon::now(), Carbon\CarbonInterface::DIFF_RELATIVE_AUTO, true,6) }}"
                                            class="monit-tick-light @if($tick['state'] === "UP") success @endif @if($tick['state'] === "DOWN") error @endif @if($tick['state'] === "WARN") warning @endif"></div>
                                    @endforeach


                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @endif
        @endif

    </div>
</a>
