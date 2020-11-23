@extends ('layout.master')

@section ('title', 'Edit Rencana Studi')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('rencana.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('rencana.update',['rencana' => $data->id])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="mahasiswa_id">Nama Mahasiswa</label>
                    <select id="mahasiswa_id" name="mahasiswa_id" disabled="true">
                        <option value="{{$data->mahasiswa_id}}">{{$data->getMahasiswa->nim}} - {{$data->getMahasiswa->getProfile->nama_lengkap}}</option>
                    </select>
                    <input type="hidden" class="form-control" id="mahasiswa_id" name="mahasiswa_id" value="{{$data->mahasiswa_id}}">
                    @error('mahasiswa_id')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="tahun_ajaran">Tahun Ajaran</label>
                    <input type="text" class="form-control" disabled="true" value="{{$ta}}">
                    <input type="hidden" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="{{$ta}}">
                    @error('tahun_ajaran')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="komentar">Komentar</label>
                    <input type="text" class="form-control" id="komentar" name="komentar" placeholder="Masukkan Komentar" value="{{old('title', $data->komentar)}}">
                    @error('komentar')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    @if(Auth::user()->getProfile->status == 'Mahasiswa')
                      <input type="hidden" class="form-control" id="status" name="status" value="Submitted">
                    @elseif(Auth::user()->getProfile->status == 'Dosen')
                      <select id="status" name="status">
                        <option value="Approved">Disetujui</option>
                        <option value="Rejected">Ditolak</option>
                      </select>
                    @elseif(Auth::user()->getProfile->status == 'Tu')
                      <select id="status" name="status">
                        <option value="Approved Final">Disetujui Program Studi</option>
                        <option value="Rejected">Ditolak</option>
                      </select>
                    @endif
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">
                    @if(Auth::user()->getProfile->status == 'Mahasiswa')
                      Pilih Mata Kuliah
                    @else
                      Submit
                    @endif
                  </button>
                </div>
              </form>
  </div>
</section>


@endsection