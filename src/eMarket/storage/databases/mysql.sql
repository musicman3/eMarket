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
        my_data json,
PRIMARY KEY (login))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_basic_settings;
CREATE TABLE emkt_basic_settings (
	id int NOT NULL auto_increment,
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
        other json,
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_categories;
CREATE TABLE emkt_categories (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
	parent_id int DEFAULT '0' NOT NULL,
        logo json,
	date_added datetime,
	last_modified datetime,
	sort_category int DEFAULT '0' NOT NULL,
	status int,
        logo_general varchar(128),
        attributes json,
        description text,
        keyword varchar(256),
        tags varchar(256),
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_countries;
CREATE TABLE emkt_countries (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        alpha_2 varchar(2),
        alpha_3 varchar(3),
        address_format varchar(256) NULL,
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
        last_updated datetime NULL,
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_customers;
CREATE TABLE emkt_customers (
        id int NOT NULL auto_increment,
        address_book json,
        gender char(1),
        firstname varchar(32) NOT NULL,
        lastname varchar(32) NOT NULL,
        middle_name varchar(32),
        date_account_created datetime,
        date_account_last_modified datetime,
        date_last_logon datetime,
        default_address_id int,
        date_of_birth datetime,
        email varchar(128) NOT NULL,
        fax varchar(32),
        global_product_notifications int DEFAULT '0',
        ip_address varchar(64),
        newsletter char(1),
        number_of_logons int,
        password varchar(256) NOT NULL,
        status int DEFAULT '0',
        telephone varchar(32),
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_customers_activation;
CREATE TABLE emkt_customers_activation (
        id int NOT NULL,
        activation_code varchar(64),
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_length;
CREATE TABLE emkt_length (
	id int NOT NULL,
	name varchar(64),
        code varchar(8),
	language varchar(64),
        value_length decimal(14,7),
        default_length int NOT NULL,
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_manufacturers;
CREATE TABLE emkt_manufacturers (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        logo json,
        logo_general varchar(128),
        site varchar(256),
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_modules;
CREATE TABLE emkt_modules (
	id int NOT NULL auto_increment,
	name varchar(256),
	type varchar(256),
        active int(64),
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_order_status;
CREATE TABLE emkt_order_status (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        default_order_status int NOT NULL,
        sort int NOT NULL,
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_orders;
CREATE TABLE emkt_orders (
        id int NOT NULL auto_increment,
        email varchar(128) NOT NULL,
        lastname varchar(32),
        firstname varchar(32),
        telephone varchar(32),
        customer_data json,
        orders_status_history json,
        products_order json,
        order_total json,
        invoice json,
        orders_transactions_history json,
        customer_ip_address varchar(30),
        payment_method json,
        shipping_method json,
        last_modified datetime,
        date_purchased datetime,
        uid varchar(64),
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_password_recovery;
CREATE TABLE emkt_password_recovery (
        id int NOT NULL auto_increment,
        customer_id int NOT NULL,
        recovery_code varchar(64),
        recovery_code_created datetime,
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_products;
CREATE TABLE emkt_products (
	id int DEFAULT '0' NOT NULL,
        name varchar(256),
        description text,
        language varchar(64),
        status int DEFAULT '1' NOT NULL,
	parent_id int DEFAULT '0' NOT NULL,
	logo json,
        logo_general varchar(128),
	date_added datetime,
	last_modified datetime,
        keyword varchar(256),
        tags varchar(256),
        price decimal(12,2),
        currency int,
        tax int,
        quantity int,
        unit int,
        model varchar(64), 
        date_available datetime,
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
        discount json,
        attributes json,
        sticker varchar(64),
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_regions;
CREATE TABLE emkt_regions (
	id int NOT NULL,
        country_id int NOT NULL,
        region_code varchar(8),
	name varchar(256),
	language varchar(64),
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_stickers;
CREATE TABLE emkt_stickers (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        default_stickers int NOT NULL,
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_slideshow;
CREATE TABLE emkt_slideshow (
	id int NOT NULL auto_increment,
	language varchar(64),
	logo json,
        logo_general varchar(128),
        animation int DEFAULT '1' NOT NULL,
        color text,
        url text,
        name varchar(256),
        heading text,
        date_start datetime,
        date_finish datetime,
        status int DEFAULT '1' NOT NULL,
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_slideshow_pref;
CREATE TABLE emkt_slideshow_pref (
	id int NOT NULL auto_increment,
	show_interval varchar(64),
	mouse_stop varchar(64),
	autostart varchar(64),
	cicles varchar(64),
	indicators varchar(64),
	navigation varchar(64),
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_staff_manager;
CREATE TABLE emkt_staff_manager (
	id int NOT NULL,
        language varchar(64),
	name varchar(256),
        note varchar(256),
        permissions json,
        mode varchar(256),
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_template_constructor;
CREATE TABLE emkt_template_constructor (
        id int UNSIGNED NOT NULL auto_increment,
	url varchar(256),
        group_id varchar(32),
        value varchar(32),
        page varchar(256),
        template_name varchar(256),
        sort int NOT NULL,
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_units;
CREATE TABLE emkt_units (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        unit varchar(256),
        default_unit int NOT NULL,
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_vendor_codes;
CREATE TABLE emkt_vendor_codes (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        vendor_code varchar(256),
        default_vendor_code int NOT NULL,
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_weight;
CREATE TABLE emkt_weight (
	id int NOT NULL,
	name varchar(64),
        code varchar(8),
	language varchar(64),
        value_weight decimal(14,7),
        default_weight int NOT NULL,
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_zones;
CREATE TABLE emkt_zones (
	id int NOT NULL,
	name varchar(256),
        note varchar(256),
	language varchar(64),
PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS emkt_zones_value;
CREATE TABLE emkt_zones_value (
	id int NOT NULL auto_increment,
        country_id int NOT NULL,
        regions_id int NOT NULL,
        zones_id int NOT NULL,
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
