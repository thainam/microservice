<?php

namespace App\Domain\Transaction;

use App\Domain\Transaction\Exceptions\TransactionStoreRequestException;
use App\Domain\User\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

/**
 * Classe responsável por validar os requests
 * de novas transações.
 */
class TransactionStoreRequest
{
    public static function rules(): array
    {
        return [
            'payer' => 'required|integer|exists:users,id|different:payee',
            'payee' => 'required|integer|exists:users,id|different:payer',
            'value' => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    public static function messages(): array
    {
        $messages = [
            'payer.required' => 'O usuário pagador deve ser informado.',
            'payer.integer' => 'O usuário pagador deve ser um número inteiro.',
            'payer.exists' => 'Este usuário pagador não existe.',
            'payer.different' => 'O usuário pagador não pode ser o igual ao recebedor.',

            'payee.required' => 'O usuário recebedor deve ser informado.',
            'payee.integer' => 'O usuário recebedor deve ser um número inteiro.',
            'payee.exists' => 'Este usuário recebedor não existe.',
            'payee.different' => 'O usuário recebedor não pode ser o igual ao pagador.',

            'value.required' => 'É necessário informar o valor da transação.',
            'value.numeric' => 'O valor da transação deve ser numérico.',
            'value.gt' => 'O valor da transação deve ser maior que zero.',
            'value.regex' => 'O valor da transação deve estar no formato 0.00 (com no máximo duas casas decimais).',
        ];

        return $messages;
    }

    /**
     * Efetua a validação do request com
     * base nas regras acima.
     *
     * @param Request
     * @throws TransactionStoreRequestException|ValidationException
     * @return void
     */
    public static function validate(Request $request): void
    {
        $validator = Validator::make($request->all(), self::rules(), self::messages());
        if ($validator->fails()) {
            throw new TransactionStoreRequestException($validator->errors(), 400);
        }

        $payer = (UserModel::find($request->input('payer')));
        if ($payer->type == 'J') {
            throw new TransactionStoreRequestException(json_encode(['payer' => ['Lojistas não podem efetuar pagamento.']]), 400);
        }
    }
}
