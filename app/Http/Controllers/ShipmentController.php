<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentCreateRequest;
use App\Http\Requests\UpdateShipmentRequest;
use App\Models\Shipment;
use App\Models\ShipmentDocuments;
use App\Models\User;
use App\Policies\ShipmentPolicy;
use App\Traits\HandleImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

use function PHPUnit\Framework\matches;

class ShipmentController extends Controller
{

    use HandleImageUpload;

    public function index()
    {
        $users = User::where('role', 'trucker')->get();

        $shipments = Cache::remember('unassignedShipments', 360, 
        fn() => Shipment::unassignedShipments()->get()); // where('status', Shipment::STATUS_UNASSIGNED)->get()
        return view('shipments.index', compact('shipments', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('canViewPage', Shipment::class);
        $users = User::all();
        return view('shipments.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipmentCreateRequest $request)
    {
        /*
        if(Auth::user()->role !== User::ROLE_ADMINISTRATOR) {
            return redirect()->route('login')->with('error', 'Niste autorizovani da kreirate shipment!');
        } */

        Gate::authorize('create', Shipment::class);

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
        Gate::authorize('view', $shipment);
        return view('shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        Gate::authorize('canViewEdit', Shipment::class);
        $users = User::all();
        return view('shipments.edit', compact('shipment', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentRequest $request, Shipment $shipment)
    {
        Gate::authorize('canViewPage', Shipment::class);
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

    public function assignUser(Request $request, Shipment $shipment) : RedirectResponse
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        $shipment->user_id = $request->user_id;
        $shipment->status = Shipment::STATUS_IN_PROGRESS;
        $shipment->save();

        //Cache::forget('unassignedShipments');

        return redirect()->back();
    }
}
