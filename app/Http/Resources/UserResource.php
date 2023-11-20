<?php



namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "name" => $this->name,
            "type" => "customer",
            "email" => $this->email,
            "avatar" => asset('storage/'.$this->avatar),
            "avatar_original" => "",
            "address" => null,
            "city" => null,
            "country" => null,
            "postal_code" => null,
            "phone" => $this->phone,
            "fcm_token" => $this->fcm_token

        ];
    }
}
