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
                    {!! Form::open(['url' => 'search-service-deliveries','method'=>'GET']) !!}
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
                                <th>Delivery Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($usersTransactions) && isset($usersTransactions))
                          
                                @foreach($usersTransactions  as $key => $transaction)
                                @php 
                                    $key++;
                                    if($transaction->dlvry_status == 0)
                                        $bgcolor = "style='background-color:#e3ef8052;'";
                                    elseif($transaction->dlvry_status == 1)
                                        $bgcolor = "style='background-color:#d1f3d7;'";
                                    else
                                        $bgcolor = "style='background-color:#f3e4d1;'";
                                @endphp
                                
                                    <tr <?= $bgcolor; ?>>
                                        <td>{{$key}}</td>
                                        <td>{{(!empty($transaction->order_id) && isset($transaction->order_id)) ? $transaction->order_id:"NA"}}</td>
                                        <td>{{(!empty($transaction->invoice_id) && isset($transaction->invoice_id)) ? $transaction->invoice_id:"NA"}}</td>
                                        <td>{{(!empty($transaction->amount) && isset($transaction->amount)) ? $transaction->amount:"NA"}}</td>
                                        <td>{{(!empty($transaction->status ) && isset($transaction->status ))? $transaction->status:"NA"}}</td>
                                        <td>{{(!empty($transaction->phone_number) && isset($transaction->phone_number)) ? $transaction->phone_number:"NA"}}</td>
                                        <td><textarea class="form-control" row="3" disabled>{{(!empty($transaction->dlvry_address) && isset($transaction->dlvry_address ))? $transaction->dlvry_address:"NA"}}</textarea></td>
                                        <td>
                                            @if($transaction->dlvry_status == 0)
                                            <select class = 'status'>
                                                <option value = " ">Change Payment Status </option>
                                                <option value = "{{$transaction->id}}">Success(If user paid)</option>
                                            </select> 
                                            @elseif($transaction->dlvry_status == 1)
                                                Succeeded
                                            @else
                                                Cancelled    
                                            @endif
                                        </td>
                                        <td>{{(!empty($transaction->created_at) && isset($transaction->created_at)) ? date('d-m-Y',strtotime($transaction->created_at)):"NA"}}</td>
                                        <td>
                                            <a href="#"><i class="fa fa-eye view-app-users" style="font-size:16px;color:green" data-toggle="tooltip" title="View User Details" id="{{$transaction->user_id}}" aria-hidden="true"></i></a>&nbsp;
                                            <a href="#"><i class="fa fa-eye view-service-providers" style="font-size:16px;color:blue" data-toggle="tooltip" title="View Assigned Service Provider" id="{{$transaction->service_provider_id}}" aria-hidden="true"></i> </a>&nbsp;
                                            @if($transaction->dlvry_status == 2)
                                                <a href="#"><i class="fa fa-eye view-feedback" style="font-size:16px;color:blue" id="{{$transaction->id}}" data-toggle="tooltip" title="View User Feedback" aria-hidden="true"></i></a>&nbsp;
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach 
                            @else
                            <tr><p>Deliveries not found</p></tr>  
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
        <!-- modal open for assigned providers -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content assigned_service_provider">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Data of Service provider</h4>
                    </div>
                    <div class="modal-body append">
                    <!-- fetch content -->
                    </div>
                    <div class="modal-footer">
                        {{ Form::submit('Submit',['class'=>'btn btn-success']) }}
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- modal close --> 
        <!-- modal open for  assigned user -->
        <div class="modal fade" id="myModal2" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content assigned_service_provider">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Data of User</h4>
                    </div>
                    <div class="modal-body append2">
                    <!-- fetch content -->
                    </div>
                    <div class="modal-footer">
                        {{ Form::submit('Submit',['class'=>'btn btn-success']) }}
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- modal close -->
        <!-- modal open for  assigned user -->
        <div class="modal fade" id="myModal3" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content assigned_service_provider">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Data of User</h4>
                    </div>
                    <div class="modal-body append3">
                    <!-- fetch content -->
                    </div>
                    <div class="modal-footer">
                        {{ Form::submit('Submit',['class'=>'btn btn-success']) }}
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- modal close --> 
    </section>    
    <!-- /.content -->
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();  
       // view assigned service providers
        $('.view-service-providers').click(function(){
            var serviceProviderId =  $(this).attr('id');
            if(serviceProviderId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('view-assigned-service-provider')}}?serviceProviderId="+serviceProviderId,
                    success:function(res){   
                        if(res.status == "success"){
                            $('.append').html(res.html);
                            $('#myModal').modal('show');
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
                        }
                    }
                });  
            }else{  
                swal("Something went wrong!", "Contact to administrator!", "error"); 
            } 
        });
        // view assigned users
        $('.view-app-users').click(function(){
            var serviceUserId =  $(this).attr('id');
            if(serviceUserId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('view-assigned-user')}}?serviceUserId="+serviceUserId,
                    success:function(res){   
                        if(res.status == "success"){
                            $('.append2').html(res.html);
                            $('#myModal2').modal('show');
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
                        }
                    }
                });  
            }else{  
                swal("Something went wrong!", "Contact to administrator!", "error"); 
            } 
        });
        // change payment status
        $(".status").change(function () {
            var data = this.value;
            if(data != " "){
                $.ajax({
                    type:'POST',
                    url: "{{URL::route('change-payment-status')}}",
                    data:{'data':data,"_token": "{{ csrf_token() }}"},
                    dataType:'json',
                    success: function(res){
                        if(res.status == "success"){
                            location.reload();
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
                        }
                    }
                }); 
            }else{
                swal("Please Select Status!", "Please try Again!", "error");
            }
        });
        // view feedback of this transaction
        $(".view-feedback").click(function () {
            var transactionId =  $(this).attr('id');
            if(transactionId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('view-feedback')}}?transactionId="+transactionId,
                    success:function(res){   
                        if(res.status == "success"){
                            $('.append3').html(res.html);
                            $('#myModal3').modal('show');
                        }else{
                            swal("FeedBack Not Found With This User", "Contact to administrator!", "error");
                        }
                    }
                });  
            }else{  
                swal("Something went wrong!", "Contact to administrator!", "error"); 
            } 
        });
    });  
</script>

@endsection