//is user session null dont show any data

//dynamic css rules
/***
/**
/*Dynamic css rules
/******/
//throw messaeg se ajax call hatao
	//var user;
	var messages = [];

	//var messages_template = Handlebars.compile($('#messages-template').html());

	//function to push thrownmesssage
	function updateMessagesCLI(msg){
		messages.push(msg);
		console.log(msg);
		if(msg['message'] != "")
		//var messages_html = messages_template({'messages': messages});
		//$('.mess_age_s').append('<div style="width:100%;height: 100%;background: red;">'+msg["message"]+'</div>');
		$('.chat_conn .mess_age_s').append("<div class='info-current' data-target='#reactnow' id='' data-toggle='modal'>"+msg['message']+"</div>");
	}
	function updateMessages(msg){
		messages.push(msg);
		console.log(msg);
		if(msg['message'] != "")
		//var messages_html = messages_template({'messages': messages});
		//$('.mess_age_s').append('<div style="width:100%;height: 100%;background: red;">'+msg["message"]+'</div>');
		$('.chat_conn .mess_age_s').append("<div class='parent-info showonscroll'><div class='info' data-target='#reactnow' id='' data-toggle='modal'>"+msg['message']+"</div></div>");
	}

	var conn = new WebSocket('ws://localhost:8080/');
	conn.onopen = function(e) {
	    console.log("Connection established!");
	};

	conn.onmessage = function(e) {
		var msg = JSON.parse(e.data);
		updateMessages(msg);
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

		updateMessages(JSON.stringify(msg));
		conn.send(msg);

		$('#user').val('');
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



var open_men;
var open_men_clicked;

/*var conn = new WebSocket('ws://localhost:8088/e');
conn.onopen = function(e) {
    console.log("Connection established!");
};*/

$( document ).on('click','.menubt', function(){
  $('.menuwillopen').css({'display': 'block','transition': 'all ease-in-out 2000ms'});
  open_men=12;
});

$(document).on('click','.menuwillopen',function(){
    open_men_clicked = 1000;
    setTimeout(function(){ $('.menuwillopen').css({'display': 'none','transition': 'all ease-in-out 2000ms'}) },2000);
    $('.stopper').hide('fast');
  });

$(document).click(function(){
  if(open_men_clicked == 1000){
    open_men_clicked = 0;
  }
  else if(open_men != 12){
    $('.menuwillopen').css('display','none');
  } else {
    open_men = 0;
    open_men_clicked = 0;
  }
});

$(document).on('click', '.grnew', function() {
  $('.users').hide();
  $('.showmygrp').hide();
  $('.testicle').hide();
  //$('.gr').css({'display': 'block','transition': 'all ease-in-out 600ms'});
  $('.gr').show("slide", { direction: "left" }, 150);//ui
});

$(document).on('click','.Groups',function() {
  $('group_details').hide();
  $('.gr').hide();
  $(this).css({'transition': 'all ease-in-out 100ms'});
  $('group_details').hide();
  $('.Freinds').css({'border-bottom':'none','transition': 'all ease-in-out 100ms'});
  $('.users').css('display','none');
  $('group_details').hide();
  $('.showmygrp').show("slide", { direction: "left" }, 150);
  chat.groupsshow();
  $('.users').hide();
  $('group_details').hide();
  //chat.groupsshow();
});

$(document).on('click','.Freinds',function() {
  $('group_details').hide();
  $('.gr').hide();
  $(this).css({'transition': 'all ease-in-out 100ms'});
  $('.Groups').css({'border-bottom':'none','transition': 'all ease-in-out 100ms'});
  $('.showmygrp').hide();
  //$('.users').show();
  $('.users').show("slide", { direction: "left" }, 150);
});

$(document).on('click','.testicle',function() {
  $('.gr').hide();
  $(this).css({'transition': 'all ease-in-out 100ms'});
  $('.Groups').css({'border-bottom':'none','transition': 'all ease-in-out 100ms'});
  $('.showmygrp').hide("slide", { direction: "left" }, 150);
  //$('.users').show();
  $('.users').hide("slide", { direction: "left" }, 150);
  $('group_details').show('slide', {direction: 'right'}, 150);
});










/********C*O*R*E*F*U*N*C*T*I*O*N*S***********/

var chat = {}

var send_id = null;
var fetch_met = "fetch";

$(document).on('click', '.user_unique', function() {
      $('.gr').css('display','none');
      send_id = $(this).attr("user_unique_id");
      localStorage.setItem("test_sendid",send_id);
      var name = $(this).attr("data-userName");
      $('.to').text(name);
      $('.to').parent().attr('href',"http://localhost/localchatwa/letschatoneonone/user_profile/user_profile.php?@id="+name);
      chat.fetchMessages();
      chat.change_to_zero();
      $('.testicle').remove();
      if(send_id.val != '')
        $('.chat_conn').show();
      $('.testicle').remove();
      chat.viewmessageoffline();
      chat.scrolltobottom();
});

//group ke liye
$(document).on('click', '.Usar_grp', function() {
      $('.gr').css('display','none');
      send_id = $(this).attr("data-@gid");
      sendg_name = $(this).attr("data-@gname");
      localStorage.setItem("test_grpid",send_id);
      localStorage.setItem("test_grpname",sendg_name);
      $('.to').text(sendg_name);
      chat.fetchMessages();
      chat.change_to_zero();
      if(send_id.val != '')
        $('.chat_conn').show();
        $('.testicle').remove();
        $('.to_name').append('<div class="testicle" style="float: right;font-size: 24px;margin: 0;">  <a class="btn-floating btn-small waves-effect waves-light grey"><i class="material-icons">add</i></a></div>');
      chat.viewmessageofflineGRP();
});
$(document).on('click','.testicle', function() {
    $('.fill_groupname').text(sendg_name);
});

$(document).on('click', '.close-it', function() {
     $('.chat_conn').hide();
});

$(document).on('click','.goandlogin', function(){
    chat.userinfo();
    window.location.href = "http://localhost/localchatwa/letschatoneonone/chatbox.php";
});

$(document).on('click','.getout', function(){
    localStorage.clear();
});

$(document).on('click','.info', function(){
  var __messid__ = $(this).children('.__messid__').val();
  var __userid__ = $(this).children('.__userid__').val();
  var __sendid__ = $(this).children('.__sendid__').val();
  var __tampid__ = $(this).children('.__tampid__').val();
  console.log(__messid__+"_____"+__tampid__+"$$$_____$$$"+__sendid__+"_____"+__userid__);
  localStorage.setItem("__reaction__current__val1__",__messid__);
  localStorage.setItem("__reaction__current__val2__",__tampid__);

});

$(document).on('click','.info-single', function(){
  var __messid__ = $(this).children('.__messid__').val();
  var __userid__ = $(this).children('.__userid__').val();
  var __sendid__ = $(this).children('.__sendid__').val();
  var __tampid__ = $(this).children('.__tampid__').val();
  console.log(__messid__+"_____"+__tampid__+"$$$_____$$$"+__sendid__+"_____"+__userid__);
  localStorage.setItem("__reaction__current__val1__",__messid__);
  localStorage.setItem("__reaction__current__val2__",__tampid__);

});

$(document).ready(function(){
    if (send_id == null) {
        $('.chat_conn').hide();
    } else {
        $('.chat_conn').show();
    }
    chat.getusers();
    chat.showusers();
		chat.userinfo();
});

chat.userinfo = function () {
    $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'userinfo'},
        success: function(data) {
            localStorage.setItem("__user_id__sess__",data);
        }
    })
}

