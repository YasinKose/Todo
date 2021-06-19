<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Jobs;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class JobsType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Jobs',
        'description' => 'Jobs List',
        'model' => Jobs::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Brings the id of the job',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Brings the name of the job',
            ],
            'deadline_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Returns the scheduled finish date of the job'
            ],

            'steps_count' => [
                'type' => Type::int(),
                'description' => 'Returns the count of steps in the job'
            ],

            'steps' => [
                'type' => Type::listOf(GraphQL::type("Steps")),
                'description' => 'Gets the list of steps in the job'
            ],

            'users' => [
                'type' => Type::listOf(GraphQL::type("User")),
                'description' => 'Gets the list of users in the job'
            ]
        ];
    }
}
