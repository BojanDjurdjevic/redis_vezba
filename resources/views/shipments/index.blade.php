<x-app-layout title="Shipments">

    <div class="max-w-6xl mx-auto py-8 px-4">

        <h1 class="text-3xl text-white font-bold mb-6">Shipments</h1>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse ($shipments as $shipment)
            <a href="{{ route('shipments.show', $shipment) }}"
                class="block bg-purple-900 text-white shadow-lg rounded-2xl p-6 hover:shadow-2xl hover:-translate-y-1 transition-transform duration-200">
                    {{-- Title --}}
                    <h2 class="text-xl font-semibold mb-2">
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
                        @elseif($shipment->status === 'in_progress') bg-blue-100 text-blue-800
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
                </a>
            @empty
                <p class="text-gray-500">Nema pošiljki.</p>
            @endforelse

        </div>

    </div>

</x-app-layout>
