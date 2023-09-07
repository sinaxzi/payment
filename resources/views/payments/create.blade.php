@extends('layout.app')
 
@section('content')
    @if (Session::has('payment-created-message'))
      <div class="alert alert-success">{{ Session::get('payment-created-message') }}</div>
    @endif
    <!-- Page Header-->
    <header class="masthead" style="background-image: url('/img/create-bg.jpg')" >
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>Create Payment</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <main class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="my-5">
                        <form action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <select class="form-control @error('category')
                                        border-danger
                                    @enderror" name="category" id="category">
                                    <option selected value=0>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value='{{ $category->id }}'>{{ $category->name }}</option>
                                        @endforeach
                                </select>
                                @error('category')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating">
                                <input class="form-control @error('price')
                                    border-danger
                                @enderror"  value="{{ old('price') }}" name="price" id="price" type="number" placeholder="Enter your price..."/>
                                <div>
                                    @error('price')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="price">Price</label>
                            </div>
                            <div class="form-floating">
                                <input class="form-control @error('shaba')
                                    border-danger
                                @enderror"  value="{{ old('shaba') }}" name="shaba" id="shaba" type="text" placeholder="Enter your shaba..."/>
                                <div>
                                    @error('shaba')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="shaba">Shaba</label>
                            </div>
                            <div class="form-floating">
                                <input class="form-control @error('national_code')
                                    border-danger
                                @enderror"  value="{{ old('national_code') }}" name="national_code" id="national_code" type="text" placeholder="Enter your national code..."/>
                                <div>
                                    @error('national_code')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <label for="national_code">National Code</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control @error('description')
                                    border-danger
                                @enderror" value="{{ old('description') }}" name="description"  id="description" type="text" placeholder="Enter your post description..." style="height: 12rem"></textarea>
                                @error('description')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                                <label for="description">Description</label>
                            </div>
                            <br />
                            <div class="form-floating">
                                <input class="form-control-file @error('attachment')
                                    border-danger
                                @enderror"  name="attachment" id="attachment" type="file"/>
                                <div>
                                    @error('attachment')
                                    <div class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <br />
                            <button class="btn btn-primary text-uppercase" id="submitButton" type="submit">Create Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection