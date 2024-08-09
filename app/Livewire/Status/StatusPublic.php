<?php

namespace App\Livewire\Status;

use Illuminate\View\View;
use Livewire\Component;

class StatusPublic extends Component
{
    public ?int $id;

    /**
     * @return View
     */
    public function render() : View
    {
        return view('livewire.status.status-public')->layout('layout-empty');
    }

    /**
     * @param int $id
     * @return void
     */
    public function mount(int $id): void
    {
        $this->id = $id;
    }
}
