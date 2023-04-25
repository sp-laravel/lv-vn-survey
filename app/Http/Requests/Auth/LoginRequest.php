<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest {

  protected $inputType;

  public function authorize(): bool {
    return true;
  }

  public function rules(): array {
    return [
      // 'email' => ['required_without:name', 'string', 'email', 'exists:users,email'],
      // 'email' => ['required_without:name', 'string', 'exists:users'],
      'name' => ['required_without:email', 'string', 'exists:users,name'],
      'password' => ['required', 'string'],
      'g-recaptcha-response' => 'required',
      // 'g-recaptcha-response' => 'required|captcha',
    ];
  }

  public function messages(): array {
    return [
      'name.required_without' => 'El campo usuario es obligatorio.',
      'name.exists' => 'El campo usuario no existe.',
      // 'email.required' => 'Email is required',
      // 'email.email' => 'Email is invalid',
      // 'password.required' => 'Password is required',
      // 'password.min:6' => 'Password must be at least 6 characters',
    ];
  }

  public function authenticate(): void {
    $this->ensureIsNotRateLimited();

    if (!Auth::attempt($this->only($this->inputType, 'password'), $this->boolean('remember'))) {
      RateLimiter::hit($this->throttleKey());

      throw ValidationException::withMessages([
        $this->inputType => trans('auth.failed'),
      ]);
    }

    RateLimiter::clear($this->throttleKey());
  }

  public function ensureIsNotRateLimited(): void {
    if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
      return;
    }

    event(new Lockout($this));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
      'email' => trans('auth.throttle', [
        'seconds' => $seconds,
        'minutes' => ceil($seconds / 60),
      ]),
    ]);
  }

  public function throttleKey(): string {
    return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
  }

  protected function prepareForValidation() {
    $this->inputType = filter_var($this->input(key: 'input_type'), filter: FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    $this->merge([$this->inputType => $this->input(key: 'input_type')]);
  }
}