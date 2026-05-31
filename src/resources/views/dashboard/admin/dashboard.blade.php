@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.admin._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.admin._partial._topMenu')
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Reservation Today
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Reservation Week
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div title="Expire Reservation"
                                         class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Reservation Today Ex
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">4</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 p-4">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                Booking Cafe
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-bordered table-hover text-center">
                                <thead>
                                <th>#</th>
                                <th>date</th>
                                <th>time</th>
                                <th>customer<br>name</th>
                                <th>customer<br>phone</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                {{--                                    @php $i=1; @endphp--}}
                                {{--                                    @forelse($resv as $res)--}}
                                {{--                                        <tr title="{{$res->message}}">--}}
                                {{--                                            <td>{{$i++}}</td>--}}
                                {{--                                            <td>{{$res->date}}</td>--}}
                                {{--                                            <td>{{$res->start}} to {{$res->end}}</td>--}}
                                {{--                                            <td>{{$res->customer_name}}</td>--}}
                                {{--                                            <td>{{$res->customer_phone}}</td>--}}
                                {{--                                            <td><a class="btn btn-warning " href="#">Expire</a></td>--}}
                                {{--                                        </tr>--}}
                                {{--                                    @empty--}}
                                {{--                                        <tr>--}}
                                {{--                                            <td colspan="6">nothing</td>--}}
                                {{--                                        </tr>--}}
                                {{--                                    @endforelse--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                Booking Vip
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-bordered table-hover text-center w-100">
                                <thead>
                                <th>#</th>
                                <th>date</th>
                                <th>time</th>
                                <th>customer<br>name</th>
                                <th>customer<br>phone</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>سه شنبه</td>
                                    <td>04:00 - 05:30</td>
                                    <td>mahdi kazemi</td>
                                    <td>09389512885</td>
                                    <td><a class="btn btn-warning " href="#">Expire</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
