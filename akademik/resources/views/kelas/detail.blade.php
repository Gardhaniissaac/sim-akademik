@extends ('layout.master')

@push('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush

@section ('title', 'Detail')

@section ('content')

<section class="content">
  <div class="card">
    <div class="card-header">
    <div class="card-body mt-2">
      <table class="table table-bordered">
        <tr>
          <td>Id</td>
          <td>{{$data->id}}</td>
        </tr>
        <tr>
          <td>Mata Kuliah</td>
          <td>{{$data->mata_kuliah}}</td>
        </tr>
        <tr>
          <td>Jurusan</td>
          <td>{{$data->getJurusan->nama_jurusan}}</td>
        </tr>
        <tr>
          <td>Nama Dosen Wali</td>
          <td>{{$data->getPengajar->getProfile->nama_lengkap}}</td>
        </tr>
        <tr>
          <td>SKS</td>
          <td>{{$data->sks}}</td>
        </tr>
        <tr>
          <td>Anggota Kelas</td>
          <td>
            @foreach($mahasiswa as $anggota)
            <li>
              {{$anggota->getRencana->getMahasiswa->nim}} {{$anggota->getRencana->getMahasiswa->getProfile->nama_lengkap}}
            </li>
            @endforeach
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div class="pl-3 my-2">
    <a href="{{route('kelas.index')}}"><button type="button" class="btn btn-warning">Back to Index</button></a>
  </div>
</section>


@endsection