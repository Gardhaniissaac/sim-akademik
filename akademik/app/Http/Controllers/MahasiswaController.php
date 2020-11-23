<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExportMahasiswa;
use Maatwebsite\Excel\Facades\Excel;
use App\Profile;
use App\Jurusan;
use App\Dosen;
use App\Mahasiswa;
use PDF;
use Alert;

class MahasiswaController extends Controller
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
            $data = Mahasiswa::all();
            $terdaftar = Mahasiswa::where('profile_id','=',$user->getProfile->id)->get();
            // dd();
            return view('mahasiswa.index', [
                'data' => $data,
                'terdaftar' => $terdaftar
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
            $user->getProfile->status=='Mahasiswa'||
            $user->getProfile->status=='Admin'
        ){
            $jurusan = Jurusan::all();
            $dosen = Dosen::where('dosens.jabatan','=','Wali')->get();
            if($user->getProfile->status=='Admin'){
                $profile = Profile::where('profiles.status','=','Mahasiswa')->get();
            } else {
                $profile = Profile::select('mahasiswas.*','profiles.*')->leftJoin('mahasiswas','profiles.id','mahasiswas.profile_id')->where('profiles.id','=',$user->getProfile->id)->where('profiles.status','=','Mahasiswa')->whereNull('mahasiswas.profile_id')->get();
            }
            // dd($dosen);
            return view('mahasiswa.form',[
                'jurusan'   => $jurusan,
                'profile'   => $profile,
                'dosen'     => $dosen
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
            $user->getProfile->status=='Mahasiswa'||
            $user->getProfile->status=='Admin'
        ){
            $request->validate([
                "profile_id"    => 'required|unique:mahasiswas',
                "jurusan_id"    => 'required',
                "nim"           => 'required|unique:mahasiswas',
                "wali_id"       => 'required'
            ]);
            $data = Mahasiswa::create([
                "profile_id" => $request['profile_id'],
                "jurusan_id"    => $request['jurusan_id'],
                "nim"    => $request['nim'],
                "wali_id"    => $request['wali_id']
            ]);

            Alert::success('Berhasil', 'Mahasiswa berhasil disimpan');
            return redirect(route('mahasiswa.index'));
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
            $data = Mahasiswa::find($id);
            return view('mahasiswa.detail', compact('data'));
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
            $user->getProfile->status=='Tu'
        ){
            $data = Mahasiswa::find($id);
            $jurusan = Jurusan::all();
            $dosen = Dosen::where('dosens.jabatan','=','Wali')->get();
            return view('mahasiswa.form_edit',[
                'data' => $data,
                'jurusan' => $jurusan,
                'dosen'   => $dosen
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
            $user->getProfile->status=='Tu'
        ){
            $request->validate([
                "profile_id"    => 'required',
                "jurusan_id"    => 'required',
                "nim"           => 'required',
                "wali_id"       => 'required'
            ]);
            $data = Mahasiswa::find($id)->update([
                "profile_id" => $request['profile_id'],
                "jurusan_id"    => $request['jurusan_id'],
                "nim"    => $request['nim'],
                "wali_id"    => $request['wali_id']
            ]);

            Alert::success('Berhasil', 'Mahasiswa berhasil diperbarui');
            return redirect(route('mahasiswa.index'));
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
            $data = Mahasiswa::destroy($id);

            Alert::success('Berhasil', 'Mahasiswa berhasil dihapus');
            return redirect(route('mahasiswa.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function showPdf(){
        $data = Mahasiswa::all();
        // dd($data);
        $pdf = PDF::loadView('mahasiswa.list_mahasiswa', [
            'data' => $data
        ]);

        return $pdf->stream('List_Mahasiswa.pdf');
    }

    public function exportExcel() 
    {
        return Excel::download(new ExportMahasiswa, 'mahasiswa.xlsx');
    }
}
