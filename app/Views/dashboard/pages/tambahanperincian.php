<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script>document.title = "Sistem Tambahan Perincian";</script>

<meta name="csrf-token" content="<?= csrf_hash() ?>">

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* 1. Global Setup */
    body, .content-wrapper, .main-sidebar, h1, h2, h3, h4, h5, h6, p, span, div, table, input, textarea, button {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    .content-wrapper > .container-fluid > .d-md-flex.align-items-center.justify-content-between.mb-5 {
        display: none !important;
    }

    /* 2. Card Styling */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        border-radius: 1.5rem;
    }

    /* 3. Modern Input */
    .modern-input-size {
        height: 56px !important;
        border-radius: 14px !important;
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #ffffff !important;
    }

    .input-with-icon { padding-left: 3.5rem !important; }

    /* 4. Table Header Styling (Standardize) */
    .compact-th {
        padding: 25px 20px !important;
        background-color: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        color: #64748b !important;
        white-space: nowrap;
    }

    #dokumenTable {
        table-layout: fixed !important;
        width: 100% !important;
    }

    #dokumenTable td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* 5. Buttons Styling */
    .btn-action-table-large {
        width: 160px; height: 44px; display: inline-flex; align-items: center; justify-content: center;
        gap: 10px; font-size: 11px !important; font-weight: 800 !important; border-radius: 12px;
        text-transform: uppercase; transition: all 0.2s; border: 1px solid transparent;
    }
    .btn-action-table-large i {
        font-size: 1rem !important;
        line-height: 1 !important;
    }
    .btn-view { background: #F1F5F9; color: #64748B; border-color: #E2E8F0; }
    .btn-edit { background: #EEF2FF; color: #4F46E5; border-color: #E0E7FF; }
    .btn-edit:hover { background: #4F46E5; color: white; }

    /* SweetAlert Standard UI */
    .swal-rounded { border-radius: 2rem !important; padding: 1.5rem !important; }
    .swal2-actions { width: 100% !important; display: flex !important; flex-direction: row !important; gap: 12px !important; margin-top: 1.5rem !important; padding: 0 1rem !important; }
    
    .btn-swal-hantar { flex: 1 !important; background: #4f46e5 !important; color: white !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; border: none !important; order: 2 !important; }
    .btn-swal-padam { flex: 1 !important; background: #fee2e2 !important; color: #ef4444 !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; border: none !important; order: 1 !important; }
    .swal2-actions.swal-delete-actions .btn-swal-hantar { order: 2 !important; }
    .swal2-actions.swal-delete-actions .btn-swal-padam { order: 1 !important; }
    
    .swal-label-custom { display: block; font-size: 0.8rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
    .swal-input-custom { height: 52px; border-radius: 12px; border: 1px solid #e2e8f0; padding: 0 15px; width: 100%; background-color: #ffffff; font-weight: 500; font-size: 0.95rem; }
    
    .icon-search-fix { position: absolute; left: 1.3rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.2rem; }

    /* Custom Dropdown Style (Tiru Tom Select Indigo) */
    .servis-select-wrapper {
        position: relative;
        width: 100%;
    }

    /* Kotak Utama - Ikut style .ts-control */
    .custom-select-trigger {
        min-height: 56px !important;
        padding: 0 1.2rem 0 1rem !important;
        border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer !important;
        transition: all 0.2s ease;
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        color: #475569 !important;
    }

    /* Kotak Menyala Indigo bila active - Ikut style focus .ts-control */
    .custom-select-wrapper.active .custom-select-trigger {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15) !important;
        background: #ffffff !important;
    }

    /* Container Dropdown Menu - Ikut style .ts-dropdown */
    .custom-options-container {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: white;
        border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        z-index: 9999;
        display: none;
        padding: 4px !important;
    }

    .custom-options-container.show {
        display: block;
        animation: slideUp 0.2s ease-out;
    }

    /* Option Style - Ikut style .option:hover */
    .custom-option-item {
        padding: 0.6rem 1rem !important;
        font-size: 0.95rem !important;
        color: #334155 !important;
        border-radius: 0.5rem !important;
        margin-bottom: 2px !important;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .custom-option-item:hover {
        background-color: #e0e7ff !important; 
        color: #3730a3 !important; 
        font-weight: 700 !important;
    }

    /* Animasi Arrow Pusing */
    .custom-arrow {
        transition: transform 0.2s ease;
    }
    .custom-select-wrapper.active .custom-arrow {
        transform: rotate(180deg);
    }

    @keyframes pulse-custom {
        0%, 100% { opacity: 1; }
        50% { opacity: .7; }
    }

    .skeleton-box {
        background-color: #e2e8f0;
        border-radius: 0.5rem;
        animation: pulse-custom 1.5s infinite ease-in-out;
    }

</style>

<div class="container-fluid py-1">
    <div class="glass-card p-8 mb-8 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="bg-indigo-50 p-3 rounded-2xl"><i class="bi bi-folder-plus text-3xl text-indigo-600"></i></div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-1">Tambahan Perincian</h1>
                <p class="text-gray-500 font-medium mb-0">Urus pautan maklumat dan perincian servis tambahan</p>
            </div>
        </div>
        <button onclick="openEditor()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-xl font-bold flex items-center gap-2 shadow-lg transition-all">
            <i class="bi bi-plus-lg"></i> Tambah Perincian
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-8">
        <div class="md:col-span-3 relative">
        <div class="servis-select-wrapper custom-select-wrapper" id="sortWrapper">
            <div class="custom-select-trigger" id="sortTrigger">
                <span id="currentSortLabel">Terdahulu (ID)</span>
                <i class="bi bi-chevron-down custom-arrow text-slate-400"></i>
            </div>
            
            <div class="custom-options-container" id="sortOptions">
                <div class="custom-option-item" data-value="asc">Terdahulu (ID)</div>
                <div class="custom-option-item" data-value="desc">Terkini (ID)</div>
            </div>
        </div>
        <input type="hidden" id="sortOrder" value="asc">
    </div>
        
        <div class="md:col-span-9 relative">
            <i class="bi bi-search icon-search-fix"></i>
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama servis..." class="modern-input-size input-with-icon w-full focus:outline-none transition focus:ring-4 focus:ring-indigo-50">
        </div>
    </div>

    <div class="glass-card overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="dokumenTable">
                <colgroup>
                    <col style="width: 55%;">
                    <col style="width: 22.5%;">
                    <col style="width: 22.5%;">
                </colgroup>
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-8 compact-th">Maklumat Servis</th>
                        <th class="px-8 compact-th text-center">Pautan Luar</th>
                        <th class="px-8 compact-th text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody id="serviceTableBody" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let allServis = [];
let editor;
let currentCsrfHash = '<?= csrf_hash() ?>';

// Standard Refresh Token Function
function refreshToken(newToken) {
    currentCsrfHash = newToken;
    $('meta[name="csrf-token"]').attr('content', newToken);
}

function showSkeleton() {
    let skeletonHTML = '';
    for (let i = 0; i < 5; i++) {
        skeletonHTML += `
            <tr class="border-b border-slate-100">
                <td class="px-8 py-6">
                    <div class="skeleton-box h-5 w-56 rounded mb-3"></div>
                    <div class="skeleton-box h-3 w-32 rounded"></div>
                </td>
                <td class="px-8 py-6 text-center">
                    <div class="skeleton-box h-11 w-40 mx-auto rounded-xl"></div>
                </td>
                <td class="px-8 py-6 text-center">
                    <div class="skeleton-box h-11 w-40 mx-auto rounded-xl"></div>
                </td>
            </tr>`;
    }
    return skeletonHTML;
}

async function fetchServis(){
    const body = document.getElementById('serviceTableBody');
    body.innerHTML = showSkeleton();

    try {
        const res = await fetch('<?= base_url("tambahanperincian/getAll") ?>');
        const json = await res.json();
        if(json.status) { 
            allServis = json.data; 
            sortData(); 
        } else {
            body.innerHTML = `<tr><td colspan="3" class="px-8 py-20 text-center text-slate-500">Tiada data untuk dipaparkan.</td></tr>`;
        }
    } catch (e) { console.error("Error:", e); body.innerHTML = `<tr><td colspan="3" class="px-8 py-20 text-center text-slate-500">Ralat memuatkan data. Sila cuba semula.</td></tr>`; }
}

function renderTable(){
    const body = document.getElementById('serviceTableBody');
    body.innerHTML = '';
    allServis.forEach(s => {
        const hasLinks = (s.infourl && s.infourl.trim() !== "") || (s.mohonurl && s.mohonurl.trim() !== "");
        const tr = document.createElement('tr');
        tr.className = "hover:bg-slate-50/50 transition-colors";
        tr.innerHTML = `
            <td class="px-8 py-6">
                <div class="text-[14px] font-bold text-slate-800 leading-tight">${s.namaservis}</div>
                <div class="text-[10px] text-slate-400 mt-1">ID: #${s.idservis}</div>
            </td>
            <td class="px-8 py-6 text-center">
                <button onclick="showLinks('${s.idservis}')" class="btn-action-table-large btn-view ${!hasLinks ? 'opacity-50' : ''}" ${!hasLinks ? 'disabled' : ''}>
                    <i class="bi bi-link-45deg text-lg"></i> ${hasLinks ? 'Lihat Pautan' : 'Tiada Pautan'}
                </button>
            </td>
            <td class="px-8 py-6 text-center">
                <button onclick="openEditor('${s.idservis}')" class="btn-action-table-large btn-edit">
                    <i class="bi bi-pencil-square text-lg"></i> KEMASKINI
                </button>
            </td>
        `;
        body.appendChild(tr);
    });
}

function openEditor(id = null) {
    let s = id ? allServis.find(item => String(item.idservis) === String(id)) : null;
    
    Swal.fire({
        title: id ? 'Kemaskini Perincian' : 'Tambah Perincian',
        showCloseButton: true,
        html: `
            <div class="text-left space-y-4 p-2 mt-4">
                <div>
                    <label class="swal-label-custom">Nama Servis</label>
                    <input id="swal-namaservis" class="swal-input-custom" value="${s ? s.namaservis : ''}" placeholder="Contoh: Permohonan IP">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="swal-label-custom">URL Informasi</label><input id="swal-infourl" class="swal-input-custom" value="${s ? (s.infourl || '') : ''}" placeholder="https://..."></div>
                    <div><label class="swal-label-custom">URL Permohonan</label><input id="swal-mohonurl" class="swal-input-custom" value="${s ? (s.mohonurl || '') : ''}" placeholder="https://..."></div>
                </div>
                <div><label class="swal-label-custom">Penerangan / Nota</label><textarea id="swal-description"></textarea></div>
            </div>
        `,
        width: '640px',
        showConfirmButton: true,
        confirmButtonText: 'Simpan Perubahan',
        showDenyButton: id ? true : false,
        denyButtonText: 'Padam Rekod',
        buttonsStyling: false,
        customClass: { 
            popup: 'swal-rounded',
            denyButton: 'btn-swal-padam', 
            confirmButton: 'btn-swal-hantar', 
            closeButton: 'swal2-close',
            actions: 'swal2-actions'
        },
        didOpen: () => {
            if(editor) { editor.destroy(); editor = null; }
            ClassicEditor.create(document.querySelector('#swal-description'), {
                toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList']
            }).then(newEditor => {
                editor = newEditor;
                if(s && s.perincian) { editor.setData(s.perincian.description || ''); }
            });
        },
        preConfirm: () => {
            const name = document.getElementById('swal-namaservis').value.trim();
            let description = editor ? editor.getData() : '';

            if (!name) { Swal.showValidationMessage('Nama Servis wajib diisi!'); return false; }

            // LOGIC PEMUTIH TAG <P>
            const plainText = description.replace(/<[^>]*>?/gm, '').replace(/&nbsp;/g, '').trim();
            if (plainText === "") { description = ""; }

            return {
                idservis: id,
                namaservis: name,
                infourl: document.getElementById('swal-infourl').value,
                mohonurl: document.getElementById('swal-mohonurl').value,
                description: description
            }
        }
    }).then((result) => {
        if (result.isConfirmed) { saveServis(result.value); } 
        else if (result.isDenied) { deleteServis(id); }
    });
}

async function saveServis(data){
    const fd = new FormData();
    fd.append('<?= csrf_token() ?>', currentCsrfHash); // Hantar token terkini
    Object.keys(data).forEach(key => fd.append(key, data[key] || ''));

    try {
        const res = await fetch('<?= base_url("tambahanperincian/saveServis") ?>', { method:'POST', body:fd });
        const json = await res.json();
        
        if(json.csrf) refreshToken(json.csrf); // Update token untuk next request

        if(json.status){ 
            fetchServis(); 
            Swal.fire({ icon: 'success', title: 'Berjaya', text: 'Data telah dikemaskini!', timer: 1500, showConfirmButton: false, customClass: {popup: 'swal-rounded'} }); 
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: json.msg, customClass: {popup: 'swal-rounded'} });
        }
    } catch (e) { console.error(e); }
}

async function deleteServis(id){
    Swal.fire({ 
        title: 'Padam rekod?', 
        text: "Tindakan ini tidak boleh diundur!", 
        icon: 'warning', 
        showCancelButton: true, 
        confirmButtonText: 'Ya, Padam', 
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: { popup: 'swal-rounded', cancelButton: 'btn-swal-padam', confirmButton: 'btn-swal-hantar',  actions: 'swal2-actions swal-delete-actions' } 
    }).then(async (result) => {
        if (result.isConfirmed) {
            const fd = new FormData(); 
            fd.append('<?= csrf_token() ?>', currentCsrfHash);
            fd.append('idservis', id);
            const res = await fetch('<?= base_url("tambahanperincian/deleteServis") ?>', { method:'POST', body:fd });
            const json = await res.json();
            if(json.csrf) refreshToken(json.csrf);
            fetchServis(); 
            Swal.fire({ icon: 'success', title: 'Dipadam!', text: 'Rekod berjaya dibuang.', timer: 1500, showConfirmButton: false, customClass: {popup: 'swal-rounded'} });
        }
    });
}

function showLinks(id) {
    const s = allServis.find(item => String(item.idservis) === String(id));
    Swal.fire({
        title: '<span class="text-xl font-bold">Pautan Luar</span>',
        showCloseButton: true,
        showConfirmButton: false,
        html: `<div class="text-left space-y-6 p-4 mt-2">
                <div><p class="swal-label-custom" style="font-size: 0.9rem;">URL Informasi</p>${s.infourl ? `<a href="${s.infourl}" target="_blank" class="text-blue-600 break-all text-lg underline font-semibold">${s.infourl}</a>` : '<span class="text-slate-400 text-base italic">Tiada pautan disediakan</span>'}</div>
                <div><p class="swal-label-custom" style="font-size: 0.9rem;">URL Permohonan</p>${s.mohonurl ? `<a href="${s.mohonurl}" target="_blank" class="text-blue-600 break-all text-lg underline font-semibold">${s.mohonurl}</a>` : '<span class="text-slate-400 text-base italic">Tiada pautan disediakan</span>'}</div>
            </div>`,
        customClass: { popup: 'swal-rounded' },
        backdrop: `rgba(15, 23, 42, 0.5) blur(8px)`
    });
}

function sortData() {
    const order = document.getElementById('sortOrder').value;
    allServis.sort((a, b) => order === 'asc' ? parseInt(a.idservis) - parseInt(b.idservis) : parseInt(b.idservis) - parseInt(a.idservis));
    renderTable();
}

function filterTable() {
    const q = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#serviceTableBody tr");
    rows.forEach(row => { row.style.display = row.innerText.toLowerCase().includes(q) ? "" : "none"; });
}

fetchServis();

document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.getElementById('sortWrapper');
    const trigger = document.getElementById('sortTrigger');
    const optionsList = document.getElementById('sortOptions');
    const options = document.querySelectorAll('.custom-option-item');
    const label = document.getElementById('currentSortLabel');
    const hiddenInput = document.getElementById('sortOrder');

    // Open/Close Dropdown
    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = optionsList.classList.contains('show');
        
        // Tutup semua yang lain kalau ada, and toggle yang ni
        optionsList.classList.toggle('show');
        wrapper.classList.toggle('active');
    });

    // Select Option
    options.forEach(opt => {
        opt.addEventListener('click', function() {
            const val = this.getAttribute('data-value');
            const text = this.innerText;

            label.innerText = text;
            hiddenInput.value = val;
            
            // UI Reset
            optionsList.classList.remove('show');
            wrapper.classList.remove('active');

            // Panggil function sorting asal kau
            sortData();
        });
    });

    // Close click outside
    window.addEventListener('click', () => {
        optionsList.classList.remove('show');
        wrapper.classList.remove('active');
    });
});
</script>

<?= $this->endSection() ?>