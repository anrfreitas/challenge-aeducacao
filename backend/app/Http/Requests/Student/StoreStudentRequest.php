<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\AbstractRequest;

/**
 * Class StoreStudentRequest
 * @package Api\Service\Requests\Student
 */
class StoreStudentRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'cpf' => 'required|string|regex:/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/',
        ];
    }
}
