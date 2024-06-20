
USE newQuotation;

DROP TABLE IF EXISTS quotations;
CREATE TABLE quotations(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quotationNo int NOT NULL DEFAULT '1',
    chargeDays int default 0,
    customerId int,
    patientId int,
    chargeMode  VARCHAR(50) default 'Daily',
    feeFor  VARCHAR(50),
    physiotherapy VARCHAR(10) default 'No',
    nurseVisit VARCHAR(10) default 'No',
    doktorVisit VARCHAR(10) default 'No',
    quotationDate DATE,
    hourPerDay int,
    dayPerWeek int,
    basicCharge double,
    startTimeDaily TIME,
    endTimeDaily TIME,
    startDate DATE,
    endDate DATE,
    mileage double default 0,
    adminFee double default 0,
    additionalCharge double default 0,
    gst double default 0,
    discount double default 0,
    totalAmount double default 0,
    totalPaid double default 0,
    amountDue double default 0,
    statusPaid int,
    status int DEFAULT 0,
    createdDate DATETIME ,
    createdId int
);

ALTER TABLE `quotations` ADD `locumFees` VARCHAR(100) NOT NULL AFTER `status`;
ALTER TABLE `quotations` ADD `subTotalAmount` double default 0 AFTER `totalAmount`;
ALTER TABLE `quotations` ADD `reasonAdditionalCharge` VARCHAR(100) NOT NULL DEFAULT 'Work On Weekend' AFTER `locumFees`;
ALTER TABLE `quotations` ADD `introducer` VARCHAR(100) NOT NULL DEFAULT 'Google' AFTER `reasonAdditionalCharge`;


CREATE TABLE usertypes(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,	
    userType VARCHAR(100) NOT NULL,
    defaultPage VARCHAR(200) NOT NULL
);

INSERT INTO usertypes(userType,defaultPage) VALUES('admin','home.php');
INSERT INTO usertypes(userType,defaultPage) VALUES('user','marketing.php');



CREATE TABLE users(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,	
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    lastname VARCHAR(100),
    firstname VARCHAR(100),
    userType int DEFAULT 0,
	status int DEFAULT 0,
    createdDate DATETIME ,
    createdId int,
    userTypeData VARCHAR(100)

);

INSERT INTO users(username,password,lastname,firstname,userType,status,createdDate,createdId) VALUES ('shima',md5('shima'),'Samad','Shima',2,1,Now(),0);

CREATE TABLE contacts(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contactTypeId int,	
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100),
    ic VARCHAR(100),
    address VARCHAR(200),
    city VARCHAR(100),
    state VARCHAR(50),
    postcode VARCHAR(50),
    mobile VARCHAR(50),
    office VARCHAR(50),
    home VARCHAR(50),
    fax VARCHAR(50),
    email VARCHAR(100),
    createdDate DATETIME,
    createdId int
);

ALTER TABLE `contacts` ADD `contactCode` VARCHAR(100) NOT NULL AFTER `id`;

INSERT INTO contacts(contactTypeId,contactCode,firstName,lastName,ic,address,city,state,postcode,mobile,office,home,fax,email,createdDate,createdId) VALUES (1,'CA0123','shima','samad','34343434343','addd','city','state','32232','01434334','034343434','03675644','0355422','email@com',Now(),1);



CREATE TABLE contacttypes(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,	
    contactType VARCHAR(100) NOT NULL
);


INSERT INTO contacttypes(contactType) VALUES ('CUSTOMER');
