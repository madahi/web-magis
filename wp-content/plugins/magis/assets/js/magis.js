
function onLoadMeetingDates(){
	var xhttp = new XMLHttpRequest(),
		mmp = document.getElementById('magis_meeting_project'),
		mms = document.getElementById('magis_meeting_schedule');

	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			var data = JSON.parse(xhttp.responseText);
			if(this.status == 200) {
				var options = '';
				data.forEach(function(item) {
					options = options + '<option value="' + item.id + '">' + item.dia + ' de ' + item.hora_inicio + ' a ' + item.hora_fin + '</option>';
				}, this);
				mms.innerHTML = options;
			}
		}
	};
	xhttp.open("GET", "/wp-json/magis/v1/cronogramas-citas/project_id=" + mmp.value, true);
	xhttp.send();
}

document.addEventListener('DOMContentLoaded', function(){
	var mmp = document.getElementById('magis_meeting_project');

	if(mmp) {
		mmp.addEventListener('change', onLoadMeetingDates);
		onLoadMeetingDates();
	}	
});
