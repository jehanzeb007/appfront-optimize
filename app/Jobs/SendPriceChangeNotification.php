<?php
namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\PriceChangeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPriceChangeNotification implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $product;
    public $oldPrice;
    public $newPrice;
    public $notificationEmail;

    /**
     * Create a new job instance.
     *
     * @param Product $product
     * @param float $oldPrice
     * @param float $newPrice
     * @param string $notificationEmail
     */
    public function __construct(Product $product, $oldPrice, $newPrice, $notificationEmail)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
        $this->notificationEmail = $notificationEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Create the data for the email
        $emailData = [
            'product_name' => $this->product->name,
            'old_price' => $this->oldPrice,
            'new_price' => $this->newPrice,
            'product_url' => route('product.show', ['product' => $this->product->id]),
        ];

        // Send the price change notification email
        Mail::to($this->notificationEmail)->send(new PriceChangeNotification($emailData));
    }
}
