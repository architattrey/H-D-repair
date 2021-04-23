
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        <div class="col-sm-12">
            <div class="listing" style="background-color: white;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>District</th>
                            <th>state</th> 
                        </tr>
                    </thead>
                    <tbody>
                
                        @if(!empty($serviceProviders) && isset($serviceProviders ))
                            @foreach($serviceProviders  as $key => $provider)
                            @php 
                                $key++;
                            @endphp
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{$provider->cat ?ucfirst($provider->cat):"NA" }}</td>
                                    <td>{{$provider->sub_cat ? ucfirst($provider->sub_cat): "NA" }}</td>
                                    <td>{{$provider->name ? ucfirst($provider->name): "NA" }}</td>
                                    <td>{{$provider->phone ? ucfirst($provider->phone): "NA" }}</td>
                                    <td><textarea class="form-control" row="3" disabled>{{$provider->address ? $provider->address: "NA" }}</textarea></td>
                                    <td>{{$provider->district ? ucfirst($provider->district): "NA" }}</td>
                                    <td>{{$provider->state ? ucfirst($provider->state) : "NA" }}</td>
                                </tr>
                            @endforeach 
                        @else
                        <tr><td><p>Services Provider not found</p></td></tr>  
                        @endif  
                    </tbody> 
                </table>    
            </div>
        </div>   
    </div>
    <!--/ row end -->
    
</div>
 
 