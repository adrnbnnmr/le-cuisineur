\c lecuisineur;


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





------------------- NOT WORKING-----------------------------
-- CREATE OR REPLACE FUNCTION rctHasard($cat) 
-- RETURN TABLE(
--     uti_login varchar, 
--     cat_label varchar, 
--     rct_date timestamp, 
--     rct_titre varchar, 
--     rct_description text, 
--     rct_temps_preparation smallint, 
--     rct_temps_cuisson smallint, 
--     rct_temps_repos smallint, 
--     rct_difficulte smallint, 
--     rct_cout smallint, 
--     rct_illustration varchar, 
--     rct_nb_personnes smallint
-- )
-- AS $$

-- BEGIN
--     RETURN QUERY EXECUTE(
--         'SELECT uti_login, cat_label, rct_date, rct_titre, rct_description, 
--         rct_temps_preparation, rct_temps_cuisson, rct_temps_repos, 
--         rct_difficulte, rct_cout, rct_illustration, rct_nb_personnes
--         FROM RECETTE
--         WHERE cat_label = $cat'
--     );
-- END;
-- $$ LANGUAGE plpgsql;



-- CREATE OR REPLACE FUNCTION menu() 
-- RETURNS TABLE(
--     uti_login varchar, 
--     cat_label varchar, 
--     rct_date timestamp, 
--     rct_titre varchar, 
--     rct_description text, 
--     rct_temps_preparation smallint, 
--     rct_temps_cuisson smallint, 
--     rct_temps_repos smallint, 
--     rct_difficulte smallint, 
--     rct_cout smallint, 
--     rct_illustration varchar, 
--     rct_nb_personnes smallint

-- ) 
-- AS $$

-- BEGIN
--     RETURN QUERY EXECUTE(
--         'SELECT rctHasard("entrée")
--         UNION ALL
--         SELECT rctHasard("plat")
--         UNION ALL
--         SELECT rctHasard("dessert")'
--     );
-- END;
-- $$ LANGUAGE plpgsql;








