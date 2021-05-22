<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('pickup_date')->nullable();
            $table->string('appointment_time')->nullable();
            $table->unsignedInteger('floor_from')->nullable();
            $table->unsignedInteger('floor_to')->nullable();
            $table->unsignedInteger('movingtype_id')->nullable();
            $table->unsignedInteger('movingsize_id')->nullable();
            $table->unsignedInteger('officesize_id')->nullable();
            $table->unsignedInteger('movernumber_id')->nullable();
            $table->unsignedInteger('vehicle_id')->nullable();
            $table->double('cost')->nullable();
            $table->string('instructions')->nullable();
            $table->string('charge_id');
            $table->string('uniqid')->unique();
            $table->string('status')->default('Not picked');
            $table->unsignedInteger('shipper_id')->nullable();
            $table->unsignedInteger('contact_id')->nullable();
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
