@if(session()->hasAny(['success', 'error', 'warning', 'info', 'status']))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                window.Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif

            @if(session('error'))
                window.Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif

            @if(session('warning'))
                window.Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: @json(session('warning')),
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif

            @if(session('info'))
                window.Swal.fire({
                    icon: 'info',
                    title: 'Informasi',
                    text: @json(session('info')),
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif

            @if(session('status'))
                window.Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('status')),
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif
        });
    </script>
@endif
