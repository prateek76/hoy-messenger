(function(){

	//var user;
	var messages = [];

	//var messages_template = Handlebars.compile($('#messages-template').html());

	function updateMessages(msg){
		messages.push(msg);
		//var messages_html = messages_template({'messages': messages});
		$('#messages').append(msg);
		$("#messages").animate({ scrollTop: $('#messages')[0].scrollHeight}, 1000);
	}

	var conn = new WebSocket('ws://localhost:8088/e');
	conn.onopen = function(e) {
	    console.log("Connection established!");
	};

	conn.onmessage = function(e) {
		//var msg = JSON.parse(e.data);
		updateMessages(e.data);
	};


	$('#join-chat').click(function(){
		user = $('#user').val();
		$('#user-container').addClass('hidden');
		$('#main-container').removeClass('hidden');

		/*var msg = {
			'user': user,
			'text': user + ' entered the room',
			'time': moment().format('hh:mm a')
		};*/
		var msg = "geekheaven";

		updateMessages(msg);
		conn.send(msg);

		$('#user').val('');
	});


	$('#send-msg').click(function(){
		var text = $('#msg').val();
		/*var msg = {
			'user': user,
			'text': text,
			'time': moment().format('hh:mm a')
		};*/
		var msg = text;
		updateMessages(msg);
		//conn.send(JSON.stringify(msg));
		conn.send(msg);
		$('#msg').val('');
	});


	$('#leave-room').click(function(){

		var msg = {
			'user': user,
			'text': user + ' has left the room',
			'time': moment().format('hh:mm a')
		};
		updateMessages(msg);
		conn.send(JSON.stringify(msg));

		$('#messages').html('');
		messages = [];

		$('#main-container').addClass('hidden');
		$('#user-container').removeClass('hidden');


	});

})();
