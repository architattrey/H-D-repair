
{!! Form::open(['url' => 'add-update-service-provider','enctype'=>'multipart/form-data','method'=>'POST']) !!}
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        {{ Form::hidden('id',($data->id))}}    
        <!-- column 6 -->
        <div class="col-sm-6">
            <!--  Categories -->
            <div class="form-group">
                {{ Form::label('categories', ' Category Name', ['class' => 'categories']) }}
                <select class="form-control" name="cat">
                    <option value="{{(!empty($data->cat))?$data->cat:old('cat')}}">{{(!empty($data->cat))?$data->cat:old('cat')}}</option>
                    @foreach($categories as $category)
                        <option value="{{$category->categories}}">{{$category->categories}}</option>
                    @endforeach
                </select>
            </div>
            <!-- name -->
            <div class="form-group">
                {{ Form::label('name', 'Name', ['class' => 'name']) }}
                {{ Form::text('name',(!empty($data->name))?$data->name:old('name'),['class'=>'form-control','id'=>'name','placeholder'=>'Enter Name', 'required' => 'required']) }}
            </div>
            <!-- district -->
            <div class="form-group">
                {{ Form::label('district', 'District', ['class' => 'district']) }}
                {{ Form::text('district',(!empty($data->district))?$data->district:old('district'),['class'=>'form-control','id'=>'district','placeholder'=>'Enter District', 'required' => 'required']) }}
            </div>
            <!-- pin code -->
            <div class="form-group">
                {{ Form::label('pin_code', 'Pin Code', ['class' => 'pin_code']) }}
                {{ Form::number('pin_code',(!empty($data->pin_code))?$data->pin_code:old('pin_code'),['class'=>'form-control','id'=>'pin_code','placeholder'=>'Enter Pin code', 'required' => 'required']) }}
            </div>
            <!-- price -->
            <div class="form-group">
                {{ Form::label('price', 'Price', ['class' => 'price']) }}
                {{ Form::number('price',(!empty($data->price))?$data->price:old('price'),['class'=>'form-control','id'=>'price','placeholder'=>'Enter Price', 'required' => 'required']) }}
            </div>
        </div>
        <!--/column 6  -->
        <!-- column 6 -->
        <div class="col-sm-6">
            <!--  sub category -->
            <div class="form-group">
                {{ Form::label('sub_category', 'Sub Category Name', ['class' => 'sub_category']) }}
                <select class="form-control" name="sub_cat">
                    <option value="{{(!empty($data->sub_cat))?$data->sub_cat:old('sub_cat')}}">{{(!empty($data->sub_cat))?$data->sub_cat:old('sub_cat')}}</option>
                    @foreach($subCategories as $subcategory)
                        <option value="{{$subcategory->sub_category}}">{{$subcategory->sub_category}}</option>
                    @endforeach
                </select>
            </div>
            <!-- phone number -->
            <div class="form-group">
                {{ Form::label('contact_number', 'Contact Number', ['class' => 'contact_number']) }}
                {{ Form::text('phone',(!empty($data->phone))?$data->phone:old('phone'),['class'=>'form-control','id'=>'phone','placeholder'=>'Enter Contact Number', 'required' => 'required']) }}
            </div>
            <!--  states -->
            <div class="form-group">
                {{ Form::label('state', 'State Name', ['class' => 'state']) }}
                <select class="form-control" name="state">
                    <option value="{{(!empty($data->state))?$data->state:old('state')}}">{{(!empty($data->state))?$data->state:old('state')}}</option>
                    @foreach($states as $state)
                        <option value="{{$state->state}}">{{$state->state}}</option>
                    @endforeach
                </select>
            </div>
            <!--  address -->
            <div class="form-group">
                {{ Form::label('address', 'Address', ['class' => 'address']) }}
                {{ Form::textarea('address',(!empty($data->address))?$data->address:old('address'), ['rows'=> 3,'class'=>'form-control','id'=>'address','placeholder'=>'Enter Address', 'required' => 'required']) }}
            </div>
        </div>
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