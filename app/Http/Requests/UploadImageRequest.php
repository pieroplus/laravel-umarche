<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UploadImageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        $rules = [
            'image' => ['image','mimes:jpg,jpeg,png','max:2048'],
            'files.*.image' => ['image','mimes:jpg,jpeg,png','max:2048'],
        ];

        if(Route::currentRouteName() === 'owner.images.store'){
            $rules = array_merge($rules,[
                'files' => 'required',
            ]);
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'image' => '指定されたファイルが画像ではありません。',
            'mines' => '指定された拡張子（jpg/jpeg/png）ではありません。',
            'max' => 'ファイルサイズは2MB以内にしてください。', 
        ];
    }
}
