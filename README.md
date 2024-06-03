# newquotation
My simple quotation project


  -- db : newQuotation


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


CREATE TABLE userTypes(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,	
    userType VARCHAR(100) NOT NULL,
    defaultPage VARCHAR(200) NOT NULL
);

INSERT INTO userTypes(userType,defaultPage) VALUES('admin','home.php');
INSERT INTO userTypes(userType,defaultPage) VALUES('user','marketing.php');



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

INSERT INTO users(username,password,lastname,firstname,userType,status,createdDate,createdId) VALUES ('shima','shima','Samad','Shima',2,1,Now(),0);


