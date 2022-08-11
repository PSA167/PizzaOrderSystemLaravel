@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-10 col-md-8 offset-2 mt-3">
                        <div class="mb-3">
                            <a href="{{ route('admin#pizza') }}" class="text-decoration-none text-dark"><i
                                    class="fas fa-arrow-left"></i> back</a>
                        </div>
                        <div class="card">
                            <div class="card-header p-2">
                                <legend class="text-center">Pizza Information</legend>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5 align-items-center d-flex">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/' . $pizza->image) }}" alt="upload/pizza"
                                                class="img-thumbnail rounded-circle w-75 h-75">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row mb-2">
                                            <div class="col-4 text-end fw-bold">
                                                Name :
                                            </div>
                                            <div class="col-8">
                                                {{ $pizza->pizza_name }}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 text-end fw-bold">
                                                Price :
                                            </div>
                                            <div class="col-8">
                                                {{ $pizza->price }} Kyats
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 text-end fw-bold">
                                                Publish Status :
                                            </div>
                                            <div class="col-8">
                                                @if ($pizza->publish_status == 1)
                                                    YES
                                                @else
                                                    NO
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 text-end fw-bold">
                                                Category :
                                            </div>
                                            <div class="col-8">
                                                {{ $pizza->category_id }}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 text-end fw-bold">
                                                Discount Price :
                                            </div>
                                            <div class="col-8">
                                                {{ $pizza->discount_price }} Kyats
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 text-end fw-bold">
                                                Buy One Get One :
                                            </div>
                                            <div class="col-8">
                                                @if ($pizza->buy_one_get_one_status == 1)
                                                    YES
                                                @else
                                                    NO
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 text-end fw-bold">
                                                Waiting Time :
                                            </div>
                                            <div class="col-8">
                                                {{ $pizza->waiting_time }} minutes
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4 text-end fw-bold">
                                                Description :
                                            </div>
                                            <div class="col-8">
                                                {{ $pizza->description }}
                                            </div>
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
