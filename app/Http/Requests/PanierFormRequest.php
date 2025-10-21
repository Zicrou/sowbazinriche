<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PanierFormRequest extends FormRequest
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
            // 'quantite' => ['required', 'integer'], 
            'produit_id'  => ['exists:produits,id', 'required'],
            'user_id' => ['exists:users,id', 'required'],
            // 'couleur' => ['string', 'nullable'],
        ];
    }
}
