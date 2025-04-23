<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('usuario');

        return [
            'username'   => 'required|alpha_dash|unique:usuarios,username|max:255',
            'password'   => 'required|string|min:8|max:255',
            'first_name' => 'required|alpha_space|max:255',
            'last_name'  => 'required|alpha_space|max:255',
            'email'      => 'required|email|max:255|unique:usuarios,email',
            'rol'        => 'required|in:administrador,usuario',
        ];
    }

    public function messages(): array
    {
        return [
            'username.alpha_dash'   => 'El username solo puede contener letras, números, guiones bajos y medios.',
            'first_name.alpha_space' => 'El nombre solo puede contener letras y espacios.',
            'last_name.alpha_space' => 'El apellido solo puede contener letras y espacios.',
            'rol.in'                => 'El rol debe ser administrador o usuario.',
        ];
    }
}
