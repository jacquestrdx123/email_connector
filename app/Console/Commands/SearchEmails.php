<?php

namespace App\Console\Commands;

use App\Models\PstEmail;
use App\Models\PstEmailAttachment;
use App\Models\PstEmailAttachmentMongo;
use App\Models\PstEmailMongo;
use Illuminate\Console\Command;

class SearchEmails extends Command
{
    protected $signature = 'SearchEmails {email}';

    protected $description = 'SearchEmails {email}';

    public function handle()
    {
        $pst_emails = PstEmail::search('hello', function () {
            // this will not be triggered
        })->get();

        return response()->json( $pst_emails );
    }
}
