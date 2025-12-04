document.addEventListener('DOMContentLoaded', () => {
  const dropzones = document.querySelectorAll('.upload-dropzone');

  dropzones.forEach((dropzone) => {
    const input = dropzone.querySelector('input[type="file"]');
    const preview = dropzone.querySelector('[data-upload-preview]');

    if (!input) return;

    dropzone.addEventListener('click', (e) => {
      if (e.target === input) return;
      input.click();
    });

    dropzone.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropzone.classList.add('is-dragover');
    });

    dropzone.addEventListener('dragleave', (e) => {
      e.preventDefault();
      dropzone.classList.remove('is-dragover');
    });

    dropzone.addEventListener('drop', (e) => {
      e.preventDefault();
      dropzone.classList.remove('is-dragover');

      const files = e.dataTransfer.files;
      if (files.length) {
        input.files = files;
        updatePreview(input, preview);
      }
    });

    input.addEventListener('change', () => {
      updatePreview(input, preview);
    });
  });

  const updatePreview = (input, preview) => {
    if (!preview) return;

    const files = input.files;
    preview.innerHTML = '';

    if (files.length === 0) {
      preview.style.display = 'none';
      return;
    }

    preview.style.display = 'block';

    Array.from(files).forEach((file, index) => {
      const fileItem = document.createElement('div');
      fileItem.className = 'preview-item';

      const icon = getFileIcon(file.name);
      const size = formatFileSize(file.size);

      fileItem.innerHTML = `
                <div class="preview-icon">${icon}</div>
                <div class="preview-info">
                    <span class="preview-name">${file.name}</span>
                    <span class="preview-size">${size}</span>
                </div>
                <button type="button" class="preview-remove" data-remove-index="${index}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            `;

      preview.appendChild(fileItem);
    });

    preview.querySelectorAll('.preview-remove').forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        input.value = '';
        preview.innerHTML = '';
        preview.style.display = 'none';
      });
    });
  };

  const getFileIcon = (filename) => {
    const ext = filename.split('.').pop().toLowerCase();

    const icons = {
      pdf: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <text x="8" y="16" font-size="6" fill="currentColor" stroke="none">PDF</text>
                  </svg>`,
      dxf: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <text x="7" y="16" font-size="5" fill="currentColor" stroke="none">DXF</text>
                  </svg>`,
      dwg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <text x="6" y="16" font-size="5" fill="currentColor" stroke="none">DWG</text>
                  </svg>`,
      step: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <text x="6" y="16" font-size="4.5" fill="currentColor" stroke="none">STEP</text>
                  </svg>`,
      stp: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <text x="7" y="16" font-size="5" fill="currentColor" stroke="none">STP</text>
                  </svg>`,
      stl: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <text x="7" y="16" font-size="5" fill="currentColor" stroke="none">STL</text>
                  </svg>`,
      iges: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <text x="5" y="16" font-size="4.5" fill="currentColor" stroke="none">IGES</text>
                  </svg>`,
      igs: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <text x="7" y="16" font-size="5" fill="currentColor" stroke="none">IGS</text>
                  </svg>`,
    };

    return (
      icons[ext] ||
      `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14,2 14,8 20,8"/>
        </svg>`
    );
  };

  const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
  };
});
