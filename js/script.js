var $url = window.location;
var loc = $url.origin + $url.pathname;
var url = "src/api.php";
var gameData = localStorage.getItem("gameData_" + loc);

$(document).ready(function() {	
	// Adding .active class to sidebar
	$("#menu a").each(function() {
		if (loc.indexOf($(this).attr("href")) != -1) {
			$(this).parent("li").addClass("active");
		}
	});

	// Check game is in progress or not
	checkSession();

	refresh();	

	// Toggle share widget (right side)
	$(".toggle").click(function() {
		if($(this).hasClass("open")) {
			$(this).removeClass("open");
			$(this).parent().animate({"right": "-50px"}, "slow");
		} else {
			$(this).addClass("open");
			$(this).parent().animate({"right": "0px"}, "slow");
		}
	});

	// Adding current URL to share widget
	$(".links a").each(function() {
		var $this = $(this);
		var _href = $this.attr("href");
		$this.attr("href", _href + loc);
	});

	$("button[name=close]").on("click", function(e) {
		localStorage.removeItem('gameData_' + loc);
		loadGame(false);
	});

	// Sending Player details
	$("button[name=sign]").on('click', function(e) {
		var name = $("input[name=name]").val();
		var email = $("input[name=email]").val();
		var sign = $(this).val();
		var game = gameData;

		if(game) game = game.board; 
		else {
			game = window.location.search;
			game = game.replace('?invite=', '');
		}

		if($.trim(name).length === 0) {
			$("#intro input[name=name]").css("border-color", "red");
			$("#intro input[name=name]").focus();
			return;
		}

		if($.trim(email).length === 0) {
			$("#intro input[name=email]").css("border-color", "red");
			$("#intro input[name=email]").focus();
			return;
		} 
		
		var data = {
					name: name,
					email: email,
					sign: sign,
					board: game,
					func: "create_game"
				};

		var x = ajax(url, data);

		x.done(function(data) {
			var gameData = {
						'board' : data.board,
						'sign' : data.sign
					};

			localStorage.setItem('gameData_' + $url.origin + $url.pathname, JSON.stringify(gameData));
			
			window.location.href = loc;
		}).fail(function(error) {
			console.log('error ' + error);
		});		
	});

	// Send Mail
	$("#options button").on('click', function(e) {
		var $mail = $("#options input[type=text]");
		var game = JSON.parse(gameData);
		var link = loc + "?invite=" + game.board;

		var data = {
					email: $mail.val(),
					board: link,
					func: "send_mail"
				};

		var x = ajax(url, data);

		x.done(function(data) {
			$mail.val('');
		}).fail(function(error) {
			console.log(error);
		});
	});

	$("#board button").on("click", function(e) {
		var game = JSON.parse(gameData);

		var moves = $("#board button").not('.empty').length;

		$(this).html(game.sign);
		$(this).removeClass('empty');

		var data = {
					board: game.board,
					cell: $(this).attr('id'),
					sign: game.sign,
					moves: moves,
					func: 'tic_tac_toe'
				};

		$("#board button").attr('disabled', true);
		$("#board button").css('cursor', 'not-allowed');

		var x = ajax(url, data);

		x.done(function(data) {
			if(data.msg == 'X' || data.msg == 'O' || data.msg == 'Tie') showResult(data.msg);
		}).fail(function(error) {
			console.log('error: ' + error);
		});		
	});
});


function loadGame(flag) {
	flag = typeof flag !== 'undefined' ? flag : true;

	if (flag) {
		$("#intro").addClass('hidden');
		$("#board").removeClass('hidden');
		$("#options").removeClass('hidden');
		$(".right-sidebar").removeClass('hidden');
		$(".game").css('width', $('.game').width() - 250 + "px");

		var game = JSON.parse(gameData);

		$("#options input[name=email]").val($url.origin + $url.pathname + "?invite=" + game.board);

		if(!game.sign) {
			$("#board button").attr('disabled', true);
			$("#board button").css('cursor', 'not-allowed');
		}

		getPlayers();
		getMoves();
	} else {
		window.location.href = loc;
	}
}

function showResult(msg) {
	$("#board table").addClass('hidden');
	$('#board div.show_result').removeClass('hidden');

	if(msg == 'X') msg = 'X Wins!';
	if(msg == 'O') msg = 'O Wins!';
	if(msg == 'Tie') msg = 'Tie!';
	
	$('#board div.show_result>p').text(msg);
}

function getPlayers() {
	var board = JSON.parse(gameData);
	
	var data = {
				board: board.board,
				func: 'get_players'
			};

	var x = ajax(url, data);

	var users = '', spectators = '';

	x.done(function(data) {
		data.users.forEach(function (user) {
			if(typeof user.name === 'undefined') user.name = '';
			if(user.sign == null) user.sign = '';

			var active = '';

			if(user.sign == user.play)
				active = "<i class='fa fa-caret-right'></i>";

			if(user.name != '' && user.sign != '' && user.flag == 1)
				users += "<p class='list'>" + active + user.name + " (" + user.sign + ")</p>";
			else
				spectators += "<p class='list'>" + user.name + "</p>";
		});

		$("#users").html(users);
		$("#spectators").html(spectators);
	});
}

function getMoves() {
	var game = JSON.parse(gameData);
	
	var data = {
				board: game.board,
				func: 'get_moves'
			};

	var x = ajax(url, data);

	x.done(function(data) {
		if(data.msg == 'X' || data.msg == 'O' || data.msg == 'Tie') {
			showResult(data.msg);
			return;
		}

		for(var value in data.moves){
			$("button#" + value).html(data.moves[value]);
			if(data.moves[value])
				$("button#" + value).removeClass('empty');
		}

		if(data.moves.play == game.sign) {
			$("#board button").removeAttr('disabled');
			$("#board button").css('cursor', 'pointer');
		} else {
			$("#board button").attr('disabled', true);
			$("#board button").css('cursor', 'not-allowed');
		}

		$("#board button").not('.empty').attr('disabled', true).css('cursor', 'not-allowed');
	});
}

function checkSession() {
	var data = gameData;

	if(data) {
		loadGame();
	} else {
		$("#intro").removeClass('hidden');
	}		
}

function ajax(url, data, type) {
	type = typeof type !== 'undefined' ? type : "POST";

	var promise = $.ajax({
		url: url,
		data: data,
		type: type,
		dataType: "json"
	});

	return promise;
}

function refresh(sec) {
	sec = typeof sec !== 'undefined' ? sec : 3;

	if(gameData) {
		setInterval(function() {
			getPlayers();
			getMoves();
		}, sec * 1000);
	}
}

function notification() {

}