//method 1 fetch message
chat.getusers = function () {
    $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'users'},
        success: function(data) {
            console.log(data);
            if(data != 'there are no users')
            localStorage.setItem("user__friends",data);
        }
    })
}

chat.showonlineusers = function () {
    $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'online_users'},
        success: function(data) {
            $('.all_online_users').html(data);

        }
    })
}

chat.fetchMessages = function () {//ajax method using jQuery
    if (send_id == null) {
      return;
    }
    if(send_id.length == 20) {
       fetch_met = "fetchGRP";
    } else {
      fetch_met = "fetch";
    }
    console.log("ffg"+fetch_met);
    $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: fetch_met,send_id: send_id},
        success: function(data) {
          localStorage.setItem("store"+send_id,data);//local storage name will be variable
        }
    });
}

var prevStatemess = "";

chat.viewmessageoffline = function () {
      if(send_id == null)
        return;
      if(send_id.length == 20) {
        chat.viewmessageofflineGRP();
        return;
      }

      if(localStorage.getItem("store"+send_id) != prevStatemess) {
      $('.chat_conn .mess_age_s').html("");
      var me = localStorage.getItem("store"+send_id);
          prevStatemess = localStorage.getItem("store"+send_id);
          if(me == "There are currently no messages") {
            return;
          }
          me = JSON.parse(me);
          console.log(me);

          $.each(me, function(k, v) {
            str = JSON.stringify(v.message).replace(/^"(.*)"$/, '$1');
            if(v.reacted == null){
                var __xl = JSON.stringify("fas fa-bullseye");
              } else if (v.reacted == "1") {
                var __xl = JSON.stringify("fas fa-thumbs-up");
              } else if (v.reacted == "2") {
                var __xl = JSON.stringify("fas fa-thumbs-down");
              } else if (v.reacted == "3") {
                var __xl = JSON.stringify("far fa-smile");
              } else if (v.reacted == "4") {
                var __xl = JSON.stringify("fas fa-frown");
              } else if (v.reacted == "5") {
                var __xl = JSON.stringify("fas fa-heart");
              }
            if(localStorage.getItem("__user_id__sess__") == parseInt(v.user_id)){
              if(v.reacted != null){
                $('.chat_conn .mess_age_s').append("<div style='margin-bottom:32px' class='info-current'>"+str+"<div class='banaochu'><i class="+__xl+"></i></div></div>");
                $('.chat_conn .mess_age_s').append("<br>");
            } else {
                $('.chat_conn .mess_age_s').append("<div class='info-current'>"+str+"</div>");
                $('.chat_conn .mess_age_s').append("<br>");
            }

            } else {
              if(v.reacted != null){
                $('.chat_conn .mess_age_s').append("<div class='info-single' style='margin-bottom:32px' data-target='#reactnow' id='' data-toggle='modal'><input id='__messid__' class='__messid__' type='hidden' value="+v.message_id+"><input id='__userid__' class='__userid__' type='hidden' value="+v.user_id+"><input id='__sendid__' class='__sendid__' type='hidden' value="+v.send_id+"><input id='__tampid__' class='__tampid__' type='hidden' value="+v.timestamp+">"+str+"<div class='banaochu'><i class="+__xl+"></i></div></div>");
                $('.chat_conn .mess_age_s').append("<br>");
            } else {
                $('.chat_conn .mess_age_s').append("<div class='info-single' data-target='#reactnow' id='' data-toggle='modal'><input id='__messid__' class='__messid__' type='hidden' value="+v.message_id+"><input id='__userid__' class='__userid__' type='hidden' value="+v.user_id+"><input id='__sendid__' class='__sendid__' type='hidden' value="+v.send_id+"><input id='__tampid__' class='__tampid__' type='hidden' value="+v.timestamp+">"+str+"</div>");
                $('.chat_conn .mess_age_s').append("<br>");
            }
            }
          });
              $('.chat_conn .mess_age_s').append('<div class="modal fade" id="reactnow" tabindex="-1" role="dialog" aria-labelledby="react" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-body"><ul class="react-menu-ul"><li class="close react-menu-ul-li thumbs-up" data-dismiss="modal" aria-label="Close" message_alt_id="" message_id=""><i class="fas fa-thumbs-up tu"></i></li><li class="react-menu-ul-li thumbs-down close" data-dismiss="modal" aria-label="Close" message_alt_id="" message_id=""><i class="fas fa-thumbs-down td"></i></li><li class="react-menu-ul-li smile close" data-dismiss="modal" aria-label="Close" message_alt_id="" message_id=""><i class="far fa-smile sm"></i></li><li class="react-menu-ul-li frown close" data-dismiss="modal" aria-label="Close" message_alt_id="" message_id=""><i class="fas fa-frown fr"></i></li><li class="react-menu-ul-li heart close" data-dismiss="modal" aria-label="Close" message_alt_id="" message_id=""><i class="fas fa-heart hr"></i></li></ul></div></div>');

        }
}


