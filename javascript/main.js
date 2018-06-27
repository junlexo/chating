var indexSong = 0;
var scrollfirst = true;
var usersend = "";
var _userTo = "";
var date_sent = "", day_sent, month_sent, year_sent, hour_sent, min_sent;
var chat_type = "";
var websocket;
function nextSong()
{
    indexSong++;
   if(indexSong >= $(".table-manul a").length)
        indexSong = 0;
    $(".table-manul a")[indexSong].click();
}
function senMessage()
{
    $body_msg = $(".messageSend input[type=text]").val();
    $.ajax({
        url : 'include/sendmsg.php',
        type : 'POST',
        data : {
            body : $body_msg
        }, success: function(result)
        {
            $('.messageSend input[type="text"]').val(''); // làm trống thanh trò chuyện  
        }
    });
    setTimeout(function(){
        $('.listmessage').scrollTop($('.listmessage')[0].scrollHeight);
    }, 1000);
}
function coverMessage(messageHTML)
{
    var len = messageHTML.length;
    var str = "";
    var f = false;
    for(var i = 0; i < len; i++)
    {
        if(messageHTML[i].charCodeAt(0) > 10000 && f == false)
        {
            str += "<span class='icon-message'>" + messageHTML[i].toString();
            f = true;
        }
        else
        if(messageHTML[i].charCodeAt(0) > 10000 && f == true)
        {
            str += messageHTML[i].toString() + "</span>";
            f = false;
        }
        else
            str += messageHTML[i];
    }
    return str;
}
$("#sendMessage").click(function(){
    senMessage();
});
function showMessage(messageHTML) {  
    var message;
    if(usersend == $('#chat-user')[0].innerHTML)  
    {
        message = '<div class="msg-user"><span>' 
            + coverMessage(messageHTML) + '</span><div class="info-msg-user"> Bạn - ' 
                + day_sent + '/' + month_sent + '/' + year_sent + ' lúc ' 
                + hour_sent + ':' + min_sent 
                + '</div></div>';
    }
    else
    {
        message = '<div class="msg"><span>' 
            + coverMessage(messageHTML) + '</span><div class="info-msg">' + usersend + ' - '
                + day_sent + '/' + month_sent + '/' + year_sent
                + ' lúc ' + hour_sent + ':' + min_sent 
                + '</div></div>';
    }
    console.log(chat_type, _userTo);
    if(chat_type === 'room')
    {
        $('.listmessage').append(message);
        $('.listmessage').scrollTop($('.listmessage')[0].scrollHeight);
        // $("video#music")[0].pause();
        $("video#nofication")[0].play();
        $('.listmessage').scrollTop($('.listmessage')[0].scrollHeight);
    }
    else
        if(chat_type === 'message')
        {          
            var str_boxshow = "#message-" + _userTo;            
            $(str_boxshow).find(".content-message").append(message);            
            //$(str_boxshow).scrollTop($(str_boxshow).find('.content-message')[0].scrollHeight);
            $("video#nofication")[0].play();
            setTimeout(function(){
                var content_mesage = str_boxshow + " .content-message";
                // console.log($(str_boxshow).find('.content-message'));
                $(content_mesage).scrollTop($(content_mesage)[0].scrollHeight);
            }, 1000);
        }
}
function sendFile() {
    $("#sendFile").click(function(){
        var formdata = new FormData();
        formdata.append('uploadFile', document.getElementById("uploadFile").files[0]);
        formdata.append('username', document.getElementById("username").value);
        // $("form").find("input").each(function(index, value){
        //     formdata[value.name] = value.value;
        // });
        $.ajax({
            url : "./include/uploadFile.php",
            type : "POST",
            data : formdata,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success : function(result){
                console.log(result);
                window.location.reload();
            }
        });
        // xhr.send();
    });
}

