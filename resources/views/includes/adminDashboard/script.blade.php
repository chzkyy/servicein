    {{--  <!-- Bootstrap core JavaScript-->  --}}
    <script src="{{ url('dashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{--  <!-- Core plugin JavaScript-->  --}}
    <script src="{{ url('dashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    {{--  <!-- Custom scripts for all pages-->  --}}
    <script src="{{ url('dashboard/js/sb-admin-2.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/b-2.3.6/kt-2.9.0/r-2.4.1/sc-2.1.1/sl-1.6.2/datatables.min.js"></script>
    <script>
        $(document).ready(function(){

            get_notif();
            getChat();
            setInterval(function() {
                get_notif();
                getChat();
            }, 30000); // 30 seconds
        });

        function read (id) {
            $.ajax ({
                url: "{{ route('read-notification') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    get_notif();
                },
                error: function(err) {
                   // console.log(err);
                }
            });
        }

        function get_notif()
        {
            $.ajax ({
                url: "{{ route('get-notification') }}",
                type: "GET",
                dataType: "JSON",
                success: function(res) {
                    html = '';
                    var notif_count = res['all_notif'];

                    $('#notif_count').html(notif_count);
                    $.each(res['data'], function(key, value) {
                        html += '<a class="dropdown-item d-flex align-items-start" onClick="read('+value.id+');" id="notif_url">'+
                                    '<div>'+
                                        '<div class="small text-gray-500 fw-bold" id="notif_title">'+value.title+'</div>'+
                                        '<div class="text-truncate" style="max-width: 270px;" id="notif_content">'+value.content+'</div>'+
                                    '</div>'+
                                '</a>';


                        $('#notif_list').html(html);
                    });

                },
                error: function(err) {
                   // console.log(err);
                }
            });
        }

        function getChat() {
            $.ajax({
                url: "{{ route('admin-chat-list') }}",
                type: "get",
                dataType: "json",
                success: function(res) {
                    var count = 0;
                    $.each(res, function(index, value) {
                        if (value.status == 'Unread') {
                            count++;
                        }
                    });

                    $('#message_count').html(count);
                },
                error: function(xhr) {
                    //console.log(xhr.responseText);
                }
            });
        }
    </script>
