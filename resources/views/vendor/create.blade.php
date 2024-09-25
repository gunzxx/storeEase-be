@extends('layout.main')

@section('css')
    <link rel="stylesheet" href="/style/admin/form.css">
@endsection

@section('content')
    <div class="content-header">
        <h1>{{ $title ?? 'Admin Dashboard' }}</h1>
    </div>

    <form method="POST" action="" class="form-container">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <div class="form-input">
                <input required autofocus name="name" type="text" id="name" placeholder="Name" value="{{ old('name') }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <div class="form-input">
                <input required name="email" type="email" id="email" placeholder="Email" value="{{ old('email') }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <div class="form-input">
                <input required name="phone" type="text" id="phone" placeholder="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="form-input">
                <input name="password" type="password" id="password" placeholder="Masukkan password baru">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirmation`">Confirm Password</label>
            <div class="form-input">
                <input name="password_confirmation" type="password" id="password_confirmation"
                    placeholder="Konfirmasi password baru">
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button>Save</button>
        </div>
    </form>
@endsection
