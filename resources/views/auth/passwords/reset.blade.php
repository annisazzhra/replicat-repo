<x-guest-layout>
    {{-- Judul Halaman --}}
    <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-6">
        Reset Password
    </h2>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Email Address
            </label>
            <div class="mt-1 relative">
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    {{-- Kelas untuk warna terang input, sesuai gambar baru --}}
                    class="appearance-none block w-full px-3 py-2 pl-10 border @error('email') border-red-300 @else border-gray-300 @enderror rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white border-gray-300 text-gray-900 placeholder-gray-500"
                    placeholder="Masukkan alamat email Anda"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Password
            </label>
            <div class="mt-1 relative">
                <input
                    id="password"
                    name="password"
                    type="password"
                    x-bind:type="showPassword ? 'text' : 'password'"
                    required
                    autocomplete="new-password"
                    {{-- Kelas untuk warna terang input, sesuai gambar baru --}}
                    class="appearance-none block w-full px-3 py-2 pl-10 pr-10 border @error('password') border-red-300 @else border-gray-300 @enderror rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white border-gray-300 text-gray-900 placeholder-gray-500"
                    placeholder="Masukkan password Anda"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                >
                    <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'" class="text-gray-400 hover:text-gray-600"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Confirm Password
            </label>
            <div class="mt-1 relative">
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    {{-- Kelas untuk warna terang input, sesuai gambar baru --}}
                    class="appearance-none block w-full px-3 py-2 pl-10 border @error('password_confirmation') border-red-300 @else border-gray-300 @enderror rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white border-gray-300 text-gray-900 placeholder-gray-500"
                    placeholder="Konfirmasi password Anda"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
            </div>
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Reset Password -->
        <div>
            <button
                type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105"
            >
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <i class="fas fa-redo text-indigo-300 group-hover:text-indigo-200"></i> {{-- Ikon reset --}}
                </span>
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>