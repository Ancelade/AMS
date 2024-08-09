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
        Schema::create('monitors', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("host");
            $table->integer("port")->nullable();
            $table->integer("timeout");
            $table->integer("interval");
            $table->integer("retry");
            $table->string("keyword")->nullable();
            $table->string("type");
            $table->unsignedInteger("n_down")->default(0);
            $table->unsignedInteger("n_up")->default(0);
            $table->unsignedInteger("n_down_total")->default(0);
            $table->unsignedInteger("n_up_total")->default(0);
            $table->integer("status")->default(-1); //0 unchecked 1 down 2 up
            $table->integer("last_latency")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitor');
    }
};
