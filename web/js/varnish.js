$(document).ready(function(){
    $('.website-id-checkbox').on('change', function () {
        var varnishId = $(this).data('varnish-id');
        var websiteId = $(this).data('website-id');

        if ($(this).is(':checked')) {
            callAjax('varnish/link', varnishId, websiteId);
        } else {
            callAjax('varnish/unlink', varnishId, websiteId);
        }
    });

    function callAjax(url, varnishId, websiteId) {
        var request = $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: { varnishId: varnishId, websiteId: websiteId }
        });

        request.done(function(response) {
            $('.container').find('.bg-success').remove();
            $('body > .container').prepend($('<p class="bg-success"/>').html(response.message));
        });

        request.fail(function(response) {
            console.log(response.message);
            $('.container').find('.bg-info').remove();
            $('body > .container').prepend($('<p class="bg-info"/>').html('Something went wrong. Please try again later.'));
        });
    }
});