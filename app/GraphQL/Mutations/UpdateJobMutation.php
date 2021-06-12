<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Jobs;
use Closure;
use GraphQL\Exception\InvalidArgument;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateJobMutation extends AuthorizeMutation
{
    protected $attributes = [
        'name' => 'updateJob',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Jobs');
    }

    public function args(): array
    {
        return [
            'job_id' => [
                'name' => 'job_id',
                'type' => Type::nonNull(Type::int())
            ],

            'name' => [
                'name' => 'name',
                'type' => Type::string(),
            ],
            'deadline_at' => [
                'name' => 'deadline_at',
                'type' => Type::string(),
            ],

            'users' => [
                'name' => 'users',
                'type' => Type::listOf(Type::int())
            ]
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

        if (!empty($args['users'])) {
            $mUser = $job->users->pluck("id")->toArray();

            if (!empty($mUser)) {
                $args['users'] = array_merge($args['users'], $mUser);
            }

            $args['users'] = array_unique($args['users']);

            $users = [];
            foreach ($args['users'] as $index => $user) {
                if (DB::table("users")->where("id", $user)->first()) {
                    $users[] = $user;
                }
            }
            unset($args['users']);

            $job->users()->sync($users);
        }

        $job->update($args);

        return $job;
    }
}
