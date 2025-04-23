<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Categoria;

class UpdateCategoriaRequest extends FormRequest
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
    $categoria = $this->route('categoria');
    $id = $categoria instanceof Categoria ? $categoria->id : $categoria;

    $requiredRule = $this->isMethod('put') ? 'required' : 'sometimes|required';

    return [
        'nombre' => "{$requiredRule}|string|max:255|unique:categorias,nombre,{$id}"
    ];
}

public function messages(): array
{
    return [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.string'   => 'El nombre debe ser una cadena de texto.',
        'nombre.max'      => 'El nombre no puede tener más de 255 caracteres.',
        'nombre.unique'   => 'El nombre ya existe en la base de datos.',
    ];
}

}
