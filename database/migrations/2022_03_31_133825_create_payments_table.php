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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');
            $table->string('price');
            $table->string('authority')->nullable();
            $table->string('ref_id')->nullable();
            $table->string('status')->default("Waiting")->comment("Canceled | Waiting => awaiting payment | Paid");
            $table->text('body')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('price_type',1)->default('R')->comment('R => rial | T => toman');
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
        Schema::dropIfExists('payments');
    }
};
