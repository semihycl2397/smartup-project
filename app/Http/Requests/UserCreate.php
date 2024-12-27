<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserCreate extends FormRequest
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
            'company_name' => 'required',
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string',
        ];
    }

    public function messages(): array {
        return [
            'company_name.required' => 'Şirket adı girilmelidir!',
            'name.required' => "İsim girilmelidir!",
            'surname.required' => 'Soyisim  girilmelidir!',
            'email.required' => 'Email Alanı girilmelidir!',
            'email.email' => 'Geçerli bir email giriniz.',
            'email.unique' => 'Bu email adresi kullanılmış.',
            'phone.required' => 'Telefon Alanı Zorunludur!',
            'password.required' => 'Parola zorunludur!',
            'password.min' => 'Parola en az 8 karakter olmalıdır.',
            'phone.unique' => 'Bu telefon numarası kullanılmış.',


        ];
    }
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
