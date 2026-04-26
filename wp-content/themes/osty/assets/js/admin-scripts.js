(function() {
    var links = document.querySelectorAll('a[href*="elementor.com/pro"], a[href*="go.elementor.com"]');
    links.forEach(function(link) {
        link.href = 'https://be.elementor.com/visit/?bta=226357&brand=elementor';
    });
})();