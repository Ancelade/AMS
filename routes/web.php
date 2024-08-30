<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::user()) {
        return redirect(\route('dashboard'));
    }
    return redirect(\route('login'));
});

Route::prefix("/")->middleware("auth")->group(function () {
    Route::get('/settings', \App\Livewire\Settings::class)->name('settings');
    Route::get('/dashboard', \App\Livewire\Home::class)->name('dashboard');

});
Route::prefix('device')->group(function () {
    Route::get('/add', \App\Livewire\Devices\DeviceAdd::class)->name('device.add');
    Route::get('/edit/{id}', \App\Livewire\Devices\DeviceAddMonitor::class)->name('device-one.edit');
    //Route::get('/upgrade/{id}', \App\Livewire\UpgradeDevice::class)->name('device-one.upgrade');
    Route::get('/{id}', \App\Livewire\Devices\DeviceOne::class)->name('device-one.one');

});
Route::prefix('monitor')->group(function () {
    Route::get('/edit/{id}', \App\Livewire\MonitorEdit::class)->name('monitor.edit');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
});

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', \App\Livewire\Settings\SettingsProfile::class)->name('profile.edit');
});

Route::prefix('status')->middleware('auth')->group(function () {
    Route::get('/', \App\Livewire\Status\Status::class)->name('status');
    Route::get('/edit/{id}', \App\Livewire\Status\StatusEdit::class)->name('status.edit');

});
Route::get('/status/page/{id}', \App\Livewire\Status\StatusPublic::class)->name('status.public');
