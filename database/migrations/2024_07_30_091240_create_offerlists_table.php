<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offerlists', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_id');
            $table->string('offername');
            $table->string('coupon_no');
            $table->string('coupon_validity');
            $table->string('coupon_time');
            $table->string('amount');
            $table->string('minimum_price');
            $table->integer('status')->default(1);
            $table->softDeletes('deleted_at', 0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('offerlists');
    }
};
