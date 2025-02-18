const gulp = require('gulp');
const browserSync = require('browser-sync').create();

// Task to start BrowserSync
function browserSyncTask() {
    browserSync.init({
        proxy: "http://localhost/tesac", // Change this to your local WP URL
        files: [
            'style.css', // Add other files you want to watch, like your theme's JS files
            '**/*.php',
            '**/*.css',
        ],
        browser: 'google chrome', // Choose your preferred browser
        open: false, // Set to true if you want BrowserSync to auto-open the browser
        notify: false, // Disable on-screen notifications (optional)
    });
}

// Task to watch files and reload BrowserSync on changes
function watchFiles() {
    gulp.watch('**/*.php', browserSync.reload); // Watch for changes in PHP files
    gulp.watch('**/*.css', browserSync.reload); // Watch for changes in CSS files
    gulp.watch('**/*.js', browserSync.reload); // Watch for changes in JS files
}

// Default task that runs both the browserSync and watch tasks
gulp.task('default', gulp.parallel(browserSyncTask, watchFiles));
