<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLogs extends Command {
	protected $signature = "clear:logs";
	protected $description = 'Clear all logs';

	public function handle() {
		exec('rm ' . storage_path('logs/*.log'));

		$this->info('Logs have been cleared!');
	}
}
