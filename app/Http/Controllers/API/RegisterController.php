<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Providers\RouteServiceProvider;
use App\Services\ActivationService;
# Models
use App\Models\Users\User;
use App\Models\Users\Profile;
# Repositories
use App\Repositories\ActivityLogRepository;
# Lang
use Lang;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Users\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    /** 
    * User Register
    * This endpoint allows you to register.
    * @group Users’ management
    * @non authenticated
    * @urlParam support email.
    * @queryParam NA
    * @bodyParam name, email, password
    * @response scenario=success {
    *  "message": "register_successfull",
    *  "status": 200
    * }
    * @response scenario=failed {
    *  "message": "invalid credentials",
    *  "status": 400
    * }
    **/
    public function register(Request $request){
        // 1. User creation 
        $user           = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // 2. Send Activation email to user 
        $user = User::find($user->id);
        $this->activationService->sendActivationMail($user);     // Email sending with activation link

        // 3. User profile creation 
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->save();
        
        // 4. Activity Logs
        $causer = $user;
        $log_name          = 'register';
        $description       = 'register';
        $custom_properties = ['application' => config('app.name'),
                            'operation'     => $log_name,
                            'causer_name'   => $causer->name,
                            'new_value'     => '',
                            'old_value'     => '',
                            ];
        $this->activity->store_activity_log($causer, $causer, $custom_properties, $log_name, $description);
        // 5. Response 
        if($user){
            return $this->success([
                'message'         => Lang::get('auth.registered_successfully'),
            ]);
        }else{
            return $this->error([
                'message'         => Lang::get('auth.invalid_parameters'),
            ]);
        }
    }
    /** 
    * Send Activation code to user
    * This endpoint allows you to send the activation code if user is disabled.
    * @group Users’ management
    * @non authenticated
    * @urlParam support email, code.
    * @queryParam NA
    * @bodyParam NA
    * @response scenario=success {
    *  "message": "auth.activation_email_sent",
    *  "status": 200
    * }
    **/
    public function sendActivationEmail(Request $request){
        $user = User::where('email',$request->email)->first();
        // dd($user);
        $this->activationService->sendActivationMail($user);     // Email sending with activation link
        return response()->json(['message' => Lang::get('auth.activation_email_sent') , 'status' => 200]);
    }

    /** 
    * User Activation
    * This endpoint allows you to activate the disabled user.
    * @group Users’ management
    * @non authenticated
    * @urlParam support token.
    * @queryParam NA
    * @bodyParam NA
    * @response scenario=success {
    *  "message": "auth.account_activated",
    *  "status": 200
    * }
    * @response scenario=failed {
    *  "message": "auth.error",
    *  "status": 404
    * }
    **/
    public function activateUser(Request $request, $token=null){
        if ($user = $this->activationService->activateUser($token)) {
            //1. Creating the access token for login in user
            $accessToken =  $user->createToken(config('app.code'))->accessToken;
            //2. Activity logs
            $causer = $user;
            $log_name          = 'user_activation';
            $description       = 'user_activation';
            $custom_properties = ['application' => config('app.name'),
                                'operation'     => $log_name,
                                'causer_name'   => $causer->name,
                                'new_value'     => '',
                                'old_value'     => '',
                                ];
            $this->activity->store_activity_log($causer, $causer, $custom_properties, $log_name, $description);
            //3. Redirect to dashboard if user activated the account
            return $this->success([
                'message'         => Lang::get('auth.account_activation_success'),
                'token'           => $accessToken,
                'user'            => $user,
            ]);
        }
        return $this->error([
            'message'         => Lang::get('auth.account_activation_error'),
            'error'           => Lang::get('auth.account_activation_error'),
        ], 404);
    }
}
