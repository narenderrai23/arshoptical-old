<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use App\Models\GeneralSetting;

class RegisterRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$general = GeneralSetting::first();
		$passwordRule = Password::min(6);
		if ($general && $general->secure_password) {
			$passwordRule = $passwordRule->mixedCase()->numbers()->symbols()->uncompromised();
		}

		$agreeRule = ($general && $general->agree) ? 'required' : 'nullable';

		$countryData = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
		$countryCodes = implode(',', array_keys($countryData));
		$mobileCodes = implode(',', array_column($countryData, 'dial_code'));
		$countries = implode(',', array_column($countryData, 'country'));

		return [
			'firstname' => 'sometimes|required|string|max:50',
			'lastname' => 'sometimes|required|string|max:50',
			'email' => 'required|string|email|max:90|unique:users',
			'mobile' => 'required|string|max:50|unique:users',
			'password' => ['required', 'confirmed', $passwordRule],
			'username' => 'required|alpha_num|unique:users|min:6',
			'captcha' => 'sometimes|required',
			'mobile_code' => 'required|in:' . $mobileCodes,
			'country_code' => 'required|in:' . $countryCodes,
			'country' => 'required|in:' . $countries,
			'agree' => $agreeRule,
		];
	}
} 