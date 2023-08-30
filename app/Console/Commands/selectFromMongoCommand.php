<?php

namespace App\Console\Commands;

use App\Models\PstEmail;
use App\Models\PstEmailMongo;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class selectFromMongoCommand extends Command
{
    protected $signature = 'mango:select {database}';

    protected $description = 'Command description';

    public function handle()
    {

        $client = ClientBuilder::create()
            ->setHosts([ 'http://'.env('ELASTICSEARCH_HOST').':'.env('ELASTICSEARCH_PORT') ])
            ->setBasicAuthentication(env('ELASTICSEARCH_USER'), env('ELASTICSEARCH_PASS'))
            ->build();
        $response = $client->info();

        dd($response->getStatusCode());

    }
}
