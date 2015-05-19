var dest = "./public",
    src = "./src";

module.exports = {
    compass: {
        src: src + "/sass",
        dest: dest + "/css",
        configFile: src + "/sass/config.rb",
        get watch() {
            return this.src + "/**/*.s*ss"
        }
    },
    coffee: {
        src: src + "/coffee",
        dest: dest + "/js",
        get watch() {
            return this.src + "/**/*.coffee"
        }
    },
    less: {
        src: src + "/less",
        dest: dest + "/css",
        get watch() {
            return this.src + "/**/*.less"
        }
    }
}
