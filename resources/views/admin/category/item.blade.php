@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-8 mx-auto">
                        <div class="card mt-5">
                            <div class="card-header">
                                <h3 class="display-5 float-start">{{ $pizza[0]->categoryName }}</h3>
                                <div class="p-0">
                                    <p class="fs-5 float-end m-3">Total - {{ $pizza->total() }}</p>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Pizza Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pizza as $item)
                                            <tr>
                                                <td>{{ $item->pizza_id }}</td>
                                                <td>
                                                    <img src="{{ asset('uploads/' . $item->image) }}" alt=""
                                                        width="100" height="75">
                                                </td>
                                                <td>{{ $item->pizza_name }}</td>
                                                <td>{{ $item->price }} Kyats</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-center text-dark">
                                    {{ $pizza->links() }}
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('admin#category') }}" class="btn btn-dark btn-sm">Back</a>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
