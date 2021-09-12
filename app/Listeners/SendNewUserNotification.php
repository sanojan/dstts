<?php

namespace App\Listeners;

use App\Notifications\NewUser;
use App\User;
use App\Workplace;
use Illuminate\Support\Facades\Auth;
use App\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewUserNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle($event)
    {
        //check if sys_admin
        $sys_admin = User::find(1);

        $sys_admin->notify(new NewUser($event->user));

        //check if auth user has user management
        $registeredUserWorkplace = Workplace::find($event->user->workplace_id);
        
        if(count($registeredUserWorkplace->users) > 0){
            foreach($registeredUserWorkplace->users as $user){
                if(count($user->subjects) > 0){
                    foreach($user->subjects as $key => $subject){
                        $assignedSubjects[$key] = $subject->subject_code;
                    }

                    if(in_array("users", $assignedSubjects)){
                        
                        $user->notify(new NewUser($event->user));
                    }
                }


            }
        }
        
    }
}
