<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class DownloadProductImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;

        Log::alert($this->product->name);

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::alert($this->product);

        if ($this->product->image_filename) {
            $imageContents = Http::get($this->product->image_filename)->body();
            $randomFilename = Str::random(40) . '.jpg';
            $filePath = 'product_images/' . $randomFilename;



            Storage::disk('public')->put($filePath, $imageContents);

            $this->product->update([
                'image_filename' => $filePath,
            ]);
        }
    }
}
