@extends('layout.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Dashboard</div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <img class="img-fluid" src="{{asset('/adminlte/dist/img/akademik_public_adminlte_dist_img_LogoUniversitas.jpg')}}" alt="">
                    <p>Selamat datang di SIM Akademik Universitas XYZ
                            @auth
                            {{Auth::user()->username}}
                            @endauth
                    </p> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
