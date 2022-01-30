<?php

namespace App\Console\Commands;

use App\Notifications\NewDonation;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class AutoPointsTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points:transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic Total Wallet Point Transfer to Donation Wallet’ must happen if a user is inactive for more than 6 or 12 months.';

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
        foreach(\App\User::whereNull('is_deleted')->get() as $row) {

            if ($row->prefix == "User" && isset($row->activity->last()->created_at)) {
                if((\Carbon\Carbon::now()->diffInMonths($row->activity->last()->created_at) > \App\Details::where('key','auto_withdrawal_time')->first()->value) && (getFinalPointsByUser($row->id)['available_points']>0)){
                    $transfer_points=getFinalPointsByUser($row->id)['available_points'];
                    $table = \App\Points::create([
                        'user_id' => $row->id,
                        'forward_points' => $transfer_points,
                        'forward_user_id' => \App\User::Where('prefix','Donations')->first()->id,
                        'week' => Carbon::now()->weekOfYear,
                    ]);
                    $table_commission = \App\Points_Commission::create([
                        'user_id' => \App\User::Where('prefix','Donations')->first()->id,
                        'agent_id' => ($row->employee)? $row->employee->id :  null,
                        'feature_partner_user_id' => ($row->employee)? null :  $row->id,
                        'type' => 'Donations',
                        'commission_points' => $transfer_points,
                        'amount' => null,
                        'week' => \Carbon\Carbon::now()->format('W'),
                        'pay_type' => "User Transfer Donation due to Inactive ".\App\Details::where('key','auto_withdrawal_time')->first()->value." Month"
                    ]);
                    \App\Points_Commission::find($table_commission->id)->notify(new NewDonation($table_commission));
                }
            }
        }
    }
}
