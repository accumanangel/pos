<?php
include('../networth/header.php');
?>


<!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <div class="row">
          <div class="col-lg-4 col-md-12">
            <div class="card rounded-0 shadow">
              <div class="card-header">
                <h3 class="card-title text-default">Store Overview</h3>
                
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-md-6">
                    <div class="info-box shadow">
                      <span class="info-box-icon bg-success"><i class="fas fa-funnel-dollar"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Daily Sales</span>
                        <span class="info-box-number">
                          <span id="daily">$0.00</span>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
                  <!-- /.col -->

                  <div class="col-lg-12 col-sm-12 col-md-6">
                    <div class="info-box shadow">
                      <span class="info-box-icon bg-primary"><i class="fas fa-poll"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Weekly Sales</span>
                        <span class="info-box-number">
                          <span id="weekly">$0.00</span>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
                  <!-- /.col -->

                  <div class="col-lg-12 col-sm-12 col-md-6">
                    <div class="info-box shadow">
                      <span class="info-box-icon bg-warning"><i class="fas fa-dolly"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Products</span>
                        <span class="info-box-number">
                          <span id="products">0</span>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
                  <!-- /.col -->

                  <div class="col-lg-12 col-sm-12 col-md-6">
                    <div class="info-box shadow">
                      <span class="info-box-icon bg-danger"><i class="fas fa-box-open"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Low Stock</span>
                        <span class="info-box-number">
                          <span id="employees">0</span>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
                  <!-- /.col -->
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-lg-8 col-md-12">
            <div class="card rounded-0 shadow">
              <div class="card-header">
                <h5 class="card-title text-default">Weekly Recap</h5>

                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-center">
                      <strong>Sales</strong>
                    </p>

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart" height="233" style="height: 233px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer bg-white border border-top">
                <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="description-block">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i></span>
                      <h5 class="description-header"><span id="revenue">$0.00</span></h5>
                      <span class="description-text text-success">REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="description-block">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i></span>
                      <h5 class="description-header"><span id="cost">$0.00</span></h5>
                      <span class="description-text text-success">COSTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="description-block">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i></span>
                      <h5 class="description-header"><span id="expense">$0.00</span></h5>
                      <span class="description-text text-success">EXPENSES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-lg-12">
            <div class="card rounded-0 shadow">
              <div class="card-header border-0">
                <h3 class="card-title text-default">Top Trending Products</h3>
              </div>
              <div class="card-body  table-responsive p-0">
                <table id="tblTrending" class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                      <th>Code</th>
                      <th>Desciption</th>
                      <th>Sold</th>
                      <th>Sales</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                  </table>
              </div>
            </div>
            
          </div>

          <!-- /. col -->
          <div class="col-lg-12">
            <div class="card rounded-0 shadow">
              <div class="card-header border-0">
                <h3 class="card-title text-default">Low Stock Products</h3>
              </div>
              <div class="card-body mb-4  table-responsive p-0">
                <table id="tblLowStock" class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                      <th>Code</th>
                      <th>Desciption</th>
                      <th>Price</th>
                      <th>Remained</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                  </table>
              </div>
            </div>
            
          </div>

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
var formatter = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  });
/**********************
   * SALES CHART
   * ********************/
  function salesChart() {
    var action = "ldSalesChart";
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: action },
      success: function (response) {
        var sale=JSON.parse(response);
        let dataSales=[];
        let labels=[];
        var sum=0;

        $.each(sale, function (i, item) {
          $.each(item, function (key, value) {
            
            x=parseFloat(value.sale);
            //console.log(x);
            dataSales[key]=x;
            labels[key]=[value.Date];
            sum=sum+dataSales[key];
            
          });
        });
        var daily=sale['data'][6][1];
        $("#daily").text(formatter.format(daily));
        $("#weekly").text(formatter.format(sum));

        'use strict'

        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //-----------------------
        //- MONTHLY SALES CHART -
        //-----------------------

        // Get context with jQuery - using jQuery's .get() method.
        var salesChartCanvas = $('#salesChart').get(0).getContext('2d')

        var salesChartData = {
          labels  : labels,
          datasets: [
            {
              label               : 'Sales',
              backgroundColor     : 'rgba(92, 184, 92, 0.5)',
              borderColor         : 'rgba(92, 184, 92, 1)',
              borderWidth         : 2,
              pointRadius         : 3,
              pointColor          : 'rgba(92, 184, 92, 1)',
              pointStrokeColor    : '#c1c7d1',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data                : dataSales
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio : false,
          responsive : true,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              gridLines : {
                display : true,
              }
            }],
            yAxes: [{
              gridLines : {
                display : true,
              }
            }]
          }
        }

        // This will get the first returned node in the jQuery collection.
        var salesChart = new Chart(salesChartCanvas, { 
            type: 'line', 
            data: salesChartData, 
            options: salesChartOptions
          }
        )

        //---------------------------
        //- END MONTHLY SALES CHART -
        //---------------------------

        
      },
    });
  }

  //call function
  salesChart();

})

</script>