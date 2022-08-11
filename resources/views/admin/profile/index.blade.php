@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-8 offset-3 mt-5">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <legend class="text-center">User Profile</legend>
                                </div>
                                <div class="card-body">
                                    @if (Session::has('updateSuccess'))
                                        <div class="alert alert-sm alert-warning alert-dismissible fade show"
                                            role="alert">
                                            {{ Session::get('updateSuccess') }}
                                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if (Session::has('changePwdSuccess'))
                                        <div class="alert alert-sm alert-warning alert-dismissible fade show"
                                            role="alert">
                                            {{ Session::get('changePwdSuccess') }}
                                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <form class="form-horizontal"
                                                action="{{ route('admin#updateProfile', $user->id) }}" method="post">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="name" class="form-control"
                                                            id="inputName" value="{{ old('name', $user->name) }}">
                                                        @if ($errors->has('name'))
                                                            <div class="text-danger fs-sm">{{ $errors->first('name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" name="email" class="form-control"
                                                            id="inputEmail" value="{{ old('email', $user->email) }}">
                                                        @if ($errors->has('email'))
                                                            <div class="text-danger fs-sm">{{ $errors->first('email') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" name="phone" class="form-control"
                                                            id="inputPhone" value="{{ old('phone', $user->phone) }}">
                                                        @if ($errors->has('phone'))
                                                            <div class="text-danger fs-sm">{{ $errors->first('phone') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputAddress"
                                                        class="col-sm-2 col-form-label">Address</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="address" class="form-control"
                                                            id="inputAddress"
                                                            value="{{ old('address', $user->address) }}">
                                                        @if ($errors->has('address'))
                                                            <div class="text-danger fs-sm">
                                                                {{ $errors->first('address') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <a href="{{ route('admin#changePasswordPage') }}">Change
                                                            Password</a>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit"
                                                            class="btn bg-dark text-white">Update</button>
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
