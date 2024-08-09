<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class SettingsUsers extends Component
{
    public $username="";
    public $password = "";
    public $email = "";
    public function render()
    {
        return view('livewire.settings.settings-users');
    }

    public function removeUser($id)
    {
        User::query()->where('id', $id)->delete();
    }
    public function addUser()
    {
        if(!User::whereEmail("$this->email")->exists()) {
            $user = new User();
            $user->name = $this->username;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->save();

            toastr()->success("Your user was created");
            return;
        }
        toastr()->error("Already exist");

    }
}
