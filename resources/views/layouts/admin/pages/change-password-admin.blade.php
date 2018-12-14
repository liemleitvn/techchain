
@php $auth_admin = Auth::guard('admin')->user()@endphp
<div class="modal fade" id="{{$auth_admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Change infor</h3>
          <span type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body">
        <div class="show-edit"></div>
        <div class="form-group">
          <label class="edit-title">Email:</label>
            <input type="email" name='admin-email'class="form-control email-admin" placeholder="Enter Email" value="{{$auth_admin->email}}">
            <!--------Enter password------->
            <label class="edit-title">Current password:</label>
            <input type="password" name='admin-current-password'class="form-control" value="" placeholder="Enter Password">
            <label class="edit-title">New password:</label>
            <input type="password" name='admin-new-password'class="form-control" value="" placeholder="Enter Password">
          </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary change-is-admin" data-id="{{$auth_admin->id}}">Save changes</button>
      </div>
    </div>
  </div>
</div>