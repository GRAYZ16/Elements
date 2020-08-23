const { server } = require('./config/config');
const { Connection } = require('./config/mongo-connection');
const assert = require('assert');

const express = require('express');


Connection.connectToMongo();
const app = express();
app.use(express.json());

var routes = require('./routes.js')(app);

app.listen(server.port, server.hostname, () => console.log(`App running on http://${server.hostname} listening on port ${server.port}`));