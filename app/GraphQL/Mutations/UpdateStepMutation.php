<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Steps;
use Closure;
use GraphQL\Exception\InvalidArgument;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateStepMutation extends AuthorizeMutation
{
    protected $attributes = [
        'name' => 'updateStep',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type("Steps");
    }

    public function args(): array
    {
        return [
            'step_id' => [
                'name' => 'step_id',
                'type' => Type::nonNull(Type::int()),
                'rules' => [
                    'required',
                    'numeric'
                ],
            ],

            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
                'rules' => [
                    'required',
                    'string'
                ],
            ],

            'status' => [
                'name' => 'status',
                'type' => Type::nonNull(Type::int()),
                'rules' => [
                    'nullable',
                    'in:0,1'
                ],
            ],
        ];
    }

    /**
     * TODO
     * @param $root
     * @param $args
     * @param $context
     * @param ResolveInfo $resolveInfo
     * @param Closure $getSelectFields
     * @return Steps
     */
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): Steps
    {
        $step = Steps::find($args['step_id']);

        if (!$step) {
            throw new InvalidArgument("Geçersiz step id!");
        }

        if (!$step->jobs->users->contains(Auth::id())) {
            throw new InvalidArgument("Erişiminiz bulunmuyor!");
        }

        $step->update($args);
        return $step;
    }
}
