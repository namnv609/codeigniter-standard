var gulp = require("gulp"),
    coffee = require("gulp-coffee"),
    handleErrors = require("../util/handleErrors"),
    config = require("../config").coffee,
    notify = require("gulp-notify"),
    watch = require("gulp-watch");

gulp.task("coffee", function() {
    gulp.src([
        config.src + "/**/*.coffee"
    ]).pipe(
        coffee({
            bare: false
        })
    ).on("error", handleErrors).pipe(
        gulp.dest(config.dest)
    ).pipe(notify("Compiled <%= file.relative %>"));
});
