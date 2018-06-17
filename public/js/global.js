var global = (function() {
    var siteUrl   = 'public/';
    var jsPath    = siteUrl + 'js/';
    var timestamp = Math.floor(Math.random() * 100000) + 0;

    this.loadScript = function(fileName) {
        $.getScript(jsPath + fileName +'.js?v=' + timestamp, function( data, textStatus, jqxhr ) {});
    };

    this.loadScript('global.events');
    this.loadScript('global.services');

    return self;
}());