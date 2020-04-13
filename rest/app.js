const express = require('express')

const app = express()
const port = 8080
const hostname = '0.0.0.0'

var routes = require('./routes.js')(app);

app.listen(port, hostname, () => console.log(`App running on http://${hostname} listening on port ${port}`))