<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExportTu;
use Maatwebsite\Excel\Facades\Excel;
use App\Profile;
use App\Jurusan;
use App\Tu;
use PDF;
use Alert;

class TuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if(
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu'
        ){
            $data = Tu::all();
            $terdaftar = Tu::where('profile_id','=',$user->getProfile->id)->get();
            return view('tu.index', [
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
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
            $jurusan = Jurusan::all();
            if($user->getProfile->status=='Admin'){
                $profile = Profile::where('profiles.status','=','Tu')->get();
            } else {
                $profile = Profile::select('tus.*','profiles.*')->leftJoin('tus','profiles.id','tus.profile_id')->where('profiles.id','=',$user->getProfile->id)->where('profiles.status','=','Tu')->whereNull('tus.profile_id')->get();
            }
            return view('tu.form',[
                'jurusan' => $jurusan,
                'profile' => $profile
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
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
            $request->validate([
                "profile_id" => 'required|unique:tus',
                "jurusan_id"    => 'required'
            ]);
            $data = Tu::create([
                "profile_id" => $request['profile_id'],
                "jurusan_id"    => $request['jurusan_id']
            ]);

            Alert::success('Berhasil', 'Staff Tata Usaha berhasil disimpan');
            return redirect(route('tu.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');
        }
        
    }

    public function show($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu'
        ){
            $data = Tu::find($id);
            return view('tu.detail', compact('data'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');
        }
        
    }

    public function edit($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
            $data = Tu::find($id);
            $jurusan = Jurusan::all();
            return view('tu.form_edit',[
                'data' => $data,
                'jurusan' => $jurusan
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
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
            $request->validate([
                "profile_id" => 'required',
                "jurusan_id"    => 'required'
            ]);
            $data = Tu::find($id)->update([
                "profile_id" => $request['profile_id'],
                "jurusan_id"    => $request['jurusan_id']
            ]);

            Alert::success('Berhasil', 'Staff Tata Usaha berhasil diperbarui');
            return redirect(route('tu.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');
        }
        
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status == 'Admin' ||
            $user->getProfile->status == 'Tu' 
        ){
            $data = Tu::destroy($id);

            Alert::success('Berhasil', 'Staff Tata Usaha berhasil dihapus');
            return redirect(route('tu.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');
        }
        
    }

    public function showPdf(){
        $data = Tu::all();
        // dd($data);
        $pdf = PDF::loadView('tu.list_tu', [
            'data' => $data
        ]);

        return $pdf->stream('List_Tata_Usaha.pdf');
    }

    public function exportExcel() 
    {
        return Excel::download(new ExportTu, 'tata_usaha.xlsx');
    }
}
