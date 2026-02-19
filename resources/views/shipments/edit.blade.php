<x-app-layout title="Edit Shipment">

    <div class="max-w-3xl mx-auto">

        <div class="dark:bg-gray-800 text-white shadow-lg rounded-2xl p-8 mt-6">

            <a href="{{ route('shipments.show', $shipment) }}"
                class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-semibold
                    hover:bg-indigo-700 transition duration-200 shadow-md hover:shadow-lg">
                Odustani
            </a>

            <h1 class="text-2xl font-bold m-6">Ažuriraj pošiljku</h1>

            @error($errors->any())
                <p class="text-red-500 text-sm mt-1">{{ $errors->first() }}</p>
            @enderror

            <form action="{{ route('shipments.update', $shipment) }}" enctype="multipart/form-data" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                {{-- TITLE --}}
                <div>
                    <label for="title" class="block text-sm font-medium mb-1">Naslov</label>
                    <input type="text" name="title" id="title"
                        value="{{ $shipment->title ?? '' }}"
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
                            value="{{ $shipment->from_country ?? '' }}"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('from_country')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Iz grada</label>
                        <input type="text" name="from_city"
                            value="{{ $shipment->from_city ?? '' }}"
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
                            value="{{ $shipment->to_country ?? '' }}"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('to_country')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">U grad</label>
                        <input type="text" name="to_city"
                            value="{{ $shipment->to_city ?? '' }}"
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
                        value="{{ $shipment->price ?? '' }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- IMAGES --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Dokumenta</label>
                    <input type="file" name="documents[]" multiple
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
                <select name="status" id="status" class="w-full border rounded-lg px-4 py-2 
                        focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                >
                    <!--
                    <option value="in_progress">In progress</option>
                    <option value="unassigned">Unassigned</option>
                    <option value="problem">Problem</option>
                    <option value="completed">Completed</option>
                    -->
                    @foreach (\App\Models\Shipment::ALLOWED_STATUSES as $status)
                         <option value="{{ $status }}"
                            {{ $shipment->status === $status ? 'selected' : '' }}
                            class="{{ $status === 'problem' ? 'text-red-600' : 'text-purple-500' }}"
                         >{{ strtoupper($status) }}</option>                       
                    @endforeach
                </select>

                {{-- DETAILS --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Detalji</label>
                    <textarea name="details" rows="4"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >{{ $shipment->details ?? '' }}</textarea>
                    @error('details')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TRUCKER --}}
                <div>
                    <label for="user_id" class="block text-sm font-medium mb-1">Vozač:</label>
                    <select name="user_id" id="user_id" class="w-full border rounded-lg px-4 py-2 
                            focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                    >
                        <option value="{{ $shipment->user_id ?? '' }}">Izaberi vozača</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                class="text-indigo-600"
                            >{{ $user->name }}</option>                       
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- CLIENT --}}
                <div>
                    <label for="client_id" class="block text-sm font-medium mb-1">Vozač:</label>
                    <select name="client_id" id="client_id" class="w-full border rounded-lg px-4 py-2 
                            focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                    >
                        <option value="{{ $shipment->client_id ?? '' }}" selected>Promeni klijenta</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                class="text-indigo-600"
                            >{{ $user->name }}</option>                       
                        @endforeach
                    </select>
                    @error('client_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SUBMIT --}}
                <div>
                    <button type="submit"
                        class="w-full bg-purple-700 text-white py-3 rounded-xl font-semibold
                               hover:bg-purple-900 transition duration-200 shadow-md hover:shadow-lg">
                        Izmeni pošiljku
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