chat.viewmessageofflineGRP = function () {
      if(send_id == null)
        return;
      if(send_id.length != 20)
        return;
      if(localStorage.getItem("store"+send_id) != prevStatemess) {

      $('.chat_conn .mess_age_s').html("");
      var me = localStorage.getItem("store"+send_id);
          prevStatemess = localStorage.getItem("store"+send_id);
          if(me == "There are currently no messages") {
            return;
          }
          me = JSON.parse(me);
          console.log(me);

          $.each(me, function(k, v) {
            str = JSON.stringify(v.message).replace(/^"(.*)"$/, '$1');
            if(localStorage.getItem("__user_id__sess__") == parseInt(v.user_id)){
                $('.chat_conn .mess_age_s').append("<div class='info-current showonscroll'>"+str+"</div>");
                $('.chat_conn .mess_age_s').append("<br>");
            } else {
                $('.chat_conn .mess_age_s').append("<div class='parent-info showonscroll'><div class='senders_name'>"+ jQuery.trim(v.senders_nameGRP) +"</div><div class='info' data-target='#reactnow' id='' data-toggle='modal'><input id='__messid__' class='__messid__' type='hidden' value="+v.message_id+"><input id='__userid__' class='__userid__' type='hidden' value="+v.user_id+"><input id='__sendid__' class='__sendid__' type='hidden' value="+v.send_id+"><input id='__tampid__' class='__tampid__' type='hidden' value="+v.timestamp+">"+str+"</div></div>");
                $('.chat_conn .mess_age_s').append("<br>");
            }

          });
        }
}

