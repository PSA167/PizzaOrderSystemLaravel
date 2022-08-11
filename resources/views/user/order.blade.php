@extends('user.layout.app')

@section('content')
    <div class="row my-5 justify-content-center gx-5">

        <div class="col-10 col-md-4 img-detail">
            <img src="{{ asset('uploads/' . $pizza->image) }}" class="img-thumbnail w-100 h-75"
                style="background-position: center; background-size:cover; background-repeat:no-repeat;"> <br>

            <a href="{{ route('user#index') }}" class="d-block">
                <button class="btn bg-dark text-white" style="margin-top: 20px;">
                    <i class="fas fa-backspace"></i> Back
                </button>
            </a>
        </div>
        <div class="col-10 col-md-6">
            @if (Session::has('orderSuccess'))
                <div class="alert alert-success alert-dismissible mb-3">
                    Order Success! Please wait {{ Session::get('orderSuccess') }} Minutes...
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <h4>Name</h4>
            <small>{{ $pizza->pizza_name }}</small>
            <hr>
            <h4>Price</h4>
            <small>{{ $pizza->price - $pizza->discount_price }} Kyats</small>
            <hr>
            <h4>Waiting Time</h4>
            <small>{{ $pizza->waiting_time }} Minutes</small>
            <hr>
            <form action="{{ route('user#orderCreate') }}" method="post">
                @csrf
                <h4>Pizza Count</h4>
                <input type="number" name="pizzaCount" id="" class="form-control"
                    placeholder="Number of pizza that you want to order." value="{{ old('pizzaCount') }}">
                @if ($errors->has('pizzaCount'))
                    <small class="text-danger">{{ $errors->first('pizzaCount') }}</small>
                @endif
                <hr>

                <h4>Payment Type</h4>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Credit Card</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">Cash</label>
                </div>
                @if ($errors->has('paymentType'))
                    <small class="text-danger d-block">{{ $errors->first('paymentType') }}</small>
                @endif
                <br><br>
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-shopping-cart"></i>
                    Place Order</button>
            </form>
        </div>
    </div>
@endsection
