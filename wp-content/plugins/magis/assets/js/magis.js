
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


function onLoadClientData(e) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(this.readyState == 4) {
			var data = JSON.parse(xhttp.responseText);
			if((this.status == 200) && (data.client)) {
				document.getElementById('magis_meeting_uname').value = data.client.nombre;
				document.getElementById('magis_meeting_uphone').value = data.client.telefono;
				document.getElementById('magis_meeting_ucity').value = data.client.ciudad;
			} else {
				document.getElementById('magis_meeting_uname').value = '';
				document.getElementById('magis_meeting_uphone').value = '';
			}
		}
	};
	xhttp.open("GET", "/wp-json/magis/v1/clientes/ver/client_ci=" + e.target.value, true);
	xhttp.send();
}


function onFilterClientMeetings() {
	var mmcci = document.getElementById('magis-meeting-client-ci');
	if(mmcci.value) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if(this.readyState == 4) {
				var data = JSON.parse(xhttp.responseText),
					mcmr = document.getElementById('magis-client-meetings-rows'),
					rows = '';

				if((this.status == 200) && (data.meetings)) {
					data.meetings.forEach(function(item) {
						rows = rows +
							'<td>' + item.proyecto + '</td>' +
							'<td>' + item.estado + '</td>' +
							'<td>' + item.dia + '</td>' +
							'<td>' + item.hora_inicio + '</td>' +
							'<td>' + item.hora_fin + '</td>' +
							'<td>' + item.fecha_creacion + '</td>';
					}, this);
				}
				mcmr.innerHTML = rows;
			}
		};
		xhttp.open("GET", "/wp-json/magis/v1/citas/buscar-de-cliente/client_ci=" + mmcci.value, true);
		xhttp.send();
	}
}

document.addEventListener('DOMContentLoaded', function(){
	var mmp = document.getElementById('magis_meeting_project');
	if(mmp) {
		mmp.addEventListener('change', onLoadMeetingDates);
		onLoadMeetingDates();
	}


	var mmuci = document.getElementById('magis_meeting_uci');
	if(mmuci) {
		mmuci.addEventListener('change', onLoadClientData);
	}


	var mmfbtn = document.getElementById('magis-meeting-filter-btn');
	if(mmfbtn) {
		mmfbtn.addEventListener('click', onFilterClientMeetings);
	}
});
