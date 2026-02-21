<x-app-layout title="Shipments">

    <div class="max-w-6xl mx-auto py-8 px-4">

        <h1 class="text-3xl text-white font-bold mb-6">Shipments</h1>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse ($shipments as $shipment)
            <div
                class="block bg-purple-900 text-white shadow-lg rounded-2xl p-6 hover:shadow-2xl hover:-translate-y-1 transition-transform duration-200">
                    <a href="{{ route('shipments.show', $shipment) }}"
                        class="text-rose-600 mt-3 mb-3"
                    >Pogledaj pošiljku</a>
                    {{-- Title --}}
                    <h2 class="text-xl font-semibold mb-2 mt-3">
                        {{ $shipment->title }}
                    </h2>

                    {{-- Route --}}
                    <p class="text-white text-sm mb-2">
                        {{ $shipment->from_city }}, {{ $shipment->from_country }}
                        →
                        {{ $shipment->to_city }}, {{ $shipment->to_country }}
                    </p>

                    {{-- Price --}}
                    <p class="text-lg font-bold text-indigo-600 mb-3">
                        {{ number_format($shipment->price, 0, ',', '.') }} RSD
                    </p>

                    {{-- Status --}}
                    <span
                        class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                        @if($shipment->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($shipment->status === 'shipped') bg-blue-100 text-blue-800
                        @elseif($shipment->status === 'delivered') bg-green-100 text-green-800
                        @elseif($shipment->status === 'cancelled') bg-red-100 text-red-800
                        @elseif($shipment->status === 'started') bg-blue-100 text-blue-800
                        @elseif($shipment->status === 'completed') bg-green-100 text-green-800
                        @elseif($shipment->status === 'problem') bg-red-100 text-red-800
                        @elseif($shipment->status === 'unassigned') bg-yellow-100 text-yellow-800
                        @endif
                        "
                    >
                        {{ ucfirst($shipment->status) }}
                    </span>

                    {{-- Details --}}
                    <p class="text-white text-sm mt-4">
                        {{ Str::limit($shipment->details, 100) }}
                    </p>
                    
                    <br />
                    <div>
                        <form action="{{ route('shipments.assignUser', $shipment) }}" method="POST">
                            @csrf
                            <label for="user_id" class="block text-sm font-medium mb-1">Vozač:</label>
                            <select name="user_id" id="user_id" class="w-full border rounded-lg px-4 py-2 
                                    focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                            >
                                @if (!$shipment->user_id)
                                    <option value="" disabled>Izaberi vozača</option>
                                @endif
                                
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id === $shipment->trucker->id ? 'selected' : ''}}
                                        class="text-indigo-600"
                                    >{{ $user->name }}</option>                       
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <button type="submit"
                                class="text-white bg-indigo-600 p-3 mt-3 rounded-lg shadow-md hover:bg-indigo-500 w-full"
                            >Dodeli</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Nema pošiljki.</p>
            @endforelse

        </div>

    </div>

</x-app-layout>
