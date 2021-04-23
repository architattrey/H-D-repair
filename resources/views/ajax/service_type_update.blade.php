
  {!! Form::open(['url' => 'add-update-service-type','enctype'=>'multipart/form-data','method'=>'POST']) !!}
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        <!-- column 6 -->
        <div class="col-sm-6">
            {{ Form::hidden('id',($data->id))}}                  
            <div class="form-group">
                {{ Form::label('service', ' Service', ['class' => 'service']) }}
                <select class="form-control" name="service_features_id">
                    <option value="{{(!empty($data->service_features_id))?$data->service_features_id:old('service_features_id')}}">{{(!empty($service_type_name->service_type))?$service_type_name->service_type:old('service_type')}}</option>
                    @foreach($serviceFeature as $service)
                        <option value="{{$service->id}}">{{$service->service_type}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--/column 6  -->
        <!-- column 6 -->
        <div class="col-sm-6">
            <!--  Categories -->
            <div class="form-group">
                {{ Form::label('type', 'Type', ['class' => 'type']) }}
                {{ Form::text('type',(!empty($data->type))?$data->type:old('type'),['class'=>'form-control','id'=>'type','placeholder'=>'Enter Service Type', 'required' => 'required']) }} 
            </div>
            
        </div>
        <!--/column 6  -->  
        <div class="col-sm-12">
            {{ Form::label('price', 'Price', ['class' => 'price']) }}
            {{ Form::number('price',(!empty($data->price))?$data->price:old('price'),['class'=>'form-control','id'=>'price','placeholder'=>'Enter Service Price', 'required' => 'required']) }}
        </div> 
        <!--/column 6  -->
    </div>
    <!--/ row end -->
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success">Update</button>
    {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
    
</div>
{!! Form::close() !!}
@section('script')
 
@endsection