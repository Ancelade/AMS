<?php

namespace App\Livewire\Status;

use App\Models\StatusGroup;
use App\Models\StatusMonitor;
use Livewire\Component;

class StatusEdit extends Component
{
    public ?int $id;
    public ?string $groupname;

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('livewire.status.status-edit')->layout('layout-large');
    }

    /**
     * @param int $id
     * @return void
     */
    public function mount(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return void
     */
    public function addGroup(): void
    {
        $status = new \App\Models\StatusGroup();
        $status->name = $this->groupname;
        $status->status_page_id = $this->id;
        $status->save();
        $this->groupname = "";
    }

    public function deleteGroup($id): void
    {
        StatusGroup::where('id', $id)->delete();
        StatusMonitor::where('status_group_id', $id)->delete();
    }

    /**
     * @param int $idGroup
     * @param int $idMonitor
     * @return void
     */
    public function addMonitor(int $idGroup, int $idMonitor): void
    {
        $status = new \App\Models\StatusMonitor();
        $status->status_group_id = $idGroup;
        $status->monitor_id = $idMonitor;
        $status->save();

    }

    /**
     * @param int $idMonitor
     * @param int $idGroup
     * @return void
     */
    public function deleteMonitor(int $idMonitor, int $idGroup): void
    {
        StatusMonitor::query()->where('monitor_id', $idMonitor)->where('status_group_id', $idGroup)->delete();
    }
}
