<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

    /**
     * @OA\Schema(
     *    schema="TypeSchema",
     *        @OA\Property(
     *            property="id",
     *            description="id",
     *            type="integer",
     *            nullable="false",
     *            example="1"
     *        ),
     *        @OA\Property(
     *            property="name",
     *            description="name",
     *            type="string",
     *            nullable="false",
     *            example="string"
     *        ),
     *    )
     * )
     */
class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
