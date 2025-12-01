<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class ThrowJsonException extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exception:throw';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Throws a hardcoded JSON exception';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jsonPath = resource_path('package_not_found.json');
        $json = file_get_contents($jsonPath);
        $exceptionData = json_decode($json, true); // true → PHP array
        throw new \App\Exception\FullJsonException($exceptionData);
        //
    }
}
