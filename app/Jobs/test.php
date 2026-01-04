<?php

/**
 * Test
 *
 * This class represents a queued job.
 *
 * A job is used when we want some work to happen in the background
 * instead of during a normal request or command execution.
 *
 * In our system, this job is a placeholder used to verify that:
 * - the queue system is configured correctly
 * - jobs can be dispatched
 * - jobs are picked up and executed by a queue worker
 *
 * Its purpose is to prove that the queue mechanism itself works.
 */

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class test implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     * This constructor is called when the job is dispatched.
     *
     * At the moment, we do not need to pass any data into the job,
     * so the constructor is intentionally empty.
     */
    public function __construct()
    {
        // No data is required for this test job.
    }

    /**
     * This method is executed by the queue worker.
     * When a worker picks up this job, this method will run.
     *
     * The mere fact that this method is reached means the queue system is functioning.
     */
    public function handle(): void
    {
        // Intentionally left empty.
        // This job only exists to test queue execution.
    }
}
