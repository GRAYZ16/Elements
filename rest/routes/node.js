var express = require('express');
var router = express.Router();

const { Connection } = require('../config/mongo-connection');

router.get('/', (req, res) => {
    res.send("Elements Node GET Request");
});

module.exports = router;