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
        Schema::table('proizvods', function (Blueprint $table) {
              $table->unsignedBigInteger('kategorija_id')->nullable()->after('kategorija');

            $table->foreign('kategorija_id')
                ->references('id')
                ->on('kategorijas')
                ->onDelete('set null');
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proizvods', function (Blueprint $table) {
            $table->dropForeign(['kategorija_id']);
            $table->dropColumn('kategorija_id');
        });
    }
};
