<x-app-layout title="Create Shipment">

    <div class="max-w-3xl mx-auto">

        <div class="dark:bg-gray-800 text-white shadow-lg rounded-2xl p-8">

            <h1 class="text-2xl font-bold mb-6">Kreiraj pošiljku</h1>

            <form action="{{ route('shipments.store') }}" enctype="multipart/form-data" method="POST" class="space-y-6">
                @csrf
                {{-- TITLE --}}
                <div>
                    <label for="title" class="block text-sm font-medium mb-1">Naslov</label>
                    <input type="text" name="title" id="title"
                        value="{{ old('title') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- FROM --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Iz države</label>
                        <input type="text" name="from_country"
                            value="{{ old('from_country') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('from_country')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Iz grada</label>
                        <input type="text" name="from_city"
                            value="{{ old('from_city') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('from_city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- TO --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">U državu</label>
                        <input type="text" name="to_country"
                            value="{{ old('to_country') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('to_country')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">U grad</label>
                        <input type="text" name="to_city"
                            value="{{ old('to_city') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('to_city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- PRICE --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Cena (RSD)</label>
                    <input type="number" name="price" min="0"
                        value="{{ old('price') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- IMAGES --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Dokumenta</label>
                    <input type="file" name="documents[]" multiple required
                        class="block w-full text-sm text-gray-900 dark:text-gray-300
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100
                                    dark:file:bg-purple-600 dark:file:text-white
                                    dark:hover:file:bg-purple-500
                                    border border-gray-300 dark:border-gray-600
                                    rounded-lg cursor-pointer
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500
                                    bg-white dark:bg-gray-700"
                        >
                    @error('documents')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <label for="status" class="block text-sm font-medium mb-1">Status:</label>
                <select type="hidden" name="status" id="status" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" >
                    <!--
                    <option value="in_progress">In progress</option>
                    <option value="unassigned">Unassigned</option>
                    <option value="problem">Problem</option>
                    <option value="completed">Completed</option>
                    -->
                    @foreach (\App\Models\Shipment::ALLOWED_STATUSES as $status)
                         <option value="{{ $status }}">{{ strtoupper($status) }}</option>                       
                    @endforeach
                </select>

                {{-- DETAILS --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Detalji</label>
                    <textarea name="details" rows="4"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('details') }}</textarea>
                    @error('details')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SUBMIT --}}
                <div>
                    <button type="submit"
                        class="w-full bg-purple-700 text-white py-3 rounded-xl font-semibold
                               hover:bg-purple-900 transition duration-200 shadow-md hover:shadow-lg">
                        Sačuvaj pošiljku
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
