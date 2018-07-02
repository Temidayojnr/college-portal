<?php

namespace App\Http\Requests;

use App\Models\ImageType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        $type = ImageType::findOrFail($this->input('image_type_id'));
        $owner = $type->owner($this->owner_id)->first();

        return $user->can('view', $type) && $user->can('update', $owner);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner_id' => 'required|numeric',
            'image_type_id' => 'required|numeric|exists:image_types,id',
            'location' => 'string',
            'file' => 'image'
        ];
    }
}
