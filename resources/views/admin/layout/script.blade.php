<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<!-- jQuery -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('dist/js/demo.js')}}"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.main-sidebar');
    const toggleButton = document.querySelector('[data-widget="pushmenu"]');
    
    toggleButton.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
    });
});
</script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8xxqUcj3DdFxFpHsecxPkaSK3ajslMUI&libraries=places" async defer></script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            var addressInput = document.getElementById('address');

            if (addressInput) {
                var autocomplete = new google.maps.places.Autocomplete(addressInput, {
                    types: ['address'],
                });

                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    if (!place.geometry) {
                        console.log('No details available for input: "' + place.name + '"');
                        return;
                    }
                    console.log(place);
                });
            }
        });
    </script>

<script>
    function confirmLogout(event) {
        event.preventDefault(); 

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to logout?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the logout route if confirmed
                window.location.href = "{{ route('admin.logout') }}";
            }
        });
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.nav-link');

    links.forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});

</script>


<!-- -->







