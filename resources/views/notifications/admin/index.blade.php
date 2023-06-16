@extends('layouts.app')

@section('title')
    {{ __('Merchant - Notification Center') }}
@endsection

@section('content')
    <section>
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12">
                    <div class="container">

                        <div class="notif-list my-3">
                            {{--  device list  --}}
                            <div class="d-flex justify-content-center align-content-center">
                                <div class="col-md-12">
                                    <h2 class="font-weight-bold txt-third txt-black mb-5">{{ __('Notification Center') }}</h2>
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>{{ __('Success') }}!</strong> {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if ($notif->isEmpty())
                                        <div class="alert alert-secondary alert-dismissible text-center fade show"
                                            role="alert">
                                            <strong></strong> {{ __('No data found.') }}
                                        </div>
                                    @else
                                        @foreach ($notif as $n)
                                            {{--  notification list  --}}
                                            @if ($n->status == 0)
                                                <div
                                                    class="card my-2 border rounded rounded-4 border-2 text-white bg-secondary notif-bg" id="read_notif">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 d-flex align-items-center">
                                                                <div class="row">
                                                                    <p class="font-weight-bold">{{ $n->title }}</p>
                                                                    <span>{{ $n->content }}</span>
                                                                    <input type="hidden" name="notif_id" value="{{ $n->id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="card my-2 border border-2 rounded rounded-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 d-flex align-items-center">
                                                                <div class="row">
                                                                    <p class="font-weight-bold">{{ $n->title }}</p>
                                                                    <span>{{ $n->content }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{--  modal edit  --}}
                                        @endforeach
                                        {{--  pagination  --}}
                                        <div class="row">
                                            <div class="col-md-12 float-right">
                                                {{ $notif->links() }}
                                            </div>
                                        </div>
                                    @endif
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
        // read notification
        $(document).on('click', '#read_notif', function() {
            var id = $(this).find('input[name="notif_id"]').val();


            $.ajax({
                url: "{{ route('read-notification') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                success: function(data) {
                    // refresh the page
                    location.reload();

                },
                error: function(err) {
                    // console.log(err);
                }
            });
        });
    </script>
@endsection
