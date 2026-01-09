CREATE TABLE kiroku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jugyoin_id VARCHAR(20) NOT NULL,
    start_work DATETIME,
    end_work DATETIME
);