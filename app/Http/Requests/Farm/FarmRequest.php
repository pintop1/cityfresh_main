<?php

namespace App\Http\Requests\Farm;

use Shamaseen\Repository\Generator\Utility\Request;

/**
 * Class FarmRequest
 * @package App\Http\Requests\Farm
 */
class FarmRequest extends Request
{
    protected $rules = [];

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
                $this->rules = [
                    
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $this->rules = [];
                break;
            default:
                break;
        }

        return $this->rules;
    }
}
