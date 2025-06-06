<?php

namespace App\Http\Requests\Album;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
            'artist_id' => 'required|integer',
            'name'      => 'required|string|max:255',
            'year'      => 'required|date',
            'sales'     => 'required|numeric',
            'image'     => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ];
    }
}
