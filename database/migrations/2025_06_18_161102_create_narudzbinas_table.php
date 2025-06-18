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
        Schema::create('narudzbinas', function (Blueprint $table) {
            $table->id();
            $table->string('ime');
            $table->string('prezime')->nullable();
            $table->string('email')->nullable();
            $table->string('telefon')->nullable();
            $table->string('adresa')->nullable();
            $table->string('grad')->nullable();
            $table->string('postanski_broj')->nullable();
            $table->enum('placanje', ['pouzecem', 'racun'])->nullable(); // ili string ako hoćeš fleksibilnije
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
        Schema::dropIfExists('narudzbinas');
    }
};
