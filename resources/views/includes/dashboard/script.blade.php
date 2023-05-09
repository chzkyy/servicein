<script>
    const url = "{{ url('/') }}";
</script>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ url('assets/js/jquery.appear.min.js') }}"></script>
<script src="{{ url('assets/js/jquery.easypiechart.min.js') }}"></script>

<script>
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
    function run()
    {
        var fName = arguments[0],
            aArgs = Array.prototype.slice.call(arguments, 1);
        try {
            fName.apply(window, aArgs);
        } catch(err) {

        }
    };

    /* chart
    ================================================== */
    function _chart ()
    {
        $('.b-profile').appear(function() {
            setTimeout(function() {
                $('.chart').easyPieChart({
                    easing: 'easeOutElastic',
                    delay: 3000,
                    barColor: '#E3C10F',
                    trackColor: '#fff',
                    scaleColor: false,
                    lineWidth: 21,
                    trackWidth: 21,
                    size: 250,
                    lineCap: 'round',
                    onStep: function(from, to, percent) {
                        this.el.children[0].innerHTML = Math.round(percent);
                    }
                });
            }, 150);
        });
    };


    $(document).ready(function() {
        run(_chart);
    });
</script>
