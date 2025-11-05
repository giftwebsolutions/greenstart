/* Import TinyMCE */
import tinymce from 'tinymce';

/* Default icons are required. After that, import custom icons if applicable */
import 'tinymce/icons/default/icons.min.js';

/* Required TinyMCE components */
import 'tinymce/themes/silver/theme.min.js';
import 'tinymce/models/dom/model.min.js';

/* Import a skin (can be a custom skin instead of the default) */
import 'tinymce/skins/ui/oxide/skin.js';

/* Import plugins */
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/code';
import 'tinymce/plugins/emoticons';
import 'tinymce/plugins/emoticons/js/emojis';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/table';

import 'tinymce/plugins/image';
import 'tinymce/plugins/media';

/* Import premium plugins */
/* NOTE: Download separately and add these to /src/plugins */
/* import './plugins/<plugincode>'; */

/* content UI CSS is required */
import contentUiSkinCss from 'tinymce/skins/ui/oxide/content.js';

/* The default content CSS can be changed or replaced with appropriate CSS for the editor content. */
import contentCss from 'tinymce/skins/content/default/content.js';

/* Initialize TinyMCE */
window.addEventListener('DOMContentLoaded', () => {
    tinymce.init({
        selector: '.ckeditor',

        /* TinyMCE configuration options */
        plugins: 'image media link code',
        toolbar: 'undo redo | formatselect| advlist | bold italic | alignleft aligncenter alignright | image media link | code | table',
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
                onMessage: function (dialogApi, details) {
                    console.log(details);
                    if (details.mceAction === 'insert') {
                        console.log(details);
                        callback(details.content.url);
                        dialogApi.close();
                    }
                }
            });
        },
        skin: false,
        content_css: false
    });
});