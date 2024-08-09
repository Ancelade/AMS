<?php

namespace App\Livewire\Settings;

use App\Models\Notifier;
use Illuminate\View\View;
use Livewire\Component;

class SettingsNotification extends Component
{
    public string $notificator = "Telegram";
    public ?string $webhookUrl;

    /**
     * @return View
     */
    public function render() : View
    {
        $notifier = Notifier::where('type', $this->notificator)->first();
        if ($notifier) {
            $this->webhookUrl = $notifier->webhook;
        } else {
            $this->webhookUrl = "";
        }

        return view('livewire.settings.settings-notification')->layout('layouts.dash');

    }

    public function changeNotifier($notifier)
    {
        $this->notificator = $notifier;
    }


    /**
     * @param string $name
     * @return void
     */
    public function selectNotificator(string $name): void
    {
        $this->notificator = $name;
        $notifier = Notifier::where('type', $this->notificator)->first();
        if ($notifier) {
            $this->webhookUrl = $notifier->webhook;
        } else {
            $this->webhookUrl = "";
        }

    }

    /**
     * @return void
     */
    public function saveWebhook(): void
    {

        $notifier = Notifier::where('type', $this->notificator)->first();
        if ($notifier) {
            $notifier->webhook = $this->webhookUrl;
            if (!empty($this->webhookUrl)) {
                $notifier->save();
            } else {
                $notifier->delete();
            }

        } else {
            $notifier = new Notifier();
            $notifier->type = $this->notificator;
            $notifier->webhook = $this->webhookUrl;
            $notifier->save();
        }
        toastr()->success('Ce Webhook a été sauvegardé');
    }


}
