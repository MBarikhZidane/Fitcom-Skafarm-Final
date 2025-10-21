<div class="modal fade custom-alert-modal" id="alertModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert-icon" id="alertIcon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title" id="alertTitle">Berhasil!</div>
                    <div class="alert-message" id="alertMessage">Operasi berhasil dilakukan.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="alertOkBtn">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status) {
            const alertModal = new bootstrap.Modal($('#alertModal')[0]);
            const alertIcon = $('#alertIcon');
            const alertTitle = $('#alertTitle');
            const alertMessage = $('#alertMessage');

            if (status === 'success') {
                alertIcon.html('<i class="bi bi-check-circle-fill text-success"></i>');
                alertTitle.text('Berhasil!');
                alertMessage.text('Operasi berhasil dilakukan.');
            } else if (status === 'error') {
                alertIcon.html('<i class="bi bi-x-circle-fill text-danger"></i>');
                alertTitle.text('Gagal!');
                alertMessage.text('Terjadi kesalahan, coba lagi.');
            }

            alertModal.show();
        }
    });
</script>