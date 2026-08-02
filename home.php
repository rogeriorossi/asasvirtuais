<main class="flex-grow-1">
    <!-- Hero Section com Radial Glow & Busca -->
    <section class="py-5 text-center hero-section position-relative overflow-hidden">
        <div class="hero-bg-glow"></div>
        <div class="container position-relative z-1">
            <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill shadow-sm mb-3 fs-6">VÍDEOS DO CANAL</span>

            <h1 class="hero-title display-4 fw-extrabold mb-3">Asas Virtuais</h1>
            <p class="hero-subtitle lead mx-auto mb-4">
                Simulação de voo, tutoriais avançados de navegacão IFR/VFR, procedimentos operacionais e lives ao vivo.
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
                    <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 filter-tags-container">
                        <button type="button" class="btn btn-sm btn-filter active rounded-pill px-3" data-filter="all">Todos</button>
                        <button type="button" class="btn btn-sm btn-filter rounded-pill px-3" data-filter="live">🔴 Lives</button>
                        <button type="button" class="btn btn-sm btn-filter rounded-pill px-3" data-filter="tutorial">Tutoriais</button>
                        <button type="button" class="btn btn-sm btn-filter rounded-pill px-3" data-filter="ils">Cartas ILS</button>
                        <button type="button" class="btn btn-sm btn-filter rounded-pill px-3" data-filter="zibo">737 / Zibo</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Grade de Vídeos -->
    <section class="pb-5">
        <div class="container">
            <div id="ultimos-videos-container" class="row g-4">
                <!-- Vídeos e Skeletons serão renderizados dinamicamente em cols do Bootstrap -->
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
