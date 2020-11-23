<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExportDosen;
use Maatwebsite\Excel\Facades\Excel;
use App\Jurusan;
use App\Profile;
use App\Dosen;
use PDF;
use Alert;

class DosenController extends Controller
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
            $user->getProfile->status=='Tu' ||
            $user->getProfile->status=='Dosen'
        ){
            $data = Dosen::all();
            $terdaftar = Dosen::where('profile_id','=',$user->getProfile->id)->get();

            return view('dosen.index', [
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
            $user->getProfile->status=='Tu' ||
            $user->getProfile->status=='Admin' ||
            $user->getProfile->status=='Dosen'
        ){
            $jurusan = Jurusan::all();
            
            if($user->getProfile->status=='Admin'){
                $profile = Profile::where('profiles.status','=','Dosen')->get();
            } else {
                $profile = Profile::select('dosens.*','profiles.*')->leftJoin('dosens','profiles.id','dosens.profile_id')->where('profiles.id','=',$user->getProfile->id)->where('profiles.status','=','Dosen')->whereNull('dosens.profile_id')->get();
            }
            return view('dosen.form',[
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
            $user->getProfile->status=='Tu' ||
            $user->getProfile->status=='Dosen'
        ){
            $request->validate([
                "profile_id"    => 'required|unique:tus',
                "jurusan_id"    => 'required',
                "nip"           => 'required'
            ]);
            $data = Dosen::create([
                "profile_id" => $request['profile_id'],
                "jurusan_id"    => $request['jurusan_id'],
                "nip"    => $request['nip'],
                "jabatan"    => $request['jabatan']
            ]);

            Alert::success('Berhasil', 'Dosen berhasil disimpan');
            return redirect(route('dosen.index'));
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
            $user->getProfile->status=='Tu' ||
            $user->getProfile->status=='Dosen'
        ){
            $data = Dosen::find($id);
            return view('dosen.detail', compact('data'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Dosen'
        ){
            $data = Dosen::find($id);
            $jurusan = Jurusan::all();
            return view('dosen.form_edit',[
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
            $user->getProfile->status=='Dosen'
        ){
            $request->validate([
                "profile_id" => 'required',
                "jurusan_id"    => 'required',
                "nip"           => 'required'
            ]);
            $data = Dosen::find($id)->update([
                "profile_id" => $request['profile_id'],
                "jurusan_id"    => $request['jurusan_id'],
                "nip"    => $request['nip'],
                "jabatan"    => $request['jabatan']
            ]);

            Alert::success('Berhasil', 'Dosen berhasil diperbarui');
            return redirect(route('dosen.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if(
            $user->getProfile->status=='Dosen'
        ){
            $data = Dosen::destroy($id);

            Alert::success('Berhasil', 'Dosen berhasil dihapus');
            return redirect(route('dosen.index'));
        } else {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki akses ke halaman ini');
            return view('denied');   
        }
    }

    public function showPdf(){
        $data = Dosen::all();
        // dd($data);
        $pdf = PDF::loadView('dosen.list_dosen', [
            'data' => $data
        ]);

        return $pdf->stream('List_Dosen.pdf');
    }

    public function exportExcel() 
    {
        return Excel::download(new ExportDosen, 'dosen.xlsx');
    }
}
