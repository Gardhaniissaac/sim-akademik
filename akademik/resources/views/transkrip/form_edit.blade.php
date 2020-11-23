@extends ('layout.master')

@section ('title', 'Edit Rencana Studi')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('transkrip.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('transkrip.update',['transkrip' => $data->id])}}" method="POST">
                @csrf
                @method('PUT')
                @if (Auth::user()->getProfile->status == 'Dosen')
                  <div class="form-group">
                    <label for="nilai">Nilai</label>
                    <input type="text" class="form-control" id="nilai" name="nilai" placeholder="Masukkan nilai" value="{{old('title', $data->nilai)}}">
                    @error('nilai')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                @else
                  <div class="card-body">
                    <div class="form-group">
                      <label for="mahasiswa_id">Nama Mahasiswa</label>
                      <select id="mahasiswa_id" name="mahasiswa_id" disabled="true">
                          <option value="{{$data->mahasiswa_id}}">{{$data->getMahasiswa->nim}} - {{$data->getMahasiswa->getProfile->nama_lengkap}}</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="kelas_id">Mata Kuliah</label>
                      <select id="kelas_id" name="kelas_id" disabled="true">
                        @foreach($kelas as $key => $value)
                          <option value="{{$value->id}}">{{$value->mata_kuliah}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="tahun_ajaran">Tahun Ajaran</label>
                      <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="Masukkan Tahun Ajaran" value="{{old('title', $data->tahun_ajaran)}}" disabled="true">
                    </div>
                    <div class="form-group">
                      <label for="nilai">Nilai</label>
                      <input type="text" class="form-control" id="nilai" name="nilai" placeholder="Masukkan nilai" value="{{old('title', $data->nilai)}}">
                      @error('nilai')
                        <div class="alert alert-danger">{{$message}}</div>
                      @enderror
                    </div>
                  </div>
                @endif
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
  </div>
</section>


@endsection