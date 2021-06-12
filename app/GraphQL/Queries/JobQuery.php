<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Jobs;
use GraphQL\Exception\InvalidArgument;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;

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
        $jobs = Auth::user()->jobs->find($args['id']);

        if (!$jobs) {
            throw new InvalidArgument("Eşleşen veri bulunamadı!");
        }

        return $jobs;
    }
}
