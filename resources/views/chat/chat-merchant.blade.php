@extends('layouts.profileMerchant')

@section('title')
    {{ __("Merchant - Chat") }}
@endsection

@section('content')
<section class="min-vh-100 mt-5">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card border border-1 rounded rounded-3" style="border-color: #655503 !important;">
                {{--  seach   --}}
                <div class="card-header bg-transparent border-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row my-2">
                                <div class="title fw-semibold fs-2">{{ __("Chat") }}</div>
                            </div>
                            <div class="input-group rounded rounded-5 shadow border">
                                <span class="input-group-text bg-transparent border-0 border" id="basic-addon2"><i class="fas fa-search text-secondary"></i></span>
                                <input type="text" class="form-control border-0 border" id="search" name="search" placeholder="{{ __('Search') }}"  onkeyup="filter_SearchChat()">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body" id="listBody">

                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('additional-script')
    <script>

        $(document).ready(function() {
            setInterval(function() {
                getChat();
            }, 5000);
        });

        function getChat() {
            $.ajax({
                url: "{{ route('admin-chat-list') }}",
                type: "get",
                dataType: "json",
                success: function(res) {
                    // foreach
                    var html = '';
                    $.each(res, function(index, value){
                        // console.log(value);
                        if(value.avatar.includes('https') == false) {
                            var avatar = url+'/'+value.avatar;
                        }
                        else {
                            var avatar = value.avatar;
                        }

                        let time   = value.time;

                        if ( value.message == null  && value.attachment != null) {
                            value.message = '<i class="fas fa-image"></i> Image';
                        }

                        if(value.status == 'Unread') {
                            html += '<a href="'+url+'/admin/chat/'+value.customer_id+'" class="text-decoration-none text-black card-list">'+
                                        '<div class="card bg-transparent card-list border shadow rounded rounded-4 my-3">'+
                                            '<div class="col-md-12 align-content-center align-items-center">'+
                                                '<div class="row my-3">'+
                                                    '<div class="col-md-1 col-sm-1 profile-img my-auto">'+
                                                        '<img src="'+avatar+'" class="img-circle align-content-center align-items-center d-block" alt="Profile Image">'+
                                                    '</div>'+
                                                    '<div class="col-md-8 col-sm-8">'+
                                                        '<div class="name fw-semibold">'+
                                                            value.customer_name+
                                                        '</div>'+
                                                        '<div class="chat">'+
                                                            value.message+
                                                        '</div>'+
                                                    '</div>'+

                                                    '<div class="col-md-3 d-flex justify-content-end align-content-end align-items-end">'+
                                                        '<span class="position-absolute top-0 mt-2 translate-middle p-2 bg-danger border border-light rounded-circle"></span>'+
                                                        '<div class="fw-normal">'+
                                                            time+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</a>';
                        } else {
                            html += '<a href="'+url+'/admin/chat/'+value.customer_id+'" class="text-decoration-none text-black card-list">'+
                                '<div class="card bg-transparent card-list border shadow rounded rounded-4 my-3">'+
                                    '<div class="col-md-12 align-content-center align-items-center">'+
                                        '<div class="row my-3">'+
                                            '<div class="col-md-1 col-sm-1 profile-img my-auto">'+
                                                '<img src="'+avatar+'" class="img-circle align-content-center align-items-center d-block" alt="Profile Image">'+
                                            '</div>'+
                                            '<div class="col-md-8 col-sm-8">'+
                                                '<div class="name fw-semibold">'+
                                                    value.customer_name+
                                                '</div>'+
                                                '<div class="chat">'+
                                                    value.message+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="col-md-3 d-flex justify-content-end align-content-end align-items-end">'+
                                                '<div class="text-muted fw-normal">'+
                                                    time+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</a>';
                        }

                        $('#listBody').html(html);
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        };

        function filter_SearchChat() {
            const search = document.querySelector('#search');
            search.focus();

            search.addEventListener('keyup', function() {
                if (this.value.length > 0) {
                    const result = document.querySelectorAll('.card-list');

                    for (let i = 0; i < result.length; i++) {
                        if (result[i].textContent.toLowerCase().indexOf(this.value.toLowerCase()) > -1) {
                            result[i].classList.remove('d-none');
                        } else {
                            result[i].classList.add('d-none');
                        }
                    }
                }
            });

            // if click enter button, then return false
            search.addEventListener('keydown', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            return false;
        };
    </script>
@endsection
