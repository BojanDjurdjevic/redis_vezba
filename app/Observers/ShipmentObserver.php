<?php

namespace App\Observers;

use App\Models\Shipment;
use Illuminate\Support\Facades\Cache;

class ShipmentObserver
{
    private function clearCache(): void
    {
        Cache::forget('unassignedShipments');
    }    

    public function created(Shipment $shipment): void
    {
        //dd("RADI OBSERVER");
        if($shipment->status === Shipment::STATUS_UNASSIGNED) {
            $this->clearCache();
        }
    }

    /**
     * Handle the Shipment "updated" event.
     */
    public function updated(Shipment $shipment): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Shipment "deleted" event.
     */
    public function deleted(Shipment $shipment): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Shipment "restored" event.
     */
    public function restored(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "force deleted" event.
     */
    public function forceDeleted(Shipment $shipment): void
    {
        //
    }

    public function assignUser()
    {
        Cache::forget('unassigned_shipments');
    }
}
