<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script>document.title = "Sistem Perincian Modul";</script>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        border-color: #3b82f6; 
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); 
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
    
    /* Styling for Close Button (X) */
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


    .btn-swal-hantar { order: 2 !important; }
    .btn-swal-batal { order: 1 !important; }

    /* CKEditor Customization */
    .ck-editor__main>.ck-editor__editable { min-height: 250px; border-radius: 0 0 12px 12px !important; padding: 10px 20px !important; }
    .ck.ck-editor__top { border-radius: 12px 12px 0 0 !important; border-bottom: none !important; }
    
    .hidden { display: none; }

    /* Tailwind Conflict Fixes */
.text-slate-500 { color: #64748b; }
</style>

<div class="container-fluid py-1">
    <div class="glass-card p-8 mb-8 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="bg-indigo-50 p-3 rounded-2xl">
                <i class="bi bi-collection-fill text-3xl text-indigo-500"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-1">Sistem Perincian Modul</h1>
                <p class="text-slate-500 font-medium mb-0">Kemaskini maklumat dan penerangan servis rasmi</p>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 mb-8 max-w-md">
        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
            <i class="bi bi-tag-fill text-black-400"></i> Pilih Servis Utama
        </label>
        <div class="relative">
            <select id="dropdownServis" class="w-full appearance-none bg-white border border-slate-200 p-3 rounded-xl focus:outline-none font-semibold text-slate-600 cursor-pointer shadow-sm">
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
            <i class="bi bi-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none"></i>
        </div>
    </div>

    <div id="emptyState" class="glass-card py-20 bg-white">
        <div class="text-center">
            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-filter text-4xl text-slate-300"></i>
            </div>
            <h5 class="text-slate-900 font-bold mb-1">Sila Pilih Servis</h5>
            <p class="text-slate-500 font-medium">Pilih kategori servis di atas untuk memaparkan borang perincian.</p>
        </div>
    </div>

    <div id="formArea" class="hidden">
        <div class="glass-card p-8 bg-white">
            <form id="servisForm" action="<?= site_url('perincianmodul/save') ?>" method="POST" class="space-y-8">
                <?= csrf_field() ?>
                <input type="hidden" name="idservis" id="idservis">

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Servis Rasmi (Max 145 Aksara)</label>
                    <input type="text" id="namaservis" name="namaservis" class="input-modern" maxlength="145">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Info URL (HTTP/HTTPS/FTP)</label>
                        <input type="url" id="infourl" name="infourl" class="input-modern" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Mohon URL (HTTP/HTTPS/FTP)</label>
                        <input type="url" id="mohonurl" name="mohonurl" class="input-modern" placeholder="https://...">
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
    // 1. SUCCESS / ERROR HANDLING (FLASH DATA)
    // ==========================================
    <?php if(session()->getFlashdata('success')): ?>
        Swal.fire({ 
            icon: 'success', 
            title: 'Berjaya!', 
            text: '<?= session()->getFlashdata('success') ?>', 
            showConfirmButton: false,
            customClass: {
                popup: 'swal-rounded',
            },
            timer: 3000,
        });
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        Swal.fire({ 
            icon: 'error', 
            title: 'Ralat!', 
            html: '<?= session()->getFlashdata('error') ?>', 
            confirmButtonText: 'Cuba Lagi',
            customClass: {
                popup: 'swal-rounded',
                confirmButton: 'btn-swal-batal'
            },
            buttonsStyling: false
        });
    <?php endif; ?>

    // ==========================================
    // 2. INITIALIZE CKEDITOR
    // ==========================================
    ClassicEditor
    .create(document.querySelector('#description'), {
        toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote','undo','redo']
    })
    .then(newEditor => {
        editor = newEditor;
    })
    .catch(error => { console.error("CKEditor failed:", error); });

    // ==========================================
    // 3. DROPDOWN CHANGE HANDLER
    // ==========================================
    $('#dropdownServis').change(function() {
        const id = $(this).val();
        const selectedOption = $(this).find('option:selected');

        if (!id) {
            $('#formArea').addClass('hidden');
            $('#emptyState').removeClass('hidden');
            return;
        }

        $('#emptyState').addClass('hidden');
        $('#formArea').removeClass('hidden');

        const name = selectedOption.data('name');
        const info = selectedOption.data('infourl') || '';
        const mohon = selectedOption.data('mohonurl') || '';

        $('#idservis').val(id);
        $('#namaservis').val(name);
        $('#infourl').val(info);
        $('#mohonurl').val(mohon);

        // Fetch data AJAX
        $.get(`<?= base_url('perincianmodul/getServis') ?>/${id}`, function(res) {
            const descContent = (res.desc && res.desc.description) ? res.desc.description : '';
            if (editor) editor.setData(descContent);
            
            // Simpan data asal untuk check perubahan link nanti
            originalData = {
                name: name,
                info: info,
                mohon: mohon,
                desc: descContent
            };
        });
    });

    // ==========================================
    // 4. VALIDATION & CONFIRMATION
    // ==========================================
    $('#servisForm').on('submit', function(e) {
        e.preventDefault();
        const form = this; // Simpan reference form

        const nameVal = $('#namaservis').val().trim();
        const currentInfoUrl = $('#infourl').val().trim();
        const currentMohonUrl = $('#mohonurl').val().trim();
        
        if (nameVal === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Borang Tidak Lengkap',
                text: 'Nama Servis Rasmi wajib diisi.',
                customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-hantar' },
                buttonsStyling: false
            });
            return false;
        }

        // Check perubahan link
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
                customClass: {
                    popup: 'swal-rounded',
                    confirmButton: 'btn-swal-hantar',
                    cancelButton: 'btn-swal-batal',
                    actions: 'swal2-actions',
                    closeButton: 'swal2-close'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form guna reference
                }
            });
        } else {
            form.submit();
        }
    });

    // ==========================================
    // 5. RESET BUTTON 
    // ==========================================
    $('#btnReset').click(function() {
        const idservis = $('#idservis').val();
        const namaservis = $('#namaservis').val();

        if (!idservis) return;

        Swal.fire({
            title: 'Reset Semula?',
            text: "Data perincian akan dikosongkan.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, Kosongkan',
            customClass: { 
                popup: 'swal-rounded', 
                confirmButton: 'btn-swal-hantar', 
                cancelButton: 'btn-swal-batal',
                actions: 'swal2-actions'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                if (editor) editor.setData(''); 
                $('#description').val(''); 
                $('#servisForm').submit(); 
            }
        });
    });
});
</script>

<?= $this->endSection() ?>