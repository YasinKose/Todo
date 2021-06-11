<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Jobs;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class JobsQuery extends Query
{
    protected $attributes = [
        'name' => 'jobs',
        'description' => 'A query'
    ];

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::check();
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],

            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
        ];
    }

    public function type(): Type
    {
        return GraphQL::paginate('Jobs');
    }

    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $args['page'] = $args['page'] ?? 1;
        $args['limit'] = $args['limit'] ?? 10;
        $args['limit'] = $args['limit'] < 100 && $args['limit'] > 10 ? $args['limit'] : 10;

        $fields = $getSelectFields();

        return Jobs::with($fields->getRelations())
            ->select($fields->getSelect())
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