var prevStateuser = "";

chat.showusers = function () {
  //show groups here only
  if(localStorage.getItem("user__friends") != prevStateuser || localStorage.getItem("store"+send_id) != prevStatemess) {
  $('.users').html("");
    var friends = localStorage.getItem("user__friends");
        prevStateuser = localStorage.getItem("user__friends");
        console.log(friends);
        if(friends == null)
          return;
        friends = JSON.parse(friends);

    $.each(friends, function(k,v){
      str = JSON.stringify(v.xs3__counter__user__69).replace(/^"(.*)"$/, '$1');
      Str = JSON.stringify(v.xs3__counter__user__96).replace(/^"(.*)"$/, '$1');
      var current__user = str;
      var me = localStorage.getItem("store"+parseInt(current__user));
      me     = JSON.parse(me);
      var lastMess = "";
      $.each(me, function(l,r){
        lastMess = JSON.stringify(r.message).replace(/^"(.*)"$/, '$1');
        if(lastMess.length > 30) {
          lastMess = lastMess.substring(0, 30);
          lastMess += "...";
      }
      });
      //if  {} make a check if user is login or not///go to server
      $('.users').append("<li class='my_friends user_unique collection-item avatar' data-userName=" + Str + "  user_unique_id = "+ str +"><div class='img-cont-user'><img src='ico.jpg' alt='profile_pic' class='circle'></div><span class='title'>"+Str+"</span><p class='last__blood'>"+lastMess+"</p></li>");
      //$('.users').append("<hr style='margin-left:75px;margin-top:0;margin-bottom:2px;color: grey'>");
      lastMess = "";

    });
  }
}
chat.throwMessage = function (message,send_id,method) {
		var od = {
			'id':send_id,
			'message': message,
			'send_by': localStorage.getItem("__user_id__sess__")
		};

    updateMessagesCLI(od);
    conn.send(JSON.stringify(od));
    if ($.trim(message).length != 0) {
        $.ajax({
            url: 'ajax/chat.php',
            type: 'post',
            data: {method: method, message: message, send_id: send_id},
            success: function(data) {
                chat.fetchMessages();
                chat.entry.val('');
                console.log(data);
            }
        });
    }
    setTimeout(chat.scrolltobottom, 2000);
}

