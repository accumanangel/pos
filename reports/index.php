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
          <div class="col-12">
            <div class="card rounded-0 shadow">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title text-default">Manage Sales Reports</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-th"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-lg-6">
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">Date From</span>
                                  </div>
                                  <input type="text" id="min" name="min" class="form-control rounded-0"/>
                              </div>
                          </div>
                        </div>
                        <!-- /. date from -->

                        <div class="col-lg-6">
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">Date To</span>
                                  </div>
                                  <input type="text" id="max" name="max" class="form-control rounded-0"/>
                              </div>
                          </div>
                        </div>
                        <!-- /. date from -->

                        
                    </div>
                    <!-- /.form add to cart -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="">
                    <table id="tblReport" class="table table-hover text-nowrap">
                  <thead>
                  <tr>
                    <th>Order</th>
                    <th>Client Name</th>
                    <th>Method</th>
                    <th>Total</th>
                    <th>Balance</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>cashier</th>
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
            </div>
            <!-- /.card -->
          </div>
          <div class="receipt-modal">
            <div class="modal fade" id="modal-receipt">
                
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-dark-grey rounded-0">

                        <div class="modal-body position-relative p-3" id="myInvoice">
                            <div class="ribbon-wrapper ribbon-xl">
                                <div id="myRibbon" class="ribbon shadow-none  text-xl">
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
        </div>
        <!-- /.row -->
        <div class="add-user-modal">
            <div class="modal fade" id="modal-order">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content bg-dark-grey rounded-0">
                        <div class="modal-header">
                          <h4 class="modal-title">Order</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div id="formClient" name="formClient" action="../networth/user" method="post"
                                enctype="multipart/form-data" autocomplete="off">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Transaction:</label>
                                            <input type="text" name="trans_id" id="trans_id"
                                                class="form-control rounded-0"
                                                placeholder="Transaction" required readonly="true">
                                        </div>
                                    </div>
                                    <!-- /. search box -->
                                </div>
                                <!-- /.form row -->
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Amount Due:</label>
                                            <input type="text" name="amtDue" id="amtDue"
                                                class="form-control rounded-0"
                                                placeholder="Amount due..." readonly="true">
                                        </div>
                                    </div>
                                    <!-- /. search box -->
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Amount Paid:</label>
                                            <input type="text" name="amtPaid" id="amtPaid"
                                                class="form-control rounded-0"
                                                placeholder="Amount paid...">
                                        </div>
                                    </div>
                                    <!-- /. search box -->
                                </div>
                                <!-- /.form row -->
                                <div class="px-2 row justify-content-between">
                                    <button type="submit" class="btn btn-default rounded-0" id="btnSavePay"><i
                                            class="fa fa-shopping-bag"></i>
                                        Update Order</button>
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
        <!-- /. order update modal -->


      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->


<?php 
include('../networth/footer.php');
?>
<script>
$(function () {


    var minDate, maxDate;
 
    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date( data[5] );
     
            if (
                ( min === null && max === null ) ||
                ( min === null && date <= max ) ||
                ( min <= date   && max === null ) ||
                ( min <= date   && date <= max )
            ) {
                return true;
            }
            return false;
        }
    );



    minDate = new DateTime($('#min'), {
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime($('#max'), {
        format: 'MMMM Do YYYY'
    });
 
    // DataTables initialisation
    var table = $('#tblReport').DataTable();
 
    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });



});

</script>