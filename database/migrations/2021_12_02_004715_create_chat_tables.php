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
            $table->id();
            $table->string('id_user');  // paciente que mandou a dúvida
            $table->text("message");    // dúvida do paciente
            $table->string("status");   // status da dúvida: waiting (default), answered
            $table->text("answered")->nullable(); // resposta do profissional ao paciente
            $table->boolean("read")->nullable(); // null (default) -> profissional respondeu e usuário não viu (false), usuário viu resposta (true)
            $table->string("answered_by")->nullable(); // id do profissional que respondeu
            $table->timestamps(); // created_at = data/hora que a pergunta foi feita, updated_at = hora que foi respondida
        });

        // tabela de solicitação de acompanhamento pelo usuário
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');  // paciente que solicitou acompanhamento
            $table->string("requested"); // se solicitou = true, se não = false
            $table->string("accepted_by")->nullable(); // null (default), caso algum profissional aceite o id dele 
            $table->timestamps(); // created_at = data/hora que a solititação foi feita, updated_at = hora que foi aceita
        });

        // tabela de mensagens de acompanhamento pelo usuário/profissional
        Schema::create('follow_up_chats', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');  // id do paciente que está em acompanhamento
            $table->string("id_professional"); // id do profissional que o acompanha
            $table->string("sent_by"); // patient = se a mensagem foi enviada pelo paciente, professional = se foi enviada pelo profissional
            $table->text("message"); // mensagem
            $table->boolean("read"); // false = se o paciente não visualizou, true = se visualizou 
            $table->timestamps(); // created_at = data/hora que a solititação foi feita, updated_at = hora que foi aceita
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
