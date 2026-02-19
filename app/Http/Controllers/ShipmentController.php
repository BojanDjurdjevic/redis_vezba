<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentCreateRequest;
use App\Http\Requests\UpdateShipmentRequest;
use App\Models\Shipment;
use App\Models\ShipmentDocuments;
use App\Models\User;
use App\Traits\HandleImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use function PHPUnit\Framework\matches;

class ShipmentController extends Controller
{

    use HandleImageUpload;

    public function index()
    {
        $shipments = Cache::remember('unassignedShipments', 360, 
        fn() => Shipment::where('status', Shipment::STATUS_UNASSIGNED)->get());
        return view('shipments.index', compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shipments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipmentCreateRequest $request)
    {
        // OSTAVLJAM ovde logiku za user auth i vađenje ID - ako zatreba...
        /*
        if(!Auth::user()) {
            return redirect()->route('login')->with('error', 'Molimo Vas da se ulogujete kako biste kreirali pošiljku!');
        } 
        $user_id = Auth::id(); */
        $shipment = Shipment::create($request->validated()); // uklonio user_id i spread operator [...validated(), user_id]

        $fileTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        foreach($request->file('documents') as $file) {
            if(str_starts_with($file->getMimeType(), 'image/')) {
                $name = $this->uploadImage($file, "documents/$shipment->id");

                $name = $shipment->id . "/" . $name;

                ShipmentDocuments::create([
                    'shipment_id' => $shipment->id,
                    'document_name' => $name
                ]);
            } elseif(in_array($file->getMimeType(), $fileTypes)) {
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid(). "." . $extension;

                $path = $file->storeAs("documents/{$shipment->id}", $filename, 'public');

                $path = str_replace('documents/', "", $path);

                ShipmentDocuments::create([
                    'shipment_id' => $shipment->id,
                    'document_name' => $path
                ]);
            } else {
                return redirect()->back()->with('error', 'Svi fajlovi moraju biti ispravnog i dozvoljenog formata!');
            }
        }    

        Cache::forget('unassignedShipments');

        return redirect()->route('shipments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        return view('shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        $users = User::all();
        return view('shipments.edit', compact('shipment', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentRequest $request, Shipment $shipment)
    {
        $shipment->update($request->validated());

        return redirect()->back()->with('success', 'Uspešno ste izmenili pošiljku!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipments)
    {
        //
    }
}
