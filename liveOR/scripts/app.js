function send() {
	
	if (hall == 'C1') {
		hall = 'C2';
	} else {
		hall = 'C1';
	}
	
	ajax();
}

function ajax() {
	$.ajax({
		url: 'data.php',
		type: 'get',
		success: function(response) {
			$('#data').load('data.php?roomName=' + hall);
			$('#header').html('<h1>SAAL ' + hall + '</h1>');
		}
	});
}

hall = 'C1';
ajax();

$(document).ready(function() {
	setInterval(send, 20000);
});