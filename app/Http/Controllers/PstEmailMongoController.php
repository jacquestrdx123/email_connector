<?php

namespace App\Http\Controllers;

use App\Http\Resources\PstEmailResource;
use App\Models\PstEmail;
use App\Models\PstEmailMongo;
use Illuminate\Http\Request;

class PstEmailMongoController extends Controller
{
    public function index(Request $request)
    {
        $email_query = PstEmailMongo::query();

        $input = $request->all();

        if(array_key_exists('start_date',$input)){
            if(strlen($input['start_date'])){
                $start_date = \DateTime::createFromFormat('m/d/Y h:i A', $input['start_date']);
                $sql_start_date = $start_date->format('Y-m-d H:i:s');
                $email_query->where('delivery_date','>',$sql_start_date);
            }
        }else{
            $input['start_date'] = '';
        }
        if(array_key_exists('end_date',$input)){
            if(strlen($input['end_date'])){
                $end_date = \DateTime::createFromFormat('m/d/Y h:i A', $input['end_date']);
                $sql_end_date = $end_date->format('Y-m-d H:i:s');
                $email_query->where('delivery_date','<',$sql_end_date);
            }

        }else{
            $input['end_date'] = '';
        }
        if(array_key_exists('keyword',$input)){
            $keyword = $input['keyword'];
            $keywords = explode(" ", $keyword);
            foreach($keywords as $keyword){
                if(strlen($keyword)){
                    $email_query->where(function ($query) use ($keyword) {
                        $columns = [
                            'body',
                            'headers',
                            'subject',
                        ];
                        foreach ($columns as $column) {
                            $query->orWhere($column, 'like', '%'.$keyword.'%');
                        }
                    });
                }
            }


        }else{
            $input['keyword'] = '';
        }
        if(array_key_exists('from_email',$input)){
            if(is_array($input['from_email'])){
                $email_query->where(function ($query) use ($input) {
                    foreach ($input['from_email'] as $input_email) {
                        if (strlen($input_email)) {
                            $query->where('sender_email', 'like', '%' . $input_email . '%');
                        }
                    }
                });
            }
        }else{
            $input['from_email'] = '';
        }
        if(array_key_exists('to_email',$input)){
            if(is_array($input['to_email'])){
                $email_query->where(function ($query) use ($input) {
                    foreach ($input['to_email'] as $input_email) {
                        if (strlen($input_email)) {
                            $query->where('receiver_email', 'like', '%' . $input_email . '%');
                        }
                    }
                });
            }
        }else{
            $input['to_email'] = '';
        }
        if(array_key_exists('search_exclude_email',$input)){
            if(is_array($input['search_exclude_email'])){
                foreach($input['search_exclude_email'] as $exclude_email){
                    if(strlen($exclude_email)){
                        $email_query->where('sender_email', 'not like', '%' . $exclude_email . '%');
                        $email_query->where('receiver_email', 'not like', '%' . $exclude_email . '%');
                    }
                }
            }

        }else{
            $input['search_exclude_email'] = '';
        }
        if(array_key_exists('from_name',$input)){
            if(strlen($input['from_name'])){
                $email_query->where('sender_name','like', '%'.$input['from_name'].'%');
            }

        }else{
            $input['from_name'] = '';
        }
        if(array_key_exists('to_name',$input)){
            if(strlen($input['to_name'])){
                $email_query->where('receiver_name','like', '%'.$input['to_name'].'%');
            }

        }else{
            $input['to_name'] = '';
        }
        if(array_key_exists('pst',$input)){
            if(is_array($input['pst_file'])){
                foreach($input['pst_file'] as $input_pst){
                    if(strlen($input_pst)){
                        $email_query->where('pst_name',$input_pst);
                    }
                }
            }

        }else{
            $input['pst'] = '';
        }
        if(array_key_exists('tags',$input)){
            if(is_array($input['tags'])){
                foreach($input['tags'] as $tag){
                    if(strlen($tag)){
                        $tagged_email_ids = \DB::select("select email_id from pst_email_pst_email_tags where tag_id=".$tag);
                        $tag_ids = [];
                        foreach($tagged_email_ids as $id){
                            $tag_ids[] = $id->email_id;
                        }
                        $email_query->whereIn('id',$tag_ids);
                    }
                }
            }


        }else{
            $input['tags'] = '';
        }
        if(array_key_exists('exclude_tags',$input)){
            if(is_array($input['exclude_tags'])){
                foreach($input['exclude_tags'] as $tag){
                    if(strlen($tag)){
                        $tagged_email_ids = \DB::select("select email_id from pst_email_pst_email_tags where tag_id=".$tag);
                        $tag_ids = [];
                        foreach($tagged_email_ids as $id){
                            $tag_ids[] = $id->email_id;
                        }
                        $email_query->whereNotIn('id',$tag_ids);
                    }
                }
            }
        }else{
            $input['exclude_tags'] = '';
        }
        if(array_key_exists('attachment_name',$input)){
            if(is_array($input['attachment_name'])){
                foreach($input['attachment_name'] as $attachment){
                    if(strlen($attachment)){
                        $attachment_emails = \DB::select('select email_id from pst_email_attachments where file_name like "%'.$attachment.'%"');
                        $attachment_ids = [];
                        foreach($attachment_emails as $id){
                            $attachment_ids[] = $id->email_id;
                        }
                        $email_query->whereIn('id',$attachment_ids);
                    }
                }
            }
        }

        $emails = $email_query->orderBy('delivery_date','DESC')->limit(5000)->get();
        return response()->json([
            "emails" => $emails
        ]);
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
