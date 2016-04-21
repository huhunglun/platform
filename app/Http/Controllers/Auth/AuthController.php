<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;
use App\Users_app;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
            ],
            [
                'name.required'=>'使用者帳號必填欄位',
                'name.max'=>'使用者帳號過長',
                'email.required'=>'E-Mail 地址必填欄位',
                'email.max'=>'E-Mail 地址過長',
                'email.unique'=>'E-Mail 地址己被使用',
                'email.email'=>'E-Mail 地址必須是有效E-Mail地址 ',
                'password.required'=>'密碼必填欄位',
                'password.confirmed'=>'密碼與重複密碼不一致',
                'password.min'=>'密碼必須六位以上',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return Redirect::to('auth/'.$provider);
        }

        $authUser = $this->findOrCreateUser($user,$provider);

//        Auth::login($authUser, true);
        return Redirect::to('/success?email='.$authUser->email);
    }

    public function handleProviderCallbackSuccess(){

        return view('auth/success');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $user
     * @param $provider
     * @return User
     */
    private function findOrCreateUser($user,$provider)
    {
        if ($authUser = Users_app::where('email', $user->email)
            ->where('account_type',$provider)
            ->first()) {

            $authUser->login_times = $authUser->login_times + 1;

            $authUser->save();

            return $authUser;
        }

        $authUser = new Users_app();

        $authUser->name = $user->name;
        $authUser->email = $user->email;
        $authUser->account_type = $provider;
        $authUser->provider_id = $user->id;

        $authUser->save();

        return $authUser;
    }

   public function providerLogout(){
       Auth::logout();

       return Redirect::to('/login');
    }
}
