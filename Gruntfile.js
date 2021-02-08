
/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

module.exports = function(grunt) {

  grunt.loadNpmTasks('grunt-contrib-compress');

  var pkg = grunt.file.readJSON('package.json');

  grunt.initConfig({

    compress: {

      dist: {
        options: {
          archive: 'pkg/EhriData-'+pkg.version+'.zip'
        },
        dest: 'EhriData/',
        src: [

          '**',

          // GIT
          '!.git/**',
          '!.gitignore',

          // NPM
          '!package.json',
          '!package-lock.json',
          '!node_modules/**',

          // COMPOSER
          '!composer.json',
          '!composer.lock',
          '!vendor/phpunit/**',
          '!vendor/bin/**',

          // GRUNT
          '!.grunt/**',
          '!Gruntfile.js',

          // DIST
          '!pkg/**',

          // Editor settings
          '!*.vim',
          '!.idea',
          '!*.iml',
        ]
      }

    }

  });

  // Spawn release package.
  grunt.registerTask('package', [
    'compress'
  ]);
};
