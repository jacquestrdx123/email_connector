<?php

namespace App\Http\Controllers;

use App\Http\Resources\PstEmailAttachmentResource;
use App\Models\PstEmailAttachment;
use Illuminate\Http\Request;

class PstEmailAttachmentMongoController extends Controller
{
    public function index()
    {
        return PstEmailAttachmentResource::collection(PstEmailAttachment::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'email_id' => ['nullable', 'integer'],
            'message_id' => ['nullable', 'integer'],
            'file_name' => ['nullable'],
            'file_path' => ['nullable'],
            'full_path' => ['nullable'],
            'pst_email_attachments_tenant_id' => ['nullable', 'integer'],
        ]);

        return new PstEmailAttachmentResource(PstEmailAttachment::create($request->validated()));
    }

    public function show(PstEmailAttachment $pstEmailAttachment)
    {
        return new PstEmailAttachmentResource($pstEmailAttachment);
    }

    public function update(Request $request, PstEmailAttachment $pstEmailAttachment)
    {
        $request->validate([
            'email_id' => ['nullable', 'integer'],
            'message_id' => ['nullable', 'integer'],
            'file_name' => ['nullable'],
            'file_path' => ['nullable'],
            'full_path' => ['nullable'],
            'pst_email_attachments_tenant_id' => ['nullable', 'integer'],
        ]);

        $pstEmailAttachment->update($request->validated());

        return new PstEmailAttachmentResource($pstEmailAttachment);
    }

    public function destroy(PstEmailAttachment $pstEmailAttachment)
    {
        $pstEmailAttachment->delete();

        return response()->json();
    }
}
