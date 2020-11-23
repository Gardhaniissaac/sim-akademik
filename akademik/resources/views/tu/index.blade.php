@extends ('layout.master')

@push('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush

@section ('title', 'List Staff Tata Usaha')

@section ('content')

<section class="content">
	@if(session('success'))
		<div class="alert alert-success">
			{{session('success')}}
		</div>
	@endif
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">Tabel Staff Tata Usaha</h3>
    <div class="card-tools">
     	<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="pl-3 my-2">
      @if (Auth::user()->getProfile)
        @if (Auth::user()->getProfile->status == 'Tu' && count($terdaftar) == 0)
          <a href="{{route('tu.create')}}"><button type="button" class="btn btn-primary">Create</button></a>
        @endif
      @endif
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>                  
          <tr>
            <th style="width: 10px">#</th>
            <th>Nama Lengkap</th>
            <th>Nama Jurusan</th>
            <th style="width: 160px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key => $value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->getProfile->nama_lengkap}}</td>
            <td>{{$value->getJurusan->nama_jurusan}}</td>
            <td>
            	<div >
	            	<a href="{{route('tu.show', ['tu' => $value->id])}}"><button class="btn btn-default" title="Detail"><i class="fa fa-search-plus" aria-hidden="true"></i></button></a>
                @if (Auth::user()->getProfile)
                  @if (Auth::user()->getProfile->status == 'Tu' && Auth::user()->getProfile->id == $value->profile_id)
                    <a href="{{route('tu.edit', ['tu'=> $value->id])}}"><button class="btn btn-default" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                     <form role="form" action="{{route('tu.destroy', ['tu'=>$value->id])}}" method="POST" style="display:inline">
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
      <a href="{{'/listtu'}}"><button type="button" class="btn btn-primary">Download List Tata Usaha</button></a>
      <a href="{{'/tuexport'}}"><button type="button" class="btn btn-primary">Download List Tata Usaha</button></a>
    </div>
  </div>
</section>


@endsection