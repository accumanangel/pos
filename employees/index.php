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
                <h3 class="card-title text-default">Manage your Users</h3>
                <div class="card-tools px-2">
                  <a href="#" class="btn btn-tool btn-default rounded-0" id="launchModalEmp">
                    <i class="fas fa-plus"></i> User
                  </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="">
                  <table id="tblEmployee" class="table table-hover text-nowrap">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Gender</th>
                    <th>Position</th>
                    <th>Sales</th>
                    <th>Phone</th>
                    <th>Status</th>
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
              <div class="card-footer" id="footerTable">
                
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

        <div class="add-employee-modal">
          <div class="modal fade" id="modal-employee">
            <div class="modal-dialog modal-md">
              <div class="modal-content bg-dark-grey rounded-0">
                <div class="modal-header">
              <h4 class="modal-title">User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <div class="modal-body">
                  <form method="POST" id="form-employee" name="form-employee" enctype="multipart/form-data" autocomplete="off" action="../networth/user.php">
                    <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Title:</label>
                            <select class="form-control rounded-0" id="title" name="title" required="">
                              <option>--Choose Title--</option>
                              <option>Mr.</option>
                              <option>Mrs.</option>
                              <option>Miss.</option>
                              <option>Dr.</option>
                            </select>
                            <input type="hidden" name="id" id="id" class="form-control rounded-0" placeholder="Firstname..." >
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->
                    <div class="form-row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Name:</label>
                            <input type="text" name="name" id="name" class="form-control rounded-0" placeholder="Firstname..." required="">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Surname:</label>
                            <input type="text" name="surname" id="surname" class="form-control rounded-0" placeholder="Surname..." required="">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Gender:</label>
                            <select class="form-control rounded-0" id="gender" name="gender" required="">
                              <option>--Select Gender--</option>
                              <option>Male</option>
                              <option>Female</option>
                            </select>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->
                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Date of Birth:</label>
                              <div class="input-group date" id="dateOfBirth" data-target-input="nearest">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">Date Of Birth</span>
                                  </div>
                                  <input type="text" id="dob" name="dob" required="" class="form-control rounded-0 datetimepicker-input" data-target="#dateOfBirth"/>
                                  <div class="input-group-append" data-target="#dateOfBirth" data-toggle="datetimepicker">
                                      <div class="input-group-text rounded-0"><i class="fa fa-calendar-alt"></i></div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" id="email" required="" class="form-control rounded-0" placeholder="Email...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Phone:</label>
                            <input type="text" name="phone" id="phone" required="" class="form-control rounded-0" placeholder="Phone Number...">
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Password:</label>
                            <div class="input-group mb-3">
                              <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Password">
                              <div class="input-group-append" style="cursor: pointer;" id="toggle-pwd">
                                <span class="input-group-text rounded-0 form-control"><i id="eye" class="fas fa-eye-slash"></i></span>
                              </div>
                              <div class="input-group-append" style="cursor: pointer;" id="generate-pwd">
                                <span class="input-group-text rounded-0 form-control">Generate</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Address:</label>
                            <textarea class="form-control rounded-0" required="" id="address" name="address" rows="2" placeholder="Enter Address..."></textarea>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Date employed:</label>
                              <div class="input-group date" id="dateEmployed" data-target-input="nearest">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">Date Employed</span>
                                  </div>
                                  <input type="text" id="emp_date" required="" name="emp_date" class="form-control rounded-0 datetimepicker-input" data-target="#dateEmployed"/>
                                  <div class="input-group-append" data-target="#dateEmployed" data-toggle="datetimepicker">
                                      <div class="input-group-text rounded-0"><i class="fa fa-calendar-alt"></i></div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Role:</label>
                            <select class="form-control rounded-0" required="" id="role" name="role">
                              <option>--Role--</option>
                              <option>admin</option>
                              <option>cashier</option>
                            </select>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->

                      <div class="form-row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Account Status:</label>
                            <select class="form-control rounded-0" required="" id="status" name="status">
                              <option>--Account Status--</option>
                              <option value="1">Active</option>
                              <option value="0">Suspended</option>
                            </select>
                          </div>
                        </div>
                        <!-- /. search box -->                        
                      </div>
                      <!-- /.form row -->
                      <div class="row px-2 justify-content-between">
                        <button type="submit" class="btn btn-default rounded-0" id="btnEmp" name="btnEmp">Save</button>
                        <button type="button" class="btn btn-danger rounded-0"  id="userDelete" >...</button>
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
        <!-- /. add employee modal -->


        <div class="delete-modal">
          <div class="modal fade" id="modal-delEmployee">
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
                  <button type="button" class="btn btn-danger rounded-0" id="delEmployee">Yes, I am Sure</button>
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

  //Date range picker
    $('#dateOfBirth').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#dateEmployed').datetimepicker({
        format: 'YYYY-MM-DD'
    });

});
</script>