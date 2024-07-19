$(document).ready(function () {
  var audio = new Audio("../dist/beep/beep.wav");
  function currency() {
    var curr = $("#shopCurrency").text();
    return curr;
  }
  /*********************
   * initialize toast***
   * *******************/
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
  });

  /***************
   * VIEW/HIDE PWD
   * *************/
  $("#toggle-pwd").click(function (e) {
    $("#eye").toggleClass("fa-eye-slash fa-eye");

    var input = $("#password");

    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  /***************************
   * GENERATE PASSWORD********
   * *************************/
  $("#generate-pwd").click(function (e) {
    var pwd = Math.random().toString(36).substr(2, 9);
    $("#password").val(pwd);
  });

  /***************************
   * POPULATE CATEGORIES
   * *-***********************/
  function loadProducts() {
    var action = "ldProducts";
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: action },
      success: function (response) {
        var opts = JSON.parse(response);
        //console.log(opts);
        $.each(opts, function (i, item) {
          $.each(item, function (key, value) {
            //console.log(value.product_code);
            $("#productDropDown").append(
              '<option data-price="' +
                value.selling_price +
                '" value="' +
                value.product_code +
                '">' +
                value.size +
                "" +
                value.units.toLowerCase() +
                " " +
                value.name +
                "</option>"
            );
          });
        });
      },
    });
  }
  function getDashboard() {
    var action = "ldDashboard";
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: action },
      success: function (response) {
        var data = JSON.parse(response);
        //console.log(data);
        $("#cost").text(formatter.format(data["data"][1][0]));
        $("#revenue").text(formatter.format(data["data"][0][0]));
        $("#expense").text(formatter.format(data["data"][4][0]));
        $("#products").text(parseInt(data["data"][3][0]));
        $("#employees").text(parseInt(data["data"][2][0]));
      },
    });
  }
  function getSubTotal() {
    var action = "subtotal";
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: action },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          $("#subTotal").text(formatter.format(data.total));

          var disc = $("#discount").val();

          if (disc == "") {
            disc = 0;
          }
          var tot = data.total - disc;

          $("#totalFee").text(formatter.format(tot));
        } else {
          //console.log(data.message);
        }
      },
    });
  }

  /**
   * CALCULATE TOTAL PRICE
   * **/
  $("#discount").on("input", function () {
    var disc = $(this).val();
    if (disc == "") {
      disc = 0;
    }
    var x = $("#subTotal").text();
    var subTotal = parseFloat(x.replace(/[^0-9\.-]+/g, "")).toFixed(2);

    var discounted_price = (disc / 100) * subTotal;

    var total = subTotal - discounted_price;
    $("#totalFee").text(formatter.format(total));
    $("#amtTendered").val("");
    $("#amtChange").text("$0.00");
  });

  $("#amtTendered").on("input", function () {
    var tender = $(this).val();
    if (tender == "") {
      tender = 0;
    }
    var x = $("#totalFee").text();
    var subTotal = parseFloat(x.replace(/[^0-9\.-]+/g, "")).toFixed(2);

    if (tender < subTotal) {
      change = 0;
    } else if (tender >= subTotal) {
      var change = tender - subTotal;
    }
    $("#amtChange").text(formatter.format(change));
  });

  //fetch subtotal
  getSubTotal();
  var eventProduct = $("#productDropDown");
  eventProduct.select2();
  $("#productDropDown").on("change", function (e) {
    $("#productQuantity").val(1);
    var qty = $("#productQuantity").val();
    var element = $("#productDropDown").find("option:selected");
    var price = element.attr("data-price");
    var pTotal = (qty * price).toFixed(2);
    var total = $("#productTotal");
    total.val(pTotal);
  });

  var formatter = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  });

  /**
   * CALCULATE TOTAL PRICE
   * **/
  $("#productQuantity").on("input", function () {
    var qty = $(this).val();
    var element = $("#productDropDown").find("option:selected");
    var price = element.attr("data-price");
    var pTotal = (qty * price).toFixed(2);
    var total = $("#productTotal");
    total.val(pTotal);
  });

  /**
   * add product to cart
   * */
  $("#formCart").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    // avoid to execute the actual submit of the form.

    var url = form.attr("action");
    var qty = $("#productQuantity").val();
    var element = $("#productDropDown").find("option:selected");
    var selected = element.attr("data-price");

    var data = form.serializeArray();
    data.push({ name: "action", value: "addToCart" });
    data.push({ name: "cost_price", value: selected });

    if (selected == "0" || qty == "") {
      $("#productQuantity").focus();
      Toast.fire({
        icon: "warning",
        title: "Select Product and quantity!",
      });
    } else {
      $.ajax({
        type: "POST",
        url: url,
        data: data, // serializes the form's elements.
        beforeSend: function () {
          //console.log(data)
          $("#btnAddToCart").html('<i class="fas fa-spinner"></i> Adding...');
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 1) {
            audio.play();
            $("#subTotal").text(formatter.format(data.total));
            Toast.fire({
              icon: "success",
              title: data.message,
            });
            $("#tblCart").DataTable().ajax.reload();
            //$('#tblCart').DataTable().draw();
            document.getElementById("formCart").reset();
            $("#amtTendered").val("");
            $("#amtChange").text("$0.00");
            $("#discount").val("");
            $("#totalFee").text(formatter.format(data.total));
            $("#btnAddToCart").html('<i class="fas fa-shopping-cart"></i> Add');
          } else {
            $("#productQuantity").focus();
            Toast.fire({
              icon: "error",
              title: data.message,
            });
          }
        },
      });
    }
  });

  /***************************
   * POPULATE PRODUCTS DROPDOWN
   * *-***********************/
  function loadCategories() {
    var action = "ldCategory";
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: action },
      success: function (response) {
        var opts = JSON.parse(response);
        //console.log(opts);
        $.each(opts, function (i, item) {
          $.each(item, function (key, value) {
            $("#categoryDropDown").append(
              '<option value="' +
                value.category_id +
                '">' +
                value.Description +
                "</option>"
            );
          });
        });
      },
    });
  }

  /***************************
   * POPULATE CLIENTS DROPDOWN
   * *-***********************/
  function loadClient() {
    var action = "ldClient";
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: action },
      success: function (response) {
        var opts = JSON.parse(response);
        //console.log(opts);
        $("#client").empty();
        $.each(opts, function (i, item) {
          $.each(item, function (key, value) {
            //console.log(value.id);
            $("#client").append(
              '<option value="' +
                value.client_id +
                '">' +
                value.Name +
                "</option>"
            );
          });
        });
      },
    });
  }

  /***************************
   * POPULATE PAYMENT METHODS
   * *-***********************/
  function loadPayMethod() {
    var action = "ldPayMethod";
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: action },
      success: function (response) {
        var opts = JSON.parse(response);
        //console.log(opts);
        $.each(opts, function (i, item) {
          $.each(item, function (key, value) {
            //console.log(value.id);
            $("#pay-method").append(
              '<option value="' + value.id + '">' + value.name + "</option>"
            );
          });
        });
      },
    });
  }

  /***************************
   * POPULATE CURRENCY
   * *-***********************/
  function loadCurrency() {
    var action = "ldCurrency";
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: action },
      success: function (response) {
        var opts = JSON.parse(response);
        //console.log(opts);
        $.each(opts, function (i, item) {
          $.each(item, function (key, value) {
            //console.log(value.id);
            $("#currency").append(
              '<option value="' + value.id + '">' + value.code + "</option>"
            );
          });
        });
      },
    });
  }

  /***************************
   * POPULATE SETTINGS
   * *-***********************/
  function loadSettings() {
    var action = "ldProfile";
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: action },
      success: function (response) {
        var settings = JSON.parse(response);
        $("#shopName").val(settings.name);
        $("#account").val(settings.account);
        $("#mobile").val(settings.mobile);
        $("#telephone").val(settings.tel);
        $("#email").val(settings.email);
        $("#currency").val(settings.currency);
        $("#street").val(settings.street);
        $("#city").val(settings.city);
        $("#state").val(settings.state);
        $("#shopCurrency").text(settings.code);

        $("#rece_company_name").text(settings.name);
        $("#rece_street").text(settings.street);
        $("#rece_city").text(settings.city);
        $("#rece_state").text(settings.state);
      },
    });
  }

  //call functions
  loadCategories();
  loadProducts();
  loadPayMethod();
  loadClient();
  loadCurrency();
  loadSettings();
  getDashboard();

  /****************************
   * LAUNCH MODAL EMP
   * * ************************/
  $("#launchModalEmp").click(function (e) {
    document.getElementById("form-employee").reset();
    $("#modal-employee").modal("show");
    var userDelete = $("#userDelete");
    userDelete.text("Close");
    userDelete.click(function (e) {
      if ($("#userDelete").text() == "Close") {
        $("#modal-employee").modal("hide");
      }
    });
  });

  /****************************
   * LAUNCH MODAL PRODUCT
   * * ************************/
  $("#launchModalProduct").click(function (e) {
    document.getElementById("formProduct").reset();
    $("#modal-product").modal("show");
  });

  /**----------------------
   * initialize datatables
   * ----------------------
   * */
  $("#example1")
    .DataTable({
      lengthChange: true,
      autoWidth: false,
      buttons: [
        { extend: "csv", className: "btn btn-success btn-sm rounded-0" },
        { extend: "pdf", className: "btn btn-success btn-sm rounded-0" },
        { extend: "print", className: "btn btn-success btn-sm rounded-0" },
      ],
      lengthMenu: [5, 10, 20, 50, 100, 200, 500],
    })
    .buttons()
    .container()
    .appendTo("#example1_wrapper .col-md-6:eq(0)");

  /*******************
   * TABLE EMPLOYEE***
   * *****************/
  $("#tblEmployee").DataTable({
    lengthChange: true,
    autoWidth: false,
    dom:
      '<"top"<"row"<"col-md-6"lB><"col-md-6"f>>>' +
      '<"row px-2"t>' +
      '<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
    buttons: [
      { extend: "copy", className: "btn btn-default btn-sm rounded-0" },
      { extend: "csv", className: "btn btn-default btn-sm rounded-0" },
      { extend: "pdf", className: "btn btn-default btn-sm rounded-0" },
      { extend: "print", className: "btn btn-default btn-sm rounded-0" },
    ],

    lengthMenu: [5, 10, 20, 50, 100, 200, 500],
    ajax: {
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: "tblEmployee",
      },
    },
    columnDefs: [{ className: "dt-center", targets: "_all" }],
    columns: [
      {
        data: "user_id",
      },
      {
        data: "name",
      },
      {
        data: "surname",
      },
      {
        data: "gender",
        className: "dt-center",
        render: function (data, type) {
          if (type === "display") {
            let gender = "";
            if (data == "Female") {
              gender =
                '<span class="badge badge-pill badge-light pt-1 pb-2"><i class="fa fa-female"></i> female</span>';
            } else {
              gender =
                '<span class="badge badge-pill badge-light pt-1 pb-2"><i class="fa fa-male"></i> male</span>';
            }
            return gender;
          }
          return data;
        },
      },
      {
        data: "role",
      },
      {
        data: "sales",
        className: "dt-center",
        render: function (data, type) {
          return (
            '<span class="badge badge-pill badge-light pt-2 pb-2">' +
            formatter.format(data) +
            "</span>"
          );
        },
      },
      {
        data: "phone",
        className: "dt-center",
        render: function (data, type) {
          return (
            '<a href="tell:' +
            data +
            '"  class="text-dark badge badge-pill badge-light pt-2 pb-2"> ' +
            data +
            "</a>"
          );
        },
      },
      {
        data: "status",
        className: "dt-center",
        render: function (data, type) {
          if (type === "display") {
            let stat = "";
            if (data == 1) {
              stat =
                '<span class="badge badge-pill badge-light pt-2 pb-2">Active</span>';
            } else if (stat == 0) {
              stat =
                '<span class="badge badge-pill badge-light pt-2 pb-2">Inactive</span>';
            }
            return stat;
          }
          return data;
        },
      },
      {
        data: null,
        className: "dt-center emp-view",
        defaultContent:
          '<a href="#"  class="text-dark"><i class="fas fa-edit"></i></a>',
        orderable: false,
      },
      {
        data: null,
        className: "dt-center emp-delete",
        defaultContent:
          '<a href="#"  class="text-red"><i class="fas fa-times"></i></a>',
        orderable: false,
      },
    ],
    order: [[0, "desc"]],
  });

  //compare functions
  function compare(x, y) {
    if (x > y) {
      return 1;
    } else {
      return 0;
    }
  }
  /*******************
   * TABLE PRODUCTS***
   * *****************/
  $("#tblProduct").DataTable({
    lengthChange: true,
    autoWidth: false,
    dom:
      '<"top"<"row"<"col-md-6"lB><"col-md-6"f>>>' +
      '<"row px-2"t>' +
      '<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
    buttons: [
      { extend: "copy", className: "btn btn-default btn-sm rounded-0" },
      { extend: "csv", className: "btn btn-default btn-sm rounded-0" },
      { extend: "pdf", className: "btn btn-default btn-sm rounded-0" },
      {
        extend: "print",
        className: "btn btn-default btn-sm rounded-0",
        title: "<h3>Product List</h3>",
      },
    ],

    lengthMenu: [
      [5, 10, 25, 50, -1],
      [5, 10, 25, 50, "All"],
    ],
    ajax: {
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: "tblProduct",
      },
    },
    columnDefs: [{ className: "dt-center", targets: "_all" }],
    columns: [
      {
        data: "product_code",
      },
      {
        data: "name",
      },
      {
        data: "cat_description",
      },
      {
        data: "cost_price",
        className: "dt-center",
        render: function (data, type, row) {
          if (type === "display") {
            return data;
          }
          return data;
        },
      },
      {
        data: "selling_price",
        className: "dt-center",
        render: function (data, type, row) {
          if (type === "display") {
            return data;
          }
          return data;
        },
      },
      {
        //data: 'quantity',
        target: -4,
        className: "dt-center",
        render: function (data, type, row) {
          if (type === "display") {
            let stat = "";
            var curr = parseInt(row["quantity"]);
            var min = parseInt(row["min_quantity"]);
            var x = 1;
            if (compare(curr, min) == 1) {
              stat =
                '<span class="text-dark"><b>' + row["quantity"] + "</b></span>";
            } else {
              stat =
                '<span class="text-red"><b>' + row["quantity"] + "</b></span>";
            }

            return stat;
          }
          return data;
        },
      },
      {
        //data: 'quantity',
        target: -4,
        className: "dt-center",
        render: function (data, type, row) {
          if (type === "display") {
            let stat = "";
            var size = row["size"];
            var unit = row["units"];

            var m = size + "" + unit.toLowerCase();

            return m;
          }
          return data;
        },
      },

      {
        data: null,
        className: "dt-center product-view",
        defaultContent:
          '<a href="#"  class="text-dark"><i class="fas fa-edit"></i></a>',
        orderable: false,
      },
      {
        data: null,
        className: "dt-center product-delete",
        defaultContent:
          '<a href="#"  class="text-red"><i class="fas fa-times"></i></a>',
        orderable: false,
      },
    ],
    order: [[0, "desc"]],
  });

  /*******************
   * TABLE REPORT***
   * *****************/
  $("#tblReport").DataTable({
    lengthChange: true,
    autoWidth: false,
    dom:
      '<"top"<"row"<"col-md-6"lB><"col-md-6"f>>>' +
      '<"row px-2"t>' +
      '<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
    buttons: [
      { extend: "copy", className: "btn btn-default btn-sm rounded-0" },
      { extend: "csv", className: "btn btn-default btn-sm rounded-0" },
      {
        extend: "pdf",
        className: "btn btn-default btn-sm rounded-0",
        title: "Report Summary",
      },
      {
        extend: "print",
        className: "btn btn-default btn-sm rounded-0",
        title: "Report Summary",
      },
    ],

    lengthMenu: [
      [5, 10, 20, 50, -1],
      [5, 10, 20, 50, "All"],
    ],
    ajax: {
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: "tblReport",
      },
    },
    columnDefs: [{ className: "dt-center", targets: "_all" }],
    columns: [
      {
        data: "order_id",
      },
      {
        data: "client",
      },
      {
        data: "method",
      },
      {
        data: "total",
      },
      {
        data: "balance",
        className: "dt-center",
        render: function (data, type, row) {
          if (type === "display") {
            var payment_status = "";
            if (data == 0) {
              payment_status =
                '&nbsp<span class="badge badge-pill badge-light pt-2 pb-2">' +
                formatter.format(data) +
                "</span>";
            } else {
              payment_status =
                '&nbsp<span class="badge badge-pill badge-warning pt-2 pb-2">' +
                formatter.format(data) +
                "</span>";
            }
            return payment_status;
          }
          return data;
        },
      },
      {
        data: "order_date",
        className: "dt-center",
        render: function (data, type, row) {
          if (type === "display") {
            return data;
          }
          return data;
        },
      },
      {
        data: "order_time",
        className: "dt-center",
        render: function (data, type, row) {
          if (type === "display") {
            return data;
          }
          return data;
        },
      },
      {
        data: "cashier",
        className: "dt-center",
        render: function (data, type, row) {
          if (type === "display") {
            return data;
          }
          return data;
        },
      },

      {
        data: null,
        className: "dt-center receipt-print",
        defaultContent:
          '<a href="#"  class="text-dark"><i class="fas fa-print"></i></a>',
        orderable: false,
      },

      {
        data: null,
        className: "dt-center order-edit",
        defaultContent:
          '<a href="#"  class="text-dark"><i class="fas fa-edit"></i></a>',
        orderable: false,
      },
    ],
    order: [[0, "desc"]],
  });

  /*******************
   * TABLE CART***
   * *****************/

  $("#tblCart").DataTable({
    lengthChange: false,
    autoWidth: false,
    serverSide: true,
    bFilter: false,
    bPaginate: false,
    bInfo: false,
    language: {
      infoEmpty: "Cart Empty",
      zeroRecords: "Nothing found in the cart",
    },
    buttons: [{ footer: true }],
    ajax: {
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: "loadCart",
      },
    },

    columnDefs: [{ className: "dt-center", targets: "_all" }],
    columns: [
      {
        data: "product_code",
      },
      {
        data: "name",
      },
      {
        data: "price",
      },
      {
        data: "quantity",
      },
      {
        data: "total",
      },
      {
        data: null,
        className: "dt-center cart-delete",
        defaultContent:
          '<a href="#"  class="text-red"><i class="fas fa-times"></i></a>',
        orderable: false,
      },
    ],
    order: [[0, "asc"]],
  });

  /*******************
   * TABLE TOP TRENDING***
   * *****************/

  $("#tblTrending").DataTable({
    lengthChange: false,
    autoWidth: false,
    serverSide: false,
    bFilter: false,
    bPaginate: false,
    bInfo: false,
    language: {
      infoEmpty: "Zero Products",
      zeroRecords: "No Sales has been recorded!",
    },
    buttons: [{ footer: true }],
    ajax: {
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: "loadTrending",
      },
    },

    columnDefs: [{ className: "dt-center", targets: "_all" }],
    columns: [
      {
        data: "item_id",
      },
      {
        data: "name",
      },
      {
        data: "SumQty",
      },
      {
        data: "SaleTotal",
        render: function (data, type, row) {
          if (type === "display") {
            return (
              '<span class="badge badge-light pt-2 pb-2">' +
              formatter.format(data) +
              "</span>"
            );
          }
          return data;
        },
      },
    ],
    order: [[2, "desc"]],
  });

  /*******************
   * TABLE TOP TRENDING***
   * *****************/

  $("#tblLowStock").DataTable({
    lengthChange: false,
    autoWidth: false,
    serverSide: false,
    bFilter: false,
    bPaginate: true,
    bInfo: false,
    language: { infoEmpty: "Zero Products", zeroRecords: "No products found!" },
    buttons: [{ footer: true }],
    ajax: {
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: "lowStock",
      },
    },

    columnDefs: [{ className: "dt-center", targets: "_all" }],
    columns: [
      {
        data: "product_code",
      },
      {
        data: "name",
      },
      {
        data: "selling_price",
        render: function (data, type, row) {
          if (type === "display") {
            return formatter.format(data);
          }
          return data;
        },
      },
      {
        data: "quantity",
        render: function (data, type, row) {
          if (type === "display") {
            var col = "";
            if (data > 5) {
              col = '<b><a href="#" class="text-success">' + data + "</a></b>";
            } else if (data > 0 && data <= 5) {
              col = '<b><a href="#" class="text-warning">' + data + "</a></b>";
            } else {
              col = '<b><a href="#" class="text-danger">' + data + "</a></b>";
            }
            return col;
          }
          return data;
        },
      },
    ],
    order: [[2, "desc"]],
  });

  /*******************
   * DELETE cart**
   * *****************/
  $("#tblCart").on("click", "td.cart-delete", function (e) {
    e.preventDefault();
    var table = $("#tblCart").DataTable();
    var data = table.row(this).data();

    var action = "removeCart";
    var id = data.product_code;
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: action,
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          $("#tblCart").DataTable().ajax.reload();
          $("#subTotal").text(formatter.format(data.total));
          $("#totalFee").text(formatter.format(data.total));
          Toast.fire({
            icon: "success",
            title: data.message,
          });
          $("#amtTendered").val("");
          $("#discount").val("");
          $("#amtChange").text("$0.00");
          getSubTotal();
        } else {
          Toast.fire({
            icon: "error",
            title: data.message,
          });
        }
      },
    });
  });

  /*
 
    jQuery.fn.dataTable.Api.register('sum()',function() {
        return this.flatten().reduce(function(a,b) {
            if (typeof a ==='string') {
                a=a.replace(/[^\d.-]/g,'')*1;
                y=parseFloat(a);
                a=y;
            }
            if (typeof b === '') {
                b=b.replace(/[^\d.-]/g,'')*1;
                x=parseFloat(b);
                b=x;
            }
            return a+b;

        },0);
    });



    

    function getSum() {
        var tableCart=$("#tblCart");
        var sumVal=0;

        for (var i = 1; i <tableCart.rows.length; i++) {
            sumVal=sumVal+parseFloat(tableCart.rows[i].cells[4].innerHTML);v
        }
        console.log(sumVal);
        $('#getSum').text(0);
    }

    getSum();*/

  /*******************
   * TABLE EXPENSE***
   * *****************/
  $("#tblExpense").DataTable({
    lengthChange: true,
    autoWidth: false,
    dom:
      '<"top"<"row"<"col-md-6"lB><"col-md-6"f>>>' +
      '<"row px-2"t>' +
      '<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
    buttons: [
      { extend: "copy", className: "btn btn-default btn-sm rounded-0" },
      { extend: "csv", className: "btn btn-default btn-sm rounded-0" },
      { extend: "pdf", className: "btn btn-default btn-sm rounded-0" },
      {
        extend: "print",
        className: "btn btn-default btn-sm rounded-0",
        title: "<h3>Expenses List</h3>",
      },
    ],

    lengthMenu: [
      [5, 10, 20, 50, -1],
      [5, 10, 20, 50, "All"],
    ],
    ajax: {
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: "tblExpense",
      },
    },
    columnDefs: [{ className: "dt-center", targets: "_all" }],
    columns: [
      {
        data: "expense_id",
      },
      {
        data: "description",
      },
      {
        data: "amount",
      },
      {
        data: "validity",
        className: "dt-center",
        render: function (data, type) {
          return dateFormat(data, "dddd, mmmm dS, yyyy");
        },
      },

      {
        data: null,
        className: "dt-center ex-view",
        defaultContent:
          '<a href="#"  class="text-dark"><i class="fas fa-edit"></i></a>',
        orderable: false,
      },
      {
        data: null,
        className: "dt-center ex-delete",
        defaultContent:
          '<a href="#"  class="text-red"><i class="fas fa-times"></i></a>',
        orderable: false,
      },
    ],
    order: [[0, "asc"]],
  });

  /*******************
   * TABLE Customer***
   * *****************/
  $("#tblCustomer").DataTable({
    lengthChange: true,
    autoWidth: false,
    dom:
      '<"top"<"row"<"col-md-6"lB><"col-md-6"f>>>' +
      '<"row px-2"t>' +
      '<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
    buttons: [
      { extend: "copy", className: "btn btn-default btn-sm rounded-0" },
      { extend: "csv", className: "btn btn-default btn-sm rounded-0" },
      { extend: "pdf", className: "btn btn-default btn-sm rounded-0" },
      {
        extend: "print",
        className: "btn btn-default btn-sm rounded-0",
        title: "<h3>Clients List</h3>",
      },
    ],

    lengthMenu: [
      [5, 10, 20, 50, -1],
      [5, 10, 20, 50, "All"],
    ],
    ajax: {
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: "tblCustomer",
      },
    },
    columnDefs: [{ className: "dt-center", targets: "_all" }],
    columns: [
      {
        data: "Name",
      },
      {
        data: "Phone",
      },
      {
        data: "email",
      },
      {
        data: "orders",
        className: "dt-center",
        render: function (data, type) {
          return (
            '<span class="badge badge-light pt-2 pb-2">' + data + "</span>"
          );
        },
      },

      {
        data: "spend",
        className: "dt-center",
        render: function (data, type) {
          return formatter.format(data);
        },
      },

      {
        data: null,
        className: "dt-center client-view",
        defaultContent:
          '<a href="#"  class="text-dark"><i class="fas fa-edit"></i></a>',
        orderable: false,
      },
      {
        data: null,
        className: "dt-center client-delete",
        defaultContent:
          '<a href="#"  class="text-red"><i class="fas fa-times"></i></a>',
        orderable: false,
      },
    ],
    order: [[3, "desc"]],
  });

  /************************
   * VIEW EMPLOYEE*********
   * **********************/
  $("#tblEmployee").on("click", "td.emp-view", function (e) {
    e.preventDefault();
    var table = $("#tblEmployee").DataTable();
    var data = table.row(this).data();
    $("#modal-employee").modal("show");

    $("#btnEmp").text("Update");

    $("#id").val(data.user_id);

    $("#title").val(data.title);
    $("#name").val(data.name);
    $("#surname").val(data.surname);
    $("#gender").val(data.gender);
    $("#dob").val(data.dob);
    $("#email").val(data.email);
    $("#phone").val(data.phone);
    $("#password").val(data.password);
    $("#address").val(data.address);
    $("#emp_date").val(data.date_employed);
    $("#role").val(data.role);
    $("#status").val(data.status);

    $("#form-employee").submit(function (e) {
      e.preventDefault();
      // avoid to execute the actual submit of the form.

      var form = $(this);
      var url = form.attr("action");
      var data = form.serializeArray();

      if ($("#btnEmp").text() == "Update") {
        data.push({ name: "action", value: "updateEmp" });
        $.ajax({
          type: "POST",
          url: url,
          data: data, // serializes the form's elements.
          beforeSend: function () {
            $("#btnEmp").text("Saving...");
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
              $("#modal-employee").modal("hide");
              Toast.fire({
                icon: "success",
                title: data.message,
              });
              $("#tblEmployee").DataTable().ajax.reload();
              $("#btnEmp").text("Save");
              document.getElementById("form-employee").reset();
            } else {
              Toast.fire({
                icon: "error",
                title: data.message,
              });
              $("#btnEmp").text("Save");
            }
          },
        });
      } else {
        data.push({ name: "action", value: "saveEmp" });
      }
    });
  });

  /************************
   * EDIT EXPENSE*********
   * **********************/
  $("#tblExpense").on("click", "td.ex-view", function (e) {
    e.preventDefault();
    var table = $("#tblExpense").DataTable();
    var data = table.row(this).data();

    $("#saveExpense").text("Update");

    $("#id").val(data.expense_id);

    $("#expense").val(data.description);
    $("#amount").val(data.amount);
    $("#validity").val(data.validity);

    $("#formExpense").submit(function (e) {
      e.preventDefault();
      // avoid to execute the actual submit of the form.

      var form = $(this);
      var url = form.attr("action");

      if ($("#saveExpense").text() == "Update") {
        var data = form.serializeArray();
        data.push({ name: "action", value: "updateExpense" });

        $.ajax({
          type: "POST",
          url: url,
          data: data, // serializes the form's elements.
          beforeSend: function () {
            $("#saveExpense").html(
              '<i class="fas fa-spinner"></i> Updating...'
            );
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
              Toast.fire({
                icon: "success",
                title: data.message,
              });
              $("#tblExpense").DataTable().ajax.reload();
              $("#saveExpense").html(
                '<i class="fas fa-spinner"></i> Save Expense'
              );
              document.getElementById("formExpense").reset();
            } else {
              Toast.fire({
                icon: "error",
                title: data.message,
              });
              $("#saveExpense").html(
                '<i class="fas fa-spinner"></i> Save Expense'
              );
            }
          },
        });
      }
    });
  });

  /************************
   * EDIT CLIENT*********
   * **********************/
  $("#tblCustomer").on("click", "td.client-view", function (e) {
    e.preventDefault();
    var table = $("#tblCustomer").DataTable();
    var data = table.row(this).data();

    $("#btnSaveCleint").html('<i class="fas fa-user-plus"></i> Update Client');

    $("#clientUId").val(data.client_id);

    $("#clientName").val(data.Name);
    $("#phoneNumber").val(data.Phone);
    $("#clientemail").val(data.email);
    $("#clientName").get(0).scrollIntoView({ behavior: "smooth" });
  });

  /************************
   * ORDER EDIT*********
   * **********************/
  $("#tblReport").on("click", "td.order-edit", function (e) {
    e.preventDefault();
    var table = $("#tblReport").DataTable();
    var data = table.row(this).data();

    $("#trans_id").val(data.order_id);
    $("#amtDue").val(data.balance);

    $("#amtPaid").val(data.email);

    $("#modal-order").modal("show");
  });

  //update order
  $("#btnSavePay").click(function (e) {
    var Orderid = $("#trans_id").val();
    var balance = $("#amtDue").val();
    var amtPaid = $("#amtPaid").val();
    var newchange = 0;

    if (amtPaid == "") {
      amtPaid = 0;
    }

    if (balance >= amtPaid) {
      newchange = 0;
      balance = balance - amtPaid;
    } else if (balance < amtPaid) {
      newchange = amtPaid - balance;
      balance = 0;
    }
    //add to amt tendered, update balance,update change
    var data = {
      action: "updateOrder",
      Orderid: Orderid,
      balance: balance,
      amtPaid: amtPaid,
      newchange: newchange,
    };

    //console.log(data);
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: data, // serializes the form's elements.
      beforeSend: function () {
        $("#btnSavePay").html(
          '<i class="fa fa-shopping-bag"></i> Updating Order'
        );
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          $("#modal-order").modal("hide");
          Toast.fire({
            icon: "success",
            title: data.message,
          });
          $("#tblReport").DataTable().ajax.reload();
          $("#btnSavePay").html(
            '<i class="fa fa-shopping-bag"></i> Update Order'
          );
        } else {
          Toast.fire({
            icon: "error",
            title: data.message,
          });
          $("#btnSavePay").html(
            '<i class="fa fa-shopping-bag"></i> Update Order'
          );
        }
      },
    });
  });

  $("#form-employee").submit(function (e) {
    e.preventDefault();
    // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr("action");
    var data = form.serializeArray();

    if ($("#btnEmp").text() == "Save") {
      data.push({ name: "action", value: "saveEmp" });
      $.ajax({
        type: "POST",
        url: url,
        data: data, // serializes the form's elements.
        beforeSend: function () {
          $("#btnEmp").text("Saving...");
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 1) {
            $("#modal-employee").modal("hide");
            Toast.fire({
              icon: "success",
              title: data.message,
            });
            $("#tblEmployee").DataTable().ajax.reload();
            $("#btnEmp").text("Save");
            document.getElementById("form-employee").reset();
          } else {
            Toast.fire({
              icon: "error",
              title: data.message,
            });
            $("#btnEmp").text("Save");
          }
        },
      });
    } else {
      data.push({ name: "action", value: "updateEmp" });
    }
  });

  /************************
   * VIEW PRODUCT*********
   * **********************/
  $("#tblProduct").on("click", "td.product-view", function (e) {
    e.preventDefault();
    var table = $("#tblProduct").DataTable();
    var data = table.row(this).data();
    $("#modal-product").modal("show");

    $("#saveItem").text("Update");

    $("#pro_id").val(data.product_code);

    $("#item_name").val(data.name);
    $("#categoryDropDown").val(data.category);
    $("#cost_price").val(data.cost_price);
    $("#selling_price").val(data.selling_price);
    $("#quantity").val(data.quantity);
    $("#min_quantity").val(data.min_quantity);
    $("#units").val(data.units);
    $("#size").val(data.size);

    $("#formProduct").submit(function (e) {
      e.preventDefault();
      // avoid to execute the actual submit of the form.

      var form = $(this);
      var url = form.attr("action");

      if ($("#saveItem").text() == "Update") {
        var data = form.serializeArray();
        data.push({ name: "action", value: "updateProduct" });

        $.ajax({
          type: "POST",
          url: url,
          data: data, // serializes the form's elements.
          beforeSend: function () {
            $("#saveItem").text("Saving...");
            //console.log(data);
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
              $("#modal-product").modal("hide");
              Toast.fire({
                icon: "success",
                title: data.message,
              });
              $("#tblProduct").DataTable().ajax.reload();
              $("#saveItem").text("Save");
              document.getElementById("formProduct").reset();
            } else {
              Toast.fire({
                icon: "error",
                title: data.message,
              });
              $("#saveItem").text("Save");
            }
          },
        });
      }
    });
  });

  /*************************
   * TABLE CATEGORY*********
   * ***********************/

  $("#tblCategory").DataTable({
    lengthChange: false,
    autoWidth: false,
    searching: false,
    lengthMenu: [
      [5, 10, 20, 50, 100, -1],
      [5, 10, 20, 50, 100, "All"],
    ],
    ajax: {
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: "tblCategory",
      },
    },
    columnDefs: [{ className: "dt-center", targets: "_all" }],
    columns: [
      {
        data: "category_id",
      },
      {
        data: "Description",
      },
      {
        data: "products",
      },
      {
        data: "date_encoded",
      },
      {
        data: null,
        className: "dt-center cat-del",
        defaultContent:
          '<a href="#"  class="text-red"><i class="fas fa-times"></i></a>',
        orderable: false,
      },
    ],
    order: [[0, "asc"]],
  });

  /*******************
   * DELETE CATEGORY**
   * *****************/
  $("#tblCategory").on("click", "td.cat-del", function (e) {
    e.preventDefault();
    var table = $("#tblCategory").DataTable();
    var data = table.row(this).data();
    $("#modal-delCat").modal("show");
    $("#delCat").click(function (e) {
      var action = "delCat";
      var id = data.category_id;

      $.ajax({
        type: "POST",
        url: "../networth/user.php",
        data: {
          action: action,
          id: id,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 1) {
            $("#modal-delCat").modal("hide");
            $("#tblCategory").DataTable().ajax.reload();
            Toast.fire({
              icon: "success",
              title: data.message,
            });
          } else {
            Toast.fire({
              icon: "error",
              title: data.message,
            });
          }
        },
      });
    });
  });

  /*******************
   * DELETE EMPLOYEE**
   * *****************/
  $("#tblEmployee").on("click", "td.emp-delete", function (e) {
    e.preventDefault();
    var table = $("#tblEmployee").DataTable();
    var data = table.row(this).data();
    $("#modal-delEmployee").modal("show");
    $("#delEmployee").click(function (e) {
      var action = "userDelete";
      var id = data.user_id;

      $.ajax({
        type: "POST",
        url: "../networth/user.php",
        data: {
          action: action,
          id: id,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 1) {
            $("#modal-delEmployee").modal("hide");
            $("#tblEmployee").DataTable().ajax.reload();
            Toast.fire({
              icon: "success",
              title: data.message,
            });
          } else {
            Toast.fire({
              icon: "error",
              title: data.message,
            });
          }
        },
      });
    });
  });

  /*******************
   * DELETE EXPENSE**
   * *****************/
  $("#tblExpense").on("click", "td.ex-delete", function (e) {
    e.preventDefault();
    var table = $("#tblExpense").DataTable();
    var data = table.row(this).data();
    $("#modal-delExpense").modal("show");
    $("#delExpense").click(function (e) {
      var action = "exDel";
      var id = data.expense_id;

      $.ajax({
        type: "POST",
        url: "../networth/user.php",
        data: {
          action: action,
          id: id,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 1) {
            $("#modal-delExpense").modal("hide");
            $("#tblExpense").DataTable().ajax.reload();
            Toast.fire({
              icon: "success",
              title: data.message,
            });
          } else {
            Toast.fire({
              icon: "error",
              title: data.message,
            });
          }
        },
      });
    });
  });

  /*******************
   * DELETE CUSTOMER**
   * *****************/
  $("#tblCustomer").on("click", "td.client-delete", function (e) {
    e.preventDefault();
    var table = $("#tblCustomer").DataTable();
    var data = table.row(this).data();
    $("#modal-delclient").modal("show");
    $("#delclient").click(function (e) {
      var action = "clientDel";
      var id = data.client_id;

      $.ajax({
        type: "POST",
        url: "../networth/user.php",
        data: {
          action: action,
          id: id,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 1) {
            $("#modal-delclient").modal("hide");
            $("#tblCustomer").DataTable().ajax.reload();
            Toast.fire({
              icon: "success",
              title: data.message,
            });
          } else {
            Toast.fire({
              icon: "error",
              title: data.message,
            });
          }
        },
      });
    });
  });

  /*******************
   * DELETE PRODUCT**
   * *****************/
  $("#tblProduct").on("click", "td.product-delete", function (e) {
    e.preventDefault();
    var table = $("#tblProduct").DataTable();
    var data = table.row(this).data();
    $("#modal-delProduct").modal("show");
    $("#delProduct").click(function (e) {
      var action = "prodDelete";
      var id = data.product_code;

      $.ajax({
        type: "POST",
        url: "../networth/user.php",
        data: {
          action: action,
          id: id,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 1) {
            $("#modal-delProduct").modal("hide");
            $("#tblProduct").DataTable().ajax.reload();
            Toast.fire({
              icon: "success",
              title: data.message,
            });
          } else {
            Toast.fire({
              icon: "error",
              title: data.message,
            });
          }
        },
      });
    });
  });

  /*****************
   * USER LOGIN*****
   * ***************/
  $("#logout").click(function (e) {
    var action = "logout";

    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: {
        action: action,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          Toast.fire({
            icon: "success",
            title: data.message,
          });
          window.location.href = "../";
        } else {
          Toast.fire({
            icon: "error",
            title: data.message,
          });
        }
      },
    });
  });

  /********************
   * SAVE CATEGORY*****
   * ******************/

  $("#form-category").submit(function (e) {
    e.preventDefault();
    // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr("action");
    var category = $("#category").val();
    var action = "add_cart";
    `                                                                                               `;
    $.ajax({
      type: "POST",
      url: url,
      data: {
        category: category,
        action: action,
      }, // serializes the form's elements.
      beforeSend: function () {
        $("#cat-message").text("Saving...");
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          $("#cat-message").text("");
          Toast.fire({
            icon: "success",
            title: data.message,
          });
          $("#tblCategory").DataTable().ajax.reload();
          document.getElementById("form-category").reset();
        } else {
          $("#cat-message").text("");
          Toast.fire({
            icon: "error",
            title: data.message,
          });
        }
      },
    });
  });

  /********************
   * SAVE EXPENSE*****
   * ******************/

  $("#formExpense").submit(function (e) {
    e.preventDefault();
    // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr("action");

    if (
      $("#saveExpense").html() == '<i class="fas fa-spinner"></i> Save Expense'
    ) {
      var data = form.serializeArray();
      data.push({ name: "action", value: "saveExpense" });

      $.ajax({
        type: "POST",
        url: url,
        data: data, // serializes the form's elements.
        beforeSend: function () {
          $("#saveExpense").text("Saving...");
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 1) {
            Toast.fire({
              icon: "success",
              title: data.message,
            });
            $("#tblExpense").DataTable().ajax.reload();
            $("#saveExpense").html(
              '<i class="fas fa-spinner"></i> Save Expense'
            );
            document.getElementById("formExpense").reset();
          } else {
            Toast.fire({
              icon: "error",
              title: data.message,
            });
            $("#saveExpense").html(
              '<i class="fas fa-spinner"></i> Save Expense'
            );
          }
        },
      });
    }
  });

  /***********************
   * SAVE ITEM*******
   ***********************/
  $("#formProduct").submit(function (e) {
    e.preventDefault();
    // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr("action");

    if ($("#saveItem").text() == "Save Product") {
      var data = form.serializeArray();
      data.push({ name: "action", value: "saveItem" });

      $.ajax({
        type: "POST",
        url: url,
        data: data, // serializes the form's elements.
        beforeSend: function () {
          $("#saveItem").text("Loading..");
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 1) {
            $("#modal-product").modal("hide");
            Toast.fire({
              icon: "success",
              title: data.message,
            });
            $("#tblProduct").DataTable().ajax.reload();
            $("#saveItem").text("Save Product");
            document.getElementById("formProduct").reset();
          } else {
            Toast.fire({
              icon: "error",
              title: data.message,
            });
            $("#saveItem").text("Save Product");
          }
        },
      });
    }
  });

  $("#testMod").click(function (e) {
    $("#modal-receipt").modal("show");
  });

  //purchase item.

  $("#checkout").click(function (e) {
    var subTotal = parseFloat(
      $("#subTotal")
        .text()
        .replace(/[^0-9\.-]+/g, "")
    ).toFixed(2);
    var discount = $("#discount").val();
    if (discount == "") {
      discount = 0;
    }
    var payMethod = $("#pay-method").val();
    var total = parseFloat(
      $("#totalFee")
        .text()
        .replace(/[^0-9\.-]+/g, "")
    ).toFixed(2);
    var amtTendered = $("#amtTendered").val();
    if (amtTendered == "") {
      amtTendered = 0;
    }

    var amtChange = parseFloat(
      $("#amtChange")
        .text()
        .replace(/[^0-9\.-]+/g, "")
    ).toFixed(2);
    var client = $("#client").val();
    var transType = $("#transactionType").val();
    var action = "checkout";
    var balance = 0;

    if (amtTendered >= total) {
      balance = 0;
    } else if (amtTendered < total) {
      balance = total - amtTendered;
      amtChange = 0;
    }

    var data = {
      action: action,
      subTotal: subTotal,
      discount: discount,
      payMethod: payMethod,
      total: total,
      amtTendered: amtTendered,
      amtChange: amtChange,
      client: client,
      transType: transType,
      balance: balance,
    };

    if (subTotal !== "0.00") {
      if (amtTendered != 0) {
        $.ajax({
          type: "POST",
          url: "../networth/user.php",
          data: data,
          beforeSend: function () {
            $("#checkout").html('<i class="fas fa-spinner"></i> Processing...');
          },
          success: function (response) {
            console.log(response); //debug console
            try {
              var data = JSON.parse(response);
              if (data.status == 1) {
                audio.play();
                Toast.fire({
                  icon: "success",
                  title: data.message,
                });

                getSubTotal();
                $("#amtChange").text("$0.00");
                $("#amtTendered").val("");
                $("#discount").val("");
                $("#subTotal").text("$0.00");
                $("#productDropDown").val(0);
                $("#tblCart").DataTable().ajax.reload();

                $("#orderId").text("NW" + data.lastid);
                $("#rec_client").text(data.clientName);
                $("#rec_client_phone").text(data.phone);
                $("#rec_client_email").text(data.email);
                $("#rec_payMethod").text(data.payMethod);
                $("#rece_sub_total").text(formatter.format(data.subTotal));
                $("#rece_discount").text(data.discount);
                $("#rece_total").text(formatter.format(data.total));
                $("#orderDate").text(
                  dateFormat(data.order_date, "dddd, mmmm dS, yyyy")
                );

                $("#rece_trans_date").text(
                  dateFormat(data.order_date, "mmmm dS, yyyy")
                );
                $("#rece_gateway").text(data.payMethod);
                $("#rece_trans_id").text(data.lastid);
                $("#rece_amount_paid").text(data.tendered);
                $("#rece_change").text(data.payment_change);

                $("#rece_balance").text(formatter.format(data.balance));
                if (data.balance == 0) {
                  $("#myRibbon").removeClass("bg-danger");
                  $("#myRibbon").addClass("bg-success");
                  $("#ribbon-text").text("Paid");
                } else {
                  $("#myRibbon").removeClass("bg-success");
                  $("#myRibbon").addClass("bg-danger");
                  $("#ribbon-text").text("Not Paid");
                }

                $("#rece_date_gen").text(
                  dateFormat(data.dateToday, "dddd, mmmm dS, yyyy")
                );

                var dataItems = {
                  action: "ldOrderItems",
                  lastid: data.lastid,
                };

                $.ajax({
                  type: "POST",
                  url: "../networth/user.php",
                  data: dataItems,
                  beforeSend: function () {},
                  success: function (response) {
                    var tabledata = JSON.parse(response);
                    var item_number = 0;
                    $.each(tabledata, function (i, item) {
                      $.each(item, function (key, value) {
                        item_number += 1;
                        $("#rece_items").append(
                          "<tr><td>" +
                            item_number +
                            "</td><td>" +
                            value.name +
                            "</td><td>" +
                            value.price +
                            "</td><td>" +
                            value.qty +
                            "</td><td>" +
                            value.total +
                            "</td></tr>"
                        );
                      });
                    });
                  },
                });

                $("#rece_items").empty();

                $("#modal-receipt").modal("show");
                $("#checkout").html(
                  '<i class="fas fa-shopping-bag"></i> Checkout'
                );
              } else {
                Toast.fire({
                  icon: "error",
                  title: data.message,
                });
              }
            } catch (e) {
              console.error("JSON parse error: ", e);
              console.log("Response: ", response);
              Toast.fire({
                icon: "error",
                title: "An error occurred. Please try again.",
              });
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX error: ", error);
            console.log("Status: ", status);
            console.log("Response: ", xhr.responseText);
            Toast.fire({
              icon: "error",
              title: "An error occurred. Please try again.",
            });
          },
          complete: function () {
            $("#checkout").html('<i class="fas fa-shopping-bag"></i> Checkout');
          },
        });
      } else {
        Toast.fire({
          icon: "error",
          title: "Amount paid cannot be zero!",
        });
      }
    } else {
      Toast.fire({
        icon: "error",
        title: "Cannot perform transaction!",
      });
    }
  });

  /*******************
   * PRINT RECEIPT**
   * *****************/
  $("#tblReport").on("click", "td.receipt-print", function (e) {
    e.preventDefault();
    var table = $("#tblReport").DataTable();
    var data = table.row(this).data();

    var action = "print-receipt";
    var id = data.order_id;
    var myData = {
      action: action,
      id: id,
    };

    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: myData, // serializes the form's elements.
      beforeSend: function () {
        //console.log(myData);
      },
      success: function (response) {
        var data = JSON.parse(response);
        //console.log(data);
        if (data.status == 1) {
          $("#orderId").text("NW" + data.lastid);
          $("#rec_client").text(data.clientName);
          $("#rec_client_phone").text(data.phone);
          $("#rec_client_email").text(data.email);
          $("#rec_payMethod").text(data.payMethod);
          $("#rece_sub_total").text(formatter.format(data.subTotal));
          $("#rece_discount").text(data.discount);
          $("#rece_total").text(formatter.format(data.total));
          $("#rece_change").text(formatter.format(data.payment_change));
          $("#orderDate").text(
            dateFormat(data.order_date, "dddd, mmmm dS, yyyy")
          );

          $("#rece_trans_date").text(
            dateFormat(data.order_date, "mmmm dS, yyyy")
          );
          $("#rece_gateway").text(data.payMethod);
          $("#rece_trans_id").text(data.lastid);
          $("#rece_amount_paid").text(data.tendered);

          $("#rece_balance").text(formatter.format(data.balance));
          if (data.balance == 0) {
            $("#myRibbon").removeClass("bg-danger");
            $("#myRibbon").addClass("bg-success");
            $("#ribbon-text").text("Paid");
          } else {
            $("#myRibbon").removeClass("bg-success");
            $("#myRibbon").addClass("bg-danger");
            $("#ribbon-text").text("Not Paid");
          }

          $("#rece_date_gen").text(
            dateFormat(data.dateToday, "dddd, mmmm dS, yyyy")
          );

          var dataItems = {
            action: "ldOrderItems",
            lastid: data.lastid,
          };

          $.ajax({
            type: "POST",
            url: "../networth/user.php",
            data: dataItems, // serializes the form's elements.
            beforeSend: function () {
              //console.log(dataItems);
            },
            success: function (response) {
              var tabledata = JSON.parse(response);
              var item_number = 0;
              $.each(tabledata, function (i, item) {
                $.each(item, function (key, value) {
                  //console.log(value.product_code);
                  item_number += 1;
                  $("#rece_items").append(
                    "<tr><td>" +
                      item_number +
                      "</td><td>" +
                      value.name +
                      "</td><td>" +
                      value.price +
                      "</td><td>" +
                      value.qty +
                      "</td><td>" +
                      value.total +
                      "</td></tr>"
                  );
                });
              });
            },
          });

          $("#rece_items").empty();

          $("#modal-receipt").modal("show");
          //console.log(dateFormat(data.order_date, "dddd, mmmm dS, yyyy"));
        } else {
          Toast.fire({
            icon: "error",
            title: data.message,
          });
        }
      },
    });
  });

  /**
   * VOID BUTTON
   * */
  $("#btnVoid").click(function (e) {
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: { action: "void" }, // serializes the form's elements.
      beforeSend: function () {
        //console.log(data);
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          Toast.fire({
            icon: "success",
            title: data.message,
          });

          getSubTotal();
          $("#amtChange").text("$0.00");
          $("#amtTendered").val("");
          $("#discount").val("");
          $("#subTotal").text("$0.00");
          $("#productDropDown").val(0);
          $("#tblCart").DataTable().ajax.reload();
        } else {
          Toast.fire({
            icon: "error",
            title: data.message,
          });
        }
      },
    });
  });

  //save client form
  $("#btnSaveCleint").click(function (e) {
    e.preventDefault();
    if ($("#clientUId").val() == "") {
      var data = {
        clientName: $("#clientName").val(),
        phoneNumber: $("#phoneNumber").val(),
        clientemail: $("#clientemail").val(),
        action: "addClient",
      };
    } else {
      var data = {
        clientName: $("#clientName").val(),
        phoneNumber: $("#phoneNumber").val(),
        clientemail: $("#clientemail").val(),
        clientUId: $("#clientUId").val(),
        action: "updateClient",
      };
    }
    $.ajax({
      type: "POST",
      url: "../networth/user.php",
      data: data, // serializes the form's elements.
      beforeSend: function () {
        //console.log(data);
        $("#btnSaveCleint").html('<i class="fa fa-spinner"></i> Processing...');
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          Toast.fire({
            icon: "success",
            title: data.message,
          });
          document.getElementById("saveMyClient").reset();
          $("#tblCustomer").DataTable().ajax.reload();
          $("#btnSaveCleint").html(
            '<i class="fa fa-user-plus"></i> Save Client'
          );
          $("#clientUId").val("");
        } else {
          Toast.fire({
            icon: "error",
            title: data.message,
          });
        }
      },
    });
  });
  /**
   * add client to database
   * */

  /**
   * add client to database
   * */
  $("#formClient").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    // avoid to execute the actual submit of the form.

    var url = form.attr("action");

    var data = form.serializeArray();
    data.push({ name: "action", value: "addClient" });

    $.ajax({
      type: "POST",
      url: url,
      data: data, // serializes the form's elements.
      beforeSend: function () {
        //console.log(data);
        $("#saveClient").html('<i class="fa fa-spinner"></i> Saving...');
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          Toast.fire({
            icon: "success",
            title: data.message,
          });
          document.getElementById("formClient").reset();
          $("#modal-client").modal("hide");
          $("#saveClient").html('<i class="fa fa-user-plus"></i> Save');
          loadClient();
        } else {
          Toast.fire({
            icon: "error",
            title: data.message,
          });
        }
      },
    });
  });

  //launch modal client
  $("#launchClient").click(function (e) {
    $("#modal-client").modal("show");
  });

  //file preview
  $("#file").on("input", function (e) {
    console.log(123);
    var input = document.getElementById("file");
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#imageResult").attr("src", e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    }
  });

  $("#formProfile").submit(function (e) {
    e.preventDefault();
    // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr("action");

    var data = new FormData(this);
    data.append("action", "updateProfile");

    $.ajax({
      type: "POST",
      url: url,
      enctype: "multipart/form-data",
      processData: false,
      contentType: false,
      data: data, // serializes the form's elements.
      beforeSend: function () {
        //console.log(data);
      },
      success: function (response) {
        window.location.href = "../";
        /*var data = JSON.parse(response);
        if (data.status == 1) {
          Toast.fire({
            icon: "success",
            title: data.message,
          });
          location.reload();
        } else {
          Toast.fire({
            icon: "error",
            title: data.message,
          });
        }*/
      },
    });
  });

  $("#printInvoice").click(function (e) {
    /*$("#myInvoice").printMe({
        "path" : ["../dist/css/adminlte.min.css"]
      });*/

    printElement(document.getElementById("myInvoice"));

    function printElement(elem) {
      var domClone = elem.cloneNode(true);

      var $printSection = document.getElementById("printSection");

      if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
      }

      $printSection.innerHTML = "";
      $printSection.appendChild(domClone);
      window.print();
      $("#modal-receipt").modal("hide");
    }
  });
});
