const express = require('express')

const app = express()
const port = 8080
const hostname = '0.0.0.0'

app.get('/', (req, res) => res.send("Hello World!"))

app.listen(port, hostname, () => console.log(`App running on http://${hostname} listening on port ${port}`))