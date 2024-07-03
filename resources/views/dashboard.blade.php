<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SIPAIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <img src="{{ asset('logo pkm-kc.png') }}" alt="SIPAIR LOGO" class="img-fluid">
                </div>
                <div class="card-header text-center">
                    <h5>Selamat Datang</h5>
                    <h5>Nama: {{ $nama }}</h5>
                    <h5>No Rekam Medis: {{ $noRekamMedis }}</h5>
                </div>
                <div class="card-body text-center">
                    <a href="{{ url('/monitoring-realtime') }}" class="btn btn-info">Monitoring Realtime</a>
                    <br><br>
                    <a href="{{ url('/history') }}" class="btn btn-info">Lihat Riwayat</a>
                    <br><br>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
