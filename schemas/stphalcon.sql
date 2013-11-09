DROP TABLE IF EXISTS companies;
CREATE TABLE companies (
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(70) COLLATE utf8_spanish_ci NOT NULL,
    telephone VARCHAR(30) COLLATE utf8_spanish_ci NOT NULL,
    address VARCHAR(40) COLLATE utf8_spanish_ci NOT NULL,
    city VARCHAR(40) COLLATE utf8_spanish_ci NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

LOCK TABLES companies WRITE;
INSERT INTO companies 
VALUES 
(1,'Acme','31566564','Address','Hello'),
(2,'Acme Inc','+44 564612345','Guildhall, PO Box 270, London','London');
UNLOCK TABLES;

DROP TABLE IF EXISTS contact;
CREATE TABLE contact (
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(70) COLLATE utf8_spanish_ci NOT NULL,
    email VARCHAR(70) COLLATE utf8_spanish_ci NOT NULL,
    comments TEXT COLLATE utf8_spanish_ci NOT NULL,
    created_at DATETIME DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

DROP TABLE IF EXISTS product_types;
CREATE TABLE product_types (
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(70) COLLATE utf8_spanish_ci NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
LOCK TABLES product_types WRITE;
INSERT INTO product_types VALUES 
(5,'Vegetables'),
(6,'Fruits');
UNLOCK TABLES;

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  product_types_id INT(10) UNSIGNED NOT NULL,
  name VARCHAR(70) COLLATE utf8_spanish_ci NOT NULL,
  price DECIMAL(16,2) NOT NULL,
  active ENUM('Y','N') COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
LOCK TABLES products WRITE;
INSERT INTO products VALUES 
(1,5,'Artichoke','10.50','Y'),
(2,5,'Bell pepper','10.40','Y'),
(3,5,'Cauliflower','20.10','Y'),
(4,5,'Chinese cabbage','15.50','Y'),
(5,5,'Malabar spinach','7.50','Y'),
(6,5,'Onion','3.50','Y'),
(7,5,'Peanut','4.50','Y');
UNLOCK TABLES;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(32) COLLATE utf8_spanish_ci NOT NULL,
  password char(40) COLLATE utf8_spanish_ci NOT NULL,
  name VARCHAR(120) COLLATE utf8_spanish_ci NOT NULL,
  email VARCHAR(70) COLLATE utf8_spanish_ci NOT NULL,
  created_at DATETIME NOT NULL,
  active char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
LOCK TABLES users WRITE;
INSERT INTO users VALUES (1,'demo','c0bd96dc7ea4ec56741a4e07f6ce98012814d853','Phalcon Demo','demo@phalconphp.com','2012-04-10 20:53:03','Y');
UNLOCK TABLES;
