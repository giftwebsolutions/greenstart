/* Livewire 4 includes Alpine. This file intentionally stays framework-free. */
const initializeAdmin = () => {
    document.querySelectorAll('.editor').forEach((editor) => {
        if (editor.dataset.initialized) return;
        editor.dataset.initialized = 'true';
        const isTextarea = editor.matches('textarea');
        const input = isTextarea
            ? editor
            : editor.parentElement?.querySelector(`input[type="hidden"][name="${editor.dataset.name}"]`);
        if (!input) return;

        const shell = document.createElement('div');
        shell.className = 'html-editor-shell';
        const toolbar = document.createElement('div');
        toolbar.className = 'html-editor-toolbar';
        toolbar.setAttribute('role', 'toolbar');
        toolbar.innerHTML = [
            ['bold', '<strong>B</strong>'], ['italic', '<em>I</em>'], ['underline', '<u>U</u>'],
            ['separator', ''], ['formatBlock:h3', 'H3'], ['formatBlock:p', 'P'], ['separator', ''],
            ['insertUnorderedList', '• List'], ['insertOrderedList', '1. List'], ['createLink', 'Link'], ['removeFormat', 'Clear'],
        ].map(([command, label]) => command === 'separator'
            ? '<span></span>'
            : `<button type="button" data-editor-command="${command}">${label}</button>`).join('');

        const surface = isTextarea ? document.createElement('div') : editor;
        if (isTextarea) {
            surface.innerHTML = editor.value;
            editor.hidden = true;
            surface.setAttribute('aria-required', editor.required ? 'true' : 'false');
            editor.required = false;
            editor.parentNode.insertBefore(shell, editor);
        } else {
            editor.parentNode.insertBefore(shell, editor);
        }
        surface.classList.remove('editor');
        surface.classList.remove('form-control');
        surface.classList.add('html-editor-surface');
        surface.contentEditable = 'true';
        surface.setAttribute('role', 'textbox');
        surface.setAttribute('aria-multiline', 'true');
        shell.append(toolbar, surface);

        const sync = () => {
            input.value = surface.innerHTML;
            input.dispatchEvent(new Event('input', { bubbles: true }));
        };
        surface.addEventListener('input', sync);
        input.form?.addEventListener('submit', sync);
        toolbar.addEventListener('mousedown', event => event.preventDefault());
        toolbar.addEventListener('click', event => {
            const button = event.target.closest('[data-editor-command]');
            if (!button) return;
            const [command, argument] = button.dataset.editorCommand.split(':');
            if (command === 'createLink') {
                const url = window.prompt('Link URL');
                if (url) document.execCommand(command, false, url);
            } else {
                document.execCommand(command, false, argument || null);
            }
            surface.focus();
            sync();
        });
    });

    document.querySelectorAll('a#cancel-button[href="javascript:void(0);"]').forEach((button) => {
        button.href = '#';
        button.addEventListener('click', (event) => { event.preventDefault(); history.back(); }, { once: true });
    });

    const previews = [
        ['featured_image', 'imgPreview'], ['thumbnail', 'imgPreview'], ['image', 'imgPreview'],
        ['image-input', 'imagePreview'], ['banner', 'bannerPreview'], ['banner-image', 'bannerPreview'],
    ];

    previews.forEach(([inputId, previewId]) => {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        if (!input || !preview || input.dataset.previewReady) return;
        input.dataset.previewReady = 'true';
        input.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file) return;
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        });
    });
};

document.addEventListener('DOMContentLoaded', initializeAdmin);
document.addEventListener('livewire:navigated', initializeAdmin);
