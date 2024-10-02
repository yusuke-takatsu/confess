<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'search_word' => ['nullable', 'string'],
            'category_id' => ['nullable', 'integer'],
            'sort_by' => ['required_with:sort_type', 'string'],
            'sort_type' => ['required_with:sort_by', 'string']
        ];
    }

    public function attributes()
    {
        return [
            'search_word' => '検索ワード',
            'category_id' => '検索カテゴリ',
            'sort_by' => '並び替え項目',
            'sort_type' => '並び替え順',
        ];
    }
}
