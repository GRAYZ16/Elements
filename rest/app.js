const config = require('./config/config');
const { Connection } = require('./config/mongo-connection');
const assert = require('assert');

const express = require('express');


Connection.connectToMongo();
const app = express();
var routes = require('./routes.js')(app);

app.listen(config.server.port, config.server.hostname, () => console.log(`App running on http://${config.server.hostname} listening on port ${config.server.port}`));