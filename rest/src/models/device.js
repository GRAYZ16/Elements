var mongoose = require('mongoose');
const { ObjectID } = require('mongodb');

var LocationSchema = new mongoose.Schema({
    from: {
        type: Date,
        required: [true, 'Initial Date Required']
    }, 
    to: Date, 
    site: ObjectID
});

var SensorSchema = new mongoose.Schema({
    description: String, 
    meta: [{units: String, accuracy: Number, max: Number, min: Number}]
})

var DeviceSchema = new mongoose.Schema({
    macAddress: {
        type: String,
        required: [true, 'Device MAC Required']
    },
    name: String,        
    description: String,
    locationHistory: [LocationSchema],
    sensors: [SensorSchema]
});

const DeviceModel = new mongoose.model("Device", DeviceSchema, "Devices");

module.exports = DeviceModel;