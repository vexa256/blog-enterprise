<?php

namespace App\Installer\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Input;
use Lang;

class DatabaseRequest extends FormRequest
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
            'connection' => 'string',
            'host' => 'required',
            'port' => 'string',
            'database' => 'required',
            'username' => 'required',
            'password' => 'nullable',
            'prefix' => 'nullable',
        ];
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'host' => Lang::get('installer.database.host'),
            'database' => Lang::get('installer.database.database'),
            'username' => Lang::get('installer.database.username'),
        ];
    }
}
