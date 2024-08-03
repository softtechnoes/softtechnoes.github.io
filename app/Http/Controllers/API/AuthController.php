<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Lang;
use Config;
use App\Helpers\Helper;
use App\Models\Users\User;

class AuthController extends Controller
{

    /**
     * Used to check user authenticated or not
     * @post ("/api/auth/check")
     * @return Response
     */
    public function check()
    {
        // Base Configuration // TODO use repository
        $configuration['authorized_domains'] = config('app.authorized_domains');
        $configuration['supported_locales'] = config('app.supported_locales');
        $configuration['multilingual'] = config('app.multilingual');
        // 
        
        // Auth check
        if (Auth::check()) {
            $user = Auth::user();
            $user->load('profile');
            return $this->success(['authenticated' => true,'config' => $configuration, 'user' => $user]);
        } else {
            return $this->success(['authenticated' => false,'config' => $configuration]);
        }

    }

}
