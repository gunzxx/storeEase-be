@extends('layout.main')

@section('css')
    <link rel="stylesheet" href="/style/admin/form.css">
@endsection

@section('content')
    <div class="content-header">
        <h1>{{ $title ?? 'Admin Dashboard' }}</h1>
    </div>

    <form method="POST" action="" class="form-container" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <div class="form-input">
                <input required name="name" type="text" id="name" placeholder="Name" value="{{ old('name', $package->name) }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="price">Harga</label>
            <div class="form-input">
                <input required name="price" type="number" id="price" placeholder="price" value="{{ old('price', $package->price) }}">
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="preview_img">Preview</label>
            <div class="form-input">
                <input required multiple="true" name="preview_img[]" type="file" accept="image/*" id="preview_img" placeholder="preview_img" value="{{ old('preview_img') }}">
                @error('preview_img')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <div class="form-input">
                <textarea name="description" id="description" cols="30" rows="10">{{ old('description', $package->description) }}</textarea>
                @error('description')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="packageCategory">Kategori Paket</label>
            <div class="form-input">
                <select name="packageCategory" id="packageCategory">
                    @foreach ($packageCategories as $packageCategory)
                        <option value="{{ $packageCategory->id }}" {{ $packageCategory->id == $package->package_category_id ? 'selected' : '' }}>{{ $packageCategory->name }}</option>
                    @endforeach
                </select>
                @error('packageCategory')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button>Simpan</button>
        </div>
    </form>
@endsection

@section('js')
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
