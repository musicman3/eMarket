/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* Add tables */

DROP TABLE IF EXISTS emkt_administrators;
CREATE TABLE emkt_administrators (
	login varchar(128) NOT NULL,
	password varchar(256) NOT NULL,
	language varchar(64) NOT NULL,
	permission varchar(20) NOT NULL,
	note varchar(256),
	status int DEFAULT '0' NOT NULL,
        my_data jsonb,
PRIMARY KEY (login));

DROP TABLE IF EXISTS emkt_basic_settings;
DROP SEQUENCE IF EXISTS emkt_basic_settings_seq;
CREATE SEQUENCE emkt_basic_settings_seq;
CREATE TABLE emkt_basic_settings (
	id int NOT NULL default nextval ('emkt_basic_settings_seq'),
	lines_on_page int DEFAULT '20' NOT NULL,
        session_expr_time int DEFAULT '60' NOT NULL,
        debug int DEFAULT '0' NOT NULL,
        host_email varchar(128) DEFAULT 'smtp.localhost' NOT NULL,
        username_email varchar(128) DEFAULT 'login' NOT NULL,
        password_email varchar(128) DEFAULT '' NOT NULL,
        smtp_secure varchar(64) DEFAULT 'ssl' NOT NULL,
        smtp_port int DEFAULT '465' NOT NULL,
        smtp_auth int DEFAULT '0' NOT NULL,
        smtp_status int DEFAULT '0' NOT NULL,
        email varchar(128) DEFAULT 'sale@localhost' NOT NULL,
        email_name varchar(128) DEFAULT 'eMarket' NOT NULL,
        primary_language varchar(128) DEFAULT '' NOT NULL,
        cache_status int DEFAULT '0' NOT NULL,
        caching_time int DEFAULT '7200' NOT NULL,
        template varchar(128) DEFAULT 'default' NOT NULL,
        other jsonb,
PRIMARY KEY (id));

