<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mahasiswa;
use App\Rencana;
use App\Matkulr;
use PDF;
use Alert;

class RencanaController extends Controller
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
            $user->getProfile->status=='Dosen' ||
            $user->getProfile->status=='Tu'
        ){
            if($user->getProfile->status=='Mahasiswa'){
                $data = Rencana::select('rencanas.*')->leftJoin('mahasiswas','mahasiswas.id','=','rencanas.mahasiswa_id')->where('mahasiswas.profile_id','=',$user->getProfile->id)->get();
            } else if ($user->getProfile->status=='Dosen'){
                $data = Rencana::select('rencanas.*')->leftJoin('mahasiswas','mahasiswas.id','=','rencanas.mahasiswa_id')->leftJoin('dosens','mahasiswas.wali_id','=','dosens.id')->where('dosens.profile_id','=',$user->getProfile->id)->get();
            } else if ($user->getProfile->status=='Tu'){
                $data = Rencana::select('rencanas.*')->leftJoin('mahasiswas','mahasiswas.id','=','rencanas.mahasiswa_id')->where('rencanas.status','=','Approved')->get();
            } else {
                $data = Rencana::select('rencanas.*')->leftJoin('mahasiswas','mahasiswas.id','=','rencanas.mahasiswa_id')->get();
            }
            
            return view('rencana.index', compact('data'));
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
            $mahasiswa = Mahasiswa::where('profile_id','=',$user->getProfile->id)->get();
            $tahun = date('Y');
            if(intval(date('m')) < 8){
                $ta = intval($tahun)-1;
                $ta = $ta.'-2';
            } else {
                $ta = intval($tahun).'-1';
            }
            // dd($tahun);
            return view('rencana.form',[
                'mahasiswa' => $mahasiswa,
                'ta'        => $ta
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
                "mahasiswa_id" => 'required',
                "tahun_ajaran"    => 'required|unique_with:rencanas,mahasiswa_id'
            ]);
            $data = Rencana::create([
                "mahasiswa_id"  => $request['mahasiswa_id'],
                "tahun_ajaran"  => $request['tahun_ajaran'],
                "komentar"      => $request['komentar'],
                "status"        => $request['status']
            ]);

            Alert::success('Berhasil', 'Rencana Studi berhasil disimpan');
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
            $user->getProfile->status=='Dosen' ||
            $user->getProfile->status=='Tu'
        ){
            $data = Rencana::find($id);
            $matkuls = Matkulr::where('matkulrs.rencana_studi_id','=',$id)->get();
            return view('rencana.detail', [
                'data'      => $data,
                'matkuls'    => $matkuls
            ]);
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Mahasiswa'||
            $user->getProfile->status=='Dosen' ||
            $user->getProfile->status=='Tu'
        ){
            $tahun = date('Y');
            if(intval(date('m')) < 8){
                $ta = intval($tahun)-1;
                $ta = $ta.'-2';
            } else {
                $ta = intval($tahun).'-1';
            }
            $data = Rencana::find($id);
            return view('rencana.form_edit',[
                'data' => $data,
                'ta'    => $ta
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
            $user->getProfile->status=='Mahasiswa'||
            $user->getProfile->status=='Dosen' ||
            $user->getProfile->status=='Tu'
        ){
            $request->validate([
                "mahasiswa_id" => 'required'
            ]);
            $data = Rencana::find($id)->update([
                "komentar"      => $request['komentar'],
                "status"        => $request['status']
            ]);

            Alert::success('Berhasil', 'Rencana Studi berhasil diperbarui');

            if($user->getProfile->status=='Mahasiswa'){
                return redirect(route('matkulr.index'));
            } else {
                return redirect(route('rencana.index'));
            }
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
            $data = Rencana::destroy($id);

            Alert::success('Berhasil', 'Rencana Studi berhasil dihapus');
            return redirect(route('rencana.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function showPdf($id){
        $user = Auth::user();
        if(
            $user->getProfile->status
        ){
            $data = Rencana::find($id);
            $matkuls = Matkulr::where('matkulrs.rencana_studi_id','=',$id)->get();
            // dd($data);
            $pdf = PDF::loadView('rencana.kartu_rencana_studi', [
                'data' => $data,
                'matkuls'    => $matkuls
            ]);

            return $pdf->stream('Kartu_Rencana_Studi.pdf');
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }
}
