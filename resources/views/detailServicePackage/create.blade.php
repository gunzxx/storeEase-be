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
            <label for="package_id">Paket</label>
            <div class="form-input">
                <select name="package_id" id="package_id">
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}" >{{ $package->name }}</option>
                    @endforeach
                </select>
                @error('package_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="service_id">Service</label>
            <div class="form-input">
                <select name="service_id" id="service_id">
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" >{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('service_id')
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
