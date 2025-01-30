<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('ip_address');
            $table->string('location');
            $table->enum('type', ['virtual', 'physical']);
            $table->string('operating_system');
            $table->string('environment');
            $table->json('specifications');
            $table->json('stakeholders');
            $table->text('business_impact');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
