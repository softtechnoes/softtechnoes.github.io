<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Repositories\ActivityLogRepository;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;
use Session, Cookie, Hash, Route, Lang;
use App\Services\ActivationService;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $activity;
    // IN-583 custom login throttle
    protected $maxAttempts = 2; // Default is 5
    protected $decayMinutes = 2; // Default is 1

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivityLogRepository $activity)
    {
        $this->middleware('guest')->except('logout');
        $this->activity = $activity;
    }

    /** 
    * Handle a login request to the application.
    *
    * @bodyParam email email required The email of the user. Example: demo@demo.com
    * @bodyParam password password required The password of the user. Example: password
    * @group Users’ management
    * @non authenticated
    * @urlParam support email.
    * @queryParam NA
    * @bodyParam NA
    * @response scenario=success {
    *  "message": "logged_in",
    *  "status": 200
    * }
    * @response scenario=failed {
    *  "message": "invalid credentials",
    *  "status": 400
    * }
    **/
    public function login(Request $request)
    {
        if($this->hasTooManyLoginAttempts($request)){
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }else{
            $credentials = ['email' => $request->email, 'password' => $request->password];
            if (Auth::attempt($credentials)) {
                $auth_user = Auth::user();
                if($auth_user->is_activated){
                    $accessToken =  $auth_user->createToken(config('app.code'))->accessToken;
                    // Activity Log
                    $causer = $auth_user;
                    $log_name          = 'login';
                    $description       = 'login';
                    $custom_properties = ['application' => config('app.name'),
                                        'operation'     => $log_name,
                                        'causer_name'   => $causer->name,
                                        'new_value'     => '',
                                        'old_value'     => '',
                                        ];
                    $this->activity->store_activity_log($causer, $causer, $custom_properties, $log_name, $description);

                    return $this->success([
                        'message'         => Lang::get('auth.logged_in'),
                        'token'           => $accessToken,
                        'user'            => $auth_user,
                    ]);

                }else{
                    Auth::guard('web')->logout();
                    Session::flush();
                    return $this->error([
                        'message'         => Lang::get('auth.account_deactivated'),
                        'error'           => Lang::get('auth.account_deactivated'),
                    ]);
                }
                
            }else{
                $this->incrementLoginAttempts($request);
                return $this->error([
                    'message'         => Lang::get('auth.failed'),
                    'error'           => Lang::get('auth.failed'),
                ]);
            }
        }
    }
    
    /** 
    * User Logout
    * This endpoint allows you to logout the user.
    * @group Users’ management
    * @non authenticated
    * @urlParam support .
    * @queryParam NA
    * @bodyParam NA
    * @response scenario=success {
    *  "message": "auth.logged_out",
    *  "status": 200
    * }
    **/
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $token = Auth::user()->token();
            $token->revoke();

            // Activity log
            $causer = Auth::user();
            $log_name = 'logout';
            $operation = 'logout';
            $description = 'logout';
            $custom_properties = ['application' => config('app.name'),
                    'operation' => $operation,
                    'causer_name' => $causer->name,
                    'new_value' => 'logged out', 
                    'old_value' => null,
                    ];
            $this->activity->store_activity_log($causer, $causer, $custom_properties, $log_name, $description);

            Auth::guard('web')->logout();
            Session::flush();

            return $this->success(['message' => Lang::get('auth.logged_out')]);

        } 
        else{ 
            // return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'] , Response::HTTP_UNAUTHORIZED);
            
        } 
    }

    /** 
    * User Email existence
    * This endpoint allows you to check the email has exist in datbase or not.
    * @group Users’ management
    * @non authenticated
    * @urlParam support email.
    * @queryParam NA
    * @bodyParam NA
    * @response scenario=success {
    *  "message": "Invalid user",
    *  "status": 422
    * }
    * @response scenario=failed {
    *  "message": "Valid user",
    *  "status": 200
    * }
    **/
    public function userEmailExists(Request $request){
        // Check if user exists
        $user = User::where('email',$request->email)->first();
        if($user){
            return $this->success([
                'message'         => Lang::get('site_lang.success'),
                'user_exists'     => true
            ]);
        }else{
            return $this->error([
                'message'         => Lang::get('validation.email', [ 'attribute' => Lang::get('validation.attributes.email') ]),
                'user_exists'     => false
            ], 404);
        }
    }
    public function sqlMapTest(Request $request) {
        // dd( $request->all());
        // return $request->id;
        $user = User::find($request->id);
        if($user) {
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['user' => null], 404);
        }
        
    }
}
