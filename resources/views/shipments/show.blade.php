<x-app-layout title="Shipment Details">

    <div class="dark:bg-gray-700 text-white max-w-3xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-2xl">

        <h1 class="text-3xl font-bold mb-6 text-center">Detalji pošiljke</h1>

        <div class="space-y-4">

            <div class="flex justify-between bg-gray-800 p-4 rounded-lg">
                <span class="font-semibold">Naslov:</span>
                <span>{{ $shipment->title }}</span>
            </div>

            <div class="flex justify-between bg-gray-800 p-4 rounded-lg">
                <span class="font-semibold">Od:</span>
                <span>{{ $shipment->from_city }}, {{ $shipment->from_country }}</span>
            </div>

            <div class="flex justify-between bg-gray-800 p-4 rounded-lg">
                <span class="font-semibold">Do:</span>
                <span>{{ $shipment->to_city }}, {{ $shipment->to_country }}</span>
            </div>

            <div class="flex justify-between bg-gray-800 p-4 rounded-lg">
                <span class="font-semibold">Cena:</span>
                <span>{{ number_format($shipment->price, 0, ',', '.') }} RSD</span>
            </div>

            <div class="flex justify-between bg-gray-800 p-4 rounded-lg">
                <span class="font-semibold">Status:</span>
                <span class="capitalize">{{ $shipment->status }}</span>
            </div>

            <div class="flex justify-between bg-gray-800 p-4 rounded-lg">
                <span class="font-semibold">Primalac:</span>
                <span class="capitalize {{ $shipment->user->name ?? 'text-red-600' }}">{{ $shipment->user->name ??  'Nije naznačeno'}}</span>
            </div>

            <div class="flex justify-between bg-gray-800 p-4 rounded-lg">
                <span class="font-semibold">Dostavljač:</span>
                <span class="capitalize {{ $shipment->trucker->name ? '' : 'text-red-600' }}">{{ $shipment->trucker->name ?? 'Nije izabran' }}</span>
            </div>

            <div class="bg-gray-800 p-4 rounded-lg">
                <span class="font-semibold">Detalji:</span>
                <p class="mt-2">{{ $shipment->details }}</p>
            </div>

            @forelse ($shipment->documents as $document)
                <div class="bg-gray-800 p-4 rounded-lg">
                    <span class="font-semibold">Dokumenta:</span>
                    <p class="mt-2"><a target="_blank" href="/storage/documents/{{ $document->document_name }}">{{ $document->document_name }}</a></p>
                </div>
            @empty
                <div class="bg-gray-800 p-4 rounded-lg">
                    <p>Nema dokumenata</p>
                </div>
            @endforelse

            <div class="flex justify-evenly mt-6">
                <a href="{{ route('shipments.index') }}"
                   class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-semibold
                          hover:bg-indigo-700 transition duration-200 shadow-md hover:shadow-lg">
                    Nazad na listu
                </a>
                <a href="{{ route('shipments.edit', $shipment) }}"
                   class="bg-rose-600 text-white px-6 py-2 rounded-xl font-semibold
                          hover:bg-rose-500 transition duration-200 shadow-md hover:shadow-lg">
                    Izmeni pošiljku
                </a>
            </div>

        </div>
    </div>

</x-app-layout>
