@props(['user'])
<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUser" action="{{ route('users.update', auth()->user()->id) }}" method="POST">
                     @csrf
                     @method('PUT')
                        <div class="mb-3">
                            <label for="nama" class="col-form-label">Nama :</label>
                            <input type="text" name="nama" class="form-control" id="modalEditNama">
                        </div>
                        <div class="mb-3">
                            <label for="nrp" class="col-form-label">NRP :</label>
                            <input type="text" name="nrp" class="form-control"  id="modalEditNrp">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Password Baru :</label>
                            <input type="password" name="password" class="form-control"  id="modalEditPassword">
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Edit Profile</button>
                </div>
                    </form>

            </div>
        </div>
    </div>

</div>

<!-- Script Bootstrap Event Listener -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('editUserModal');
        
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function (event) {
                // Tombol pemicu yang diklik
                const button = event.relatedTarget;
                
                // Ambil data dari atribut data-bs-*
                const id = button.getAttribute('data-bs-id');
                const nama = button.getAttribute('data-bs-nama');
                const nrp = button.getAttribute('data-bs-nrp');
                const updateUrl = button.getAttribute('data-bs-url');

                // Isi nilai ke dalam form modal
                document.getElementById('modalEditNama').value = nama;
                document.getElementById('modalEditNrp').value = nrp;
                document.getElementById('modalEditPassword').value = password;
                
                // Set action URL form ke route update laravel
                document.getElementById('editUser').action = updateUrl;
            });
        }
    });
</script>
