@extends ('layout.master')

@section ('title', 'Create Fakultas')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('dosen.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('dosen.store')}}" method="Post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="profile_id">Nama Lengkap</label>
                    <select id="profile_id" name="profile_id">
                      @foreach($profile as $key => $value)
                        <option value="{{$value->id}}">{{$value->id}} - {{$value->nama_lengkap}}</option>
                      @endforeach
                    </select>
                    @error('profile_id')
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
                    <label for="nip">NIP</label>
                    <input id="nip" name ="nip" value="{{old('nip', '')}}">
                    @error('nip')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="jabatan">Nama Jabatan</label>
                    <select id="jabatan" name="jabatan">
                      <option value="-"> - </option>
                      <option value="Wali"> Dosen Wali </option>
                      <option value="Kaprodi"> Ketua Program Studi </option>
                    </select>
                    @error('jabatan')
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