$(document).ready(function() {
    var socket = new WebSocket('ws://localhost:8080');
    var chat_id = new URLSearchParams(window.location.search).get('chat_id');
    var user_id = $('#user_id').val();

    socket.onopen = function() {
        console.log('Conexión establecida');
    };

    socket.onmessage = function(event) {
        var data = JSON.parse(event.data);
        if (data.chat_id === chat_id) {
            var messageClass = (data.user_id == user_id) ? 'my-message' : 'other-message';
            $('#messages').append('<p class="' + messageClass + '"><strong>' + data.username + ':</strong> ' + data.message + '</p>');
            $('#messages').scrollTop($('#messages')[0].scrollHeight);
        }
    };

    $('#messageForm').submit(function(event) {
        event.preventDefault();
        var message = $('#message').val();
        socket.send(JSON.stringify({ chat_id: chat_id, user_id: user_id, message: message }));
        $('#message').val('');
    });

    $('#createChatForm').submit(function(event) {
        event.preventDefault();
        var chatName = $('#chatName').val();
        $.post('create_chat.php', { name: chatName }, function(data) {
            $('#chatList').append('<li class="list-group-item"><a href="chat.php?chat_id=' + data.id + '">' + data.name + '</a></li>');
            $('#chatName').val('');
        }, 'json');
    });
});
