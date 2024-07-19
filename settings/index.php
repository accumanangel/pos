<?php
include('../networth/header.php');
?>

<style type="text/css">
  .image-area {
    border: 2px dashed rgba(153, 153, 153, 1);
    padding: 1rem;
    position: relative;
}

.image-area::before {
    content: 'Uploaded image result';
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.8rem;
}

.image-area img {
    position: relative;
}
</style>
<!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card rounded-0 shadow">
              <div class="card-header">
                <h3 class="card-title text-default">Your Profile</h3>
              </div>
              <div class="card-body pb-2">
                <div class="row">
                  <div class="col-md-12">
                    <form id="formProfile" name="formProfile" action="../networth/user" method="post"
                                    enctype="multipart/form-data" autocomplete="off">
                      <div class="row">
                        <div class="col-lg-8">
                          <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="shopName" id='shopName' class="form-control rounded-0 form-control" placeholder="Shop / Company Name...">
                            <input type='hidden' name='account' id='account'>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-6">
                          <div class="form-group">
                          <label>Phone Number</label>
                            <input type="text" name="mobile" id='mobile' class="form-control rounded-0 form-control" placeholder="Mobile Number...">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                          <label>Telephone</label>
                            <input type="text" name="telephone" id='telephone' class="form-control rounded-0 form-control" placeholder="Telephone...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                          <label>Email</label>
                            <input type="email" name="email" id='email' class="form-control rounded-0 form-control" placeholder="Email...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                          <label>Street</label>
                          <input type="text" name="street" id='street' class="form-control rounded-0 form-control" placeholder="Street...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->
                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                          <label>City</label>
                          <input type="text" name="city" id='city' class="form-control rounded-0 form-control" placeholder="City...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->
                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                          <label>State/Province</label>
                          <input type="text" name="state" id='state' class="form-control rounded-0 form-control" placeholder="State/Province...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      
                      
                      

                        </div>

                        <div class="col-lg-4">
                          <div class="form-row">
                            <div class="col-lg-12">
                              <div class="form-group">
                              <label>Currency</label>
                                <select class="form-control form-control rounded-0" id='currency' name='currency'>
                                  <option value='0'>Select Currency</option>
                                </select>
                              </div>
                            </div>
                            <!-- /. search box -->                        
                          </div>
                          <!-- /.form row -->
                          <div class="form-row">
                            <div class="col-lg-12">
                              <div class="form-group">
                              <label>Logo</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input id='file' name='file' type="file" class="form-control form-control rounded-0 custom-file-input " id="exampleInputFile" required="">
                                    <label class="custom-file-label form-control form-control-sm rounded-0" for="exampleInputFile">Choose a logo</label>
                                  </div>
                                </div>
                                <small class="form-text text-muted">Only Scalable Vector Graphics (svg) are allowed</small>

                                <div class="image-area mt-4"><img id="imageResult" src="../dist/img/credit/logo.svg" alt="" class="img-fluid rounded mx-auto d-block" ></div>

                              </div>
                            </div>
                            <!-- /. search box -->                        
                          </div>
                      <!-- /.form row -->
                        </div>
                        
                      </div>
                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <div class="row justify-content-between px-2">
                              <button type='submit' class="btn btn-default rounded-0"><i class="fas fa-spinner"></i> Update Profile</button>
                          </div>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                    </form>
                    <!-- /.form add to cart -->
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