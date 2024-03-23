import 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css';


export default (function () {
  $('.start-dte').datepicker();
  $('.end-date').datepicker();
  $('.datepicker').datepicker({format: 'yyyy-mm-dd'});
  $('.datepicker-future').datepicker({
      format: 'yyyy-mm-dd',
      date: new Date(),
  });
}())
