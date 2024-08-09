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
        Schema::create('snmp_iface', function (Blueprint $table) {
            $table->id();
            $table->integer("device_id");
            $table->string("identifier");
            $table->string("name");
            $table->string("type");
            $table->string("mtu");
            $table->string("speed");
            $table->string("mac");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snmp_iface');
    }
};
