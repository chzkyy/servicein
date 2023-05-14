<script>
    const url = "{{ url('/') }}";
</script>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ url('assets/js/jquery.appear.min.js') }}"></script>
<script src="{{ url('assets/js/jquery.easypiechart.min.js') }}"></script>
<script src="{{ url('assets/js/simpleGauge.js') }}"></script>

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
    $('#btn_saveChanges').click(function(){
        $('#update_profile').submit();
    });

    $(document).ready(function() {

        $('.gauge-wrap').simpleGauge({
            width:'120',
            hueLow:'0',
            hueHigh:'0',
            saturation:'0%',
            lightness:'0%',
            gaugeBG:'#fff',
            parentBG:'#fff'
        });
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

    $('#btn_uploadAvatar').click(function(){
        $('#updt_avatar').submit();
    });

</script>
