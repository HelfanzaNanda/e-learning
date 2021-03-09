<!-- jQuery -->
<script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('assets/vendor/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap.min.js') }}"></script>

<!-- Perfect Scrollbar -->
<script src="{{ asset('assets/vendor/perfect-scrollbar.min.js') }}"></script>

<!-- DOM Factory -->
<script src="{{ asset('assets/vendor/dom-factory.js') }}"></script>

<!-- MDK -->
<script src="{{ asset('assets/vendor/material-design-kit.js') }}"></script>

<!-- Range Slider -->
<script src="{{ asset('assets/vendor/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('assets/js/ion-rangeslider.js') }}"></script>

<!-- App -->
<script src="{{ asset('assets/js/toggle-check-all.js') }}"></script>
<script src="{{ asset('assets/js/check-selected-row.js') }}"></script>
<script src="{{ asset('assets/js/dropdown.js') }}"></script>
<script src="{{ asset('assets/js/sidebar-mini.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- App Settings (safe to remove) -->
<script src="{{ asset('assets/js/app-settings.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha512-UwcC/iaz5ziHX7V6LjSKaXgCuRRqbTp1QHpbOJ4l1nw2/boCfZ2KlFIqBUA/uRVF0onbREnY9do8rM/uT/ilqw==" crossorigin="anonymous"></script>

<script>
    const BASE_URL = "{{ env('APP_URL') }}"
</script>

<script>
    function insert(url, form_data){
        return $.ajax({
            type: 'post',
            url: url,
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
        });
    }

    function get(url){
        return $.ajax({
            type: 'get',
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
        });
    }

    
    function alertError(message){
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: message
        });
    }
</script>