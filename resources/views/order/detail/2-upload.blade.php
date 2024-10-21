@extends('layout.main')

@section('css')
    <link rel="stylesheet" href="/style/admin/form.css">
@endsection

@section('content')
    <div class="content-header">
        <a href="/order/{{ $order->uuid }}/detail">
            <i class="nav-icon fas fa-arrow-left"></i>
        </a>
        <h1>{{ $title ?? 'Admin Dashboard' }}</h1>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert-container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $error }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endforeach
    @endif

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

    <form method="POST" action="" class="form-container" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <div class="form-input">
                <input required name="name" type="text" id="name" placeholder="Name" value="{{ old('name') }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="document">Document</label>
            <div class="form-input">
                <input required name="document" type="file" accept="application/pdf" id="document"
                    placeholder="document">
                @error('document')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group other-type-form">
            <label for="type">Jenis Dokumen</label>
            <div class="form-input">
                <select name="type" id="type" class="select2">
                    <option value="Notulensi Rapat Perdana">Notulensi Rapat Perdana</option>
                    <option value="Desain Venue">Desain Venue</option>
                    <option value="Mou">MOU</option>
                    <option value="Invoice Down Payment">Invoice Down Payment</option>
                    <option value="Invoice Final Payment">Invoice Final Payment</option>
                    <option value="Desain Tata Ruang">Desain Tata Ruang</option>
                    <option value="Tata Acara(Rundown)">Tata Acara(Rundown)</option>
                    <option value="Laporan Akhir">Laporan Akhir</option>
                    <option value="other">Lain-lain</option>
                </select>
                <input style="display: none" type="text" name="other_type" id="other_type"
                    placeholder="Masukkan jenis dokumen">
                @error('type')
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
        document.getElementById('type').addEventListener('change', function(e) {
            const selectValue = e.target.value;
            const otherElement = document.getElementById('other_type');

            if (selectValue == 'other') {
                otherElement.style.display = 'inline';
                otherElement.required = true;
            } else {
                otherElement.style.display = 'none';
                otherElement.required = false;
            }
        });
    </script>
@endsection
