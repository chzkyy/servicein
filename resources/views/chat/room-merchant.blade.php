@extends('layouts.dashboard')

@section('title')
    {{ __("Chat") }}
@endsection

@section('content')
<section class=" mt-5">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="container pt-5">
                {{--  back  --}}
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="text-decoration-none text-dark">
                            <i class="fas fa-arrow-left"></i>
                            <span class="ms-2">{{ __("Back") }}</span>
                        </a>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border border-1 rounded rounded-3 h-auto" style="border-color: #655503 !important;">
                            {{--  seach   --}}
                            <div class="card-header bg-transparent border">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row my-3 d-flex align-items-center">
                                            <div class="col-3 col-md-1 profile-img my-auto d-flex justify-content-end align-content-center">
                                                <img src="{{ url($avatar) }}"
                                                    class="img-circle" alt="Profile Image">
                                            </div>
                                            <div class="col-8">
                                                <div class="name fw-semibold">
                                                    {{ ucwords($name) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                {{--  chat  --}}
                                <div class="card-bubble">
                                    <div class="containerBubble" id='cntrBubble'>
                                    </div>
                                </div>

                                {{--  crreate field text  --}}
                                <div class="bg-transparent mt-3">
                                    <div class="input-group">
                                        {{--  <input type="text" class="form-control shadow rounded rounded-2 border-1 border-secondary bg-light small" id="chat-text" placeholder="Type a message" aria-label="Recipient's username" aria-describedby="basic-addon2">  --}}
                                        <textarea name="" id="chat-text" cols="30" rows="1" class="form-control shadow rounded rounded-2 border-1 border-secondary bg-light small" placeholder="Type a message"></textarea>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary ms-2" type="button">
                                                <i class="fas fa-paperclip"></i>
                                            </button>
                                            <button class="btn btn-primary" id="sendChat" type="button">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection


@section('additional-script')
    <script>
        $(document).ready(function() {
            $(".containerBubble").animate({ scrollTop: 20000000 }, "slow");

            setInterval(function() {
                getChat();
            }, 5000); //5 seconds

            $('#sendChat').click(function() {
                var message = $('#chat-text').val();
                if (message != '') {
                    $.ajax({
                        url: "{{ route('sendAdminChat') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            to: "{{ $customer_id }}",
                            from: "{{ auth()->user()->id }}",
                            message: message
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            $('#chat-text').val('');
                            getChat();
                        }
                    })
                }
            });
        });


        function getChat() {
            $.ajax({
                url: "{{ route('getAdminChat') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    customer_id: "{{ $customer_id }}"
                },
                dataType: "json",
                success: function(data) {
                    //
                    var html = '';
                    $.each(data, function(index, value) {
                        if (value.from == "{{ auth()->user()->id }}") {
                            html += '<div class="d-flex flex-row justify-content-end mb-4">';
                            html += '<div class="p-3 me-3 col-md-6 border rounded rounded-full bg-white border-2 shadow">';
                            html += '<p class="small mb-0 text-wrap col-md-12 chat">' + value.message + '</p>';
                            html += '</div>';
                            html += '</div>';
                        } else {
                            html += '<div class="d-flex flex-row justify-content-start mb-4">';
                            html += '<div class="p-3 ms-3 col-md-6 border rounded rounded-full bg-gradient-light border-2 shadow">';
                            html += '<p class="small mb-0 text-wrap col-md-12 chat">' + value.message + '</p>';
                            html += '</div>';
                            html += '</div>';

                            $.ajax({
                                url: "{{ route('readChat') }}",
                                type: "post",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    id: value.id
                                },
                                dataType: "json",
                                success: function(res) {
                                    // console.log(res);
                                }
                            })
                        }
                    });
                    $('.containerBubble').html(html);
                    $(".containerBubble").animate({ scrollTop: 20000000 }, "slow");
                }
            })
        }
    </script>
@endsection
