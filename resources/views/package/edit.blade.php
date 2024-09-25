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
                <input required name="name" type="text" id="name" placeholder="Name" value="{{ old('name', $package->name) }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <div class="form-input">
                <input required name="price" type="number" id="price" placeholder="price" value="{{ old('price', $package->price) }}">
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="detail">Phone</label>
            <div class="form-input">
                <textarea name="detail" id="detail" cols="30" rows="10">{{ old('detail', $package->detail) }}</textarea>
                {{-- <input required name="detail" type="text" id="detail" placeholder="Detail" value="{{ old('detail', $package->detail) }}"> --}}
                @error('detail')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button>Edit</button>
        </div>
    </form>
@endsection

@section('js')
    <script>
        CKEDITOR.replace('detail');
    </script>
@endsection
