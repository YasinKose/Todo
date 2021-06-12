<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class RegisterType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Register',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of newly registered user',
            ],

            'access_token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Contains token for newly registered user to login',
            ],

        ];
    }
}
