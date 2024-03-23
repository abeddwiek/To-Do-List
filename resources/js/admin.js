import './bootstrap';
window.jQuery = window.$ = $
import * as bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min';
import  'startbootstrap-sb-admin-2/js/sb-admin-2.min';
import 'datatables.net-bs4/js/dataTables.bootstrap4.min'
import 'startbootstrap-sb-admin-2/vendor/datatables/dataTables.bootstrap4.min'
import './admin/moment'
import 'daterangepicker/daterangepicker'
import './admin/bootbox/index'
import './admin/datepicker/index'
import './admin/bootstrap4-toggle/index'
import 'datatables.net-buttons/js/buttons.print'
import 'datatables.net-responsive-bs4/js/responsive.bootstrap4.min'
import 'startbootstrap-sb-admin-2/vendor/chart.js/Chart.min'
import moment from "moment";

import select2 from 'select2';
select2();
$("select:not(.not-select2)").select2({  theme: 'bootstrap4'});


window.moment = moment;
var start = moment().startOf('day');
var end = moment().endOf('day');

function cb(start, end) {
    //$('.range-element span').html('')
}

$('.range-element').daterangepicker({
    "timePicker": true,
    "timePicker24Hour": true,
    startDate: start,
    endDate: end,
    ranges: {
        'Today': [moment().startOf('day'), moment().endOf('day')],
        'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
        'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
        'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
        'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf('day')],
        'Last Month': [moment().subtract(1, 'month').startOf('month').startOf('day'), moment().subtract(1, 'month').endOf('month').endOf('day')],
        'Last Year': [moment().subtract(1, 'Year').startOf('Year').startOf('month').startOf('day'), moment().subtract(1, 'Year').endOf('Year').endOf('month').endOf('day')],
        'This Year': [moment().startOf('Year').startOf('month').startOf('day'), moment().endOf('month').endOf('day')],
        'All Time': [moment().subtract(20, 'Year').startOf('Year').startOf('month').startOf('day'), moment().endOf('day')]

    },
    locale: {
        format: 'Y-MM-DD HH:mm:ss'
    }
}, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
}, cb);

$(".nav-pills").find("li a").first().click();

var url = document.URL;
var hash = url.substring(url.indexOf('#'));

$(".nav-pills").find("li a").each(function(key, val) {

    if (hash == $(val).attr('href')) {

        $(val).click();

    }
    $(val).click(function(ky, vl) {

        console.log($(this).attr('href'));
        location.hash = $(this).attr('href');
    });

});
