@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-12 my-3">
                        <a href="{{ route('admin#adminList') }}" class="btn btn-outline-dark float-end">Go To Admin
                            List</a>
                    </div>
                    <div class="col-12">
                        @if (Session::has('deleteSuccess'))
                            <div class="alert alert-danger alert-dismissible mb-3">
                                {{ Session::get('deleteSuccess') }}
                                <div class="btn btn-close" data-bs-dismiss="alert"></div>
                            </div>
                        @endif
                        @if (Session::has('changeRole'))
                            <div class="alert alert-success alert-dismissible mb-3">
                                {{ Session::get('changeRole') }}
                                <div class="btn btn-close" data-bs-dismiss="alert"></div>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center card-title">
                                    <div class="fs-2">User List</div>
                                    <div class="ms-5 mt-1 fs-5"> Total - {{ $user->total() }}</div>
                                </div>

                                <div class="card-tools d-flex align-items-center mt-2">
                                    <a href="{{ route('admin#userDownload') }}" class="btn btn-success btn-sm me-3">Download
                                        CSV</a>
                                    <form action="{{ route('admin#userSearch') }}" method="get">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="tableSearch" class="form-control float-right"
                                                placeholder="Search">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($user->toArray()['data'] == null)
                                            <tr>
                                                <td colspan="7">
                                                    <div class="text-muted">There is no user yet.</div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($user as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td>{{ $item->address }}</td>
                                                    <td>
                                                        <a href="{{ route('admin#userEdit', $item->id) }}"
                                                            class="btn btn-sm btn-dark"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('admin#userDelete', $item->id) }}"
                                                            class="btn btn-sm bg-danger text-white"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-center text-dark">
                                    {{ $user->links() }}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
