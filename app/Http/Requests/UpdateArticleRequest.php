<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "url_name"      => "required|between:3,255|unique:articles,title," . $this->route('article'),
            "title"         => "required|between:3,255|unique:articles,title," . $this->route('article'),
            "content"       => "required",
            "cover"         => "url|required",
            "display_order" => "integer|required|max:999",
            "source"        => Rule::in([1, 2]),
            "categories"    => "array|present",
            "tags"          => "array|present",
        ];
    }
}
