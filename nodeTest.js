var http = require('http');

var server = http.createServer( function(request, response) {
	response.writeHead(200, {'content-type': 'text/plain'});
	response.end('Hello World');
});

var mysql = require('mysql');
var connection = mysql.createConnection({
	host: 'electricathleticscom.ipagemysql.com',
	user: 'dancody',
	password: 'tino24', 
	database: 'blogdatabase',
});

connection.connect();

var post  = {id: 'NULL', time: 'CURRENT_TIMESTAMP', title: 'Yankees', photo: 'http://thenypost.files.wordpress.com/2014/01/rangers8.jpg?w=720&h=480&crop=1', desc: 'Rangers', post: 'Ranges Post',};
var query = connection.query('INSERT INTO blogs SET ?', post, function(err, result) {
  // Neat!
});

console.log(query.sql); 
console.log(connection);
connection.end();

