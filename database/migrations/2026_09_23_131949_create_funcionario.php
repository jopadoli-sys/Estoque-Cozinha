<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('senha');
            $table->string('cpf', 11)->unique();
            $table->string('nif', 9)->unique();
            $table->date('data_nascimento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('funcionario', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
        });

        Schema::dropIfExists('funcionario');
    }
};
