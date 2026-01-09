CREATE TABLE kiroku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jugyoin_id VARCHAR(20) NOT NULL,
    start_work DATETIME,
    end_work DATETIME
);

CREATE TABLE employees (
    jugyoin_id VARCHAR(20) PRIMARY KEY,
    sei VARCHAR(50) NOT NULL,
    mei VARCHAR(50) NOT NULL
);