<?php

namespace App\Http\Requests\User;

use Shamaseen\Repository\Generator\Utility\Request;

/**
 * Class UserRequest
 * @package App\Http\Requests\User
 */
class UserRequest extends Request
{
    protected $rules = [

    ];

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
        parent::rules();
        $method = $this->method();
        if (null !== $this->get('_method', null)) {
            $method = $this->get('_method');
        }
        $this->offsetUnset('_method');
        switch ($method) {
            case 'DELETE':
            case 'GET':
                    $this->rules = [];
                break;

            case 'POST':

                break;
            // in case of edit
            case 'PUT':
            case 'PATCH':

                break;
            default:
                break;
        }

        return $this->rules;
    }
}
