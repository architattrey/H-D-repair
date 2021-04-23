<table class="table">
   <thead>
       <tr>
           <th>#</th>
           <th>Category</th>
           <th>Sub Category</th>
           <th>Name</th>
           <th>Contact Number</th>
           <th>Address</th>
           <th>District</th>
           <th>State</th>
           <th>Pin Code</th>
           <th>Price</th>
           <th>Raitings</th>
      </tr>
   </thead>
   <tbody>
    @foreach($serviceProiders as $key => $provider)
       @php
           $key++;
       @endphp
        <tr>
           <td>{{$key}}</td>
           <td>{{$provider->cat ? $provider->cat:""}}</td>
           <td>{{$provider->sub_cat ? $provider->sub_cat:""}}</td>
           <td>{{$provider->name ? $provider->name:"" }}</td>
           <td>{{$provider->phone ? $provider->phone:""}}</td>
           <td>{{$provider->address ? $provider->address:""}}</td>
           <td>{{$provider->district ? $provider->district:""}}</td>
           <td>{{$provider->state ? $provider->state :""}}</td>
           <td>{{$provider->pin_code ? $provider->pin_code:""}}</td>
           <td>{{$provider->price ? $provider->price:""}}</td>
           <td>{{$provider->ratings ? $provider->ratings:""}}</td>
        </tr>
    @endforeach   
    </tbody>   
</table>


