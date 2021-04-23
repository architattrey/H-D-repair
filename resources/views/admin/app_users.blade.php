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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All App Users</li>
      </ol>
    </section>
    <div class="row">
        <div class="col-md-12 col-sm-12">
           
            <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">

                <div class="col-sm-6">
                    {!! Form::open(['url' => 'search-app-users','method'=>'GET']) !!}
                        {{ Form::text('search',old('search'),['id'=>'search','placeholder'=>' Search By Name']) }}
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Gender</th>
                                <th>State</th>
                                <th>City</th>
                                <th>DOB</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($appUsers ) && isset($appUsers ))
                                @foreach($appUsers  as $key => $user)
                                @php 
                                    $key++;
                                @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$user->name ? ucfirst($user->name): "NA" }}</td>
                                        <td>{{$user->email_id ? $user->email_id: "NA" }}</td>
                                        <td>{{$user->phone_number ? $user->phone_number: "NA" }}</td>
                                        <td>{{$user->gender ? ucfirst($user->name): "NA" }}</td>
                                        <td>{{$user->state ? ucfirst($user->name): "NA" }}</td>
                                        <td>{{$user->city ? ucfirst($user->name): "NA" }}</td>
                                        <td>{{$user->dob ?date('d-m-Y',strtotime($user->dob)): "NA" }}</td>
                                        <td><img src ="{{url('/').'/storage/app/'}}{{$user->image ?$user->image:'NA'}}" style="width: 64px;"></td>
                                        <td>{{$user->created_at ? date('d-m-Y',strtotime($user->created_at)): "NA"}}</td>
                                        <td>{{$user->updated_at ? date('d-m-Y',strtotime($user->updated_at)): "NA"}}</td>
                                        <td>
                                            <a href="#"><i class="fa fa-trash delete-app-users" style="font-size:16px;color:red" data-toggle="tooltip" title="Disable This User" id="{{$user->id}}" aria-hidden="true"></i></a>&nbsp;
                                        </td>
                                    </tr>
                                @endforeach 
                            @else
                            <tr><p>Users not found</p></tr>  
                            @endif  
                        </tbody> 
                    </table>
                   <div class="row">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <div class ="pagination" style="margin-left: 75px;">
                                {{$appUsers->links()}}
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
<script>
    
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();  
         
        // delete app user
        $('.delete-app-users').click(function(){
            var appUserId =  $(this).attr('id');
            if(appUserId != " "){
                 
                $.ajax({
                    type:"GET",
                    url:"{{url('delete-app-user')}}?appUserId="+appUserId,
                    success:function(res){   
                        if(res.status == "success"){
                            location.reload();
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
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
 
