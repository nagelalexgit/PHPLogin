DROP SCHEMA IF EXISTS `testDB` ;
CREATE SCHEMA IF NOT EXISTS `testDB` ;

USE testDB;

DROP TABLE IF EXISTS `emps`;
DROP TABLE IF EXISTS `patients`;
DROP TABLE IF EXISTS `bayregister`;

CREATE TABLE emps (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
				username VARCHAR(50) NOT NULL UNIQUE, 
					password VARCHAR(255) NOT NULL,
						department VARCHAR(50), 
							reg_date DATETIME DEFAULT CURRENT_TIMESTAMP);
                            
CREATE TABLE patients (pid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
				pname VARCHAR(50) NOT NULL, 
					ptype VARCHAR(25) NOT NULL,
							reg_date DATETIME DEFAULT CURRENT_TIMESTAMP);

                            
CREATE TABLE bayregister (id INT NOT NULL PRIMARY KEY,
				pid int NOT NULL, assignStatus bool, assignTime timestamp,
					reqStatus bool, reqTime timestamp, transStatus bool, transTime timestamp,
						alarmStatus bool, alarmTime timestamp, 
							note VARCHAR(255));
                            
INSERT INTO bayregister values(1,25,0,null,0,null,0,null,0,null,"bherfbehfugfbhhu");
INSERT INTO bayregister values(2,27,0,null,0,null,0,null,0,null,"bherfbehfugfbhhu");
INSERT INTO bayregister values(3,29,0,null,0,null,0,null,0,null,"bherfbehfugfbhhu");
INSERT INTO bayregister values(4,21,0,null,0,null,0,null,0,null,"bherfbehfugfbhhu");
INSERT INTO bayregister values(5,22,0,null,0,null,0,null,0,null,"bherfbehfugfbhhu");
INSERT INTO bayregister values(6,12,0,null,0,null,0,null,0,null,"bherfbehfugfbhhu");
INSERT INTO bayregister values(7,34,0,null,0,null,0,null,0,null,"bherfbehfugfbhhu");
INSERT INTO bayregister values(8,67,0,null,0,null,0,null,0,null,"bherfbehfugfbhhu");

SELECT * FROM bayregister;
SELECT * FROM patients;
                            

 

