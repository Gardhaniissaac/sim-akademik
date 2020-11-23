<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mahasiswa;
use App\Kelas;
use App\Transkrip;
use PDF;
use Alert;

class TranskripController extends Controller
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

            // dd($user->getProfile->id);
            if( $user->getProfile->status == 'Mahasiswa'){
                $data = Transkrip::select('transkrips.*')->leftJoin('mahasiswas','mahasiswas.id','=','transkrips.mahasiswa_id')->where('mahasiswas.profile_id','=',$user->getProfile->id)->get();
            } else if($user->getProfile->status == 'Dosen'){
                $data = Transkrip::select('transkrips.*')->leftJoin('kelas','kelas.id','=','transkrips.kelas_id')->leftJoin('dosens','dosens.id','=','kelas.pengajar_id')->where('dosens.profile_id','=',$user->getProfile->id)->get();
            } else {
                $data = Transkrip::all();
            }
            
            return view('transkrip.index', compact('data'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function create()
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Tu'
        ){
            $mahasiswa = Mahasiswa::all();
            $kelas = Kelas::all();
            return view('transkrip.form',[
                'mahasiswa' => $mahasiswa,
                'kelas'     => $kelas
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
            $user->getProfile->status=='Tu'
        ){
            $request->validate([
                "mahasiswa_id" => 'required',
                "tahun_ajaran"    => 'required',
                "kelas_id"    => 'required|unique_with:transkrips,tahun_ajaran,mahasiswa_id'
            ]);
            $data = Transkrip::create([
                "mahasiswa_id"  => $request['mahasiswa_id'],
                "tahun_ajaran"  => $request['tahun_ajaran'],
                "kelas_id"      => $request['kelas_id'],
                "nilai"         => $request['nilai']
            ]);

            Alert::success('Berhasil', 'Transkrip berhasil disimpan');
            return redirect(route('transkrip.index'));
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
            $data = Transkrip::find($id);
            return view('transkrip.detail', [
                'data'      => $data
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
            $user->getProfile->status=='Admin' ||
            $user->getProfile->status=='Dosen' ||
            $user->getProfile->status=='Tu'
        ){
            $data = Transkrip::find($id);
            $kelas = Kelas::all();
            return view('transkrip.form_edit',[
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
            $user->getProfile->status=='Mahasiswa'||
            $user->getProfile->status=='Admin' ||
            $user->getProfile->status=='Dosen' ||
            $user->getProfile->status=='Tu'
        ){
            if($user->getProfile->status=='Dosen'){
                $data = Transkrip::find($id)->update([
                    "nilai"         => $request['nilai']
                ]);
            } else {
                $request->validate([
                    "nilai" => 'required',
                ]);
                $data = Transkrip::find($id)->update([
                    "nilai"         => $request['nilai']
                ]);
            }

            Alert::success('Berhasil', 'Transkrip berhasil diperbarui');
            return redirect(route('transkrip.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Admin' ||
            $user->getProfile->status=='Tu'
        ){
            $data = Transkrip::destroy($id);

            Alert::success('Berhasil', 'Transkrip berhasil dihapus');
            return redirect(route('transkrip.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function showPdf(){
        $user = Auth::user();
        if(
            $user->getProfile->status=='Mahasiswa'
        ){
            $data = Transkrip::select()->leftJoin('mahasiswas','mahasiswas.id','=','transkrips.mahasiswa_id')->where('mahasiswas.profile_id','=',$user->getProfile->id)->get();
            // dd($data);
            $pdf = PDF::loadView('transkrip.transkrip_mahasiswa', [
                'data' => $data
            ]);

            return $pdf->stream('Transkrip_Mahasiswa.pdf');
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }
}
