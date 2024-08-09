<div style="width: 100%">
    <div class="device">
        <div class="d-flex flex-between mb-3">
            <div>  {{ $monitors->name }}

            </div>
            <div>
                <div class="badge"> {{ $monitors->last_latency  }}ms</div>
                <div
                    class="badge">@if($monitors->n_up_total != 0 && ($monitors->n_up_total + $monitors->n_down_total) != 0)
                        {{ round(( $monitors->n_up_total/($monitors->n_up_total + $monitors->n_down_total))*100,2) }}
                        %
                    @else
                        ??
                    @endif</div>
            </div>

        </div>
        <div class="overflower">
            <div class="d-flex flex-nowrap flex-right ticker">

                @foreach($monitors->getTick($this->range[0], $this->range[1]) as $k => $tick)
                    <div
                        title="{{ \Carbon\Carbon::createFromTimestamp($tick['time'])->diffForHumans(\Carbon\Carbon::now(), Carbon\CarbonInterface::DIFF_RELATIVE_AUTO, true,6) }}"
                        class="monit-tick @if($tick['state'] === "UP") success @endif @if($tick['state'] === "DOWN") error @endif @if($tick['state'] === "WARN") warning @endif"></div>
                @endforeach


            </div>
        </div>

    </div>
</div>
