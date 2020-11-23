<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExportKelas;
use Maatwebsite\Excel\Facades\Excel;
use App\Jurusan;
use App\Dosen;
use App\Kelas;
use App\Mahasiswa;
use App\Matkulr;
use PDF;
use Alert;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Kelas::all();
        // dd($user);
        return view('kelas.index', compact('data'));
    }

    public function create()
    {
        $user = Auth::user();
        if (
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
            $jurusan = Jurusan::all();
            $dosen = Dosen::all();
            return view('kelas.form',[
                'jurusan'   => $jurusan,
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
        if (
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
           $request->validate([
                "mata_kuliah"   => 'required|unique:kelas',
                "jurusan_id"    => 'required',
                "pengajar_id"   => 'required',
                "sks"           => 'required'
            ]);
            $data = Kelas::create([
                "mata_kuliah"   => $request['mata_kuliah'],
                "jurusan_id"    => $request['jurusan_id'],
                "pengajar_id"   => $request['pengajar_id'],
                "sks"           => $request['sks']
            ]);

            Alert::success('Berhasil', 'Kelas berhasil disimpan');
            return redirect(route('kelas.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');
        }
    }

    public function show($id)
    {
        $data = Kelas::find($id);
        $mahasiswa = Matkulr::where('kelas_id','=',$id)->get();
        // dd($mahasiswa);
        return view('kelas.detail', [
            'data' => $data,
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
            $data = Kelas::find($id);
            $jurusan = Jurusan::all();
            $dosen = Dosen::all();
            return view('kelas.form_edit',[
                'data'      => $data,
                'jurusan'   => $jurusan,
                'dosen'     => $dosen
            ]);
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
            $request->validate([
                "mata_kuliah"   => 'required',
                "jurusan_id"    => 'required',
                "pengajar_id"   => 'required',
                "sks"           => 'required'
            ]);
            $data = Kelas::find($id)->update([
                "mata_kuliah"   => $request['mata_kuliah'],
                "jurusan_id"    => $request['jurusan_id'],
                "pengajar_id"   => $request['pengajar_id'],
                "sks"           => $request['sks']
            ]);

            Alert::success('Berhasil', 'Kelas berhasil diperbarui');
            return redirect(route('kelas.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
            $data = Kelas::destroy($id);

            Alert::success('Berhasil', 'Kelas berhasil dihapus');
            return redirect(route('kelas.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');
        }
    }

    public function showPdf(){
        $data = Kelas::all();
        // dd($data);
        $pdf = PDF::loadView('kelas.list_kelas', [
            'data' => $data
        ]);

        return $pdf->stream('List_Kelas.pdf');
    }

    public function exportExcel() 
    {
        return Excel::download(new ExportKelas, 'kelas.xlsx');
    }
}
