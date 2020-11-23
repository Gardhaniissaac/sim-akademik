@extends ('layout.master')

@section ('title', 'Edit Jurusan')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('jurusan.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('jurusan.update',['jurusan' => $data->id])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama_jurusan">Nama Jurusan</label>
                    <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" placeholder="Masukkan Nama Jurusan" value="{{old('title', $data->nama_jurusan)}}">
                    @error('nama_jurusan')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="fakultas_id">Nama Fakultas</label>
                    <select id="fakultas_id" name="fakultas_id">
                      @foreach($fakultas as $key => $value)
                        <option value="{{$value->id}}">{{$value->id}} - {{$value->nama_fakultas}}</option>
                      @endforeach
                    </select>
                    @error('fakultas_id')
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