@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-12 my-3">
                        <a href="{{ route('admin#userList') }}" class="btn btn-outline-dark float-end">Go To User
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
                        @if (Session::has('errorChange'))
                            <div class="alert alert-warning alert-dismissible mb-3">
                                {{ Session::get('errorChange') }}
                                <div class="btn btn-close" data-bs-dismiss="alert"></div>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fs-3">Admin List</h3>
                                <span class="d-inline-block ms-5 mt-1 fs-5">Total - {{ $admin->total() }}</span>
                                <div class="card-tools d-flex align-items-center mt-1">
                                    <a href="{{ route('admin#adminDownload') }}"
                                        class="btn btn-sm btn-success me-4">Download CSV</a>
                                    <form action="{{ route('admin#adminSearch') }}" method="get">
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
                                            <th>Admin Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($admin->toArray()['data'] == null)
                                            <tr>
                                                <td colspan="7">
                                                    <div class="text-muted">There is no user yet.</div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($admin as $item)
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
                                    {{ $admin->links() }}
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
