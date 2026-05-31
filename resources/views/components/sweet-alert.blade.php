@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false,
        });
    </script>
@endif

@if(session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: '{{ session('warning') }}',
            timer: 3000,
            showConfirmButton: false,
        });
    </script>
@endif

@if(session('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: '{{ session('info') }}',
            timer: 3000,
            showConfirmButton: false,
        });
    </script>
@endif

@if(session('status'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('status') }}',
            timer: 3000,
            showConfirmButton: false,
        });
    </script>
@endif
