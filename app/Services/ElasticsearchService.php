<?php

namespace App\Services;

use Elastic\Elasticsearch\Client as ElasticClient;
use Elastic\Elasticsearch\ClientBuilder as ElasticClientBuilder;

class ElasticsearchService
{
    protected ElasticClient $client;

    public function __construct()
    {
        $this->client = ElasticClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST', 'localhost:9200')])
            ->build();
    }

    public function indexProduct($product)
    {
        return $this->client->index([
            'index' => 'products',
            'id' => $product->id,
            'body' => [
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'brand' => $product->brand->name ?? null,
                'category' => $product->category->name ?? null,
            ]
        ]);
    }

    public function searchProduct($query)
    {
        return $this->client->search([
            'index' => 'products',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['name^3', 'description', 'brand', 'category'],
                        'fuzziness' => 'AUTO',
                    ]
                ]
            ]
        ]);
    }

    public function autocomplete(string $input)
    {
        return $this->client->search([
            'index' => 'products',
            'body' => [
                'size' => 10,
                '_source' => ['id', 'name'], // return only what you need
                'query' => [
                    'match_phrase_prefix' => [
                        'name' => [
                            'query' => $input
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function deleteProduct($id)
    {
        return $this->client->delete([
            'index' => 'products',
            'id' => $id
        ]);
    }
}
