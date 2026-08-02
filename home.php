<main class="flex-grow-1">
    <!-- Hero Section com Radial Glow & Busca -->
    <section class="py-5 text-center hero-section position-relative overflow-hidden">
        <div class="hero-bg-glow"></div>
        <div class="container position-relative z-1">
            <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill shadow-sm mb-3 fs-6">VÍDEOS DO CANAL</span>

            <h1 class="hero-title display-4 fw-extrabold mb-3">Asas Virtuais</h1>
            <p class="hero-subtitle lead mx-auto mb-4">
                Confira os últimos vídeos publicados no canal. Para buscar em todo o nosso acervo com mais de 100 vídeos, utilize a busca abaixo ou acesse diretamente nosso canal no YouTube.
            </p>

            <!-- Barra de Pesquisa e Filtros -->
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="search-box-wrapper position-relative mb-3">
                        <i class="bi bi-search search-icon position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary fs-5"></i>
                        <input type="text" id="video-search-input" class="form-control form-control-lg search-input ps-5 pe-4 bg-dark text-light border-secondary shadow-lg rounded-pill" placeholder="Buscar vídeo por título (ex: ILS, Zibo, Live)..." aria-label="Buscar vídeo">
                        <button type="button" id="clear-search-btn" class="btn btn-link text-secondary position-absolute top-50 end-0 translate-middle-y me-2 d-none" aria-label="Limpar busca">
                            <i class="bi bi-x-circle-fill fs-5"></i>
                        </button>
                    </div>

                    <!-- Tags de Filtro Rápido -->
                    <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 filter-tags-container mb-2">
                        <button type="button" class="btn btn-sm btn-filter active rounded-pill px-3" data-filter="all" data-term="">Todos os Recentes</button>
                        <button type="button" class="btn btn-sm btn-filter rounded-pill px-3" data-filter="live" data-term="Live">🔴 Lives</button>
                        <button type="button" class="btn btn-sm btn-filter rounded-pill px-3" data-filter="tutorial" data-term="Tutorial">Tutoriais</button>
                        <button type="button" class="btn btn-sm btn-filter rounded-pill px-3" data-filter="ils" data-term="Carta ILS">Cartas ILS</button>
                        <button type="button" class="btn btn-sm btn-filter rounded-pill px-3" data-filter="zibo" data-term="737 Zibo">737 / Zibo / PMDG</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Grade de Vídeos -->
    <section class="pb-4">
        <div class="container">
            <div id="ultimos-videos-container" class="row g-4">
                <!-- Vídeos e Skeletons serão renderizados dinamicamente em cols do Bootstrap -->
            </div>

            <!-- Banner do YouTube para ver acervo completo -->
            <div class="mt-5 p-4 p-md-5 rounded-4 text-center cta-banner border border-danger border-opacity-50 shadow-lg">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-8">
                        <h3 class="h4 fw-bold text-white mb-2">Procurando por um vídeo específico ou mais antigo?</h3>
                        <p class="text-secondary mb-4">O canal Asas Virtuais conta com um acervo completo de mais de 100 vídeos, lives e tutoriais disponíveis no YouTube.</p>
                        <a id="yt-search-external-btn" href="https://www.youtube.com/@asasvirtuais/videos" target="_blank" rel="noopener" class="btn btn-danger btn-yt-custom btn-lg px-4 py-3 fw-bold shadow-lg d-inline-flex align-items-center gap-3 rounded-pill">
                            <i class="bi bi-youtube fs-3"></i>
                            <span id="yt-search-btn-text">Ver Todo o Acervo no YouTube (+100 Vídeos)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Bootstrap 5 para o Player de Vídeo -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content custom-modal-content border border-secondary shadow-lg">
                <div class="modal-header border-bottom border-secondary-subtle py-3 px-4">
                    <h5 class="modal-title fs-5 text-truncate text-light pe-3" id="videoModalLabel">Assistir Vídeo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9 bg-black">
                        <iframe id="modalIframe" src="" title="YouTube Video Player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="./assets/js/ultimos-videos.js"></script>
