<?php

namespace App\Http\Requests;

use App\Traits\LockedDemoUser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    use LockedDemoUser;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:50'],
            'phone' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email',
                Rule::unique('users')->ignore($this->route('user')->id)
            ],
            'password' => ['nullable'],
            'owner' => ['required', 'boolean'],
        ];
    }

}
