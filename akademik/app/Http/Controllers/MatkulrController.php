<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rencana;
use App\Kelas;
use App\Matkulr;
use Alert;

class MatkulrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Mahasiswa'||
            $user->getProfile->status=='Admin' ||
            $user->getProfile->status=='Tu'
        ){
            if($user->getProfile->status == 'Mahasiswa'){
                $data = Matkulr::select('matkulrs.*')->leftJoin('rencanas','rencanas.id','=','matkulrs.rencana_studi_id')->leftJoin('mahasiswas','rencanas.mahasiswa_id','=','mahasiswas.id')->where('mahasiswas.profile_id','=',$user->getProfile->id)->get();
            } else {
                $data = Matkulr::all();
            }
            $fix = Rencana::select('rencanas.*')->leftJoin('mahasiswas','rencanas.mahasiswa_id','=','mahasiswas.id')->where('mahasiswas.profile_id','=',$user->getProfile->id)->get();
            // dd($fix);
            return view('matkulr.index', [
                'data' => $data,
                'fix'   => $fix['0'] 
            ]);
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function create()
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Mahasiswa'
        ){
            $kelas = Kelas::all();
            $rencana = Rencana::select('mahasiswas.*','rencanas.*')->leftJoin('mahasiswas','mahasiswas.id','=','rencanas.mahasiswa_id')->leftJoin('profiles','mahasiswas.profile_id','=','profiles.id')->where('profiles.id','=',$user->getProfile->id)->get();
            return view('matkulr.form',[
                'kelas' => $kelas,
                'rencana' => $rencana
            ]);
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Mahasiswa'
        ){
            $request->validate([
                "rencana_studi_id" => 'required',
                "kelas_id"    => 'required|unique_with:matkulrs,rencana_studi_id'
            ]);
            $data = Matkulr::create([
                "rencana_studi_id" => $request['rencana_studi_id'],
                "kelas_id"    => $request['kelas_id']
            ]);


            Alert::success('Berhasil', 'Mata kuliah rencana studi berhasil disimpan');
            return redirect(route('matkulr.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Mahasiswa'||
            $user->getProfile->status=='Admin' ||
            $user->getProfile->status=='Tu'
        ){
            $data = Matkulr::find($id);
            return view('matkulr.detail', compact('data'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Mahasiswa'
        ){
            $data = Matkulr::find($id);
            $kelas = Kelas::select('kelas.*')->leftJoin('matkulrs','kelas.id','=','matkulrs.kelas_id')->where('matkulrs.id','=', NULL)->orWhere('matkulrs.id','=',$id)->get();
            return view('matkulr.form_edit',[
                'data' => $data,
                'kelas' => $kelas
            ]);
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Mahasiswa'
        ){
            $request->validate([
                "rencana_studi_id" => 'required',
                "kelas_id"    => 'required'
            ]);
            $data = Matkulr::find($id)->update([
                "rencana_studi_id" => $request['rencana_studi_id'],
                "kelas_id"    => $request['kelas_id']
            ]);

            Alert::success('Berhasil', 'Mata kuliah rencana studi berhasil diperbarui');
            return redirect(route('matkulr.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Mahasiswa'
        ){
            $data = Matkulr::destroy($id);

            Alert::success('Berhasil', 'Mata kuliah rencana studi berhasil dihapus');
            return redirect(route('matkulr.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }
}
