@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (Session::has('createSuccess'))
                    <div class="alert alert-success alert-dismissible fade show mt-3">
                        {{ Session::get('createSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (Session::has('updateSuccess'))
                    <div class="alert alert-warning alert-dismissible fade show mt-3">
                        {{ Session::get('updateSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (Session::has('deleteSuccess'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3">
                        {{ Session::get('deleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <a href="{{ route('admin#createPizza') }}" class="btn btn-sm btn-dark"><i
                                            class="fas fa-plus"></i></a>
                                </div>
                                <span class="d-inline-block ms-4 fs-5">Total - {{ $pizza->total() }}</span>
                                <div class="card-tools mt-1 d-flex align-items-center">
                                    <a href="{{ route('admin#pizzaDownload') }}"
                                        class="btn btn-sm btn-success me-3">Download CSV</a>
                                    <form action="{{ route('admin#searchPizza') }}" method="get">
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
                                            <th>Pizza Name</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Publish Status</th>
                                            <th>Buy 1 Get 1 Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if ($pizza->toArray()['data'] == null || $status == 0)
                                            <tr>
                                                <td colspan="7">
                                                    <div class="text-muted">There is no pizza data.</div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($pizza as $item)
                                                <tr>
                                                    <td>{{ $item->pizza_id }}</td>
                                                    <td>{{ $item->pizza_name }}</td>
                                                    <td>
                                                        <div style="height: 75px">
                                                            <img src="{{ asset('uploads/' . $item->image) }}"
                                                                class="img-thumbnail h-100" width="100px">
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->price }} kyats</td>
                                                    <td>
                                                        @if ($item->publish_status == 1)
                                                            Yes
                                                        @elseif ($item->publish_status == 0)
                                                            No
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->buy_one_get_one_status == 1)
                                                            Yes
                                                        @elseif ($item->buy_one_get_one_status == 0)
                                                            No
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin#editPizza', $item->pizza_id) }}"
                                                            class="btn btn-sm bg-dark text-white"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="{{ route('admin#deletePizza', $item->pizza_id) }}"
                                                            class="btn btn-sm bg-danger text-white"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                        <a href="{{ route('admin#infoPizza', $item->pizza_id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $pizza->links() }}
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
