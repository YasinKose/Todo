<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Jobs;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class JobQuery extends AuthorizeQueries
{
    protected $attributes = [
        'name' => 'job',
        'description' => 'A query',
        'model' => Jobs::class
    ];

    public function type(): Type
    {
        return GraphQL::type('Jobs');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => [
                    'required'
                ]
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Jobs::findOrFail($args['id']);
    }
}
