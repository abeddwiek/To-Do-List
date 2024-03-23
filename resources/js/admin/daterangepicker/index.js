import 'bootstrap-daterangepicker';

export default (function () {
    window.moment = require('moment');
    var start = moment().startOf('month').startOf('day');
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

}())
