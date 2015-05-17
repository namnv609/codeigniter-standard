var gulp = require("gulp"),
    config = require("../config"),
    watch = require("gulp-watch");

gulp.task("watch", function() {
    watch(config.compass.watch, function() {
        gulp.start("compass");
    });
    watch(config.coffee.watch, function() {
        gulp.start("coffee");
    });
});
