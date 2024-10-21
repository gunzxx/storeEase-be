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
        </div>
        <form class="side right-side" action="/order/{{ $order->uuid }}/to2" method="POST">
            @csrf
            <span class="order-status">
                {{ $order->statusOrder->name }}
            </span>
            <input type="datetime-local" required name="meeting_date" id="meeting_date" class="meeting-date">
            <button class="next-button">Lanjut ke tahap RAPAT PERDANA</button>
        </form>
    </div>
@endsection
