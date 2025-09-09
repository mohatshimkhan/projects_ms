@extends('layouts.master')


@section('content')

  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <!--<small>Admin panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listings</h3>
                <!--<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_Form"><i class="fa fa-plus"></i> Add New
                </button>-->
                <a onclick="deleteData(23)" class="btn btn-primary pull-right" ><i class="fa fa-minus"></i> Delete</a>
                <a onclick="editForm(23)" class="btn btn-primary pull-right" ><i class="fa fa-minus"></i> Edit</a>
                <a onclick="addForm()" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i> Add New</a>
    
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
          <!--<table id="example2" class="tblDataTable table table-bordered table-striped yajra-datatable">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Active</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                    <tr>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->role_id }}</td>
                      <td>{{ $user->is_active }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Active</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>-->

            <div class="container mt-5">
              <h2 class="mb-4">Laravel 7|8 Yajra Datatables Example</h2>
              <table class="table table-bordered yajra-datatable">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Active</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- form model -->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"> </h4>
            </div>
            <div class="modal-body">
              
              <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">User</h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <form id="myForm" name="myForm" role="form" method="post" enctype="multipart/form-data">
                      
                    {{ csrf_field() }} {{ method_field('POST') }}
                      
                      <input type="hidden" name="hfid" id="hfid">

                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputName1">Name</label>
                          <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email</label>
                          <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Password</label>
                          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputRole1">Role</label>
                          <select class="form-control" name="role" id="role"><option value="">Select Role</option>
                           <option value="1">Admin</option>
                           <option value="2">User</option>
                          </select>
                        </div>
                    <!--<div class="form-group">
                          <label for="exampleInputFile">Picture</label>
                          <input type="file" id="profile_pic">
                          <p class="help-block"></p>
                        </div>-->
                        <div class="form-group">&nbsp;</div>

                        <div class="form-group">
                          <div class="checkbox icheck">
                            <label>
                              <input type="checkbox" name="is_active" id="is_active" checked>&nbsp;<b>Active</b>
                            </label>
                          </div>
                        </div>

                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                      </div>

                  </div>
                  <!-- /.box -->

                </div>
                <!--/.col (left) -->

              </div>
              <!-- /.row -->

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary">Submit</button>
            </div>

            </form>
            <!-- form close -->

          </div>
          <!-- /.modal-content -->

        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.add new modal -->

    </section>

@endsection


@section('extraScripts')

<script type="text/javascript">

function addForm() {
    save_method = "add";
    $('input[name=_method]').val('POST');
    $('#myModal').modal('show');
    $('#myModal form')[0].reset();
    $('.modal-title').text('Add new');
}

function editForm(id) {
    //alert(id);
    save_method = 'edit';
    $('input[name=_method]').val('PATCH');
    $('#myModal form')[0].reset();
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ url('admin/users') }}" + '/' + id + "/edit",
        type: "POST",
        data : {'_method' : 'GET', '_token' : csrf_token},
        dataType: "JSON",
        success: function(responsedata) {
            $('#myModal').modal('show');
            $('.modal-title').text('Edit');

            $('#hfid').val(responsedata.id);
            $('#name').val(responsedata.name);
            $('#email').val(responsedata.email);
            $('#password').val(responsedata.password);
            $('#role').val(responsedata.role_id);
            if(responsedata.is_active=='1'){
              $('#is_active').checked(true);
            } else {
              $('#is_active').checked(false);
            }
        },
        error : function() {
            alert("Nothing Data");
        }
    }); 
}

function deleteData(id){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then(function () {
        $.ajax({
            url : "{{ url('admin/users') }}"+'/'+id,
            type : "POST",
            data : {'_method' : 'DELETE', '_token' : csrf_token},
            success : function(data) {
                //table.ajax.reload();
                window.location.href = "{{ route('users.index') }}";
                swal({
                    title: 'Success!',
                    text: data.message,
                    type: 'success',
                    timer: '1500'
                })  
            },
            error : function () {
                swal({
                    title: 'Oops...',
                    text: data.message,
                    type: 'error',
                    timer: '1500'
                })
            }
        });

        return false;
    });
}


$(document).ready(function() {

  $("#myForm").submit(function(event) {
    
    event.preventDefault(); // Prevent the default form submission
    
    //alert("Submitted");
    var id = $('#hfid').val();
    //var id = '1';
    if(save_method == 'add') 
      url = "{{ url('admin/users') }}";
   else 
      url = "{{ url('admin/users') . '/' }}"+id;
    //alert(url);

    $.ajax({
        url : url,
        type : "POST",
        //data : $('#modal-form form').serialize(),
        data: new FormData($("#myForm")[0]),
        contentType: false,
        processData: false,
        success : function(responsedata) {
            $('#myModal').modal('hide');
            //console.log(data);
            window.location.href = "{{ route('users.index') }}";
            swal({
                title: 'Success!',
                text: responsedata.message,
                type: 'success',
                timer: '1500'
            })
            //table.ajax.reload();
        },
        error : function(responsedata){
            swal({
                title: 'Oops...',
                text: responsedata.message,
                type: 'error',
                timer: '1500'
            })
        }
    });

    return false;
    
  });

  var table = $('.yajra-datatable').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: "{{ route('api.categories') }}",
                  columns: [
                      {data: 'id', name: 'id'},
                      {data: 'name', name: 'name'},
                      {data: 'email', name: 'email'},
                      {data: 'action', name: 'action', orderable: false, searchable: false}
                  ]
              });

  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' /* optional */
  });

});

</script>

@endsection