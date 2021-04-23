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
        <li class="active">All Cities</li>
      </ol>
    </section>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
                <div class="col-sm-6">
                    {!! Form::open(['url' => 'search-city','method'=>'GET']) !!}
                        {{ Form::text('search',old('search'),['id'=>'search','placeholder'=>' Search By City']) }}
                        <button type="submit" class="btn btn-warning" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Search</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" id="add_more">Add More Cities</button>
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
                                <th>Cities</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($cities ) && isset($cities ))
                                @foreach($cities  as $key => $city)
                                @php 
                                    $key++;
                                @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$city->city ? ucfirst($city->city): "NA" }}</td>
                                        <td>{{$city->created_at ? date('d-m-Y',strtotime($city->created_at)): "NA"}}</td>
                                        <td>{{$city->updated_at ? date('d-m-Y',strtotime($city->updated_at)): "NA"}}</td>
                                        <td>
                                            <a href="#"><i class="fa fa-pencil update-modal" style="font-size:16px;color:green" data-toggle="tooltip" title="Update city" id="{{$city->id}}" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a href="#"><i class="fa fa-trash delete-city" style="font-size:16px;color:red" data-toggle="tooltip" title="Delete city" id="{{$city->id}}" aria-hidden="true"></i></a>&nbsp;
                                        </td>
                                    </tr>
                                @endforeach 
                            @else
                            <tr><p>City not found</p></tr>  
                            @endif  
                        </tbody> 
                    </table>
                   <div class="row">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <div class ="pagination" style="margin-left: 75px;">
                                {{$cities->links()}}
                            </div>    
                        </div>     
                   </div>
                </div>
            </div>
        </div>
        <!-- add Filed Boy modal -->
        <div class="modal fade" id="addCity" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want add City!</h4>
                    </div>
                    <div class="modal-body">
                        <!-- row strat -->
                        <div class="row">
                            {!! Form::open(['url' => 'add-update-city','enctype'=>'multipart/form-data','method'=>'POST']) !!}
                            <!-- column 6 -->
                            <div class="col-sm-6">
                                <!-- State Dropdown -->
                                <div class="form-group">
                                    {{ Form::label('state', 'State', ['class' => 'state']) }}
                                    <select class="form-control" id="state" name="state">
                                        <option value="">Please Select state</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}">{{$state->state}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- City -->
                                <div class="form-group">
                                    {{ Form::label('city', 'City', ['class' => 'city']) }} 
                                    {{ Form::text('city', old('city'),['class'=>'form-control','id'=>'city','placeholder'=>'Enter City Name', 'required' => 'required']) }}
                                </div>
                            </div>
                            <!--/column 6  --> 
                        </div>
                        <!--/ row end -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- update state modal -->
         <div class="modal fade" id="updateCity" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want update city</h4>
                    </div>
                    <div class="append">
                    <!-- you will append the html here -->
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
        $('#add_more').click(function(){
            $('#addCity').modal('show');
        });
        
        // update modal with filed data
        $('.update-modal').click(function(){
            var cityId =  $(this).attr('id');
            if(cityId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('update-view-city')}}?cityId="+cityId,
                    success:function(res){   
                        if(res.status == "success"){
                            $('.append').html(res.html);
                            $('#updateCity').modal('show');
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
                        }
                    }
                });  
            }else{  
                swal("Something went wrong!", "Contact to administrator!", "error"); 
            } 
        });
        // update modal with filed data
        $('.delete-city').click(function(){
            var cityId =  $(this).attr('id');
            if(cityId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('delete-city')}}?cityId="+cityId,
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
 