///change new messages to 0
chat.change_to_zero = function () {
  $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'change_to_zero', send_id: send_id},
        success: function(data) {
            $('.notify_child').html(data);
        }
    });
}

//notification_react

chat.notification_react = function () {
    $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'notify_react'},
        success: function(data) {
            $('.notify_child').html(data);
        }
    });
}

chat.scrolltobottom = function () {
    var elem = document.getElementById('mess_age_s');
    elem.scrollTop = elem.scrollHeight;
}

chat.entry = $('.chat_conn .mess_enter');
chat.entry.on('keydown', function(e){

    if(e.keyCode === 13 && e.shiftKey === false && send_id != null) {//here big k was giving error
        //throw message
        var method = "throw";
        if(send_id.length == 20) {
          method = "throwGRP";
        }
        console.log(method);
        chat.throwMessage($(this).val(),send_id,method);//sending value of text area
        e.preventDefault();
        //return false;
    }
});

//chat.interval = setInterval(chat.fetchMessages, 500);//change to 2000 afterwards
chat.interval = setInterval(chat.viewmessageoffline, 100);
chat.interval = setInterval(chat.viewmessageofflineGRP, 100);
//chat.interval = setInterval(chat.userinfo, 1000);//ye babnd karo bas kuch bhi action ke samay check karlo//if null show message u need to be logged in
chat.getusers();
chat.fetchMessages();

/****/
/** reacted val
/****/
//TASK --- reduce ajax call function 5->1
$(document).on('click', '.tu', function() {
      var  message_id = localStorage.getItem("__reaction__current__val1__");
      var message_alt_id = localStorage.getItem("__reaction__current__val2__");
      $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'update_reacted', message_id: message_id, message_alt_id: message_alt_id, reacted_val: 1},
        success: function(data) {
            chat.fetchMessages();
        }
    });
      $('.modal-backdrop').hide();
});

$(document).on('click', '.td', function() {
      var  message_id = localStorage.getItem("__reaction__current__val1__");
      var message_alt_id = localStorage.getItem("__reaction__current__val2__");
      $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'update_reacted', message_id: message_id, message_alt_id: message_alt_id, reacted_val: 2},
        success: function(data) {
            chat.fetchMessages();
        }
    });
      $('.modal-backdrop').hide();
});

$(document).on('click', '.sm', function() {
      var  message_id = localStorage.getItem("__reaction__current__val1__");
      var message_alt_id = localStorage.getItem("__reaction__current__val2__");
      $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'update_reacted', message_id: message_id, message_alt_id: message_alt_id, reacted_val: 3},
        success: function(data) {
            chat.fetchMessages();
        }
    });
      $('.modal-backdrop').hide();
});

$(document).on('click', '.fr', function() {
      var  message_id = localStorage.getItem("__reaction__current__val1__");
      var message_alt_id = localStorage.getItem("__reaction__current__val2__");
      $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'update_reacted', message_id: message_id, message_alt_id: message_alt_id, reacted_val: 4},
        success: function(data) {
            chat.fetchMessages();
        }
    });
      $('.modal-backdrop').hide();
});

