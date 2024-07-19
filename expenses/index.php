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
                <h3 class="card-title text-default">Manage your Expenses</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="row">
                  <div class="col-lg-12">
                    <form name="formExpense" id="formExpense" method="post" action="../networth/user.php" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-row">
                        <div class="col-lg-5">
                          <div class="form-group">
                            <input type="text" name="expense" id="expense" class="form-control rounded-0" placeholder="Desciption...">
                            <input type="hidden" name="id" id="id">
                            
                          </div>
                        </div>

                        <div class="col-lg-2">
                          <div class="form-group">
                            <input type="text" name="amount" id="amount" class="form-control rounded-0" placeholder="Amount...">
                            
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <div class="form-group">
                            <input type="text" name="validity" id="validity" class="form-control rounded-0" placeholder="Valid Until...">
                            
                          </div>
                        </div>
                        <div class="col-lg-2">
                          <div class="form-group">
                            <button type="submit" class="btn btn-block btn-default rounded-0" id="saveExpense" name="saveExpense"><i class="fas fa-spinner"></i> Save Expense</button>
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
                  <table id="tblExpense" class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Desciption</th>
                      <th>Amount</th>
                      <th>Valid Until</th>
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
          <div class="modal fade" id="modal-delExpense">
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
                  <button type="button" class="btn btn-danger rounded-0" id="delExpense">Yes, I am Sure</button>
                  <button type="button" class="btn btn-success rounded-0"  data-dismiss="modal">No, Cancel</button>
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