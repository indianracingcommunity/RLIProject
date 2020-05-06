<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RaceResults extends FormRequest
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
            'track' => 'required',
            'track.circuit_id' => 'required',
            'track.season_id' => 'required',
            'track.round' => 'required',
            
            'results' => 'required',
            'results.constructor_id' => 'required',
            'results.driver_id' => 'required'
        ];
    }
}
