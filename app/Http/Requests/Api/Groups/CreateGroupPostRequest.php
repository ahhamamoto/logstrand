<?php

namespace App\Http\Requests\Api\Groups;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;

class CreateGroupPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Group::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:64',
            'description' => 'required|max:512',
        ];
    }
}
