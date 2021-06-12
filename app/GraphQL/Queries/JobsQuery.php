<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Jobs;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;

class JobsQuery extends AuthorizeQueries
{
    protected $attributes = [
        'name' => 'jobs',
        'description' => 'A query'
    ];

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


        $user = Auth::id();
        $job = Jobs::whereHas("users", function ($query) use ($user) {
            $query->whereIn("user_id", [$user]);
        })->with($fields->getRelations());

        if (collect($fields->getSelect())->search("jobs.steps_count")) {
            $job->withCount("steps");
        }

        return $job->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
