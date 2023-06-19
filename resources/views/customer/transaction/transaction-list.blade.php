@extends('layouts.dashboard')

@section('title')
    {{ __('Transaction List') }}
@endsection

@section('content')
<section class="mt-5 pt-md-5 min-vh-100">
    <div class="container-fluid">
        <div class="container">
            <div class="col-md-12">
                <div class="container pt-5">

                    <div class="card border shadow shadow-md">
                        <div class="card-body">
                            <div class="row d-flex align-content-center align-items-center">
                                <div class="card-wrap d-flex align-items-center overflow-auto">
                                    <div class="col-auto col-md-2 justify-content-center d-flex align-items-center">
                                        <label>
                                            <span class="fw-semibold">{{ __("Status :") }}</span>
                                        </label>
                                    </div>

                                    <label>
                                        <input type="radio" name="status" id="status" class="card-input-element" value="ALL" checked/>
                                        <div class="card card-default card-input shadow shadow-md">
                                            <div class="card-header">All</div>
                                        </div>
                                    </label>

                                    <label>
                                        <input type="radio" name="status" id="status" class="card-input-element" value="BOOKED"/>
                                        <div class="card card-default card-input shadow shadow-md">
                                            <div class="card-header">Booked</div>
                                        </div>
                                    </label>

                                    <label class="col-auto">
                                        <input type="radio" name="status" id="status" class="card-input-element" value="ON PROGRESS"/>
                                        <div class="card card-default card-input shadow shadow-md">
                                            <div class="card-header">On Progress</div>
                                        </div>
                                    </label>

                                    <label>
                                        <input type="radio" name="status" id="status" class="card-input-element" value="COMPLETED"/>
                                        <div class="card card-default card-input shadow shadow-md">
                                            <div class="card-header">Completed</div>
                                        </div>
                                    </label>

                                    <label>
                                        <input type="radio" name="status" id="status" class="card-input-element" value="CANCELLED"/>
                                        <div class="card card-default card-input shadow shadow-md">
                                            <div class="card-header">Cancelled</div>
                                        </div>
                                    </label>

                                    <label class="col-auto">
                                        <input type="radio" name="status" id="status" class="card-input-element" value="ON COMPLAINT"/>
                                        <div class="card card-default card-input shadow shadow-md">
                                            <div class="card-header">On Complaint</div>
                                        </div>
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="transaction-list mt-5">
                        <div class="row">
                            <div id="data-container"></div>
                            <div class="d-flex justify-content-end align-content-center">
                                <div id="pagination-container"></div>
                            </div>
                        </div>
                    </div>


                    <div class="row d-flex justify-content-center align-items-center mt-4">
                        <div class="col-md-12  d-flex justify-content-center align-items-center mb-3" id="pagination">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


@include('includes.customer.modal.cust-confirmation')

@endsection


