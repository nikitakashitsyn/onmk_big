<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTestPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_packs', function (Blueprint $table) {
            $table->string('description')->nullable();
            $table->integer('timeout')->default(0);
            $table->integer('max_attempts')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('test_packs', 'description');
        Schema::dropColumns('test_packs', 'timeout');
        Schema::dropColumns('test_packs', 'max_attempts');
    }
}
