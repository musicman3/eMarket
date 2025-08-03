delimiter $$ DROP
    PROCEDURE IF EXISTS foo $$ CREATE
        PROCEDURE foo() BEGIN DECLARE CONTINUE handler FOR 1060 BEGIN
    END;

ALTER TABLE
    emkt_basic_settings ADD logo_general VARCHAR(128);

ALTER TABLE
    emkt_basic_settings ADD logo json;
END $$ CALL foo() $$
