"use strict";

const cleanCSS = require("gulp-clean-css");
const gulp = require("gulp");
const plumber = require("gulp-plumber");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const uglify = require('gulp-uglify');
const notify = require('gulp-notify');
const babel = require('gulp-babel');

// CSS task
function css() {
  return gulp
    .src("./source/sass/**/*.scss")
    .pipe(plumber({errorHandler: errorStyles}))
    .pipe(sass({
      outputStyle: "expanded",
      includePaths: "./node_modules",
    }))
    .on("error", sass.logError)
    .pipe(gulp.dest("./web/css"))
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest("./web/css"))
}

function js() {
  return gulp
    .src('./source/javascript/**/*.js')
    .pipe(babel())
    .pipe(plumber({errorHandler: errorScripts}))
    .pipe(gulp.dest('./web/js'))
    .pipe(uglify())
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(gulp.dest("./web/js"))
}

// Watch files
function watchFiles() {
  gulp.watch(["./source/sass/**/*"], css);
}

function watchJs() {
  gulp.watch(["./source/javascript/**/*"], js);
}

function errorStyles(error) {
  notify.onError({
    title: "Sass Error",
    message: "",
    sound: "Sosumi"
  })(error);
  console.log(error.toString());
  this.emit("end");
};

function errorScripts(error) {
  notify.onError({
    title: "JS Error",
    message: "", sound: "Sosumi"
  })(error);
  console.log(error.toString());
  this.emit("end");
};

// Define complex tasks
// const vendor = gulp.series(clean, modules);
const build = gulp.series(css, js);
const watch = gulp.series(build, gulp.parallel(watchFiles, watchJs));

// Export tasks
exports.css = css;
exports.js = js;
// exports.clean = clean;
// exports.vendor = vendor;
exports.build = build;
exports.watch = watch;
exports.default = build;