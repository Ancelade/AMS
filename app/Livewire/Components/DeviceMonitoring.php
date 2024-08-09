<?php

namespace App\Livewire\Components;

use App\Models\Devices;
use Livewire\Component;

class DeviceMonitoring extends Component
{
    public $device_id = 0;
    public $device = null;
    public $verbosity = 3;
    public $timerange = "hourly";
    public $range = [32, 3600];
    public function mount()
    {
        $this->device = Devices::where('id', '=', $this->device_id)->first();
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
        return view('livewire.components.device-monitoring');
    }
}
