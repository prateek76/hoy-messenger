/*$(document).ready(function(){
    var users = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('username'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: 'core/users.php?query=%QUERY'
    });

    users.initialize();

    $('#users').typeahead({
        hint: true,
        highlight: true,
        minLength: 2
    }, {
        name: 'users',
        displayKey: 'username',
        source: users.ttAdapter()
    });
});*/
//is user session null dont show any data


var open_men;
var open_men_clicked;

$( document ).on('click','.menubt', function(){
  $('.menuwillopen').css({'display': 'block','transition': 'all ease-in-out 600ms'});
  open_men=12;
});

$(document).on('click','.menuwillopen',function(){
    open_men_clicked = 1000;
    setTimeout(function(){ $('.menuwillopen').css('display','none') },300);
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
  $('.gr').css({'display': 'block','transition': 'all ease-in-out 600ms'});
});

$(document).on('click','.Groups',function() {
  $(this).css({'border-bottom':'2px solid #fff','transition': 'all ease-in-out 100ms'});
  $('.Freinds').css({'border-bottom':'none','transition': 'all ease-in-out 100ms'});
  $('.gr').css('display','none');
  chat.groupsshow();
});

$(document).on('click','.Freinds',function() {
  $(this).css({'border-bottom':'2px solid #fff','transition': 'all ease-in-out 100ms'});
  $('.Groups').css({'border-bottom':'none','transition': 'all ease-in-out 100ms'});
  $('.showmygrp').hide();
  $('.gr').css('display','none');
  $('.users').show();
});

var chat = {}

var send_id = null;
var fetch_met = "fetch";

/*var textarea_clicked;
var open ;

$( document ).on('click','._opentext', function(){
  $('textarea').slideToggle(300,'swing');
  open=12;
});

$(document).on('click','.mess_enter',function(){
    textarea_clicked = 1000;
  });

$(document).click(function(){
  
  console.log(textarea_clicked);
  if(textarea_clicked == 1000){
    textarea_clicked = 0;
  } else if(open != 12){
    $('.mess_enter').hide(300,'swing');
  } else {
    open = 0;
  }
});*/

$(document).on('click', '.user_unique', function() { 
      $('.gr').css('display','none');
      send_id = $(this).attr("user_unique_id");
      localStorage.setItem("test_sendid",send_id);
      var name = $(this).attr("data-userName");
      $('.to').text(name);
      $('.to').parent().attr('href',"http://localhost/lets%20chat%20oneonone/user_profile/user_profile.php?@id="+$(this).text());
      //console.log(send_id);
      chat.fetchMessages();
      chat.change_to_zero();
      if(send_id.val != '')
        $('.chat_conn').show();
      //chat.getusers();
      //chat.showusers();
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
      //console.log(send_id);
      chat.fetchMessages();
      chat.change_to_zero();
      if(send_id.val != '')
        $('.chat_conn').show();
      chat.viewmessageofflineGRP();
});

$(document).on('click', '.close-it', function() { 
     $('.chat_conn').hide();
});

$(document).on('click','.goandlogin', function(){
    chat.userinfo();
});

$(document).on('click','.getout', function(){
    localStorage.clear();
});

$(document).on('click','.info', function(){
  //console.log(69);
  var __messid__ = $(this).children('.__messid__').val();
  var __userid__ = $(this).children('.__userid__').val();
  var __sendid__ = $(this).children('.__sendid__').val();
  var __tampid__ = $(this).children('.__tampid__').val();
  console.log(__messid__+"_____"+__tampid__+"$$$_____$$$"+__sendid__+"_____"+__userid__);
  localStorage.setItem("__reaction__current__val1__",__messid__);
  localStorage.setItem("__reaction__current__val2__",__tampid__);

});

$(document).on('click','.info-single', function(){
  //console.log(69);
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
});

chat.userinfo = function () {
    $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: 'userinfo'},
        success: function(data) {
            localStorage.setItem("__user_id__sess__",data);
            //console.log(data);
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
            //$('.users').html(data);
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
    }
    $.ajax({
        url: 'ajax/chat.php',
        type: 'post',
        data: {method: fetch_met,send_id: send_id},
        success: function(data) {
          //console.log(data);
          //$('.chat_conn .mess_age_s').html("");
          localStorage.setItem("store"+send_id,data);//local storage name will be variable
          /*var me = localStorage.getItem("store"+send_id);
          me = JSON.parse(me);
          ////console.log(me);

          $.each(me, function(k, v) {
            $('.chat_conn .mess_age_s').append("username:"+ JSON.stringify(v.username));
            $('.chat_conn .mess_age_s').append("<br>");
            $('.chat_conn .mess_age_s').append("message:"+JSON.stringify(v.message));
            $('.chat_conn .mess_age_s').append("<br>");
          });*/
        }
    });
    ////console.log(send_id);
}

