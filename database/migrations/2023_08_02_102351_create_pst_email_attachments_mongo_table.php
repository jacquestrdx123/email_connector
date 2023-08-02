<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::connection('mongodb')->create('pst_email_attachments', function (Blueprint $table) {
            $table->id();
            $table->integer('email_id')->nullable();
            $table->integer('message_id')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('full_path')->nullable();
            $table->integer('pst_email_attachments_tenant_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pst_email_attachments');
    }
};
