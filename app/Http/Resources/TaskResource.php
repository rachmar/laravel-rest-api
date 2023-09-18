<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'user' => $this->user,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'deadline_at' => $this->deadline_at,
            'archived' => (bool) $this->archived,
            'archived_at' => $this->archived_at,
            'completed' => (bool) $this->completed,
            'completed_at' => $this->completed_at,
            'tags' => $this->tags,
            'documents' => $this->documents
        ];
    }
}
