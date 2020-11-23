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
  </section>
</body>
</html>