const { Connection } = require('../config/mongo-connection');

exports.getDevice = function(req, res)
{
    Connection.db.collection('Devices').find({id: parseInt(req.params.deviceId)}).toArray(function (e, result) {

        if (e) 
        {
            res.statusCode = 500;
            res.json({err: e});
        }
        else if (result.length != 1)
        {
            res.statusCode = 404;
            res.json({err: "The Requested Device ID cant be found."});
        }
        else
        {
            res.json(result[0]);
        }    
      });
};

exports.queryDevices = function(req, res)
{
    for (const key in req.query) 
    {
        switch (key) {
            case 'contains':
                var searchString = req.query[key];
                
                Connection.db.collection('Devices').find({deviceName: new RegExp(searchString, 'g')}).toArray(function(e, result) {
                    if(e)
                    {
                        res.statusCode = 500;
                        res.json({err: e});
                    }
                    else
                    {
                        res.json(result);
                    }
                });
                break;

            case 'id':

                break;

            case 'startsWith':

                break;

            case 'endsWith':

                break;
        
            default:
                res.send("None");
                break;
        }
    }
};


exports.createDevice = function(req, res)
{
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

            //TODO: Finish Device Enrollment

            res.send({status: "Object Created", objectId: 1});
        }
    });
};

exports.updateDevice = function(req, res)
{
    res.send('Update Device not yet implemented');
};

exports.deleteDevice = function(req, res)
{
    res.send('Delete Device not yet implemented.')
}