$(document).on('click', '.hr', function() {
      var  message_id = localStorage.getItem("__reaction__current__val1__");
      var message_alt_id = localStorage.getItem("__reaction__current__val2__");
      $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'update_reacted', message_id: message_id, message_alt_id: message_alt_id, reacted_val: 5},
        success: function(data) {
            chat.fetchMessages();
        }
    });
      $('.modal-backdrop').hide();
});


/****/
/** reactopen react-menu-open
/****/

$(document).on('mouseover', '.react-menu-open', function() {
      $(this).hide('fast');
      $(this).next().show('fast');
      clearInterval(chat.interval);
});

$(document).on('mousemove', '.react-menu-ul', function() {
      //not working
      clearInterval(chat.interval);
      //console.log("stop");
});

//on mouse out set interval

$(document).on('mouseout', '.react-menu-ul', function() {
      //not working
      chat.interval = setInterval(chat.showonlineusers, 10000);
      //console.log("stop");
});

//make use of this
$(document).on('click', '.send_my_file', function(evt,send_id) {
    evt.preventDefault();
      var formData = new FormData($('#frm')[0]);
      formData.append('send_id', send_id);
      //console.log(formData);
       $.ajax({
           url: 'core/upload.php/?send_id='+localStorage.getItem("test_sendid"),
           type: 'POST',
           data: formData,
           contentType: false,
           enctype: 'multipart/form-data',
           processData: false,
           success: function (response) {
             alert(response);
           }
});

});

//GROUP INITIALIZATION
//ALGO
//IF GROUP USERS IS ONLY ONE SHOW SOME INSTRUCTION
//HOW TO ADD NEW USERS
//use only user_id to stroe in group table
$(document).on('click','.submit_group_init', function() {

    var group_name = $('.group_name_val').val();
    var group_category = $('.group_category_val').val();
    console.log(group_name+" "+group_category);
    $.ajax({
      url: 'ajax/chat.php',
      type: 'POST',
      data: {method: 'create_new_group', group_name: group_name, group_category: group_category},
        success: function(data) {
            console.log(data);
        }
    });

    $.ajax({
      url: 'ajax/chat.php',
      type: 'POST',
      data: {method: 'fetchgroups'},//send groupid as data
        success: function(data) {
            //storing locally
            localStorage.setItem("__datagid@ll__",data);
            console.log(data);
            localStorage.setItem("__datagid@ll__",data);
        }
    });

    $('group_details').hide();
    $('.gr').hide();
    $('group_details').hide();
    $('.Freinds').css({'border-bottom':'none','transition': 'all ease-in-out 100ms'});
    $('.users').css('display','none');
    $('group_details').hide();
    $('.showmygrp').show("slide", { direction: "left" }, 150);
    chat.groupsshow();
    $('.users').hide();
    $('group_details').hide();
});

$(document).ready(function() {

    $.ajax({
      url: 'ajax/chat.php',
      type: 'POST',
      data: {method: 'fetchgroups'},//send groupid as data
        success: function(data) {
            //storing locally
            localStorage.setItem("__datagid@ll__",data);
            console.log(data);
            localStorage.setItem("__datagid@ll__",data);
        }
    })

});

