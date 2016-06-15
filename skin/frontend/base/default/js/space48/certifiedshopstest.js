document.observe("dom:loaded", function() {
    var html = $('gts-order').innerHTML;
    $('test-certifiedshops').insert(html.escapeHTML());
});
