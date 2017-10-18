
function onLoadMeetingDates(){
	var xhttp = new XMLHttpRequest(),
		mmp = document.getElementById('magis_meeting_project'),
		mmd = document.getElementById('magis_meeting_date');

	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			var data = JSON.parse(xhttp.responseText);
			if(this.status == 200) {
				var options = '';
				data.forEach(function(item) {
					options = options + '<option value="' + item.id + '">' + item.dia + ' - ' + item.periodo + '</option>';
				}, this);;
				mmd.innerHTML = options;
			}
		}
	};
	xhttp.open("GET", "/wp-json/magis/v1/cronograma-citas/" + mmp.value, true);
	xhttp.send();
}

document.addEventListener('DOMContentLoaded', function(){
	var mmp = document.getElementById('magis_meeting_project');

	if(mmp) {
		mmp.addEventListener('change', onLoadMeetingDates);
		onLoadMeetingDates();
	}	
});
