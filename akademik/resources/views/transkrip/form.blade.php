@extends ('layout.master')

@section ('title', 'Create Rencana Studi')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('transkrip.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('transkrip.store')}}" method="Post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="mahasiswa_id">Nama Mahasiswa</label>
                    <select id="mahasiswa_id" name="mahasiswa_id">
                      @foreach($mahasiswa as $key => $value)
                        <option value="{{$value->id}}">{{$value->nim}} - {{$value->getProfile->nama_lengkap}}</option>
                      @endforeach
                    </select>
                    @error('mahasiswa_id')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="kelas_id">Mata Kuliah</label>
                    <select id="kelas_id" name="kelas_id">
                      @foreach($kelas as $key => $value)
                        <option value="{{$value->id}}">{{$value->mata_kuliah}}</option>
                      @endforeach
                    </select>
                    @error('kelas_id')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="tahun_ajaran">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="Masukkan Tahun Ajaran" value="{{old('title', '')}}">
                    @error('tahun_ajaran')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="nilai">Nilai</label>
                    <input type="text" class="form-control" id="nilai" name="nilai" placeholder="Masukkan nilai" value="{{old('title', '')}}">
                    @error('nilai')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
  </div>
</section>


@endsection