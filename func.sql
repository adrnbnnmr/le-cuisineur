CREATE OR REPLACE FUNCTION badusers() 
RETURNS TABLE(
    login_utilisateur varchar,
    nbNotes int
) 
AS $$

BEGIN
    RETURN QUERY EXECUTE(
        'SELECT uti_login, count(note) as nbNotes
        FROM NOTATION 
        WHERE note <= 1
        GROUP BY uti_login'
    );
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION rctHasard($cat) 
RETURN TABLE(
    rct_label
)

CREATE OR REPLACE FUNCTION menu() 
RETURNS TABLE(
    rct_label

) 
AS $$

BEGIN
    RETURN QUERY EXECUTE(
        'SELECT uti_login, count(note) as nbNotes
        FROM NOTATION 
        WHERE note <= 1
        GROUP BY uti_login'
    );
END;
$$ LANGUAGE plpgsql;







SELECT uti_login FROM UTILISATEUR u
WHERE uti_login in (SELECT uti_login from NOTATION WHERE note <= 1)


INNER JOIN NOTATION n ON u.uti_login = n.uti_login
WHERE (SELECT COUNT )



-- CREATE OR REPLACE FUNCTION get_film (p_pattern VARCHAR) 
--    RETURNS TABLE (
--       film_title VARCHAR,
--       film_release_year INT
-- ) 
-- AS $$
-- BEGIN
--    RETURN QUERY SELECT
--       title,
--       cast( release_year as integer)
--    FROM
--       film
--    WHERE
--       title ILIKE p_pattern ;
-- END; $$ 
 
-- LANGUAGE 'plpgsql';