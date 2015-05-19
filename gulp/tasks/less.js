var gulp = require("gulp"),
    less = require("gulp-less"),
    notify = require("gulp-notify"),
    handleErrors = require("../util/handleErrors"),
    config = require("../config").less;

gulp.task("less", function() {
    gulp.src([
        config.src + "/**/*.less",
        "!" + config.src + "/common/**/*.less",
        "!" + config.src + "/components/**/*.less"
    ]).pipe(less({
        compress: false
    })).on("error", handleErrors).pipe(
        gulp.dest(config.dest)
    ).pipe(notify("Complied <%= file.relative %>"));
});
