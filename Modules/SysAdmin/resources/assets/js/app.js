import './bootstrap';
import 'laravel-datatables-vite';

import Quill from 'quill';
import 'quill/dist/quill.snow.css';

document.addEventListener('DOMContentLoaded', () => {
    const toolbarOptions = [
        [{ header: [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ color: [] }, { background: [] }],
        [{ align: [] }],
        [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
        [{ script: 'sub' }, { script: 'super' }],
        ['blockquote', 'code-block'],
        ['link', 'image', 'video'],
        ['clean']
    ];

    document.querySelectorAll('.editor').forEach((el, index) => {
        // Skip if already initialized
        if (el.dataset.initialized) return;

        const quill = new Quill(el, {
            theme: 'snow',
            placeholder: el.getAttribute('data-placeholder') || 'Start writing here...',
            modules: {
                toolbar: {
                    container: toolbarOptions,
                    handlers: {
                        image: function () {
                            const fileManagerUrl = '/file-manager/quill';
                            const fileWindow = window.open(
                                fileManagerUrl,
                                'FileManager',
                                'width=1100,height=650,resizable=yes,scrollbars=yes'
                            );

                            // Wait for image selection from file manager
                            window.addEventListener('quillFileSelected', (event) => {
                                const imageUrl = event.detail.url;
                                const range = this.quill.getSelection(true);
                                this.quill.insertEmbed(range.index, 'image', imageUrl);
                                this.quill.setSelection(range.index + 1);
                                if (fileWindow) fileWindow.close();
                            }, { once: true });
                        }
                    }
                }
            }
        });

        // Sync HTML back to hidden input (for form submission)
        const form = el.closest('form');
        if (form) {
            const hiddenInput = form.querySelector(
                `input[name="content"], textarea[name="content"], input[name="${el.dataset.name}"], textarea[name="${el.dataset.name}"]`
            );
            if (hiddenInput) {
                hiddenInput.value = quill.root.innerHTML;
                quill.on('text-change', () => {
                    hiddenInput.value = quill.root.innerHTML;
                });
            }
        }

        // Mark initialized
        el.dataset.initialized = true;
    });
});
