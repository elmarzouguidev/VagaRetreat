<?php

namespace App\Console\Commands;

use App\Services\CurrencyConversionService;
use Illuminate\Console\Command;

class RefreshExchangeRates extends Command
{
    
    protected $signature = 'currency:refresh-rates';
    protected $description = 'Refresh all currency exchange rates';

    public function handle(CurrencyConversionService $service): int
    {
        $this->info('Refreshing exchange rates...');

        try {
            $service->refreshRates();
            $this->info('Exchange rates refreshed successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to refresh rates: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
