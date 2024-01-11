<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|regex:/^[6789]\d{9}$/|unique:users,phone',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name.',
            'email.required' => 'Please enter email.',
            'phone.required' => 'Please enter phone number.',
            'country.required' => 'Please select country.',
            'state.required' => 'Please select state.',
            'city.required' => 'Please select city.',

            'email.unique' => 'This email is already taken please try again with another.',
            'phone.unique' => 'This phone number is already taken please try again with another.',
            'phone.regex' => 'Please enter a valid phone number.',
        ];
    }
}
