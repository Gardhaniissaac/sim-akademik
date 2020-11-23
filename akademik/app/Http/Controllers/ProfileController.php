<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\Mahasiswa;
use App\Tu;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Alert;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {   
        $user = Auth::user();
        if($user->getProfile){
            if($user->getProfile->status == 'Admin'){
                $data = Profile::all();
            } else {
                $data = Profile::select('profiles.*')->where('profiles.user_id','=',$user->id)->get();
            }
        } else {
            $data = Profile::select('profiles.*')->where('profiles.user_id','=',$user->id)->get();
        }
        // dd($data);
        return view('profile.index', compact('data'));
    }

    public function create()
    {
        $user = Auth::user();
        if ( $user->getProfile){
            if($user->getProfile->status == 'Admin'){
                $data = User::select('profiles.*','users.*')->leftJoin('profiles','profiles.user_id','users.id')->whereNull('profiles.user_id')->get();
            } else {
                $data = User::select('profiles.*','users.*')->leftJoin('profiles','profiles.user_id','users.id')->where('users.id','=',$user->id)->get();
            }
        } else {
            $data = User::select('profiles.*','users.*')->leftJoin('profiles','profiles.user_id','users.id')->where('users.id','=',$user->id)->get();
        }
        // dd($data);
        return view('profile.form',compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama_lengkap" => 'required',
            "user_id"   => 'required|unique:profiles',
            "status"   => 'required'
        ]);
        $data = Profile::create([
            "nama_lengkap" => $request['nama_lengkap'],
            "user_id"   => $request['user_id'],
            "tempat_lahir" => $request["tempat_lahir"],
            "tanggal_lahir" => $request['tanggal_lahir'],
            "status"   => $request['status'],
            "foto" => $request["foto"],
            "process"   => $request['process']
        ]);
        Alert::success('Berhasil', 'Profile berhasil disimpan');
        return redirect(route('profile.index'));
    }

    public function show($id)
    {
        $data = Profile::find($id);
        return view('profile.detail', compact('data'));
    }

    public function edit($id)
    {
        $data = Profile::find($id);
        $user = User::all();
        
        return view('profile.form_edit',[
            'data' => $data,
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {   
        $user = Auth::user();
        $status_lama = Profile::find($id)->status;
        if(
            $user->getProfile->id== $id ||
            $user->getProfile->status == 'Admin'
        ){
            $request->validate([
            "nama_lengkap" => 'required',
            "status"   => 'required'
            ]);

            $data = Profile::find($id)->update([
            "nama_lengkap" => $request['nama_lengkap'],
            "user_id"   => $request['user_id'],
            "tempat_lahir" => $request["tempat_lahir"],
            "tanggal_lahir" => $request['tanggal_lahir'],
            "status"   => $request['status'],
            "foto" => $request["foto"],
            "process"   => $request['process']
            ]);

            if($status_lama != $request['status'] && $status_lama == 'Tu'){
                $tulama = Tu::where('profile_id','=',$user->getProfile->id)->first();
                // dd($tulama);
                if($tulama != null){
                    $hapustu = Tu::destroy($tulama->id);    
                }
            } else if ($status_lama != $request['status'] && $status_lama == 'Mahasiswa'){
                $mahasiswalama = Mahasiswa::where('profile_id','=',$user->getProfile->id)->first();
                // dd($mahasiswalama);
                if($mahasiswalama != null){
                    $hapusmahasiswa = Mahasiswa::destroy($mahasiswalama->id);   
                }
            }

            Alert::success('Berhasil', 'Profile berhasil diperbarui');
            return redirect(route('profile.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->id== $id ||
            $user->getProfile->status == 'Admin'
        ){
            $data = Profile::destroy($id);

            Alert::success('Berhasil', 'Profile berhasil dihapus');
            return redirect(route('profile.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }
}
