@extends('layouts.admin.master',['title'=>'User','name_content'=>'User'])
@section('script')
    <script src="{{url('admin/js/admin-user.js')}}"></script> 
@stop
@section('content')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
      <!-------------------------Button Add question---------------------------------->
          <div class="col-xs-12 add">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" id="btn-category">
              Add <span><i class="fa fa-plus-square"></i></span>
            </button>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalCenterTitle">Add user</h3>
                      <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                  </div>
                  <div class="modal-body">
                    <div class='show-add'></div>
                    <div class="form-group">
                      @php $password = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,10))),1,6);@endphp
                      <!--------Enter Email------->
                      <label for="exampleInputEmail1">Email:</label>
                      <input type="email" name='user-email'class="form-control" placeholder="Enter Email">

                      <!--------Enter password------->
                      <label for="exampleInputEmail1">Password:</label>
                      <input type="text" name='user-password'class="form-control" value="{{$password}}" >
                      
                      <!--------Choose category------->
                      <label for="exampleInputEmail1">Choose category</label>
                      <select class="form-control select">
                        <option value='0'> ----- Choose category ----- </option>
                        @foreach($categories as $category)
                          <option value="{{$category['id']}}">{{$category['name']}}</option>
                        @endforeach
                      </select>

                      <!--------Enter phone------->
                      <label for="exampleInputEmail1">Phone number:</label>
                      <input type="number" name='user-phone'class="form-control" placeholder="Enter Phone number">

                      <!--------Enter Address------->
                      <label for="exampleInputEmail1">Address:</label>
                      <input type="tex" name='user-address'class="form-control" placeholder="Enter Address">

                      <!--------Enter phone------->
                      <label for="exampleInputEmail1">Link CV:</label>
                      <input type="text" name='user-cv'class="form-control" placeholder="Enter Link CV">

                    </div> 
                  </div>
              
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-add-user">Add</button>
                  </div>
                </div>
              </div>
            </div>  
          </div>
      <!-------------------------Table list question---------------------------------->
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th class="id">ID</th>
                  <th>Email</th>
                  <th>Category</th>
                  <th class="phone">Phone</th>
                  <th class="address">Address</th>
                  <th class="">Link CV</th>
                  <th class="is_disable">Is_disable</th>
                  <th class="time">Date</th>
                  <th class="time">Start_time</th>
                  <th class="time">End_time</th>
                  <th class="delete">Delete</th>
                  <th class="edit">Edit</th>
                </tr>
              </thead>
              <tbody>
                @if($users)
                  @php $stt=0; @endphp
                @foreach($users as $user)
                  @php $stt++; @endphp
                  <tr data-id='{{$user['id']}}'>
                    <td class="id">{{$stt}}</td>
                    <td>{{$user['email']}}</td>
                    <td>
                      @php $category = DB::table('categories')->select('name')->where('id',$user['category_id'])->first();@endphp
                      {{$category->name}}
                    </td>
                    <td>@if($user['phone_number']){{$user['phone_number']}} @else{{'NULL'}} @endif</td>
                    <td>@if($user['address']){{$user['address']}} @else{{'NULL'}} @endif</td>
                    <td>@if($user['cv_link']){{$user['cv_link']}} @else{{'NULL'}} @endif</td>
                    <td>{{$user['is_disable']}}</td>
                    <td>
                      {{\Carbon\Carbon::createFromTimeStamp(strtotime($user['created_at']))->diffForHumans()}}
                    </td>
                    <td>@if($user['start_time']){{$user['start_time']}} @else{{'NULL'}} @endif</td>
                    <td>@if($user['end_time']){{$user['end_time']}} @else{{'NULL'}} @endif</td>
                    <td class="delete"><a href="javascript:void(0)"><i class="fa fa-trash delete-user" title="Delete" data-id='{{$user['id']}}'></i></a></td>
                    <td class="edit">
                      <a href="javascript:void(0)"><i type="button" class="fa fa-pencil btn-edit" data-toggle="modal" data-target="#{{$user['id']}}" title="Edit"></i>
                      </a>
                      <div class="modal fade" id="{{$user['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title edit-title" id="anime">Edit user</h3>
                                <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                            </div>
                            <div class="modal-body">
                              <div class="show-edit"></div>
                              <div class="form-group edit-user">
                                <label class='lb-user'>Email:</label>
                                <input type="email" name='user-email'class="form-control" placeholder="Enter Email" value="{{$user['email']}}">
                              
                                <!--------Choose category------->
                                <label class='lb-user'>Choose category</label>
                                <select class="form-control select">
                                  <option value='0'> ----- Choose category ----- </option>
                                  @foreach($categories as $category)
                                    <option @if($user['category_id'] == $category['id']){{'selected'}} @endif 
                                    value="{{$category['id']}}">{{$category['name']}}</option>
                                  @endforeach
                                </select>

                                <!--------Enter phone------->
                                <label class='lb-user'>Phone number:</label>
                                <input type="number" name='user-phone'class="form-control" placeholder="Enter Phone number" value="{{$user['phone_number']}}">

                                <!--------Enter Address------->
                                <label class='lb-user'>Address:</label>
                                <input type="tex" name='user-address'class="form-control" placeholder="Enter Address" value="{{$user['address']}}">

                                <!--------Enter phone------->
                                <label class='lb-user'>Link CV:</label>
                                <input type="text" name='user-cv'class="form-control" placeholder="Enter Link CV" value="{{$user['cv_link']}}">
                              </div> 
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary edit-user-account" data-id='{{$user['id']}}'>Edit</button>
                            </div>
                          </div>
                        </div>
                    </td>
                  </tr>
                @endforeach
                @endif
            </table>
      <!-------------------------Pagination---------------------------------->    
          {{ $users->links()}}
        </div>
        <!-- /.box-body -->
      </div>

    </div>

    <!-------------------------Layout Edit question---------------------------------->
    
    </div>  
  </section>
@endsection()