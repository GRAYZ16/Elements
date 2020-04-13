var express = require('express');
var router = express.Router();

router.get('/', (req, res) => {
    res.send("Device GET Request");
});

module.exports = router;