<?php
include('../networth/header.php');
?>


<!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          
          <div class="col-lg-12">
            <div class="card rounded-0 shadow">
              <div class="card-header">
                <h3 class="card-title text-default">Manage your clients</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="row">
                  <div class="col-lg-12">
                    <form name="saveMyClient" id="saveMyClient"  autocomplete="off">
                    <div class="form-row">
                        <div class="col-lg-4">
                          <div class="form-group">
                            <input type="text" name="clientName" id="clientName" class="form-control rounded-0" placeholder="Company/Client's name...">
                            <input type="hidden" name="clientUId" id="clientUId">
                            
                          </div>
                        </div>

                        <div class="col-lg-2">
                          <div class="form-group">
                            <input type="text" name="phoneNumber" id="phoneNumber" class="form-control rounded-0" placeholder="Phone Number...">
                            
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <input type="text" name="clientemail" id="clientemail" class="form-control rounded-0" placeholder="Email...">
                            
                          </div>
                        </div>
                        <div class="col-lg-2">
                          <div class="form-group">
                            <button type="submit" class="btn btn-block btn-default rounded-0" id="btnSaveCleint" name="btnSaveClient"><i class="fas fa-user-plus"></i> Save Client</button>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->
                      <div class="form-row">
                        
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->
                      <div class="row px-2 justify-content-between">
                        
                      </div>
                  </form>
                  </div>
                  
                </div>
                <div class="">
                  <table id="tblCustomer" class="table table-hover text-nowrap">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Orders</th>
                    <th>Spend</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                </table>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer"></div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->



        <div class="delete-modal">
          <div class="modal fade" id="modal-delclient">
            <div class="modal-dialog modal-md">
              <div class="modal-content bg-dark-grey rounded-0">
                <div class="modal-header">
                  <p class="modal-title">Confirm Deletion</p>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <p>Are you sure you want to permanently remove this record?</p>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->
                  </form>
                </div>
                <div class="btn-group justify-content-between">
                  <button type="button" class="btn btn-default rounded-0 pt-3 pb-3" id="delclient">Yes, I am Sure</button>
                  <button type="button" class="btn btn-default rounded-0 pt-3 pb-3"  data-dismiss="modal">No, Cancel</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
        </div>
        <!-- /. add expense modal -->

        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->


<?php 
include('../networth/footer.php');
?>
<script>
var valDate = new DateTime($('#validity'), {
        format: 'YYYY-MM-DD',
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        showOn: "button",
        minDate: new Date(1964,12, 31),
    });

</script>