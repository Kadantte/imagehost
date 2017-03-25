<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendActivationMail;
use App\Models\User;
use App\Models\UserActivation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/';

    protected $group_id = 5;

    public function __construct()
    {
        $this->middleware('guest');

        parent::__construct();

        $this->meta->setMeta('Register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, User $user)
    {
        $token = hash_hmac('sha256', $user->username . $user->email . str_random(16), config('app.key'));

        UserActivation::create([
            'user_id' => $user->id,
            'token'   => $token,
        ]);

        $this->dispatch(new SendActivationMail($user, $token));

        flash('You have been successfully registered. A confirmation email has been sent to "' . e($user->email) . '" Please confirm your email address, before you login.',
            'info');

        return redirect('login');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8|max:48|password_policy',
        ], [
            'password.password_policy' => 'Choose a stronger password, at least one uppercase letter with number or symbol.',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'group_id' => $this->group_id,
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
