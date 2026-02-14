-- Création d'une view joignant exch_object, exch_user et exch_category
-- Date: 2026-02-14

DROP VIEW IF EXISTS v_exch_object_details;

CREATE VIEW v_exch_object_details AS
SELECT 
    o.id,
    o.id_user,
    o.id_category,
    o.obj_name,
    o.descript,
    o.prix,
    u.username,
    c.nomcategory,
    c.path_img AS category_img
FROM exch_object o
LEFT JOIN exch_user u ON o.id_user = u.id
LEFT JOIN exch_category c ON o.id_category = c.id;
