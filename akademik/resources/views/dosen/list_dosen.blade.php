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
    <h3 class="card-title">Tabel Dosen</h3>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>                  
          <tr>
            <th style="width: 10px">#</th>
            <th>Nama Lengkap</th>
            <th>NIP</th>
            <th>Nama Jurusan</th>
            <th>Jabatan</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key => $value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->getProfile->nama_lengkap}}</td>
            <td>{{$value->nip}}</td>
            <td>{{$value->getJurusan->nama_jurusan}}</td>
            <td>{{$value->jabatan}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
</body>
</html>

