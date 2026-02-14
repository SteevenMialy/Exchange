CREATE TABLE exch_statusProposition (
    id INT(11) NOT NULL AUTO_INCREMENT,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    PRIMARY KEY (id)
);

INSERT INTO exch_statusProposition (status) VALUES
('pending'),
('accepted'),
('rejected');

CREATE TABLE exch_proposition (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_object_offered INT(11),
    id_object_requested INT(11),
    id_user_offered INT(11),
    id_user_requested INT(11),
    id_status INT(11) DEFAULT 1, -- 1 correspond à 'pending'
    PRIMARY KEY (id),
    FOREIGN KEY (id_object_offered) REFERENCES exch_object(id),
    FOREIGN KEY (id_object_requested) REFERENCES exch_object(id),
    FOREIGN KEY (id_user_offered) REFERENCES exch_user(id),
    FOREIGN KEY (id_user_requested) REFERENCES exch_user(id)
);

CREATE VIEW v_proposition_details AS
SELECT 
    p.id,
    p.id_object_offered,
    p.id_object_requested,
    p.id_user_offered,
    p.id_user_requested,
    s.status,
    o_offered.obj_name AS offered_obj_name,
    o_requested.obj_name AS requested_obj_name,
    u_offered.username AS offered_username,
    u_requested.username AS requested_username
FROM exch_proposition p
JOIN exch_statusProposition s ON p.id_status = s.id
JOIN exch_object o_offered ON p.id_object_offered = o_offered.id
JOIN exch_object o_requested ON p.id_object_requested = o_requested.id
JOIN exch_user u_offered ON p.id_user_offered = u_offered.id
JOIN exch_user u_requested ON p.id_user_requested = u_requested.id;

CREATE TABLE exch_exchange_history (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_proposition INT(11),
    date_exchange DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (id_proposition) REFERENCES exch_proposition(id)
);

CREATE OR REPLACE VIEW v_exchange_history AS
SELECT 
    h.id,
    h.date_exchange,
    p.id_object_offered,
    p.id_object_requested,
    o_offered.obj_name AS offered_obj_name,
    o_requested.obj_name AS requested_obj_name,
    u_offered.username AS offered_username,
    u_requested.username AS requested_username
FROM exch_exchange_history h
JOIN exch_proposition p ON h.id_proposition = p.id
JOIN exch_object o_offered ON p.id_object_offered = o_offered.id
JOIN exch_object o_requested ON p.id_object_requested = o_requested.id
JOIN exch_user u_offered ON p.id_user_offered = u_offered.id
JOIN exch_user u_requested ON p.id_user_requested = u_requested.id;
