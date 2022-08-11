@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-8 offset-3 mt-5">
                        <div class="col-md-9">
                            <div class="mb-3">
                                <a href="{{ route('admin#' . $user->role . 'List') }}"
                                    class="text-decoration-none text-dark"><i class="fas fa-arrow-left"></i> back</a>
                            </div>
                            <div class="card">
                                <div class="card-header p-2">
                                    <legend class="text-center">Edit User Role</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <form class="form-horizontal" action="{{ route('admin#userChangeRole') }}"
                                                method="post">
                                                @csrf
                                                <div class="form-group row mb-4">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                                        <input type="text" name="name" class="form-control"
                                                            id="inputName" value="{{ $user->name }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label class="col-2 col-form-lable">Email</label>
                                                    <div class="col-10">
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{ $user->email }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label class="col-2 col-form-lable">Role</label>
                                                    <div class="col-10">
                                                        <select name="role" class="form-select">
                                                            @if ($user->role == 'admin')
                                                                <option value="admin" selected>Admin</option>
                                                                <option value="user">User</option>
                                                            @elseif ($user->role == 'user')
                                                                <option value="admin">Admin</option>
                                                                <option value="user" selected>User</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <input type="submit" value="Change" class="btn btn-dark">
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
