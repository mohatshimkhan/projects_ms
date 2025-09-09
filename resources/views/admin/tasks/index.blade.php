@extends('layouts.master')

@section('extraStyles')

@endsection 

@section('content')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Tasks
        <!--<small>Admin panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tasks</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listings</h3>
                <a class="btn_addnew btn btn-primary pull-right" ><i class="fa fa-plus"></i> Add New</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
              <table class="table table-bordered yajra-datatable">
              <thead>
                  <tr>
                      <th>Sr No.</th>
                      <th>Title</th>
                      <th>Desc</th>
                      <th>Company</th>
                      <th>Project</th>
                      <th>User</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
              </table>
          
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
                    <!-- /.box-header -->

                    <!-- form start -->
                    <form id="myForm" name="myForm" role="form" method="post" data-toggle="validator"  enctype="multipart/form-data">
                      
                    {{ csrf_field() }} {{ method_field('POST') }}
                      
                      <input type="hidden" name="hfid" id="hfid">

                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputTitle">Title</label>
                          <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
                           <strong style="color:red; font-weight:lighter; display:none;" class="error-title"></strong>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputDescription">Description</label>
                          <textarea class="form-control" name="description" id="description" placeholder="Enter Description"></textarea>
                           <strong style="color:red; font-weight:lighter; display:none;" class="error-description"></strong>
                        </div>
                        
                        <div class="form-group">
                          <label for="exampleInputCompany">Company</label>
                          <select name="company" id="company" class="form-control">
                           <option value="">Select Company</option>
                           <option value="1">ABC</option>
                           <option value="2">BBB</option>
                           <option value="3">CCC</option>
                          </select>
                           <strong style="color:red; font-weight:lighter; display:none;" class="error-company"></strong>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputProject">Project</label>
                          <select name="project" id="project" class="form-control">
                           <option value="">Select Project</option>
                           <option value="1">AA</option>
                           <option value="2">BB</option>
                           <option value="3">CC</option>
                          </select>
                           <strong style="color:red; font-weight:lighter; display:none;" class="error-project"></strong>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputUser">User</label>
                          <select name="user" id="user" class="form-control">
                           <option value="">Select User</option>
                           <option value="1">X</option>
                           <option value="2">Y</option>
                           <option value="3">Z</option>
                          </select>
                           <strong style="color:red; font-weight:lighter; display:none;" class="error-user"></strong>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputDays">Days</label>
                          <input type="text" class="form-control" name="days" id="days" placeholder="Enter Days">
                           <strong style="color:red; font-weight:lighter; display:none;" class="error-days"></strong>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputHours">Hours</label>
                          <input type="text" class="form-control" name="hours" id="hours" placeholder="Enter Hours">
                           <strong style="color:red; font-weight:lighter; display:none;" class="error-hours"></strong>
                        </div>

                        <div class="form-group">&nbsp;</div>

                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                      </div>

                  </div>
                  <!-- /.box -->

                </div>
                <!--/.col (left) -->

              </div>
              <!-- /.row -->

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
var table = $('.yajra-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('tasks.list') }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex'},
        { data: 'title',       name: 'title'},
        { data: 'description', name: 'description'},
        { data: 'company_id',  name: 'company_id'},
        { data: 'project_id',  name: 'project_id'},
        { data: 'user_id',     name: 'user_id'},
        {
          data: 'action', 
          name: 'action', 
          orderable: true, 
          searchable: true
        },
      ]
    });
</script>

<script type="text/javascript">
$(document).ready(function() {
    
  const SweetAlt = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  });

/*$('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional 
  });*/  


  $('#myForm').on('submit', function (event) {

    event.preventDefault();

    var id = $('#hfid').val();
    
    if(save_method == 'add') 
      url = "{{ url('admin/tasks') }}";
    else 
      url = "{{ url('admin/tasks') . '/' }}"+id;

    var formData = $(this).serialize();
    
    $.ajax({
      type: 'POST',
      url :  url,
      data:  formData,
      success: function (responseData) {
        //console.log(responseData);
        $('.error-title ').hide();
        $('.error-description').hide();
        $('.error-company').hide();
        $('.error-project').hide();
        $('.error-user').hide();
        $('.error-days').hide();
        $('.error-hours').hide();

        $('#myModal').modal('hide');

        SweetAlt.fire({
          type: 'success',
          title: responseData.message
        });

        table.ajax.reload(); 
      },
      error: function (responseData) {
        
        let respData   = responseData.responseJSON;
        let respStatus = respData.status;  
        let respErrors = respData.errors;
      
        if(respErrors.title) {
          $('.error-title').show().text(respErrors.title);
        } else {
          $('.error-title').hide();
        }
        
        if(respErrors.description) {
            $('.error-description').show().text(respErrors.description);
        } else {
            $('.error-description').hide();
        }

        if(respErrors.company) {
          $('.error-company').show().text(respErrors.company);
        } else {
          $('.error-company').hide();
        } 

        if(respErrors.project) {
          $('.error-project').show().text(respErrors.project);
        } else {
          $('.error-project').hide();
        } 

        if(respErrors.user) {
          $('.error-user').show().text(respErrors.user);
        } else {
          $('.error-user').hide();
        } 

        if(respErrors.days) {
          $('.error-days').show().text(respErrors.days);
        } else {
          $('.error-days').hide();
        }   
        
        if(respErrors.hours) {
          $('.error-hours').show().text(respErrors.hours);
        } else {
          $('.error-hours').hide();
        } 

      }
    
    });

  });

  $(document).on('click', '.btn_addnew', function() {
    
    save_method = "add";

    $('input[name=_method]').val('POST');
    $('#myModal').modal('show');
    $('#myModal form')[0].reset();
    $('.modal-title').text('Add Project');
  });

  $(document).on('click', '.btn_edit', function() {
    
    save_method = 'edit';
    var edit_id = $(this).data("id");
    
    $('input[name=_method]').val('PATCH');
    $('#myModal form')[0].reset();
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
    $.ajax({
      url: "{{ url('admin/tasks') }}"+'/'+edit_id+"/edit",
      type: "POST",
      data : {'_method' : 'GET', '_token' : csrf_token},
      dataType: "JSON",
      success: function(responsedata) {
        
        $('#myModal').modal('show');
        $('.modal-title').text('Edit Task');

        $('#hfid').val(responsedata.id);
        $('#title').val(responsedata.title);
        $('#description').val(responsedata.description);
        $('#company').val(responsedata.company);
        $('#project').val(responsedata.project);
        $('#user').val(responsedata.user);
        $('#days').val(responsedata.days);
        $('#hours').val(responsedata.hours);    
      },
      error : function() {
        alert("Nothing Data");
      }
    });

  });

  
  $(document).on('click', '.btn_delete', function() {
  
    var del_id = $(this).data("id");

    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
      title: 'Are you sure?',
      text: 'You would not be able to revert this!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, keep it'
    }).then((result) => {
      
      if(result.value) {
        
        $.ajax({
          url : "{{ url('admin/tasks') }}"+'/'+del_id,
          type : "POST",
          data : {'_method' : 'DELETE', '_token' : csrf_token},
          success : function(data) {
          //window.location.href = "{{ route('users.index') }}";
            SweetAlt.fire({
              type: 'success',
              title: data.message
            });

            table.ajax.reload();  
          },
          error : function () {
            SweetAlt.fire({
              type: 'error',
              title: data.message
            });
          }
        });

       // For more information about handling dismissals please visit
      // https://sweetalert2.github.io/#handling-dismissals
      } else if (result.dismiss === Swal.DismissReason.cancel) {
          return false; 
      }
    });

  });

});  
</script>

@endsection