<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Steps;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class StepsType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Steps',
        'description' => 'Step List',
        'model' => Steps::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Shows the name of ID',
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'Brings the one who added step',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Shows the name of step',
            ],
            'status' => [
                'type' => Type::int(),
                'description' => 'Shows the name of step',
            ],
        ];
    }
}
