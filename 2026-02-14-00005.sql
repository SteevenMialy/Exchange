ALTER TABLE exch_proposition
ADD COLUMN date_proposal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

UPDATE exch_proposition
SET date_proposal = NOW()
WHERE date_proposal IS NULL;

CREATE OR REPLACE VIEW v_proposition_details AS
SELECT 
    p.id,
    p.id_object_offered,
    p.id_object_requested,
    p.id_user_offered,
    p.id_user_requested,
    p.id_status,
    p.date_proposal,
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
