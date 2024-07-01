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
                <input name="name" type="text" id="name" placeholder="Name" value="{{ old('name', $customer->name) }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <div class="form-input">
                <input name="email" type="email" id="email" placeholder="Email" value="{{ old('email', $customer->email) }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <div class="form-input">
                <input name="phone" type="text" id="phone" placeholder="phone" value="{{ old('phone', $customer->phone) }}">
                @error('phone')
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
