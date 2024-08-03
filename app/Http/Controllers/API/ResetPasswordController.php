<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Services\ActivationService;
use DB;
# Models
use App\Models\Users\User;
# Repositories
use App\Repositories\ActivityLogRepository;
# Lang
use Lang;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $activationService;
    protected $activity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, ActivationService $activationService, ActivityLogRepository $activity)
    {
        $this->middleware('guest');
        $this->request = $request;
        $this->activity = $activity;
        $this->activationService = $activationService;
    }
    /** 
    * Handle a reset password email request to the application.
    *
    * @bodyParam email email required The email of the user. Example: demo@demo.com
    * @non authenticated
    * @urlParam support email.
    * @queryParam NA
    * @bodyParam NA
    * @response scenario=success {
    *  "message": "reset email send",
    *  "status": 200
    * }
    * @response scenario=failed {
    *  "message": "user not exist",
    *  "status": 400
    * }
    **/
    public function sendResetpasswordEmail(Request $request){
        // Front ent has already verified if user exists, we check anyway
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return $this->error([
                'error'           => Lang::get('auth.failed'),
            ], 404);
        }
        
        $token = $this->activationService->sendPasswordResetMail($user); // mail sending with reset code
        return $this->success([
            'message'         => Lang::get('auth.reset_email_sent'),
            'token'           => $token,
        ]);
    }
   /** 
    * Handle a change password request to the application.
    *
    * @bodyParam token token required The token of the related user.
    * @bodyParam password new password required of the related user.
    * @non authenticated
    * @queryParam NA
    * @bodyParam NA
    * @response scenario=success {
    *  "message": "password change successfully",
    *  "status": 200
    * }
    * @response scenario=failed {
    *  "message": "not authenticated token",
    *  "status": 400
    **/
    public function resetPassword(Request $request){
        $change = false;
        $reset_query = DB::table('password_resets')->where('token', $request->token);
        $reset = $reset_query->first();
        if($reset) {
            // Check if code matches, for security purposes - double validation
            if(((int)$request->code === (int)$reset->code) && ($request->email === $reset->email)) {
                $change = true;
            }
        }
        if($change) {
            User::where('email', $reset->email)->update([
                'password' => bcrypt($request->password)  
            ]);
            $causer = User::where('email', $reset->email)->first();
            $log_name          = 'ResetPassword';
            $description       = 'ResetPassword';
            $custom_properties = ['application' => config('app.name'),
                                'operation'     => $log_name,
                                'causer_name'   => $causer->name,
                                'new_value'     => '',
                                'old_value'     => '',
                                ];
            $this->activity->store_activity_log($causer, $causer, $custom_properties, $log_name, $description);
            $reset_query->delete();
            return $this->success([
                'message' => Lang::get('auth.reset_password_success'),
            ]);
        } else {
            return $this->error([
                'error' => Lang::get('auth.reset_not_authorized') . '. ' . Lang::get('auth.restart_reset_password'),
            ], 403);
        }
    }
    /** 
    * Handle a reset code matching request of the application.
    *
    * @bodyParam code reset code required  for user authentication.
    * @non authenticated
    * @queryParam NA
    * @bodyParam NA
    * @response scenario=success {
    *  "token": $token,
    *  "status": 200
    * }
    * @response scenario=failed {
    *  "message": "code not match",
    *  "status": 400
    **/
    public function authorizePasswordReset(Request $request){
        $authorized = false;
        $reset = DB::table('password_resets')->where('token', $request->token)->first();
        if($reset) {
            //IN-582 Check if activation is not expired
            if(strtotime($reset->created_at) + 60 * config('auth.passwords.users.expire') > time()) {
                // Check if code matches
                if((int)$request->code === (int)$reset->code) {
                    $authorized = true;
                }
            }
        }
        if($authorized) {
            return $this->success([
                'message'         => Lang::get('auth.reset_authorized'),
            ]);
        } else {
            return $this->error([
                'error' => Lang::get('auth.reset_not_authorized'),
            ], 403);
        }
    }
}
