<?php

namespace App\Console\Commands;

use App\Models\PstEmail;
use App\Models\PstEmailMongo;
use Illuminate\Console\Command;

class selectFromMongoCommand extends Command
{
    protected $signature = 'mango:select';

    protected $description = 'Command description';

    public function handle()
    {
        $emails = PstEmailMongo::get()->toArray();
        dd($emails);
    }
}
