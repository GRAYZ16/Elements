var express = require('express');
var router = express.Router();

const { Connection } = require('../config/mongo-connection');

router.get('/', (req, res) => {
    res.send("Device GET Request");
});

router.get('/:deviceId', (req, res) => {
    Connection.db.collection('Devices').find({id: parseInt(req.params.deviceId)}).toArray(function (err, result) {
        if (err) throw err;

        if (result.length != 1)
        {
            res.statusCode = 404;
            res.json({err: "The Requested Device ID cannot be found."});
        }
        else
        {
            res.json(result[0]);
        }    
      });
});

router.post('/', (req, res) => {

    var device = {};

    device.macAddress = req.body.macAddress;
    device.deviceName = req.body.deviceName;
    device.deviceDescription = req.body.deviceDescription;

    Connection.db.collection('Devices').find({macAddress: req.body.macAddress}).toArray(function (err, result) {
        if (err) throw err;

        if(result.length > 0)
        {
            res.statusCode = 400;
            res.json({err: "Device MAC is already registered"});
        }
        else
        {
            console.log(device);

            req.body.sensors.forEach(sensor => {
                console.log(sensor.description);
            });

            res.send({status: "Object Created", objectId: 1});
        }
    });
});

module.exports = router;