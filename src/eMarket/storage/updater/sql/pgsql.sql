ALTER TABLE emkt_basic_settings ADD COLUMN logo jsonb;
ALTER TABLE emkt_basic_settings ADD COLUMN logo_general varchar(128);
ALTER TABLE emkt_basic_settings DROP COLUMN logo_general;
ALTER TABLE emkt_basic_settings DROP COLUMN logo json;