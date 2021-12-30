<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // tabela de dúvidas
        // usuários do tipo paciente podem mandar quantas dúvidas quiserem
        // usuários do tipo profissionais respondem essas dúvidas
        Schema::create('doubts', function (Blueprint $table) {
            $table->id('id_doubt'); // id da dúvida
            $table->string('id_user');  // paciente que mandou a dúvida
            $table->text("message");    // dúvida do paciente
            $table->string("status");   // status da dúvida: waiting (default), answered
            $table->boolean("read")->nullable(); // null (default) -> profissional respondeu e usuário não viu (false), usuário viu resposta (true)
            $table->timestamps(); // created_at = data/hora que a pergunta foi feita, updated_at = hora que foi respondida
        });

        Schema::create('doubt_answers', function (Blueprint $table) {
            $table->string('id_doubt');  // paciente que mandou a dúvida
            $table->text("answer")->nullable(); // resposta do profissional ao paciente
            $table->string("answered_by")->nullable(); // id do profissional que respondeu
            $table->timestamps(); // created_at = data/hora que a pergunta foi feita, updated_at = hora que foi respondida
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_tables');
    }
}
