@extends ('layout.master')

@section ('title', 'Add Matakuliah')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('matkulr.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('matkulr.store')}}" method="Post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="rencana_studi_id">Rencana Studi</label>
                    <select id="rencana_studi_id" name="rencana_studi_id">
                      @foreach($rencana as $key => $value)
                        <option value="{{$value->id}}">{{$value->getMahasiswa->nim}}-{{$value->getMahasiswa->getProfile->nama_lengkap}}, TA {{$value->tahun_ajaran}}</option>
                      @endforeach
                    </select>
                    @error('rencana_studi_id')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="kelas_id">Nama Kelas</label>
                    <select id="kelas_id" name="kelas_id">
                      @foreach($kelas as $key => $value)
                        <option value="{{$value->id}}">{{$value->id}} - {{$value->mata_kuliah}}</option>
                      @endforeach
                    </select>
                    @error('kelas_id')
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