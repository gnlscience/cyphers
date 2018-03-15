//VENDOR START
import 'babel-polyfill';
import 'jquery';
import 'jquery-ui';
import 'foundation-sites/dist/js/foundation';
import 'angular';
import 'angular-sanitize';
import 'angular-animate';
import 'angular-no-captcha';
import 'angucomplete-alt';
import 'ng-infinite-scroll';
import 'ngstorage';
import 'angular-formly';
import 'angular-toastr';
import 'api-check';
//VENDOR END

//VENDOR CSS START
require('../css/_settings.scss');
require('../css/foundation.scss');
//require('foundation-sites/assets/foundation.scss');
require('font-awesome/css/font-awesome.css');
require('angular-toastr/dist/angular-toastr.css');
require('angucomplete-alt/angucomplete-alt.css');
//VENDOR CSS END

//CSS START
//require('../css/foundation.css');
require('../css/sanco.scss');
require('../css/comments.scss');

//CSS END

//JS START
//import './default';
import './app';
//JS END
