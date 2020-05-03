var express = require('express');
var app = express();
var request = require('request');
var path = require("path");
var bodyParser =require("body-parser");
var jsonParser = bodyParser.json();
// var multipart = require('connect-multiparty');
// var multipartMiddleware = multipart();


// const googleApiKey = "AIzaSyBUgmuhI38JvxPGgLiB2d0QdIxyaPDvOjs";
// const searchEngineId = "010569830817504491424:ybmux6svzrk";
const temp = '%20State%20Seal&cx=014226069218176724898:ct0iplcwprm&imgSize=huge&imgType=news&num=1&searchType=image&key=AIzaSyCUbX3thvUqn4ul82mYU9guuASGixoH-SI';
app.get('/get/:id', function (req, res){
    // console.log(req.params.id);
    console.log(sealUrl+req.params.id+temp);
    request(sealUrl+req.params.id+temp,function (error, response, body) {
        if (!error && response.statusCode == 200) {
            res.send(body)
        }
    })
})

const searchUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=";
app.post('/searchgeo', jsonParser, function(req, res){
    const gurl = req.body.geoUrl;
    // console.log(req.body)
    // console.log(searchUrl+gurl);
    request(searchUrl+gurl, function(error, response, body){
        if(!error && response.statusCode==200){
            res.send(body);
        }
    })
})

const sealUrl = "https://www.googleapis.com/customsearch/v1?q=";
app.post('/searchseal', jsonParser, function(req, res){
    const surl = req.body.sealUrl;
    console.log(sealUrl+surl);
    request(sealUrl+surl, function(error, response, body){
        if(!error && response.statusCode==200){
            res.send(body);
        }
    })
})

const weatherUrl = "https://api.darksky.net/forecast/";
app.post('/searchweather', jsonParser, function(req, res){
    const wurl = req.body.weatherUrl;
    // console.log(req.body);
    console.log(weatherUrl+wurl);
    request(weatherUrl+wurl, function(error, response, body){
        if(!error && response.statusCode==200){
            res.send(body);
        }
    })
})

const dateUrl = "https://api.darksky.net/forecast/";
app.post('/searchdate', jsonParser, function(req, res){
    const durl = req.body.dateUrl;
    request(dateUrl+durl, function(error, response, body){
        if(!error && response.statusCode==200){
            res.send(body);
        }
    })
})

app.use(express.static(path.join(__dirname, 'public')));

app.use(function(req, res) {
    // send index.html to start client side
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.sendFile("index.html", { root: path.join(__dirname, 'public/') });
});


var server = app.listen(8081, function () {
    var host = server.address().address
    var port = server.address().port
   
    console.log("应用实例，访问地址为 http://%s:%s", host, port)
  
})