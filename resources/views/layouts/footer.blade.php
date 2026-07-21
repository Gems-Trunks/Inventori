@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: @json(session('success')),
                showConfirmButton: false,
                timer: 1500,
                showClass: {
                    popup: `
      animate__animated
      animate__fadeInDown
      animate__faster
    `
                },
            });
        });
    </script>
@endif
<script>
    Swal.fire({
        position: "top-end",
        icon: "",
        title: "Your work has been saved",
        showConfirmButton: false,
        timer: 1500
    });
</script>

</body>

</html>
