<?php

namespace App\Jobs;

use App\Models\Pizza;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
    {
        // Retrieve the pizza order
        $pizza = Pizza::find($this->orderId);

        // Check if the order is still in 'waiting' status
        if ($pizza && $pizza->status === 'waiting') {
            // Cancel the order
            $pizza->update(['status' => 'canceled']);
        }
    }
}
