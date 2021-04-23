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
        <li class="active">All Price</li>
      </ol>
    </section>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
                <div class="col-sm-6">
                    {!! Form::open(['url' => 'search-price-range','method'=>'GET']) !!}
                        {{ Form::text('search',old('search'),['id'=>'search','placeholder'=>' Search By range']) }}
                        <button type="submit" class="btn btn-warning" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Search</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" id="add_more">Add More Price Range</button>
                </div> 
            </div>
        </div>
    </div>
    <!-- view Price Range -->
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
                                <th>Range</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($priceRanges) && isset($priceRanges))
                                @foreach($priceRanges  as $key => $range)
                                @php 
                                    $key++;
                                @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$range->range ? ucfirst($range->range): "NA" }}</td>
                                        <td>{{$range->created_at ? date('d-m-Y',strtotime($range->created_at)): "NA"}}</td>
                                        <td>{{$range->updated_at ? date('d-m-Y',strtotime($range->updated_at)): "NA"}}</td>
                                        <td>
                                            <a href="#"><i class="fa fa-pencil update-modal" style="font-size:16px;color:green" data-toggle="tooltip" title="Update Price Range" id="{{$range->id}}" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a href="#"><i class="fa fa-trash delete-price-range" style="font-size:16px;color:red" data-toggle="tooltip" title="Delete Price Range" id="{{$range->id}}" aria-hidden="true"></i></a>&nbsp;
                                        </td>
                                    </tr>
                                @endforeach 
                            @else
                            <tr><p>Price Range not found</p></tr>  
                            @endif  
                        </tbody> 
                    </table>
                   <div class="row">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <div class ="pagination" style="margin-left: 75px;">
                                {{$priceRanges->links()}}
                            </div>    
                        </div>     
                   </div>
                </div>
            </div>
        </div>
        <!-- add price range modal -->
        <div class="modal fade" id="addPriceRange" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want add Price Range!</h4>
                    </div>
                    <div class="modal-body">
                        <!-- row strat -->
                        <div class="row">
                            {!! Form::open(['url' => 'add-update-price-range','enctype'=>'multipart/form-data','method'=>'POST']) !!}
                            <!-- column 12 -->
                            <div class="col-sm-12">
                                <!--  range -->
                                <div class="form-group">
                                    {{ Form::label('range', ' Price Range', ['class' => 'name']) }}
                                    {{ Form::text('range',old('range'),['class'=>'form-control','id'=>'price-range','placeholder'=>'Enter Price Range', 'required' => 'required']) }}
                                </div>
                            </div>
                            <!--/column 12  -->    
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
        <!-- update price range modal -->
         <div class="modal fade" id="updatePriceRange" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want update Price Range</h4>
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
            $('#addPriceRange').modal('show');
        });
        
        // update modal with filed data
        $('.update-modal').click(function(){
            var priceRangeId =  $(this).attr('id');
            if(priceRangeId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('update-view-price-range')}}?priceRangeId="+priceRangeId,
                    success:function(res){   
                        if(res.status == "success"){
                            $('.append').html(res.html);
                            $('#updatePriceRange').modal('show');
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
        $('.delete-price-range').click(function(){
            var priceRangeId =  $(this).attr('id');
            if(priceRangeId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('delete-price-range')}}?priceRangeId="+priceRangeId,
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
 
