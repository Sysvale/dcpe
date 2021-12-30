<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesFollowUp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // tabela de solicitação de acompanhamento pelo usuário
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id(); // id do chat
            $table->string('id_user');  // paciente que solicitou acompanhamento
            $table->string("requested"); // se solicitou = true, se não = false
            $table->string("accepted_by")->nullable(); // null (default), caso algum profissional aceite o id dele 
            $table->timestamps(); // created_at = data/hora que a solititação foi feita, updated_at = hora que foi aceita
        });

        // tabela de mensagens de acompanhamento pelo usuário/profissional
        Schema::create('follow_up_chats', function (Blueprint $table) {
            $table->id();
            $table->string('id_chat');
            $table->string('id_user');  // id do paciente que está em acompanhamento
            $table->text("message"); // mensagem
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
        Schema::dropIfExists('tables_follow_up');
    }
}
