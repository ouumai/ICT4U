<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script>document.title = "Sistem Pengurusan Dokumen";</script>

<meta name="csrf-token" content="<?= csrf_hash() ?>">

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.css" rel="stylesheet">

<style>
    /* 1. Global Setup & Typography */
    body, .content-wrapper, h1, h2, h3, h4, h5, h6, p, span, div, table, input, textarea, button {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* 2. Hide Default Dashboard Header */
    .content-wrapper > .container-fluid > .d-md-flex.align-items-center.justify-content-between.mb-5 {
        display: none !important;
    }

    /* 3. Card Styling */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        border-radius: 1.5rem;
    }

    /* 4. Table Header Design */
    .compact-th {
        padding: 25px 20px !important;
        background-color: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        color: #64748b !important;
    }

    #btnTambahModal:disabled {
        cursor: not-allowed !important;
        opacity: 0.6;
    }

    /* 5. SweetAlert UI Design (Standard ICT4U) */
    .swal-rounded { border-radius: 2rem !important; padding: 1.5rem !important; }
    .swal2-popup { border-radius: 28px !important; padding: 2rem !important; }
    .swal2-actions { width: 100% !important; display: flex !important; flex-direction: row !important; gap: 12px !important; margin-top: 1.5rem !important; padding: 0 1rem !important; }
    
    .btn-swal-indigo { flex: 1 !important; background: #4f46e5 !important; color: white !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; border: none !important; order: 2 !important; }
    .btn-swal-merah { flex: 1 !important; background: #fee2e2 !important; color: #ef4444 !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; border: none !important; order: 1 !important; }

    .swal-label-custom { display: block; font-size: 0.8rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
    .swal-input-custom { min-height: 52px; border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px 15px; width: 100%; background-color: #ffffff; font-weight: 500; font-size: 0.95rem; }

    .ict4u-dropzone {
        border: 2px dashed #a5b4fc !important;
        border-radius: 1rem !important;
        background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%) !important;
        padding: 1.5rem 1.25rem !important;
        min-height: 220px !important;
        transition: all 0.2s ease !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    .ict4u-dropzone:hover,
    .ict4u-dropzone.dz-drag-hover {
        border-color: #4f46e5 !important;
        background: linear-gradient(135deg, #e0e7ff 0%, #ffffff 100%) !important;
        box-shadow: 0 0 0 6px rgba(79, 70, 229, 0.10) !important;
        transform: translateY(-1px);
    }

    .ict4u-dropzone .dz-message {
        margin: 0 !important;
        width: 100%;
    }

    .ict4u-dropzone .dz-preview {
        margin: 0.75rem 0 0 !important;
        width: 100%;
        min-height: auto !important;
    }

    .ict4u-dropzone .dz-preview .dz-details {
        border-radius: 1rem !important;
        background: #ffffff !important;
        border: 1px solid #c7d2fe !important;
        padding: 1rem !important;
    }

    .ict4u-dropzone .dz-preview .dz-filename,
    .ict4u-dropzone .dz-preview .dz-size {
        color: #312e81 !important;
        font-weight: 700 !important;
    }

    .ict4u-dropzone .dz-remove {
        color: #dc2626 !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        margin-top: 0.75rem;
        display: inline-block;
    }

    .ict4u-dropzone .dz-error-message {
        top: calc(100% + 0.5rem) !important;
    }

    /* 6. Status Pills (WARNA-WARNI MACAM APPROVAL) */
    .status-pill { padding: 4px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; display: inline-block; }
    .status-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .status-approved { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .status-rejected { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* ==========================================
       TOM SELECT - DROPDOWN INPUT UI (MAGIC)
    ========================================== */
    .servis-select-wrapper {
        position: relative;
        z-index: 60;
        width: 100%;
    }

    /* Kotak Utama (Tempat user klik) */
    .TS-Compact .ts-wrapper.single .ts-control {
        min-height: 48px !important;
        padding: 0 2.5rem 0 1rem !important; /* Elak teks langgar arrow */
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

    /* Text Pilihan */
    .TS-Compact .ts-wrapper.single .ts-control > .item,
    .TS-Compact .ts-control > input::placeholder {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        color: #475569 !important;
    }

    /* Bunuh terus arrow default Tom Select */
    .TS-Compact .ts-wrapper.single::after,
    .TS-Compact .ts-control::after {
        display: none !important;
        content: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
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

    /* Kotak Search Dalam Dropdown */
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

    /* Tema Indigo Hover */
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
                <i class="bi bi-files text-3xl text-indigo-600"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-1">Pengurusan Dokumen</h1>
                <p class="text-gray-500 font-medium mb-0">Kemaskini dan urus fail mengikut servis</p>
            </div>
        </div>
        <button id="btnTambahModal" onclick="openDokumenEditor()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-xl font-bold transition flex items-center shadow-lg disabled:opacity-50 mt-4 md:mt-0" disabled>
            <i class="bi bi-cloud-plus-fill me-2"></i> Muat Naik Dokumen
        </button>
    </div>

    <div class="glass-card p-4 mb-6 max-w-sm relative z-50 shadow-sm">
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-normal mb-2 flex items-center gap-2">
            <i class="bi bi-tag-fill text-slate-700"></i> Kategori Servis
        </label>
        <div class="servis-select-wrapper TS-Compact relative">
            <select id="dropdownServis" class="w-full appearance-none">
                <option value="">-- Sila Pilih Servis --</option>
                <?php foreach($servis as $s): ?>
                    <option value="<?= esc($s['idservis']) ?>"><?= esc($s['namaservis']) ?></option>
                <?php endforeach; ?>
            </select>
            <i class="custom-arrow bi bi-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none transition-transform duration-200" style="z-index: 100;"></i>
        </div>
    </div>

    <div id="dokumenArea" class="glass-card overflow-hidden bg-white relative z-10">
        <div class="text-center py-20">
            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                <i class="bi bi-filter text-4xl text-slate-300"></i>
            </div>
            <h5 class="text-slate-900 font-bold mb-1">Sila Pilih Servis</h5>
            <p class="text-slate-500 font-medium">Pilih kategori servis untuk memaparkan senarai dokumen.</p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>

<script>
let editorInstance = null;
let dokumenDropzone = null;
let currentCsrfHash = '<?= csrf_hash() ?>';

Dropzone.autoDiscover = false;

$(document).ready(function() {
    // ==========================================
    // INIT TOM SELECT (MAGIC SEBIJIK PERINCIAN)
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

    // Pindah event listener ke sini lepas init
    $('#dropdownServis').change(function(){
        refreshTable($(this).val());
    });
});

function refreshToken(newToken) {
    currentCsrfHash = newToken;
    $('meta[name="csrf-token"]').attr('content', newToken);
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': currentCsrfHash } });
}

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': currentCsrfHash } });

function refreshTable(idservis){
    if(!idservis){
        $('#dokumenArea').html(`<div class="text-center py-20"><div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm"><i class="bi bi-filter text-4xl text-slate-300"></i></div><h5 class="text-slate-900 font-bold mb-1">Sila Pilih Servis</h5><p class="text-slate-500 font-medium">Pilih kategori servis di atas untuk memaparkan senarai dokumen.</p></div>`);
        $('#btnTambahModal').prop('disabled', true);
        return;
    }
    
    $('#btnTambahModal').prop('disabled', false);
    $('#dokumenArea').html('<div class="text-center py-20 text-slate-400 font-bold">Memproses data...</div>');
    
    $.get('<?= base_url('pengurusandokumen/getDokumen') ?>/' + idservis, function(res){
        if(res.csrf) refreshToken(res.csrf);
        var items = res.items;
        if(!items || items.length === 0){
            $('#dokumenArea').html(`<div class="p-20 text-center"><div class="bg-red-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm"><i class="bi bi-folder-x text-4xl text-red-500"></i></div><h5 class="text-slate-900 font-bold mb-1">Tiada Fail Dijumpai</h5><p class="text-slate-500 font-medium">Tiada dokumen yang dimuat naik untuk servis ini.</p></div>`);
            return;
        }

        let html = `<div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-8 compact-th text-center">Fail</th>
                        <th class="px-8 compact-th">Maklumat Dokumen</th>
                        <th class="px-8 compact-th text-center">Status</th>
                        <th class="px-8 compact-th text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">`;
        
        items.forEach(d => {
            const fileUrl = `<?= base_url('pengurusandokumen/viewFile') ?>/${d.idservis}/${d.namafail}`;
            const createdDate = d.created_at ? d.created_at : '-';
            const updatedDate = d.updated_at ? d.updated_at : createdDate;
            const statusLabel = d.status ? d.status.toLowerCase() : 'pending';
            
            const cleanDesc = d.descdoc ? d.descdoc.replace(/<[^>]*>?/gm, '').trim() : '';
            const displayDesc = cleanDesc.length > 0 ? cleanDesc : 'Tiada nota';

            html += `
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-6 text-center">
                        <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mx-auto shadow-sm">
                            <i class="bi bi-file-earmark-pdf-fill text-2xl"></i>
                        </div>
                    </td>
                    <td class="px-8 py-6" style="max-width: 400px; word-wrap: break-word; white-space: normal;">
                        <div class="font-bold text-slate-800 text-[14px]">${d.nama}</div>
                        <div class="text-xs text-slate-400 mt-1">${displayDesc}</div>
                        
                        <div class="mt-2 space-y-0.5">
                            <div class="text-xs text-slate-400 font-medium flex items-center gap-1">
                                <i class="bi bi-plus-circle"></i> Dicipta: ${createdDate}
                            </div>
                            <div class="text-xs text-blue-500 font-bold flex items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Kemaskini: ${updatedDate}
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="status-pill status-${statusLabel}">${statusLabel}</span>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="${fileUrl}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-gray-100 text-gray-600 p-2 rounded-xl hover:bg-gray-600 hover:text-white transition" title="Lihat">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <button onclick="openDokumenEditor(${d.iddoc})" class="w-10 h-10 flex items-center justify-center bg-indigo-50 text-indigo-600 p-2 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button onclick="hapusDokumen(${d.iddoc})" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 p-2 rounded-xl hover:bg-red-600 hover:text-white transition" title="Padam">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
        });
        
        html += '</tbody></table></div>';
        $('#dokumenArea').html(html);
    });
}

function openDokumenEditor(iddoc = null) {
    const idservis = $('#dropdownServis').val();
    if(!idservis) { Swal.fire('Info', 'Sila pilih servis dahulu', 'info'); return; }

    if(iddoc) {
        $.get('<?= base_url('pengurusandokumen/getDokumenDetail') ?>/' + iddoc, function(res) {
            if(res.csrf) refreshToken(res.csrf);
            if(res.status) showSwalEditor(res.data, idservis);
        });
    } else {
        showSwalEditor(null, idservis);
    }
}

function showSwalEditor(data = null, idservis) {
    const isNew = !data;
    
    Swal.fire({
        title: isNew ? 'Muat Naik Dokumen Baru' : 'Kemaskini Dokumen',
        showCloseButton: true,
        showCancelButton: true,
        html: `
        <div class="text-left space-y-4 p-2 mt-4">
            <div>
                <label class="swal-label-custom">Tajuk Dokumen</label>
                <input id="swal-nama" class="swal-input-custom" value="${data ? data.nama : ''}" placeholder="Contoh: Sijil Kelayakan">
            </div>
            <div>
                <label class="swal-label-custom">Penerangan / Nota</label>
                <textarea id="swal-descdoc">${data ? (data.descdoc || '') : ''}</textarea>
            </div>
            <div>
                <label class="swal-label-custom">Fail Dokumen (PDF Sahaja)</label>
                <form id="swal-dropzone" class="dropzone ict4u-dropzone">
                    <div class="dz-message needsclick">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4 shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill text-3xl"></i>
                            </div>
                            <div class="text-base font-extrabold text-slate-800">Seret fail PDF ke sini</div>
                            <div class="text-sm text-slate-500 mt-2">Atau klik kawasan ini untuk pilih satu fail sahaja.</div>
                        </div>
                    </div>
                </form>
                ${!isNew ? `<div class="text-sm text-blue-600 mt-1">* Biarkan kosong jika tidak mahu tukar fail</div>` : ''}
            </div>
        </div>`,
        width: '600px',
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: { 
            popup: 'swal-rounded',
            confirmButton: 'btn-swal-indigo', 
            cancelButton: 'btn-swal-merah', 
            closeButton: 'swal2-close',
            actions: 'swal2-actions'
        },
        didOpen: () => {
            if (editorInstance) { editorInstance.destroy(); }
            ClassicEditor.create(document.querySelector('#swal-descdoc'))
                .then(newEditor => { editorInstance = newEditor; });

            if (dokumenDropzone) {
                dokumenDropzone.destroy();
                dokumenDropzone = null;
            }

            dokumenDropzone = new Dropzone('#swal-dropzone', {
                url: '#',
                autoProcessQueue: false,
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: 'application/pdf,.pdf',
                addRemoveLinks: true,
                clickable: true,
                dictRemoveFile: 'Buang fail',
                dictInvalidFileType: 'Hanya fail PDF dibenarkan.',
                dictMaxFilesExceeded: 'Hanya satu fail dibenarkan untuk setiap muat naik.',
                init: function() {
                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    });

                    this.on('maxfilesexceeded', function(file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                }
            });
        },
        willClose: () => {
            if (editorInstance) {
                editorInstance.destroy();
                editorInstance = null;
            }

            if (dokumenDropzone) {
                dokumenDropzone.destroy();
                dokumenDropzone = null;
            }
        },
        preConfirm: () => {
            const nama = document.getElementById('swal-nama').value.trim();
            let description = editorInstance ? editorInstance.getData() : '';
            const acceptedFiles = dokumenDropzone ? dokumenDropzone.getAcceptedFiles() : [];

            if (!nama) { Swal.showValidationMessage('Tajuk Dokumen wajib diisi.'); return false; }
            const plainText = description.replace(/<[^>]*>?/gm, '').replace(/&nbsp;/g, '').trim();
            if (plainText === "") { description = ""; }
            if (isNew && acceptedFiles.length === 0) {
                Swal.showValidationMessage('Sila muat naik satu fail PDF sebelum simpan.');
                return false;
            }

            const fd = new FormData();
            fd.append('<?= csrf_token() ?>', currentCsrfHash); 
            fd.append('idservis', idservis);
            fd.append('nama', nama);
            fd.append('descdoc', description);
            
            if (acceptedFiles.length > 0) {
                fd.append('file', acceptedFiles[0]);
            }
            return { formData: fd };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { formData } = result.value;
            const url = isNew ? '<?= base_url('pengurusandokumen/tambah') ?>' : '<?= base_url('pengurusandokumen/kemaskini') ?>/' + data.iddoc;
            saveDokumen(url, formData);
        }
    });
}

function saveDokumen(url, formData) {
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if(res.csrf) refreshToken(res.csrf); 
            if(res.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berjaya',
                    text: res.msg || 'Dokumen berjaya disimpan.',
                    timer: 1800,
                    showConfirmButton: false,
                    customClass: {popup: 'swal-rounded'}
                });
                refreshTable($('#dropdownServis').val());
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.msg, customClass: {popup: 'swal-rounded'} });
            }
        }
    });
}

window.hapusDokumen = function(id) {
    Swal.fire({
        title: 'Hapus Dokumen?',
        text: "Tindakan ini tidak boleh diundur. Adakah anda pasti?",
        icon: 'warning',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya, Padam',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: { 
            popup: 'swal-rounded',
            confirmButton: 'btn-swal-indigo', 
            cancelButton: 'btn-swal-merah',   
            actions: 'swal2-actions',
            closeButton: 'swal2-close'
        }
    }).then((result) => {
        if(result.isConfirmed) {
            const dataPadam = { [ '<?= csrf_token() ?>' ]: currentCsrfHash };
            $.post('<?= base_url('pengurusandokumen/hapus') ?>/' + id, dataPadam, function(res) {
                if(res.csrf) refreshToken(res.csrf);
                if(res.status) {
                    Swal.fire({ icon: 'success', title: 'Dipadam!', text: 'Rekod berjaya dibuang.', timer: 1500, showConfirmButton: false, customClass: {popup: 'swal-rounded'} });
                    refreshTable($('#dropdownServis').val());
                }
            });
        }
    });
}
</script>

<?= $this->endSection() ?>
