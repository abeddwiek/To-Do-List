import moment from "moment";
import 'tempusdominus-bootstrap';

export default (function () {
    var startTime = moment().hours(9).startOf('hour');
    var endTime = moment().hours(12).startOf('hour');

    $('.datetimepicker').datetimepicker();

    $('.startTimeInline').datetimepicker({
        format: 'LT',
        inline: true,
        sideBySide: true,
        defaultDate : startTime
    });

    $('.endTimeInline').datetimepicker({
        format: 'LT',
        inline: true,
        sideBySide: true,
        defaultDate : endTime
    });

    $('.startTime').datetimepicker({
        format: 'LT',
        defaultDate : startTime
    });

    $('.endTime').datetimepicker({
        format: 'LT',
        defaultDate : endTime
    });

}())
