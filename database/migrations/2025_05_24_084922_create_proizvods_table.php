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
        Schema::create('proizvods', function (Blueprint $table) {
            $table->id();
            $table->string('naziv');
            $table->text('opis');
            $table->decimal('cena', 10, 2);
            $table->unsignedTinyInteger('popust')->default(0);
            $table->string('kategorija');
            $table->json('slike')->nullable(); // niz putanja ka slikama
            $table->text('napomena')->nullable();
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
        Schema::dropIfExists('proizvods');
    }
};
