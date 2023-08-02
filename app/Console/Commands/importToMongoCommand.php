<?php

namespace App\Console\Commands;

use App\Models\PstEmail;
use App\Models\PstEmailAttachment;
use App\Models\PstEmailAttachmentMongo;
use App\Models\PstEmailMongo;
use Illuminate\Console\Command;

class importToMongoCommand extends Command
{
    protected $signature = 'import:to-mongo';

    protected $description = 'Command description';

    public function handle()
    {
        $batchSize = 100; // Number of emails to process per batch
        $totalEmails = PstEmail::count();
        $totalBatches = ceil($totalEmails / $batchSize);

        for ($batch = 1; $batch <= $totalBatches; $batch++) {
            $offset = ($batch - 1) * $batchSize;
            $emails = PstEmail::skip($offset)->take($batchSize)->get();

            foreach ($emails as $email) {
                $attachments = PstEmailAttachment::where('email_id',$email->id)->get();
                $mongo_email = PstEmailMongo::create($email->toArray());
                $mongo_email->email_id = $email->id;
                $mongo_email->save();
                foreach($attachments as $attachment){
                    $mongo_attachment = PstEmailAttachmentMongo::create($attachment->toArray());
                    $mongo_attachment->email_id = $mongo_email->email_id;
                    $mongo_attachment->attachment_id = $attachment->id;
                    $mongo_attachment->save();
                }
                unset($attachments);
            }

            // Manually clear memory for each batch
            unset($emails);
            echo "Batch :".$batch." done \n";
        }
    }
}
