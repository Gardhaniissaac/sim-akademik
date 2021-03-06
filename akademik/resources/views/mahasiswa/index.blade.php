@extends ('layout.master')

@push('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush

@section ('title', 'List Mahasiswa')

@section ('content')

<section class="content">
	@if(session('success'))
		<div class="alert alert-success">
			{{session('success')}}
		</div>
	@endif
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">Tabel Mahasiswa</h3>
    <div class="card-tools">
     	<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="pl-3 my-2">
      @if (Auth::user()->getProfile)
        @if (Auth::user()->getProfile->status == 'Admin' || (Auth::user()->getProfile->status == 'Mahasiswa' && count($terdaftar) == 0))
      	 <a href="{{route('mahasiswa.create')}}"><button type="button" class="btn btn-primary">Create</button></a>
        @endif
      @endif
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>                  
          <tr>
            <th style="width: 10px">#</th>
            <th>Nama Lengkap</th>
            <th>NIM</th>
            <th>Jurusan</th>
            <th>Dosen Wali</th>
            <th style="width: 160px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key => $value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->getProfile->nama_lengkap}}</td>
            <td>{{$value->nim}}</td>
            <td>{{$value->getJurusan->nama_jurusan}}</td>
            <td>{{$value->getWali->getProfile->nama_lengkap}}</td>
            <td>
            	<div >
	            	<a href="{{route('mahasiswa.show', ['mahasiswa' => $value->id])}}"><button class="btn btn-default" title="Detail"><i class="fa fa-search-plus" aria-hidden="true"></i></button></a>
                 @if (Auth::user()->getProfile)
                    @if ((Auth::user()->getProfile->status == 'Mahasiswa' && $value->profile_id == Auth::user()->getProfile->id) || Auth::user()->getProfile->status == 'Tu')
      	            	<a href="{{route('mahasiswa.edit', ['mahasiswa'=> $value->id])}}"><button class="btn btn-default" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                    @endif
                    @if (Auth::user()->getProfile->status == 'Mahasiswa' && $value->profile_id == Auth::user()->getProfile->id)
            					<form role="form" action="{{route('mahasiswa.destroy', ['mahasiswa'=>$value->id])}}" method="POST" style="display:inline">
            				    @csrf
            				    @method('DELETE')
            				    <a href=# ><button class="btn btn-default" type="submit" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
            				  </form>
                  @endif
                @endif
            	</div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="pl-3 my-2">
      <a href="{{'/listmahasiswa'}}"><button type="button" class="btn btn-primary">Download List Mahasiswa</button></a>
      <a href="{{'/mahasiswaexport'}}"><button type="button" class="btn btn-primary">Download List Mahasiswa</button></a>
    </div>
  </div>
</section>


@endsection