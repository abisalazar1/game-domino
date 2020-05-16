<?php

namespace App\Http\Requests;

use App\Rules\MustHaveInHand;
use App\Rules\MustBeUsersTurn;
use App\Rules\MustNotHaveAWinner;
use App\Rules\TileMustHaveOneOfTheNumbers;
use Illuminate\Foundation\Http\FormRequest;

class TurnRequest extends FormRequest
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
            'tile_id' => [
                'required',
                'integer',
                new MustNotHaveAWinner($this->game),
                'exists:tiles,id',
                new MustBeUsersTurn($this->game, $this->user()),
                new MustHaveInHand($this->game, $this->user()),
            ],
            'side' => ['required', 'string', 'in:left,right',   new TileMustHaveOneOfTheNumbers($this->game, $this->tile_id)]
        ];
    }
}
