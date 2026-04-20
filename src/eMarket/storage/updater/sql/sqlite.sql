ALTER TABLE emkt_basic_settings ADD COLUMN logo text;
ALTER TABLE emkt_basic_settings ADD COLUMN logo_general text(128);
ALTER TABLE emkt_basic_settings DROP COLUMN logo_general;
ALTER TABLE emkt_basic_settings DROP COLUMN logo;
CREATE TABLE emkt_contacts (id int NOT NULL,language text(64),logo text,logo_general text(128),status int,description text,PRIMARY KEY (language));
CREATE TABLE emkt_about_us (id int NOT NULL,language text(64),logo text,logo_general text(128),status int,description text,PRIMARY KEY (language));
CREATE TABLE emkt_shipping (id int NOT NULL,language text(64),logo text,logo_general text(128),status int,description text,PRIMARY KEY (language));
