<?php

namespace App\Console\Commands;

use App\Mail\NotificationMail;
use App\Models\EmailQueue;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email in the background.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mails = EmailQueue::getPendingEmails();
        if(!empty($mails)){
            foreach ($mails as $mail){
                $user = User::find($mail->user_id);
                if(!empty($user)){
                    try {
                        Mail::to($user)->send(new NotificationMail($user, $mail->subject, $mail->message));
                        $mail->status = 1;
                        $mail->save();
                    }catch (\Exception $exception){
                        $mail->status = 2;
                        $mail->save();
                    }
                }
            }
        }
    }
}
