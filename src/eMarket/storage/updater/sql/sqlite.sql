ALTER TABLE emkt_basic_settings ADD COLUMN logo text;
ALTER TABLE emkt_basic_settings ADD COLUMN logo_general text(128);
ALTER TABLE emkt_basic_settings DROP COLUMN logo_general;
ALTER TABLE emkt_basic_settings DROP COLUMN logo;
DROP TABLE IF EXISTS emkt_contacts;
CREATE TABLE emkt_contacts (language text(64),logo text,logo_general text(128),status int,description text,PRIMARY KEY (language));
