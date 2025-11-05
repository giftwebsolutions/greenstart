
import ButtonView from "@ckeditor/ckeditor5-ui/src/button/buttonview";
import Plugin from "@ckeditor/ckeditor5-core/src/plugin";
import extToMime from "./extToMime";

export default class FileManager extends Plugin {

    init() {
        const editor = this.editor;

        let popupWindow = null;

        editor.ui.componentFactory.add('fileManager', () => {
            const button = new ButtonView();

            button.set({
                label: 'Insert Image',
                icon: `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M10 4H2C1.447 4 1 4.447 1 5v14c0 .553.447 1 1 1h20c.553 0 1-.447 1-1V8c0-.553-.447-1-1-1h-10L10 4zM2 5h7.172l2 2H22v12H2V5z"/>
                    </svg>
                `,
                tooltip: true
            });

            button.on('execute', () => {
                const url = '/file-manager?type=Images';
                window.open(url, 'FileManager', 'width=900,height=600');

                window.SetUrl = function (files) {
                    files.forEach(file => {
                        editor.model.change(writer => {
                            const imageElement = writer.createElement('image', {
                                src: file.url
                            });

                            // Insert the image at the current selection
                            editor.model.insertContent(imageElement, editor.model.document.selection);
                        });
                    });
                };
            });

            return button;
        });
    }
}