<?php

use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function($table)
        {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('channel', 50)->index();
            $table->string('level',   50)->index();
            $table->string('level_name', 100);
            $table->text('message');
            $table->text('context');

            $table->integer('remote_addr');
            $table->string('user_agent');
            $table->string('session_id');
            $table->integer('created_by')->index();

            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('logs');
    }
}
