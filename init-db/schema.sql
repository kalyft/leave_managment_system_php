-- CREATE DATABASE lms_db;
USE lms_db;

-- Users table
CREATE TABLE tUser (
    id         INT         AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50)                           NOT NULL UNIQUE,
    password   VARCHAR(255)                          NOT NULL,
    role       ENUM('employee', 'manager')           NOT NULL,
    full_name  VARCHAR(100)                          NOT NULL,
    email      VARCHAR(255)                          NOT NULL,
    created_at TIMESTAMP                                      DEFAULT CURRENT_TIMESTAMP
);

-- Vacation requests
CREATE TABLE tVacationRequest (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    user_id          INT                            NOT NULL,
    start_date       DATE                           NOT NULL,
    end_date         DATE                           NOT NULL,
    reason           ENUM('sick_leave', 'holiday', 'maternity_leave', 'paternity_leave') DEFAULT 'holiday' NOT NULL,
    status           ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    submitted_at     TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tUser(id)
);

insert into tUser (username, password,role, full_name, email) values ('admin', '$2y$10$VXZxkTeq0wZY9Qg0KQsoge4y6TxZxO5MLxEvGdj/Fs69SkEPphcBC','manager', 'Giorgos Georgiou', 'admin@lms.com');