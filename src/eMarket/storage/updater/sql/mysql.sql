ALTER TABLE emkt_basic_settings ADD logo_general VARCHAR(128);
ALTER TABLE emkt_basic_settings ADD logo json;
ALTER TABLE emkt_basic_settings DROP COLUMN logo_general;
ALTER TABLE emkt_basic_settings DROP COLUMN logo;