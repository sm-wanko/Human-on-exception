<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment('Human-on-Exception');
})->purpose('Display the sample application name');
