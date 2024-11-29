<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Register Form</title>
</head>
<body class="bg-primary">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="text-center mb-3 mt-2" style="font-family: 'Courier New', Courier, monospace">Register</h3>
                        <div style="text-align: center;">
                            <img src="{{asset('assets/images/auth/register.png')}}" alt="register_icon" width="160px">
                        </div>
                        <form action="/register" method="POST">
                            @csrf
                            <div class="mb-3 mx-4">
                                <label for="name" class="form-label" style="width: 100%; font-family: 'Courier New', Courier, monospace;">Username</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                                @error('name')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="mb-3 mx-4">
                                <label for="email" class="form-label" style="width: 100%; font-family: 'Courier New', Courier, monospace;">Email</label>
                                <input type="text" name="email" class="form-control" value="{{old('email')}}">
                                @error('email')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="mb-3 mx-4">
                                <label for="password" class="form-label" style="width: 100%;font-family: 'Courier New', Courier, monospace;">Password</label>
                                <input type="password" name="password" class="form-control">
                                @error('password')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="mx-4">
                                <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
                            </div>
                        </form>
                        <small class="d-block text-center mt-3">Sudah punya akun? <a href="/">Login disini</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
