<?php

namespace App\Livewire;

use App\Models\Devices;
use Illuminate\View\View;
use Livewire\Component;

class UpgradeDevice extends Component
{
    public ?int $id;
    public ?\App\Models\Monitor $monitor;
    public ?Devices $device;


    public string $type = 'SNMP';
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

    /**
     * @param int $id
     * @return void
     */
    public function mount(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     * @return void
     */
    public function select(string $name): void
    {
        $this->type = $name;
    }


    /**
     * @return View
     */
    public function render(): View
    {
        $this->device = \App\Models\Devices::where('id', $this->id)->first();
        $this->monitor = $this->device->getMasterMonitor();
        return view('livewire.upgrade-device')->layout('layouts.dash');

    }

    /**
     * @return void
     */
    public function addMonitor(): void
    {
        $monitor = new \App\Models\Monitor();
        if(!empty($this->host)) {
            $monitor->host = $this->host;
        } else {
            $monitorDefault = $this->device->getMasterMonitor();
            $monitor->host = $monitorDefault->host;
        }

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

        toastr()->success("Your monitor was created");
        $this->name = "";
        $this->host = "";
        $this->port = 0;
        $this->timeout = 1;
        $this->interval = 1;
        $this->retry = 3;
        $this->keyword = "";

    }
}
