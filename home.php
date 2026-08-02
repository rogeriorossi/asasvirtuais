<main class="flex-grow-1">
    <section class="py-5 text-center hero-section">
        <div class="container">
            <h1 class="hero-title display-5 fw-bold mb-3">Canal Asas Virtuais</h1>
            <p class="hero-subtitle lead mx-auto">
                Confira os últimos vídeos de simulação de voo, tutoriais e gameplays de aviação virtual, publicados no canal. 
            </p>
        </div>
    </section>

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
