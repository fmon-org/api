<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Serve extends Command {
	protected $signature = "serve";
	protected $description = 'Start the application';

	public function handle() {
		$command = exec('php -S localhost:8000 -t public');

		$this->info($command);
	}
}
