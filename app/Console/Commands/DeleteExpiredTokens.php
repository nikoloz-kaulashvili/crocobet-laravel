<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserToken;

class DeleteExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired access tokens from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = UserToken::where('expires_at', '<', now())->delete();

        $this->info("$token expired tokens deleted successfully.");
    }
}
