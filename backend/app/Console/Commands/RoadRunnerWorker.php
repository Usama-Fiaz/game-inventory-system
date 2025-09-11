<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spiral\GRPC\Server as GrpcServer;
use Spiral\RoadRunner\Worker;
use App\Grpc\ItemService;

class RoadRunnerWorker extends Command
{
    protected $signature = 'rr:worker';

    protected $description = 'Run RoadRunner gRPC worker';

    public function handle(): int
    {
        $worker = Worker::create();

        $server = new GrpcServer($worker);
        $server->registerService(ItemService::class);

        $this->info('RoadRunner gRPC worker started');
        $server->serve();

        return self::SUCCESS;
    }
}


