@extends('layout.main')

@section('content')
    <div class="content-header">
        <h1>{{ $title ?? 'Admin Dashboard' }}</h1>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $key => $customer)
                <tr>
                    <td>
                        <p>{{ $key+1 }}</p>
                    </td>
                    <td>
                        <p>{{ $customer->name }}</p>
                    </td>
                    <td>
                        <p>{{ $customer->email }}</p>
                    </td>
                    <td>
                        <p>{{ $customer->phone }}</p>
                    </td>
                    <td>
                        <div class="action-container">
                            <a href="/customer/{{ $customer->id }}/edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a>
                                <i class="fas fa-trash" style="color: rgb(255, 98, 98);"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection