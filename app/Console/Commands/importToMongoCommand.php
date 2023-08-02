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
                $mongo_email = PstEmailMongo::create($email->toArray());
                $mongo_email->email_id = $email->id;
                $mongo_email->save();
            }

            // Manually clear memory for each batch
            unset($emails);
            echo "Batch :".$batch." done \n";
        }
    }
}
