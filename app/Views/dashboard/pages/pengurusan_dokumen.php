<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script>document.title = "Pengurusan Dokumen Modul";</script>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* 1. Global Setup & Typography */
    body, .content-wrapper, h1, h2, h3, h4, h5, h6, p, span, div, table, input, textarea, button {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* 2. Hide Default Dashboard Header */
    .content-wrapper > .container-fluid > .d-md-flex.align-items-center.justify-content-between.mb-5 {
        display: none !important;
    }

    /* 2. Card Styling */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        border-radius: 1.5rem; /* rounded-3xl */
    }

    /* 3. Table Header Design */
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

    /* 4. Modern Action Buttons (Match Gambar Mai) */
    .btn-tindakan-moden {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        transition: all 0.2s ease-in-out;
        border: none;
        cursor: pointer;
    }

    .btn-tindakan-moden i {
        font-size: 1.35rem !important;
        transition: transform 0.2s ease-in-out;
    }

    .btn-tindakan-moden:hover i {
        transform: scale(1.25);
    }

    #btnTambahModal:disabled {
        cursor: not-allowed !important;
        pointer-events: auto !important;
        opacity: 0.6;
    }

    /* Button Colors: Kelabu, Purple, Merah */
    .btn-lihat { background-color: #F1F5F9; color: #64748B; } /* Slate */
    .btn-lihat:hover { background-color: #E2E8F0; color: #1E293B; }

    .btn-kemaskini { background-color: #EEF2FF; color: #4F46E5; } /* Indigo */
    .btn-kemaskini:hover { background-color: #E0E7FF; color: #3730A3; }

    .btn-buang { background-color: #FFF1F2; color: #E11D48; } /* Rose */
    .btn-buang:hover { background-color: #FFE4E6; color: #9F1239; }

    /* 5. SweetAlert UI Design */
    .swal2-popup { border-radius: 28px !important; padding: 2rem !important; }
    .swal2-actions { width: 100% !important; display: flex !important; flex-direction: row !important; gap: 12px !important; margin-top: 1.5rem !important; padding: 0 1rem !important; }
    
    .btn-swal-hantar { flex: 1 !important; background: #3b82f6 !important; color: white !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; border: none !important; font-size: 0.95rem !important; order: 2; }
    .btn-swal-padam { flex: 1 !important; background: #fee2e2 !important; color: #ef4444 !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; border: none !important; font-size: 0.95rem !important; order: 1; }
    
    .swal-label-custom { display: block; font-size: 0.8rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
    .swal-input-custom { min-height: 52px; border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px 15px; width: 100%; background-color: #ffffff; font-weight: 500; font-size: 0.95rem; }

    /* 6. Status & Misc */
    .status-pill { padding: 4px 12px; border-radius: 9999px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
    .status-pending { background-color: #FEF3C7; color: #92400E; }
    .status-approved { background-color: #DCFCE7; color: #166534; }

    /* Style untuk nota halus dalam pop-up */
    .file-reminder-text {
        font-size: 8px !important; 
        color: #94a3b8; 
        margin-top: 4px; 
        font-style: italic; 
        opacity: 0.8;
    }
</style>

<div class="container-fluid py-1">
    <div class="glass-card p-8 mb-8 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="bg-indigo-50 p-3 rounded-2xl">
                <i class="bi bi-files text-3xl text-indigo-600"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-1">Pengurusan Dokumen Modul</h1>
                <p class="text-slate-500 font-medium mb-0">Kemaskini dan urus fail mengikut servis</p>
            </div>
        </div>
        <button id="btnTambahModal" onclick="openDokumenEditor()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-xl font-bold transition flex items-center shadow-lg disabled:opacity-50" disabled>
            <i class="bi bi-cloud-plus-fill me-2"></i> Muat Naik Dokumen
        </button>
    </div>

    <div class="glass-card p-6 mb-8 max-w-md">
        <label class="swal-label-custom flex items-center gap-2">
            <i class="bi bi-tag-fill"></i> Pilih Kategori Servis
        </label>
        <div class="relative">
            <select id="dropdownServis" class="w-full appearance-none bg-white border border-slate-200 p-3.5 rounded-xl focus:outline-none font-semibold text-slate-700 cursor-pointer">
                <option value="">Sila Pilih Servis...</option>
                <?php foreach($servis as $s): ?>
                    <option value="<?= esc($s['idservis']) ?>"><?= esc($s['namaservis']) ?></option>
                <?php endforeach; ?>
            </select>
            <i class="bi bi-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none"></i>
        </div>
    </div>

    <div id="dokumenArea" class="glass-card overflow-hidden bg-white">
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

<script>
let editorInstance = null;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
    }
});

// 1. Dropdown listener
$('#dropdownServis').change(function(){
    refreshTable($(this).val());
});

// 2. Refresh Table Function
function refreshTable(idservis){
    if(!idservis){
        $('#dokumenArea').html(`<div class="text-center py-20"><div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm"><i class="bi bi-filter text-4xl text-slate-300"></i></div><h5 class="text-slate-900 font-bold mb-1">Sila Pilih Servis</h5><p class="text-slate-500 font-medium">Pilih kategori servis di atas untuk memaparkan senarai dokumen.</p></div>`);
        $('#btnTambahModal').prop('disabled', true);
        return;
    }
    
    $('#btnTambahModal').prop('disabled', false);
    $('#dokumenArea').html('<div class="text-center py-20 text-slate-400">Memproses data...</div>');
    
    // Guna base_url untuk elak 404
    $.get('<?= base_url('dokumen/getDokumen') ?>/' + idservis, function(res){
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
        const fileUrl = `<?= base_url('dokumen/viewFile') ?>/${d.idservis}/${d.namafail}`;
        const createdDate = d.created_at ? d.created_at : '-';
        const updatedDate = d.updated_at ? d.updated_at : createdDate;

        html += `
            <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="px-8 py-6 text-center">
                    <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mx-auto shadow-sm">
                        <i class="bi bi-file-earmark-pdf-fill text-2xl"></i>
                    </div>
                </td>
                <td class="px-8 py-6">
                    <div class="font-bold text-slate-800 text-[14px]">${d.nama}</div>
                    <div class="text-xs text-slate-400 mt-1">${d.descdoc ? d.descdoc.replace(/<[^>]*>?/gm, '').substring(0, 50) + '...' : 'Tiada nota'}</div>
                    
                    <div class="mt-2 space-y-0.5">
                        <div class="text-xs text-slate-400 font-medium flex items-center gap-1">
                            <i class="bi bi-plus-circle"></i> Dicipta: ${createdDate}
                        </div>
                        <div class="text-xs text-blue-500 font-bold flex items-center gap-1">
                            <i class="bi bi-pencil-square"></i> Kemaskini: ${updatedDate}
                        </div>
                    </div>
                </td>
                <td class="px-8 py-6 text-center"><span class="status-pill status-${d.status}">${d.status}</span></td>
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
    }).fail(function(){
        $('#dokumenArea').html('<div class="p-10 text-center text-red-500">Ralat memuatkan data. Sila periksa sambungan atau route.</div>');
    });
}

// 3. Open Editor (Create/Edit)
function openDokumenEditor(iddoc = null) {
    const idservis = $('#dropdownServis').val();
    if(!idservis) { 
        Swal.fire('Sila pilih servis dahulu'); 
        return; 
    }

    if(iddoc) {
        // Bahagian Kemaskini - Guna route getDokumenDetail
        $.get('<?= base_url('dokumen/getDokumenDetail') ?>/' + iddoc, function(res) {
            if(res.status) {
                showSwalEditor(res.data, idservis);
            } else {
                Swal.fire('Ralat', 'Gagal mengambil data dokumen', 'error');
            }
        });
    } else {
        showSwalEditor(null, idservis);
    }
}

// 4. Show SweetAlert Editor
function showSwalEditor(data = null, idservis) {
    const isNew = !data;
    
    Swal.fire({
        title: isNew ? 'Muat Naik Dokumen Baru' : 'Kemaskini Dokumen',
        showCloseButton: true,
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
                <input type="file" id="swal-file" class="swal-input-custom" style="padding-top:12px" accept="application/pdf">
                ${!isNew ? `<div class="text-xs text-rose-500 mt-1">* Biarkan kosong jika tidak mahu tukar fail</div>` : ''}
            </div>
        </div>`,
        width: '600px',
        showConfirmButton: true,
        confirmButtonText: 'Hantar',
        buttonsStyling: false,
        customClass: { confirmButton: 'btn-swal-hantar', closeButton: 'swal2-close' },
        backdrop: `rgba(15,23,42,0.5) blur(8px)`,
        didOpen: () => {
            if (editorInstance) { editorInstance.destroy(); }
            ClassicEditor.create(document.querySelector('#swal-descdoc'))
                .then(newEditor => { editorInstance = newEditor; })
                .catch(err => console.error(err));
        },

        preConfirm: () => {
        const idservis = $('#dropdownServis').val();
        const nama = document.getElementById('swal-nama').value;
        const fileInput = document.getElementById('swal-file');
        
        // 1. Ambil Nama & Hash Token CSRF dari CI4
        const csrfName = '<?= csrf_token() ?>';
        const csrfHash = '<?= csrf_hash() ?>';

        const fd = new FormData();
        // 2. Masukkan Token ke dalam FormData (WAJIB)
        fd.append(csrfName, csrfHash); 
        
        fd.append('idservis', idservis);
        fd.append('nama', nama);
        fd.append('descdoc', editorInstance ? editorInstance.getData() : '');
        if (fileInput.files[0]) fd.append('file', fileInput.files[0]);
        
        return fd;
    }

    }).then((result) => {
        if (result.isConfirmed) {
        const url = isNew ? '<?= base_url('dokumen/tambah') ?>' : '<?= base_url('dokumen/kemaskini') ?>/' + data.iddoc;
            saveDokumen(url, result.value);
        }
    });
}

// 5. Save Function
function saveDokumen(url, formData) {
    $.ajax({
        url: url, type: 'POST', data: formData, processData: false, contentType: false,
        success: function(res) {
            if(res.status) {
                Swal.fire({ icon: 'success', title: 'Berjaya', text: res.msg || 'Data disimpan!', timer: 1500, showConfirmButton: false });
                refreshTable($('#dropdownServis').val());
            } else {
                Swal.fire('Ralat', res.msg || 'Gagal menyimpan fail', 'error');
            }
        }
    });
}

// 6. Delete Function
window.hapusDokumen = function(id) {
    // Ambil token CSRF untuk keselamatan
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    Swal.fire({
        title: 'Hapus Dokumen?',
        text: "Fail fizikal dan rekod pangkalan data akan dipadam sepenuhnya!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Padam',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn-swal-hantar', // Guna class yang Mai dah design
            cancelButton: 'btn-swal-padam'
        },
        buttonsStyling: false
    }).then((result) => {
        if(result.isConfirmed) {
            // Kita bina data untuk dihantar
            const dataPadam = {};
            dataPadam[csrfName] = csrfHash;

            // Buat request POST ke Controller
            $.post('<?= base_url('dokumen/hapus') ?>/' + id, dataPadam, function(res) {
                if(res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berjaya',
                        text: res.msg,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    // Refresh table ikut servis yang tengah dipilih
                    refreshTable($('#dropdownServis').val());
                } else {
                    Swal.fire('Ralat!', res.msg, 'error');
                }
            }).fail(function() {
                Swal.fire('Ralat!', 'Gagal menghubungi pelayan (Check CSRF/Route)', 'error');
            });
        }
    });
}
</script>

<?= $this->endSection() ?>