<?php

namespace App\Http\Requests\Blog;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class BlogStoreRequest extends FormRequest
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
            'title' => 'required|string',
            'content' => 'required|string',
            'featured_image' => 'required|mimes:png,jpg|image|max:10240',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:png,jpg|max:10240'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        Log::warning('blog store validation failed', [
            'errors' => $validator->errors()->toArray()
        ]);

        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}
