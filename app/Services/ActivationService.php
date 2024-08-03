<?php

namespace App\Services;


use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use App\Repositories\ActivationRepository;
use App\Notifications\UserAccountActivation;
use App\Notifications\PasswordReset;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Config;

class ActivationService
{

    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;

    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMail($user)
    {

        if ($user->status) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);
        $link = url('/auth/activate-user', $token);
        $user->notify(new UserAccountActivation($user, $link));
        
    }
    
    public function sendPasswordResetMail($user)
    {
        $token = hash_hmac('sha256', Str::random(20), config('app.key'));
        $code =  mt_rand(100000,999999);
        // Try to find if there is already a password_reset entry
        $reset = \DB::table('password_resets')->where('email', $user->email)->first();
        if(!$reset) {
            \DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $token,
                'code'  => $code,
                'created_at' => Carbon::now()
            ]);
        } else {
            \DB::table('password_resets')->where('email', $user->email)->update([
                'token' => $token,
                'code'  => $code,
                'created_at' => Carbon::now()
            ]);
        }

        $user->notify(new PasswordReset($user,$code));
        return $token;
    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        //IN-577 Check if activation is not expired
        if(strtotime($activation->created_at) + 60 * config('auth.passwords.users.expire') < time()) {
            // Token is no longer active
            return null;
        }

        $user = User::find($activation->user_id);

        $user->is_activated = 1;
        $user->activated_at = new Carbon();
        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;

    }

    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}