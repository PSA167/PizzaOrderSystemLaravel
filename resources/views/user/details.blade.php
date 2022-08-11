@extends('user.layout.app')

@section('content')
    <div class="row my-5 justify-content-center g-2">

        <div class="col-10 col-md-4 img-detail">
            <img src="{{ asset('uploads/' . $pizza->image) }}" class="img-thumbnail w-100 h-75"
                style="background-position: center; background-size:cover; background-repeat:no-repeat;"> <br>
            <a href="{{ route('user#orderPage') }}" class="btn btn-primary mt-2 col-12"><i class="fas fa-shopping-cart"></i>
                Buy</a>
            <a href="{{ route('user#index') }}" class="d-block">
                <button class="btn bg-dark text-white" style="margin-top: 20px;">
                    <i class="fas fa-backspace"></i> Back
                </button>
            </a>
        </div>
        <div class="col-12 col-md-6">
            <div class="row gx-5 mb-3">
                <div class="col-5 col-md-4 text-end">
                    <h4 class="">Name</h4>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <p class="fs-5">{{ $pizza->pizza_name }}</p>
                </div>
            </div>

            <div class="row g-5 mb-3">
                <div class="col-5 col-md-4 text-end">
                    <h4 class="">Price</h4>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <p class="fs-5">{{ $pizza->price }} Kyats</p>
                </div>
            </div>

            <div class="row g-5 mb-3">
                <div class="col-5 col-md-4 text-end">
                    <h4 class="">Discount Price</h4>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <p class="fs-5">{{ $pizza->discount_price }} Kyats</p>
                </div>
            </div>

            <div class="row g-5 mb-3">
                <div class="col-5 col-md-4 text-end">
                    <h4 class="">Buy One Get One</h4>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <p class="fs-5">
                        @if ($pizza->buy_one_get_one_status == 1)
                            Have
                        @else
                            Not Have
                        @endif
                    </p>
                </div>
            </div>

            <div class="row g-5 mb-3">
                <div class="col-5 col-md-4 text-end">
                    <h4 class="">Waiting Time</h4>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <p class="fs-5">{{ $pizza->waiting_time }} minutes</p>
                </div>
            </div>

            <div class="row g-5 mb-3">
                <div class="col-5 col-md-4 text-end">
                    <h4 class="">Description</h4>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <p class="fs-5">{{ $pizza->description }}</p>
                </div>
            </div>

            <div class="row g-5 mb-3">
                <div class="col-5 col-md-4 text-end">
                    <h3 class="text-danger display-5">Total Price</h3>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <p class="display-5 text-success">{{ $pizza->price - $pizza->discount_price }} Kyats</p>
                </div>
            </div>
        </div>
    </div>
@endsection
