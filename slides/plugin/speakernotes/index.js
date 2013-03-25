var express   = require('express');
var fs        = require('fs');
var io        = require('socket.io');
var _         = require('underscore');
var Mustache  = require('mustache');

var app       = express.createServer();
var staticDir = express.static;

io            = io.listen(app);

var opts = {
	port :      8080,
	baseDir :   __dirname + '/../../'
};
console.log("socket setup");

var connectedCount = 0;
var tickerStarted = false;

var welcomeMessages = [
  "Welcome to Real Time Web Apps with Node.js",
  "These are the participant notes. They will allow you to interact during the presentation",
  "There is live chat below. Join in the conversation!",
  "We hope you enjoy the presentation"
];
var polls = {
  "nodejs": {
    question: "Have you used Node.js before",
    answers: [
        "What's Node.js?",
        "I've heard of it",
        "I've played around with it a little",
        "I have built and deployed a Node.js application",
        "I'm a Node Ninja!",
        "Other"
    ]
  },
  "realtime": {
    question: "How familiar are you with real-time technologies like WebSockets and Comet?",
    answers: [
      "Not much, that's why I'm here",
      "I've dabbled a bit",
      "I did some with the older Comet technologies, but I haven't tried WebSockets yet",
      "I've used Comet or WebSockets in one of my applications",
      "I'm a WebSocket Wizard!",
      "Other"
    ]
  }
}
var currentPoll;
function startPoll(pollId) {
  console.log("Starting poll: ", pollId);
  currentPoll = {
    pollId: pollId,
    poll: polls[pollId],
    responses: [
      0,0,0,0,0,0
    ]
  };
};
function Ticker(socket) {
  var active = true;
  var tickerSender;
  var tickerSocket = socket;
  var curIndex = 0;
  this.sendTickerEvent = function() {
    if (!active) {
      console.log("ticker not active, returning");
      return;
    }
//    console.log("sendTickerEvent socket", socket);
    var message = welcomeMessages[curIndex];
    if (tickerSocket) {
      console.log("sending ticker event to " + socket.id + " with message: " + message);
      tickerSocket.emit("welcomemessage", message);
    }

    var timeout = Math.round(Math.random() * 10000);
    if(timeout < 5000) {
      timeout += 5000;
    }
    curIndex++;
    curIndex = curIndex % welcomeMessages.length;
//    console.log('setting timer for next index: ' + curIndex);
    tickerSender = setTimeout(this.sendTickerEvent, timeout);
  }
  this.sendTickerEvent();
  this.stop = function () {
    console.log("setting active to false", active);
    active = false;

  }
}
io.sockets.on('connection', function(socket) {
  console.log("socket connection: ", socket.id);
  connectedCount++;
  socket.broadcast.emit("connectedCount", connectedCount);

  console.log("on connection currentPoll: ", currentPoll);
  if (currentPoll) {
    socket.emit("pollcreate", currentPoll);
  } else {
    var ticker = new Ticker(socket);
    console.log("created ticker", ticker);
  }

  socket.on("connect", function() {
    console.log("socket connect");
    connectedCount++;
    socket.broadcast.emit("connectedCount", connectedCount);
  });

  socket.on("disconnect", function() {
    console.log("socket disconnect");
    connectedCount--;
    socket.broadcast.emit("connectedCount", connectedCount);
  });

	socket.on('slidechanged', function(slideData) {
    console.log("server changed slides: ", slideData);
    console.log("ticker", ticker);
    ticker.stop();
		socket.broadcast.emit('slidedata', slideData);
    if (slideData.slideId === "poll-nodejs") {
      startPoll("nodejs");
      socket.broadcast.emit("pollcreate", currentPoll);
      socket.emit("pollupdate", currentPoll);
    } else if (slideData.slideId === "poll-realtime") {
      startPoll("realtime");
      socket.broadcast.emit("pollcreate", currentPoll);
      socket.emit("pollupdate", currentPoll);
    } else {
      currentPoll = null;
    }
	});

	socket.on('sendChatMessage', function(chatMessage) {
    console.log("server received sendChatMessage: " + JSON.stringify(chatMessage));
		socket.broadcast.emit('chatmessage', chatMessage);
	});

	socket.on('pollresponse', function(pollMessage) {
    console.log("server received pollresponse: " + JSON.stringify(pollMessage));
    currentPoll.responses[pollMessage.selection]++;
    // send to sender, then everyone
		socket.emit('pollupdate', currentPoll);
		socket.broadcast.emit('pollupdate', currentPoll);
	});
});

app.configure(function() {
	[ 'css', 'js', 'plugin', 'lib', 'img' ].forEach(function(dir) {
		app.use('/' + dir, staticDir(opts.baseDir + dir));
	});
  app.use(express.static(__dirname + '/plugin/speakernotes'));
});

app.get("/", function(req, res) {
	fs.createReadStream(opts.baseDir + '/index.html').pipe(res);
});

app.get("/demo", function(req, res) {
  fs.readFile(opts.baseDir + 'plugin/speakernotes/demo.html', function(err, data) {
    res.send(Mustache.to_html(data.toString(), {
      socketId : req.params.socketId
    }));
  });
});

app.get("/notes/:socketId", function(req, res) {

	fs.readFile(opts.baseDir + 'plugin/speakernotes/notes.html', function(err, data) {
		res.send(Mustache.to_html(data.toString(), {
			socketId : req.params.socketId
		}));
	});
	// fs.createReadStream(opts.baseDir + 'speakernotes/notes.html').pipe(res);
});

// Actually listen
app.listen(opts.port || null);

var brown = '\033[33m', 
	green = '\033[32m', 
	reset = '\033[0m';

var slidesLocation = "http://localhost" + ( opts.port ? ( ':' + opts.port ) : '' );

console.log( brown + "reveal.js - Speaker Notes" + reset );
console.log( "1. Open the slides at " + green + slidesLocation + reset );
console.log( "2. Click on the link your JS console to go to the notes page" );
console.log( "3. Advance through your slides and your notes will advance automatically" );


