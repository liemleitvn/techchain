@extends('layouts.admin.master',['title'=>'Admin account', 'name_content'=>'Admin account'])
@section("script")
    <script src='{{url('admin/js/admin-account.js')}}'></script>
    <script src="{{url('admin/js/admin-change-password.js')}}"></script>
@stop
@section('content')
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" id="btn-add">
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
                              <!--------Enter Email------->
                              <label for="exampleInputEmail1">Email:</label>
                              <input type="email" name='admin-email'class="form-control" placeholder="Enter Email">

                              <!--------Enter password------->
                              <label for="exampleInputEmail1">Password:</label>
                              <input type="password" name='admin-password'class="form-control" value="" placeholder="Enter Password">

                              <!--------Enter phone------->
                              <label for="exampleInputEmail1">Role:</label>
                              <input type="text" name='admin-role'class="role-admin form-control" placeholder="Enter Role" value="{{config('constant.manager')}}">
                            </div> 
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-add-admin">Add</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                              <th class="id">STT</th>
                              <th>Email</th>
                              <th class="time">Date</th>
                              <th class="delete">Delete</th>
                              <th class="edit">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $stt=0 @endphp
                            @foreach($data as $item)
                                @php $stt++ @endphp
                                <tr data-id="{{$item['id']}}">
                                    <td>{{$stt}}</td>
                                    <td>{{$item['email']}}</td>
                                    <td>
                                        {!! \Carbon\Carbon::createFromTimeStamp(strtotime($item['created_at']))->diffForHumans() !!}
                                    </td>
                                    <td class="delete">
                                      <form action="" method="POST">
                                       {!! method_field('delete') !!}
                                          {!! csrf_field() !!}
                                        <a href="javascipt:void(0)"><i data-id='{{$item['id']}}'class="fa fa-trash delete-acc-admin" title="Delete"></i></a>
                                      </form>
                                    </td>
                                    <td class="edit">
                                      <a href="javascript:void(0)"><i type="button" class="fa fa-pencil edit-acc-admin" data-toggle="modal" data-target="#{{$item['id']}}"  title="Edit"></i>
                                      </a>
                                      <!--Modal edit acc admin-->
                                      <div class="modal fade" id="{{$item['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h3 class="modal-title edit-title" id="exampleModalCenterTitle">Edit account</h3>
                                                <span type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                                            </div>
                                            <div class="modal-body">
                                              <div class="show-edit"></div>
                                              <div class="form-group">
                                                <label class="edit-title">Email:</label>
                                                  <input type="email" name='admin-email'class="form-control email-admin" placeholder="Enter Email" value="{{$item['email']}}">

                                                  <!--------Enter password------->
                                                  <label class="edit-title">Password:</label>
                                                  <input type="password" name='admin-password-edit'class="form-control" value="" placeholder="Enter Password">

                                                  <!--------Enter phone------->
                                                  <label class="edit-title">Role:</label>
                                                  <input type="text" name='admin-role-edit'class="role-admin form-control" placeholder="Enter Role" value="{{config('constant.manager')}}">
                                                </div> 
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary close-all" data-dismiss="modal">Close</button>
                                              <button type="button" data-id='{{$item['id']}}' class=" btn-edit-acc-admin btn btn-primary">Edit</button>
                                            </div>
                                          </div>
                                        </div>
                                     </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    <!--Edit admin has login-->
    </section>
@endsection
