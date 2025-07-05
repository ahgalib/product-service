<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use App\Services\ElasticsearchService;

class ReindexProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reindex-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting reindexing...');

        $service = app(ElasticsearchService::class);

        // Optional: chunk to handle 100k products efficiently
        Product::chunk(1000, function ($products) use ($service) {
            foreach ($products as $product) {
                $service->indexProduct($product);
            }
        });

        $this->info('Reindexing complete!');
    }
}
