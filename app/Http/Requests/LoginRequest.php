<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Extension;

class LoginRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$customRecaptcha = Extension::where('act', 'custom-captcha')->where('status', 1)->first();

		$rules = [
			'login' => 'required|string',
			'password' => 'required|string',
		];

		if ($customRecaptcha) {
			$rules['captcha'] = 'required';
		}

		return $rules;
	}
} 