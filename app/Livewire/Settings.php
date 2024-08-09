<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Settings extends Component
{
    public $menu = "me";

    public function render(): View
    {

        return view('livewire.settings')->layout('layout-large');

    }

    public function selectMenu($menu)
    {
        $this->menu = $menu;
    }

}
