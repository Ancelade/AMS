<?php

namespace App\Livewire;

use App\Models\Devices;
use Livewire\Component;

class MonitorEdit extends Component
{
    public ?int $id;
    public ?\App\Models\Monitor $monitor;
    public ?Devices $device;


    public string $type = 'HTTPS';
    public ?string $name = "";
    public ?string $host = "";
    public ?int $port = 161;
    public ?string $community = "";
    public ?string $username = "";
    public ?string $password = "";

    public ?int $timeout = 2;
    public ?int $interval = 1;
    public ?int $retry = 3;
    public ?string $keyword = "";

    public function render()
    {
        return view('livewire.monitor-edit')->layout('layout-light');
    }

    public function mount($id)
    {
        $this->id = $id;
        $this->monitor = \App\Models\Monitor::where('id', $id)->whereIn('type', ['HTTPS', 'TCP'])->first();

        if(!$this->monitor) {
            abort(404);
        }
        $this->device = Devices::where('id', $this->monitor->device_id)->first();
        $this->type = $this->monitor->type;
        $this->name = $this->monitor->name;
        $this->host = $this->monitor->host;
        $this->port = $this->monitor->port;
        $this->community = $this->monitor->community;
        $this->username = $this->monitor->username;
        $this->password = $this->monitor->password;
        $this->timeout = $this->monitor->timeout;
        $this->interval = $this->monitor->interval;
        $this->retry = $this->monitor->retry;
        $this->keyword = $this->monitor->keyword;
    }

    public function edit()
    {
        $monitor = $this->monitor;
        $monitor->host = $this->host;
        if (!empty($this->port)) {
            $monitor->port = $this->port;
        }
        if (!empty($this->name)) {
            $monitor->name = $this->name;
        } else {
            $monitor->name = $this->device->name;
        }

        $monitor->timeout = $this->timeout;
        $monitor->interval = $this->interval;
        $monitor->retry = $this->retry;
        $monitor->username = $this->username;
        $monitor->password = $this->password;
        $monitor->community = $this->community;

        if (!empty($this->keyword)) {
            $monitor->keyword = $this->keyword;
        }

        $monitor->type = $this->type;
        $monitor->device_id = $this->device->id;
        $monitor->save();

        toastr()->success("Your monitor was edited");
        $this->redirect('/device/'.$this->device->id);
    }
}
