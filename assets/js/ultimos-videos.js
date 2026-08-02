document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('ultimos-videos-container');
    const modalEl = document.getElementById('videoModal');
    const modalIframe = document.getElementById('modalIframe');
    const modalLabel = document.getElementById('videoModalLabel');
    const searchInput = document.getElementById('video-search-input');
    const clearSearchBtn = document.getElementById('clear-search-btn');
    const filterButtons = document.querySelectorAll('.btn-filter');
    const ytExternalBtn = document.getElementById('yt-search-external-btn');
    const ytBtnText = document.getElementById('yt-search-btn-text');

    let allVideos = [];
    let currentFilterTag = 'all';
    let currentFilterTerm = '';
    let bsModalInstance = null;

    if (modalEl && typeof bootstrap !== 'undefined') {
        bsModalInstance = new bootstrap.Modal(modalEl);
        
        // Limpar iframe ao fechar o modal
        modalEl.addEventListener('hidden.bs.modal', () => {
            if (modalIframe) {
                modalIframe.src = '';
            }
        });
    }

    // Carregar os vídeos da API PHP com cache
    async function loadVideos() {
        if (!container) return;

        // Exibir Skeletons durante o carregamento
        renderSkeletons(6);

        try {
            const response = await fetch('./api/videos.php');
            if (!response.ok) {
                throw new Error('Falha ao conectar à API de vídeos');
            }

            const data = await response.json();

            if (data.success && data.videos && data.videos.length > 0) {
                allVideos = data.videos;
                applyFiltersAndRender();
            } else {
                renderError('Nenhum vídeo encontrado no momento.');
            }
        } catch (error) {
            console.error('Erro ao carregar vídeos:', error);
            renderError('Ocorreu um erro ao carregar os vídeos do canal. Tente novamente mais tarde.');
        }
    }

    // Aplicar Filtro por busca e tag
    function applyFiltersAndRender() {
        const query = searchInput ? searchInput.value.trim() : '';
        const queryLower = query.toLowerCase();

        const filtered = allVideos.filter(video => {
            const title = video.title ? video.title.toLowerCase() : '';
            const desc = video.description ? video.description.toLowerCase() : '';

            // Match busca por texto
            const matchesQuery = !queryLower || title.includes(queryLower) || desc.includes(queryLower);

            // Match busca por tag
            let matchesTag = true;
            if (currentFilterTag === 'live') {
                matchesTag = title.includes('live') || title.includes('ao vivo');
            } else if (currentFilterTag === 'tutorial') {
                matchesTag = title.includes('tutorial') || title.includes('carta') || desc.includes('tutorial');
            } else if (currentFilterTag === 'ils') {
                matchesTag = title.includes('ils') || desc.includes('ils');
            } else if (currentFilterTag === 'zibo') {
                matchesTag = title.includes('737') || title.includes('zibo') || title.includes('pmdg');
            }

            return matchesQuery && matchesTag;
        });

        // Atualizar o botão de busca externa do YouTube
        updateYouTubeExternalLink(query || currentFilterTerm);

        if (filtered.length > 0) {
            renderVideos(filtered);
        } else {
            renderEmptySearch(query || currentFilterTerm);
        }
    }

    // Atualizar o botão CTA do YouTube dinamicamente com o termo buscado
    function updateYouTubeExternalLink(searchTerm) {
        if (!ytExternalBtn || !ytBtnText) return;

        if (searchTerm && searchTerm.trim() !== '') {
            const encodedTerm = encodeURIComponent(searchTerm.trim());
            ytExternalBtn.href = `https://www.youtube.com/@asasvirtuais/search?query=${encodedTerm}`;
            ytBtnText.textContent = `Buscar "${searchTerm.trim()}" no acervo completo do YouTube`;
        } else {
            ytExternalBtn.href = `https://www.youtube.com/@asasvirtuais/videos`;
            ytBtnText.textContent = `Ver Todo o Acervo no YouTube (+100 Vídeos)`;
        }
    }

    // Event Listeners de Busca e Tags
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            if (clearSearchBtn) {
                clearSearchBtn.classList.toggle('d-none', !searchInput.value);
            }
            applyFiltersAndRender();
        });
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', () => {
            if (searchInput) {
                searchInput.value = '';
                clearSearchBtn.classList.add('d-none');
                applyFiltersAndRender();
            }
        });
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentFilterTag = btn.getAttribute('data-filter') || 'all';
            currentFilterTerm = btn.getAttribute('data-term') || '';
            applyFiltersAndRender();
        });
    });

    // Renderizar Skeletons de carregamento com Colunas Bootstrap 5
    function renderSkeletons(count) {
        let html = '';
        for (let i = 0; i < count; i++) {
            html += `
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card bg-dark border-secondary h-100 skeleton-card overflow-hidden">
                        <div class="skeleton-thumb"></div>
                        <div class="card-body p-3">
                            <div class="skeleton-line short mb-2"></div>
                            <div class="skeleton-line long"></div>
                        </div>
                    </div>
                </div>
            `;
        }
        container.innerHTML = html;
    }

    // Renderizar a lista de vídeos
    function renderVideos(videos) {
        container.innerHTML = '';

        videos.forEach(video => {
            const dateFormatted = formatDate(video.publishedAt);
            const isLive = video.title.toLowerCase().includes('live') || video.title.toLowerCase().includes('ao vivo');

            const col = document.createElement('div');
            col.className = 'col-12 col-md-6 col-lg-4';

            col.innerHTML = `
                <div class="card video-card bg-dark border-secondary h-100 shadow-sm overflow-hidden" role="button">
                    <div class="thumb-wrapper position-relative">
                        <img src="${escapeHtml(video.thumbnail)}" class="card-img-top img-fluid" alt="${escapeHtml(video.title)}" loading="lazy" />
                        <div class="play-overlay d-flex align-items-center justify-content-center">
                            <div class="play-icon d-flex align-items-center justify-content-center shadow-lg">
                                <i class="bi bi-play-fill fs-1"></i>
                            </div>
                        </div>
                        ${isLive ? '<span class="badge bg-danger position-absolute top-0 start-0 m-3 px-2 py-1 shadow-sm"><i class="bi bi-broadcast me-1"></i>LIVE</span>' : ''}
                    </div>
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="badge bg-warning text-dark mb-2 text-uppercase fw-semibold">${dateFormatted}</div>
                            <h3 class="card-title h6 text-light video-card-title mb-0">${escapeHtml(video.title)}</h3>
                        </div>
                    </div>
                </div>
            `;

            col.querySelector('.video-card').addEventListener('click', () => {
                openModal(video.embedUrl, video.title);
            });

            container.appendChild(col);
        });
    }

    // Mensagem de Busca Vazia orientando busca no YouTube
    function renderEmptySearch(searchTerm) {
        const encodedTerm = encodeURIComponent(searchTerm || '');
        const searchUrl = searchTerm ? `https://www.youtube.com/@asasvirtuais/search?query=${encodedTerm}` : `https://www.youtube.com/@asasvirtuais/videos`;

        container.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="p-4 p-md-5 bg-dark rounded-4 border border-secondary d-inline-block shadow-lg" style="max-width: 600px;">
                    <i class="bi bi-search text-warning fs-1 mb-3 d-block"></i>
                    <h4 class="h5 text-light mb-2">Nenhum vídeo recente encontrado para "${escapeHtml(searchTerm)}"</h4>
                    <p class="text-secondary mb-4 fs-6">
                        Exibimos nesta página os vídeos mais recentes do canal. Caso o vídeo que você procura seja mais antigo, pesquise em todo o nosso acervo diretamente no YouTube.
                    </p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="${searchUrl}" target="_blank" rel="noopener" class="btn btn-danger btn-md rounded-pill px-4 fw-bold">
                            <i class="bi bi-youtube me-2"></i>Buscar "${escapeHtml(searchTerm)}" no YouTube
                        </a>
                        <button type="button" id="reset-filter-btn" class="btn btn-outline-warning btn-md rounded-pill px-4">
                            Limpar Filtros
                        </button>
                    </div>
                </div>
            </div>
        `;

        const resetBtn = document.getElementById('reset-filter-btn');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                if (searchInput) searchInput.value = '';
                if (clearSearchBtn) clearSearchBtn.classList.add('d-none');
                currentFilterTag = 'all';
                currentFilterTerm = '';
                filterButtons.forEach(b => b.classList.remove('active'));
                const allBtn = document.querySelector('.btn-filter[data-filter="all"]');
                if (allBtn) allBtn.classList.add('active');
                applyFiltersAndRender();
            });
        }
    }

    // Mensagem de Erro
    function renderError(message) {
        container.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="p-4 bg-dark rounded-4 border border-secondary d-inline-block">
                    <i class="bi bi-exclamation-triangle text-warning fs-1 mb-3 d-block"></i>
                    <p class="text-secondary mb-0 fs-6">${escapeHtml(message)}</p>
                </div>
            </div>
        `;
    }

    // Modal Player Logic com Bootstrap 5 Modal
    function openModal(embedUrl, title) {
        if (!modalIframe) return;

        if (modalLabel) {
            modalLabel.textContent = title;
        }

        modalIframe.src = `${embedUrl}?autoplay=1`;

        if (bsModalInstance) {
            bsModalInstance.show();
        } else if (modalEl) {
            modalEl.classList.add('show');
            modalEl.style.display = 'block';
        }
    }

    // Formatação de data
    function formatDate(dateString) {
        if (!dateString) return '';
        try {
            const date = new Date(dateString);
            return new Intl.DateTimeFormat('pt-BR', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }).format(date);
        } catch (e) {
            return dateString;
        }
    }

    // Helper sanitização HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Inicializar busca
    loadVideos();
});