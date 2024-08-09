<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;


class Monitor extends Component
{

    /**
     * @return View
     */
    public function render() : View
    {
        return view('livewire.monitor');
    }


}
