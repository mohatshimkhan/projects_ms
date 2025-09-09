@extends('layouts.master')

@section('extraStyles')

@endsection 

@section('content')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Companies
        <!--<small>Admin panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Companies</li>
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
                      <th>Name</th>
                      <th>Description</th>
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
                          <label for="exampleInputName1">Name</label>
                          <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                           <strong style="color:red; font-weight:lighter; display:none;" class="error-name"></strong>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputDescription">Description</label>
                          <textarea class="form-control" name="description" id="description" placeholder="Enter name"></textarea>
                           <strong style="color:red; font-weight:lighter; display:none;" class="error-description"></strong>
                        </div>
                        
                        <div class="form-group">&nbsp;</div>

                        <div class="form-group">
                          <div class="checkbox icheck">
                            <label>
                              <input type="checkbox" name="is_active" id="is_active" checked>&nbsp;<b>Active</b>
                            </label>
                             <div class="help-block with-errors"></div>
                          </div>
                        </div>

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
    ajax: "{{ route('companies.list') }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex'},
        { data: 'name', name: 'name'},
        { data: 'description', name: 'description'},
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

  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });


  $('#myForm').on('submit', function (event) {

    event.preventDefault();

    var id = $('#hfid').val();
    
    if(save_method == 'add') 
      url = "{{ url('admin/companies') }}";
    else 
      url = "{{ url('admin/companies') . '/' }}"+id;

    var formData = $(this).serialize();
    
    $.ajax({
      type: 'POST',
      url :  url,
      data:  formData,
      success: function (responseData) {
        //console.log(responseData);
        $('.error-name').hide();
        $('.error-description').hide();
        $('.error-active').hide();

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
      
        if(respErrors.name) {
          $('.error-name').show().text(respErrors.name);
        } else {
          $('.error-name').hide();
        }
        
        if(respErrors.description) {
            $('.error-description').show().text(respErrors.description);
        } else {
            $('.error-description').hide();
        }

        if(respErrors.active) {
          $('.error-active').show().text(respErrors.active);
        } else {
          $('.error-active').hide();
        }   
      
      }
    
    });

  });

  $(document).on('click', '.btn_addnew', function() {
    
    save_method = "add";

    $('input[name=_method]').val('POST');
    $('#myModal').modal('show');
    $('#myModal form')[0].reset();
    $('.modal-title').text('Add Company');
  });

  $(document).on('click', '.btn_edit', function() {
    
    save_method = 'edit';
    var edit_id = $(this).data("id");
    
    $('input[name=_method]').val('PATCH');
    $('#myModal form')[0].reset();
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
    $.ajax({
      url: "{{ url('admin/companies') }}"+'/'+edit_id+"/edit",
      type: "POST",
      data : {'_method' : 'GET', '_token' : csrf_token},
      dataType: "JSON",
      success: function(responsedata) {
        
        $('#myModal').modal('show');
        $('.modal-title').text('Edit Company');

        $('#hfid').val(responsedata.id);
        $('#name').val(responsedata.name);
        $('#description').val(responsedata.description);
        //console.log(responsedata.is_active);
        if(responsedata.is_active=='1'){
          //$('#is_active').prop("checked", true);
          $('div.icheckbox_square-blue').addClass('checked');
        } else {
          //$('#is_active').prop("checked", false);
          $('div.icheckbox_square-blue').removeClass('checked');
        }
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
          url : "{{ url('admin/companies') }}"+'/'+del_id,
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