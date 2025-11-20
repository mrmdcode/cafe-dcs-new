<?php

namespace App\Events;

use App\Models\Printer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class order_registration implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $orders  ,$company,$printer; // if active printer option in company

    public function __construct($company,$orders,$printer)
    {
        $this->orders = $orders;
        $this->company = $company;
        $this->printer = $printer;
//        Log::warning('event',[$company,$orders,$printer]);
    }

    public function broadcastOn()
    {
        return new Channel('order');
    }

    public function broadcastAs()
    {
        return $this->company;
    }

    public function broadcastWith()
    {
        return [
            'orders' => $this->orders,
            'printer' => $this->printer,
        ];
    }
}
