<x-guest-layout>
    {{-- Judul "Lupa Kata Sandi?" --}}
    <h2 class="text-center text-3xl font-bold text-gray-900 mb-6">
        Lupa Kata Sandi?
    </h2>

    {{-- Deskripsi --}}
    <p class="mb-6 block text-sm font-medium text-gray-700">
        Tidak masalah. Cukup beritahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi yang memungkinkan Anda memilih yang baru.
    </p>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md dark:bg-text-gray-900 dark:border-green-700">
            <p class="text-sm  text-gray-900">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        {{-- Input Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-900">
                Alamat Email
            </label>
            <div class="mt-1 relative">
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    class="appearance-none block w-full px-3 py-2 pl-10 border @error('email') border-red-300 @else border-gray-300 @enderror rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
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

        {{-- Tombol Kirim --}}
        <div>
            <button
                type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105"
            >
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <i class="fas fa-paper-plane text-indigo-300 group-hover:text-indigo-200"></i>
                </span>
                {{ __('Kirim Tautan Reset Kata Sandi') }}
            </button>
        </div>

        {{-- Link Kembali ke Login --}}
        <div class="mt-6 text-center">
            <a
                href="{{ route('login') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200 dark:text-gray-400 dark:hover:text-gray-200"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke halaman Login
            </a>
        </div>
    </form>
</x-guest-layout>