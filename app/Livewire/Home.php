<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class Home extends Component
{
    /**
     * @return View
     */
    public function render() : View
    {
        return view('livewire.home')->layout('layout-large');

    }
}
