# CPSC332

# Getting Started 

## Clone the Repository
```
git clone
cd CPSC332
```

## Connect to MySQL 
```
mysql -h localhost -u root -p
```

Create a new database named "UNIVERSITY"
```
CREATE DATABASE UNIVERSITY;
```

Select the "UNIVERSITY" database to use
```
USE UNIVERSITY;
```

Run "tables.sql" to create tables in "UNIVERSITY" and add data to those tables
```
SOURCE tables.sql
```

Exit MySQL using "CRTL + D"

## Edit DB_Credentials.php
Change dbUsername, dbPassword, and dbName
```
<?php
  putenv("dbUsername=root");
  putenv("dbPassword=YOUR_PASSWORD");
  putenv("dbName=university");
?>
```

## Install Dependencies 
```
npm install
```

## Start [localhost:3000](http://localhost:3000/)
```
npm start
```
