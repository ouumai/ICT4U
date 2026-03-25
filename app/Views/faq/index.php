<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script>document.title = "FAQ";</script>

<meta name="csrf-token" content="<?= csrf_hash() ?>">

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

<style>
    /* 1. Global Font */
    body, .content-wrapper, .main-sidebar, h1, h2, h3, h4, h5, h6, p, span, div, table, input, textarea, button, select {
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

    /* 5. Accordion Styling */
    .accordion-item {
        border: 1px solid #e2e8f0 !important;
        border-radius: 1.25rem !important;
        margin-bottom: 1rem;
        overflow: hidden;
        background: white;
    }
    .accordion-button {
        padding: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        background: white;
        width: 100%;
        text-align: left;
    }
    .accordion-button:not(.collapsed) {
        background: #f8fafc;
        color: #4f46e5;
        box-shadow: none;
    }

    /* 6. SweetAlert Custom Styling */
    .swal-rounded { border-radius: 2rem !important; padding: 1.5rem !important; }
    .swal2-actions { width: 100% !important; display: flex !important; gap: 12px !important; margin-top: 1.5rem !important; padding: 0 1rem !important; }
    
    .btn-swal-indigo { flex: 1 !important; background: #4f46e5 !important; color: white !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; border: none !important; order: 2; }
    .btn-swal-merah { flex: 1 !important; background: #fee2e2 !important; color: #ef4444 !important; font-weight: 700 !important; padding: 14px !important; border-radius: 16px !important; order: 1; }

    .hidden { display: none !important; }
    .input-with-icon { padding-left: 3rem !important; }

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

    /* Text Pilihan */
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
                <i class="bi bi-question-diamond-fill text-3xl text-indigo-500"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-1">FAQ</h1>
                <p class="text-gray-500 font-medium mb-0">Uruskan soalan lazim mengikut kategori servis sistem</p>
            </div>
        </div>
        <div id="actionArea" class="hidden mt-4 md:mt-0">
            <button id="btnCreateFaq" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-xl font-bold transition shadow-lg flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Tambah FAQ Baru 
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-8">
        <div class="md:col-span-4">
            <div class="glass-card p-6 h-full relative z-50">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                    <i class="bi bi-tag-fill text-black-400"></i> Kategori Servis
                </label>
                <div class="servis-select-wrapper TS-Compact relative">
                    <select id="dropdownServis" autocomplete="off" name="idservis_pilih" class="w-full appearance-none">
                        <option value="">-- Sila Pilih Servis --</option>
                        <?php foreach($servisList as $s): ?>
                            <option value="<?= esc($s['idservis']) ?>"><?= esc($s['namaservis']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="custom-arrow bi bi-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none transition-transform duration-200" style="z-index: 100;"></i>
                </div>
            </div>
        </div>
        <div class="md:col-span-8">
            <div id="searchContainer" class="glass-card p-6 h-full hidden">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                    <i class="bi bi-question-lg"></i> Cari Soalan / Jawapan
                </label>
                <div class="relative">
                    <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 z-10"></i>
                    <input type="text" id="faqSearch" placeholder="Taip kata kunci carian..." class="input-modern input-with-icon">
                </div>
            </div>
        </div>
    </div>

    <div id="emptyState" class="glass-card py-20 bg-white text-center">
        <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
            <i class="bi bi-filter text-4xl text-slate-300"></i>
        </div>
        <h5 class="text-slate-900 font-bold mb-1">Sila Pilih Servis</h5>
        <p class="text-slate-500 font-medium">Pilih kategori servis untuk memaparkan senarai FAQ.</p>
    </div>

    <div id="faqArea" class="hidden">
        <div id="faqList"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>
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

    function refreshToken(newToken) {
        if(newToken) {
            $('meta[name="csrf-token"]').attr('content', newToken);
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': newToken } });
        }
    }

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    function loadFaq(id) {
        $('#faqList').html('<div class="text-center py-10 text-slate-400 font-bold">Memproses data...</div>');
        $.get(`<?= base_url('faq/ajax') ?>/${id}`, function(res) {
            if(res.csrf) refreshToken(res.csrf);
            if(res.success && res.faqs.length > 0) {
                let html = '<div class="accordion" id="faqAccordion">';
                res.faqs.forEach((faq, i) => {
                    let qBase64 = btoa(unescape(encodeURIComponent(faq.question)));
                    let aBase64 = btoa(unescape(encodeURIComponent(faq.answer)));

                    html += `
                    <div class="accordion-item shadow-sm border-0">
                        <div class="flex items-center justify-between bg-white pr-4">
                            <button class="accordion-button ${i>0?'collapsed':''}" data-bs-toggle="collapse" data-bs-target="#faq${faq.id}">
                                <span>${faq.question}</span>
                            </button>
                            <div class="flex gap-2 py-2">
                                <button onclick="openEditModal(${faq.id}, '${qBase64}', '${aBase64}')" class="w-10 h-10 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="deleteFaq(${faq.id})" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </div>
                        </div>
                        <div id="faq${faq.id}" class="accordion-collapse collapse ${i===0?'show':''}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-slate-600 leading-relaxed p-6 border-t border-slate-50">
                                ${faq.answer}
                            </div>
                        </div>
                    </div>`;
                });
                html += '</div>';
                $('#faqList').html(html);
            } else {
                $('#faqList').html('<div class="glass-card p-20 text-center text-slate-400">Belum ada soalan untuk servis ini.</div>');
            }
        });
    }

    $('#faqSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase().trim();
        const faqItems = $('.accordion-item');
        const listContainer = $('#faqList');

        if (searchTerm === "") {
            faqItems.show();
            $('#noSearchMsg').remove();
            return;
        }

        faqItems.each(function() {
            const question = $(this).find('.accordion-button').text().toLowerCase();
            const answer = $(this).find('.accordion-body').text().toLowerCase();
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        const visibleCount = $('.accordion-item:visible').length;
        if (visibleCount === 0) {
            if ($('#noSearchMsg').length === 0) {
                listContainer.append(`
                    <div id="noSearchMsg" class="glass-card py-20 bg-white text-center">
                        <div class="bg-red-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <i class="bi bi-journal-x text-4xl text-red-500"></i>
                        </div>
                        <h5 class="text-slate-900 font-bold mb-1">Tiada Padanan Ditemui</h5>
                        <p class="text-slate-500 font-medium">Maaf, tiada FAQ yang sepadan dengan kata kunci "${searchTerm}".</p>
                    </div>
                `);
            } else {
                $('#noSearchMsg').find('p').text(`Maaf, tiada FAQ yang sepadan dengan kata kunci "${searchTerm}".`);
            }
        } else {
            $('#noSearchMsg').remove();
        }
    });

    $('#dropdownServis').change(function() {
        const id = $(this).val();
        $('#faqSearch').val(''); 
        if(id) {
            $('#emptyState').addClass('hidden');
            $('#faqArea, #actionArea, #searchContainer').removeClass('hidden');
            loadFaq(id);
        } else {
            $('#faqArea, #actionArea, #searchContainer').addClass('hidden');
            $('#emptyState').removeClass('hidden');
        }
    });

    $('#btnCreateFaq').click(function() {
        const idServis = $('#dropdownServis').val();
        Swal.fire({
            title: 'Tambah FAQ Baru',
            showCloseButton: true,
            html: `<div class="text-left mt-4"><label class="text-xs font-bold text-slate-400 uppercase">Soalan</label><input id="swal-q" class="input-modern mb-4 mt-1" placeholder="Taip soalan..."><label class="text-xs font-bold text-slate-400 uppercase">Jawapan</label><textarea id="swal-a" class="input-modern mt-1" rows="5" placeholder="Taip jawapan..."></textarea></div>`,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-indigo', cancelButton: 'btn-swal-merah', actions: 'swal2-actions', closeButton: 'swal2-close' },
            preConfirm: () => {
                const q = $('#swal-q').val().trim();
                const a = $('#swal-a').val().trim();
                if (!q || !a) { Swal.showValidationMessage('Sila isi soalan dan jawapan'); return false; }
                return { question: q, answer: a, idservis: idServis };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                
                $.post('<?= base_url('faq/store') ?>', result.value, function(res) {
                    refreshToken(res.csrf);
                    Swal.fire({ icon: 'success', title: 'Berjaya!', text: 'FAQ baru ditambah.', timer: 1500, showConfirmButton: false, customClass: {popup: 'swal-rounded'} });
                    loadFaq(idServis);
                });
            }
        });
    });

    window.openEditModal = function(id, qBase64, aBase64) {
        let question = decodeURIComponent(escape(atob(qBase64)));
        let answer = decodeURIComponent(escape(atob(aBase64)));
        Swal.fire({
            title: 'Kemaskini FAQ',
            showCloseButton: true,
            html: `<div class="text-left mt-4"><label class="text-xs font-bold text-slate-400 uppercase">Soalan</label><input id="swal-eq" class="input-modern mb-4 mt-1" value="${question}"><label class="text-xs font-bold text-slate-400 uppercase">Jawapan</label><textarea id="swal-ea" class="input-modern mt-1" rows="5">${answer}</textarea></div>`,
            showCancelButton: true,
            confirmButtonText: 'Kemaskini',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-indigo', cancelButton: 'btn-swal-merah', actions: 'swal2-actions', closeButton: 'swal2-close' },
            preConfirm: () => { return { question: $('#swal-eq').val(), answer: $('#swal-ea').val() }; }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                $.post(`<?= base_url('faq/update') ?>/${id}`, result.value, function(res) {
                    refreshToken(res.csrf);
                    loadFaq($('#dropdownServis').val());
                    Swal.fire({ icon: 'success', title: 'Berjaya!', text: 'FAQ dikemaskini.', timer: 1500, showConfirmButton: false, customClass: {popup: 'swal-rounded'} });
                });
            }
        });
    };

    window.deleteFaq = function(id) {
        Swal.fire({
            title: 'Padam FAQ?',
            text: 'Tindakan ini tidak boleh diundur!',
            icon: 'warning',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya, Padam',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: { popup: 'swal-rounded', confirmButton: 'btn-swal-indigo', cancelButton: 'btn-swal-merah', actions: 'swal2-actions', closeButton: 'swal2-close' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= base_url('faq/delete') ?>/${id}`,
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) { 
                        refreshToken(res.csrf);
                        loadFaq($('#dropdownServis').val());
                        Swal.fire({ icon: 'success', title: 'Dipadam!', text: 'FAQ berjaya dibuang.', timer: 1500, showConfirmButton: false, customClass: {popup: 'swal-rounded'} });
                    }
                });
            }
        });
    };
});
</script>

<?= $this->endSection() ?>