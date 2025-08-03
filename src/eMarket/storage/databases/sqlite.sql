/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* Add tables */

DROP TABLE IF EXISTS emkt_administrators;
CREATE TABLE emkt_administrators (
	login text(128) NOT NULL,
	password text(256) NOT NULL,
	language text(64) NOT NULL,
	permission text(20) NOT NULL,
	note text(256),
	status int DEFAULT '0' NOT NULL,
        my_data text,
PRIMARY KEY (login));

DROP TABLE IF EXISTS emkt_basic_settings;
CREATE TABLE emkt_basic_settings (
	id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
	lines_on_page int DEFAULT '20' NOT NULL,
        session_expr_time int DEFAULT '60' NOT NULL,
        debug int DEFAULT '0' NOT NULL,
        host_email text(128) DEFAULT 'smtp.localhost' NOT NULL,
        username_email text(128) DEFAULT 'login' NOT NULL,
        password_email text(128) DEFAULT '' NOT NULL,
        smtp_secure text(64) DEFAULT 'ssl' NOT NULL,
        smtp_port int DEFAULT '465' NOT NULL,
        smtp_auth int DEFAULT '0' NOT NULL,
        smtp_status int DEFAULT '0' NOT NULL,
        email text(128) DEFAULT 'sale@localhost' NOT NULL,
        email_name text(128) DEFAULT 'eMarket' NOT NULL,
        primary_language text(128) DEFAULT '' NOT NULL,
        cache_status int DEFAULT '0' NOT NULL,
        caching_time int DEFAULT '7200' NOT NULL,
        template varchar(128) DEFAULT 'default' NOT NULL,
        other text,
        logo text,
        logo_general text(128));

