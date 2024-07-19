<?php
include('../networth/header.php');
?>


<!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card rounded-0 shadow">
              <div class="card-header">
                <h3 class="card-title text-default">Manage your Categories</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool">
                    <span id="message"></span>
                  </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body pb-2">
                <div class="row">
                  <div class="col-md-12">
                    <form class="form-category" id="form-category" action="../networth/user.php" method="post" enctype="multipart/form-data" autocomplete="off">
                      <div class="form-row">
                        <div class="col-lg-9">
                          <div class="form-group">
                            <input type="text" name="category" id="category" class="form-control rounded-0" placeholder="Enter category..." required>
                          </div>
                        </div>
                        <!-- /. search box -->

                        <div class="col-lg-3">
                          <div class="form-group">
                            <button class="btn btn-default btn-block rounded-0"><i class="fas fa-upload"></i> Save Category</button>
                          </div>
                        </div>
                        <!-- /. search box -->
                        
                      </div>
                    </form>
                    <!-- /.form add to cart -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">
                  <div class="col-md-12 table-responsive">
                    <table id="tblCategory" class="table table-hover text-nowrap">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th>Date Created</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="delete-modal">
          <div class="modal fade" id="modal-delCat">
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
                  <button type="button" class="btn btn-danger rounded-0" id="delCat">Yes, I am Sure</button>
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
$(function () {
$(document).ready(function () {
  bsCustomFileInput.init();
});
})

</script>