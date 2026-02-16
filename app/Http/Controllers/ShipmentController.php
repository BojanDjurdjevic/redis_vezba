<?php

namespace App\Http\Controllers;

use App\Models\Shipments;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentCreateRequest;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('shipments.index', [
            'shipments' => Shipments::all()
        ]);
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
        
        $user_id = auth()->id ?? 1;
        
        Shipments::create([...$request->validated(), 'user_id' => $user_id]);
        return redirect('/shipments');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipments $shipments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipments $shipments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipments $shipments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipments $shipments)
    {
        //
    }
}
