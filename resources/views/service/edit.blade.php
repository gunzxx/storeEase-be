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
                <input required autofocus name="name" type="text" id="name" placeholder="Name"
                    value="{{ old('name', $product->name) }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <div class="form-input">
                <input required autofocus name="price" type="number" id="price" placeholder="Price"
                    value="{{ old('price', intVal($product->price)) }}">
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <div class="form-input">
                <select name="category_id" id="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $category->id ==  $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                    @error('category_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="vendor_id">Vendor</label>
            <div class="form-input">
                <select name="vendor_id" id="vendor_id">
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}"
                            {{ $vendor->id == $product->vendor_id ? 'selected' : '' }}>
                            {{ $vendor->name }}</option>
                    @endforeach
                    @error('vendor_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </select>
            </div>
        </div>
        <div class="form-group">
            <button>Edit</button>
        </div>
    </form>
@endsection
