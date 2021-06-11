<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;

class AuthorizeMutation extends Mutation
{
    /*
     * This class was created to provide access control
     */
    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return Auth::check();
    }

    public function type(): Type { }
}
