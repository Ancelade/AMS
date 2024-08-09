<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class SettingsProfile extends Component
{
    public $lang = "en";
    public $username = "";
    public $email = "";
    public $currentPassword = "";
    public $password = "";
    public $passwordConfirmation = "";
    public function render()
    {

        return view('livewire.settings.settings-profile');
    }
    public function mount()
    {
        $this->lang = Auth::user()->language;
        $this->username = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function changeLang()
    {
        $me = Auth::user();
        $me->language  = $this->lang;
        $me->save();
        toastr()->success(t('La langue a été modifier'));
    }

    public function updateAccount()
    {
        $me = Auth::user();
        $me->name = $this->username;
        if($me->email != $this->email){
            if(User::where('email', $this->email)->count() === 0) {
                $me->email = $this->email;
            };

        }

        $me->save();
        toastr()->success(t('Vos informations ont été modifier'));
    }

    public function changePassword() {
        $me = Auth::user();

        if(Hash::check($this->currentPassword, $me->password)) {
            if($this->password === $this->passwordConfirmation) {
                $me->password = Hash::make($this->password);

                $me->save();
                toastr()->success(t('Votre mot de passe a été modifier'));
            } else {
                toastr()->error(t('Les mots de passes ne correspondent pas'));
            }

        } else {
            toastr()->error(t('Votre mot de passe actuel ne correspond pas'));
        }

    }
}
