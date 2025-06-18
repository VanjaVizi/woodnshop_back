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
        Schema::create('cenovniks', function (Blueprint $table) {
             $table->id();
            $table->foreignId('proizvod_id')->constrained()->onDelete('cascade');
            $table->string('naziv'); // npr. "30x20 cm"
            $table->decimal('cena', 10, 2); // npr. 2500.00
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
        Schema::dropIfExists('cenovniks');
    }
};
