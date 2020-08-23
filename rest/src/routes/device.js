var express = require('express');
var router = express.Router();

const { Connection } = require('../config/mongo-connection');
var deviceController = require('../controllers/device-controller');


// GET Device ID query
router.get('/', deviceController.queryDevices);

// GET Device
router.get('/:deviceId', deviceController.getDevice);

// POST Device creation
router.post('/', deviceController.createDevice);

// PUT Device Update
router.put('/', deviceController.updateDevice);

// DELETE Device
router.delete('/:deviceId', deviceController.deleteDevice);


module.exports = router;