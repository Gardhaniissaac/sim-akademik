<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fakultas;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExportFakultas;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Alert;

class FakultasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Fakultas::all();
        return view('fakultas.index', compact('data'));
    }

    public function create()
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Admin' 
        ){
            return view('fakultas.form');
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Admin' 
        ){
            $request->validate([
                "nama_fakultas" => 'required|unique:fakultas'
            ]);
            $data = Fakultas::create([
                "nama_fakultas" => $request['nama_fakultas']
            ]);

            Alert::success('Berhasil', 'Fakultas berhasil disimpan');
            return redirect(route('fakultas.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function show($id)
    {
        $data = Fakultas::find($id);
        return view('fakultas.detail', compact('data'));
    }

    public function edit($id)
    {   
        $user = Auth::user();
        if(
            $user->getProfile->status=='Admin' 
        ){
            $data = Fakultas::find($id);
        
            return view('fakultas.form_edit',compact('data'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Admin' 
        ){
            $request->validate([
                "nama_fakultas" => 'required'
            ]);
            $data = Fakultas::find($id)->update([
                "nama_fakultas" => $request['nama_fakultas']
            ]);

            Alert::success('Berhasil', 'Fakultas berhasil diperbarui');
            return redirect(route('fakultas.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Admin' 
        ){
            $data = Fakultas::destroy($id);

            Alert::success('Berhasil', 'Fakultas berhasil dihapus');
            return redirect(route('fakultas.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function showPdf(){
        $data = Fakultas::all();
        // dd($data);
        $pdf = PDF::loadView('fakultas.list_fakultas', [
            'data' => $data
        ]);

        return $pdf->stream('List_Fakultas.pdf');
    }

    public function exportExcel() 
    {
        return Excel::download(new ExportFakultas, 'fakultas.xlsx');
    }
}