@section('additional-script')
    <script src="{{ url('assets/library/pagination.js.org_dist_2.6.0_pagination.js') }}"></script>
    <script>
        // get value from radio button

        $(document).ready(function() {
            let status = 'ALL';
            let no_transaction = '';

            $('input[type=radio][name=status]').change(function() {
                status = this.value;
                getTransaction(status);
                // var status = checked;
            });

            getTransaction(status);
        });


        function getTransaction(status) {
            $.ajax({
                url: "{{ route('customer.transaction.list') }}",
                type: "GET",
                data: {
                    status: status
                },
                dataType: "JSON",
                success: function(data) {
                    // looping append data to html
                    var html = '';
                    const arr = [];

                    $('#pagination-container').pagination({
                        dataSource: data,
                        pageSize: 5,
                        //showNavigator: true,
                        //formatNavigator: '<%= rangeStart %>-<%= rangeEnd %> of <%= totalNumber %> items',
                        position: 'bottom',
                        callback: function(data, pagination) {

                            if ( data.length == 0 )
                            {
                                html += '<div class="alert alert-secondary" role="alert">';
                                html += '<h4 class="alert-heading text-center">Data Not Found!</h4>';
                                html += '</div>';

                                html = html.replace(/undefined/g, "");
                                $('#data-container').html(html);
                            }
                            else {

                                $.each(data, function(key, value) {
                                    // console.log(value)
                                    if (value.device_picture == null) {
                                        var img_url = 'assets/img/no-image.jpg';
                                    } else {
                                        var img_url = value.device_picture;
                                    }
                                    if(value.status == 'BOOKED'){
                                        var status = '<span class="badge bg-primary fw-semibold">'+value.status+'</span>';
                                    }else if(value.status == 'ON PROGRESS'){
                                        var status = '<span class="badge bg-dark fw-semibold">'+value.status+'</span>';
                                    }else if(value.status == 'DONE'){
                                        var status = '<span class="badge bg-success fw-semibold">'+value.status+'</span>';
                                    }else if(value.status == 'CANCELLED'){
                                        var status = '<span class="badge bg-danger fw-semibold">'+value.status+'</span>';
                                    }else if(value.status == 'ON COMPLAINT'){
                                        var status = '<span class="badge bg-info fw-semibold">'+value.status+'</span>';
                                    }else if(value.status == 'ON PROGRESS - Need Confirmation'){
                                        var split = value.status.split(" - ");
                                        var status = '<span class="badge bg-dark fw-semibold">'+split[0]+'</span>'+' - '+ '<span class="badge bg-warning text-white">'+split[1] +'</span>';
                                    }

                                    var btn_action = '';
                                    if(value.status != 'ON PROGRESS - Need Confirmation'){
                                        btn_action = '<button class="btn btn-custome my-2 px-2 btn-sm fs-6" onclick="location.href =\''+url+'/transaction/detail/'+value.no_transaction+'\'">{{ __("See Detail") }}</button>';
                                    } else{
                                        btn_action = '<button class="btn btn-custome my-2 px-2 btn-sm fs-6" onclick="location.href =\''+url+'/transaction/detail/'+value.no_transaction+'\'">{{ __("See Detail") }}</button>'+'<br>'+
                                                    '<button type="button" class="btn btn-custome my-2 btn-sm" onclick="getConfirmation(\''+value.no_transaction+'\')" data-bs-toggle="modal" data-bs-target="#confirmation">{{ __("Confirmation") }}</button>';
                                    }

                                    html += '<div class="card my-2 transaction mb-2 border border-2">'+
                                                '<div class="card-body">'+
                                                    '<div class="row">'+
                                                        '<div class="col-md-2 d-flex align-items-center">'+
                                                            '<img src="'+url+'/'+img_url+'" alt="device_images" class="img-thumbnail img-fluid" style="width: 150px; height: auto;">'+
                                                        '</div>'+
                                                        '<div class="col-md-8 d-flex align-items-center">'+
                                                            '<div class="row">'+
                                                                '<p class="fw-semibold" id="merchant_id"></p>'+
                                                                '<span>Device : '+value.device_name+'</span>'+
                                                                '<span id="status">Status : '+status+'</span>'+
                                                                '<span>Transaction ID : '+value.no_transaction+'</span>'+
                                                            '</div>'+
                                                        '</div>'+

                                                        '<div class="col-md-2 d-flex justify-content-end align-items-center">'+
                                                            '<div class="row">'+
                                                                '<div class="container text-end">'+
                                                                    btn_action+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>';
                                });

                                // menhapus undifined di html
                                html = html.replace(/undefined/g, "");

                                $("#pagination-container").find(".paginationjs-pages").before("<br><br>");
                                var template = $('#data-container').html(html);
                                var html = pagination.totalPages > 1? template : "";
                                return html;
                            }
                        }
                    });
                }
            });
        }

        function getConfirmation(no_transaction){
            $.ajax({
                url: "{{ route('sevice_confirmation') }}",
                type: "POST",
                data: {
                    _token : "{{ csrf_token() }}",
                    no_transaction: no_transaction
                },
                dataType: "JSON",
                success: function(data) {
                    var merchant_name = data.merchant_name;
                        merchant_name = merchant_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    });

                    $('#SC_transactionID').html(data.no_transaction);
                    $('#SC_deviceName').html(data.device_name);
                    $('#SC_merchantName').html(merchant_name);
                    $('#SC_description').html(data.service_confirmation);
                    $('#merchant_id').val(data.merchant_id);
                }
            });
        }

        $('#acceptService').click(function(){
            var status_confirmation = '1';
            var merchant_id = $('#merchant_id').val();
            var no_transaction = $('#SC_transactionID').html();
            Swal.fire({
                title: 'Are you sure?',
                text: "You will accept this service!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, accept it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#acceptService').html('<i class="fa fa-spinner fa-spin"></i> Sending...');
                    $('#acceptService').addClass('disabled');

                    $.ajax({
                        url: "{{ route('confirm-service') }}",
                        type: "POST",
                        data: {
                            _token : "{{ csrf_token() }}",
                            no_transaction: no_transaction,
                            merchant_id: merchant_id,
                            status_confirmation: status_confirmation,
                        },
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire(
                                'Accepted!',
                                'Service has been accepted.',
                                'success'
                            )
                            $('#confirmation').modal('hide');
                            getTransaction();
                        }
                    });
                }
            })

        });

        $('#declineService').click(function(){
            var status_confirmation = '2';
            var merchant_id         = $('#merchant_id').val();
            var no_transaction      = $('#SC_transactionID').html();

            Swal.fire({
                title: 'Are you sure?',
                text: "You will decline this confirmation!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, decline'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('confirm-service') }}",
                        type: "POST",
                        data: {
                            _token : "{{ csrf_token() }}",
                            no_transaction: no_transaction,
                            merchant_id: merchant_id,
                            status_confirmation: status_confirmation,
                        },
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire(
                                'Declined!',
                                'Service has been declined.',
                                'success'
                            )
                            $('#confirmation').modal('hide');
                            getTransaction();
                        }
                    });
                }
            })
        });


    </script>
@endsection
