@extends('layout.main')

@section('css')
    <link rel="stylesheet" href="/style/admin/form.css">

    @session('token')
        <input type="hidden" id="jwttoken" value="{{ session('token') }}">
        <script>
            const token = document.getElementById('jwttoken').value;
            document.cookie = `jwt=${token}`;
        </script>
    @endsession
@endsection

@section('content')
    <div class="content-header">
        <h1>{{ $title ?? 'Admin Dashboard' }}</h1>
    </div>

    @session('success')
        <div class="alert-container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endsession

    <form method="POST" action="" class="form-container">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <div class="form-input">
                <input name="name" type="text" id="name" placeholder="Name" value="{{ $admin->name }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <div class="form-input">
                <input name="email" type="email" id="email" placeholder="Email" value="{{ $admin->email }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <div class="form-input">
                <input name="new_password" type="password" id="new_password" placeholder="Masukkan password baru">
                @error('new_password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="new_password_confirmation`">Confirm Password</label>
            <div class="form-input">
                <input name="new_password_confirmation" type="password" id="new_password_confirmation"
                    placeholder="Konfirmasi password baru">
                @error('new_password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button>Edit</button>
        </div>
    </form>
@endsection
