<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Login extends Component
{

    public ?string $email = "";
    public ?string $password = "";
    public bool $remember = false;

    public function render() : View
    {

        return view('livewire.auth.login')->layout('layout-empty');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function login()
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            return redirect(route('dashboard'));
        } else {
            toastr()->error('Ce compte semble introuvable');
        }

    }
}
