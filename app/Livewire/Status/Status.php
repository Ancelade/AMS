<?php

namespace App\Livewire\Status;

use App\Models\StatusGroup;
use App\Models\StatusMonitor;
use App\Models\StatusPage;
use Illuminate\View\View;
use Livewire\Component;

class Status extends Component
{
    public ?string $pageTitle;

    /**
     * @return View|null
     */
    public function render() : ?View
    {
        return view('livewire.status.status')->layout('layout-large');
    }

    /**
     * @return void
     */
    public function addPage(): void
    {
        if (!empty($this->pageTitle)) {
            $status = new StatusPage();
            $status->name = $this->pageTitle;
            $status->save();
            $this->pageTitle = "";
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $status = StatusPage::find($id);
        if ($status) {
            $status->delete();
            $statusGroup = StatusGroup::query()->where('status_page_id', $id)->get();
            foreach ($statusGroup as $sg) {
                StatusMonitor::query()->where('status_group_id', $sg->id)->delete();
                $sg->delete();
            }
        }


    }


}
