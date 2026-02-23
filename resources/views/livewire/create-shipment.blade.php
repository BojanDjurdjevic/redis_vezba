<?php

use Livewire\Component;
use App\Services\ShipmentService;
use App\Http\Requests\ShipmentCreateRequest;

new class extends Component
{
    use Livewire\WithFileUploads;


    public string $title;
    public string $from_country;
    public string $from_city;
    public string $to_country;
    public string $to_city;
    public string $details;
    public array $statuses = [];
    public string $status;
    public int $price;

    public $clients;
    public int $client_id;

    public string $clientError;

    public array $documents;

    public function validateUser()
    {
        /*
        $user = App\Models\User::firstWhere('id', $this->client_id);

        $this->clientError = $user ? '' : "Ovaj korisnik ne postoji"; */

        $this->validate([
            'client_id' => 'required|integer|exists:users,id'
        ]);
    }

    public function mount()
    {
        $this->statuses = App\Models\Shipment::ALLOWED_STATUSES;
        $this->clients = App\Models\User::where('role', 'client')->get();
    }

    public function submit(ShipmentService $service)
    {
        $request = new ShipmentCreateRequest();

        $data = $this->validate($request->rules());

        //dd($data);

        $service->store($data);

        return redirect()->route('shipments.index')->with('success', 'Uspešno ste kreirali pošiljku!');
    }
};
?>

<div>
    <div class="max-w-3xl mx-auto">

    <div class="dark:bg-gray-800 text-white shadow-lg rounded-2xl p-8">
    <form action="" wire:submit="submit">

        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach

        {{-- TITLE --}}
                <div>
                    <label for="title" class="block text-sm font-medium mb-1">Naslov</label>
                    <input type="text" id="title"
                        wire:model.live="title"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                    <p>{{ $title }}</p>
                </div>

                {{-- FROM --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Iz države</label>
                        <input type="text" wire:model="from_country"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Iz grada</label>
                        <input type="text" wire:model="from_city"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>

                {{-- TO --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">U državu</label>
                        <input type="text" wire:model="to_country"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">U grad</label>
                        <input type="text" wire:model="to_city"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>

                {{-- PRICE --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Cena (RSD)</label>
                    <input type="number" wire:model="price" min="0"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                {{-- IMAGES --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Dokumenta</label>
                    <input type="file" wire:model="documents" multiple required
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
                </div>
                {{-- STATUS --}}
                <label for="status" class="block text-sm font-medium mb-1">Status:</label>
                <select wire:model="status" id="status" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" >
                    @foreach ($statuses as $s)
                        <option class="text-indigo-600" {{ $s == 'unassigned' ? 'selected' : '' }} value="{{ $s }}">{{ $s }}</option>                       
                    @endforeach                
                </select>

                {{-- DETAILS --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Detalji</label>
                    <textarea wire:model="details" rows="4"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                </div>

                {{-- CLIENT --}}
                <div>
                    @error('client_id')
                        <p>{{ $message }}</p>
                    @enderror
                    <p class="text-red-600">{{ $clientError }}</p>
                    <label for="client_id" class="block text-sm font-medium mb-1">Klijent:</label>
                    <select name="client_id" id="client_id" class="w-full border rounded-lg px-4 py-2 
                            focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                            wire:model.live="client_id" 
                            wire:blur="validateUser"
                    >
                        <option value="0" selected >Izaberi klijenta</option>
                        @foreach ($this->clients as $client)
                            <option value="{{ $client->id }}"
                                class="text-indigo-700"    
                            >{{ $client->name }}</option>
                        @endforeach
                    </select>
                    
                </div>

                {{-- SUBMIT --}}
                <div>
                    <button 
                        class="w-full bg-purple-700 text-white py-3 rounded-xl font-semibold
                               hover:bg-purple-900 transition duration-200 shadow-md hover:shadow-lg">
                        Sačuvaj pošiljku
                    </button>
                </div>
    </form>
    </div>
    </div>
</div>