<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;

class MeQuery extends AuthorizeQueries
{
    protected $attributes = [
        'name' => 'me',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return GraphQL::type("Me");
    }

    public function resolve()
    {
        return Auth::user();
    }
}
