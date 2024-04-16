<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ asset('') }}">
    <link rel="icon"
		href="img-logo/VT_luxury.png"
		type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>VT LUXURY - Foot, brain & difference</title>

    <!-- Bootstrap -->
    <link href="backend/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="backend/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="backend/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="backend/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="backend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css"
        rel="stylesheet">
    <!-- JQVMap -->
    <link href="backend/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="backend/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="backend/build/css/custom.min.css" rel="stylesheet">

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" language="javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- sidebar -->
            @include('admin.layout.sidebar')
            <!-- sidebar -->

            <!-- top navigation -->
            @include('admin.layout.header')
            <!-- /top navigation -->

            <!-- page content -->
            @yield('admin_content')
            <!-- /page content -->

            <!-- footer content -->
            @include('admin.layout.footer')
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="backend/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="backend/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="backend/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="backend/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="backend/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="backend/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="backend/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="backend/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="backend/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="backend/vendors/Flot/jquery.flot.js"></script>
    <script src="backend/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="backend/vendors/Flot/jquery.flot.time.js"></script>
    <script src="backend/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="backend/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="backend/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="backend/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="backend/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="backend/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="backend/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="backend/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="backend/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="backend/vendors/moment/min/moment.min.js"></script>
    <script src="backend/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="backend/build/js/custom.min.js"></script>

    @yield('script')
    <script>
        // ------------------------------Xử lý hiển thị thông báo---------------------------------
        /*
                Trong đoạn mã này sẽ:
                Đặt giá trị 'opacity' của phần tử có id "alert" thành 0 sau 10s
                Sau đó, đặt thuộc tính 'display' thành none sau 2s để ẩn phần tử
                (Hiệu ứng mờ dần sẽ diễn ra trong vòng 2s)
            */
        setTimeout(function() {
            // Lấy thẻ div chứa thông báo
            var alertDiv = document.getElementById('alert');
            alertDiv.style.opacity = 0;
            setTimeout(function() {
                alertDiv.style.display = 'none';
            }, 2000); // Mất sau 2 giây
        }, 5000); // Hiển thị trong 5 giây

        // ------------------------------Xử lý show filter tìm kiếm---------------------------------
        // Chọn phần tử có class là "show-filter"
        var showFilterBtn = document.querySelector('.show-filter');
        var iconShowFilter = document.querySelector('.icon-show-filter')
        // chọn form có id='filter-form'
        var filterForm = document.getElementById('filter-form');

        // Gán sự kiện click cho phần tử
        showFilterBtn.addEventListener('click', function() {
            // Kiểm tra trạng thái hiện tại của form
            var isFormHidden = filterForm.classList.contains('d-none');
            if (isFormHidden) {
                filterForm.classList.remove('d-none');
                iconShowFilter.classList.remove('fa-chevron-down');
                iconShowFilter.classList.add('fa-chevron-up');
            } else {
                filterForm.classList.add('d-none');
                iconShowFilter.classList.remove('fa-chevron-up');
                iconShowFilter.classList.add('fa-chevron-down');
            }
        });
    </script>
</body>

</html>
