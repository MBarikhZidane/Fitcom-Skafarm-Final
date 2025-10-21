<style>
    .custom-alert-modal .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .custom-alert-modal .modal-body {
        padding: 40px 30px 20px;
        text-align: center;
    }

    .custom-alert-modal .alert-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin: 0 auto 20px;
        flex-shrink: 0;
    }

    .custom-alert-modal .alert-icon.warning {
        background: #fef3c7;
        color: #d97706;
    }

    .custom-alert-modal .alert-icon.success {
        background: #dcfce7;
        color: #16a34a;
    }

    .custom-alert-modal .alert-icon.error {
        background: #fee2e2;
        color: #dc2626;
    }

    .custom-alert-modal .alert-content {
        text-align: center;
    }

    .custom-alert-modal .alert-title {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .custom-alert-modal .alert-message {
        color: #64748b;
        margin-bottom: 0;
        line-height: 1.6;
        font-size: 16px;
    }

    .custom-alert-modal .modal-footer {
        border: none;
        padding: 20px 30px 40px;
        justify-content: center;
        gap: 12px;
    }

    .custom-alert-modal .btn {
        min-width: 100px;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
    }
</style>
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
    $(function() {
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