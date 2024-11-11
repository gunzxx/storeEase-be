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
                <input required name="name" type="text" id="name" placeholder="Name"
                    value="{{ old('name', $package->name) }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="price">Harga</label>
            <div class="form-input">
                <input required name="price" type="number" id="price" placeholder="price"
                    value="{{ old('price', $package->price) }}">
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group preview-img-form">
            <label for="preview_img">Preview</label>
            <div class="form-input">
                <input multiple="true" name="preview_img[]" type="file" accept="image/*" id="preview_img"
                    placeholder="preview_img" value="{{ old('preview_img') }}">
                @error('preview_img')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                @if ($package->hasMedia('preview_img'))
                    @foreach ($package->getMedia('preview_img') as $media)
                        <div class="preview-imgs">
                            <div class="preview-list">
                                <img src="{{ $media->getUrl() }}">
                                <button data-id="{{ $media->id }}" class="delete-media-button">
                                    <i class="fas fa-trash"
                                        style="color: rgb(255, 98, 98);"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
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
                        <option value="{{ $packageCategory->id }}"
                            {{ $packageCategory->id == $package->package_category_id ? 'selected' : '' }}>
                            {{ $packageCategory->name }}</option>
                    @endforeach
                </select>
                @error('packageCategory')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="service">Pilih Service</label>
            <div class="form-input">
                @foreach ($services as $service)
                    <label>
                        <input {{ in_array($service->id, $serviceCheck) ? 'checked' : '' }} type="checkbox" value="{{ $service->id }}" name="services[]" >{{ $service->name }}
                    </label>
                @endforeach
                @error('services')
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
        document.querySelectorAll('.delete-media-button').forEach(deleteButton => {
            deleteButton.addEventListener('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Hapus gambar?',
                    icon: 'question',
                    showCancelButton: true,
                }).then(answer => {
                    if (answer.isConfirmed) {
                        const id = event.target.getAttribute('data-id');
                        const token = getCookie('jwt');
                        console.log(token);
                        
                        fetch(`/api/preview-package/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                },
                            })
                            .then((res) => {
                                if (!res.ok) {
                                    return res.json().then(errData => {
                                        throw new Error(`Error: ${errData.message}`);
                                    });
                                }
                                return res.json()
                            })
                            .then((data) => {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: data.message,
                                    icon: 'success',
                                }).then(() => {
                                    location.reload();
                                })
                            })
                            .catch(err => {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: err.message,
                                    icon: 'error',
                                });
                            });
                    }
                })
            });
        });
    </script>
@endsection
