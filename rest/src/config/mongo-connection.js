const assert = require('assert');
const { mongodb } = require('./config');
const MongoClient = require('mongodb').MongoClient;

class Connection {
    static connectToMongo() {
        if ( this.db ) return Promise.resolve(this.db);  
        MongoClient.connect(this.url.concat('/', this.DB_NAME), function (err, db) {
            assert.equal(null, err);
            Connection.db = db.db('elements');
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