function callBack_1() {
    // body...
    $(".show-un-active a").click(function (){
        setTimeout(function (){
            $(".show-active .listuser").load("./include/loadActive.php", function(){
                callBack_2();
            });
            $(".show-un-active .listuser").load("./include/loadunActive.php", function(){
                callBack_1();    
            });
        },1000);            
    });
}
function callBack_2() {
     $(".user-active a").click(function (){
        setTimeout(function (){
            $(".show-active .listuser").load("./include/loadActive.php", function(){
                callBack_2();
            });
            $(".show-un-active .listuser").load("./include/loadunActive.php", function(){
                callBack_1();    
            });
        },1000);
        
    });
}
function removeMessage()
{
    $(".close-message").click(function(){
        var userClosed = $(this).parent().find(".user-message-to")[0].innerHTML;        
        var div_parent = $(this).parents(".message-friend");        
        div_parent.remove();
        for(var i = 0; i < $(".list-friend .friend .name").length; i++)
        {
            if($(".list-friend .friend .name")[i].innerHTML == userClosed)
                $(".list-friend .friend").removeClass("isActive");
        }
    });
}
function ClickUser() {
    $(".list-friend .friend").click(function(){
        if(!$(this).hasClass("isActive"))
        {
            $(this).addClass("isActive");
            var id = $(this).find(".name")[0].innerHTML;
            $.ajax({
                url : "./include/appendUser.php?id="+id,
                type : "GET",
                success : function(result){                    
                    $(".show-list-message-friend .list-message-friend").append(result);   
                    removeMessage();
                    loadClickIcon();
                    sendMessager();
                    setTimeout(function(){
                        var id = "#"+$(result)[0].attributes[1].nodeValue + " .content-message";
                        // console.log($(result));
                        $(id).scrollTop($(id)[0].scrollHeight);  
                    },1000);
                    $(".show-list-message-friend .list-message-friend input[type=text]")[$(".show-list-message-friend .list-message-friend").length-1].focus();                                    
                }
            });
        }
    });
}
function loadClickIcon()
{
    $(".message-friend-send .show-icon").click(function () {
        var input_text = $(this).parent();
        input_text.find(".list-icon").removeClass("hide");
    });
    $(".message-friend-send .list-icon span").click(function(){    
        var input_text = $(this).parents(".input-text");
        var textOld = input_text.find("input").val();        
        textOld += $(this)[0].innerHTML;
        input_text.find("input").val(textOld);
        input_text.find(".list-icon").addClass('hide');
        input_text.find("input").focus();
    });
}
function sendUserFriend(userbox,message,userto) {
    $.ajax({
        url : 'include/sendMessageUser.php',
        type : 'POST',
        data : {
            body : message,
            userto : userto
        }, success: function(result)
        {
            userbox.find('input[type="text"]').val(''); // làm trống thanh trò chuyện  
        }
    });
    setTimeout(function(){
        userbox.find('.content-message').scrollTop(userbox.find('.content-message')[0].scrollHeight);
    }, 1000);
}
function sendMessager() {
    $(".btn-send-friend").click(function () {
        event.preventDefault();  
        var userbox = $(this).parents(".message-friend");
        var message = userbox.find('input[type="text"]').val();
        var userto = userbox.find('.user-message-to')[0].innerHTML;
        var messageJSON = {
            chat_type: 'message',
            chat_user: $('#chat-user')[0].innerHTML,
            user_to: userto,
            chat_message: message
        };
        websocket.send(JSON.stringify(messageJSON));
        sendUserFriend(userbox, message, userto);
    });
    $('.message-friend-send input[type="text"]').keypress(function(){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == 13)
        {
            event.preventDefault();      
            var userbox = $(this).parents(".message-friend");
            var message = userbox.find('input[type="text"]').val();
            var userto = userbox.find('.user-message-to')[0].innerHTML;
            var messageJSON = {
                chat_type: 'message',
                chat_user: $('#chat-user')[0].innerHTML,
                user_to: userto,
                chat_message: message
            };
            websocket.send(JSON.stringify(messageJSON));
            sendUserFriend(userbox, message, userto);
        }
    });
}
$(document).ready(function(){    
    sendFile();
    var widthScreen = $("body").width() - $(".message-box").width() - 250 - 61;
    $(".show-list-message-friend").css("width", widthScreen);
    $(".show-list-message-friend").css("left", -(widthScreen + 255));
    $(".list-friend").load("./include/listfriend.php", function(){
        ClickUser();        
    });    
    $(".btn-open-music").click(function () {
        if($(this).hasClass('closed'))
        {
            $(".list-friend").addClass('hide');
            $(".show-list-message-friend").addClass('hide');
            $(this).removeClass('closed');
            $(".table-parent").removeClass('isClose');
        }
        else
        {
             $(this).addClass('closed');
             $(".table-parent").addClass('isClose');
             setTimeout(function(){
                $(".list-friend").removeClass('hide');
                $(".show-list-message-friend").removeClass('hide');
            },1000);
             
        }
    });
    $('.list-image').slick({
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 10000,
    });
    $("#view-history").click(function () {
        $("#view-history").hide();
        $(".listmessage").load("./include/mslog.php", function(){
            // $("#view-history").show();
        });
        setTimeout(function(){
            $('.listmessage').scrollTop($('.listmessage')[0].scrollHeight);
        }, 1000);
    });
    $(".table-manul a").on("click", function() 
    {   indexSong = $(".table-manul a").index($(this));
        if($(this).hasClass("active"))
            $(this).parent().removeClass("active");
        else
        {
            $(".table-manul a").parent().removeClass("active");
            $(this).parent().addClass("active");
        }
        $("video#music source")[0].src = "music_path/" + $(this)[0].hash.slice(1,$(this)[0].hash.length);
        $("video#music").load();      
    });
    $("video#music").bind("ended", function() {
        if(!$("#repeat")[0].checked)
            nextSong();
        else
            $("video#music").load();
    });
    $("video#nofication").bind("ended", function() {
       // $("video#music")[0].play();ư
    });
    $(".messageSend input").focus(function(){
        $(".message-box").addClass("focus");
        $(".messageSend .listIcon").addClass('hide');
    });
    $(".messageSend input").blur(function(){
        $(".message-box").removeClass("focus");
    });
    $("#showIcon").click(function(){
        if($(".messageSend .listIcon").hasClass('hide'))
        {
            $(".messageSend .listIcon").removeClass('hide');
        }
        else
            $(".messageSend .listIcon").addClass('hide');
    });
    $(document).mouseup(function(e) 
    {
        var container = $(".messageSend .listIcon");
        var container_list_icon = $(".message-friend-send .list-icon");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            $(".messageSend .listIcon").addClass('hide');
        }
        if (!container_list_icon.is(e.target) && container_list_icon.has(e.target).length === 0) 
        {
            $(".message-friend-send .list-icon").addClass('hide');
        }
    });        
    $(".messageSend .listIcon span").click(function(){        
        var textOld = $(".messageSend .input-text input").val();        
        textOld += $(this)[0].innerHTML;
        $(".messageSend .input-text input").val(textOld);
        $(".messageSend .listIcon").addClass('hide');
        $(".messageSend .input-text input").focus();
    });
    $(".show-un-active .listuser").load("./include/loadunActive.php",function () {
        callBack_1();
    });   
    $(".show-active .listuser").load("./include/loadActive.php",function (){
       callBack_2();
    });
    setInterval(function(){
        $(".show-un-active .listuser").load("./include/loadunActive.php",function () {
            callBack_1();
        });   
        $(".show-active .listuser").load("./include/loadActive.php",function (){
           callBack_2();
        });   
    }, 300000);
    
    websocket = new WebSocket("ws://"+ window.location.hostname +":8090/chating/include/php-socket.php"); 
    websocket.onopen = function(event) { 
        $('.listmessage').append("<div class='chat-connection-ack'>Connection is established!</div>");       
    }
    websocket.onmessage = function(event) {
        var Data = JSON.parse(event.data); 
        // if(Data.message === 'New client') 
        // {
        //     console.log("New client");
        //     var messageJSON = {
        //     chat_user: $('#chat-user')[0].innerHTML,
        //     chat_message: 'New client ' + $('#chat-user')[0].innerHTML + ' joined!!'
        //     };
        //     websocket.send(JSON.stringify(messageJSON));
        //     return ;
        // }      
        usersend = Data.user;
        date_sent = Data.date_curent;
        chat_type = Data.chatType;
        if(Data.userto == $('#chat-user')[0].innerHTML)
            _userTo = Data.user;
        else
            _userTo = Data.userto;
        console.log(chat_type);
        day_sent = date_sent.slice(8, 10); // Ngày gửi
        month_sent = date_sent.slice(5, 7); // Tháng gửi
        year_sent = date_sent.slice(0, 4); // Năm gửi
        hour_sent = date_sent.slice(11, 13); // Giờ gửi
        min_sent = date_sent.slice(14, 16); // Phút gửi
        showMessage(/*"<div class='"+Data.message_type+"'>"+*/Data.message/*+"</div>"*/);
        $('#chat-message').val('');
    };
    
    websocket.onerror = function(event){
        showMessage("<div class='error'>Problem due to some Error</div>");
    };
    websocket.onclose = function(event){
        showMessage("<div class='chat-connection-ack'>Connection Closed</div>");
    }; 
    
    $('#sendMessage').on("click",function(event){
        event.preventDefault();    
        var messageJSON = {
            chat_type: 'room',
            chat_user: $('#chat-user')[0].innerHTML,
            chat_message: $('.messageSend input[type=text]').val()
        };
        websocket.send(JSON.stringify(messageJSON));
        senMessage();
    });
    $('.messageSend input[type="text"]').keypress(function(){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == 13)
        {
            event.preventDefault();      
            var messageJSON = {
                chat_type: 'room',
                chat_user: $('#chat-user')[0].innerHTML,
                chat_message: $('.messageSend input[type=text]').val()
            };
            websocket.send(JSON.stringify(messageJSON));
            senMessage();
        }
    });
});
