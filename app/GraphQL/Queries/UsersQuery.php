<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;

class UsersQuery extends AuthorizeQueries
{
    protected $attributes = [
        'name' => 'users',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type("User"));
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();

        return User::query()
            ->select($fields->getSelect())
            ->get();

    }
}
