<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var File $this */
        return [
            'name'           => $this->name,
            'profiles_count' => $this->profiles_count,
            'imported'       => $this->created_at->toDateTimeString()
        ];
    }
}