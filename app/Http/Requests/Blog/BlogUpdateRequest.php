<?php

namespace App\Http\Requests\Blog;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class BlogUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,png|max:10240',
            'new_gallery_images' => 'nullable|array',
            'new_gallery_images.*' => 'image|mimes:jpg,png|max:10240',
            'existing_gallery' => 'nullable|array',
            'deleted_gallery' => 'nullable|string',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        Log::warning('blog update validation failed', [
            'errors' => $validator->errors()->toArray()
        ]);

        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}
