(function(win, $, router) {

    $(win.document).ready(function() {

        var $modal = $('#modal');

        function modalResponse(xmldata) {

            var $title = $(xmldata).find('title');
            if ($title.length == 1) {
                $modal.find('.modal-title').html($title.text());
            }

            var $form = $(xmldata).find('form');
            if ($form.length == 1) {
                $form = $($form.text());
                $form.find('.form-footer a.form-cancel-btn').click(function(e) {
                    e.preventDefault();
                    $modal.modal('hide');
                });

                $form.ajaxForm({
                    dataType: 'xml',
                    success: function(xmldata) {
                        for (var edId in tinymce.editors) {
                            tinymce.editors[edId].destroy();
                            tinymce.editors[edId].remove();
                        }
                        tinymce.editors = [];
                        modalResponse(xmldata);
                    },
                    beforeSerialize: function() {
                        win.tinymce.EditorManager.triggerSave();
                    }
                });

                $modal.find('.modal-body').html($form);

                $form.formWidget();
                initTinyMCE();

                $modal.modal('show');
            }

            var $result = $(xmldata).find('result');
            if ($result.length == 1) {
                $modal.find('.modal-body').html($result.text());
                $modal.modal('show');
            }
        }

        $('[data-role="advert-submit"]').bind('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            $.ajax({
                url: $(this).attr('href'),
                dataType: 'xml',
                cache: false
            })
            .done(function(xmldata) {
                modalResponse(xmldata);
            });
        });

    });

})(window, jQuery, Routing);
