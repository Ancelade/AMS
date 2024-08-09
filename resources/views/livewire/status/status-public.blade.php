<div>
    <div class="d-flex flex-center mb-5">
        <img width="200px" src="/images/logo.svg">
    </div>

    <?php $groups = \App\Models\StatusGroup::query()->where('status_page_id', $id)->get(); ?>
    @foreach($groups as $group)

        <h4 style=" color: #fff" class="mt-4 mb-2">{{ $group->name }}</h4>
        @foreach(\App\Models\StatusMonitor::where('status_group_id', $group->id)->get() as $monit)
                <?php $monitTotal = \App\Models\Monitor::find($monit->monitor_id) ?>


            <livewire:components.device-monitoring device_id="{{ $monitTotal->device_id }}"></livewire:components.device-monitoring>

        @endforeach

    @endforeach
</div>
