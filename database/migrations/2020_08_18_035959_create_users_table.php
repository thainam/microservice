<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('fullname', 60);
            $table->enum('type',['J','F'])->index('type_INDEX')->comment('J = Pessoa Jurídica; F = Pessoa Física.');
            $table->string('cpf', 14)->unique('cpf_UNIQUE');
            $table->string('cnpj', 18)->unique('cnpj_UNIQUE')->nulllable();
            $table->string('email', 45)->unique('email_UNIQUE');
            $table->char('password', 60);
            $table->decimal('wallet', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
