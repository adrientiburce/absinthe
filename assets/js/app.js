/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

require('../js/components/Course/course.scss');
require('../js/components/CourseList/courseList.scss');
require('../js/components/CourseSmall/courseSmall.scss');

// IMAGE :
require('../img/logo.jpg');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.


// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything

require('bootstrap');
// require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

$(document).ready(function(){
    console.log("Script working properly");
});
