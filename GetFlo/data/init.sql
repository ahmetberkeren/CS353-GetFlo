CREATE DATABASE test;

  use test;

    CREATE TABLE users(
        ID INT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE ,
        password VARCHAR(255) NOT NULL,
        type VARCHAR(255) NOT NULL
    );
    CREATE TABLE customers(
        name VARCHAR(255) NOT NULL,
        gender VARCHAR(255),
        phone_number VARCHAR(20) NOT NULL,
        customerID INT PRIMARY KEY AUTO_INCREMENT REFERENCES users(ID) ON DELETE CASCADE ,
        password VARCHAR(255) REFERENCES users(password) ON DELETE CASCADE ,
        username VARCHAR(255) REFERENCES users(username) ON DELETE CASCADE
    );
    ALTER TABLE customers AUTO_INCREMENT = 1001;
    CREATE TABLE flowersellers(
        company_name varchar(255) NOT NULL,
        rating float(8,4),
        people_rated int,
        phone_number varchar(20) NOT NULL,
        sellerID INT PRIMARY KEY AUTO_INCREMENT REFERENCES users(ID) ON DELETE CASCADE ,
        username varchar(255) NOT NULL UNIQUE REFERENCES users(username) ON DELETE CASCADE ,
        password varchar(255) NOT NULL REFERENCES  users(password) ON DELETE CASCADE
    );
    ALTER TABLE flowersellers AUTO_INCREMENT = 2001;
    CREATE TABLE couriers(
        name varchar(255) NOT NULL,
        rating float(8,4),
        people_rated int,
        phone_number varchar(20) NOT NULL,
        courierID INT PRIMARY KEY AUTO_INCREMENT REFERENCES users(ID) ON DELETE CASCADE ,
        username varchar(255) NOT NULL UNIQUE REFERENCES users(username) ON DELETE CASCADE ,
        password varchar(255) NOT NULL REFERENCES users(password) ON DELETE CASCADE
    );
    ALTER TABLE couriers AUTO_INCREMENT = 3001;

    CREATE TABLE customer_service(
         name varchar(255) NOT NULL,
         serviceID INT PRIMARY KEY AUTO_INCREMENT REFERENCES users(ID) ON DELETE CASCADE ,
         username varchar(255) NOT NULL UNIQUE REFERENCES users(username) ON DELETE CASCADE ,
         password varchar(255) NOT NULL REFERENCES users(password) ON DELETE CASCADE
    );
    ALTER TABLE customer_service AUTO_INCREMENT = 4001;

    CREATE TABLE orders(
        orderID int PRIMARY KEY AUTO_INCREMENT,
        order_time date,
        payment_type varchar(255) NOT NULL,
        delivery_address varchar(255) NOT NULL,
        delivery_type varchar(255),
        note varchar(255),
        status varchar(255),
        is_accepted boolean
    );

    CREATE TABLE is_assigned(
        orderID int NOT NULL PRIMARY KEY REFERENCES orders(orderID) ON DELETE CASCADE,
        courierID int REFERENCES couriers(courierID) ON DELETE CASCADE ON UPDATE CASCADE ,
        sellerID int NOT NULL REFERENCES flowersellers(sellerID) ON DELETE CASCADE,
        customerID int NOT NULL REFERENCES customers(customerID) ON DELETE CASCADE
    );

    CREATE TABLE complaint_form(
        complaintID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        message varchar(255) NOT NULL,
        subject varchar(255),
        is_answered boolean,
        orderID int NOT NULL REFERENCES orders(orderID) ON DELETE CASCADE
    );

    CREATE TABLE receives(
        serviceID int NOT NULL,
        complaintID int NOT NULL REFERENCES complaint_form(complaintID) ON DELETE CASCADE,
        PRIMARY KEY (serviceID, complaintID)
    );

    CREATE TABLE flowers(
       flowerID int PRIMARY KEY AUTO_INCREMENT,
       name varchar(255) NOT NULL,
       sellerID int NOT NULL REFERENCES flowersellers(sellerID) ON DELETE CASCADE ,
       scent varchar(255),
       colour varchar(255),
       price float(8,4) NOT NULL,
       photo varchar(255),
       kind varchar(255),
       amount int,
       details varchar(255)
    );
