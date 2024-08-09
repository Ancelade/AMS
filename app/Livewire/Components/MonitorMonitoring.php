<?php

namespace App\Livewire\Components;

use App\Livewire\Monitor;
use App\Models\Devices;
use Livewire\Component;

class MonitorMonitoring extends Component
{
    public $monitor_id = 0;
    public $monitors = null;
    public $verbosity = 0;

    public $timerange = "hourly";
    public $range = [32, 3600];
    public function mount()
    {
        $this->monitors = \App\Models\Monitor::where('id', '=', $this->monitor_id)->first();
        if($this->timerange === "hourly") {
            $this->range = [256, 60];
        }
        if($this->timerange === "dayly") {
            $this->range = [256, 3600];
        }
        if($this->timerange === "montly") {
            $this->range = [256, 109800];
        }
    }
    public function render()
    {
        return view('livewire.components.monitor-monitoring');
    }
}
