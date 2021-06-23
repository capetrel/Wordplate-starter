(function () {
    tinymce.PluginManager.add('caret', function (editor, url) {
        editor.addButton('caret', {
            title: 'Retour chariot',
            cmd: 'caret',
            image: url + '/caret.svg'
        });
        editor.addCommand('caret', function () {
            let text = editor.selection.getContent({
                'format': 'html'
            });
            let matchBr = text.match(/<br\/?>/g);
            let html = text;
            if (matchBr) {
                html = html.replace(/<br\/?>/g, ' ')
            } else {
                html = `<br>`
            }
            editor.execCommand('mceReplaceContent', false, html);
        })
    });
})();