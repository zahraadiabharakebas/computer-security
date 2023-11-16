<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}">
    <title>Preclinic - Medical & Hospital - Bootstrap 4 Admin Template</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <!--[if lt IE 9]>
    <script src="{{asset('assets/js/html5shiv.min.js')}}"></script>
    <script src="{{asset('assets/js/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<div id="successfully_deleted" class="modal fade success-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="assets/img/check.png" alt="" width="50" height="46">
                <h3>Successfully Deleted</h3>
                <div class="m-t-20">
                    <a href="#" class="btn btn-white" data-dismiss="modal">Ok</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="failed_model" class="modal fade success-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src={{asset('assets/img/sent.png')}} alt="" width="50" height="46">
                <h3>This field is connected to other attributes, delete them first</h3>
                <div class="m-t-20">
                    <a href="#" class="btn btn-white" data-dismiss="modal">Ok</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="internal_error" class="modal fade success-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src={{asset('assets/img/sent.png')}} alt="" width="50" height="46">
                <h3>We're sorry, we witnessed an error in your system</h3>
                <div class="m-t-20">
                    <a href="#" class="btn btn-white" data-dismiss="modal">Ok</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main-wrapper">
    @include('commons.topbar')
    @include('commons.sidebar')
    <div class="main-wrapper">
            @yield('content')
    </div>

</div>
<div class="sidebar-overlay" data-reff=""></div>
<script>

    function DeleteAjaxCall(id, targetUrl) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'DELETE',
            url: targetUrl,
            data: { id },
            success: function (data) {
                if (data.code == 200) {
                    $('#delete_department_' + id).modal('hide');
                    $('#delete_doctor_' + id).modal('hide');

                    $('#successfully_deleted').modal('show');
                    var removingRow = $("#row" + id);
                    removingRow.remove();
                } else if (data.code == 500) {
                    $('#delete_department_' + id).modal('hide');
                    $('#delete_doctor_' + id).modal('hide');
                    $('#failed_model').modal('show');
                }
            },
            error: function (response) {
                $('#delete_department_' + id).modal('hide');
                $('#delete_doctor_' + id).modal('hide');
                $('#internal_error').modal('show');
                swal('Error', 'An error has occurred. Please contact BA Solutions.', "error");
            }
        });

        block_ele.unblock();
    }

</script>








<script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('assets/js/select2.min.js')}}"></script>
<script src="{{asset('assets/js/moment.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/select2.min.js')}}"></script>


<script>
    $('img[data-enlargable]').addClass('img-enlargable').click(function () {
        var src = $(this).attr('src');
        $('<div>').css({
            background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
            backgroundSize: 'contain',
            width: '100%', height: '100%',
            position: 'fixed',
            zIndex: '10000',
            top: '0', left: '0',
            cursor: 'zoom-out'
        }).click(function () {
            $(this).remove();
        }).appendTo('body');
    });

    function previewFile(input, id) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function () {
                $("#" + id).show();
                $("#" + id).attr("src", reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@yield('customjs')
</body>

</html>
