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
                                <h3 class="card-title">
                                    <div class="fs-4 ms-3">Total - {{ $order->total() }}</div>
                                </h3>

                                <div class="card-tools mt-1 d-flex align-items-center">
                                    <a href="{{ route('admin#orderDownload') }}"
                                        class="btn btn-sm btn-success me-4">Download CSV</a>
                                    <form action="{{ route('admin#orderSearch') }}" method="get">
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
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Pizza Name</th>
                                            <th>Pizza Count</th>
                                            <th>Payment With</th>
                                            <th>Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($order->toArray()['data'] == null)
                                            <tr>
                                                <td colspan="7">
                                                    <div class="text-muted">There is no order yet.</div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($order as $item)
                                                <tr>
                                                    <td>{{ $item->order_id }}</td>
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ $item->pizza_name }}</td>
                                                    <td>{{ $item->count }}</td>
                                                    <td>
                                                        @if ($item->payment_status == 1)
                                                            Credit Card
                                                        @elseif ($item->payment_status == 2)
                                                            Cash
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->order_time }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-center text-dark">
                                    {{ $order->links() }}
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
