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
            $table->string('uniqid')->unique();
            $table->unsignedInteger('floor_from')->nullable();
            $table->unsignedInteger('floor_to')->nullable();
            $table->date('pickup_date');
            $table->string('appointment_time');
            $table->unsignedInteger('movingtype_id');
            $table->unsignedInteger('movingsize_id')->nullable();
            $table->unsignedInteger('officesize_id')->nullable();
            $table->unsignedInteger('movernumber_id')->nullable();
            $table->unsignedInteger('vehicle_id')->nullable();
            $table->string('instructions')->nullable();
            $table->string('status')->default('New');
            $table->double('cost');
            $table->double('travel_cost');
            $table->double('moving_cost');
            $table->double('tax');
            $table->double('service_fee');
            $table->double('disposal_fee')->nullable();
            $table->double('supplies_cost')->nullable();
            $table->double('tips')->nullable();
            $table->double('distance')->nullable();
            $table->double('duration')->nullable();

            $table->string('charge_id')->nullable();

            $table->unsignedInteger('shipper_id');
            $table->unsignedInteger('contact_id');
         
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
