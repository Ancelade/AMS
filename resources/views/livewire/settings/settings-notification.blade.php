<div wire:ignore>

    <div class="row">
        <div class="col-12">
            <h4 class="mt-3 mb-3">{{ t('Notification') }}</h4>
        </div>


            <div class="row w-100 d-flex flex-nowrap">
                <div class="sidebar" style="border-radius: 10px; border:none; height: auto">
                    <div class="items m-0 pl-0">
                        <a wire:click="changeNotifier('Telegram')" class="item @if($notificator==='Telegram') active @endif">
                            <p>Telegram</p>
                        </a>
                        <a wire:click="changeNotifier('Discord')" class="item @if($notificator==='Discord') active @endif">
                            <p>Discord</p>
                        </a>
                        <a wire:click="changeNotifier('Slack')" class="item @if($notificator==='Slack') active @endif">
                            <p>Slack</p>
                        </a>
                    </div>
                </div>

               <div class="col-10">
                   <h4>{{ t('Webhook pour') }} {{ $notificator }}</h4>
                   <form wire:submit.prevent="saveWebhook">
                       <input type="text" class="form-control" wire:model="webhookUrl"
                              placeholder="https://xxxxx - Webhook Url">
                       <div class="d-flex justify-content-end">
                           <button type="submit" class="btn btn-primary mt-2">{{ t('Enregistrer') }}</button>
                       </div>
                   </form>
               </div>
            </div>


    </div>




</div>
