    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ url('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ url('assets/js/simpleGauge.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ url('assets/library/lightslider-master/dist/js/lightslider.js') }}"></script>
    <script src="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/js/lightgallery.js"></script>
    <script src="https://cdn.rawgit.com/sachinchoolur/lg-pager.js/master/dist/lg-pager.js"></script>
    <script src="https://cdn.rawgit.com/sachinchoolur/lg-autoplay.js/master/dist/lg-autoplay.js"></script>
    <script src="https://cdn.rawgit.com/sachinchoolur/lg-fullscreen.js/master/dist/lg-fullscreen.js"></script>
    <script src="https://cdn.rawgit.com/sachinchoolur/lg-zoom.js/master/dist/lg-zoom.js"></script>
    <script src="https://cdn.rawgit.com/sachinchoolur/lg-hash.js/master/dist/lg-hash.js"></script>
    <script src="https://cdn.rawgit.com/sachinchoolur/lg-share.js/master/dist/lg-share.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>


    <script>
        const url = "{{ url('/') }}";

        @if ($errors->has('username'))
            toastr.error('{{ $errors->first('username') }}', {
                closeButton: true,
                progressBar: true,
                showDuration: 600,
                hideDuration: 2000,
                timeOut: 10000,
                newestOnTop: false,
                extendedTimeOut: 2000,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                showMethod: 'slideDown',
                hideMethod: 'slideUp',
                showEasing: 'swing',
                hideEasing: 'linear',
            });
        @endif

        @if ($errors->has('email'))
            toastr.error('{{ $errors->first('email') }}', {
                closeButton: true,
                progressBar: true,
                showDuration: 600,
                hideDuration: 2000,
                timeOut: 10000,
                newestOnTop: false,
                extendedTimeOut: 2000,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                showMethod: 'slideDown',
                hideMethod: 'slideUp',
                showEasing: 'swing',
                hideEasing: 'linear',
            });
        @endif

        @if ($errors->has('password'))
            toastr.error('{{ $errors->first('password') }}', {
                closeButton: true,
                progressBar: true,
                showDuration: 600,
                hideDuration: 2000,
                timeOut: 10000,
                newestOnTop: false,
                extendedTimeOut: 2000,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                showMethod: 'slideDown',
                hideMethod: 'slideUp',
                showEasing: 'swing',
                hideEasing: 'linear',
            });
        @endif

        @if ($errors->has('tnc'))
            toastr.error('{{ $errors->first('tnc') }}', {
                closeButton: true,
                progressBar: true,
                showDuration: 600,
                hideDuration: 2000,
                timeOut: 10000,
                newestOnTop: false,
                extendedTimeOut: 2000,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                showMethod: 'slideDown',
                hideMethod: 'slideUp',
                showEasing: 'swing',
                hideEasing: 'linear',
            });
        @endif

    </script>

    <script>
        $(document).ready(function() {
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Geolocation is not supported by this browser.',
                    });
                }
            }

            getLocation();

            function showPosition(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                $('#origin').val(lat + ',' + lng);
            }
        });

    </script>

    <script>
        $('#btn_saveChanges').click(function(){
            var fullname = $('#fullname').val();
            var gemder = $('#gender').val();
            var dob = $('#dob').val();
            var phone_number = $('#phone_number').val();
            var cust_address = $('#cust_address').val();

            if ( fullname == '' || gemder == '' || dob == '' || phone_number == '' || cust_address == '' ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all the fields!',
                });
                return false;
            }

            $('#update_profile').submit();
        });

        $('.img-preview').hide();
        $('#btn_uploadAvatar').hide();

        function preview_avatar() {
            const avatar = document.querySelector('#profile_picture');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';
            $('.avatar').hide();

            const OFReader = new FileReader();
            OFReader.readAsDataURL(avatar.files[0]);

            OFReader.onload = function(OFREvent) {
                imgPreview.src = OFREvent.target.result;
            }

            $('#btn_uploadAvatar').show();
        }

        $("input[type='file']").on("change", function () {
            if(this.files[0].size > 2000000) {
                file = $(this)[0].files[0];
                //console.log(file);

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: file.name + ' size must be less than 2 MB!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.img-preview').hide();
                        $('#btn_uploadAvatar').hide();
                        $('.avatar').show();
                    }
                });
            }

            return false;
        });

        $('#btn_uploadAvatar').click(function(){
            $('#updt_avatar').submit();
        });

        $('#fileup').click(function() {
            $('#profile_picture').click();
        });

        // when the user click a button book now smooth scroll to .book_merchant
        $('#btn_bookNow').click(function() {
            $('html, body').animate({
                scrollTop: $($.attr(this, 'href')).offset().top
            }, 1000);
        });

        $(document).ready(function(){
            get_notif();
            getChat();
            setInterval(function() {
                get_notif();
                getChat();
            }, 5000); //5 seconds
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

                    // d-block #notif_count
                    if (notif_count == 0) {
                        $('#notif_count').removeClass('d-md-inline');
                        $('#notif_count').addClass('d-none');
                    } else {
                        $('#notif_count').removeClass('d-none');
                        $('#notif_count').addClass('d-md-inline d-none');
                        $('#notif_mobile').addClass('d-sm-inline')
                    }
                    $('#notif_mobile').html(notif_count);
                    $('#notif_count').html(notif_count);
                    $.each(res['data'], function(key, value) {
                        html += '<a class="dropdown-item d-flex align-items-center" onClick="read('+value.id+');" id="notif_url">'+
                                    '<div>'+
                                        '<div class="small text-gray-500 fw-bold" id="notif_title">'+value.title+'</div>'+
                                        '<div class="text-truncate" style="max-width: 250px;" id="notif_content">'+value.content+'</div>'+
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
                url: "{{ route('get-list-customer') }}",
                type: "get",
                dataType: "json",
                success: function(res) {
                    var count = 0;
                    $.each(res, function(index, value) {
                        if (value.status == 'Unread') {
                            count++;
                        }
                    });

                    if (notif_count == 0) {
                        $('#chat_dstp').removeClass('d-md-inline');
                        $('#chat_dstp').addClass('d-none');
                    } else {
                        $('#chat_dstp').addClass('d-md-inline d-none');
                        $('#chat_dstp').removeClass('d-none');
                        $('#chat_mobile').addClass('d-sm-inline')
                    }
                    $('#chat_mobile').html(count);
                    $('#chat_dstp').html(count);
                },
                error: function(xhr) {
                    //console.log(xhr.responseText);
                }
            });
        }

    </script>
