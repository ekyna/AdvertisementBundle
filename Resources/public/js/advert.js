require(['require', 'jquery'], function(require, $) {

    var $submitLink = $('[data-role="advert-submit"]');
    if ($submitLink.length > 0) {
        require(['ekyna-modal'], function(Modal) {
            $submitLink.on('click', function(e) {
                e.preventDefault();

                var modal = new Modal(), form;
                modal.load({url: $(this).attr('href')});

                return false;
            });
        });
    }
});
