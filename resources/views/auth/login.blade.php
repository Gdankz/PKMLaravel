<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIPAIR</title>
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
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger text-center" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="mb-3 text-center">
                            <label for="noRekamMedis" class="form-label">No Rekam Medis</label>
                            <input type="text" class="form-control" id="noRekamMedis" name="noRekamMedis" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                            <br>
                            <a href="{{ url('/register') }}" class="btn btn-link">Belum Terdaftar? Buat Akun</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
