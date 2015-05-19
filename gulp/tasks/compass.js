var gulp = require("gulp"),
    compass = require("gulp-compass"),
    handleErrors = require("../util/handleErrors"),
    config = require("../config").compass,
    notify = require("gulp-notify");

gulp.task("compass", function() {
    gulp.src([
        config.src + "/**/*.s*ss",
        "!" + config.src + "/common/**/*.s*ss",
        "!" + config.src + "/components/**/*.s*ss"
    ]).pipe(compass({
        config_file: config.configFile,
        sass: config.src,
        css: config.dest
    })).on("error", handleErrors).pipe(
        gulp.dest(config.dest)
    ).pipe(notify("Compiled <%= file.relative %>"))
})
