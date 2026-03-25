<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script>document.title = "Sistem Perincian Modul";</script>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<style>
    /* 1. Global Font */
    body, .content-wrapper, .main-sidebar, h1, h2, h3, h4, h5, h6, p, span, div, table, input, textarea, button {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* 2. Hide Dashboard Header */
    .content-wrapper > .container-fluid > .d-md-flex.align-items-center.justify-content-between.mb-5 {
        display: none !important;
    }

    /* 3. Glassmorphism Card Style */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        border-radius: 1.5rem;
    }

    /* 4. Input Modern Style */
    .input-modern {
        width: 100%;
        padding: 0.85rem 1rem;
        border-radius: 0.85rem;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        outline: none;
        transition: all 0.2s;
        font-size: 0.95rem;
        font-weight: 500;
    }
    .input-modern:focus { 
        border-color: #4f46e5; 
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); 
    }

    /* 5. Reset Button Style */
    .btn-reset {
        color: #dc2626;
        font-weight: 700;
        padding: 12px 20px;
        border-radius: 12px;
        transition: 0.2s;
    }

    /* 6. SweetAlert Custom Styling */
    .swal-rounded {
        border-radius: 2rem !important;
        padding: 1.5rem !important;
    }
    
    .swal2-close {
        border-radius: 50% !important;
        margin-top: 10px !important;
        margin-right: 10px !important;
        transition: all 0.2s ease !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .swal2-close:hover {
        background: transparent !important; 
        color: #ef4444 !important; 
    }

    .swal2-actions {
        width: 100% !important;
        display: flex !important;
        gap: 12px !important;
        margin-top: 1.5rem !important;
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
        order: 2;
    }

    .btn-swal-batal {
        flex: 1 !important;
        background: #fee2e2 !important; 
        color: #ef4444 !important; 
        font-weight: 700 !important;
        padding: 14px !important; 
        border-radius: 16px !important;
        order: 1;
    }
    .btn-reset:hover { background: #FEEBE7; color: #dc2626; }

    /* CKEditor Customization */
    .ck-editor__main>.ck-editor__editable { min-height: 250px; border-radius: 0 0 12px 12px !important; padding: 10px 20px !important; }
    .ck.ck-editor__top { border-radius: 12px 12px 0 0 !important; border-bottom: none !important; }
    
    .hidden { display: none; }
    .text-slate-500 { color: #64748b; }
    .input-modern.pr-12 { padding-right: 3.5rem !important; }

    .relative.group .absolute {
        right: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        height: auto;
        z-index: 10;
        line-height: 0;
    }

    .relative.group:hover .bi-clipboard {
        color: #4f46e5;
        transform: scale(1.1);
    }

    .swal-toast-custom {
        display: flex !important;
        align-items: center !important;
        flex-direction: row !important;
        padding: 2px 8px !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        animation: slideDown 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    }

    @keyframes slideDown {
        from { transform: translateY(-150%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .swal-toast-custom .swal2-title {
        margin: 0 0 0 10px !important;
        padding: 0 !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        color: #334155 !important;
        white-space: nowrap !important;
        display: flex !important;
        align-items: center !important;
    }

    .swal-toast-custom .swal2-icon {
        margin: 0 !important;
        border: none !important;
        width: auto !important;
        height: auto !important;
        display: flex !important;
        align-items: center !important;
    }

    .animate__fadeOutUp { animation: fadeOutUp 0.10s forwards !important; }
    @keyframes fadeOutUp {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }

    /* ==========================================
       TOM SELECT - DROPDOWN INPUT UI 
    ========================================== */
    .servis-select-wrapper {
        position: relative;
        z-index: 60;
    }

    /* Kotak Utama (Tempat user klik) */
    .TS-Compact .ts-wrapper.single .ts-control {
        min-height: 48px !important;
        padding: 0 1.2rem 0 1rem !important;
        border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        display: flex;
        align-items: center;
        cursor: pointer !important;
        transition: all 0.2s ease;
    }

    /* Kotak Menyala Indigo bila diklik */
    .TS-Compact .ts-wrapper.focus .ts-control,
    .TS-Compact .ts-wrapper.dropdown-active .ts-control {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15) !important;
    }

    /* Text Pilihan (Kat luar dropdown) */
    .TS-Compact .ts-wrapper.single .ts-control > .item,
    .TS-Compact .ts-control > input::placeholder {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        color: #475569 !important;
    }

    /* Bunuh terus arrow default Tom Select */
    .TS-Compact .ts-wrapper::after,
    .TS-Compact .ts-control::after {
        display: none !important;
        content: none !important;
    }

    /* Container Dropdown Menu */
    .TS-Compact .ts-dropdown {
        border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        margin-top: 8px !important;
        overflow: hidden;
        z-index: 9999;
    }

    /* -------------------------------------------
       MAGIC: KOTAK SEARCH DALAM DROPDOWN
       ------------------------------------------- */
    .TS-Compact .dropdown-input-wrap {
        padding: 10px !important; 
        border-bottom: 1px solid #e2e8f0 !important; 
        background: #ffffff !important;
    }

    .TS-Compact .dropdown-input {
        width: 100% !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.5rem !important;
        padding: 0.6rem 1rem !important;
        font-size: 0.95rem !important;
        color: #475569 !important;
        outline: none !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    .TS-Compact .dropdown-input:focus {
        border-color: #4f46e5 !important; 
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
    }

    /* -------------------------------------------
       MAGIC: TEMA INDIGO HOVER (BUBBLE EFFECT)
       ------------------------------------------- */
    .TS-Compact .ts-dropdown-content {
        padding: 4px !important; 
    }

    .TS-Compact .ts-dropdown .option {
        padding: 0.6rem 1rem !important;
        font-size: 0.95rem !important;
        color: #334155 !important;
        border-radius: 0.5rem !important;
        margin-bottom: 2px !important;
        transition: all 0.2s ease;
    }

    /* Warna highlight Indigo */
    .TS-Compact .ts-dropdown .active,
    .TS-Compact .ts-dropdown .option:hover {
        background-color: #e0e7ff !important; 
        color: #3730a3 !important; 
        font-weight: 700 !important;
    }

    /* Sorok Placeholder Dari Dropdown List */
    .TS-Compact .ts-dropdown .option[data-value=""] {
        display: none !important;
    }

    /* Animasi Arrow Pusing 180 Darjah */
    .ts-wrapper.dropdown-active ~ .custom-arrow {
        transform: translateY(-50%) rotate(180deg) !important;
    }

</style>

<div class="container-fluid py-1">
    <div class="glass-card p-8 mb-8 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="bg-indigo-50 p-3 rounded-2xl">
                <i class="bi bi-collection-fill text-3xl text-indigo-500"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-1">Perincian Modul</h1>
                <p class="text-slate-500 font-medium mb-0">Kemaskini maklumat dan penerangan servis rasmi</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-8 relative z-30">
        <div class="md:col-span-4">
            <div class="glass-card p-6 h-full shadow-sm">
                <div class="block text-xs font-bold text-slate-700 uppercase tracking-normal mb-2 flex items-center gap-2">
                    <i class="bi bi-tag-fill text-slate-700"></i> Pilih Servis Utama
                </div>
                <div class="servis-select-wrapper TS-Compact relative">
                    <select id="dropdownServis" autocomplete="off" name="idservis_pilih">
                        <option value="">-- Sila Pilih Servis --</option>
                        <?php foreach($servisList as $s): ?>
                            <option value="<?= esc($s['idservis']) ?>" 
                                    data-name="<?= esc($s['namaservis']) ?>"
                                    data-infourl="<?= esc($s['infourl']) ?>"
                                    data-mohonurl="<?= esc($s['mohonurl']) ?>">
                                <?= esc($s['namaservis']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i class="custom-arrow bi bi-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none transition-transform duration-200" style="z-index: 100;"></i>
                </div>
            </div>
        </div>
    </div>

    <div id="emptyState" class="glass-card py-20 bg-white relative z-10">
        <div class="text-center">
            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-filter text-4xl text-slate-300"></i>
            </div>
            <h5 class="text-slate-900 font-bold mb-1">Sila Pilih Servis</h5>
            <p class="text-slate-500 font-medium">Pilih kategori servis di atas untuk memaparkan borang perincian.</p>
        </div>
    </div>

    <div id="formArea" class="hidden">
        <div class="glass-card p-8 bg-white relative z-10">
            <form id="servisForm" action="<?= site_url('perincianmodul/save') ?>" method="POST" class="space-y-8">
                <?= csrf_field() ?>
                <input type="hidden" name="idservis" id="idservis">

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Servis Rasmi (Max 145 Aksara)</label>
                    <input type="text" id="namaservis" name="namaservis" class="input-modern" maxlength="145">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">URL Info (HTTP/HTTPS/FTP)</label>
                        <div class="relative group">
                            <input type="url" id="infourl" name="infourl" class="input-modern pr-12" placeholder="https://...">
                            <button type="button" onclick="copyToClipboard('infourl')" class="absolute" title="Salin Link">
                                <i class="bi bi-clipboard text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">URL Mohon (HTTP/HTTPS/FTP)</label>
                        <div class="relative group">
                            <input type="url" id="mohonurl" name="mohonurl" class="input-modern pr-12" placeholder="https://...">
                            <button type="button" onclick="copyToClipboard('mohonurl')" class="absolute" title="Salin Link">
                                <i class="bi bi-clipboard text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Description / Perincian</label>
                    <textarea id="description" name="description"></textarea>
                </div>

                <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                    <button type="button" id="btnReset" class="bg-red-500 hover:bg-red-600 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg shadow-red-500/30">
                        Reset
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg shadow-blue-500/30">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let editor;
    let originalData = { name: '', info: '', mohon: '', desc: '' };

    // ==========================================
    // INIT TOM SELECT (DENGAN PLUGIN DROPDOWN INPUT)
    // ==========================================
    const dropdownServis = new TomSelect('#dropdownServis', {
        allowEmptyOption: true,
        create: false,
        maxItems: 1,
        searchField: ['text'],
        placeholder: 'Cari nama servis...',
        plugins: ['dropdown_input'], 
        
        onInitialize: function() {
            this.wrapper.classList.toggle('dropdown-active', this.isOpen);
        },
        onDropdownOpen: function() {
            this.wrapper.classList.add('dropdown-active');
            setTimeout(() => {
                const searchInput = this.dropdown.querySelector('.dropdown-input');
                if(searchInput) searchInput.focus();
            }, 50);
        },
        onDropdownClose: function() {
            this.wrapper.classList.remove('dropdown-active');
        }
    });

    // ==========================================
    // 1. SUCCESS / ERROR HANDLING (FLASH DATA)
    // ==========================================
    <?php if(session()->getFlashdata('success')): ?>
        Swal.fire({ 
            icon: 'success', title: 'Berjaya!', text: '<?= session()->getFlashdata('success') ?>', 
            showConfirmButton: false, customClass: { popup: 'swal-rounded' }, timer: 3000 
        });
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        Swal.fire({ 
            icon: 'error', title: 'Ralat!', html: '<?= session()->getFlashdata('error') ?>', 
            confirmButtonText: 'Cuba Lagi', customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-batal' }, buttonsStyling: false 
        });
    <?php endif; ?>

    // ==========================================
    // 2. INITIALIZE CKEDITOR
    // ==========================================
    ClassicEditor.create(document.querySelector('#description'), {
        toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote','undo','redo']
    }).then(newEditor => { editor = newEditor; }).catch(err => { console.error(err); });

    // ==========================================
    // 3. DROPDOWN CHANGE HANDLER
    // ==========================================
    $('#dropdownServis').change(function() {
        const id = $(this).val();
        const selectEl = document.getElementById('dropdownServis');
        const selectedOption = selectEl.options[selectEl.selectedIndex];

        if (!id) {
            $('#formArea').addClass('hidden');
            $('#emptyState').removeClass('hidden');
            return;
        }

        $('#emptyState').addClass('hidden');
        $('#formArea').removeClass('hidden');

        const name = selectedOption.getAttribute('data-name');
        const info = selectedOption.getAttribute('data-infourl') || '';
        const mohon = selectedOption.getAttribute('data-mohonurl') || '';

        $('#idservis').val(id);
        $('#namaservis').val(name);
        $('#infourl').val(info);
        $('#mohonurl').val(mohon);

        $.get(`<?= base_url('perincianmodul/getServis') ?>/${id}`, function(res) {
            const descContent = (res.desc && res.desc.description) ? res.desc.description : '';
            if (editor) editor.setData(descContent);
            originalData = { name: name, info: info, mohon: mohon, desc: descContent };
        });
    });

    // ==========================================
    // 4. VALIDATION & CONFIRMATION
    // ==========================================
    $('#servisForm').on('submit', function(e) {
        e.preventDefault();
        const form = this; 
        const nameVal = $('#namaservis').val().trim();
        const currentInfoUrl = $('#infourl').val().trim();
        const currentMohonUrl = $('#mohonurl').val().trim();
        
        if (nameVal === "") {
            Swal.fire({ icon: 'warning', title: 'Borang Tidak Lengkap', text: 'Nama Servis Rasmi wajib diisi.', customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-hantar' }, buttonsStyling: false });
            return false;
        }

        const isInfoUrlChanged = (currentInfoUrl !== (originalData.info || ''));
        const isMohonUrlChanged = (currentMohonUrl !== (originalData.mohon || ''));

        if (isInfoUrlChanged || isMohonUrlChanged) {
            Swal.fire({
                title: 'Sahkan Perubahan Link?',
                text: "Adakah anda pasti untuk tukar ke link yang baru?",
                icon: 'question',
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-hantar', cancelButton: 'btn-swal-batal', actions: 'swal2-actions', closeButton: 'swal2-close' },
                buttonsStyling: false
            }).then((result) => { if (result.isConfirmed) { form.submit(); } });
        } else {
            form.submit();
        }
    });

    // ==========================================
    // 5. RESET BUTTON 
    // ==========================================
    $('#btnReset').click(function() {
        const idservis = $('#idservis').val();
        if (!idservis) return;

        Swal.fire({
            title: 'Reset Semula?',
            text: "Data perincian akan dikosongkan.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, Kosongkan',
            customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-hantar', cancelButton: 'btn-swal-batal', actions: 'swal2-actions' },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                if (editor) editor.setData(''); 
                $('#description').val(''); 
                $('#servisForm').submit(); 
            }
        });
    });

    window.copyToClipboard = function(inputId) {
        const copyText = document.getElementById(inputId);
        const value = copyText.value.trim();

        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 2000, timerProgressBar: false, width: 'auto',
            hideClass: { popup: 'animate__animated animate__fadeOutUp' },
            customClass: { popup: 'swal-toast-custom', timerProgressBar: 'swal-progress-custom' }
        });

        if (!value) {
            Toast.fire({ iconHtml: '<i class="bi bi-exclamation-circle text-red-500" style="font-size: 1.1rem;"></i>', title: 'Gagal! Tiada link untuk disalin.', background: '#fff5f5' });
            return;
        }

        navigator.clipboard.writeText(value).then(() => {
            Toast.fire({ iconHtml: '<i class="bi bi-check2-circle text-green-500" style="font-size: 1.1rem;"></i>', title: 'Berjaya! Link telah disalin.', background: '#f0fff4' });
        });
    }
});
</script>

<?= $this->endSection() ?>