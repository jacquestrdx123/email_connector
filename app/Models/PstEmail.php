<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class PstEmail extends Model
{
    use Searchable;

    public function toSearchableArray()
    {
        return $this->toArray();
    }

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
