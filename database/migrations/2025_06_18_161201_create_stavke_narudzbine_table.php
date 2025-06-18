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
        Schema::create('stavke_narudzbine', function (Blueprint $table) {
             $table->id();
                $table->foreignId('narudzbina_id')->constrained()->onDelete('cascade');
                $table->foreignId('proizvod_id')->constrained()->onDelete('cascade');
             

                // Snapshot podaci
                $table->string('naziv_proizvoda'); // kopija iz trenutka porudžbine
                $table->string('dimenzija')->nullable(); // može biti iz cenovnika ili custom
                $table->decimal('cena', 10, 2)->nullable();
                $table->boolean('cena_na_upit')->default(false);

                $table->integer('kolicina')->default(1);
                $table->text('napomena_kupca')->nullable();
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
        Schema::dropIfExists('stavke_narudzbine');
    }
};
