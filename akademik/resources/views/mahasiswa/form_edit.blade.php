@extends ('layout.master')

@section ('title', 'Edit Jurusan')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('mahasiswa.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('mahasiswa.update',['mahasiswa' => $data->id])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="profile_id">Nama Lengkap</label>
                    <select id="profile_id" name="profile_id" disabled="true">
                        <option value="{{$data->profile_id}}">{{$data->profile_id}} - {{$data->getProfile->nama_lengkap}}</option>
                    </select>
                    <input type='hidden' id="profile_id" name ="profile_id" value="{{$data->profile_id}}">
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
                    <label for="nim">NIM</label>
                    <input id="nim" name ="nim" value="{{old('nim', $data->nim)}}">
                    @error('nim')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  @if(Auth::user()->getProfile->status == 'Mahasiswa')
                    <div class="form-group">
                      <label for="wali_id">Nama Dosen Wali</label>
                      <select id="wali_id" name="wali_id" disabled="true">
                          <option value="{{$data->id}}">{{$data->id}} - {{$data->getWali->getProfile->nama_lengkap}}</option>
                      </select>
                      <input type='hidden' id="wali_id" name ="wali_id" value="{{$data->wali_id}}">
                    </div>
                  @elseif(Auth::user()->getProfile->status == 'Tu' || Auth::user()->getProfile->status == 'Admin')
                    <div class="form-group">
                      <label for="wali_id">Nama Dosen Wali</label>
                      <select id="wali_id" name="wali_id">
                        @foreach($dosen as $key => $value)
                          <option value="{{$value->id}}">{{$value->id}} - {{$value->getProfile->nama_lengkap}}</option>
                        @endforeach
                      </select>
                      @error('wali_id')
                        <div class="alert alert-danger">{{$message}}</div>
                      @enderror
                    </div>
                  @endif
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
  </div>
</section>


@endsection