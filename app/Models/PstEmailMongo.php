<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PstEmailMongo extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'pst_emails';
    protected $table = 'pst_emails';

    protected $fillable = [
        'folder_id',
        'message_id',
        'pst_name',
        'body',
        'folder_name',
        'sender_name',
        'sender_email',
        'receiver_name',
        'receiver_email',
        'headers',
        'subject',
        'creation_date',
        'delivery_date',
        'attachment_count',
        'pst_emails_tenant_id',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'delivery_date' => 'datetime',
    ];
}
