CREATE TABLE exch_category (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomcategory VARCHAR(255)
);
CREATE TABLE exch_object (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    id_category INT,
    descript TEXT,
    prix NUMBER(10,2),

    CONSTRAINT fk_category 
    FOREIGN KEY (id_category) 
    REFERENCES exch_category(id)

    CONSTRAINT fk_object_user
    FOREIGN KEY (id_user) 
    REFERENCES exch_user(id)

);

CREATE TABLE exch_pictures (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_object INT,
    path_img VARCHAR(255),

    CONSTRAINT fk_object 
    FOREIGN KEY (id_object) 
    REFERENCES exch_object(id)
);