// Client side support
// -------------------

// This file contains all of the relevant client side code to communicate through
// `socket.io` to the server, and in turn all other connected clients

;(function() {
  'use strict'

// Wait for the DOM to load before taking action
  $(function() {
    // Setup
    // -----
    if (!window.io && window.Notifier) {
      Notifier.error("Could not connect to WebSocket server.", "Connection Failure");
    }

    // Create the socket connection object, as well as the references to our DOM
    // handlers for input and recording output
    var socket = io.connect("http://rtchat-redbugz.dotcloud.com:80/")
        , $messages = $('#messages')
        , $input = $('#msg')
        , $button = $('#submit')

    //###send
    // Send the input value to the server, recording our own message since `socket.io`
    // wont re-broadcast the message back to the client who sent it. Clear the input
    // field out when we are finished so it is ready to send another
    function send() {
      var msg = $input.val().trim()
      if (msg) {
        socket.emit('message', msg)
        $messages.prepend('<li><span><b>' + socket.socket.sessionid + '</b></span> ' + msg + '</li>')
        Notifier.info("Congratulations, you sent a chat message.", "Message Sent");
      }
      $input.val('')
    }

    // Socket.io listeners
    // --------------------
    socket.on('connect', function(data) {
      Notifier.info("You have connected", "Connection");
    });
    socket.on('disconnect', function(data) {
      Notifier.error("You have been disconnected from the chat server.", "Disconnected");
    });
    //###message
    // A new message has been received, the data comes through as a JSON object with
    // two attributes, an `id` of the client who sent the message, as well as a `msg`
    // with the actual text of the message, add it to the DOM message container
    socket.on('message', function(data) {
      $messages.prepend('<li><span>' + data.id + '</span> ' + data.msg + '</li>');
      Notifier.info("Congratulations, you received a chat message.", "Message Received");
    })

    //###connected
    // Another client has connected to the application, lets make a note of that, and
    // add it to the DOM message container with the `id` that is passed from the server.
    socket.on('connected', function(id) {
      $messages.prepend('<li class="status"><span>Connected</span> ' + id + '</li>')
      Notifier.success(id + " has been connected to the chat server.", "User Connected");
    })

    socket.on('connectedCount', function(number) {
      $("#connected-count").text(number + " people are connected");
    })

    //###disconnected
    // Another client has disconnected from the application
    socket.on('disconnected', function(id) {
      $messages.prepend('<li class="status"><span>Disconnected</span> ' + id + '</li>')
      Notifier.warning(id + " has been disconnected from the chat server.", "User Disconnected");
    })

    // User interaction
    // ----------------

    //###keypress listener
    // Create a keystroke listener on the input element, since we are not sending a
    // traditional form, it would be nice to send the message when we hit `enter`
    $input.keypress(function(event) {
      if (event.which == 13) {
        send()
      }
    })

    //###click listener
    // Listen to a `click` event on the submit button to the message through
    $button.click(send)
  })

}).call(this);
