function send() {
	
	if (hall == 'A') {
		hall = 'B';
	} else if (hall == 'B') {
		hall = 'F';
	} else {
		hall = 'A';
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

hall = 'A';
ajax();

$(document).ready(function() {
	setInterval(send, 20000);
});