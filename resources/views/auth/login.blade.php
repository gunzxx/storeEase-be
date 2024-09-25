<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - StoreEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/style/login.css">
</head>

<body>
    <div class="form-container">
        <img src="/img/logo.png" class="img-logo">
        <form action="" method="POST">
            @csrf
            <h1>Harap login terlebih dahulu</h1>
            @error('wrong')
                <span style="color: rgb(255, 98, 98);">{{ $message }}</span>
            @enderror
            <input type="text" name="email" id="email">
            <input type="password" name="password" id="password">
            <button>Login</button>
        </form>
    </div>
</body>

</html>
