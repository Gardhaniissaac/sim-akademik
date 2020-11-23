@extends ('layout.master')

@section ('title', 'Create Fakultas')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('kelas.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('kelas.store')}}" method="Post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="mata_kuliah">Nama Mata Kuliah</label>
                    <input id="mata_kuliah" name ="mata_kuliah" value="{{old('mata_kuliah', '')}}">
                    @error('mata_kuliah')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="jurusan_id">Nama Jurusan</label>
                    <select id="jurusan_id" name="jurusan_id">
                      @foreach($jurusan as $key => $value)
                        <option value="{{$value->id}}">{{$value->id}} - {{$value->nama_jurusan}}</option>
                      @endforeach
                    </select>
                    @error('jurusan_id')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="sks">Jumlah SKS</label>
                    <input id="sks" name ="sks" value="{{old('sks', '')}}">
                    @error('sks')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="pengajar_id">Nama Dosen Pengajar</label>
                    <select id="pengajar_id" name="pengajar_id">
                      @foreach($dosen as $key => $value)
                        <option value="{{$value->id}}">{{$value->id}} - {{$value->getProfile->nama_lengkap}}</option>
                      @endforeach
                    </select>
                    @error('pengajar_id')
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