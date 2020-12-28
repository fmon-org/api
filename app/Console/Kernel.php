<?php

namespace App\Console;

use App\Console\Commands\ClearLogs;
use App\Console\Commands\Serve;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
	protected $commands = [
		ClearLogs::class,
		Serve::class
	];

	protected function schedule(Schedule $schedule) {
		//
	}
}
