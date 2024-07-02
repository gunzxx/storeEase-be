@extends('layout.main')

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

    <div class="table-container">
        <div class="btn-back">
            <a href="/order">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Harga Produk</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                    <tr>
                        <td>
                            <p>{{ $key + 1 }}</p>
                        </td>
                        <td>
                            <a href="/{{ "product/{$order->product->id}/edit" }}">{{ $order->product->name }}</a>
                        </td>
                        <td>
                            <p>Rp. {{ number_format($order->product->price, 0, 2, '.') }}</p>
                        </td>
                        <td>
                            <p>{{ $order->quantity }}</p>
                        </td>
                        <td>
                            <p>Rp. {{ number_format($order->total_price, 0, 2, '.') }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection