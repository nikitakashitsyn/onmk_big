<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTableExamData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_data', function (Blueprint $table) {
            $table->integer('exam_id');
            $table->integer('test_id');
            $table->json('question');
            $table->json('answer');
            $table->integer('started_at');
            $table->integer('ended_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('exam_data', 'exam_id');
        Schema::dropColumns('exam_data', 'test_id');
        Schema::dropColumns('exam_data', 'question');
        Schema::dropColumns('exam_data', 'answer');
        Schema::dropColumns('exam_data', 'started_at');
        Schema::dropColumns('exam_data', 'ended_at');
    }
}
