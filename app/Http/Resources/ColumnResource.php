<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TypeResource;

    /**
     * @OA\Schema(
     *    schema="ColumnSchema",
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
     *        @OA\Property(
     *            property="type_id",
     *            description="Type id",
     *            type="integer",
     *            nullable="false",
     *            example="1"
     *        ),
     *    )
     * )
     */
class ColumnResource extends JsonResource
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
            'type_id' => $this->type_id,
        ];
    }
}
