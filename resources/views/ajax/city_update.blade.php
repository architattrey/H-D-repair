
{!! Form::open(['url' => 'add-update-city','enctype'=>'multipart/form-data','method'=>'POST']) !!}
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        <!-- id in hidden field -->
        {{ Form::hidden('id',($data->id))}}
        <!-- column 6 -->
        <div class="col-sm-6">
            <!-- State Dropdown -->
            <div class="form-group">
                {{ Form::label('state', 'State', ['class' => 'state']) }}
                <select class="form-control" id="state" name="state_id">
                    <option value="(!empty($data->state_id))?$data->state_id:old('state_id')">{{$state->state}}</option>
                    @foreach($states as $state)
                        <option value="{{$state->id}}">{{$state->state}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <!-- City -->
            <div class="form-group">
                {{ Form::label('city', ' City Name', ['class' => 'name']) }}
                {{ Form::text('city',(!empty($data->city))?$data->city:old('city'),['class'=>'form-control','id'=>'city','placeholder'=>'Enter City Name', 'required' => 'required']) }}
            </div>
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