<?php

namespace App\Http\Resources;

use TiMacDonald\JsonApi\JsonApiResource;

class UserResource extends JsonApiResource
{
    public array $attributes = [
        'name',
        'email',
    ];
}