chat.groupsshow = function() {

  var __datagid = localStorage.getItem("__datagid@ll__");
  $('.showmygrp').html("");
  var __datagid = JSON.parse(__datagid);
  $.each(__datagid, function(k,v) {
    //console.log(__datagid['groupdetails_user'].length);//use this in looping
    for(var i = 0; i < __datagid['groupdetails_user'].length; i++) {
      console.log(__datagid['groupdetails_user'][i]['group_name']);
      var group_name = __datagid['groupdetails_user'][i]['group_name'];
      var group_id   = __datagid['groupdetails_user'][i]['group_id'];
      var category   = __datagid['groupdetails_user'][i]['category'];
      var cunt       = __datagid['groupdetails_user'][i]['users_count'];
      var usersI     = __datagid['groupdetails_user'][i]['users_grp'];
      var admin      = __datagid['groupdetails_user'][i]['created_by_name'];
      var adminsI    = __datagid['groupdetails_user'][i]['admins'];
      var UsErS      = [];
      var Usar = "";
      for (var j = 0; j < __datagid['groupdetails_user'][i]['users'].length; j++) {
        UsErS[j] = __datagid['groupdetails_user'][i]['users'][j]['username'];
        //console.log(UsErS[j]);
        Usar += UsErS[j]+"__";
      }
      console.log(Usar);
      $('.showmygrp').append("<li class='Usar_grp collection-item' data-@gid = " + group_id + " data-@gname = " + JSON.stringify(group_name) + " data-@cat = " + JSON.stringify(category) + " data-@cunt = " + cunt + " data-@llId = " + usersI + " data-@god = " + admin + " data-@godId = " + adminsI + " data-@janta = " + Usar + ">" + group_name + "</li>")
      Usar = "";
      //$('.users').hide();
      //$('.showmygrp').show();
    }
    //console.log(__datagid['groupdetails_user'][0]['users']);
  })
};

//make functions for get groups
//show groups

$(document).on('click','.custom-btn-addnow', function() {
  var user_id = $(this).attr("user_unique");
  console.log(user_id);
  $.ajax({
    url: 'ajax/chat.php',
    type: 'POST',
    data: {method: 'add_new_member',group_id: send_id,user_id: user_id},
      success: function(data) {
        console.log("addeddddd");
        console.log(data);
      }
  });
  $.ajax({
      url: 'ajax/chat.php',
      type: 'POST',
      data: {method: 'showAddOption',group_id: send_id},
        success: function(data) {
          console.log(data);
            localStorage.setItem("grpOptAvail"+send_id,data);
            chat.grpOptAvail();
        }
    });
});

$(document).on('click','.testicle', function() {

    $.ajax({
      url: 'ajax/chat.php',
      type: 'POST',
      data: {method: 'showAddOption',group_id: send_id},
        success: function(data) {
          console.log(data);
            localStorage.setItem("grpOptAvail"+send_id,data);
            chat.grpOptAvail();
        }
    })

});

chat.grpOptAvail = function () {
  //show groups here only
  //if(localStorage.getItem("grpOptAvail"+send_id) != prevStateuser || localStorage.getItem("store"+send_id) != prevStatemess) {
  $('.showMyFri-list').html("");
    var grpOptAvail = localStorage.getItem("grpOptAvail"+send_id);
    if(grpOptAvail != null)
        grpOptAvail = JSON.parse(grpOptAvail);

    $.each(grpOptAvail, function(k,v){
      id_str = JSON.stringify(v.xs3__counter__user__69).replace(/^"(.*)"$/, '$1');
      name_str = JSON.stringify(v.xs3__counter__user__96).replace(/^"(.*)"$/, '$1');
      check = JSON.stringify(v.addornot).replace(/^"(.*)"$/, '$1');
      //if  {} make a check if user is login or not///go to server
      if(check == 'YES') {

        $('.showMyFri-list').append('<li user_unique_id = '+ id_str +' class="collection-item add-karo"><div class="name-hai">'+name_str+'<div user_unique='+id_str+' class="custom-btn-addnow">Add<div></div></li>');
      //$('.users').append("<hr style='margin-left:75px;margin-top:0;margin-bottom:2px;color: grey'>");
      //on click change css to disabled in fronthend
    } else {
      //
      $('.showMyFri-list').append('<li user_unique_id = '+ id_str +' class="collection-item added-hai"><div class="name-hai">'+name_str+'<div class="custom-btn-disabled">Member<div></div></li>');
    }
    });


}
