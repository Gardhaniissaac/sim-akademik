<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExportJurusan;
use Maatwebsite\Excel\Facades\Excel;
use App\Jurusan;
use App\Fakultas;
use PDF;
use Alert;

class JurusanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Jurusan::all();
        return view('jurusan.index', compact('data'));
    }

    public function create()
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Tu' ||
            $user->getProfile->status=='Admin'
        ){
            $fakultas = Fakultas::all();
            return view('jurusan.form',[
                'fakultas' => $fakultas
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
            $user->getProfile->status=='Tu' ||
            $user->getProfile->status=='Admin'
        ){
            $request->validate([
                "nama_jurusan" => 'required|unique:jurusans',
                "fakultas_id"    => 'required'
            ]);
            $data = Jurusan::create([
                "nama_jurusan" => $request['nama_jurusan'],
                "fakultas_id"    => $request['fakultas_id']
            ]);

            Alert::success('Berhasil', 'Jurusan berhasil disimpan');
            return redirect(route('jurusan.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function show($id)
    {
        $data = Jurusan::find($id);
        return view('jurusan.detail', compact('data'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Tu' ||
            $user->getProfile->status=='Admin'
        ){
            $data = Jurusan::find($id);
            $fakultas = Fakultas::all();
            return view('jurusan.form_edit',[
                'data' => $data,
                'fakultas' => $fakultas
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
            $user->getProfile->status=='Tu' ||
            $user->getProfile->status=='Admin'
        ){
            $request->validate([
                "nama_jurusan" => 'required',
                "fakultas_id"    => 'required'
            ]);
            $data = Jurusan::find($id)->update([
                "nama_jurusan" => $request['nama_jurusan'],
                "fakultas_id"    => $request['fakultas_id']
            ]);

            Alert::success('Berhasil', 'Jurusan berhasil diperbarui');
            return redirect(route('jurusan.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Tu' ||
            $user->getProfile->status=='Admin'
        ){
            $data = Jurusan::destroy($id);

            Alert::success('Berhasil', 'Jurusan berhasil dihapus');
            return redirect(route('jurusan.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function showPdf(){
        $data = Jurusan::all();
        // dd($data);
        $pdf = PDF::loadView('jurusan.list_jurusan', [
            'data' => $data
        ]);

        return $pdf->stream('List_Jurusan.pdf');
    }

    public function exportExcel() 
    {
        return Excel::download(new ExportJurusan, 'jurusan.xlsx');
    }
}
