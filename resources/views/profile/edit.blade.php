<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="rounded-4xl shadow-lg overflow-hidden w-36">
                        <img src="/storage/images/avatars/{{ \Illuminate\Support\Facades\Auth::user()->avatar }}" alt="Profilna slika">
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                        Postavi sliku
                    </h1>

                    <form method="POST" action="{{ route('profile.changeAvatar') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Image Input --}}
                        <div>
                            <label for="profile_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Izaberi sliku
                            </label>

                            <input 
                                id="profile_image"
                                name="profile_image"
                                type="file"
                                accept="image/*"
                                class="block w-full text-sm text-gray-900 dark:text-gray-300
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100
                                    dark:file:bg-indigo-600 dark:file:text-white
                                    dark:hover:file:bg-indigo-500
                                    border border-gray-300 dark:border-gray-600
                                    rounded-lg cursor-pointer
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500
                                    bg-white dark:bg-gray-700">
                            
                            @error('profile_image')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex items-center gap-4">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5
                                        bg-indigo-600 border border-transparent
                                        rounded-xl font-semibold text-sm text-white
                                        hover:bg-indigo-700
                                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                        dark:focus:ring-offset-gray-800
                                        transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                                Sačuvaj sliku
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
