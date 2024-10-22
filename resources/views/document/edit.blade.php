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
                    value="{{ old('name', $document->name) }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="document">Document</label>
            <div class="form-input">
                <input name="document" type="file" accept="application/pdf" id="document" placeholder="document">
                @error('document')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group other-type-form">
            <label for="type">Jenis Dokumen</label>
            <div class="form-input">
                <select name="type" id="type" class="select2">
                    <option {{ $document->type == "Notulensi Rapat Perdana" ? "selected" : '' }} value="Notulensi Rapat Perdana" >Notulensi Rapat Perdana</option>
                    <option {{ $document->type == "Desain Venue" ? "selected" : '' }} value="Desain Venue" >Desain Venue</option>
                    <option {{ $document->type == "MOU" ? "selected" : '' }} value="MOU" >MOU</option>
                    <option {{ $document->type == "Invoice Down Payment" ? "selected" : '' }} value="Invoice Down Payment" >Invoice Down Payment</option>
                    <option {{ $document->type == "Invoice Final Payment" ? "selected" : '' }} value="Invoice Final Payment" >Invoice Final Payment</option>
                    <option {{ $document->type == "Desain Tata Ruang" ? "selected" : '' }} value="Desain Tata Ruang" >Desain Tata Ruang</option>
                    <option {{ $document->type == "Tata Acara(Rundown)" ? "selected" : '' }} value="Tata Acara(Rundown)" >Tata Acara(Rundown)</option>
                    <option {{ $document->type == "Laporan Akhir" ? "selected" : '' }} value="Laporan Akhir" >Laporan Akhir</option>
                    <option {{ !in_array($document->type, $options) ? "selected" : "" }} value="other" >Lain-lain</option>
                </select>
                <input style="display: {{ in_array($document->type, $options) ? "none" : "block" }}"
                    @if (!in_array($document->type, $options)) 
                        value="{{ e($document->type) }}" 
                    @endif
                    type="text" name="other_type" id="other_type" placeholder="Masukkan jenis dokumen">
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
        document.getElementById('type').addEventListener('change', function(e){
            const selectValue = e.target.value;
            const otherElement = document.getElementById('other_type');
            
            if(selectValue == 'other'){
                otherElement.style.display = 'inline';
                otherElement.required = true;
            }else{
                otherElement.style.display = 'none';
                otherElement.value = '';
                otherElement.required = false;
            }
        });
    </script>
@endsection