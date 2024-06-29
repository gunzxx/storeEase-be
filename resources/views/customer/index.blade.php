@extends('layout.main')

@section('content')
    <div class="content-header">
        <h1>{{ $title ?? 'Admin Dashboard' }}</h1>
    </div>

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
                            <p>{{ $key + 1 }}</p>
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
                                <a class="delete-button">
                                    <i data-id="{{ $customer->id }}" class="fas fa-trash"
                                        style="color: rgb(255, 98, 98);"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


@section('js')
    <script>
        $('.delete-button').click((e) => {
            const id = e.target.getAttribute('data-id');
            fetch(`/api/customer/${id}`, {
                    method: 'DELETE',
                })
                .then((res) => {
                    if(!res.ok){
                        return res.json().then(errData=>{
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
                    }).then(()=>{
                        location.reload();
                    })
                })
                .catch(err => {
                    console.log(err.message);
                    Swal.fire({
                        title: 'Gagal',
                        text: err.message,
                        icon: 'error',
                    });
                });
        });
    </script>
@endsection
