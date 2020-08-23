module.exports = function(app) {
    app.use('/device', require("./routes/device.js"));
    app.use('/node', require('./routes/node'))
}