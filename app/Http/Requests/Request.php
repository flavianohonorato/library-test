<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

abstract class Request extends FormRequest
{
    protected $errorMessage;

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
     * Handle a failed validation attempt.
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        $message = $this->errorMessage ?? 'Erro na validação de dados.';

        $message .= ' -> ' . $this->firstErrorMessage($errors);

        throw new HttpResponseException(response()->json([
            'meta' => [
                'message' => $message
            ],
            'errors' => $errors,
            'code' => JsonResponse::HTTP_BAD_REQUEST
        ], JsonResponse::HTTP_BAD_REQUEST));
    }

    protected function firstErrorMessage(array $errors = [])
    {
        $firstError = current($errors);

        if (\is_array($firstError)) {
            return $this->firstErrorMessage($firstError);
        }

        return $firstError;
    }
}
