<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pst_emails', function (Blueprint $table) {
            $table->id();
            $table->integer('folder_id')->nullable();
            $table->integer('message_id')->nullable();
            $table->string('pst_name')->nullable();
            $table->string('body')->nullable();
            $table->string('folder_name')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_email')->nullable();
            $table->longText('headers')->nullable();
            $table->longText('subject')->nullable();
            $table->dateTime('creation_date')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->integer('attachment_count')->nullable();
            $table->integer('pst_emails_tenant_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pst_emails');
    }
};
