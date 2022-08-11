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
                                <legend class="text-center">Edit Pizza</legend>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <img src="{{ asset('uploads/' . $pizza->image) }}" alt="" width="120"
                                        class="rounded">
                                </div>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <form class="form-horizontal"
                                            action="{{ route('admin#updatePizza', $pizza->pizza_id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control" id="inputName"
                                                        placeholder="Enter pizza name"
                                                        value="{{ old('name', $pizza->pizza_name) }}">
                                                    @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputImage" class="col-sm-2 col-form-label">Image</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="image" class="form-control"
                                                        id="inputImage">
                                                    @if ($errors->has('image'))
                                                        <p class="text-danger">{{ $errors->first('image') }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputPrice" class="col-sm-2 col-form-label">Price</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="price" class="form-control"
                                                        id="inputPrice" placeholder="Enter pizza price"
                                                        value="{{ old('price', $pizza->price) }}">
                                                    @if ($errors->has('price'))
                                                        <p class="text-danger">{{ $errors->first('price') }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputPublish" class="col-sm-2 col-form-label">Publish
                                                    Status</label>
                                                <div class="col-sm-10">
                                                    @if ($pizza->publish_status == 1)
                                                        <select name="publish" id="inputPublish" class="form-select">
                                                            <option value="">Choose Option...</option>
                                                            <option value="1" selected>Publish</option>
                                                            <option value="0">Unpublish</option>
                                                        </select>
                                                    @elseif ($pizza->publish_status == 0)
                                                        <select name="publish" id="inputPublish" class="form-select">
                                                            <option value="">Choose Option...</option>
                                                            <option value="1">Publish</option>
                                                            <option value="0" selected>Unpublish</option>
                                                        </select>
                                                    @endif
                                                    @if ($errors->has('publish'))
                                                        <p class="text-danger">{{ $errors->first('publish') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputCategory" class="col-sm-2 col-form-label">Category</label>
                                                <div class="col-sm-10">
                                                    <select name="category" id="inputCategory" class="form-select">
                                                        <option value="{{ $pizza->category_id }}">
                                                            {{ $pizza->category_name }}</option>
                                                        @foreach ($category as $item)
                                                            @if ($item->category_id != $pizza->category_id)
                                                                <option value="{{ $item->category_id }}">
                                                                    {{ $item->category_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('category'))
                                                        <p class="text-danger">{{ $errors->first('category') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputDiscount" class="col-sm-2 colform-label">Discount</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="discount" class="form-control"
                                                        id="inputDiscount" placeholder="Enter discount price"
                                                        value="{{ old('discount', $pizza->discount_price) }}">
                                                    @if ($errors->has('discount'))
                                                        <p class="text-danger">{{ $errors->first('discount') }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 form-label">Buy 1 Get
                                                    1</label>
                                                <div class="col-sm-10">
                                                    @if ($pizza->buy_one_get_one_status == 1)
                                                        <input type="radio" name="buyOneGetOne" class="form-input-check"
                                                            value="1" checked /> Yes
                                                        <input type="radio" name="buyOneGetOne"
                                                            class="form-input-check" value="0" /> No
                                                    @elseif ($pizza->buy_one_get_one_status == 0)
                                                        <input type="radio" name="buyOneGetOne"
                                                            class="form-input-check" value="1" /> Yes
                                                        <input type="radio" name="buyOneGetOne"
                                                            class="form-input-check" value="0" checked /> No
                                                    @endif
                                                    @if ($errors->has('buyOneGetOne'))
                                                        <p class="text-danger">{{ $errors->first('buyOneGetOne') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputWaiting" class="col-sm-2 form-label">Waiting
                                                    Time</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="waitingTime" class="form-control"
                                                        id="inputWaiting" placeholder="Enter waiting time"
                                                        value="{{ old('waitingTime', $pizza->waiting_time) }}">
                                                    @if ($errors->has('waitingTime'))
                                                        <p class="text-danger">{{ $errors->first('waitingTime') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputDescription"
                                                    class="col-sm-2 col-form-label">Description</label>
                                                <div class="col-sm-10">
                                                    <textarea name="description" id="inputDescription" rows="3" class="form-control"
                                                        placeholder="Enter description">{{ $pizza->description }}</textarea>
                                                    @if ($errors->has('description'))
                                                        <p class="text-danger">
                                                            {{ $errors->first('description') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <input type="submit" value="Submit" class="btn btn-dark">
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
        </section>
    </div>
@endsection
