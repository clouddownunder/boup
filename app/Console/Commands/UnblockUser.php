<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UnblockUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:unblock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unblock User if Blocked period is over';

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
        try {
            $users = User::where('status', User::STATUS_ADMIN_BLOCK)->whereDate('blocked_until','<=', Carbon::today())->get();
            if ($users->isNotEmpty()){
                foreach ($users as $user){
                    $user->update([
                    'status' => User::STATUS_ACTIVE,
                    'blocked_until' => null,
                    ]);
                }
            }
        } catch(ModelNotFoundException $e){
            $this->error('User Not Found!!');
        }
    }
}
