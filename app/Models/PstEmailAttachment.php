<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PstEmailAttachment extends Model
{
    protected $fillable = [
        'email_id',
        'message_id',
        'file_name',
        'file_path',
        'full_path',
        'pst_email_attachments_tenant_id',
    ];
}
