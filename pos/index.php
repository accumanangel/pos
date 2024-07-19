<?php
include('../networth/header.php');
?>
<style type="text/css">
    @media screen {
  #printSection {
      display: none;
      overflow: visible;
  }
}

@media print {
  body * {
    visibility:hidden;
    -webkit-print-color-adjust: exact;
  }
  #printSection, #printSection * {
    visibility:visible;
    overflow: visible;
  }
  #printSection {
    position:absolute;
    top: 0%;  /* position the top  edge of the element at the middle of the parent */

    /*transform: translate(-50%, -50%); */
    max-width: 100%;
    width: 100%;
    overflow: visible;
    font-size: 20px;

  }
  .table th{
        background-color: #f7f7f7 !important;
    }


}



</style>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">


        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="card rounded-0 shadow">
                    <div class="card-body pb-2">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="formCart" name="formCart" action="../networth/user.php" method="post"
                                    enctype="multipart/form-data" autocomplete="off">
                                    <div class="form-row">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <select class="form-control  select2 select2-dark"
                                                    name="pro_code" id="productDropDown"
                                                    data-dropdown-css-class="select2-dark"
                                                    style="width: 100%; border-radius: 0px !important;">
                                                    <option data-price="0" value="0">Search Product</option>

                                                </select>
                                            </div>
                                        </div>
                                        <!-- /. search box -->

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <input type="number" min="1" name="productQuantity" id="productQuantity"
                                                    class="form-control rounded-0" placeholder="Qty">
                                            </div>
                                        </div>
                                        <!-- /. search box -->

                                        <div class="col-lg-3">
                                            <div class="form-group input-group">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fas fa-dollar-sign"></i>
                                                    </div>
                                                </div>
                                                <input type="text" name="productTotal" id="productTotal"
                                                    class="form-control rounded-0" placeholder="Total">
                                            </div>
                                        </div>
                                        <!-- /. search box -->

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <button class="btn btn-default btn-block rounded-0" id="btnAddToCart"><i
                                                        class="fas fa-shopping-basket"></i> Cart</button>
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
                    </div>
                    <!-- ./card-body -->
                </div>
                <!-- /.card -->
                <div class="card rounded-0 shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tblCart" class="table table-hover text-nowrap">
                            <thead class="">
                                <tr>
                                    <th>Code</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <!-- ./card-body -->
                </div>
                <!-- /.card -->
            </div>


            <div class="col-lg-4 col-md-12">
                <div class="card rounded-0 shadow">
                    <div class="card-body pb-2">
                    <div class="row">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          <label>Customer</label>
                                            <div class="form-row">
                                                <input type="hidden" name="transactionType" id="transactionType" value="1">
                                                <div class="col-lg-10">
                                                    <select class="form-control  select2 select2-dark rounded-0"
                                                        data-dropdown-css-class="select2-dark" style="width: 100%;" id='client'
                                                        name='client'>

                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <button class="btn btn-default rounded-0" id="launchClient"><i class="fa fa-user-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- /. search box -->

                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row justify-content-between px-2">
                                    <p>Sub Total:</p>
                                    <p><a href="#"><b><span id="subTotal">$0.00</span></b></a></p>
                                </div>



                                <div class="row">
                                    <div class="col-lg-6">
                                        <p>Discount %:</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-warning"><input type="number" min="0" name="discount" id="discount"
                                                class=" form-control rounded-0" placeholder="Discount %">
                                        </p>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <p>Payment Method:</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p><select class="form-control rounded-0" id='pay-method'
                                            name='pay-method'>
                                    </select></p>
                                    </div>
                                    
                                </div>

                                

                                <hr>


                                <div class="row justify-content-between px-2">
                                    <p>Total:</p>
                                    <p class="text-default"><b><span id="totalFee">$0.00</span></b></p>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6">
                                        <p>Tendered:</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-warning"><input type="number" min="0" name="amtTendered" id="amtTendered"
                                                class=" form-control rounded-0" placeholder="Amount Paid">
                                        </p>
                                    </div>
                                    
                                </div>


                                <div class="row justify-content-between px-2">
                                    
                                    
                                </div>

                                <div class="row justify-content-between px-2">
                                    <p>Change:</p>
                                    <p class="text-default"><b><span name="amtChange" id="amtChange">$0.00</span></b>
                                    </p>
                                </div>
                                <hr>
                                <div class="row justify-content-between px-2 pb-4">
                                    <button class="btn btn-default rounded-0" id='checkout' name='checkout'><i
                                            class="fas fa-shopping-bag"></i> Checkout</button>
                                            <!--<button id="testMod">Test</button>-->
                                    <button id="btnVoid" name="btnVoid" class="btn btn-danger rounded-0"><i class="fas fa-times"></i>
                                        Cancel</button>
                                </div>
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



        <div class="receipt-modal">
            <div class="modal fade" id="modal-receipt">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-dark-grey rounded-0">

                        <div class="modal-body position-relative p-3" id="myInvoice">
                            <div class="ribbon-wrapper ribbon-xl">
                                <div id="myRibbon" class="ribbon shadow-none text-xl">
                                  <b><span id="ribbon-text"></span></b>
                                </div>
                            </div>
                            <div class="row myInvoice">
                                <div class="col-12">
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <img src="../dist/img/metipix.png" height="60">
                                        </div>
                                        <div class="col-6">
                                            
                                        </div>        
                                    </div>
                            <div class="row bg-light mb-3">
                                <div class="col-6 pt-3">
                                    <p class=""><b>Transaction Date:</b> <span id="orderDate">N/A</span></p>
                                </div>
                                <div class="col-6">
                                    
                                </div>     
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class=""><b>Invoiced To:</b><br><span id="rec_client">N/A</span><br><span id="rec_client_phone"></span><br><span id="rec_client_email"></span></p>
                                </div>
                                <div class="col-6 text-right">
                                    <p class=""><b>Company:</b><br><span id="rece_company_name"></span><br><span id="rece_street"></span><br><span id="rece_city"></span><br><span id="rece_state"></span></p>
                                </div>     
                            </div>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-sm border border-top border-1">
                                        <thead class="bg-light border border-top border-1">
                                            <th>#</th>
                                            <th>Description</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </thead>
                                        <tbody id="rece_items">
                                            
                                        </tbody>
                                        <tfoot class="bg-light border border-top border-1">
                                            <tr class="tfoot">
                                                <th colspan="3"></th>
                                                <th><b>Subtotal</b></th>
                                                <th id="rece_sub_total">$0.00</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3"></th>
                                                <th><b>Discount</b></th>
                                                <th><span id="rece_discount">0</span>%</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3"></th>
                                                <th><b>Total</b></th>
                                                <th id="rece_total">$0.00</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3"></th>
                                                <th><b>Change</b></th>
                                                <th id="rece_change">$0.00</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-12 table-responsive pt-3">

                                    <table class="table table-sm border border-top border-1">
                                        <thead class="bg-light border border-top border-1">
                                            <th>Transaction Date</th>
                                            <th>Gateway</th>
                                            <th>Transaction ID</th>
                                            <th>Tendered</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class=""><span id="rece_trans_date"></span></td>
                                                <td class=""><span id="rece_gateway"></span></td>
                                                <td class=""><span id="rece_trans_id"></span></td>
                                                <td class=""><span id="rece_amount_paid"></span></td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="bg-light border border-top border-1">
                                            <tr>
                                                <th colspan="3" class="text-right"><b>Balance</b></th>
                                                <th><span id="rece_balance"></span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>     
                            </div> 
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p class="">PDF generated on <span id="rece_date_gen"></span></p>
                                </div>
                            </div>                                       
                                </div>
                                
                            </div>

                            
                            

                        </div>
                        <div class="row mb-4">
                                
                                <div class="col-12 text-center">
                                    <div class="btn-group">
                                        <button id="printInvoice" class="btn btn-default rounded-0"><i class="fa fa-print"></i> Print or Download PDF</button>
                                        <button id="close" class="btn btn-default rounded-0"  data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                    </div>
                                </div>     
                            </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <!-- /. receipt modal -->




        <div class="add-user-modal">
            <div class="modal fade" id="modal-client">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content bg-dark-grey rounded-0">
                        <div class="modal-header">
                          <h4 class="modal-title">Client</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form id="formClient" name="formClient" action="../networth/user" method="post"
                                enctype="multipart/form-data" autocomplete="off">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Fullname:</label>
                                            <input type="text" name="clientName" id="clientName"
                                                class="form-control rounded-0"
                                                placeholder="Client / Company Name..." required>
                                        </div>
                                    </div>
                                    <!-- /. search box -->
                                </div>
                                <!-- /.form row -->
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Phone:</label>
                                            <input type="text" name="phoneNumber" id="phoneNumber"
                                                class="form-control rounded-0"
                                                placeholder="Phone Number...">
                                        </div>
                                    </div>
                                    <!-- /. search box -->
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" name="clientemail" id="clientemail"
                                                class="form-control rounded-0"
                                                placeholder="email...">
                                        </div>
                                    </div>
                                    <!-- /. search box -->
                                </div>
                                <!-- /.form row -->
                                <div class="px-2 row justify-content-between">
                                    <button type="submit" class="btn btn-default rounded-0" id="saveClient"><i
                                            class="fa fa-user-plus"></i>
                                        Save</button>
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
        <!-- /. add customer modal -->

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->


<?php 
include('../networth/footer.php');
?>
<script>
$(function() {

    //Initialize Select2 Elements
    $('.select2').select2()


})
</script>