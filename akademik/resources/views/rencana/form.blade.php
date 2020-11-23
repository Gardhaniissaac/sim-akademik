@extends ('layout.master')

@section ('title', 'Create Rencana Studi')

@section ('content')

<section class="content">
  <div class="pl-3">
    <a href="{{route('rencana.index')}}"><button type="button" class="btn btn-warning mb-3">Back to Index</button></a>
  </div>
  <div class="card card-primary"> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('rencana.store')}}" method="Post">
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
                    <label for="tahun_ajaran">Tahun Ajaran</label>
                    <input type="text" class="form-control" disabled="true" value="{{$ta}}">
                    <input type="hidden" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="{{$ta}}">
                    @error('tahun_ajaran')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="komentar">Komentar</label>
                    <input type="text" class="form-control" id="komentar" name="komentar" placeholder="Masukkan Komentar" value="{{old('title', '')}}">
                    @error('komentar')
                      <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="status" name="status" value="Submitted">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Pilih Mata Kuliah</button>
                </div>
              </form>
  </div>
</section>


@endsection