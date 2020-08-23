var express = require('express');
var router = express.Router();

const { Connection } = require('../config/mongo-connection');
const nodeController = require('../controllers/node-controller');


// GET Node 
router.get('/', nodeController.getNode);

module.exports = router;