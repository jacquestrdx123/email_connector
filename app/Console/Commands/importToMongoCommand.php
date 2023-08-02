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
        $emails = PstEmail::take(1000)->get()->toArray();
        foreach($emails as $email){
            $mongo_email = PstEmailMongo::create($email);
            $mongo_email->save();
        }
    }
}
