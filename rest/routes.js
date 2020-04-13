module.exports = function(app) {
    app.use('/device', require("./routes/device.js"));
}