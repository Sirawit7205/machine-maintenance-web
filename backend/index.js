const express = require("express")
const cors = require("cors")
const mysql = require("mysql")
const bodyParser = require('body-parser')

const app = express()
const conn = mysql.createConnection({ 
  host: "localhost",
  user: "root",
  password: "",
  database: "art_course"
 })
conn.connect()

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: true }))

app.use(cors())

app.get("/:id", function (req, res) {
  conn.query("SELECT * FROM course WHERE CourseNumber = ? AND Fee > ?",
  [ req.params.id, req.query.fee ], (err, result) => {
    res.json(result)
  })
})

app.post("/", (req, res) => {
  conn.query("SELECT * FROM course WHERE CourseNumber = ?",
  [ req.body.id ], (err, result) => {
    res.json(result[0])
  })
})

app.listen(8888, () => console.log("Running on port 8888."))
