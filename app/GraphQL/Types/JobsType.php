<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Jobs;
use GraphQL\Type\Definition\Type;
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
                'description' => 'Id of a particular book',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the book',
            ],
            'deadline_at' => [
                'type' => Type::nonNull(Type::string()),
            ]
        ];
    }
}
