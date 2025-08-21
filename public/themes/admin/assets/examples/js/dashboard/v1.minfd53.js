!(function (global, factory) {
    if ("function" == typeof define && define.amd) define("/dashboard/v1", ["jquery", "Site"], factory);
    else if ("undefined" != typeof exports) factory(require("jquery"), require("Site"));
    else {
        var mod = { exports: {} };
        factory(global.jQuery, global.Site), (global.dashboardV1 = mod.exports);
    }
})(this, function (_jquery, _Site) {
    "use strict";
    var _jquery2 = babelHelpers.interopRequireDefault(_jquery),
        Site = babelHelpers.interopRequireWildcard(_Site);
    (0, _jquery2.default)(document).ready(function ($) {
        Site.run();
    });
});
