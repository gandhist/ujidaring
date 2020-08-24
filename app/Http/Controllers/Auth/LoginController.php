<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Traits\Ujidaring\GlobalFunction;

class LoginController extends Controller
{
    use GlobalFUnction;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(\Illuminate\Http\Request $request) {
        $this->validateLogin($request);
    
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
    
        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            if ($user->is_login == 1) {
                return redirect()
                ->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors(['active' => 'anda sudah login.']);
            }
    
            // Make sure the user is active
            if ($user->is_active == 1 && $this->attemptLogin($request)) {
                // Send the normal successful login response

                // save device id here
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['active' => 'Userlogin tidak aktif.']);
            }
        }
    
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
    
        return $this->sendFailedLoginResponse($request);
    }

    public function showLoginForm(){
        return view('login');
    }

    public function username(){
        return 'username';
    }

    protected function authenticated()
    {
        $user = Auth::user();
        $user->last_login = date("Y-m-d H:i:s");
        $user->is_login = Auth::user()->role_id == 2 ? '1' : '0';
        $user->save();
        \LogActivity::addToLog("Login ke halaman ujian");
        

        // singel user login only
        \Auth::logoutOtherDevices(request('password'));

        if (Auth::user()->role_id == 2){
            $allow_absen_masuk = $this->_is_allow_masuk();
            $allow_absen_pulang = $this->_is_allow_pulang();
            if($allow_absen_masuk){
                return redirect('peserta/presensi');
            }
            else {
                return redirect('peserta/dashboard');
            }
        }
        if (Auth::user()->role_id == 3 || Auth::user()->role_id == 3){
                return redirect('instruktur/dashboardinstruktur');
        }
        
    }

    public function logout(\Illuminate\Http\Request $request){
        \LogActivity::addToLog("Logout dari halaman ujian");
        $user = Auth::user();
        $user->is_login = 0;
        $user->save();
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');

    }
}
