<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use App\Kategori;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        
    }
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        
        \DB::table('kategori')->insert([
            [ 'user_id' => $user->id, 'nama' => 'belanja', 'jenis' => 'pengeluaran' ],
            [ 'user_id' => $user->id, 'nama' => 'pendidikan', 'jenis' => 'pengeluaran' ],
            [ 'user_id' => $user->id, 'nama' => 'pakaian', 'jenis' => 'pengeluaran' ],
            [ 'user_id' => $user->id, 'nama' => 'motor', 'jenis' => 'pengeluaran' ],
            [ 'user_id' => $user->id, 'nama' => 'makanan', 'jenis' => 'pengeluaran' ],
            [ 'user_id' => $user->id, 'nama' => 'lain-lain', 'jenis' => 'pengeluaran' ],
            [ 'user_id' => $user->id, 'nama' => 'lain-lain', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'penghargaan', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'penyewaan', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'penjualan', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'tabungan', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'pengembalian dana', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'kupon', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'investasi', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'hibah', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'gaji', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'dividen', 'jenis' => 'pemasukan' ],
            [ 'user_id' => $user->id, 'nama' => 'uang saku', 'jenis' => 'pemasukan' ],
        ]);
        
        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }
    
}
