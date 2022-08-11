@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-5 offset-3 mt-5">
                        <div class="mb-3">
                            <a href="{{ route('admin#profile') }}" class="text-decoration-none text-dark"><i
                                    class="fas fa-arrow-left"></i> back</a>
                        </div>
                        <div class="card">
                            <div class="card-header p-2">
                                <legend class="text-center">Change Password</legend>
                            </div>
                            <div class="card-body">
                                @if (Session::has('matchError'))
                                    <div class="alert alert-sm alert-danger alert-dismissible fade show mb-4">
                                        {{ Session::get('matchError') }}
                                        <span class="btn-close" data-bs-dismiss="alert"></span>
                                    </div>
                                @endif

                                @if (Session::has('sameError'))
                                    <div class="alert alert-sm alert-danger alert-dismissible fade show mb-4">
                                        {{ Session::get('sameError') }}
                                        <button class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if (Session::has('lengthError'))
                                    <div class="alert alert-sm alert-danger alert-dismissible fade show mb-4">
                                        {{ Session::get('lengthError') }}
                                        <button class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <form class="form-horizontal" action="{{ route('admin#changePassword') }}"
                                            method="POST">
                                            @csrf
                                            <div class="mb-3 row">
                                                <label class="col-3 form-label">Old Password</label>
                                                <div class="col-9">
                                                    <input type="password" name="oldPassword" class="form-control">
                                                    @if ($errors->has('oldPassword'))
                                                        <p class="text-danger">{{ $errors->first('oldPassword') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-2 row">
                                                <label class="col-3 form-label">New Password</label>
                                                <div class="col-9">
                                                    <input type="password" name="newPassword" class="form-control">
                                                    @if ($errors->has('newPassword'))
                                                        <p class="text-danger">{{ $errors->first('newPassword') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-2 row">
                                                <label class="col-3 form-label">Confirm Password</label>
                                                <div class="col-9">
                                                    <input type="password" name="confirmPassword" class="form-control">
                                                    @if ($errors->has('confirmPassword'))
                                                        <p class="text-danger">{{ $errors->first('confirmPassword') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="offset-3">
                                                <input type="submit" value="Change" class="btn btn-dark">
                                            </div>
                                        </form>
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
