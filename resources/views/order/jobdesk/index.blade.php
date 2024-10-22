@extends('layout.main')

@section('css')
    <link rel="stylesheet" href="/style/admin/jobdesk.css">
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

    <div class="jobdesk-container">
        <div class="jobdesk-container-header">
            <h1>{{ $order->statusOrder->name }}</h1>
            <div class="last-update">
                <p>Terakhir Dirubah</p>
                <p>{{ $order->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="jobdesk-list">
            <a href="/order/{{ $order->uuid }}/job-desk/{{ $jobDesk->id }}/create" class="jobdesk-create">
                Baru
                <i class="nav-icon fas fa-plus"></i>
            </a>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pekerjaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>Diperbarui Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobLists as $key => $jobList)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $jobList->name }}</td>
                            <td>
                                <input data-joblist-id="{{ $jobList->id }}" class="joblist-status" type="checkbox"
                                    {{ $jobList->finished ? 'checked' : '' }}>
                            </td>
                            <td class="action">
                                <a href="/order/{{ $order->uuid }}/job-desk/{{ $jobDesk->id }}/job-list/{{ $jobList->id }}">Perbarui</a>
                                <a data-id="{{ $jobList->id }}" class="delete-button">Hapus</a>
                            </td>
                            <td>{{ $jobList->updated_at->format('d F Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('js')
    <script>
        const token = getCookie('jwt');
        const jobListStatus = document.querySelectorAll('.joblist-status');

        jobListStatus.forEach(jobListStatusElemen => {
            jobListStatusElemen.addEventListener('change', function(event) {
                const jobListId = event.target.getAttribute('data-joblist-id');
                const jobListStatus = event.target.checked;
                console.log(jobListStatus);


                fetch(`/api/job-list/${jobListId}`, {
                        method: 'PUT',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json', // Ternyata kita perlu menambahkan content-type ygy agar data kita terbaca sebagai JSON
                        },
                        body: JSON.stringify({
                            finished: jobListStatus,
                        }),
                    })
                    .then((res) => {
                        if (!res.ok) {
                            return res.json().then(errData => {
                                console.log(errData);
                                throw new Error(`Error: ${errData.message}`);
                            });
                        }

                        return res.json()
                    })
                    .then((data) => {
                        console.log(data);
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
            });
        });
    </script>
    <script>
        $('.delete-button').click((e) => {
            const id = e.target.getAttribute('data-id');
            console.log(id);            

            Swal.fire({
                title: 'Hapus',
                text: 'Hapus pekerjaan?',
                icon: 'question',
                showCancelButton: true,
            }).then(answer => {
                if (answer.isConfirmed) {
                    const token = getCookie('jwt');
                    fetch(`/api/job-list/${id}`, {
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
    </script>
@endsection
