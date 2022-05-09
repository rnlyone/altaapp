<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Subkriteria;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function indexLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $attr = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if (Auth::attempt($attr)){
            Auth::login($user);
        return redirect()->intended('/')->with('sukses', "Login Sukses");
        } else {
            return back()->with('gagal', 'Username / Password Salah!');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/login')->with('sukses', 'logout berhasil');
    }

    public function indexDash()
    {
        return view('auth.dashboard');
    }

    public function index(Request $request)
    {
        if (auth()->user()->role != 'admin'){
            return abort(403, 'Maaf, Halaman Ini Bukan Untuk Anda');
        }

        $userdata = User::all();
        $usercount = User::count();

        if ($request->ajax()){
            return DataTables::of($userdata)
            ->addColumn('action', function($data){
                $button = '
                <button data-toggle="modal" data-bs-toggle="modal" data-original-title="Edit" type="button" data-bs-target="#modaledit'.$data->id.'" type="button" class="edit-post btn btn-icon btn-success">
                    <i data-feather="edit-3"></i>
                </button>';
                // $button .= '&nbsp;&nbsp;';
                $button .= '
                <button data-toggle="modal" data-bs-toggle="modal" name="delete" data-original-title="delete" data-bs-target="#modaldel'.$data->id.'" type="button" class="delete btn btn-icon btn-outline-danger">
                    <i data-feather="trash-2"></i>
                </button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('auth.usermgmt', ['userdata' => $userdata, 'latestuser_id' => $usercount]);
    }

    public function store(Request $r)
    {
        // dd($r->id);
        try {

            $validationstore = request()->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8'],
            ]);

            User::Create([
                'id' => $r->id,
                'name' => $r->name,
                'role' => $r->role,
                'email' => $r->email,
                'password' => bcrypt($r->password),
            ]);
            return back()->with('success', 'User Berhasil Dibuat.');
        } catch (Exception $th) {
            return back()->with('error', 'User Gagal Dibuat');
        }
    }

    public function destroy($id)
    {
        Penilaian::where('id_user', $id)->delete();
        User::where('id', $id)->delete();
        return back()->with('success', 'User Berhasil Dihapus.');
    }

    public function edit(Request $req)
    {
        try {
            if ($req->password == '') {
                User::where('id', $req->idedit)->update([
                    'id' => $req->id,
                    'name' => $req->name,
                    'role' => $req->role,
                    'email' => $req->email,
                ]);
            }else{
                User::where('id', $req->idedit)->update([
                    'id' => $req->id,
                    'name' => $req->name,
                    'role' => $req->role,
                    'email' => $req->email,
                    'password' => bcrypt($req->password),
                ]);
            }
            return back()->with('success', 'User Berhasil Diedit.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Terdapat Kesalahan');
        }
    }
}
