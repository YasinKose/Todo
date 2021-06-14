<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ProfileMutation extends AuthorizeMutation
{
    protected $attributes = [
        'name' => 'profile',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type("Profile");
    }

    public function args(): array
    {
        $user = Auth::user();

        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
                'rules' => [
                    'required'
                ],
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => [
                    'required',
                    'email',
                    'unique:users,id,' . Auth::id()
                ],
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => [
                    'nullable',
                    'min:10',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#\?&]/',
                ],
            ],
            'current_password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => [
                    'required',
                    'min:10',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#\?&]/',
                ],
            ],
            'profilePicture' => [
                'name' => 'profilePicture',
                'type' => GraphQL::type('Upload'),
                'rules' => ['nullable', 'image', 'max:15360'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $args = array_filter($args);

        if (isset($args['profilePicture'])) {
            $args['profilePicture']->store("public/profile-photos");
            $args['profilePicture'] = asset("storage/profile-photos/" . $args['profilePicture']->hashName());
        }

        $user = Auth::user();
        $user->fill($args)->update();

        return $user;
    }
}
