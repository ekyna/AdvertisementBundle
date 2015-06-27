require(['require', 'jquery'], function(require, $) {

    var $submitLink = $('[data-role="advert-submit"]');
    if ($submitLink.length > 0) {
        require(['ekyna-modal', 'ekyna-form'], function(Modal, Form) {
            $submitLink.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var modal = new Modal(), form;
                modal.load({url: $(this).attr('href')});

                $(modal).on('ekyna.modal.content', function (e) {
                    if (form) {
                        form.destroy();
                        form = null;
                    }
                    if (e.contentType == 'form') {
                        form = Form.create(e.content);
                    }
                });

                $(modal).on('ekyna.modal.button_click', function (e) {
                    if (e.buttonId == 'submit' && form) {
                        form.save();
                        setTimeout(function() {
                            form.getElement().ajaxSubmit({
                                dataType: 'xml',
                                success: function(response) {
                                    form.destroy();
                                    form = null;
                                    modal.handleResponse(response);
                                }
                            });
                        }, 100);
                    }
                });

                modal.getDialog().onHide(function() {
                    if (form) {
                        form.destroy();
                        form = null;
                    }
                });
            });
        });
    }
});
