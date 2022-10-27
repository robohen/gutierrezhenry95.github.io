// const IP = '172.127.5.14'; // Added cause weird localhost IP
const express = require('express');
const app = express();
const router = express.Router();
var session = require('express-session')
const request = require('request');


app.use ('/' , router);
router.use(session({ resave: false, saveUninitialized: true, secret: 'keyboard cat', cookie: { maxAge: 60000 }}));

router.get('/home', (req,res) => {
  res.send('Hello World, This is home router');
});


router.get('/ip', (req,res) => { //this obtains the ip of the user
  let ip = IP || req.headers['x-forwarded-for'] || req.connection.remoteAddress;
  req.session.ip = ip;

  res.setHeader('Content-Type', 'application/json');
  res.send(JSON.stringify({ ip: ip }));

  //res.send("This is your ip");  //https://api.ipify.org/?format=json http://ip-api.com/json/`{ip}`
});

router.get('/zipcode', (req,res) => {
  let ip = req.session.ip;
  let urlEndpoint = `http://ip-api.com/json/${ip}`;

  request(urlEndpoint, function (error, response, body) {
    if (!error && response.statusCode == 200) {
      res.setHeader('Content-Type', 'application/json');
      req.session.geo = body;
      res.send(body); //this obtains the zip code of the user http://localhost:port/zipcode
    }
    else {
      res.send("Something went wrong!")
    }
  });


});

router.get('/weather', (req,res) => {


  let apiKey = 'db4d41318e585ae936cbe747948ae6d9';
  let geo = JSON.parse(req.session.geo);
  let urlEndpoint = `https://api.openweathermap.org/data/2.5/weather?zip=${geo.zip},${geo.countryCode}&appid=${apiKey}&units=imperial`;

  request(urlEndpoint, function (error, response, body) {
    if (!error && response.statusCode == 200) {
      res.setHeader('Content-Type', 'application/json');
      req.session.weather = JSON.parse(body);
      console.log(req.session.weather)
      res.send(JSON.stringify({ temperature: req.session.weather.main.temp })); //this obtains the zip code of the user http://localhost:port/zipcode
    }
    else {
      res.send(body);
    }
  });


});

router.get('/localized', (req,res) => {
  let weather = req.session.weather;
  let geo = JSON.parse(req.session.geo);
  let ip = req.session.ip;
  

  let body = {
    CityName: geo.city,
    DateTime: new Date().toLocaleString(),
    IP: ip,
    ZipCode: geo.zip,
    localWeather: [`${weather.main.temp} F` , 
      `${weather.main.temp - 32 * (5/9).toFixed(2)} C`, 
      `${weather.weather[0].main} ${weather.weather[0].description}`,
      `${weather.wind.speed} mph`,
      `${weather.wind.speed * 1.60934} m/s`
    ]

  }
  res.setHeader('Content-Type', 'application/json');
  console.log(body)
  res.send(JSON.stringify(body));
});


app.listen(process.env.port || 8080);
console.log('Web Server is listening at port '+ (process.env.port || 8080));