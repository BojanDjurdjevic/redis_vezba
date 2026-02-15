<x-app-layout>
    <div>
        <form method="POST" action="{{ route('product.create') }}">
            @csrf
            @method('POST')
            <label for="name">Naziv</label>
            <input type="text" name="name" id="name" />
            <label for="description">Opis</label>
            <textarea name="description" id="description"></textarea>
            <label for="price">Cena</label>
            <input type="number" name="price" id="price">

            <button type="submit"
            >Pošalji</button>
        </form>
    </div>
</x-app-layout>