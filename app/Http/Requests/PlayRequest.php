<?php

namespace App\Http\Requests;

use App\Helpers\CardHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class PlayRequest extends FormRequest
{

    private string $invalidCards = '';
    private array $cards = [];


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'distinct' => 'sometimes|boolean',
            'cards' => ['bail', 'required', 'array',
                function ($attribute, $cards, $fail) {
                    foreach ($cards as $card) {
                        if ($card == "" || !in_array($card, CardHelper::VALID_CARDS) ) {
                            $this->invalidCards .= " $card";
                            $fail("Input contains following invalid cards: [$this->invalidCards], please provide valid cards only");
                        }
                        else if($this->get('distinct')) {
                            if (in_array($card, $this->cards)) {
                                $fail("Input contains Duplicate cards, please uncheck distinct cards checkbox if you want to play with repeat cards");
                            }
                        }
                        $this->cards[] = $card;
                    }
                }],
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     * @throws ValidationException
     */
    protected function formatErrors(Validator $validator): void
    {
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

}
