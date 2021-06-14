<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Steps;
use Closure;
use GraphQL\Exception\InvalidArgument;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;

class DeleteStepMutation extends AuthorizeMutation
{
    protected $attributes = [
        'name' => 'deleteStep',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return Type::boolean();
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
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $step = Steps::find($args['step_id']);

        if (!$step) {
            throw new InvalidArgument("Geçersiz id!");
        }

        if (!$step->jobs->users->contains(Auth::id())) {
            throw new InvalidArgument("Bu görev size ait değil!");
        }

        return $step->delete();
    }
}
