@extends ('layout.master')

@push('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush

@section ('title', 'List Rencana Studi')

@section ('content')

<section class="content">
	@if(session('success'))
		<div class="alert alert-success">
			{{session('success')}}
		</div>
	@endif
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">Tabel Rencana Studi</h3>
    <div class="card-tools">
     	<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="pl-3 my-2">
      @if (Auth::user()->getProfile)
        @if (Auth::user()->getProfile->status == 'Mahasiswa')
    	<a href="{{route('rencana.create')}}"><button type="button" class="btn btn-primary">Create</button></a>
      @endif
      @endif
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>                  
          <tr>
            <th style="width: 10px">#</th>
            <th>Mahasiswa</th>
            <th>Tahun Ajaran</th>
            <th>Status</th>
            <th style="width: 160px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key => $value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->getMahasiswa->nim}}  {{$value->getMahasiswa->getProfile->nama_lengkap}}</td>
            <td>{{$value->tahun_ajaran}}</td>
            <td>{{$value->status}}</td>
            <td>
            	<div >
	            	<a href="{{route('rencana.show', ['rencana' => $value->id])}}"><button class="btn btn-default" title="Detail"><i class="fa fa-search-plus" aria-hidden="true"></i></button></a>
                @if (Auth::user()->getProfile)
                  @if (Auth::user()->getProfile->status == 'Dosen'||(Auth::user()->getProfile->status == 'Mahasiswa' && ($value->status == 'Submitted' || $value->status == 'Rejected') )||Auth::user()->getProfile->status == 'Tu')
	            	  <a href="{{route('rencana.edit', ['rencana'=> $value->id])}}"><button class="btn btn-default" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                  @endif
                @endif
					<form role="form" action="{{route('rencana.destroy', ['rencana'=>$value->id])}}" method="POST" style="display:inline">
				        @csrf
				        @method('DELETE')
                @if (Auth::user()->getProfile)
                  @if ((Auth::user()->getProfile->status == 'Mahasiswa' && ($value->status == 'Submitted' || $value->status == 'Rejected') )||Auth::user()->getProfile->status == 'Tu')
				        <a href=# ><button class="btn btn-default" type="submit" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                  @endif
                @endif
				    </form>
            	</div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>


@endsection