DROP TABLE IF EXISTS emkt_categories;
CREATE TABLE emkt_categories (
	id int NOT NULL,
	name text(256),
	language text(64),
	parent_id int DEFAULT '0' NOT NULL,
        logo text,
	date_added datetime(0),
	last_modified datetime(0),
	sort_category int DEFAULT '0' NOT NULL,
	status int,
        logo_general text(128),
        attributes text,
        description text,
        keyword text(256),
        tags text(256),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_countries;
CREATE TABLE emkt_countries (
	id int NOT NULL,
	name text(256),
	language text(64),
        alpha_2 text(2),
        alpha_3 text(3),
        address_format text(256) NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_currencies;
CREATE TABLE emkt_currencies (
	id int NOT NULL,
	name text(64),
        code text(16),
        iso_4217 text(3),
	language text(64),
        value numeric(20,10),
        default_value int NOT NULL,
        symbol text(16),
        symbol_position text(16),
        decimal_places text(1),
        last_updated datetime(0) NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_customers;
CREATE TABLE emkt_customers (
        id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
        address_book text,
        gender text(1),
        firstname text(32) NOT NULL,
        lastname text(32) NOT NULL,
        middle_name text(32),
        date_account_created datetime(0),
        date_account_last_modified datetime(0),
        date_last_logon datetime(0),
        default_address_id int,
        date_of_birth datetime(0),
        email text(128) NOT NULL,
        fax text(32),
        global_product_notifications int DEFAULT '0',
        ip_address text(64),
        newsletter text(1),
        number_of_logons int,
        password text(256) NOT NULL,
        status int DEFAULT '0',
        telephone text(32));

DROP TABLE IF EXISTS emkt_customers_activation;
CREATE TABLE emkt_customers_activation (
        id int NOT NULL,
        activation_code text(64),
PRIMARY KEY (id));

DROP TABLE IF EXISTS emkt_length;
CREATE TABLE emkt_length (
	id int NOT NULL,
	name text(64),
        code text(8),
	language text(64),
        value_length numeric(14,7),
        default_length int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_manufacturers;
CREATE TABLE emkt_manufacturers (
	id int NOT NULL,
	name text(256),
	language text(64),
        logo text,
        logo_general text(128),
        site text(256),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_modules;
CREATE TABLE emkt_modules (
	id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
	name text(256),
	type text(256),
        active int);

DROP TABLE IF EXISTS emkt_order_status;
CREATE TABLE emkt_order_status (
	id int NOT NULL,
	name text(256),
	language text(64),
        default_order_status int NOT NULL,
        sort int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_orders;
CREATE TABLE emkt_orders (
        id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
        email text(128) NOT NULL,
        lastname text(32),
        firstname text(32),
        telephone text(32),
        customer_data text,
        orders_status_history text,
        products_order text,
        order_total text,
        invoice text,
        orders_transactions_history text,
        customer_ip_address text(30),
        payment_method text,
        shipping_method text,
        last_modified datetime(0),
        date_purchased datetime(0),
        uid text(64));

DROP TABLE IF EXISTS emkt_password_recovery;
CREATE TABLE emkt_password_recovery (
        id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
        customer_id int NOT NULL,
        recovery_code text(64),
        recovery_code_created datetime(0));

DROP TABLE IF EXISTS emkt_products;
CREATE TABLE emkt_products (
	id int DEFAULT '0' NOT NULL,
        name text(256),
        description text,
        language text(64),
        status int DEFAULT '1' NOT NULL,
	parent_id int DEFAULT '0' NOT NULL,
	logo text,
        logo_general text(128),
	date_added datetime(0),
	last_modified datetime(0),
        keyword text(256),
        tags text(256),
        price numeric(12,2),
        currency int,
        tax int,
        quantity int,
        unit int,
        model text(64), 
        date_available datetime,
        manufacturer int,
        barcode text(256),
        barcode_value text(256),
        vendor_code text(64),
        vendor_code_value text(64),
        weight int,
        weight_value numeric(5,2),
        min_quantity int,
        dimension int,
        length numeric(12,2),
        width numeric(12,2),
        height numeric(12,2),
        type int,
        ordered int default '0',
        viewed int default '0',
        download_file text(256),
        downloads_stat int default '0',
        discount text,
        attributes text,
        sticker text(64),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_regions;
CREATE TABLE emkt_regions (
	id int NOT NULL,
        country_id int NOT NULL,
        region_code text(8),
	name text(256),
	language text(64),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_stickers;
CREATE TABLE emkt_stickers (
	id int NOT NULL,
	name text(256),
	language text(64),
        default_stickers int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_slideshow;
CREATE TABLE emkt_slideshow (
	id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
	language text(64),
	logo text,
        logo_general text(128),
        animation int DEFAULT '1' NOT NULL,
        color text,
        url text,
        name text(256),
        heading text,
        date_start datetime(0),
        date_finish datetime(0),
        status int DEFAULT '1' NOT NULL);

DROP TABLE IF EXISTS emkt_slideshow_pref;
CREATE TABLE emkt_slideshow_pref (
	id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
	show_interval text(64),
	mouse_stop text(64),
	autostart text(64),
	cicles text(64),
	indicators text(64),
	navigation text(64));

DROP TABLE IF EXISTS emkt_staff_manager;
CREATE TABLE emkt_staff_manager (
	id int NOT NULL,
        language text(64),
	name text(256),
        note text(256),
        permissions text,
        mode text(256),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_taxes;
CREATE TABLE emkt_taxes (
	id int NOT NULL,
	name text(256),
	language text(64),
        rate numeric(4,2),
        tax_type int NOT NULL,
        zones_id int NOT NULL,
        fixed int NOT NULL,
        currency int,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_template_constructor;
CREATE TABLE emkt_template_constructor (
        id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
	url text(256),
        group_id text(32),
        value text(32),
        page text(256),
        template_name text(256),
        sort int NOT NULL);

DROP TABLE IF EXISTS emkt_units;
CREATE TABLE emkt_units (
	id int NOT NULL,
	name text(256),
	language text(64),
        unit text(256),
        default_unit int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_vendor_codes;
CREATE TABLE emkt_vendor_codes (
	id int NOT NULL,
	name text(256),
	language text(64),
        vendor_code text(256),
        default_vendor_code int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_weight;
CREATE TABLE emkt_weight (
	id int NOT NULL,
	name text(64),
        code text(8),
	language text(64),
        value_weight numeric(14,7),
        default_weight int NOT NULL,
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_zones;
CREATE TABLE emkt_zones (
	id int NOT NULL,
	name text(256),
        note text(256),
	language text(64),
PRIMARY KEY (id, language));

DROP TABLE IF EXISTS emkt_zones_value;
CREATE TABLE emkt_zones_value (
	id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
        country_id int NOT NULL,
        regions_id int NOT NULL,
        zones_id int NOT NULL);
