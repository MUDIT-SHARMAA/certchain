<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\BlockchainService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Validate blockchain chain integrity daily
Artisan::command('certchain:validate', function (BlockchainService $blockchain) {
    $result = $blockchain->validateChain();
    if ($result['valid']) {
        $this->info("✅ Blockchain chain valid. {$result['total_blocks']} blocks intact.");
    } else {
        $this->error("🚨 Chain compromised! " . count($result['errors']) . " error(s) found.");
        foreach ($result['errors'] as $err) {
            $this->line("  - " . $err);
        }
    }
})->purpose('Validate the blockchain chain integrity');

Schedule::command('certchain:validate')->daily();
