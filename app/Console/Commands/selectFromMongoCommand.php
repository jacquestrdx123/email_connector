<?php

namespace App\Console\Commands;

use App\Models\PstEmail;
use App\Models\PstEmailMongo;
use Illuminate\Console\Command;

class selectFromMongoCommand extends Command
{
    protected $signature = 'mango:select {database}';

    protected $description = 'Command description';

    public function handle()
    {

        config(['database.connections.mongodb.database' => $this->argument('database') ]);

        $emails = PstEmailMongo::get()->toArray();
        foreach($emails as $email){
            dd($email);
        }
    }
}
