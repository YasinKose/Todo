<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Jobs;
use Closure;
use Doctrine\DBAL\Query\QueryException;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateStepMutation extends AuthorizeMutation
{
    protected $attributes = [
        'name' => 'createStep',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type("Steps");
    }

    public function args(): array
    {
        return [
            'jobs_id' => [
                'name' => 'jobs_id',
                'type' => Type::nonNull(Type::int()),
                'rules' => [
                    'required',
                    'numeric'
                ],
            ],

            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
                'rules' => [
                    'required',
                    'string'
                ],
            ],

            'status' => [
                'name' => 'status',
                'type' => Type::nonNull(Type::int()),
                'rules' => [
                    'nullable',
                    'in:0,1'
                ],
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $job = Jobs::find($args['jobs_id']);

        if (!$job) {
            throw new QueryException("Geçersiz job id!");
        }

        if ($job->users()->contains(Auth::id())) {
            throw new QueryException("Erişiminiz bulunmuyor!");
        }



        return $job->steps()->create($args);
    }
}
