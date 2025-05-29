CREATE DATABASE lms_db;
USE lms_db;

-- Users table (employees + managers)
CREATE TABLE users (
    id         INT         AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50)                           NOT NULL UNIQUE,
    password   VARCHAR(255)                          NOT NULL,
    role       ENUM('employee', 'manager')           NOT NULL,
    full_name  VARCHAR(100)                          NOT NULL,
    email      VARCHAR(255)                          NOT NULL,
    created_at TIMESTAMP                                      DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vacation_reasons (
    id          INT       AUTO_INCREMENT PRIMARY KEY,
    reason_key  VARCHAR(50)          UNIQUE NOT NULL,
    label       VARCHAR(100)                NOT NULL,
    is_active   BOOLEAN   DEFAULT TRUE,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Vacation requests
CREATE TABLE vacation_requests (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    user_id          INT                            NOT NULL,
    start_date       DATE                           NOT NULL,
    end_date         DATE                           NOT NULL,
    reason_id        INT                            NOT NULL,
    duration         INT                            NOT NULL,
    status           ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    submitted_at     TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)   REFERENCES users(id)
    FOREIGN KEY (reason_id) REFERENCES vacation_reasons(id)
);


-- Insert initial values
INSERT INTO vacation_reasons (reason_key, label) VALUES 
('sick_leave', 'Sick Leave'),
('holiday', 'Annual Leave/Holiday'),
('maternity_leave', 'Maternity Leave'),
('paternity_leave', 'Paternity Leave'),
('bereavement_leave', 'Bereavement Leave'),
('personal_leave', 'Personal Leave');

INSERT INTO users (username,password,role,full_name,email) VALUES 
('admin','$2y$10$CpbYkV1m.PTmqxbvFwQ5pu.B/h0GnGxEZVA2fNfJgaxVT4oND/N6S','manager','Giorgos Georgiou', 'admin@lms.com');