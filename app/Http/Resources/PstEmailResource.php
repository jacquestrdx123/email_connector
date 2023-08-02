<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\PstEmail */
class PstEmailResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'folder_id' => $this->folder_id,
            'message_id' => $this->message_id,
            'pst_name' => $this->pst_name,
            'body' => $this->body,
            'folder_name' => $this->folder_name,
            'sender_name' => $this->sender_name,
            'sender_email' => $this->sender_email,
            'receiver_name' => $this->receiver_name,
            'receiver_email' => $this->receiver_email,
            'headers' => $this->headers,
            'subject' => $this->subject,
            'creation_date' => $this->creation_date,
            'delivery_date' => $this->delivery_date,
            'attachment_count' => $this->attachment_count,
            'pst_emails_tenant_id' => $this->pst_emails_tenant_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
