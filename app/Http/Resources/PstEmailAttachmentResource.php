<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\PstEmailAttachment */
class PstEmailAttachmentResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'email_id' => $this->email_id,
            'message_id' => $this->message_id,
            'file_name' => $this->file_name,
            'file_path' => $this->file_path,
            'full_path' => $this->full_path,
            'pst_email_attachments_tenant_id' => $this->pst_email_attachments_tenant_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
