CREATE TABLE exch_user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50),
    pwd VARCHAR(20)
);

CREATE TABLE exch_admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    pwd VARCHAR(100),

    CONSTRAINT fk_admin 
    FOREIGN KEY (id_user) 
    REFERENCES exch_user(id)
);
