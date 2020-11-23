@extends ('layout.master')

@push('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush

@section ('title', 'List Jurusan')

@section ('content')

<section class="content">
	@if(session('success'))
		<div class="alert alert-success">
			{{session('success')}}
		</div>
	@endif
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">Tabel Jurusan</h3>
    <div class="card-tools">
     	<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="pl-3 my-2">
      @if (Auth::user()->getProfile)
        @if (Auth::user()->getProfile->status == "Admin")
         <a href="{{route('jurusan.create')}}"><button type="button" class="btn btn-primary">Create</button></a>
        @endif
      @endif
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>                  
          <tr>
            <th style="width: 10px">#</th>
            <th>Nama Jurusan</th>
            <th>Nama Fakultas</th>
            <th style="width: 160px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key => $value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->nama_jurusan}}</td>
            <td>{{$value->getFakultas->nama_fakultas}}</td>
            <td>
            	<div >
	            	<a href="{{route('jurusan.show', ['jurusan' => $value->id])}}"><button class="btn btn-default" title="Detail"><i class="fa fa-search-plus" aria-hidden="true"></i></button></a>
                @if (Auth::user()->getProfile)
                    @if (Auth::user()->getProfile->status == 'Admin')
                      <a href="{{route('jurusan.edit', ['jurusan'=> $value->id])}}"><button class="btn btn-default" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                      <form role="form" action="{{route('jurusan.destroy', ['jurusan'=>$value->id])}}" method="POST" style="display:inline">
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
      <a href="{{'/listjurusan'}}"><button type="button" class="btn btn-primary">Download List Jurusan</button></a>
      <a href="{{'/jurusanexport'}}"><button type="button" class="btn btn-primary">Download List Jurusan</button></a>
    </div>
  </div>
</section>


@endsection