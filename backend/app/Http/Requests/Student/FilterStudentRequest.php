<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\AbstractRequest;

/**
 * Class FilterStudentRequest
 * @package Api\Service\Requests\Student
 */
class FilterStudentRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }
}
