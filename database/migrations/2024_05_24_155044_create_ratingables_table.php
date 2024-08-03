<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('ratingables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rating_id');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->float('rating');

            $table->unsignedBigInteger('ratingable_id');
            $table->string('ratingable_type');


            $table->foreign('rating_id')->references('id')->on('ratings')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('ratingables');
    }
};
