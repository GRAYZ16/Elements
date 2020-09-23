const { mongodb } = require('./config');
const mongoose = require('mongoose');

class Connection {
    static connectToMongo() {
        if ( this.db ) return Promise.resolve(this.db);  
        mongoose.connect(this.url.concat('/', this.DB_NAME), {useNewUrlParser: true});

        this.db = mongoose.connection;

        this.db.on('error', console.error.bind(console, 'connection error: '));

        this.db.once('open', function() {
            console.log('REST bound to mongodb');
        });

        return this.db;
    }
}

Connection.db = null;
Connection.url = mongodb.URL;
Connection.db_name = mongodb.DB_NAME;
Connection.options = {
    bufferMaxEntries:   0,
    reconnectTries:     5000,
    useNewUrlParser:    true,
    useUnifiedTopology: true,
};

module.exports = { Connection };