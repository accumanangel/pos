<?php
include('../networth/header.php');
?>


<!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card rounded-0 shadow">
              <div class="card-header">
                <h3 class="card-title text-default">Manage your Products</h3>
                <div class="card-tools pr-2">
                  <a href="#" class="btn btn-tool btn-default rounded-0" id="launchModalProduct">
                    <i class="fas fa-upload"></i> Product
                  </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tblProduct" class="table table-hover text-nowrap">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Cost</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Size</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer"></div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

        <div class="add-product-modal">
          <div class="modal fade" id="modal-product">
            <div class="modal-dialog modal-md">
              <div class="modal-content bg-dark-grey rounded-0">
                <div class="modal-header">
                  <h4 class="modal-title">Product</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="../networth/user.php" method="post" enctype="multipart/form-data" autocomplete="off" name="formProduct" id="formProduct">
                    <div class="form-row pt-3">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Product name:</label>
                            <input type="text" name="item_name" id="item_name" class="form-control rounded-0" placeholder="Product name...">
                            <input type="hidden" name="pro_id" id="pro_id">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Category:</label>
                            <select class="form-control rounded-0"name="categoryDropDown" id="categoryDropDown">
                              <option value="0">--Select Category--</option>
                            </select>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Cost price:</label>
                            <input type="text" name="cost_price" id="cost_price" class="form-control rounded-0" placeholder="Cost Price...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Selling Price:</label>
                            <input type="text" name="selling_price" id="selling_price" class="form-control rounded-0" placeholder="Selling Price...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Minimum Quantity</label>
                            <select class="form-control rounded-0" name="min_quantity" id="min_quantity">
                              
                              <option value="0">--Min Quantity--</option>
                              <option value="5">5</option>
                              <option value="10">10</option>
                              <option value="15">15</option>
                              <option value="20">20</option>
                              <option value="20">30</option>
                            </select>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Quantity:</label>
                            <input type="number" name="quantity" id="quantity" class="form-control rounded-0" placeholder="Quantity...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->


                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Size</label>
                            <input type="number" name="size" id="size" class="form-control rounded-0" placeholder="Size...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->
                      

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Units:</label>
                            <select class="form-control rounded-0" name="units" id="units">
                              
                              <option value="Units">--Select Units--</option>
                              <option value="pc">Piece(s)</option>
                              <option value="ml">Milligram</option>
                              <option value="g">Gram</option>
                              <option value="kg">Kilogram</option>
                              <option value="ml">Millilitres</option>
                              <option value="l">Litres</option>
                              <option value="box(s)">Box(s)</option>
                              <option value="pack(s)">Pack(s)</option>                              <option value="mm">Millimeter</option>
                              <option value="cm">Centimeter</option>
                              <option value="m">Meter</option>
                              <option value="in.">Inch</option>
                            </select>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      


                      <div class="row form-group px-2 justify-content-between">
                        <button type="submit" class="btn btn-default rounded-0" name="saveItem" id="saveItem">Save Product</button>
                        
                      </div>
                  </form>
                </div>
                
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
        </div>
        <!-- /. add product modal -->

        <div class="delete-modal">
          <div class="modal fade" id="modal-delProduct">
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
                  <button type="button" class="btn btn-danger rounded-0" id="delProduct">Yes, I am Sure</button>
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
    