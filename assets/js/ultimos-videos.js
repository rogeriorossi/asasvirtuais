document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('ultimos-videos-container');
    const modalEl = document.getElementById('videoModal');
    const modalIframe = document.getElementById('modalIframe');
    const modalLabel = document.getElementById('videoModalLabel');

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
                renderVideos(data.videos);
            } else {
                renderError('Nenhum vídeo encontrado no momento.');
            }
        } catch (error) {
            console.error('Erro ao carregar vídeos:', error);
            renderError('Ocorreu um erro ao carregar os vídeos do canal. Tente novamente mais tarde.');
        }
    }

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
            
            const col = document.createElement('div');
            col.className = 'col-12 col-md-6 col-lg-4';

            col.innerHTML = `
                <div class="card video-card bg-dark border-secondary h-100 shadow-sm overflow-hidden" role="button">
                    <div class="thumb-wrapper position-relative">
                        <img src="${escapeHtml(video.thumbnail)}" class="card-img-top img-fluid" alt="${escapeHtml(video.title)}" loading="lazy" />
                        <div class="play-overlay d-flex align-items-center justify-content-center">
                            <div class="play-icon d-flex align-items-center justify-content-center shadow-lg">
                                <i class="bi bi-play-fill fs-2"></i>
                            </div>
                        </div>
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
            // Fallback caso Bootstrap JS esteja carregando
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