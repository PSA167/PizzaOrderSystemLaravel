@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (Session::has('successCreate'))
                    <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                        {{ Session::get('successCreate') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('deleteSuccess'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ Session::get('deleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('updateSuccess'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ Session::get('updateSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('pizzaError'))
                    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                        {{ Session::get('pizzaError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin#addCategory') }}" class="btn btn-sm btn-outline-dark">Add
                                        Category</a>
                                </h3>
                                <span class="d-inline-block ms-4 fs-5">Total - {{ $category->total() }}</span>

                                <div class="card-tools mt-1 d-flex align-items-center">
                                    <a href="{{ route('admin#categoryDownload') }}"
                                        class="btn btn-sm btn-success me-3">Download CSV</a>
                                    <form action="{{ route('admin#searchCategory') }}" method="get">
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
                                            <th>Category Name</th>
                                            <th>Product Count</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($category->toArray()['data'] == null)
                                            <tr>
                                                <td colspan="7">
                                                    <div class="text-muted">There is no category data.</div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($category as $item)
                                                <tr>
                                                    <td>{{ $item->category_id }}</td>
                                                    <td>{{ $item->category_name }}</td>
                                                    <td>
                                                        @if ($item->count == 0)
                                                            <a href="#" class="fs-none">{{ $item->count }}</a>
                                                        @else
                                                            <a href="{{ route('admin#categoryItem', $item->category_id) }}"
                                                                class="fs-none">{{ $item->count }}</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin#editCategory', $item->category_id) }}"
                                                            class="btn btn-sm bg-dark text-white"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="{{ route('admin#deleteCategory', $item->category_id) }}"
                                                            class="btn btn-sm bg-danger text-white"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-center text-dark">
                                    {{ $category->links() }}
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
