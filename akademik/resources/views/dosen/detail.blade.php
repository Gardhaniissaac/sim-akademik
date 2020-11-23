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
          <td>Nama Lengkap</td>
          <td>{{$data->getProfile->nama_lengkap}}</td>
        </tr>
        <tr>
          <td>Nama Jurusan</td>
          <td>{{$data->getJurusan->nama_jurusan}}</td>
        </tr>
        <tr>
          <td>NIK</td>
          <td>{{$data->nip}}</td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>{{$data->jabatan}}</td>
        </tr>
      </table>
    </div>
  </div>
  <div class="pl-3 my-2">
    <a href="{{route('dosen.index')}}"><button type="button" class="btn btn-warning">Back to Index</button></a>
  </div>
</section>


@endsection