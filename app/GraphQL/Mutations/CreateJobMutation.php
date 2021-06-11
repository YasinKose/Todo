<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Jobs;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateJobMutation extends AuthorizeMutation
{
    protected $attributes = [
        'name' => 'createJob',
        'description' => 'Used to add a new job'
    ];

    public function type(): Type
    {
        return GraphQL::type('Jobs');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'deadline_at' => [
                'name' => 'deadline_at',
                'type' => Type::nonNull(Type::string()),
            ],

            'users' => [
                'name' => 'users',
                'type' => Type::listOf(Type::int())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $args['users'][] = Auth::id();
        $args['users'] = array_unique($args['users']);

        $users = [];
        foreach ($args['users'] as $index => $user) {
            if (DB::table("users")->where("id", $user)->first()) {
                $users[] = $user;
            }
        }

        $job = Jobs::create($args);
        $job->users()->attach($users);

        return $job;
    }
}
