<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investimentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id', 9)->unasigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('tipo_investimento',10);
            $table->float('valor', 8, 2);
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
        Schema::table('investimentos', function (Blueprint $table) {
            Schema::drop('investimentos');
        });
    }
}
