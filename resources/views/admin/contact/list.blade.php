@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-12">

                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title me-5 fs-3">
                                    Contact List
                                </h3>
                                <span class="d-inline-block mt-1 fs-5">Total -
                                    {{ $contact->total() }}</span>

                                <div class="card-tools mt-1 d-flex align-items-center">
                                    <a href="{{ route('admin#contactDownload') }}"
                                        class="btn btn-sm btn-success me-4">Download CSV</a>
                                    <form action="{{ route('admin#searchContact') }}" method="get">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="searchData" class="form-control float-right"
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($contact->toArray()['data'] == null)
                                            <tr>
                                                <td colspan="7">
                                                    <div class="text-muted">There is no contact data.</div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($contact as $item)
                                                <tr>
                                                    <td>{{ $item->contact_id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->message }}</td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-center text-dark">
                                    {{ $contact->links() }}
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
