<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Error\AuthorizationError;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'login',
        'description' => 'Log the user in by email',
    ];

    public function type(): Type
    {
        return GraphQL::type("LoginCallback");
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'email'],
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'string'],
            ],
        ];
    }

    public function resolve($root, $args, $context)
    {
        if (!$token = Auth::attempt($args)) {
            throw new AuthorizationError("Giriş Yapılamadı!");
        }

        return [
            'user_id' => Auth::id(),
            'access_token' => $token,
            'token_type' => "Bearer",
            'expires_in' => 60 * 60
        ];
    }
}
