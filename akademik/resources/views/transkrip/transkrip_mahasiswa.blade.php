<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIM AKADEMIK</title>
</head>
<body>
  <section class="content">
    <div class="card">
      <div class="card-header">
      <h3 class="card-title">Transkrip {{$data['0']->getMahasiswa->nim}} - {{$data['0']->getMahasiswa->getProfile->nama_lengkap}}</h3>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>                  
            <tr>
              <th style="width: 10px">#</th>
              <th>Kelas</th>
              <th>Tahun Ajaran</th>
              <th>Nilai</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $key => $value)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$value->getKelas->mata_kuliah}}</td>
              <td>{{$value->tahun_ajaran}}</td>
              <td>{{$value->nilai}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>
</html>
