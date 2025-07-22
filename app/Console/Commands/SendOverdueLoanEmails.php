<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use Illuminate\Support\Facades\Mail;
use App\Mail\OverdueLoanReminder;

class SendOverdueLoanEmails extends Command
{
    protected $signature = 'loans:send-overdue-emails';
    protected $description = 'Send daily emails to members with overdue loans';

    /**
     * Handle the command.
     * @return void
     */
    public function handle()
    {
        $today = today();

        $overdueLoans = Loan::with('member', 'book')
            ->whereNull('returned_at')
            ->whereDate('due_at', '<', $today)
            ->get();

        // Group by member
        $grouped = $overdueLoans->groupBy('member_id');

        foreach ($grouped as $loans) {
            $member = $loans->first()->member;

            Mail::to($member->email)->send(new OverdueLoanReminder($member, $loans));
        }

        $this->info("Overdue emails sent successfully.");
    }
}
