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
                        modalResponse(xmldata);
                    }
                });

                $modal
                    .off('shown.bs.modal')
                    .on('shown.bs.modal', function() {
                        $form.formWidget();
                        initTinyMCE();
                    });

                $modal.find('.modal-body').html($form);
                $modal.modal({show:true});
            }

            var $result = $(xmldata).find('result');
            if ($result.length == 1) {
                $modal.find('.modal-body').html($result.text());
                $modal.modal({show:true});
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
