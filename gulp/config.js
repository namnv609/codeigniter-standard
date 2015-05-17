var dest = "./public",
    src = "./src";

module.exports = {
    compass: {
        src: src + "/sass",
        dest: dest + "/css",
        configFile: src + "/sass/config.rb",
        get watch() {
            return this.src + "/**/*.sass"
        }
    },
    coffee: {
        src: src + "/coffee",
        dest: dest + "/js",
        get watch() {
            return this.src + "/**/*.coffee"
        }
    }
}