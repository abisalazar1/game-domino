<?php

namespace App\Http\Requests;

use App\Rules\AllPlayersMustExist;
use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
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
            'players' => ['required','array','between:2,4', new AllPlayersMustExist]
        ];
    }
}
