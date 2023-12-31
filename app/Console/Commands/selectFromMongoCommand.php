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
            ->setHosts([ env('ELASTICSEARCH_HOST') ])
            ->setBasicAuthentication(env('ELASTICSEARCH_USER'), env('ELASTICSEARCH_PASSWORD'))
            ->build();
        $response = $client->info();

        dd($response->getStatusCode());

    }
}
