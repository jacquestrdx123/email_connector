<?php

namespace App\Http\Controllers;

use App\Http\Resources\PstEmailResource;
use App\Models\PstEmail;
use Illuminate\Http\Request;

class PstEmailMongoController extends Controller
{
    public function index()
    {
        return PstEmailResource::collection(PstEmail::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'folder_id' => ['nullable', 'integer'],
            'message_id' => ['nullable', 'integer'],
            'pst_name' => ['nullable'],
            'body' => ['nullable'],
            'folder_name' => ['nullable'],
            'sender_name' => ['nullable'],
            'sender_email' => ['nullable', 'email', 'max:254'],
            'receiver_name' => ['nullable'],
            'receiver_email' => ['nullable', 'email', 'max:254'],
            'headers' => ['nullable'],
            'subject' => ['nullable'],
            'creation_date' => ['nullable', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'attachment_count' => ['nullable', 'integer'],
            'pst_emails_tenant_id' => ['nullable', 'integer'],
        ]);

        return new PstEmailResource(PstEmail::create($request->validated()));
    }

    public function show(PstEmail $pstEmail)
    {
        return new PstEmailResource($pstEmail);
    }

    public function update(Request $request, PstEmail $pstEmail)
    {
        $request->validate([
            'folder_id' => ['nullable', 'integer'],
            'message_id' => ['nullable', 'integer'],
            'pst_name' => ['nullable'],
            'body' => ['nullable'],
            'folder_name' => ['nullable'],
            'sender_name' => ['nullable'],
            'sender_email' => ['nullable', 'email', 'max:254'],
            'receiver_name' => ['nullable'],
            'receiver_email' => ['nullable', 'email', 'max:254'],
            'headers' => ['nullable'],
            'subject' => ['nullable'],
            'creation_date' => ['nullable', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'attachment_count' => ['nullable', 'integer'],
            'pst_emails_tenant_id' => ['nullable', 'integer'],
        ]);

        $pstEmail->update($request->validated());

        return new PstEmailResource($pstEmail);
    }

    public function destroy(PstEmail $pstEmail)
    {
        $pstEmail->delete();

        return response()->json();
    }
}
