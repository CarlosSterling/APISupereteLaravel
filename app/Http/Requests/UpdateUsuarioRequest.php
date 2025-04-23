<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('usuario'); // o $this->route('id'), según tu ruta

        return [
            'username'   => "sometimes|alpha_dash|unique:usuarios,username,{$id}|max:255",
            'password'   => 'sometimes|string|min:8|max:255',
            'first_name' => 'sometimes|alpha_space|max:255',
            'last_name'  => 'sometimes|alpha_space|max:255',
            'email'      => "sometimes|email|max:255|unique:usuarios,email,{$id}|max:255",
            'rol'        => 'sometimes|in:administrador,usuario',
        ];
    }

    public function messages(): array
    {
        return [
            'username.alpha_dash'   => 'El username solo puede contener letras, números, guiones bajos y medios.',
            'first_name.alpha_space'=> 'El nombre solo puede contener letras y espacios.',
            'last_name.alpha_space' => 'El apellido solo puede contener letras y espacios.',
            'rol.in'                => 'El rol debe ser administrador o usuario.',
        ];
    }

}
