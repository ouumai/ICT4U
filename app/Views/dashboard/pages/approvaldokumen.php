<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<meta name="csrf-token" content="<?= csrf_hash() ?>">

<script>document.title = "Sistem Pengesahan Dokumen";</script>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<style>
    /* 1. Global Setup */
    body, .content-wrapper, .main-sidebar, h1, h2, h3, h4, h5, h6, p, span, div, table {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }
    .content-wrapper > .container-fluid > .d-md-flex.align-items-center.justify-content-between.mb-5 {
        display: none !important;
    }

    /* 2. UI Styles */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .input-with-icon { padding-left: 3rem !important; }
    #searchDokumen::placeholder { color: #94a3b8 !important; font-weight: 600; opacity: 1; }
    #searchDokumen { color: #475569; font-weight: 600; }

    /* 3. Table Header Style */
    #dokumenTable thead th {
        padding-top: 25px !important;
        padding-bottom: 25px !important;
        background-color: #f8fafc !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        color: #64748b !important;
        white-space: nowrap;
    }

    /* Status Pills */
    .status-pill { padding: 4px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; display: inline-block; }
    .status-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .status-approved { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .status-rejected { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* 4. MODAL X BUTTON */
    #closeViewModal {
        color: #94a3b8;
        transition: all 0.2s ease;
        background: transparent;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        -webkit-text-stroke: 1.2px #94a3b8;
    }
    #closeViewModal:hover, #closeViewModal:active {
        color: #ef4444 !important; 
        -webkit-text-stroke: 1.2px #ef4444;
    }

    .swal-rounded { border-radius: 2rem !important; padding: 1.5rem !important; }
    .swal2-actions { display: flex !important; flex-direction: row !important; align-items: center !important; justify-content: center !important; width: 100% !important; gap: 10px !important; margin-top: 1.5rem !important; }

    .btn-swal-hantar { flex: 1 !important; background: #4f46e5 !important; color: white !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; border: none !important; order: 2 !important; transition: all 0.2s ease; }
    .btn-swal-batal { flex: 1 !important; background: #fee2e2 !important; color: #ef4444 !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; border: none !important; order: 1 !important; }

    .modal-container {
        margin: auto; width: min(90vw, 960px); height: min(85vh, 760px); min-width: 640px; min-height: 520px;
        max-width: 96vw; max-height: 92vh; display: flex; flex-direction: column; resize: both; overflow: hidden;
    }

    #dokumenDetails { flex: 1; overflow: auto; }
    .file-preview-frame { width: 100%; height: 100%; min-height: 450px; border: 1px solid #e2e8f0; border-radius: 1rem; }
    .file-preview-wrapper { height: clamp(420px, 58vh, 720px); }

    @media (max-width: 768px) { .modal-container { width: 100%; height: 88vh; min-width: 0; min-height: 0; resize: none; } }

    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    /* Custom Dropdown Style (Tiru Indigo Style) */
    .servis-select-wrapper { position: relative; width: 100%; }
    .custom-select-trigger {
        min-height: 56px !important; padding: 0 1.2rem !important; border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important; background: #ffffff !important; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        display: flex; align-items: center; justify-content: space-between; cursor: pointer !important;
        transition: all 0.2s ease; font-size: 0.95rem !important; font-weight: 600 !important; color: #475569 !important;
    }
    .custom-select-wrapper.active .custom-select-trigger { border-color: #4f46e5 !important; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15) !important; }
    .custom-options-container {
        position: absolute; top: calc(100% + 8px); left: 0; right: 0; background: white; border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        z-index: 9999; display: none; padding: 4px !important;
    }
    .custom-options-container.show { display: block; animation: slideUp 0.2s ease-out; }
    .custom-option-item { padding: 0.6rem 1rem !important; font-size: 0.95rem !important; color: #334155 !important; border-radius: 0.5rem !important; margin-bottom: 2px !important; transition: all 0.2s ease; cursor: pointer; }
    .custom-option-item:hover { background-color: #e0e7ff !important; color: #3730a3 !important; font-weight: 700 !important; }
    .custom-arrow { transition: transform 0.2s ease; }
    .custom-select-wrapper.active .custom-arrow { transform: rotate(180deg); }

</style>

<div class="container-fluid py-1">
    <div class="glass-card rounded-3xl p-8 mb-8 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center gap-6">
             <div class="bg-indigo-100 p-3 rounded-2xl">
                <i class="bi bi-check-circle text-3xl text-indigo-600"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-1 text-dark">Pengesahan Dokumen</h1>
                <p class="text-gray-500 font-medium mb-0">Jalan Kerja Dokumen Servis</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6">
        <div class="md:col-span-3 relative">
            <div class="servis-select-wrapper custom-select-wrapper" id="statusFilterWrapper">
                <div class="custom-select-trigger" id="statusFilterTrigger">
                    <span id="currentStatusLabel">Semua Status</span>
                    <i class="bi bi-chevron-down custom-arrow text-slate-400"></i>
                </div>
                
                <div class="custom-options-container" id="statusFilterOptions">
                    <div class="custom-option-item" data-value="all">Semua Status</div>
                    <div class="custom-option-item" data-value="pending">Menunggu (Pending)</div>
                    <div class="custom-option-item" data-value="approved">Diterima (Approved)</div>
                    <div class="custom-option-item" data-value="rejected">Ditolak (Rejected)</div>
                </div>
            </div>
            <input type="hidden" id="filterStatus" value="all">
        </div>

        <div class="md:col-span-9 relative">
            <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 z-10"></i>
            <input type="text" id="searchDokumen" placeholder="Cari tajuk dokumen..." 
                class="input-with-icon w-full bg-white border border-slate-200 p-3 rounded-xl focus:outline-none h-[56px] focus:ring-4 focus:ring-indigo-50 transition">
        </div>
    </div>

    <div class="glass-card rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto" id="dokumenTable">
                <thead>
                    <tr class="bg-slate-50 border-b">
                        <th class="p-4 w-10"></th>
                        <th class="p-4 text-center w-20">No</th>
                        <th class="p-4 text-left w-[220px]">Maklumat Dokumen</th>
                        <th class="p-4 text-center">Format</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-left">Tarikh Hantar</th>
                        <th class="p-4 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white"></tbody>
            </table>
        </div>
        <div class="p-6 border-t bg-slate-50/50 flex justify-between items-center">
            <p id="totalInfo" class="text-sm text-slate-500 font-medium mb-0"></p>
            <div class="flex space-x-2 pagination"></div>
        </div>
    </div>
</div>

<div id="bulkToast" class="fixed bottom-10 right-10 bg-white p-6 z-50 transition-all duration-300 hidden transform translate-y-8 opacity-0 border border-gray-50" style="width: 380px; border-radius: 24px; box-shadow: 0 20px 50px -12px rgba(0,0,0,0.15);">
    
    <div class="flex items-center" style="margin-top: 15px; margin-bottom: 24px; gap: 1rem;">
        <div class="flex items-center justify-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #E2E8FF; border-radius: 12px;">
            <i class="bi bi-file-earmark-text" style="font-size: 22px; color: #5A55D2;"></i>
        </div>
        
        <div class="flex flex-col justify-center text-left">
            <div id="bulkToastCount" class="font-extrabold leading-none transition-colors duration-200" style="color: #0f172a; font-size: 16px; margin-bottom: 5px;">1 Dokumen</div>
            <div class="font-medium leading-none" style="color: #64748b; font-size: 13px;">Sedia untuk disemak</div>
        </div>
    </div>
    
    <div class="flex" style="gap: 0.75rem;">
        <button onclick="confirmBulkStatus('approved')" class="flex-1 font-bold flex items-center justify-center focus:outline-none" 
                style="background-color: #dcfce7; color: #166534; border-radius: 12px; font-size: 14px; gap: 0.5rem; transition: background-color 0.2s; padding: 10px 0;" 
                onmouseover="this.style.backgroundColor='#bbf7d0'" onmouseout="this.style.backgroundColor='#dcfce7'">
            <i class="bi bi-check-lg" style="font-size: 18px; -webkit-text-stroke: 0.5px;"></i>
            Diterima
        </button>
        
        <button onclick="confirmBulkStatus('rejected')" class="flex-1 font-bold flex items-center justify-center focus:outline-none" 
                style="background-color: #fee2e2; color: #991b1b; border-radius: 12px; font-size: 14px; gap: 0.5rem; transition: background-color 0.2s; padding: 10px 0;" 
                onmouseover="this.style.backgroundColor='#fecaca'" onmouseout="this.style.backgroundColor='#fee2e2'">
            <i class="bi bi-x-lg" style="font-size: 16px; -webkit-text-stroke: 0.5px;"></i>
            Ditolak
        </button>
    </div>
</div>

<div id="viewModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4" style="z-index: 9999;">
    <div class="modal-container bg-white rounded-3xl shadow-2xl animate-[slideUp_0.3s_ease-out]">
        <div class="bg-slate-50 p-5 flex justify-between items-center border-b">
            <h2 class="text-xs font-bold text-slate-800 flex items-center gap-2 m-0">Perincian Dokumen</h2>
            <button id="closeViewModal" title="Tutup"><i class="bi bi-x-lg" style="font-size: 1.3rem;"></i></button>
        </div>
        <div id="dokumenDetails" class="p-8"></div>
    </div>
</div>

<div id="lottieContainer" style="position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index:10000; display:none;">
    <lottie-player id="successAnimation" src="https://assets10.lottiefiles.com/packages/lf20_jbrw3hcz.json" background="transparent" speed="1" style="width:250px;height:250px;" autoplay></lottie-player>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#dokumenTable tbody');
    const searchInput = document.getElementById('searchDokumen');
    const filterStatus = document.getElementById('filterStatus');
    const viewModal = document.getElementById('viewModal');
    const dokumenDetails = document.getElementById('dokumenDetails');
    const paginationContainer = document.querySelector('.pagination');
    const lottieContainer = document.getElementById('lottieContainer');
    const successAnimation = document.getElementById('successAnimation');

    const wrapper = document.getElementById('statusFilterWrapper');
    const trigger = document.getElementById('statusFilterTrigger');
    const optionsList = document.getElementById('statusFilterOptions');
    const options = document.querySelectorAll('#statusFilterOptions .custom-option-item');
    const label = document.getElementById('currentStatusLabel');
    const hiddenInput = document.getElementById('filterStatus');

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        optionsList.classList.toggle('show');
        wrapper.classList.toggle('active');
    });

    options.forEach(opt => {
        opt.addEventListener('click', function() {
            label.innerText = this.innerText;
            hiddenInput.value = this.getAttribute('data-value');
            optionsList.classList.remove('show');
            wrapper.classList.remove('active');
            loadData(1);
        });
    });

    window.addEventListener('click', () => {
        optionsList.classList.remove('show');
        wrapper.classList.remove('active');
    });

    tbody.addEventListener('change', (e) => {
        if (e.target.classList.contains('doc-checkbox')) {
            toggleBulkBar();
        }
    });

    const bulkToast = document.getElementById('bulkToast');
    const bulkToastCount = document.getElementById('bulkToastCount');

    let currentPage = 1, limit = 10;

    window.showBulkToast = function(count) {
        bulkToastCount.innerText = `${count} Dokumen`;
        
        if (bulkToast.classList.contains('hidden')) {
            bulkToast.classList.remove('hidden');
            
            // Trigger DOM reflow supaya tailwind animation boleh jalan
            void bulkToast.offsetWidth;
            
            // Slide up & Fade in
            bulkToast.classList.remove('translate-y-8', 'opacity-0');
            bulkToast.classList.add('translate-y-0', 'opacity-100');
        }

        // Desktop UI Feedback: Teks nombor akan kelip warna indigo sekejap bila user tick dokumen baru
        bulkToastCount.classList.add('text-indigo-600');
        setTimeout(() => {
            bulkToastCount.classList.remove('text-indigo-600');
        }, 200);
    }

    window.hideBulkToast = function() {
        const bulkToast = document.getElementById('bulkToast');
        
        // Slide down & Fade out
        bulkToast.classList.remove('translate-y-0', 'opacity-100');
        bulkToast.classList.add('translate-y-8', 'opacity-0');
        
        // Tunggu transition (300ms) habis baru betul-betul hide dari DOM
        setTimeout(() => {
            bulkToast.classList.add('hidden');
        }, 300);
    }

    async function loadData(page = 1) {
        const status = filterStatus.value;
        tbody.innerHTML = '<tr><td colspan="7" class="p-10 text-center text-slate-400">Memuatkan data...</td></tr>';
        try {
            const res = await fetch(`<?= url_to('pengesahan_dokumen') ?>/getAll?status=${status}&page=${page}`);
            const result = await res.json();
            if (result.data && result.data.length > 0) {
                populateTable(result.data, result.pagination);
            } else {
                tbody.innerHTML = '<tr><td colspan="7" class="p-12 text-center text-slate-400">Tiada rekod dijumpai.</td></tr>';
                document.getElementById('totalInfo').innerText = 'Menunjukkan 0 rekod';
                paginationContainer.innerHTML = '';
            }
        } catch (err) { console.error(err); }
    }

    function populateTable(data, pagination) {
        tbody.innerHTML = '';
        currentPage = pagination.page;
        const totalPages = Math.ceil(pagination.total / pagination.limit);
        
        const start = (currentPage - 1) * pagination.limit + 1;
        const end = start + data.length - 1;
        document.getElementById('totalInfo').innerText = `Menunjukkan ${start}-${end} daripada ${pagination.total} rekod`;

        data.forEach((d, index) => {
            const statusLabel = d.status ?? 'pending';
            
            // Format: Ambil PDF sahaja
            let displayFormat = 'FILE';
            if (d.mime) {
                displayFormat = d.mime.split('/').pop().toUpperCase();
            }

            const tr = document.createElement('tr');
            tr.className = "hover:bg-slate-50/50 transition-colors border-b border-slate-50";
            tr.innerHTML = `
                <td class="p-4 text-center">
                    <input type="checkbox" class="doc-checkbox w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" data-id="${d.iddoc}">
                </td>
                <td class="p-4 text-center text-slate-400 font-semibold">${index + 1 + (currentPage - 1) * limit}</td>
                
                <td class="p-4">
                    <div class="flex items-center cursor-pointer group justify-between min-h-[56px]" onclick="showDokumenModal('${d.iddoc}')">
                        <div class="w-[160px] min-w-0 flex flex-col justify-center"> 
                            <div class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors line-clamp-1">${d.nama}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">ID: #${d.iddoc}</div>
                        </div>
                        <i class="bi bi-chevron-down text-slate-300 text-m"></i>
                    </div>
                </td>

                <td class="p-4 text-center">
                    <span class="font-bold text-slate-700 text-base">${displayFormat}</span>
                </td>

                <td class="p-4 text-center">
                    <span class="status-pill status-${statusLabel.toLowerCase()}">${statusLabel.toUpperCase()}</span>
                </td>

                <td class="p-4">
                    <div class="flex items-center gap-2 text-slate-500 text-sm">
                        <i class="bi bi-clock-history text-slate-400"></i>
                        ${formatDate(d.created_at)}
                    </div>
                </td>

                <td class="p-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button class="viewBtn btn-action w-9 h-9 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" data-id="${d.iddoc}"><i class="bi bi-eye-fill pointer-events-none"></i></button>
                        <button class="approveBtn btn-action w-9 h-9 flex items-center justify-center bg-green-50 text-green-600 rounded-xl hover:bg-green-600 hover:text-white transition" data-id="${d.iddoc}"><i class="bi bi-check-lg pointer-events-none"></i></button>
                        <button class="rejectBtn btn-action w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition" data-id="${d.iddoc}"><i class="bi bi-x-lg pointer-events-none"></i></button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

        renderPagination(totalPages);
    }
    
    // Fungsi Toggle Bulk Action Bar (Di-adjust sikit untuk panggil bulkToast baru)
    window.toggleBulkBar = function() {
        const selected = document.querySelectorAll('.doc-checkbox:checked');

        if (selected.length > 0) {
            showBulkToast(selected.length);
        } else {
            hideBulkToast();
        }
    }

    window.unselectAll = function() {
        document.querySelectorAll('.doc-checkbox').forEach(cb => cb.checked = false);
        toggleBulkBar();
    }

    function renderPagination(totalPages) {
        paginationContainer.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = `w-10 h-10 rounded-xl font-bold transition ${i === currentPage ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-slate-100'}`;
            btn.addEventListener('click', () => { loadData(i); });
            paginationContainer.appendChild(btn);
        }
    }

    function formatDate(str) { 
        if (!str) return '-'; 
        const d = new Date(str); 
        return d.toLocaleString('ms-MY', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true }); 
    }

    window.showDokumenModal = async function(id) {
        viewModal.classList.remove('hidden');
        dokumenDetails.innerHTML = '<div class="text-center p-10">Memuatkan...</div>';
        try {
            const res = await fetch(`<?= base_url('pengesahandokumen/getDokumen') ?>/${id}`);
            const json = await res.json();
            if (json.status) {
                const d = json.data;
                const fileUrl = `<?= base_url('pengesahandokumen/viewFile') ?>/${d.idservis}/${d.namafail}`;
                const statusLabel = d.status ? d.status.toLowerCase() : 'pending';
                let fileHTML = d.mime.includes('image') ? `<img src="${fileUrl}" class="w-full rounded-2xl shadow-lg border" />` : (d.mime === 'application/pdf' ? `<div class="file-preview-wrapper"><iframe src="${fileUrl}" class="file-preview-frame"></iframe></div>` : `<div class="p-8 border-2 border-dashed rounded-2xl text-center"><a href="${fileUrl}" target="_blank" class="text-indigo-600 font-bold underline">Muat Turun Fail</a></div>`);
                dokumenDetails.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4 mb-6">
                        <div><span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Nama Dokumen</span><p class="font-bold text-slate-800 mt-1">${d.nama}</p></div>
                        <div><span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Jenis Servis</span><p class="font-bold text-slate-800 mt-1">${d.namaservis || '-'}</p></div>
                        <div><span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Status Semasa</span><div class="mt-2"><span class="status-pill status-${statusLabel}">${statusLabel.toUpperCase()}</span></div></div>
                        <div><div class="mt-2 flex justify-start"><a href="${fileUrl}" target="_blank" class="bg-indigo-100 hover:bg-indigo-600 text-indigo-700 hover:text-white px-4 py-2 rounded-xl text-sm font-bold transition inline-flex items-center gap-2"><i class="bi bi-box-arrow-up-right"></i> Buka Tab Baru</a></div></div>
                    </div>
                    <div class="mb-6"><span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Catatan</span><div class="text-slate-600 mt-1">${d.descdoc || 'Tiada catatan.'}</div></div>
                    ${fileHTML}`;
            }
        } catch (err) { console.error(err); }
    }

    window.confirmBulkStatus = async function(status) {
        const selected = document.querySelectorAll('.doc-checkbox:checked');
        if (selected.length === 0) return;

        const confirmText = status === 'approved' ? 'Luluskan' : 'Tolak';
        const result = await Swal.fire({
            title: `Pengesahan ${confirmText}`,
            text: `Adakah anda pasti untuk ${confirmText.toLowerCase()} ${selected.length} dokumen?`,
            icon: status === 'approved' ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonText: `Ya, ${confirmText}!`,
            cancelButtonText: 'Batal',
            customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-hantar', cancelButton: 'btn-swal-batal', actions: 'swal2-actions' }
        });

        if (!result.isConfirmed) return;
        bulkChangeStatus(status);
    }

    // Function Bulk Actions
    window.bulkChangeStatus = async function(status) 
    {
        const selected = document.querySelectorAll('.doc-checkbox:checked');
        const ids = Array.from(selected).map(cb => cb.getAttribute('data-id'));
        if (ids.length === 0) return;

        const formData = new FormData();
        formData.append('<?= csrf_token() ?>', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('status', status);
        ids.forEach(id => formData.append('ids[]', id));
        
        try {
            const res = await fetch(`<?= base_url('pengesahandokumen/bulkChangeStatus') ?>`, { 
                method: 'POST', 
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            // Kalau URL salah (404) atau Server Error (500), dia akan tangkap
            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
            
            const data = await res.json();
            if (data.csrf) document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf);
            
            if (data.status) {
                Swal.fire({ icon: 'success', title: 'Berjaya!', text: data.message, timer: 2000, showConfirmButton: false, customClass: { popup: 'swal-rounded' } });
                unselectAll();
                loadData(currentPage);
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message, customClass: { popup: 'swal-rounded' } });
            }
        } catch (err) { 
            console.error('AJAX Error:', err); 
            // Pop up kalau crash
            Swal.fire({ icon: 'error', title: 'Ralat Sistem', text: 'Gagal berhubung dengan server. Sila semak console.', customClass: { popup: 'swal-rounded' } });
        }
    }

    // Kod changeStatus tunggal
    window.changeStatus = async function(id, status) {
        const confirmText = status.charAt(0).toUpperCase() + status.slice(1);
        const result = await Swal.fire({ 
            title: `Pengesahan ${confirmText}`, 
            text: `Adakah anda pasti untuk tukar status dokumen ini kepada ${status}?`, 
            icon: status === 'approved' ? 'question' : 'warning', 
            showCancelButton: true, 
            confirmButtonText: `Ya, ${confirmText}!`,
            cancelButtonText: 'Batal',
            customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-hantar', cancelButton: 'btn-swal-batal', actions: 'swal2-actions' }
        });
        if (!result.isConfirmed) return;
        try {
            const formData = new FormData();
            formData.append('<?= csrf_token() ?>', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            const res = await fetch(`<?= base_url('pengesahandokumen/changeStatus') ?>/${id}/${status}`, { method: 'POST', body: formData });
            const data = await res.json();
            if (data.csrf) document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf);
            if (data.status) {
                if (status === 'approved') { lottieContainer.style.display = 'block'; successAnimation.play(); setTimeout(() => { lottieContainer.style.display = 'none'; }, 1500); }
                Swal.fire({ icon: 'success', title: 'Berjaya!', text: data.message, timer: 2000, showConfirmButton: false, customClass: { popup: 'swal-rounded' } });
                loadData(currentPage);
            }
        } catch (err) { console.error(err); }
    }

    tbody.addEventListener('click', e => {
        const btn = e.target.closest('.btn-action');
        if (!btn) return;
        const id = btn.getAttribute('data-id');
        if (btn.classList.contains('viewBtn')) showDokumenModal(id);
        else if (btn.classList.contains('approveBtn')) changeStatus(id, 'approved');
        else if (btn.classList.contains('rejectBtn')) changeStatus(id, 'rejected');
    });

    searchInput.addEventListener('input', () => {
        const term = searchInput.value.toLowerCase();
        Array.from(tbody.rows).forEach(row => { row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none'; });
    });

    document.getElementById('closeViewModal').onclick = () => viewModal.classList.add('hidden');

    loadData(1);
});
</script>

<?= $this->endSection() ?>