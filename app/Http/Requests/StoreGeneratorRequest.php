<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneratorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "course_id" => "required",
            "source" => "required",
            "questions" => "required",
            "answer" => "required",
        ];
    }
}
