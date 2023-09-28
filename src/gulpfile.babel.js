const gulp = require('gulp');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const sass = require('gulp-sass')(require('sass'));
const cssnano = require('cssnano');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const cssMinify = require('gulp-css-minify');
const browserSync = require('browser-sync').create();
const webpack = require('webpack-stream');
const TerserPlugin = require('terser-webpack-plugin');
const yargs = require('yargs');

const PRODUCTION = yargs.argv.prod;

function style() {
	let plugins = [
		cssnano(),
		autoprefixer()
	];
	return gulp.src('./assets/scss/**/*.scss')
		.pipe(sass())
		.pipe(postcss(plugins))
		.pipe(gulp.dest('./assets/css'))
}

function cssBundle(){
	return gulp.src(
		['./assets/css/assets.css','./assets/css/style.css']
	)
		.pipe(concat('style.css'))
		.pipe(cssMinify())
		.pipe(gulp.dest('dist/css/'))
}

function scripts() {
  return gulp.src('./assets/js/main.js')
    .pipe(webpack({
			mode: !PRODUCTION ? 'development' : 'production',
				module: {
					rules: [
						{
							test: /\.js$/,
							use: {
								loader: 'babel-loader',
								options: {
									presets: ['@babel/preset-env'],
								}
							}
						}
					]
					},
					optimization: {
						minimize: true,
						minimizer: [new TerserPlugin({
								terserOptions: {
										format: {
												comments: false,
										},
								},
								extractComments: false,
						})],
					},
					output: {
						filename: '[name].js'
					},
					externals: {
						jquery: 'jQuery'
					},
				}))
		.pipe(uglify())
    .pipe(gulp.dest('dist/js'));
}

function watch(cb) {
	browserSync.init({
		proxy: "http://localhost:8888",
		notify: false
	});
	gulp.watch('./assets/scss/**/*.scss', style);
	gulp.watch('./assets/css/*.css', cssBundle);
	gulp.watch('./dist/css/*.css').on('change',browserSync.reload);
	gulp.watch('./assets/js/**/*.js', scripts);
	gulp.watch('./dist/js/*.js').on('change',browserSync.reload);
	gulp.watch('**/*.php').on('change',browserSync.reload);
	gulp.watch('../**/*.php').on('change',browserSync.reload);

	cb();
}



exports.cssBundle = cssBundle;
exports.style = style;
exports.scripts = scripts;
exports.watch = watch;