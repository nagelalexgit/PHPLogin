DROP SCHEMA IF EXISTS `testDB` ;
CREATE SCHEMA IF NOT EXISTS `testDB` ;

USE testDB;

DROP TABLE IF EXISTS `emps`;
DROP TABLE IF EXISTS `patients`;
DROP TABLE IF EXISTS `bayregister`;

CREATE TABLE emps (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
				username VARCHAR(50) NOT NULL, 
					password VARCHAR(255) NOT NULL,
						department VARCHAR(50), 
							reg_date DATETIME DEFAULT CURRENT_TIMESTAMP);
                            
CREATE TABLE patients (pid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
				ptitle VARCHAR(6) NOT NULL,
					pfname VARCHAR(50) NOT NULL,
						psname VARCHAR(50) NOT NULL,
							ptype VARCHAR(25) NOT NULL,
								reg_date DATETIME DEFAULT CURRENT_TIMESTAMP);

                            
CREATE TABLE bayregister (id INT NOT NULL PRIMARY KEY,
				pid int NOT NULL, assignStatus bool, assignTime timestamp,
					reqStatus bool, reqTime timestamp, transStatus bool, transTime timestamp,
						alarmStatus bool, alarmTime timestamp, 
							note VARCHAR(255),
								pubnote VARCHAR(255));
                            
INSERT INTO bayregister values(1,0,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,"None","None");
INSERT INTO bayregister values(2,0,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,"None","None");
INSERT INTO bayregister values(3,0,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,"None","None");
INSERT INTO bayregister values(4,0,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,"None","None");
INSERT INTO bayregister values(5,0,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,"None","None");
INSERT INTO bayregister values(6,0,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,"None","None");
INSERT INTO bayregister values(7,0,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,"None","None");
INSERT INTO bayregister values(8,0,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,0,CURRENT_TIMESTAMP,"None","None");

SELECT * FROM bayregister;
SELECT * FROM patients;
SELECT * FROM emps;



## SELECT pid FROM patients ORDER BY pid DESC LIMIT 1;

## UPDATE bayregister SET pid = 6, assignStatus = true, assignTime = '2018-05-22 00:00:00' WHERE id = 4;
                            

 

