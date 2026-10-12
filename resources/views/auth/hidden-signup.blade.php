<x-guest-layout>
	<form method="POST" action="{{ route('hidden-signup.store') }}" class="space-y-4">
		@csrf

		<div class="space-y-1">
			<h1 class="text-xl font-semibold text-gray-900">Create the first admin</h1>
			<p class="text-sm text-gray-600">This setup page closes after the first admin account is created.</p>
		</div>

		<div>
			<x-input-label for="first_name" value="First name" />
			<x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" required autofocus autocomplete="given-name" />
			<x-input-error :messages="$errors->get('first_name')" class="mt-2" />
		</div>

		<div>
			<x-input-label for="middle_name" value="Middle name" />
			<x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name')" autocomplete="additional-name" />
			<x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
		</div>

		<div>
			<x-input-label for="last_name" value="Last name" />
			<x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" required autocomplete="family-name" />
			<x-input-error :messages="$errors->get('last_name')" class="mt-2" />
		</div>

		<div>
			<x-input-label for="email" value="Email" />
			<x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="email" />
			<x-input-error :messages="$errors->get('email')" class="mt-2" />
		</div>

		<div>
			<x-input-label for="username" value="Username" />
			<x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required autocomplete="username" />
			<x-input-error :messages="$errors->get('username')" class="mt-2" />
		</div>

		<div>
			<x-input-label for="setup_token" value="Setup key" />
			<x-text-input id="setup_token" name="setup_token" type="password" class="mt-1 block w-full" required autocomplete="off" />
			<x-input-error :messages="$errors->get('setup_token')" class="mt-2" />
		</div>

		<div>
			<x-input-label for="password" value="Password" />
			<x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
			<x-input-error :messages="$errors->get('password')" class="mt-2" />
		</div>

		<div>
			<x-input-label for="password_confirmation" value="Confirm password" />
			<x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
		</div>

		<x-primary-button class="w-full justify-center">Create admin account</x-primary-button>
	</form>
</x-guest-layout>
