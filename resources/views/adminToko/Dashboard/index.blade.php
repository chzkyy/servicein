@extends('layouts.adminDashboard')

@section('title')
    {{ __('Merchant - Dashboard') }}
@endsection

@section('content')
<div class="col-md-12">
    <div class="card rounded shadow shadow-md mt-5 mb-2">
        <div class="card-body">
            <div class="row d-flex align-content-center align-items-center">
                <div class="col-md-12">
                    <div class="card-wrap d-flex align-items-center overflow-auto">
                        <div class="col-auto col-md-2 justify-content-center d-flex align-items-center">
                            <label>
                                <span class="font-weight-bold   ">{{ __("Status :") }}</span>
                            </label>
                        </div>

                        <label>
                            <input type="radio" name="status" id="status" class="card-input-element" value="ALL" checked/>
                            <div class="card card-default card-input shadow shadow-md ">
                                <div class="card-header rounded">All</div>
                            </div>
                        </label>

                        <label>
                            <input type="radio" name="status" id="status" class="card-input-element" value="BOOKED"/>
                            <div class="card card-default card-input shadow shadow-md ">
                                <div class="card-header rounded">Booked</div>
                            </div>
                        </label>

                        <label class="col-auto">
                            <input type="radio" name="status" id="status" class="card-input-element" value="ON PROGRESS"/>
                            <div class="card card-default card-input shadow shadow-md ">
                                <div class="card-header rounded">On Progress</div>
                            </div>
                        </label>

                        <label>
                            <input type="radio" name="status" id="status" class="card-input-element" value="DONE"/>
                            <div class="card card-default card-input shadow shadow-md ">
                                <div class="card-header rounded">Completed</div>
                            </div>
                        </label>

                        <label>
                            <input type="radio" name="status" id="status" class="card-input-element" value="CANCELLED"/>
                            <div class="card card-default card-input shadow shadow-md">
                                <div class="card-header rounded">Cancelled</div>
                            </div>
                        </label>

                        <label class="col-auto">
                            <input type="radio" name="status" id="status" class="card-input-element" value="ON COMPLAINT"/>
                            <div class="card card-default card-input shadow shadow-md ">
                                <div class="card-header rounded">On Complaint</div>
                            </div>
                        </label>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card rounded shadow shadow-md">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="font-weight-bold h6">{{ __('All Transaction') }}</div>
                        <div class="font-weight-normal mb-1">{{ __('Commision deadline is on first Saturday on the next month') }}</div>

                        <div class="table-responsive">
                            <table id="transaction-list" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead class="table-custome">
                                    <tr>
                                        <th class="text-center">{{ __('No') }}</th>
                                        <th class="text-center">{{ __('Transaction No') }}</th>
                                        <th class="text-center">{{ __('Device Owner') }}</th>
                                        <th class="text-center">{{ __('Laptop Model') }}</th>
                                        <th class="text-center">{{ __('Status') }}</th>
                                        <th class="text-center">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('additional-script')
    <script>
        $(document).ready(function() {
            let status = 'ALL';

            $('input[type=radio][name=status]').change(function() {
                status = this.value;
                getTransaction(status);
                // var status = checked;
            });

            getTransaction(status);
        });


        function getTransaction(status) {
            $.ajax({
                url: "{{ route('merchant.transaction.list') }}",
                type: "GET",
                data: {
                    status: status
                },
                dataType: "JSON",
                success: function(res) {
                    // console.log(res);
                    $('#transaction-list').DataTable({
                        // "select"        : true,
                        "responsive"    : true,
                        "autoWidth"     : false,
                        "searching"     : true,
                        "destroy"       : true,
                        "data"          : res,
                        "bLengthChange" : false,
                        "dom"           : '<"pull-left"f>' + 'B' + 'lrtip',
                        "pagingType"    : "simple",
                        "iDisplayLength": 5,
                        "bInfo"         : true,
                        "dataType"      : "json",
                        "columns"       : [
                            {
                                data: "id",
                                width : "5%",
                                className: "text-center",
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                },
                            },
                            {
                                data: "no_transaction",
                                width : "20%",
                                className: "text-center",
                            },
                            {
                                data: "fullname",
                                width : "20%",
                                className: "text-center",
                                // create fullname with uppercase first letter
                                render: function(data, type, row, meta) {
                                    return data.charAt(0).toUpperCase() + data.slice(1);
                                },
                            },
                            {
                                data: "device_name",
                                width : "20%",
                                className: "text-center",
                            },
                            {
                                data: "status",
                                width : "20%",
                                className: "text-center",
                                render: function(data, type, row, meta) {
                                    // if status is booked
                                    if (data == 'BOOKED') {
                                        return '<span class="badge badge-primary text-white">' + data + '</span>';
                                    }
                                    // if status is on progress
                                    else if (data == 'ON PROGRESS') {
                                        return '<span class="badge badge-dark text-white">' + data + '</span>';
                                    }

                                    else if (data == 'ON PROGRESS - Need Confirmation') {
                                        var split = data.split(" - ");
                                        return '<span class="badge badge-dark text-white">' + split[0] + '</span>' + ' - ' + '<span class="badge badge-warning text-white">' + split[1] + '</span>';
                                    }
                                    // if status is completed
                                    else if (data == 'DONE') {
                                        return '<span class="badge badge-success text-white">' + data + '</span>';
                                    }
                                    // if status is cancelled
                                    else if (data == 'CANCELLED') {
                                        return '<span class="badge badge-danger text-white">' + data + '</span>';
                                    }
                                    // if status is on complaint
                                    else if (data == 'ON COMPLAINT') {
                                        return '<span class="badge badge-info text-white">' + data + '</span>';
                                    }
                                },
                            },
                            {
                                data: "id",
                                width : "15%",
                                className: "text-center",
                                order : false,
                                // create button action for view modal
                                render: function(data, type, row, meta) {
                                    var id = row.no_transaction;
                                    var url = "{{ route('detail-transaction-admin', ':id') }}";
	                                    url = url.replace(':id', id);
                                    return '<a href="'+url+'" class="btn btn-sm btn-custome">View Detail</a>';
                                },
                            },
                        ]
                    })
                }
            });
        }
    </script>
@endsection