var prevStatemess = "";

chat.viewmessageoffline = function () {
      //make always update from localstorage
      //it should update from local storage
      //make html = ""
      //then update the timer
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
      //make always update from localstorage
      //it should update from local storage
      //make html = ""
      //then update the timer
      if(send_id == null)
        return;
      if(send_id.length != 20)
        return;
      if(localStorage.getItem("store"+send_id) != prevStatemess) {
      $('.chat_conn .mess_age_s').html("");
      var me = localStorage.getItem("store"+send_id);
          prevStatemess = localStorage.getItem("store"+send_id);
          me = JSON.parse(me);
          console.log(me);

          $.each(me, function(k, v) {
            str = JSON.stringify(v.message).replace(/^"(.*)"$/, '$1');
            
            if(localStorage.getItem("__user_id__sess__") == parseInt(v.user_id)){
              
                $('.chat_conn .mess_age_s').append("<div class='info-current'>"+str+"</div>");
                $('.chat_conn .mess_age_s').append("<br>");


            } else {
              
                $('.chat_conn .mess_age_s').append("<div class='parent-info'><div class='senders_name'>"+ jQuery.trim(v.senders_nameGRP) +"</div><div class='info' data-target='#reactnow' id='' data-toggle='modal'><input id='__messid__' class='__messid__' type='hidden' value="+v.message_id+"><input id='__userid__' class='__userid__' type='hidden' value="+v.user_id+"><input id='__sendid__' class='__sendid__' type='hidden' value="+v.send_id+"><input id='__tampid__' class='__tampid__' type='hidden' value="+v.timestamp+">"+str+"</div></div>");
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
    //var me      = localStorage.getItem("store"+send_id);
        prevStateuser = localStorage.getItem("user__friends");
        friends = JSON.parse(friends);
        //me = JSON.parse(me);

    //console.log(friends);
    
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
    
    if ($.trim(message).length != 0) {
        $.ajax({
            url: 'ajax/chat.php',
            type: 'post',
            data: {method: method, message: message, send_id: send_id},
            success: function(data) {
                chat.fetchMessages();
                chat.entry.val('');
            }
        });
        //console.log("done");
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
    //console.log(e.which);
    //var send_id = $('.user_unique').attr("user_unique_id");  

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

chat.interval = setInterval(chat.fetchMessages, 500);//change to 2000 afterwards
//chat.interval = setInterval(chat.showonlineusers, 1000);
//chat.interval = setInterval(chat.getusers, 1000);
//chat.interval = setInterval(chat.showusers, 500);
chat.interval = setInterval(chat.viewmessageoffline, 100);
chat.interval = setInterval(chat.viewmessageofflineGRP, 100);
chat.interval = setInterval(chat.userinfo, 1000);//ye babnd karo bas kuch bhi action ke samay check karlo
chat.getusers();
//chat.showonlineusers();
chat.fetchMessages();
//chat.notification_react();


/****/
/** reacted val
/****/
//TASK --- reduce ajax call function 5->1
$(document).on('click', '.tu', function() { 
      //message_id = $(this).parent().attr("message_id");
      //message_alt_id = $(this).parent().attr("message_alt_id");
      //console.log(message_id);
      //console.log(message_alt_id);
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
    ////console.log(6565656565656);
      //message_id = $(this).parent().attr("message_id");
      //message_alt_id = $(this).parent().attr("message_alt_id");
      //console.log(message_id);
      //console.log(message_alt_id);
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
  ////console.log(6565656565656);
      //message_id = $(this).parent().attr("message_id");
      //message_alt_id = $(this).parent().attr("message_alt_id");
      //console.log(message_id);
      //console.log(message_alt_id);
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
  //console.log(6565656565656);
      //message_id = $(this).parent().attr("message_id");
      //message_alt_id = $(this).parent().attr("message_alt_id");
      //console.log(message_id);
      //console.log(message_alt_id);
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
      //message_id = $(this).parent().attr("message_id");
      //message_alt_id = $(this).parent().attr("message_alt_id");
      //console.log(message_id);
      //console.log(message_alt_id);
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
    })

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
      $('.users').hide();
      $('.showmygrp').show();
    }
    //console.log(__datagid['groupdetails_user'][0]['users']);
  })
};

//make functions for get groups
//show groups