<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'content' => 'required|min:10|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'tags' => 'min:2',
            'user_id' => 'integer',
            'post_id' => 'integer',
        ];
    }
}
