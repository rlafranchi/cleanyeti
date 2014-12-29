// FOUNDATION FOR APPS TEMPLATE GULPFILE
// -------------------------------------
// This file processes all of the assets in the "client" folder, combines them with the Foundation
// for Apps assets, and outputs the finished files in the "build" folder as a finished app.

// 1. LIBRARIES
// - - - - - - - - - - - - - - -

var gulp           = require('gulp'),
    runSequence    = require('run-sequence'),
    sass           = require('gulp-ruby-sass'),
    path           = require('path');

// 2. SETTINGS VARIABLES
// - - - - - - - - - - - - - - -

// Sass will check these folders for files when you use @import.
var sassPaths = [
  'library/Foundation/scss',
];

// 3. TASKS
// - - - - - - - - - - - - - - -


// Copies user-created files and Foundation assets
gulp.task('copy', function() {
  // modernizr and foundation
  return gulp.src(['./bower_components/bower-foundation/js/foundation.min.js', './bower_components/bower-foundation/js/vendor/modernizr.js'])
        .pipe(gulp.dest('library/Foundation/js/'));
});

gulp.task('copy-js', function() {
  return gulp.src(['./bower_components/bower-foundation/js/foundation/**/*.js'])
        .pipe(gulp.dest('library/Foundation/js/foundation/'));
});

gulp.task('copy-sass', function() {
  return gulp.src(['./bower_components/bower-foundation/scss/**/*.scss'])
        .pipe(gulp.dest('library/Foundation/scss/'));
});

// Compiles Sass
gulp.task('sass', function() {
  return gulp.src('library/Foundation/scss/cleanyeti-app.scss')
    .pipe(sass({
      loadPath: sassPaths,
      style: 'compressed',
      bundleExec: true
    }))
    .on('error', function(e) {
      console.log(e);
    })
    .pipe(gulp.dest('./library/Foundation/css/cleanyeti-default.css'));
});

gulp.task('sass-preview', function() {
  return gulp.src('library/Foundation/scss/cleanyeti-app-preview.scss')
    .pipe(sass({
      loadPath: sassPaths,
      style: 'compressed',
      bundleExec: true
    }))
    .on('error', function(e) {
      console.log(e);
    })
    .pipe(gulp.dest('./library/Foundation/css/cleanyetipreview.css'));
});


// Builds your entire app once, without starting a server
gulp.task('build', function() {
  runSequence('copy-sass', ['copy-js', 'copy', 'sass', 'sass-preview'], function() {
    console.log("Successfully built.");
  })
});

// Default task: builds your app, starts a server, and recompiles assets when they change
gulp.task('default', ['build'], function() {
  // Watch Sass
  gulp.watch(['./library/Foundation/scss/**/*'], ['sass']);
});
