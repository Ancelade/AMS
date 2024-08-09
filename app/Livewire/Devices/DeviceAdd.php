<?php

namespace App\Livewire\Devices;

use App\Models\Devices;
use Illuminate\View\View;
use Livewire\Component;

class DeviceAdd extends Component
{
    public string $type = 'ICMP';
    public ?string $name = "";
    public ?string $host = "";
    public ?int $port = 0;
    public int $timeout = 2;
    public int $interval = 1;
    public int $retry = 3;
    public ?string $keyword = "";


    public function render() : View
    {
        return view('livewire.devices.device-add')->layout('layout-light');
    }


    /**
     * @return void
     */
    public function addMonitor(): void
    {

        if (\App\Models\Monitor::where('host', $this->host)->exists()) {
            toastr()->error("This device already exist");
            return;
        }
        $device = new Devices();
        $device->name = $this->name;
        $device->save();


        $monitor = new \App\Models\Monitor();
        $monitor->name = $this->name;
        $monitor->host = $this->host;
        if (!empty($this->port)) {
            $monitor->port = $this->port;
        }

        $monitor->timeout = $this->timeout;
        $monitor->interval = $this->interval;
        $monitor->retry = $this->retry;

        if (!empty($this->keyword)) {
            $monitor->keyword = $this->keyword;
        }

        $monitor->type = $this->type;
        $monitor->device_id = $device->id;
        $monitor->save();
        toastr()->success("Your device was created");
        $this->name = "";
        $this->host = "";
        $this->port = 0;
        $this->timeout = 1;
        $this->interval = 1;
        $this->retry = 3;
        $this->keyword = "";
        $this->redirect('/dashboard');

    }
}
