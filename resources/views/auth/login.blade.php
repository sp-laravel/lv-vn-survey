<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />
  {{-- <div class="my-3">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div> --}}

  @php
    $routeTutor = route('login');
    $routeAlumn = route('alumno.login');
  @endphp

  <form method="POST" action="{{ $routeTutor }}">
    @csrf

    <!-- Email Address -->
    {{-- <div>
      <x-input-label for="email" :value="__('Usuario')" />
      <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" autofocus
        autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div> --}}
    <div>
      <x-input-label for="input_type" :value="__('Usuario')" />
      <x-text-input id="input_type" class="block w-full mt-1" type="text" name="input_type" :value="old('input_type')" autofocus
        autocomplete="name" />
      {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <small class="text-red-700">
            {{ session('success') }}
          </small>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-input-label for="password" :value="__('Password')" />

      <x-text-input id="password" class="block w-full mt-1" type="password" name="password" :value="old('password')"
        autocomplete="current-password" />

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    {{-- <div class="mt-4 form-group" style="width: 100%;">
      {!! NoCaptcha::renderJs('es', false, 'recaptchaCallback') !!}
      {!! NoCaptcha::display() !!}
      <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
    </div> --}}

    <!-- Remember Me -->
    <div class="flex justify-between gap-3 mt-4">
      <div class="">
        <label for="remember_me" class="inline-flex items-center">
          <input id="remember_me" type="checkbox"
            class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500" name="remember">
          <span class="ml-2 text-sm text-gray-600">Recordarme</span>
        </label>
      </div>
      {{-- <div class="">
        <label for="tutor" class="inline-flex items-center">
          <input id="tutor" type="checkbox"
            class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500" name="tutor">
          <span class="ml-2 text-sm text-gray-600">Tutor</span>
        </label>
      </div> --}}
    </div>

    <div class="flex items-center justify-end mt-4">

      <x-primary-button class="text-center">
        {{ __('Log in') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
