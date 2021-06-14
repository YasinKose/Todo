<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MeType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Me',
        'description' => 'A type',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID of the user',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Name of the user',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'Email of the user',
            ],
            'profilePicture' => [
                'type' => Type::string(),
                'description' => 'Profile Picture of the user',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => "Created At of the user"
            ],


            'jobs' => [
                'type' => Type::listOf(GraphQL::type("Jobs")),
                'description' => "Jobs of the user"
            ]
        ];
    }
}
