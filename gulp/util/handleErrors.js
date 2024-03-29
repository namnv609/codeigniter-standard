var notify = require("gulp-notify");

module.exports = function() {
    var args = Array.prototype.slice.call(arguments);

    notify.onError({
        title: "Compile error",
        message: "<%= error.message %>"
    }).apply(this, args);

    this.emit("end");
}
