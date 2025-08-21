<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate data from database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Truncating Data');
        try {
            DB::getSchemaBuilder()->disableForeignKeyConstraints();
            DB::table('feedbacks')->truncate();
            DB::table('otps')->truncate();
            DB::table('user_images')->truncate();
            DB::table('user_interest')->truncate();
            DB::table('user_matches')->truncate();
            DB::table('user_occupation')->truncate();
            DB::table('user_pet')->truncate();
            DB::table('block_users')->truncate();
            DB::table('report_users')->truncate();
            DB::table('user_pushnotifications')->truncate();
            DB::table('users')->truncate();
            DB::getSchemaBuilder()->enableForeignKeyConstraints();

            $this->info('Data Truncated Successfully...');
        } catch(\Throwable $e) {
            $this->error('Something went wrong. Data not truncated.');
            $this->line('');
            $this->error("Error: {$e->getMessage()}");
        }
    }
}
