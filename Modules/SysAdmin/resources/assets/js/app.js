import './bootstrap';
import 'laravel-datatables-vite';

import 'tinymce/tinymce';
import 'tinymce/skins/ui/oxide/skin.min.css';
import 'tinymce/skins/content/default/content.min.css';
import 'tinymce/skins/content/default/content.css';
import 'tinymce/icons/default/icons';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';
import 'tinymce/plugins/image';
import 'tinymce/plugins/media';
import 'tinymce/plugins/link';
import 'tinymce/plugins/code';
import 'tinymce/plugins/table';

import '@eonasdan/tempus-dominus/dist/css/tempus-dominus.min.css';
import '@fortawesome/fontawesome-free/scss/fontawesome.scss';
import '@fortawesome/fontawesome-free/scss/brands.scss';
import '@fortawesome/fontawesome-free/scss/regular.scss';
import '@fortawesome/fontawesome-free/scss/solid.scss';
import '@fortawesome/fontawesome-free/scss/v4-shims.scss';

// Import CodeMirror styles and scripts
//import '@codemirror/view/style.css';

tinymce.init({
    selector: '.editor',

    /* TinyMCE configuration options */
    plugins: 'image media link code table',
    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | image media link | table code',
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    file_picker_callback: function (callback, value, meta) {
        let fileManagerUrl = '/file-manager/tinymce';

        tinymce.activeEditor.windowManager.openUrl({
            title: 'File Manager',
            url: fileManagerUrl,
            buttons: [
                {
                    type: 'cancel',
                    text: 'Close',
                    onClick: 'close'
                }
            ],
        });

        window.addEventListener('tinymceFileSelected', function (event) {
            const url = event.detail.url;
            console.log('Received URL from custom event:', url);
            callback(url); // Pass the URL to TinyMCE's callback function

            // Optionally close the TinyMCE window
            tinymce.activeEditor.windowManager.close();
        }, { once: true });

    },
    skin: false,
    content_css: false
});
