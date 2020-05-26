<?php

namespace App\Http\Requests\Api\Groups;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupPutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->group);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|max:64',
            'description' => 'sometimes|required|max:512',
        ];
    }
}
