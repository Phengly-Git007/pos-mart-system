window._ = require('lodash');

// window.Swal = require('sweetalert2');

try {
    require('bootstrap');
    require('admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js');
} catch (e) {}


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


