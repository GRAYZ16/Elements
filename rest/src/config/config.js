

const mongodb = {
    URL: 'mongodb://192.168.0.3:27017',
    PORT: '27017',
    USER: 'ELEMENTS',
    DB_NAME: 'elements'
};

const server = {
    port: 8080,
    hostname: '0.0.0.0'
};

module.exports = {
    mongodb,
    server
}