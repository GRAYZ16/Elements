const assert = require('assert');
const { mongodb } = require('./config');
const MongoClient = require('mongodb').MongoClient;

class Connection {
    static connectToMongo() {
        if ( this.db ) return Promise.resolve(this.db);  
        MongoClient.connect(this.url, function (err, db) {
            assert.equal(null, err);
            Connection.db = db.db('elements');
        });
        return this.db;
    }
}

Connection.db = null;
Connection.url = 'mongodb://192.168.0.3:27017/elements';
Connection.db_name = 'elements';
Connection.options = {
    bufferMaxEntries:   0,
    reconnectTries:     5000,
    useNewUrlParser:    true,
    useUnifiedTopology: true,
};

module.exports = { Connection };