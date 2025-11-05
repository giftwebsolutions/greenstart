<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'File Manager') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" id="fm-main-block">
            <div id="fm"></div>
        </div>
    </div>
</div>

<!-- File manager -->
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // set fm height
    document.getElementById('fm-main-block').setAttribute('style', 'height:' + window.innerHeight + 'px');

    const FileBrowserDialogue = {
      init: function() {
        // Custom initialization code if needed
      },
     mySubmit: function (URL) {
            console.log('File URL selected:', URL);

            // Dispatch a custom event with the selected file URL
            const event = new CustomEvent('tinymceFileSelected', {
                detail: { url: URL }
            });

            // Trigger the event on the window object
            parent.window.dispatchEvent(event);

            // Close the file manager window if needed
            parent.tinymce.activeEditor.windowManager.close();
        }
    };

    // Add callback to file manager
    fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
      console.log('File selected in file manager:', fileUrl); // Debugging log
      FileBrowserDialogue.mySubmit(fileUrl);
    });
  });
</script>
</body>
</html>