@extends('admin.layouts.app')

@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">All Transaction</li>
      </ol>
    </section>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
                <div class="col-sm-6">
                    {!! Form::open(['url' => 'search-transactions','method'=>'GET']) !!}
                        {{ Form::text('search',old('search'),['id'=>'search','placeholder'=>' Search By Order Id']) }}
                        <button type="submit" class="btn btn-warning" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Search</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-6">
                </div> 
            </div>
        </div>
    </div>

    <!-- view list of agents -->
    <!-- Main content -->
    <section class="content">
        @if(Session::has('flash_message'))
        <div class="alert alert-success"><strong>Success!</strong>  {!! session('flash_message') !!}</div>
        @elseif(Session::has('flash_error'))
        <div class="alert alert-danger"><strong>Danger!</strong> {!! session('flash_error') !!} </div>
        @endif
        <div class="row"> 
            <div class="col-sm-12">
                <div class="listing" style="background-color: white;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Id</th>
                                <th>Invoice Id</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($usersTransactions) && isset($usersTransactions))
                          
                                @foreach($usersTransactions  as $key => $transaction)
                                @php 
                                    $key++;
                                @endphp
                                
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{(!empty($transaction->order_id) && isset($transaction->order_id)) ? $transaction->order_id:"NA"}}</td>
                                        <td>{{(!empty($transaction->invoice_id) && isset($transaction->invoice_id)) ? $transaction->invoice_id:"NA"}}</td>
                                        <td>{{(!empty($transaction->amount) && isset($transaction->amount)) ? $transaction->amount:"NA"}}</td>
                                        <td>{{(!empty($transaction->status ) && isset($transaction->status ))? $transaction->status:"NA"}}</td>
                                        <td>{{(!empty($transaction->phone_number) && isset($transaction->phone_number)) ? $transaction->phone_number:"NA"}}</td>
                                        <td><textarea class="form-control" row="3" disabled>{{(!empty($transaction->dlvry_address) && isset($transaction->dlvry_address ))? $transaction->dlvry_address:"NA"}}</textarea></td>
                                        <td>{{(!empty($transaction->created_at) && isset($transaction->created_at)) ? date('d-m-Y',strtotime($transaction->created_at)):"NA"}}</td>
                                    </tr>
                                @endforeach 
                            @else
                            <tr><p>Transaction not found</p></tr>  
                            @endif  
                        </tbody> 
                    </table>
                   <div class="row">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <div class ="pagination" style="margin-left: 75px;">
                                {{$usersTransactions->links()}}
                            </div>    
                        </div>     
                   </div>
                </div>
            </div>
        </div> 
    </section>    
    <!-- /.content -->
@endsection
@section('script')

@endsection