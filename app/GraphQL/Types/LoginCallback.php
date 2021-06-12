<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LoginCallback extends GraphQLType
{
    protected $attributes = [
        'name' => 'LoginCallback',
        'description' => 'A type'
    ];


    public function fields(): array
    {
        return [
            'user_id' => [
                'type' => Type::int(),
                'description' => "The id of the logged in user"
            ],

            'access_token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Shows the name of ID',
            ],
            'token_type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Shows the name of ID',
            ],
            'expires_in' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Shows the name of ID',
            ]
        ];
    }
}
