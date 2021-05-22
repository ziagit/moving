<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carriers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company');
            $table->integer('year_established');
            $table->integer('employees');
            $table->integer('vehicles');
            $table->string('insurance_papers');
            $table->string('business_license');
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->text('detail')->nullable();
            $table->double('votes')->default(2.0);
            $table->unsignedInteger('contact_id');
            $table->unsignedInteger('address_id');
            $table->unsignedInteger('user_id');

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
        Schema::dropIfExists('carriers');
    }
}
