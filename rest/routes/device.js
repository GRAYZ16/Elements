var express = require('express');
var router = express.Router();

const { Connection } = require('../config/mongo-connection');

const db = Connection.connectToMongo();

router.get('/', (req, res) => {
    res.send("Device GET Request");
});

router.get('/:deviceId', (req, res) => {
    Connection.db.collection('Devices').find({id: parseInt(req.params.deviceId)}).toArray(function (err, result) {
        if (err) throw err;
    
        res.json(result);
      });
});

module.exports = router;