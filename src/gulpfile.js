"use strict";

// Load plugins
const gulp = require("gulp");
const concat = require("gulp-concat");
const sass = require("gulp-sass");
const autoprefixer = require("gulp-autoprefixer");
const terser = require('gulp-terser');


//
// Watch SCSS.
function watchFiles() 
{
    gulp.watch(["./resources/stylesheets/**/*.scss"], cssTask);
}

// 
// Compile SCSS to CSS
function cssTask()
{
    return gulp
        .src("./resources/stylesheets/app.scss")
        .pipe(sass({
            outputStyle: "compressed"
        }).on("error", sass.logError))
        .pipe(autoprefixer({
            browsers: ["last 2 versions"]
        }))
        .pipe(gulp.dest("./public/assets/css/"));
}


// 
// Clears out any things we shouldn't have in js files
function compileJsTask()
{
    return gulp.src([
        './resources/js/.js',
    ])
        .pipe(terser({
            output: {
                comments: false,
            },
            compress: {
                drop_console: true,
            },
        }))
        .pipe(gulp.dest('./public/assets/js'));
}

const defaultTask = gulp.series(
    cssTask,
    // compileJsTask
    watchFiles
);

const buildTask = gulp.series(
    cssTask,
    // compileJsTask
);


// Default task when calling gulp
exports.default = defaultTask;
exports.build = buildTask;