<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_transactions', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->bigInteger('payer')->unsigned()->index('fk_user_transactions_users1_idx')->comment('ID do usuário que está pagando.');
            $table->bigInteger('payee')->unsigned()->index('fk_user_transactions_users2_idx')->comment('ID do usuário que está recebendo.');
            $table->enum('status', ['0','1','2'])->default('0')->comment('0 = Pendente; 1 = Concluída; 2 = Estornada');
            $table->decimal('amount', 10, 2);

            $table->foreign('payer', 'fk_user_transactions_users1')->references('id')->on('users');
            $table->foreign('payee', 'fk_user_transactions_users2')->references('id')->on('users');

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
        Schema::dropIfExists('user_transactions');
    }
}
