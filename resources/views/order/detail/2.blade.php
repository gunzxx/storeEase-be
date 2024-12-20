@extends('layout.main')

@section('css')
    <link rel="stylesheet" href="/style/admin/order.css">
@endsection

@section('content')
    <div class="content-header">
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

    <div class="detail-order-container">
        <div class="side left-side">
            <div class="wedding-date-container">
                <p>Tanggal Pernikahan</p>
                <h1>{{ $order->wedding_date }}</h1>
            </div>
            <div class="customer-bio">
                <h1>BIODATA CUSTOMER</h1>
                <div class="customer-data">
                    <img src="{{ $order->customer->getFirstMediaUrl('profile_img') != '' ? $order->customer->getFirstMediaUrl('profile_img') : '/img/profile/default.png' }}"
                        alt="" class="customer-img">
                    <div class="customer-detail">
                        <p>Nama: {{ $order->customer->name }}</p>
                        <p>Alamat: {{ $order->customer->address }}</p>
                    </div>
                </div>
            </div>
            <div class="package-data">
                <h1>PAKET YANG DIPILIH</h1>
                @if ($package->getMedia('preview_img')->count() > 0)
                    <div class="preview-package">
                        @foreach ($package->getMedia('preview_img') as $preview)
                            {{ $preview }}
                        @endforeach
                    </div>
                @endif
                <div class="package-description">
                    <p>
                        {!! $package->description !!}
                    </p>
                </div>
            </div>
            @if ($order->document->count() > 0)
                <div class="order-file order-document">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Dokumen</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->document as $key => $document)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $document->name }}</td>
                                    <td>{{ $document->type }}</td>
                                    <td class="action">
                                        @foreach ($document->media as $media)
                                            <a target="_blank" href="{{ $media->getUrl() }}">lihat</a>
                                            <a href="/order/{{ $order->uuid }}/{{ $media->collection_name }}">perbarui</a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="side right-side">
            @csrf
            <span class="order-status">
                {{ $order->statusOrder->name }}
            </span>
            <a href="/order/{{ $order->uuid }}/first_meet" class="order-action">Unggah File Notulensi Rapat Perdana</a>
            <a href="/order/{{ $order->uuid }}/to3" class="next-button">Lanjut ke tahap PEMBAYARAN AWAL</a>
        </div>
    </div>
@endsection
