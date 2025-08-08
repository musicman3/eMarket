ALTER TABLE emkt_basic_settings ADD COLUMN logo text;
ALTER TABLE emkt_basic_settings ADD COLUMN logo_general text(128);
ALTER TABLE emkt_basic_settings DROP COLUMN logo_general;
ALTER TABLE emkt_basic_settings DROP COLUMN logo;