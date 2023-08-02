<?php

namespace App\Console\Commands;

use App\Models\PstEmail;
use App\Models\PstEmailMongo;
use Illuminate\Console\Command;

class importToMongoCommand extends Command
{
    protected $signature = 'import:to-mongo';

    protected $description = 'Command description';

    public function handle()
    {
        $emails = PstEmail::get();
        foreach($emails as $email){
            $mongo_email = new PstEmailMongo();
            $mongo_email->update($email->toArray());
            $mongo_email->save();
        }
    }
}
