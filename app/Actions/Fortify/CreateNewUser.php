<?php

namespace App\Actions\Fortify;

use App\Entities\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:11', 'min:11', 'unique:users'],
            'password' => $this->passwordRules(),
            //'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'terms' => ['required', 'accepted'],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
    }
}
