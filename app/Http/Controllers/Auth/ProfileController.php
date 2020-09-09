<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\AppUser\Entities\User;
use Exception;


class ProfileController extends Controller
{
	/**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
         $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('profile'), 'text' => 'Profile Pengguna'],
        ];

        return view('auth.profile.index', [
            'page' => $this,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function changePassword()
    {
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('profile'), 'text' => 'Ubah Password'],
        ];

        return view('auth.profile.password', [
            'page' => $this,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $validator = $this->validateRequestForm($request);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first()
            ]);
        }

        DB::beginTransaction();
        try {
           
            $user = \Auth::user();
            $user->password = Hash::make($request->password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            DB::commit();

            return response_json(true, null, 'Kata sandi baru berhasil disimpan', $user);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat menyimpan data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Validate incoming request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\Validator
     */
    public function validateRequestForm($request)
    {
        return Validator::make($request->all(), [
            // 'old_password' => 'bail|required|password',
            'password' => 'bail|required|max:255|string|min:8|confirmed|different:old_password'
        ], [
            // 'old_password.required' => 'Kata sandi lama harus diisi',
            // 'old_password.password' => 'Kata sandi lama Anda tidak cocok dengan kata sandi saat ini',
            'password.required' => 'Kata sandi baru harus diisi',
            'password.min' => 'Kata sandi baru tidak boleh kurang dari 8 karakter',
            'password.max' => 'Kata sandi baru tidak boleh lebih dari 255 karakter',
            'password.confirmed' => 'Kata sandi baru tidak cocok dengan Konfirmasi kata sandi',
            'password.different' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama',
        ]);
    }

}
