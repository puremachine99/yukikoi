const mysql = require('mysql2/promise');
require('dotenv').config();

let connection;

async function getDb() {
  if (!connection) {
    connection = await mysql.createConnection({
      host: process.env.DB_HOST,
      user: process.env.DB_USERNAME,
      password: process.env.DB_PASSWORD,
      database: process.env.DB_DATABASE,
      port: process.env.DB_PORT || 3306
    });
  }
  return connection;
}

module.exports = { getDb };