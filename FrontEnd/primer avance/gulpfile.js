const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');

// Rutas
const paths = {
  scss: 'src/scss/**/*.scss',
  js: 'src/js/**/*.js',
  html: './*.html'
};

/* SCSS -> CSS
gulp.task('styles', () => {
  return gulp.src(paths.scss)
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(cleanCSS())
    .pipe(gulp.dest('build/css'));
});
*/
gulp.task('styles', function () {
    return gulp.src('src/scss/app.scss') // <-- Only compile app.scss
      .pipe(sass().on('error', sass.logError))
      .pipe(autoprefixer())
      .pipe(cleanCSS())
      .pipe(gulp.dest('build/css'));
  });

// Minificar JS
gulp.task('scripts', () => {
  return gulp.src(paths.js)
    .pipe(concat('main.js'))
    .pipe(uglify())
    .pipe(gulp.dest('build/js'));
});

// Copiar HTML (opcional)
gulp.task('html', () => {
  return gulp.src(paths.html)
    .pipe(gulp.dest('build'));
});

// Tarea por defecto
gulp.task('default', gulp.parallel('styles', 'scripts', 'html'));