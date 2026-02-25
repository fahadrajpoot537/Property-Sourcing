<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GeneratePropertyPostJob implements ShouldQueue
{
    use Queueable;

    protected $property;

    /**
     * Create a new job instance.
     */
    public function __construct(\App\Models\AvailableProperty $property)
    {
        $this->property = $property;
    }

    /**
     * Execute the job.
     */
    public function handle(\App\Services\PropertyImageGeneratorService $generatorService): void
    {
        $generatorService->generateCarousel($this->property);
    }
}
