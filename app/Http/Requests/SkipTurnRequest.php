<?php

namespace App\Http\Requests;

use App\Rules\MustBeUsersTurn;
use App\Rules\MustNotHaveAWinner;
use App\Rules\PoolMustBeEmpty;
use Illuminate\Foundation\Http\FormRequest;

class SkipTurnRequest extends FormRequest
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
            'game' => [
                'required',
                'integer',
                new PoolMustBeEmpty($this->game),
                new MustNotHaveAWinner($this->game),
                new MustBeUsersTurn($this->game, $this->user())
            ]
        ];
    }


    /**
     * data to validate
     *
     * @return void
     */
    public function validationData()
    {
        return array_merge($this->all(), [
            'game' => $this->game
        ]);
    }
}
