<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pizzas', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('type');
            $table->string('base');
            $table->string('name');
            $table->json('toppings');
            $table->string('status')->default('waiting');

            // Add the user_id column
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['user_id']);

            // Then drop the user_id column
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('pizzas');
    }
};
