<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::table('monitors', function (Blueprint $table) {
            $table->integer("device_id");

        });

        $monitors = \App\Models\Monitor::get();
        foreach ($monitors as $monitor) {
            $dev = new \App\Models\Devices();
            $dev->name = $monitor->name;
            $dev->save();
            $monitor->device_id = $dev->id;
            $monitor->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitor_device');
    }
};
