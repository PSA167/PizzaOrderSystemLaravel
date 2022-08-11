@extends('user.layout.app')


@section('content')
    <!-- Page Content-->
    <div class="container px-5" id="home">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center py-5">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0 shake" id="code-lab-pizza"
                    src="https://www.pizzamarumyanmar.com/wp-content/uploads/2019/04/chigago.jpg" alt="..." />
            </div>
            <div class="col-lg-5" id="about">
                <h1 class="font-weight-light">CODE LAB Pizza</h1>
                <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it,
                    but it makes a great use of the standard Bootstrap core components. Feel free to use this template
                    for any project you want!</p>
                <a class="btn btn-primary" href="#!">Enjoy!</a>
            </div>
        </div>

        <!-- Content Row-->
        <div class="row my-3">
            <div class="col-10 col-md-3 mx-auto me-5">
                <div class="">
                    <div class="text-center">
                        <form action="{{ route('user#searchItem') }}" class="d-flex m-5">
                            <input class="form-control me-2" type="search" name="searchData" placeholder="Search"
                                aria-label="Search">
                            <button class="btn btn-outline-dark" type="submit">Search</button>
                        </form>

                        <div class="d-none d-md-block">
                            <a href="{{ route('user#index', '#pizza') }}" class="text-decoration-none text-dark">
                                <div class="m-2 p-2">All</div>
                            </a>
                            @foreach ($category as $item)
                                <a href="{{ route('user#categorySearch', $item->category_id) }}"
                                    class="text-decoration-none text-dark">
                                    <div class="m-2 p-2">{{ $item->category_name }}</div>
                                </a>
                            @endforeach
                        </div>
                        <hr class="d-none d-md-block">
                        <form action="{{ route('user#searchByDatePrice') }}" method="get">
                            @csrf
                            <div class="text-center m-4 p-2 d-none d-md-block">
                                <h3 class="mb-3">Start Date - End Date</h3>
                                <input type="date" name="startDate" id="" class="form-control"> -
                                <input type="date" name="endDate" id="" class="form-control">
                            </div>
                            <hr class="d-none d-md-block">
                            <div class="text-center m-4 p-2 d-none d-md-block">
                                <h3 class="mb-3">Min - Max Amount</h3>
                                <input type="number" name="minPrice" id="" class="form-control"
                                    placeholder="minimum price"> -
                                <input type="number" name="maxPrice" id="" class="form-control"
                                    placeholder="maximun price">
                            </div>
                            <button type="submit" class="btn btn-dark">Search <i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @if (count($pizza) == 0)
                <div class="col mt-5 alert alert-danger" style="height: 60px">
                    There is no pizza
                </div>
            @else
                <div class="col-12 col-md" id="pizza">
                    <div class="row gx-5">
                        @foreach ($pizza as $item)
                            <div class="col-12 col-md-4 mb-5">
                                <div class="card">
                                    <!-- Sale badge-->

                                    @if ($item->buy_one_get_one_status == 1)
                                        <div class="badge bg-danger text-white position-absolute"
                                            style="top: 0.5rem; right: 0.5rem">Buy One Get One</div>
                                    @endif
                                    <!-- Product image-->
                                    <div class="img-container">
                                        <img class="card-img-top pizza-img h-100"
                                            src="{{ asset('uploads/' . $item->image) }}" alt="..." />
                                    </div>
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder">{{ $item->pizza_name }}</h5>
                                            <!-- Product price-->
                                            <span class="text-muted">{{ $item->price }} Kyats</span>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto"
                                                href="{{ route('user#pizzaDetails', $item->pizza_id) }}">More
                                                Details</a></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            {{ $pizza->links() }}
        </div>
    </div>

    <div class="text-center d-flex justify-content-center align-items-center" id="contact">
        <div class="col-10 col-md-4 border shadow-sm ps-5 pt-5 pe-5 pb-2 mb-5">
            @if (Session::has('contactSuccess'))
                <div class="alert alert-success alert-dismissible fade show mb-3">
                    {{ Session::get('contactSuccess') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <h3>Contact Us</h3>

            <form action="{{ route('user#createContact') }}" method="post" class="my-4">
                @csrf
                <div class="my-3">
                    <input type="text" name="name" class="form-control" placeholder="Name"
                        value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="my-3">
                    <input type="text" name="email" class="form-control" placeholder="Email"
                        value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="my-3">
                    <textarea name="message" class="form-control" rows="3" placeholder="Message">{{ old('message') }}</textarea>
                    @if ($errors->has('message'))
                        <p class="text-danger">{{ $errors->first('message') }}</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-outline-dark">Send <i class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </div>
@endsection
