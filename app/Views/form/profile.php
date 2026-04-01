<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script>document.title = "My Profile";</script>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body, .content-wrapper, .main-sidebar, h1, h2, h3, h4, h5, h6, p, span, div, input, button {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    .content-wrapper > .container-fluid > .d-md-flex.align-items-center.justify-content-between.mb-5 {
        display: none !important;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .enterprise-card {
        background: white;
        border-radius: 32px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .swal-rounded {
        border-radius: 2rem !important;
        padding: 1.5rem !important;
    }

    .swal2-actions {
        width: 100% !important;
        display: flex !important;
        flex-direction: row !important;
        gap: 12px !important;
        margin-top: 2rem !important;
        padding: 0 1rem !important;
    }

    .btn-swal-hantar {
        flex: 1 !important;
        background: #4f46e5 !important;
        color: white !important;
        font-weight: 700 !important;
        padding: 14px !important;
        border-radius: 16px !important;
        border: none !important;
        order: 2 !important;
    }

    .btn-swal-batal {
        flex: 1 !important;
        background: #fee2e2 !important;
        color: #ef4444 !important;
        font-weight: 700 !important;
        padding: 14px !important;
        border-radius: 16px !important;
        border: none !important;
        order: 1 !important;
    }
    .swal-password-popup {
        --swal-password-side-gap: 1rem;
        border-radius: 2rem !important;
        padding: 2.2rem 2.1rem 1.9rem !important;
    }
    .swal-password-popup .swal2-html-container,
    .swal-password-popup .swal2-validation-message,
    .swal-password-popup .swal2-actions {
        width: calc(100% - (var(--swal-password-side-gap) * 2)) !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }
    .swal-password-popup .swal2-html-container {
        padding: 0 !important;
    }
    .swal-password-title {
        font-size: 1.05rem !important;
        font-weight: 800 !important;
        color: #374151 !important;
        margin-bottom: 1.8rem !important;
        text-align: center;
    }
    .swal-password-label {
        font-size: 1.05rem !important;
        font-weight: 800 !important;
        color: #374151 !important;
        margin-bottom: 0.8rem !important;
        text-align: center;
        padding-top: 10px;
    }
    .swal-password-body {
        margin: 0.9rem 0 0 !important;
    }

    .swal-password-input-wrap {
        position: relative;
        margin-top: 0.5rem;
        width: 100%; 
        display: block; 
    }

    .swal-password-input {
        width: 100% !important; 
        box-sizing: border-box !important; 
        border: 2px solid #fca5a5 !important;
        border-radius: 16px !important;
        padding: 1.1rem 3.5rem 1.1rem 1.2rem !important;
        font-size: 1rem !important;
        font-weight: 600 !important;
        color: #111827 !important;
        background: #fff !important;
        display: block !important;
    }

    .swal-password-input:focus {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12) !important;
    }

    .swal-password-toggle {
        position: absolute;
        top: 50%;
        right: 0.9rem;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #6b7280;
        font-size: 1.1rem;
        cursor: pointer;
        padding: 0.2rem;
    }

    .swal-password-toggle:hover {
        color: #4f46e5;
    }

    .swal-password-popup .swal2-validation-message {
        margin-top: 1rem !important;
        border-radius: 14px !important;
        font-weight: 600 !important;
    }
    .swal-password-popup .swal2-actions {
        padding: 0 !important;
    }

    .dropdown-menu {
        min-width: 200px;
        margin-top: 10px !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }

    .dropdown-item:active {
        background-color: #4f46e5 !important;
        color: white !important;
    }

    .dropdown-item:active i {
        color: white !important;
    }

    .profile-header-bg { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); height: 150px; }
    .avatar-wrapper { position: relative; display: inline-block; margin-top: -55px; margin-left: 30px; }
    .avatar-box { width: 110px; height: 110px; background: white; border: 4px solid white; border-radius: 28px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; color: #4f46e5; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; }
    .avatar-box img { width: 100%; height: 100%; object-fit: cover; }
    .upload-badge { position: absolute; bottom: -5px; right: -5px; background: #4f46e5; color: white; width: 34px; height: 34px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid white; }

    .modern-input { background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 14px; padding: 0.8rem 1.1rem; font-weight: 600; transition: all 0.2s; }
    .modern-input:focus { border-color: #4f46e5; background: white; outline: none; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); }
    .section-title { font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.2px; }
    .profile-section { padding: 0 3rem 3rem; }
    .deactivate-copy { color: #374151; font-size: 1rem; line-height: 1.7; margin-bottom: 0; }
    .btn-deactivate-inline {
        min-width: 190px;
        border-radius: 16px;
        border: 1px solid #dc2626;
        background: #ef4444;
        color: #fff;
        font-weight: 700;
        padding: 0.82rem 1.5rem;
        transition: all 0.2s;
    }
    .btn-deactivate-inline:hover {
        border-color: #b91c1c;
        background: #dc2626;
        color: #fff;
    }
</style>

<div class="container-fluid py-1 animate__animated animate__fadeIn">
    <div class="glass-card rounded-3xl p-8 mb-8 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center gap-6">
            <div class="bg-indigo-100 p-3 rounded-2xl">
                <i class="bi bi-person-bounding-box text-3xl text-indigo-600"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-1 text-dark">Profil Pengguna</h1>
                <p class="text-gray-500 font-medium mb-0">Urus maklumat peribadi dan keselamatan akaun anda</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="enterprise-card mb-4">
                <div class="profile-header-bg"></div>

                <form action="<?= base_url('/profile/update') ?>" method="post" enctype="multipart/form-data" id="formProfile" class="profile-form">
                    <?= csrf_field() ?>

                    <div class="avatar-wrapper">
                        <div class="avatar-box" id="imagePreview" data-default-initial="<?= esc(strtoupper(substr($user->username, 0, 1))) ?>">
                            <?php
                                $picName = $user->profile_pic;
                                $filePath = FCPATH . 'uploads/profile/' . $picName;

                                if (!empty($picName) && is_file($filePath)):
                            ?>
                                <img src="<?= base_url('uploads/profile/' . $picName) ?>?t=<?= time() ?>" alt="Profile">
                            <?php else: ?>
                                <span class="text-uppercase"><?= substr($user->username, 0, 1) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="dropdown">
                            <button class="upload-badge border-0" type="button" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-camera-fill"></i>
                            </button>
                            <ul class="dropdown-menu shadow-lg border-0 rounded-2xl p-2 animate__animated animate__fadeIn animate__faster" aria-labelledby="dropdownProfile">
                                <li>
                                    <label class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded-xl cursor-pointer hover:bg-indigo-50 transition-all">
                                        <i class="bi bi-image text-indigo-600"></i>
                                        <span class="small fw-bold text-slate-700">Pilih Gambar Baru</span>
                                        <input type="file" name="profile_pic" id="profile_pic" class="d-none" accept="image/*" onchange="this.form.submit()">
                                    </label>
                                </li>
                                <?php if (!empty($picName) && is_file($filePath)): ?>
                                    <li id="removePicDivider"><hr class="dropdown-divider opacity-50"></li>
                                    <li id="removePicItem">
                                        <button type="button" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded-xl text-danger hover:bg-red-50 transition-all" onclick="confirmRemove()">
                                            <i class="bi bi-trash3-fill"></i>
                                            <span class="small fw-bold">Buang Gambar</span>
                                        </button>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="p-4 p-md-5 pt-4">
                        <div class="mb-5">
                            <h3 class="fw-800 text-dark mb-1 font-bold text-2xl"><?= esc($user->username) ?></h3>
                            <p class="text-muted small fw-bold"><i class="bi bi-patch-check-fill text-primary"></i> Administrator Sistem</p>
                        </div>
                        <div class="profile-section px-md-0 pb-md-0">
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <span class="section-title font-bold">Maklumat Peribadi</span>
                                <div class="flex-grow-1 border-bottom border-slate-100"></div>
                            </div>
                            <div class="row g-4 mb-0">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-slate-600">Nama Penuh</label>
                                    <input type="text" name="username" class="form-control modern-input" value="<?= old('username', $user->username) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-slate-600">Alamat Emel</label>
                                    <input type="email" name="email" class="form-control modern-input" value="<?= old('email', $user->email) ?>" required>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn-submit bg-blue-600 hover:bg-blue-800 text-white px-6 py-2.5 rounded-2xl font-bold transition-all duration-300 shadow-lg shadow-blue-100 border-0">
                                        Simpan Perubahan Profil
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="<?= base_url('/profile/update-password') ?>" method="post" id="formPassword" class="profile-form profile-section px-4 px-md-5 pb-5">
                    <?= csrf_field() ?>
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <span class="section-title text-danger font-bold">Keselamatan Kata Laluan</span>
                        <div class="flex-grow-1 border-bottom border-red-50"></div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-slate-600">Kata Laluan Lama</label>
                            <div class="input-group">
                                <input type="password" name="current_password" class="form-control modern-input" id="old_pw" required>
                                <button class="btn toggle-password border-2 border-start-0 bg-light" style="border-radius: 0 14px 14px 0;" type="button" data-target="old_pw"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-slate-600">Kata Laluan Baru</label>
                            <div class="input-group">
                                <input type="password" name="new_password" class="form-control modern-input" id="new_pw" required>
                                <button class="btn toggle-password border-2 border-start-0 bg-light" type="button" data-target="new_pw"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-slate-600">Sahkan Kata Laluan</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" class="form-control modern-input" id="conf_pw" required>
                                <button class="btn toggle-password border-2 border-start-0 bg-light" type="button" data-target="conf_pw"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>
                        <div class="col-12 text-end mt-4">
                            <div id="pw-error" class="text-danger small mb-3 d-none font-bold">Kata laluan tidak sepadan!</div>
                            <button type="submit" id="btn-submit-pw" class="btn-submit bg-blue-600 hover:bg-blue-800 text-white px-6 py-2.5 rounded-2xl font-bold transition-all duration-300 border-0 shadow-lg">
                                Kemaskini Password
                            </button>
                        </div>
                    </div>
                </form>

                <div class="profile-section px-4 px-md-5 pb-5">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <span class="section-title text-danger font-bold">Penyahaktifan Akaun</span>
                        <div class="flex-grow-1 border-bottom border-red-100"></div>
                    </div>

                    <div class="row align-items-center g-4">
                        <div class="col-md-8">
                            <p class="deactivate-copy">Tindakan ini akan menyahaktifkan akaun anda daripada sistem ICT4U.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <button type="button" id="btnDeactivateAccount" class="btn-submit btn-deactivate-inline">
                                Nyahaktif Akaun
                            </button>
                        </div>
                    </div>

                    <form action="<?= base_url('/profile/deactivate-account') ?>" method="post" id="formDeactivateAccount" class="d-none">
                        <?= csrf_field() ?>
                        <input type="hidden" name="deactivate_password" id="deactivate_password">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berjaya!',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 2500,
                showConfirmButton: false,
                showCloseButton: false,
                customClass: { popup: 'swal-rounded', closeButton: 'swal2-close' }
            });
        <?php endif; ?>

        <?php if(session()->getFlashdata('error_pw')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Ralat!',
                text: '<?= session()->getFlashdata('error_pw') ?>',
                showCloseButton: true,
                customClass: { popup: 'swal-rounded', closeButton: 'swal2-close' }
            });
        <?php endif; ?>

        <?php if(session()->getFlashdata('error_deactivate')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Nyahaktif Gagal',
                text: '<?= session()->getFlashdata('error_deactivate') ?>',
                showCloseButton: true,
                customClass: { popup: 'swal-rounded', closeButton: 'swal2-close' }
            });
        <?php endif; ?>

        const profileInput = document.getElementById('profile_pic');
        const previewBox = document.getElementById('imagePreview');

        if (profileInput) {
            profileInput.onchange = function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => previewBox.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
                    reader.readAsDataURL(file);
                }
            };
        }

        document.querySelectorAll('.profile-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Kemaskini Maklumat?',
                    text: 'Pastikan maklumat anda adalah tepat sebelum disimpan.',
                    icon: 'question',
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'swal-rounded',
                        confirmButton: 'btn-swal-hantar',
                        cancelButton: 'btn-swal-batal',
                        actions: 'swal2-actions',
                        closeButton: 'swal2-close'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const btn = this.querySelector('.btn-submit');
                        btn.disabled = true;
                        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';
                        this.submit();
                    }
                });
            });
        });

        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = document.getElementById(this.getAttribute('data-target'));
                const icon = this.querySelector('i');
                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });

        const newPw = document.getElementById('new_pw');
        const confPw = document.getElementById('conf_pw');
        const err = document.getElementById('pw-error');
        const btn = document.getElementById('btn-submit-pw');
        const deactivateButton = document.getElementById('btnDeactivateAccount');
        const deactivateForm = document.getElementById('formDeactivateAccount');
        const deactivatePassword = document.getElementById('deactivate_password');
        const csrfInput = deactivateForm ? deactivateForm.querySelector('input[name="<?= csrf_token() ?>"]') : null;

        function checkMatch() {
            if (confPw.value.length > 0) {
                const match = newPw.value === confPw.value;
                err.classList.toggle('d-none', match);
                confPw.style.borderColor = match ? '#10b981' : '#ef4444';
                btn.disabled = !match;
            }
        }

        if (newPw && confPw) {
            newPw.addEventListener('input', checkMatch);
            confPw.addEventListener('input', checkMatch);
        }

        if (deactivateButton && deactivateForm && deactivatePassword) {
            deactivateButton.addEventListener('click', async function() {
                const confirmResult = await Swal.fire({
                    title: 'Nyahaktifkan Akaun?',
                    text: 'Akaun anda akan dinyahaktifkan dan anda akan dilog keluar secara automatik',
                    icon: 'warning',
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: 'Teruskan',
                    cancelButtonText: 'Batal',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'swal-rounded',
                        confirmButton: 'btn-swal-hantar',
                        cancelButton: 'btn-swal-batal',
                        actions: 'swal2-actions',
                        closeButton: 'swal2-close'
                    }
                });

                if (!confirmResult.isConfirmed) {
                    return;
                }

                const passwordResult = await Swal.fire({
                    title: 'Sahkan Kata Laluan',
                    text: '',
                    html: `
                        <div class="swal-password-body">
                            <div class="swal-password-label">Kata laluan semasa</div>
                            <div class="swal-password-input-wrap">
                                <input id="swalDeactivatePassword" type="password" class="swal-password-input" placeholder="Masukkan kata laluan" autocapitalize="off" autocorrect="off">
                                <button type="button" id="swalTogglePassword" class="swal-password-toggle" aria-label="Tunjuk kata laluan">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: 'Sahkan',
                    cancelButtonText: 'Batal',
                    buttonsStyling: false,
                    showLoaderOnConfirm: true,
                    customClass: {
                        popup: 'swal-password-popup',
                        confirmButton: 'btn-swal-hantar',
                        cancelButton: 'btn-swal-batal',
                        actions: 'swal2-actions',
                        closeButton: 'swal2-close'
                    },
                    didOpen: () => {
                        const passwordInput = document.getElementById('swalDeactivatePassword');
                        const toggleButton = document.getElementById('swalTogglePassword');
                        if (passwordInput) {
                            passwordInput.focus();
                        }

                        if (toggleButton && passwordInput) {
                            toggleButton.addEventListener('click', function() {
                                const icon = this.querySelector('i');
                                const isPassword = passwordInput.type === 'password';
                                passwordInput.type = isPassword ? 'text' : 'password';
                                icon.classList.toggle('bi-eye', !isPassword);
                                icon.classList.toggle('bi-eye-slash', isPassword);
                            });
                        }
                    },
                    preConfirm: async () => {
                        const passwordInput = document.getElementById('swalDeactivatePassword');
                        const value = passwordInput ? passwordInput.value : '';

                        if (!value) {
                            Swal.showValidationMessage('Kata laluan wajib diisi sebelum proses nyahaktifkan akaun.');
                            return false;
                        }

                        try {
                            const formData = new FormData();
                            formData.append('deactivate_password', value);

                            if (csrfInput) {
                                formData.append(csrfInput.name, csrfInput.value);
                            }

                            const response = await fetch("<?= base_url('profile/verify-deactivate-password') ?>", {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                },
                                body: formData
                            });

                            const result = await response.json();

                            if (csrfInput && result.csrf) {
                                csrfInput.value = result.csrf;
                            }

                            if (!response.ok || !result.status) {
                                Swal.showValidationMessage(result.message || 'Kata laluan semasa tidak betul.');
                                return false;
                            }

                            return value;
                        } catch (error) {
                            Swal.showValidationMessage('Semakan kata laluan gagal diproses.');
                            return false;
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                });

                if (passwordResult.isConfirmed) {
                    deactivatePassword.value = passwordResult.value;
                    this.disabled = true;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
                    deactivateForm.submit();
                }
            });
        }
    });

    function confirmRemove() {
        Swal.fire({
            title: 'Buang Gambar?',
            text: 'Gambar anda akan ditukar semula kepada default.',
            icon: 'warning',
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonText: 'Ya, Buang',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                popup: 'swal-rounded',
                confirmButton: 'btn-swal-hantar',
                cancelButton: 'btn-swal-batal',
                actions: 'swal2-actions',
                closeButton: 'swal2-close'
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch("<?= base_url('profile/delete-pic') ?>", {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const res = await response.json();

                    if (res.status) {
                        const previewBox = document.getElementById('imagePreview');
                        const defaultInitial = previewBox.dataset.defaultInitial || 'U';
                        previewBox.innerHTML = `<span class="text-uppercase">${defaultInitial}</span>`;

                        const removePicItem = document.getElementById('removePicItem');
                        const removePicDivider = document.getElementById('removePicDivider');
                        if (removePicItem) removePicItem.remove();
                        if (removePicDivider) removePicDivider.remove();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berjaya!',
                            text: res.message || 'Gambar profil berjaya dibuang.',
                            timer: 1800,
                            showConfirmButton: false,
                            showCloseButton: true,
                            customClass: { popup: 'swal-rounded', closeButton: 'swal2-close' }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message || 'Tidak berjaya membuang gambar profil.',
                            showCloseButton: true,
                            customClass: { popup: 'swal-rounded', closeButton: 'swal2-close' }
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ralat',
                        text: 'Permintaan AJAX gagal diproses.',
                        showCloseButton: true,
                        customClass: { popup: 'swal-rounded', closeButton: 'swal2-close' }
                    });
                }
            }
        });
    }
</script>

<?= $this->endSection() ?>
