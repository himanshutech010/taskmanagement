<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        
            return [
                'old_password' => 'required|current_password:admin|different:password',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ];
    
    }
    public function messages(){
        return [
            'old_password.current_password' => 'The current password field is incorrect.',
        ];
    }
}
