<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class PstEmailAttachmentMongo extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'pst_email_attachments';
    protected $fillable = [
        'email_id',
        'message_id',
        'file_name',
        'file_path',
        'full_path',
        'pst_email_attachments_tenant_id',
    ];
}
