<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LogStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'message' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'message.required' => 'The message is required.',
            'message.string' => 'The message must be a string.',
            'message.max' => 'The message may not be greater than 255 characters.',
        ];
    }

}
