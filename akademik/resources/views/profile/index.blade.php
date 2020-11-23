@extends ('layout.master')

@push('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush

@section ('title', 'List Profile')

@section ('content')

<section class="content">
	@if(session('success'))
		<div class="alert alert-success">
			{{session('success')}}
		</div>
	@endif
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">Table Profile</h3>
    <div class="card-tools">
     	<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="pl-3 my-2">
      @if (count($data) == 0 || Auth::user()->getProfile->status == 'Admin')
    	<a href="{{route('profile.create')}}"><button type="button" class="btn btn-primary">Create</button></a>
      @endif
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>                  
          <tr>
            <th style="width: 10px">#</th>
            <th>Nama Lengkap</th>
            <th>Status</th>
            <th style="width: 160px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key => $value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->nama_lengkap}}</td>
            <td>{{$value->status}}</td>
            <td>
            	<div >
	            	<a href="{{route('profile.show', ['profile' => $value->id])}}"><button class="btn btn-default" title="Detail"><i class="fa fa-search-plus" aria-hidden="true"></i></button></a>
	            	<a href="{{route('profile.edit', ['profile'=> $value->id])}}"><button class="btn btn-default" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
					<form role="form" action="{{route('profile.destroy', ['profile'=>$value->id])}}" method="POST" style="display:inline">
				        @csrf
				        @method('DELETE')
				        <a href=# ><button class="btn btn-default" type="submit" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
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