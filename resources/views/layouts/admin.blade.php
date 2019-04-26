
<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Fantasy Cric League</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('./Admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/bower_components/Ionicons/css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/dist/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/bower_components/morris.js/morris.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/dist/css/./AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('./Admin/dist/css/skins/skin-blue.min.css')}}">
  <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini" style="background-color: #fff">
    <div class="wrapper">

  <!-- Main Header -->
        <header class="main-header">
    <!-- Logo -->
          <a href="index2.html" class="logo">
              <span class="logo-mini">Fantasy Cric League</span>
              <span class="logo-lg"><b>Fantasy Cric League</span>
          </a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('./Admin/dist/img/user3-128x128.jpg')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{asset('./Admin/dist/img/user3-128x128.jpg')}}" class="img-circle" alt="User Image">
                <p>
                  {{ Auth::user()->name }}
                </p>
              </li>
              <li class="user-body">
              </li>
              <li class="user-footer">
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('./Admin/dist/img/user8-128x128.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>

            <li><a href="{{ url('home') }}"><i class="fa fa-user"></i> <span>Home</span></a></li>                 
            <li><a href="{{ url('create-series') }}"><i class="fa fa-user"></i> <span>Create Series</span></a></li>                 
            <li><a href="{{ url('view-all-series') }}"><i class="fa fa-users"></i> <span>Show Series</span></a></li>
             <li><a href="{{url('show-rules')}}"><i class="fa fa-money"></i> <span>Show Rules</span></a></li> 
            <!-- <li><a href="{{url('show-products')}}"><i class="fa fa-product-hunt"></i> <span>Products</span></a></li> -->
             <!-- <li><a href="{{url('new-sales-form')}}"><i class="fa fa-male"></i> <span>Sale</span></a></li> -->
           <!--  <li><a href="{{url('new-purchase-form')}}"><i class="fa fa-male"></i> <span>Purchase</span></a></li>
            <li><a href="{{url('show-fixed-expenses')}}"><i class="fa fa-file"></i> <span>Fixed Expenses</span></a></li>
            <li><a href="{{ url('new-employee') }}"><i class="fa fa-users"></i> <span>Add Employee</span></a></li>
            <li><a href="{{ url('show-employes') }}"><i class="fa fa-users"></i> <span>All Employes</span></a></li> -->
      </ul>
    </section>
  </aside>

  <div class="content-wrapper">
    <section class="content-header">
      @yield('content')
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

    </section>
  </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>
              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>
              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>
            <p>
              Some information about this general settings option
            </p>
          </div>
        </form>
      </div>
    </div>
  </aside>
  <div class="control-sidebar-bg"></div>
</div>

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->

<script src="{{asset('./Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('./Admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('./Admin/bower_components/chart.js/Chart.js')}}"></script>
<script src="{{ asset('./Admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{asset('./Admin/dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('./Admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('./Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('./Admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('./Admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ url('js/JsBarcode.all.min.js') }}"></script>

<script>
    var focusStatus = true;
  $(function () {
    $("#insert-more").click(function () {
          $("#mytable").each(function () {
              var tds = '<tr>';
              jQuery.each($('tr:last td', this), function () {
                //  $(this).closest('td').find("input").each(function() {
                //     var id=this.id;
                //     $(this).attr("id",id+i);   
                // });
                //  i++;
                  tds += '<td class="'+$(this).attr('class')+'">' + $(this).html() + '</td>';
              });
              tds += '</tr>';
              if ($('tbody', this).length > 0) {
                  $('tbody', this).append(tds);
              } else {
                  $(this).append(tds);
              }
          });
     });

    $( "#txtCode" ).focus(function() {
        focusStatus = true;
    });
    $( "#txtCode" ).focusout(function() {
        focusStatus = false;
    });
    $('#example1').DataTable();
    $('#paymentHistory').DataTable();
    
    // $('#example2').DataTable({
    //   'paging'      : true,
    //   'lengthChange': false,
    //   'searching'   : false,
    //   'ordering'    : true,
    //   'info'        : true,
    //   'autoWidth'   : false
    // })
    
    
  });
  function printElem(code)
  {
    JsBarcode("#barcodeA", code);
    printBarcodePopup($('#barcodeA').parent().html());
  }
  function printBarcodePopup(data) {
        //alert(data);
        var mywindow = window.open('', 'new div', 'height=768,width=1366');
        mywindow.document.write('<html><head><title>Barcode</title>');
        // mywindow.document.write('<link rel="stylesheet" href="/css/barcode.css" type="text/css" />');
        mywindow.document.write("<style>@page  { size: 3.51in 1.25in; margin:.0in .0in; } @media print { *{ color: ##000# !important } #barcode{ width:'100%'; /*width for whole barcode */ } }</style>");
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }
    function printInvoice(data)
    {
        //alert(data);
        var mywindow = window.open('', 'new div', 'height=768,width=1366');
        mywindow.document.write('<html><head><title>Invoice</title>');
        // mywindow.document.write('<link rel="stylesheet" href="/css/barcode.css" type="text/css" />');
        //mywindow.document.write("<style>@page  { size: 3.51in 1.25in; margin:.0in .0in; } @media print { *{ color: ##000# !important } #barcode{ width:'100%'; /*width for whole barcode */ } }</style>");
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;   
    }
   function quantityChange(obj)
    {
      //console.log(obj);
      var row  = $(obj).parents("tr");
      var cost = parseInt($(row).children("td.cost").children("input").val());

      //console.log(obj.value);
      $(row).children("td.total").children("input").val(cost * obj.value);
      
      var grandTotal = 0;
      $('input[name="totalPrice[]"]').each(function(){
        grandTotal = grandTotal + parseInt(this.value);
      });
      $("#grandTotal").val(grandTotal);
      $("#famount").val(grandTotal);
      calculateBalnce();
      calculateReturn();
      calculateDiscount();
    }
    function costChange(obj)
    {
      //console.log(obj);
      var row  = $(obj).parents("tr");
      var quantity = parseInt($(row).children("td.quantity").children("input").val());
      $(row).children("td.total").children("input").val(quantity * obj.value);

      var grandTotal = 0;
      $('input[name="totalPrice[]"]').each(function(){
        grandTotal = grandTotal + parseInt(this.value);
      });
      $("#grandTotal").val(grandTotal);
      $("#famount").val(grandTotal);
      calculateBalnce();
      calculateReturn();
      calculateDiscount();

    }

    function brandChange(value)
    {
      if(value=="Existing")
      {
          $("#existing").show();
          $("#new").hide();

          $("#brandExist").attr("required","true");
          $("#brandNew").removeAttr("required");
      }
      else
      {
          $("#existing").hide();
          $("#new").show();

          $("#brandNew").attr("required","true");
          $("#brandExist").removeAttr("required");
      }
    }

    function removeRow(obj)
    {
        if(focusStatus==false)
        {
            var row  = $(obj).parents("tr");
            var rowCount = $('#mytable tr').length;

            //alert(rowCount);
            if(rowCount==2)
            {

                $("#insert-more").trigger('click');
                firstTimeStatus=true;
                row.remove();
            }
            else
            {
                row.remove();   
            }

            calculateDiscount();
        }
        
    }
    function removeRowPurchase(obj)
    {
        var row  = $(obj).parents("tr");
        var rowCount = $('#mytable tr').length;

        //alert(rowCount);
        if(rowCount==2)
        {

            $("#insert-more").trigger('click');
            firstTimeStatus=true;
            row.remove();
        }
        else
        {
            row.remove();   
        }

        calculateDiscount();   
    }
    function calculateBR()
    {
        calculateBalnce();
        calculateReturn();
    }
    function calculateBalnce()
    {
        var total = parseInt($("#grandTotal").val());
        var paid  = parseInt($("#amountPaid").val());

        if(total>paid)
        {
          $("#balance").val(total-paid);
        }
        else
        {
          $("#balance").val(0); 
        } 
    }
    function calculateReturn()
    {
        var total = parseInt($("#grandTotal").val());
        var paid  = parseInt($("#amountPaid").val());

        if(paid>=total)
        {
           $("#return").val(paid-total); 
        }
        else
        {
          $("#return").val(0);
        }
    }

    function calculateDiscount()
    {

        var grandTotal = 0;
        var discount  = parseInt($("#discount").val());


        $('input[name="totalPrice[]"]').each(function(){
            grandTotal = grandTotal + parseInt(this.value);
        });
        //alert(grandTotal + "   " + discount);
        if(discount<=grandTotal)
        {
           $("#grandTotal").val(grandTotal-discount);
           $("#famount").val(grandTotal);
           calculateBR();
 
        }
        else
        {
          $("#discount").val(0);
          $("#famount").val(grandTotal);
           calculateBR();
        }
    }

    // $(document).scannerDetection({
     
    //   //https://github.com/kabachello/jQuery-Scanner-Detection

    //   timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    //   avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
    //   preventDefault: true,

    //   // endChar: [13],
    //   //   onComplete: function(barcode, qty){
    //   //  validScan = true;
       
    //   //     alert("haha");
    //   //     $('#scannerInput').val(barcode);
      
    //   //   } // main callback function ,
    //   // ,
    //   // onError: function(string, qty) {

    //   // $('#userInput').val ($('#userInput').val()  + string);

      
    //   // }
      
      
    // });
    function BarCodeDetect()
    {
      $("#txtCode").focus();
      $("#getData").trigger('click');
    }

    $(document).ready(function () 
    {


        var keyupFiredCount = 0; 

        function DelayExecution(f, delay) {
            var timer = null; 
            return function () {
                var context = this, args = arguments;
               
                clearTimeout(timer);
                timer = window.setTimeout(function () {
                    f.apply(context, args);
                },
                delay || 300);
            };
        }
        $.fn.ConvertToBarcodeTextbox = function () {

            $(this).focus(function () { $(this).select();$("#msg").html(""); });

             $(this).keydown(function (event) {
                var keycode = (event.keyCode ? event.keyCode : event.which); 
                
                if ($(this).val() == '') {
                    keyupFiredCount = 0; 
                }  
                if (keycode == 13) {//enter key 
                        $(".nextcontrol").focus();
                        return false;
                        event.stopPropagation(); 
                } 
            });

            $(this).keyup(DelayExecution(function (event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);  
                    keyupFiredCount = keyupFiredCount + 1;  
            }));

             $(this).blur(function (event) { 
                 if ($(this).val() == '')
                     return false;

                 if(keyupFiredCount <= 1)
                 {
                     //$("#msg").html("<span style='color:green'>Its Scanner!</span>");
                     //alert('Its Scanner'); 
                 }
                 else 
                 {
                     //$("#msg").html("<span style='color:red'>Its Manually Typed!</span>");
                     //alert('Its Manual Entry');
                 }

                 keyupFiredCount = 0;
             }); 
        };
    
        try {
            $(".barcodeinput").ConvertToBarcodeTextbox();
            if ($(".barcodeinput").val() == '')
                $(".barcodeinput").focus();
            else
                $(".nextcontrol").focus(); 
        } catch (e) { };

});
</script>
<!-- ChartJS -->
<script src="{{ url('js/Chart.js') }}"></script>
<script type="text/javascript">
    var firstTimeStatus=true;
  $(document).ready(function() {

    $("#getData").click(function() {                
      var myData = $('#txtCode').val();
      $.ajax({    //create an ajax request to display.php
        type: "GET",
        data: {
          barCode:myData,
        },
        url: "{{url('get-product-data/')}}",             
        dataType: "json",   //expect html to be returned                
        success: function(response){                    
            //$("#responsecontainer").html(response); 
            //console.log(response.data['code']);
            if(response.data['code']==200)
            {
                // var rowCount = $('#myTable tr').length;
                if(firstTimeStatus==true)
                {
                    firstTimeStatus=false;
                }
                else
                {
                    $("#insert-more").trigger('click');
                }
                var obj = $('#mytable tr:last');
                $(obj).children("td.productName").children("input").val(response.data['name']);
                $(obj).children("td.productColor").children("input").val(response.data['color']);
                $(obj).children("td.productSize").children("input").val(response.data['size']);
                $(obj).children("td.productModel").children("input").val(response.data['model']);
                $(obj).children("td.cost").children("input").val(response.data['costPrice']);
                $(obj).children("td.quantity").children("input").val(1);
                var quantityObj = $(obj).children("td.quantity").children("input");
                $(quantityObj).trigger('onkeyup')
                $(quantityObj).attr('max',response.data['quantity'])
                //quantityChange(quantityObj);
            }
            else
            {
                alert("Product Not Found!!!");
            }
        }

    });
});
});
</script>


@yield('pagescript')
</body>
</html>