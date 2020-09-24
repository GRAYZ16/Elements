const { server, mongodb } = require('./config/config');
const { Connection } = require('./config/mongo-connection');
const DeviceModel = require('./models/device');
const mongoose = require('mongoose');

const express = require('express');

mongoose.connect(mongodb.URL.concat('/', mongodb.DB_NAME));

const app = express();
app.use(express.json());

var routes = require('./routes.js')(app);


app.listen(server.port, server.hostname, () => console.log(`App running on http://${server.hostname} listening on port ${server.port}`));