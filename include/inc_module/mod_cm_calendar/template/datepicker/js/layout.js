(function($){
	var initLayout = function() {

		$('#date1').DatePicker({
			flat: true,
			date: '2008-07-31',
			current: '2009-07-31',
			calendars: 1,
			starts: 1,
			view: 'years'
		});
		var now = new Date();
		now.addDays(-10);
		var now2 = new Date();
		now2.addDays(-5);
		now2.setHours(0,0,0,0);
		$('#date2').DatePicker({
			flat: true,
      date: $('#cm_events_date').val(),
	    current: $('#cm_events_date').val(),
			format: 'Y-m-d',
			calendars: 1,
			mode: 'single',
			onChange: function(formated, dates) {
			 $('#cm_events_date').val(formated);
			},
			starts: 1
		});

		$('#daily_until').DatePicker({
			format:'Y-m-d',
			date: $('#daily_until').val(),
			current: $('#daily_until').val(),
			starts: 1,
			position: 'right',
			mode: 'single',
			onBeforeShow: function(){
				$('#daily_until').DatePickerSetDate($('#daily_until').val(), true);
			},
			onChange: function(formated, dates){
				$('#daily_until').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#daily_until').DatePickerHide();
				}
			}
		});

	};
	
	EYE.register(initLayout, 'init');
})(jQuery)