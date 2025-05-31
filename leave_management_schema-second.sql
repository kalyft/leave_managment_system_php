CREATE DATABASE lms_db;
USE lms_db;

-- table employees
CREATE TABLE tEmployee (
    id         INT         AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50)                           NOT NULL UNIQUE,
    password   VARCHAR(255)                          NOT NULL,
    full_name  VARCHAR(100)                          NOT NULL,
    email      VARCHAR(255)                          NOT NULL,
    created_at TIMESTAMP                                      DEFAULT CURRENT_TIMESTAMP
);

-- table admin
CREATE TABLE tAdmin (
    id         INT         AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50)                           NOT NULL UNIQUE,
    password   VARCHAR(255)                          NOT NULL,
    full_name  VARCHAR(100)                          NOT NULL,
    email      VARCHAR(255)                          NOT NULL,
    created_at TIMESTAMP                                      DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tVacationReason (
    id          INT       AUTO_INCREMENT PRIMARY KEY,
    reason_key  VARCHAR(50)          UNIQUE NOT NULL,
    label       VARCHAR(100)                NOT NULL,
    is_active   BOOLEAN   DEFAULT TRUE,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Vacation requests
CREATE TABLE tVacationRequest (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    employee_id      INT                            NOT NULL,
    start_date       DATE                           NOT NULL,
    end_date         DATE                           NOT NULL,
    reason_id        INT                            NOT NULL,
    duration         INT                            NOT NULL,
    status           ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    submitted_at     TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id)   REFERENCES tEmployee(id)
    FOREIGN KEY (reason_id)     REFERENCES tVacationReason(id)
);

-- table admin
CREATE TABLE tAdminEployee (
    admin_id     INT       NOT NULL,
    employee_id  INT       NOT NULL,
    PRIMARY KEY(admin_id, employee_id),
    FOREIGN KEY (employee_id)  REFERENCES tEmployee(id)
    FOREIGN KEY (admin_id)     REFERENCES tAdmin(id)
);


-- Insert initial values
INSERT INTO tVacationReason (reason_key, label) VALUES 
('sick_leave', 'Sick Leave'),
('holiday', 'Annual Leave/Holiday'),
('maternity_leave', 'Maternity Leave'),
('paternity_leave', 'Paternity Leave'),
('bereavement_leave', 'Bereavement Leave'),
('personal_leave', 'Personal Leave');



INSERT INTO tAdmin (username,password,full_name,email) VALUES 
('admin','$2y$10$CpbYkV1m.PTmqxbvFwQ5pu.B/h0GnGxEZVA2fNfJgaxVT4oND/N6S','Giorgos Georgiou', 'admin@lms.com');