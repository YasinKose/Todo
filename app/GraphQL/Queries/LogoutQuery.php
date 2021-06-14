<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;

class LogoutQuery extends AuthorizeQueries
{
    protected $attributes = [
        'name' => 'logout',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        Auth::logout();

        return [
            true
        ];
    }
}
