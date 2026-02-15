<x-app-layout>
    @foreach ($products as $p)
        <div>
            <p>Naziv: {{ $p->name }}</p>
            <p>Opis: {{ $p->description }}</p>
            <p>Cena: {{ $p->price }}</p>
        </div>
    @endforeach
</x-app-layout>