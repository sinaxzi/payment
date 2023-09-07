@extends('layout.app')

@section('content')
    @if (Session::has('payment-accepted-message'))
        <div class="alert alert-success">{{ Session::get('payment-accepted-message') }}</div>
    @elseif(Session::has('payment-rejected-message'))  
        <div class="alert alert-danger">{{ Session::get('payment-rejected-message') }}</div>
    @elseif(Session::has('payment-forbidden-message'))  
        <div class="alert alert-danger">{{ Session::get('payment-forbidden-message') }}</div>
    @elseif(Session::has('payment-success-message'))  
        <div class="alert alert-success">{{ Session::get('payment-success-message') }}</div>
    @elseif(Session::has('payment-fail-message'))  
        <div class="alert alert-danger">{{ Session::get('payment-fail-message') }}</div>
    @endif
    <header class="masthead" style="background-image: url({{ asset('img/home-bg.jpg') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1>organization payment</h1>
                        <span class="subheading">a test project for dadeh pardaz</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
        <div class="container-fluid">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Employee First Name</th>
                        <th>Employee Last Name</th>
                        <th>Employee National Code</th>
                        <th>Price</th>
                        <th>Shaba</th>
                        <th>status</th>
                        <th>description</th>
                        <th>Attachment</th>
                        <th>Accept</th>
                        <th>Reject</th>
                        <th>Pay</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment )
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->employee->first_name }}</td>
                        <td>{{ $payment->employee->last_name }}</td>
                        <td>{{ $payment->employee->national_code }}</td>
                        <td>{{ $payment->price }}</td>
                        <td>{{ $payment->shaba }}</td>
                        <td>{{ $payment->statusName($payment->status) }}</td>
                        <td>{{ $payment->description }}</td>
                        <td>
                            @if(!is_null($payment->attachment))
                                <form method="GET" action="{{ route('payment.download',$payment->id) }}">
                                @csrf
                                <button class="btn btn-warning">Download</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if($payment->status == 0)
                                <form method="GET" action="{{ route('payment.accept',$payment->id) }}">
                                @csrf
                                <button class="btn btn-success">Accept</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if($payment->status == 0)
                                <form method="GET" action="{{ route('payment.reject',$payment->id) }}">
                                @csrf
                                <button class="btn btn-danger">Reject</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if($payment->status == 1)
                                <form method="GET" action="{{ route('payment.pay',$payment->id) }}">
                                @csrf
                                <button class="btn btn-primary">Pay</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$payments->links()}}
        </div>
@endsection