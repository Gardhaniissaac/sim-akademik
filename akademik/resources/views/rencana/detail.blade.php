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
          <td>Nama Mahasiswa</td>
          <td>{{$data->getMahasiswa->getProfile->nama_lengkap}}</td>
        </tr>
        <tr>
          <td>NIM</td>
          <td>{{$data->getMahasiswa->nim}}</td>
        </tr>
        <tr>
          <td>Tahun Ajaran</td>
          <td>{{$data->tahun_ajaran}}</td>
        </tr>
        <tr>
          <td>Komentar</td>
          <td>{{$data->komentar}}</td>
        </tr>
        <tr>
          <td>Matakuliah Yang Diambil</td>
          <td>
            <ul>
              @foreach($matkuls as $matkul)
                <li>
                  {{$matkul->getKelas->mata_kuliah}}
                </li>
              @endforeach
            </ul>
          </td>
        </tr>
        <tr>
          <td>Status</td>
          <td>{{$data->status}}</td>
        </tr>
      </table>
    </div>
  </div>
  <div class="pl-3 my-2">
    <a href="{{route('rencana.index')}}"><button type="button" class="btn btn-warning">Back to Index</button></a>
    <a href="{{route('rencana.rencanastudi', ['rencana'=> $data->id])}}"><button type="button" class="btn btn-primary">Download Kartu Rencana Studi Mahasiswa</button></a>
  </div>
</section>


@endsection