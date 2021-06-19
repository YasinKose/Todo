<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Jobs;
use App\Models\Steps;
use Closure;
use GraphQL\Exception\InvalidArgument;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class DeleteJobMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteJob',
        'description' => 'Delete a job mutation'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'job_id' => [
                'name' => 'job_id',
                'type' => Type::nonNull(Type::int()),
                'rules' => [
                    'required',
                    'numeric'
                ],
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $job = Jobs::find($args['job_id']);

        if (!$job) {
            throw new InvalidArgument("Geçersiz job id!");
        }

        if (!$job->users->contains(Auth::id())) {
            throw new InvalidArgument("Erişiminiz bulunmuyor!");
        }
        $job->users()->sync([]);
        $job->steps()->delete();
        $job->delete();

    }
}
