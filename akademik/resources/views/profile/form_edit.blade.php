@extends ('layout.master')

@section ('title', 'Edit Profile')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('profile.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('profile.update',['profile' => $data->id])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" value="{{old('title', $data->nama_lengkap)}}">
                    @error('nama_lengkap')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input class="form-control" id="tempat_lahir" name ="tempat_lahir" placeholder="Kota Kelahiran" value="{{old('tempat_lahir', $data->tempat_lahir)}}">
                    @error('tempat_lahir')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type='date' class="form-control" id="tanggal_lahir" name ="tanggal_lahir" value="{{old('tanggal_lahir', $data->tanggal_lahir)}}">
                    @error('tanggal_lahir')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="user_id">User</label>
                    <select id="status" name="status" disabled="true">
                      <option value="{{$data->user_id}}">{{$data->getUser->username}}</option>
                    </select>
                    <input type='hidden' id="user_id" name ="user_id" value="{{$data->user_id}}">
                  </div>
                  <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" value="{{old('status', $data->status)}}">
                      <option value="Mahasiswa">Mahasiswa</option>
                      <option value="Dosen">Dosen</option>
                      <option value="Tu">Staff Tu</option>
                      @if(Auth::user()->getProfile)
                        @if(Auth::user()->getProfile->status == 'Admin')
                          <option value="Admin">Admin</option>
                        @endif
                      @endif
                    </select>
                  </div>
                  <div class="form-group">
                    <input type='hidden' id="process" name ="process" value="Submitted">
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