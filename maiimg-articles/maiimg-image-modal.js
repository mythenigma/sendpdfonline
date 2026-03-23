(() => {
  function createModalIfNeeded() {
    let modalEl = document.getElementById("imagePreviewModal");
    if (modalEl) return modalEl;

    modalEl = document.createElement("div");
    modalEl.className = "modal fade";
    modalEl.id = "imagePreviewModal";
    modalEl.tabIndex = -1;
    modalEl.setAttribute("aria-hidden", "true");
    modalEl.innerHTML = `
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="imagePreviewModalTitle">Image preview</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img id="imagePreviewModalImage" src="" alt="">
          </div>
        </div>
      </div>
    `;
    document.body.appendChild(modalEl);
    return modalEl;
  }

  function bindImageZoom() {
    if (!window.bootstrap) return;
    const modalEl = createModalIfNeeded();
    const modal = new window.bootstrap.Modal(modalEl);
    const modalImage = modalEl.querySelector("#imagePreviewModalImage");
    const modalTitle = modalEl.querySelector("#imagePreviewModalTitle");
    const images = document.querySelectorAll("img.img-cyber");

    images.forEach((img) => {
      img.classList.add("zoomable-image");
      img.setAttribute("role", "button");
      img.tabIndex = 0;
      img.setAttribute("title", "Click to enlarge");

      const openModal = () => {
        modalImage.src = img.currentSrc || img.src;
        modalImage.alt = img.alt || "Image preview";
        modalTitle.textContent = img.alt || "Image preview";
        modal.show();
      };

      img.addEventListener("click", openModal);
      img.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === " ") {
          e.preventDefault();
          openModal();
        }
      });
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", bindImageZoom);
  } else {
    bindImageZoom();
  }
})();