DROP TABLE IF EXISTS emkt_categories;
CREATE TABLE emkt_categories (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
	parent_id int DEFAULT '0' NOT NULL,
        logo jsonb,
	date_added timestamp(0),
	last_modified timestamp(0),
	sort_category int DEFAULT '0' NOT NULL,
	status int,
        logo_general varchar(128),
        attributes jsonb,
        description text,
        keyword varchar(256),
        tags varchar(256),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_countries;
CREATE TABLE emkt_countries (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        alpha_2 varchar(2),
        alpha_3 varchar(3),
        address_format varchar(256) NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_currencies;
CREATE TABLE emkt_currencies (
	id int NOT NULL,
	name varchar(64),
        code varchar(16),
        iso_4217 varchar(3),
	language varchar(64),
        value decimal(20,10),
        default_value int NOT NULL,
        symbol varchar(16),
        symbol_position varchar(16),
        decimal_places char(1),
        last_updated timestamp(0) NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_customers;
DROP SEQUENCE IF EXISTS emkt_customers_seq;
CREATE SEQUENCE emkt_customers_seq;
CREATE TABLE emkt_customers (
        id int NOT NULL default nextval ('emkt_customers_seq'),
        address_book jsonb,
        gender char(1),
        firstname varchar(32) NOT NULL,
        lastname varchar(32) NOT NULL,
        middle_name varchar(32),
        date_account_created timestamp(0),
        date_account_last_modified timestamp(0),
        date_last_logon timestamp(0),
        default_address_id int,
        date_of_birth timestamp(0),
        email varchar(128) NOT NULL,
        fax varchar(32),
        global_product_notifications int DEFAULT '0',
        ip_address varchar(64),
        newsletter char(1),
        number_of_logons int,
        password varchar(256) NOT NULL,
        status int DEFAULT '0',
        telephone varchar(32),
PRIMARY KEY (id));

DROP TABLE IF EXISTS emkt_customers_activation;
CREATE TABLE emkt_customers_activation (
        id int NOT NULL,
        activation_code varchar(64),
PRIMARY KEY (id));

DROP TABLE IF EXISTS emkt_length;
CREATE TABLE emkt_length (
	id int NOT NULL,
	name varchar(64),
        code varchar(8),
	language varchar(64),
        value_length decimal(14,7),
        default_length int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_manufacturers;
CREATE TABLE emkt_manufacturers (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        logo jsonb,
        logo_general varchar(128),
        site varchar(256),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_modules;
DROP SEQUENCE IF EXISTS emkt_modules_seq;
CREATE SEQUENCE emkt_modules_seq;
CREATE TABLE emkt_modules (
	id int NOT NULL default nextval ('emkt_modules_seq'),
	name varchar(256),
	type varchar(256),
        active int,
PRIMARY KEY (id));

DROP TABLE IF EXISTS emkt_order_status;
CREATE TABLE emkt_order_status (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        default_order_status int NOT NULL,
        sort int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_orders;
DROP SEQUENCE IF EXISTS emkt_orders_seq;
CREATE SEQUENCE emkt_orders_seq;
CREATE TABLE emkt_orders (
        id int NOT NULL default nextval ('emkt_orders_seq'),
        email varchar(128) NOT NULL,
        lastname varchar(32),
        firstname varchar(32),
        telephone varchar(32),
        customer_data jsonb,
        orders_status_history jsonb,
        products_order jsonb,
        order_total jsonb,
        invoice jsonb,
        orders_transactions_history jsonb,
        customer_ip_address varchar(30),
        payment_method jsonb,
        shipping_method jsonb,
        last_modified timestamp(0),
        date_purchased timestamp(0),
        uid varchar(64),
PRIMARY KEY (id));

DROP TABLE IF EXISTS emkt_password_recovery;
DROP SEQUENCE IF EXISTS emkt_password_recovery_seq;
CREATE SEQUENCE emkt_password_recovery_seq;
CREATE TABLE emkt_password_recovery (
        id int NOT NULL default nextval ('emkt_password_recovery_seq'),
        customer_id int NOT NULL,
        recovery_code varchar(64),
        recovery_code_created timestamp(0),
PRIMARY KEY (id));

DROP TABLE IF EXISTS emkt_products;
CREATE TABLE emkt_products (
	id int DEFAULT '0' NOT NULL,
        name varchar(256),
        description text,
        language varchar(64),
        status int DEFAULT '1' NOT NULL,
	parent_id int DEFAULT '0' NOT NULL,
	logo jsonb,
        logo_general varchar(128),
	date_added timestamp(0),
	last_modified timestamp(0),
        keyword varchar(256),
        tags varchar(256),
        price decimal(12,2),
        currency int,
        tax int,
        quantity int,
        unit int,
        model varchar(64), 
        date_available timestamp(0),
        manufacturer int,
        barcode varchar(256),
        barcode_value varchar(256),
        vendor_code varchar(64),
        vendor_code_value varchar(64),
        weight int,
        weight_value decimal(5,2),
        min_quantity int,
        dimension int,
        length decimal(12,2),
        width decimal(12,2),
        height decimal(12,2),
        type int,
        ordered int default '0',
        viewed int default '0',
        download_file varchar(256),
        downloads_stat int default '0',
        discount jsonb,
        attributes jsonb,
        sticker varchar(64),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_regions;
CREATE TABLE emkt_regions (
	id int NOT NULL,
        country_id int NOT NULL,
        region_code varchar(8),
	name varchar(256),
	language varchar(64),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_stickers;
CREATE TABLE emkt_stickers (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        default_stickers int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_slideshow;
DROP SEQUENCE IF EXISTS emkt_slideshow_seq;
CREATE SEQUENCE emkt_slideshow_seq;
CREATE TABLE emkt_slideshow (
	id int NOT NULL default nextval ('emkt_slideshow_seq'),
	language varchar(64),
	logo jsonb,
        logo_general varchar(128),
        animation int DEFAULT '1' NOT NULL,
        color text,
        url text,
        name varchar(256),
        heading text,
        date_start timestamp(0),
        date_finish timestamp(0),
        status int DEFAULT '1' NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_slideshow_pref;
DROP SEQUENCE IF EXISTS emkt_slideshow_pref_seq;
CREATE SEQUENCE emkt_slideshow_pref_seq;
CREATE TABLE emkt_slideshow_pref (
	id int NOT NULL default nextval ('emkt_slideshow_pref_seq'),
	show_interval varchar(64),
	mouse_stop varchar(64),
	autostart varchar(64),
	cicles varchar(64),
	indicators varchar(64),
	navigation varchar(64),
PRIMARY KEY (id));

DROP TABLE IF EXISTS emkt_staff_manager;
CREATE TABLE emkt_staff_manager (
	id int NOT NULL,
        language varchar(64),
	name varchar(256),
        note varchar(256),
        permissions jsonb,
        mode varchar(256),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_taxes;
CREATE TABLE emkt_taxes (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        rate decimal(4,2),
        tax_type int NOT NULL,
        zones_id int NOT NULL,
        fixed int NOT NULL,
        currency int,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_template_constructor;
DROP SEQUENCE IF EXISTS emkt_template_constructor_seq;
CREATE SEQUENCE emkt_template_constructor_seq;
CREATE TABLE emkt_template_constructor (
        id int CHECK (id > 0) NOT NULL default nextval ('emkt_template_constructor_seq'),
	url varchar(256),
        group_id varchar(32),
        value varchar(32),
        page varchar(256),
        template_name varchar(256),
        sort int NOT NULL,
PRIMARY KEY (id));

DROP TABLE IF EXISTS emkt_units;
CREATE TABLE emkt_units (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        unit varchar(256),
        default_unit int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_vendor_codes;
CREATE TABLE emkt_vendor_codes (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        vendor_code varchar(256),
        default_vendor_code int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_weight;
CREATE TABLE emkt_weight (
	id int NOT NULL,
	name varchar(64),
        code varchar(8),
	language varchar(64),
        value_weight decimal(14,7),
        default_weight int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_zones;
CREATE TABLE emkt_zones (
	id int NOT NULL,
	name varchar(256),
        note varchar(256),
	language varchar(64),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_zones_value;
DROP SEQUENCE IF EXISTS emkt_zones_value_seq;
CREATE SEQUENCE emkt_zones_value_seq;
CREATE TABLE emkt_zones_value (
	id int NOT NULL default nextval ('emkt_zones_value_seq'),
        country_id int NOT NULL,
        regions_id int NOT NULL,
        zones_id int NOT NULL,
PRIMARY KEY (id));
