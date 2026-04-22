ALTER TABLE emkt_basic_settings ADD COLUMN logo jsonb;
ALTER TABLE emkt_basic_settings ADD COLUMN logo_general varchar(128);
ALTER TABLE emkt_basic_settings DROP COLUMN logo_general;
ALTER TABLE emkt_basic_settings DROP COLUMN logo;
CREATE TABLE IF NOT EXISTS emkt_contacts (id int NOT NULL, language varchar(64),logo jsonb,logo_general varchar(128),status int,description text,PRIMARY KEY (language));
CREATE TABLE IF NOT EXISTS emkt_about_us (id int NOT NULL, language varchar(64),logo jsonb,logo_general varchar(128),status int,description text,PRIMARY KEY (language));
CREATE TABLE IF NOT EXISTS emkt_shipping (id int NOT NULL, language varchar(64),logo jsonb,logo_general varchar(128),status int,description text,PRIMARY KEY (language));
