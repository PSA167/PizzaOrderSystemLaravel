@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-8 offset-3 mt-5">
                        <div class="col-md-9">
                            <div class="mb-3">
                                <a href="{{ route('admin#category') }}" class="text-decoration-none text-dark"><i
                                        class="fas fa-arrow-left"></i> back</a>
                            </div>
                            <div class="card">
                                <div class="card-header p-2">
                                    <legend class="text-center">Update Category</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <form class="form-horizontal" action="{{ route('admin#updateCategory') }}"
                                                method="post">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="hidden" name="id"
                                                            value="{{ $category->category_id }}">
                                                        <input type="text" name="name" class="form-control"
                                                            id="inputName"
                                                            value="{{ old('name', $category->category_name) }}">
                                                        @if ($errors->has('name'))
                                                            <small
                                                                class="text-danger">{{ $errors->first('name') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <input type="submit" value="Update" class="btn btn-dark">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
