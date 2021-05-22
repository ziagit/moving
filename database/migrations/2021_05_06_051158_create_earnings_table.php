<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->double('travel_cost');
            $table->double('moving_cost');
            $table->double('supplies_cost');
            $table->double('service_fee');
            $table->double('disposal_fee');
            $table->double('carrier_earning');
            $table->double('tingsapp_earning');
            $table->double('received_gst');
            $table->double('paid_gst');
            $table->double('unpaid_gst');
            $table->string('status')->default('unpaid');
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('carrier_id');
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
        Schema::dropIfExists('earnings');
    }
}
