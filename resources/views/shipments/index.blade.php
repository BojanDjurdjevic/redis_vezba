<x-app-layout title="Shipments">
    @foreach ($shipments as $shipment)
        <div>
            <h1>{{ $shipment->title }}</h1>
            <h1>{{ $shipment->price }}</h1>
        </div>
    @endforeach
    
</x-app-layout>