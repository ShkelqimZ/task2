<?php

use App\Console\Commands\SendOverdueLoanEmails;
use Illuminate\Support\Facades\Artisan;

Artisan::command(SendOverdueLoanEmails::class, function () {
})->purpose('Send overdue loan emails')->dailyAt('10:00');
