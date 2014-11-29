var gulp = require('gulp');

var jshint = require('gulp-jshint');
var compass = require('gulp-compass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var minifyCSS = require('gulp-minify-css');
var rename = require('gulp-rename');

var inputJSDir = 'ressources/js/';
var inputSASSDir = 'ressources/sass/';
var inputCSS = 'ressources/css/';

var outputCSS = 'public/assets/css';
var outputJS = 'public/assets/js';

// Lint Task
gulp.task('lint', function() {
	return gulp.src(inputJSDir + 'app.js')
		.pipe(jshint())
		.pipe(jshint.reporter('default'));
});

// Compile SASS
gulp.task('compass', function() {
	return gulp.src(inputSASSDir + '*.scss')
	.pipe(compass({
		config_file: './config.rb',
		sass: inputSASSDir,
		css: inputCSS
	}))
	.pipe(gulp.dest(inputCSS));
});

// Concatenate and minify JS
gulp.task('scripts', function() {
	return gulp.src([
			inputJSDir + 'ripples.min.js',
			inputJSDir + 'material.min.js',
			inputJSDir + 'headroom.min.js',
			inputJSDir + 'nouislider.min.js',
			inputJSDir + 'chosen.min.js',
			inputJSDir + 'chosen-create-option.min.js',
			inputJSDir + 'app.js',
			inputJSDir + 'recipe-create-rating.js',
			inputJSDir + 'timers/preparation-time.js',
			inputJSDir + 'timers/cooking-time.js',
		])
		.pipe(concat('scripts.min.js'))
		.pipe(gulp.dest(outputJS))
		.pipe(uglify())
		.pipe(gulp.dest(outputJS));
});

// Concatenate and minify CSS
gulp.task('css', function() {
	return gulp.src([
			inputCSS + 'ripples.min.css',
			inputCSS + 'material-wfont.min.css',
			inputCSS + 'animate.css',
			inputCSS + 'chosen.css',
			inputCSS + 'app.css'
		])
		.pipe(concat('styles.min.css'))
		.pipe(gulp.dest(outputCSS))
		.pipe(minifyCSS())
		.pipe(gulp.dest(outputCSS));
});

// Watch files for changes
gulp.task('watch', function() {
	gulp.watch(inputJSDir + '*.js', ['lint', 'scripts']);
	gulp.watch(inputJSDir + '*/*.js', ['lint', 'scripts']);
	gulp.watch(inputSASSDir + '*/*.scss', ['compass']);
	gulp.watch(inputSASSDir + '*.scss', ['compass']);
	gulp.watch(inputCSS + '*.css', ['css']);
});

// Default Task
gulp.task('default', ['lint', 'compass', 'scripts', 'css', 'watch']);