/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* Add tables */

DROP TABLE IF EXISTS emkt_administrators;
CREATE TABLE emkt_administrators (
	login varchar(128) binary NOT NULL,
	password varchar(256) NOT NULL,
	language varchar(64) NOT NULL,
	permission varchar(20) NOT NULL,
	note varchar(256),
	status int DEFAULT '0' NOT NULL,
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
        date_available date,
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


/* Load data */
/* russian */
INSERT INTO emkt_countries VALUES (1,'Афганистан','russian','AF','AFG','');

INSERT INTO emkt_regions VALUES(1, 1, 'BDS', 'بد خشان', 'russian');
INSERT INTO emkt_regions VALUES(2, 1, 'BDG', 'بادغیس', 'russian');
INSERT INTO emkt_regions VALUES(3, 1, 'BGL', 'بغلان', 'russian');
INSERT INTO emkt_regions VALUES(4, 1, 'BAL', 'بلخ', 'russian');
INSERT INTO emkt_regions VALUES(5, 1, 'BAM', 'بامیان', 'russian');
INSERT INTO emkt_regions VALUES(6, 1, 'DAY', 'دایکندی', 'russian');
INSERT INTO emkt_regions VALUES(7, 1, 'FRA', 'فراه', 'russian');
INSERT INTO emkt_regions VALUES(8, 1, 'FYB', 'فارياب', 'russian');
INSERT INTO emkt_regions VALUES(9, 1, 'GHA', 'غزنى', 'russian');
INSERT INTO emkt_regions VALUES(10, 1, 'GHO', 'غور', 'russian');
INSERT INTO emkt_regions VALUES(11, 1, 'HEL', 'هلمند', 'russian');
INSERT INTO emkt_regions VALUES(12, 1, 'HER', 'هرات', 'russian');
INSERT INTO emkt_regions VALUES(13, 1, 'JOW', 'جوزجان', 'russian');
INSERT INTO emkt_regions VALUES(14, 1, 'KAB', 'کابل', 'russian');
INSERT INTO emkt_regions VALUES(15, 1, 'KAN', 'قندھار', 'russian');
INSERT INTO emkt_regions VALUES(16, 1, 'KAP', 'کاپيسا', 'russian');
INSERT INTO emkt_regions VALUES(17, 1, 'KHO', 'خوست', 'russian');
INSERT INTO emkt_regions VALUES(18, 1, 'KNR', 'کُنَر', 'russian');
INSERT INTO emkt_regions VALUES(19, 1, 'KDZ', 'كندوز', 'russian');
INSERT INTO emkt_regions VALUES(20, 1, 'LAG', 'لغمان', 'russian');
INSERT INTO emkt_regions VALUES(21, 1, 'LOW', 'لوګر', 'russian');
INSERT INTO emkt_regions VALUES(22, 1, 'NAN', 'ننگرهار', 'russian');
INSERT INTO emkt_regions VALUES(23, 1, 'NIM', 'نیمروز', 'russian');
INSERT INTO emkt_regions VALUES(24, 1, 'NUR', 'نورستان', 'russian');
INSERT INTO emkt_regions VALUES(25, 1, 'ORU', 'ؤروزگان', 'russian');
INSERT INTO emkt_regions VALUES(26, 1, 'PIA', 'پکتیا', 'russian');
INSERT INTO emkt_regions VALUES(27, 1, 'PKA', 'پکتيکا', 'russian');
INSERT INTO emkt_regions VALUES(28, 1, 'PAN', 'پنج شیر', 'russian');
INSERT INTO emkt_regions VALUES(29, 1, 'PAR', 'پروان', 'russian');
INSERT INTO emkt_regions VALUES(30, 1, 'SAM', 'سمنگان', 'russian');
INSERT INTO emkt_regions VALUES(31, 1, 'SAR', 'سر پل', 'russian');
INSERT INTO emkt_regions VALUES(32, 1, 'TAK', 'تخار', 'russian');
INSERT INTO emkt_regions VALUES(33, 1, 'WAR', 'وردک', 'russian');
INSERT INTO emkt_regions VALUES(34, 1, 'ZAB', 'زابل', 'russian');

INSERT INTO emkt_countries VALUES (2,'Албания','russian','AL','ALB','');

INSERT INTO emkt_regions VALUES(35, 2, 'BR', 'Beratit', 'russian');
INSERT INTO emkt_regions VALUES(36, 2, 'BU', 'Bulqizës', 'russian');
INSERT INTO emkt_regions VALUES(37, 2, 'DI', 'Dibrës', 'russian');
INSERT INTO emkt_regions VALUES(38, 2, 'DL', 'Delvinës', 'russian');
INSERT INTO emkt_regions VALUES(39, 2, 'DR', 'Durrësit', 'russian');
INSERT INTO emkt_regions VALUES(40, 2, 'DV', 'Devollit', 'russian');
INSERT INTO emkt_regions VALUES(41, 2, 'EL', 'Elbasanit', 'russian');
INSERT INTO emkt_regions VALUES(42, 2, 'ER', 'Kolonjës', 'russian');
INSERT INTO emkt_regions VALUES(43, 2, 'FR', 'Fierit', 'russian');
INSERT INTO emkt_regions VALUES(44, 2, 'GJ', 'Gjirokastrës', 'russian');
INSERT INTO emkt_regions VALUES(45, 2, 'GR', 'Gramshit', 'russian');
INSERT INTO emkt_regions VALUES(46, 2, 'HA', 'Hasit', 'russian');
INSERT INTO emkt_regions VALUES(47, 2, 'KA', 'Kavajës', 'russian');
INSERT INTO emkt_regions VALUES(48, 2, 'KB', 'Kurbinit', 'russian');
INSERT INTO emkt_regions VALUES(49, 2, 'KC', 'Kuçovës', 'russian');
INSERT INTO emkt_regions VALUES(50, 2, 'KO', 'Korçës', 'russian');
INSERT INTO emkt_regions VALUES(51, 2, 'KR', 'Krujës', 'russian');
INSERT INTO emkt_regions VALUES(52, 2, 'KU', 'Kukësit', 'russian');
INSERT INTO emkt_regions VALUES(53, 2, 'LB', 'Librazhdit', 'russian');
INSERT INTO emkt_regions VALUES(54, 2, 'LE', 'Lezhës', 'russian');
INSERT INTO emkt_regions VALUES(55, 2, 'LU', 'Lushnjës', 'russian');
INSERT INTO emkt_regions VALUES(56, 2, 'MK', 'Mallakastrës', 'russian');
INSERT INTO emkt_regions VALUES(57, 2, 'MM', 'Malësisë së Madhe', 'russian');
INSERT INTO emkt_regions VALUES(58, 2, 'MR', 'Mirditës', 'russian');
INSERT INTO emkt_regions VALUES(59, 2, 'MT', 'Matit', 'russian');
INSERT INTO emkt_regions VALUES(60, 2, 'PG', 'Pogradecit', 'russian');
INSERT INTO emkt_regions VALUES(61, 2, 'PQ', 'Peqinit', 'russian');
INSERT INTO emkt_regions VALUES(62, 2, 'PR', 'Përmetit', 'russian');
INSERT INTO emkt_regions VALUES(63, 2, 'PU', 'Pukës', 'russian');
INSERT INTO emkt_regions VALUES(64, 2, 'SH', 'Shkodrës', 'russian');
INSERT INTO emkt_regions VALUES(65, 2, 'SK', 'Skraparit', 'russian');
INSERT INTO emkt_regions VALUES(66, 2, 'SR', 'Sarandës', 'russian');
INSERT INTO emkt_regions VALUES(67, 2, 'TE', 'Tepelenës', 'russian');
INSERT INTO emkt_regions VALUES(68, 2, 'TP', 'Tropojës', 'russian');
INSERT INTO emkt_regions VALUES(69, 2, 'TR', 'Tiranës', 'russian');
INSERT INTO emkt_regions VALUES(70, 2, 'VL', 'Vlorës', 'russian');

INSERT INTO emkt_countries VALUES (3,'Алжир','russian','DZ','DZA','');

INSERT INTO emkt_regions VALUES(71, 3, '01', 'ولاية أدرار', 'russian');
INSERT INTO emkt_regions VALUES(72, 3, '02', 'ولاية الشلف', 'russian');
INSERT INTO emkt_regions VALUES(73, 3, '03', 'ولاية الأغواط', 'russian');
INSERT INTO emkt_regions VALUES(74, 3, '04', 'ولاية أم البواقي', 'russian');
INSERT INTO emkt_regions VALUES(75, 3, '05', 'ولاية باتنة', 'russian');
INSERT INTO emkt_regions VALUES(76, 3, '06', 'ولاية بجاية', 'russian');
INSERT INTO emkt_regions VALUES(77, 3, '07', 'ولاية بسكرة', 'russian');
INSERT INTO emkt_regions VALUES(78, 3, '08', 'ولاية بشار', 'russian');
INSERT INTO emkt_regions VALUES(79, 3, '09', 'البليدة‎', 'russian');
INSERT INTO emkt_regions VALUES(80, 3, '10', 'ولاية البويرة', 'russian');
INSERT INTO emkt_regions VALUES(81, 3, '11', 'ولاية تمنراست', 'russian');
INSERT INTO emkt_regions VALUES(82, 3, '12', 'ولاية تبسة', 'russian');
INSERT INTO emkt_regions VALUES(83, 3, '13', 'تلمسان', 'russian');
INSERT INTO emkt_regions VALUES(84, 3, '14', 'ولاية تيارت', 'russian');
INSERT INTO emkt_regions VALUES(85, 3, '15', 'تيزي وزو', 'russian');
INSERT INTO emkt_regions VALUES(86, 3, '16', 'ولاية الجزائر', 'russian');
INSERT INTO emkt_regions VALUES(87, 3, '17', 'ولاية عين الدفلى', 'russian');
INSERT INTO emkt_regions VALUES(88, 3, '18', 'ولاية جيجل', 'russian');
INSERT INTO emkt_regions VALUES(89, 3, '19', 'ولاية سطيف', 'russian');
INSERT INTO emkt_regions VALUES(90, 3, '20', 'ولاية سعيدة', 'russian');
INSERT INTO emkt_regions VALUES(91, 3, '21', 'السكيكدة', 'russian');
INSERT INTO emkt_regions VALUES(92, 3, '22', 'ولاية سيدي بلعباس', 'russian');
INSERT INTO emkt_regions VALUES(93, 3, '23', 'ولاية عنابة', 'russian');
INSERT INTO emkt_regions VALUES(94, 3, '24', 'ولاية قالمة', 'russian');
INSERT INTO emkt_regions VALUES(95, 3, '25', 'قسنطينة', 'russian');
INSERT INTO emkt_regions VALUES(96, 3, '26', 'ولاية المدية', 'russian');
INSERT INTO emkt_regions VALUES(97, 3, '27', 'ولاية مستغانم', 'russian');
INSERT INTO emkt_regions VALUES(98, 3, '28', 'ولاية المسيلة', 'russian');
INSERT INTO emkt_regions VALUES(99, 3, '29', 'ولاية معسكر', 'russian');
INSERT INTO emkt_regions VALUES(100, 3, '30', 'ورقلة', 'russian');
INSERT INTO emkt_regions VALUES(101, 3, '31', 'وهران', 'russian');
INSERT INTO emkt_regions VALUES(102, 3, '32', 'ولاية البيض', 'russian');
INSERT INTO emkt_regions VALUES(103, 3, '33', 'ولاية اليزي', 'russian');
INSERT INTO emkt_regions VALUES(104, 3, '34', 'ولاية برج بوعريريج', 'russian');
INSERT INTO emkt_regions VALUES(105, 3, '35', 'ولاية بومرداس', 'russian');
INSERT INTO emkt_regions VALUES(106, 3, '36', 'ولاية الطارف', 'russian');
INSERT INTO emkt_regions VALUES(107, 3, '37', 'تندوف', 'russian');
INSERT INTO emkt_regions VALUES(108, 3, '38', 'ولاية تسمسيلت', 'russian');
INSERT INTO emkt_regions VALUES(109, 3, '39', 'ولاية الوادي', 'russian');
INSERT INTO emkt_regions VALUES(110, 3, '40', 'ولاية خنشلة', 'russian');
INSERT INTO emkt_regions VALUES(111, 3, '41', 'ولاية سوق أهراس', 'russian');
INSERT INTO emkt_regions VALUES(112, 3, '42', 'ولاية تيبازة', 'russian');
INSERT INTO emkt_regions VALUES(113, 3, '43', 'ولاية ميلة', 'russian');
INSERT INTO emkt_regions VALUES(114, 3, '44', 'ولاية عين الدفلى', 'russian');
INSERT INTO emkt_regions VALUES(115, 3, '45', 'ولاية النعامة', 'russian');
INSERT INTO emkt_regions VALUES(116, 3, '46', 'ولاية عين تموشنت', 'russian');
INSERT INTO emkt_regions VALUES(117, 3, '47', 'ولاية غرداية', 'russian');
INSERT INTO emkt_regions VALUES(118, 3, '48', 'ولاية غليزان', 'russian');

INSERT INTO emkt_countries VALUES (4,'Американское Самоа','russian','AS','ASM','');

INSERT INTO emkt_regions VALUES(119, 4, 'EA', 'Eastern', 'russian');
INSERT INTO emkt_regions VALUES(120, 4, 'MA', 'Manu\'a', 'russian');
INSERT INTO emkt_regions VALUES(121, 4, 'RI', 'Rose Island', 'russian');
INSERT INTO emkt_regions VALUES(122, 4, 'SI', 'Swains Island', 'russian');
INSERT INTO emkt_regions VALUES(123, 4, 'WE', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (5,'Андорра','russian','AD','AND','');

INSERT INTO emkt_regions VALUES(124, 5, 'AN', 'Andorra la Vella', 'russian');
INSERT INTO emkt_regions VALUES(125, 5, 'CA', 'Canillo', 'russian');
INSERT INTO emkt_regions VALUES(126, 5, 'EN', 'Encamp', 'russian');
INSERT INTO emkt_regions VALUES(127, 5, 'LE', 'Escaldes-Engordany', 'russian');
INSERT INTO emkt_regions VALUES(128, 5, 'LM', 'La Massana', 'russian');
INSERT INTO emkt_regions VALUES(129, 5, 'OR', 'Ordino', 'russian');
INSERT INTO emkt_regions VALUES(130, 5, 'SJ', 'Sant Juliá de Lória', 'russian');

INSERT INTO emkt_countries VALUES (6,'Ангола','russian','AO','AGO','');

INSERT INTO emkt_regions VALUES(131, 6, 'BGO', 'Bengo', 'russian');
INSERT INTO emkt_regions VALUES(132, 6, 'BGU', 'Benguela', 'russian');
INSERT INTO emkt_regions VALUES(133, 6, 'BIE', 'Bié', 'russian');
INSERT INTO emkt_regions VALUES(134, 6, 'CAB', 'Cabinda', 'russian');
INSERT INTO emkt_regions VALUES(135, 6, 'CCU', 'Cuando Cubango', 'russian');
INSERT INTO emkt_regions VALUES(136, 6, 'CNO', 'Cuanza Norte', 'russian');
INSERT INTO emkt_regions VALUES(137, 6, 'CUS', 'Cuanza Sul', 'russian');
INSERT INTO emkt_regions VALUES(138, 6, 'CNN', 'Cunene', 'russian');
INSERT INTO emkt_regions VALUES(139, 6, 'HUA', 'Huambo', 'russian');
INSERT INTO emkt_regions VALUES(140, 6, 'HUI', 'Huíla', 'russian');
INSERT INTO emkt_regions VALUES(141, 6, 'LUA', 'Luanda', 'russian');
INSERT INTO emkt_regions VALUES(142, 6, 'LNO', 'Lunda Norte', 'russian');
INSERT INTO emkt_regions VALUES(143, 6, 'LSU', 'Lunda Sul', 'russian');
INSERT INTO emkt_regions VALUES(144, 6, 'MAL', 'Malanje', 'russian');
INSERT INTO emkt_regions VALUES(145, 6, 'MOX', 'Moxico', 'russian');
INSERT INTO emkt_regions VALUES(146, 6, 'NAM', 'Namibe', 'russian');
INSERT INTO emkt_regions VALUES(147, 6, 'UIG', 'Uíge', 'russian');
INSERT INTO emkt_regions VALUES(148, 6, 'ZAI', 'Zaire', 'russian');

INSERT INTO emkt_countries VALUES (7,'Ангилья','russian','AI','AIA','');

INSERT INTO emkt_regions VALUES(4250, 7, 'NOCODE', 'Anguilla', 'russian');

INSERT INTO emkt_countries VALUES (8,'Антарктида','russian','AQ','ATA','');

INSERT INTO emkt_regions VALUES(4251, 8, 'NOCODE', 'Antarctica', 'russian');

INSERT INTO emkt_countries VALUES (9,'Антигуа и Барбуда','russian','AG','ATG','');

INSERT INTO emkt_regions VALUES(149, 9, 'BAR', 'Barbuda', 'russian');
INSERT INTO emkt_regions VALUES(150, 9, 'SGE', 'Saint George', 'russian');
INSERT INTO emkt_regions VALUES(151, 9, 'SJO', 'Saint John', 'russian');
INSERT INTO emkt_regions VALUES(152, 9, 'SMA', 'Saint Mary', 'russian');
INSERT INTO emkt_regions VALUES(153, 9, 'SPA', 'Saint Paul', 'russian');
INSERT INTO emkt_regions VALUES(154, 9, 'SPE', 'Saint Peter', 'russian');
INSERT INTO emkt_regions VALUES(155, 9, 'SPH', 'Saint Philip', 'russian');

INSERT INTO emkt_countries VALUES (10,'Аргентина','russian','AR','ARG','');

INSERT INTO emkt_regions VALUES(156, 10, 'A', 'Salta', 'russian');
INSERT INTO emkt_regions VALUES(157, 10, 'B', 'Buenos Aires Province', 'russian');
INSERT INTO emkt_regions VALUES(158, 10, 'C', 'Capital Federal', 'russian');
INSERT INTO emkt_regions VALUES(159, 10, 'D', 'San Luis', 'russian');
INSERT INTO emkt_regions VALUES(160, 10, 'E', 'Entre Ríos', 'russian');
INSERT INTO emkt_regions VALUES(161, 10, 'F', 'La Rioja', 'russian');
INSERT INTO emkt_regions VALUES(162, 10, 'G', 'Santiago del Estero', 'russian');
INSERT INTO emkt_regions VALUES(163, 10, 'H', 'Chaco', 'russian');
INSERT INTO emkt_regions VALUES(164, 10, 'J', 'San Juan', 'russian');
INSERT INTO emkt_regions VALUES(165, 10, 'K', 'Catamarca', 'russian');
INSERT INTO emkt_regions VALUES(166, 10, 'L', 'La Pampa', 'russian');
INSERT INTO emkt_regions VALUES(167, 10, 'M', 'Mendoza', 'russian');
INSERT INTO emkt_regions VALUES(168, 10, 'N', 'Misiones', 'russian');
INSERT INTO emkt_regions VALUES(169, 10, 'P', 'Formosa', 'russian');
INSERT INTO emkt_regions VALUES(170, 10, 'Q', 'Neuquén', 'russian');
INSERT INTO emkt_regions VALUES(171, 10, 'R', 'Río Negro', 'russian');
INSERT INTO emkt_regions VALUES(172, 10, 'S', 'Santa Fe', 'russian');
INSERT INTO emkt_regions VALUES(173, 10, 'T', 'Tucumán', 'russian');
INSERT INTO emkt_regions VALUES(174, 10, 'U', 'Chubut', 'russian');
INSERT INTO emkt_regions VALUES(175, 10, 'V', 'Tierra del Fuego', 'russian');
INSERT INTO emkt_regions VALUES(176, 10, 'W', 'Corrientes', 'russian');
INSERT INTO emkt_regions VALUES(177, 10, 'X', 'Córdoba', 'russian');
INSERT INTO emkt_regions VALUES(178, 10, 'Y', 'Jujuy', 'russian');
INSERT INTO emkt_regions VALUES(179, 10, 'Z', 'Santa Cruz', 'russian');

INSERT INTO emkt_countries VALUES (11,'Армения','russian','AM','ARM','');

INSERT INTO emkt_regions VALUES(180, 11, 'AG', 'Արագածոտն', 'russian');
INSERT INTO emkt_regions VALUES(181, 11, 'AR', 'Արարատ', 'russian');
INSERT INTO emkt_regions VALUES(182, 11, 'AV', 'Արմավիր', 'russian');
INSERT INTO emkt_regions VALUES(183, 11, 'ER', 'Երևան', 'russian');
INSERT INTO emkt_regions VALUES(184, 11, 'GR', 'Գեղարքունիք', 'russian');
INSERT INTO emkt_regions VALUES(185, 11, 'KT', 'Կոտայք', 'russian');
INSERT INTO emkt_regions VALUES(186, 11, 'LO', 'Լոռի', 'russian');
INSERT INTO emkt_regions VALUES(187, 11, 'SH', 'Շիրակ', 'russian');
INSERT INTO emkt_regions VALUES(188, 11, 'SU', 'Սյունիք', 'russian');
INSERT INTO emkt_regions VALUES(189, 11, 'TV', 'Տավուշ', 'russian');
INSERT INTO emkt_regions VALUES(190, 11, 'VD', 'Վայոց Ձոր', 'russian');

INSERT INTO emkt_countries VALUES (12,'Аруба','russian','AW','ABW','');

INSERT INTO emkt_regions VALUES(4252, 12, 'NOCODE', 'Aruba', 'russian');

INSERT INTO emkt_countries VALUES (13,'Австралия','russian','AU','AUS','');

INSERT INTO emkt_regions VALUES(191, 13, 'ACT', 'Australian Capital Territory', 'russian');
INSERT INTO emkt_regions VALUES(192, 13, 'NSW', 'New South Wales', 'russian');
INSERT INTO emkt_regions VALUES(193, 13, 'NT', 'Northern Territory', 'russian');
INSERT INTO emkt_regions VALUES(194, 13, 'QLD', 'Queensland', 'russian');
INSERT INTO emkt_regions VALUES(195, 13, 'SA', 'South Australia', 'russian');
INSERT INTO emkt_regions VALUES(196, 13, 'TAS', 'Tasmania', 'russian');
INSERT INTO emkt_regions VALUES(197, 13, 'VIC', 'Victoria', 'russian');
INSERT INTO emkt_regions VALUES(198, 13, 'WA', 'Western Australia', 'russian');

INSERT INTO emkt_countries VALUES (14,'Австрия','russian','AT','AUT','');

INSERT INTO emkt_regions VALUES(199, 14, '1', 'Burgenland', 'russian');
INSERT INTO emkt_regions VALUES(200, 14, '2', 'Kärnten', 'russian');
INSERT INTO emkt_regions VALUES(201, 14, '3', 'Niederösterreich', 'russian');
INSERT INTO emkt_regions VALUES(202, 14, '4', 'Oberösterreich', 'russian');
INSERT INTO emkt_regions VALUES(203, 14, '5', 'Salzburg', 'russian');
INSERT INTO emkt_regions VALUES(204, 14, '6', 'Steiermark', 'russian');
INSERT INTO emkt_regions VALUES(205, 14, '7', 'Tirol', 'russian');
INSERT INTO emkt_regions VALUES(206, 14, '8', 'Voralberg', 'russian');
INSERT INTO emkt_regions VALUES(207, 14, '9', 'Wien', 'russian');

INSERT INTO emkt_countries VALUES (15,'Азербайджан','russian','AZ','AZE','');

INSERT INTO emkt_regions VALUES(208, 15, 'AB', 'Əli Bayramlı', 'russian');
INSERT INTO emkt_regions VALUES(209, 15, 'ABS', 'Abşeron', 'russian');
INSERT INTO emkt_regions VALUES(210, 15, 'AGC', 'Ağcabədi', 'russian');
INSERT INTO emkt_regions VALUES(211, 15, 'AGM', 'Ağdam', 'russian');
INSERT INTO emkt_regions VALUES(212, 15, 'AGS', 'Ağdaş', 'russian');
INSERT INTO emkt_regions VALUES(213, 15, 'AGA', 'Ağstafa', 'russian');
INSERT INTO emkt_regions VALUES(214, 15, 'AGU', 'Ağsu', 'russian');
INSERT INTO emkt_regions VALUES(215, 15, 'AST', 'Astara', 'russian');
INSERT INTO emkt_regions VALUES(216, 15, 'BA', 'Bakı', 'russian');
INSERT INTO emkt_regions VALUES(217, 15, 'BAB', 'Babək', 'russian');
INSERT INTO emkt_regions VALUES(218, 15, 'BAL', 'Balakən', 'russian');
INSERT INTO emkt_regions VALUES(219, 15, 'BAR', 'Bərdə', 'russian');
INSERT INTO emkt_regions VALUES(220, 15, 'BEY', 'Beyləqan', 'russian');
INSERT INTO emkt_regions VALUES(221, 15, 'BIL', 'Biləsuvar', 'russian');
INSERT INTO emkt_regions VALUES(222, 15, 'CAB', 'Cəbrayıl', 'russian');
INSERT INTO emkt_regions VALUES(223, 15, 'CAL', 'Cəlilabab', 'russian');
INSERT INTO emkt_regions VALUES(224, 15, 'CUL', 'Julfa', 'russian');
INSERT INTO emkt_regions VALUES(225, 15, 'DAS', 'Daşkəsən', 'russian');
INSERT INTO emkt_regions VALUES(226, 15, 'DAV', 'Dəvəçi', 'russian');
INSERT INTO emkt_regions VALUES(227, 15, 'FUZ', 'Füzuli', 'russian');
INSERT INTO emkt_regions VALUES(228, 15, 'GA', 'Gəncə', 'russian');
INSERT INTO emkt_regions VALUES(229, 15, 'GAD', 'Gədəbəy', 'russian');
INSERT INTO emkt_regions VALUES(230, 15, 'GOR', 'Goranboy', 'russian');
INSERT INTO emkt_regions VALUES(231, 15, 'GOY', 'Göyçay', 'russian');
INSERT INTO emkt_regions VALUES(232, 15, 'HAC', 'Hacıqabul', 'russian');
INSERT INTO emkt_regions VALUES(233, 15, 'IMI', 'İmişli', 'russian');
INSERT INTO emkt_regions VALUES(234, 15, 'ISM', 'İsmayıllı', 'russian');
INSERT INTO emkt_regions VALUES(235, 15, 'KAL', 'Kəlbəcər', 'russian');
INSERT INTO emkt_regions VALUES(236, 15, 'KUR', 'Kürdəmir', 'russian');
INSERT INTO emkt_regions VALUES(237, 15, 'LA', 'Lənkəran', 'russian');
INSERT INTO emkt_regions VALUES(238, 15, 'LAC', 'Laçın', 'russian');
INSERT INTO emkt_regions VALUES(239, 15, 'LAN', 'Lənkəran', 'russian');
INSERT INTO emkt_regions VALUES(240, 15, 'LER', 'Lerik', 'russian');
INSERT INTO emkt_regions VALUES(241, 15, 'MAS', 'Masallı', 'russian');
INSERT INTO emkt_regions VALUES(242, 15, 'MI', 'Mingəçevir', 'russian');
INSERT INTO emkt_regions VALUES(243, 15, 'NA', 'Naftalan', 'russian');
INSERT INTO emkt_regions VALUES(244, 15, 'NEF', 'Neftçala', 'russian');
INSERT INTO emkt_regions VALUES(245, 15, 'OGU', 'Oğuz', 'russian');
INSERT INTO emkt_regions VALUES(246, 15, 'ORD', 'Ordubad', 'russian');
INSERT INTO emkt_regions VALUES(247, 15, 'QAB', 'Qəbələ', 'russian');
INSERT INTO emkt_regions VALUES(248, 15, 'QAX', 'Qax', 'russian');
INSERT INTO emkt_regions VALUES(249, 15, 'QAZ', 'Qazax', 'russian');
INSERT INTO emkt_regions VALUES(250, 15, 'QOB', 'Qobustan', 'russian');
INSERT INTO emkt_regions VALUES(251, 15, 'QBA', 'Quba', 'russian');
INSERT INTO emkt_regions VALUES(252, 15, 'QBI', 'Qubadlı', 'russian');
INSERT INTO emkt_regions VALUES(253, 15, 'QUS', 'Qusar', 'russian');
INSERT INTO emkt_regions VALUES(254, 15, 'SA', 'Şəki', 'russian');
INSERT INTO emkt_regions VALUES(255, 15, 'SAT', 'Saatlı', 'russian');
INSERT INTO emkt_regions VALUES(256, 15, 'SAB', 'Sabirabad', 'russian');
INSERT INTO emkt_regions VALUES(257, 15, 'SAD', 'Sədərək', 'russian');
INSERT INTO emkt_regions VALUES(258, 15, 'SAH', 'Şahbuz', 'russian');
INSERT INTO emkt_regions VALUES(259, 15, 'SAK', 'Şəki', 'russian');
INSERT INTO emkt_regions VALUES(260, 15, 'SAL', 'Salyan', 'russian');
INSERT INTO emkt_regions VALUES(261, 15, 'SM', 'Sumqayıt', 'russian');
INSERT INTO emkt_regions VALUES(262, 15, 'SMI', 'Şamaxı', 'russian');
INSERT INTO emkt_regions VALUES(263, 15, 'SKR', 'Şəmkir', 'russian');
INSERT INTO emkt_regions VALUES(264, 15, 'SMX', 'Samux', 'russian');
INSERT INTO emkt_regions VALUES(265, 15, 'SAR', 'Şərur', 'russian');
INSERT INTO emkt_regions VALUES(266, 15, 'SIY', 'Siyəzən', 'russian');
INSERT INTO emkt_regions VALUES(267, 15, 'SS', 'Şuşa (City)', 'russian');
INSERT INTO emkt_regions VALUES(268, 15, 'SUS', 'Şuşa', 'russian');
INSERT INTO emkt_regions VALUES(269, 15, 'TAR', 'Tərtər', 'russian');
INSERT INTO emkt_regions VALUES(270, 15, 'TOV', 'Tovuz', 'russian');
INSERT INTO emkt_regions VALUES(271, 15, 'UCA', 'Ucar', 'russian');
INSERT INTO emkt_regions VALUES(272, 15, 'XA', 'Xankəndi', 'russian');
INSERT INTO emkt_regions VALUES(273, 15, 'XAC', 'Xaçmaz', 'russian');
INSERT INTO emkt_regions VALUES(274, 15, 'XAN', 'Xanlar', 'russian');
INSERT INTO emkt_regions VALUES(275, 15, 'XIZ', 'Xızı', 'russian');
INSERT INTO emkt_regions VALUES(276, 15, 'XCI', 'Xocalı', 'russian');
INSERT INTO emkt_regions VALUES(277, 15, 'XVD', 'Xocavənd', 'russian');
INSERT INTO emkt_regions VALUES(278, 15, 'YAR', 'Yardımlı', 'russian');
INSERT INTO emkt_regions VALUES(279, 15, 'YE', 'Yevlax (City)', 'russian');
INSERT INTO emkt_regions VALUES(280, 15, 'YEV', 'Yevlax', 'russian');
INSERT INTO emkt_regions VALUES(281, 15, 'ZAN', 'Zəngilan', 'russian');
INSERT INTO emkt_regions VALUES(282, 15, 'ZAQ', 'Zaqatala', 'russian');
INSERT INTO emkt_regions VALUES(283, 15, 'ZAR', 'Zərdab', 'russian');
INSERT INTO emkt_regions VALUES(284, 15, 'NX', 'Nakhichevan', 'russian');

INSERT INTO emkt_countries VALUES (16,'Багамские Острова','russian','BS','BHS','');

INSERT INTO emkt_regions VALUES(285, 16, 'AC', 'Acklins and Crooked Islands', 'russian');
INSERT INTO emkt_regions VALUES(286, 16, 'BI', 'Bimini', 'russian');
INSERT INTO emkt_regions VALUES(287, 16, 'CI', 'Cat Island', 'russian');
INSERT INTO emkt_regions VALUES(288, 16, 'EX', 'Exuma', 'russian');
INSERT INTO emkt_regions VALUES(289, 16, 'FR', 'Freeport', 'russian');
INSERT INTO emkt_regions VALUES(290, 16, 'FC', 'Fresh Creek', 'russian');
INSERT INTO emkt_regions VALUES(291, 16, 'GH', 'Governor\'s Harbour', 'russian');
INSERT INTO emkt_regions VALUES(292, 16, 'GT', 'Green Turtle Cay', 'russian');
INSERT INTO emkt_regions VALUES(293, 16, 'HI', 'Harbour Island', 'russian');
INSERT INTO emkt_regions VALUES(294, 16, 'HR', 'High Rock', 'russian');
INSERT INTO emkt_regions VALUES(295, 16, 'IN', 'Inagua', 'russian');
INSERT INTO emkt_regions VALUES(296, 16, 'KB', 'Kemps Bay', 'russian');
INSERT INTO emkt_regions VALUES(297, 16, 'LI', 'Long Island', 'russian');
INSERT INTO emkt_regions VALUES(298, 16, 'MH', 'Marsh Harbour', 'russian');
INSERT INTO emkt_regions VALUES(299, 16, 'MA', 'Mayaguana', 'russian');
INSERT INTO emkt_regions VALUES(300, 16, 'NP', 'New Providence', 'russian');
INSERT INTO emkt_regions VALUES(301, 16, 'NT', 'Nicholls Town and Berry Islands', 'russian');
INSERT INTO emkt_regions VALUES(302, 16, 'RI', 'Ragged Island', 'russian');
INSERT INTO emkt_regions VALUES(303, 16, 'RS', 'Rock Sound', 'russian');
INSERT INTO emkt_regions VALUES(304, 16, 'SS', 'San Salvador and Rum Cay', 'russian');
INSERT INTO emkt_regions VALUES(305, 16, 'SP', 'Sandy Point', 'russian');

INSERT INTO emkt_countries VALUES (17,'Бахрейн','russian','BH','BHR','');

INSERT INTO emkt_regions VALUES(306, 17, '01', 'الحد', 'russian');
INSERT INTO emkt_regions VALUES(307, 17, '02', 'المحرق', 'russian');
INSERT INTO emkt_regions VALUES(308, 17, '03', 'المنامة', 'russian');
INSERT INTO emkt_regions VALUES(309, 17, '04', 'جد حفص', 'russian');
INSERT INTO emkt_regions VALUES(310, 17, '05', 'المنطقة الشمالية', 'russian');
INSERT INTO emkt_regions VALUES(311, 17, '06', 'سترة', 'russian');
INSERT INTO emkt_regions VALUES(312, 17, '07', 'المنطقة الوسطى', 'russian');
INSERT INTO emkt_regions VALUES(313, 17, '08', 'مدينة عيسى', 'russian');
INSERT INTO emkt_regions VALUES(314, 17, '09', 'الرفاع والمنطقة الجنوبية', 'russian');
INSERT INTO emkt_regions VALUES(315, 17, '10', 'المنطقة الغربية', 'russian');
INSERT INTO emkt_regions VALUES(316, 17, '11', 'جزر حوار', 'russian');
INSERT INTO emkt_regions VALUES(317, 17, '12', 'مدينة حمد', 'russian');

INSERT INTO emkt_countries VALUES (18,'Бангладеш','russian','BD','BGD','');

INSERT INTO emkt_regions VALUES(318, 18, '01', 'Bandarban', 'russian');
INSERT INTO emkt_regions VALUES(319, 18, '02', 'Barguna', 'russian');
INSERT INTO emkt_regions VALUES(320, 18, '03', 'Bogra', 'russian');
INSERT INTO emkt_regions VALUES(321, 18, '04', 'Brahmanbaria', 'russian');
INSERT INTO emkt_regions VALUES(322, 18, '05', 'Bagerhat', 'russian');
INSERT INTO emkt_regions VALUES(323, 18, '06', 'Barisal', 'russian');
INSERT INTO emkt_regions VALUES(324, 18, '07', 'Bhola', 'russian');
INSERT INTO emkt_regions VALUES(325, 18, '08', 'Comilla', 'russian');
INSERT INTO emkt_regions VALUES(326, 18, '09', 'Chandpur', 'russian');
INSERT INTO emkt_regions VALUES(327, 18, '10', 'Chittagong', 'russian');
INSERT INTO emkt_regions VALUES(328, 18, '11', 'Cox\'s Bazar', 'russian');
INSERT INTO emkt_regions VALUES(329, 18, '12', 'Chuadanga', 'russian');
INSERT INTO emkt_regions VALUES(330, 18, '13', 'Dhaka', 'russian');
INSERT INTO emkt_regions VALUES(331, 18, '14', 'Dinajpur', 'russian');
INSERT INTO emkt_regions VALUES(332, 18, '15', 'Faridpur', 'russian');
INSERT INTO emkt_regions VALUES(333, 18, '16', 'Feni', 'russian');
INSERT INTO emkt_regions VALUES(334, 18, '17', 'Gopalganj', 'russian');
INSERT INTO emkt_regions VALUES(335, 18, '18', 'Gazipur', 'russian');
INSERT INTO emkt_regions VALUES(336, 18, '19', 'Gaibandha', 'russian');
INSERT INTO emkt_regions VALUES(337, 18, '20', 'Habiganj', 'russian');
INSERT INTO emkt_regions VALUES(338, 18, '21', 'Jamalpur', 'russian');
INSERT INTO emkt_regions VALUES(339, 18, '22', 'Jessore', 'russian');
INSERT INTO emkt_regions VALUES(340, 18, '23', 'Jhenaidah', 'russian');
INSERT INTO emkt_regions VALUES(341, 18, '24', 'Jaipurhat', 'russian');
INSERT INTO emkt_regions VALUES(342, 18, '25', 'Jhalakati', 'russian');
INSERT INTO emkt_regions VALUES(343, 18, '26', 'Kishoreganj', 'russian');
INSERT INTO emkt_regions VALUES(344, 18, '27', 'Khulna', 'russian');
INSERT INTO emkt_regions VALUES(345, 18, '28', 'Kurigram', 'russian');
INSERT INTO emkt_regions VALUES(346, 18, '29', 'Khagrachari', 'russian');
INSERT INTO emkt_regions VALUES(347, 18, '30', 'Kushtia', 'russian');
INSERT INTO emkt_regions VALUES(348, 18, '31', 'Lakshmipur', 'russian');
INSERT INTO emkt_regions VALUES(349, 18, '32', 'Lalmonirhat', 'russian');
INSERT INTO emkt_regions VALUES(350, 18, '33', 'Manikganj', 'russian');
INSERT INTO emkt_regions VALUES(351, 18, '34', 'Mymensingh', 'russian');
INSERT INTO emkt_regions VALUES(352, 18, '35', 'Munshiganj', 'russian');
INSERT INTO emkt_regions VALUES(353, 18, '36', 'Madaripur', 'russian');
INSERT INTO emkt_regions VALUES(354, 18, '37', 'Magura', 'russian');
INSERT INTO emkt_regions VALUES(355, 18, '38', 'Moulvibazar', 'russian');
INSERT INTO emkt_regions VALUES(356, 18, '39', 'Meherpur', 'russian');
INSERT INTO emkt_regions VALUES(357, 18, '40', 'Narayanganj', 'russian');
INSERT INTO emkt_regions VALUES(358, 18, '41', 'Netrakona', 'russian');
INSERT INTO emkt_regions VALUES(359, 18, '42', 'Narsingdi', 'russian');
INSERT INTO emkt_regions VALUES(360, 18, '43', 'Narail', 'russian');
INSERT INTO emkt_regions VALUES(361, 18, '44', 'Natore', 'russian');
INSERT INTO emkt_regions VALUES(362, 18, '45', 'Nawabganj', 'russian');
INSERT INTO emkt_regions VALUES(363, 18, '46', 'Nilphamari', 'russian');
INSERT INTO emkt_regions VALUES(364, 18, '47', 'Noakhali', 'russian');
INSERT INTO emkt_regions VALUES(365, 18, '48', 'Naogaon', 'russian');
INSERT INTO emkt_regions VALUES(366, 18, '49', 'Pabna', 'russian');
INSERT INTO emkt_regions VALUES(367, 18, '50', 'Pirojpur', 'russian');
INSERT INTO emkt_regions VALUES(368, 18, '51', 'Patuakhali', 'russian');
INSERT INTO emkt_regions VALUES(369, 18, '52', 'Panchagarh', 'russian');
INSERT INTO emkt_regions VALUES(370, 18, '53', 'Rajbari', 'russian');
INSERT INTO emkt_regions VALUES(371, 18, '54', 'Rajshahi', 'russian');
INSERT INTO emkt_regions VALUES(372, 18, '55', 'Rangpur', 'russian');
INSERT INTO emkt_regions VALUES(373, 18, '56', 'Rangamati', 'russian');
INSERT INTO emkt_regions VALUES(374, 18, '57', 'Sherpur', 'russian');
INSERT INTO emkt_regions VALUES(375, 18, '58', 'Satkhira', 'russian');
INSERT INTO emkt_regions VALUES(376, 18, '59', 'Sirajganj', 'russian');
INSERT INTO emkt_regions VALUES(377, 18, '60', 'Sylhet', 'russian');
INSERT INTO emkt_regions VALUES(378, 18, '61', 'Sunamganj', 'russian');
INSERT INTO emkt_regions VALUES(379, 18, '62', 'Shariatpur', 'russian');
INSERT INTO emkt_regions VALUES(380, 18, '63', 'Tangail', 'russian');
INSERT INTO emkt_regions VALUES(381, 18, '64', 'Thakurgaon', 'russian');

INSERT INTO emkt_countries VALUES (19,'Барбадос','russian','BB','BRB','');

INSERT INTO emkt_regions VALUES(382, 19, 'A', 'Saint Andrew', 'russian');
INSERT INTO emkt_regions VALUES(383, 19, 'C', 'Christ Church', 'russian');
INSERT INTO emkt_regions VALUES(384, 19, 'E', 'Saint Peter', 'russian');
INSERT INTO emkt_regions VALUES(385, 19, 'G', 'Saint George', 'russian');
INSERT INTO emkt_regions VALUES(386, 19, 'J', 'Saint John', 'russian');
INSERT INTO emkt_regions VALUES(387, 19, 'L', 'Saint Lucy', 'russian');
INSERT INTO emkt_regions VALUES(388, 19, 'M', 'Saint Michael', 'russian');
INSERT INTO emkt_regions VALUES(389, 19, 'O', 'Saint Joseph', 'russian');
INSERT INTO emkt_regions VALUES(390, 19, 'P', 'Saint Philip', 'russian');
INSERT INTO emkt_regions VALUES(391, 19, 'S', 'Saint James', 'russian');
INSERT INTO emkt_regions VALUES(392, 19, 'T', 'Saint Thomas', 'russian');

INSERT INTO emkt_countries VALUES (20,'Беларусь','russian','BY','BLR','');

INSERT INTO emkt_regions VALUES(393, 20, 'BR', 'Брэсцкая вобласць', 'russian');
INSERT INTO emkt_regions VALUES(394, 20, 'HO', 'Гомельская вобласць', 'russian');
INSERT INTO emkt_regions VALUES(395, 20, 'HR', 'Гродзенская вобласць', 'russian');
INSERT INTO emkt_regions VALUES(396, 20, 'MA', 'Магілёўская вобласць', 'russian');
INSERT INTO emkt_regions VALUES(397, 20, 'MI', 'Мінская вобласць', 'russian');
INSERT INTO emkt_regions VALUES(398, 20, 'VI', 'Віцебская вобласць', 'russian');

INSERT INTO emkt_countries VALUES (21,'Бельгия','russian','BE','BEL','');

INSERT INTO emkt_regions VALUES(399, 21, 'BRU', 'Brussel', 'russian');
INSERT INTO emkt_regions VALUES(400, 21, 'VAN', 'Antwerpen', 'russian');
INSERT INTO emkt_regions VALUES(401, 21, 'VBR', 'Vlaams-Brabant', 'russian');
INSERT INTO emkt_regions VALUES(402, 21, 'VLI', 'Limburg', 'russian');
INSERT INTO emkt_regions VALUES(403, 21, 'VOV', 'Oost-Vlaanderen', 'russian');
INSERT INTO emkt_regions VALUES(404, 21, 'VWV', 'West-Vlaanderen', 'russian');
INSERT INTO emkt_regions VALUES(405, 21, 'WBR', 'Brabant Wallon', 'russian');
INSERT INTO emkt_regions VALUES(406, 21, 'WHT', 'Hainaut', 'russian');
INSERT INTO emkt_regions VALUES(407, 21, 'WLG', 'Liège/Lüttich', 'russian');
INSERT INTO emkt_regions VALUES(408, 21, 'WLX', 'Luxembourg', 'russian');
INSERT INTO emkt_regions VALUES(409, 21, 'WNA', 'Namur', 'russian');

INSERT INTO emkt_countries VALUES (22,'Белиз','russian','BZ','BLZ','');

INSERT INTO emkt_regions VALUES(410, 22, 'BZ', 'Belize District', 'russian');
INSERT INTO emkt_regions VALUES(411, 22, 'CY', 'Cayo District', 'russian');
INSERT INTO emkt_regions VALUES(412, 22, 'CZL', 'Corozal District', 'russian');
INSERT INTO emkt_regions VALUES(413, 22, 'OW', 'Orange Walk District', 'russian');
INSERT INTO emkt_regions VALUES(414, 22, 'SC', 'Stann Creek District', 'russian');
INSERT INTO emkt_regions VALUES(415, 22, 'TOL', 'Toledo District', 'russian');

INSERT INTO emkt_countries VALUES (23,'Бенин','russian','BJ','BEN','');

INSERT INTO emkt_regions VALUES(416, 23, 'AL', 'Alibori', 'russian');
INSERT INTO emkt_regions VALUES(417, 23, 'AK', 'Atakora', 'russian');
INSERT INTO emkt_regions VALUES(418, 23, 'AQ', 'Atlantique', 'russian');
INSERT INTO emkt_regions VALUES(419, 23, 'BO', 'Borgou', 'russian');
INSERT INTO emkt_regions VALUES(420, 23, 'CO', 'Collines', 'russian');
INSERT INTO emkt_regions VALUES(421, 23, 'DO', 'Donga', 'russian');
INSERT INTO emkt_regions VALUES(422, 23, 'KO', 'Kouffo', 'russian');
INSERT INTO emkt_regions VALUES(423, 23, 'LI', 'Littoral', 'russian');
INSERT INTO emkt_regions VALUES(424, 23, 'MO', 'Mono', 'russian');
INSERT INTO emkt_regions VALUES(425, 23, 'OU', 'Ouémé', 'russian');
INSERT INTO emkt_regions VALUES(426, 23, 'PL', 'Plateau', 'russian');
INSERT INTO emkt_regions VALUES(427, 23, 'ZO', 'Zou', 'russian');

INSERT INTO emkt_countries VALUES (24,'Бермудские Острова','russian','BM','BMU','');

INSERT INTO emkt_regions VALUES(428, 24, 'DEV', 'Devonshire', 'russian');
INSERT INTO emkt_regions VALUES(429, 24, 'HA', 'Hamilton City', 'russian');
INSERT INTO emkt_regions VALUES(430, 24, 'HAM', 'Hamilton', 'russian');
INSERT INTO emkt_regions VALUES(431, 24, 'PAG', 'Paget', 'russian');
INSERT INTO emkt_regions VALUES(432, 24, 'PEM', 'Pembroke', 'russian');
INSERT INTO emkt_regions VALUES(433, 24, 'SAN', 'Sandys', 'russian');
INSERT INTO emkt_regions VALUES(434, 24, 'SG', 'Saint George City', 'russian');
INSERT INTO emkt_regions VALUES(435, 24, 'SGE', 'Saint George\'s', 'russian');
INSERT INTO emkt_regions VALUES(436, 24, 'SMI', 'Smiths', 'russian');
INSERT INTO emkt_regions VALUES(437, 24, 'SOU', 'Southampton', 'russian');
INSERT INTO emkt_regions VALUES(438, 24, 'WAR', 'Warwick', 'russian');

INSERT INTO emkt_countries VALUES (25,'Бутан','russian','BT','BTN','');

INSERT INTO emkt_regions VALUES(439, 25, '11', 'Paro', 'russian');
INSERT INTO emkt_regions VALUES(440, 25, '12', 'Chukha', 'russian');
INSERT INTO emkt_regions VALUES(441, 25, '13', 'Haa', 'russian');
INSERT INTO emkt_regions VALUES(442, 25, '14', 'Samtse', 'russian');
INSERT INTO emkt_regions VALUES(443, 25, '15', 'Thimphu', 'russian');
INSERT INTO emkt_regions VALUES(444, 25, '21', 'Tsirang', 'russian');
INSERT INTO emkt_regions VALUES(445, 25, '22', 'Dagana', 'russian');
INSERT INTO emkt_regions VALUES(446, 25, '23', 'Punakha', 'russian');
INSERT INTO emkt_regions VALUES(447, 25, '24', 'Wangdue Phodrang', 'russian');
INSERT INTO emkt_regions VALUES(448, 25, '31', 'Sarpang', 'russian');
INSERT INTO emkt_regions VALUES(449, 25, '32', 'Trongsa', 'russian');
INSERT INTO emkt_regions VALUES(450, 25, '33', 'Bumthang', 'russian');
INSERT INTO emkt_regions VALUES(451, 25, '34', 'Zhemgang', 'russian');
INSERT INTO emkt_regions VALUES(452, 25, '41', 'Trashigang', 'russian');
INSERT INTO emkt_regions VALUES(453, 25, '42', 'Mongar', 'russian');
INSERT INTO emkt_regions VALUES(454, 25, '43', 'Pemagatshel', 'russian');
INSERT INTO emkt_regions VALUES(455, 25, '44', 'Luentse', 'russian');
INSERT INTO emkt_regions VALUES(456, 25, '45', 'Samdrup Jongkhar', 'russian');
INSERT INTO emkt_regions VALUES(457, 25, 'GA', 'Gasa', 'russian');
INSERT INTO emkt_regions VALUES(458, 25, 'TY', 'Trashiyangse', 'russian');

INSERT INTO emkt_countries VALUES (26,'Боливия','russian','BO','BOL','');

INSERT INTO emkt_regions VALUES(459, 26, 'B', 'El Beni', 'russian');
INSERT INTO emkt_regions VALUES(460, 26, 'C', 'Cochabamba', 'russian');
INSERT INTO emkt_regions VALUES(461, 26, 'H', 'Chuquisaca', 'russian');
INSERT INTO emkt_regions VALUES(462, 26, 'L', 'La Paz', 'russian');
INSERT INTO emkt_regions VALUES(463, 26, 'N', 'Pando', 'russian');
INSERT INTO emkt_regions VALUES(464, 26, 'O', 'Oruro', 'russian');
INSERT INTO emkt_regions VALUES(465, 26, 'P', 'Potosí', 'russian');
INSERT INTO emkt_regions VALUES(466, 26, 'S', 'Santa Cruz', 'russian');
INSERT INTO emkt_regions VALUES(467, 26, 'T', 'Tarija', 'russian');

INSERT INTO emkt_countries VALUES (27,'Босния и Герцеговина','russian','BA','BIH','');

INSERT INTO emkt_regions VALUES(4253, 27, 'NOCODE', 'Bosnia and Herzegowina', 'russian');

INSERT INTO emkt_countries VALUES (28,'Ботсвана','russian','BW','BWA','');

INSERT INTO emkt_regions VALUES(468, 28, 'CE', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(469, 28, 'GH', 'Ghanzi', 'russian');
INSERT INTO emkt_regions VALUES(470, 28, 'KG', 'Kgalagadi', 'russian');
INSERT INTO emkt_regions VALUES(471, 28, 'KL', 'Kgatleng', 'russian');
INSERT INTO emkt_regions VALUES(472, 28, 'KW', 'Kweneng', 'russian');
INSERT INTO emkt_regions VALUES(473, 28, 'NE', 'North-East', 'russian');
INSERT INTO emkt_regions VALUES(474, 28, 'NW', 'North-West', 'russian');
INSERT INTO emkt_regions VALUES(475, 28, 'SE', 'South-East', 'russian');
INSERT INTO emkt_regions VALUES(476, 28, 'SO', 'Southern', 'russian');

INSERT INTO emkt_countries VALUES (29,'Остров Буве','russian','BV','BVT','');

INSERT INTO emkt_regions VALUES(4254, 29, 'NOCODE', 'Bouvet Island', 'russian');

INSERT INTO emkt_countries VALUES (30,'Бразилия','russian','BR','BRA','');

INSERT INTO emkt_regions VALUES(477, 30, 'AC', 'Acre', 'russian');
INSERT INTO emkt_regions VALUES(478, 30, 'AL', 'Alagoas', 'russian');
INSERT INTO emkt_regions VALUES(479, 30, 'AM', 'Amazônia', 'russian');
INSERT INTO emkt_regions VALUES(480, 30, 'AP', 'Amapá', 'russian');
INSERT INTO emkt_regions VALUES(481, 30, 'BA', 'Bahia', 'russian');
INSERT INTO emkt_regions VALUES(482, 30, 'CE', 'Ceará', 'russian');
INSERT INTO emkt_regions VALUES(483, 30, 'DF', 'Distrito Federal', 'russian');
INSERT INTO emkt_regions VALUES(484, 30, 'ES', 'Espírito Santo', 'russian');
INSERT INTO emkt_regions VALUES(485, 30, 'GO', 'Goiás', 'russian');
INSERT INTO emkt_regions VALUES(486, 30, 'MA', 'Maranhão', 'russian');
INSERT INTO emkt_regions VALUES(487, 30, 'MG', 'Minas Gerais', 'russian');
INSERT INTO emkt_regions VALUES(488, 30, 'MS', 'Mato Grosso do Sul', 'russian');
INSERT INTO emkt_regions VALUES(489, 30, 'MT', 'Mato Grosso', 'russian');
INSERT INTO emkt_regions VALUES(490, 30, 'PA', 'Pará', 'russian');
INSERT INTO emkt_regions VALUES(491, 30, 'PB', 'Paraíba', 'russian');
INSERT INTO emkt_regions VALUES(492, 30, 'PE', 'Pernambuco', 'russian');
INSERT INTO emkt_regions VALUES(493, 30, 'PI', 'Piauí', 'russian');
INSERT INTO emkt_regions VALUES(494, 30, 'PR', 'Paraná', 'russian');
INSERT INTO emkt_regions VALUES(495, 30, 'RJ', 'Rio de Janeiro', 'russian');
INSERT INTO emkt_regions VALUES(496, 30, 'RN', 'Rio Grande do Norte', 'russian');
INSERT INTO emkt_regions VALUES(497, 30, 'RO', 'Rondônia', 'russian');
INSERT INTO emkt_regions VALUES(498, 30, 'RR', 'Roraima', 'russian');
INSERT INTO emkt_regions VALUES(499, 30, 'RS', 'Rio Grande do Sul', 'russian');
INSERT INTO emkt_regions VALUES(500, 30, 'SC', 'Santa Catarina', 'russian');
INSERT INTO emkt_regions VALUES(501, 30, 'SE', 'Sergipe', 'russian');
INSERT INTO emkt_regions VALUES(502, 30, 'SP', 'São Paulo', 'russian');
INSERT INTO emkt_regions VALUES(503, 30, 'TO', 'Tocantins', 'russian');

INSERT INTO emkt_countries VALUES (31,'Британская Территория в Индийском Океане','russian','IO','IOT','');

INSERT INTO emkt_regions VALUES(504, 31, 'PB', 'Peros Banhos', 'russian');
INSERT INTO emkt_regions VALUES(505, 31, 'SI', 'Salomon Islands', 'russian');
INSERT INTO emkt_regions VALUES(506, 31, 'NI', 'Nelsons Island', 'russian');
INSERT INTO emkt_regions VALUES(507, 31, 'TB', 'Three Brothers', 'russian');
INSERT INTO emkt_regions VALUES(508, 31, 'EA', 'Eagle Islands', 'russian');
INSERT INTO emkt_regions VALUES(509, 31, 'DI', 'Danger Island', 'russian');
INSERT INTO emkt_regions VALUES(510, 31, 'EG', 'Egmont Islands', 'russian');
INSERT INTO emkt_regions VALUES(511, 31, 'DG', 'Diego Garcia', 'russian');

INSERT INTO emkt_countries VALUES (32,'Бруней','russian','BN','BRN','');

INSERT INTO emkt_regions VALUES(512, 32, 'BE', 'Belait', 'russian');
INSERT INTO emkt_regions VALUES(513, 32, 'BM', 'Brunei-Muara', 'russian');
INSERT INTO emkt_regions VALUES(514, 32, 'TE', 'Temburong', 'russian');
INSERT INTO emkt_regions VALUES(515, 32, 'TU', 'Tutong', 'russian');

INSERT INTO emkt_countries VALUES (33,'Болгария','russian','BG','BGR','');

INSERT INTO emkt_regions VALUES(516, 33, '01', 'Blagoevgrad', 'russian');
INSERT INTO emkt_regions VALUES(517, 33, '02', 'Burgas', 'russian');
INSERT INTO emkt_regions VALUES(518, 33, '03', 'Varna', 'russian');
INSERT INTO emkt_regions VALUES(519, 33, '04', 'Veliko Tarnovo', 'russian');
INSERT INTO emkt_regions VALUES(520, 33, '05', 'Vidin', 'russian');
INSERT INTO emkt_regions VALUES(521, 33, '06', 'Vratsa', 'russian');
INSERT INTO emkt_regions VALUES(522, 33, '07', 'Gabrovo', 'russian');
INSERT INTO emkt_regions VALUES(523, 33, '08', 'Dobrich', 'russian');
INSERT INTO emkt_regions VALUES(524, 33, '09', 'Kardzhali', 'russian');
INSERT INTO emkt_regions VALUES(525, 33, '10', 'Kyustendil', 'russian');
INSERT INTO emkt_regions VALUES(526, 33, '11', 'Lovech', 'russian');
INSERT INTO emkt_regions VALUES(527, 33, '12', 'Montana', 'russian');
INSERT INTO emkt_regions VALUES(528, 33, '13', 'Pazardzhik', 'russian');
INSERT INTO emkt_regions VALUES(529, 33, '14', 'Pernik', 'russian');
INSERT INTO emkt_regions VALUES(530, 33, '15', 'Pleven', 'russian');
INSERT INTO emkt_regions VALUES(531, 33, '16', 'Plovdiv', 'russian');
INSERT INTO emkt_regions VALUES(532, 33, '17', 'Razgrad', 'russian');
INSERT INTO emkt_regions VALUES(533, 33, '18', 'Ruse', 'russian');
INSERT INTO emkt_regions VALUES(534, 33, '19', 'Silistra', 'russian');
INSERT INTO emkt_regions VALUES(535, 33, '20', 'Sliven', 'russian');
INSERT INTO emkt_regions VALUES(536, 33, '21', 'Smolyan', 'russian');
INSERT INTO emkt_regions VALUES(537, 33, '23', 'Sofia', 'russian');
INSERT INTO emkt_regions VALUES(538, 33, '22', 'Sofia Province', 'russian');
INSERT INTO emkt_regions VALUES(539, 33, '24', 'Stara Zagora', 'russian');
INSERT INTO emkt_regions VALUES(540, 33, '25', 'Targovishte', 'russian');
INSERT INTO emkt_regions VALUES(541, 33, '26', 'Haskovo', 'russian');
INSERT INTO emkt_regions VALUES(542, 33, '27', 'Shumen', 'russian');
INSERT INTO emkt_regions VALUES(543, 33, '28', 'Yambol', 'russian');

INSERT INTO emkt_countries VALUES (34,'Буркина-Фасо','russian','BF','BFA','');

INSERT INTO emkt_regions VALUES(544, 34, 'BAL', 'Balé', 'russian');
INSERT INTO emkt_regions VALUES(545, 34, 'BAM', 'Bam', 'russian');
INSERT INTO emkt_regions VALUES(546, 34, 'BAN', 'Banwa', 'russian');
INSERT INTO emkt_regions VALUES(547, 34, 'BAZ', 'Bazèga', 'russian');
INSERT INTO emkt_regions VALUES(548, 34, 'BGR', 'Bougouriba', 'russian');
INSERT INTO emkt_regions VALUES(549, 34, 'BLG', 'Boulgou', 'russian');
INSERT INTO emkt_regions VALUES(550, 34, 'BLK', 'Boulkiemdé', 'russian');
INSERT INTO emkt_regions VALUES(551, 34, 'COM', 'Komoé', 'russian');
INSERT INTO emkt_regions VALUES(552, 34, 'GAN', 'Ganzourgou', 'russian');
INSERT INTO emkt_regions VALUES(553, 34, 'GNA', 'Gnagna', 'russian');
INSERT INTO emkt_regions VALUES(554, 34, 'GOU', 'Gourma', 'russian');
INSERT INTO emkt_regions VALUES(555, 34, 'HOU', 'Houet', 'russian');
INSERT INTO emkt_regions VALUES(556, 34, 'IOB', 'Ioba', 'russian');
INSERT INTO emkt_regions VALUES(557, 34, 'KAD', 'Kadiogo', 'russian');
INSERT INTO emkt_regions VALUES(558, 34, 'KEN', 'Kénédougou', 'russian');
INSERT INTO emkt_regions VALUES(559, 34, 'KMD', 'Komondjari', 'russian');
INSERT INTO emkt_regions VALUES(560, 34, 'KMP', 'Kompienga', 'russian');
INSERT INTO emkt_regions VALUES(561, 34, 'KOP', 'Koulpélogo', 'russian');
INSERT INTO emkt_regions VALUES(562, 34, 'KOS', 'Kossi', 'russian');
INSERT INTO emkt_regions VALUES(563, 34, 'KOT', 'Kouritenga', 'russian');
INSERT INTO emkt_regions VALUES(564, 34, 'KOW', 'Kourwéogo', 'russian');
INSERT INTO emkt_regions VALUES(565, 34, 'LER', 'Léraba', 'russian');
INSERT INTO emkt_regions VALUES(566, 34, 'LOR', 'Loroum', 'russian');
INSERT INTO emkt_regions VALUES(567, 34, 'MOU', 'Mouhoun', 'russian');
INSERT INTO emkt_regions VALUES(568, 34, 'NAM', 'Namentenga', 'russian');
INSERT INTO emkt_regions VALUES(569, 34, 'NAO', 'Naouri', 'russian');
INSERT INTO emkt_regions VALUES(570, 34, 'NAY', 'Nayala', 'russian');
INSERT INTO emkt_regions VALUES(571, 34, 'NOU', 'Noumbiel', 'russian');
INSERT INTO emkt_regions VALUES(572, 34, 'OUB', 'Oubritenga', 'russian');
INSERT INTO emkt_regions VALUES(573, 34, 'OUD', 'Oudalan', 'russian');
INSERT INTO emkt_regions VALUES(574, 34, 'PAS', 'Passoré', 'russian');
INSERT INTO emkt_regions VALUES(575, 34, 'PON', 'Poni', 'russian');
INSERT INTO emkt_regions VALUES(576, 34, 'SEN', 'Séno', 'russian');
INSERT INTO emkt_regions VALUES(577, 34, 'SIS', 'Sissili', 'russian');
INSERT INTO emkt_regions VALUES(578, 34, 'SMT', 'Sanmatenga', 'russian');
INSERT INTO emkt_regions VALUES(579, 34, 'SNG', 'Sanguié', 'russian');
INSERT INTO emkt_regions VALUES(580, 34, 'SOM', 'Soum', 'russian');
INSERT INTO emkt_regions VALUES(581, 34, 'SOR', 'Sourou', 'russian');
INSERT INTO emkt_regions VALUES(582, 34, 'TAP', 'Tapoa', 'russian');
INSERT INTO emkt_regions VALUES(583, 34, 'TUI', 'Tui', 'russian');
INSERT INTO emkt_regions VALUES(584, 34, 'YAG', 'Yagha', 'russian');
INSERT INTO emkt_regions VALUES(585, 34, 'YAT', 'Yatenga', 'russian');
INSERT INTO emkt_regions VALUES(586, 34, 'ZIR', 'Ziro', 'russian');
INSERT INTO emkt_regions VALUES(587, 34, 'ZON', 'Zondoma', 'russian');
INSERT INTO emkt_regions VALUES(588, 34, 'ZOU', 'Zoundwéogo', 'russian');

INSERT INTO emkt_countries VALUES (35,'Бурунди','russian','BI','BDI','');

INSERT INTO emkt_regions VALUES(589, 35, 'BB', 'Bubanza', 'russian');
INSERT INTO emkt_regions VALUES(590, 35, 'BJ', 'Bujumbura Mairie', 'russian');
INSERT INTO emkt_regions VALUES(591, 35, 'BR', 'Bururi', 'russian');
INSERT INTO emkt_regions VALUES(592, 35, 'CA', 'Cankuzo', 'russian');
INSERT INTO emkt_regions VALUES(593, 35, 'CI', 'Cibitoke', 'russian');
INSERT INTO emkt_regions VALUES(594, 35, 'GI', 'Gitega', 'russian');
INSERT INTO emkt_regions VALUES(595, 35, 'KR', 'Karuzi', 'russian');
INSERT INTO emkt_regions VALUES(596, 35, 'KY', 'Kayanza', 'russian');
INSERT INTO emkt_regions VALUES(597, 35, 'KI', 'Kirundo', 'russian');
INSERT INTO emkt_regions VALUES(598, 35, 'MA', 'Makamba', 'russian');
INSERT INTO emkt_regions VALUES(599, 35, 'MU', 'Muramvya', 'russian');
INSERT INTO emkt_regions VALUES(600, 35, 'MY', 'Muyinga', 'russian');
INSERT INTO emkt_regions VALUES(601, 35, 'MW', 'Mwaro', 'russian');
INSERT INTO emkt_regions VALUES(602, 35, 'NG', 'Ngozi', 'russian');
INSERT INTO emkt_regions VALUES(603, 35, 'RT', 'Rutana', 'russian');
INSERT INTO emkt_regions VALUES(604, 35, 'RY', 'Ruyigi', 'russian');

INSERT INTO emkt_countries VALUES (36,'Камбоджа','russian','KH','KHM','');

INSERT INTO emkt_regions VALUES(4255, 36, 'NOCODE', 'Cambodia', 'russian');

INSERT INTO emkt_countries VALUES (37,'Камерун','russian','CM','CMR','');

INSERT INTO emkt_regions VALUES(605, 37, 'AD', 'Adamaoua', 'russian');
INSERT INTO emkt_regions VALUES(606, 37, 'CE', 'Centre', 'russian');
INSERT INTO emkt_regions VALUES(607, 37, 'EN', 'Extrême-Nord', 'russian');
INSERT INTO emkt_regions VALUES(608, 37, 'ES', 'Est', 'russian');
INSERT INTO emkt_regions VALUES(609, 37, 'LT', 'Littoral', 'russian');
INSERT INTO emkt_regions VALUES(610, 37, 'NO', 'Nord', 'russian');
INSERT INTO emkt_regions VALUES(611, 37, 'NW', 'Nord-Ouest', 'russian');
INSERT INTO emkt_regions VALUES(612, 37, 'OU', 'Ouest', 'russian');
INSERT INTO emkt_regions VALUES(613, 37, 'SU', 'Sud', 'russian');
INSERT INTO emkt_regions VALUES(614, 37, 'SW', 'Sud-Ouest', 'russian');

INSERT INTO emkt_countries VALUES (38,'Канада','russian','CA','CAN','');

INSERT INTO emkt_regions VALUES(615, 38, 'AB', 'Alberta', 'russian');
INSERT INTO emkt_regions VALUES(616, 38, 'BC', 'British Columbia', 'russian');
INSERT INTO emkt_regions VALUES(617, 38, 'MB', 'Manitoba', 'russian');
INSERT INTO emkt_regions VALUES(618, 38, 'NB', 'New Brunswick', 'russian');
INSERT INTO emkt_regions VALUES(619, 38, 'NL', 'Newfoundland and Labrador', 'russian');
INSERT INTO emkt_regions VALUES(620, 38, 'NS', 'Nova Scotia', 'russian');
INSERT INTO emkt_regions VALUES(621, 38, 'NT', 'Northwest Territories', 'russian');
INSERT INTO emkt_regions VALUES(622, 38, 'NU', 'Nunavut', 'russian');
INSERT INTO emkt_regions VALUES(623, 38, 'ON', 'Ontario', 'russian');
INSERT INTO emkt_regions VALUES(624, 38, 'PE', 'Prince Edward Island', 'russian');
INSERT INTO emkt_regions VALUES(625, 38, 'QC', 'Quebec', 'russian');
INSERT INTO emkt_regions VALUES(626, 38, 'SK', 'Saskatchewan', 'russian');
INSERT INTO emkt_regions VALUES(627, 38, 'YT', 'Yukon Territory', 'russian');

INSERT INTO emkt_countries VALUES (39,'Кабо-Верде','russian','CV','CPV','');

INSERT INTO emkt_regions VALUES(628, 39, 'BR', 'Brava', 'russian');
INSERT INTO emkt_regions VALUES(629, 39, 'BV', 'Boa Vista', 'russian');
INSERT INTO emkt_regions VALUES(630, 39, 'CA', 'Santa Catarina', 'russian');
INSERT INTO emkt_regions VALUES(631, 39, 'CR', 'Santa Cruz', 'russian');
INSERT INTO emkt_regions VALUES(632, 39, 'CS', 'Calheta de São Miguel', 'russian');
INSERT INTO emkt_regions VALUES(633, 39, 'MA', 'Maio', 'russian');
INSERT INTO emkt_regions VALUES(634, 39, 'MO', 'Mosteiros', 'russian');
INSERT INTO emkt_regions VALUES(635, 39, 'PA', 'Paúl', 'russian');
INSERT INTO emkt_regions VALUES(636, 39, 'PN', 'Porto Novo', 'russian');
INSERT INTO emkt_regions VALUES(637, 39, 'PR', 'Praia', 'russian');
INSERT INTO emkt_regions VALUES(638, 39, 'RG', 'Ribeira Grande', 'russian');
INSERT INTO emkt_regions VALUES(639, 39, 'SD', 'São Domingos', 'russian');
INSERT INTO emkt_regions VALUES(640, 39, 'SF', 'São Filipe', 'russian');
INSERT INTO emkt_regions VALUES(641, 39, 'SL', 'Sal', 'russian');
INSERT INTO emkt_regions VALUES(642, 39, 'SN', 'São Nicolau', 'russian');
INSERT INTO emkt_regions VALUES(643, 39, 'SV', 'São Vicente', 'russian');
INSERT INTO emkt_regions VALUES(644, 39, 'TA', 'Tarrafal', 'russian');

INSERT INTO emkt_countries VALUES (40,'Острова Кайман','russian','KY','CYM','');

INSERT INTO emkt_regions VALUES(645, 40, 'CR', 'Creek', 'russian');
INSERT INTO emkt_regions VALUES(646, 40, 'EA', 'Eastern', 'russian');
INSERT INTO emkt_regions VALUES(647, 40, 'MI', 'Midland', 'russian');
INSERT INTO emkt_regions VALUES(648, 40, 'SO', 'South Town', 'russian');
INSERT INTO emkt_regions VALUES(649, 40, 'SP', 'Spot Bay', 'russian');
INSERT INTO emkt_regions VALUES(650, 40, 'ST', 'Stake Bay', 'russian');
INSERT INTO emkt_regions VALUES(651, 40, 'WD', 'West End', 'russian');
INSERT INTO emkt_regions VALUES(652, 40, 'WN', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (41,'Центральноафриканская Республика','russian','CF','CAF','');

INSERT INTO emkt_regions VALUES(653, 41, 'AC ', 'Ouham', 'russian');
INSERT INTO emkt_regions VALUES(654, 41, 'BB ', 'Bamingui-Bangoran', 'russian');
INSERT INTO emkt_regions VALUES(655, 41, 'BGF', 'Bangui', 'russian');
INSERT INTO emkt_regions VALUES(656, 41, 'BK ', 'Basse-Kotto', 'russian');
INSERT INTO emkt_regions VALUES(657, 41, 'HK ', 'Haute-Kotto', 'russian');
INSERT INTO emkt_regions VALUES(658, 41, 'HM ', 'Haut-Mbomou', 'russian');
INSERT INTO emkt_regions VALUES(659, 41, 'HS ', 'Mambéré-Kadéï', 'russian');
INSERT INTO emkt_regions VALUES(660, 41, 'KB ', 'Nana-Grébizi', 'russian');
INSERT INTO emkt_regions VALUES(661, 41, 'KG ', 'Kémo', 'russian');
INSERT INTO emkt_regions VALUES(662, 41, 'LB ', 'Lobaye', 'russian');
INSERT INTO emkt_regions VALUES(663, 41, 'MB ', 'Mbomou', 'russian');
INSERT INTO emkt_regions VALUES(664, 41, 'MP ', 'Ombella-M\'Poko', 'russian');
INSERT INTO emkt_regions VALUES(665, 41, 'NM ', 'Nana-Mambéré', 'russian');
INSERT INTO emkt_regions VALUES(666, 41, 'OP ', 'Ouham-Pendé', 'russian');
INSERT INTO emkt_regions VALUES(667, 41, 'SE ', 'Sangha-Mbaéré', 'russian');
INSERT INTO emkt_regions VALUES(668, 41, 'UK ', 'Ouaka', 'russian');
INSERT INTO emkt_regions VALUES(669, 41, 'VR ', 'Vakaga', 'russian');

INSERT INTO emkt_countries VALUES (42,'Чад','russian','TD','TCD','');

INSERT INTO emkt_regions VALUES(670, 42, 'BA ', 'Batha', 'russian');
INSERT INTO emkt_regions VALUES(671, 42, 'BET', 'Borkou-Ennedi-Tibesti', 'russian');
INSERT INTO emkt_regions VALUES(672, 42, 'BI ', 'Biltine', 'russian');
INSERT INTO emkt_regions VALUES(673, 42, 'CB ', 'Chari-Baguirmi', 'russian');
INSERT INTO emkt_regions VALUES(674, 42, 'GR ', 'Guéra', 'russian');
INSERT INTO emkt_regions VALUES(675, 42, 'KA ', 'Kanem', 'russian');
INSERT INTO emkt_regions VALUES(676, 42, 'LC ', 'Lac', 'russian');
INSERT INTO emkt_regions VALUES(677, 42, 'LR ', 'Logone-Oriental', 'russian');
INSERT INTO emkt_regions VALUES(678, 42, 'LO ', 'Logone-Occidental', 'russian');
INSERT INTO emkt_regions VALUES(679, 42, 'MC ', 'Moyen-Chari', 'russian');
INSERT INTO emkt_regions VALUES(680, 42, 'MK ', 'Mayo-Kébbi', 'russian');
INSERT INTO emkt_regions VALUES(681, 42, 'OD ', 'Ouaddaï', 'russian');
INSERT INTO emkt_regions VALUES(682, 42, 'SA ', 'Salamat', 'russian');
INSERT INTO emkt_regions VALUES(683, 42, 'TA ', 'Tandjilé', 'russian');

INSERT INTO emkt_countries VALUES (43,'Чили','russian','CL','CHL','');

INSERT INTO emkt_regions VALUES(684, 43, 'AI', 'Aisén del General Carlos Ibañez', 'russian');
INSERT INTO emkt_regions VALUES(685, 43, 'AN', 'Antofagasta', 'russian');
INSERT INTO emkt_regions VALUES(686, 43, 'AR', 'La Araucanía', 'russian');
INSERT INTO emkt_regions VALUES(687, 43, 'AT', 'Atacama', 'russian');
INSERT INTO emkt_regions VALUES(688, 43, 'BI', 'Biobío', 'russian');
INSERT INTO emkt_regions VALUES(689, 43, 'CO', 'Coquimbo', 'russian');
INSERT INTO emkt_regions VALUES(690, 43, 'LI', 'Libertador Bernardo O\'Higgins', 'russian');
INSERT INTO emkt_regions VALUES(691, 43, 'LL', 'Los Lagos', 'russian');
INSERT INTO emkt_regions VALUES(692, 43, 'MA', 'Magallanes y de la Antartica', 'russian');
INSERT INTO emkt_regions VALUES(693, 43, 'ML', 'Maule', 'russian');
INSERT INTO emkt_regions VALUES(694, 43, 'RM', 'Metropolitana de Santiago', 'russian');
INSERT INTO emkt_regions VALUES(695, 43, 'TA', 'Tarapacá', 'russian');
INSERT INTO emkt_regions VALUES(696, 43, 'VS', 'Valparaíso', 'russian');

INSERT INTO emkt_countries VALUES (44,'Китайская Народная Республика','russian','CN','CHN','');

INSERT INTO emkt_regions VALUES(697, 44, '11', '北京', 'russian');
INSERT INTO emkt_regions VALUES(698, 44, '12', '天津', 'russian');
INSERT INTO emkt_regions VALUES(699, 44, '13', '河北', 'russian');
INSERT INTO emkt_regions VALUES(700, 44, '14', '山西', 'russian');
INSERT INTO emkt_regions VALUES(701, 44, '15', '内蒙古自治区', 'russian');
INSERT INTO emkt_regions VALUES(702, 44, '21', '辽宁', 'russian');
INSERT INTO emkt_regions VALUES(703, 44, '22', '吉林', 'russian');
INSERT INTO emkt_regions VALUES(704, 44, '23', '黑龙江省', 'russian');
INSERT INTO emkt_regions VALUES(705, 44, '31', '上海', 'russian');
INSERT INTO emkt_regions VALUES(706, 44, '32', '江苏', 'russian');
INSERT INTO emkt_regions VALUES(707, 44, '33', '浙江', 'russian');
INSERT INTO emkt_regions VALUES(708, 44, '34', '安徽', 'russian');
INSERT INTO emkt_regions VALUES(709, 44, '35', '福建', 'russian');
INSERT INTO emkt_regions VALUES(710, 44, '36', '江西', 'russian');
INSERT INTO emkt_regions VALUES(711, 44, '37', '山东', 'russian');
INSERT INTO emkt_regions VALUES(712, 44, '41', '河南', 'russian');
INSERT INTO emkt_regions VALUES(713, 44, '42', '湖北', 'russian');
INSERT INTO emkt_regions VALUES(714, 44, '43', '湖南', 'russian');
INSERT INTO emkt_regions VALUES(715, 44, '44', '广东', 'russian');
INSERT INTO emkt_regions VALUES(716, 44, '45', '广西壮族自治区', 'russian');
INSERT INTO emkt_regions VALUES(717, 44, '46', '海南', 'russian');
INSERT INTO emkt_regions VALUES(718, 44, '50', '重庆', 'russian');
INSERT INTO emkt_regions VALUES(719, 44, '51', '四川', 'russian');
INSERT INTO emkt_regions VALUES(720, 44, '52', '贵州', 'russian');
INSERT INTO emkt_regions VALUES(721, 44, '53', '云南', 'russian');
INSERT INTO emkt_regions VALUES(722, 44, '54', '西藏自治区', 'russian');
INSERT INTO emkt_regions VALUES(723, 44, '61', '陕西', 'russian');
INSERT INTO emkt_regions VALUES(724, 44, '62', '甘肃', 'russian');
INSERT INTO emkt_regions VALUES(725, 44, '63', '青海', 'russian');
INSERT INTO emkt_regions VALUES(726, 44, '64', '宁夏', 'russian');
INSERT INTO emkt_regions VALUES(727, 44, '65', '新疆', 'russian');
INSERT INTO emkt_regions VALUES(728, 44, '71', '臺灣', 'russian');
INSERT INTO emkt_regions VALUES(729, 44, '91', '香港', 'russian');
INSERT INTO emkt_regions VALUES(730, 44, '92', '澳門', 'russian');

INSERT INTO emkt_countries VALUES (45,'Остров Рождества','russian','CX','CXR','');

INSERT INTO emkt_regions VALUES(4256, 45, 'NOCODE', 'Christmas Island', 'russian');

INSERT INTO emkt_countries VALUES (46,'Кокосовые острова','russian','CC','CCK','');

INSERT INTO emkt_regions VALUES(731, 46, 'D', 'Direction Island', 'russian');
INSERT INTO emkt_regions VALUES(732, 46, 'H', 'Home Island', 'russian');
INSERT INTO emkt_regions VALUES(733, 46, 'O', 'Horsburgh Island', 'russian');
INSERT INTO emkt_regions VALUES(734, 46, 'S', 'South Island', 'russian');
INSERT INTO emkt_regions VALUES(735, 46, 'W', 'West Island', 'russian');

INSERT INTO emkt_countries VALUES (47,'Колумбия','russian','CO','COL','');

INSERT INTO emkt_regions VALUES(736, 47, 'AMA', 'Amazonas', 'russian');
INSERT INTO emkt_regions VALUES(737, 47, 'ANT', 'Antioquia', 'russian');
INSERT INTO emkt_regions VALUES(738, 47, 'ARA', 'Arauca', 'russian');
INSERT INTO emkt_regions VALUES(739, 47, 'ATL', 'Atlántico', 'russian');
INSERT INTO emkt_regions VALUES(740, 47, 'BOL', 'Bolívar', 'russian');
INSERT INTO emkt_regions VALUES(741, 47, 'BOY', 'Boyacá', 'russian');
INSERT INTO emkt_regions VALUES(742, 47, 'CAL', 'Caldas', 'russian');
INSERT INTO emkt_regions VALUES(743, 47, 'CAQ', 'Caquetá', 'russian');
INSERT INTO emkt_regions VALUES(744, 47, 'CAS', 'Casanare', 'russian');
INSERT INTO emkt_regions VALUES(745, 47, 'CAU', 'Cauca', 'russian');
INSERT INTO emkt_regions VALUES(746, 47, 'CES', 'Cesar', 'russian');
INSERT INTO emkt_regions VALUES(747, 47, 'CHO', 'Chocó', 'russian');
INSERT INTO emkt_regions VALUES(748, 47, 'COR', 'Córdoba', 'russian');
INSERT INTO emkt_regions VALUES(749, 47, 'CUN', 'Cundinamarca', 'russian');
INSERT INTO emkt_regions VALUES(750, 47, 'DC', 'Bogotá Distrito Capital', 'russian');
INSERT INTO emkt_regions VALUES(751, 47, 'GUA', 'Guainía', 'russian');
INSERT INTO emkt_regions VALUES(752, 47, 'GUV', 'Guaviare', 'russian');
INSERT INTO emkt_regions VALUES(753, 47, 'HUI', 'Huila', 'russian');
INSERT INTO emkt_regions VALUES(754, 47, 'LAG', 'La Guajira', 'russian');
INSERT INTO emkt_regions VALUES(755, 47, 'MAG', 'Magdalena', 'russian');
INSERT INTO emkt_regions VALUES(756, 47, 'MET', 'Meta', 'russian');
INSERT INTO emkt_regions VALUES(757, 47, 'NAR', 'Nariño', 'russian');
INSERT INTO emkt_regions VALUES(758, 47, 'NSA', 'Norte de Santander', 'russian');
INSERT INTO emkt_regions VALUES(759, 47, 'PUT', 'Putumayo', 'russian');
INSERT INTO emkt_regions VALUES(760, 47, 'QUI', 'Quindío', 'russian');
INSERT INTO emkt_regions VALUES(761, 47, 'RIS', 'Risaralda', 'russian');
INSERT INTO emkt_regions VALUES(762, 47, 'SAN', 'Santander', 'russian');
INSERT INTO emkt_regions VALUES(763, 47, 'SAP', 'San Andrés y Providencia', 'russian');
INSERT INTO emkt_regions VALUES(764, 47, 'SUC', 'Sucre', 'russian');
INSERT INTO emkt_regions VALUES(765, 47, 'TOL', 'Tolima', 'russian');
INSERT INTO emkt_regions VALUES(766, 47, 'VAC', 'Valle del Cauca', 'russian');
INSERT INTO emkt_regions VALUES(767, 47, 'VAU', 'Vaupés', 'russian');
INSERT INTO emkt_regions VALUES(768, 47, 'VID', 'Vichada', 'russian');

INSERT INTO emkt_countries VALUES (48,'Коморы','russian','KM','COM','');

INSERT INTO emkt_regions VALUES(769, 48, 'A', 'Anjouan', 'russian');
INSERT INTO emkt_regions VALUES(770, 48, 'G', 'Grande Comore', 'russian');
INSERT INTO emkt_regions VALUES(771, 48, 'M', 'Mohéli', 'russian');

INSERT INTO emkt_countries VALUES (49,'Конго','russian','CG','COG','');

INSERT INTO emkt_regions VALUES(772, 49, 'BC', 'Congo-Central', 'russian');
INSERT INTO emkt_regions VALUES(773, 49, 'BN', 'Bandundu', 'russian');
INSERT INTO emkt_regions VALUES(774, 49, 'EQ', 'Équateur', 'russian');
INSERT INTO emkt_regions VALUES(775, 49, 'KA', 'Katanga', 'russian');
INSERT INTO emkt_regions VALUES(776, 49, 'KE', 'Kasai-Oriental', 'russian');
INSERT INTO emkt_regions VALUES(777, 49, 'KN', 'Kinshasa', 'russian');
INSERT INTO emkt_regions VALUES(778, 49, 'KW', 'Kasai-Occidental', 'russian');
INSERT INTO emkt_regions VALUES(779, 49, 'MA', 'Maniema', 'russian');
INSERT INTO emkt_regions VALUES(780, 49, 'NK', 'Nord-Kivu', 'russian');
INSERT INTO emkt_regions VALUES(781, 49, 'OR', 'Orientale', 'russian');
INSERT INTO emkt_regions VALUES(782, 49, 'SK', 'Sud-Kivu', 'russian');

INSERT INTO emkt_countries VALUES (50,'Острова Кука','russian','CK','COK','');

INSERT INTO emkt_regions VALUES(783, 50, 'PU', 'Pukapuka', 'russian');
INSERT INTO emkt_regions VALUES(784, 50, 'RK', 'Rakahanga', 'russian');
INSERT INTO emkt_regions VALUES(785, 50, 'MK', 'Manihiki', 'russian');
INSERT INTO emkt_regions VALUES(786, 50, 'PE', 'Penrhyn', 'russian');
INSERT INTO emkt_regions VALUES(787, 50, 'NI', 'Nassau Island', 'russian');
INSERT INTO emkt_regions VALUES(788, 50, 'SU', 'Surwarrow', 'russian');
INSERT INTO emkt_regions VALUES(789, 50, 'PA', 'Palmerston', 'russian');
INSERT INTO emkt_regions VALUES(790, 50, 'AI', 'Aitutaki', 'russian');
INSERT INTO emkt_regions VALUES(791, 50, 'MA', 'Manuae', 'russian');
INSERT INTO emkt_regions VALUES(792, 50, 'TA', 'Takutea', 'russian');
INSERT INTO emkt_regions VALUES(793, 50, 'MT', 'Mitiaro', 'russian');
INSERT INTO emkt_regions VALUES(794, 50, 'AT', 'Atiu', 'russian');
INSERT INTO emkt_regions VALUES(795, 50, 'MU', 'Mauke', 'russian');
INSERT INTO emkt_regions VALUES(796, 50, 'RR', 'Rarotonga', 'russian');
INSERT INTO emkt_regions VALUES(797, 50, 'MG', 'Mangaia', 'russian');

INSERT INTO emkt_countries VALUES (51,'Коста-Рика','russian','CR','CRI','');

INSERT INTO emkt_regions VALUES(798, 51, 'A', 'Alajuela', 'russian');
INSERT INTO emkt_regions VALUES(799, 51, 'C', 'Cartago', 'russian');
INSERT INTO emkt_regions VALUES(800, 51, 'G', 'Guanacaste', 'russian');
INSERT INTO emkt_regions VALUES(801, 51, 'H', 'Heredia', 'russian');
INSERT INTO emkt_regions VALUES(802, 51, 'L', 'Limón', 'russian');
INSERT INTO emkt_regions VALUES(803, 51, 'P', 'Puntarenas', 'russian');
INSERT INTO emkt_regions VALUES(804, 51, 'SJ', 'San José', 'russian');

INSERT INTO emkt_countries VALUES (52,'Кот-Д\'Ивуар','russian','CI','CIV','');

INSERT INTO emkt_regions VALUES(805, 52, '01', 'Lagunes', 'russian');
INSERT INTO emkt_regions VALUES(806, 52, '02', 'Haut-Sassandra', 'russian');
INSERT INTO emkt_regions VALUES(807, 52, '03', 'Savanes', 'russian');
INSERT INTO emkt_regions VALUES(808, 52, '04', 'Vallée du Bandama', 'russian');
INSERT INTO emkt_regions VALUES(809, 52, '05', 'Moyen-Comoé', 'russian');
INSERT INTO emkt_regions VALUES(810, 52, '06', 'Dix-Huit', 'russian');
INSERT INTO emkt_regions VALUES(811, 52, '07', 'Lacs', 'russian');
INSERT INTO emkt_regions VALUES(812, 52, '08', 'Zanzan', 'russian');
INSERT INTO emkt_regions VALUES(813, 52, '09', 'Bas-Sassandra', 'russian');
INSERT INTO emkt_regions VALUES(814, 52, '10', 'Denguélé', 'russian');
INSERT INTO emkt_regions VALUES(815, 52, '11', 'N\'zi-Comoé', 'russian');
INSERT INTO emkt_regions VALUES(816, 52, '12', 'Marahoué', 'russian');
INSERT INTO emkt_regions VALUES(817, 52, '13', 'Sud-Comoé', 'russian');
INSERT INTO emkt_regions VALUES(818, 52, '14', 'Worodouqou', 'russian');
INSERT INTO emkt_regions VALUES(819, 52, '15', 'Sud-Bandama', 'russian');
INSERT INTO emkt_regions VALUES(820, 52, '16', 'Agnébi', 'russian');
INSERT INTO emkt_regions VALUES(821, 52, '17', 'Bafing', 'russian');
INSERT INTO emkt_regions VALUES(822, 52, '18', 'Fromager', 'russian');
INSERT INTO emkt_regions VALUES(823, 52, '19', 'Moyen-Cavally', 'russian');

INSERT INTO emkt_countries VALUES (53,'Хорватия','russian','HR','HRV','');

INSERT INTO emkt_regions VALUES(824, 53, '01', 'Zagrebačka županija', 'russian');
INSERT INTO emkt_regions VALUES(825, 53, '02', 'Krapinsko-zagorska županija', 'russian');
INSERT INTO emkt_regions VALUES(826, 53, '03', 'Sisačko-moslavačka županija', 'russian');
INSERT INTO emkt_regions VALUES(827, 53, '04', 'Karlovačka županija', 'russian');
INSERT INTO emkt_regions VALUES(828, 53, '05', 'Varaždinska županija', 'russian');
INSERT INTO emkt_regions VALUES(829, 53, '06', 'Koprivničko-križevačka županija', 'russian');
INSERT INTO emkt_regions VALUES(830, 53, '07', 'Bjelovarsko-bilogorska županija', 'russian');
INSERT INTO emkt_regions VALUES(831, 53, '08', 'Primorsko-goranska županija', 'russian');
INSERT INTO emkt_regions VALUES(832, 53, '09', 'Ličko-senjska županija', 'russian');
INSERT INTO emkt_regions VALUES(833, 53, '10', 'Virovitičko-podravska županija', 'russian');
INSERT INTO emkt_regions VALUES(834, 53, '11', 'Požeško-slavonska županija', 'russian');
INSERT INTO emkt_regions VALUES(835, 53, '12', 'Brodsko-posavska županija', 'russian');
INSERT INTO emkt_regions VALUES(836, 53, '13', 'Zadarska županija', 'russian');
INSERT INTO emkt_regions VALUES(837, 53, '14', 'Osječko-baranjska županija', 'russian');
INSERT INTO emkt_regions VALUES(838, 53, '15', 'Šibensko-kninska županija', 'russian');
INSERT INTO emkt_regions VALUES(839, 53, '16', 'Vukovarsko-srijemska županija', 'russian');
INSERT INTO emkt_regions VALUES(840, 53, '17', 'Splitsko-dalmatinska županija', 'russian');
INSERT INTO emkt_regions VALUES(841, 53, '18', 'Istarska županija', 'russian');
INSERT INTO emkt_regions VALUES(842, 53, '19', 'Dubrovačko-neretvanska županija', 'russian');
INSERT INTO emkt_regions VALUES(843, 53, '20', 'Međimurska županija', 'russian');
INSERT INTO emkt_regions VALUES(844, 53, '21', 'Zagreb', 'russian');

INSERT INTO emkt_countries VALUES (54,'Куба','russian','CU','CUB','');

INSERT INTO emkt_regions VALUES(845, 54, '01', 'Pinar del Río', 'russian');
INSERT INTO emkt_regions VALUES(846, 54, '02', 'La Habana', 'russian');
INSERT INTO emkt_regions VALUES(847, 54, '03', 'Ciudad de La Habana', 'russian');
INSERT INTO emkt_regions VALUES(848, 54, '04', 'Matanzas', 'russian');
INSERT INTO emkt_regions VALUES(849, 54, '05', 'Villa Clara', 'russian');
INSERT INTO emkt_regions VALUES(850, 54, '06', 'Cienfuegos', 'russian');
INSERT INTO emkt_regions VALUES(851, 54, '07', 'Sancti Spíritus', 'russian');
INSERT INTO emkt_regions VALUES(852, 54, '08', 'Ciego de Ávila', 'russian');
INSERT INTO emkt_regions VALUES(853, 54, '09', 'Camagüey', 'russian');
INSERT INTO emkt_regions VALUES(854, 54, '10', 'Las Tunas', 'russian');
INSERT INTO emkt_regions VALUES(855, 54, '11', 'Holguín', 'russian');
INSERT INTO emkt_regions VALUES(856, 54, '12', 'Granma', 'russian');
INSERT INTO emkt_regions VALUES(857, 54, '13', 'Santiago de Cuba', 'russian');
INSERT INTO emkt_regions VALUES(858, 54, '14', 'Guantánamo', 'russian');
INSERT INTO emkt_regions VALUES(859, 54, '99', 'Isla de la Juventud', 'russian');

INSERT INTO emkt_countries VALUES (55,'Республика Кипр','russian','CY','CYP','');

INSERT INTO emkt_regions VALUES(860, 55, '01', 'Κερύvεια', 'russian');
INSERT INTO emkt_regions VALUES(861, 55, '02', 'Λευκωσία', 'russian');
INSERT INTO emkt_regions VALUES(862, 55, '03', 'Αμμόχωστος', 'russian');
INSERT INTO emkt_regions VALUES(863, 55, '04', 'Λάρνακα', 'russian');
INSERT INTO emkt_regions VALUES(864, 55, '05', 'Λεμεσός', 'russian');
INSERT INTO emkt_regions VALUES(865, 55, '06', 'Πάφος', 'russian');

INSERT INTO emkt_countries VALUES (56,'Чешская Республика','russian','CZ','CZE','');

INSERT INTO emkt_regions VALUES(866, 56, 'JC', 'Jihočeský kraj', 'russian');
INSERT INTO emkt_regions VALUES(867, 56, 'JM', 'Jihomoravský kraj', 'russian');
INSERT INTO emkt_regions VALUES(868, 56, 'KA', 'Karlovarský kraj', 'russian');
INSERT INTO emkt_regions VALUES(869, 56, 'VY', 'Vysočina kraj', 'russian');
INSERT INTO emkt_regions VALUES(870, 56, 'KR', 'Královéhradecký kraj', 'russian');
INSERT INTO emkt_regions VALUES(871, 56, 'LI', 'Liberecký kraj', 'russian');
INSERT INTO emkt_regions VALUES(872, 56, 'MO', 'Moravskoslezský kraj', 'russian');
INSERT INTO emkt_regions VALUES(873, 56, 'OL', 'Olomoucký kraj', 'russian');
INSERT INTO emkt_regions VALUES(874, 56, 'PA', 'Pardubický kraj', 'russian');
INSERT INTO emkt_regions VALUES(875, 56, 'PL', 'Plzeňský kraj', 'russian');
INSERT INTO emkt_regions VALUES(876, 56, 'PR', 'Hlavní město Praha', 'russian');
INSERT INTO emkt_regions VALUES(877, 56, 'ST', 'Středočeský kraj', 'russian');
INSERT INTO emkt_regions VALUES(878, 56, 'US', 'Ústecký kraj', 'russian');
INSERT INTO emkt_regions VALUES(879, 56, 'ZL', 'Zlínský kraj', 'russian');

INSERT INTO emkt_countries VALUES (57,'Дания','russian','DK','DNK','');

INSERT INTO emkt_regions VALUES(880, 57, '040', 'Bornholms Regionskommune', 'russian');
INSERT INTO emkt_regions VALUES(881, 57, '101', 'København', 'russian');
INSERT INTO emkt_regions VALUES(882, 57, '147', 'Frederiksberg', 'russian');
INSERT INTO emkt_regions VALUES(883, 57, '070', 'Århus Amt', 'russian');
INSERT INTO emkt_regions VALUES(884, 57, '015', 'Københavns Amt', 'russian');
INSERT INTO emkt_regions VALUES(885, 57, '020', 'Frederiksborg Amt', 'russian');
INSERT INTO emkt_regions VALUES(886, 57, '042', 'Fyns Amt', 'russian');
INSERT INTO emkt_regions VALUES(887, 57, '080', 'Nordjyllands Amt', 'russian');
INSERT INTO emkt_regions VALUES(888, 57, '055', 'Ribe Amt', 'russian');
INSERT INTO emkt_regions VALUES(889, 57, '065', 'Ringkjøbing Amt', 'russian');
INSERT INTO emkt_regions VALUES(890, 57, '025', 'Roskilde Amt', 'russian');
INSERT INTO emkt_regions VALUES(891, 57, '050', 'Sønderjyllands Amt', 'russian');
INSERT INTO emkt_regions VALUES(892, 57, '035', 'Storstrøms Amt', 'russian');
INSERT INTO emkt_regions VALUES(893, 57, '060', 'Vejle Amt', 'russian');
INSERT INTO emkt_regions VALUES(894, 57, '030', 'Vestsjællands Amt', 'russian');
INSERT INTO emkt_regions VALUES(895, 57, '076', 'Viborg Amt', 'russian');

INSERT INTO emkt_countries VALUES (58,'Джибути','russian','DJ','DJI','');

INSERT INTO emkt_regions VALUES(896, 58, 'AS', 'Region d\'Ali Sabieh', 'russian');
INSERT INTO emkt_regions VALUES(897, 58, 'AR', 'Region d\'Arta', 'russian');
INSERT INTO emkt_regions VALUES(898, 58, 'DI', 'Region de Dikhil', 'russian');
INSERT INTO emkt_regions VALUES(899, 58, 'DJ', 'Ville de Djibouti', 'russian');
INSERT INTO emkt_regions VALUES(900, 58, 'OB', 'Region d\'Obock', 'russian');
INSERT INTO emkt_regions VALUES(901, 58, 'TA', 'Region de Tadjourah', 'russian');

INSERT INTO emkt_countries VALUES (59,'Доминика','russian','DM','DMA','');

INSERT INTO emkt_regions VALUES(902, 59, 'AND', 'Saint Andrew Parish', 'russian');
INSERT INTO emkt_regions VALUES(903, 59, 'DAV', 'Saint David Parish', 'russian');
INSERT INTO emkt_regions VALUES(904, 59, 'GEO', 'Saint George Parish', 'russian');
INSERT INTO emkt_regions VALUES(905, 59, 'JOH', 'Saint John Parish', 'russian');
INSERT INTO emkt_regions VALUES(906, 59, 'JOS', 'Saint Joseph Parish', 'russian');
INSERT INTO emkt_regions VALUES(907, 59, 'LUK', 'Saint Luke Parish', 'russian');
INSERT INTO emkt_regions VALUES(908, 59, 'MAR', 'Saint Mark Parish', 'russian');
INSERT INTO emkt_regions VALUES(909, 59, 'PAT', 'Saint Patrick Parish', 'russian');
INSERT INTO emkt_regions VALUES(910, 59, 'PAU', 'Saint Paul Parish', 'russian');
INSERT INTO emkt_regions VALUES(911, 59, 'PET', 'Saint Peter Parish', 'russian');

INSERT INTO emkt_countries VALUES (60,'Доминиканская Республика','russian','DO','DOM','');

INSERT INTO emkt_regions VALUES(912, 60, '01', 'Distrito Nacional', 'russian');
INSERT INTO emkt_regions VALUES(913, 60, '02', 'Ázua', 'russian');
INSERT INTO emkt_regions VALUES(914, 60, '03', 'Baoruco', 'russian');
INSERT INTO emkt_regions VALUES(915, 60, '04', 'Barahona', 'russian');
INSERT INTO emkt_regions VALUES(916, 60, '05', 'Dajabón', 'russian');
INSERT INTO emkt_regions VALUES(917, 60, '06', 'Duarte', 'russian');
INSERT INTO emkt_regions VALUES(918, 60, '07', 'Elías Piña', 'russian');
INSERT INTO emkt_regions VALUES(919, 60, '08', 'El Seibo', 'russian');
INSERT INTO emkt_regions VALUES(920, 60, '09', 'Espaillat', 'russian');
INSERT INTO emkt_regions VALUES(921, 60, '10', 'Independencia', 'russian');
INSERT INTO emkt_regions VALUES(922, 60, '11', 'La Altagracia', 'russian');
INSERT INTO emkt_regions VALUES(923, 60, '12', 'La Romana', 'russian');
INSERT INTO emkt_regions VALUES(924, 60, '13', 'La Vega', 'russian');
INSERT INTO emkt_regions VALUES(925, 60, '14', 'María Trinidad Sánchez', 'russian');
INSERT INTO emkt_regions VALUES(926, 60, '15', 'Monte Cristi', 'russian');
INSERT INTO emkt_regions VALUES(927, 60, '16', 'Pedernales', 'russian');
INSERT INTO emkt_regions VALUES(928, 60, '17', 'Peravia', 'russian');
INSERT INTO emkt_regions VALUES(929, 60, '18', 'Puerto Plata', 'russian');
INSERT INTO emkt_regions VALUES(930, 60, '19', 'Salcedo', 'russian');
INSERT INTO emkt_regions VALUES(931, 60, '20', 'Samaná', 'russian');
INSERT INTO emkt_regions VALUES(932, 60, '21', 'San Cristóbal', 'russian');
INSERT INTO emkt_regions VALUES(933, 60, '22', 'San Juan', 'russian');
INSERT INTO emkt_regions VALUES(934, 60, '23', 'San Pedro de Macorís', 'russian');
INSERT INTO emkt_regions VALUES(935, 60, '24', 'Sánchez Ramírez', 'russian');
INSERT INTO emkt_regions VALUES(936, 60, '25', 'Santiago', 'russian');
INSERT INTO emkt_regions VALUES(937, 60, '26', 'Santiago Rodríguez', 'russian');
INSERT INTO emkt_regions VALUES(938, 60, '27', 'Valverde', 'russian');
INSERT INTO emkt_regions VALUES(939, 60, '28', 'Monseñor Nouel', 'russian');
INSERT INTO emkt_regions VALUES(940, 60, '29', 'Monte Plata', 'russian');
INSERT INTO emkt_regions VALUES(941, 60, '30', 'Hato Mayor', 'russian');

INSERT INTO emkt_countries VALUES (61,'Восточный Тимор','russian','TP','TMP','');

INSERT INTO emkt_regions VALUES(942, 61, 'AL', 'Aileu', 'russian');
INSERT INTO emkt_regions VALUES(943, 61, 'AN', 'Ainaro', 'russian');
INSERT INTO emkt_regions VALUES(944, 61, 'BA', 'Baucau', 'russian');
INSERT INTO emkt_regions VALUES(945, 61, 'BO', 'Bobonaro', 'russian');
INSERT INTO emkt_regions VALUES(946, 61, 'CO', 'Cova-Lima', 'russian');
INSERT INTO emkt_regions VALUES(947, 61, 'DI', 'Dili', 'russian');
INSERT INTO emkt_regions VALUES(948, 61, 'ER', 'Ermera', 'russian');
INSERT INTO emkt_regions VALUES(949, 61, 'LA', 'Lautem', 'russian');
INSERT INTO emkt_regions VALUES(950, 61, 'LI', 'Liquiçá', 'russian');
INSERT INTO emkt_regions VALUES(951, 61, 'MF', 'Manufahi', 'russian');
INSERT INTO emkt_regions VALUES(952, 61, 'MT', 'Manatuto', 'russian');
INSERT INTO emkt_regions VALUES(953, 61, 'OE', 'Oecussi', 'russian');
INSERT INTO emkt_regions VALUES(954, 61, 'VI', 'Viqueque', 'russian');

INSERT INTO emkt_countries VALUES (62,'Эквадор','russian','EC','ECU','');

INSERT INTO emkt_regions VALUES(955, 62, 'A', 'Azuay', 'russian');
INSERT INTO emkt_regions VALUES(956, 62, 'B', 'Bolívar', 'russian');
INSERT INTO emkt_regions VALUES(957, 62, 'C', 'Carchi', 'russian');
INSERT INTO emkt_regions VALUES(958, 62, 'D', 'Orellana', 'russian');
INSERT INTO emkt_regions VALUES(959, 62, 'E', 'Esmeraldas', 'russian');
INSERT INTO emkt_regions VALUES(960, 62, 'F', 'Cañar', 'russian');
INSERT INTO emkt_regions VALUES(961, 62, 'G', 'Guayas', 'russian');
INSERT INTO emkt_regions VALUES(962, 62, 'H', 'Chimborazo', 'russian');
INSERT INTO emkt_regions VALUES(963, 62, 'I', 'Imbabura', 'russian');
INSERT INTO emkt_regions VALUES(964, 62, 'L', 'Loja', 'russian');
INSERT INTO emkt_regions VALUES(965, 62, 'M', 'Manabí', 'russian');
INSERT INTO emkt_regions VALUES(966, 62, 'N', 'Napo', 'russian');
INSERT INTO emkt_regions VALUES(967, 62, 'O', 'El Oro', 'russian');
INSERT INTO emkt_regions VALUES(968, 62, 'P', 'Pichincha', 'russian');
INSERT INTO emkt_regions VALUES(969, 62, 'R', 'Los Ríos', 'russian');
INSERT INTO emkt_regions VALUES(970, 62, 'S', 'Morona-Santiago', 'russian');
INSERT INTO emkt_regions VALUES(971, 62, 'T', 'Tungurahua', 'russian');
INSERT INTO emkt_regions VALUES(972, 62, 'U', 'Sucumbíos', 'russian');
INSERT INTO emkt_regions VALUES(973, 62, 'W', 'Galápagos', 'russian');
INSERT INTO emkt_regions VALUES(974, 62, 'X', 'Cotopaxi', 'russian');
INSERT INTO emkt_regions VALUES(975, 62, 'Y', 'Pastaza', 'russian');
INSERT INTO emkt_regions VALUES(976, 62, 'Z', 'Zamora-Chinchipe', 'russian');

INSERT INTO emkt_countries VALUES (63,'Египет','russian','EG','EGY','');

INSERT INTO emkt_regions VALUES(977, 63, 'ALX', 'الإسكندرية', 'russian');
INSERT INTO emkt_regions VALUES(978, 63, 'ASN', 'أسوان', 'russian');
INSERT INTO emkt_regions VALUES(979, 63, 'AST', 'أسيوط', 'russian');
INSERT INTO emkt_regions VALUES(980, 63, 'BA', 'البحر الأحمر', 'russian');
INSERT INTO emkt_regions VALUES(981, 63, 'BH', 'البحيرة', 'russian');
INSERT INTO emkt_regions VALUES(982, 63, 'BNS', 'بني سويف', 'russian');
INSERT INTO emkt_regions VALUES(983, 63, 'C', 'القاهرة', 'russian');
INSERT INTO emkt_regions VALUES(984, 63, 'DK', 'الدقهلية', 'russian');
INSERT INTO emkt_regions VALUES(985, 63, 'DT', 'دمياط', 'russian');
INSERT INTO emkt_regions VALUES(986, 63, 'FYM', 'الفيوم', 'russian');
INSERT INTO emkt_regions VALUES(987, 63, 'GH', 'الغربية', 'russian');
INSERT INTO emkt_regions VALUES(988, 63, 'GZ', 'الجيزة', 'russian');
INSERT INTO emkt_regions VALUES(989, 63, 'IS', 'الإسماعيلية', 'russian');
INSERT INTO emkt_regions VALUES(990, 63, 'JS', 'جنوب سيناء', 'russian');
INSERT INTO emkt_regions VALUES(991, 63, 'KB', 'القليوبية', 'russian');
INSERT INTO emkt_regions VALUES(992, 63, 'KFS', 'كفر الشيخ', 'russian');
INSERT INTO emkt_regions VALUES(993, 63, 'KN', 'قنا', 'russian');
INSERT INTO emkt_regions VALUES(994, 63, 'MN', 'محافظة المنيا', 'russian');
INSERT INTO emkt_regions VALUES(995, 63, 'MNF', 'المنوفية', 'russian');
INSERT INTO emkt_regions VALUES(996, 63, 'MT', 'مطروح', 'russian');
INSERT INTO emkt_regions VALUES(997, 63, 'PTS', 'محافظة بور سعيد', 'russian');
INSERT INTO emkt_regions VALUES(998, 63, 'SHG', 'محافظة سوهاج', 'russian');
INSERT INTO emkt_regions VALUES(999, 63, 'SHR', 'المحافظة الشرقيّة', 'russian');
INSERT INTO emkt_regions VALUES(1000, 63, 'SIN', 'شمال سيناء', 'russian');
INSERT INTO emkt_regions VALUES(1001, 63, 'SUZ', 'السويس', 'russian');
INSERT INTO emkt_regions VALUES(1002, 63, 'WAD', 'الوادى الجديد', 'russian');

INSERT INTO emkt_countries VALUES (64,'Сальвадор','russian','SV','SLV','');

INSERT INTO emkt_regions VALUES(1003, 64, 'AH', 'Ahuachapán', 'russian');
INSERT INTO emkt_regions VALUES(1004, 64, 'CA', 'Cabañas', 'russian');
INSERT INTO emkt_regions VALUES(1005, 64, 'CH', 'Chalatenango', 'russian');
INSERT INTO emkt_regions VALUES(1006, 64, 'CU', 'Cuscatlán', 'russian');
INSERT INTO emkt_regions VALUES(1007, 64, 'LI', 'La Libertad', 'russian');
INSERT INTO emkt_regions VALUES(1008, 64, 'MO', 'Morazán', 'russian');
INSERT INTO emkt_regions VALUES(1009, 64, 'PA', 'La Paz', 'russian');
INSERT INTO emkt_regions VALUES(1010, 64, 'SA', 'Santa Ana', 'russian');
INSERT INTO emkt_regions VALUES(1011, 64, 'SM', 'San Miguel', 'russian');
INSERT INTO emkt_regions VALUES(1012, 64, 'SO', 'Sonsonate', 'russian');
INSERT INTO emkt_regions VALUES(1013, 64, 'SS', 'San Salvador', 'russian');
INSERT INTO emkt_regions VALUES(1014, 64, 'SV', 'San Vicente', 'russian');
INSERT INTO emkt_regions VALUES(1015, 64, 'UN', 'La Unión', 'russian');
INSERT INTO emkt_regions VALUES(1016, 64, 'US', 'Usulután', 'russian');

INSERT INTO emkt_countries VALUES (65,'Экваториальная Гвинея','russian','GQ','GNQ','');

INSERT INTO emkt_regions VALUES(1017, 65, 'AN', 'Annobón', 'russian');
INSERT INTO emkt_regions VALUES(1018, 65, 'BN', 'Bioko Norte', 'russian');
INSERT INTO emkt_regions VALUES(1019, 65, 'BS', 'Bioko Sur', 'russian');
INSERT INTO emkt_regions VALUES(1020, 65, 'CS', 'Centro Sur', 'russian');
INSERT INTO emkt_regions VALUES(1021, 65, 'KN', 'Kié-Ntem', 'russian');
INSERT INTO emkt_regions VALUES(1022, 65, 'LI', 'Litoral', 'russian');
INSERT INTO emkt_regions VALUES(1023, 65, 'WN', 'Wele-Nzas', 'russian');

INSERT INTO emkt_countries VALUES (66,'Эритрея','russian','ER','ERI','');

INSERT INTO emkt_regions VALUES(1024, 66, 'AN', 'Zoba Anseba', 'russian');
INSERT INTO emkt_regions VALUES(1025, 66, 'DK', 'Zoba Debubawi Keyih Bahri', 'russian');
INSERT INTO emkt_regions VALUES(1026, 66, 'DU', 'Zoba Debub', 'russian');
INSERT INTO emkt_regions VALUES(1027, 66, 'GB', 'Zoba Gash-Barka', 'russian');
INSERT INTO emkt_regions VALUES(1028, 66, 'MA', 'Zoba Ma\'akel', 'russian');
INSERT INTO emkt_regions VALUES(1029, 66, 'SK', 'Zoba Semienawi Keyih Bahri', 'russian');

INSERT INTO emkt_countries VALUES (67,'Эстония','russian','EE','EST','');

INSERT INTO emkt_regions VALUES(1030, 67, '37', 'Harju maakond', 'russian');
INSERT INTO emkt_regions VALUES(1031, 67, '39', 'Hiiu maakond', 'russian');
INSERT INTO emkt_regions VALUES(1032, 67, '44', 'Ida-Viru maakond', 'russian');
INSERT INTO emkt_regions VALUES(1033, 67, '49', 'Jõgeva maakond', 'russian');
INSERT INTO emkt_regions VALUES(1034, 67, '51', 'Järva maakond', 'russian');
INSERT INTO emkt_regions VALUES(1035, 67, '57', 'Lääne maakond', 'russian');
INSERT INTO emkt_regions VALUES(1036, 67, '59', 'Lääne-Viru maakond', 'russian');
INSERT INTO emkt_regions VALUES(1037, 67, '65', 'Põlva maakond', 'russian');
INSERT INTO emkt_regions VALUES(1038, 67, '67', 'Pärnu maakond', 'russian');
INSERT INTO emkt_regions VALUES(1039, 67, '70', 'Rapla maakond', 'russian');
INSERT INTO emkt_regions VALUES(1040, 67, '74', 'Saare maakond', 'russian');
INSERT INTO emkt_regions VALUES(1041, 67, '78', 'Tartu maakond', 'russian');
INSERT INTO emkt_regions VALUES(1042, 67, '82', 'Valga maakond', 'russian');
INSERT INTO emkt_regions VALUES(1043, 67, '84', 'Viljandi maakond', 'russian');
INSERT INTO emkt_regions VALUES(1044, 67, '86', 'Võru maakond', 'russian');

INSERT INTO emkt_countries VALUES (68,'Эфиопия','russian','ET','ETH','');

INSERT INTO emkt_regions VALUES(1045, 68, 'AA', 'አዲስ አበባ', 'russian');
INSERT INTO emkt_regions VALUES(1046, 68, 'AF', 'አፋር', 'russian');
INSERT INTO emkt_regions VALUES(1047, 68, 'AH', 'አማራ', 'russian');
INSERT INTO emkt_regions VALUES(1048, 68, 'BG', 'ቤንሻንጉል-ጉምዝ', 'russian');
INSERT INTO emkt_regions VALUES(1049, 68, 'DD', 'ድሬዳዋ', 'russian');
INSERT INTO emkt_regions VALUES(1050, 68, 'GB', 'ጋምቤላ ሕዝቦች', 'russian');
INSERT INTO emkt_regions VALUES(1051, 68, 'HR', 'ሀረሪ ሕዝብ', 'russian');
INSERT INTO emkt_regions VALUES(1052, 68, 'OR', 'ኦሮሚያ', 'russian');
INSERT INTO emkt_regions VALUES(1053, 68, 'SM', 'ሶማሌ', 'russian');
INSERT INTO emkt_regions VALUES(1054, 68, 'SN', 'ደቡብ ብሔሮች ብሔረሰቦችና ሕዝቦች', 'russian');
INSERT INTO emkt_regions VALUES(1055, 68, 'TG', 'ትግራይ', 'russian');

INSERT INTO emkt_countries VALUES (69,'Фолклендские острова','russian','FK','FLK','');

INSERT INTO emkt_regions VALUES(4257, 69, 'NOCODE', 'Falkland Islands (Malvinas)', 'russian');

INSERT INTO emkt_countries VALUES (70,'Фарерские острова','russian','FO','FRO','');

INSERT INTO emkt_regions VALUES(4258, 70, 'NOCODE', 'Faroe Islands', 'russian');

INSERT INTO emkt_countries VALUES (71,'Фиджи','russian','FJ','FJI','');

INSERT INTO emkt_regions VALUES(1056, 71, 'C', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(1057, 71, 'E', 'Northern', 'russian');
INSERT INTO emkt_regions VALUES(1058, 71, 'N', 'Eastern', 'russian');
INSERT INTO emkt_regions VALUES(1059, 71, 'R', 'Rotuma', 'russian');
INSERT INTO emkt_regions VALUES(1060, 71, 'W', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (72,'Финляндия','russian','FI','FIN','');

INSERT INTO emkt_regions VALUES(1061, 72, 'AL', 'Ahvenanmaan maakunta', 'russian');
INSERT INTO emkt_regions VALUES(1062, 72, 'ES', 'Etelä-Suomen lääni', 'russian');
INSERT INTO emkt_regions VALUES(1063, 72, 'IS', 'Itä-Suomen lääni', 'russian');
INSERT INTO emkt_regions VALUES(1064, 72, 'LL', 'Lapin lääni', 'russian');
INSERT INTO emkt_regions VALUES(1065, 72, 'LS', 'Länsi-Suomen lääni', 'russian');
INSERT INTO emkt_regions VALUES(1066, 72, 'OL', 'Oulun lääni', 'russian');

INSERT INTO emkt_countries VALUES (73,'Франция','russian','FR','FRA','');

INSERT INTO emkt_regions VALUES(1067, 73, '01', 'Ain', 'russian');
INSERT INTO emkt_regions VALUES(1068, 73, '02', 'Aisne', 'russian');
INSERT INTO emkt_regions VALUES(1069, 73, '03', 'Allier', 'russian');
INSERT INTO emkt_regions VALUES(1070, 73, '04', 'Alpes-de-Haute-Provence', 'russian');
INSERT INTO emkt_regions VALUES(1071, 73, '05', 'Hautes-Alpes', 'russian');
INSERT INTO emkt_regions VALUES(1072, 73, '06', 'Alpes-Maritimes', 'russian');
INSERT INTO emkt_regions VALUES(1073, 73, '07', 'Ardèche', 'russian');
INSERT INTO emkt_regions VALUES(1074, 73, '08', 'Ardennes', 'russian');
INSERT INTO emkt_regions VALUES(1075, 73, '09', 'Ariège', 'russian');
INSERT INTO emkt_regions VALUES(1076, 73, '10', 'Aube', 'russian');
INSERT INTO emkt_regions VALUES(1077, 73, '11', 'Aude', 'russian');
INSERT INTO emkt_regions VALUES(1078, 73, '12', 'Aveyron', 'russian');
INSERT INTO emkt_regions VALUES(1079, 73, '13', 'Bouches-du-Rhône', 'russian');
INSERT INTO emkt_regions VALUES(1080, 73, '14', 'Calvados', 'russian');
INSERT INTO emkt_regions VALUES(1081, 73, '15', 'Cantal', 'russian');
INSERT INTO emkt_regions VALUES(1082, 73, '16', 'Charente', 'russian');
INSERT INTO emkt_regions VALUES(1083, 73, '17', 'Charente-Maritime', 'russian');
INSERT INTO emkt_regions VALUES(1084, 73, '18', 'Cher', 'russian');
INSERT INTO emkt_regions VALUES(1085, 73, '19', 'Corrèze', 'russian');
INSERT INTO emkt_regions VALUES(1086, 73, '21', 'Côte-d\'Or', 'russian');
INSERT INTO emkt_regions VALUES(1087, 73, '22', 'Côtes-d\'Armor', 'russian');
INSERT INTO emkt_regions VALUES(1088, 73, '23', 'Creuse', 'russian');
INSERT INTO emkt_regions VALUES(1089, 73, '24', 'Dordogne', 'russian');
INSERT INTO emkt_regions VALUES(1090, 73, '25', 'Doubs', 'russian');
INSERT INTO emkt_regions VALUES(1091, 73, '26', 'Drôme', 'russian');
INSERT INTO emkt_regions VALUES(1092, 73, '27', 'Eure', 'russian');
INSERT INTO emkt_regions VALUES(1093, 73, '28', 'Eure-et-Loir', 'russian');
INSERT INTO emkt_regions VALUES(1094, 73, '29', 'Finistère', 'russian');
INSERT INTO emkt_regions VALUES(1095, 73, '2A', 'Corse-du-Sud', 'russian');
INSERT INTO emkt_regions VALUES(1096, 73, '2B', 'Haute-Corse', 'russian');
INSERT INTO emkt_regions VALUES(1097, 73, '30', 'Gard', 'russian');
INSERT INTO emkt_regions VALUES(1098, 73, '31', 'Haute-Garonne', 'russian');
INSERT INTO emkt_regions VALUES(1099, 73, '32', 'Gers', 'russian');
INSERT INTO emkt_regions VALUES(1100, 73, '33', 'Gironde', 'russian');
INSERT INTO emkt_regions VALUES(1101, 73, '34', 'Hérault', 'russian');
INSERT INTO emkt_regions VALUES(1102, 73, '35', 'Ille-et-Vilaine', 'russian');
INSERT INTO emkt_regions VALUES(1103, 73, '36', 'Indre', 'russian');
INSERT INTO emkt_regions VALUES(1104, 73, '37', 'Indre-et-Loire', 'russian');
INSERT INTO emkt_regions VALUES(1105, 73, '38', 'Isère', 'russian');
INSERT INTO emkt_regions VALUES(1106, 73, '39', 'Jura', 'russian');
INSERT INTO emkt_regions VALUES(1107, 73, '40', 'Landes', 'russian');
INSERT INTO emkt_regions VALUES(1108, 73, '41', 'Loir-et-Cher', 'russian');
INSERT INTO emkt_regions VALUES(1109, 73, '42', 'Loire', 'russian');
INSERT INTO emkt_regions VALUES(1110, 73, '43', 'Haute-Loire', 'russian');
INSERT INTO emkt_regions VALUES(1111, 73, '44', 'Loire-Atlantique', 'russian');
INSERT INTO emkt_regions VALUES(1112, 73, '45', 'Loiret', 'russian');
INSERT INTO emkt_regions VALUES(1113, 73, '46', 'Lot', 'russian');
INSERT INTO emkt_regions VALUES(1114, 73, '47', 'Lot-et-Garonne', 'russian');
INSERT INTO emkt_regions VALUES(1115, 73, '48', 'Lozère', 'russian');
INSERT INTO emkt_regions VALUES(1116, 73, '49', 'Maine-et-Loire', 'russian');
INSERT INTO emkt_regions VALUES(1117, 73, '50', 'Manche', 'russian');
INSERT INTO emkt_regions VALUES(1118, 73, '51', 'Marne', 'russian');
INSERT INTO emkt_regions VALUES(1119, 73, '52', 'Haute-Marne', 'russian');
INSERT INTO emkt_regions VALUES(1120, 73, '53', 'Mayenne', 'russian');
INSERT INTO emkt_regions VALUES(1121, 73, '54', 'Meurthe-et-Moselle', 'russian');
INSERT INTO emkt_regions VALUES(1122, 73, '55', 'Meuse', 'russian');
INSERT INTO emkt_regions VALUES(1123, 73, '56', 'Morbihan', 'russian');
INSERT INTO emkt_regions VALUES(1124, 73, '57', 'Moselle', 'russian');
INSERT INTO emkt_regions VALUES(1125, 73, '58', 'Nièvre', 'russian');
INSERT INTO emkt_regions VALUES(1126, 73, '59', 'Nord', 'russian');
INSERT INTO emkt_regions VALUES(1127, 73, '60', 'Oise', 'russian');
INSERT INTO emkt_regions VALUES(1128, 73, '61', 'Orne', 'russian');
INSERT INTO emkt_regions VALUES(1129, 73, '62', 'Pas-de-Calais', 'russian');
INSERT INTO emkt_regions VALUES(1130, 73, '63', 'Puy-de-Dôme', 'russian');
INSERT INTO emkt_regions VALUES(1131, 73, '64', 'Pyrénées-Atlantiques', 'russian');
INSERT INTO emkt_regions VALUES(1132, 73, '65', 'Hautes-Pyrénées', 'russian');
INSERT INTO emkt_regions VALUES(1133, 73, '66', 'Pyrénées-Orientales', 'russian');
INSERT INTO emkt_regions VALUES(1134, 73, '67', 'Bas-Rhin', 'russian');
INSERT INTO emkt_regions VALUES(1135, 73, '68', 'Haut-Rhin', 'russian');
INSERT INTO emkt_regions VALUES(1136, 73, '69', 'Rhône', 'russian');
INSERT INTO emkt_regions VALUES(1137, 73, '70', 'Haute-Saône', 'russian');
INSERT INTO emkt_regions VALUES(1138, 73, '71', 'Saône-et-Loire', 'russian');
INSERT INTO emkt_regions VALUES(1139, 73, '72', 'Sarthe', 'russian');
INSERT INTO emkt_regions VALUES(1140, 73, '73', 'Savoie', 'russian');
INSERT INTO emkt_regions VALUES(1141, 73, '74', 'Haute-Savoie', 'russian');
INSERT INTO emkt_regions VALUES(1142, 73, '75', 'Paris', 'russian');
INSERT INTO emkt_regions VALUES(1143, 73, '76', 'Seine-Maritime', 'russian');
INSERT INTO emkt_regions VALUES(1144, 73, '77', 'Seine-et-Marne', 'russian');
INSERT INTO emkt_regions VALUES(1145, 73, '78', 'Yvelines', 'russian');
INSERT INTO emkt_regions VALUES(1146, 73, '79', 'Deux-Sèvres', 'russian');
INSERT INTO emkt_regions VALUES(1147, 73, '80', 'Somme', 'russian');
INSERT INTO emkt_regions VALUES(1148, 73, '81', 'Tarn', 'russian');
INSERT INTO emkt_regions VALUES(1149, 73, '82', 'Tarn-et-Garonne', 'russian');
INSERT INTO emkt_regions VALUES(1150, 73, '83', 'Var', 'russian');
INSERT INTO emkt_regions VALUES(1151, 73, '84', 'Vaucluse', 'russian');
INSERT INTO emkt_regions VALUES(1152, 73, '85', 'Vendée', 'russian');
INSERT INTO emkt_regions VALUES(1153, 73, '86', 'Vienne', 'russian');
INSERT INTO emkt_regions VALUES(1154, 73, '87', 'Haute-Vienne', 'russian');
INSERT INTO emkt_regions VALUES(1155, 73, '88', 'Vosges', 'russian');
INSERT INTO emkt_regions VALUES(1156, 73, '89', 'Yonne', 'russian');
INSERT INTO emkt_regions VALUES(1157, 73, '90', 'Territoire de Belfort', 'russian');
INSERT INTO emkt_regions VALUES(1158, 73, '91', 'Essonne', 'russian');
INSERT INTO emkt_regions VALUES(1159, 73, '92', 'Hauts-de-Seine', 'russian');
INSERT INTO emkt_regions VALUES(1160, 73, '93', 'Seine-Saint-Denis', 'russian');
INSERT INTO emkt_regions VALUES(1161, 73, '94', 'Val-de-Marne', 'russian');
INSERT INTO emkt_regions VALUES(1162, 73, '95', 'Val-d\'Oise', 'russian');
INSERT INTO emkt_regions VALUES(1163, 73, 'NC', 'Territoire des Nouvelle-Calédonie et Dependances', 'russian');
INSERT INTO emkt_regions VALUES(1164, 73, 'PF', 'Polynésie Française', 'russian');
INSERT INTO emkt_regions VALUES(1165, 73, 'PM', 'Saint-Pierre et Miquelon', 'russian');
INSERT INTO emkt_regions VALUES(1166, 73, 'TF', 'Terres australes et antarctiques françaises', 'russian');
INSERT INTO emkt_regions VALUES(1167, 73, 'YT', 'Mayotte', 'russian');
INSERT INTO emkt_regions VALUES(1168, 73, 'WF', 'Territoire des îles Wallis et Futuna', 'russian');

INSERT INTO emkt_countries VALUES (74,'Французская Гвиана','russian','GF','GUF','');

INSERT INTO emkt_regions VALUES(4259, 74, 'NOCODE', 'French Guiana', 'russian');

INSERT INTO emkt_countries VALUES (75,'Французская Полинезия','russian','PF','PYF','');

INSERT INTO emkt_regions VALUES(1169, 75, 'M', 'Archipel des Marquises', 'russian');
INSERT INTO emkt_regions VALUES(1170, 75, 'T', 'Archipel des Tuamotu', 'russian');
INSERT INTO emkt_regions VALUES(1171, 75, 'I', 'Archipel des Tubuai', 'russian');
INSERT INTO emkt_regions VALUES(1172, 75, 'V', 'Iles du Vent', 'russian');
INSERT INTO emkt_regions VALUES(1173, 75, 'S', 'Iles Sous-le-Vent', 'russian');

INSERT INTO emkt_countries VALUES (76,'Французские Южные и Антарктические территории','russian','TF','ATF','');

INSERT INTO emkt_regions VALUES(1174, 76, 'C', 'Iles Crozet', 'russian');
INSERT INTO emkt_regions VALUES(1175, 76, 'K', 'Iles Kerguelen', 'russian');
INSERT INTO emkt_regions VALUES(1176, 76, 'A', 'Ile Amsterdam', 'russian');
INSERT INTO emkt_regions VALUES(1177, 76, 'P', 'Ile Saint-Paul', 'russian');
INSERT INTO emkt_regions VALUES(1178, 76, 'D', 'Adelie Land', 'russian');

INSERT INTO emkt_countries VALUES (77,'Габон','russian','GA','GAB','');

INSERT INTO emkt_regions VALUES(1179, 77, 'ES', 'Estuaire', 'russian');
INSERT INTO emkt_regions VALUES(1180, 77, 'HO', 'Haut-Ogooue', 'russian');
INSERT INTO emkt_regions VALUES(1181, 77, 'MO', 'Moyen-Ogooue', 'russian');
INSERT INTO emkt_regions VALUES(1182, 77, 'NG', 'Ngounie', 'russian');
INSERT INTO emkt_regions VALUES(1183, 77, 'NY', 'Nyanga', 'russian');
INSERT INTO emkt_regions VALUES(1184, 77, 'OI', 'Ogooue-Ivindo', 'russian');
INSERT INTO emkt_regions VALUES(1185, 77, 'OL', 'Ogooue-Lolo', 'russian');
INSERT INTO emkt_regions VALUES(1186, 77, 'OM', 'Ogooue-Maritime', 'russian');
INSERT INTO emkt_regions VALUES(1187, 77, 'WN', 'Woleu-Ntem', 'russian');

INSERT INTO emkt_countries VALUES (78,'Гамбия','russian','GM','GMB','');

INSERT INTO emkt_regions VALUES(1188, 78, 'AH', 'Ashanti', 'russian');
INSERT INTO emkt_regions VALUES(1189, 78, 'BA', 'Brong-Ahafo', 'russian');
INSERT INTO emkt_regions VALUES(1190, 78, 'CP', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(1191, 78, 'EP', 'Eastern', 'russian');
INSERT INTO emkt_regions VALUES(1192, 78, 'AA', 'Greater Accra', 'russian');
INSERT INTO emkt_regions VALUES(1193, 78, 'NP', 'Northern', 'russian');
INSERT INTO emkt_regions VALUES(1194, 78, 'UE', 'Upper East', 'russian');
INSERT INTO emkt_regions VALUES(1195, 78, 'UW', 'Upper West', 'russian');
INSERT INTO emkt_regions VALUES(1196, 78, 'TV', 'Volta', 'russian');
INSERT INTO emkt_regions VALUES(1197, 78, 'WP', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (79,'Грузия','russian','GE','GEO','');

INSERT INTO emkt_regions VALUES(1198, 79, 'AB', 'აფხაზეთი', 'russian');
INSERT INTO emkt_regions VALUES(1199, 79, 'AJ', 'აჭარა', 'russian');
INSERT INTO emkt_regions VALUES(1200, 79, 'GU', 'გურია', 'russian');
INSERT INTO emkt_regions VALUES(1201, 79, 'IM', 'იმერეთი', 'russian');
INSERT INTO emkt_regions VALUES(1202, 79, 'KA', 'კახეთი', 'russian');
INSERT INTO emkt_regions VALUES(1203, 79, 'KK', 'ქვემო ქართლი', 'russian');
INSERT INTO emkt_regions VALUES(1204, 79, 'MM', 'მცხეთა-მთიანეთი', 'russian');
INSERT INTO emkt_regions VALUES(1205, 79, 'RL', 'რაჭა-ლეჩხუმი და ქვემო სვანეთი', 'russian');
INSERT INTO emkt_regions VALUES(1206, 79, 'SJ', 'სამცხე-ჯავახეთი', 'russian');
INSERT INTO emkt_regions VALUES(1207, 79, 'SK', 'შიდა ქართლი', 'russian');
INSERT INTO emkt_regions VALUES(1208, 79, 'SZ', 'სამეგრელო-ზემო სვანეთი', 'russian');
INSERT INTO emkt_regions VALUES(1209, 79, 'TB', 'თბილისი', 'russian');

INSERT INTO emkt_countries VALUES (80,'Германия','russian','DE','DEU','');

INSERT INTO emkt_regions VALUES(1210, 80, 'BE', 'Berlin', 'russian');
INSERT INTO emkt_regions VALUES(1211, 80, 'BR', 'Brandenburg', 'russian');
INSERT INTO emkt_regions VALUES(1212, 80, 'BW', 'Baden-Württemberg', 'russian');
INSERT INTO emkt_regions VALUES(1213, 80, 'BY', 'Bayern', 'russian');
INSERT INTO emkt_regions VALUES(1214, 80, 'HB', 'Bremen', 'russian');
INSERT INTO emkt_regions VALUES(1215, 80, 'HE', 'Hessen', 'russian');
INSERT INTO emkt_regions VALUES(1216, 80, 'HH', 'Hamburg', 'russian');
INSERT INTO emkt_regions VALUES(1217, 80, 'MV', 'Mecklenburg-Vorpommern', 'russian');
INSERT INTO emkt_regions VALUES(1218, 80, 'NI', 'Niedersachsen', 'russian');
INSERT INTO emkt_regions VALUES(1219, 80, 'NW', 'Nordrhein-Westfalen', 'russian');
INSERT INTO emkt_regions VALUES(1220, 80, 'RP', 'Rheinland-Pfalz', 'russian');
INSERT INTO emkt_regions VALUES(1221, 80, 'SH', 'Schleswig-Holstein', 'russian');
INSERT INTO emkt_regions VALUES(1222, 80, 'SL', 'Saarland', 'russian');
INSERT INTO emkt_regions VALUES(1223, 80, 'SN', 'Sachsen', 'russian');
INSERT INTO emkt_regions VALUES(1224, 80, 'ST', 'Sachsen-Anhalt', 'russian');
INSERT INTO emkt_regions VALUES(1225, 80, 'TH', 'Thüringen', 'russian');

INSERT INTO emkt_countries VALUES (81,'Гана','russian','GH','GHA','');

INSERT INTO emkt_regions VALUES(1226, 81, 'AA', 'Greater Accra', 'russian');
INSERT INTO emkt_regions VALUES(1227, 81, 'AH', 'Ashanti', 'russian');
INSERT INTO emkt_regions VALUES(1228, 81, 'BA', 'Brong-Ahafo', 'russian');
INSERT INTO emkt_regions VALUES(1229, 81, 'CP', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(1230, 81, 'EP', 'Eastern', 'russian');
INSERT INTO emkt_regions VALUES(1231, 81, 'NP', 'Northern', 'russian');
INSERT INTO emkt_regions VALUES(1232, 81, 'TV', 'Volta', 'russian');
INSERT INTO emkt_regions VALUES(1233, 81, 'UE', 'Upper East', 'russian');
INSERT INTO emkt_regions VALUES(1234, 81, 'UW', 'Upper West', 'russian');
INSERT INTO emkt_regions VALUES(1235, 81, 'WP', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (82,'Гибралтар','russian','GI','GIB','');

INSERT INTO emkt_regions VALUES(4260, 82, 'NOCODE', 'Gibraltar', 'russian');

INSERT INTO emkt_countries VALUES (83,'Греция','russian','GR','GRC','');

INSERT INTO emkt_regions VALUES(1236, 83, '01', 'Αιτωλοακαρνανία', 'russian');
INSERT INTO emkt_regions VALUES(1237, 83, '03', 'Βοιωτία', 'russian');
INSERT INTO emkt_regions VALUES(1238, 83, '04', 'Εύβοια', 'russian');
INSERT INTO emkt_regions VALUES(1239, 83, '05', 'Ευρυτανία', 'russian');
INSERT INTO emkt_regions VALUES(1240, 83, '06', 'Φθιώτιδα', 'russian');
INSERT INTO emkt_regions VALUES(1241, 83, '07', 'Φωκίδα', 'russian');
INSERT INTO emkt_regions VALUES(1242, 83, '11', 'Αργολίδα', 'russian');
INSERT INTO emkt_regions VALUES(1243, 83, '12', 'Αρκαδία', 'russian');
INSERT INTO emkt_regions VALUES(1244, 83, '13', 'Ἀχαΐα', 'russian');
INSERT INTO emkt_regions VALUES(1245, 83, '14', 'Ηλεία', 'russian');
INSERT INTO emkt_regions VALUES(1246, 83, '15', 'Κορινθία', 'russian');
INSERT INTO emkt_regions VALUES(1247, 83, '16', 'Λακωνία', 'russian');
INSERT INTO emkt_regions VALUES(1248, 83, '17', 'Μεσσηνία', 'russian');
INSERT INTO emkt_regions VALUES(1249, 83, '21', 'Ζάκυνθος', 'russian');
INSERT INTO emkt_regions VALUES(1250, 83, '22', 'Κέρκυρα', 'russian');
INSERT INTO emkt_regions VALUES(1251, 83, '23', 'Κεφαλλονιά', 'russian');
INSERT INTO emkt_regions VALUES(1252, 83, '24', 'Λευκάδα', 'russian');
INSERT INTO emkt_regions VALUES(1253, 83, '31', 'Άρτα', 'russian');
INSERT INTO emkt_regions VALUES(1254, 83, '32', 'Θεσπρωτία', 'russian');
INSERT INTO emkt_regions VALUES(1255, 83, '33', 'Ιωάννινα', 'russian');
INSERT INTO emkt_regions VALUES(1256, 83, '34', 'Πρεβεζα', 'russian');
INSERT INTO emkt_regions VALUES(1257, 83, '41', 'Καρδίτσα', 'russian');
INSERT INTO emkt_regions VALUES(1258, 83, '42', 'Λάρισα', 'russian');
INSERT INTO emkt_regions VALUES(1259, 83, '43', 'Μαγνησία', 'russian');
INSERT INTO emkt_regions VALUES(1260, 83, '44', 'Τρίκαλα', 'russian');
INSERT INTO emkt_regions VALUES(1261, 83, '51', 'Γρεβενά', 'russian');
INSERT INTO emkt_regions VALUES(1262, 83, '52', 'Δράμα', 'russian');
INSERT INTO emkt_regions VALUES(1263, 83, '53', 'Ημαθία', 'russian');
INSERT INTO emkt_regions VALUES(1264, 83, '54', 'Θεσσαλονίκη', 'russian');
INSERT INTO emkt_regions VALUES(1265, 83, '55', 'Καβάλα', 'russian');
INSERT INTO emkt_regions VALUES(1266, 83, '56', 'Καστοριά', 'russian');
INSERT INTO emkt_regions VALUES(1267, 83, '57', 'Κιλκίς', 'russian');
INSERT INTO emkt_regions VALUES(1268, 83, '58', 'Κοζάνη', 'russian');
INSERT INTO emkt_regions VALUES(1269, 83, '59', 'Πέλλα', 'russian');
INSERT INTO emkt_regions VALUES(1270, 83, '61', 'Πιερία', 'russian');
INSERT INTO emkt_regions VALUES(1271, 83, '62', 'Σερρών', 'russian');
INSERT INTO emkt_regions VALUES(1272, 83, '63', 'Φλώρινα', 'russian');
INSERT INTO emkt_regions VALUES(1273, 83, '64', 'Χαλκιδική', 'russian');
INSERT INTO emkt_regions VALUES(1274, 83, '69', 'Όρος Άθως', 'russian');
INSERT INTO emkt_regions VALUES(1275, 83, '71', 'Έβρος', 'russian');
INSERT INTO emkt_regions VALUES(1276, 83, '72', 'Ξάνθη', 'russian');
INSERT INTO emkt_regions VALUES(1277, 83, '73', 'Ροδόπη', 'russian');
INSERT INTO emkt_regions VALUES(1278, 83, '81', 'Δωδεκάνησα', 'russian');
INSERT INTO emkt_regions VALUES(1279, 83, '82', 'Κυκλάδες', 'russian');
INSERT INTO emkt_regions VALUES(1280, 83, '83', 'Λέσβου', 'russian');
INSERT INTO emkt_regions VALUES(1281, 83, '84', 'Σάμος', 'russian');
INSERT INTO emkt_regions VALUES(1282, 83, '85', 'Χίος', 'russian');
INSERT INTO emkt_regions VALUES(1283, 83, '91', 'Ηράκλειο', 'russian');
INSERT INTO emkt_regions VALUES(1284, 83, '92', 'Λασίθι', 'russian');
INSERT INTO emkt_regions VALUES(1285, 83, '93', 'Ρεθύμνο', 'russian');
INSERT INTO emkt_regions VALUES(1286, 83, '94', 'Χανίων', 'russian');
INSERT INTO emkt_regions VALUES(1287, 83, 'A1', 'Αττική', 'russian');

INSERT INTO emkt_countries VALUES (84,'Гренландия','russian','GL','GRL','');

INSERT INTO emkt_regions VALUES(1288, 84, 'A', 'Avannaa', 'russian');
INSERT INTO emkt_regions VALUES(1289, 84, 'T', 'Tunu ', 'russian');
INSERT INTO emkt_regions VALUES(1290, 84, 'K', 'Kitaa', 'russian');

INSERT INTO emkt_countries VALUES (85,'Гренада','russian','GD','GRD','');

INSERT INTO emkt_regions VALUES(1291, 85, 'A', 'Saint Andrew', 'russian');
INSERT INTO emkt_regions VALUES(1292, 85, 'D', 'Saint David', 'russian');
INSERT INTO emkt_regions VALUES(1293, 85, 'G', 'Saint George', 'russian');
INSERT INTO emkt_regions VALUES(1294, 85, 'J', 'Saint John', 'russian');
INSERT INTO emkt_regions VALUES(1295, 85, 'M', 'Saint Mark', 'russian');
INSERT INTO emkt_regions VALUES(1296, 85, 'P', 'Saint Patrick', 'russian');

INSERT INTO emkt_countries VALUES (86,'Гваделупа','russian','GP','GLP','');

INSERT INTO emkt_regions VALUES(4261, 86, 'NOCODE', 'Guadeloupe', 'russian');

INSERT INTO emkt_countries VALUES (87,'Гуам','russian','GU','GUM','');

INSERT INTO emkt_regions VALUES(4262, 87, 'NOCODE', 'Guam', 'russian');

INSERT INTO emkt_countries VALUES (88,'Гватемала','russian','GT','GTM','');

INSERT INTO emkt_regions VALUES(1297, 88, 'AV', 'Alta Verapaz', 'russian');
INSERT INTO emkt_regions VALUES(1298, 88, 'BV', 'Baja Verapaz', 'russian');
INSERT INTO emkt_regions VALUES(1299, 88, 'CM', 'Chimaltenango', 'russian');
INSERT INTO emkt_regions VALUES(1300, 88, 'CQ', 'Chiquimula', 'russian');
INSERT INTO emkt_regions VALUES(1301, 88, 'ES', 'Escuintla', 'russian');
INSERT INTO emkt_regions VALUES(1302, 88, 'GU', 'Guatemala', 'russian');
INSERT INTO emkt_regions VALUES(1303, 88, 'HU', 'Huehuetenango', 'russian');
INSERT INTO emkt_regions VALUES(1304, 88, 'IZ', 'Izabal', 'russian');
INSERT INTO emkt_regions VALUES(1305, 88, 'JA', 'Jalapa', 'russian');
INSERT INTO emkt_regions VALUES(1306, 88, 'JU', 'Jutiapa', 'russian');
INSERT INTO emkt_regions VALUES(1307, 88, 'PE', 'El Petén', 'russian');
INSERT INTO emkt_regions VALUES(1308, 88, 'PR', 'El Progreso', 'russian');
INSERT INTO emkt_regions VALUES(1309, 88, 'QC', 'El Quiché', 'russian');
INSERT INTO emkt_regions VALUES(1310, 88, 'QZ', 'Quetzaltenango', 'russian');
INSERT INTO emkt_regions VALUES(1311, 88, 'RE', 'Retalhuleu', 'russian');
INSERT INTO emkt_regions VALUES(1312, 88, 'SA', 'Sacatepéquez', 'russian');
INSERT INTO emkt_regions VALUES(1313, 88, 'SM', 'San Marcos', 'russian');
INSERT INTO emkt_regions VALUES(1314, 88, 'SO', 'Sololá', 'russian');
INSERT INTO emkt_regions VALUES(1315, 88, 'SR', 'Santa Rosa', 'russian');
INSERT INTO emkt_regions VALUES(1316, 88, 'SU', 'Suchitepéquez', 'russian');
INSERT INTO emkt_regions VALUES(1317, 88, 'TO', 'Totonicapán', 'russian');
INSERT INTO emkt_regions VALUES(1318, 88, 'ZA', 'Zacapa', 'russian');

INSERT INTO emkt_countries VALUES (89,'Гвинея','russian','GN','GIN','');

INSERT INTO emkt_regions VALUES(1319, 89, 'BE', 'Beyla', 'russian');
INSERT INTO emkt_regions VALUES(1320, 89, 'BF', 'Boffa', 'russian');
INSERT INTO emkt_regions VALUES(1321, 89, 'BK', 'Boké', 'russian');
INSERT INTO emkt_regions VALUES(1322, 89, 'CO', 'Coyah', 'russian');
INSERT INTO emkt_regions VALUES(1323, 89, 'DB', 'Dabola', 'russian');
INSERT INTO emkt_regions VALUES(1324, 89, 'DI', 'Dinguiraye', 'russian');
INSERT INTO emkt_regions VALUES(1325, 89, 'DL', 'Dalaba', 'russian');
INSERT INTO emkt_regions VALUES(1326, 89, 'DU', 'Dubréka', 'russian');
INSERT INTO emkt_regions VALUES(1327, 89, 'FA', 'Faranah', 'russian');
INSERT INTO emkt_regions VALUES(1328, 89, 'FO', 'Forécariah', 'russian');
INSERT INTO emkt_regions VALUES(1329, 89, 'FR', 'Fria', 'russian');
INSERT INTO emkt_regions VALUES(1330, 89, 'GA', 'Gaoual', 'russian');
INSERT INTO emkt_regions VALUES(1331, 89, 'GU', 'Guékédou', 'russian');
INSERT INTO emkt_regions VALUES(1332, 89, 'KA', 'Kankan', 'russian');
INSERT INTO emkt_regions VALUES(1333, 89, 'KB', 'Koubia', 'russian');
INSERT INTO emkt_regions VALUES(1334, 89, 'KD', 'Kindia', 'russian');
INSERT INTO emkt_regions VALUES(1335, 89, 'KE', 'Kérouané', 'russian');
INSERT INTO emkt_regions VALUES(1336, 89, 'KN', 'Koundara', 'russian');
INSERT INTO emkt_regions VALUES(1337, 89, 'KO', 'Kouroussa', 'russian');
INSERT INTO emkt_regions VALUES(1338, 89, 'KS', 'Kissidougou', 'russian');
INSERT INTO emkt_regions VALUES(1339, 89, 'LA', 'Labé', 'russian');
INSERT INTO emkt_regions VALUES(1340, 89, 'LE', 'Lélouma', 'russian');
INSERT INTO emkt_regions VALUES(1341, 89, 'LO', 'Lola', 'russian');
INSERT INTO emkt_regions VALUES(1342, 89, 'MC', 'Macenta', 'russian');
INSERT INTO emkt_regions VALUES(1343, 89, 'MD', 'Mandiana', 'russian');
INSERT INTO emkt_regions VALUES(1344, 89, 'ML', 'Mali', 'russian');
INSERT INTO emkt_regions VALUES(1345, 89, 'MM', 'Mamou', 'russian');
INSERT INTO emkt_regions VALUES(1346, 89, 'NZ', 'Nzérékoré', 'russian');
INSERT INTO emkt_regions VALUES(1347, 89, 'PI', 'Pita', 'russian');
INSERT INTO emkt_regions VALUES(1348, 89, 'SI', 'Siguiri', 'russian');
INSERT INTO emkt_regions VALUES(1349, 89, 'TE', 'Télimélé', 'russian');
INSERT INTO emkt_regions VALUES(1350, 89, 'TO', 'Tougué', 'russian');
INSERT INTO emkt_regions VALUES(1351, 89, 'YO', 'Yomou', 'russian');

INSERT INTO emkt_countries VALUES (90,'Гвинея-Бисау','russian','GW','GNB','');

INSERT INTO emkt_regions VALUES(1352, 90, 'BF', 'Bafata', 'russian');
INSERT INTO emkt_regions VALUES(1353, 90, 'BB', 'Biombo', 'russian');
INSERT INTO emkt_regions VALUES(1354, 90, 'BS', 'Bissau', 'russian');
INSERT INTO emkt_regions VALUES(1355, 90, 'BL', 'Bolama', 'russian');
INSERT INTO emkt_regions VALUES(1356, 90, 'CA', 'Cacheu', 'russian');
INSERT INTO emkt_regions VALUES(1357, 90, 'GA', 'Gabu', 'russian');
INSERT INTO emkt_regions VALUES(1358, 90, 'OI', 'Oio', 'russian');
INSERT INTO emkt_regions VALUES(1359, 90, 'QU', 'Quinara', 'russian');
INSERT INTO emkt_regions VALUES(1360, 90, 'TO', 'Tombali', 'russian');

INSERT INTO emkt_countries VALUES (91,'Гайана','russian','GY','GUY','');

INSERT INTO emkt_regions VALUES(1361, 91, 'BA', 'Barima-Waini', 'russian');
INSERT INTO emkt_regions VALUES(1362, 91, 'CU', 'Cuyuni-Mazaruni', 'russian');
INSERT INTO emkt_regions VALUES(1363, 91, 'DE', 'Demerara-Mahaica', 'russian');
INSERT INTO emkt_regions VALUES(1364, 91, 'EB', 'East Berbice-Corentyne', 'russian');
INSERT INTO emkt_regions VALUES(1365, 91, 'ES', 'Essequibo Islands-West Demerara', 'russian');
INSERT INTO emkt_regions VALUES(1366, 91, 'MA', 'Mahaica-Berbice', 'russian');
INSERT INTO emkt_regions VALUES(1367, 91, 'PM', 'Pomeroon-Supenaam', 'russian');
INSERT INTO emkt_regions VALUES(1368, 91, 'PT', 'Potaro-Siparuni', 'russian');
INSERT INTO emkt_regions VALUES(1369, 91, 'UD', 'Upper Demerara-Berbice', 'russian');
INSERT INTO emkt_regions VALUES(1370, 91, 'UT', 'Upper Takutu-Upper Essequibo', 'russian');

INSERT INTO emkt_countries VALUES (92,'Гаити','russian','HT','HTI','');

INSERT INTO emkt_regions VALUES(1371, 92, 'AR', 'Artibonite', 'russian');
INSERT INTO emkt_regions VALUES(1372, 92, 'CE', 'Centre', 'russian');
INSERT INTO emkt_regions VALUES(1373, 92, 'GA', 'Grand\'Anse', 'russian');
INSERT INTO emkt_regions VALUES(1374, 92, 'NI', 'Nippes', 'russian');
INSERT INTO emkt_regions VALUES(1375, 92, 'ND', 'Nord', 'russian');
INSERT INTO emkt_regions VALUES(1376, 92, 'NE', 'Nord-Est', 'russian');
INSERT INTO emkt_regions VALUES(1377, 92, 'NO', 'Nord-Ouest', 'russian');
INSERT INTO emkt_regions VALUES(1378, 92, 'OU', 'Ouest', 'russian');
INSERT INTO emkt_regions VALUES(1379, 92, 'SD', 'Sud', 'russian');
INSERT INTO emkt_regions VALUES(1380, 92, 'SE', 'Sud-Est', 'russian');

INSERT INTO emkt_countries VALUES (93,'Остров Херд и острова Макдональд','russian','HM','HMD','');

INSERT INTO emkt_regions VALUES(1381, 93, 'F', 'Flat Island', 'russian');
INSERT INTO emkt_regions VALUES(1382, 93, 'M', 'McDonald Island', 'russian');
INSERT INTO emkt_regions VALUES(1383, 93, 'S', 'Shag Island', 'russian');
INSERT INTO emkt_regions VALUES(1384, 93, 'H', 'Heard Island', 'russian');

INSERT INTO emkt_countries VALUES (94,'Гондурас','russian','HN','HND','');

INSERT INTO emkt_regions VALUES(1385, 94, 'AT', 'Atlántida', 'russian');
INSERT INTO emkt_regions VALUES(1386, 94, 'CH', 'Choluteca', 'russian');
INSERT INTO emkt_regions VALUES(1387, 94, 'CL', 'Colón', 'russian');
INSERT INTO emkt_regions VALUES(1388, 94, 'CM', 'Comayagua', 'russian');
INSERT INTO emkt_regions VALUES(1389, 94, 'CP', 'Copán', 'russian');
INSERT INTO emkt_regions VALUES(1390, 94, 'CR', 'Cortés', 'russian');
INSERT INTO emkt_regions VALUES(1391, 94, 'EP', 'El Paraíso', 'russian');
INSERT INTO emkt_regions VALUES(1392, 94, 'FM', 'Francisco Morazán', 'russian');
INSERT INTO emkt_regions VALUES(1393, 94, 'GD', 'Gracias a Dios', 'russian');
INSERT INTO emkt_regions VALUES(1394, 94, 'IB', 'Islas de la Bahía', 'russian');
INSERT INTO emkt_regions VALUES(1395, 94, 'IN', 'Intibucá', 'russian');
INSERT INTO emkt_regions VALUES(1396, 94, 'LE', 'Lempira', 'russian');
INSERT INTO emkt_regions VALUES(1397, 94, 'LP', 'La Paz', 'russian');
INSERT INTO emkt_regions VALUES(1398, 94, 'OC', 'Ocotepeque', 'russian');
INSERT INTO emkt_regions VALUES(1399, 94, 'OL', 'Olancho', 'russian');
INSERT INTO emkt_regions VALUES(1400, 94, 'SB', 'Santa Bárbara', 'russian');
INSERT INTO emkt_regions VALUES(1401, 94, 'VA', 'Valle', 'russian');
INSERT INTO emkt_regions VALUES(1402, 94, 'YO', 'Yoro', 'russian');

INSERT INTO emkt_countries VALUES (95,'Гонконг','russian','HK','HKG','');

INSERT INTO emkt_regions VALUES(1403, 95, 'HCW', '中西區', 'russian');
INSERT INTO emkt_regions VALUES(1404, 95, 'HEA', '東區', 'russian');
INSERT INTO emkt_regions VALUES(1405, 95, 'HSO', '南區', 'russian');
INSERT INTO emkt_regions VALUES(1406, 95, 'HWC', '灣仔區', 'russian');
INSERT INTO emkt_regions VALUES(1407, 95, 'KKC', '九龍城區', 'russian');
INSERT INTO emkt_regions VALUES(1408, 95, 'KKT', '觀塘區', 'russian');
INSERT INTO emkt_regions VALUES(1409, 95, 'KSS', '深水埗區', 'russian');
INSERT INTO emkt_regions VALUES(1410, 95, 'KWT', '黃大仙區', 'russian');
INSERT INTO emkt_regions VALUES(1411, 95, 'KYT', '油尖旺區', 'russian');
INSERT INTO emkt_regions VALUES(1412, 95, 'NIS', '離島區', 'russian');
INSERT INTO emkt_regions VALUES(1413, 95, 'NKT', '葵青區', 'russian');
INSERT INTO emkt_regions VALUES(1414, 95, 'NNO', '北區', 'russian');
INSERT INTO emkt_regions VALUES(1415, 95, 'NSK', '西貢區', 'russian');
INSERT INTO emkt_regions VALUES(1416, 95, 'NST', '沙田區', 'russian');
INSERT INTO emkt_regions VALUES(1417, 95, 'NTP', '大埔區', 'russian');
INSERT INTO emkt_regions VALUES(1418, 95, 'NTW', '荃灣區', 'russian');
INSERT INTO emkt_regions VALUES(1419, 95, 'NTM', '屯門區', 'russian');
INSERT INTO emkt_regions VALUES(1420, 95, 'NYL', '元朗區', 'russian');

INSERT INTO emkt_countries VALUES (96,'Венгрия','russian','HU','HUN','');

INSERT INTO emkt_regions VALUES(1421, 96, 'BA', 'Baranja megye', 'russian');
INSERT INTO emkt_regions VALUES(1422, 96, 'BC', 'Békéscsaba', 'russian');
INSERT INTO emkt_regions VALUES(1423, 96, 'BE', 'Békés megye', 'russian');
INSERT INTO emkt_regions VALUES(1424, 96, 'BK', 'Bács-Kiskun megye', 'russian');
INSERT INTO emkt_regions VALUES(1425, 96, 'BU', 'Budapest', 'russian');
INSERT INTO emkt_regions VALUES(1426, 96, 'BZ', 'Borsod-Abaúj-Zemplén megye', 'russian');
INSERT INTO emkt_regions VALUES(1427, 96, 'CS', 'Csongrád megye', 'russian');
INSERT INTO emkt_regions VALUES(1428, 96, 'DE', 'Debrecen', 'russian');
INSERT INTO emkt_regions VALUES(1429, 96, 'DU', 'Dunaújváros', 'russian');
INSERT INTO emkt_regions VALUES(1430, 96, 'EG', 'Eger', 'russian');
INSERT INTO emkt_regions VALUES(1431, 96, 'FE', 'Fejér megye', 'russian');
INSERT INTO emkt_regions VALUES(1432, 96, 'GS', 'Győr-Moson-Sopron megye', 'russian');
INSERT INTO emkt_regions VALUES(1433, 96, 'GY', 'Győr', 'russian');
INSERT INTO emkt_regions VALUES(1434, 96, 'HB', 'Hajdú-Bihar megye', 'russian');
INSERT INTO emkt_regions VALUES(1435, 96, 'HE', 'Heves megye', 'russian');
INSERT INTO emkt_regions VALUES(1436, 96, 'HV', 'Hódmezővásárhely', 'russian');
INSERT INTO emkt_regions VALUES(1437, 96, 'JN', 'Jász-Nagykun-Szolnok megye', 'russian');
INSERT INTO emkt_regions VALUES(1438, 96, 'KE', 'Komárom-Esztergom megye', 'russian');
INSERT INTO emkt_regions VALUES(1439, 96, 'KM', 'Kecskemét', 'russian');
INSERT INTO emkt_regions VALUES(1440, 96, 'KV', 'Kaposvár', 'russian');
INSERT INTO emkt_regions VALUES(1441, 96, 'MI', 'Miskolc', 'russian');
INSERT INTO emkt_regions VALUES(1442, 96, 'NK', 'Nagykanizsa', 'russian');
INSERT INTO emkt_regions VALUES(1443, 96, 'NO', 'Nógrád megye', 'russian');
INSERT INTO emkt_regions VALUES(1444, 96, 'NY', 'Nyíregyháza', 'russian');
INSERT INTO emkt_regions VALUES(1445, 96, 'PE', 'Pest megye', 'russian');
INSERT INTO emkt_regions VALUES(1446, 96, 'PS', 'Pécs', 'russian');
INSERT INTO emkt_regions VALUES(1447, 96, 'SD', 'Szeged', 'russian');
INSERT INTO emkt_regions VALUES(1448, 96, 'SF', 'Székesfehérvár', 'russian');
INSERT INTO emkt_regions VALUES(1449, 96, 'SH', 'Szombathely', 'russian');
INSERT INTO emkt_regions VALUES(1450, 96, 'SK', 'Szolnok', 'russian');
INSERT INTO emkt_regions VALUES(1451, 96, 'SN', 'Sopron', 'russian');
INSERT INTO emkt_regions VALUES(1452, 96, 'SO', 'Somogy megye', 'russian');
INSERT INTO emkt_regions VALUES(1453, 96, 'SS', 'Szekszárd', 'russian');
INSERT INTO emkt_regions VALUES(1454, 96, 'ST', 'Salgótarján', 'russian');
INSERT INTO emkt_regions VALUES(1455, 96, 'SZ', 'Szabolcs-Szatmár-Bereg megye', 'russian');
INSERT INTO emkt_regions VALUES(1456, 96, 'TB', 'Tatabánya', 'russian');
INSERT INTO emkt_regions VALUES(1457, 96, 'TO', 'Tolna megye', 'russian');
INSERT INTO emkt_regions VALUES(1458, 96, 'VA', 'Vas megye', 'russian');
INSERT INTO emkt_regions VALUES(1459, 96, 'VE', 'Veszprém megye', 'russian');
INSERT INTO emkt_regions VALUES(1460, 96, 'VM', 'Veszprém', 'russian');
INSERT INTO emkt_regions VALUES(1461, 96, 'ZA', 'Zala megye', 'russian');
INSERT INTO emkt_regions VALUES(1462, 96, 'ZE', 'Zalaegerszeg', 'russian');

INSERT INTO emkt_countries VALUES (97,'Исландия','russian','IS','ISL','');

INSERT INTO emkt_regions VALUES(1463, 97, '1', 'Höfuðborgarsvæðið', 'russian');
INSERT INTO emkt_regions VALUES(1464, 97, '2', 'Suðurnes', 'russian');
INSERT INTO emkt_regions VALUES(1465, 97, '3', 'Vesturland', 'russian');
INSERT INTO emkt_regions VALUES(1466, 97, '4', 'Vestfirðir', 'russian');
INSERT INTO emkt_regions VALUES(1467, 97, '5', 'Norðurland vestra', 'russian');
INSERT INTO emkt_regions VALUES(1468, 97, '6', 'Norðurland eystra', 'russian');
INSERT INTO emkt_regions VALUES(1469, 97, '7', 'Austfirðir', 'russian');
INSERT INTO emkt_regions VALUES(1470, 97, '8', 'Suðurland', 'russian');

INSERT INTO emkt_countries VALUES (98,'Индия','russian','IN','IND','');

INSERT INTO emkt_regions VALUES(1471, 98, 'IN-AN', 'अंडमान और निकोबार द्वीप', 'russian');
INSERT INTO emkt_regions VALUES(1472, 98, 'IN-AP', 'ఆంధ్ర ప్రదేశ్', 'russian');
INSERT INTO emkt_regions VALUES(1473, 98, 'IN-AR', 'अरुणाचल प्रदेश', 'russian');
INSERT INTO emkt_regions VALUES(1474, 98, 'IN-AS', 'অসম', 'russian');
INSERT INTO emkt_regions VALUES(1475, 98, 'IN-BR', 'बिहार', 'russian');
INSERT INTO emkt_regions VALUES(1476, 98, 'IN-CH', 'चंडीगढ़', 'russian');
INSERT INTO emkt_regions VALUES(1477, 98, 'IN-CT', 'छत्तीसगढ़', 'russian');
INSERT INTO emkt_regions VALUES(1478, 98, 'IN-DD', 'દમણ અને દિવ', 'russian');
INSERT INTO emkt_regions VALUES(1479, 98, 'IN-DL', 'दिल्ली', 'russian');
INSERT INTO emkt_regions VALUES(1480, 98, 'IN-DN', 'દાદરા અને નગર હવેલી', 'russian');
INSERT INTO emkt_regions VALUES(1481, 98, 'IN-GA', 'गोंय', 'russian');
INSERT INTO emkt_regions VALUES(1482, 98, 'IN-GJ', 'ગુજરાત', 'russian');
INSERT INTO emkt_regions VALUES(1483, 98, 'IN-HP', 'हिमाचल प्रदेश', 'russian');
INSERT INTO emkt_regions VALUES(1484, 98, 'IN-HR', 'हरियाणा', 'russian');
INSERT INTO emkt_regions VALUES(1485, 98, 'IN-JH', 'झारखंड', 'russian');
INSERT INTO emkt_regions VALUES(1486, 98, 'IN-JK', 'जम्मू और कश्मीर', 'russian');
INSERT INTO emkt_regions VALUES(1487, 98, 'IN-KA', 'ಕನಾ೯ಟಕ', 'russian');
INSERT INTO emkt_regions VALUES(1488, 98, 'IN-KL', 'കേരളം', 'russian');
INSERT INTO emkt_regions VALUES(1489, 98, 'IN-LD', 'ലക്ഷദ്വീപ്', 'russian');
INSERT INTO emkt_regions VALUES(1490, 98, 'IN-ML', 'मेघालय', 'russian');
INSERT INTO emkt_regions VALUES(1491, 98, 'IN-MH', 'महाराष्ट्र', 'russian');
INSERT INTO emkt_regions VALUES(1492, 98, 'IN-MN', 'मणिपुर', 'russian');
INSERT INTO emkt_regions VALUES(1493, 98, 'IN-MP', 'मध्य प्रदेश', 'russian');
INSERT INTO emkt_regions VALUES(1494, 98, 'IN-MZ', 'मिज़ोरम', 'russian');
INSERT INTO emkt_regions VALUES(1495, 98, 'IN-NL', 'नागालैंड', 'russian');
INSERT INTO emkt_regions VALUES(1496, 98, 'IN-OR', 'उड़ीसा', 'russian');
INSERT INTO emkt_regions VALUES(1497, 98, 'IN-PB', 'ਪੰਜਾਬ', 'russian');
INSERT INTO emkt_regions VALUES(1498, 98, 'IN-PY', 'புதுச்சேரி', 'russian');
INSERT INTO emkt_regions VALUES(1499, 98, 'IN-RJ', 'राजस्थान', 'russian');
INSERT INTO emkt_regions VALUES(1500, 98, 'IN-SK', 'सिक्किम', 'russian');
INSERT INTO emkt_regions VALUES(1501, 98, 'IN-TN', 'தமிழ் நாடு', 'russian');
INSERT INTO emkt_regions VALUES(1502, 98, 'IN-TR', 'ত্রিপুরা', 'russian');
INSERT INTO emkt_regions VALUES(1503, 98, 'IN-UL', 'उत्तरांचल', 'russian');
INSERT INTO emkt_regions VALUES(1504, 98, 'IN-UP', 'उत्तर प्रदेश', 'russian');
INSERT INTO emkt_regions VALUES(1505, 98, 'IN-WB', 'পশ্চিমবঙ্গ', 'russian');

INSERT INTO emkt_countries VALUES (99,'Индонезия','russian','ID','IDN','');

INSERT INTO emkt_regions VALUES(1506, 99, 'AC', 'Aceh', 'russian');
INSERT INTO emkt_regions VALUES(1507, 99, 'BA', 'Bali', 'russian');
INSERT INTO emkt_regions VALUES(1508, 99, 'BB', 'Bangka-Belitung', 'russian');
INSERT INTO emkt_regions VALUES(1509, 99, 'BE', 'Bengkulu', 'russian');
INSERT INTO emkt_regions VALUES(1510, 99, 'BT', 'Banten', 'russian');
INSERT INTO emkt_regions VALUES(1511, 99, 'GO', 'Gorontalo', 'russian');
INSERT INTO emkt_regions VALUES(1512, 99, 'IJ', 'Papua', 'russian');
INSERT INTO emkt_regions VALUES(1513, 99, 'JA', 'Jambi', 'russian');
INSERT INTO emkt_regions VALUES(1514, 99, 'JI', 'Jawa Timur', 'russian');
INSERT INTO emkt_regions VALUES(1515, 99, 'JK', 'Jakarta Raya', 'russian');
INSERT INTO emkt_regions VALUES(1516, 99, 'JR', 'Jawa Barat', 'russian');
INSERT INTO emkt_regions VALUES(1517, 99, 'JT', 'Jawa Tengah', 'russian');
INSERT INTO emkt_regions VALUES(1518, 99, 'KB', 'Kalimantan Barat', 'russian');
INSERT INTO emkt_regions VALUES(1519, 99, 'KI', 'Kalimantan Timur', 'russian');
INSERT INTO emkt_regions VALUES(1520, 99, 'KS', 'Kalimantan Selatan', 'russian');
INSERT INTO emkt_regions VALUES(1521, 99, 'KT', 'Kalimantan Tengah', 'russian');
INSERT INTO emkt_regions VALUES(1522, 99, 'LA', 'Lampung', 'russian');
INSERT INTO emkt_regions VALUES(1523, 99, 'MA', 'Maluku', 'russian');
INSERT INTO emkt_regions VALUES(1524, 99, 'MU', 'Maluku Utara', 'russian');
INSERT INTO emkt_regions VALUES(1525, 99, 'NB', 'Nusa Tenggara Barat', 'russian');
INSERT INTO emkt_regions VALUES(1526, 99, 'NT', 'Nusa Tenggara Timur', 'russian');
INSERT INTO emkt_regions VALUES(1527, 99, 'RI', 'Riau', 'russian');
INSERT INTO emkt_regions VALUES(1528, 99, 'SB', 'Sumatera Barat', 'russian');
INSERT INTO emkt_regions VALUES(1529, 99, 'SG', 'Sulawesi Tenggara', 'russian');
INSERT INTO emkt_regions VALUES(1530, 99, 'SL', 'Sumatera Selatan', 'russian');
INSERT INTO emkt_regions VALUES(1531, 99, 'SN', 'Sulawesi Selatan', 'russian');
INSERT INTO emkt_regions VALUES(1532, 99, 'ST', 'Sulawesi Tengah', 'russian');
INSERT INTO emkt_regions VALUES(1533, 99, 'SW', 'Sulawesi Utara', 'russian');
INSERT INTO emkt_regions VALUES(1534, 99, 'SU', 'Sumatera Utara', 'russian');
INSERT INTO emkt_regions VALUES(1535, 99, 'YO', 'Yogyakarta', 'russian');

INSERT INTO emkt_countries VALUES (100,'Иран','russian','IR','IRN','');

INSERT INTO emkt_regions VALUES(1536, 100, '01', 'محافظة آذربایجان شرقي', 'russian');
INSERT INTO emkt_regions VALUES(1537, 100, '02', 'محافظة آذربایجان غربي', 'russian');
INSERT INTO emkt_regions VALUES(1538, 100, '03', 'محافظة اردبیل', 'russian');
INSERT INTO emkt_regions VALUES(1539, 100, '04', 'محافظة اصفهان', 'russian');
INSERT INTO emkt_regions VALUES(1540, 100, '05', 'محافظة ایلام', 'russian');
INSERT INTO emkt_regions VALUES(1541, 100, '06', 'محافظة بوشهر', 'russian');
INSERT INTO emkt_regions VALUES(1542, 100, '07', 'محافظة طهران', 'russian');
INSERT INTO emkt_regions VALUES(1543, 100, '08', 'محافظة چهارمحل و بختیاري', 'russian');
INSERT INTO emkt_regions VALUES(1544, 100, '09', 'محافظة خراسان رضوي', 'russian');
INSERT INTO emkt_regions VALUES(1545, 100, '10', 'محافظة خوزستان', 'russian');
INSERT INTO emkt_regions VALUES(1546, 100, '11', 'محافظة زنجان', 'russian');
INSERT INTO emkt_regions VALUES(1547, 100, '12', 'محافظة سمنان', 'russian');
INSERT INTO emkt_regions VALUES(1548, 100, '13', 'محافظة سيستان وبلوتشستان', 'russian');
INSERT INTO emkt_regions VALUES(1549, 100, '14', 'محافظة فارس', 'russian');
INSERT INTO emkt_regions VALUES(1550, 100, '15', 'محافظة کرمان', 'russian');
INSERT INTO emkt_regions VALUES(1551, 100, '16', 'محافظة کردستان', 'russian');
INSERT INTO emkt_regions VALUES(1552, 100, '17', 'محافظة کرمانشاه', 'russian');
INSERT INTO emkt_regions VALUES(1553, 100, '18', 'محافظة کهکیلویه و بویر أحمد', 'russian');
INSERT INTO emkt_regions VALUES(1554, 100, '19', 'محافظة گیلان', 'russian');
INSERT INTO emkt_regions VALUES(1555, 100, '20', 'محافظة لرستان', 'russian');
INSERT INTO emkt_regions VALUES(1556, 100, '21', 'محافظة مازندران', 'russian');
INSERT INTO emkt_regions VALUES(1557, 100, '22', 'محافظة مرکزي', 'russian');
INSERT INTO emkt_regions VALUES(1558, 100, '23', 'محافظة هرمزگان', 'russian');
INSERT INTO emkt_regions VALUES(1559, 100, '24', 'محافظة همدان', 'russian');
INSERT INTO emkt_regions VALUES(1560, 100, '25', 'محافظة یزد', 'russian');
INSERT INTO emkt_regions VALUES(1561, 100, '26', 'محافظة قم', 'russian');
INSERT INTO emkt_regions VALUES(1562, 100, '27', 'محافظة گلستان', 'russian');
INSERT INTO emkt_regions VALUES(1563, 100, '28', 'محافظة قزوين', 'russian');

INSERT INTO emkt_countries VALUES (101,'Ирак','russian','IQ','IRQ','');

INSERT INTO emkt_regions VALUES(1564, 101, 'AN', 'محافظة الأنبار', 'russian');
INSERT INTO emkt_regions VALUES(1565, 101, 'AR', 'أربيل', 'russian');
INSERT INTO emkt_regions VALUES(1566, 101, 'BA', 'محافظة البصرة', 'russian');
INSERT INTO emkt_regions VALUES(1567, 101, 'BB', 'بابل', 'russian');
INSERT INTO emkt_regions VALUES(1568, 101, 'BG', 'محافظة بغداد', 'russian');
INSERT INTO emkt_regions VALUES(1569, 101, 'DA', 'دهوك', 'russian');
INSERT INTO emkt_regions VALUES(1570, 101, 'DI', 'ديالى', 'russian');
INSERT INTO emkt_regions VALUES(1571, 101, 'DQ', 'ذي قار', 'russian');
INSERT INTO emkt_regions VALUES(1572, 101, 'KA', 'كربلاء', 'russian');
INSERT INTO emkt_regions VALUES(1573, 101, 'MA', 'ميسان', 'russian');
INSERT INTO emkt_regions VALUES(1574, 101, 'MU', 'المثنى', 'russian');
INSERT INTO emkt_regions VALUES(1575, 101, 'NA', 'النجف', 'russian');
INSERT INTO emkt_regions VALUES(1576, 101, 'NI', 'نینوى', 'russian');
INSERT INTO emkt_regions VALUES(1577, 101, 'QA', 'القادسية', 'russian');
INSERT INTO emkt_regions VALUES(1578, 101, 'SD', 'صلاح الدين', 'russian');
INSERT INTO emkt_regions VALUES(1579, 101, 'SW', 'محافظة السليمانية', 'russian');
INSERT INTO emkt_regions VALUES(1580, 101, 'TS', 'التأمیم', 'russian');
INSERT INTO emkt_regions VALUES(1581, 101, 'WA', 'واسط', 'russian');

INSERT INTO emkt_countries VALUES (102,'Ирландия','russian','IE','IRL','');

INSERT INTO emkt_regions VALUES(1582, 102, 'C', 'Corcaigh', 'russian');
INSERT INTO emkt_regions VALUES(1583, 102, 'CE', 'Contae an Chláir', 'russian');
INSERT INTO emkt_regions VALUES(1584, 102, 'CN', 'An Cabhán', 'russian');
INSERT INTO emkt_regions VALUES(1585, 102, 'CW', 'Ceatharlach', 'russian');
INSERT INTO emkt_regions VALUES(1586, 102, 'D', 'Baile Átha Cliath', 'russian');
INSERT INTO emkt_regions VALUES(1587, 102, 'DL', 'Dún na nGall', 'russian');
INSERT INTO emkt_regions VALUES(1588, 102, 'G', 'Gaillimh', 'russian');
INSERT INTO emkt_regions VALUES(1589, 102, 'KE', 'Cill Dara', 'russian');
INSERT INTO emkt_regions VALUES(1590, 102, 'KK', 'Cill Chainnigh', 'russian');
INSERT INTO emkt_regions VALUES(1591, 102, 'KY', 'Contae Chiarraí', 'russian');
INSERT INTO emkt_regions VALUES(1592, 102, 'LD', 'An Longfort', 'russian');
INSERT INTO emkt_regions VALUES(1593, 102, 'LH', 'Contae Lú', 'russian');
INSERT INTO emkt_regions VALUES(1594, 102, 'LK', 'Luimneach', 'russian');
INSERT INTO emkt_regions VALUES(1595, 102, 'LM', 'Contae Liatroma', 'russian');
INSERT INTO emkt_regions VALUES(1596, 102, 'LS', 'Contae Laoise', 'russian');
INSERT INTO emkt_regions VALUES(1597, 102, 'MH', 'Contae na Mí', 'russian');
INSERT INTO emkt_regions VALUES(1598, 102, 'MN', 'Muineachán', 'russian');
INSERT INTO emkt_regions VALUES(1599, 102, 'MO', 'Contae Mhaigh Eo', 'russian');
INSERT INTO emkt_regions VALUES(1600, 102, 'OY', 'Contae Uíbh Fhailí', 'russian');
INSERT INTO emkt_regions VALUES(1601, 102, 'RN', 'Ros Comáin', 'russian');
INSERT INTO emkt_regions VALUES(1602, 102, 'SO', 'Sligeach', 'russian');
INSERT INTO emkt_regions VALUES(1603, 102, 'TA', 'Tiobraid Árann', 'russian');
INSERT INTO emkt_regions VALUES(1604, 102, 'WD', 'Port Lairge', 'russian');
INSERT INTO emkt_regions VALUES(1605, 102, 'WH', 'Contae na hIarmhí', 'russian');
INSERT INTO emkt_regions VALUES(1606, 102, 'WW', 'Cill Mhantáin', 'russian');
INSERT INTO emkt_regions VALUES(1607, 102, 'WX', 'Loch Garman', 'russian');

INSERT INTO emkt_countries VALUES (103,'Израиль','russian','IL','ISR','');

INSERT INTO emkt_regions VALUES(1608, 103, 'D ', 'מחוז הדרום', 'russian');
INSERT INTO emkt_regions VALUES(1609, 103, 'HA', 'מחוז חיפה', 'russian');
INSERT INTO emkt_regions VALUES(1610, 103, 'JM', 'ירושלים', 'russian');
INSERT INTO emkt_regions VALUES(1611, 103, 'M ', 'מחוז המרכז', 'russian');
INSERT INTO emkt_regions VALUES(1612, 103, 'TA', 'תל אביב-יפו', 'russian');
INSERT INTO emkt_regions VALUES(1613, 103, 'Z ', 'מחוז הצפון', 'russian');

INSERT INTO emkt_countries VALUES (104,'Италия','russian','IT','ITA','');

INSERT INTO emkt_regions VALUES(1614, 104, 'AG', 'Agrigento', 'russian');
INSERT INTO emkt_regions VALUES(1615, 104, 'AL', 'Alessandria', 'russian');
INSERT INTO emkt_regions VALUES(1616, 104, 'AN', 'Ancona', 'russian');
INSERT INTO emkt_regions VALUES(1617, 104, 'AO', 'Valle d\'Aosta', 'russian');
INSERT INTO emkt_regions VALUES(1618, 104, 'AP', 'Ascoli Piceno', 'russian');
INSERT INTO emkt_regions VALUES(1619, 104, 'AQ', 'L\'Aquila', 'russian');
INSERT INTO emkt_regions VALUES(1620, 104, 'AR', 'Arezzo', 'russian');
INSERT INTO emkt_regions VALUES(1621, 104, 'AT', 'Asti', 'russian');
INSERT INTO emkt_regions VALUES(1622, 104, 'AV', 'Avellino', 'russian');
INSERT INTO emkt_regions VALUES(1623, 104, 'BA', 'Bari', 'russian');
INSERT INTO emkt_regions VALUES(1624, 104, 'BG', 'Bergamo', 'russian');
INSERT INTO emkt_regions VALUES(1625, 104, 'BI', 'Biella', 'russian');
INSERT INTO emkt_regions VALUES(1626, 104, 'BL', 'Belluno', 'russian');
INSERT INTO emkt_regions VALUES(1627, 104, 'BN', 'Benevento', 'russian');
INSERT INTO emkt_regions VALUES(1628, 104, 'BO', 'Bologna', 'russian');
INSERT INTO emkt_regions VALUES(1629, 104, 'BR', 'Brindisi', 'russian');
INSERT INTO emkt_regions VALUES(1630, 104, 'BS', 'Brescia', 'russian');
INSERT INTO emkt_regions VALUES(1631, 104, 'BT', 'Barletta-Andria-Trani', 'russian');
INSERT INTO emkt_regions VALUES(1632, 104, 'BZ', 'Alto Adige', 'russian');
INSERT INTO emkt_regions VALUES(1633, 104, 'CA', 'Cagliari', 'russian');
INSERT INTO emkt_regions VALUES(1634, 104, 'CB', 'Campobasso', 'russian');
INSERT INTO emkt_regions VALUES(1635, 104, 'CE', 'Caserta', 'russian');
INSERT INTO emkt_regions VALUES(1636, 104, 'CH', 'Chieti', 'russian');
INSERT INTO emkt_regions VALUES(1637, 104, 'CI', 'Carbonia-Iglesias', 'russian');
INSERT INTO emkt_regions VALUES(1638, 104, 'CL', 'Caltanissetta', 'russian');
INSERT INTO emkt_regions VALUES(1639, 104, 'CN', 'Cuneo', 'russian');
INSERT INTO emkt_regions VALUES(1640, 104, 'CO', 'Como', 'russian');
INSERT INTO emkt_regions VALUES(1641, 104, 'CR', 'Cremona', 'russian');
INSERT INTO emkt_regions VALUES(1642, 104, 'CS', 'Cosenza', 'russian');
INSERT INTO emkt_regions VALUES(1643, 104, 'CT', 'Catania', 'russian');
INSERT INTO emkt_regions VALUES(1644, 104, 'CZ', 'Catanzaro', 'russian');
INSERT INTO emkt_regions VALUES(1645, 104, 'EN', 'Enna', 'russian');
INSERT INTO emkt_regions VALUES(1646, 104, 'FE', 'Ferrara', 'russian');
INSERT INTO emkt_regions VALUES(1647, 104, 'FG', 'Foggia', 'russian');
INSERT INTO emkt_regions VALUES(1648, 104, 'FI', 'Firenze', 'russian');
INSERT INTO emkt_regions VALUES(1649, 104, 'FM', 'Fermo', 'russian');
INSERT INTO emkt_regions VALUES(1650, 104, 'FO', 'Forlì-Cesena', 'russian');
INSERT INTO emkt_regions VALUES(1651, 104, 'FR', 'Frosinone', 'russian');
INSERT INTO emkt_regions VALUES(1652, 104, 'GE', 'Genova', 'russian');
INSERT INTO emkt_regions VALUES(1653, 104, 'GO', 'Gorizia', 'russian');
INSERT INTO emkt_regions VALUES(1654, 104, 'GR', 'Grosseto', 'russian');
INSERT INTO emkt_regions VALUES(1655, 104, 'IM', 'Imperia', 'russian');
INSERT INTO emkt_regions VALUES(1656, 104, 'IS', 'Isernia', 'russian');
INSERT INTO emkt_regions VALUES(1657, 104, 'KR', 'Crotone', 'russian');
INSERT INTO emkt_regions VALUES(1658, 104, 'LC', 'Lecco', 'russian');
INSERT INTO emkt_regions VALUES(1659, 104, 'LE', 'Lecce', 'russian');
INSERT INTO emkt_regions VALUES(1660, 104, 'LI', 'Livorno', 'russian');
INSERT INTO emkt_regions VALUES(1661, 104, 'LO', 'Lodi', 'russian');
INSERT INTO emkt_regions VALUES(1662, 104, 'LT', 'Latina', 'russian');
INSERT INTO emkt_regions VALUES(1663, 104, 'LU', 'Lucca', 'russian');
INSERT INTO emkt_regions VALUES(1664, 104, 'MC', 'Macerata', 'russian');
INSERT INTO emkt_regions VALUES(1665, 104, 'MD', 'Medio Campidano', 'russian');
INSERT INTO emkt_regions VALUES(1666, 104, 'ME', 'Messina', 'russian');
INSERT INTO emkt_regions VALUES(1667, 104, 'MI', 'Milano', 'russian');
INSERT INTO emkt_regions VALUES(1668, 104, 'MN', 'Mantova', 'russian');
INSERT INTO emkt_regions VALUES(1669, 104, 'MO', 'Modena', 'russian');
INSERT INTO emkt_regions VALUES(1670, 104, 'MS', 'Massa-Carrara', 'russian');
INSERT INTO emkt_regions VALUES(1671, 104, 'MT', 'Matera', 'russian');
INSERT INTO emkt_regions VALUES(1672, 104, 'MZ', 'Monza e Brianza', 'russian');
INSERT INTO emkt_regions VALUES(1673, 104, 'NA', 'Napoli', 'russian');
INSERT INTO emkt_regions VALUES(1674, 104, 'NO', 'Novara', 'russian');
INSERT INTO emkt_regions VALUES(1675, 104, 'NU', 'Nuoro', 'russian');
INSERT INTO emkt_regions VALUES(1676, 104, 'OG', 'Ogliastra', 'russian');
INSERT INTO emkt_regions VALUES(1677, 104, 'OR', 'Oristano', 'russian');
INSERT INTO emkt_regions VALUES(1678, 104, 'OT', 'Olbia-Tempio', 'russian');
INSERT INTO emkt_regions VALUES(1679, 104, 'PA', 'Palermo', 'russian');
INSERT INTO emkt_regions VALUES(1680, 104, 'PC', 'Piacenza', 'russian');
INSERT INTO emkt_regions VALUES(1681, 104, 'PD', 'Padova', 'russian');
INSERT INTO emkt_regions VALUES(1682, 104, 'PE', 'Pescara', 'russian');
INSERT INTO emkt_regions VALUES(1683, 104, 'PG', 'Perugia', 'russian');
INSERT INTO emkt_regions VALUES(1684, 104, 'PI', 'Pisa', 'russian');
INSERT INTO emkt_regions VALUES(1685, 104, 'PN', 'Pordenone', 'russian');
INSERT INTO emkt_regions VALUES(1686, 104, 'PO', 'Prato', 'russian');
INSERT INTO emkt_regions VALUES(1687, 104, 'PR', 'Parma', 'russian');
INSERT INTO emkt_regions VALUES(1688, 104, 'PS', 'Pesaro e Urbino', 'russian');
INSERT INTO emkt_regions VALUES(1689, 104, 'PT', 'Pistoia', 'russian');
INSERT INTO emkt_regions VALUES(1690, 104, 'PV', 'Pavia', 'russian');
INSERT INTO emkt_regions VALUES(1691, 104, 'PZ', 'Potenza', 'russian');
INSERT INTO emkt_regions VALUES(1692, 104, 'RA', 'Ravenna', 'russian');
INSERT INTO emkt_regions VALUES(1693, 104, 'RC', 'Reggio Calabria', 'russian');
INSERT INTO emkt_regions VALUES(1694, 104, 'RE', 'Reggio Emilia', 'russian');
INSERT INTO emkt_regions VALUES(1695, 104, 'RG', 'Ragusa', 'russian');
INSERT INTO emkt_regions VALUES(1696, 104, 'RI', 'Rieti', 'russian');
INSERT INTO emkt_regions VALUES(1697, 104, 'RM', 'Roma', 'russian');
INSERT INTO emkt_regions VALUES(1698, 104, 'RN', 'Rimini', 'russian');
INSERT INTO emkt_regions VALUES(1699, 104, 'RO', 'Rovigo', 'russian');
INSERT INTO emkt_regions VALUES(1700, 104, 'SA', 'Salerno', 'russian');
INSERT INTO emkt_regions VALUES(1701, 104, 'SI', 'Siena', 'russian');
INSERT INTO emkt_regions VALUES(1702, 104, 'SO', 'Sondrio', 'russian');
INSERT INTO emkt_regions VALUES(1703, 104, 'SP', 'La Spezia', 'russian');
INSERT INTO emkt_regions VALUES(1704, 104, 'SR', 'Siracusa', 'russian');
INSERT INTO emkt_regions VALUES(1705, 104, 'SS', 'Sassari', 'russian');
INSERT INTO emkt_regions VALUES(1706, 104, 'SV', 'Savona', 'russian');
INSERT INTO emkt_regions VALUES(1707, 104, 'TA', 'Taranto', 'russian');
INSERT INTO emkt_regions VALUES(1708, 104, 'TE', 'Teramo', 'russian');
INSERT INTO emkt_regions VALUES(1709, 104, 'TN', 'Trento', 'russian');
INSERT INTO emkt_regions VALUES(1710, 104, 'TO', 'Torino', 'russian');
INSERT INTO emkt_regions VALUES(1711, 104, 'TP', 'Trapani', 'russian');
INSERT INTO emkt_regions VALUES(1712, 104, 'TR', 'Terni', 'russian');
INSERT INTO emkt_regions VALUES(1713, 104, 'TS', 'Trieste', 'russian');
INSERT INTO emkt_regions VALUES(1714, 104, 'TV', 'Treviso', 'russian');
INSERT INTO emkt_regions VALUES(1715, 104, 'UD', 'Udine', 'russian');
INSERT INTO emkt_regions VALUES(1716, 104, 'VA', 'Varese', 'russian');
INSERT INTO emkt_regions VALUES(1717, 104, 'VB', 'Verbano-Cusio-Ossola', 'russian');
INSERT INTO emkt_regions VALUES(1718, 104, 'VC', 'Vercelli', 'russian');
INSERT INTO emkt_regions VALUES(1719, 104, 'VE', 'Venezia', 'russian');
INSERT INTO emkt_regions VALUES(1720, 104, 'VI', 'Vicenza', 'russian');
INSERT INTO emkt_regions VALUES(1721, 104, 'VR', 'Verona', 'russian');
INSERT INTO emkt_regions VALUES(1722, 104, 'VT', 'Viterbo', 'russian');
INSERT INTO emkt_regions VALUES(1723, 104, 'VV', 'Vibo Valentia', 'russian');

INSERT INTO emkt_countries VALUES (105,'Ямайка','russian','JM','JAM','');

INSERT INTO emkt_regions VALUES(1724, 105, '01', 'Kingston', 'russian');
INSERT INTO emkt_regions VALUES(1725, 105, '02', 'Half Way Tree', 'russian');
INSERT INTO emkt_regions VALUES(1726, 105, '03', 'Morant Bay', 'russian');
INSERT INTO emkt_regions VALUES(1727, 105, '04', 'Port Antonio', 'russian');
INSERT INTO emkt_regions VALUES(1728, 105, '05', 'Port Maria', 'russian');
INSERT INTO emkt_regions VALUES(1729, 105, '06', 'Saint Ann\'s Bay', 'russian');
INSERT INTO emkt_regions VALUES(1730, 105, '07', 'Falmouth', 'russian');
INSERT INTO emkt_regions VALUES(1731, 105, '08', 'Montego Bay', 'russian');
INSERT INTO emkt_regions VALUES(1732, 105, '09', 'Lucea', 'russian');
INSERT INTO emkt_regions VALUES(1733, 105, '10', 'Savanna-la-Mar', 'russian');
INSERT INTO emkt_regions VALUES(1734, 105, '11', 'Black River', 'russian');
INSERT INTO emkt_regions VALUES(1735, 105, '12', 'Mandeville', 'russian');
INSERT INTO emkt_regions VALUES(1736, 105, '13', 'May Pen', 'russian');
INSERT INTO emkt_regions VALUES(1737, 105, '14', 'Spanish Town', 'russian');

INSERT INTO emkt_countries VALUES (106,'Япония','russian','JP','JPN','');

INSERT INTO emkt_regions VALUES(1738, 106, '01', '北海道', 'russian');
INSERT INTO emkt_regions VALUES(1739, 106, '02', '青森', 'russian');
INSERT INTO emkt_regions VALUES(1740, 106, '03', '岩手', 'russian');
INSERT INTO emkt_regions VALUES(1741, 106, '04', '宮城', 'russian');
INSERT INTO emkt_regions VALUES(1742, 106, '05', '秋田', 'russian');
INSERT INTO emkt_regions VALUES(1743, 106, '06', '山形', 'russian');
INSERT INTO emkt_regions VALUES(1744, 106, '07', '福島', 'russian');
INSERT INTO emkt_regions VALUES(1745, 106, '08', '茨城', 'russian');
INSERT INTO emkt_regions VALUES(1746, 106, '09', '栃木', 'russian');
INSERT INTO emkt_regions VALUES(1747, 106, '10', '群馬', 'russian');
INSERT INTO emkt_regions VALUES(1748, 106, '11', '埼玉', 'russian');
INSERT INTO emkt_regions VALUES(1749, 106, '12', '千葉', 'russian');
INSERT INTO emkt_regions VALUES(1750, 106, '13', '東京', 'russian');
INSERT INTO emkt_regions VALUES(1751, 106, '14', '神奈川', 'russian');
INSERT INTO emkt_regions VALUES(1752, 106, '15', '新潟', 'russian');
INSERT INTO emkt_regions VALUES(1753, 106, '16', '富山', 'russian');
INSERT INTO emkt_regions VALUES(1754, 106, '17', '石川', 'russian');
INSERT INTO emkt_regions VALUES(1755, 106, '18', '福井', 'russian');
INSERT INTO emkt_regions VALUES(1756, 106, '19', '山梨', 'russian');
INSERT INTO emkt_regions VALUES(1757, 106, '20', '長野', 'russian');
INSERT INTO emkt_regions VALUES(1758, 106, '21', '岐阜', 'russian');
INSERT INTO emkt_regions VALUES(1759, 106, '22', '静岡', 'russian');
INSERT INTO emkt_regions VALUES(1760, 106, '23', '愛知', 'russian');
INSERT INTO emkt_regions VALUES(1761, 106, '24', '三重', 'russian');
INSERT INTO emkt_regions VALUES(1762, 106, '25', '滋賀', 'russian');
INSERT INTO emkt_regions VALUES(1763, 106, '26', '京都', 'russian');
INSERT INTO emkt_regions VALUES(1764, 106, '27', '大阪', 'russian');
INSERT INTO emkt_regions VALUES(1765, 106, '28', '兵庫', 'russian');
INSERT INTO emkt_regions VALUES(1766, 106, '29', '奈良', 'russian');
INSERT INTO emkt_regions VALUES(1767, 106, '30', '和歌山', 'russian');
INSERT INTO emkt_regions VALUES(1768, 106, '31', '鳥取', 'russian');
INSERT INTO emkt_regions VALUES(1769, 106, '32', '島根', 'russian');
INSERT INTO emkt_regions VALUES(1770, 106, '33', '岡山', 'russian');
INSERT INTO emkt_regions VALUES(1771, 106, '34', '広島', 'russian');
INSERT INTO emkt_regions VALUES(1772, 106, '35', '山口', 'russian');
INSERT INTO emkt_regions VALUES(1773, 106, '36', '徳島', 'russian');
INSERT INTO emkt_regions VALUES(1774, 106, '37', '香川', 'russian');
INSERT INTO emkt_regions VALUES(1775, 106, '38', '愛媛', 'russian');
INSERT INTO emkt_regions VALUES(1776, 106, '39', '高知', 'russian');
INSERT INTO emkt_regions VALUES(1777, 106, '40', '福岡', 'russian');
INSERT INTO emkt_regions VALUES(1778, 106, '41', '佐賀', 'russian');
INSERT INTO emkt_regions VALUES(1779, 106, '42', '長崎', 'russian');
INSERT INTO emkt_regions VALUES(1780, 106, '43', '熊本', 'russian');
INSERT INTO emkt_regions VALUES(1781, 106, '44', '大分', 'russian');
INSERT INTO emkt_regions VALUES(1782, 106, '45', '宮崎', 'russian');
INSERT INTO emkt_regions VALUES(1783, 106, '46', '鹿児島', 'russian');
INSERT INTO emkt_regions VALUES(1784, 106, '47', '沖縄', 'russian');

INSERT INTO emkt_countries VALUES (107,'Иордания','russian','JO','JOR','');

INSERT INTO emkt_regions VALUES(1785, 107, 'AJ', 'محافظة عجلون', 'russian');
INSERT INTO emkt_regions VALUES(1786, 107, 'AM', 'محافظة العاصمة', 'russian');
INSERT INTO emkt_regions VALUES(1787, 107, 'AQ', 'محافظة العقبة', 'russian');
INSERT INTO emkt_regions VALUES(1788, 107, 'AT', 'محافظة الطفيلة', 'russian');
INSERT INTO emkt_regions VALUES(1789, 107, 'AZ', 'محافظة الزرقاء', 'russian');
INSERT INTO emkt_regions VALUES(1790, 107, 'BA', 'محافظة البلقاء', 'russian');
INSERT INTO emkt_regions VALUES(1791, 107, 'JA', 'محافظة جرش', 'russian');
INSERT INTO emkt_regions VALUES(1792, 107, 'JR', 'محافظة إربد', 'russian');
INSERT INTO emkt_regions VALUES(1793, 107, 'KA', 'محافظة الكرك', 'russian');
INSERT INTO emkt_regions VALUES(1794, 107, 'MA', 'محافظة المفرق', 'russian');
INSERT INTO emkt_regions VALUES(1795, 107, 'MD', 'محافظة مادبا', 'russian');
INSERT INTO emkt_regions VALUES(1796, 107, 'MN', 'محافظة معان', 'russian');

INSERT INTO emkt_countries VALUES (108,'Казахстан','russian','KZ','KAZ','');

INSERT INTO emkt_regions VALUES(1797, 108, 'AL', 'Алматы', 'russian');
INSERT INTO emkt_regions VALUES(1798, 108, 'AC', 'Almaty City', 'russian');
INSERT INTO emkt_regions VALUES(1799, 108, 'AM', 'Ақмола', 'russian');
INSERT INTO emkt_regions VALUES(1800, 108, 'AQ', 'Ақтөбе', 'russian');
INSERT INTO emkt_regions VALUES(1801, 108, 'AS', 'Астана', 'russian');
INSERT INTO emkt_regions VALUES(1802, 108, 'AT', 'Атырау', 'russian');
INSERT INTO emkt_regions VALUES(1803, 108, 'BA', 'Батыс Қазақстан', 'russian');
INSERT INTO emkt_regions VALUES(1804, 108, 'BY', 'Байқоңыр', 'russian');
INSERT INTO emkt_regions VALUES(1805, 108, 'MA', 'Маңғыстау', 'russian');
INSERT INTO emkt_regions VALUES(1806, 108, 'ON', 'Оңтүстік Қазақстан', 'russian');
INSERT INTO emkt_regions VALUES(1807, 108, 'PA', 'Павлодар', 'russian');
INSERT INTO emkt_regions VALUES(1808, 108, 'QA', 'Қарағанды', 'russian');
INSERT INTO emkt_regions VALUES(1809, 108, 'QO', 'Қостанай', 'russian');
INSERT INTO emkt_regions VALUES(1810, 108, 'QY', 'Қызылорда', 'russian');
INSERT INTO emkt_regions VALUES(1811, 108, 'SH', 'Шығыс Қазақстан', 'russian');
INSERT INTO emkt_regions VALUES(1812, 108, 'SO', 'Солтүстік Қазақстан', 'russian');
INSERT INTO emkt_regions VALUES(1813, 108, 'ZH', 'Жамбыл', 'russian');

INSERT INTO emkt_countries VALUES (109,'Кения','russian','KE','KEN','');

INSERT INTO emkt_regions VALUES(1814, 109, '110', 'Nairobi', 'russian');
INSERT INTO emkt_regions VALUES(1815, 109, '200', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(1816, 109, '300', 'Mombasa', 'russian');
INSERT INTO emkt_regions VALUES(1817, 109, '400', 'Eastern', 'russian');
INSERT INTO emkt_regions VALUES(1818, 109, '500', 'North Eastern', 'russian');
INSERT INTO emkt_regions VALUES(1819, 109, '600', 'Nyanza', 'russian');
INSERT INTO emkt_regions VALUES(1820, 109, '700', 'Rift Valley', 'russian');
INSERT INTO emkt_regions VALUES(1821, 109, '900', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (110,'Кирибати','russian','KI','KIR','');

INSERT INTO emkt_regions VALUES(1822, 110, 'G', 'Gilbert Islands', 'russian');
INSERT INTO emkt_regions VALUES(1823, 110, 'L', 'Line Islands', 'russian');
INSERT INTO emkt_regions VALUES(1824, 110, 'P', 'Phoenix Islands', 'russian');

INSERT INTO emkt_countries VALUES (111,'Корейская Народно-Демократическая Республика','russian','KP','PRK','');

INSERT INTO emkt_regions VALUES(1825, 111, 'CHA', '자강도', 'russian');
INSERT INTO emkt_regions VALUES(1826, 111, 'HAB', '함경 북도', 'russian');
INSERT INTO emkt_regions VALUES(1827, 111, 'HAN', '함경 남도', 'russian');
INSERT INTO emkt_regions VALUES(1828, 111, 'HWB', '황해 북도', 'russian');
INSERT INTO emkt_regions VALUES(1829, 111, 'HWN', '황해 남도', 'russian');
INSERT INTO emkt_regions VALUES(1830, 111, 'KAN', '강원도', 'russian');
INSERT INTO emkt_regions VALUES(1831, 111, 'KAE', '개성시', 'russian');
INSERT INTO emkt_regions VALUES(1832, 111, 'NAJ', '라선 직할시', 'russian');
INSERT INTO emkt_regions VALUES(1833, 111, 'NAM', '남포 특급시', 'russian');
INSERT INTO emkt_regions VALUES(1834, 111, 'PYB', '평안 북도', 'russian');
INSERT INTO emkt_regions VALUES(1835, 111, 'PYN', '평안 남도', 'russian');
INSERT INTO emkt_regions VALUES(1836, 111, 'PYO', '평양 직할시', 'russian');
INSERT INTO emkt_regions VALUES(1837, 111, 'YAN', '량강도', 'russian');

INSERT INTO emkt_countries VALUES (112,'Республика Корея','russian','KR','KOR','');

INSERT INTO emkt_regions VALUES(1838, 112, '11', '서울특별시', 'russian');
INSERT INTO emkt_regions VALUES(1839, 112, '26', '부산 광역시', 'russian');
INSERT INTO emkt_regions VALUES(1840, 112, '27', '대구 광역시', 'russian');
INSERT INTO emkt_regions VALUES(1841, 112, '28', '인천광역시', 'russian');
INSERT INTO emkt_regions VALUES(1842, 112, '29', '광주 광역시', 'russian');
INSERT INTO emkt_regions VALUES(1843, 112, '30', '대전 광역시', 'russian');
INSERT INTO emkt_regions VALUES(1844, 112, '31', '울산 광역시', 'russian');
INSERT INTO emkt_regions VALUES(1845, 112, '41', '경기도', 'russian');
INSERT INTO emkt_regions VALUES(1846, 112, '42', '강원도', 'russian');
INSERT INTO emkt_regions VALUES(1847, 112, '43', '충청 북도', 'russian');
INSERT INTO emkt_regions VALUES(1848, 112, '44', '충청 남도', 'russian');
INSERT INTO emkt_regions VALUES(1849, 112, '45', '전라 북도', 'russian');
INSERT INTO emkt_regions VALUES(1850, 112, '46', '전라 남도', 'russian');
INSERT INTO emkt_regions VALUES(1851, 112, '47', '경상 북도', 'russian');
INSERT INTO emkt_regions VALUES(1852, 112, '48', '경상 남도', 'russian');
INSERT INTO emkt_regions VALUES(1853, 112, '49', '제주특별자치도', 'russian');

INSERT INTO emkt_countries VALUES (113,'Кувейт','russian','KW','KWT','');

INSERT INTO emkt_regions VALUES(1854, 113, 'AH', 'الاحمدي', 'russian');
INSERT INTO emkt_regions VALUES(1855, 113, 'FA', 'الفروانية', 'russian');
INSERT INTO emkt_regions VALUES(1856, 113, 'JA', 'الجهراء', 'russian');
INSERT INTO emkt_regions VALUES(1857, 113, 'KU', 'ألعاصمه', 'russian');
INSERT INTO emkt_regions VALUES(1858, 113, 'HW', 'حولي', 'russian');
INSERT INTO emkt_regions VALUES(1859, 113, 'MU', 'مبارك الكبير', 'russian');

INSERT INTO emkt_countries VALUES (114,'Киргистан','russian','KG','KGZ','');

INSERT INTO emkt_regions VALUES(1860, 114, 'B', 'Баткен областы', 'russian');
INSERT INTO emkt_regions VALUES(1861, 114, 'C', 'Чүй областы', 'russian');
INSERT INTO emkt_regions VALUES(1862, 114, 'GB', 'Бишкек', 'russian');
INSERT INTO emkt_regions VALUES(1863, 114, 'J', 'Жалал-Абад областы', 'russian');
INSERT INTO emkt_regions VALUES(1864, 114, 'N', 'Нарын областы', 'russian');
INSERT INTO emkt_regions VALUES(1865, 114, 'O', 'Ош областы', 'russian');
INSERT INTO emkt_regions VALUES(1866, 114, 'T', 'Талас областы', 'russian');
INSERT INTO emkt_regions VALUES(1867, 114, 'Y', 'Ысык-Көл областы', 'russian');

INSERT INTO emkt_countries VALUES (115,'Лаос','russian','LA','LAO','');

INSERT INTO emkt_regions VALUES(1868, 115, 'AT', 'ອັດຕະປື', 'russian');
INSERT INTO emkt_regions VALUES(1869, 115, 'BK', 'ບໍ່ແກ້ວ', 'russian');
INSERT INTO emkt_regions VALUES(1870, 115, 'BL', 'ບໍລິຄໍາໄຊ', 'russian');
INSERT INTO emkt_regions VALUES(1871, 115, 'CH', 'ຈໍາປາສັກ', 'russian');
INSERT INTO emkt_regions VALUES(1872, 115, 'HO', 'ຫົວພັນ', 'russian');
INSERT INTO emkt_regions VALUES(1873, 115, 'KH', 'ຄໍາມ່ວນ', 'russian');
INSERT INTO emkt_regions VALUES(1874, 115, 'LM', 'ຫລວງນໍ້າທາ', 'russian');
INSERT INTO emkt_regions VALUES(1875, 115, 'LP', 'ຫລວງພະບາງ', 'russian');
INSERT INTO emkt_regions VALUES(1876, 115, 'OU', 'ອຸດົມໄຊ', 'russian');
INSERT INTO emkt_regions VALUES(1877, 115, 'PH', 'ຜົງສາລີ', 'russian');
INSERT INTO emkt_regions VALUES(1878, 115, 'SL', 'ສາລະວັນ', 'russian');
INSERT INTO emkt_regions VALUES(1879, 115, 'SV', 'ສະຫວັນນະເຂດ', 'russian');
INSERT INTO emkt_regions VALUES(1880, 115, 'VI', 'ວຽງຈັນ', 'russian');
INSERT INTO emkt_regions VALUES(1881, 115, 'VT', 'ວຽງຈັນ', 'russian');
INSERT INTO emkt_regions VALUES(1882, 115, 'XA', 'ໄຊຍະບູລີ', 'russian');
INSERT INTO emkt_regions VALUES(1883, 115, 'XE', 'ເຊກອງ', 'russian');
INSERT INTO emkt_regions VALUES(1884, 115, 'XI', 'ຊຽງຂວາງ', 'russian');
INSERT INTO emkt_regions VALUES(1885, 115, 'XN', 'ໄຊສົມບູນ', 'russian');

INSERT INTO emkt_countries VALUES (116,'Латвия','russian','LV','LVA','');

INSERT INTO emkt_regions VALUES(1886, 116, 'AI', 'Aizkraukles rajons', 'russian');
INSERT INTO emkt_regions VALUES(1887, 116, 'AL', 'Alūksnes rajons', 'russian');
INSERT INTO emkt_regions VALUES(1888, 116, 'BL', 'Balvu rajons', 'russian');
INSERT INTO emkt_regions VALUES(1889, 116, 'BU', 'Bauskas rajons', 'russian');
INSERT INTO emkt_regions VALUES(1890, 116, 'CE', 'Cēsu rajons', 'russian');
INSERT INTO emkt_regions VALUES(1891, 116, 'DA', 'Daugavpils rajons', 'russian');
INSERT INTO emkt_regions VALUES(1892, 116, 'DGV', 'Daugpilis', 'russian');
INSERT INTO emkt_regions VALUES(1893, 116, 'DO', 'Dobeles rajons', 'russian');
INSERT INTO emkt_regions VALUES(1894, 116, 'GU', 'Gulbenes rajons', 'russian');
INSERT INTO emkt_regions VALUES(1895, 116, 'JEL', 'Jelgava', 'russian');
INSERT INTO emkt_regions VALUES(1896, 116, 'JK', 'Jēkabpils rajons', 'russian');
INSERT INTO emkt_regions VALUES(1897, 116, 'JL', 'Jelgavas rajons', 'russian');
INSERT INTO emkt_regions VALUES(1898, 116, 'JUR', 'Jūrmala', 'russian');
INSERT INTO emkt_regions VALUES(1899, 116, 'KR', 'Krāslavas rajons', 'russian');
INSERT INTO emkt_regions VALUES(1900, 116, 'KU', 'Kuldīgas rajons', 'russian');
INSERT INTO emkt_regions VALUES(1901, 116, 'LE', 'Liepājas rajons', 'russian');
INSERT INTO emkt_regions VALUES(1902, 116, 'LM', 'Limbažu rajons', 'russian');
INSERT INTO emkt_regions VALUES(1903, 116, 'LPX', 'Liepoja', 'russian');
INSERT INTO emkt_regions VALUES(1904, 116, 'LU', 'Ludzas rajons', 'russian');
INSERT INTO emkt_regions VALUES(1905, 116, 'MA', 'Madonas rajons', 'russian');
INSERT INTO emkt_regions VALUES(1906, 116, 'OG', 'Ogres rajons', 'russian');
INSERT INTO emkt_regions VALUES(1907, 116, 'PR', 'Preiļu rajons', 'russian');
INSERT INTO emkt_regions VALUES(1908, 116, 'RE', 'Rēzeknes rajons', 'russian');
INSERT INTO emkt_regions VALUES(1909, 116, 'REZ', 'Rēzekne', 'russian');
INSERT INTO emkt_regions VALUES(1910, 116, 'RI', 'Rīgas rajons', 'russian');
INSERT INTO emkt_regions VALUES(1911, 116, 'RIX', 'Rīga', 'russian');
INSERT INTO emkt_regions VALUES(1912, 116, 'SA', 'Saldus rajons', 'russian');
INSERT INTO emkt_regions VALUES(1913, 116, 'TA', 'Talsu rajons', 'russian');
INSERT INTO emkt_regions VALUES(1914, 116, 'TU', 'Tukuma rajons', 'russian');
INSERT INTO emkt_regions VALUES(1915, 116, 'VE', 'Ventspils rajons', 'russian');
INSERT INTO emkt_regions VALUES(1916, 116, 'VEN', 'Ventspils', 'russian');
INSERT INTO emkt_regions VALUES(1917, 116, 'VK', 'Valkas rajons', 'russian');
INSERT INTO emkt_regions VALUES(1918, 116, 'VM', 'Valmieras rajons', 'russian');

INSERT INTO emkt_countries VALUES (117,'Ливан','russian','LB','LBN','');

INSERT INTO emkt_regions VALUES(4263, 117, 'NOCODE', 'Lebanon', 'russian');

INSERT INTO emkt_countries VALUES (118,'Лесото','russian','LS','LSO','');

INSERT INTO emkt_regions VALUES(1919, 118, 'A', 'Maseru', 'russian');
INSERT INTO emkt_regions VALUES(1920, 118, 'B', 'Butha-Buthe', 'russian');
INSERT INTO emkt_regions VALUES(1921, 118, 'C', 'Leribe', 'russian');
INSERT INTO emkt_regions VALUES(1922, 118, 'D', 'Berea', 'russian');
INSERT INTO emkt_regions VALUES(1923, 118, 'E', 'Mafeteng', 'russian');
INSERT INTO emkt_regions VALUES(1924, 118, 'F', 'Mohale\'s Hoek', 'russian');
INSERT INTO emkt_regions VALUES(1925, 118, 'G', 'Quthing', 'russian');
INSERT INTO emkt_regions VALUES(1926, 118, 'H', 'Qacha\'s Nek', 'russian');
INSERT INTO emkt_regions VALUES(1927, 118, 'J', 'Mokhotlong', 'russian');
INSERT INTO emkt_regions VALUES(1928, 118, 'K', 'Thaba-Tseka', 'russian');

INSERT INTO emkt_countries VALUES (119,'Либерия','russian','LR','LBR','');

INSERT INTO emkt_regions VALUES(1929, 119, 'BG', 'Bong', 'russian');
INSERT INTO emkt_regions VALUES(1930, 119, 'BM', 'Bomi', 'russian');
INSERT INTO emkt_regions VALUES(1931, 119, 'CM', 'Grand Cape Mount', 'russian');
INSERT INTO emkt_regions VALUES(1932, 119, 'GB', 'Grand Bassa', 'russian');
INSERT INTO emkt_regions VALUES(1933, 119, 'GG', 'Grand Gedeh', 'russian');
INSERT INTO emkt_regions VALUES(1934, 119, 'GK', 'Grand Kru', 'russian');
INSERT INTO emkt_regions VALUES(1935, 119, 'GP', 'Gbarpolu', 'russian');
INSERT INTO emkt_regions VALUES(1936, 119, 'LO', 'Lofa', 'russian');
INSERT INTO emkt_regions VALUES(1937, 119, 'MG', 'Margibi', 'russian');
INSERT INTO emkt_regions VALUES(1938, 119, 'MO', 'Montserrado', 'russian');
INSERT INTO emkt_regions VALUES(1939, 119, 'MY', 'Maryland', 'russian');
INSERT INTO emkt_regions VALUES(1940, 119, 'NI', 'Nimba', 'russian');
INSERT INTO emkt_regions VALUES(1941, 119, 'RG', 'River Gee', 'russian');
INSERT INTO emkt_regions VALUES(1942, 119, 'RI', 'Rivercess', 'russian');
INSERT INTO emkt_regions VALUES(1943, 119, 'SI', 'Sinoe', 'russian');

INSERT INTO emkt_countries VALUES (120,'Ливия','russian','LY','LBY','');

INSERT INTO emkt_regions VALUES(1944, 120, 'AJ', 'Ajdābiyā', 'russian');
INSERT INTO emkt_regions VALUES(1945, 120, 'BA', 'Banghāzī', 'russian');
INSERT INTO emkt_regions VALUES(1946, 120, 'BU', 'Al Buţnān', 'russian');
INSERT INTO emkt_regions VALUES(1947, 120, 'BW', 'Banī Walīd', 'russian');
INSERT INTO emkt_regions VALUES(1948, 120, 'DR', 'Darnah', 'russian');
INSERT INTO emkt_regions VALUES(1949, 120, 'GD', 'Ghadāmis', 'russian');
INSERT INTO emkt_regions VALUES(1950, 120, 'GR', 'Gharyān', 'russian');
INSERT INTO emkt_regions VALUES(1951, 120, 'GT', 'Ghāt', 'russian');
INSERT INTO emkt_regions VALUES(1952, 120, 'HZ', 'Al Ḩizām al Akhḑar', 'russian');
INSERT INTO emkt_regions VALUES(1953, 120, 'JA', 'Al Jabal al Akhḑar', 'russian');
INSERT INTO emkt_regions VALUES(1954, 120, 'JB', 'Jaghbūb', 'russian');
INSERT INTO emkt_regions VALUES(1955, 120, 'JI', 'Al Jifārah', 'russian');
INSERT INTO emkt_regions VALUES(1956, 120, 'JU', 'Al Jufrah', 'russian');
INSERT INTO emkt_regions VALUES(1957, 120, 'KF', 'Al Kufrah', 'russian');
INSERT INTO emkt_regions VALUES(1958, 120, 'MB', 'Al Marqab', 'russian');
INSERT INTO emkt_regions VALUES(1959, 120, 'MI', 'Mişrātah', 'russian');
INSERT INTO emkt_regions VALUES(1960, 120, 'MJ', 'Al Marj', 'russian');
INSERT INTO emkt_regions VALUES(1961, 120, 'MQ', 'Murzuq', 'russian');
INSERT INTO emkt_regions VALUES(1962, 120, 'MZ', 'Mizdah', 'russian');
INSERT INTO emkt_regions VALUES(1963, 120, 'NL', 'Nālūt', 'russian');
INSERT INTO emkt_regions VALUES(1964, 120, 'NQ', 'An Nuqaţ al Khams', 'russian');
INSERT INTO emkt_regions VALUES(1965, 120, 'QB', 'Al Qubbah', 'russian');
INSERT INTO emkt_regions VALUES(1966, 120, 'QT', 'Al Qaţrūn', 'russian');
INSERT INTO emkt_regions VALUES(1967, 120, 'SB', 'Sabhā', 'russian');
INSERT INTO emkt_regions VALUES(1968, 120, 'SH', 'Ash Shāţi', 'russian');
INSERT INTO emkt_regions VALUES(1969, 120, 'SR', 'Surt', 'russian');
INSERT INTO emkt_regions VALUES(1970, 120, 'SS', 'Şabrātah Şurmān', 'russian');
INSERT INTO emkt_regions VALUES(1971, 120, 'TB', 'Ţarābulus', 'russian');
INSERT INTO emkt_regions VALUES(1972, 120, 'TM', 'Tarhūnah-Masallātah', 'russian');
INSERT INTO emkt_regions VALUES(1973, 120, 'TN', 'Tājūrā wa an Nawāḩī al Arbāʻ', 'russian');
INSERT INTO emkt_regions VALUES(1974, 120, 'WA', 'Al Wāḩah', 'russian');
INSERT INTO emkt_regions VALUES(1975, 120, 'WD', 'Wādī al Ḩayāt', 'russian');
INSERT INTO emkt_regions VALUES(1976, 120, 'YJ', 'Yafran-Jādū', 'russian');
INSERT INTO emkt_regions VALUES(1977, 120, 'ZA', 'Az Zāwiyah', 'russian');

INSERT INTO emkt_countries VALUES (121,'Лихтенштейн','russian','LI','LIE','');

INSERT INTO emkt_regions VALUES(1978, 121, 'B', 'Balzers', 'russian');
INSERT INTO emkt_regions VALUES(1979, 121, 'E', 'Eschen', 'russian');
INSERT INTO emkt_regions VALUES(1980, 121, 'G', 'Gamprin', 'russian');
INSERT INTO emkt_regions VALUES(1981, 121, 'M', 'Mauren', 'russian');
INSERT INTO emkt_regions VALUES(1982, 121, 'P', 'Planken', 'russian');
INSERT INTO emkt_regions VALUES(1983, 121, 'R', 'Ruggell', 'russian');
INSERT INTO emkt_regions VALUES(1984, 121, 'A', 'Schaan', 'russian');
INSERT INTO emkt_regions VALUES(1985, 121, 'L', 'Schellenberg', 'russian');
INSERT INTO emkt_regions VALUES(1986, 121, 'N', 'Triesen', 'russian');
INSERT INTO emkt_regions VALUES(1987, 121, 'T', 'Triesenberg', 'russian');
INSERT INTO emkt_regions VALUES(1988, 121, 'V', 'Vaduz', 'russian');

INSERT INTO emkt_countries VALUES (122,'Литва','russian','LT','LTU','');

INSERT INTO emkt_regions VALUES(1989, 122, 'AL', 'Alytaus Apskritis', 'russian');
INSERT INTO emkt_regions VALUES(1990, 122, 'KL', 'Klaipėdos Apskritis', 'russian');
INSERT INTO emkt_regions VALUES(1991, 122, 'KU', 'Kauno Apskritis', 'russian');
INSERT INTO emkt_regions VALUES(1992, 122, 'MR', 'Marijampolės Apskritis', 'russian');
INSERT INTO emkt_regions VALUES(1993, 122, 'PN', 'Panevėžio Apskritis', 'russian');
INSERT INTO emkt_regions VALUES(1994, 122, 'SA', 'Šiaulių Apskritis', 'russian');
INSERT INTO emkt_regions VALUES(1995, 122, 'TA', 'Tauragės Apskritis', 'russian');
INSERT INTO emkt_regions VALUES(1996, 122, 'TE', 'Telšių Apskritis', 'russian');
INSERT INTO emkt_regions VALUES(1997, 122, 'UT', 'Utenos Apskritis', 'russian');
INSERT INTO emkt_regions VALUES(1998, 122, 'VL', 'Vilniaus Apskritis', 'russian');

INSERT INTO emkt_countries VALUES (123,'Люксембург','russian','LU','LUX','');

INSERT INTO emkt_regions VALUES(1999, 123, 'D', 'Diekirch', 'russian');
INSERT INTO emkt_regions VALUES(2000, 123, 'G', 'Grevenmacher', 'russian');
INSERT INTO emkt_regions VALUES(2001, 123, 'L', 'Luxemburg', 'russian');

INSERT INTO emkt_countries VALUES (124,'Макао','russian','MO','MAC','');

INSERT INTO emkt_regions VALUES(2002, 124, 'I', '海島市', 'russian');
INSERT INTO emkt_regions VALUES(2003, 124, 'M', '澳門市', 'russian');

INSERT INTO emkt_countries VALUES (125,'Македония','russian','MK','MKD','');

INSERT INTO emkt_regions VALUES(2004, 125, 'BR', 'Berovo', 'russian');
INSERT INTO emkt_regions VALUES(2005, 125, 'CH', 'Чешиново-Облешево', 'russian');
INSERT INTO emkt_regions VALUES(2006, 125, 'DL', 'Делчево', 'russian');
INSERT INTO emkt_regions VALUES(2007, 125, 'KB', 'Карбинци', 'russian');
INSERT INTO emkt_regions VALUES(2008, 125, 'OC', 'Кочани', 'russian');
INSERT INTO emkt_regions VALUES(2009, 125, 'LO', 'Лозово', 'russian');
INSERT INTO emkt_regions VALUES(2010, 125, 'MK', 'Македонска каменица', 'russian');
INSERT INTO emkt_regions VALUES(2011, 125, 'PH', 'Пехчево', 'russian');
INSERT INTO emkt_regions VALUES(2012, 125, 'PT', 'Пробиштип', 'russian');
INSERT INTO emkt_regions VALUES(2013, 125, 'ST', 'Штип', 'russian');
INSERT INTO emkt_regions VALUES(2014, 125, 'SL', 'Свети Николе', 'russian');
INSERT INTO emkt_regions VALUES(2015, 125, 'NI', 'Виница', 'russian');
INSERT INTO emkt_regions VALUES(2016, 125, 'ZR', 'Зрновци', 'russian');
INSERT INTO emkt_regions VALUES(2017, 125, 'KY', 'Кратово', 'russian');
INSERT INTO emkt_regions VALUES(2018, 125, 'KZ', 'Крива Паланка', 'russian');
INSERT INTO emkt_regions VALUES(2019, 125, 'UM', 'Куманово', 'russian');
INSERT INTO emkt_regions VALUES(2020, 125, 'LI', 'Липково', 'russian');
INSERT INTO emkt_regions VALUES(2021, 125, 'RN', 'Ранковце', 'russian');
INSERT INTO emkt_regions VALUES(2022, 125, 'NA', 'Старо Нагоричане', 'russian');
INSERT INTO emkt_regions VALUES(2023, 125, 'TL', 'Битола', 'russian');
INSERT INTO emkt_regions VALUES(2024, 125, 'DM', 'Демир Хисар', 'russian');
INSERT INTO emkt_regions VALUES(2025, 125, 'DE', 'Долнени', 'russian');
INSERT INTO emkt_regions VALUES(2026, 125, 'KG', 'Кривогаштани', 'russian');
INSERT INTO emkt_regions VALUES(2027, 125, 'KS', 'Крушево', 'russian');
INSERT INTO emkt_regions VALUES(2028, 125, 'MG', 'Могила', 'russian');
INSERT INTO emkt_regions VALUES(2029, 125, 'NV', 'Новаци', 'russian');
INSERT INTO emkt_regions VALUES(2030, 125, 'PP', 'Прилеп', 'russian');
INSERT INTO emkt_regions VALUES(2031, 125, 'RE', 'Ресен', 'russian');
INSERT INTO emkt_regions VALUES(2032, 125, 'VJ', 'Боговиње', 'russian');
INSERT INTO emkt_regions VALUES(2033, 125, 'BN', 'Брвеница', 'russian');
INSERT INTO emkt_regions VALUES(2034, 125, 'GT', 'Гостивар', 'russian');
INSERT INTO emkt_regions VALUES(2035, 125, 'JG', 'Јегуновце', 'russian');
INSERT INTO emkt_regions VALUES(2036, 125, 'MR', 'Маврово и Ростуша', 'russian');
INSERT INTO emkt_regions VALUES(2037, 125, 'TR', 'Теарце', 'russian');
INSERT INTO emkt_regions VALUES(2038, 125, 'ET', 'Тетово', 'russian');
INSERT INTO emkt_regions VALUES(2039, 125, 'VH', 'Врапчиште', 'russian');
INSERT INTO emkt_regions VALUES(2040, 125, 'ZE', 'Желино', 'russian');
INSERT INTO emkt_regions VALUES(2041, 125, 'AD', 'Аеродром', 'russian');
INSERT INTO emkt_regions VALUES(2042, 125, 'AR', 'Арачиново', 'russian');
INSERT INTO emkt_regions VALUES(2043, 125, 'BU', 'Бутел', 'russian');
INSERT INTO emkt_regions VALUES(2044, 125, 'CI', 'Чаир', 'russian');
INSERT INTO emkt_regions VALUES(2045, 125, 'CE', 'Центар', 'russian');
INSERT INTO emkt_regions VALUES(2046, 125, 'CS', 'Чучер Сандево', 'russian');
INSERT INTO emkt_regions VALUES(2047, 125, 'GB', 'Гази Баба', 'russian');
INSERT INTO emkt_regions VALUES(2048, 125, 'GP', 'Ѓорче Петров', 'russian');
INSERT INTO emkt_regions VALUES(2049, 125, 'IL', 'Илинден', 'russian');
INSERT INTO emkt_regions VALUES(2050, 125, 'KX', 'Карпош', 'russian');
INSERT INTO emkt_regions VALUES(2051, 125, 'VD', 'Кисела Вода', 'russian');
INSERT INTO emkt_regions VALUES(2052, 125, 'PE', 'Петровец', 'russian');
INSERT INTO emkt_regions VALUES(2053, 125, 'AJ', 'Сарај', 'russian');
INSERT INTO emkt_regions VALUES(2054, 125, 'SS', 'Сопиште', 'russian');
INSERT INTO emkt_regions VALUES(2055, 125, 'SU', 'Студеничани', 'russian');
INSERT INTO emkt_regions VALUES(2056, 125, 'SO', 'Шуто Оризари', 'russian');
INSERT INTO emkt_regions VALUES(2057, 125, 'ZK', 'Зелениково', 'russian');
INSERT INTO emkt_regions VALUES(2058, 125, 'BG', 'Богданци', 'russian');
INSERT INTO emkt_regions VALUES(2059, 125, 'BS', 'Босилово', 'russian');
INSERT INTO emkt_regions VALUES(2060, 125, 'GV', 'Гевгелија', 'russian');
INSERT INTO emkt_regions VALUES(2061, 125, 'KN', 'Конче', 'russian');
INSERT INTO emkt_regions VALUES(2062, 125, 'NS', 'Ново Село', 'russian');
INSERT INTO emkt_regions VALUES(2063, 125, 'RV', 'Радовиш', 'russian');
INSERT INTO emkt_regions VALUES(2064, 125, 'SD', 'Стар Дојран', 'russian');
INSERT INTO emkt_regions VALUES(2065, 125, 'RU', 'Струмица', 'russian');
INSERT INTO emkt_regions VALUES(2066, 125, 'VA', 'Валандово', 'russian');
INSERT INTO emkt_regions VALUES(2067, 125, 'VL', 'Василево', 'russian');
INSERT INTO emkt_regions VALUES(2068, 125, 'CZ', 'Центар Жупа', 'russian');
INSERT INTO emkt_regions VALUES(2069, 125, 'DB', 'Дебар', 'russian');
INSERT INTO emkt_regions VALUES(2070, 125, 'DA', 'Дебарца', 'russian');
INSERT INTO emkt_regions VALUES(2071, 125, 'DR', 'Другово', 'russian');
INSERT INTO emkt_regions VALUES(2072, 125, 'KH', 'Кичево', 'russian');
INSERT INTO emkt_regions VALUES(2073, 125, 'MD', 'Македонски Брод', 'russian');
INSERT INTO emkt_regions VALUES(2074, 125, 'OD', 'Охрид', 'russian');
INSERT INTO emkt_regions VALUES(2075, 125, 'OS', 'Осломеј', 'russian');
INSERT INTO emkt_regions VALUES(2076, 125, 'PN', 'Пласница', 'russian');
INSERT INTO emkt_regions VALUES(2077, 125, 'UG', 'Струга', 'russian');
INSERT INTO emkt_regions VALUES(2078, 125, 'VV', 'Вевчани', 'russian');
INSERT INTO emkt_regions VALUES(2079, 125, 'VC', 'Вранештица', 'russian');
INSERT INTO emkt_regions VALUES(2080, 125, 'ZA', 'Зајас', 'russian');
INSERT INTO emkt_regions VALUES(2081, 125, 'CA', 'Чашка', 'russian');
INSERT INTO emkt_regions VALUES(2082, 125, 'DK', 'Демир Капија', 'russian');
INSERT INTO emkt_regions VALUES(2083, 125, 'GR', 'Градско', 'russian');
INSERT INTO emkt_regions VALUES(2084, 125, 'AV', 'Кавадарци', 'russian');
INSERT INTO emkt_regions VALUES(2085, 125, 'NG', 'Неготино', 'russian');
INSERT INTO emkt_regions VALUES(2086, 125, 'RM', 'Росоман', 'russian');
INSERT INTO emkt_regions VALUES(2087, 125, 'VE', 'Велес', 'russian');

INSERT INTO emkt_countries VALUES (126,'Мадагаскар','russian','MG','MDG','');

INSERT INTO emkt_regions VALUES(2088, 126, 'A', 'Toamasina', 'russian');
INSERT INTO emkt_regions VALUES(2089, 126, 'D', 'Antsiranana', 'russian');
INSERT INTO emkt_regions VALUES(2090, 126, 'F', 'Fianarantsoa', 'russian');
INSERT INTO emkt_regions VALUES(2091, 126, 'M', 'Mahajanga', 'russian');
INSERT INTO emkt_regions VALUES(2092, 126, 'T', 'Antananarivo', 'russian');
INSERT INTO emkt_regions VALUES(2093, 126, 'U', 'Toliara', 'russian');

INSERT INTO emkt_countries VALUES (127,'Малави','russian','MW','MWI','');

INSERT INTO emkt_regions VALUES(2094, 127, 'BA', 'Balaka', 'russian');
INSERT INTO emkt_regions VALUES(2095, 127, 'BL', 'Blantyre', 'russian');
INSERT INTO emkt_regions VALUES(2096, 127, 'C', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(2097, 127, 'CK', 'Chikwawa', 'russian');
INSERT INTO emkt_regions VALUES(2098, 127, 'CR', 'Chiradzulu', 'russian');
INSERT INTO emkt_regions VALUES(2099, 127, 'CT', 'Chitipa', 'russian');
INSERT INTO emkt_regions VALUES(2100, 127, 'DE', 'Dedza', 'russian');
INSERT INTO emkt_regions VALUES(2101, 127, 'DO', 'Dowa', 'russian');
INSERT INTO emkt_regions VALUES(2102, 127, 'KR', 'Karonga', 'russian');
INSERT INTO emkt_regions VALUES(2103, 127, 'KS', 'Kasungu', 'russian');
INSERT INTO emkt_regions VALUES(2104, 127, 'LK', 'Likoma Island', 'russian');
INSERT INTO emkt_regions VALUES(2105, 127, 'LI', 'Lilongwe', 'russian');
INSERT INTO emkt_regions VALUES(2106, 127, 'MH', 'Machinga', 'russian');
INSERT INTO emkt_regions VALUES(2107, 127, 'MG', 'Mangochi', 'russian');
INSERT INTO emkt_regions VALUES(2108, 127, 'MC', 'Mchinji', 'russian');
INSERT INTO emkt_regions VALUES(2109, 127, 'MU', 'Mulanje', 'russian');
INSERT INTO emkt_regions VALUES(2110, 127, 'MW', 'Mwanza', 'russian');
INSERT INTO emkt_regions VALUES(2111, 127, 'MZ', 'Mzimba', 'russian');
INSERT INTO emkt_regions VALUES(2112, 127, 'N', 'Northern', 'russian');
INSERT INTO emkt_regions VALUES(2113, 127, 'NB', 'Nkhata', 'russian');
INSERT INTO emkt_regions VALUES(2114, 127, 'NK', 'Nkhotakota', 'russian');
INSERT INTO emkt_regions VALUES(2115, 127, 'NS', 'Nsanje', 'russian');
INSERT INTO emkt_regions VALUES(2116, 127, 'NU', 'Ntcheu', 'russian');
INSERT INTO emkt_regions VALUES(2117, 127, 'NI', 'Ntchisi', 'russian');
INSERT INTO emkt_regions VALUES(2118, 127, 'PH', 'Phalombe', 'russian');
INSERT INTO emkt_regions VALUES(2119, 127, 'RU', 'Rumphi', 'russian');
INSERT INTO emkt_regions VALUES(2120, 127, 'S', 'Southern', 'russian');
INSERT INTO emkt_regions VALUES(2121, 127, 'SA', 'Salima', 'russian');
INSERT INTO emkt_regions VALUES(2122, 127, 'TH', 'Thyolo', 'russian');
INSERT INTO emkt_regions VALUES(2123, 127, 'ZO', 'Zomba', 'russian');

INSERT INTO emkt_countries VALUES (128,'Малайзия','russian','MY','MYS','');

INSERT INTO emkt_regions VALUES(2124, 128, '01', 'Johor Darul Takzim', 'russian');
INSERT INTO emkt_regions VALUES(2125, 128, '02', 'Kedah Darul Aman', 'russian');
INSERT INTO emkt_regions VALUES(2126, 128, '03', 'Kelantan Darul Naim', 'russian');
INSERT INTO emkt_regions VALUES(2127, 128, '04', 'Melaka Negeri Bersejarah', 'russian');
INSERT INTO emkt_regions VALUES(2128, 128, '05', 'Negeri Sembilan Darul Khusus', 'russian');
INSERT INTO emkt_regions VALUES(2129, 128, '06', 'Pahang Darul Makmur', 'russian');
INSERT INTO emkt_regions VALUES(2130, 128, '07', 'Pulau Pinang', 'russian');
INSERT INTO emkt_regions VALUES(2131, 128, '08', 'Perak Darul Ridzuan', 'russian');
INSERT INTO emkt_regions VALUES(2132, 128, '09', 'Perlis Indera Kayangan', 'russian');
INSERT INTO emkt_regions VALUES(2133, 128, '10', 'Selangor Darul Ehsan', 'russian');
INSERT INTO emkt_regions VALUES(2134, 128, '11', 'Terengganu Darul Iman', 'russian');
INSERT INTO emkt_regions VALUES(2135, 128, '12', 'Sabah Negeri Di Bawah Bayu', 'russian');
INSERT INTO emkt_regions VALUES(2136, 128, '13', 'Sarawak Bumi Kenyalang', 'russian');
INSERT INTO emkt_regions VALUES(2137, 128, '14', 'Wilayah Persekutuan Kuala Lumpur', 'russian');
INSERT INTO emkt_regions VALUES(2138, 128, '15', 'Wilayah Persekutuan Labuan', 'russian');
INSERT INTO emkt_regions VALUES(2139, 128, '16', 'Wilayah Persekutuan Putrajaya', 'russian');

INSERT INTO emkt_countries VALUES (129,'Мальдивы','russian','MV','MDV','');

INSERT INTO emkt_regions VALUES(2140, 129, 'THU', 'Thiladhunmathi Uthuru', 'russian');
INSERT INTO emkt_regions VALUES(2141, 129, 'THD', 'Thiladhunmathi Dhekunu', 'russian');
INSERT INTO emkt_regions VALUES(2142, 129, 'MLU', 'Miladhunmadulu Uthuru', 'russian');
INSERT INTO emkt_regions VALUES(2143, 129, 'MLD', 'Miladhunmadulu Dhekunu', 'russian');
INSERT INTO emkt_regions VALUES(2144, 129, 'MAU', 'Maalhosmadulu Uthuru', 'russian');
INSERT INTO emkt_regions VALUES(2145, 129, 'MAD', 'Maalhosmadulu Dhekunu', 'russian');
INSERT INTO emkt_regions VALUES(2146, 129, 'FAA', 'Faadhippolhu', 'russian');
INSERT INTO emkt_regions VALUES(2147, 129, 'MAA', 'Male Atoll', 'russian');
INSERT INTO emkt_regions VALUES(2148, 129, 'AAU', 'Ari Atoll Uthuru', 'russian');
INSERT INTO emkt_regions VALUES(2149, 129, 'AAD', 'Ari Atoll Dheknu', 'russian');
INSERT INTO emkt_regions VALUES(2150, 129, 'FEA', 'Felidhe Atoll', 'russian');
INSERT INTO emkt_regions VALUES(2151, 129, 'MUA', 'Mulaku Atoll', 'russian');
INSERT INTO emkt_regions VALUES(2152, 129, 'NAU', 'Nilandhe Atoll Uthuru', 'russian');
INSERT INTO emkt_regions VALUES(2153, 129, 'NAD', 'Nilandhe Atoll Dhekunu', 'russian');
INSERT INTO emkt_regions VALUES(2154, 129, 'KLH', 'Kolhumadulu', 'russian');
INSERT INTO emkt_regions VALUES(2155, 129, 'HDH', 'Hadhdhunmathi', 'russian');
INSERT INTO emkt_regions VALUES(2156, 129, 'HAU', 'Huvadhu Atoll Uthuru', 'russian');
INSERT INTO emkt_regions VALUES(2157, 129, 'HAD', 'Huvadhu Atoll Dhekunu', 'russian');
INSERT INTO emkt_regions VALUES(2158, 129, 'FMU', 'Fua Mulaku', 'russian');
INSERT INTO emkt_regions VALUES(2159, 129, 'ADD', 'Addu', 'russian');

INSERT INTO emkt_countries VALUES (130,'Мали','russian','ML','MLI','');

INSERT INTO emkt_regions VALUES(2160, 130, '1', 'Kayes', 'russian');
INSERT INTO emkt_regions VALUES(2161, 130, '2', 'Koulikoro', 'russian');
INSERT INTO emkt_regions VALUES(2162, 130, '3', 'Sikasso', 'russian');
INSERT INTO emkt_regions VALUES(2163, 130, '4', 'Ségou', 'russian');
INSERT INTO emkt_regions VALUES(2164, 130, '5', 'Mopti', 'russian');
INSERT INTO emkt_regions VALUES(2165, 130, '6', 'Tombouctou', 'russian');
INSERT INTO emkt_regions VALUES(2166, 130, '7', 'Gao', 'russian');
INSERT INTO emkt_regions VALUES(2167, 130, '8', 'Kidal', 'russian');
INSERT INTO emkt_regions VALUES(2168, 130, 'BK0', 'Bamako', 'russian');

INSERT INTO emkt_countries VALUES (131,'Мальта','russian','MT','MLT','');

INSERT INTO emkt_regions VALUES(2169, 131, 'ATT', 'Attard', 'russian');
INSERT INTO emkt_regions VALUES(2170, 131, 'BAL', 'Balzan', 'russian');
INSERT INTO emkt_regions VALUES(2171, 131, 'BGU', 'Birgu', 'russian');
INSERT INTO emkt_regions VALUES(2172, 131, 'BKK', 'Birkirkara', 'russian');
INSERT INTO emkt_regions VALUES(2173, 131, 'BRZ', 'Birzebbuga', 'russian');
INSERT INTO emkt_regions VALUES(2174, 131, 'BOR', 'Bormla', 'russian');
INSERT INTO emkt_regions VALUES(2175, 131, 'DIN', 'Dingli', 'russian');
INSERT INTO emkt_regions VALUES(2176, 131, 'FGU', 'Fgura', 'russian');
INSERT INTO emkt_regions VALUES(2177, 131, 'FLO', 'Floriana', 'russian');
INSERT INTO emkt_regions VALUES(2178, 131, 'GDJ', 'Gudja', 'russian');
INSERT INTO emkt_regions VALUES(2179, 131, 'GZR', 'Gzira', 'russian');
INSERT INTO emkt_regions VALUES(2180, 131, 'GRG', 'Gargur', 'russian');
INSERT INTO emkt_regions VALUES(2181, 131, 'GXQ', 'Gaxaq', 'russian');
INSERT INTO emkt_regions VALUES(2182, 131, 'HMR', 'Hamrun', 'russian');
INSERT INTO emkt_regions VALUES(2183, 131, 'IKL', 'Iklin', 'russian');
INSERT INTO emkt_regions VALUES(2184, 131, 'ISL', 'Isla', 'russian');
INSERT INTO emkt_regions VALUES(2185, 131, 'KLK', 'Kalkara', 'russian');
INSERT INTO emkt_regions VALUES(2186, 131, 'KRK', 'Kirkop', 'russian');
INSERT INTO emkt_regions VALUES(2187, 131, 'LIJ', 'Lija', 'russian');
INSERT INTO emkt_regions VALUES(2188, 131, 'LUQ', 'Luqa', 'russian');
INSERT INTO emkt_regions VALUES(2189, 131, 'MRS', 'Marsa', 'russian');
INSERT INTO emkt_regions VALUES(2190, 131, 'MKL', 'Marsaskala', 'russian');
INSERT INTO emkt_regions VALUES(2191, 131, 'MXL', 'Marsaxlokk', 'russian');
INSERT INTO emkt_regions VALUES(2192, 131, 'MDN', 'Mdina', 'russian');
INSERT INTO emkt_regions VALUES(2193, 131, 'MEL', 'Melliea', 'russian');
INSERT INTO emkt_regions VALUES(2194, 131, 'MGR', 'Mgarr', 'russian');
INSERT INTO emkt_regions VALUES(2195, 131, 'MST', 'Mosta', 'russian');
INSERT INTO emkt_regions VALUES(2196, 131, 'MQA', 'Mqabba', 'russian');
INSERT INTO emkt_regions VALUES(2197, 131, 'MSI', 'Msida', 'russian');
INSERT INTO emkt_regions VALUES(2198, 131, 'MTF', 'Mtarfa', 'russian');
INSERT INTO emkt_regions VALUES(2199, 131, 'NAX', 'Naxxar', 'russian');
INSERT INTO emkt_regions VALUES(2200, 131, 'PAO', 'Paola', 'russian');
INSERT INTO emkt_regions VALUES(2201, 131, 'PEM', 'Pembroke', 'russian');
INSERT INTO emkt_regions VALUES(2202, 131, 'PIE', 'Pieta', 'russian');
INSERT INTO emkt_regions VALUES(2203, 131, 'QOR', 'Qormi', 'russian');
INSERT INTO emkt_regions VALUES(2204, 131, 'QRE', 'Qrendi', 'russian');
INSERT INTO emkt_regions VALUES(2205, 131, 'RAB', 'Rabat', 'russian');
INSERT INTO emkt_regions VALUES(2206, 131, 'SAF', 'Safi', 'russian');
INSERT INTO emkt_regions VALUES(2207, 131, 'SGI', 'San Giljan', 'russian');
INSERT INTO emkt_regions VALUES(2208, 131, 'SLU', 'Santa Lucija', 'russian');
INSERT INTO emkt_regions VALUES(2209, 131, 'SPB', 'San Pawl il-Bahar', 'russian');
INSERT INTO emkt_regions VALUES(2210, 131, 'SGW', 'San Gwann', 'russian');
INSERT INTO emkt_regions VALUES(2211, 131, 'SVE', 'Santa Venera', 'russian');
INSERT INTO emkt_regions VALUES(2212, 131, 'SIG', 'Siggiewi', 'russian');
INSERT INTO emkt_regions VALUES(2213, 131, 'SLM', 'Sliema', 'russian');
INSERT INTO emkt_regions VALUES(2214, 131, 'SWQ', 'Swieqi', 'russian');
INSERT INTO emkt_regions VALUES(2215, 131, 'TXB', 'Ta Xbiex', 'russian');
INSERT INTO emkt_regions VALUES(2216, 131, 'TRX', 'Tarxien', 'russian');
INSERT INTO emkt_regions VALUES(2217, 131, 'VLT', 'Valletta', 'russian');
INSERT INTO emkt_regions VALUES(2218, 131, 'XGJ', 'Xgajra', 'russian');
INSERT INTO emkt_regions VALUES(2219, 131, 'ZBR', 'Zabbar', 'russian');
INSERT INTO emkt_regions VALUES(2220, 131, 'ZBG', 'Zebbug', 'russian');
INSERT INTO emkt_regions VALUES(2221, 131, 'ZJT', 'Zejtun', 'russian');
INSERT INTO emkt_regions VALUES(2222, 131, 'ZRQ', 'Zurrieq', 'russian');
INSERT INTO emkt_regions VALUES(2223, 131, 'FNT', 'Fontana', 'russian');
INSERT INTO emkt_regions VALUES(2224, 131, 'GHJ', 'Ghajnsielem', 'russian');
INSERT INTO emkt_regions VALUES(2225, 131, 'GHR', 'Gharb', 'russian');
INSERT INTO emkt_regions VALUES(2226, 131, 'GHS', 'Ghasri', 'russian');
INSERT INTO emkt_regions VALUES(2227, 131, 'KRC', 'Kercem', 'russian');
INSERT INTO emkt_regions VALUES(2228, 131, 'MUN', 'Munxar', 'russian');
INSERT INTO emkt_regions VALUES(2229, 131, 'NAD', 'Nadur', 'russian');
INSERT INTO emkt_regions VALUES(2230, 131, 'QAL', 'Qala', 'russian');
INSERT INTO emkt_regions VALUES(2231, 131, 'VIC', 'Victoria', 'russian');
INSERT INTO emkt_regions VALUES(2232, 131, 'SLA', 'San Lawrenz', 'russian');
INSERT INTO emkt_regions VALUES(2233, 131, 'SNT', 'Sannat', 'russian');
INSERT INTO emkt_regions VALUES(2234, 131, 'ZAG', 'Xagra', 'russian');
INSERT INTO emkt_regions VALUES(2235, 131, 'XEW', 'Xewkija', 'russian');
INSERT INTO emkt_regions VALUES(2236, 131, 'ZEB', 'Zebbug', 'russian');

INSERT INTO emkt_countries VALUES (132,'Маршалловы Острова','russian','MH','MHL','');

INSERT INTO emkt_regions VALUES(2237, 132, 'ALK', 'Ailuk', 'russian');
INSERT INTO emkt_regions VALUES(2238, 132, 'ALL', 'Ailinglapalap', 'russian');
INSERT INTO emkt_regions VALUES(2239, 132, 'ARN', 'Arno', 'russian');
INSERT INTO emkt_regions VALUES(2240, 132, 'AUR', 'Aur', 'russian');
INSERT INTO emkt_regions VALUES(2241, 132, 'EBO', 'Ebon', 'russian');
INSERT INTO emkt_regions VALUES(2242, 132, 'ENI', 'Eniwetok', 'russian');
INSERT INTO emkt_regions VALUES(2243, 132, 'JAB', 'Jabat', 'russian');
INSERT INTO emkt_regions VALUES(2244, 132, 'JAL', 'Jaluit', 'russian');
INSERT INTO emkt_regions VALUES(2245, 132, 'KIL', 'Kili', 'russian');
INSERT INTO emkt_regions VALUES(2246, 132, 'KWA', 'Kwajalein', 'russian');
INSERT INTO emkt_regions VALUES(2247, 132, 'LAE', 'Lae', 'russian');
INSERT INTO emkt_regions VALUES(2248, 132, 'LIB', 'Lib', 'russian');
INSERT INTO emkt_regions VALUES(2249, 132, 'LIK', 'Likiep', 'russian');
INSERT INTO emkt_regions VALUES(2250, 132, 'MAJ', 'Majuro', 'russian');
INSERT INTO emkt_regions VALUES(2251, 132, 'MAL', 'Maloelap', 'russian');
INSERT INTO emkt_regions VALUES(2252, 132, 'MEJ', 'Mejit', 'russian');
INSERT INTO emkt_regions VALUES(2253, 132, 'MIL', 'Mili', 'russian');
INSERT INTO emkt_regions VALUES(2254, 132, 'NMK', 'Namorik', 'russian');
INSERT INTO emkt_regions VALUES(2255, 132, 'NMU', 'Namu', 'russian');
INSERT INTO emkt_regions VALUES(2256, 132, 'RON', 'Rongelap', 'russian');
INSERT INTO emkt_regions VALUES(2257, 132, 'UJA', 'Ujae', 'russian');
INSERT INTO emkt_regions VALUES(2258, 132, 'UJL', 'Ujelang', 'russian');
INSERT INTO emkt_regions VALUES(2259, 132, 'UTI', 'Utirik', 'russian');
INSERT INTO emkt_regions VALUES(2260, 132, 'WTJ', 'Wotje', 'russian');
INSERT INTO emkt_regions VALUES(2261, 132, 'WTN', 'Wotho', 'russian');

INSERT INTO emkt_countries VALUES (133,'Мартиника','russian','MQ','MTQ','');

INSERT INTO emkt_regions VALUES(4264, 133, 'NOCODE', 'Martinique', 'russian');

INSERT INTO emkt_countries VALUES (134,'Мавритания','russian','MR','MRT','');

INSERT INTO emkt_regions VALUES(2262, 134, '01', 'ولاية الحوض الشرقي', 'russian');
INSERT INTO emkt_regions VALUES(2263, 134, '02', 'ولاية الحوض الغربي', 'russian');
INSERT INTO emkt_regions VALUES(2264, 134, '03', 'ولاية العصابة', 'russian');
INSERT INTO emkt_regions VALUES(2265, 134, '04', 'ولاية كركول', 'russian');
INSERT INTO emkt_regions VALUES(2266, 134, '05', 'ولاية البراكنة', 'russian');
INSERT INTO emkt_regions VALUES(2267, 134, '06', 'ولاية الترارزة', 'russian');
INSERT INTO emkt_regions VALUES(2268, 134, '07', 'ولاية آدرار', 'russian');
INSERT INTO emkt_regions VALUES(2269, 134, '08', 'ولاية داخلت نواذيبو', 'russian');
INSERT INTO emkt_regions VALUES(2270, 134, '09', 'ولاية تكانت', 'russian');
INSERT INTO emkt_regions VALUES(2271, 134, '10', 'ولاية كيدي ماغة', 'russian');
INSERT INTO emkt_regions VALUES(2272, 134, '11', 'ولاية تيرس زمور', 'russian');
INSERT INTO emkt_regions VALUES(2273, 134, '12', 'ولاية إينشيري', 'russian');
INSERT INTO emkt_regions VALUES(2274, 134, 'NKC', 'نواكشوط', 'russian');

INSERT INTO emkt_countries VALUES (135,'Маврикий','russian','MU','MUS','');

INSERT INTO emkt_regions VALUES(2275, 135, 'AG', 'Agalega Islands', 'russian');
INSERT INTO emkt_regions VALUES(2276, 135, 'BL', 'Black River', 'russian');
INSERT INTO emkt_regions VALUES(2277, 135, 'BR', 'Beau Bassin-Rose Hill', 'russian');
INSERT INTO emkt_regions VALUES(2278, 135, 'CC', 'Cargados Carajos Shoals', 'russian');
INSERT INTO emkt_regions VALUES(2279, 135, 'CU', 'Curepipe', 'russian');
INSERT INTO emkt_regions VALUES(2280, 135, 'FL', 'Flacq', 'russian');
INSERT INTO emkt_regions VALUES(2281, 135, 'GP', 'Grand Port', 'russian');
INSERT INTO emkt_regions VALUES(2282, 135, 'MO', 'Moka', 'russian');
INSERT INTO emkt_regions VALUES(2283, 135, 'PA', 'Pamplemousses', 'russian');
INSERT INTO emkt_regions VALUES(2284, 135, 'PL', 'Port Louis', 'russian');
INSERT INTO emkt_regions VALUES(2285, 135, 'PU', 'Port Louis City', 'russian');
INSERT INTO emkt_regions VALUES(2286, 135, 'PW', 'Plaines Wilhems', 'russian');
INSERT INTO emkt_regions VALUES(2287, 135, 'QB', 'Quatre Bornes', 'russian');
INSERT INTO emkt_regions VALUES(2288, 135, 'RO', 'Rodrigues', 'russian');
INSERT INTO emkt_regions VALUES(2289, 135, 'RR', 'Riviere du Rempart', 'russian');
INSERT INTO emkt_regions VALUES(2290, 135, 'SA', 'Savanne', 'russian');
INSERT INTO emkt_regions VALUES(2291, 135, 'VP', 'Vacoas-Phoenix', 'russian');

INSERT INTO emkt_countries VALUES (136,'Майотта','russian','YT','MYT','');

INSERT INTO emkt_regions VALUES(4265, 136, 'NOCODE', 'Mayotte', 'russian');

INSERT INTO emkt_countries VALUES (137,'Мексика','russian','MX','MEX','');

INSERT INTO emkt_regions VALUES(2292, 137, 'AGU', 'Aguascalientes', 'russian');
INSERT INTO emkt_regions VALUES(2293, 137, 'BCN', 'Baja California', 'russian');
INSERT INTO emkt_regions VALUES(2294, 137, 'BCS', 'Baja California Sur', 'russian');
INSERT INTO emkt_regions VALUES(2295, 137, 'CAM', 'Campeche', 'russian');
INSERT INTO emkt_regions VALUES(2296, 137, 'CHH', 'Chihuahua', 'russian');
INSERT INTO emkt_regions VALUES(2297, 137, 'CHP', 'Chiapas', 'russian');
INSERT INTO emkt_regions VALUES(2298, 137, 'COA', 'Coahuila', 'russian');
INSERT INTO emkt_regions VALUES(2299, 137, 'COL', 'Colima', 'russian');
INSERT INTO emkt_regions VALUES(2300, 137, 'DIF', 'Distrito Federal', 'russian');
INSERT INTO emkt_regions VALUES(2301, 137, 'DUR', 'Durango', 'russian');
INSERT INTO emkt_regions VALUES(2302, 137, 'GRO', 'Guerrero', 'russian');
INSERT INTO emkt_regions VALUES(2303, 137, 'GUA', 'Guanajuato', 'russian');
INSERT INTO emkt_regions VALUES(2304, 137, 'HID', 'Hidalgo', 'russian');
INSERT INTO emkt_regions VALUES(2305, 137, 'JAL', 'Jalisco', 'russian');
INSERT INTO emkt_regions VALUES(2306, 137, 'MEX', 'Mexico', 'russian');
INSERT INTO emkt_regions VALUES(2307, 137, 'MIC', 'Michoacán', 'russian');
INSERT INTO emkt_regions VALUES(2308, 137, 'MOR', 'Morelos', 'russian');
INSERT INTO emkt_regions VALUES(2309, 137, 'NAY', 'Nayarit', 'russian');
INSERT INTO emkt_regions VALUES(2310, 137, 'NLE', 'Nuevo León', 'russian');
INSERT INTO emkt_regions VALUES(2311, 137, 'OAX', 'Oaxaca', 'russian');
INSERT INTO emkt_regions VALUES(2312, 137, 'PUE', 'Puebla', 'russian');
INSERT INTO emkt_regions VALUES(2313, 137, 'QUE', 'Querétaro', 'russian');
INSERT INTO emkt_regions VALUES(2314, 137, 'ROO', 'Quintana Roo', 'russian');
INSERT INTO emkt_regions VALUES(2315, 137, 'SIN', 'Sinaloa', 'russian');
INSERT INTO emkt_regions VALUES(2316, 137, 'SLP', 'San Luis Potosí', 'russian');
INSERT INTO emkt_regions VALUES(2317, 137, 'SON', 'Sonora', 'russian');
INSERT INTO emkt_regions VALUES(2318, 137, 'TAB', 'Tabasco', 'russian');
INSERT INTO emkt_regions VALUES(2319, 137, 'TAM', 'Tamaulipas', 'russian');
INSERT INTO emkt_regions VALUES(2320, 137, 'TLA', 'Tlaxcala', 'russian');
INSERT INTO emkt_regions VALUES(2321, 137, 'VER', 'Veracruz', 'russian');
INSERT INTO emkt_regions VALUES(2322, 137, 'YUC', 'Yucatan', 'russian');
INSERT INTO emkt_regions VALUES(2323, 137, 'ZAC', 'Zacatecas', 'russian');

INSERT INTO emkt_countries VALUES (138,'Федеративные Штаты Микронезии','russian','FM','FSM','');

INSERT INTO emkt_regions VALUES(2324, 138, 'KSA', 'Kosrae', 'russian');
INSERT INTO emkt_regions VALUES(2325, 138, 'PNI', 'Pohnpei', 'russian');
INSERT INTO emkt_regions VALUES(2326, 138, 'TRK', 'Chuuk', 'russian');
INSERT INTO emkt_regions VALUES(2327, 138, 'YAP', 'Yap', 'russian');

INSERT INTO emkt_countries VALUES (139,'Молдавия','russian','MD','MDA','');

INSERT INTO emkt_regions VALUES(2328, 139, 'BA', 'Bălţi', 'russian');
INSERT INTO emkt_regions VALUES(2329, 139, 'CA', 'Cahul', 'russian');
INSERT INTO emkt_regions VALUES(2330, 139, 'CU', 'Chişinău', 'russian');
INSERT INTO emkt_regions VALUES(2331, 139, 'ED', 'Edineţ', 'russian');
INSERT INTO emkt_regions VALUES(2332, 139, 'GA', 'Găgăuzia', 'russian');
INSERT INTO emkt_regions VALUES(2333, 139, 'LA', 'Lăpuşna', 'russian');
INSERT INTO emkt_regions VALUES(2334, 139, 'OR', 'Orhei', 'russian');
INSERT INTO emkt_regions VALUES(2335, 139, 'SN', 'Stânga Nistrului', 'russian');
INSERT INTO emkt_regions VALUES(2336, 139, 'SO', 'Soroca', 'russian');
INSERT INTO emkt_regions VALUES(2337, 139, 'TI', 'Tighina', 'russian');
INSERT INTO emkt_regions VALUES(2338, 139, 'UN', 'Ungheni', 'russian');

INSERT INTO emkt_countries VALUES (140,'Монако','russian','MC','MCO','');

INSERT INTO emkt_regions VALUES(2339, 140, 'MC', 'Monte Carlo', 'russian');
INSERT INTO emkt_regions VALUES(2340, 140, 'LR', 'La Rousse', 'russian');
INSERT INTO emkt_regions VALUES(2341, 140, 'LA', 'Larvotto', 'russian');
INSERT INTO emkt_regions VALUES(2342, 140, 'MV', 'Monaco Ville', 'russian');
INSERT INTO emkt_regions VALUES(2343, 140, 'SM', 'Saint Michel', 'russian');
INSERT INTO emkt_regions VALUES(2344, 140, 'CO', 'Condamine', 'russian');
INSERT INTO emkt_regions VALUES(2345, 140, 'LC', 'La Colle', 'russian');
INSERT INTO emkt_regions VALUES(2346, 140, 'RE', 'Les Révoires', 'russian');
INSERT INTO emkt_regions VALUES(2347, 140, 'MO', 'Moneghetti', 'russian');
INSERT INTO emkt_regions VALUES(2348, 140, 'FV', 'Fontvieille', 'russian');

INSERT INTO emkt_countries VALUES (141,'Монголия','russian','MN','MNG','');

INSERT INTO emkt_regions VALUES(2349, 141, '1', 'Улаанбаатар', 'russian');
INSERT INTO emkt_regions VALUES(2350, 141, '035', 'Орхон аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2351, 141, '037', 'Дархан-Уул аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2352, 141, '039', 'Хэнтий аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2353, 141, '041', 'Хөвсгөл аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2354, 141, '043', 'Ховд аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2355, 141, '046', 'Увс аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2356, 141, '047', 'Төв аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2357, 141, '049', 'Сэлэнгэ аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2358, 141, '051', 'Сүхбаатар аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2359, 141, '053', 'Өмнөговь аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2360, 141, '055', 'Өвөрхангай аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2361, 141, '057', 'Завхан аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2362, 141, '059', 'Дундговь аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2363, 141, '061', 'Дорнод аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2364, 141, '063', 'Дорноговь аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2365, 141, '064', 'Говьсүмбэр аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2366, 141, '065', 'Говь-Алтай аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2367, 141, '067', 'Булган аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2368, 141, '069', 'Баянхонгор аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2369, 141, '071', 'Баян Өлгий аймаг', 'russian');
INSERT INTO emkt_regions VALUES(2370, 141, '073', 'Архангай аймаг', 'russian');

INSERT INTO emkt_countries VALUES (142,'Монтсеррат','russian','MS','MSR','');

INSERT INTO emkt_regions VALUES(2371, 142, 'A', 'Saint Anthony', 'russian');
INSERT INTO emkt_regions VALUES(2372, 142, 'G', 'Saint Georges', 'russian');
INSERT INTO emkt_regions VALUES(2373, 142, 'P', 'Saint Peter', 'russian');

INSERT INTO emkt_countries VALUES (143,'Марокко','russian','MA','MAR','');

INSERT INTO emkt_regions VALUES(4266, 143, 'NOCODE', 'Morocco', 'russian');

INSERT INTO emkt_countries VALUES (144,'Мозамбик','russian','MZ','MOZ','');

INSERT INTO emkt_regions VALUES(2374, 144, 'A', 'Niassa', 'russian');
INSERT INTO emkt_regions VALUES(2375, 144, 'B', 'Manica', 'russian');
INSERT INTO emkt_regions VALUES(2376, 144, 'G', 'Gaza', 'russian');
INSERT INTO emkt_regions VALUES(2377, 144, 'I', 'Inhambane', 'russian');
INSERT INTO emkt_regions VALUES(2378, 144, 'L', 'Maputo', 'russian');
INSERT INTO emkt_regions VALUES(2379, 144, 'MPM', 'Maputo cidade', 'russian');
INSERT INTO emkt_regions VALUES(2380, 144, 'N', 'Nampula', 'russian');
INSERT INTO emkt_regions VALUES(2381, 144, 'P', 'Cabo Delgado', 'russian');
INSERT INTO emkt_regions VALUES(2382, 144, 'Q', 'Zambézia', 'russian');
INSERT INTO emkt_regions VALUES(2383, 144, 'S', 'Sofala', 'russian');
INSERT INTO emkt_regions VALUES(2384, 144, 'T', 'Tete', 'russian');

INSERT INTO emkt_countries VALUES (145,'Мьянма','russian','MM','MMR','');

INSERT INTO emkt_regions VALUES(2385, 145, 'AY', 'ဧရာ၀တီတိုင္‌း', 'russian');
INSERT INTO emkt_regions VALUES(2386, 145, 'BG', 'ပဲခူးတုိင္‌း', 'russian');
INSERT INTO emkt_regions VALUES(2387, 145, 'MG', 'မကေ္ဝးတိုင္‌း', 'russian');
INSERT INTO emkt_regions VALUES(2388, 145, 'MD', 'မန္တလေးတုိင္‌း', 'russian');
INSERT INTO emkt_regions VALUES(2389, 145, 'SG', 'စစ္‌ကုိင္‌း‌တုိင္‌း', 'russian');
INSERT INTO emkt_regions VALUES(2390, 145, 'TN', 'တနင္သာရိတုိင္‌း', 'russian');
INSERT INTO emkt_regions VALUES(2391, 145, 'YG', 'ရန္‌ကုန္‌တုိင္‌း', 'russian');
INSERT INTO emkt_regions VALUES(2392, 145, 'CH', 'ခ္ယင္‌းပ္ရည္‌နယ္‌', 'russian');
INSERT INTO emkt_regions VALUES(2393, 145, 'KC', 'ကခ္ယင္‌ပ္ရည္‌နယ္‌', 'russian');
INSERT INTO emkt_regions VALUES(2394, 145, 'KH', 'ကယား‌ပ္ရည္‌နယ္‌', 'russian');
INSERT INTO emkt_regions VALUES(2395, 145, 'KN', 'ကရင္‌‌ပ္ရည္‌နယ္‌', 'russian');
INSERT INTO emkt_regions VALUES(2396, 145, 'MN', 'မ္ဝန္‌ပ္ရည္‌နယ္‌', 'russian');
INSERT INTO emkt_regions VALUES(2397, 145, 'RK', 'ရခုိင္‌ပ္ရည္‌နယ္‌', 'russian');
INSERT INTO emkt_regions VALUES(2398, 145, 'SH', 'ရုမ္‌းပ္ရည္‌နယ္‌', 'russian');

INSERT INTO emkt_countries VALUES (146,'Намибия','russian','NA','NAM','');

INSERT INTO emkt_regions VALUES(2399, 146, 'CA', 'Caprivi', 'russian');
INSERT INTO emkt_regions VALUES(2400, 146, 'ER', 'Erongo', 'russian');
INSERT INTO emkt_regions VALUES(2401, 146, 'HA', 'Hardap', 'russian');
INSERT INTO emkt_regions VALUES(2402, 146, 'KA', 'Karas', 'russian');
INSERT INTO emkt_regions VALUES(2403, 146, 'KH', 'Khomas', 'russian');
INSERT INTO emkt_regions VALUES(2404, 146, 'KU', 'Kunene', 'russian');
INSERT INTO emkt_regions VALUES(2405, 146, 'OD', 'Otjozondjupa', 'russian');
INSERT INTO emkt_regions VALUES(2406, 146, 'OH', 'Omaheke', 'russian');
INSERT INTO emkt_regions VALUES(2407, 146, 'OK', 'Okavango', 'russian');
INSERT INTO emkt_regions VALUES(2408, 146, 'ON', 'Oshana', 'russian');
INSERT INTO emkt_regions VALUES(2409, 146, 'OS', 'Omusati', 'russian');
INSERT INTO emkt_regions VALUES(2410, 146, 'OT', 'Oshikoto', 'russian');
INSERT INTO emkt_regions VALUES(2411, 146, 'OW', 'Ohangwena', 'russian');

INSERT INTO emkt_countries VALUES (147,'Науру','russian','NR','NRU','');

INSERT INTO emkt_regions VALUES(2412, 147, 'AO', 'Aiwo', 'russian');
INSERT INTO emkt_regions VALUES(2413, 147, 'AA', 'Anabar', 'russian');
INSERT INTO emkt_regions VALUES(2414, 147, 'AT', 'Anetan', 'russian');
INSERT INTO emkt_regions VALUES(2415, 147, 'AI', 'Anibare', 'russian');
INSERT INTO emkt_regions VALUES(2416, 147, 'BA', 'Baiti', 'russian');
INSERT INTO emkt_regions VALUES(2417, 147, 'BO', 'Boe', 'russian');
INSERT INTO emkt_regions VALUES(2418, 147, 'BU', 'Buada', 'russian');
INSERT INTO emkt_regions VALUES(2419, 147, 'DE', 'Denigomodu', 'russian');
INSERT INTO emkt_regions VALUES(2420, 147, 'EW', 'Ewa', 'russian');
INSERT INTO emkt_regions VALUES(2421, 147, 'IJ', 'Ijuw', 'russian');
INSERT INTO emkt_regions VALUES(2422, 147, 'ME', 'Meneng', 'russian');
INSERT INTO emkt_regions VALUES(2423, 147, 'NI', 'Nibok', 'russian');
INSERT INTO emkt_regions VALUES(2424, 147, 'UA', 'Uaboe', 'russian');
INSERT INTO emkt_regions VALUES(2425, 147, 'YA', 'Yaren', 'russian');

INSERT INTO emkt_countries VALUES (148,'Непал','russian','NP','NPL','');

INSERT INTO emkt_regions VALUES(2426, 148, 'BA', 'Bagmati', 'russian');
INSERT INTO emkt_regions VALUES(2427, 148, 'BH', 'Bheri', 'russian');
INSERT INTO emkt_regions VALUES(2428, 148, 'DH', 'Dhawalagiri', 'russian');
INSERT INTO emkt_regions VALUES(2429, 148, 'GA', 'Gandaki', 'russian');
INSERT INTO emkt_regions VALUES(2430, 148, 'JA', 'Janakpur', 'russian');
INSERT INTO emkt_regions VALUES(2431, 148, 'KA', 'Karnali', 'russian');
INSERT INTO emkt_regions VALUES(2432, 148, 'KO', 'Kosi', 'russian');
INSERT INTO emkt_regions VALUES(2433, 148, 'LU', 'Lumbini', 'russian');
INSERT INTO emkt_regions VALUES(2434, 148, 'MA', 'Mahakali', 'russian');
INSERT INTO emkt_regions VALUES(2435, 148, 'ME', 'Mechi', 'russian');
INSERT INTO emkt_regions VALUES(2436, 148, 'NA', 'Narayani', 'russian');
INSERT INTO emkt_regions VALUES(2437, 148, 'RA', 'Rapti', 'russian');
INSERT INTO emkt_regions VALUES(2438, 148, 'SA', 'Sagarmatha', 'russian');
INSERT INTO emkt_regions VALUES(2439, 148, 'SE', 'Seti', 'russian');

INSERT INTO emkt_countries VALUES (149,'Нидерланды','russian','NL','NLD','');

INSERT INTO emkt_regions VALUES(2440, 149, 'DR', 'Drenthe', 'russian');
INSERT INTO emkt_regions VALUES(2441, 149, 'FL', 'Flevoland', 'russian');
INSERT INTO emkt_regions VALUES(2442, 149, 'FR', 'Friesland', 'russian');
INSERT INTO emkt_regions VALUES(2443, 149, 'GE', 'Gelderland', 'russian');
INSERT INTO emkt_regions VALUES(2444, 149, 'GR', 'Groningen', 'russian');
INSERT INTO emkt_regions VALUES(2445, 149, 'LI', 'Limburg', 'russian');
INSERT INTO emkt_regions VALUES(2446, 149, 'NB', 'Noord-Brabant', 'russian');
INSERT INTO emkt_regions VALUES(2447, 149, 'NH', 'Noord-Holland', 'russian');
INSERT INTO emkt_regions VALUES(2448, 149, 'OV', 'Overijssel', 'russian');
INSERT INTO emkt_regions VALUES(2449, 149, 'UT', 'Utrecht', 'russian');
INSERT INTO emkt_regions VALUES(2450, 149, 'ZE', 'Zeeland', 'russian');
INSERT INTO emkt_regions VALUES(2451, 149, 'ZH', 'Zuid-Holland', 'russian');

INSERT INTO emkt_countries VALUES (150,'Нидерландские Антильские острова','russian','AN','ANT','');

INSERT INTO emkt_regions VALUES(4267, 150, 'NOCODE', 'Netherlands Antilles', 'russian');

INSERT INTO emkt_countries VALUES (151,'Новая Каледония','russian','NC','NCL','');

INSERT INTO emkt_regions VALUES(2452, 151, 'L', 'Province des Îles', 'russian');
INSERT INTO emkt_regions VALUES(2453, 151, 'N', 'Province Nord', 'russian');
INSERT INTO emkt_regions VALUES(2454, 151, 'S', 'Province Sud', 'russian');

INSERT INTO emkt_countries VALUES (152,'Новая Зеландия','russian','NZ','NZL','');

INSERT INTO emkt_regions VALUES(2455, 152, 'AUK', 'Auckland', 'russian');
INSERT INTO emkt_regions VALUES(2456, 152, 'BOP', 'Bay of Plenty', 'russian');
INSERT INTO emkt_regions VALUES(2457, 152, 'CAN', 'Canterbury', 'russian');
INSERT INTO emkt_regions VALUES(2458, 152, 'GIS', 'Gisborne', 'russian');
INSERT INTO emkt_regions VALUES(2459, 152, 'HKB', 'Hawke\'s Bay', 'russian');
INSERT INTO emkt_regions VALUES(2460, 152, 'MBH', 'Marlborough', 'russian');
INSERT INTO emkt_regions VALUES(2461, 152, 'MWT', 'Manawatu-Wanganui', 'russian');
INSERT INTO emkt_regions VALUES(2462, 152, 'NSN', 'Nelson', 'russian');
INSERT INTO emkt_regions VALUES(2463, 152, 'NTL', 'Northland', 'russian');
INSERT INTO emkt_regions VALUES(2464, 152, 'OTA', 'Otago', 'russian');
INSERT INTO emkt_regions VALUES(2465, 152, 'STL', 'Southland', 'russian');
INSERT INTO emkt_regions VALUES(2466, 152, 'TAS', 'Tasman', 'russian');
INSERT INTO emkt_regions VALUES(2467, 152, 'TKI', 'Taranaki', 'russian');
INSERT INTO emkt_regions VALUES(2468, 152, 'WGN', 'Wellington', 'russian');
INSERT INTO emkt_regions VALUES(2469, 152, 'WKO', 'Waikato', 'russian');
INSERT INTO emkt_regions VALUES(2470, 152, 'WTC', 'West Coast', 'russian');

INSERT INTO emkt_countries VALUES (153,'Никарагуа','russian','NI','NIC','');

INSERT INTO emkt_regions VALUES(2471, 153, 'AN', 'Atlántico Norte', 'russian');
INSERT INTO emkt_regions VALUES(2472, 153, 'AS', 'Atlántico Sur', 'russian');
INSERT INTO emkt_regions VALUES(2473, 153, 'BO', 'Boaco', 'russian');
INSERT INTO emkt_regions VALUES(2474, 153, 'CA', 'Carazo', 'russian');
INSERT INTO emkt_regions VALUES(2475, 153, 'CI', 'Chinandega', 'russian');
INSERT INTO emkt_regions VALUES(2476, 153, 'CO', 'Chontales', 'russian');
INSERT INTO emkt_regions VALUES(2477, 153, 'ES', 'Estelí', 'russian');
INSERT INTO emkt_regions VALUES(2478, 153, 'GR', 'Granada', 'russian');
INSERT INTO emkt_regions VALUES(2479, 153, 'JI', 'Jinotega', 'russian');
INSERT INTO emkt_regions VALUES(2480, 153, 'LE', 'León', 'russian');
INSERT INTO emkt_regions VALUES(2481, 153, 'MD', 'Madriz', 'russian');
INSERT INTO emkt_regions VALUES(2482, 153, 'MN', 'Managua', 'russian');
INSERT INTO emkt_regions VALUES(2483, 153, 'MS', 'Masaya', 'russian');
INSERT INTO emkt_regions VALUES(2484, 153, 'MT', 'Matagalpa', 'russian');
INSERT INTO emkt_regions VALUES(2485, 153, 'NS', 'Nueva Segovia', 'russian');
INSERT INTO emkt_regions VALUES(2486, 153, 'RI', 'Rivas', 'russian');
INSERT INTO emkt_regions VALUES(2487, 153, 'SJ', 'Río San Juan', 'russian');

INSERT INTO emkt_countries VALUES (154,'Республика Нигер','russian','NE','NER','');

INSERT INTO emkt_regions VALUES(2488, 154, '1', 'Agadez', 'russian');
INSERT INTO emkt_regions VALUES(2489, 154, '2', 'Daffa', 'russian');
INSERT INTO emkt_regions VALUES(2490, 154, '3', 'Dosso', 'russian');
INSERT INTO emkt_regions VALUES(2491, 154, '4', 'Maradi', 'russian');
INSERT INTO emkt_regions VALUES(2492, 154, '5', 'Tahoua', 'russian');
INSERT INTO emkt_regions VALUES(2493, 154, '6', 'Tillabéry', 'russian');
INSERT INTO emkt_regions VALUES(2494, 154, '7', 'Zinder', 'russian');
INSERT INTO emkt_regions VALUES(2495, 154, '8', 'Niamey', 'russian');

INSERT INTO emkt_countries VALUES (155,'Нигерия','russian','NG','NGA','');

INSERT INTO emkt_regions VALUES(2496, 155, 'AB', 'Abia State', 'russian');
INSERT INTO emkt_regions VALUES(2497, 155, 'AD', 'Adamawa State', 'russian');
INSERT INTO emkt_regions VALUES(2498, 155, 'AK', 'Akwa Ibom State', 'russian');
INSERT INTO emkt_regions VALUES(2499, 155, 'AN', 'Anambra State', 'russian');
INSERT INTO emkt_regions VALUES(2500, 155, 'BA', 'Bauchi State', 'russian');
INSERT INTO emkt_regions VALUES(2501, 155, 'BE', 'Benue State', 'russian');
INSERT INTO emkt_regions VALUES(2502, 155, 'BO', 'Borno State', 'russian');
INSERT INTO emkt_regions VALUES(2503, 155, 'BY', 'Bayelsa State', 'russian');
INSERT INTO emkt_regions VALUES(2504, 155, 'CR', 'Cross River State', 'russian');
INSERT INTO emkt_regions VALUES(2505, 155, 'DE', 'Delta State', 'russian');
INSERT INTO emkt_regions VALUES(2506, 155, 'EB', 'Ebonyi State', 'russian');
INSERT INTO emkt_regions VALUES(2507, 155, 'ED', 'Edo State', 'russian');
INSERT INTO emkt_regions VALUES(2508, 155, 'EK', 'Ekiti State', 'russian');
INSERT INTO emkt_regions VALUES(2509, 155, 'EN', 'Enugu State', 'russian');
INSERT INTO emkt_regions VALUES(2510, 155, 'GO', 'Gombe State', 'russian');
INSERT INTO emkt_regions VALUES(2511, 155, 'IM', 'Imo State', 'russian');
INSERT INTO emkt_regions VALUES(2512, 155, 'JI', 'Jigawa State', 'russian');
INSERT INTO emkt_regions VALUES(2513, 155, 'KB', 'Kebbi State', 'russian');
INSERT INTO emkt_regions VALUES(2514, 155, 'KD', 'Kaduna State', 'russian');
INSERT INTO emkt_regions VALUES(2515, 155, 'KN', 'Kano State', 'russian');
INSERT INTO emkt_regions VALUES(2516, 155, 'KO', 'Kogi State', 'russian');
INSERT INTO emkt_regions VALUES(2517, 155, 'KT', 'Katsina State', 'russian');
INSERT INTO emkt_regions VALUES(2518, 155, 'KW', 'Kwara State', 'russian');
INSERT INTO emkt_regions VALUES(2519, 155, 'LA', 'Lagos State', 'russian');
INSERT INTO emkt_regions VALUES(2520, 155, 'NA', 'Nassarawa State', 'russian');
INSERT INTO emkt_regions VALUES(2521, 155, 'NI', 'Niger State', 'russian');
INSERT INTO emkt_regions VALUES(2522, 155, 'OG', 'Ogun State', 'russian');
INSERT INTO emkt_regions VALUES(2523, 155, 'ON', 'Ondo State', 'russian');
INSERT INTO emkt_regions VALUES(2524, 155, 'OS', 'Osun State', 'russian');
INSERT INTO emkt_regions VALUES(2525, 155, 'OY', 'Oyo State', 'russian');
INSERT INTO emkt_regions VALUES(2526, 155, 'PL', 'Plateau State', 'russian');
INSERT INTO emkt_regions VALUES(2527, 155, 'RI', 'Rivers State', 'russian');
INSERT INTO emkt_regions VALUES(2528, 155, 'SO', 'Sokoto State', 'russian');
INSERT INTO emkt_regions VALUES(2529, 155, 'TA', 'Taraba State', 'russian');
INSERT INTO emkt_regions VALUES(2530, 155, 'ZA', 'Zamfara State', 'russian');

INSERT INTO emkt_countries VALUES (156,'Ниуэ','russian','NU','NIU','');

INSERT INTO emkt_regions VALUES(4268, 156, 'NOCODE', 'Niue', 'russian');

INSERT INTO emkt_countries VALUES (157,'Остров Норфолк','russian','NF','NFK','');

INSERT INTO emkt_regions VALUES(4269, 157, 'NOCODE', 'Norfolk Island', 'russian');

INSERT INTO emkt_countries VALUES (158,'Северные Марианские Острова','russian','MP','MNP','');

INSERT INTO emkt_regions VALUES(2531, 158, 'N', 'Northern Islands', 'russian');
INSERT INTO emkt_regions VALUES(2532, 158, 'R', 'Rota', 'russian');
INSERT INTO emkt_regions VALUES(2533, 158, 'S', 'Saipan', 'russian');
INSERT INTO emkt_regions VALUES(2534, 158, 'T', 'Tinian', 'russian');

INSERT INTO emkt_countries VALUES (159,'Норвегия','russian','NO','NOR','');

INSERT INTO emkt_regions VALUES(2535, 159, '01', 'Østfold fylke', 'russian');
INSERT INTO emkt_regions VALUES(2536, 159, '02', 'Akershus fylke', 'russian');
INSERT INTO emkt_regions VALUES(2537, 159, '03', 'Oslo fylke', 'russian');
INSERT INTO emkt_regions VALUES(2538, 159, '04', 'Hedmark fylke', 'russian');
INSERT INTO emkt_regions VALUES(2539, 159, '05', 'Oppland fylke', 'russian');
INSERT INTO emkt_regions VALUES(2540, 159, '06', 'Buskerud fylke', 'russian');
INSERT INTO emkt_regions VALUES(2541, 159, '07', 'Vestfold fylke', 'russian');
INSERT INTO emkt_regions VALUES(2542, 159, '08', 'Telemark fylke', 'russian');
INSERT INTO emkt_regions VALUES(2543, 159, '09', 'Aust-Agder fylke', 'russian');
INSERT INTO emkt_regions VALUES(2544, 159, '10', 'Vest-Agder fylke', 'russian');
INSERT INTO emkt_regions VALUES(2545, 159, '11', 'Rogaland fylke', 'russian');
INSERT INTO emkt_regions VALUES(2546, 159, '12', 'Hordaland fylke', 'russian');
INSERT INTO emkt_regions VALUES(2547, 159, '14', 'Sogn og Fjordane fylke', 'russian');
INSERT INTO emkt_regions VALUES(2548, 159, '15', 'Møre og Romsdal fylke', 'russian');
INSERT INTO emkt_regions VALUES(2549, 159, '16', 'Sør-Trøndelag fylke', 'russian');
INSERT INTO emkt_regions VALUES(2550, 159, '17', 'Nord-Trøndelag fylke', 'russian');
INSERT INTO emkt_regions VALUES(2551, 159, '18', 'Nordland fylke', 'russian');
INSERT INTO emkt_regions VALUES(2552, 159, '19', 'Troms fylke', 'russian');
INSERT INTO emkt_regions VALUES(2553, 159, '20', 'Finnmark fylke', 'russian');

INSERT INTO emkt_countries VALUES (160,'Оман','russian','OM','OMN','');

INSERT INTO emkt_regions VALUES(2554, 160, 'BA', 'الباطنة', 'russian');
INSERT INTO emkt_regions VALUES(2555, 160, 'DA', 'الداخلية', 'russian');
INSERT INTO emkt_regions VALUES(2556, 160, 'DH', 'ظفار', 'russian');
INSERT INTO emkt_regions VALUES(2557, 160, 'MA', 'مسقط', 'russian');
INSERT INTO emkt_regions VALUES(2558, 160, 'MU', 'مسندم', 'russian');
INSERT INTO emkt_regions VALUES(2559, 160, 'SH', 'الشرقية', 'russian');
INSERT INTO emkt_regions VALUES(2560, 160, 'WU', 'الوسطى', 'russian');
INSERT INTO emkt_regions VALUES(2561, 160, 'ZA', 'الظاهرة', 'russian');

INSERT INTO emkt_countries VALUES (161,'Пакистан','russian','PK','PAK','');

INSERT INTO emkt_regions VALUES(2562, 161, 'BA', 'بلوچستان', 'russian');
INSERT INTO emkt_regions VALUES(2563, 161, 'IS', 'وفاقی دارالحکومت', 'russian');
INSERT INTO emkt_regions VALUES(2564, 161, 'JK', 'آزاد کشمیر', 'russian');
INSERT INTO emkt_regions VALUES(2565, 161, 'NA', 'شمالی علاقہ جات', 'russian');
INSERT INTO emkt_regions VALUES(2566, 161, 'NW', 'شمال مغربی سرحدی صوبہ', 'russian');
INSERT INTO emkt_regions VALUES(2567, 161, 'PB', 'پنجاب', 'russian');
INSERT INTO emkt_regions VALUES(2568, 161, 'SD', 'سندھ', 'russian');
INSERT INTO emkt_regions VALUES(2569, 161, 'TA', 'وفاقی قبائلی علاقہ جات', 'russian');

INSERT INTO emkt_countries VALUES (162,'Палау','russian','PW','PLW','');

INSERT INTO emkt_regions VALUES(2570, 162, 'AM', 'Aimeliik', 'russian');
INSERT INTO emkt_regions VALUES(2571, 162, 'AR', 'Airai', 'russian');
INSERT INTO emkt_regions VALUES(2572, 162, 'AN', 'Angaur', 'russian');
INSERT INTO emkt_regions VALUES(2573, 162, 'HA', 'Hatohobei', 'russian');
INSERT INTO emkt_regions VALUES(2574, 162, 'KA', 'Kayangel', 'russian');
INSERT INTO emkt_regions VALUES(2575, 162, 'KO', 'Koror', 'russian');
INSERT INTO emkt_regions VALUES(2576, 162, 'ME', 'Melekeok', 'russian');
INSERT INTO emkt_regions VALUES(2577, 162, 'NA', 'Ngaraard', 'russian');
INSERT INTO emkt_regions VALUES(2578, 162, 'NG', 'Ngarchelong', 'russian');
INSERT INTO emkt_regions VALUES(2579, 162, 'ND', 'Ngardmau', 'russian');
INSERT INTO emkt_regions VALUES(2580, 162, 'NT', 'Ngatpang', 'russian');
INSERT INTO emkt_regions VALUES(2581, 162, 'NC', 'Ngchesar', 'russian');
INSERT INTO emkt_regions VALUES(2582, 162, 'NR', 'Ngeremlengui', 'russian');
INSERT INTO emkt_regions VALUES(2583, 162, 'NW', 'Ngiwal', 'russian');
INSERT INTO emkt_regions VALUES(2584, 162, 'PE', 'Peleliu', 'russian');
INSERT INTO emkt_regions VALUES(2585, 162, 'SO', 'Sonsorol', 'russian');

INSERT INTO emkt_countries VALUES (163,'Панама','russian','PA','PAN','');

INSERT INTO emkt_regions VALUES(2586, 163, '1', 'Bocas del Toro', 'russian');
INSERT INTO emkt_regions VALUES(2587, 163, '2', 'Coclé', 'russian');
INSERT INTO emkt_regions VALUES(2588, 163, '3', 'Colón', 'russian');
INSERT INTO emkt_regions VALUES(2589, 163, '4', 'Chiriquí', 'russian');
INSERT INTO emkt_regions VALUES(2590, 163, '5', 'Darién', 'russian');
INSERT INTO emkt_regions VALUES(2591, 163, '6', 'Herrera', 'russian');
INSERT INTO emkt_regions VALUES(2592, 163, '7', 'Los Santos', 'russian');
INSERT INTO emkt_regions VALUES(2593, 163, '8', 'Panamá', 'russian');
INSERT INTO emkt_regions VALUES(2594, 163, '9', 'Veraguas', 'russian');
INSERT INTO emkt_regions VALUES(2595, 163, 'Q', 'Kuna Yala', 'russian');

INSERT INTO emkt_countries VALUES (164,'Папуа-Новая Гвинея','russian','PG','PNG','');

INSERT INTO emkt_regions VALUES(2596, 164, 'CPK', 'Chimbu', 'russian');
INSERT INTO emkt_regions VALUES(2597, 164, 'CPM', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(2598, 164, 'EBR', 'East New Britain', 'russian');
INSERT INTO emkt_regions VALUES(2599, 164, 'EHG', 'Eastern Highlands', 'russian');
INSERT INTO emkt_regions VALUES(2600, 164, 'EPW', 'Enga', 'russian');
INSERT INTO emkt_regions VALUES(2601, 164, 'ESW', 'East Sepik', 'russian');
INSERT INTO emkt_regions VALUES(2602, 164, 'GPK', 'Gulf', 'russian');
INSERT INTO emkt_regions VALUES(2603, 164, 'MBA', 'Milne Bay', 'russian');
INSERT INTO emkt_regions VALUES(2604, 164, 'MPL', 'Morobe', 'russian');
INSERT INTO emkt_regions VALUES(2605, 164, 'MPM', 'Madang', 'russian');
INSERT INTO emkt_regions VALUES(2606, 164, 'MRL', 'Manus', 'russian');
INSERT INTO emkt_regions VALUES(2607, 164, 'NCD', 'National Capital District', 'russian');
INSERT INTO emkt_regions VALUES(2608, 164, 'NIK', 'New Ireland', 'russian');
INSERT INTO emkt_regions VALUES(2609, 164, 'NPP', 'Northern', 'russian');
INSERT INTO emkt_regions VALUES(2610, 164, 'NSA', 'North Solomons', 'russian');
INSERT INTO emkt_regions VALUES(2611, 164, 'SAN', 'Sandaun', 'russian');
INSERT INTO emkt_regions VALUES(2612, 164, 'SHM', 'Southern Highlands', 'russian');
INSERT INTO emkt_regions VALUES(2613, 164, 'WBK', 'West New Britain', 'russian');
INSERT INTO emkt_regions VALUES(2614, 164, 'WHM', 'Western Highlands', 'russian');
INSERT INTO emkt_regions VALUES(2615, 164, 'WPD', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (165,'Парагвай','russian','PY','PRY','');

INSERT INTO emkt_regions VALUES(2616, 165, '1', 'Concepción', 'russian');
INSERT INTO emkt_regions VALUES(2617, 165, '2', 'San Pedro', 'russian');
INSERT INTO emkt_regions VALUES(2618, 165, '3', 'Cordillera', 'russian');
INSERT INTO emkt_regions VALUES(2619, 165, '4', 'Guairá', 'russian');
INSERT INTO emkt_regions VALUES(2620, 165, '5', 'Caaguazú', 'russian');
INSERT INTO emkt_regions VALUES(2621, 165, '6', 'Caazapá', 'russian');
INSERT INTO emkt_regions VALUES(2622, 165, '7', 'Itapúa', 'russian');
INSERT INTO emkt_regions VALUES(2623, 165, '8', 'Misiones', 'russian');
INSERT INTO emkt_regions VALUES(2624, 165, '9', 'Paraguarí', 'russian');
INSERT INTO emkt_regions VALUES(2625, 165, '10', 'Alto Paraná', 'russian');
INSERT INTO emkt_regions VALUES(2626, 165, '11', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(2627, 165, '12', 'Ñeembucú', 'russian');
INSERT INTO emkt_regions VALUES(2628, 165, '13', 'Amambay', 'russian');
INSERT INTO emkt_regions VALUES(2629, 165, '14', 'Canindeyú', 'russian');
INSERT INTO emkt_regions VALUES(2630, 165, '15', 'Presidente Hayes', 'russian');
INSERT INTO emkt_regions VALUES(2631, 165, '16', 'Alto Paraguay', 'russian');
INSERT INTO emkt_regions VALUES(2632, 165, '19', 'Boquerón', 'russian');
INSERT INTO emkt_regions VALUES(2633, 165, 'ASU', 'Asunción', 'russian');

INSERT INTO emkt_countries VALUES (166,'Перу','russian','PE','PER','');

INSERT INTO emkt_regions VALUES(2634, 166, 'AMA', 'Amazonas', 'russian');
INSERT INTO emkt_regions VALUES(2635, 166, 'ANC', 'Ancash', 'russian');
INSERT INTO emkt_regions VALUES(2636, 166, 'APU', 'Apurímac', 'russian');
INSERT INTO emkt_regions VALUES(2637, 166, 'ARE', 'Arequipa', 'russian');
INSERT INTO emkt_regions VALUES(2638, 166, 'AYA', 'Ayacucho', 'russian');
INSERT INTO emkt_regions VALUES(2639, 166, 'CAJ', 'Cajamarca', 'russian');
INSERT INTO emkt_regions VALUES(2640, 166, 'CAL', 'Callao', 'russian');
INSERT INTO emkt_regions VALUES(2641, 166, 'CUS', 'Cuzco', 'russian');
INSERT INTO emkt_regions VALUES(2642, 166, 'HUC', 'Huánuco', 'russian');
INSERT INTO emkt_regions VALUES(2643, 166, 'HUV', 'Huancavelica', 'russian');
INSERT INTO emkt_regions VALUES(2644, 166, 'ICA', 'Ica', 'russian');
INSERT INTO emkt_regions VALUES(2645, 166, 'JUN', 'Junín', 'russian');
INSERT INTO emkt_regions VALUES(2646, 166, 'LAL', 'La Libertad', 'russian');
INSERT INTO emkt_regions VALUES(2647, 166, 'LAM', 'Lambayeque', 'russian');
INSERT INTO emkt_regions VALUES(2648, 166, 'LIM', 'Lima', 'russian');
INSERT INTO emkt_regions VALUES(2649, 166, 'LOR', 'Loreto', 'russian');
INSERT INTO emkt_regions VALUES(2650, 166, 'MDD', 'Madre de Dios', 'russian');
INSERT INTO emkt_regions VALUES(2651, 166, 'MOQ', 'Moquegua', 'russian');
INSERT INTO emkt_regions VALUES(2652, 166, 'PAS', 'Pasco', 'russian');
INSERT INTO emkt_regions VALUES(2653, 166, 'PIU', 'Piura', 'russian');
INSERT INTO emkt_regions VALUES(2654, 166, 'PUN', 'Puno', 'russian');
INSERT INTO emkt_regions VALUES(2655, 166, 'SAM', 'San Martín', 'russian');
INSERT INTO emkt_regions VALUES(2656, 166, 'TAC', 'Tacna', 'russian');
INSERT INTO emkt_regions VALUES(2657, 166, 'TUM', 'Tumbes', 'russian');
INSERT INTO emkt_regions VALUES(2658, 166, 'UCA', 'Ucayali', 'russian');

INSERT INTO emkt_countries VALUES (167,'Филиппины','russian','PH','PHL','');

INSERT INTO emkt_regions VALUES(2659, 167, 'ABR', 'Abra', 'russian');
INSERT INTO emkt_regions VALUES(2660, 167, 'AGN', 'Agusan del Norte', 'russian');
INSERT INTO emkt_regions VALUES(2661, 167, 'AGS', 'Agusan del Sur', 'russian');
INSERT INTO emkt_regions VALUES(2662, 167, 'AKL', 'Aklan', 'russian');
INSERT INTO emkt_regions VALUES(2663, 167, 'ALB', 'Albay', 'russian');
INSERT INTO emkt_regions VALUES(2664, 167, 'ANT', 'Antique', 'russian');
INSERT INTO emkt_regions VALUES(2665, 167, 'APA', 'Apayao', 'russian');
INSERT INTO emkt_regions VALUES(2666, 167, 'AUR', 'Aurora', 'russian');
INSERT INTO emkt_regions VALUES(2667, 167, 'BAN', 'Bataan', 'russian');
INSERT INTO emkt_regions VALUES(2668, 167, 'BAS', 'Basilan', 'russian');
INSERT INTO emkt_regions VALUES(2669, 167, 'BEN', 'Benguet', 'russian');
INSERT INTO emkt_regions VALUES(2670, 167, 'BIL', 'Biliran', 'russian');
INSERT INTO emkt_regions VALUES(2671, 167, 'BOH', 'Bohol', 'russian');
INSERT INTO emkt_regions VALUES(2672, 167, 'BTG', 'Batangas', 'russian');
INSERT INTO emkt_regions VALUES(2673, 167, 'BTN', 'Batanes', 'russian');
INSERT INTO emkt_regions VALUES(2674, 167, 'BUK', 'Bukidnon', 'russian');
INSERT INTO emkt_regions VALUES(2675, 167, 'BUL', 'Bulacan', 'russian');
INSERT INTO emkt_regions VALUES(2676, 167, 'CAG', 'Cagayan', 'russian');
INSERT INTO emkt_regions VALUES(2677, 167, 'CAM', 'Camiguin', 'russian');
INSERT INTO emkt_regions VALUES(2678, 167, 'CAN', 'Camarines Norte', 'russian');
INSERT INTO emkt_regions VALUES(2679, 167, 'CAP', 'Capiz', 'russian');
INSERT INTO emkt_regions VALUES(2680, 167, 'CAS', 'Camarines Sur', 'russian');
INSERT INTO emkt_regions VALUES(2681, 167, 'CAT', 'Catanduanes', 'russian');
INSERT INTO emkt_regions VALUES(2682, 167, 'CAV', 'Cavite', 'russian');
INSERT INTO emkt_regions VALUES(2683, 167, 'CEB', 'Cebu', 'russian');
INSERT INTO emkt_regions VALUES(2684, 167, 'COM', 'Compostela Valley', 'russian');
INSERT INTO emkt_regions VALUES(2685, 167, 'DAO', 'Davao Oriental', 'russian');
INSERT INTO emkt_regions VALUES(2686, 167, 'DAS', 'Davao del Sur', 'russian');
INSERT INTO emkt_regions VALUES(2687, 167, 'DAV', 'Davao del Norte', 'russian');
INSERT INTO emkt_regions VALUES(2688, 167, 'EAS', 'Eastern Samar', 'russian');
INSERT INTO emkt_regions VALUES(2689, 167, 'GUI', 'Guimaras', 'russian');
INSERT INTO emkt_regions VALUES(2690, 167, 'IFU', 'Ifugao', 'russian');
INSERT INTO emkt_regions VALUES(2691, 167, 'ILI', 'Iloilo', 'russian');
INSERT INTO emkt_regions VALUES(2692, 167, 'ILN', 'Ilocos Norte', 'russian');
INSERT INTO emkt_regions VALUES(2693, 167, 'ILS', 'Ilocos Sur', 'russian');
INSERT INTO emkt_regions VALUES(2694, 167, 'ISA', 'Isabela', 'russian');
INSERT INTO emkt_regions VALUES(2695, 167, 'KAL', 'Kalinga', 'russian');
INSERT INTO emkt_regions VALUES(2696, 167, 'LAG', 'Laguna', 'russian');
INSERT INTO emkt_regions VALUES(2697, 167, 'LAN', 'Lanao del Norte', 'russian');
INSERT INTO emkt_regions VALUES(2698, 167, 'LAS', 'Lanao del Sur', 'russian');
INSERT INTO emkt_regions VALUES(2699, 167, 'LEY', 'Leyte', 'russian');
INSERT INTO emkt_regions VALUES(2700, 167, 'LUN', 'La Union', 'russian');
INSERT INTO emkt_regions VALUES(2701, 167, 'MAD', 'Marinduque', 'russian');
INSERT INTO emkt_regions VALUES(2702, 167, 'MAG', 'Maguindanao', 'russian');
INSERT INTO emkt_regions VALUES(2703, 167, 'MAS', 'Masbate', 'russian');
INSERT INTO emkt_regions VALUES(2704, 167, 'MDC', 'Mindoro Occidental', 'russian');
INSERT INTO emkt_regions VALUES(2705, 167, 'MDR', 'Mindoro Oriental', 'russian');
INSERT INTO emkt_regions VALUES(2706, 167, 'MOU', 'Mountain Province', 'russian');
INSERT INTO emkt_regions VALUES(2707, 167, 'MSC', 'Misamis Occidental', 'russian');
INSERT INTO emkt_regions VALUES(2708, 167, 'MSR', 'Misamis Oriental', 'russian');
INSERT INTO emkt_regions VALUES(2709, 167, 'NCO', 'Cotabato', 'russian');
INSERT INTO emkt_regions VALUES(2710, 167, 'NSA', 'Northern Samar', 'russian');
INSERT INTO emkt_regions VALUES(2711, 167, 'NEC', 'Negros Occidental', 'russian');
INSERT INTO emkt_regions VALUES(2712, 167, 'NER', 'Negros Oriental', 'russian');
INSERT INTO emkt_regions VALUES(2713, 167, 'NUE', 'Nueva Ecija', 'russian');
INSERT INTO emkt_regions VALUES(2714, 167, 'NUV', 'Nueva Vizcaya', 'russian');
INSERT INTO emkt_regions VALUES(2715, 167, 'PAM', 'Pampanga', 'russian');
INSERT INTO emkt_regions VALUES(2716, 167, 'PAN', 'Pangasinan', 'russian');
INSERT INTO emkt_regions VALUES(2717, 167, 'PLW', 'Palawan', 'russian');
INSERT INTO emkt_regions VALUES(2718, 167, 'QUE', 'Quezon', 'russian');
INSERT INTO emkt_regions VALUES(2719, 167, 'QUI', 'Quirino', 'russian');
INSERT INTO emkt_regions VALUES(2720, 167, 'RIZ', 'Rizal', 'russian');
INSERT INTO emkt_regions VALUES(2721, 167, 'ROM', 'Romblon', 'russian');
INSERT INTO emkt_regions VALUES(2722, 167, 'SAR', 'Sarangani', 'russian');
INSERT INTO emkt_regions VALUES(2723, 167, 'SCO', 'South Cotabato', 'russian');
INSERT INTO emkt_regions VALUES(2724, 167, 'SIG', 'Siquijor', 'russian');
INSERT INTO emkt_regions VALUES(2725, 167, 'SLE', 'Southern Leyte', 'russian');
INSERT INTO emkt_regions VALUES(2726, 167, 'SLU', 'Sulu', 'russian');
INSERT INTO emkt_regions VALUES(2727, 167, 'SOR', 'Sorsogon', 'russian');
INSERT INTO emkt_regions VALUES(2728, 167, 'SUK', 'Sultan Kudarat', 'russian');
INSERT INTO emkt_regions VALUES(2729, 167, 'SUN', 'Surigao del Norte', 'russian');
INSERT INTO emkt_regions VALUES(2730, 167, 'SUR', 'Surigao del Sur', 'russian');
INSERT INTO emkt_regions VALUES(2731, 167, 'TAR', 'Tarlac', 'russian');
INSERT INTO emkt_regions VALUES(2732, 167, 'TAW', 'Tawi-Tawi', 'russian');
INSERT INTO emkt_regions VALUES(2733, 167, 'WSA', 'Samar', 'russian');
INSERT INTO emkt_regions VALUES(2734, 167, 'ZAN', 'Zamboanga del Norte', 'russian');
INSERT INTO emkt_regions VALUES(2735, 167, 'ZAS', 'Zamboanga del Sur', 'russian');
INSERT INTO emkt_regions VALUES(2736, 167, 'ZMB', 'Zambales', 'russian');
INSERT INTO emkt_regions VALUES(2737, 167, 'ZSI', 'Zamboanga Sibugay', 'russian');

INSERT INTO emkt_countries VALUES (168,'Острова Питкэрн','russian','PN','PCN','');

INSERT INTO emkt_regions VALUES(4270, 168, 'NOCODE', 'Pitcairn', 'russian');

INSERT INTO emkt_countries VALUES (169,'Польша','russian','PL','POL','');

INSERT INTO emkt_regions VALUES(2738, 169, 'DS', 'Dolnośląskie', 'russian');
INSERT INTO emkt_regions VALUES(2739, 169, 'KP', 'Kujawsko-Pomorskie', 'russian');
INSERT INTO emkt_regions VALUES(2740, 169, 'LU', 'Lubelskie', 'russian');
INSERT INTO emkt_regions VALUES(2741, 169, 'LB', 'Lubuskie', 'russian');
INSERT INTO emkt_regions VALUES(2742, 169, 'LD', 'Łódzkie', 'russian');
INSERT INTO emkt_regions VALUES(2743, 169, 'MA', 'Małopolskie', 'russian');
INSERT INTO emkt_regions VALUES(2744, 169, 'MZ', 'Mazowieckie', 'russian');
INSERT INTO emkt_regions VALUES(2745, 169, 'OP', 'Opolskie', 'russian');
INSERT INTO emkt_regions VALUES(2746, 169, 'PK', 'Podkarpackie', 'russian');
INSERT INTO emkt_regions VALUES(2747, 169, 'PD', 'Podlaskie', 'russian');
INSERT INTO emkt_regions VALUES(2748, 169, 'PM', 'Pomorskie', 'russian');
INSERT INTO emkt_regions VALUES(2749, 169, 'SL', 'Śląskie', 'russian');
INSERT INTO emkt_regions VALUES(2750, 169, 'SK', 'Świętokrzyskie', 'russian');
INSERT INTO emkt_regions VALUES(2751, 169, 'WN', 'Warmińsko-Mazurskie', 'russian');
INSERT INTO emkt_regions VALUES(2752, 169, 'WP', 'Wielkopolskie', 'russian');
INSERT INTO emkt_regions VALUES(2753, 169, 'ZP', 'Zachodniopomorskie', 'russian');

INSERT INTO emkt_countries VALUES (170,'Португалия','russian','PT','PRT','');

INSERT INTO emkt_regions VALUES(2754, 170, '01', 'Aveiro', 'russian');
INSERT INTO emkt_regions VALUES(2755, 170, '02', 'Beja', 'russian');
INSERT INTO emkt_regions VALUES(2756, 170, '03', 'Braga', 'russian');
INSERT INTO emkt_regions VALUES(2757, 170, '04', 'Bragança', 'russian');
INSERT INTO emkt_regions VALUES(2758, 170, '05', 'Castelo Branco', 'russian');
INSERT INTO emkt_regions VALUES(2759, 170, '06', 'Coimbra', 'russian');
INSERT INTO emkt_regions VALUES(2760, 170, '07', 'Évora', 'russian');
INSERT INTO emkt_regions VALUES(2761, 170, '08', 'Faro', 'russian');
INSERT INTO emkt_regions VALUES(2762, 170, '09', 'Guarda', 'russian');
INSERT INTO emkt_regions VALUES(2763, 170, '10', 'Leiria', 'russian');
INSERT INTO emkt_regions VALUES(2764, 170, '11', 'Lisboa', 'russian');
INSERT INTO emkt_regions VALUES(2765, 170, '12', 'Portalegre', 'russian');
INSERT INTO emkt_regions VALUES(2766, 170, '13', 'Porto', 'russian');
INSERT INTO emkt_regions VALUES(2767, 170, '14', 'Santarém', 'russian');
INSERT INTO emkt_regions VALUES(2768, 170, '15', 'Setúbal', 'russian');
INSERT INTO emkt_regions VALUES(2769, 170, '16', 'Viana do Castelo', 'russian');
INSERT INTO emkt_regions VALUES(2770, 170, '17', 'Vila Real', 'russian');
INSERT INTO emkt_regions VALUES(2771, 170, '18', 'Viseu', 'russian');
INSERT INTO emkt_regions VALUES(2772, 170, '20', 'Região Autónoma dos Açores', 'russian');
INSERT INTO emkt_regions VALUES(2773, 170, '30', 'Região Autónoma da Madeira', 'russian');

INSERT INTO emkt_countries VALUES (171,'Пуэрто-Рико','russian','PR','PRI','');

INSERT INTO emkt_regions VALUES(4271, 171, 'NOCODE', 'Puerto Rico', 'russian');

INSERT INTO emkt_countries VALUES (172,'Катар','russian','QA','QAT','');

INSERT INTO emkt_regions VALUES(2774, 172, 'DA', 'الدوحة', 'russian');
INSERT INTO emkt_regions VALUES(2775, 172, 'GH', 'الغويرية', 'russian');
INSERT INTO emkt_regions VALUES(2776, 172, 'JB', 'جريان الباطنة', 'russian');
INSERT INTO emkt_regions VALUES(2777, 172, 'JU', 'الجميلية', 'russian');
INSERT INTO emkt_regions VALUES(2778, 172, 'KH', 'الخور', 'russian');
INSERT INTO emkt_regions VALUES(2779, 172, 'ME', 'مسيعيد', 'russian');
INSERT INTO emkt_regions VALUES(2780, 172, 'MS', 'الشمال', 'russian');
INSERT INTO emkt_regions VALUES(2781, 172, 'RA', 'الريان', 'russian');
INSERT INTO emkt_regions VALUES(2782, 172, 'US', 'أم صلال', 'russian');
INSERT INTO emkt_regions VALUES(2783, 172, 'WA', 'الوكرة', 'russian');

INSERT INTO emkt_countries VALUES (173,'Реюньон','russian','RE','REU','');

INSERT INTO emkt_regions VALUES(4272, 173, 'NOCODE', 'Reunion', 'russian');

INSERT INTO emkt_countries VALUES (174,'Румыния','russian','RO','ROM','');

INSERT INTO emkt_regions VALUES(2784, 174, 'AB', 'Alba', 'russian');
INSERT INTO emkt_regions VALUES(2785, 174, 'AG', 'Argeş', 'russian');
INSERT INTO emkt_regions VALUES(2786, 174, 'AR', 'Arad', 'russian');
INSERT INTO emkt_regions VALUES(2787, 174, 'B', 'Bucureşti', 'russian');
INSERT INTO emkt_regions VALUES(2788, 174, 'BC', 'Bacău', 'russian');
INSERT INTO emkt_regions VALUES(2789, 174, 'BH', 'Bihor', 'russian');
INSERT INTO emkt_regions VALUES(2790, 174, 'BN', 'Bistriţa-Năsăud', 'russian');
INSERT INTO emkt_regions VALUES(2791, 174, 'BR', 'Brăila', 'russian');
INSERT INTO emkt_regions VALUES(2792, 174, 'BT', 'Botoşani', 'russian');
INSERT INTO emkt_regions VALUES(2793, 174, 'BV', 'Braşov', 'russian');
INSERT INTO emkt_regions VALUES(2794, 174, 'BZ', 'Buzău', 'russian');
INSERT INTO emkt_regions VALUES(2795, 174, 'CJ', 'Cluj', 'russian');
INSERT INTO emkt_regions VALUES(2796, 174, 'CL', 'Călăraşi', 'russian');
INSERT INTO emkt_regions VALUES(2797, 174, 'CS', 'Caraş-Severin', 'russian');
INSERT INTO emkt_regions VALUES(2798, 174, 'CT', 'Constanţa', 'russian');
INSERT INTO emkt_regions VALUES(2799, 174, 'CV', 'Covasna', 'russian');
INSERT INTO emkt_regions VALUES(2800, 174, 'DB', 'Dâmboviţa', 'russian');
INSERT INTO emkt_regions VALUES(2801, 174, 'DJ', 'Dolj', 'russian');
INSERT INTO emkt_regions VALUES(2802, 174, 'GJ', 'Gorj', 'russian');
INSERT INTO emkt_regions VALUES(2803, 174, 'GL', 'Galaţi', 'russian');
INSERT INTO emkt_regions VALUES(2804, 174, 'GR', 'Giurgiu', 'russian');
INSERT INTO emkt_regions VALUES(2805, 174, 'HD', 'Hunedoara', 'russian');
INSERT INTO emkt_regions VALUES(2806, 174, 'HG', 'Harghita', 'russian');
INSERT INTO emkt_regions VALUES(2807, 174, 'IF', 'Ilfov', 'russian');
INSERT INTO emkt_regions VALUES(2808, 174, 'IL', 'Ialomiţa', 'russian');
INSERT INTO emkt_regions VALUES(2809, 174, 'IS', 'Iaşi', 'russian');
INSERT INTO emkt_regions VALUES(2810, 174, 'MH', 'Mehedinţi', 'russian');
INSERT INTO emkt_regions VALUES(2811, 174, 'MM', 'Maramureş', 'russian');
INSERT INTO emkt_regions VALUES(2812, 174, 'MS', 'Mureş', 'russian');
INSERT INTO emkt_regions VALUES(2813, 174, 'NT', 'Neamţ', 'russian');
INSERT INTO emkt_regions VALUES(2814, 174, 'OT', 'Olt', 'russian');
INSERT INTO emkt_regions VALUES(2815, 174, 'PH', 'Prahova', 'russian');
INSERT INTO emkt_regions VALUES(2816, 174, 'SB', 'Sibiu', 'russian');
INSERT INTO emkt_regions VALUES(2817, 174, 'SJ', 'Sălaj', 'russian');
INSERT INTO emkt_regions VALUES(2818, 174, 'SM', 'Satu Mare', 'russian');
INSERT INTO emkt_regions VALUES(2819, 174, 'SV', 'Suceava', 'russian');
INSERT INTO emkt_regions VALUES(2820, 174, 'TL', 'Tulcea', 'russian');
INSERT INTO emkt_regions VALUES(2821, 174, 'TM', 'Timiş', 'russian');
INSERT INTO emkt_regions VALUES(2822, 174, 'TR', 'Teleorman', 'russian');
INSERT INTO emkt_regions VALUES(2823, 174, 'VL', 'Vâlcea', 'russian');
INSERT INTO emkt_regions VALUES(2824, 174, 'VN', 'Vrancea', 'russian');
INSERT INTO emkt_regions VALUES(2825, 174, 'VS', 'Vaslui', 'russian');

INSERT INTO emkt_countries VALUES (175,'Российская Федерация','russian','RU','RUS','');

INSERT INTO emkt_regions VALUES(2826, 175, 'AD', 'Республика Адыгея', 'russian');
INSERT INTO emkt_regions VALUES(2827, 175, 'AL', 'Республика Алтай', 'russian');
INSERT INTO emkt_regions VALUES(2828, 175, 'ALT', 'Алтайский край', 'russian');
INSERT INTO emkt_regions VALUES(2829, 175, 'AMU', 'Амурская область', 'russian');
INSERT INTO emkt_regions VALUES(2830, 175, 'ARK', 'Архангельская область', 'russian');
INSERT INTO emkt_regions VALUES(2831, 175, 'AST', 'Астраханская область', 'russian');
INSERT INTO emkt_regions VALUES(2832, 175, 'BA', 'Республика Башкортостан', 'russian');
INSERT INTO emkt_regions VALUES(2833, 175, 'BEL', 'Белгородская область', 'russian');
INSERT INTO emkt_regions VALUES(2834, 175, 'BRY', 'Брянская область', 'russian');
INSERT INTO emkt_regions VALUES(2835, 175, 'BU', 'Республика Бурятия', 'russian');
INSERT INTO emkt_regions VALUES(2836, 175, 'CE', 'Чеченская Республика', 'russian');
INSERT INTO emkt_regions VALUES(2837, 175, 'CHE', 'Челябинская область', 'russian');
INSERT INTO emkt_regions VALUES(2838, 175, 'ZAB', 'Забайкальский край', 'russian');
INSERT INTO emkt_regions VALUES(2839, 175, 'CHU', 'Чукотский автономный округ', 'russian');
INSERT INTO emkt_regions VALUES(2840, 175, 'CU', 'Чувашская Республика', 'russian');
INSERT INTO emkt_regions VALUES(2841, 175, 'DA', 'Республика Дагестан', 'russian');
INSERT INTO emkt_regions VALUES(2842, 175, 'IN', 'Республика Ингушетия', 'russian');
INSERT INTO emkt_regions VALUES(2843, 175, 'IRK', 'Иркутская область', 'russian');
INSERT INTO emkt_regions VALUES(2844, 175, 'IVA', 'Ивановская область', 'russian');
INSERT INTO emkt_regions VALUES(2845, 175, 'KAM', 'Камчатский край', 'russian');
INSERT INTO emkt_regions VALUES(2846, 175, 'KB', 'Кабардино-Балкарская Республика', 'russian');
INSERT INTO emkt_regions VALUES(2847, 175, 'KC', 'Карачаево-Черкесская Республика', 'russian');
INSERT INTO emkt_regions VALUES(2848, 175, 'KDA', 'Краснодарский край', 'russian');
INSERT INTO emkt_regions VALUES(2849, 175, 'KEM', 'Кемеровская область', 'russian');
INSERT INTO emkt_regions VALUES(2850, 175, 'KGD', 'Калининградская область', 'russian');
INSERT INTO emkt_regions VALUES(2851, 175, 'KGN', 'Курганская область', 'russian');
INSERT INTO emkt_regions VALUES(2852, 175, 'KHA', 'Хабаровский край', 'russian');
INSERT INTO emkt_regions VALUES(2853, 175, 'KHM', 'Ханты-Мансийский автономный округ—Югра', 'russian');
INSERT INTO emkt_regions VALUES(2854, 175, 'KIA', 'Красноярский край', 'russian');
INSERT INTO emkt_regions VALUES(2855, 175, 'KIR', 'Кировская область', 'russian');
INSERT INTO emkt_regions VALUES(2856, 175, 'KK', 'Республика Хакасия', 'russian');
INSERT INTO emkt_regions VALUES(2857, 175, 'KL', 'Республика Калмыкия', 'russian');
INSERT INTO emkt_regions VALUES(2858, 175, 'KLU', 'Калужская область', 'russian');
INSERT INTO emkt_regions VALUES(2859, 175, 'KO', 'Республика Коми', 'russian');
INSERT INTO emkt_regions VALUES(2860, 175, 'KOS', 'Костромская область', 'russian');
INSERT INTO emkt_regions VALUES(2861, 175, 'KR', 'Республика Карелия', 'russian');
INSERT INTO emkt_regions VALUES(2862, 175, 'KRS', 'Курская область', 'russian');
INSERT INTO emkt_regions VALUES(2863, 175, 'LEN', 'Ленинградская область', 'russian');
INSERT INTO emkt_regions VALUES(2864, 175, 'LIP', 'Липецкая область', 'russian');
INSERT INTO emkt_regions VALUES(2865, 175, 'MAG', 'Магаданская область', 'russian');
INSERT INTO emkt_regions VALUES(2866, 175, 'ME', 'Республика Марий Эл', 'russian');
INSERT INTO emkt_regions VALUES(2867, 175, 'MO', 'Республика Мордовия', 'russian');
INSERT INTO emkt_regions VALUES(2868, 175, 'MOS', 'Московская область', 'russian');
INSERT INTO emkt_regions VALUES(2869, 175, 'MOW', 'Москва', 'russian');
INSERT INTO emkt_regions VALUES(2870, 175, 'MUR', 'Мурманская область', 'russian');
INSERT INTO emkt_regions VALUES(2871, 175, 'NEN', 'Ненецкий автономный округ', 'russian');
INSERT INTO emkt_regions VALUES(2872, 175, 'NGR', 'Новгородская область', 'russian');
INSERT INTO emkt_regions VALUES(2873, 175, 'NIZ', 'Нижегородская область', 'russian');
INSERT INTO emkt_regions VALUES(2874, 175, 'NVS', 'Новосибирская область', 'russian');
INSERT INTO emkt_regions VALUES(2875, 175, 'OMS', 'Омская область', 'russian');
INSERT INTO emkt_regions VALUES(2876, 175, 'ORE', 'Оренбургская область', 'russian');
INSERT INTO emkt_regions VALUES(2877, 175, 'ORL', 'Орловская область', 'russian');
INSERT INTO emkt_regions VALUES(2878, 175, 'PNZ', 'Пензенская область', 'russian');
INSERT INTO emkt_regions VALUES(2879, 175, 'PRI', 'Приморский край', 'russian');
INSERT INTO emkt_regions VALUES(2880, 175, 'PSK', 'Псковская область', 'russian');
INSERT INTO emkt_regions VALUES(2881, 175, 'ROS', 'Ростовская область', 'russian');
INSERT INTO emkt_regions VALUES(2882, 175, 'RYA', 'Рязанская область', 'russian');
INSERT INTO emkt_regions VALUES(2883, 175, 'SA', 'Республика Саха (Якутия)', 'russian');
INSERT INTO emkt_regions VALUES(2884, 175, 'SAK', 'Сахалинская область', 'russian');
INSERT INTO emkt_regions VALUES(2885, 175, 'SAM', 'Самарская область', 'russian');
INSERT INTO emkt_regions VALUES(2886, 175, 'SAR', 'Саратовская область', 'russian');
INSERT INTO emkt_regions VALUES(2887, 175, 'SE', 'Республика Северная Осетия–Алания', 'russian');
INSERT INTO emkt_regions VALUES(2888, 175, 'SMO', 'Смоленская область', 'russian');
INSERT INTO emkt_regions VALUES(2889, 175, 'SPE', 'Санкт-Петербург', 'russian');
INSERT INTO emkt_regions VALUES(2890, 175, 'STA', 'Ставропольский край', 'russian');
INSERT INTO emkt_regions VALUES(2891, 175, 'SVE', 'Свердловская область', 'russian');
INSERT INTO emkt_regions VALUES(2892, 175, 'TA', 'Республика Татарстан', 'russian');
INSERT INTO emkt_regions VALUES(2893, 175, 'TAM', 'Тамбовская область', 'russian');
INSERT INTO emkt_regions VALUES(2894, 175, 'TOM', 'Томская область', 'russian');
INSERT INTO emkt_regions VALUES(2895, 175, 'TUL', 'Тульская область', 'russian');
INSERT INTO emkt_regions VALUES(2896, 175, 'TVE', 'Тверская область', 'russian');
INSERT INTO emkt_regions VALUES(2897, 175, 'TY', 'Республика Тыва', 'russian');
INSERT INTO emkt_regions VALUES(2898, 175, 'TYU', 'Тюменская область', 'russian');
INSERT INTO emkt_regions VALUES(2899, 175, 'UD', 'Удмуртская Республика', 'russian');
INSERT INTO emkt_regions VALUES(2900, 175, 'ULY', 'Ульяновская область', 'russian');
INSERT INTO emkt_regions VALUES(2901, 175, 'VGG', 'Волгоградская область', 'russian');
INSERT INTO emkt_regions VALUES(2902, 175, 'VLA', 'Владимирская область', 'russian');
INSERT INTO emkt_regions VALUES(2903, 175, 'VLG', 'Вологодская область', 'russian');
INSERT INTO emkt_regions VALUES(2904, 175, 'VOR', 'Воронежская область', 'russian');
INSERT INTO emkt_regions VALUES(2905, 175, 'PER', 'Пермский край', 'russian');
INSERT INTO emkt_regions VALUES(2906, 175, 'YAN', 'Ямало-Ненецкий автономный округ', 'russian');
INSERT INTO emkt_regions VALUES(2907, 175, 'YAR', 'Ярославская область', 'russian');
INSERT INTO emkt_regions VALUES(2908, 175, 'YEV', 'Еврейская автономная область', 'russian');

INSERT INTO emkt_countries VALUES (176,'Руанда','russian','RW','RWA','');

INSERT INTO emkt_regions VALUES(2909, 176, 'N', 'Nord', 'russian');
INSERT INTO emkt_regions VALUES(2910, 176, 'E', 'Est', 'russian');
INSERT INTO emkt_regions VALUES(2911, 176, 'S', 'Sud', 'russian');
INSERT INTO emkt_regions VALUES(2912, 176, 'O', 'Ouest', 'russian');
INSERT INTO emkt_regions VALUES(2913, 176, 'K', 'Kigali', 'russian');

INSERT INTO emkt_countries VALUES (177,'Сент-Китс и Невис','russian','KN','KNA','');

INSERT INTO emkt_regions VALUES(2914, 177, 'K', 'Saint Kitts', 'russian');
INSERT INTO emkt_regions VALUES(2915, 177, 'N', 'Nevis', 'russian');

INSERT INTO emkt_countries VALUES (178,'Сент-Люсия','russian','LC','LCA','');

INSERT INTO emkt_regions VALUES(2916, 178, 'AR', 'Anse-la-Raye', 'russian');
INSERT INTO emkt_regions VALUES(2917, 178, 'CA', 'Castries', 'russian');
INSERT INTO emkt_regions VALUES(2918, 178, 'CH', 'Choiseul', 'russian');
INSERT INTO emkt_regions VALUES(2919, 178, 'DA', 'Dauphin', 'russian');
INSERT INTO emkt_regions VALUES(2920, 178, 'DE', 'Dennery', 'russian');
INSERT INTO emkt_regions VALUES(2921, 178, 'GI', 'Gros-Islet', 'russian');
INSERT INTO emkt_regions VALUES(2922, 178, 'LA', 'Laborie', 'russian');
INSERT INTO emkt_regions VALUES(2923, 178, 'MI', 'Micoud', 'russian');
INSERT INTO emkt_regions VALUES(2924, 178, 'PR', 'Praslin', 'russian');
INSERT INTO emkt_regions VALUES(2925, 178, 'SO', 'Soufriere', 'russian');
INSERT INTO emkt_regions VALUES(2926, 178, 'VF', 'Vieux-Fort', 'russian');

INSERT INTO emkt_countries VALUES (179,'Сент-Винсент и Гренадины','russian','VC','VCT','');

INSERT INTO emkt_regions VALUES(2927, 179, 'C', 'Charlotte', 'russian');
INSERT INTO emkt_regions VALUES(2928, 179, 'R', 'Grenadines', 'russian');
INSERT INTO emkt_regions VALUES(2929, 179, 'A', 'Saint Andrew', 'russian');
INSERT INTO emkt_regions VALUES(2930, 179, 'D', 'Saint David', 'russian');
INSERT INTO emkt_regions VALUES(2931, 179, 'G', 'Saint George', 'russian');
INSERT INTO emkt_regions VALUES(2932, 179, 'P', 'Saint Patrick', 'russian');

INSERT INTO emkt_countries VALUES (180,'Самоа','russian','WS','WSM','');

INSERT INTO emkt_regions VALUES(2933, 180, 'AA', 'A\'ana', 'russian');
INSERT INTO emkt_regions VALUES(2934, 180, 'AL', 'Aiga-i-le-Tai', 'russian');
INSERT INTO emkt_regions VALUES(2935, 180, 'AT', 'Atua', 'russian');
INSERT INTO emkt_regions VALUES(2936, 180, 'FA', 'Fa\'asaleleaga', 'russian');
INSERT INTO emkt_regions VALUES(2937, 180, 'GE', 'Gaga\'emauga', 'russian');
INSERT INTO emkt_regions VALUES(2938, 180, 'GI', 'Gaga\'ifomauga', 'russian');
INSERT INTO emkt_regions VALUES(2939, 180, 'PA', 'Palauli', 'russian');
INSERT INTO emkt_regions VALUES(2940, 180, 'SA', 'Satupa\'itea', 'russian');
INSERT INTO emkt_regions VALUES(2941, 180, 'TU', 'Tuamasaga', 'russian');
INSERT INTO emkt_regions VALUES(2942, 180, 'VF', 'Va\'a-o-Fonoti', 'russian');
INSERT INTO emkt_regions VALUES(2943, 180, 'VS', 'Vaisigano', 'russian');

INSERT INTO emkt_countries VALUES (181,'Сан-Марино','russian','SM','SMR','');

INSERT INTO emkt_regions VALUES(2944, 181, 'AC', 'Acquaviva', 'russian');
INSERT INTO emkt_regions VALUES(2945, 181, 'BM', 'Borgo Maggiore', 'russian');
INSERT INTO emkt_regions VALUES(2946, 181, 'CH', 'Chiesanuova', 'russian');
INSERT INTO emkt_regions VALUES(2947, 181, 'DO', 'Domagnano', 'russian');
INSERT INTO emkt_regions VALUES(2948, 181, 'FA', 'Faetano', 'russian');
INSERT INTO emkt_regions VALUES(2949, 181, 'FI', 'Fiorentino', 'russian');
INSERT INTO emkt_regions VALUES(2950, 181, 'MO', 'Montegiardino', 'russian');
INSERT INTO emkt_regions VALUES(2951, 181, 'SM', 'Citta di San Marino', 'russian');
INSERT INTO emkt_regions VALUES(2952, 181, 'SE', 'Serravalle', 'russian');

INSERT INTO emkt_countries VALUES (182,'Сан-Томе и Принсипи','russian','ST','STP','');

INSERT INTO emkt_regions VALUES(2953, 182, 'P', 'Príncipe', 'russian');
INSERT INTO emkt_regions VALUES(2954, 182, 'S', 'São Tomé', 'russian');

INSERT INTO emkt_countries VALUES (183,'Саудовская Аравия','russian','SA','SAU','');

INSERT INTO emkt_regions VALUES(2955, 183, '01', 'الرياض', 'russian');
INSERT INTO emkt_regions VALUES(2956, 183, '02', 'مكة المكرمة', 'russian');
INSERT INTO emkt_regions VALUES(2957, 183, '03', 'المدينه', 'russian');
INSERT INTO emkt_regions VALUES(2958, 183, '04', 'الشرقية', 'russian');
INSERT INTO emkt_regions VALUES(2959, 183, '05', 'القصيم', 'russian');
INSERT INTO emkt_regions VALUES(2960, 183, '06', 'حائل', 'russian');
INSERT INTO emkt_regions VALUES(2961, 183, '07', 'تبوك', 'russian');
INSERT INTO emkt_regions VALUES(2962, 183, '08', 'الحدود الشمالية', 'russian');
INSERT INTO emkt_regions VALUES(2963, 183, '09', 'جيزان', 'russian');
INSERT INTO emkt_regions VALUES(2964, 183, '10', 'نجران', 'russian');
INSERT INTO emkt_regions VALUES(2965, 183, '11', 'الباحة', 'russian');
INSERT INTO emkt_regions VALUES(2966, 183, '12', 'الجوف', 'russian');
INSERT INTO emkt_regions VALUES(2967, 183, '14', 'عسير', 'russian');

INSERT INTO emkt_countries VALUES (184,'Сенегал','russian','SN','SEN','');

INSERT INTO emkt_regions VALUES(2968, 184, 'DA', 'Dakar', 'russian');
INSERT INTO emkt_regions VALUES(2969, 184, 'DI', 'Diourbel', 'russian');
INSERT INTO emkt_regions VALUES(2970, 184, 'FA', 'Fatick', 'russian');
INSERT INTO emkt_regions VALUES(2971, 184, 'KA', 'Kaolack', 'russian');
INSERT INTO emkt_regions VALUES(2972, 184, 'KO', 'Kolda', 'russian');
INSERT INTO emkt_regions VALUES(2973, 184, 'LO', 'Louga', 'russian');
INSERT INTO emkt_regions VALUES(2974, 184, 'MA', 'Matam', 'russian');
INSERT INTO emkt_regions VALUES(2975, 184, 'SL', 'Saint-Louis', 'russian');
INSERT INTO emkt_regions VALUES(2976, 184, 'TA', 'Tambacounda', 'russian');
INSERT INTO emkt_regions VALUES(2977, 184, 'TH', 'Thies', 'russian');
INSERT INTO emkt_regions VALUES(2978, 184, 'ZI', 'Ziguinchor', 'russian');

INSERT INTO emkt_countries VALUES (185,'Сейшельские Острова','russian','SC','SYC','');

INSERT INTO emkt_regions VALUES(2979, 185, 'AP', 'Anse aux Pins', 'russian');
INSERT INTO emkt_regions VALUES(2980, 185, 'AB', 'Anse Boileau', 'russian');
INSERT INTO emkt_regions VALUES(2981, 185, 'AE', 'Anse Etoile', 'russian');
INSERT INTO emkt_regions VALUES(2982, 185, 'AL', 'Anse Louis', 'russian');
INSERT INTO emkt_regions VALUES(2983, 185, 'AR', 'Anse Royale', 'russian');
INSERT INTO emkt_regions VALUES(2984, 185, 'BL', 'Baie Lazare', 'russian');
INSERT INTO emkt_regions VALUES(2985, 185, 'BS', 'Baie Sainte Anne', 'russian');
INSERT INTO emkt_regions VALUES(2986, 185, 'BV', 'Beau Vallon', 'russian');
INSERT INTO emkt_regions VALUES(2987, 185, 'BA', 'Bel Air', 'russian');
INSERT INTO emkt_regions VALUES(2988, 185, 'BO', 'Bel Ombre', 'russian');
INSERT INTO emkt_regions VALUES(2989, 185, 'CA', 'Cascade', 'russian');
INSERT INTO emkt_regions VALUES(2990, 185, 'GL', 'Glacis', 'russian');
INSERT INTO emkt_regions VALUES(2991, 185, 'GM', 'Grand\' Anse (on Mahe)', 'russian');
INSERT INTO emkt_regions VALUES(2992, 185, 'GP', 'Grand\' Anse (on Praslin)', 'russian');
INSERT INTO emkt_regions VALUES(2993, 185, 'DG', 'La Digue', 'russian');
INSERT INTO emkt_regions VALUES(2994, 185, 'RA', 'La Riviere Anglaise', 'russian');
INSERT INTO emkt_regions VALUES(2995, 185, 'MB', 'Mont Buxton', 'russian');
INSERT INTO emkt_regions VALUES(2996, 185, 'MF', 'Mont Fleuri', 'russian');
INSERT INTO emkt_regions VALUES(2997, 185, 'PL', 'Plaisance', 'russian');
INSERT INTO emkt_regions VALUES(2998, 185, 'PR', 'Pointe La Rue', 'russian');
INSERT INTO emkt_regions VALUES(2999, 185, 'PG', 'Port Glaud', 'russian');
INSERT INTO emkt_regions VALUES(3000, 185, 'SL', 'Saint Louis', 'russian');
INSERT INTO emkt_regions VALUES(3001, 185, 'TA', 'Takamaka', 'russian');

INSERT INTO emkt_countries VALUES (186,'Сьерра-Леоне','russian','SL','SLE','');

INSERT INTO emkt_regions VALUES(3002, 186, 'E', 'Eastern', 'russian');
INSERT INTO emkt_regions VALUES(3003, 186, 'N', 'Northern', 'russian');
INSERT INTO emkt_regions VALUES(3004, 186, 'S', 'Southern', 'russian');
INSERT INTO emkt_regions VALUES(3005, 186, 'W', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (187,'Сингапур','russian','SG','SGP','');

INSERT INTO emkt_regions VALUES(4273, 187, 'NOCODE', 'Singapore', 'russian');

INSERT INTO emkt_countries VALUES (188,'Словакия','russian','SK','SVK','');

INSERT INTO emkt_regions VALUES(3006, 188, 'BC', 'Banskobystrický kraj', 'russian');
INSERT INTO emkt_regions VALUES(3007, 188, 'BL', 'Bratislavský kraj', 'russian');
INSERT INTO emkt_regions VALUES(3008, 188, 'KI', 'Košický kraj', 'russian');
INSERT INTO emkt_regions VALUES(3009, 188, 'NJ', 'Nitrianský kraj', 'russian');
INSERT INTO emkt_regions VALUES(3010, 188, 'PV', 'Prešovský kraj', 'russian');
INSERT INTO emkt_regions VALUES(3011, 188, 'TA', 'Trnavský kraj', 'russian');
INSERT INTO emkt_regions VALUES(3012, 188, 'TC', 'Trenčianský kraj', 'russian');
INSERT INTO emkt_regions VALUES(3013, 188, 'ZI', 'Žilinský kraj', 'russian');

INSERT INTO emkt_countries VALUES (189,'Словения','russian','SI','SVN','');

INSERT INTO emkt_regions VALUES(3014, 189, '001', 'Ajdovščina', 'russian');
INSERT INTO emkt_regions VALUES(3015, 189, '002', 'Beltinci', 'russian');
INSERT INTO emkt_regions VALUES(3016, 189, '003', 'Bled', 'russian');
INSERT INTO emkt_regions VALUES(3017, 189, '004', 'Bohinj', 'russian');
INSERT INTO emkt_regions VALUES(3018, 189, '005', 'Borovnica', 'russian');
INSERT INTO emkt_regions VALUES(3019, 189, '006', 'Bovec', 'russian');
INSERT INTO emkt_regions VALUES(3020, 189, '007', 'Brda', 'russian');
INSERT INTO emkt_regions VALUES(3021, 189, '008', 'Brezovica', 'russian');
INSERT INTO emkt_regions VALUES(3022, 189, '009', 'Brežice', 'russian');
INSERT INTO emkt_regions VALUES(3023, 189, '010', 'Tišina', 'russian');
INSERT INTO emkt_regions VALUES(3024, 189, '011', 'Celje', 'russian');
INSERT INTO emkt_regions VALUES(3025, 189, '012', 'Cerklje na Gorenjskem', 'russian');
INSERT INTO emkt_regions VALUES(3026, 189, '013', 'Cerknica', 'russian');
INSERT INTO emkt_regions VALUES(3027, 189, '014', 'Cerkno', 'russian');
INSERT INTO emkt_regions VALUES(3028, 189, '015', 'Črenšovci', 'russian');
INSERT INTO emkt_regions VALUES(3029, 189, '016', 'Črna na Koroškem', 'russian');
INSERT INTO emkt_regions VALUES(3030, 189, '017', 'Črnomelj', 'russian');
INSERT INTO emkt_regions VALUES(3031, 189, '018', 'Destrnik', 'russian');
INSERT INTO emkt_regions VALUES(3032, 189, '019', 'Divača', 'russian');
INSERT INTO emkt_regions VALUES(3033, 189, '020', 'Dobrepolje', 'russian');
INSERT INTO emkt_regions VALUES(3034, 189, '021', 'Dobrova-Polhov Gradec', 'russian');
INSERT INTO emkt_regions VALUES(3035, 189, '022', 'Dol pri Ljubljani', 'russian');
INSERT INTO emkt_regions VALUES(3036, 189, '023', 'Domžale', 'russian');
INSERT INTO emkt_regions VALUES(3037, 189, '024', 'Dornava', 'russian');
INSERT INTO emkt_regions VALUES(3038, 189, '025', 'Dravograd', 'russian');
INSERT INTO emkt_regions VALUES(3039, 189, '026', 'Duplek', 'russian');
INSERT INTO emkt_regions VALUES(3040, 189, '027', 'Gorenja vas-Poljane', 'russian');
INSERT INTO emkt_regions VALUES(3041, 189, '028', 'Gorišnica', 'russian');
INSERT INTO emkt_regions VALUES(3042, 189, '029', 'Gornja Radgona', 'russian');
INSERT INTO emkt_regions VALUES(3043, 189, '030', 'Gornji Grad', 'russian');
INSERT INTO emkt_regions VALUES(3044, 189, '031', 'Gornji Petrovci', 'russian');
INSERT INTO emkt_regions VALUES(3045, 189, '032', 'Grosuplje', 'russian');
INSERT INTO emkt_regions VALUES(3046, 189, '033', 'Šalovci', 'russian');
INSERT INTO emkt_regions VALUES(3047, 189, '034', 'Hrastnik', 'russian');
INSERT INTO emkt_regions VALUES(3048, 189, '035', 'Hrpelje-Kozina', 'russian');
INSERT INTO emkt_regions VALUES(3049, 189, '036', 'Idrija', 'russian');
INSERT INTO emkt_regions VALUES(3050, 189, '037', 'Ig', 'russian');
INSERT INTO emkt_regions VALUES(3051, 189, '038', 'Ilirska Bistrica', 'russian');
INSERT INTO emkt_regions VALUES(3052, 189, '039', 'Ivančna Gorica', 'russian');
INSERT INTO emkt_regions VALUES(3053, 189, '040', 'Izola', 'russian');
INSERT INTO emkt_regions VALUES(3054, 189, '041', 'Jesenice', 'russian');
INSERT INTO emkt_regions VALUES(3055, 189, '042', 'Juršinci', 'russian');
INSERT INTO emkt_regions VALUES(3056, 189, '043', 'Kamnik', 'russian');
INSERT INTO emkt_regions VALUES(3057, 189, '044', 'Kanal ob Soči', 'russian');
INSERT INTO emkt_regions VALUES(3058, 189, '045', 'Kidričevo', 'russian');
INSERT INTO emkt_regions VALUES(3059, 189, '046', 'Kobarid', 'russian');
INSERT INTO emkt_regions VALUES(3060, 189, '047', 'Kobilje', 'russian');
INSERT INTO emkt_regions VALUES(3061, 189, '048', 'Kočevje', 'russian');
INSERT INTO emkt_regions VALUES(3062, 189, '049', 'Komen', 'russian');
INSERT INTO emkt_regions VALUES(3063, 189, '050', 'Koper', 'russian');
INSERT INTO emkt_regions VALUES(3064, 189, '051', 'Kozje', 'russian');
INSERT INTO emkt_regions VALUES(3065, 189, '052', 'Kranj', 'russian');
INSERT INTO emkt_regions VALUES(3066, 189, '053', 'Kranjska Gora', 'russian');
INSERT INTO emkt_regions VALUES(3067, 189, '054', 'Krško', 'russian');
INSERT INTO emkt_regions VALUES(3068, 189, '055', 'Kungota', 'russian');
INSERT INTO emkt_regions VALUES(3069, 189, '056', 'Kuzma', 'russian');
INSERT INTO emkt_regions VALUES(3070, 189, '057', 'Laško', 'russian');
INSERT INTO emkt_regions VALUES(3071, 189, '058', 'Lenart', 'russian');
INSERT INTO emkt_regions VALUES(3072, 189, '059', 'Lendava', 'russian');
INSERT INTO emkt_regions VALUES(3073, 189, '060', 'Litija', 'russian');
INSERT INTO emkt_regions VALUES(3074, 189, '061', 'Ljubljana', 'russian');
INSERT INTO emkt_regions VALUES(3075, 189, '062', 'Ljubno', 'russian');
INSERT INTO emkt_regions VALUES(3076, 189, '063', 'Ljutomer', 'russian');
INSERT INTO emkt_regions VALUES(3077, 189, '064', 'Logatec', 'russian');
INSERT INTO emkt_regions VALUES(3078, 189, '065', 'Loška Dolina', 'russian');
INSERT INTO emkt_regions VALUES(3079, 189, '066', 'Loški Potok', 'russian');
INSERT INTO emkt_regions VALUES(3080, 189, '067', 'Luče', 'russian');
INSERT INTO emkt_regions VALUES(3081, 189, '068', 'Lukovica', 'russian');
INSERT INTO emkt_regions VALUES(3082, 189, '069', 'Majšperk', 'russian');
INSERT INTO emkt_regions VALUES(3083, 189, '070', 'Maribor', 'russian');
INSERT INTO emkt_regions VALUES(3084, 189, '071', 'Medvode', 'russian');
INSERT INTO emkt_regions VALUES(3085, 189, '072', 'Mengeš', 'russian');
INSERT INTO emkt_regions VALUES(3086, 189, '073', 'Metlika', 'russian');
INSERT INTO emkt_regions VALUES(3087, 189, '074', 'Mežica', 'russian');
INSERT INTO emkt_regions VALUES(3088, 189, '075', 'Miren-Kostanjevica', 'russian');
INSERT INTO emkt_regions VALUES(3089, 189, '076', 'Mislinja', 'russian');
INSERT INTO emkt_regions VALUES(3090, 189, '077', 'Moravče', 'russian');
INSERT INTO emkt_regions VALUES(3091, 189, '078', 'Moravske Toplice', 'russian');
INSERT INTO emkt_regions VALUES(3092, 189, '079', 'Mozirje', 'russian');
INSERT INTO emkt_regions VALUES(3093, 189, '080', 'Murska Sobota', 'russian');
INSERT INTO emkt_regions VALUES(3094, 189, '081', 'Muta', 'russian');
INSERT INTO emkt_regions VALUES(3095, 189, '082', 'Naklo', 'russian');
INSERT INTO emkt_regions VALUES(3096, 189, '083', 'Nazarje', 'russian');
INSERT INTO emkt_regions VALUES(3097, 189, '084', 'Nova Gorica', 'russian');
INSERT INTO emkt_regions VALUES(3098, 189, '085', 'Novo mesto', 'russian');
INSERT INTO emkt_regions VALUES(3099, 189, '086', 'Odranci', 'russian');
INSERT INTO emkt_regions VALUES(3100, 189, '087', 'Ormož', 'russian');
INSERT INTO emkt_regions VALUES(3101, 189, '088', 'Osilnica', 'russian');
INSERT INTO emkt_regions VALUES(3102, 189, '089', 'Pesnica', 'russian');
INSERT INTO emkt_regions VALUES(3103, 189, '090', 'Piran', 'russian');
INSERT INTO emkt_regions VALUES(3104, 189, '091', 'Pivka', 'russian');
INSERT INTO emkt_regions VALUES(3105, 189, '092', 'Podčetrtek', 'russian');
INSERT INTO emkt_regions VALUES(3106, 189, '093', 'Podvelka', 'russian');
INSERT INTO emkt_regions VALUES(3107, 189, '094', 'Postojna', 'russian');
INSERT INTO emkt_regions VALUES(3108, 189, '095', 'Preddvor', 'russian');
INSERT INTO emkt_regions VALUES(3109, 189, '096', 'Ptuj', 'russian');
INSERT INTO emkt_regions VALUES(3110, 189, '097', 'Puconci', 'russian');
INSERT INTO emkt_regions VALUES(3111, 189, '098', 'Rače-Fram', 'russian');
INSERT INTO emkt_regions VALUES(3112, 189, '099', 'Radeče', 'russian');
INSERT INTO emkt_regions VALUES(3113, 189, '100', 'Radenci', 'russian');
INSERT INTO emkt_regions VALUES(3114, 189, '101', 'Radlje ob Dravi', 'russian');
INSERT INTO emkt_regions VALUES(3115, 189, '102', 'Radovljica', 'russian');
INSERT INTO emkt_regions VALUES(3116, 189, '103', 'Ravne na Koroškem', 'russian');
INSERT INTO emkt_regions VALUES(3117, 189, '104', 'Ribnica', 'russian');
INSERT INTO emkt_regions VALUES(3118, 189, '106', 'Rogaška Slatina', 'russian');
INSERT INTO emkt_regions VALUES(3119, 189, '105', 'Rogašovci', 'russian');
INSERT INTO emkt_regions VALUES(3120, 189, '107', 'Rogatec', 'russian');
INSERT INTO emkt_regions VALUES(3121, 189, '108', 'Ruše', 'russian');
INSERT INTO emkt_regions VALUES(3122, 189, '109', 'Semič', 'russian');
INSERT INTO emkt_regions VALUES(3123, 189, '110', 'Sevnica', 'russian');
INSERT INTO emkt_regions VALUES(3124, 189, '111', 'Sežana', 'russian');
INSERT INTO emkt_regions VALUES(3125, 189, '112', 'Slovenj Gradec', 'russian');
INSERT INTO emkt_regions VALUES(3126, 189, '113', 'Slovenska Bistrica', 'russian');
INSERT INTO emkt_regions VALUES(3127, 189, '114', 'Slovenske Konjice', 'russian');
INSERT INTO emkt_regions VALUES(3128, 189, '115', 'Starše', 'russian');
INSERT INTO emkt_regions VALUES(3129, 189, '116', 'Sveti Jurij', 'russian');
INSERT INTO emkt_regions VALUES(3130, 189, '117', 'Šenčur', 'russian');
INSERT INTO emkt_regions VALUES(3131, 189, '118', 'Šentilj', 'russian');
INSERT INTO emkt_regions VALUES(3132, 189, '119', 'Šentjernej', 'russian');
INSERT INTO emkt_regions VALUES(3133, 189, '120', 'Šentjur pri Celju', 'russian');
INSERT INTO emkt_regions VALUES(3134, 189, '121', 'Škocjan', 'russian');
INSERT INTO emkt_regions VALUES(3135, 189, '122', 'Škofja Loka', 'russian');
INSERT INTO emkt_regions VALUES(3136, 189, '123', 'Škofljica', 'russian');
INSERT INTO emkt_regions VALUES(3137, 189, '124', 'Šmarje pri Jelšah', 'russian');
INSERT INTO emkt_regions VALUES(3138, 189, '125', 'Šmartno ob Paki', 'russian');
INSERT INTO emkt_regions VALUES(3139, 189, '126', 'Šoštanj', 'russian');
INSERT INTO emkt_regions VALUES(3140, 189, '127', 'Štore', 'russian');
INSERT INTO emkt_regions VALUES(3141, 189, '128', 'Tolmin', 'russian');
INSERT INTO emkt_regions VALUES(3142, 189, '129', 'Trbovlje', 'russian');
INSERT INTO emkt_regions VALUES(3143, 189, '130', 'Trebnje', 'russian');
INSERT INTO emkt_regions VALUES(3144, 189, '131', 'Tržič', 'russian');
INSERT INTO emkt_regions VALUES(3145, 189, '132', 'Turnišče', 'russian');
INSERT INTO emkt_regions VALUES(3146, 189, '133', 'Velenje', 'russian');
INSERT INTO emkt_regions VALUES(3147, 189, '134', 'Velike Lašče', 'russian');
INSERT INTO emkt_regions VALUES(3148, 189, '135', 'Videm', 'russian');
INSERT INTO emkt_regions VALUES(3149, 189, '136', 'Vipava', 'russian');
INSERT INTO emkt_regions VALUES(3150, 189, '137', 'Vitanje', 'russian');
INSERT INTO emkt_regions VALUES(3151, 189, '138', 'Vodice', 'russian');
INSERT INTO emkt_regions VALUES(3152, 189, '139', 'Vojnik', 'russian');
INSERT INTO emkt_regions VALUES(3153, 189, '140', 'Vrhnika', 'russian');
INSERT INTO emkt_regions VALUES(3154, 189, '141', 'Vuzenica', 'russian');
INSERT INTO emkt_regions VALUES(3155, 189, '142', 'Zagorje ob Savi', 'russian');
INSERT INTO emkt_regions VALUES(3156, 189, '143', 'Zavrč', 'russian');
INSERT INTO emkt_regions VALUES(3157, 189, '144', 'Zreče', 'russian');
INSERT INTO emkt_regions VALUES(3158, 189, '146', 'Železniki', 'russian');
INSERT INTO emkt_regions VALUES(3159, 189, '147', 'Žiri', 'russian');
INSERT INTO emkt_regions VALUES(3160, 189, '148', 'Benedikt', 'russian');
INSERT INTO emkt_regions VALUES(3161, 189, '149', 'Bistrica ob Sotli', 'russian');
INSERT INTO emkt_regions VALUES(3162, 189, '150', 'Bloke', 'russian');
INSERT INTO emkt_regions VALUES(3163, 189, '151', 'Braslovče', 'russian');
INSERT INTO emkt_regions VALUES(3164, 189, '152', 'Cankova', 'russian');
INSERT INTO emkt_regions VALUES(3165, 189, '153', 'Cerkvenjak', 'russian');
INSERT INTO emkt_regions VALUES(3166, 189, '154', 'Dobje', 'russian');
INSERT INTO emkt_regions VALUES(3167, 189, '155', 'Dobrna', 'russian');
INSERT INTO emkt_regions VALUES(3168, 189, '156', 'Dobrovnik', 'russian');
INSERT INTO emkt_regions VALUES(3169, 189, '157', 'Dolenjske Toplice', 'russian');
INSERT INTO emkt_regions VALUES(3170, 189, '158', 'Grad', 'russian');
INSERT INTO emkt_regions VALUES(3171, 189, '159', 'Hajdina', 'russian');
INSERT INTO emkt_regions VALUES(3172, 189, '160', 'Hoče-Slivnica', 'russian');
INSERT INTO emkt_regions VALUES(3173, 189, '161', 'Hodoš', 'russian');
INSERT INTO emkt_regions VALUES(3174, 189, '162', 'Horjul', 'russian');
INSERT INTO emkt_regions VALUES(3175, 189, '163', 'Jezersko', 'russian');
INSERT INTO emkt_regions VALUES(3176, 189, '164', 'Komenda', 'russian');
INSERT INTO emkt_regions VALUES(3177, 189, '165', 'Kostel', 'russian');
INSERT INTO emkt_regions VALUES(3178, 189, '166', 'Križevci', 'russian');
INSERT INTO emkt_regions VALUES(3179, 189, '167', 'Lovrenc na Pohorju', 'russian');
INSERT INTO emkt_regions VALUES(3180, 189, '168', 'Markovci', 'russian');
INSERT INTO emkt_regions VALUES(3181, 189, '169', 'Miklavž na Dravskem polju', 'russian');
INSERT INTO emkt_regions VALUES(3182, 189, '170', 'Mirna Peč', 'russian');
INSERT INTO emkt_regions VALUES(3183, 189, '171', 'Oplotnica', 'russian');
INSERT INTO emkt_regions VALUES(3184, 189, '172', 'Podlehnik', 'russian');
INSERT INTO emkt_regions VALUES(3185, 189, '173', 'Polzela', 'russian');
INSERT INTO emkt_regions VALUES(3186, 189, '174', 'Prebold', 'russian');
INSERT INTO emkt_regions VALUES(3187, 189, '175', 'Prevalje', 'russian');
INSERT INTO emkt_regions VALUES(3188, 189, '176', 'Razkrižje', 'russian');
INSERT INTO emkt_regions VALUES(3189, 189, '177', 'Ribnica na Pohorju', 'russian');
INSERT INTO emkt_regions VALUES(3190, 189, '178', 'Selnica ob Dravi', 'russian');
INSERT INTO emkt_regions VALUES(3191, 189, '179', 'Sodražica', 'russian');
INSERT INTO emkt_regions VALUES(3192, 189, '180', 'Solčava', 'russian');
INSERT INTO emkt_regions VALUES(3193, 189, '181', 'Sveta Ana', 'russian');
INSERT INTO emkt_regions VALUES(3194, 189, '182', 'Sveti Andraž v Slovenskih goricah', 'russian');
INSERT INTO emkt_regions VALUES(3195, 189, '183', 'Šempeter-Vrtojba', 'russian');
INSERT INTO emkt_regions VALUES(3196, 189, '184', 'Tabor', 'russian');
INSERT INTO emkt_regions VALUES(3197, 189, '185', 'Trnovska vas', 'russian');
INSERT INTO emkt_regions VALUES(3198, 189, '186', 'Trzin', 'russian');
INSERT INTO emkt_regions VALUES(3199, 189, '187', 'Velika Polana', 'russian');
INSERT INTO emkt_regions VALUES(3200, 189, '188', 'Veržej', 'russian');
INSERT INTO emkt_regions VALUES(3201, 189, '189', 'Vransko', 'russian');
INSERT INTO emkt_regions VALUES(3202, 189, '190', 'Žalec', 'russian');
INSERT INTO emkt_regions VALUES(3203, 189, '191', 'Žetale', 'russian');
INSERT INTO emkt_regions VALUES(3204, 189, '192', 'Žirovnica', 'russian');
INSERT INTO emkt_regions VALUES(3205, 189, '193', 'Žužemberk', 'russian');
INSERT INTO emkt_regions VALUES(3206, 189, '194', 'Šmartno pri Litiji', 'russian');

INSERT INTO emkt_countries VALUES (190,'Соломоновы Острова','russian','SB','SLB','');

INSERT INTO emkt_regions VALUES(3207, 190, 'CE', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(3208, 190, 'CH', 'Choiseul', 'russian');
INSERT INTO emkt_regions VALUES(3209, 190, 'GC', 'Guadalcanal', 'russian');
INSERT INTO emkt_regions VALUES(3210, 190, 'HO', 'Honiara', 'russian');
INSERT INTO emkt_regions VALUES(3211, 190, 'IS', 'Isabel', 'russian');
INSERT INTO emkt_regions VALUES(3212, 190, 'MK', 'Makira', 'russian');
INSERT INTO emkt_regions VALUES(3213, 190, 'ML', 'Malaita', 'russian');
INSERT INTO emkt_regions VALUES(3214, 190, 'RB', 'Rennell and Bellona', 'russian');
INSERT INTO emkt_regions VALUES(3215, 190, 'TM', 'Temotu', 'russian');
INSERT INTO emkt_regions VALUES(3216, 190, 'WE', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (191,'Сомали','russian','SO','SOM','');

INSERT INTO emkt_regions VALUES(3217, 191, 'AD', 'Awdal', 'russian');
INSERT INTO emkt_regions VALUES(3218, 191, 'BK', 'Bakool', 'russian');
INSERT INTO emkt_regions VALUES(3219, 191, 'BN', 'Banaadir', 'russian');
INSERT INTO emkt_regions VALUES(3220, 191, 'BR', 'Bari', 'russian');
INSERT INTO emkt_regions VALUES(3221, 191, 'BY', 'Bay', 'russian');
INSERT INTO emkt_regions VALUES(3222, 191, 'GD', 'Gedo', 'russian');
INSERT INTO emkt_regions VALUES(3223, 191, 'GG', 'Galguduud', 'russian');
INSERT INTO emkt_regions VALUES(3224, 191, 'HR', 'Hiiraan', 'russian');
INSERT INTO emkt_regions VALUES(3225, 191, 'JD', 'Jubbada Dhexe', 'russian');
INSERT INTO emkt_regions VALUES(3226, 191, 'JH', 'Jubbada Hoose', 'russian');
INSERT INTO emkt_regions VALUES(3227, 191, 'MD', 'Mudug', 'russian');
INSERT INTO emkt_regions VALUES(3228, 191, 'NG', 'Nugaal', 'russian');
INSERT INTO emkt_regions VALUES(3229, 191, 'SD', 'Shabeellaha Dhexe', 'russian');
INSERT INTO emkt_regions VALUES(3230, 191, 'SG', 'Sanaag', 'russian');
INSERT INTO emkt_regions VALUES(3231, 191, 'SH', 'Shabeellaha Hoose', 'russian');
INSERT INTO emkt_regions VALUES(3232, 191, 'SL', 'Sool', 'russian');
INSERT INTO emkt_regions VALUES(3233, 191, 'TG', 'Togdheer', 'russian');
INSERT INTO emkt_regions VALUES(3234, 191, 'WG', 'Woqooyi Galbeed', 'russian');

INSERT INTO emkt_countries VALUES (192,'Южно-Африканская Республика','russian','ZA','ZAF','');

INSERT INTO emkt_regions VALUES(3235, 192, 'EC', 'Eastern Cape', 'russian');
INSERT INTO emkt_regions VALUES(3236, 192, 'FS', 'Free State', 'russian');
INSERT INTO emkt_regions VALUES(3237, 192, 'GT', 'Gauteng', 'russian');
INSERT INTO emkt_regions VALUES(3238, 192, 'LP', 'Limpopo', 'russian');
INSERT INTO emkt_regions VALUES(3239, 192, 'MP', 'Mpumalanga', 'russian');
INSERT INTO emkt_regions VALUES(3240, 192, 'NC', 'Northern Cape', 'russian');
INSERT INTO emkt_regions VALUES(3241, 192, 'NL', 'KwaZulu-Natal', 'russian');
INSERT INTO emkt_regions VALUES(3242, 192, 'NW', 'North-West', 'russian');
INSERT INTO emkt_regions VALUES(3243, 192, 'WC', 'Western Cape', 'russian');

INSERT INTO emkt_countries VALUES (193,'Южная Георгия и Южные Сандвичевы Острова','russian','GS','SGS','');

INSERT INTO emkt_regions VALUES(4274, 193, 'NOCODE', 'South Georgia and the South Sandwich Islands', 'russian');

INSERT INTO emkt_countries VALUES (194,'Испания','russian','ES','ESP','');

INSERT INTO emkt_regions VALUES(3244, 194, 'AN', 'Andalucía', 'russian');
INSERT INTO emkt_regions VALUES(3245, 194, 'AR', 'Aragón', 'russian');
INSERT INTO emkt_regions VALUES(3246, 194, 'A', 'Alicante', 'russian');
INSERT INTO emkt_regions VALUES(3247, 194, 'AB', 'Albacete', 'russian');
INSERT INTO emkt_regions VALUES(3248, 194, 'AL', 'Almería', 'russian');
INSERT INTO emkt_regions VALUES(3249, 194, 'AN', 'Andalucía', 'russian');
INSERT INTO emkt_regions VALUES(3250, 194, 'AV', 'Ávila', 'russian');
INSERT INTO emkt_regions VALUES(3251, 194, 'B', 'Barcelona', 'russian');
INSERT INTO emkt_regions VALUES(3252, 194, 'BA', 'Badajoz', 'russian');
INSERT INTO emkt_regions VALUES(3253, 194, 'BI', 'Vizcaya', 'russian');
INSERT INTO emkt_regions VALUES(3254, 194, 'BU', 'Burgos', 'russian');
INSERT INTO emkt_regions VALUES(3255, 194, 'C', 'A Coruña', 'russian');
INSERT INTO emkt_regions VALUES(3256, 194, 'CA', 'Cádiz', 'russian');
INSERT INTO emkt_regions VALUES(3257, 194, 'CC', 'Cáceres', 'russian');
INSERT INTO emkt_regions VALUES(3258, 194, 'CE', 'Ceuta', 'russian');
INSERT INTO emkt_regions VALUES(3259, 194, 'CL', 'Castilla y León', 'russian');
INSERT INTO emkt_regions VALUES(3260, 194, 'CM', 'Castilla-La Mancha', 'russian');
INSERT INTO emkt_regions VALUES(3261, 194, 'CN', 'Islas Canarias', 'russian');
INSERT INTO emkt_regions VALUES(3262, 194, 'CO', 'Córdoba', 'russian');
INSERT INTO emkt_regions VALUES(3263, 194, 'CR', 'Ciudad Real', 'russian');
INSERT INTO emkt_regions VALUES(3264, 194, 'CS', 'Castellón', 'russian');
INSERT INTO emkt_regions VALUES(3265, 194, 'CT', 'Catalonia', 'russian');
INSERT INTO emkt_regions VALUES(3266, 194, 'CU', 'Cuenca', 'russian');
INSERT INTO emkt_regions VALUES(3267, 194, 'EX', 'Extremadura', 'russian');
INSERT INTO emkt_regions VALUES(3268, 194, 'GA', 'Galicia', 'russian');
INSERT INTO emkt_regions VALUES(3269, 194, 'GC', 'Las Palmas', 'russian');
INSERT INTO emkt_regions VALUES(3270, 194, 'GI', 'Girona', 'russian');
INSERT INTO emkt_regions VALUES(3271, 194, 'GR', 'Granada', 'russian');
INSERT INTO emkt_regions VALUES(3272, 194, 'GU', 'Guadalajara', 'russian');
INSERT INTO emkt_regions VALUES(3273, 194, 'H', 'Huelva', 'russian');
INSERT INTO emkt_regions VALUES(3274, 194, 'HU', 'Huesca', 'russian');
INSERT INTO emkt_regions VALUES(3275, 194, 'IB', 'Islas Baleares', 'russian');
INSERT INTO emkt_regions VALUES(3276, 194, 'J', 'Jaén', 'russian');
INSERT INTO emkt_regions VALUES(3277, 194, 'L', 'Lleida', 'russian');
INSERT INTO emkt_regions VALUES(3278, 194, 'LE', 'León', 'russian');
INSERT INTO emkt_regions VALUES(3279, 194, 'LO', 'La Rioja', 'russian');
INSERT INTO emkt_regions VALUES(3280, 194, 'LU', 'Lugo', 'russian');
INSERT INTO emkt_regions VALUES(3281, 194, 'M', 'Madrid', 'russian');
INSERT INTO emkt_regions VALUES(3282, 194, 'MA', 'Málaga', 'russian');
INSERT INTO emkt_regions VALUES(3283, 194, 'ML', 'Melilla', 'russian');
INSERT INTO emkt_regions VALUES(3284, 194, 'MU', 'Murcia', 'russian');
INSERT INTO emkt_regions VALUES(3285, 194, 'NA', 'Navarre', 'russian');
INSERT INTO emkt_regions VALUES(3286, 194, 'O', 'Asturias', 'russian');
INSERT INTO emkt_regions VALUES(3287, 194, 'OR', 'Ourense', 'russian');
INSERT INTO emkt_regions VALUES(3288, 194, 'P', 'Palencia', 'russian');
INSERT INTO emkt_regions VALUES(3289, 194, 'PM', 'Baleares', 'russian');
INSERT INTO emkt_regions VALUES(3290, 194, 'PO', 'Pontevedra', 'russian');
INSERT INTO emkt_regions VALUES(3291, 194, 'PV', 'Basque Euskadi', 'russian');
INSERT INTO emkt_regions VALUES(3292, 194, 'S', 'Cantabria', 'russian');
INSERT INTO emkt_regions VALUES(3293, 194, 'SA', 'Salamanca', 'russian');
INSERT INTO emkt_regions VALUES(3294, 194, 'SE', 'Seville', 'russian');
INSERT INTO emkt_regions VALUES(3295, 194, 'SG', 'Segovia', 'russian');
INSERT INTO emkt_regions VALUES(3296, 194, 'SO', 'Soria', 'russian');
INSERT INTO emkt_regions VALUES(3297, 194, 'SS', 'Guipúzcoa', 'russian');
INSERT INTO emkt_regions VALUES(3298, 194, 'T', 'Tarragona', 'russian');
INSERT INTO emkt_regions VALUES(3299, 194, 'TE', 'Teruel', 'russian');
INSERT INTO emkt_regions VALUES(3300, 194, 'TF', 'Santa Cruz De Tenerife', 'russian');
INSERT INTO emkt_regions VALUES(3301, 194, 'TO', 'Toledo', 'russian');
INSERT INTO emkt_regions VALUES(3302, 194, 'V', 'Valencia', 'russian');
INSERT INTO emkt_regions VALUES(3303, 194, 'VA', 'Valladolid', 'russian');
INSERT INTO emkt_regions VALUES(3304, 194, 'VI', 'Álava', 'russian');
INSERT INTO emkt_regions VALUES(3305, 194, 'Z', 'Zaragoza', 'russian');
INSERT INTO emkt_regions VALUES(3306, 194, 'ZA', 'Zamora', 'russian');

INSERT INTO emkt_countries VALUES (195,'Шри-Ланка','russian','LK','LKA','');

INSERT INTO emkt_regions VALUES(3307, 195, 'CE', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(3308, 195, 'NC', 'North Central', 'russian');
INSERT INTO emkt_regions VALUES(3309, 195, 'NO', 'North', 'russian');
INSERT INTO emkt_regions VALUES(3310, 195, 'EA', 'Eastern', 'russian');
INSERT INTO emkt_regions VALUES(3311, 195, 'NW', 'North Western', 'russian');
INSERT INTO emkt_regions VALUES(3312, 195, 'SO', 'Southern', 'russian');
INSERT INTO emkt_regions VALUES(3313, 195, 'UV', 'Uva', 'russian');
INSERT INTO emkt_regions VALUES(3314, 195, 'SA', 'Sabaragamuwa', 'russian');
INSERT INTO emkt_regions VALUES(3315, 195, 'WE', 'Western', 'russian');

INSERT INTO emkt_countries VALUES (196,'Остров Святой Елены','russian','SH','SHN','');

INSERT INTO emkt_regions VALUES(4275, 196, 'NOCODE', 'St. Helena', 'russian');

INSERT INTO emkt_countries VALUES (197,'Сен-Пьер и Микелон','russian','PM','SPM','');

INSERT INTO emkt_regions VALUES(4276, 197, 'NOCODE', 'St. Pierre and Miquelon', 'russian');

INSERT INTO emkt_countries VALUES (198,'Судан','russian','SD','SDN','');

INSERT INTO emkt_regions VALUES(3316, 198, 'ANL', 'أعالي النيل', 'russian');
INSERT INTO emkt_regions VALUES(3317, 198, 'BAM', 'البحر الأحمر', 'russian');
INSERT INTO emkt_regions VALUES(3318, 198, 'BRT', 'البحيرات', 'russian');
INSERT INTO emkt_regions VALUES(3319, 198, 'JZR', 'ولاية الجزيرة', 'russian');
INSERT INTO emkt_regions VALUES(3320, 198, 'KRT', 'الخرطوم', 'russian');
INSERT INTO emkt_regions VALUES(3321, 198, 'QDR', 'القضارف', 'russian');
INSERT INTO emkt_regions VALUES(3322, 198, 'WDH', 'الوحدة', 'russian');
INSERT INTO emkt_regions VALUES(3323, 198, 'ANB', 'النيل الأبيض', 'russian');
INSERT INTO emkt_regions VALUES(3324, 198, 'ANZ', 'النيل الأزرق', 'russian');
INSERT INTO emkt_regions VALUES(3325, 198, 'ASH', 'الشمالية', 'russian');
INSERT INTO emkt_regions VALUES(3326, 198, 'BJA', 'الاستوائية الوسطى', 'russian');
INSERT INTO emkt_regions VALUES(3327, 198, 'GIS', 'غرب الاستوائية', 'russian');
INSERT INTO emkt_regions VALUES(3328, 198, 'GBG', 'غرب بحر الغزال', 'russian');
INSERT INTO emkt_regions VALUES(3329, 198, 'GDA', 'غرب دارفور', 'russian');
INSERT INTO emkt_regions VALUES(3330, 198, 'GKU', 'غرب كردفان', 'russian');
INSERT INTO emkt_regions VALUES(3331, 198, 'JDA', 'جنوب دارفور', 'russian');
INSERT INTO emkt_regions VALUES(3332, 198, 'JKU', 'جنوب كردفان', 'russian');
INSERT INTO emkt_regions VALUES(3333, 198, 'JQL', 'جونقلي', 'russian');
INSERT INTO emkt_regions VALUES(3334, 198, 'KSL', 'كسلا', 'russian');
INSERT INTO emkt_regions VALUES(3335, 198, 'NNL', 'ولاية نهر النيل', 'russian');
INSERT INTO emkt_regions VALUES(3336, 198, 'SBG', 'شمال بحر الغزال', 'russian');
INSERT INTO emkt_regions VALUES(3337, 198, 'SDA', 'شمال دارفور', 'russian');
INSERT INTO emkt_regions VALUES(3338, 198, 'SKU', 'شمال كردفان', 'russian');
INSERT INTO emkt_regions VALUES(3339, 198, 'SIS', 'شرق الاستوائية', 'russian');
INSERT INTO emkt_regions VALUES(3340, 198, 'SNR', 'سنار', 'russian');
INSERT INTO emkt_regions VALUES(3341, 198, 'WRB', 'واراب', 'russian');

INSERT INTO emkt_countries VALUES (199,'Суринам','russian','SR','SUR','');

INSERT INTO emkt_regions VALUES(3342, 199, 'BR', 'Brokopondo', 'russian');
INSERT INTO emkt_regions VALUES(3343, 199, 'CM', 'Commewijne', 'russian');
INSERT INTO emkt_regions VALUES(3344, 199, 'CR', 'Coronie', 'russian');
INSERT INTO emkt_regions VALUES(3345, 199, 'MA', 'Marowijne', 'russian');
INSERT INTO emkt_regions VALUES(3346, 199, 'NI', 'Nickerie', 'russian');
INSERT INTO emkt_regions VALUES(3347, 199, 'PM', 'Paramaribo', 'russian');
INSERT INTO emkt_regions VALUES(3348, 199, 'PR', 'Para', 'russian');
INSERT INTO emkt_regions VALUES(3349, 199, 'SA', 'Saramacca', 'russian');
INSERT INTO emkt_regions VALUES(3350, 199, 'SI', 'Sipaliwini', 'russian');
INSERT INTO emkt_regions VALUES(3351, 199, 'WA', 'Wanica', 'russian');

INSERT INTO emkt_countries VALUES (200,'Шпицберген и Ян-Майен','russian','SJ','SJM','');

INSERT INTO emkt_regions VALUES(4277, 200, 'NOCODE', 'Svalbard and Jan Mayen Islands', 'russian');

INSERT INTO emkt_countries VALUES (201,'Свазиленд','russian','SZ','SWZ','');

INSERT INTO emkt_regions VALUES(3352, 201, 'HH', 'Hhohho', 'russian');
INSERT INTO emkt_regions VALUES(3353, 201, 'LU', 'Lubombo', 'russian');
INSERT INTO emkt_regions VALUES(3354, 201, 'MA', 'Manzini', 'russian');
INSERT INTO emkt_regions VALUES(3355, 201, 'SH', 'Shiselweni', 'russian');

INSERT INTO emkt_countries VALUES (202,'Швеция','russian','SE','SWE','');

INSERT INTO emkt_regions VALUES(3356, 202, 'AB', 'Stockholms län', 'russian');
INSERT INTO emkt_regions VALUES(3357, 202, 'C', 'Uppsala län', 'russian');
INSERT INTO emkt_regions VALUES(3358, 202, 'D', 'Södermanlands län', 'russian');
INSERT INTO emkt_regions VALUES(3359, 202, 'E', 'Östergötlands län', 'russian');
INSERT INTO emkt_regions VALUES(3360, 202, 'F', 'Jönköpings län', 'russian');
INSERT INTO emkt_regions VALUES(3361, 202, 'G', 'Kronobergs län', 'russian');
INSERT INTO emkt_regions VALUES(3362, 202, 'H', 'Kalmar län', 'russian');
INSERT INTO emkt_regions VALUES(3363, 202, 'I', 'Gotlands län', 'russian');
INSERT INTO emkt_regions VALUES(3364, 202, 'K', 'Blekinge län', 'russian');
INSERT INTO emkt_regions VALUES(3365, 202, 'M', 'Skåne län', 'russian');
INSERT INTO emkt_regions VALUES(3366, 202, 'N', 'Hallands län', 'russian');
INSERT INTO emkt_regions VALUES(3367, 202, 'O', 'Västra Götalands län', 'russian');
INSERT INTO emkt_regions VALUES(3368, 202, 'S', 'Värmlands län;', 'russian');
INSERT INTO emkt_regions VALUES(3369, 202, 'T', 'Örebro län', 'russian');
INSERT INTO emkt_regions VALUES(3370, 202, 'U', 'Västmanlands län;', 'russian');
INSERT INTO emkt_regions VALUES(3371, 202, 'W', 'Dalarnas län', 'russian');
INSERT INTO emkt_regions VALUES(3372, 202, 'X', 'Gävleborgs län', 'russian');
INSERT INTO emkt_regions VALUES(3373, 202, 'Y', 'Västernorrlands län', 'russian');
INSERT INTO emkt_regions VALUES(3374, 202, 'Z', 'Jämtlands län', 'russian');
INSERT INTO emkt_regions VALUES(3375, 202, 'AC', 'Västerbottens län', 'russian');
INSERT INTO emkt_regions VALUES(3376, 202, 'BD', 'Norrbottens län', 'russian');

INSERT INTO emkt_countries VALUES (203,'Швейцария','russian','CH','CHE','');

INSERT INTO emkt_regions VALUES(3377, 203, 'ZH', 'Zürich', 'russian');
INSERT INTO emkt_regions VALUES(3378, 203, 'BE', 'Bern', 'russian');
INSERT INTO emkt_regions VALUES(3379, 203, 'LU', 'Luzern', 'russian');
INSERT INTO emkt_regions VALUES(3380, 203, 'UR', 'Uri', 'russian');
INSERT INTO emkt_regions VALUES(3381, 203, 'SZ', 'Schwyz', 'russian');
INSERT INTO emkt_regions VALUES(3382, 203, 'OW', 'Obwalden', 'russian');
INSERT INTO emkt_regions VALUES(3383, 203, 'NW', 'Nidwalden', 'russian');
INSERT INTO emkt_regions VALUES(3384, 203, 'GL', 'Glasrus', 'russian');
INSERT INTO emkt_regions VALUES(3385, 203, 'ZG', 'Zug', 'russian');
INSERT INTO emkt_regions VALUES(3386, 203, 'FR', 'Fribourg', 'russian');
INSERT INTO emkt_regions VALUES(3387, 203, 'SO', 'Solothurn', 'russian');
INSERT INTO emkt_regions VALUES(3388, 203, 'BS', 'Basel-Stadt', 'russian');
INSERT INTO emkt_regions VALUES(3389, 203, 'BL', 'Basel-Landschaft', 'russian');
INSERT INTO emkt_regions VALUES(3390, 203, 'SH', 'Schaffhausen', 'russian');
INSERT INTO emkt_regions VALUES(3391, 203, 'AR', 'Appenzell Ausserrhoden', 'russian');
INSERT INTO emkt_regions VALUES(3392, 203, 'AI', 'Appenzell Innerrhoden', 'russian');
INSERT INTO emkt_regions VALUES(3393, 203, 'SG', 'Saint Gallen', 'russian');
INSERT INTO emkt_regions VALUES(3394, 203, 'GR', 'Graubünden', 'russian');
INSERT INTO emkt_regions VALUES(3395, 203, 'AG', 'Aargau', 'russian');
INSERT INTO emkt_regions VALUES(3396, 203, 'TG', 'Thurgau', 'russian');
INSERT INTO emkt_regions VALUES(3397, 203, 'TI', 'Ticino', 'russian');
INSERT INTO emkt_regions VALUES(3398, 203, 'VD', 'Vaud', 'russian');
INSERT INTO emkt_regions VALUES(3399, 203, 'VS', 'Valais', 'russian');
INSERT INTO emkt_regions VALUES(3400, 203, 'NE', 'Nuechâtel', 'russian');
INSERT INTO emkt_regions VALUES(3401, 203, 'GE', 'Genève', 'russian');
INSERT INTO emkt_regions VALUES(3402, 203, 'JU', 'Jura', 'russian');

INSERT INTO emkt_countries VALUES (204,'Сирийская Арабская Республика','russian','SY','SYR','');

INSERT INTO emkt_regions VALUES(3403, 204, 'DI', 'دمشق', 'russian');
INSERT INTO emkt_regions VALUES(3404, 204, 'DR', 'درعا', 'russian');
INSERT INTO emkt_regions VALUES(3405, 204, 'DZ', 'دير الزور', 'russian');
INSERT INTO emkt_regions VALUES(3406, 204, 'HA', 'الحسكة', 'russian');
INSERT INTO emkt_regions VALUES(3407, 204, 'HI', 'حمص', 'russian');
INSERT INTO emkt_regions VALUES(3408, 204, 'HL', 'حلب', 'russian');
INSERT INTO emkt_regions VALUES(3409, 204, 'HM', 'حماه', 'russian');
INSERT INTO emkt_regions VALUES(3410, 204, 'ID', 'ادلب', 'russian');
INSERT INTO emkt_regions VALUES(3411, 204, 'LA', 'اللاذقية', 'russian');
INSERT INTO emkt_regions VALUES(3412, 204, 'QU', 'القنيطرة', 'russian');
INSERT INTO emkt_regions VALUES(3413, 204, 'RA', 'الرقة', 'russian');
INSERT INTO emkt_regions VALUES(3414, 204, 'RD', 'ریف دمشق', 'russian');
INSERT INTO emkt_regions VALUES(3415, 204, 'SU', 'السويداء', 'russian');
INSERT INTO emkt_regions VALUES(3416, 204, 'TA', 'طرطوس', 'russian');

INSERT INTO emkt_countries VALUES (205,'Тайвань','russian','TW','TWN','');

INSERT INTO emkt_regions VALUES(3417, 205, 'CHA', '彰化縣', 'russian');
INSERT INTO emkt_regions VALUES(3418, 205, 'CYI', '嘉義市', 'russian');
INSERT INTO emkt_regions VALUES(3419, 205, 'CYQ', '嘉義縣', 'russian');
INSERT INTO emkt_regions VALUES(3420, 205, 'HSQ', '新竹縣', 'russian');
INSERT INTO emkt_regions VALUES(3421, 205, 'HSZ', '新竹市', 'russian');
INSERT INTO emkt_regions VALUES(3422, 205, 'HUA', '花蓮縣', 'russian');
INSERT INTO emkt_regions VALUES(3423, 205, 'ILA', '宜蘭縣', 'russian');
INSERT INTO emkt_regions VALUES(3424, 205, 'KEE', '基隆市', 'russian');
INSERT INTO emkt_regions VALUES(3425, 205, 'KHH', '高雄市', 'russian');
INSERT INTO emkt_regions VALUES(3426, 205, 'KHQ', '高雄縣', 'russian');
INSERT INTO emkt_regions VALUES(3427, 205, 'MIA', '苗栗縣', 'russian');
INSERT INTO emkt_regions VALUES(3428, 205, 'NAN', '南投縣', 'russian');
INSERT INTO emkt_regions VALUES(3429, 205, 'PEN', '澎湖縣', 'russian');
INSERT INTO emkt_regions VALUES(3430, 205, 'PIF', '屏東縣', 'russian');
INSERT INTO emkt_regions VALUES(3431, 205, 'TAO', '桃源县', 'russian');
INSERT INTO emkt_regions VALUES(3432, 205, 'TNN', '台南市', 'russian');
INSERT INTO emkt_regions VALUES(3433, 205, 'TNQ', '台南縣', 'russian');
INSERT INTO emkt_regions VALUES(3434, 205, 'TPE', '臺北市', 'russian');
INSERT INTO emkt_regions VALUES(3435, 205, 'TPQ', '臺北縣', 'russian');
INSERT INTO emkt_regions VALUES(3436, 205, 'TTT', '台東縣', 'russian');
INSERT INTO emkt_regions VALUES(3437, 205, 'TXG', '台中市', 'russian');
INSERT INTO emkt_regions VALUES(3438, 205, 'TXQ', '台中縣', 'russian');
INSERT INTO emkt_regions VALUES(3439, 205, 'YUN', '雲林縣', 'russian');

INSERT INTO emkt_countries VALUES (206,'Таджикистан','russian','TJ','TJK','');

INSERT INTO emkt_regions VALUES(3440, 206, 'GB', 'کوهستان بدخشان', 'russian');
INSERT INTO emkt_regions VALUES(3441, 206, 'KT', 'ختلان', 'russian');
INSERT INTO emkt_regions VALUES(3442, 206, 'SU', 'سغد', 'russian');

INSERT INTO emkt_countries VALUES (207,'Танзания','russian','TZ','TZA','');

INSERT INTO emkt_regions VALUES(3443, 207, '01', 'Arusha', 'russian');
INSERT INTO emkt_regions VALUES(3444, 207, '02', 'Dar es Salaam', 'russian');
INSERT INTO emkt_regions VALUES(3445, 207, '03', 'Dodoma', 'russian');
INSERT INTO emkt_regions VALUES(3446, 207, '04', 'Iringa', 'russian');
INSERT INTO emkt_regions VALUES(3447, 207, '05', 'Kagera', 'russian');
INSERT INTO emkt_regions VALUES(3448, 207, '06', 'Pemba Sever', 'russian');
INSERT INTO emkt_regions VALUES(3449, 207, '07', 'Zanzibar Sever', 'russian');
INSERT INTO emkt_regions VALUES(3450, 207, '08', 'Kigoma', 'russian');
INSERT INTO emkt_regions VALUES(3451, 207, '09', 'Kilimanjaro', 'russian');
INSERT INTO emkt_regions VALUES(3452, 207, '10', 'Pemba Jih', 'russian');
INSERT INTO emkt_regions VALUES(3453, 207, '11', 'Zanzibar Jih', 'russian');
INSERT INTO emkt_regions VALUES(3454, 207, '12', 'Lindi', 'russian');
INSERT INTO emkt_regions VALUES(3455, 207, '13', 'Mara', 'russian');
INSERT INTO emkt_regions VALUES(3456, 207, '14', 'Mbeya', 'russian');
INSERT INTO emkt_regions VALUES(3457, 207, '15', 'Zanzibar Západ', 'russian');
INSERT INTO emkt_regions VALUES(3458, 207, '16', 'Morogoro', 'russian');
INSERT INTO emkt_regions VALUES(3459, 207, '17', 'Mtwara', 'russian');
INSERT INTO emkt_regions VALUES(3460, 207, '18', 'Mwanza', 'russian');
INSERT INTO emkt_regions VALUES(3461, 207, '19', 'Pwani', 'russian');
INSERT INTO emkt_regions VALUES(3462, 207, '20', 'Rukwa', 'russian');
INSERT INTO emkt_regions VALUES(3463, 207, '21', 'Ruvuma', 'russian');
INSERT INTO emkt_regions VALUES(3464, 207, '22', 'Shinyanga', 'russian');
INSERT INTO emkt_regions VALUES(3465, 207, '23', 'Singida', 'russian');
INSERT INTO emkt_regions VALUES(3466, 207, '24', 'Tabora', 'russian');
INSERT INTO emkt_regions VALUES(3467, 207, '25', 'Tanga', 'russian');
INSERT INTO emkt_regions VALUES(3468, 207, '26', 'Manyara', 'russian');

INSERT INTO emkt_countries VALUES (208,'Таиланд','russian','TH','THA','');

INSERT INTO emkt_regions VALUES(3469, 208, 'TH-10', 'กรุงเทพมหานคร', 'russian');
INSERT INTO emkt_regions VALUES(3470, 208, 'TH-11', 'สมุทรปราการ', 'russian');
INSERT INTO emkt_regions VALUES(3471, 208, 'TH-12', 'นนทบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3472, 208, 'TH-13', 'ปทุมธานี', 'russian');
INSERT INTO emkt_regions VALUES(3473, 208, 'TH-14', 'พระนครศรีอยุธยา', 'russian');
INSERT INTO emkt_regions VALUES(3474, 208, 'TH-15', 'อ่างทอง', 'russian');
INSERT INTO emkt_regions VALUES(3475, 208, 'TH-16', 'ลพบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3476, 208, 'TH-17', 'สิงห์บุรี', 'russian');
INSERT INTO emkt_regions VALUES(3477, 208, 'TH-18', 'ชัยนาท', 'russian');
INSERT INTO emkt_regions VALUES(3478, 208, 'TH-19', 'สระบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3479, 208, 'TH-20', 'ชลบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3480, 208, 'TH-21', 'ระยอง', 'russian');
INSERT INTO emkt_regions VALUES(3481, 208, 'TH-22', 'จันทบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3482, 208, 'TH-23', 'ตราด', 'russian');
INSERT INTO emkt_regions VALUES(3483, 208, 'TH-24', 'ฉะเชิงเทรา', 'russian');
INSERT INTO emkt_regions VALUES(3484, 208, 'TH-25', 'ปราจีนบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3485, 208, 'TH-26', 'นครนายก', 'russian');
INSERT INTO emkt_regions VALUES(3486, 208, 'TH-27', 'สระแก้ว', 'russian');
INSERT INTO emkt_regions VALUES(3487, 208, 'TH-30', 'นครราชสีมา', 'russian');
INSERT INTO emkt_regions VALUES(3488, 208, 'TH-31', 'บุรีรัมย์', 'russian');
INSERT INTO emkt_regions VALUES(3489, 208, 'TH-32', 'สุรินทร์', 'russian');
INSERT INTO emkt_regions VALUES(3490, 208, 'TH-33', 'ศรีสะเกษ', 'russian');
INSERT INTO emkt_regions VALUES(3491, 208, 'TH-34', 'อุบลราชธานี', 'russian');
INSERT INTO emkt_regions VALUES(3492, 208, 'TH-35', 'ยโสธร', 'russian');
INSERT INTO emkt_regions VALUES(3493, 208, 'TH-36', 'ชัยภูมิ', 'russian');
INSERT INTO emkt_regions VALUES(3494, 208, 'TH-37', 'อำนาจเจริญ', 'russian');
INSERT INTO emkt_regions VALUES(3495, 208, 'TH-39', 'หนองบัวลำภู', 'russian');
INSERT INTO emkt_regions VALUES(3496, 208, 'TH-40', 'ขอนแก่น', 'russian');
INSERT INTO emkt_regions VALUES(3497, 208, 'TH-41', 'อุดรธานี', 'russian');
INSERT INTO emkt_regions VALUES(3498, 208, 'TH-42', 'เลย', 'russian');
INSERT INTO emkt_regions VALUES(3499, 208, 'TH-43', 'หนองคาย', 'russian');
INSERT INTO emkt_regions VALUES(3500, 208, 'TH-44', 'มหาสารคาม', 'russian');
INSERT INTO emkt_regions VALUES(3501, 208, 'TH-45', 'ร้อยเอ็ด', 'russian');
INSERT INTO emkt_regions VALUES(3502, 208, 'TH-46', 'กาฬสินธุ์', 'russian');
INSERT INTO emkt_regions VALUES(3503, 208, 'TH-47', 'สกลนคร', 'russian');
INSERT INTO emkt_regions VALUES(3504, 208, 'TH-48', 'นครพนม', 'russian');
INSERT INTO emkt_regions VALUES(3505, 208, 'TH-49', 'มุกดาหาร', 'russian');
INSERT INTO emkt_regions VALUES(3506, 208, 'TH-50', 'เชียงใหม่', 'russian');
INSERT INTO emkt_regions VALUES(3507, 208, 'TH-51', 'ลำพูน', 'russian');
INSERT INTO emkt_regions VALUES(3508, 208, 'TH-52', 'ลำปาง', 'russian');
INSERT INTO emkt_regions VALUES(3509, 208, 'TH-53', 'อุตรดิตถ์', 'russian');
INSERT INTO emkt_regions VALUES(3510, 208, 'TH-55', 'น่าน', 'russian');
INSERT INTO emkt_regions VALUES(3511, 208, 'TH-56', 'พะเยา', 'russian');
INSERT INTO emkt_regions VALUES(3512, 208, 'TH-57', 'เชียงราย', 'russian');
INSERT INTO emkt_regions VALUES(3513, 208, 'TH-58', 'แม่ฮ่องสอน', 'russian');
INSERT INTO emkt_regions VALUES(3514, 208, 'TH-60', 'นครสวรรค์', 'russian');
INSERT INTO emkt_regions VALUES(3515, 208, 'TH-61', 'อุทัยธานี', 'russian');
INSERT INTO emkt_regions VALUES(3516, 208, 'TH-62', 'กำแพงเพชร', 'russian');
INSERT INTO emkt_regions VALUES(3517, 208, 'TH-63', 'ตาก', 'russian');
INSERT INTO emkt_regions VALUES(3518, 208, 'TH-64', 'สุโขทัย', 'russian');
INSERT INTO emkt_regions VALUES(3519, 208, 'TH-66', 'ชุมพร', 'russian');
INSERT INTO emkt_regions VALUES(3520, 208, 'TH-67', 'พิจิตร', 'russian');
INSERT INTO emkt_regions VALUES(3521, 208, 'TH-70', 'ราชบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3522, 208, 'TH-71', 'กาญจนบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3523, 208, 'TH-72', 'สุพรรณบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3524, 208, 'TH-73', 'นครปฐม', 'russian');
INSERT INTO emkt_regions VALUES(3525, 208, 'TH-74', 'สมุทรสาคร', 'russian');
INSERT INTO emkt_regions VALUES(3526, 208, 'TH-75', 'สมุทรสงคราม', 'russian');
INSERT INTO emkt_regions VALUES(3527, 208, 'TH-76', 'เพชรบุรี', 'russian');
INSERT INTO emkt_regions VALUES(3528, 208, 'TH-77', 'ประจวบคีรีขันธ์', 'russian');
INSERT INTO emkt_regions VALUES(3529, 208, 'TH-80', 'นครศรีธรรมราช', 'russian');
INSERT INTO emkt_regions VALUES(3530, 208, 'TH-81', 'กระบี่', 'russian');
INSERT INTO emkt_regions VALUES(3531, 208, 'TH-82', 'พังงา', 'russian');
INSERT INTO emkt_regions VALUES(3532, 208, 'TH-83', 'ภูเก็ต', 'russian');
INSERT INTO emkt_regions VALUES(3533, 208, 'TH-84', 'สุราษฎร์ธานี', 'russian');
INSERT INTO emkt_regions VALUES(3534, 208, 'TH-85', 'ระนอง', 'russian');
INSERT INTO emkt_regions VALUES(3535, 208, 'TH-86', 'ชุมพร', 'russian');
INSERT INTO emkt_regions VALUES(3536, 208, 'TH-90', 'สงขลา', 'russian');
INSERT INTO emkt_regions VALUES(3537, 208, 'TH-91', 'สตูล', 'russian');
INSERT INTO emkt_regions VALUES(3538, 208, 'TH-92', 'ตรัง', 'russian');
INSERT INTO emkt_regions VALUES(3539, 208, 'TH-93', 'พัทลุง', 'russian');
INSERT INTO emkt_regions VALUES(3540, 208, 'TH-94', 'ปัตตานี', 'russian');
INSERT INTO emkt_regions VALUES(3541, 208, 'TH-95', 'ยะลา', 'russian');
INSERT INTO emkt_regions VALUES(3542, 208, 'TH-96', 'นราธิวาส', 'russian');

INSERT INTO emkt_countries VALUES (209,'Того','russian','TG','TGO','');

INSERT INTO emkt_regions VALUES(3543, 209, 'C', 'Centrale', 'russian');
INSERT INTO emkt_regions VALUES(3544, 209, 'K', 'Kara', 'russian');
INSERT INTO emkt_regions VALUES(3545, 209, 'M', 'Maritime', 'russian');
INSERT INTO emkt_regions VALUES(3546, 209, 'P', 'Plateaux', 'russian');
INSERT INTO emkt_regions VALUES(3547, 209, 'S', 'Savanes', 'russian');

INSERT INTO emkt_countries VALUES (210,'Токелау','russian','TK','TKL','');

INSERT INTO emkt_regions VALUES(3548, 210, 'A', 'Atafu', 'russian');
INSERT INTO emkt_regions VALUES(3549, 210, 'F', 'Fakaofo', 'russian');
INSERT INTO emkt_regions VALUES(3550, 210, 'N', 'Nukunonu', 'russian');

INSERT INTO emkt_countries VALUES (211,'Тонга','russian','TO','TON','');

INSERT INTO emkt_regions VALUES(3551, 211, 'H', 'Ha\'apai', 'russian');
INSERT INTO emkt_regions VALUES(3552, 211, 'T', 'Tongatapu', 'russian');
INSERT INTO emkt_regions VALUES(3553, 211, 'V', 'Vava\'u', 'russian');

INSERT INTO emkt_countries VALUES (212,'Тринидад и Тобаго','russian','TT','TTO','');

INSERT INTO emkt_regions VALUES(3554, 212, 'ARI', 'Arima', 'russian');
INSERT INTO emkt_regions VALUES(3555, 212, 'CHA', 'Chaguanas', 'russian');
INSERT INTO emkt_regions VALUES(3556, 212, 'CTT', 'Couva-Tabaquite-Talparo', 'russian');
INSERT INTO emkt_regions VALUES(3557, 212, 'DMN', 'Diego Martin', 'russian');
INSERT INTO emkt_regions VALUES(3558, 212, 'ETO', 'Eastern Tobago', 'russian');
INSERT INTO emkt_regions VALUES(3559, 212, 'RCM', 'Rio Claro-Mayaro', 'russian');
INSERT INTO emkt_regions VALUES(3560, 212, 'PED', 'Penal-Debe', 'russian');
INSERT INTO emkt_regions VALUES(3561, 212, 'PTF', 'Point Fortin', 'russian');
INSERT INTO emkt_regions VALUES(3562, 212, 'POS', 'Port of Spain', 'russian');
INSERT INTO emkt_regions VALUES(3563, 212, 'PRT', 'Princes Town', 'russian');
INSERT INTO emkt_regions VALUES(3564, 212, 'SFO', 'San Fernando', 'russian');
INSERT INTO emkt_regions VALUES(3565, 212, 'SGE', 'Sangre Grande', 'russian');
INSERT INTO emkt_regions VALUES(3566, 212, 'SJL', 'San Juan-Laventille', 'russian');
INSERT INTO emkt_regions VALUES(3567, 212, 'SIP', 'Siparia', 'russian');
INSERT INTO emkt_regions VALUES(3568, 212, 'TUP', 'Tunapuna-Piarco', 'russian');
INSERT INTO emkt_regions VALUES(3569, 212, 'WTO', 'Western Tobago', 'russian');

INSERT INTO emkt_countries VALUES (213,'Тунис','russian','TN','TUN','');

INSERT INTO emkt_regions VALUES(3570, 213, '11', 'ولاية تونس', 'russian');
INSERT INTO emkt_regions VALUES(3571, 213, '12', 'ولاية أريانة', 'russian');
INSERT INTO emkt_regions VALUES(3572, 213, '13', 'ولاية بن عروس', 'russian');
INSERT INTO emkt_regions VALUES(3573, 213, '14', 'ولاية منوبة', 'russian');
INSERT INTO emkt_regions VALUES(3574, 213, '21', 'ولاية نابل', 'russian');
INSERT INTO emkt_regions VALUES(3575, 213, '22', 'ولاية زغوان', 'russian');
INSERT INTO emkt_regions VALUES(3576, 213, '23', 'ولاية بنزرت', 'russian');
INSERT INTO emkt_regions VALUES(3577, 213, '31', 'ولاية باجة', 'russian');
INSERT INTO emkt_regions VALUES(3578, 213, '32', 'ولاية جندوبة', 'russian');
INSERT INTO emkt_regions VALUES(3579, 213, '33', 'ولاية الكاف', 'russian');
INSERT INTO emkt_regions VALUES(3580, 213, '34', 'ولاية سليانة', 'russian');
INSERT INTO emkt_regions VALUES(3581, 213, '41', 'ولاية القيروان', 'russian');
INSERT INTO emkt_regions VALUES(3582, 213, '42', 'ولاية القصرين', 'russian');
INSERT INTO emkt_regions VALUES(3583, 213, '43', 'ولاية سيدي بوزيد', 'russian');
INSERT INTO emkt_regions VALUES(3584, 213, '51', 'ولاية سوسة', 'russian');
INSERT INTO emkt_regions VALUES(3585, 213, '52', 'ولاية المنستير', 'russian');
INSERT INTO emkt_regions VALUES(3586, 213, '53', 'ولاية المهدية', 'russian');
INSERT INTO emkt_regions VALUES(3587, 213, '61', 'ولاية صفاقس', 'russian');
INSERT INTO emkt_regions VALUES(3588, 213, '71', 'ولاية قفصة', 'russian');
INSERT INTO emkt_regions VALUES(3589, 213, '72', 'ولاية توزر', 'russian');
INSERT INTO emkt_regions VALUES(3590, 213, '73', 'ولاية قبلي', 'russian');
INSERT INTO emkt_regions VALUES(3591, 213, '81', 'ولاية قابس', 'russian');
INSERT INTO emkt_regions VALUES(3592, 213, '82', 'ولاية مدنين', 'russian');
INSERT INTO emkt_regions VALUES(3593, 213, '83', 'ولاية تطاوين', 'russian');

INSERT INTO emkt_countries VALUES (214,'Турция','russian','TR','TUR','');

INSERT INTO emkt_regions VALUES(3594, 214, '01', 'Adana', 'russian');
INSERT INTO emkt_regions VALUES(3595, 214, '02', 'Adıyaman', 'russian');
INSERT INTO emkt_regions VALUES(3596, 214, '03', 'Afyonkarahisar', 'russian');
INSERT INTO emkt_regions VALUES(3597, 214, '04', 'Ağrı', 'russian');
INSERT INTO emkt_regions VALUES(3598, 214, '05', 'Amasya', 'russian');
INSERT INTO emkt_regions VALUES(3599, 214, '06', 'Ankara', 'russian');
INSERT INTO emkt_regions VALUES(3600, 214, '07', 'Antalya', 'russian');
INSERT INTO emkt_regions VALUES(3601, 214, '08', 'Artvin', 'russian');
INSERT INTO emkt_regions VALUES(3602, 214, '09', 'Aydın', 'russian');
INSERT INTO emkt_regions VALUES(3603, 214, '10', 'Balıkesir', 'russian');
INSERT INTO emkt_regions VALUES(3604, 214, '11', 'Bilecik', 'russian');
INSERT INTO emkt_regions VALUES(3605, 214, '12', 'Bingöl', 'russian');
INSERT INTO emkt_regions VALUES(3606, 214, '13', 'Bitlis', 'russian');
INSERT INTO emkt_regions VALUES(3607, 214, '14', 'Bolu', 'russian');
INSERT INTO emkt_regions VALUES(3608, 214, '15', 'Burdur', 'russian');
INSERT INTO emkt_regions VALUES(3609, 214, '16', 'Bursa', 'russian');
INSERT INTO emkt_regions VALUES(3610, 214, '17', 'Çanakkale', 'russian');
INSERT INTO emkt_regions VALUES(3611, 214, '18', 'Çankırı', 'russian');
INSERT INTO emkt_regions VALUES(3612, 214, '19', 'Çorum', 'russian');
INSERT INTO emkt_regions VALUES(3613, 214, '20', 'Denizli', 'russian');
INSERT INTO emkt_regions VALUES(3614, 214, '21', 'Diyarbakır', 'russian');
INSERT INTO emkt_regions VALUES(3615, 214, '22', 'Edirne', 'russian');
INSERT INTO emkt_regions VALUES(3616, 214, '23', 'Elazığ', 'russian');
INSERT INTO emkt_regions VALUES(3617, 214, '24', 'Erzincan', 'russian');
INSERT INTO emkt_regions VALUES(3618, 214, '25', 'Erzurum', 'russian');
INSERT INTO emkt_regions VALUES(3619, 214, '26', 'Eskişehir', 'russian');
INSERT INTO emkt_regions VALUES(3620, 214, '27', 'Gaziantep', 'russian');
INSERT INTO emkt_regions VALUES(3621, 214, '28', 'Giresun', 'russian');
INSERT INTO emkt_regions VALUES(3622, 214, '29', 'Gümüşhane', 'russian');
INSERT INTO emkt_regions VALUES(3623, 214, '30', 'Hakkari', 'russian');
INSERT INTO emkt_regions VALUES(3624, 214, '31', 'Hatay', 'russian');
INSERT INTO emkt_regions VALUES(3625, 214, '32', 'Isparta', 'russian');
INSERT INTO emkt_regions VALUES(3626, 214, '33', 'Mersin', 'russian');
INSERT INTO emkt_regions VALUES(3627, 214, '34', 'İstanbul', 'russian');
INSERT INTO emkt_regions VALUES(3628, 214, '35', 'İzmir', 'russian');
INSERT INTO emkt_regions VALUES(3629, 214, '36', 'Kars', 'russian');
INSERT INTO emkt_regions VALUES(3630, 214, '37', 'Kastamonu', 'russian');
INSERT INTO emkt_regions VALUES(3631, 214, '38', 'Kayseri', 'russian');
INSERT INTO emkt_regions VALUES(3632, 214, '39', 'Kırklareli', 'russian');
INSERT INTO emkt_regions VALUES(3633, 214, '40', 'Kırşehir', 'russian');
INSERT INTO emkt_regions VALUES(3634, 214, '41', 'Kocaeli', 'russian');
INSERT INTO emkt_regions VALUES(3635, 214, '42', 'Konya', 'russian');
INSERT INTO emkt_regions VALUES(3636, 214, '43', 'Kütahya', 'russian');
INSERT INTO emkt_regions VALUES(3637, 214, '44', 'Malatya', 'russian');
INSERT INTO emkt_regions VALUES(3638, 214, '45', 'Manisa', 'russian');
INSERT INTO emkt_regions VALUES(3639, 214, '46', 'Kahramanmaraş', 'russian');
INSERT INTO emkt_regions VALUES(3640, 214, '47', 'Mardin', 'russian');
INSERT INTO emkt_regions VALUES(3641, 214, '48', 'Muğla', 'russian');
INSERT INTO emkt_regions VALUES(3642, 214, '49', 'Muş', 'russian');
INSERT INTO emkt_regions VALUES(3643, 214, '50', 'Nevşehir', 'russian');
INSERT INTO emkt_regions VALUES(3644, 214, '51', 'Niğde', 'russian');
INSERT INTO emkt_regions VALUES(3645, 214, '52', 'Ordu', 'russian');
INSERT INTO emkt_regions VALUES(3646, 214, '53', 'Rize', 'russian');
INSERT INTO emkt_regions VALUES(3647, 214, '54', 'Sakarya', 'russian');
INSERT INTO emkt_regions VALUES(3648, 214, '55', 'Samsun', 'russian');
INSERT INTO emkt_regions VALUES(3649, 214, '56', 'Siirt', 'russian');
INSERT INTO emkt_regions VALUES(3650, 214, '57', 'Sinop', 'russian');
INSERT INTO emkt_regions VALUES(3651, 214, '58', 'Sivas', 'russian');
INSERT INTO emkt_regions VALUES(3652, 214, '59', 'Tekirdağ', 'russian');
INSERT INTO emkt_regions VALUES(3653, 214, '60', 'Tokat', 'russian');
INSERT INTO emkt_regions VALUES(3654, 214, '61', 'Trabzon', 'russian');
INSERT INTO emkt_regions VALUES(3655, 214, '62', 'Tunceli', 'russian');
INSERT INTO emkt_regions VALUES(3656, 214, '63', 'Şanlıurfa', 'russian');
INSERT INTO emkt_regions VALUES(3657, 214, '64', 'Uşak', 'russian');
INSERT INTO emkt_regions VALUES(3658, 214, '65', 'Van', 'russian');
INSERT INTO emkt_regions VALUES(3659, 214, '66', 'Yozgat', 'russian');
INSERT INTO emkt_regions VALUES(3660, 214, '67', 'Zonguldak', 'russian');
INSERT INTO emkt_regions VALUES(3661, 214, '68', 'Aksaray', 'russian');
INSERT INTO emkt_regions VALUES(3662, 214, '69', 'Bayburt', 'russian');
INSERT INTO emkt_regions VALUES(3663, 214, '70', 'Karaman', 'russian');
INSERT INTO emkt_regions VALUES(3664, 214, '71', 'Kırıkkale', 'russian');
INSERT INTO emkt_regions VALUES(3665, 214, '72', 'Batman', 'russian');
INSERT INTO emkt_regions VALUES(3666, 214, '73', 'Şırnak', 'russian');
INSERT INTO emkt_regions VALUES(3667, 214, '74', 'Bartın', 'russian');
INSERT INTO emkt_regions VALUES(3668, 214, '75', 'Ardahan', 'russian');
INSERT INTO emkt_regions VALUES(3669, 214, '76', 'Iğdır', 'russian');
INSERT INTO emkt_regions VALUES(3670, 214, '77', 'Yalova', 'russian');
INSERT INTO emkt_regions VALUES(3671, 214, '78', 'Karabük', 'russian');
INSERT INTO emkt_regions VALUES(3672, 214, '79', 'Kilis', 'russian');
INSERT INTO emkt_regions VALUES(3673, 214, '80', 'Osmaniye', 'russian');
INSERT INTO emkt_regions VALUES(3674, 214, '81', 'Düzce', 'russian');

INSERT INTO emkt_countries VALUES (215,'Туркменистан','russian','TM','TKM','');

INSERT INTO emkt_regions VALUES(3675, 215, 'A', 'Ahal welaýaty', 'russian');
INSERT INTO emkt_regions VALUES(3676, 215, 'B', 'Balkan welaýaty', 'russian');
INSERT INTO emkt_regions VALUES(3677, 215, 'D', 'Daşoguz welaýaty', 'russian');
INSERT INTO emkt_regions VALUES(3678, 215, 'L', 'Lebap welaýaty', 'russian');
INSERT INTO emkt_regions VALUES(3679, 215, 'M', 'Mary welaýaty', 'russian');

INSERT INTO emkt_countries VALUES (216,'Теркс и Кайкос','russian','TC','TCA','');

INSERT INTO emkt_regions VALUES(3680, 216, 'AC', 'Ambergris Cays', 'russian');
INSERT INTO emkt_regions VALUES(3681, 216, 'DC', 'Dellis Cay', 'russian');
INSERT INTO emkt_regions VALUES(3682, 216, 'FC', 'French Cay', 'russian');
INSERT INTO emkt_regions VALUES(3683, 216, 'LW', 'Little Water Cay', 'russian');
INSERT INTO emkt_regions VALUES(3684, 216, 'RC', 'Parrot Cay', 'russian');
INSERT INTO emkt_regions VALUES(3685, 216, 'PN', 'Pine Cay', 'russian');
INSERT INTO emkt_regions VALUES(3686, 216, 'SL', 'Salt Cay', 'russian');
INSERT INTO emkt_regions VALUES(3687, 216, 'GT', 'Grand Turk', 'russian');
INSERT INTO emkt_regions VALUES(3688, 216, 'SC', 'South Caicos', 'russian');
INSERT INTO emkt_regions VALUES(3689, 216, 'EC', 'East Caicos', 'russian');
INSERT INTO emkt_regions VALUES(3690, 216, 'MC', 'Middle Caicos', 'russian');
INSERT INTO emkt_regions VALUES(3691, 216, 'NC', 'North Caicos', 'russian');
INSERT INTO emkt_regions VALUES(3692, 216, 'PR', 'Providenciales', 'russian');
INSERT INTO emkt_regions VALUES(3693, 216, 'WC', 'West Caicos', 'russian');

INSERT INTO emkt_countries VALUES (217,'Тувалу','russian','TV','TUV','');

INSERT INTO emkt_regions VALUES(3694, 217, 'FUN', 'Funafuti', 'russian');
INSERT INTO emkt_regions VALUES(3695, 217, 'NMA', 'Nanumea', 'russian');
INSERT INTO emkt_regions VALUES(3696, 217, 'NMG', 'Nanumanga', 'russian');
INSERT INTO emkt_regions VALUES(3697, 217, 'NIT', 'Niutao', 'russian');
INSERT INTO emkt_regions VALUES(3698, 217, 'NIU', 'Nui', 'russian');
INSERT INTO emkt_regions VALUES(3699, 217, 'NKF', 'Nukufetau', 'russian');
INSERT INTO emkt_regions VALUES(3700, 217, 'NKL', 'Nukulaelae', 'russian');
INSERT INTO emkt_regions VALUES(3701, 217, 'VAI', 'Vaitupu', 'russian');

INSERT INTO emkt_countries VALUES (218,'Уганда','russian','UG','UGA','');

INSERT INTO emkt_regions VALUES(3702, 218, '101', 'Kalangala', 'russian');
INSERT INTO emkt_regions VALUES(3703, 218, '102', 'Kampala', 'russian');
INSERT INTO emkt_regions VALUES(3704, 218, '103', 'Kiboga', 'russian');
INSERT INTO emkt_regions VALUES(3705, 218, '104', 'Luwero', 'russian');
INSERT INTO emkt_regions VALUES(3706, 218, '105', 'Masaka', 'russian');
INSERT INTO emkt_regions VALUES(3707, 218, '106', 'Mpigi', 'russian');
INSERT INTO emkt_regions VALUES(3708, 218, '107', 'Mubende', 'russian');
INSERT INTO emkt_regions VALUES(3709, 218, '108', 'Mukono', 'russian');
INSERT INTO emkt_regions VALUES(3710, 218, '109', 'Nakasongola', 'russian');
INSERT INTO emkt_regions VALUES(3711, 218, '110', 'Rakai', 'russian');
INSERT INTO emkt_regions VALUES(3712, 218, '111', 'Sembabule', 'russian');
INSERT INTO emkt_regions VALUES(3713, 218, '112', 'Kayunga', 'russian');
INSERT INTO emkt_regions VALUES(3714, 218, '113', 'Wakiso', 'russian');
INSERT INTO emkt_regions VALUES(3715, 218, '201', 'Bugiri', 'russian');
INSERT INTO emkt_regions VALUES(3716, 218, '202', 'Busia', 'russian');
INSERT INTO emkt_regions VALUES(3717, 218, '203', 'Iganga', 'russian');
INSERT INTO emkt_regions VALUES(3718, 218, '204', 'Jinja', 'russian');
INSERT INTO emkt_regions VALUES(3719, 218, '205', 'Kamuli', 'russian');
INSERT INTO emkt_regions VALUES(3720, 218, '206', 'Kapchorwa', 'russian');
INSERT INTO emkt_regions VALUES(3721, 218, '207', 'Katakwi', 'russian');
INSERT INTO emkt_regions VALUES(3722, 218, '208', 'Kumi', 'russian');
INSERT INTO emkt_regions VALUES(3723, 218, '209', 'Mbale', 'russian');
INSERT INTO emkt_regions VALUES(3724, 218, '210', 'Pallisa', 'russian');
INSERT INTO emkt_regions VALUES(3725, 218, '211', 'Soroti', 'russian');
INSERT INTO emkt_regions VALUES(3726, 218, '212', 'Tororo', 'russian');
INSERT INTO emkt_regions VALUES(3727, 218, '213', 'Kaberamaido', 'russian');
INSERT INTO emkt_regions VALUES(3728, 218, '214', 'Mayuge', 'russian');
INSERT INTO emkt_regions VALUES(3729, 218, '215', 'Sironko', 'russian');
INSERT INTO emkt_regions VALUES(3730, 218, '301', 'Adjumani', 'russian');
INSERT INTO emkt_regions VALUES(3731, 218, '302', 'Apac', 'russian');
INSERT INTO emkt_regions VALUES(3732, 218, '303', 'Arua', 'russian');
INSERT INTO emkt_regions VALUES(3733, 218, '304', 'Gulu', 'russian');
INSERT INTO emkt_regions VALUES(3734, 218, '305', 'Kitgum', 'russian');
INSERT INTO emkt_regions VALUES(3735, 218, '306', 'Kotido', 'russian');
INSERT INTO emkt_regions VALUES(3736, 218, '307', 'Lira', 'russian');
INSERT INTO emkt_regions VALUES(3737, 218, '308', 'Moroto', 'russian');
INSERT INTO emkt_regions VALUES(3738, 218, '309', 'Moyo', 'russian');
INSERT INTO emkt_regions VALUES(3739, 218, '310', 'Nebbi', 'russian');
INSERT INTO emkt_regions VALUES(3740, 218, '311', 'Nakapiripirit', 'russian');
INSERT INTO emkt_regions VALUES(3741, 218, '312', 'Pader', 'russian');
INSERT INTO emkt_regions VALUES(3742, 218, '313', 'Yumbe', 'russian');
INSERT INTO emkt_regions VALUES(3743, 218, '401', 'Bundibugyo', 'russian');
INSERT INTO emkt_regions VALUES(3744, 218, '402', 'Bushenyi', 'russian');
INSERT INTO emkt_regions VALUES(3745, 218, '403', 'Hoima', 'russian');
INSERT INTO emkt_regions VALUES(3746, 218, '404', 'Kabale', 'russian');
INSERT INTO emkt_regions VALUES(3747, 218, '405', 'Kabarole', 'russian');
INSERT INTO emkt_regions VALUES(3748, 218, '406', 'Kasese', 'russian');
INSERT INTO emkt_regions VALUES(3749, 218, '407', 'Kibale', 'russian');
INSERT INTO emkt_regions VALUES(3750, 218, '408', 'Kisoro', 'russian');
INSERT INTO emkt_regions VALUES(3751, 218, '409', 'Masindi', 'russian');
INSERT INTO emkt_regions VALUES(3752, 218, '410', 'Mbarara', 'russian');
INSERT INTO emkt_regions VALUES(3753, 218, '411', 'Ntungamo', 'russian');
INSERT INTO emkt_regions VALUES(3754, 218, '412', 'Rukungiri', 'russian');
INSERT INTO emkt_regions VALUES(3755, 218, '413', 'Kamwenge', 'russian');
INSERT INTO emkt_regions VALUES(3756, 218, '414', 'Kanungu', 'russian');
INSERT INTO emkt_regions VALUES(3757, 218, '415', 'Kyenjojo', 'russian');

INSERT INTO emkt_countries VALUES (219,'Украина','russian','UA','UKR','');

INSERT INTO emkt_regions VALUES(3758, 219, '05', 'Вінницька область', 'russian');
INSERT INTO emkt_regions VALUES(3759, 219, '07', 'Волинська область', 'russian');
INSERT INTO emkt_regions VALUES(3760, 219, '09', 'Луганська область', 'russian');
INSERT INTO emkt_regions VALUES(3761, 219, '12', 'Дніпропетровська область', 'russian');
INSERT INTO emkt_regions VALUES(3762, 219, '14', 'Донецька область', 'russian');
INSERT INTO emkt_regions VALUES(3763, 219, '18', 'Житомирська область', 'russian');
INSERT INTO emkt_regions VALUES(3764, 219, '19', 'Рівненська область', 'russian');
INSERT INTO emkt_regions VALUES(3765, 219, '21', 'Закарпатська область', 'russian');
INSERT INTO emkt_regions VALUES(3766, 219, '23', 'Запорізька область', 'russian');
INSERT INTO emkt_regions VALUES(3767, 219, '26', 'Івано-Франківська область', 'russian');
INSERT INTO emkt_regions VALUES(3768, 219, '30', 'Київ', 'russian');
INSERT INTO emkt_regions VALUES(3769, 219, '32', 'Київська область', 'russian');
INSERT INTO emkt_regions VALUES(3770, 219, '35', 'Кіровоградська область', 'russian');
INSERT INTO emkt_regions VALUES(3771, 219, '46', 'Львівська область', 'russian');
INSERT INTO emkt_regions VALUES(3772, 219, '48', 'Миколаївська область', 'russian');
INSERT INTO emkt_regions VALUES(3773, 219, '51', 'Одеська область', 'russian');
INSERT INTO emkt_regions VALUES(3774, 219, '53', 'Полтавська область', 'russian');
INSERT INTO emkt_regions VALUES(3775, 219, '59', 'Сумська область', 'russian');
INSERT INTO emkt_regions VALUES(3776, 219, '61', 'Тернопільська область', 'russian');
INSERT INTO emkt_regions VALUES(3777, 219, '63', 'Харківська область', 'russian');
INSERT INTO emkt_regions VALUES(3778, 219, '65', 'Херсонська область', 'russian');
INSERT INTO emkt_regions VALUES(3779, 219, '68', 'Хмельницька область', 'russian');
INSERT INTO emkt_regions VALUES(3780, 219, '71', 'Черкаська область', 'russian');
INSERT INTO emkt_regions VALUES(3781, 219, '74', 'Чернігівська область', 'russian');
INSERT INTO emkt_regions VALUES(3782, 219, '77', 'Чернівецька область', 'russian');

INSERT INTO emkt_countries VALUES (220,'Объединённые Арабские Эмираты','russian','AE','ARE','');

INSERT INTO emkt_regions VALUES(4278, 220, 'NOCODE', 'United Arab Emirates', 'russian');

INSERT INTO emkt_countries VALUES (221,'Великобритания','russian','GB','GBR','');

INSERT INTO emkt_regions VALUES(3783, 221, 'ABD', 'Aberdeenshire', 'russian');
INSERT INTO emkt_regions VALUES(3784, 221, 'ABE', 'Aberdeen', 'russian');
INSERT INTO emkt_regions VALUES(3785, 221, 'AGB', 'Argyll and Bute', 'russian');
INSERT INTO emkt_regions VALUES(3786, 221, 'AGY', 'Isle of Anglesey', 'russian');
INSERT INTO emkt_regions VALUES(3787, 221, 'ANS', 'Angus', 'russian');
INSERT INTO emkt_regions VALUES(3788, 221, 'ANT', 'Antrim', 'russian');
INSERT INTO emkt_regions VALUES(3789, 221, 'ARD', 'Ards', 'russian');
INSERT INTO emkt_regions VALUES(3790, 221, 'ARM', 'Armagh', 'russian');
INSERT INTO emkt_regions VALUES(3791, 221, 'BAS', 'Bath and North East Somerset', 'russian');
INSERT INTO emkt_regions VALUES(3792, 221, 'BBD', 'Blackburn with Darwen', 'russian');
INSERT INTO emkt_regions VALUES(3793, 221, 'BDF', 'Bedfordshire', 'russian');
INSERT INTO emkt_regions VALUES(3794, 221, 'BDG', 'Barking and Dagenham', 'russian');
INSERT INTO emkt_regions VALUES(3795, 221, 'BEN', 'Brent', 'russian');
INSERT INTO emkt_regions VALUES(3796, 221, 'BEX', 'Bexley', 'russian');
INSERT INTO emkt_regions VALUES(3797, 221, 'BFS', 'Belfast', 'russian');
INSERT INTO emkt_regions VALUES(3798, 221, 'BGE', 'Bridgend', 'russian');
INSERT INTO emkt_regions VALUES(3799, 221, 'BGW', 'Blaenau Gwent', 'russian');
INSERT INTO emkt_regions VALUES(3800, 221, 'BIR', 'Birmingham', 'russian');
INSERT INTO emkt_regions VALUES(3801, 221, 'BKM', 'Buckinghamshire', 'russian');
INSERT INTO emkt_regions VALUES(3802, 221, 'BLA', 'Ballymena', 'russian');
INSERT INTO emkt_regions VALUES(3803, 221, 'BLY', 'Ballymoney', 'russian');
INSERT INTO emkt_regions VALUES(3804, 221, 'BMH', 'Bournemouth', 'russian');
INSERT INTO emkt_regions VALUES(3805, 221, 'BNB', 'Banbridge', 'russian');
INSERT INTO emkt_regions VALUES(3806, 221, 'BNE', 'Barnet', 'russian');
INSERT INTO emkt_regions VALUES(3807, 221, 'BNH', 'Brighton and Hove', 'russian');
INSERT INTO emkt_regions VALUES(3808, 221, 'BNS', 'Barnsley', 'russian');
INSERT INTO emkt_regions VALUES(3809, 221, 'BOL', 'Bolton', 'russian');
INSERT INTO emkt_regions VALUES(3810, 221, 'BPL', 'Blackpool', 'russian');
INSERT INTO emkt_regions VALUES(3811, 221, 'BRC', 'Bracknell', 'russian');
INSERT INTO emkt_regions VALUES(3812, 221, 'BRD', 'Bradford', 'russian');
INSERT INTO emkt_regions VALUES(3813, 221, 'BRY', 'Bromley', 'russian');
INSERT INTO emkt_regions VALUES(3814, 221, 'BST', 'Bristol', 'russian');
INSERT INTO emkt_regions VALUES(3815, 221, 'BUR', 'Bury', 'russian');
INSERT INTO emkt_regions VALUES(3816, 221, 'CAM', 'Cambridgeshire', 'russian');
INSERT INTO emkt_regions VALUES(3817, 221, 'CAY', 'Caerphilly', 'russian');
INSERT INTO emkt_regions VALUES(3818, 221, 'CGN', 'Ceredigion', 'russian');
INSERT INTO emkt_regions VALUES(3819, 221, 'CGV', 'Craigavon', 'russian');
INSERT INTO emkt_regions VALUES(3820, 221, 'CHS', 'Cheshire', 'russian');
INSERT INTO emkt_regions VALUES(3821, 221, 'CKF', 'Carrickfergus', 'russian');
INSERT INTO emkt_regions VALUES(3822, 221, 'CKT', 'Cookstown', 'russian');
INSERT INTO emkt_regions VALUES(3823, 221, 'CLD', 'Calderdale', 'russian');
INSERT INTO emkt_regions VALUES(3824, 221, 'CLK', 'Clackmannanshire', 'russian');
INSERT INTO emkt_regions VALUES(3825, 221, 'CLR', 'Coleraine', 'russian');
INSERT INTO emkt_regions VALUES(3826, 221, 'CMA', 'Cumbria', 'russian');
INSERT INTO emkt_regions VALUES(3827, 221, 'CMD', 'Camden', 'russian');
INSERT INTO emkt_regions VALUES(3828, 221, 'CMN', 'Carmarthenshire', 'russian');
INSERT INTO emkt_regions VALUES(3829, 221, 'CON', 'Cornwall', 'russian');
INSERT INTO emkt_regions VALUES(3830, 221, 'COV', 'Coventry', 'russian');
INSERT INTO emkt_regions VALUES(3831, 221, 'CRF', 'Cardiff', 'russian');
INSERT INTO emkt_regions VALUES(3832, 221, 'CRY', 'Croydon', 'russian');
INSERT INTO emkt_regions VALUES(3833, 221, 'CSR', 'Castlereagh', 'russian');
INSERT INTO emkt_regions VALUES(3834, 221, 'CWY', 'Conwy', 'russian');
INSERT INTO emkt_regions VALUES(3835, 221, 'DAL', 'Darlington', 'russian');
INSERT INTO emkt_regions VALUES(3836, 221, 'DBY', 'Derbyshire', 'russian');
INSERT INTO emkt_regions VALUES(3837, 221, 'DEN', 'Denbighshire', 'russian');
INSERT INTO emkt_regions VALUES(3838, 221, 'DER', 'Derby', 'russian');
INSERT INTO emkt_regions VALUES(3839, 221, 'DEV', 'Devon', 'russian');
INSERT INTO emkt_regions VALUES(3840, 221, 'DGN', 'Dungannon and South Tyrone', 'russian');
INSERT INTO emkt_regions VALUES(3841, 221, 'DGY', 'Dumfries and Galloway', 'russian');
INSERT INTO emkt_regions VALUES(3842, 221, 'DNC', 'Doncaster', 'russian');
INSERT INTO emkt_regions VALUES(3843, 221, 'DND', 'Dundee', 'russian');
INSERT INTO emkt_regions VALUES(3844, 221, 'DOR', 'Dorset', 'russian');
INSERT INTO emkt_regions VALUES(3845, 221, 'DOW', 'Down', 'russian');
INSERT INTO emkt_regions VALUES(3846, 221, 'DRY', 'Derry', 'russian');
INSERT INTO emkt_regions VALUES(3847, 221, 'DUD', 'Dudley', 'russian');
INSERT INTO emkt_regions VALUES(3848, 221, 'DUR', 'Durham', 'russian');
INSERT INTO emkt_regions VALUES(3849, 221, 'EAL', 'Ealing', 'russian');
INSERT INTO emkt_regions VALUES(3850, 221, 'EAY', 'East Ayrshire', 'russian');
INSERT INTO emkt_regions VALUES(3851, 221, 'EDH', 'Edinburgh', 'russian');
INSERT INTO emkt_regions VALUES(3852, 221, 'EDU', 'East Dunbartonshire', 'russian');
INSERT INTO emkt_regions VALUES(3853, 221, 'ELN', 'East Lothian', 'russian');
INSERT INTO emkt_regions VALUES(3854, 221, 'ELS', 'Eilean Siar', 'russian');
INSERT INTO emkt_regions VALUES(3855, 221, 'ENF', 'Enfield', 'russian');
INSERT INTO emkt_regions VALUES(3856, 221, 'ERW', 'East Renfrewshire', 'russian');
INSERT INTO emkt_regions VALUES(3857, 221, 'ERY', 'East Riding of Yorkshire', 'russian');
INSERT INTO emkt_regions VALUES(3858, 221, 'ESS', 'Essex', 'russian');
INSERT INTO emkt_regions VALUES(3859, 221, 'ESX', 'East Sussex', 'russian');
INSERT INTO emkt_regions VALUES(3860, 221, 'FAL', 'Falkirk', 'russian');
INSERT INTO emkt_regions VALUES(3861, 221, 'FER', 'Fermanagh', 'russian');
INSERT INTO emkt_regions VALUES(3862, 221, 'FIF', 'Fife', 'russian');
INSERT INTO emkt_regions VALUES(3863, 221, 'FLN', 'Flintshire', 'russian');
INSERT INTO emkt_regions VALUES(3864, 221, 'GAT', 'Gateshead', 'russian');
INSERT INTO emkt_regions VALUES(3865, 221, 'GLG', 'Glasgow', 'russian');
INSERT INTO emkt_regions VALUES(3866, 221, 'GLS', 'Gloucestershire', 'russian');
INSERT INTO emkt_regions VALUES(3867, 221, 'GRE', 'Greenwich', 'russian');
INSERT INTO emkt_regions VALUES(3868, 221, 'GSY', 'Guernsey', 'russian');
INSERT INTO emkt_regions VALUES(3869, 221, 'GWN', 'Gwynedd', 'russian');
INSERT INTO emkt_regions VALUES(3870, 221, 'HAL', 'Halton', 'russian');
INSERT INTO emkt_regions VALUES(3871, 221, 'HAM', 'Hampshire', 'russian');
INSERT INTO emkt_regions VALUES(3872, 221, 'HAV', 'Havering', 'russian');
INSERT INTO emkt_regions VALUES(3873, 221, 'HCK', 'Hackney', 'russian');
INSERT INTO emkt_regions VALUES(3874, 221, 'HEF', 'Herefordshire', 'russian');
INSERT INTO emkt_regions VALUES(3875, 221, 'HIL', 'Hillingdon', 'russian');
INSERT INTO emkt_regions VALUES(3876, 221, 'HLD', 'Highland', 'russian');
INSERT INTO emkt_regions VALUES(3877, 221, 'HMF', 'Hammersmith and Fulham', 'russian');
INSERT INTO emkt_regions VALUES(3878, 221, 'HNS', 'Hounslow', 'russian');
INSERT INTO emkt_regions VALUES(3879, 221, 'HPL', 'Hartlepool', 'russian');
INSERT INTO emkt_regions VALUES(3880, 221, 'HRT', 'Hertfordshire', 'russian');
INSERT INTO emkt_regions VALUES(3881, 221, 'HRW', 'Harrow', 'russian');
INSERT INTO emkt_regions VALUES(3882, 221, 'HRY', 'Haringey', 'russian');
INSERT INTO emkt_regions VALUES(3883, 221, 'IOS', 'Isles of Scilly', 'russian');
INSERT INTO emkt_regions VALUES(3884, 221, 'IOW', 'Isle of Wight', 'russian');
INSERT INTO emkt_regions VALUES(3885, 221, 'ISL', 'Islington', 'russian');
INSERT INTO emkt_regions VALUES(3886, 221, 'IVC', 'Inverclyde', 'russian');
INSERT INTO emkt_regions VALUES(3887, 221, 'JSY', 'Jersey', 'russian');
INSERT INTO emkt_regions VALUES(3888, 221, 'KEC', 'Kensington and Chelsea', 'russian');
INSERT INTO emkt_regions VALUES(3889, 221, 'KEN', 'Kent', 'russian');
INSERT INTO emkt_regions VALUES(3890, 221, 'KHL', 'Kingston upon Hull', 'russian');
INSERT INTO emkt_regions VALUES(3891, 221, 'KIR', 'Kirklees', 'russian');
INSERT INTO emkt_regions VALUES(3892, 221, 'KTT', 'Kingston upon Thames', 'russian');
INSERT INTO emkt_regions VALUES(3893, 221, 'KWL', 'Knowsley', 'russian');
INSERT INTO emkt_regions VALUES(3894, 221, 'LAN', 'Lancashire', 'russian');
INSERT INTO emkt_regions VALUES(3895, 221, 'LBH', 'Lambeth', 'russian');
INSERT INTO emkt_regions VALUES(3896, 221, 'LCE', 'Leicester', 'russian');
INSERT INTO emkt_regions VALUES(3897, 221, 'LDS', 'Leeds', 'russian');
INSERT INTO emkt_regions VALUES(3898, 221, 'LEC', 'Leicestershire', 'russian');
INSERT INTO emkt_regions VALUES(3899, 221, 'LEW', 'Lewisham', 'russian');
INSERT INTO emkt_regions VALUES(3900, 221, 'LIN', 'Lincolnshire', 'russian');
INSERT INTO emkt_regions VALUES(3901, 221, 'LIV', 'Liverpool', 'russian');
INSERT INTO emkt_regions VALUES(3902, 221, 'LMV', 'Limavady', 'russian');
INSERT INTO emkt_regions VALUES(3903, 221, 'LND', 'London', 'russian');
INSERT INTO emkt_regions VALUES(3904, 221, 'LRN', 'Larne', 'russian');
INSERT INTO emkt_regions VALUES(3905, 221, 'LSB', 'Lisburn', 'russian');
INSERT INTO emkt_regions VALUES(3906, 221, 'LUT', 'Luton', 'russian');
INSERT INTO emkt_regions VALUES(3907, 221, 'MAN', 'Manchester', 'russian');
INSERT INTO emkt_regions VALUES(3908, 221, 'MDB', 'Middlesbrough', 'russian');
INSERT INTO emkt_regions VALUES(3909, 221, 'MDW', 'Medway', 'russian');
INSERT INTO emkt_regions VALUES(3910, 221, 'MFT', 'Magherafelt', 'russian');
INSERT INTO emkt_regions VALUES(3911, 221, 'MIK', 'Milton Keynes', 'russian');
INSERT INTO emkt_regions VALUES(3912, 221, 'MLN', 'Midlothian', 'russian');
INSERT INTO emkt_regions VALUES(3913, 221, 'MON', 'Monmouthshire', 'russian');
INSERT INTO emkt_regions VALUES(3914, 221, 'MRT', 'Merton', 'russian');
INSERT INTO emkt_regions VALUES(3915, 221, 'MRY', 'Moray', 'russian');
INSERT INTO emkt_regions VALUES(3916, 221, 'MTY', 'Merthyr Tydfil', 'russian');
INSERT INTO emkt_regions VALUES(3917, 221, 'MYL', 'Moyle', 'russian');
INSERT INTO emkt_regions VALUES(3918, 221, 'NAY', 'North Ayrshire', 'russian');
INSERT INTO emkt_regions VALUES(3919, 221, 'NBL', 'Northumberland', 'russian');
INSERT INTO emkt_regions VALUES(3920, 221, 'NDN', 'North Down', 'russian');
INSERT INTO emkt_regions VALUES(3921, 221, 'NEL', 'North East Lincolnshire', 'russian');
INSERT INTO emkt_regions VALUES(3922, 221, 'NET', 'Newcastle upon Tyne', 'russian');
INSERT INTO emkt_regions VALUES(3923, 221, 'NFK', 'Norfolk', 'russian');
INSERT INTO emkt_regions VALUES(3924, 221, 'NGM', 'Nottingham', 'russian');
INSERT INTO emkt_regions VALUES(3925, 221, 'NLK', 'North Lanarkshire', 'russian');
INSERT INTO emkt_regions VALUES(3926, 221, 'NLN', 'North Lincolnshire', 'russian');
INSERT INTO emkt_regions VALUES(3927, 221, 'NSM', 'North Somerset', 'russian');
INSERT INTO emkt_regions VALUES(3928, 221, 'NTA', 'Newtownabbey', 'russian');
INSERT INTO emkt_regions VALUES(3929, 221, 'NTH', 'Northamptonshire', 'russian');
INSERT INTO emkt_regions VALUES(3930, 221, 'NTL', 'Neath Port Talbot', 'russian');
INSERT INTO emkt_regions VALUES(3931, 221, 'NTT', 'Nottinghamshire', 'russian');
INSERT INTO emkt_regions VALUES(3932, 221, 'NTY', 'North Tyneside', 'russian');
INSERT INTO emkt_regions VALUES(3933, 221, 'NWM', 'Newham', 'russian');
INSERT INTO emkt_regions VALUES(3934, 221, 'NWP', 'Newport', 'russian');
INSERT INTO emkt_regions VALUES(3935, 221, 'NYK', 'North Yorkshire', 'russian');
INSERT INTO emkt_regions VALUES(3936, 221, 'NYM', 'Newry and Mourne', 'russian');
INSERT INTO emkt_regions VALUES(3937, 221, 'OLD', 'Oldham', 'russian');
INSERT INTO emkt_regions VALUES(3938, 221, 'OMH', 'Omagh', 'russian');
INSERT INTO emkt_regions VALUES(3939, 221, 'ORK', 'Orkney Islands', 'russian');
INSERT INTO emkt_regions VALUES(3940, 221, 'OXF', 'Oxfordshire', 'russian');
INSERT INTO emkt_regions VALUES(3941, 221, 'PEM', 'Pembrokeshire', 'russian');
INSERT INTO emkt_regions VALUES(3942, 221, 'PKN', 'Perth and Kinross', 'russian');
INSERT INTO emkt_regions VALUES(3943, 221, 'PLY', 'Plymouth', 'russian');
INSERT INTO emkt_regions VALUES(3944, 221, 'POL', 'Poole', 'russian');
INSERT INTO emkt_regions VALUES(3945, 221, 'POR', 'Portsmouth', 'russian');
INSERT INTO emkt_regions VALUES(3946, 221, 'POW', 'Powys', 'russian');
INSERT INTO emkt_regions VALUES(3947, 221, 'PTE', 'Peterborough', 'russian');
INSERT INTO emkt_regions VALUES(3948, 221, 'RCC', 'Redcar and Cleveland', 'russian');
INSERT INTO emkt_regions VALUES(3949, 221, 'RCH', 'Rochdale', 'russian');
INSERT INTO emkt_regions VALUES(3950, 221, 'RCT', 'Rhondda Cynon Taf', 'russian');
INSERT INTO emkt_regions VALUES(3951, 221, 'RDB', 'Redbridge', 'russian');
INSERT INTO emkt_regions VALUES(3952, 221, 'RDG', 'Reading', 'russian');
INSERT INTO emkt_regions VALUES(3953, 221, 'RFW', 'Renfrewshire', 'russian');
INSERT INTO emkt_regions VALUES(3954, 221, 'RIC', 'Richmond upon Thames', 'russian');
INSERT INTO emkt_regions VALUES(3955, 221, 'ROT', 'Rotherham', 'russian');
INSERT INTO emkt_regions VALUES(3956, 221, 'RUT', 'Rutland', 'russian');
INSERT INTO emkt_regions VALUES(3957, 221, 'SAW', 'Sandwell', 'russian');
INSERT INTO emkt_regions VALUES(3958, 221, 'SAY', 'South Ayrshire', 'russian');
INSERT INTO emkt_regions VALUES(3959, 221, 'SCB', 'Scottish Borders', 'russian');
INSERT INTO emkt_regions VALUES(3960, 221, 'SFK', 'Suffolk', 'russian');
INSERT INTO emkt_regions VALUES(3961, 221, 'SFT', 'Sefton', 'russian');
INSERT INTO emkt_regions VALUES(3962, 221, 'SGC', 'South Gloucestershire', 'russian');
INSERT INTO emkt_regions VALUES(3963, 221, 'SHF', 'Sheffield', 'russian');
INSERT INTO emkt_regions VALUES(3964, 221, 'SHN', 'Saint Helens', 'russian');
INSERT INTO emkt_regions VALUES(3965, 221, 'SHR', 'Shropshire', 'russian');
INSERT INTO emkt_regions VALUES(3966, 221, 'SKP', 'Stockport', 'russian');
INSERT INTO emkt_regions VALUES(3967, 221, 'SLF', 'Salford', 'russian');
INSERT INTO emkt_regions VALUES(3968, 221, 'SLG', 'Slough', 'russian');
INSERT INTO emkt_regions VALUES(3969, 221, 'SLK', 'South Lanarkshire', 'russian');
INSERT INTO emkt_regions VALUES(3970, 221, 'SND', 'Sunderland', 'russian');
INSERT INTO emkt_regions VALUES(3971, 221, 'SOL', 'Solihull', 'russian');
INSERT INTO emkt_regions VALUES(3972, 221, 'SOM', 'Somerset', 'russian');
INSERT INTO emkt_regions VALUES(3973, 221, 'SOS', 'Southend-on-Sea', 'russian');
INSERT INTO emkt_regions VALUES(3974, 221, 'SRY', 'Surrey', 'russian');
INSERT INTO emkt_regions VALUES(3975, 221, 'STB', 'Strabane', 'russian');
INSERT INTO emkt_regions VALUES(3976, 221, 'STE', 'Stoke-on-Trent', 'russian');
INSERT INTO emkt_regions VALUES(3977, 221, 'STG', 'Stirling', 'russian');
INSERT INTO emkt_regions VALUES(3978, 221, 'STH', 'Southampton', 'russian');
INSERT INTO emkt_regions VALUES(3979, 221, 'STN', 'Sutton', 'russian');
INSERT INTO emkt_regions VALUES(3980, 221, 'STS', 'Staffordshire', 'russian');
INSERT INTO emkt_regions VALUES(3981, 221, 'STT', 'Stockton-on-Tees', 'russian');
INSERT INTO emkt_regions VALUES(3982, 221, 'STY', 'South Tyneside', 'russian');
INSERT INTO emkt_regions VALUES(3983, 221, 'SWA', 'Swansea', 'russian');
INSERT INTO emkt_regions VALUES(3984, 221, 'SWD', 'Swindon', 'russian');
INSERT INTO emkt_regions VALUES(3985, 221, 'SWK', 'Southwark', 'russian');
INSERT INTO emkt_regions VALUES(3986, 221, 'TAM', 'Tameside', 'russian');
INSERT INTO emkt_regions VALUES(3987, 221, 'TFW', 'Telford and Wrekin', 'russian');
INSERT INTO emkt_regions VALUES(3988, 221, 'THR', 'Thurrock', 'russian');
INSERT INTO emkt_regions VALUES(3989, 221, 'TOB', 'Torbay', 'russian');
INSERT INTO emkt_regions VALUES(3990, 221, 'TOF', 'Torfaen', 'russian');
INSERT INTO emkt_regions VALUES(3991, 221, 'TRF', 'Trafford', 'russian');
INSERT INTO emkt_regions VALUES(3992, 221, 'TWH', 'Tower Hamlets', 'russian');
INSERT INTO emkt_regions VALUES(3993, 221, 'VGL', 'Vale of Glamorgan', 'russian');
INSERT INTO emkt_regions VALUES(3994, 221, 'WAR', 'Warwickshire', 'russian');
INSERT INTO emkt_regions VALUES(3995, 221, 'WBK', 'West Berkshire', 'russian');
INSERT INTO emkt_regions VALUES(3996, 221, 'WDU', 'West Dunbartonshire', 'russian');
INSERT INTO emkt_regions VALUES(3997, 221, 'WFT', 'Waltham Forest', 'russian');
INSERT INTO emkt_regions VALUES(3998, 221, 'WGN', 'Wigan', 'russian');
INSERT INTO emkt_regions VALUES(3999, 221, 'WIL', 'Wiltshire', 'russian');
INSERT INTO emkt_regions VALUES(4000, 221, 'WKF', 'Wakefield', 'russian');
INSERT INTO emkt_regions VALUES(4001, 221, 'WLL', 'Walsall', 'russian');
INSERT INTO emkt_regions VALUES(4002, 221, 'WLN', 'West Lothian', 'russian');
INSERT INTO emkt_regions VALUES(4003, 221, 'WLV', 'Wolverhampton', 'russian');
INSERT INTO emkt_regions VALUES(4004, 221, 'WNM', 'Windsor and Maidenhead', 'russian');
INSERT INTO emkt_regions VALUES(4005, 221, 'WOK', 'Wokingham', 'russian');
INSERT INTO emkt_regions VALUES(4006, 221, 'WOR', 'Worcestershire', 'russian');
INSERT INTO emkt_regions VALUES(4007, 221, 'WRL', 'Wirral', 'russian');
INSERT INTO emkt_regions VALUES(4008, 221, 'WRT', 'Warrington', 'russian');
INSERT INTO emkt_regions VALUES(4009, 221, 'WRX', 'Wrexham', 'russian');
INSERT INTO emkt_regions VALUES(4010, 221, 'WSM', 'Westminster', 'russian');
INSERT INTO emkt_regions VALUES(4011, 221, 'WSX', 'West Sussex', 'russian');
INSERT INTO emkt_regions VALUES(4012, 221, 'YOR', 'York', 'russian');
INSERT INTO emkt_regions VALUES(4013, 221, 'ZET', 'Shetland Islands', 'russian');

INSERT INTO emkt_countries VALUES (222,'Соединённые Штаты Америки','russian','US','USA','');

INSERT INTO emkt_regions VALUES(4014, 222, 'AK', 'Alaska', 'russian');
INSERT INTO emkt_regions VALUES(4015, 222, 'AL', 'Alabama', 'russian');
INSERT INTO emkt_regions VALUES(4016, 222, 'AS', 'American Samoa', 'russian');
INSERT INTO emkt_regions VALUES(4017, 222, 'AR', 'Arkansas', 'russian');
INSERT INTO emkt_regions VALUES(4018, 222, 'AZ', 'Arizona', 'russian');
INSERT INTO emkt_regions VALUES(4019, 222, 'CA', 'California', 'russian');
INSERT INTO emkt_regions VALUES(4020, 222, 'CO', 'Colorado', 'russian');
INSERT INTO emkt_regions VALUES(4021, 222, 'CT', 'Connecticut', 'russian');
INSERT INTO emkt_regions VALUES(4022, 222, 'DC', 'District of Columbia', 'russian');
INSERT INTO emkt_regions VALUES(4023, 222, 'DE', 'Delaware', 'russian');
INSERT INTO emkt_regions VALUES(4024, 222, 'FL', 'Florida', 'russian');
INSERT INTO emkt_regions VALUES(4025, 222, 'GA', 'Georgia', 'russian');
INSERT INTO emkt_regions VALUES(4026, 222, 'GU', 'Guam', 'russian');
INSERT INTO emkt_regions VALUES(4027, 222, 'HI', 'Hawaii', 'russian');
INSERT INTO emkt_regions VALUES(4028, 222, 'IA', 'Iowa', 'russian');
INSERT INTO emkt_regions VALUES(4029, 222, 'ID', 'Idaho', 'russian');
INSERT INTO emkt_regions VALUES(4030, 222, 'IL', 'Illinois', 'russian');
INSERT INTO emkt_regions VALUES(4031, 222, 'IN', 'Indiana', 'russian');
INSERT INTO emkt_regions VALUES(4032, 222, 'KS', 'Kansas', 'russian');
INSERT INTO emkt_regions VALUES(4033, 222, 'KY', 'Kentucky', 'russian');
INSERT INTO emkt_regions VALUES(4034, 222, 'LA', 'Louisiana', 'russian');
INSERT INTO emkt_regions VALUES(4035, 222, 'MA', 'Massachusetts', 'russian');
INSERT INTO emkt_regions VALUES(4036, 222, 'MD', 'Maryland', 'russian');
INSERT INTO emkt_regions VALUES(4037, 222, 'ME', 'Maine', 'russian');
INSERT INTO emkt_regions VALUES(4038, 222, 'MI', 'Michigan', 'russian');
INSERT INTO emkt_regions VALUES(4039, 222, 'MN', 'Minnesota', 'russian');
INSERT INTO emkt_regions VALUES(4040, 222, 'MO', 'Missouri', 'russian');
INSERT INTO emkt_regions VALUES(4041, 222, 'MS', 'Mississippi', 'russian');
INSERT INTO emkt_regions VALUES(4042, 222, 'MT', 'Montana', 'russian');
INSERT INTO emkt_regions VALUES(4043, 222, 'NC', 'North Carolina', 'russian');
INSERT INTO emkt_regions VALUES(4044, 222, 'ND', 'North Dakota', 'russian');
INSERT INTO emkt_regions VALUES(4045, 222, 'NE', 'Nebraska', 'russian');
INSERT INTO emkt_regions VALUES(4046, 222, 'NH', 'New Hampshire', 'russian');
INSERT INTO emkt_regions VALUES(4047, 222, 'NJ', 'New Jersey', 'russian');
INSERT INTO emkt_regions VALUES(4048, 222, 'NM', 'New Mexico', 'russian');
INSERT INTO emkt_regions VALUES(4049, 222, 'NV', 'Nevada', 'russian');
INSERT INTO emkt_regions VALUES(4050, 222, 'NY', 'New York', 'russian');
INSERT INTO emkt_regions VALUES(4051, 222, 'MP', 'Northern Mariana Islands', 'russian');
INSERT INTO emkt_regions VALUES(4052, 222, 'OH', 'Ohio', 'russian');
INSERT INTO emkt_regions VALUES(4053, 222, 'OK', 'Oklahoma', 'russian');
INSERT INTO emkt_regions VALUES(4054, 222, 'OR', 'Oregon', 'russian');
INSERT INTO emkt_regions VALUES(4055, 222, 'PA', 'Pennsylvania', 'russian');
INSERT INTO emkt_regions VALUES(4056, 222, 'PR', 'Puerto Rico', 'russian');
INSERT INTO emkt_regions VALUES(4057, 222, 'RI', 'Rhode Island', 'russian');
INSERT INTO emkt_regions VALUES(4058, 222, 'SC', 'South Carolina', 'russian');
INSERT INTO emkt_regions VALUES(4059, 222, 'SD', 'South Dakota', 'russian');
INSERT INTO emkt_regions VALUES(4060, 222, 'TN', 'Tennessee', 'russian');
INSERT INTO emkt_regions VALUES(4061, 222, 'TX', 'Texas', 'russian');
INSERT INTO emkt_regions VALUES(4062, 222, 'UM', 'U.S. Minor Outlying Islands', 'russian');
INSERT INTO emkt_regions VALUES(4063, 222, 'UT', 'Utah', 'russian');
INSERT INTO emkt_regions VALUES(4064, 222, 'VA', 'Virginia', 'russian');
INSERT INTO emkt_regions VALUES(4065, 222, 'VI', 'Virgin Islands of the U.S.', 'russian');
INSERT INTO emkt_regions VALUES(4066, 222, 'VT', 'Vermont', 'russian');
INSERT INTO emkt_regions VALUES(4067, 222, 'WA', 'Washington', 'russian');
INSERT INTO emkt_regions VALUES(4068, 222, 'WI', 'Wisconsin', 'russian');
INSERT INTO emkt_regions VALUES(4069, 222, 'WV', 'West Virginia', 'russian');
INSERT INTO emkt_regions VALUES(4070, 222, 'WY', 'Wyoming', 'russian');

INSERT INTO emkt_countries VALUES (223,'Внешние малые острова США','russian','UM','UMI','');

INSERT INTO emkt_regions VALUES(4071, 223, 'BI', 'Baker Island', 'russian');
INSERT INTO emkt_regions VALUES(4072, 223, 'HI', 'Howland Island', 'russian');
INSERT INTO emkt_regions VALUES(4073, 223, 'JI', 'Jarvis Island', 'russian');
INSERT INTO emkt_regions VALUES(4074, 223, 'JA', 'Johnston Atoll', 'russian');
INSERT INTO emkt_regions VALUES(4075, 223, 'KR', 'Kingman Reef', 'russian');
INSERT INTO emkt_regions VALUES(4076, 223, 'MA', 'Midway Atoll', 'russian');
INSERT INTO emkt_regions VALUES(4077, 223, 'NI', 'Navassa Island', 'russian');
INSERT INTO emkt_regions VALUES(4078, 223, 'PA', 'Palmyra Atoll', 'russian');
INSERT INTO emkt_regions VALUES(4079, 223, 'WI', 'Wake Island', 'russian');

INSERT INTO emkt_countries VALUES (224,'Уругвай','russian','UY','URY','');

INSERT INTO emkt_regions VALUES(4080, 224, 'AR', 'Artigas', 'russian');
INSERT INTO emkt_regions VALUES(4081, 224, 'CA', 'Canelones', 'russian');
INSERT INTO emkt_regions VALUES(4082, 224, 'CL', 'Cerro Largo', 'russian');
INSERT INTO emkt_regions VALUES(4083, 224, 'CO', 'Colonia', 'russian');
INSERT INTO emkt_regions VALUES(4084, 224, 'DU', 'Durazno', 'russian');
INSERT INTO emkt_regions VALUES(4085, 224, 'FD', 'Florida', 'russian');
INSERT INTO emkt_regions VALUES(4086, 224, 'FS', 'Flores', 'russian');
INSERT INTO emkt_regions VALUES(4087, 224, 'LA', 'Lavalleja', 'russian');
INSERT INTO emkt_regions VALUES(4088, 224, 'MA', 'Maldonado', 'russian');
INSERT INTO emkt_regions VALUES(4089, 224, 'MO', 'Montevideo', 'russian');
INSERT INTO emkt_regions VALUES(4090, 224, 'PA', 'Paysandu', 'russian');
INSERT INTO emkt_regions VALUES(4091, 224, 'RN', 'Río Negro', 'russian');
INSERT INTO emkt_regions VALUES(4092, 224, 'RO', 'Rocha', 'russian');
INSERT INTO emkt_regions VALUES(4093, 224, 'RV', 'Rivera', 'russian');
INSERT INTO emkt_regions VALUES(4094, 224, 'SA', 'Salto', 'russian');
INSERT INTO emkt_regions VALUES(4095, 224, 'SJ', 'San José', 'russian');
INSERT INTO emkt_regions VALUES(4096, 224, 'SO', 'Soriano', 'russian');
INSERT INTO emkt_regions VALUES(4097, 224, 'TA', 'Tacuarembó', 'russian');
INSERT INTO emkt_regions VALUES(4098, 224, 'TT', 'Treinta y Tres', 'russian');

INSERT INTO emkt_countries VALUES (225,'Узбекистан','russian','UZ','UZB','');

INSERT INTO emkt_regions VALUES(4099, 225, 'AN', 'Andijon viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4100, 225, 'BU', 'Buxoro viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4101, 225, 'FA', 'Farg\'ona viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4102, 225, 'JI', 'Jizzax viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4103, 225, 'NG', 'Namangan viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4104, 225, 'NW', 'Navoiy viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4105, 225, 'QA', 'Qashqadaryo viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4106, 225, 'QR', 'Qoraqalpog\'iston Respublikasi', 'russian');
INSERT INTO emkt_regions VALUES(4107, 225, 'SA', 'Samarqand viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4108, 225, 'SI', 'Sirdaryo viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4109, 225, 'SU', 'Surxondaryo viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4110, 225, 'TK', 'Toshkent', 'russian');
INSERT INTO emkt_regions VALUES(4111, 225, 'TO', 'Toshkent viloyati', 'russian');
INSERT INTO emkt_regions VALUES(4112, 225, 'XO', 'Xorazm viloyati', 'russian');

INSERT INTO emkt_countries VALUES (226,'Вануату','russian','VU','VUT','');

INSERT INTO emkt_regions VALUES(4113, 226, 'MAP', 'Malampa', 'russian');
INSERT INTO emkt_regions VALUES(4114, 226, 'PAM', 'Pénama', 'russian');
INSERT INTO emkt_regions VALUES(4115, 226, 'SAM', 'Sanma', 'russian');
INSERT INTO emkt_regions VALUES(4116, 226, 'SEE', 'Shéfa', 'russian');
INSERT INTO emkt_regions VALUES(4117, 226, 'TAE', 'Taféa', 'russian');
INSERT INTO emkt_regions VALUES(4118, 226, 'TOB', 'Torba', 'russian');

INSERT INTO emkt_countries VALUES (227,'Ватикан','russian','VA','VAT','');

INSERT INTO emkt_regions VALUES(4279, 227, 'NOCODE', 'Vatican City State (Holy See)', 'russian');

INSERT INTO emkt_countries VALUES (228,'Венесуэла','russian','VE','VEN','');

INSERT INTO emkt_regions VALUES(4119, 228, 'A', 'Distrito Capital', 'russian');
INSERT INTO emkt_regions VALUES(4120, 228, 'B', 'Anzoátegui', 'russian');
INSERT INTO emkt_regions VALUES(4121, 228, 'C', 'Apure', 'russian');
INSERT INTO emkt_regions VALUES(4122, 228, 'D', 'Aragua', 'russian');
INSERT INTO emkt_regions VALUES(4123, 228, 'E', 'Barinas', 'russian');
INSERT INTO emkt_regions VALUES(4124, 228, 'F', 'Bolívar', 'russian');
INSERT INTO emkt_regions VALUES(4125, 228, 'G', 'Carabobo', 'russian');
INSERT INTO emkt_regions VALUES(4126, 228, 'H', 'Cojedes', 'russian');
INSERT INTO emkt_regions VALUES(4127, 228, 'I', 'Falcón', 'russian');
INSERT INTO emkt_regions VALUES(4128, 228, 'J', 'Guárico', 'russian');
INSERT INTO emkt_regions VALUES(4129, 228, 'K', 'Lara', 'russian');
INSERT INTO emkt_regions VALUES(4130, 228, 'L', 'Mérida', 'russian');
INSERT INTO emkt_regions VALUES(4131, 228, 'M', 'Miranda', 'russian');
INSERT INTO emkt_regions VALUES(4132, 228, 'N', 'Monagas', 'russian');
INSERT INTO emkt_regions VALUES(4133, 228, 'O', 'Nueva Esparta', 'russian');
INSERT INTO emkt_regions VALUES(4134, 228, 'P', 'Portuguesa', 'russian');
INSERT INTO emkt_regions VALUES(4135, 228, 'R', 'Sucre', 'russian');
INSERT INTO emkt_regions VALUES(4136, 228, 'S', 'Tachira', 'russian');
INSERT INTO emkt_regions VALUES(4137, 228, 'T', 'Trujillo', 'russian');
INSERT INTO emkt_regions VALUES(4138, 228, 'U', 'Yaracuy', 'russian');
INSERT INTO emkt_regions VALUES(4139, 228, 'V', 'Zulia', 'russian');
INSERT INTO emkt_regions VALUES(4140, 228, 'W', 'Capital Dependencia', 'russian');
INSERT INTO emkt_regions VALUES(4141, 228, 'X', 'Vargas', 'russian');
INSERT INTO emkt_regions VALUES(4142, 228, 'Y', 'Delta Amacuro', 'russian');
INSERT INTO emkt_regions VALUES(4143, 228, 'Z', 'Amazonas', 'russian');

INSERT INTO emkt_countries VALUES (229,'Вьетнам','russian','VN','VNM','');

INSERT INTO emkt_regions VALUES(4144, 229, '01', 'Lai Châu', 'russian');
INSERT INTO emkt_regions VALUES(4145, 229, '02', 'Lào Cai', 'russian');
INSERT INTO emkt_regions VALUES(4146, 229, '03', 'Hà Giang', 'russian');
INSERT INTO emkt_regions VALUES(4147, 229, '04', 'Cao Bằng', 'russian');
INSERT INTO emkt_regions VALUES(4148, 229, '05', 'Sơn La', 'russian');
INSERT INTO emkt_regions VALUES(4149, 229, '06', 'Yên Bái', 'russian');
INSERT INTO emkt_regions VALUES(4150, 229, '07', 'Tuyên Quang', 'russian');
INSERT INTO emkt_regions VALUES(4151, 229, '09', 'Lạng Sơn', 'russian');
INSERT INTO emkt_regions VALUES(4152, 229, '13', 'Quảng Ninh', 'russian');
INSERT INTO emkt_regions VALUES(4153, 229, '14', 'Hòa Bình', 'russian');
INSERT INTO emkt_regions VALUES(4154, 229, '15', 'Hà Tây', 'russian');
INSERT INTO emkt_regions VALUES(4155, 229, '18', 'Ninh Bình', 'russian');
INSERT INTO emkt_regions VALUES(4156, 229, '20', 'Thái Bình', 'russian');
INSERT INTO emkt_regions VALUES(4157, 229, '21', 'Thanh Hóa', 'russian');
INSERT INTO emkt_regions VALUES(4158, 229, '22', 'Nghệ An', 'russian');
INSERT INTO emkt_regions VALUES(4159, 229, '23', 'Hà Tĩnh', 'russian');
INSERT INTO emkt_regions VALUES(4160, 229, '24', 'Quảng Bình', 'russian');
INSERT INTO emkt_regions VALUES(4161, 229, '25', 'Quảng Trị', 'russian');
INSERT INTO emkt_regions VALUES(4162, 229, '26', 'Thừa Thiên-Huế', 'russian');
INSERT INTO emkt_regions VALUES(4163, 229, '27', 'Quảng Nam', 'russian');
INSERT INTO emkt_regions VALUES(4164, 229, '28', 'Kon Tum', 'russian');
INSERT INTO emkt_regions VALUES(4165, 229, '29', 'Quảng Ngãi', 'russian');
INSERT INTO emkt_regions VALUES(4166, 229, '30', 'Gia Lai', 'russian');
INSERT INTO emkt_regions VALUES(4167, 229, '31', 'Bình Định', 'russian');
INSERT INTO emkt_regions VALUES(4168, 229, '32', 'Phú Yên', 'russian');
INSERT INTO emkt_regions VALUES(4169, 229, '33', 'Đắk Lắk', 'russian');
INSERT INTO emkt_regions VALUES(4170, 229, '34', 'Khánh Hòa', 'russian');
INSERT INTO emkt_regions VALUES(4171, 229, '35', 'Lâm Đồng', 'russian');
INSERT INTO emkt_regions VALUES(4172, 229, '36', 'Ninh Thuận', 'russian');
INSERT INTO emkt_regions VALUES(4173, 229, '37', 'Tây Ninh', 'russian');
INSERT INTO emkt_regions VALUES(4174, 229, '39', 'Đồng Nai', 'russian');
INSERT INTO emkt_regions VALUES(4175, 229, '40', 'Bình Thuận', 'russian');
INSERT INTO emkt_regions VALUES(4176, 229, '41', 'Long An', 'russian');
INSERT INTO emkt_regions VALUES(4177, 229, '43', 'Bà Rịa-Vũng Tàu', 'russian');
INSERT INTO emkt_regions VALUES(4178, 229, '44', 'An Giang', 'russian');
INSERT INTO emkt_regions VALUES(4179, 229, '45', 'Đồng Tháp', 'russian');
INSERT INTO emkt_regions VALUES(4180, 229, '46', 'Tiền Giang', 'russian');
INSERT INTO emkt_regions VALUES(4181, 229, '47', 'Kiên Giang', 'russian');
INSERT INTO emkt_regions VALUES(4182, 229, '48', 'Cần Thơ', 'russian');
INSERT INTO emkt_regions VALUES(4183, 229, '49', 'Vĩnh Long', 'russian');
INSERT INTO emkt_regions VALUES(4184, 229, '50', 'Bến Tre', 'russian');
INSERT INTO emkt_regions VALUES(4185, 229, '51', 'Trà Vinh', 'russian');
INSERT INTO emkt_regions VALUES(4186, 229, '52', 'Sóc Trăng', 'russian');
INSERT INTO emkt_regions VALUES(4187, 229, '53', 'Bắc Kạn', 'russian');
INSERT INTO emkt_regions VALUES(4188, 229, '54', 'Bắc Giang', 'russian');
INSERT INTO emkt_regions VALUES(4189, 229, '55', 'Bạc Liêu', 'russian');
INSERT INTO emkt_regions VALUES(4190, 229, '56', 'Bắc Ninh', 'russian');
INSERT INTO emkt_regions VALUES(4191, 229, '57', 'Bình Dương', 'russian');
INSERT INTO emkt_regions VALUES(4192, 229, '58', 'Bình Phước', 'russian');
INSERT INTO emkt_regions VALUES(4193, 229, '59', 'Cà Mau', 'russian');
INSERT INTO emkt_regions VALUES(4194, 229, '60', 'Đà Nẵng', 'russian');
INSERT INTO emkt_regions VALUES(4195, 229, '61', 'Hải Dương', 'russian');
INSERT INTO emkt_regions VALUES(4196, 229, '62', 'Hải Phòng', 'russian');
INSERT INTO emkt_regions VALUES(4197, 229, '63', 'Hà Nam', 'russian');
INSERT INTO emkt_regions VALUES(4198, 229, '64', 'Hà Nội', 'russian');
INSERT INTO emkt_regions VALUES(4199, 229, '65', 'Sài Gòn', 'russian');
INSERT INTO emkt_regions VALUES(4200, 229, '66', 'Hưng Yên', 'russian');
INSERT INTO emkt_regions VALUES(4201, 229, '67', 'Nam Định', 'russian');
INSERT INTO emkt_regions VALUES(4202, 229, '68', 'Phú Thọ', 'russian');
INSERT INTO emkt_regions VALUES(4203, 229, '69', 'Thái Nguyên', 'russian');
INSERT INTO emkt_regions VALUES(4204, 229, '70', 'Vĩnh Phúc', 'russian');
INSERT INTO emkt_regions VALUES(4205, 229, '71', 'Điện Biên', 'russian');
INSERT INTO emkt_regions VALUES(4206, 229, '72', 'Đắk Nông', 'russian');
INSERT INTO emkt_regions VALUES(4207, 229, '73', 'Hậu Giang', 'russian');

INSERT INTO emkt_countries VALUES (230,'Британские Виргинские острова','russian','VG','VGB','');

INSERT INTO emkt_regions VALUES(4280, 230, 'NOCODE', 'Virgin Islands (British)', 'russian');

INSERT INTO emkt_countries VALUES (231,'Американские Виргинские острова','russian','VI','VIR','');

INSERT INTO emkt_regions VALUES(4208, 231, 'C', 'Saint Croix', 'russian');
INSERT INTO emkt_regions VALUES(4209, 231, 'J', 'Saint John', 'russian');
INSERT INTO emkt_regions VALUES(4210, 231, 'T', 'Saint Thomas', 'russian');

INSERT INTO emkt_countries VALUES (232,'Уоллис и Футуна','russian','WF','WLF','');

INSERT INTO emkt_regions VALUES(4211, 232, 'A', 'Alo', 'russian');
INSERT INTO emkt_regions VALUES(4212, 232, 'S', 'Sigave', 'russian');
INSERT INTO emkt_regions VALUES(4213, 232, 'W', 'Wallis', 'russian');

INSERT INTO emkt_countries VALUES (233,'Западная Сахара','russian','EH','ESH','');

INSERT INTO emkt_regions VALUES(4281, 233, 'NOCODE', 'Western Sahara', 'russian');

INSERT INTO emkt_countries VALUES (234,'Йемен','russian','YE','YEM','');

INSERT INTO emkt_regions VALUES(4214, 234, 'AB', 'أبين‎', 'russian');
INSERT INTO emkt_regions VALUES(4215, 234, 'AD', 'عدن', 'russian');
INSERT INTO emkt_regions VALUES(4216, 234, 'AM', 'عمران', 'russian');
INSERT INTO emkt_regions VALUES(4217, 234, 'BA', 'البيضاء', 'russian');
INSERT INTO emkt_regions VALUES(4218, 234, 'DA', 'الضالع', 'russian');
INSERT INTO emkt_regions VALUES(4219, 234, 'DH', 'ذمار', 'russian');
INSERT INTO emkt_regions VALUES(4220, 234, 'HD', 'حضرموت', 'russian');
INSERT INTO emkt_regions VALUES(4221, 234, 'HJ', 'حجة', 'russian');
INSERT INTO emkt_regions VALUES(4222, 234, 'HU', 'الحديدة', 'russian');
INSERT INTO emkt_regions VALUES(4223, 234, 'IB', 'إب', 'russian');
INSERT INTO emkt_regions VALUES(4224, 234, 'JA', 'الجوف', 'russian');
INSERT INTO emkt_regions VALUES(4225, 234, 'LA', 'لحج', 'russian');
INSERT INTO emkt_regions VALUES(4226, 234, 'MA', 'مأرب', 'russian');
INSERT INTO emkt_regions VALUES(4227, 234, 'MR', 'المهرة', 'russian');
INSERT INTO emkt_regions VALUES(4228, 234, 'MW', 'المحويت', 'russian');
INSERT INTO emkt_regions VALUES(4229, 234, 'SD', 'صعدة', 'russian');
INSERT INTO emkt_regions VALUES(4230, 234, 'SN', 'صنعاء', 'russian');
INSERT INTO emkt_regions VALUES(4231, 234, 'SH', 'شبوة', 'russian');
INSERT INTO emkt_regions VALUES(4232, 234, 'TA', 'تعز', 'russian');

INSERT INTO emkt_countries VALUES (235,'Югославия','russian','YU','YUG','');

INSERT INTO emkt_regions VALUES(4282, 235, 'NOCODE', 'Yugoslavia', 'russian');

INSERT INTO emkt_countries VALUES (236,'Заир','russian','ZR','ZAR','');

INSERT INTO emkt_regions VALUES(4283, 236, 'NOCODE', 'Zaire', 'russian');

INSERT INTO emkt_countries VALUES (237,'Замбия','russian','ZM','ZMB','');

INSERT INTO emkt_regions VALUES(4233, 237, '01', 'Western', 'russian');
INSERT INTO emkt_regions VALUES(4234, 237, '02', 'Central', 'russian');
INSERT INTO emkt_regions VALUES(4235, 237, '03', 'Eastern', 'russian');
INSERT INTO emkt_regions VALUES(4236, 237, '04', 'Luapula', 'russian');
INSERT INTO emkt_regions VALUES(4237, 237, '05', 'Northern', 'russian');
INSERT INTO emkt_regions VALUES(4238, 237, '06', 'North-Western', 'russian');
INSERT INTO emkt_regions VALUES(4239, 237, '07', 'Southern', 'russian');
INSERT INTO emkt_regions VALUES(4240, 237, '08', 'Copperbelt', 'russian');
INSERT INTO emkt_regions VALUES(4241, 237, '09', 'Lusaka', 'russian');

INSERT INTO emkt_countries VALUES (238,'Зимбабве','russian','ZW','ZWE','');

INSERT INTO emkt_regions VALUES(4242, 238, 'MA', 'Manicaland', 'russian');
INSERT INTO emkt_regions VALUES(4243, 238, 'MC', 'Mashonaland Central', 'russian');
INSERT INTO emkt_regions VALUES(4244, 238, 'ME', 'Mashonaland East', 'russian');
INSERT INTO emkt_regions VALUES(4245, 238, 'MI', 'Midlands', 'russian');
INSERT INTO emkt_regions VALUES(4246, 238, 'MN', 'Matabeleland North', 'russian');
INSERT INTO emkt_regions VALUES(4247, 238, 'MS', 'Matabeleland South', 'russian');
INSERT INTO emkt_regions VALUES(4248, 238, 'MV', 'Masvingo', 'russian');
INSERT INTO emkt_regions VALUES(4249, 238, 'MW', 'Mashonaland West', 'russian');

/* english */
INSERT INTO emkt_countries VALUES (1,'Afghanistan','english','AF','AFG','');

INSERT INTO emkt_regions VALUES(1, 1, 'BDS', 'بد خشان', 'english');
INSERT INTO emkt_regions VALUES(2, 1, 'BDG', 'بادغیس', 'english');
INSERT INTO emkt_regions VALUES(3, 1, 'BGL', 'بغلان', 'english');
INSERT INTO emkt_regions VALUES(4, 1, 'BAL', 'بلخ', 'english');
INSERT INTO emkt_regions VALUES(5, 1, 'BAM', 'بامیان', 'english');
INSERT INTO emkt_regions VALUES(6, 1, 'DAY', 'دایکندی', 'english');
INSERT INTO emkt_regions VALUES(7, 1, 'FRA', 'فراه', 'english');
INSERT INTO emkt_regions VALUES(8, 1, 'FYB', 'فارياب', 'english');
INSERT INTO emkt_regions VALUES(9, 1, 'GHA', 'غزنى', 'english');
INSERT INTO emkt_regions VALUES(10, 1, 'GHO', 'غور', 'english');
INSERT INTO emkt_regions VALUES(11, 1, 'HEL', 'هلمند', 'english');
INSERT INTO emkt_regions VALUES(12, 1, 'HER', 'هرات', 'english');
INSERT INTO emkt_regions VALUES(13, 1, 'JOW', 'جوزجان', 'english');
INSERT INTO emkt_regions VALUES(14, 1, 'KAB', 'کابل', 'english');
INSERT INTO emkt_regions VALUES(15, 1, 'KAN', 'قندھار', 'english');
INSERT INTO emkt_regions VALUES(16, 1, 'KAP', 'کاپيسا', 'english');
INSERT INTO emkt_regions VALUES(17, 1, 'KHO', 'خوست', 'english');
INSERT INTO emkt_regions VALUES(18, 1, 'KNR', 'کُنَر', 'english');
INSERT INTO emkt_regions VALUES(19, 1, 'KDZ', 'كندوز', 'english');
INSERT INTO emkt_regions VALUES(20, 1, 'LAG', 'لغمان', 'english');
INSERT INTO emkt_regions VALUES(21, 1, 'LOW', 'لوګر', 'english');
INSERT INTO emkt_regions VALUES(22, 1, 'NAN', 'ننگرهار', 'english');
INSERT INTO emkt_regions VALUES(23, 1, 'NIM', 'نیمروز', 'english');
INSERT INTO emkt_regions VALUES(24, 1, 'NUR', 'نورستان', 'english');
INSERT INTO emkt_regions VALUES(25, 1, 'ORU', 'ؤروزگان', 'english');
INSERT INTO emkt_regions VALUES(26, 1, 'PIA', 'پکتیا', 'english');
INSERT INTO emkt_regions VALUES(27, 1, 'PKA', 'پکتيکا', 'english');
INSERT INTO emkt_regions VALUES(28, 1, 'PAN', 'پنج شیر', 'english');
INSERT INTO emkt_regions VALUES(29, 1, 'PAR', 'پروان', 'english');
INSERT INTO emkt_regions VALUES(30, 1, 'SAM', 'سمنگان', 'english');
INSERT INTO emkt_regions VALUES(31, 1, 'SAR', 'سر پل', 'english');
INSERT INTO emkt_regions VALUES(32, 1, 'TAK', 'تخار', 'english');
INSERT INTO emkt_regions VALUES(33, 1, 'WAR', 'وردک', 'english');
INSERT INTO emkt_regions VALUES(34, 1, 'ZAB', 'زابل', 'english');

INSERT INTO emkt_countries VALUES (2,'Albania','english','AL','ALB','');

INSERT INTO emkt_regions VALUES(35, 2, 'BR', 'Beratit', 'english');
INSERT INTO emkt_regions VALUES(36, 2, 'BU', 'Bulqizës', 'english');
INSERT INTO emkt_regions VALUES(37, 2, 'DI', 'Dibrës', 'english');
INSERT INTO emkt_regions VALUES(38, 2, 'DL', 'Delvinës', 'english');
INSERT INTO emkt_regions VALUES(39, 2, 'DR', 'Durrësit', 'english');
INSERT INTO emkt_regions VALUES(40, 2, 'DV', 'Devollit', 'english');
INSERT INTO emkt_regions VALUES(41, 2, 'EL', 'Elbasanit', 'english');
INSERT INTO emkt_regions VALUES(42, 2, 'ER', 'Kolonjës', 'english');
INSERT INTO emkt_regions VALUES(43, 2, 'FR', 'Fierit', 'english');
INSERT INTO emkt_regions VALUES(44, 2, 'GJ', 'Gjirokastrës', 'english');
INSERT INTO emkt_regions VALUES(45, 2, 'GR', 'Gramshit', 'english');
INSERT INTO emkt_regions VALUES(46, 2, 'HA', 'Hasit', 'english');
INSERT INTO emkt_regions VALUES(47, 2, 'KA', 'Kavajës', 'english');
INSERT INTO emkt_regions VALUES(48, 2, 'KB', 'Kurbinit', 'english');
INSERT INTO emkt_regions VALUES(49, 2, 'KC', 'Kuçovës', 'english');
INSERT INTO emkt_regions VALUES(50, 2, 'KO', 'Korçës', 'english');
INSERT INTO emkt_regions VALUES(51, 2, 'KR', 'Krujës', 'english');
INSERT INTO emkt_regions VALUES(52, 2, 'KU', 'Kukësit', 'english');
INSERT INTO emkt_regions VALUES(53, 2, 'LB', 'Librazhdit', 'english');
INSERT INTO emkt_regions VALUES(54, 2, 'LE', 'Lezhës', 'english');
INSERT INTO emkt_regions VALUES(55, 2, 'LU', 'Lushnjës', 'english');
INSERT INTO emkt_regions VALUES(56, 2, 'MK', 'Mallakastrës', 'english');
INSERT INTO emkt_regions VALUES(57, 2, 'MM', 'Malësisë së Madhe', 'english');
INSERT INTO emkt_regions VALUES(58, 2, 'MR', 'Mirditës', 'english');
INSERT INTO emkt_regions VALUES(59, 2, 'MT', 'Matit', 'english');
INSERT INTO emkt_regions VALUES(60, 2, 'PG', 'Pogradecit', 'english');
INSERT INTO emkt_regions VALUES(61, 2, 'PQ', 'Peqinit', 'english');
INSERT INTO emkt_regions VALUES(62, 2, 'PR', 'Përmetit', 'english');
INSERT INTO emkt_regions VALUES(63, 2, 'PU', 'Pukës', 'english');
INSERT INTO emkt_regions VALUES(64, 2, 'SH', 'Shkodrës', 'english');
INSERT INTO emkt_regions VALUES(65, 2, 'SK', 'Skraparit', 'english');
INSERT INTO emkt_regions VALUES(66, 2, 'SR', 'Sarandës', 'english');
INSERT INTO emkt_regions VALUES(67, 2, 'TE', 'Tepelenës', 'english');
INSERT INTO emkt_regions VALUES(68, 2, 'TP', 'Tropojës', 'english');
INSERT INTO emkt_regions VALUES(69, 2, 'TR', 'Tiranës', 'english');
INSERT INTO emkt_regions VALUES(70, 2, 'VL', 'Vlorës', 'english');

INSERT INTO emkt_countries VALUES (3,'Algeria','english','DZ','DZA','');

INSERT INTO emkt_regions VALUES(71, 3, '01', 'ولاية أدرار', 'english');
INSERT INTO emkt_regions VALUES(72, 3, '02', 'ولاية الشلف', 'english');
INSERT INTO emkt_regions VALUES(73, 3, '03', 'ولاية الأغواط', 'english');
INSERT INTO emkt_regions VALUES(74, 3, '04', 'ولاية أم البواقي', 'english');
INSERT INTO emkt_regions VALUES(75, 3, '05', 'ولاية باتنة', 'english');
INSERT INTO emkt_regions VALUES(76, 3, '06', 'ولاية بجاية', 'english');
INSERT INTO emkt_regions VALUES(77, 3, '07', 'ولاية بسكرة', 'english');
INSERT INTO emkt_regions VALUES(78, 3, '08', 'ولاية بشار', 'english');
INSERT INTO emkt_regions VALUES(79, 3, '09', 'البليدة‎', 'english');
INSERT INTO emkt_regions VALUES(80, 3, '10', 'ولاية البويرة', 'english');
INSERT INTO emkt_regions VALUES(81, 3, '11', 'ولاية تمنراست', 'english');
INSERT INTO emkt_regions VALUES(82, 3, '12', 'ولاية تبسة', 'english');
INSERT INTO emkt_regions VALUES(83, 3, '13', 'تلمسان', 'english');
INSERT INTO emkt_regions VALUES(84, 3, '14', 'ولاية تيارت', 'english');
INSERT INTO emkt_regions VALUES(85, 3, '15', 'تيزي وزو', 'english');
INSERT INTO emkt_regions VALUES(86, 3, '16', 'ولاية الجزائر', 'english');
INSERT INTO emkt_regions VALUES(87, 3, '17', 'ولاية عين الدفلى', 'english');
INSERT INTO emkt_regions VALUES(88, 3, '18', 'ولاية جيجل', 'english');
INSERT INTO emkt_regions VALUES(89, 3, '19', 'ولاية سطيف', 'english');
INSERT INTO emkt_regions VALUES(90, 3, '20', 'ولاية سعيدة', 'english');
INSERT INTO emkt_regions VALUES(91, 3, '21', 'السكيكدة', 'english');
INSERT INTO emkt_regions VALUES(92, 3, '22', 'ولاية سيدي بلعباس', 'english');
INSERT INTO emkt_regions VALUES(93, 3, '23', 'ولاية عنابة', 'english');
INSERT INTO emkt_regions VALUES(94, 3, '24', 'ولاية قالمة', 'english');
INSERT INTO emkt_regions VALUES(95, 3, '25', 'قسنطينة', 'english');
INSERT INTO emkt_regions VALUES(96, 3, '26', 'ولاية المدية', 'english');
INSERT INTO emkt_regions VALUES(97, 3, '27', 'ولاية مستغانم', 'english');
INSERT INTO emkt_regions VALUES(98, 3, '28', 'ولاية المسيلة', 'english');
INSERT INTO emkt_regions VALUES(99, 3, '29', 'ولاية معسكر', 'english');
INSERT INTO emkt_regions VALUES(100, 3, '30', 'ورقلة', 'english');
INSERT INTO emkt_regions VALUES(101, 3, '31', 'وهران', 'english');
INSERT INTO emkt_regions VALUES(102, 3, '32', 'ولاية البيض', 'english');
INSERT INTO emkt_regions VALUES(103, 3, '33', 'ولاية اليزي', 'english');
INSERT INTO emkt_regions VALUES(104, 3, '34', 'ولاية برج بوعريريج', 'english');
INSERT INTO emkt_regions VALUES(105, 3, '35', 'ولاية بومرداس', 'english');
INSERT INTO emkt_regions VALUES(106, 3, '36', 'ولاية الطارف', 'english');
INSERT INTO emkt_regions VALUES(107, 3, '37', 'تندوف', 'english');
INSERT INTO emkt_regions VALUES(108, 3, '38', 'ولاية تسمسيلت', 'english');
INSERT INTO emkt_regions VALUES(109, 3, '39', 'ولاية الوادي', 'english');
INSERT INTO emkt_regions VALUES(110, 3, '40', 'ولاية خنشلة', 'english');
INSERT INTO emkt_regions VALUES(111, 3, '41', 'ولاية سوق أهراس', 'english');
INSERT INTO emkt_regions VALUES(112, 3, '42', 'ولاية تيبازة', 'english');
INSERT INTO emkt_regions VALUES(113, 3, '43', 'ولاية ميلة', 'english');
INSERT INTO emkt_regions VALUES(114, 3, '44', 'ولاية عين الدفلى', 'english');
INSERT INTO emkt_regions VALUES(115, 3, '45', 'ولاية النعامة', 'english');
INSERT INTO emkt_regions VALUES(116, 3, '46', 'ولاية عين تموشنت', 'english');
INSERT INTO emkt_regions VALUES(117, 3, '47', 'ولاية غرداية', 'english');
INSERT INTO emkt_regions VALUES(118, 3, '48', 'ولاية غليزان', 'english');

INSERT INTO emkt_countries VALUES (4,'American Samoa','english','AS','ASM','');

INSERT INTO emkt_regions VALUES(119, 4, 'EA', 'Eastern', 'english');
INSERT INTO emkt_regions VALUES(120, 4, 'MA', 'Manu\'a', 'english');
INSERT INTO emkt_regions VALUES(121, 4, 'RI', 'Rose Island', 'english');
INSERT INTO emkt_regions VALUES(122, 4, 'SI', 'Swains Island', 'english');
INSERT INTO emkt_regions VALUES(123, 4, 'WE', 'Western', 'english');

INSERT INTO emkt_countries VALUES (5,'Andorra','english','AD','AND','');

INSERT INTO emkt_regions VALUES(124, 5, 'AN', 'Andorra la Vella', 'english');
INSERT INTO emkt_regions VALUES(125, 5, 'CA', 'Canillo', 'english');
INSERT INTO emkt_regions VALUES(126, 5, 'EN', 'Encamp', 'english');
INSERT INTO emkt_regions VALUES(127, 5, 'LE', 'Escaldes-Engordany', 'english');
INSERT INTO emkt_regions VALUES(128, 5, 'LM', 'La Massana', 'english');
INSERT INTO emkt_regions VALUES(129, 5, 'OR', 'Ordino', 'english');
INSERT INTO emkt_regions VALUES(130, 5, 'SJ', 'Sant Juliá de Lória', 'english');

INSERT INTO emkt_countries VALUES (6,'Angola','english','AO','AGO','');

INSERT INTO emkt_regions VALUES(131, 6, 'BGO', 'Bengo', 'english');
INSERT INTO emkt_regions VALUES(132, 6, 'BGU', 'Benguela', 'english');
INSERT INTO emkt_regions VALUES(133, 6, 'BIE', 'Bié', 'english');
INSERT INTO emkt_regions VALUES(134, 6, 'CAB', 'Cabinda', 'english');
INSERT INTO emkt_regions VALUES(135, 6, 'CCU', 'Cuando Cubango', 'english');
INSERT INTO emkt_regions VALUES(136, 6, 'CNO', 'Cuanza Norte', 'english');
INSERT INTO emkt_regions VALUES(137, 6, 'CUS', 'Cuanza Sul', 'english');
INSERT INTO emkt_regions VALUES(138, 6, 'CNN', 'Cunene', 'english');
INSERT INTO emkt_regions VALUES(139, 6, 'HUA', 'Huambo', 'english');
INSERT INTO emkt_regions VALUES(140, 6, 'HUI', 'Huíla', 'english');
INSERT INTO emkt_regions VALUES(141, 6, 'LUA', 'Luanda', 'english');
INSERT INTO emkt_regions VALUES(142, 6, 'LNO', 'Lunda Norte', 'english');
INSERT INTO emkt_regions VALUES(143, 6, 'LSU', 'Lunda Sul', 'english');
INSERT INTO emkt_regions VALUES(144, 6, 'MAL', 'Malanje', 'english');
INSERT INTO emkt_regions VALUES(145, 6, 'MOX', 'Moxico', 'english');
INSERT INTO emkt_regions VALUES(146, 6, 'NAM', 'Namibe', 'english');
INSERT INTO emkt_regions VALUES(147, 6, 'UIG', 'Uíge', 'english');
INSERT INTO emkt_regions VALUES(148, 6, 'ZAI', 'Zaire', 'english');

INSERT INTO emkt_countries VALUES (7,'Anguilla','english','AI','AIA','');

INSERT INTO emkt_regions VALUES(4250, 7, 'NOCODE', 'Anguilla', 'english');

INSERT INTO emkt_countries VALUES (8,'Antarctica','english','AQ','ATA','');

INSERT INTO emkt_regions VALUES(4251, 8, 'NOCODE', 'Antarctica', 'english');

INSERT INTO emkt_countries VALUES (9,'Antigua and Barbuda','english','AG','ATG','');

INSERT INTO emkt_regions VALUES(149, 9, 'BAR', 'Barbuda', 'english');
INSERT INTO emkt_regions VALUES(150, 9, 'SGE', 'Saint George', 'english');
INSERT INTO emkt_regions VALUES(151, 9, 'SJO', 'Saint John', 'english');
INSERT INTO emkt_regions VALUES(152, 9, 'SMA', 'Saint Mary', 'english');
INSERT INTO emkt_regions VALUES(153, 9, 'SPA', 'Saint Paul', 'english');
INSERT INTO emkt_regions VALUES(154, 9, 'SPE', 'Saint Peter', 'english');
INSERT INTO emkt_regions VALUES(155, 9, 'SPH', 'Saint Philip', 'english');

INSERT INTO emkt_countries VALUES (10,'Argentina','english','AR','ARG','');

INSERT INTO emkt_regions VALUES(156, 10, 'A', 'Salta', 'english');
INSERT INTO emkt_regions VALUES(157, 10, 'B', 'Buenos Aires Province', 'english');
INSERT INTO emkt_regions VALUES(158, 10, 'C', 'Capital Federal', 'english');
INSERT INTO emkt_regions VALUES(159, 10, 'D', 'San Luis', 'english');
INSERT INTO emkt_regions VALUES(160, 10, 'E', 'Entre Ríos', 'english');
INSERT INTO emkt_regions VALUES(161, 10, 'F', 'La Rioja', 'english');
INSERT INTO emkt_regions VALUES(162, 10, 'G', 'Santiago del Estero', 'english');
INSERT INTO emkt_regions VALUES(163, 10, 'H', 'Chaco', 'english');
INSERT INTO emkt_regions VALUES(164, 10, 'J', 'San Juan', 'english');
INSERT INTO emkt_regions VALUES(165, 10, 'K', 'Catamarca', 'english');
INSERT INTO emkt_regions VALUES(166, 10, 'L', 'La Pampa', 'english');
INSERT INTO emkt_regions VALUES(167, 10, 'M', 'Mendoza', 'english');
INSERT INTO emkt_regions VALUES(168, 10, 'N', 'Misiones', 'english');
INSERT INTO emkt_regions VALUES(169, 10, 'P', 'Formosa', 'english');
INSERT INTO emkt_regions VALUES(170, 10, 'Q', 'Neuquén', 'english');
INSERT INTO emkt_regions VALUES(171, 10, 'R', 'Río Negro', 'english');
INSERT INTO emkt_regions VALUES(172, 10, 'S', 'Santa Fe', 'english');
INSERT INTO emkt_regions VALUES(173, 10, 'T', 'Tucumán', 'english');
INSERT INTO emkt_regions VALUES(174, 10, 'U', 'Chubut', 'english');
INSERT INTO emkt_regions VALUES(175, 10, 'V', 'Tierra del Fuego', 'english');
INSERT INTO emkt_regions VALUES(176, 10, 'W', 'Corrientes', 'english');
INSERT INTO emkt_regions VALUES(177, 10, 'X', 'Córdoba', 'english');
INSERT INTO emkt_regions VALUES(178, 10, 'Y', 'Jujuy', 'english');
INSERT INTO emkt_regions VALUES(179, 10, 'Z', 'Santa Cruz', 'english');

INSERT INTO emkt_countries VALUES (11,'Armenia','english','AM','ARM','');

INSERT INTO emkt_regions VALUES(180, 11, 'AG', 'Արագածոտն', 'english');
INSERT INTO emkt_regions VALUES(181, 11, 'AR', 'Արարատ', 'english');
INSERT INTO emkt_regions VALUES(182, 11, 'AV', 'Արմավիր', 'english');
INSERT INTO emkt_regions VALUES(183, 11, 'ER', 'Երևան', 'english');
INSERT INTO emkt_regions VALUES(184, 11, 'GR', 'Գեղարքունիք', 'english');
INSERT INTO emkt_regions VALUES(185, 11, 'KT', 'Կոտայք', 'english');
INSERT INTO emkt_regions VALUES(186, 11, 'LO', 'Լոռի', 'english');
INSERT INTO emkt_regions VALUES(187, 11, 'SH', 'Շիրակ', 'english');
INSERT INTO emkt_regions VALUES(188, 11, 'SU', 'Սյունիք', 'english');
INSERT INTO emkt_regions VALUES(189, 11, 'TV', 'Տավուշ', 'english');
INSERT INTO emkt_regions VALUES(190, 11, 'VD', 'Վայոց Ձոր', 'english');

INSERT INTO emkt_countries VALUES (12,'Aruba','english','AW','ABW','');

INSERT INTO emkt_regions VALUES(4252, 12, 'NOCODE', 'Aruba', 'english');

INSERT INTO emkt_countries VALUES (13,'Australia','english','AU','AUS','');

INSERT INTO emkt_regions VALUES(191, 13, 'ACT', 'Australian Capital Territory', 'english');
INSERT INTO emkt_regions VALUES(192, 13, 'NSW', 'New South Wales', 'english');
INSERT INTO emkt_regions VALUES(193, 13, 'NT', 'Northern Territory', 'english');
INSERT INTO emkt_regions VALUES(194, 13, 'QLD', 'Queensland', 'english');
INSERT INTO emkt_regions VALUES(195, 13, 'SA', 'South Australia', 'english');
INSERT INTO emkt_regions VALUES(196, 13, 'TAS', 'Tasmania', 'english');
INSERT INTO emkt_regions VALUES(197, 13, 'VIC', 'Victoria', 'english');
INSERT INTO emkt_regions VALUES(198, 13, 'WA', 'Western Australia', 'english');

INSERT INTO emkt_countries VALUES (14,'Austria','english','AT','AUT','');

INSERT INTO emkt_regions VALUES(199, 14, '1', 'Burgenland', 'english');
INSERT INTO emkt_regions VALUES(200, 14, '2', 'Kärnten', 'english');
INSERT INTO emkt_regions VALUES(201, 14, '3', 'Niederösterreich', 'english');
INSERT INTO emkt_regions VALUES(202, 14, '4', 'Oberösterreich', 'english');
INSERT INTO emkt_regions VALUES(203, 14, '5', 'Salzburg', 'english');
INSERT INTO emkt_regions VALUES(204, 14, '6', 'Steiermark', 'english');
INSERT INTO emkt_regions VALUES(205, 14, '7', 'Tirol', 'english');
INSERT INTO emkt_regions VALUES(206, 14, '8', 'Voralberg', 'english');
INSERT INTO emkt_regions VALUES(207, 14, '9', 'Wien', 'english');

INSERT INTO emkt_countries VALUES (15,'Azerbaijan','english','AZ','AZE','');

INSERT INTO emkt_regions VALUES(208, 15, 'AB', 'Əli Bayramlı', 'english');
INSERT INTO emkt_regions VALUES(209, 15, 'ABS', 'Abşeron', 'english');
INSERT INTO emkt_regions VALUES(210, 15, 'AGC', 'Ağcabədi', 'english');
INSERT INTO emkt_regions VALUES(211, 15, 'AGM', 'Ağdam', 'english');
INSERT INTO emkt_regions VALUES(212, 15, 'AGS', 'Ağdaş', 'english');
INSERT INTO emkt_regions VALUES(213, 15, 'AGA', 'Ağstafa', 'english');
INSERT INTO emkt_regions VALUES(214, 15, 'AGU', 'Ağsu', 'english');
INSERT INTO emkt_regions VALUES(215, 15, 'AST', 'Astara', 'english');
INSERT INTO emkt_regions VALUES(216, 15, 'BA', 'Bakı', 'english');
INSERT INTO emkt_regions VALUES(217, 15, 'BAB', 'Babək', 'english');
INSERT INTO emkt_regions VALUES(218, 15, 'BAL', 'Balakən', 'english');
INSERT INTO emkt_regions VALUES(219, 15, 'BAR', 'Bərdə', 'english');
INSERT INTO emkt_regions VALUES(220, 15, 'BEY', 'Beyləqan', 'english');
INSERT INTO emkt_regions VALUES(221, 15, 'BIL', 'Biləsuvar', 'english');
INSERT INTO emkt_regions VALUES(222, 15, 'CAB', 'Cəbrayıl', 'english');
INSERT INTO emkt_regions VALUES(223, 15, 'CAL', 'Cəlilabab', 'english');
INSERT INTO emkt_regions VALUES(224, 15, 'CUL', 'Julfa', 'english');
INSERT INTO emkt_regions VALUES(225, 15, 'DAS', 'Daşkəsən', 'english');
INSERT INTO emkt_regions VALUES(226, 15, 'DAV', 'Dəvəçi', 'english');
INSERT INTO emkt_regions VALUES(227, 15, 'FUZ', 'Füzuli', 'english');
INSERT INTO emkt_regions VALUES(228, 15, 'GA', 'Gəncə', 'english');
INSERT INTO emkt_regions VALUES(229, 15, 'GAD', 'Gədəbəy', 'english');
INSERT INTO emkt_regions VALUES(230, 15, 'GOR', 'Goranboy', 'english');
INSERT INTO emkt_regions VALUES(231, 15, 'GOY', 'Göyçay', 'english');
INSERT INTO emkt_regions VALUES(232, 15, 'HAC', 'Hacıqabul', 'english');
INSERT INTO emkt_regions VALUES(233, 15, 'IMI', 'İmişli', 'english');
INSERT INTO emkt_regions VALUES(234, 15, 'ISM', 'İsmayıllı', 'english');
INSERT INTO emkt_regions VALUES(235, 15, 'KAL', 'Kəlbəcər', 'english');
INSERT INTO emkt_regions VALUES(236, 15, 'KUR', 'Kürdəmir', 'english');
INSERT INTO emkt_regions VALUES(237, 15, 'LA', 'Lənkəran', 'english');
INSERT INTO emkt_regions VALUES(238, 15, 'LAC', 'Laçın', 'english');
INSERT INTO emkt_regions VALUES(239, 15, 'LAN', 'Lənkəran', 'english');
INSERT INTO emkt_regions VALUES(240, 15, 'LER', 'Lerik', 'english');
INSERT INTO emkt_regions VALUES(241, 15, 'MAS', 'Masallı', 'english');
INSERT INTO emkt_regions VALUES(242, 15, 'MI', 'Mingəçevir', 'english');
INSERT INTO emkt_regions VALUES(243, 15, 'NA', 'Naftalan', 'english');
INSERT INTO emkt_regions VALUES(244, 15, 'NEF', 'Neftçala', 'english');
INSERT INTO emkt_regions VALUES(245, 15, 'OGU', 'Oğuz', 'english');
INSERT INTO emkt_regions VALUES(246, 15, 'ORD', 'Ordubad', 'english');
INSERT INTO emkt_regions VALUES(247, 15, 'QAB', 'Qəbələ', 'english');
INSERT INTO emkt_regions VALUES(248, 15, 'QAX', 'Qax', 'english');
INSERT INTO emkt_regions VALUES(249, 15, 'QAZ', 'Qazax', 'english');
INSERT INTO emkt_regions VALUES(250, 15, 'QOB', 'Qobustan', 'english');
INSERT INTO emkt_regions VALUES(251, 15, 'QBA', 'Quba', 'english');
INSERT INTO emkt_regions VALUES(252, 15, 'QBI', 'Qubadlı', 'english');
INSERT INTO emkt_regions VALUES(253, 15, 'QUS', 'Qusar', 'english');
INSERT INTO emkt_regions VALUES(254, 15, 'SA', 'Şəki', 'english');
INSERT INTO emkt_regions VALUES(255, 15, 'SAT', 'Saatlı', 'english');
INSERT INTO emkt_regions VALUES(256, 15, 'SAB', 'Sabirabad', 'english');
INSERT INTO emkt_regions VALUES(257, 15, 'SAD', 'Sədərək', 'english');
INSERT INTO emkt_regions VALUES(258, 15, 'SAH', 'Şahbuz', 'english');
INSERT INTO emkt_regions VALUES(259, 15, 'SAK', 'Şəki', 'english');
INSERT INTO emkt_regions VALUES(260, 15, 'SAL', 'Salyan', 'english');
INSERT INTO emkt_regions VALUES(261, 15, 'SM', 'Sumqayıt', 'english');
INSERT INTO emkt_regions VALUES(262, 15, 'SMI', 'Şamaxı', 'english');
INSERT INTO emkt_regions VALUES(263, 15, 'SKR', 'Şəmkir', 'english');
INSERT INTO emkt_regions VALUES(264, 15, 'SMX', 'Samux', 'english');
INSERT INTO emkt_regions VALUES(265, 15, 'SAR', 'Şərur', 'english');
INSERT INTO emkt_regions VALUES(266, 15, 'SIY', 'Siyəzən', 'english');
INSERT INTO emkt_regions VALUES(267, 15, 'SS', 'Şuşa (City)', 'english');
INSERT INTO emkt_regions VALUES(268, 15, 'SUS', 'Şuşa', 'english');
INSERT INTO emkt_regions VALUES(269, 15, 'TAR', 'Tərtər', 'english');
INSERT INTO emkt_regions VALUES(270, 15, 'TOV', 'Tovuz', 'english');
INSERT INTO emkt_regions VALUES(271, 15, 'UCA', 'Ucar', 'english');
INSERT INTO emkt_regions VALUES(272, 15, 'XA', 'Xankəndi', 'english');
INSERT INTO emkt_regions VALUES(273, 15, 'XAC', 'Xaçmaz', 'english');
INSERT INTO emkt_regions VALUES(274, 15, 'XAN', 'Xanlar', 'english');
INSERT INTO emkt_regions VALUES(275, 15, 'XIZ', 'Xızı', 'english');
INSERT INTO emkt_regions VALUES(276, 15, 'XCI', 'Xocalı', 'english');
INSERT INTO emkt_regions VALUES(277, 15, 'XVD', 'Xocavənd', 'english');
INSERT INTO emkt_regions VALUES(278, 15, 'YAR', 'Yardımlı', 'english');
INSERT INTO emkt_regions VALUES(279, 15, 'YE', 'Yevlax (City)', 'english');
INSERT INTO emkt_regions VALUES(280, 15, 'YEV', 'Yevlax', 'english');
INSERT INTO emkt_regions VALUES(281, 15, 'ZAN', 'Zəngilan', 'english');
INSERT INTO emkt_regions VALUES(282, 15, 'ZAQ', 'Zaqatala', 'english');
INSERT INTO emkt_regions VALUES(283, 15, 'ZAR', 'Zərdab', 'english');
INSERT INTO emkt_regions VALUES(284, 15, 'NX', 'Nakhichevan', 'english');

INSERT INTO emkt_countries VALUES (16,'Bahamas','english','BS','BHS','');

INSERT INTO emkt_regions VALUES(285, 16, 'AC', 'Acklins and Crooked Islands', 'english');
INSERT INTO emkt_regions VALUES(286, 16, 'BI', 'Bimini', 'english');
INSERT INTO emkt_regions VALUES(287, 16, 'CI', 'Cat Island', 'english');
INSERT INTO emkt_regions VALUES(288, 16, 'EX', 'Exuma', 'english');
INSERT INTO emkt_regions VALUES(289, 16, 'FR', 'Freeport', 'english');
INSERT INTO emkt_regions VALUES(290, 16, 'FC', 'Fresh Creek', 'english');
INSERT INTO emkt_regions VALUES(291, 16, 'GH', 'Governor\'s Harbour', 'english');
INSERT INTO emkt_regions VALUES(292, 16, 'GT', 'Green Turtle Cay', 'english');
INSERT INTO emkt_regions VALUES(293, 16, 'HI', 'Harbour Island', 'english');
INSERT INTO emkt_regions VALUES(294, 16, 'HR', 'High Rock', 'english');
INSERT INTO emkt_regions VALUES(295, 16, 'IN', 'Inagua', 'english');
INSERT INTO emkt_regions VALUES(296, 16, 'KB', 'Kemps Bay', 'english');
INSERT INTO emkt_regions VALUES(297, 16, 'LI', 'Long Island', 'english');
INSERT INTO emkt_regions VALUES(298, 16, 'MH', 'Marsh Harbour', 'english');
INSERT INTO emkt_regions VALUES(299, 16, 'MA', 'Mayaguana', 'english');
INSERT INTO emkt_regions VALUES(300, 16, 'NP', 'New Providence', 'english');
INSERT INTO emkt_regions VALUES(301, 16, 'NT', 'Nicholls Town and Berry Islands', 'english');
INSERT INTO emkt_regions VALUES(302, 16, 'RI', 'Ragged Island', 'english');
INSERT INTO emkt_regions VALUES(303, 16, 'RS', 'Rock Sound', 'english');
INSERT INTO emkt_regions VALUES(304, 16, 'SS', 'San Salvador and Rum Cay', 'english');
INSERT INTO emkt_regions VALUES(305, 16, 'SP', 'Sandy Point', 'english');

INSERT INTO emkt_countries VALUES (17,'Bahrain','english','BH','BHR','');

INSERT INTO emkt_regions VALUES(306, 17, '01', 'الحد', 'english');
INSERT INTO emkt_regions VALUES(307, 17, '02', 'المحرق', 'english');
INSERT INTO emkt_regions VALUES(308, 17, '03', 'المنامة', 'english');
INSERT INTO emkt_regions VALUES(309, 17, '04', 'جد حفص', 'english');
INSERT INTO emkt_regions VALUES(310, 17, '05', 'المنطقة الشمالية', 'english');
INSERT INTO emkt_regions VALUES(311, 17, '06', 'سترة', 'english');
INSERT INTO emkt_regions VALUES(312, 17, '07', 'المنطقة الوسطى', 'english');
INSERT INTO emkt_regions VALUES(313, 17, '08', 'مدينة عيسى', 'english');
INSERT INTO emkt_regions VALUES(314, 17, '09', 'الرفاع والمنطقة الجنوبية', 'english');
INSERT INTO emkt_regions VALUES(315, 17, '10', 'المنطقة الغربية', 'english');
INSERT INTO emkt_regions VALUES(316, 17, '11', 'جزر حوار', 'english');
INSERT INTO emkt_regions VALUES(317, 17, '12', 'مدينة حمد', 'english');

INSERT INTO emkt_countries VALUES (18,'Bangladesh','english','BD','BGD','');

INSERT INTO emkt_regions VALUES(318, 18, '01', 'Bandarban', 'english');
INSERT INTO emkt_regions VALUES(319, 18, '02', 'Barguna', 'english');
INSERT INTO emkt_regions VALUES(320, 18, '03', 'Bogra', 'english');
INSERT INTO emkt_regions VALUES(321, 18, '04', 'Brahmanbaria', 'english');
INSERT INTO emkt_regions VALUES(322, 18, '05', 'Bagerhat', 'english');
INSERT INTO emkt_regions VALUES(323, 18, '06', 'Barisal', 'english');
INSERT INTO emkt_regions VALUES(324, 18, '07', 'Bhola', 'english');
INSERT INTO emkt_regions VALUES(325, 18, '08', 'Comilla', 'english');
INSERT INTO emkt_regions VALUES(326, 18, '09', 'Chandpur', 'english');
INSERT INTO emkt_regions VALUES(327, 18, '10', 'Chittagong', 'english');
INSERT INTO emkt_regions VALUES(328, 18, '11', 'Cox\'s Bazar', 'english');
INSERT INTO emkt_regions VALUES(329, 18, '12', 'Chuadanga', 'english');
INSERT INTO emkt_regions VALUES(330, 18, '13', 'Dhaka', 'english');
INSERT INTO emkt_regions VALUES(331, 18, '14', 'Dinajpur', 'english');
INSERT INTO emkt_regions VALUES(332, 18, '15', 'Faridpur', 'english');
INSERT INTO emkt_regions VALUES(333, 18, '16', 'Feni', 'english');
INSERT INTO emkt_regions VALUES(334, 18, '17', 'Gopalganj', 'english');
INSERT INTO emkt_regions VALUES(335, 18, '18', 'Gazipur', 'english');
INSERT INTO emkt_regions VALUES(336, 18, '19', 'Gaibandha', 'english');
INSERT INTO emkt_regions VALUES(337, 18, '20', 'Habiganj', 'english');
INSERT INTO emkt_regions VALUES(338, 18, '21', 'Jamalpur', 'english');
INSERT INTO emkt_regions VALUES(339, 18, '22', 'Jessore', 'english');
INSERT INTO emkt_regions VALUES(340, 18, '23', 'Jhenaidah', 'english');
INSERT INTO emkt_regions VALUES(341, 18, '24', 'Jaipurhat', 'english');
INSERT INTO emkt_regions VALUES(342, 18, '25', 'Jhalakati', 'english');
INSERT INTO emkt_regions VALUES(343, 18, '26', 'Kishoreganj', 'english');
INSERT INTO emkt_regions VALUES(344, 18, '27', 'Khulna', 'english');
INSERT INTO emkt_regions VALUES(345, 18, '28', 'Kurigram', 'english');
INSERT INTO emkt_regions VALUES(346, 18, '29', 'Khagrachari', 'english');
INSERT INTO emkt_regions VALUES(347, 18, '30', 'Kushtia', 'english');
INSERT INTO emkt_regions VALUES(348, 18, '31', 'Lakshmipur', 'english');
INSERT INTO emkt_regions VALUES(349, 18, '32', 'Lalmonirhat', 'english');
INSERT INTO emkt_regions VALUES(350, 18, '33', 'Manikganj', 'english');
INSERT INTO emkt_regions VALUES(351, 18, '34', 'Mymensingh', 'english');
INSERT INTO emkt_regions VALUES(352, 18, '35', 'Munshiganj', 'english');
INSERT INTO emkt_regions VALUES(353, 18, '36', 'Madaripur', 'english');
INSERT INTO emkt_regions VALUES(354, 18, '37', 'Magura', 'english');
INSERT INTO emkt_regions VALUES(355, 18, '38', 'Moulvibazar', 'english');
INSERT INTO emkt_regions VALUES(356, 18, '39', 'Meherpur', 'english');
INSERT INTO emkt_regions VALUES(357, 18, '40', 'Narayanganj', 'english');
INSERT INTO emkt_regions VALUES(358, 18, '41', 'Netrakona', 'english');
INSERT INTO emkt_regions VALUES(359, 18, '42', 'Narsingdi', 'english');
INSERT INTO emkt_regions VALUES(360, 18, '43', 'Narail', 'english');
INSERT INTO emkt_regions VALUES(361, 18, '44', 'Natore', 'english');
INSERT INTO emkt_regions VALUES(362, 18, '45', 'Nawabganj', 'english');
INSERT INTO emkt_regions VALUES(363, 18, '46', 'Nilphamari', 'english');
INSERT INTO emkt_regions VALUES(364, 18, '47', 'Noakhali', 'english');
INSERT INTO emkt_regions VALUES(365, 18, '48', 'Naogaon', 'english');
INSERT INTO emkt_regions VALUES(366, 18, '49', 'Pabna', 'english');
INSERT INTO emkt_regions VALUES(367, 18, '50', 'Pirojpur', 'english');
INSERT INTO emkt_regions VALUES(368, 18, '51', 'Patuakhali', 'english');
INSERT INTO emkt_regions VALUES(369, 18, '52', 'Panchagarh', 'english');
INSERT INTO emkt_regions VALUES(370, 18, '53', 'Rajbari', 'english');
INSERT INTO emkt_regions VALUES(371, 18, '54', 'Rajshahi', 'english');
INSERT INTO emkt_regions VALUES(372, 18, '55', 'Rangpur', 'english');
INSERT INTO emkt_regions VALUES(373, 18, '56', 'Rangamati', 'english');
INSERT INTO emkt_regions VALUES(374, 18, '57', 'Sherpur', 'english');
INSERT INTO emkt_regions VALUES(375, 18, '58', 'Satkhira', 'english');
INSERT INTO emkt_regions VALUES(376, 18, '59', 'Sirajganj', 'english');
INSERT INTO emkt_regions VALUES(377, 18, '60', 'Sylhet', 'english');
INSERT INTO emkt_regions VALUES(378, 18, '61', 'Sunamganj', 'english');
INSERT INTO emkt_regions VALUES(379, 18, '62', 'Shariatpur', 'english');
INSERT INTO emkt_regions VALUES(380, 18, '63', 'Tangail', 'english');
INSERT INTO emkt_regions VALUES(381, 18, '64', 'Thakurgaon', 'english');

INSERT INTO emkt_countries VALUES (19,'Barbados','english','BB','BRB','');

INSERT INTO emkt_regions VALUES(382, 19, 'A', 'Saint Andrew', 'english');
INSERT INTO emkt_regions VALUES(383, 19, 'C', 'Christ Church', 'english');
INSERT INTO emkt_regions VALUES(384, 19, 'E', 'Saint Peter', 'english');
INSERT INTO emkt_regions VALUES(385, 19, 'G', 'Saint George', 'english');
INSERT INTO emkt_regions VALUES(386, 19, 'J', 'Saint John', 'english');
INSERT INTO emkt_regions VALUES(387, 19, 'L', 'Saint Lucy', 'english');
INSERT INTO emkt_regions VALUES(388, 19, 'M', 'Saint Michael', 'english');
INSERT INTO emkt_regions VALUES(389, 19, 'O', 'Saint Joseph', 'english');
INSERT INTO emkt_regions VALUES(390, 19, 'P', 'Saint Philip', 'english');
INSERT INTO emkt_regions VALUES(391, 19, 'S', 'Saint James', 'english');
INSERT INTO emkt_regions VALUES(392, 19, 'T', 'Saint Thomas', 'english');

INSERT INTO emkt_countries VALUES (20,'Belarus','english','BY','BLR','');

INSERT INTO emkt_regions VALUES(393, 20, 'BR', 'Брэсцкая вобласць', 'english');
INSERT INTO emkt_regions VALUES(394, 20, 'HO', 'Гомельская вобласць', 'english');
INSERT INTO emkt_regions VALUES(395, 20, 'HR', 'Гродзенская вобласць', 'english');
INSERT INTO emkt_regions VALUES(396, 20, 'MA', 'Магілёўская вобласць', 'english');
INSERT INTO emkt_regions VALUES(397, 20, 'MI', 'Мінская вобласць', 'english');
INSERT INTO emkt_regions VALUES(398, 20, 'VI', 'Віцебская вобласць', 'english');

INSERT INTO emkt_countries VALUES (21,'Belgium','english','BE','BEL','');

INSERT INTO emkt_regions VALUES(399, 21, 'BRU', 'Brussel', 'english');
INSERT INTO emkt_regions VALUES(400, 21, 'VAN', 'Antwerpen', 'english');
INSERT INTO emkt_regions VALUES(401, 21, 'VBR', 'Vlaams-Brabant', 'english');
INSERT INTO emkt_regions VALUES(402, 21, 'VLI', 'Limburg', 'english');
INSERT INTO emkt_regions VALUES(403, 21, 'VOV', 'Oost-Vlaanderen', 'english');
INSERT INTO emkt_regions VALUES(404, 21, 'VWV', 'West-Vlaanderen', 'english');
INSERT INTO emkt_regions VALUES(405, 21, 'WBR', 'Brabant Wallon', 'english');
INSERT INTO emkt_regions VALUES(406, 21, 'WHT', 'Hainaut', 'english');
INSERT INTO emkt_regions VALUES(407, 21, 'WLG', 'Liège/Lüttich', 'english');
INSERT INTO emkt_regions VALUES(408, 21, 'WLX', 'Luxembourg', 'english');
INSERT INTO emkt_regions VALUES(409, 21, 'WNA', 'Namur', 'english');

INSERT INTO emkt_countries VALUES (22,'Belize','english','BZ','BLZ','');

INSERT INTO emkt_regions VALUES(410, 22, 'BZ', 'Belize District', 'english');
INSERT INTO emkt_regions VALUES(411, 22, 'CY', 'Cayo District', 'english');
INSERT INTO emkt_regions VALUES(412, 22, 'CZL', 'Corozal District', 'english');
INSERT INTO emkt_regions VALUES(413, 22, 'OW', 'Orange Walk District', 'english');
INSERT INTO emkt_regions VALUES(414, 22, 'SC', 'Stann Creek District', 'english');
INSERT INTO emkt_regions VALUES(415, 22, 'TOL', 'Toledo District', 'english');

INSERT INTO emkt_countries VALUES (23,'Benin','english','BJ','BEN','');

INSERT INTO emkt_regions VALUES(416, 23, 'AL', 'Alibori', 'english');
INSERT INTO emkt_regions VALUES(417, 23, 'AK', 'Atakora', 'english');
INSERT INTO emkt_regions VALUES(418, 23, 'AQ', 'Atlantique', 'english');
INSERT INTO emkt_regions VALUES(419, 23, 'BO', 'Borgou', 'english');
INSERT INTO emkt_regions VALUES(420, 23, 'CO', 'Collines', 'english');
INSERT INTO emkt_regions VALUES(421, 23, 'DO', 'Donga', 'english');
INSERT INTO emkt_regions VALUES(422, 23, 'KO', 'Kouffo', 'english');
INSERT INTO emkt_regions VALUES(423, 23, 'LI', 'Littoral', 'english');
INSERT INTO emkt_regions VALUES(424, 23, 'MO', 'Mono', 'english');
INSERT INTO emkt_regions VALUES(425, 23, 'OU', 'Ouémé', 'english');
INSERT INTO emkt_regions VALUES(426, 23, 'PL', 'Plateau', 'english');
INSERT INTO emkt_regions VALUES(427, 23, 'ZO', 'Zou', 'english');

INSERT INTO emkt_countries VALUES (24,'Bermuda','english','BM','BMU','');

INSERT INTO emkt_regions VALUES(428, 24, 'DEV', 'Devonshire', 'english');
INSERT INTO emkt_regions VALUES(429, 24, 'HA', 'Hamilton City', 'english');
INSERT INTO emkt_regions VALUES(430, 24, 'HAM', 'Hamilton', 'english');
INSERT INTO emkt_regions VALUES(431, 24, 'PAG', 'Paget', 'english');
INSERT INTO emkt_regions VALUES(432, 24, 'PEM', 'Pembroke', 'english');
INSERT INTO emkt_regions VALUES(433, 24, 'SAN', 'Sandys', 'english');
INSERT INTO emkt_regions VALUES(434, 24, 'SG', 'Saint George City', 'english');
INSERT INTO emkt_regions VALUES(435, 24, 'SGE', 'Saint George\'s', 'english');
INSERT INTO emkt_regions VALUES(436, 24, 'SMI', 'Smiths', 'english');
INSERT INTO emkt_regions VALUES(437, 24, 'SOU', 'Southampton', 'english');
INSERT INTO emkt_regions VALUES(438, 24, 'WAR', 'Warwick', 'english');

INSERT INTO emkt_countries VALUES (25,'Bhutan','english','BT','BTN','');

INSERT INTO emkt_regions VALUES(439, 25, '11', 'Paro', 'english');
INSERT INTO emkt_regions VALUES(440, 25, '12', 'Chukha', 'english');
INSERT INTO emkt_regions VALUES(441, 25, '13', 'Haa', 'english');
INSERT INTO emkt_regions VALUES(442, 25, '14', 'Samtse', 'english');
INSERT INTO emkt_regions VALUES(443, 25, '15', 'Thimphu', 'english');
INSERT INTO emkt_regions VALUES(444, 25, '21', 'Tsirang', 'english');
INSERT INTO emkt_regions VALUES(445, 25, '22', 'Dagana', 'english');
INSERT INTO emkt_regions VALUES(446, 25, '23', 'Punakha', 'english');
INSERT INTO emkt_regions VALUES(447, 25, '24', 'Wangdue Phodrang', 'english');
INSERT INTO emkt_regions VALUES(448, 25, '31', 'Sarpang', 'english');
INSERT INTO emkt_regions VALUES(449, 25, '32', 'Trongsa', 'english');
INSERT INTO emkt_regions VALUES(450, 25, '33', 'Bumthang', 'english');
INSERT INTO emkt_regions VALUES(451, 25, '34', 'Zhemgang', 'english');
INSERT INTO emkt_regions VALUES(452, 25, '41', 'Trashigang', 'english');
INSERT INTO emkt_regions VALUES(453, 25, '42', 'Mongar', 'english');
INSERT INTO emkt_regions VALUES(454, 25, '43', 'Pemagatshel', 'english');
INSERT INTO emkt_regions VALUES(455, 25, '44', 'Luentse', 'english');
INSERT INTO emkt_regions VALUES(456, 25, '45', 'Samdrup Jongkhar', 'english');
INSERT INTO emkt_regions VALUES(457, 25, 'GA', 'Gasa', 'english');
INSERT INTO emkt_regions VALUES(458, 25, 'TY', 'Trashiyangse', 'english');

INSERT INTO emkt_countries VALUES (26,'Bolivia','english','BO','BOL','');

INSERT INTO emkt_regions VALUES(459, 26, 'B', 'El Beni', 'english');
INSERT INTO emkt_regions VALUES(460, 26, 'C', 'Cochabamba', 'english');
INSERT INTO emkt_regions VALUES(461, 26, 'H', 'Chuquisaca', 'english');
INSERT INTO emkt_regions VALUES(462, 26, 'L', 'La Paz', 'english');
INSERT INTO emkt_regions VALUES(463, 26, 'N', 'Pando', 'english');
INSERT INTO emkt_regions VALUES(464, 26, 'O', 'Oruro', 'english');
INSERT INTO emkt_regions VALUES(465, 26, 'P', 'Potosí', 'english');
INSERT INTO emkt_regions VALUES(466, 26, 'S', 'Santa Cruz', 'english');
INSERT INTO emkt_regions VALUES(467, 26, 'T', 'Tarija', 'english');

INSERT INTO emkt_countries VALUES (27,'Bosnia and Herzegowina','english','BA','BIH','');

INSERT INTO emkt_regions VALUES(4253, 27, 'NOCODE', 'Bosnia and Herzegowina', 'english');

INSERT INTO emkt_countries VALUES (28,'Botswana','english','BW','BWA','');

INSERT INTO emkt_regions VALUES(468, 28, 'CE', 'Central', 'english');
INSERT INTO emkt_regions VALUES(469, 28, 'GH', 'Ghanzi', 'english');
INSERT INTO emkt_regions VALUES(470, 28, 'KG', 'Kgalagadi', 'english');
INSERT INTO emkt_regions VALUES(471, 28, 'KL', 'Kgatleng', 'english');
INSERT INTO emkt_regions VALUES(472, 28, 'KW', 'Kweneng', 'english');
INSERT INTO emkt_regions VALUES(473, 28, 'NE', 'North-East', 'english');
INSERT INTO emkt_regions VALUES(474, 28, 'NW', 'North-West', 'english');
INSERT INTO emkt_regions VALUES(475, 28, 'SE', 'South-East', 'english');
INSERT INTO emkt_regions VALUES(476, 28, 'SO', 'Southern', 'english');

INSERT INTO emkt_countries VALUES (29,'Bouvet Island','english','BV','BVT','');

INSERT INTO emkt_regions VALUES(4254, 29, 'NOCODE', 'Bouvet Island', 'english');

INSERT INTO emkt_countries VALUES (30,'Brazil','english','BR','BRA','');

INSERT INTO emkt_regions VALUES(477, 30, 'AC', 'Acre', 'english');
INSERT INTO emkt_regions VALUES(478, 30, 'AL', 'Alagoas', 'english');
INSERT INTO emkt_regions VALUES(479, 30, 'AM', 'Amazônia', 'english');
INSERT INTO emkt_regions VALUES(480, 30, 'AP', 'Amapá', 'english');
INSERT INTO emkt_regions VALUES(481, 30, 'BA', 'Bahia', 'english');
INSERT INTO emkt_regions VALUES(482, 30, 'CE', 'Ceará', 'english');
INSERT INTO emkt_regions VALUES(483, 30, 'DF', 'Distrito Federal', 'english');
INSERT INTO emkt_regions VALUES(484, 30, 'ES', 'Espírito Santo', 'english');
INSERT INTO emkt_regions VALUES(485, 30, 'GO', 'Goiás', 'english');
INSERT INTO emkt_regions VALUES(486, 30, 'MA', 'Maranhão', 'english');
INSERT INTO emkt_regions VALUES(487, 30, 'MG', 'Minas Gerais', 'english');
INSERT INTO emkt_regions VALUES(488, 30, 'MS', 'Mato Grosso do Sul', 'english');
INSERT INTO emkt_regions VALUES(489, 30, 'MT', 'Mato Grosso', 'english');
INSERT INTO emkt_regions VALUES(490, 30, 'PA', 'Pará', 'english');
INSERT INTO emkt_regions VALUES(491, 30, 'PB', 'Paraíba', 'english');
INSERT INTO emkt_regions VALUES(492, 30, 'PE', 'Pernambuco', 'english');
INSERT INTO emkt_regions VALUES(493, 30, 'PI', 'Piauí', 'english');
INSERT INTO emkt_regions VALUES(494, 30, 'PR', 'Paraná', 'english');
INSERT INTO emkt_regions VALUES(495, 30, 'RJ', 'Rio de Janeiro', 'english');
INSERT INTO emkt_regions VALUES(496, 30, 'RN', 'Rio Grande do Norte', 'english');
INSERT INTO emkt_regions VALUES(497, 30, 'RO', 'Rondônia', 'english');
INSERT INTO emkt_regions VALUES(498, 30, 'RR', 'Roraima', 'english');
INSERT INTO emkt_regions VALUES(499, 30, 'RS', 'Rio Grande do Sul', 'english');
INSERT INTO emkt_regions VALUES(500, 30, 'SC', 'Santa Catarina', 'english');
INSERT INTO emkt_regions VALUES(501, 30, 'SE', 'Sergipe', 'english');
INSERT INTO emkt_regions VALUES(502, 30, 'SP', 'São Paulo', 'english');
INSERT INTO emkt_regions VALUES(503, 30, 'TO', 'Tocantins', 'english');

INSERT INTO emkt_countries VALUES (31,'British Indian Ocean Territory','english','IO','IOT','');

INSERT INTO emkt_regions VALUES(504, 31, 'PB', 'Peros Banhos', 'english');
INSERT INTO emkt_regions VALUES(505, 31, 'SI', 'Salomon Islands', 'english');
INSERT INTO emkt_regions VALUES(506, 31, 'NI', 'Nelsons Island', 'english');
INSERT INTO emkt_regions VALUES(507, 31, 'TB', 'Three Brothers', 'english');
INSERT INTO emkt_regions VALUES(508, 31, 'EA', 'Eagle Islands', 'english');
INSERT INTO emkt_regions VALUES(509, 31, 'DI', 'Danger Island', 'english');
INSERT INTO emkt_regions VALUES(510, 31, 'EG', 'Egmont Islands', 'english');
INSERT INTO emkt_regions VALUES(511, 31, 'DG', 'Diego Garcia', 'english');

INSERT INTO emkt_countries VALUES (32,'Brunei Darussalam','english','BN','BRN','');

INSERT INTO emkt_regions VALUES(512, 32, 'BE', 'Belait', 'english');
INSERT INTO emkt_regions VALUES(513, 32, 'BM', 'Brunei-Muara', 'english');
INSERT INTO emkt_regions VALUES(514, 32, 'TE', 'Temburong', 'english');
INSERT INTO emkt_regions VALUES(515, 32, 'TU', 'Tutong', 'english');

INSERT INTO emkt_countries VALUES (33,'Bulgaria','english','BG','BGR','');

INSERT INTO emkt_regions VALUES(516, 33, '01', 'Blagoevgrad', 'english');
INSERT INTO emkt_regions VALUES(517, 33, '02', 'Burgas', 'english');
INSERT INTO emkt_regions VALUES(518, 33, '03', 'Varna', 'english');
INSERT INTO emkt_regions VALUES(519, 33, '04', 'Veliko Tarnovo', 'english');
INSERT INTO emkt_regions VALUES(520, 33, '05', 'Vidin', 'english');
INSERT INTO emkt_regions VALUES(521, 33, '06', 'Vratsa', 'english');
INSERT INTO emkt_regions VALUES(522, 33, '07', 'Gabrovo', 'english');
INSERT INTO emkt_regions VALUES(523, 33, '08', 'Dobrich', 'english');
INSERT INTO emkt_regions VALUES(524, 33, '09', 'Kardzhali', 'english');
INSERT INTO emkt_regions VALUES(525, 33, '10', 'Kyustendil', 'english');
INSERT INTO emkt_regions VALUES(526, 33, '11', 'Lovech', 'english');
INSERT INTO emkt_regions VALUES(527, 33, '12', 'Montana', 'english');
INSERT INTO emkt_regions VALUES(528, 33, '13', 'Pazardzhik', 'english');
INSERT INTO emkt_regions VALUES(529, 33, '14', 'Pernik', 'english');
INSERT INTO emkt_regions VALUES(530, 33, '15', 'Pleven', 'english');
INSERT INTO emkt_regions VALUES(531, 33, '16', 'Plovdiv', 'english');
INSERT INTO emkt_regions VALUES(532, 33, '17', 'Razgrad', 'english');
INSERT INTO emkt_regions VALUES(533, 33, '18', 'Ruse', 'english');
INSERT INTO emkt_regions VALUES(534, 33, '19', 'Silistra', 'english');
INSERT INTO emkt_regions VALUES(535, 33, '20', 'Sliven', 'english');
INSERT INTO emkt_regions VALUES(536, 33, '21', 'Smolyan', 'english');
INSERT INTO emkt_regions VALUES(537, 33, '23', 'Sofia', 'english');
INSERT INTO emkt_regions VALUES(538, 33, '22', 'Sofia Province', 'english');
INSERT INTO emkt_regions VALUES(539, 33, '24', 'Stara Zagora', 'english');
INSERT INTO emkt_regions VALUES(540, 33, '25', 'Targovishte', 'english');
INSERT INTO emkt_regions VALUES(541, 33, '26', 'Haskovo', 'english');
INSERT INTO emkt_regions VALUES(542, 33, '27', 'Shumen', 'english');
INSERT INTO emkt_regions VALUES(543, 33, '28', 'Yambol', 'english');

INSERT INTO emkt_countries VALUES (34,'Burkina Faso','english','BF','BFA','');

INSERT INTO emkt_regions VALUES(544, 34, 'BAL', 'Balé', 'english');
INSERT INTO emkt_regions VALUES(545, 34, 'BAM', 'Bam', 'english');
INSERT INTO emkt_regions VALUES(546, 34, 'BAN', 'Banwa', 'english');
INSERT INTO emkt_regions VALUES(547, 34, 'BAZ', 'Bazèga', 'english');
INSERT INTO emkt_regions VALUES(548, 34, 'BGR', 'Bougouriba', 'english');
INSERT INTO emkt_regions VALUES(549, 34, 'BLG', 'Boulgou', 'english');
INSERT INTO emkt_regions VALUES(550, 34, 'BLK', 'Boulkiemdé', 'english');
INSERT INTO emkt_regions VALUES(551, 34, 'COM', 'Komoé', 'english');
INSERT INTO emkt_regions VALUES(552, 34, 'GAN', 'Ganzourgou', 'english');
INSERT INTO emkt_regions VALUES(553, 34, 'GNA', 'Gnagna', 'english');
INSERT INTO emkt_regions VALUES(554, 34, 'GOU', 'Gourma', 'english');
INSERT INTO emkt_regions VALUES(555, 34, 'HOU', 'Houet', 'english');
INSERT INTO emkt_regions VALUES(556, 34, 'IOB', 'Ioba', 'english');
INSERT INTO emkt_regions VALUES(557, 34, 'KAD', 'Kadiogo', 'english');
INSERT INTO emkt_regions VALUES(558, 34, 'KEN', 'Kénédougou', 'english');
INSERT INTO emkt_regions VALUES(559, 34, 'KMD', 'Komondjari', 'english');
INSERT INTO emkt_regions VALUES(560, 34, 'KMP', 'Kompienga', 'english');
INSERT INTO emkt_regions VALUES(561, 34, 'KOP', 'Koulpélogo', 'english');
INSERT INTO emkt_regions VALUES(562, 34, 'KOS', 'Kossi', 'english');
INSERT INTO emkt_regions VALUES(563, 34, 'KOT', 'Kouritenga', 'english');
INSERT INTO emkt_regions VALUES(564, 34, 'KOW', 'Kourwéogo', 'english');
INSERT INTO emkt_regions VALUES(565, 34, 'LER', 'Léraba', 'english');
INSERT INTO emkt_regions VALUES(566, 34, 'LOR', 'Loroum', 'english');
INSERT INTO emkt_regions VALUES(567, 34, 'MOU', 'Mouhoun', 'english');
INSERT INTO emkt_regions VALUES(568, 34, 'NAM', 'Namentenga', 'english');
INSERT INTO emkt_regions VALUES(569, 34, 'NAO', 'Naouri', 'english');
INSERT INTO emkt_regions VALUES(570, 34, 'NAY', 'Nayala', 'english');
INSERT INTO emkt_regions VALUES(571, 34, 'NOU', 'Noumbiel', 'english');
INSERT INTO emkt_regions VALUES(572, 34, 'OUB', 'Oubritenga', 'english');
INSERT INTO emkt_regions VALUES(573, 34, 'OUD', 'Oudalan', 'english');
INSERT INTO emkt_regions VALUES(574, 34, 'PAS', 'Passoré', 'english');
INSERT INTO emkt_regions VALUES(575, 34, 'PON', 'Poni', 'english');
INSERT INTO emkt_regions VALUES(576, 34, 'SEN', 'Séno', 'english');
INSERT INTO emkt_regions VALUES(577, 34, 'SIS', 'Sissili', 'english');
INSERT INTO emkt_regions VALUES(578, 34, 'SMT', 'Sanmatenga', 'english');
INSERT INTO emkt_regions VALUES(579, 34, 'SNG', 'Sanguié', 'english');
INSERT INTO emkt_regions VALUES(580, 34, 'SOM', 'Soum', 'english');
INSERT INTO emkt_regions VALUES(581, 34, 'SOR', 'Sourou', 'english');
INSERT INTO emkt_regions VALUES(582, 34, 'TAP', 'Tapoa', 'english');
INSERT INTO emkt_regions VALUES(583, 34, 'TUI', 'Tui', 'english');
INSERT INTO emkt_regions VALUES(584, 34, 'YAG', 'Yagha', 'english');
INSERT INTO emkt_regions VALUES(585, 34, 'YAT', 'Yatenga', 'english');
INSERT INTO emkt_regions VALUES(586, 34, 'ZIR', 'Ziro', 'english');
INSERT INTO emkt_regions VALUES(587, 34, 'ZON', 'Zondoma', 'english');
INSERT INTO emkt_regions VALUES(588, 34, 'ZOU', 'Zoundwéogo', 'english');

INSERT INTO emkt_countries VALUES (35,'Burundi','english','BI','BDI','');

INSERT INTO emkt_regions VALUES(589, 35, 'BB', 'Bubanza', 'english');
INSERT INTO emkt_regions VALUES(590, 35, 'BJ', 'Bujumbura Mairie', 'english');
INSERT INTO emkt_regions VALUES(591, 35, 'BR', 'Bururi', 'english');
INSERT INTO emkt_regions VALUES(592, 35, 'CA', 'Cankuzo', 'english');
INSERT INTO emkt_regions VALUES(593, 35, 'CI', 'Cibitoke', 'english');
INSERT INTO emkt_regions VALUES(594, 35, 'GI', 'Gitega', 'english');
INSERT INTO emkt_regions VALUES(595, 35, 'KR', 'Karuzi', 'english');
INSERT INTO emkt_regions VALUES(596, 35, 'KY', 'Kayanza', 'english');
INSERT INTO emkt_regions VALUES(597, 35, 'KI', 'Kirundo', 'english');
INSERT INTO emkt_regions VALUES(598, 35, 'MA', 'Makamba', 'english');
INSERT INTO emkt_regions VALUES(599, 35, 'MU', 'Muramvya', 'english');
INSERT INTO emkt_regions VALUES(600, 35, 'MY', 'Muyinga', 'english');
INSERT INTO emkt_regions VALUES(601, 35, 'MW', 'Mwaro', 'english');
INSERT INTO emkt_regions VALUES(602, 35, 'NG', 'Ngozi', 'english');
INSERT INTO emkt_regions VALUES(603, 35, 'RT', 'Rutana', 'english');
INSERT INTO emkt_regions VALUES(604, 35, 'RY', 'Ruyigi', 'english');

INSERT INTO emkt_countries VALUES (36,'Cambodia','english','KH','KHM','');

INSERT INTO emkt_regions VALUES(4255, 36, 'NOCODE', 'Cambodia', 'english');

INSERT INTO emkt_countries VALUES (37,'Cameroon','english','CM','CMR','');

INSERT INTO emkt_regions VALUES(605, 37, 'AD', 'Adamaoua', 'english');
INSERT INTO emkt_regions VALUES(606, 37, 'CE', 'Centre', 'english');
INSERT INTO emkt_regions VALUES(607, 37, 'EN', 'Extrême-Nord', 'english');
INSERT INTO emkt_regions VALUES(608, 37, 'ES', 'Est', 'english');
INSERT INTO emkt_regions VALUES(609, 37, 'LT', 'Littoral', 'english');
INSERT INTO emkt_regions VALUES(610, 37, 'NO', 'Nord', 'english');
INSERT INTO emkt_regions VALUES(611, 37, 'NW', 'Nord-Ouest', 'english');
INSERT INTO emkt_regions VALUES(612, 37, 'OU', 'Ouest', 'english');
INSERT INTO emkt_regions VALUES(613, 37, 'SU', 'Sud', 'english');
INSERT INTO emkt_regions VALUES(614, 37, 'SW', 'Sud-Ouest', 'english');

INSERT INTO emkt_countries VALUES (38,'Canada','english','CA','CAN','');

INSERT INTO emkt_regions VALUES(615, 38, 'AB', 'Alberta', 'english');
INSERT INTO emkt_regions VALUES(616, 38, 'BC', 'British Columbia', 'english');
INSERT INTO emkt_regions VALUES(617, 38, 'MB', 'Manitoba', 'english');
INSERT INTO emkt_regions VALUES(618, 38, 'NB', 'New Brunswick', 'english');
INSERT INTO emkt_regions VALUES(619, 38, 'NL', 'Newfoundland and Labrador', 'english');
INSERT INTO emkt_regions VALUES(620, 38, 'NS', 'Nova Scotia', 'english');
INSERT INTO emkt_regions VALUES(621, 38, 'NT', 'Northwest Territories', 'english');
INSERT INTO emkt_regions VALUES(622, 38, 'NU', 'Nunavut', 'english');
INSERT INTO emkt_regions VALUES(623, 38, 'ON', 'Ontario', 'english');
INSERT INTO emkt_regions VALUES(624, 38, 'PE', 'Prince Edward Island', 'english');
INSERT INTO emkt_regions VALUES(625, 38, 'QC', 'Quebec', 'english');
INSERT INTO emkt_regions VALUES(626, 38, 'SK', 'Saskatchewan', 'english');
INSERT INTO emkt_regions VALUES(627, 38, 'YT', 'Yukon Territory', 'english');

INSERT INTO emkt_countries VALUES (39,'Cape Verde','english','CV','CPV','');

INSERT INTO emkt_regions VALUES(628, 39, 'BR', 'Brava', 'english');
INSERT INTO emkt_regions VALUES(629, 39, 'BV', 'Boa Vista', 'english');
INSERT INTO emkt_regions VALUES(630, 39, 'CA', 'Santa Catarina', 'english');
INSERT INTO emkt_regions VALUES(631, 39, 'CR', 'Santa Cruz', 'english');
INSERT INTO emkt_regions VALUES(632, 39, 'CS', 'Calheta de São Miguel', 'english');
INSERT INTO emkt_regions VALUES(633, 39, 'MA', 'Maio', 'english');
INSERT INTO emkt_regions VALUES(634, 39, 'MO', 'Mosteiros', 'english');
INSERT INTO emkt_regions VALUES(635, 39, 'PA', 'Paúl', 'english');
INSERT INTO emkt_regions VALUES(636, 39, 'PN', 'Porto Novo', 'english');
INSERT INTO emkt_regions VALUES(637, 39, 'PR', 'Praia', 'english');
INSERT INTO emkt_regions VALUES(638, 39, 'RG', 'Ribeira Grande', 'english');
INSERT INTO emkt_regions VALUES(639, 39, 'SD', 'São Domingos', 'english');
INSERT INTO emkt_regions VALUES(640, 39, 'SF', 'São Filipe', 'english');
INSERT INTO emkt_regions VALUES(641, 39, 'SL', 'Sal', 'english');
INSERT INTO emkt_regions VALUES(642, 39, 'SN', 'São Nicolau', 'english');
INSERT INTO emkt_regions VALUES(643, 39, 'SV', 'São Vicente', 'english');
INSERT INTO emkt_regions VALUES(644, 39, 'TA', 'Tarrafal', 'english');

INSERT INTO emkt_countries VALUES (40,'Cayman Islands','english','KY','CYM','');

INSERT INTO emkt_regions VALUES(645, 40, 'CR', 'Creek', 'english');
INSERT INTO emkt_regions VALUES(646, 40, 'EA', 'Eastern', 'english');
INSERT INTO emkt_regions VALUES(647, 40, 'MI', 'Midland', 'english');
INSERT INTO emkt_regions VALUES(648, 40, 'SO', 'South Town', 'english');
INSERT INTO emkt_regions VALUES(649, 40, 'SP', 'Spot Bay', 'english');
INSERT INTO emkt_regions VALUES(650, 40, 'ST', 'Stake Bay', 'english');
INSERT INTO emkt_regions VALUES(651, 40, 'WD', 'West End', 'english');
INSERT INTO emkt_regions VALUES(652, 40, 'WN', 'Western', 'english');

INSERT INTO emkt_countries VALUES (41,'Central African Republic','english','CF','CAF','');

INSERT INTO emkt_regions VALUES(653, 41, 'AC ', 'Ouham', 'english');
INSERT INTO emkt_regions VALUES(654, 41, 'BB ', 'Bamingui-Bangoran', 'english');
INSERT INTO emkt_regions VALUES(655, 41, 'BGF', 'Bangui', 'english');
INSERT INTO emkt_regions VALUES(656, 41, 'BK ', 'Basse-Kotto', 'english');
INSERT INTO emkt_regions VALUES(657, 41, 'HK ', 'Haute-Kotto', 'english');
INSERT INTO emkt_regions VALUES(658, 41, 'HM ', 'Haut-Mbomou', 'english');
INSERT INTO emkt_regions VALUES(659, 41, 'HS ', 'Mambéré-Kadéï', 'english');
INSERT INTO emkt_regions VALUES(660, 41, 'KB ', 'Nana-Grébizi', 'english');
INSERT INTO emkt_regions VALUES(661, 41, 'KG ', 'Kémo', 'english');
INSERT INTO emkt_regions VALUES(662, 41, 'LB ', 'Lobaye', 'english');
INSERT INTO emkt_regions VALUES(663, 41, 'MB ', 'Mbomou', 'english');
INSERT INTO emkt_regions VALUES(664, 41, 'MP ', 'Ombella-M\'Poko', 'english');
INSERT INTO emkt_regions VALUES(665, 41, 'NM ', 'Nana-Mambéré', 'english');
INSERT INTO emkt_regions VALUES(666, 41, 'OP ', 'Ouham-Pendé', 'english');
INSERT INTO emkt_regions VALUES(667, 41, 'SE ', 'Sangha-Mbaéré', 'english');
INSERT INTO emkt_regions VALUES(668, 41, 'UK ', 'Ouaka', 'english');
INSERT INTO emkt_regions VALUES(669, 41, 'VR ', 'Vakaga', 'english');

INSERT INTO emkt_countries VALUES (42,'Chad','english','TD','TCD','');

INSERT INTO emkt_regions VALUES(670, 42, 'BA ', 'Batha', 'english');
INSERT INTO emkt_regions VALUES(671, 42, 'BET', 'Borkou-Ennedi-Tibesti', 'english');
INSERT INTO emkt_regions VALUES(672, 42, 'BI ', 'Biltine', 'english');
INSERT INTO emkt_regions VALUES(673, 42, 'CB ', 'Chari-Baguirmi', 'english');
INSERT INTO emkt_regions VALUES(674, 42, 'GR ', 'Guéra', 'english');
INSERT INTO emkt_regions VALUES(675, 42, 'KA ', 'Kanem', 'english');
INSERT INTO emkt_regions VALUES(676, 42, 'LC ', 'Lac', 'english');
INSERT INTO emkt_regions VALUES(677, 42, 'LR ', 'Logone-Oriental', 'english');
INSERT INTO emkt_regions VALUES(678, 42, 'LO ', 'Logone-Occidental', 'english');
INSERT INTO emkt_regions VALUES(679, 42, 'MC ', 'Moyen-Chari', 'english');
INSERT INTO emkt_regions VALUES(680, 42, 'MK ', 'Mayo-Kébbi', 'english');
INSERT INTO emkt_regions VALUES(681, 42, 'OD ', 'Ouaddaï', 'english');
INSERT INTO emkt_regions VALUES(682, 42, 'SA ', 'Salamat', 'english');
INSERT INTO emkt_regions VALUES(683, 42, 'TA ', 'Tandjilé', 'english');

INSERT INTO emkt_countries VALUES (43,'Chile','english','CL','CHL','');

INSERT INTO emkt_regions VALUES(684, 43, 'AI', 'Aisén del General Carlos Ibañez', 'english');
INSERT INTO emkt_regions VALUES(685, 43, 'AN', 'Antofagasta', 'english');
INSERT INTO emkt_regions VALUES(686, 43, 'AR', 'La Araucanía', 'english');
INSERT INTO emkt_regions VALUES(687, 43, 'AT', 'Atacama', 'english');
INSERT INTO emkt_regions VALUES(688, 43, 'BI', 'Biobío', 'english');
INSERT INTO emkt_regions VALUES(689, 43, 'CO', 'Coquimbo', 'english');
INSERT INTO emkt_regions VALUES(690, 43, 'LI', 'Libertador Bernardo O\'Higgins', 'english');
INSERT INTO emkt_regions VALUES(691, 43, 'LL', 'Los Lagos', 'english');
INSERT INTO emkt_regions VALUES(692, 43, 'MA', 'Magallanes y de la Antartica', 'english');
INSERT INTO emkt_regions VALUES(693, 43, 'ML', 'Maule', 'english');
INSERT INTO emkt_regions VALUES(694, 43, 'RM', 'Metropolitana de Santiago', 'english');
INSERT INTO emkt_regions VALUES(695, 43, 'TA', 'Tarapacá', 'english');
INSERT INTO emkt_regions VALUES(696, 43, 'VS', 'Valparaíso', 'english');

INSERT INTO emkt_countries VALUES (44,'China','english','CN','CHN','');

INSERT INTO emkt_regions VALUES(697, 44, '11', '北京', 'english');
INSERT INTO emkt_regions VALUES(698, 44, '12', '天津', 'english');
INSERT INTO emkt_regions VALUES(699, 44, '13', '河北', 'english');
INSERT INTO emkt_regions VALUES(700, 44, '14', '山西', 'english');
INSERT INTO emkt_regions VALUES(701, 44, '15', '内蒙古自治区', 'english');
INSERT INTO emkt_regions VALUES(702, 44, '21', '辽宁', 'english');
INSERT INTO emkt_regions VALUES(703, 44, '22', '吉林', 'english');
INSERT INTO emkt_regions VALUES(704, 44, '23', '黑龙江省', 'english');
INSERT INTO emkt_regions VALUES(705, 44, '31', '上海', 'english');
INSERT INTO emkt_regions VALUES(706, 44, '32', '江苏', 'english');
INSERT INTO emkt_regions VALUES(707, 44, '33', '浙江', 'english');
INSERT INTO emkt_regions VALUES(708, 44, '34', '安徽', 'english');
INSERT INTO emkt_regions VALUES(709, 44, '35', '福建', 'english');
INSERT INTO emkt_regions VALUES(710, 44, '36', '江西', 'english');
INSERT INTO emkt_regions VALUES(711, 44, '37', '山东', 'english');
INSERT INTO emkt_regions VALUES(712, 44, '41', '河南', 'english');
INSERT INTO emkt_regions VALUES(713, 44, '42', '湖北', 'english');
INSERT INTO emkt_regions VALUES(714, 44, '43', '湖南', 'english');
INSERT INTO emkt_regions VALUES(715, 44, '44', '广东', 'english');
INSERT INTO emkt_regions VALUES(716, 44, '45', '广西壮族自治区', 'english');
INSERT INTO emkt_regions VALUES(717, 44, '46', '海南', 'english');
INSERT INTO emkt_regions VALUES(718, 44, '50', '重庆', 'english');
INSERT INTO emkt_regions VALUES(719, 44, '51', '四川', 'english');
INSERT INTO emkt_regions VALUES(720, 44, '52', '贵州', 'english');
INSERT INTO emkt_regions VALUES(721, 44, '53', '云南', 'english');
INSERT INTO emkt_regions VALUES(722, 44, '54', '西藏自治区', 'english');
INSERT INTO emkt_regions VALUES(723, 44, '61', '陕西', 'english');
INSERT INTO emkt_regions VALUES(724, 44, '62', '甘肃', 'english');
INSERT INTO emkt_regions VALUES(725, 44, '63', '青海', 'english');
INSERT INTO emkt_regions VALUES(726, 44, '64', '宁夏', 'english');
INSERT INTO emkt_regions VALUES(727, 44, '65', '新疆', 'english');
INSERT INTO emkt_regions VALUES(728, 44, '71', '臺灣', 'english');
INSERT INTO emkt_regions VALUES(729, 44, '91', '香港', 'english');
INSERT INTO emkt_regions VALUES(730, 44, '92', '澳門', 'english');

INSERT INTO emkt_countries VALUES (45,'Christmas Island','english','CX','CXR','');

INSERT INTO emkt_regions VALUES(4256, 45, 'NOCODE', 'Christmas Island', 'english');

INSERT INTO emkt_countries VALUES (46,'Cocos (Keeling) Islands','english','CC','CCK','');

INSERT INTO emkt_regions VALUES(731, 46, 'D', 'Direction Island', 'english');
INSERT INTO emkt_regions VALUES(732, 46, 'H', 'Home Island', 'english');
INSERT INTO emkt_regions VALUES(733, 46, 'O', 'Horsburgh Island', 'english');
INSERT INTO emkt_regions VALUES(734, 46, 'S', 'South Island', 'english');
INSERT INTO emkt_regions VALUES(735, 46, 'W', 'West Island', 'english');

INSERT INTO emkt_countries VALUES (47,'Colombia','english','CO','COL','');

INSERT INTO emkt_regions VALUES(736, 47, 'AMA', 'Amazonas', 'english');
INSERT INTO emkt_regions VALUES(737, 47, 'ANT', 'Antioquia', 'english');
INSERT INTO emkt_regions VALUES(738, 47, 'ARA', 'Arauca', 'english');
INSERT INTO emkt_regions VALUES(739, 47, 'ATL', 'Atlántico', 'english');
INSERT INTO emkt_regions VALUES(740, 47, 'BOL', 'Bolívar', 'english');
INSERT INTO emkt_regions VALUES(741, 47, 'BOY', 'Boyacá', 'english');
INSERT INTO emkt_regions VALUES(742, 47, 'CAL', 'Caldas', 'english');
INSERT INTO emkt_regions VALUES(743, 47, 'CAQ', 'Caquetá', 'english');
INSERT INTO emkt_regions VALUES(744, 47, 'CAS', 'Casanare', 'english');
INSERT INTO emkt_regions VALUES(745, 47, 'CAU', 'Cauca', 'english');
INSERT INTO emkt_regions VALUES(746, 47, 'CES', 'Cesar', 'english');
INSERT INTO emkt_regions VALUES(747, 47, 'CHO', 'Chocó', 'english');
INSERT INTO emkt_regions VALUES(748, 47, 'COR', 'Córdoba', 'english');
INSERT INTO emkt_regions VALUES(749, 47, 'CUN', 'Cundinamarca', 'english');
INSERT INTO emkt_regions VALUES(750, 47, 'DC', 'Bogotá Distrito Capital', 'english');
INSERT INTO emkt_regions VALUES(751, 47, 'GUA', 'Guainía', 'english');
INSERT INTO emkt_regions VALUES(752, 47, 'GUV', 'Guaviare', 'english');
INSERT INTO emkt_regions VALUES(753, 47, 'HUI', 'Huila', 'english');
INSERT INTO emkt_regions VALUES(754, 47, 'LAG', 'La Guajira', 'english');
INSERT INTO emkt_regions VALUES(755, 47, 'MAG', 'Magdalena', 'english');
INSERT INTO emkt_regions VALUES(756, 47, 'MET', 'Meta', 'english');
INSERT INTO emkt_regions VALUES(757, 47, 'NAR', 'Nariño', 'english');
INSERT INTO emkt_regions VALUES(758, 47, 'NSA', 'Norte de Santander', 'english');
INSERT INTO emkt_regions VALUES(759, 47, 'PUT', 'Putumayo', 'english');
INSERT INTO emkt_regions VALUES(760, 47, 'QUI', 'Quindío', 'english');
INSERT INTO emkt_regions VALUES(761, 47, 'RIS', 'Risaralda', 'english');
INSERT INTO emkt_regions VALUES(762, 47, 'SAN', 'Santander', 'english');
INSERT INTO emkt_regions VALUES(763, 47, 'SAP', 'San Andrés y Providencia', 'english');
INSERT INTO emkt_regions VALUES(764, 47, 'SUC', 'Sucre', 'english');
INSERT INTO emkt_regions VALUES(765, 47, 'TOL', 'Tolima', 'english');
INSERT INTO emkt_regions VALUES(766, 47, 'VAC', 'Valle del Cauca', 'english');
INSERT INTO emkt_regions VALUES(767, 47, 'VAU', 'Vaupés', 'english');
INSERT INTO emkt_regions VALUES(768, 47, 'VID', 'Vichada', 'english');

INSERT INTO emkt_countries VALUES (48,'Comoros','english','KM','COM','');

INSERT INTO emkt_regions VALUES(769, 48, 'A', 'Anjouan', 'english');
INSERT INTO emkt_regions VALUES(770, 48, 'G', 'Grande Comore', 'english');
INSERT INTO emkt_regions VALUES(771, 48, 'M', 'Mohéli', 'english');

INSERT INTO emkt_countries VALUES (49,'Congo','english','CG','COG','');

INSERT INTO emkt_regions VALUES(772, 49, 'BC', 'Congo-Central', 'english');
INSERT INTO emkt_regions VALUES(773, 49, 'BN', 'Bandundu', 'english');
INSERT INTO emkt_regions VALUES(774, 49, 'EQ', 'Équateur', 'english');
INSERT INTO emkt_regions VALUES(775, 49, 'KA', 'Katanga', 'english');
INSERT INTO emkt_regions VALUES(776, 49, 'KE', 'Kasai-Oriental', 'english');
INSERT INTO emkt_regions VALUES(777, 49, 'KN', 'Kinshasa', 'english');
INSERT INTO emkt_regions VALUES(778, 49, 'KW', 'Kasai-Occidental', 'english');
INSERT INTO emkt_regions VALUES(779, 49, 'MA', 'Maniema', 'english');
INSERT INTO emkt_regions VALUES(780, 49, 'NK', 'Nord-Kivu', 'english');
INSERT INTO emkt_regions VALUES(781, 49, 'OR', 'Orientale', 'english');
INSERT INTO emkt_regions VALUES(782, 49, 'SK', 'Sud-Kivu', 'english');

INSERT INTO emkt_countries VALUES (50,'Cook Islands','english','CK','COK','');

INSERT INTO emkt_regions VALUES(783, 50, 'PU', 'Pukapuka', 'english');
INSERT INTO emkt_regions VALUES(784, 50, 'RK', 'Rakahanga', 'english');
INSERT INTO emkt_regions VALUES(785, 50, 'MK', 'Manihiki', 'english');
INSERT INTO emkt_regions VALUES(786, 50, 'PE', 'Penrhyn', 'english');
INSERT INTO emkt_regions VALUES(787, 50, 'NI', 'Nassau Island', 'english');
INSERT INTO emkt_regions VALUES(788, 50, 'SU', 'Surwarrow', 'english');
INSERT INTO emkt_regions VALUES(789, 50, 'PA', 'Palmerston', 'english');
INSERT INTO emkt_regions VALUES(790, 50, 'AI', 'Aitutaki', 'english');
INSERT INTO emkt_regions VALUES(791, 50, 'MA', 'Manuae', 'english');
INSERT INTO emkt_regions VALUES(792, 50, 'TA', 'Takutea', 'english');
INSERT INTO emkt_regions VALUES(793, 50, 'MT', 'Mitiaro', 'english');
INSERT INTO emkt_regions VALUES(794, 50, 'AT', 'Atiu', 'english');
INSERT INTO emkt_regions VALUES(795, 50, 'MU', 'Mauke', 'english');
INSERT INTO emkt_regions VALUES(796, 50, 'RR', 'Rarotonga', 'english');
INSERT INTO emkt_regions VALUES(797, 50, 'MG', 'Mangaia', 'english');

INSERT INTO emkt_countries VALUES (51,'Costa Rica','english','CR','CRI','');

INSERT INTO emkt_regions VALUES(798, 51, 'A', 'Alajuela', 'english');
INSERT INTO emkt_regions VALUES(799, 51, 'C', 'Cartago', 'english');
INSERT INTO emkt_regions VALUES(800, 51, 'G', 'Guanacaste', 'english');
INSERT INTO emkt_regions VALUES(801, 51, 'H', 'Heredia', 'english');
INSERT INTO emkt_regions VALUES(802, 51, 'L', 'Limón', 'english');
INSERT INTO emkt_regions VALUES(803, 51, 'P', 'Puntarenas', 'english');
INSERT INTO emkt_regions VALUES(804, 51, 'SJ', 'San José', 'english');

INSERT INTO emkt_countries VALUES (52,'Cote D\'Ivoire','english','CI','CIV','');

INSERT INTO emkt_regions VALUES(805, 52, '01', 'Lagunes', 'english');
INSERT INTO emkt_regions VALUES(806, 52, '02', 'Haut-Sassandra', 'english');
INSERT INTO emkt_regions VALUES(807, 52, '03', 'Savanes', 'english');
INSERT INTO emkt_regions VALUES(808, 52, '04', 'Vallée du Bandama', 'english');
INSERT INTO emkt_regions VALUES(809, 52, '05', 'Moyen-Comoé', 'english');
INSERT INTO emkt_regions VALUES(810, 52, '06', 'Dix-Huit', 'english');
INSERT INTO emkt_regions VALUES(811, 52, '07', 'Lacs', 'english');
INSERT INTO emkt_regions VALUES(812, 52, '08', 'Zanzan', 'english');
INSERT INTO emkt_regions VALUES(813, 52, '09', 'Bas-Sassandra', 'english');
INSERT INTO emkt_regions VALUES(814, 52, '10', 'Denguélé', 'english');
INSERT INTO emkt_regions VALUES(815, 52, '11', 'N\'zi-Comoé', 'english');
INSERT INTO emkt_regions VALUES(816, 52, '12', 'Marahoué', 'english');
INSERT INTO emkt_regions VALUES(817, 52, '13', 'Sud-Comoé', 'english');
INSERT INTO emkt_regions VALUES(818, 52, '14', 'Worodouqou', 'english');
INSERT INTO emkt_regions VALUES(819, 52, '15', 'Sud-Bandama', 'english');
INSERT INTO emkt_regions VALUES(820, 52, '16', 'Agnébi', 'english');
INSERT INTO emkt_regions VALUES(821, 52, '17', 'Bafing', 'english');
INSERT INTO emkt_regions VALUES(822, 52, '18', 'Fromager', 'english');
INSERT INTO emkt_regions VALUES(823, 52, '19', 'Moyen-Cavally', 'english');

INSERT INTO emkt_countries VALUES (53,'Croatia','english','HR','HRV','');

INSERT INTO emkt_regions VALUES(824, 53, '01', 'Zagrebačka županija', 'english');
INSERT INTO emkt_regions VALUES(825, 53, '02', 'Krapinsko-zagorska županija', 'english');
INSERT INTO emkt_regions VALUES(826, 53, '03', 'Sisačko-moslavačka županija', 'english');
INSERT INTO emkt_regions VALUES(827, 53, '04', 'Karlovačka županija', 'english');
INSERT INTO emkt_regions VALUES(828, 53, '05', 'Varaždinska županija', 'english');
INSERT INTO emkt_regions VALUES(829, 53, '06', 'Koprivničko-križevačka županija', 'english');
INSERT INTO emkt_regions VALUES(830, 53, '07', 'Bjelovarsko-bilogorska županija', 'english');
INSERT INTO emkt_regions VALUES(831, 53, '08', 'Primorsko-goranska županija', 'english');
INSERT INTO emkt_regions VALUES(832, 53, '09', 'Ličko-senjska županija', 'english');
INSERT INTO emkt_regions VALUES(833, 53, '10', 'Virovitičko-podravska županija', 'english');
INSERT INTO emkt_regions VALUES(834, 53, '11', 'Požeško-slavonska županija', 'english');
INSERT INTO emkt_regions VALUES(835, 53, '12', 'Brodsko-posavska županija', 'english');
INSERT INTO emkt_regions VALUES(836, 53, '13', 'Zadarska županija', 'english');
INSERT INTO emkt_regions VALUES(837, 53, '14', 'Osječko-baranjska županija', 'english');
INSERT INTO emkt_regions VALUES(838, 53, '15', 'Šibensko-kninska županija', 'english');
INSERT INTO emkt_regions VALUES(839, 53, '16', 'Vukovarsko-srijemska županija', 'english');
INSERT INTO emkt_regions VALUES(840, 53, '17', 'Splitsko-dalmatinska županija', 'english');
INSERT INTO emkt_regions VALUES(841, 53, '18', 'Istarska županija', 'english');
INSERT INTO emkt_regions VALUES(842, 53, '19', 'Dubrovačko-neretvanska županija', 'english');
INSERT INTO emkt_regions VALUES(843, 53, '20', 'Međimurska županija', 'english');
INSERT INTO emkt_regions VALUES(844, 53, '21', 'Zagreb', 'english');

INSERT INTO emkt_countries VALUES (54,'Cuba','english','CU','CUB','');

INSERT INTO emkt_regions VALUES(845, 54, '01', 'Pinar del Río', 'english');
INSERT INTO emkt_regions VALUES(846, 54, '02', 'La Habana', 'english');
INSERT INTO emkt_regions VALUES(847, 54, '03', 'Ciudad de La Habana', 'english');
INSERT INTO emkt_regions VALUES(848, 54, '04', 'Matanzas', 'english');
INSERT INTO emkt_regions VALUES(849, 54, '05', 'Villa Clara', 'english');
INSERT INTO emkt_regions VALUES(850, 54, '06', 'Cienfuegos', 'english');
INSERT INTO emkt_regions VALUES(851, 54, '07', 'Sancti Spíritus', 'english');
INSERT INTO emkt_regions VALUES(852, 54, '08', 'Ciego de Ávila', 'english');
INSERT INTO emkt_regions VALUES(853, 54, '09', 'Camagüey', 'english');
INSERT INTO emkt_regions VALUES(854, 54, '10', 'Las Tunas', 'english');
INSERT INTO emkt_regions VALUES(855, 54, '11', 'Holguín', 'english');
INSERT INTO emkt_regions VALUES(856, 54, '12', 'Granma', 'english');
INSERT INTO emkt_regions VALUES(857, 54, '13', 'Santiago de Cuba', 'english');
INSERT INTO emkt_regions VALUES(858, 54, '14', 'Guantánamo', 'english');
INSERT INTO emkt_regions VALUES(859, 54, '99', 'Isla de la Juventud', 'english');

INSERT INTO emkt_countries VALUES (55,'Cyprus','english','CY','CYP','');

INSERT INTO emkt_regions VALUES(860, 55, '01', 'Κερύvεια', 'english');
INSERT INTO emkt_regions VALUES(861, 55, '02', 'Λευκωσία', 'english');
INSERT INTO emkt_regions VALUES(862, 55, '03', 'Αμμόχωστος', 'english');
INSERT INTO emkt_regions VALUES(863, 55, '04', 'Λάρνακα', 'english');
INSERT INTO emkt_regions VALUES(864, 55, '05', 'Λεμεσός', 'english');
INSERT INTO emkt_regions VALUES(865, 55, '06', 'Πάφος', 'english');

INSERT INTO emkt_countries VALUES (56,'Czech Republic','english','CZ','CZE','');

INSERT INTO emkt_regions VALUES(866, 56, 'JC', 'Jihočeský kraj', 'english');
INSERT INTO emkt_regions VALUES(867, 56, 'JM', 'Jihomoravský kraj', 'english');
INSERT INTO emkt_regions VALUES(868, 56, 'KA', 'Karlovarský kraj', 'english');
INSERT INTO emkt_regions VALUES(869, 56, 'VY', 'Vysočina kraj', 'english');
INSERT INTO emkt_regions VALUES(870, 56, 'KR', 'Královéhradecký kraj', 'english');
INSERT INTO emkt_regions VALUES(871, 56, 'LI', 'Liberecký kraj', 'english');
INSERT INTO emkt_regions VALUES(872, 56, 'MO', 'Moravskoslezský kraj', 'english');
INSERT INTO emkt_regions VALUES(873, 56, 'OL', 'Olomoucký kraj', 'english');
INSERT INTO emkt_regions VALUES(874, 56, 'PA', 'Pardubický kraj', 'english');
INSERT INTO emkt_regions VALUES(875, 56, 'PL', 'Plzeňský kraj', 'english');
INSERT INTO emkt_regions VALUES(876, 56, 'PR', 'Hlavní město Praha', 'english');
INSERT INTO emkt_regions VALUES(877, 56, 'ST', 'Středočeský kraj', 'english');
INSERT INTO emkt_regions VALUES(878, 56, 'US', 'Ústecký kraj', 'english');
INSERT INTO emkt_regions VALUES(879, 56, 'ZL', 'Zlínský kraj', 'english');

INSERT INTO emkt_countries VALUES (57,'Denmark','english','DK','DNK','');

INSERT INTO emkt_regions VALUES(880, 57, '040', 'Bornholms Regionskommune', 'english');
INSERT INTO emkt_regions VALUES(881, 57, '101', 'København', 'english');
INSERT INTO emkt_regions VALUES(882, 57, '147', 'Frederiksberg', 'english');
INSERT INTO emkt_regions VALUES(883, 57, '070', 'Århus Amt', 'english');
INSERT INTO emkt_regions VALUES(884, 57, '015', 'Københavns Amt', 'english');
INSERT INTO emkt_regions VALUES(885, 57, '020', 'Frederiksborg Amt', 'english');
INSERT INTO emkt_regions VALUES(886, 57, '042', 'Fyns Amt', 'english');
INSERT INTO emkt_regions VALUES(887, 57, '080', 'Nordjyllands Amt', 'english');
INSERT INTO emkt_regions VALUES(888, 57, '055', 'Ribe Amt', 'english');
INSERT INTO emkt_regions VALUES(889, 57, '065', 'Ringkjøbing Amt', 'english');
INSERT INTO emkt_regions VALUES(890, 57, '025', 'Roskilde Amt', 'english');
INSERT INTO emkt_regions VALUES(891, 57, '050', 'Sønderjyllands Amt', 'english');
INSERT INTO emkt_regions VALUES(892, 57, '035', 'Storstrøms Amt', 'english');
INSERT INTO emkt_regions VALUES(893, 57, '060', 'Vejle Amt', 'english');
INSERT INTO emkt_regions VALUES(894, 57, '030', 'Vestsjællands Amt', 'english');
INSERT INTO emkt_regions VALUES(895, 57, '076', 'Viborg Amt', 'english');

INSERT INTO emkt_countries VALUES (58,'Djibouti','english','DJ','DJI','');

INSERT INTO emkt_regions VALUES(896, 58, 'AS', 'Region d\'Ali Sabieh', 'english');
INSERT INTO emkt_regions VALUES(897, 58, 'AR', 'Region d\'Arta', 'english');
INSERT INTO emkt_regions VALUES(898, 58, 'DI', 'Region de Dikhil', 'english');
INSERT INTO emkt_regions VALUES(899, 58, 'DJ', 'Ville de Djibouti', 'english');
INSERT INTO emkt_regions VALUES(900, 58, 'OB', 'Region d\'Obock', 'english');
INSERT INTO emkt_regions VALUES(901, 58, 'TA', 'Region de Tadjourah', 'english');

INSERT INTO emkt_countries VALUES (59,'Dominica','english','DM','DMA','');

INSERT INTO emkt_regions VALUES(902, 59, 'AND', 'Saint Andrew Parish', 'english');
INSERT INTO emkt_regions VALUES(903, 59, 'DAV', 'Saint David Parish', 'english');
INSERT INTO emkt_regions VALUES(904, 59, 'GEO', 'Saint George Parish', 'english');
INSERT INTO emkt_regions VALUES(905, 59, 'JOH', 'Saint John Parish', 'english');
INSERT INTO emkt_regions VALUES(906, 59, 'JOS', 'Saint Joseph Parish', 'english');
INSERT INTO emkt_regions VALUES(907, 59, 'LUK', 'Saint Luke Parish', 'english');
INSERT INTO emkt_regions VALUES(908, 59, 'MAR', 'Saint Mark Parish', 'english');
INSERT INTO emkt_regions VALUES(909, 59, 'PAT', 'Saint Patrick Parish', 'english');
INSERT INTO emkt_regions VALUES(910, 59, 'PAU', 'Saint Paul Parish', 'english');
INSERT INTO emkt_regions VALUES(911, 59, 'PET', 'Saint Peter Parish', 'english');

INSERT INTO emkt_countries VALUES (60,'Dominican Republic','english','DO','DOM','');

INSERT INTO emkt_regions VALUES(912, 60, '01', 'Distrito Nacional', 'english');
INSERT INTO emkt_regions VALUES(913, 60, '02', 'Ázua', 'english');
INSERT INTO emkt_regions VALUES(914, 60, '03', 'Baoruco', 'english');
INSERT INTO emkt_regions VALUES(915, 60, '04', 'Barahona', 'english');
INSERT INTO emkt_regions VALUES(916, 60, '05', 'Dajabón', 'english');
INSERT INTO emkt_regions VALUES(917, 60, '06', 'Duarte', 'english');
INSERT INTO emkt_regions VALUES(918, 60, '07', 'Elías Piña', 'english');
INSERT INTO emkt_regions VALUES(919, 60, '08', 'El Seibo', 'english');
INSERT INTO emkt_regions VALUES(920, 60, '09', 'Espaillat', 'english');
INSERT INTO emkt_regions VALUES(921, 60, '10', 'Independencia', 'english');
INSERT INTO emkt_regions VALUES(922, 60, '11', 'La Altagracia', 'english');
INSERT INTO emkt_regions VALUES(923, 60, '12', 'La Romana', 'english');
INSERT INTO emkt_regions VALUES(924, 60, '13', 'La Vega', 'english');
INSERT INTO emkt_regions VALUES(925, 60, '14', 'María Trinidad Sánchez', 'english');
INSERT INTO emkt_regions VALUES(926, 60, '15', 'Monte Cristi', 'english');
INSERT INTO emkt_regions VALUES(927, 60, '16', 'Pedernales', 'english');
INSERT INTO emkt_regions VALUES(928, 60, '17', 'Peravia', 'english');
INSERT INTO emkt_regions VALUES(929, 60, '18', 'Puerto Plata', 'english');
INSERT INTO emkt_regions VALUES(930, 60, '19', 'Salcedo', 'english');
INSERT INTO emkt_regions VALUES(931, 60, '20', 'Samaná', 'english');
INSERT INTO emkt_regions VALUES(932, 60, '21', 'San Cristóbal', 'english');
INSERT INTO emkt_regions VALUES(933, 60, '22', 'San Juan', 'english');
INSERT INTO emkt_regions VALUES(934, 60, '23', 'San Pedro de Macorís', 'english');
INSERT INTO emkt_regions VALUES(935, 60, '24', 'Sánchez Ramírez', 'english');
INSERT INTO emkt_regions VALUES(936, 60, '25', 'Santiago', 'english');
INSERT INTO emkt_regions VALUES(937, 60, '26', 'Santiago Rodríguez', 'english');
INSERT INTO emkt_regions VALUES(938, 60, '27', 'Valverde', 'english');
INSERT INTO emkt_regions VALUES(939, 60, '28', 'Monseñor Nouel', 'english');
INSERT INTO emkt_regions VALUES(940, 60, '29', 'Monte Plata', 'english');
INSERT INTO emkt_regions VALUES(941, 60, '30', 'Hato Mayor', 'english');

INSERT INTO emkt_countries VALUES (61,'East Timor','english','TP','TMP','');

INSERT INTO emkt_regions VALUES(942, 61, 'AL', 'Aileu', 'english');
INSERT INTO emkt_regions VALUES(943, 61, 'AN', 'Ainaro', 'english');
INSERT INTO emkt_regions VALUES(944, 61, 'BA', 'Baucau', 'english');
INSERT INTO emkt_regions VALUES(945, 61, 'BO', 'Bobonaro', 'english');
INSERT INTO emkt_regions VALUES(946, 61, 'CO', 'Cova-Lima', 'english');
INSERT INTO emkt_regions VALUES(947, 61, 'DI', 'Dili', 'english');
INSERT INTO emkt_regions VALUES(948, 61, 'ER', 'Ermera', 'english');
INSERT INTO emkt_regions VALUES(949, 61, 'LA', 'Lautem', 'english');
INSERT INTO emkt_regions VALUES(950, 61, 'LI', 'Liquiçá', 'english');
INSERT INTO emkt_regions VALUES(951, 61, 'MF', 'Manufahi', 'english');
INSERT INTO emkt_regions VALUES(952, 61, 'MT', 'Manatuto', 'english');
INSERT INTO emkt_regions VALUES(953, 61, 'OE', 'Oecussi', 'english');
INSERT INTO emkt_regions VALUES(954, 61, 'VI', 'Viqueque', 'english');

INSERT INTO emkt_countries VALUES (62,'Ecuador','english','EC','ECU','');

INSERT INTO emkt_regions VALUES(955, 62, 'A', 'Azuay', 'english');
INSERT INTO emkt_regions VALUES(956, 62, 'B', 'Bolívar', 'english');
INSERT INTO emkt_regions VALUES(957, 62, 'C', 'Carchi', 'english');
INSERT INTO emkt_regions VALUES(958, 62, 'D', 'Orellana', 'english');
INSERT INTO emkt_regions VALUES(959, 62, 'E', 'Esmeraldas', 'english');
INSERT INTO emkt_regions VALUES(960, 62, 'F', 'Cañar', 'english');
INSERT INTO emkt_regions VALUES(961, 62, 'G', 'Guayas', 'english');
INSERT INTO emkt_regions VALUES(962, 62, 'H', 'Chimborazo', 'english');
INSERT INTO emkt_regions VALUES(963, 62, 'I', 'Imbabura', 'english');
INSERT INTO emkt_regions VALUES(964, 62, 'L', 'Loja', 'english');
INSERT INTO emkt_regions VALUES(965, 62, 'M', 'Manabí', 'english');
INSERT INTO emkt_regions VALUES(966, 62, 'N', 'Napo', 'english');
INSERT INTO emkt_regions VALUES(967, 62, 'O', 'El Oro', 'english');
INSERT INTO emkt_regions VALUES(968, 62, 'P', 'Pichincha', 'english');
INSERT INTO emkt_regions VALUES(969, 62, 'R', 'Los Ríos', 'english');
INSERT INTO emkt_regions VALUES(970, 62, 'S', 'Morona-Santiago', 'english');
INSERT INTO emkt_regions VALUES(971, 62, 'T', 'Tungurahua', 'english');
INSERT INTO emkt_regions VALUES(972, 62, 'U', 'Sucumbíos', 'english');
INSERT INTO emkt_regions VALUES(973, 62, 'W', 'Galápagos', 'english');
INSERT INTO emkt_regions VALUES(974, 62, 'X', 'Cotopaxi', 'english');
INSERT INTO emkt_regions VALUES(975, 62, 'Y', 'Pastaza', 'english');
INSERT INTO emkt_regions VALUES(976, 62, 'Z', 'Zamora-Chinchipe', 'english');

INSERT INTO emkt_countries VALUES (63,'Egypt','english','EG','EGY','');

INSERT INTO emkt_regions VALUES(977, 63, 'ALX', 'الإسكندرية', 'english');
INSERT INTO emkt_regions VALUES(978, 63, 'ASN', 'أسوان', 'english');
INSERT INTO emkt_regions VALUES(979, 63, 'AST', 'أسيوط', 'english');
INSERT INTO emkt_regions VALUES(980, 63, 'BA', 'البحر الأحمر', 'english');
INSERT INTO emkt_regions VALUES(981, 63, 'BH', 'البحيرة', 'english');
INSERT INTO emkt_regions VALUES(982, 63, 'BNS', 'بني سويف', 'english');
INSERT INTO emkt_regions VALUES(983, 63, 'C', 'القاهرة', 'english');
INSERT INTO emkt_regions VALUES(984, 63, 'DK', 'الدقهلية', 'english');
INSERT INTO emkt_regions VALUES(985, 63, 'DT', 'دمياط', 'english');
INSERT INTO emkt_regions VALUES(986, 63, 'FYM', 'الفيوم', 'english');
INSERT INTO emkt_regions VALUES(987, 63, 'GH', 'الغربية', 'english');
INSERT INTO emkt_regions VALUES(988, 63, 'GZ', 'الجيزة', 'english');
INSERT INTO emkt_regions VALUES(989, 63, 'IS', 'الإسماعيلية', 'english');
INSERT INTO emkt_regions VALUES(990, 63, 'JS', 'جنوب سيناء', 'english');
INSERT INTO emkt_regions VALUES(991, 63, 'KB', 'القليوبية', 'english');
INSERT INTO emkt_regions VALUES(992, 63, 'KFS', 'كفر الشيخ', 'english');
INSERT INTO emkt_regions VALUES(993, 63, 'KN', 'قنا', 'english');
INSERT INTO emkt_regions VALUES(994, 63, 'MN', 'محافظة المنيا', 'english');
INSERT INTO emkt_regions VALUES(995, 63, 'MNF', 'المنوفية', 'english');
INSERT INTO emkt_regions VALUES(996, 63, 'MT', 'مطروح', 'english');
INSERT INTO emkt_regions VALUES(997, 63, 'PTS', 'محافظة بور سعيد', 'english');
INSERT INTO emkt_regions VALUES(998, 63, 'SHG', 'محافظة سوهاج', 'english');
INSERT INTO emkt_regions VALUES(999, 63, 'SHR', 'المحافظة الشرقيّة', 'english');
INSERT INTO emkt_regions VALUES(1000, 63, 'SIN', 'شمال سيناء', 'english');
INSERT INTO emkt_regions VALUES(1001, 63, 'SUZ', 'السويس', 'english');
INSERT INTO emkt_regions VALUES(1002, 63, 'WAD', 'الوادى الجديد', 'english');

INSERT INTO emkt_countries VALUES (64,'El Salvador','english','SV','SLV','');

INSERT INTO emkt_regions VALUES(1003, 64, 'AH', 'Ahuachapán', 'english');
INSERT INTO emkt_regions VALUES(1004, 64, 'CA', 'Cabañas', 'english');
INSERT INTO emkt_regions VALUES(1005, 64, 'CH', 'Chalatenango', 'english');
INSERT INTO emkt_regions VALUES(1006, 64, 'CU', 'Cuscatlán', 'english');
INSERT INTO emkt_regions VALUES(1007, 64, 'LI', 'La Libertad', 'english');
INSERT INTO emkt_regions VALUES(1008, 64, 'MO', 'Morazán', 'english');
INSERT INTO emkt_regions VALUES(1009, 64, 'PA', 'La Paz', 'english');
INSERT INTO emkt_regions VALUES(1010, 64, 'SA', 'Santa Ana', 'english');
INSERT INTO emkt_regions VALUES(1011, 64, 'SM', 'San Miguel', 'english');
INSERT INTO emkt_regions VALUES(1012, 64, 'SO', 'Sonsonate', 'english');
INSERT INTO emkt_regions VALUES(1013, 64, 'SS', 'San Salvador', 'english');
INSERT INTO emkt_regions VALUES(1014, 64, 'SV', 'San Vicente', 'english');
INSERT INTO emkt_regions VALUES(1015, 64, 'UN', 'La Unión', 'english');
INSERT INTO emkt_regions VALUES(1016, 64, 'US', 'Usulután', 'english');

INSERT INTO emkt_countries VALUES (65,'Equatorial Guinea','english','GQ','GNQ','');

INSERT INTO emkt_regions VALUES(1017, 65, 'AN', 'Annobón', 'english');
INSERT INTO emkt_regions VALUES(1018, 65, 'BN', 'Bioko Norte', 'english');
INSERT INTO emkt_regions VALUES(1019, 65, 'BS', 'Bioko Sur', 'english');
INSERT INTO emkt_regions VALUES(1020, 65, 'CS', 'Centro Sur', 'english');
INSERT INTO emkt_regions VALUES(1021, 65, 'KN', 'Kié-Ntem', 'english');
INSERT INTO emkt_regions VALUES(1022, 65, 'LI', 'Litoral', 'english');
INSERT INTO emkt_regions VALUES(1023, 65, 'WN', 'Wele-Nzas', 'english');

INSERT INTO emkt_countries VALUES (66,'Eritrea','english','ER','ERI','');

INSERT INTO emkt_regions VALUES(1024, 66, 'AN', 'Zoba Anseba', 'english');
INSERT INTO emkt_regions VALUES(1025, 66, 'DK', 'Zoba Debubawi Keyih Bahri', 'english');
INSERT INTO emkt_regions VALUES(1026, 66, 'DU', 'Zoba Debub', 'english');
INSERT INTO emkt_regions VALUES(1027, 66, 'GB', 'Zoba Gash-Barka', 'english');
INSERT INTO emkt_regions VALUES(1028, 66, 'MA', 'Zoba Ma\'akel', 'english');
INSERT INTO emkt_regions VALUES(1029, 66, 'SK', 'Zoba Semienawi Keyih Bahri', 'english');

INSERT INTO emkt_countries VALUES (67,'Estonia','english','EE','EST','');

INSERT INTO emkt_regions VALUES(1030, 67, '37', 'Harju maakond', 'english');
INSERT INTO emkt_regions VALUES(1031, 67, '39', 'Hiiu maakond', 'english');
INSERT INTO emkt_regions VALUES(1032, 67, '44', 'Ida-Viru maakond', 'english');
INSERT INTO emkt_regions VALUES(1033, 67, '49', 'Jõgeva maakond', 'english');
INSERT INTO emkt_regions VALUES(1034, 67, '51', 'Järva maakond', 'english');
INSERT INTO emkt_regions VALUES(1035, 67, '57', 'Lääne maakond', 'english');
INSERT INTO emkt_regions VALUES(1036, 67, '59', 'Lääne-Viru maakond', 'english');
INSERT INTO emkt_regions VALUES(1037, 67, '65', 'Põlva maakond', 'english');
INSERT INTO emkt_regions VALUES(1038, 67, '67', 'Pärnu maakond', 'english');
INSERT INTO emkt_regions VALUES(1039, 67, '70', 'Rapla maakond', 'english');
INSERT INTO emkt_regions VALUES(1040, 67, '74', 'Saare maakond', 'english');
INSERT INTO emkt_regions VALUES(1041, 67, '78', 'Tartu maakond', 'english');
INSERT INTO emkt_regions VALUES(1042, 67, '82', 'Valga maakond', 'english');
INSERT INTO emkt_regions VALUES(1043, 67, '84', 'Viljandi maakond', 'english');
INSERT INTO emkt_regions VALUES(1044, 67, '86', 'Võru maakond', 'english');

INSERT INTO emkt_countries VALUES (68,'Ethiopia','english','ET','ETH','');

INSERT INTO emkt_regions VALUES(1045, 68, 'AA', 'አዲስ አበባ', 'english');
INSERT INTO emkt_regions VALUES(1046, 68, 'AF', 'አፋር', 'english');
INSERT INTO emkt_regions VALUES(1047, 68, 'AH', 'አማራ', 'english');
INSERT INTO emkt_regions VALUES(1048, 68, 'BG', 'ቤንሻንጉል-ጉምዝ', 'english');
INSERT INTO emkt_regions VALUES(1049, 68, 'DD', 'ድሬዳዋ', 'english');
INSERT INTO emkt_regions VALUES(1050, 68, 'GB', 'ጋምቤላ ሕዝቦች', 'english');
INSERT INTO emkt_regions VALUES(1051, 68, 'HR', 'ሀረሪ ሕዝብ', 'english');
INSERT INTO emkt_regions VALUES(1052, 68, 'OR', 'ኦሮሚያ', 'english');
INSERT INTO emkt_regions VALUES(1053, 68, 'SM', 'ሶማሌ', 'english');
INSERT INTO emkt_regions VALUES(1054, 68, 'SN', 'ደቡብ ብሔሮች ብሔረሰቦችና ሕዝቦች', 'english');
INSERT INTO emkt_regions VALUES(1055, 68, 'TG', 'ትግራይ', 'english');

INSERT INTO emkt_countries VALUES (69,'Falkland Islands (Malvinas)','english','FK','FLK','');

INSERT INTO emkt_regions VALUES(4257, 69, 'NOCODE', 'Falkland Islands (Malvinas)', 'english');

INSERT INTO emkt_countries VALUES (70,'Faroe Islands','english','FO','FRO','');

INSERT INTO emkt_regions VALUES(4258, 70, 'NOCODE', 'Faroe Islands', 'english');

INSERT INTO emkt_countries VALUES (71,'Fiji','english','FJ','FJI','');

INSERT INTO emkt_regions VALUES(1056, 71, 'C', 'Central', 'english');
INSERT INTO emkt_regions VALUES(1057, 71, 'E', 'Northern', 'english');
INSERT INTO emkt_regions VALUES(1058, 71, 'N', 'Eastern', 'english');
INSERT INTO emkt_regions VALUES(1059, 71, 'R', 'Rotuma', 'english');
INSERT INTO emkt_regions VALUES(1060, 71, 'W', 'Western', 'english');

INSERT INTO emkt_countries VALUES (72,'Finland','english','FI','FIN','');

INSERT INTO emkt_regions VALUES(1061, 72, 'AL', 'Ahvenanmaan maakunta', 'english');
INSERT INTO emkt_regions VALUES(1062, 72, 'ES', 'Etelä-Suomen lääni', 'english');
INSERT INTO emkt_regions VALUES(1063, 72, 'IS', 'Itä-Suomen lääni', 'english');
INSERT INTO emkt_regions VALUES(1064, 72, 'LL', 'Lapin lääni', 'english');
INSERT INTO emkt_regions VALUES(1065, 72, 'LS', 'Länsi-Suomen lääni', 'english');
INSERT INTO emkt_regions VALUES(1066, 72, 'OL', 'Oulun lääni', 'english');

INSERT INTO emkt_countries VALUES (73,'France','english','FR','FRA','');

INSERT INTO emkt_regions VALUES(1067, 73, '01', 'Ain', 'english');
INSERT INTO emkt_regions VALUES(1068, 73, '02', 'Aisne', 'english');
INSERT INTO emkt_regions VALUES(1069, 73, '03', 'Allier', 'english');
INSERT INTO emkt_regions VALUES(1070, 73, '04', 'Alpes-de-Haute-Provence', 'english');
INSERT INTO emkt_regions VALUES(1071, 73, '05', 'Hautes-Alpes', 'english');
INSERT INTO emkt_regions VALUES(1072, 73, '06', 'Alpes-Maritimes', 'english');
INSERT INTO emkt_regions VALUES(1073, 73, '07', 'Ardèche', 'english');
INSERT INTO emkt_regions VALUES(1074, 73, '08', 'Ardennes', 'english');
INSERT INTO emkt_regions VALUES(1075, 73, '09', 'Ariège', 'english');
INSERT INTO emkt_regions VALUES(1076, 73, '10', 'Aube', 'english');
INSERT INTO emkt_regions VALUES(1077, 73, '11', 'Aude', 'english');
INSERT INTO emkt_regions VALUES(1078, 73, '12', 'Aveyron', 'english');
INSERT INTO emkt_regions VALUES(1079, 73, '13', 'Bouches-du-Rhône', 'english');
INSERT INTO emkt_regions VALUES(1080, 73, '14', 'Calvados', 'english');
INSERT INTO emkt_regions VALUES(1081, 73, '15', 'Cantal', 'english');
INSERT INTO emkt_regions VALUES(1082, 73, '16', 'Charente', 'english');
INSERT INTO emkt_regions VALUES(1083, 73, '17', 'Charente-Maritime', 'english');
INSERT INTO emkt_regions VALUES(1084, 73, '18', 'Cher', 'english');
INSERT INTO emkt_regions VALUES(1085, 73, '19', 'Corrèze', 'english');
INSERT INTO emkt_regions VALUES(1086, 73, '21', 'Côte-d\'Or', 'english');
INSERT INTO emkt_regions VALUES(1087, 73, '22', 'Côtes-d\'Armor', 'english');
INSERT INTO emkt_regions VALUES(1088, 73, '23', 'Creuse', 'english');
INSERT INTO emkt_regions VALUES(1089, 73, '24', 'Dordogne', 'english');
INSERT INTO emkt_regions VALUES(1090, 73, '25', 'Doubs', 'english');
INSERT INTO emkt_regions VALUES(1091, 73, '26', 'Drôme', 'english');
INSERT INTO emkt_regions VALUES(1092, 73, '27', 'Eure', 'english');
INSERT INTO emkt_regions VALUES(1093, 73, '28', 'Eure-et-Loir', 'english');
INSERT INTO emkt_regions VALUES(1094, 73, '29', 'Finistère', 'english');
INSERT INTO emkt_regions VALUES(1095, 73, '2A', 'Corse-du-Sud', 'english');
INSERT INTO emkt_regions VALUES(1096, 73, '2B', 'Haute-Corse', 'english');
INSERT INTO emkt_regions VALUES(1097, 73, '30', 'Gard', 'english');
INSERT INTO emkt_regions VALUES(1098, 73, '31', 'Haute-Garonne', 'english');
INSERT INTO emkt_regions VALUES(1099, 73, '32', 'Gers', 'english');
INSERT INTO emkt_regions VALUES(1100, 73, '33', 'Gironde', 'english');
INSERT INTO emkt_regions VALUES(1101, 73, '34', 'Hérault', 'english');
INSERT INTO emkt_regions VALUES(1102, 73, '35', 'Ille-et-Vilaine', 'english');
INSERT INTO emkt_regions VALUES(1103, 73, '36', 'Indre', 'english');
INSERT INTO emkt_regions VALUES(1104, 73, '37', 'Indre-et-Loire', 'english');
INSERT INTO emkt_regions VALUES(1105, 73, '38', 'Isère', 'english');
INSERT INTO emkt_regions VALUES(1106, 73, '39', 'Jura', 'english');
INSERT INTO emkt_regions VALUES(1107, 73, '40', 'Landes', 'english');
INSERT INTO emkt_regions VALUES(1108, 73, '41', 'Loir-et-Cher', 'english');
INSERT INTO emkt_regions VALUES(1109, 73, '42', 'Loire', 'english');
INSERT INTO emkt_regions VALUES(1110, 73, '43', 'Haute-Loire', 'english');
INSERT INTO emkt_regions VALUES(1111, 73, '44', 'Loire-Atlantique', 'english');
INSERT INTO emkt_regions VALUES(1112, 73, '45', 'Loiret', 'english');
INSERT INTO emkt_regions VALUES(1113, 73, '46', 'Lot', 'english');
INSERT INTO emkt_regions VALUES(1114, 73, '47', 'Lot-et-Garonne', 'english');
INSERT INTO emkt_regions VALUES(1115, 73, '48', 'Lozère', 'english');
INSERT INTO emkt_regions VALUES(1116, 73, '49', 'Maine-et-Loire', 'english');
INSERT INTO emkt_regions VALUES(1117, 73, '50', 'Manche', 'english');
INSERT INTO emkt_regions VALUES(1118, 73, '51', 'Marne', 'english');
INSERT INTO emkt_regions VALUES(1119, 73, '52', 'Haute-Marne', 'english');
INSERT INTO emkt_regions VALUES(1120, 73, '53', 'Mayenne', 'english');
INSERT INTO emkt_regions VALUES(1121, 73, '54', 'Meurthe-et-Moselle', 'english');
INSERT INTO emkt_regions VALUES(1122, 73, '55', 'Meuse', 'english');
INSERT INTO emkt_regions VALUES(1123, 73, '56', 'Morbihan', 'english');
INSERT INTO emkt_regions VALUES(1124, 73, '57', 'Moselle', 'english');
INSERT INTO emkt_regions VALUES(1125, 73, '58', 'Nièvre', 'english');
INSERT INTO emkt_regions VALUES(1126, 73, '59', 'Nord', 'english');
INSERT INTO emkt_regions VALUES(1127, 73, '60', 'Oise', 'english');
INSERT INTO emkt_regions VALUES(1128, 73, '61', 'Orne', 'english');
INSERT INTO emkt_regions VALUES(1129, 73, '62', 'Pas-de-Calais', 'english');
INSERT INTO emkt_regions VALUES(1130, 73, '63', 'Puy-de-Dôme', 'english');
INSERT INTO emkt_regions VALUES(1131, 73, '64', 'Pyrénées-Atlantiques', 'english');
INSERT INTO emkt_regions VALUES(1132, 73, '65', 'Hautes-Pyrénées', 'english');
INSERT INTO emkt_regions VALUES(1133, 73, '66', 'Pyrénées-Orientales', 'english');
INSERT INTO emkt_regions VALUES(1134, 73, '67', 'Bas-Rhin', 'english');
INSERT INTO emkt_regions VALUES(1135, 73, '68', 'Haut-Rhin', 'english');
INSERT INTO emkt_regions VALUES(1136, 73, '69', 'Rhône', 'english');
INSERT INTO emkt_regions VALUES(1137, 73, '70', 'Haute-Saône', 'english');
INSERT INTO emkt_regions VALUES(1138, 73, '71', 'Saône-et-Loire', 'english');
INSERT INTO emkt_regions VALUES(1139, 73, '72', 'Sarthe', 'english');
INSERT INTO emkt_regions VALUES(1140, 73, '73', 'Savoie', 'english');
INSERT INTO emkt_regions VALUES(1141, 73, '74', 'Haute-Savoie', 'english');
INSERT INTO emkt_regions VALUES(1142, 73, '75', 'Paris', 'english');
INSERT INTO emkt_regions VALUES(1143, 73, '76', 'Seine-Maritime', 'english');
INSERT INTO emkt_regions VALUES(1144, 73, '77', 'Seine-et-Marne', 'english');
INSERT INTO emkt_regions VALUES(1145, 73, '78', 'Yvelines', 'english');
INSERT INTO emkt_regions VALUES(1146, 73, '79', 'Deux-Sèvres', 'english');
INSERT INTO emkt_regions VALUES(1147, 73, '80', 'Somme', 'english');
INSERT INTO emkt_regions VALUES(1148, 73, '81', 'Tarn', 'english');
INSERT INTO emkt_regions VALUES(1149, 73, '82', 'Tarn-et-Garonne', 'english');
INSERT INTO emkt_regions VALUES(1150, 73, '83', 'Var', 'english');
INSERT INTO emkt_regions VALUES(1151, 73, '84', 'Vaucluse', 'english');
INSERT INTO emkt_regions VALUES(1152, 73, '85', 'Vendée', 'english');
INSERT INTO emkt_regions VALUES(1153, 73, '86', 'Vienne', 'english');
INSERT INTO emkt_regions VALUES(1154, 73, '87', 'Haute-Vienne', 'english');
INSERT INTO emkt_regions VALUES(1155, 73, '88', 'Vosges', 'english');
INSERT INTO emkt_regions VALUES(1156, 73, '89', 'Yonne', 'english');
INSERT INTO emkt_regions VALUES(1157, 73, '90', 'Territoire de Belfort', 'english');
INSERT INTO emkt_regions VALUES(1158, 73, '91', 'Essonne', 'english');
INSERT INTO emkt_regions VALUES(1159, 73, '92', 'Hauts-de-Seine', 'english');
INSERT INTO emkt_regions VALUES(1160, 73, '93', 'Seine-Saint-Denis', 'english');
INSERT INTO emkt_regions VALUES(1161, 73, '94', 'Val-de-Marne', 'english');
INSERT INTO emkt_regions VALUES(1162, 73, '95', 'Val-d\'Oise', 'english');
INSERT INTO emkt_regions VALUES(1163, 73, 'NC', 'Territoire des Nouvelle-Calédonie et Dependances', 'english');
INSERT INTO emkt_regions VALUES(1164, 73, 'PF', 'Polynésie Française', 'english');
INSERT INTO emkt_regions VALUES(1165, 73, 'PM', 'Saint-Pierre et Miquelon', 'english');
INSERT INTO emkt_regions VALUES(1166, 73, 'TF', 'Terres australes et antarctiques françaises', 'english');
INSERT INTO emkt_regions VALUES(1167, 73, 'YT', 'Mayotte', 'english');
INSERT INTO emkt_regions VALUES(1168, 73, 'WF', 'Territoire des îles Wallis et Futuna', 'english');

INSERT INTO emkt_countries VALUES (74,'French Guiana','english','GF','GUF','');

INSERT INTO emkt_regions VALUES(4259, 74, 'NOCODE', 'French Guiana', 'english');

INSERT INTO emkt_countries VALUES (75,'French Polynesia','english','PF','PYF','');

INSERT INTO emkt_regions VALUES(1169, 75, 'M', 'Archipel des Marquises', 'english');
INSERT INTO emkt_regions VALUES(1170, 75, 'T', 'Archipel des Tuamotu', 'english');
INSERT INTO emkt_regions VALUES(1171, 75, 'I', 'Archipel des Tubuai', 'english');
INSERT INTO emkt_regions VALUES(1172, 75, 'V', 'Iles du Vent', 'english');
INSERT INTO emkt_regions VALUES(1173, 75, 'S', 'Iles Sous-le-Vent', 'english');

INSERT INTO emkt_countries VALUES (76,'French Southern Territories','english','TF','ATF','');

INSERT INTO emkt_regions VALUES(1174, 76, 'C', 'Iles Crozet', 'english');
INSERT INTO emkt_regions VALUES(1175, 76, 'K', 'Iles Kerguelen', 'english');
INSERT INTO emkt_regions VALUES(1176, 76, 'A', 'Ile Amsterdam', 'english');
INSERT INTO emkt_regions VALUES(1177, 76, 'P', 'Ile Saint-Paul', 'english');
INSERT INTO emkt_regions VALUES(1178, 76, 'D', 'Adelie Land', 'english');

INSERT INTO emkt_countries VALUES (77,'Gabon','english','GA','GAB','');

INSERT INTO emkt_regions VALUES(1179, 77, 'ES', 'Estuaire', 'english');
INSERT INTO emkt_regions VALUES(1180, 77, 'HO', 'Haut-Ogooue', 'english');
INSERT INTO emkt_regions VALUES(1181, 77, 'MO', 'Moyen-Ogooue', 'english');
INSERT INTO emkt_regions VALUES(1182, 77, 'NG', 'Ngounie', 'english');
INSERT INTO emkt_regions VALUES(1183, 77, 'NY', 'Nyanga', 'english');
INSERT INTO emkt_regions VALUES(1184, 77, 'OI', 'Ogooue-Ivindo', 'english');
INSERT INTO emkt_regions VALUES(1185, 77, 'OL', 'Ogooue-Lolo', 'english');
INSERT INTO emkt_regions VALUES(1186, 77, 'OM', 'Ogooue-Maritime', 'english');
INSERT INTO emkt_regions VALUES(1187, 77, 'WN', 'Woleu-Ntem', 'english');

INSERT INTO emkt_countries VALUES (78,'Gambia','english','GM','GMB','');

INSERT INTO emkt_regions VALUES(1188, 78, 'AH', 'Ashanti', 'english');
INSERT INTO emkt_regions VALUES(1189, 78, 'BA', 'Brong-Ahafo', 'english');
INSERT INTO emkt_regions VALUES(1190, 78, 'CP', 'Central', 'english');
INSERT INTO emkt_regions VALUES(1191, 78, 'EP', 'Eastern', 'english');
INSERT INTO emkt_regions VALUES(1192, 78, 'AA', 'Greater Accra', 'english');
INSERT INTO emkt_regions VALUES(1193, 78, 'NP', 'Northern', 'english');
INSERT INTO emkt_regions VALUES(1194, 78, 'UE', 'Upper East', 'english');
INSERT INTO emkt_regions VALUES(1195, 78, 'UW', 'Upper West', 'english');
INSERT INTO emkt_regions VALUES(1196, 78, 'TV', 'Volta', 'english');
INSERT INTO emkt_regions VALUES(1197, 78, 'WP', 'Western', 'english');

INSERT INTO emkt_countries VALUES (79,'Georgia','english','GE','GEO','');

INSERT INTO emkt_regions VALUES(1198, 79, 'AB', 'აფხაზეთი', 'english');
INSERT INTO emkt_regions VALUES(1199, 79, 'AJ', 'აჭარა', 'english');
INSERT INTO emkt_regions VALUES(1200, 79, 'GU', 'გურია', 'english');
INSERT INTO emkt_regions VALUES(1201, 79, 'IM', 'იმერეთი', 'english');
INSERT INTO emkt_regions VALUES(1202, 79, 'KA', 'კახეთი', 'english');
INSERT INTO emkt_regions VALUES(1203, 79, 'KK', 'ქვემო ქართლი', 'english');
INSERT INTO emkt_regions VALUES(1204, 79, 'MM', 'მცხეთა-მთიანეთი', 'english');
INSERT INTO emkt_regions VALUES(1205, 79, 'RL', 'რაჭა-ლეჩხუმი და ქვემო სვანეთი', 'english');
INSERT INTO emkt_regions VALUES(1206, 79, 'SJ', 'სამცხე-ჯავახეთი', 'english');
INSERT INTO emkt_regions VALUES(1207, 79, 'SK', 'შიდა ქართლი', 'english');
INSERT INTO emkt_regions VALUES(1208, 79, 'SZ', 'სამეგრელო-ზემო სვანეთი', 'english');
INSERT INTO emkt_regions VALUES(1209, 79, 'TB', 'თბილისი', 'english');

INSERT INTO emkt_countries VALUES (80,'Germany','english','DE','DEU','');

INSERT INTO emkt_regions VALUES(1210, 80, 'BE', 'Berlin', 'english');
INSERT INTO emkt_regions VALUES(1211, 80, 'BR', 'Brandenburg', 'english');
INSERT INTO emkt_regions VALUES(1212, 80, 'BW', 'Baden-Württemberg', 'english');
INSERT INTO emkt_regions VALUES(1213, 80, 'BY', 'Bayern', 'english');
INSERT INTO emkt_regions VALUES(1214, 80, 'HB', 'Bremen', 'english');
INSERT INTO emkt_regions VALUES(1215, 80, 'HE', 'Hessen', 'english');
INSERT INTO emkt_regions VALUES(1216, 80, 'HH', 'Hamburg', 'english');
INSERT INTO emkt_regions VALUES(1217, 80, 'MV', 'Mecklenburg-Vorpommern', 'english');
INSERT INTO emkt_regions VALUES(1218, 80, 'NI', 'Niedersachsen', 'english');
INSERT INTO emkt_regions VALUES(1219, 80, 'NW', 'Nordrhein-Westfalen', 'english');
INSERT INTO emkt_regions VALUES(1220, 80, 'RP', 'Rheinland-Pfalz', 'english');
INSERT INTO emkt_regions VALUES(1221, 80, 'SH', 'Schleswig-Holstein', 'english');
INSERT INTO emkt_regions VALUES(1222, 80, 'SL', 'Saarland', 'english');
INSERT INTO emkt_regions VALUES(1223, 80, 'SN', 'Sachsen', 'english');
INSERT INTO emkt_regions VALUES(1224, 80, 'ST', 'Sachsen-Anhalt', 'english');
INSERT INTO emkt_regions VALUES(1225, 80, 'TH', 'Thüringen', 'english');

INSERT INTO emkt_countries VALUES (81,'Ghana','english','GH','GHA','');

INSERT INTO emkt_regions VALUES(1226, 81, 'AA', 'Greater Accra', 'english');
INSERT INTO emkt_regions VALUES(1227, 81, 'AH', 'Ashanti', 'english');
INSERT INTO emkt_regions VALUES(1228, 81, 'BA', 'Brong-Ahafo', 'english');
INSERT INTO emkt_regions VALUES(1229, 81, 'CP', 'Central', 'english');
INSERT INTO emkt_regions VALUES(1230, 81, 'EP', 'Eastern', 'english');
INSERT INTO emkt_regions VALUES(1231, 81, 'NP', 'Northern', 'english');
INSERT INTO emkt_regions VALUES(1232, 81, 'TV', 'Volta', 'english');
INSERT INTO emkt_regions VALUES(1233, 81, 'UE', 'Upper East', 'english');
INSERT INTO emkt_regions VALUES(1234, 81, 'UW', 'Upper West', 'english');
INSERT INTO emkt_regions VALUES(1235, 81, 'WP', 'Western', 'english');

INSERT INTO emkt_countries VALUES (82,'Gibraltar','english','GI','GIB','');

INSERT INTO emkt_regions VALUES(4260, 82, 'NOCODE', 'Gibraltar', 'english');

INSERT INTO emkt_countries VALUES (83,'Greece','english','GR','GRC','');

INSERT INTO emkt_regions VALUES(1236, 83, '01', 'Αιτωλοακαρνανία', 'english');
INSERT INTO emkt_regions VALUES(1237, 83, '03', 'Βοιωτία', 'english');
INSERT INTO emkt_regions VALUES(1238, 83, '04', 'Εύβοια', 'english');
INSERT INTO emkt_regions VALUES(1239, 83, '05', 'Ευρυτανία', 'english');
INSERT INTO emkt_regions VALUES(1240, 83, '06', 'Φθιώτιδα', 'english');
INSERT INTO emkt_regions VALUES(1241, 83, '07', 'Φωκίδα', 'english');
INSERT INTO emkt_regions VALUES(1242, 83, '11', 'Αργολίδα', 'english');
INSERT INTO emkt_regions VALUES(1243, 83, '12', 'Αρκαδία', 'english');
INSERT INTO emkt_regions VALUES(1244, 83, '13', 'Ἀχαΐα', 'english');
INSERT INTO emkt_regions VALUES(1245, 83, '14', 'Ηλεία', 'english');
INSERT INTO emkt_regions VALUES(1246, 83, '15', 'Κορινθία', 'english');
INSERT INTO emkt_regions VALUES(1247, 83, '16', 'Λακωνία', 'english');
INSERT INTO emkt_regions VALUES(1248, 83, '17', 'Μεσσηνία', 'english');
INSERT INTO emkt_regions VALUES(1249, 83, '21', 'Ζάκυνθος', 'english');
INSERT INTO emkt_regions VALUES(1250, 83, '22', 'Κέρκυρα', 'english');
INSERT INTO emkt_regions VALUES(1251, 83, '23', 'Κεφαλλονιά', 'english');
INSERT INTO emkt_regions VALUES(1252, 83, '24', 'Λευκάδα', 'english');
INSERT INTO emkt_regions VALUES(1253, 83, '31', 'Άρτα', 'english');
INSERT INTO emkt_regions VALUES(1254, 83, '32', 'Θεσπρωτία', 'english');
INSERT INTO emkt_regions VALUES(1255, 83, '33', 'Ιωάννινα', 'english');
INSERT INTO emkt_regions VALUES(1256, 83, '34', 'Πρεβεζα', 'english');
INSERT INTO emkt_regions VALUES(1257, 83, '41', 'Καρδίτσα', 'english');
INSERT INTO emkt_regions VALUES(1258, 83, '42', 'Λάρισα', 'english');
INSERT INTO emkt_regions VALUES(1259, 83, '43', 'Μαγνησία', 'english');
INSERT INTO emkt_regions VALUES(1260, 83, '44', 'Τρίκαλα', 'english');
INSERT INTO emkt_regions VALUES(1261, 83, '51', 'Γρεβενά', 'english');
INSERT INTO emkt_regions VALUES(1262, 83, '52', 'Δράμα', 'english');
INSERT INTO emkt_regions VALUES(1263, 83, '53', 'Ημαθία', 'english');
INSERT INTO emkt_regions VALUES(1264, 83, '54', 'Θεσσαλονίκη', 'english');
INSERT INTO emkt_regions VALUES(1265, 83, '55', 'Καβάλα', 'english');
INSERT INTO emkt_regions VALUES(1266, 83, '56', 'Καστοριά', 'english');
INSERT INTO emkt_regions VALUES(1267, 83, '57', 'Κιλκίς', 'english');
INSERT INTO emkt_regions VALUES(1268, 83, '58', 'Κοζάνη', 'english');
INSERT INTO emkt_regions VALUES(1269, 83, '59', 'Πέλλα', 'english');
INSERT INTO emkt_regions VALUES(1270, 83, '61', 'Πιερία', 'english');
INSERT INTO emkt_regions VALUES(1271, 83, '62', 'Σερρών', 'english');
INSERT INTO emkt_regions VALUES(1272, 83, '63', 'Φλώρινα', 'english');
INSERT INTO emkt_regions VALUES(1273, 83, '64', 'Χαλκιδική', 'english');
INSERT INTO emkt_regions VALUES(1274, 83, '69', 'Όρος Άθως', 'english');
INSERT INTO emkt_regions VALUES(1275, 83, '71', 'Έβρος', 'english');
INSERT INTO emkt_regions VALUES(1276, 83, '72', 'Ξάνθη', 'english');
INSERT INTO emkt_regions VALUES(1277, 83, '73', 'Ροδόπη', 'english');
INSERT INTO emkt_regions VALUES(1278, 83, '81', 'Δωδεκάνησα', 'english');
INSERT INTO emkt_regions VALUES(1279, 83, '82', 'Κυκλάδες', 'english');
INSERT INTO emkt_regions VALUES(1280, 83, '83', 'Λέσβου', 'english');
INSERT INTO emkt_regions VALUES(1281, 83, '84', 'Σάμος', 'english');
INSERT INTO emkt_regions VALUES(1282, 83, '85', 'Χίος', 'english');
INSERT INTO emkt_regions VALUES(1283, 83, '91', 'Ηράκλειο', 'english');
INSERT INTO emkt_regions VALUES(1284, 83, '92', 'Λασίθι', 'english');
INSERT INTO emkt_regions VALUES(1285, 83, '93', 'Ρεθύμνο', 'english');
INSERT INTO emkt_regions VALUES(1286, 83, '94', 'Χανίων', 'english');
INSERT INTO emkt_regions VALUES(1287, 83, 'A1', 'Αττική', 'english');

INSERT INTO emkt_countries VALUES (84,'Greenland','english','GL','GRL','');

INSERT INTO emkt_regions VALUES(1288, 84, 'A', 'Avannaa', 'english');
INSERT INTO emkt_regions VALUES(1289, 84, 'T', 'Tunu ', 'english');
INSERT INTO emkt_regions VALUES(1290, 84, 'K', 'Kitaa', 'english');

INSERT INTO emkt_countries VALUES (85,'Grenada','english','GD','GRD','');

INSERT INTO emkt_regions VALUES(1291, 85, 'A', 'Saint Andrew', 'english');
INSERT INTO emkt_regions VALUES(1292, 85, 'D', 'Saint David', 'english');
INSERT INTO emkt_regions VALUES(1293, 85, 'G', 'Saint George', 'english');
INSERT INTO emkt_regions VALUES(1294, 85, 'J', 'Saint John', 'english');
INSERT INTO emkt_regions VALUES(1295, 85, 'M', 'Saint Mark', 'english');
INSERT INTO emkt_regions VALUES(1296, 85, 'P', 'Saint Patrick', 'english');

INSERT INTO emkt_countries VALUES (86,'Guadeloupe','english','GP','GLP','');

INSERT INTO emkt_regions VALUES(4261, 86, 'NOCODE', 'Guadeloupe', 'english');

INSERT INTO emkt_countries VALUES (87,'Guam','english','GU','GUM','');

INSERT INTO emkt_regions VALUES(4262, 87, 'NOCODE', 'Guam', 'english');

INSERT INTO emkt_countries VALUES (88,'Guatemala','english','GT','GTM','');

INSERT INTO emkt_regions VALUES(1297, 88, 'AV', 'Alta Verapaz', 'english');
INSERT INTO emkt_regions VALUES(1298, 88, 'BV', 'Baja Verapaz', 'english');
INSERT INTO emkt_regions VALUES(1299, 88, 'CM', 'Chimaltenango', 'english');
INSERT INTO emkt_regions VALUES(1300, 88, 'CQ', 'Chiquimula', 'english');
INSERT INTO emkt_regions VALUES(1301, 88, 'ES', 'Escuintla', 'english');
INSERT INTO emkt_regions VALUES(1302, 88, 'GU', 'Guatemala', 'english');
INSERT INTO emkt_regions VALUES(1303, 88, 'HU', 'Huehuetenango', 'english');
INSERT INTO emkt_regions VALUES(1304, 88, 'IZ', 'Izabal', 'english');
INSERT INTO emkt_regions VALUES(1305, 88, 'JA', 'Jalapa', 'english');
INSERT INTO emkt_regions VALUES(1306, 88, 'JU', 'Jutiapa', 'english');
INSERT INTO emkt_regions VALUES(1307, 88, 'PE', 'El Petén', 'english');
INSERT INTO emkt_regions VALUES(1308, 88, 'PR', 'El Progreso', 'english');
INSERT INTO emkt_regions VALUES(1309, 88, 'QC', 'El Quiché', 'english');
INSERT INTO emkt_regions VALUES(1310, 88, 'QZ', 'Quetzaltenango', 'english');
INSERT INTO emkt_regions VALUES(1311, 88, 'RE', 'Retalhuleu', 'english');
INSERT INTO emkt_regions VALUES(1312, 88, 'SA', 'Sacatepéquez', 'english');
INSERT INTO emkt_regions VALUES(1313, 88, 'SM', 'San Marcos', 'english');
INSERT INTO emkt_regions VALUES(1314, 88, 'SO', 'Sololá', 'english');
INSERT INTO emkt_regions VALUES(1315, 88, 'SR', 'Santa Rosa', 'english');
INSERT INTO emkt_regions VALUES(1316, 88, 'SU', 'Suchitepéquez', 'english');
INSERT INTO emkt_regions VALUES(1317, 88, 'TO', 'Totonicapán', 'english');
INSERT INTO emkt_regions VALUES(1318, 88, 'ZA', 'Zacapa', 'english');

INSERT INTO emkt_countries VALUES (89,'Guinea','english','GN','GIN','');

INSERT INTO emkt_regions VALUES(1319, 89, 'BE', 'Beyla', 'english');
INSERT INTO emkt_regions VALUES(1320, 89, 'BF', 'Boffa', 'english');
INSERT INTO emkt_regions VALUES(1321, 89, 'BK', 'Boké', 'english');
INSERT INTO emkt_regions VALUES(1322, 89, 'CO', 'Coyah', 'english');
INSERT INTO emkt_regions VALUES(1323, 89, 'DB', 'Dabola', 'english');
INSERT INTO emkt_regions VALUES(1324, 89, 'DI', 'Dinguiraye', 'english');
INSERT INTO emkt_regions VALUES(1325, 89, 'DL', 'Dalaba', 'english');
INSERT INTO emkt_regions VALUES(1326, 89, 'DU', 'Dubréka', 'english');
INSERT INTO emkt_regions VALUES(1327, 89, 'FA', 'Faranah', 'english');
INSERT INTO emkt_regions VALUES(1328, 89, 'FO', 'Forécariah', 'english');
INSERT INTO emkt_regions VALUES(1329, 89, 'FR', 'Fria', 'english');
INSERT INTO emkt_regions VALUES(1330, 89, 'GA', 'Gaoual', 'english');
INSERT INTO emkt_regions VALUES(1331, 89, 'GU', 'Guékédou', 'english');
INSERT INTO emkt_regions VALUES(1332, 89, 'KA', 'Kankan', 'english');
INSERT INTO emkt_regions VALUES(1333, 89, 'KB', 'Koubia', 'english');
INSERT INTO emkt_regions VALUES(1334, 89, 'KD', 'Kindia', 'english');
INSERT INTO emkt_regions VALUES(1335, 89, 'KE', 'Kérouané', 'english');
INSERT INTO emkt_regions VALUES(1336, 89, 'KN', 'Koundara', 'english');
INSERT INTO emkt_regions VALUES(1337, 89, 'KO', 'Kouroussa', 'english');
INSERT INTO emkt_regions VALUES(1338, 89, 'KS', 'Kissidougou', 'english');
INSERT INTO emkt_regions VALUES(1339, 89, 'LA', 'Labé', 'english');
INSERT INTO emkt_regions VALUES(1340, 89, 'LE', 'Lélouma', 'english');
INSERT INTO emkt_regions VALUES(1341, 89, 'LO', 'Lola', 'english');
INSERT INTO emkt_regions VALUES(1342, 89, 'MC', 'Macenta', 'english');
INSERT INTO emkt_regions VALUES(1343, 89, 'MD', 'Mandiana', 'english');
INSERT INTO emkt_regions VALUES(1344, 89, 'ML', 'Mali', 'english');
INSERT INTO emkt_regions VALUES(1345, 89, 'MM', 'Mamou', 'english');
INSERT INTO emkt_regions VALUES(1346, 89, 'NZ', 'Nzérékoré', 'english');
INSERT INTO emkt_regions VALUES(1347, 89, 'PI', 'Pita', 'english');
INSERT INTO emkt_regions VALUES(1348, 89, 'SI', 'Siguiri', 'english');
INSERT INTO emkt_regions VALUES(1349, 89, 'TE', 'Télimélé', 'english');
INSERT INTO emkt_regions VALUES(1350, 89, 'TO', 'Tougué', 'english');
INSERT INTO emkt_regions VALUES(1351, 89, 'YO', 'Yomou', 'english');

INSERT INTO emkt_countries VALUES (90,'Guinea-Bissau','english','GW','GNB','');

INSERT INTO emkt_regions VALUES(1352, 90, 'BF', 'Bafata', 'english');
INSERT INTO emkt_regions VALUES(1353, 90, 'BB', 'Biombo', 'english');
INSERT INTO emkt_regions VALUES(1354, 90, 'BS', 'Bissau', 'english');
INSERT INTO emkt_regions VALUES(1355, 90, 'BL', 'Bolama', 'english');
INSERT INTO emkt_regions VALUES(1356, 90, 'CA', 'Cacheu', 'english');
INSERT INTO emkt_regions VALUES(1357, 90, 'GA', 'Gabu', 'english');
INSERT INTO emkt_regions VALUES(1358, 90, 'OI', 'Oio', 'english');
INSERT INTO emkt_regions VALUES(1359, 90, 'QU', 'Quinara', 'english');
INSERT INTO emkt_regions VALUES(1360, 90, 'TO', 'Tombali', 'english');

INSERT INTO emkt_countries VALUES (91,'Guyana','english','GY','GUY','');

INSERT INTO emkt_regions VALUES(1361, 91, 'BA', 'Barima-Waini', 'english');
INSERT INTO emkt_regions VALUES(1362, 91, 'CU', 'Cuyuni-Mazaruni', 'english');
INSERT INTO emkt_regions VALUES(1363, 91, 'DE', 'Demerara-Mahaica', 'english');
INSERT INTO emkt_regions VALUES(1364, 91, 'EB', 'East Berbice-Corentyne', 'english');
INSERT INTO emkt_regions VALUES(1365, 91, 'ES', 'Essequibo Islands-West Demerara', 'english');
INSERT INTO emkt_regions VALUES(1366, 91, 'MA', 'Mahaica-Berbice', 'english');
INSERT INTO emkt_regions VALUES(1367, 91, 'PM', 'Pomeroon-Supenaam', 'english');
INSERT INTO emkt_regions VALUES(1368, 91, 'PT', 'Potaro-Siparuni', 'english');
INSERT INTO emkt_regions VALUES(1369, 91, 'UD', 'Upper Demerara-Berbice', 'english');
INSERT INTO emkt_regions VALUES(1370, 91, 'UT', 'Upper Takutu-Upper Essequibo', 'english');

INSERT INTO emkt_countries VALUES (92,'Haiti','english','HT','HTI','');

INSERT INTO emkt_regions VALUES(1371, 92, 'AR', 'Artibonite', 'english');
INSERT INTO emkt_regions VALUES(1372, 92, 'CE', 'Centre', 'english');
INSERT INTO emkt_regions VALUES(1373, 92, 'GA', 'Grand\'Anse', 'english');
INSERT INTO emkt_regions VALUES(1374, 92, 'NI', 'Nippes', 'english');
INSERT INTO emkt_regions VALUES(1375, 92, 'ND', 'Nord', 'english');
INSERT INTO emkt_regions VALUES(1376, 92, 'NE', 'Nord-Est', 'english');
INSERT INTO emkt_regions VALUES(1377, 92, 'NO', 'Nord-Ouest', 'english');
INSERT INTO emkt_regions VALUES(1378, 92, 'OU', 'Ouest', 'english');
INSERT INTO emkt_regions VALUES(1379, 92, 'SD', 'Sud', 'english');
INSERT INTO emkt_regions VALUES(1380, 92, 'SE', 'Sud-Est', 'english');

INSERT INTO emkt_countries VALUES (93,'Heard and McDonald Islands','english','HM','HMD','');

INSERT INTO emkt_regions VALUES(1381, 93, 'F', 'Flat Island', 'english');
INSERT INTO emkt_regions VALUES(1382, 93, 'M', 'McDonald Island', 'english');
INSERT INTO emkt_regions VALUES(1383, 93, 'S', 'Shag Island', 'english');
INSERT INTO emkt_regions VALUES(1384, 93, 'H', 'Heard Island', 'english');

INSERT INTO emkt_countries VALUES (94,'Honduras','english','HN','HND','');

INSERT INTO emkt_regions VALUES(1385, 94, 'AT', 'Atlántida', 'english');
INSERT INTO emkt_regions VALUES(1386, 94, 'CH', 'Choluteca', 'english');
INSERT INTO emkt_regions VALUES(1387, 94, 'CL', 'Colón', 'english');
INSERT INTO emkt_regions VALUES(1388, 94, 'CM', 'Comayagua', 'english');
INSERT INTO emkt_regions VALUES(1389, 94, 'CP', 'Copán', 'english');
INSERT INTO emkt_regions VALUES(1390, 94, 'CR', 'Cortés', 'english');
INSERT INTO emkt_regions VALUES(1391, 94, 'EP', 'El Paraíso', 'english');
INSERT INTO emkt_regions VALUES(1392, 94, 'FM', 'Francisco Morazán', 'english');
INSERT INTO emkt_regions VALUES(1393, 94, 'GD', 'Gracias a Dios', 'english');
INSERT INTO emkt_regions VALUES(1394, 94, 'IB', 'Islas de la Bahía', 'english');
INSERT INTO emkt_regions VALUES(1395, 94, 'IN', 'Intibucá', 'english');
INSERT INTO emkt_regions VALUES(1396, 94, 'LE', 'Lempira', 'english');
INSERT INTO emkt_regions VALUES(1397, 94, 'LP', 'La Paz', 'english');
INSERT INTO emkt_regions VALUES(1398, 94, 'OC', 'Ocotepeque', 'english');
INSERT INTO emkt_regions VALUES(1399, 94, 'OL', 'Olancho', 'english');
INSERT INTO emkt_regions VALUES(1400, 94, 'SB', 'Santa Bárbara', 'english');
INSERT INTO emkt_regions VALUES(1401, 94, 'VA', 'Valle', 'english');
INSERT INTO emkt_regions VALUES(1402, 94, 'YO', 'Yoro', 'english');

INSERT INTO emkt_countries VALUES (95,'Hong Kong','english','HK','HKG','');

INSERT INTO emkt_regions VALUES(1403, 95, 'HCW', '中西區', 'english');
INSERT INTO emkt_regions VALUES(1404, 95, 'HEA', '東區', 'english');
INSERT INTO emkt_regions VALUES(1405, 95, 'HSO', '南區', 'english');
INSERT INTO emkt_regions VALUES(1406, 95, 'HWC', '灣仔區', 'english');
INSERT INTO emkt_regions VALUES(1407, 95, 'KKC', '九龍城區', 'english');
INSERT INTO emkt_regions VALUES(1408, 95, 'KKT', '觀塘區', 'english');
INSERT INTO emkt_regions VALUES(1409, 95, 'KSS', '深水埗區', 'english');
INSERT INTO emkt_regions VALUES(1410, 95, 'KWT', '黃大仙區', 'english');
INSERT INTO emkt_regions VALUES(1411, 95, 'KYT', '油尖旺區', 'english');
INSERT INTO emkt_regions VALUES(1412, 95, 'NIS', '離島區', 'english');
INSERT INTO emkt_regions VALUES(1413, 95, 'NKT', '葵青區', 'english');
INSERT INTO emkt_regions VALUES(1414, 95, 'NNO', '北區', 'english');
INSERT INTO emkt_regions VALUES(1415, 95, 'NSK', '西貢區', 'english');
INSERT INTO emkt_regions VALUES(1416, 95, 'NST', '沙田區', 'english');
INSERT INTO emkt_regions VALUES(1417, 95, 'NTP', '大埔區', 'english');
INSERT INTO emkt_regions VALUES(1418, 95, 'NTW', '荃灣區', 'english');
INSERT INTO emkt_regions VALUES(1419, 95, 'NTM', '屯門區', 'english');
INSERT INTO emkt_regions VALUES(1420, 95, 'NYL', '元朗區', 'english');

INSERT INTO emkt_countries VALUES (96,'Hungary','english','HU','HUN','');

INSERT INTO emkt_regions VALUES(1421, 96, 'BA', 'Baranja megye', 'english');
INSERT INTO emkt_regions VALUES(1422, 96, 'BC', 'Békéscsaba', 'english');
INSERT INTO emkt_regions VALUES(1423, 96, 'BE', 'Békés megye', 'english');
INSERT INTO emkt_regions VALUES(1424, 96, 'BK', 'Bács-Kiskun megye', 'english');
INSERT INTO emkt_regions VALUES(1425, 96, 'BU', 'Budapest', 'english');
INSERT INTO emkt_regions VALUES(1426, 96, 'BZ', 'Borsod-Abaúj-Zemplén megye', 'english');
INSERT INTO emkt_regions VALUES(1427, 96, 'CS', 'Csongrád megye', 'english');
INSERT INTO emkt_regions VALUES(1428, 96, 'DE', 'Debrecen', 'english');
INSERT INTO emkt_regions VALUES(1429, 96, 'DU', 'Dunaújváros', 'english');
INSERT INTO emkt_regions VALUES(1430, 96, 'EG', 'Eger', 'english');
INSERT INTO emkt_regions VALUES(1431, 96, 'FE', 'Fejér megye', 'english');
INSERT INTO emkt_regions VALUES(1432, 96, 'GS', 'Győr-Moson-Sopron megye', 'english');
INSERT INTO emkt_regions VALUES(1433, 96, 'GY', 'Győr', 'english');
INSERT INTO emkt_regions VALUES(1434, 96, 'HB', 'Hajdú-Bihar megye', 'english');
INSERT INTO emkt_regions VALUES(1435, 96, 'HE', 'Heves megye', 'english');
INSERT INTO emkt_regions VALUES(1436, 96, 'HV', 'Hódmezővásárhely', 'english');
INSERT INTO emkt_regions VALUES(1437, 96, 'JN', 'Jász-Nagykun-Szolnok megye', 'english');
INSERT INTO emkt_regions VALUES(1438, 96, 'KE', 'Komárom-Esztergom megye', 'english');
INSERT INTO emkt_regions VALUES(1439, 96, 'KM', 'Kecskemét', 'english');
INSERT INTO emkt_regions VALUES(1440, 96, 'KV', 'Kaposvár', 'english');
INSERT INTO emkt_regions VALUES(1441, 96, 'MI', 'Miskolc', 'english');
INSERT INTO emkt_regions VALUES(1442, 96, 'NK', 'Nagykanizsa', 'english');
INSERT INTO emkt_regions VALUES(1443, 96, 'NO', 'Nógrád megye', 'english');
INSERT INTO emkt_regions VALUES(1444, 96, 'NY', 'Nyíregyháza', 'english');
INSERT INTO emkt_regions VALUES(1445, 96, 'PE', 'Pest megye', 'english');
INSERT INTO emkt_regions VALUES(1446, 96, 'PS', 'Pécs', 'english');
INSERT INTO emkt_regions VALUES(1447, 96, 'SD', 'Szeged', 'english');
INSERT INTO emkt_regions VALUES(1448, 96, 'SF', 'Székesfehérvár', 'english');
INSERT INTO emkt_regions VALUES(1449, 96, 'SH', 'Szombathely', 'english');
INSERT INTO emkt_regions VALUES(1450, 96, 'SK', 'Szolnok', 'english');
INSERT INTO emkt_regions VALUES(1451, 96, 'SN', 'Sopron', 'english');
INSERT INTO emkt_regions VALUES(1452, 96, 'SO', 'Somogy megye', 'english');
INSERT INTO emkt_regions VALUES(1453, 96, 'SS', 'Szekszárd', 'english');
INSERT INTO emkt_regions VALUES(1454, 96, 'ST', 'Salgótarján', 'english');
INSERT INTO emkt_regions VALUES(1455, 96, 'SZ', 'Szabolcs-Szatmár-Bereg megye', 'english');
INSERT INTO emkt_regions VALUES(1456, 96, 'TB', 'Tatabánya', 'english');
INSERT INTO emkt_regions VALUES(1457, 96, 'TO', 'Tolna megye', 'english');
INSERT INTO emkt_regions VALUES(1458, 96, 'VA', 'Vas megye', 'english');
INSERT INTO emkt_regions VALUES(1459, 96, 'VE', 'Veszprém megye', 'english');
INSERT INTO emkt_regions VALUES(1460, 96, 'VM', 'Veszprém', 'english');
INSERT INTO emkt_regions VALUES(1461, 96, 'ZA', 'Zala megye', 'english');
INSERT INTO emkt_regions VALUES(1462, 96, 'ZE', 'Zalaegerszeg', 'english');

INSERT INTO emkt_countries VALUES (97,'Iceland','english','IS','ISL','');

INSERT INTO emkt_regions VALUES(1463, 97, '1', 'Höfuðborgarsvæðið', 'english');
INSERT INTO emkt_regions VALUES(1464, 97, '2', 'Suðurnes', 'english');
INSERT INTO emkt_regions VALUES(1465, 97, '3', 'Vesturland', 'english');
INSERT INTO emkt_regions VALUES(1466, 97, '4', 'Vestfirðir', 'english');
INSERT INTO emkt_regions VALUES(1467, 97, '5', 'Norðurland vestra', 'english');
INSERT INTO emkt_regions VALUES(1468, 97, '6', 'Norðurland eystra', 'english');
INSERT INTO emkt_regions VALUES(1469, 97, '7', 'Austfirðir', 'english');
INSERT INTO emkt_regions VALUES(1470, 97, '8', 'Suðurland', 'english');

INSERT INTO emkt_countries VALUES (98,'India','english','IN','IND','');

INSERT INTO emkt_regions VALUES(1471, 98, 'IN-AN', 'अंडमान और निकोबार द्वीप', 'english');
INSERT INTO emkt_regions VALUES(1472, 98, 'IN-AP', 'ఆంధ్ర ప్రదేశ్', 'english');
INSERT INTO emkt_regions VALUES(1473, 98, 'IN-AR', 'अरुणाचल प्रदेश', 'english');
INSERT INTO emkt_regions VALUES(1474, 98, 'IN-AS', 'অসম', 'english');
INSERT INTO emkt_regions VALUES(1475, 98, 'IN-BR', 'बिहार', 'english');
INSERT INTO emkt_regions VALUES(1476, 98, 'IN-CH', 'चंडीगढ़', 'english');
INSERT INTO emkt_regions VALUES(1477, 98, 'IN-CT', 'छत्तीसगढ़', 'english');
INSERT INTO emkt_regions VALUES(1478, 98, 'IN-DD', 'દમણ અને દિવ', 'english');
INSERT INTO emkt_regions VALUES(1479, 98, 'IN-DL', 'दिल्ली', 'english');
INSERT INTO emkt_regions VALUES(1480, 98, 'IN-DN', 'દાદરા અને નગર હવેલી', 'english');
INSERT INTO emkt_regions VALUES(1481, 98, 'IN-GA', 'गोंय', 'english');
INSERT INTO emkt_regions VALUES(1482, 98, 'IN-GJ', 'ગુજરાત', 'english');
INSERT INTO emkt_regions VALUES(1483, 98, 'IN-HP', 'हिमाचल प्रदेश', 'english');
INSERT INTO emkt_regions VALUES(1484, 98, 'IN-HR', 'हरियाणा', 'english');
INSERT INTO emkt_regions VALUES(1485, 98, 'IN-JH', 'झारखंड', 'english');
INSERT INTO emkt_regions VALUES(1486, 98, 'IN-JK', 'जम्मू और कश्मीर', 'english');
INSERT INTO emkt_regions VALUES(1487, 98, 'IN-KA', 'ಕನಾ೯ಟಕ', 'english');
INSERT INTO emkt_regions VALUES(1488, 98, 'IN-KL', 'കേരളം', 'english');
INSERT INTO emkt_regions VALUES(1489, 98, 'IN-LD', 'ലക്ഷദ്വീപ്', 'english');
INSERT INTO emkt_regions VALUES(1490, 98, 'IN-ML', 'मेघालय', 'english');
INSERT INTO emkt_regions VALUES(1491, 98, 'IN-MH', 'महाराष्ट्र', 'english');
INSERT INTO emkt_regions VALUES(1492, 98, 'IN-MN', 'मणिपुर', 'english');
INSERT INTO emkt_regions VALUES(1493, 98, 'IN-MP', 'मध्य प्रदेश', 'english');
INSERT INTO emkt_regions VALUES(1494, 98, 'IN-MZ', 'मिज़ोरम', 'english');
INSERT INTO emkt_regions VALUES(1495, 98, 'IN-NL', 'नागालैंड', 'english');
INSERT INTO emkt_regions VALUES(1496, 98, 'IN-OR', 'उड़ीसा', 'english');
INSERT INTO emkt_regions VALUES(1497, 98, 'IN-PB', 'ਪੰਜਾਬ', 'english');
INSERT INTO emkt_regions VALUES(1498, 98, 'IN-PY', 'புதுச்சேரி', 'english');
INSERT INTO emkt_regions VALUES(1499, 98, 'IN-RJ', 'राजस्थान', 'english');
INSERT INTO emkt_regions VALUES(1500, 98, 'IN-SK', 'सिक्किम', 'english');
INSERT INTO emkt_regions VALUES(1501, 98, 'IN-TN', 'தமிழ் நாடு', 'english');
INSERT INTO emkt_regions VALUES(1502, 98, 'IN-TR', 'ত্রিপুরা', 'english');
INSERT INTO emkt_regions VALUES(1503, 98, 'IN-UL', 'उत्तरांचल', 'english');
INSERT INTO emkt_regions VALUES(1504, 98, 'IN-UP', 'उत्तर प्रदेश', 'english');
INSERT INTO emkt_regions VALUES(1505, 98, 'IN-WB', 'পশ্চিমবঙ্গ', 'english');

INSERT INTO emkt_countries VALUES (99,'Indonesia','english','ID','IDN','');

INSERT INTO emkt_regions VALUES(1506, 99, 'AC', 'Aceh', 'english');
INSERT INTO emkt_regions VALUES(1507, 99, 'BA', 'Bali', 'english');
INSERT INTO emkt_regions VALUES(1508, 99, 'BB', 'Bangka-Belitung', 'english');
INSERT INTO emkt_regions VALUES(1509, 99, 'BE', 'Bengkulu', 'english');
INSERT INTO emkt_regions VALUES(1510, 99, 'BT', 'Banten', 'english');
INSERT INTO emkt_regions VALUES(1511, 99, 'GO', 'Gorontalo', 'english');
INSERT INTO emkt_regions VALUES(1512, 99, 'IJ', 'Papua', 'english');
INSERT INTO emkt_regions VALUES(1513, 99, 'JA', 'Jambi', 'english');
INSERT INTO emkt_regions VALUES(1514, 99, 'JI', 'Jawa Timur', 'english');
INSERT INTO emkt_regions VALUES(1515, 99, 'JK', 'Jakarta Raya', 'english');
INSERT INTO emkt_regions VALUES(1516, 99, 'JR', 'Jawa Barat', 'english');
INSERT INTO emkt_regions VALUES(1517, 99, 'JT', 'Jawa Tengah', 'english');
INSERT INTO emkt_regions VALUES(1518, 99, 'KB', 'Kalimantan Barat', 'english');
INSERT INTO emkt_regions VALUES(1519, 99, 'KI', 'Kalimantan Timur', 'english');
INSERT INTO emkt_regions VALUES(1520, 99, 'KS', 'Kalimantan Selatan', 'english');
INSERT INTO emkt_regions VALUES(1521, 99, 'KT', 'Kalimantan Tengah', 'english');
INSERT INTO emkt_regions VALUES(1522, 99, 'LA', 'Lampung', 'english');
INSERT INTO emkt_regions VALUES(1523, 99, 'MA', 'Maluku', 'english');
INSERT INTO emkt_regions VALUES(1524, 99, 'MU', 'Maluku Utara', 'english');
INSERT INTO emkt_regions VALUES(1525, 99, 'NB', 'Nusa Tenggara Barat', 'english');
INSERT INTO emkt_regions VALUES(1526, 99, 'NT', 'Nusa Tenggara Timur', 'english');
INSERT INTO emkt_regions VALUES(1527, 99, 'RI', 'Riau', 'english');
INSERT INTO emkt_regions VALUES(1528, 99, 'SB', 'Sumatera Barat', 'english');
INSERT INTO emkt_regions VALUES(1529, 99, 'SG', 'Sulawesi Tenggara', 'english');
INSERT INTO emkt_regions VALUES(1530, 99, 'SL', 'Sumatera Selatan', 'english');
INSERT INTO emkt_regions VALUES(1531, 99, 'SN', 'Sulawesi Selatan', 'english');
INSERT INTO emkt_regions VALUES(1532, 99, 'ST', 'Sulawesi Tengah', 'english');
INSERT INTO emkt_regions VALUES(1533, 99, 'SW', 'Sulawesi Utara', 'english');
INSERT INTO emkt_regions VALUES(1534, 99, 'SU', 'Sumatera Utara', 'english');
INSERT INTO emkt_regions VALUES(1535, 99, 'YO', 'Yogyakarta', 'english');

INSERT INTO emkt_countries VALUES (100,'Iran','english','IR','IRN','');

INSERT INTO emkt_regions VALUES(1536, 100, '01', 'محافظة آذربایجان شرقي', 'english');
INSERT INTO emkt_regions VALUES(1537, 100, '02', 'محافظة آذربایجان غربي', 'english');
INSERT INTO emkt_regions VALUES(1538, 100, '03', 'محافظة اردبیل', 'english');
INSERT INTO emkt_regions VALUES(1539, 100, '04', 'محافظة اصفهان', 'english');
INSERT INTO emkt_regions VALUES(1540, 100, '05', 'محافظة ایلام', 'english');
INSERT INTO emkt_regions VALUES(1541, 100, '06', 'محافظة بوشهر', 'english');
INSERT INTO emkt_regions VALUES(1542, 100, '07', 'محافظة طهران', 'english');
INSERT INTO emkt_regions VALUES(1543, 100, '08', 'محافظة چهارمحل و بختیاري', 'english');
INSERT INTO emkt_regions VALUES(1544, 100, '09', 'محافظة خراسان رضوي', 'english');
INSERT INTO emkt_regions VALUES(1545, 100, '10', 'محافظة خوزستان', 'english');
INSERT INTO emkt_regions VALUES(1546, 100, '11', 'محافظة زنجان', 'english');
INSERT INTO emkt_regions VALUES(1547, 100, '12', 'محافظة سمنان', 'english');
INSERT INTO emkt_regions VALUES(1548, 100, '13', 'محافظة سيستان وبلوتشستان', 'english');
INSERT INTO emkt_regions VALUES(1549, 100, '14', 'محافظة فارس', 'english');
INSERT INTO emkt_regions VALUES(1550, 100, '15', 'محافظة کرمان', 'english');
INSERT INTO emkt_regions VALUES(1551, 100, '16', 'محافظة کردستان', 'english');
INSERT INTO emkt_regions VALUES(1552, 100, '17', 'محافظة کرمانشاه', 'english');
INSERT INTO emkt_regions VALUES(1553, 100, '18', 'محافظة کهکیلویه و بویر أحمد', 'english');
INSERT INTO emkt_regions VALUES(1554, 100, '19', 'محافظة گیلان', 'english');
INSERT INTO emkt_regions VALUES(1555, 100, '20', 'محافظة لرستان', 'english');
INSERT INTO emkt_regions VALUES(1556, 100, '21', 'محافظة مازندران', 'english');
INSERT INTO emkt_regions VALUES(1557, 100, '22', 'محافظة مرکزي', 'english');
INSERT INTO emkt_regions VALUES(1558, 100, '23', 'محافظة هرمزگان', 'english');
INSERT INTO emkt_regions VALUES(1559, 100, '24', 'محافظة همدان', 'english');
INSERT INTO emkt_regions VALUES(1560, 100, '25', 'محافظة یزد', 'english');
INSERT INTO emkt_regions VALUES(1561, 100, '26', 'محافظة قم', 'english');
INSERT INTO emkt_regions VALUES(1562, 100, '27', 'محافظة گلستان', 'english');
INSERT INTO emkt_regions VALUES(1563, 100, '28', 'محافظة قزوين', 'english');

INSERT INTO emkt_countries VALUES (101,'Iraq','english','IQ','IRQ','');

INSERT INTO emkt_regions VALUES(1564, 101, 'AN', 'محافظة الأنبار', 'english');
INSERT INTO emkt_regions VALUES(1565, 101, 'AR', 'أربيل', 'english');
INSERT INTO emkt_regions VALUES(1566, 101, 'BA', 'محافظة البصرة', 'english');
INSERT INTO emkt_regions VALUES(1567, 101, 'BB', 'بابل', 'english');
INSERT INTO emkt_regions VALUES(1568, 101, 'BG', 'محافظة بغداد', 'english');
INSERT INTO emkt_regions VALUES(1569, 101, 'DA', 'دهوك', 'english');
INSERT INTO emkt_regions VALUES(1570, 101, 'DI', 'ديالى', 'english');
INSERT INTO emkt_regions VALUES(1571, 101, 'DQ', 'ذي قار', 'english');
INSERT INTO emkt_regions VALUES(1572, 101, 'KA', 'كربلاء', 'english');
INSERT INTO emkt_regions VALUES(1573, 101, 'MA', 'ميسان', 'english');
INSERT INTO emkt_regions VALUES(1574, 101, 'MU', 'المثنى', 'english');
INSERT INTO emkt_regions VALUES(1575, 101, 'NA', 'النجف', 'english');
INSERT INTO emkt_regions VALUES(1576, 101, 'NI', 'نینوى', 'english');
INSERT INTO emkt_regions VALUES(1577, 101, 'QA', 'القادسية', 'english');
INSERT INTO emkt_regions VALUES(1578, 101, 'SD', 'صلاح الدين', 'english');
INSERT INTO emkt_regions VALUES(1579, 101, 'SW', 'محافظة السليمانية', 'english');
INSERT INTO emkt_regions VALUES(1580, 101, 'TS', 'التأمیم', 'english');
INSERT INTO emkt_regions VALUES(1581, 101, 'WA', 'واسط', 'english');

INSERT INTO emkt_countries VALUES (102,'Ireland','english','IE','IRL','');

INSERT INTO emkt_regions VALUES(1582, 102, 'C', 'Corcaigh', 'english');
INSERT INTO emkt_regions VALUES(1583, 102, 'CE', 'Contae an Chláir', 'english');
INSERT INTO emkt_regions VALUES(1584, 102, 'CN', 'An Cabhán', 'english');
INSERT INTO emkt_regions VALUES(1585, 102, 'CW', 'Ceatharlach', 'english');
INSERT INTO emkt_regions VALUES(1586, 102, 'D', 'Baile Átha Cliath', 'english');
INSERT INTO emkt_regions VALUES(1587, 102, 'DL', 'Dún na nGall', 'english');
INSERT INTO emkt_regions VALUES(1588, 102, 'G', 'Gaillimh', 'english');
INSERT INTO emkt_regions VALUES(1589, 102, 'KE', 'Cill Dara', 'english');
INSERT INTO emkt_regions VALUES(1590, 102, 'KK', 'Cill Chainnigh', 'english');
INSERT INTO emkt_regions VALUES(1591, 102, 'KY', 'Contae Chiarraí', 'english');
INSERT INTO emkt_regions VALUES(1592, 102, 'LD', 'An Longfort', 'english');
INSERT INTO emkt_regions VALUES(1593, 102, 'LH', 'Contae Lú', 'english');
INSERT INTO emkt_regions VALUES(1594, 102, 'LK', 'Luimneach', 'english');
INSERT INTO emkt_regions VALUES(1595, 102, 'LM', 'Contae Liatroma', 'english');
INSERT INTO emkt_regions VALUES(1596, 102, 'LS', 'Contae Laoise', 'english');
INSERT INTO emkt_regions VALUES(1597, 102, 'MH', 'Contae na Mí', 'english');
INSERT INTO emkt_regions VALUES(1598, 102, 'MN', 'Muineachán', 'english');
INSERT INTO emkt_regions VALUES(1599, 102, 'MO', 'Contae Mhaigh Eo', 'english');
INSERT INTO emkt_regions VALUES(1600, 102, 'OY', 'Contae Uíbh Fhailí', 'english');
INSERT INTO emkt_regions VALUES(1601, 102, 'RN', 'Ros Comáin', 'english');
INSERT INTO emkt_regions VALUES(1602, 102, 'SO', 'Sligeach', 'english');
INSERT INTO emkt_regions VALUES(1603, 102, 'TA', 'Tiobraid Árann', 'english');
INSERT INTO emkt_regions VALUES(1604, 102, 'WD', 'Port Lairge', 'english');
INSERT INTO emkt_regions VALUES(1605, 102, 'WH', 'Contae na hIarmhí', 'english');
INSERT INTO emkt_regions VALUES(1606, 102, 'WW', 'Cill Mhantáin', 'english');
INSERT INTO emkt_regions VALUES(1607, 102, 'WX', 'Loch Garman', 'english');

INSERT INTO emkt_countries VALUES (103,'Israel','english','IL','ISR','');

INSERT INTO emkt_regions VALUES(1608, 103, 'D ', 'מחוז הדרום', 'english');
INSERT INTO emkt_regions VALUES(1609, 103, 'HA', 'מחוז חיפה', 'english');
INSERT INTO emkt_regions VALUES(1610, 103, 'JM', 'ירושלים', 'english');
INSERT INTO emkt_regions VALUES(1611, 103, 'M ', 'מחוז המרכז', 'english');
INSERT INTO emkt_regions VALUES(1612, 103, 'TA', 'תל אביב-יפו', 'english');
INSERT INTO emkt_regions VALUES(1613, 103, 'Z ', 'מחוז הצפון', 'english');

INSERT INTO emkt_countries VALUES (104,'Italy','english','IT','ITA','');

INSERT INTO emkt_regions VALUES(1614, 104, 'AG', 'Agrigento', 'english');
INSERT INTO emkt_regions VALUES(1615, 104, 'AL', 'Alessandria', 'english');
INSERT INTO emkt_regions VALUES(1616, 104, 'AN', 'Ancona', 'english');
INSERT INTO emkt_regions VALUES(1617, 104, 'AO', 'Valle d\'Aosta', 'english');
INSERT INTO emkt_regions VALUES(1618, 104, 'AP', 'Ascoli Piceno', 'english');
INSERT INTO emkt_regions VALUES(1619, 104, 'AQ', 'L\'Aquila', 'english');
INSERT INTO emkt_regions VALUES(1620, 104, 'AR', 'Arezzo', 'english');
INSERT INTO emkt_regions VALUES(1621, 104, 'AT', 'Asti', 'english');
INSERT INTO emkt_regions VALUES(1622, 104, 'AV', 'Avellino', 'english');
INSERT INTO emkt_regions VALUES(1623, 104, 'BA', 'Bari', 'english');
INSERT INTO emkt_regions VALUES(1624, 104, 'BG', 'Bergamo', 'english');
INSERT INTO emkt_regions VALUES(1625, 104, 'BI', 'Biella', 'english');
INSERT INTO emkt_regions VALUES(1626, 104, 'BL', 'Belluno', 'english');
INSERT INTO emkt_regions VALUES(1627, 104, 'BN', 'Benevento', 'english');
INSERT INTO emkt_regions VALUES(1628, 104, 'BO', 'Bologna', 'english');
INSERT INTO emkt_regions VALUES(1629, 104, 'BR', 'Brindisi', 'english');
INSERT INTO emkt_regions VALUES(1630, 104, 'BS', 'Brescia', 'english');
INSERT INTO emkt_regions VALUES(1631, 104, 'BT', 'Barletta-Andria-Trani', 'english');
INSERT INTO emkt_regions VALUES(1632, 104, 'BZ', 'Alto Adige', 'english');
INSERT INTO emkt_regions VALUES(1633, 104, 'CA', 'Cagliari', 'english');
INSERT INTO emkt_regions VALUES(1634, 104, 'CB', 'Campobasso', 'english');
INSERT INTO emkt_regions VALUES(1635, 104, 'CE', 'Caserta', 'english');
INSERT INTO emkt_regions VALUES(1636, 104, 'CH', 'Chieti', 'english');
INSERT INTO emkt_regions VALUES(1637, 104, 'CI', 'Carbonia-Iglesias', 'english');
INSERT INTO emkt_regions VALUES(1638, 104, 'CL', 'Caltanissetta', 'english');
INSERT INTO emkt_regions VALUES(1639, 104, 'CN', 'Cuneo', 'english');
INSERT INTO emkt_regions VALUES(1640, 104, 'CO', 'Como', 'english');
INSERT INTO emkt_regions VALUES(1641, 104, 'CR', 'Cremona', 'english');
INSERT INTO emkt_regions VALUES(1642, 104, 'CS', 'Cosenza', 'english');
INSERT INTO emkt_regions VALUES(1643, 104, 'CT', 'Catania', 'english');
INSERT INTO emkt_regions VALUES(1644, 104, 'CZ', 'Catanzaro', 'english');
INSERT INTO emkt_regions VALUES(1645, 104, 'EN', 'Enna', 'english');
INSERT INTO emkt_regions VALUES(1646, 104, 'FE', 'Ferrara', 'english');
INSERT INTO emkt_regions VALUES(1647, 104, 'FG', 'Foggia', 'english');
INSERT INTO emkt_regions VALUES(1648, 104, 'FI', 'Firenze', 'english');
INSERT INTO emkt_regions VALUES(1649, 104, 'FM', 'Fermo', 'english');
INSERT INTO emkt_regions VALUES(1650, 104, 'FO', 'Forlì-Cesena', 'english');
INSERT INTO emkt_regions VALUES(1651, 104, 'FR', 'Frosinone', 'english');
INSERT INTO emkt_regions VALUES(1652, 104, 'GE', 'Genova', 'english');
INSERT INTO emkt_regions VALUES(1653, 104, 'GO', 'Gorizia', 'english');
INSERT INTO emkt_regions VALUES(1654, 104, 'GR', 'Grosseto', 'english');
INSERT INTO emkt_regions VALUES(1655, 104, 'IM', 'Imperia', 'english');
INSERT INTO emkt_regions VALUES(1656, 104, 'IS', 'Isernia', 'english');
INSERT INTO emkt_regions VALUES(1657, 104, 'KR', 'Crotone', 'english');
INSERT INTO emkt_regions VALUES(1658, 104, 'LC', 'Lecco', 'english');
INSERT INTO emkt_regions VALUES(1659, 104, 'LE', 'Lecce', 'english');
INSERT INTO emkt_regions VALUES(1660, 104, 'LI', 'Livorno', 'english');
INSERT INTO emkt_regions VALUES(1661, 104, 'LO', 'Lodi', 'english');
INSERT INTO emkt_regions VALUES(1662, 104, 'LT', 'Latina', 'english');
INSERT INTO emkt_regions VALUES(1663, 104, 'LU', 'Lucca', 'english');
INSERT INTO emkt_regions VALUES(1664, 104, 'MC', 'Macerata', 'english');
INSERT INTO emkt_regions VALUES(1665, 104, 'MD', 'Medio Campidano', 'english');
INSERT INTO emkt_regions VALUES(1666, 104, 'ME', 'Messina', 'english');
INSERT INTO emkt_regions VALUES(1667, 104, 'MI', 'Milano', 'english');
INSERT INTO emkt_regions VALUES(1668, 104, 'MN', 'Mantova', 'english');
INSERT INTO emkt_regions VALUES(1669, 104, 'MO', 'Modena', 'english');
INSERT INTO emkt_regions VALUES(1670, 104, 'MS', 'Massa-Carrara', 'english');
INSERT INTO emkt_regions VALUES(1671, 104, 'MT', 'Matera', 'english');
INSERT INTO emkt_regions VALUES(1672, 104, 'MZ', 'Monza e Brianza', 'english');
INSERT INTO emkt_regions VALUES(1673, 104, 'NA', 'Napoli', 'english');
INSERT INTO emkt_regions VALUES(1674, 104, 'NO', 'Novara', 'english');
INSERT INTO emkt_regions VALUES(1675, 104, 'NU', 'Nuoro', 'english');
INSERT INTO emkt_regions VALUES(1676, 104, 'OG', 'Ogliastra', 'english');
INSERT INTO emkt_regions VALUES(1677, 104, 'OR', 'Oristano', 'english');
INSERT INTO emkt_regions VALUES(1678, 104, 'OT', 'Olbia-Tempio', 'english');
INSERT INTO emkt_regions VALUES(1679, 104, 'PA', 'Palermo', 'english');
INSERT INTO emkt_regions VALUES(1680, 104, 'PC', 'Piacenza', 'english');
INSERT INTO emkt_regions VALUES(1681, 104, 'PD', 'Padova', 'english');
INSERT INTO emkt_regions VALUES(1682, 104, 'PE', 'Pescara', 'english');
INSERT INTO emkt_regions VALUES(1683, 104, 'PG', 'Perugia', 'english');
INSERT INTO emkt_regions VALUES(1684, 104, 'PI', 'Pisa', 'english');
INSERT INTO emkt_regions VALUES(1685, 104, 'PN', 'Pordenone', 'english');
INSERT INTO emkt_regions VALUES(1686, 104, 'PO', 'Prato', 'english');
INSERT INTO emkt_regions VALUES(1687, 104, 'PR', 'Parma', 'english');
INSERT INTO emkt_regions VALUES(1688, 104, 'PS', 'Pesaro e Urbino', 'english');
INSERT INTO emkt_regions VALUES(1689, 104, 'PT', 'Pistoia', 'english');
INSERT INTO emkt_regions VALUES(1690, 104, 'PV', 'Pavia', 'english');
INSERT INTO emkt_regions VALUES(1691, 104, 'PZ', 'Potenza', 'english');
INSERT INTO emkt_regions VALUES(1692, 104, 'RA', 'Ravenna', 'english');
INSERT INTO emkt_regions VALUES(1693, 104, 'RC', 'Reggio Calabria', 'english');
INSERT INTO emkt_regions VALUES(1694, 104, 'RE', 'Reggio Emilia', 'english');
INSERT INTO emkt_regions VALUES(1695, 104, 'RG', 'Ragusa', 'english');
INSERT INTO emkt_regions VALUES(1696, 104, 'RI', 'Rieti', 'english');
INSERT INTO emkt_regions VALUES(1697, 104, 'RM', 'Roma', 'english');
INSERT INTO emkt_regions VALUES(1698, 104, 'RN', 'Rimini', 'english');
INSERT INTO emkt_regions VALUES(1699, 104, 'RO', 'Rovigo', 'english');
INSERT INTO emkt_regions VALUES(1700, 104, 'SA', 'Salerno', 'english');
INSERT INTO emkt_regions VALUES(1701, 104, 'SI', 'Siena', 'english');
INSERT INTO emkt_regions VALUES(1702, 104, 'SO', 'Sondrio', 'english');
INSERT INTO emkt_regions VALUES(1703, 104, 'SP', 'La Spezia', 'english');
INSERT INTO emkt_regions VALUES(1704, 104, 'SR', 'Siracusa', 'english');
INSERT INTO emkt_regions VALUES(1705, 104, 'SS', 'Sassari', 'english');
INSERT INTO emkt_regions VALUES(1706, 104, 'SV', 'Savona', 'english');
INSERT INTO emkt_regions VALUES(1707, 104, 'TA', 'Taranto', 'english');
INSERT INTO emkt_regions VALUES(1708, 104, 'TE', 'Teramo', 'english');
INSERT INTO emkt_regions VALUES(1709, 104, 'TN', 'Trento', 'english');
INSERT INTO emkt_regions VALUES(1710, 104, 'TO', 'Torino', 'english');
INSERT INTO emkt_regions VALUES(1711, 104, 'TP', 'Trapani', 'english');
INSERT INTO emkt_regions VALUES(1712, 104, 'TR', 'Terni', 'english');
INSERT INTO emkt_regions VALUES(1713, 104, 'TS', 'Trieste', 'english');
INSERT INTO emkt_regions VALUES(1714, 104, 'TV', 'Treviso', 'english');
INSERT INTO emkt_regions VALUES(1715, 104, 'UD', 'Udine', 'english');
INSERT INTO emkt_regions VALUES(1716, 104, 'VA', 'Varese', 'english');
INSERT INTO emkt_regions VALUES(1717, 104, 'VB', 'Verbano-Cusio-Ossola', 'english');
INSERT INTO emkt_regions VALUES(1718, 104, 'VC', 'Vercelli', 'english');
INSERT INTO emkt_regions VALUES(1719, 104, 'VE', 'Venezia', 'english');
INSERT INTO emkt_regions VALUES(1720, 104, 'VI', 'Vicenza', 'english');
INSERT INTO emkt_regions VALUES(1721, 104, 'VR', 'Verona', 'english');
INSERT INTO emkt_regions VALUES(1722, 104, 'VT', 'Viterbo', 'english');
INSERT INTO emkt_regions VALUES(1723, 104, 'VV', 'Vibo Valentia', 'english');

INSERT INTO emkt_countries VALUES (105,'Jamaica','english','JM','JAM','');

INSERT INTO emkt_regions VALUES(1724, 105, '01', 'Kingston', 'english');
INSERT INTO emkt_regions VALUES(1725, 105, '02', 'Half Way Tree', 'english');
INSERT INTO emkt_regions VALUES(1726, 105, '03', 'Morant Bay', 'english');
INSERT INTO emkt_regions VALUES(1727, 105, '04', 'Port Antonio', 'english');
INSERT INTO emkt_regions VALUES(1728, 105, '05', 'Port Maria', 'english');
INSERT INTO emkt_regions VALUES(1729, 105, '06', 'Saint Ann\'s Bay', 'english');
INSERT INTO emkt_regions VALUES(1730, 105, '07', 'Falmouth', 'english');
INSERT INTO emkt_regions VALUES(1731, 105, '08', 'Montego Bay', 'english');
INSERT INTO emkt_regions VALUES(1732, 105, '09', 'Lucea', 'english');
INSERT INTO emkt_regions VALUES(1733, 105, '10', 'Savanna-la-Mar', 'english');
INSERT INTO emkt_regions VALUES(1734, 105, '11', 'Black River', 'english');
INSERT INTO emkt_regions VALUES(1735, 105, '12', 'Mandeville', 'english');
INSERT INTO emkt_regions VALUES(1736, 105, '13', 'May Pen', 'english');
INSERT INTO emkt_regions VALUES(1737, 105, '14', 'Spanish Town', 'english');

INSERT INTO emkt_countries VALUES (106,'Japan','english','JP','JPN','');

INSERT INTO emkt_regions VALUES(1738, 106, '01', '北海道', 'english');
INSERT INTO emkt_regions VALUES(1739, 106, '02', '青森', 'english');
INSERT INTO emkt_regions VALUES(1740, 106, '03', '岩手', 'english');
INSERT INTO emkt_regions VALUES(1741, 106, '04', '宮城', 'english');
INSERT INTO emkt_regions VALUES(1742, 106, '05', '秋田', 'english');
INSERT INTO emkt_regions VALUES(1743, 106, '06', '山形', 'english');
INSERT INTO emkt_regions VALUES(1744, 106, '07', '福島', 'english');
INSERT INTO emkt_regions VALUES(1745, 106, '08', '茨城', 'english');
INSERT INTO emkt_regions VALUES(1746, 106, '09', '栃木', 'english');
INSERT INTO emkt_regions VALUES(1747, 106, '10', '群馬', 'english');
INSERT INTO emkt_regions VALUES(1748, 106, '11', '埼玉', 'english');
INSERT INTO emkt_regions VALUES(1749, 106, '12', '千葉', 'english');
INSERT INTO emkt_regions VALUES(1750, 106, '13', '東京', 'english');
INSERT INTO emkt_regions VALUES(1751, 106, '14', '神奈川', 'english');
INSERT INTO emkt_regions VALUES(1752, 106, '15', '新潟', 'english');
INSERT INTO emkt_regions VALUES(1753, 106, '16', '富山', 'english');
INSERT INTO emkt_regions VALUES(1754, 106, '17', '石川', 'english');
INSERT INTO emkt_regions VALUES(1755, 106, '18', '福井', 'english');
INSERT INTO emkt_regions VALUES(1756, 106, '19', '山梨', 'english');
INSERT INTO emkt_regions VALUES(1757, 106, '20', '長野', 'english');
INSERT INTO emkt_regions VALUES(1758, 106, '21', '岐阜', 'english');
INSERT INTO emkt_regions VALUES(1759, 106, '22', '静岡', 'english');
INSERT INTO emkt_regions VALUES(1760, 106, '23', '愛知', 'english');
INSERT INTO emkt_regions VALUES(1761, 106, '24', '三重', 'english');
INSERT INTO emkt_regions VALUES(1762, 106, '25', '滋賀', 'english');
INSERT INTO emkt_regions VALUES(1763, 106, '26', '京都', 'english');
INSERT INTO emkt_regions VALUES(1764, 106, '27', '大阪', 'english');
INSERT INTO emkt_regions VALUES(1765, 106, '28', '兵庫', 'english');
INSERT INTO emkt_regions VALUES(1766, 106, '29', '奈良', 'english');
INSERT INTO emkt_regions VALUES(1767, 106, '30', '和歌山', 'english');
INSERT INTO emkt_regions VALUES(1768, 106, '31', '鳥取', 'english');
INSERT INTO emkt_regions VALUES(1769, 106, '32', '島根', 'english');
INSERT INTO emkt_regions VALUES(1770, 106, '33', '岡山', 'english');
INSERT INTO emkt_regions VALUES(1771, 106, '34', '広島', 'english');
INSERT INTO emkt_regions VALUES(1772, 106, '35', '山口', 'english');
INSERT INTO emkt_regions VALUES(1773, 106, '36', '徳島', 'english');
INSERT INTO emkt_regions VALUES(1774, 106, '37', '香川', 'english');
INSERT INTO emkt_regions VALUES(1775, 106, '38', '愛媛', 'english');
INSERT INTO emkt_regions VALUES(1776, 106, '39', '高知', 'english');
INSERT INTO emkt_regions VALUES(1777, 106, '40', '福岡', 'english');
INSERT INTO emkt_regions VALUES(1778, 106, '41', '佐賀', 'english');
INSERT INTO emkt_regions VALUES(1779, 106, '42', '長崎', 'english');
INSERT INTO emkt_regions VALUES(1780, 106, '43', '熊本', 'english');
INSERT INTO emkt_regions VALUES(1781, 106, '44', '大分', 'english');
INSERT INTO emkt_regions VALUES(1782, 106, '45', '宮崎', 'english');
INSERT INTO emkt_regions VALUES(1783, 106, '46', '鹿児島', 'english');
INSERT INTO emkt_regions VALUES(1784, 106, '47', '沖縄', 'english');

INSERT INTO emkt_countries VALUES (107,'Jordan','english','JO','JOR','');

INSERT INTO emkt_regions VALUES(1785, 107, 'AJ', 'محافظة عجلون', 'english');
INSERT INTO emkt_regions VALUES(1786, 107, 'AM', 'محافظة العاصمة', 'english');
INSERT INTO emkt_regions VALUES(1787, 107, 'AQ', 'محافظة العقبة', 'english');
INSERT INTO emkt_regions VALUES(1788, 107, 'AT', 'محافظة الطفيلة', 'english');
INSERT INTO emkt_regions VALUES(1789, 107, 'AZ', 'محافظة الزرقاء', 'english');
INSERT INTO emkt_regions VALUES(1790, 107, 'BA', 'محافظة البلقاء', 'english');
INSERT INTO emkt_regions VALUES(1791, 107, 'JA', 'محافظة جرش', 'english');
INSERT INTO emkt_regions VALUES(1792, 107, 'JR', 'محافظة إربد', 'english');
INSERT INTO emkt_regions VALUES(1793, 107, 'KA', 'محافظة الكرك', 'english');
INSERT INTO emkt_regions VALUES(1794, 107, 'MA', 'محافظة المفرق', 'english');
INSERT INTO emkt_regions VALUES(1795, 107, 'MD', 'محافظة مادبا', 'english');
INSERT INTO emkt_regions VALUES(1796, 107, 'MN', 'محافظة معان', 'english');

INSERT INTO emkt_countries VALUES (108,'Kazakhstan','english','KZ','KAZ','');

INSERT INTO emkt_regions VALUES(1797, 108, 'AL', 'Алматы', 'english');
INSERT INTO emkt_regions VALUES(1798, 108, 'AC', 'Almaty City', 'english');
INSERT INTO emkt_regions VALUES(1799, 108, 'AM', 'Ақмола', 'english');
INSERT INTO emkt_regions VALUES(1800, 108, 'AQ', 'Ақтөбе', 'english');
INSERT INTO emkt_regions VALUES(1801, 108, 'AS', 'Астана', 'english');
INSERT INTO emkt_regions VALUES(1802, 108, 'AT', 'Атырау', 'english');
INSERT INTO emkt_regions VALUES(1803, 108, 'BA', 'Батыс Қазақстан', 'english');
INSERT INTO emkt_regions VALUES(1804, 108, 'BY', 'Байқоңыр', 'english');
INSERT INTO emkt_regions VALUES(1805, 108, 'MA', 'Маңғыстау', 'english');
INSERT INTO emkt_regions VALUES(1806, 108, 'ON', 'Оңтүстік Қазақстан', 'english');
INSERT INTO emkt_regions VALUES(1807, 108, 'PA', 'Павлодар', 'english');
INSERT INTO emkt_regions VALUES(1808, 108, 'QA', 'Қарағанды', 'english');
INSERT INTO emkt_regions VALUES(1809, 108, 'QO', 'Қостанай', 'english');
INSERT INTO emkt_regions VALUES(1810, 108, 'QY', 'Қызылорда', 'english');
INSERT INTO emkt_regions VALUES(1811, 108, 'SH', 'Шығыс Қазақстан', 'english');
INSERT INTO emkt_regions VALUES(1812, 108, 'SO', 'Солтүстік Қазақстан', 'english');
INSERT INTO emkt_regions VALUES(1813, 108, 'ZH', 'Жамбыл', 'english');

INSERT INTO emkt_countries VALUES (109,'Kenya','english','KE','KEN','');

INSERT INTO emkt_regions VALUES(1814, 109, '110', 'Nairobi', 'english');
INSERT INTO emkt_regions VALUES(1815, 109, '200', 'Central', 'english');
INSERT INTO emkt_regions VALUES(1816, 109, '300', 'Mombasa', 'english');
INSERT INTO emkt_regions VALUES(1817, 109, '400', 'Eastern', 'english');
INSERT INTO emkt_regions VALUES(1818, 109, '500', 'North Eastern', 'english');
INSERT INTO emkt_regions VALUES(1819, 109, '600', 'Nyanza', 'english');
INSERT INTO emkt_regions VALUES(1820, 109, '700', 'Rift Valley', 'english');
INSERT INTO emkt_regions VALUES(1821, 109, '900', 'Western', 'english');

INSERT INTO emkt_countries VALUES (110,'Kiribati','english','KI','KIR','');

INSERT INTO emkt_regions VALUES(1822, 110, 'G', 'Gilbert Islands', 'english');
INSERT INTO emkt_regions VALUES(1823, 110, 'L', 'Line Islands', 'english');
INSERT INTO emkt_regions VALUES(1824, 110, 'P', 'Phoenix Islands', 'english');

INSERT INTO emkt_countries VALUES (111,'Korea, North','english','KP','PRK','');

INSERT INTO emkt_regions VALUES(1825, 111, 'CHA', '자강도', 'english');
INSERT INTO emkt_regions VALUES(1826, 111, 'HAB', '함경 북도', 'english');
INSERT INTO emkt_regions VALUES(1827, 111, 'HAN', '함경 남도', 'english');
INSERT INTO emkt_regions VALUES(1828, 111, 'HWB', '황해 북도', 'english');
INSERT INTO emkt_regions VALUES(1829, 111, 'HWN', '황해 남도', 'english');
INSERT INTO emkt_regions VALUES(1830, 111, 'KAN', '강원도', 'english');
INSERT INTO emkt_regions VALUES(1831, 111, 'KAE', '개성시', 'english');
INSERT INTO emkt_regions VALUES(1832, 111, 'NAJ', '라선 직할시', 'english');
INSERT INTO emkt_regions VALUES(1833, 111, 'NAM', '남포 특급시', 'english');
INSERT INTO emkt_regions VALUES(1834, 111, 'PYB', '평안 북도', 'english');
INSERT INTO emkt_regions VALUES(1835, 111, 'PYN', '평안 남도', 'english');
INSERT INTO emkt_regions VALUES(1836, 111, 'PYO', '평양 직할시', 'english');
INSERT INTO emkt_regions VALUES(1837, 111, 'YAN', '량강도', 'english');

INSERT INTO emkt_countries VALUES (112,'Korea, South','english','KR','KOR','');

INSERT INTO emkt_regions VALUES(1838, 112, '11', '서울특별시', 'english');
INSERT INTO emkt_regions VALUES(1839, 112, '26', '부산 광역시', 'english');
INSERT INTO emkt_regions VALUES(1840, 112, '27', '대구 광역시', 'english');
INSERT INTO emkt_regions VALUES(1841, 112, '28', '인천광역시', 'english');
INSERT INTO emkt_regions VALUES(1842, 112, '29', '광주 광역시', 'english');
INSERT INTO emkt_regions VALUES(1843, 112, '30', '대전 광역시', 'english');
INSERT INTO emkt_regions VALUES(1844, 112, '31', '울산 광역시', 'english');
INSERT INTO emkt_regions VALUES(1845, 112, '41', '경기도', 'english');
INSERT INTO emkt_regions VALUES(1846, 112, '42', '강원도', 'english');
INSERT INTO emkt_regions VALUES(1847, 112, '43', '충청 북도', 'english');
INSERT INTO emkt_regions VALUES(1848, 112, '44', '충청 남도', 'english');
INSERT INTO emkt_regions VALUES(1849, 112, '45', '전라 북도', 'english');
INSERT INTO emkt_regions VALUES(1850, 112, '46', '전라 남도', 'english');
INSERT INTO emkt_regions VALUES(1851, 112, '47', '경상 북도', 'english');
INSERT INTO emkt_regions VALUES(1852, 112, '48', '경상 남도', 'english');
INSERT INTO emkt_regions VALUES(1853, 112, '49', '제주특별자치도', 'english');

INSERT INTO emkt_countries VALUES (113,'Kuwait','english','KW','KWT','');

INSERT INTO emkt_regions VALUES(1854, 113, 'AH', 'الاحمدي', 'english');
INSERT INTO emkt_regions VALUES(1855, 113, 'FA', 'الفروانية', 'english');
INSERT INTO emkt_regions VALUES(1856, 113, 'JA', 'الجهراء', 'english');
INSERT INTO emkt_regions VALUES(1857, 113, 'KU', 'ألعاصمه', 'english');
INSERT INTO emkt_regions VALUES(1858, 113, 'HW', 'حولي', 'english');
INSERT INTO emkt_regions VALUES(1859, 113, 'MU', 'مبارك الكبير', 'english');

INSERT INTO emkt_countries VALUES (114,'Kyrgyzstan','english','KG','KGZ','');

INSERT INTO emkt_regions VALUES(1860, 114, 'B', 'Баткен областы', 'english');
INSERT INTO emkt_regions VALUES(1861, 114, 'C', 'Чүй областы', 'english');
INSERT INTO emkt_regions VALUES(1862, 114, 'GB', 'Бишкек', 'english');
INSERT INTO emkt_regions VALUES(1863, 114, 'J', 'Жалал-Абад областы', 'english');
INSERT INTO emkt_regions VALUES(1864, 114, 'N', 'Нарын областы', 'english');
INSERT INTO emkt_regions VALUES(1865, 114, 'O', 'Ош областы', 'english');
INSERT INTO emkt_regions VALUES(1866, 114, 'T', 'Талас областы', 'english');
INSERT INTO emkt_regions VALUES(1867, 114, 'Y', 'Ысык-Көл областы', 'english');

INSERT INTO emkt_countries VALUES (115,'Laos','english','LA','LAO','');

INSERT INTO emkt_regions VALUES(1868, 115, 'AT', 'ອັດຕະປື', 'english');
INSERT INTO emkt_regions VALUES(1869, 115, 'BK', 'ບໍ່ແກ້ວ', 'english');
INSERT INTO emkt_regions VALUES(1870, 115, 'BL', 'ບໍລິຄໍາໄຊ', 'english');
INSERT INTO emkt_regions VALUES(1871, 115, 'CH', 'ຈໍາປາສັກ', 'english');
INSERT INTO emkt_regions VALUES(1872, 115, 'HO', 'ຫົວພັນ', 'english');
INSERT INTO emkt_regions VALUES(1873, 115, 'KH', 'ຄໍາມ່ວນ', 'english');
INSERT INTO emkt_regions VALUES(1874, 115, 'LM', 'ຫລວງນໍ້າທາ', 'english');
INSERT INTO emkt_regions VALUES(1875, 115, 'LP', 'ຫລວງພະບາງ', 'english');
INSERT INTO emkt_regions VALUES(1876, 115, 'OU', 'ອຸດົມໄຊ', 'english');
INSERT INTO emkt_regions VALUES(1877, 115, 'PH', 'ຜົງສາລີ', 'english');
INSERT INTO emkt_regions VALUES(1878, 115, 'SL', 'ສາລະວັນ', 'english');
INSERT INTO emkt_regions VALUES(1879, 115, 'SV', 'ສະຫວັນນະເຂດ', 'english');
INSERT INTO emkt_regions VALUES(1880, 115, 'VI', 'ວຽງຈັນ', 'english');
INSERT INTO emkt_regions VALUES(1881, 115, 'VT', 'ວຽງຈັນ', 'english');
INSERT INTO emkt_regions VALUES(1882, 115, 'XA', 'ໄຊຍະບູລີ', 'english');
INSERT INTO emkt_regions VALUES(1883, 115, 'XE', 'ເຊກອງ', 'english');
INSERT INTO emkt_regions VALUES(1884, 115, 'XI', 'ຊຽງຂວາງ', 'english');
INSERT INTO emkt_regions VALUES(1885, 115, 'XN', 'ໄຊສົມບູນ', 'english');

INSERT INTO emkt_countries VALUES (116,'Latvia','english','LV','LVA','');

INSERT INTO emkt_regions VALUES(1886, 116, 'AI', 'Aizkraukles rajons', 'english');
INSERT INTO emkt_regions VALUES(1887, 116, 'AL', 'Alūksnes rajons', 'english');
INSERT INTO emkt_regions VALUES(1888, 116, 'BL', 'Balvu rajons', 'english');
INSERT INTO emkt_regions VALUES(1889, 116, 'BU', 'Bauskas rajons', 'english');
INSERT INTO emkt_regions VALUES(1890, 116, 'CE', 'Cēsu rajons', 'english');
INSERT INTO emkt_regions VALUES(1891, 116, 'DA', 'Daugavpils rajons', 'english');
INSERT INTO emkt_regions VALUES(1892, 116, 'DGV', 'Daugpilis', 'english');
INSERT INTO emkt_regions VALUES(1893, 116, 'DO', 'Dobeles rajons', 'english');
INSERT INTO emkt_regions VALUES(1894, 116, 'GU', 'Gulbenes rajons', 'english');
INSERT INTO emkt_regions VALUES(1895, 116, 'JEL', 'Jelgava', 'english');
INSERT INTO emkt_regions VALUES(1896, 116, 'JK', 'Jēkabpils rajons', 'english');
INSERT INTO emkt_regions VALUES(1897, 116, 'JL', 'Jelgavas rajons', 'english');
INSERT INTO emkt_regions VALUES(1898, 116, 'JUR', 'Jūrmala', 'english');
INSERT INTO emkt_regions VALUES(1899, 116, 'KR', 'Krāslavas rajons', 'english');
INSERT INTO emkt_regions VALUES(1900, 116, 'KU', 'Kuldīgas rajons', 'english');
INSERT INTO emkt_regions VALUES(1901, 116, 'LE', 'Liepājas rajons', 'english');
INSERT INTO emkt_regions VALUES(1902, 116, 'LM', 'Limbažu rajons', 'english');
INSERT INTO emkt_regions VALUES(1903, 116, 'LPX', 'Liepoja', 'english');
INSERT INTO emkt_regions VALUES(1904, 116, 'LU', 'Ludzas rajons', 'english');
INSERT INTO emkt_regions VALUES(1905, 116, 'MA', 'Madonas rajons', 'english');
INSERT INTO emkt_regions VALUES(1906, 116, 'OG', 'Ogres rajons', 'english');
INSERT INTO emkt_regions VALUES(1907, 116, 'PR', 'Preiļu rajons', 'english');
INSERT INTO emkt_regions VALUES(1908, 116, 'RE', 'Rēzeknes rajons', 'english');
INSERT INTO emkt_regions VALUES(1909, 116, 'REZ', 'Rēzekne', 'english');
INSERT INTO emkt_regions VALUES(1910, 116, 'RI', 'Rīgas rajons', 'english');
INSERT INTO emkt_regions VALUES(1911, 116, 'RIX', 'Rīga', 'english');
INSERT INTO emkt_regions VALUES(1912, 116, 'SA', 'Saldus rajons', 'english');
INSERT INTO emkt_regions VALUES(1913, 116, 'TA', 'Talsu rajons', 'english');
INSERT INTO emkt_regions VALUES(1914, 116, 'TU', 'Tukuma rajons', 'english');
INSERT INTO emkt_regions VALUES(1915, 116, 'VE', 'Ventspils rajons', 'english');
INSERT INTO emkt_regions VALUES(1916, 116, 'VEN', 'Ventspils', 'english');
INSERT INTO emkt_regions VALUES(1917, 116, 'VK', 'Valkas rajons', 'english');
INSERT INTO emkt_regions VALUES(1918, 116, 'VM', 'Valmieras rajons', 'english');

INSERT INTO emkt_countries VALUES (117,'Lebanon','english','LB','LBN','');

INSERT INTO emkt_regions VALUES(4263, 117, 'NOCODE', 'Lebanon', 'english');

INSERT INTO emkt_countries VALUES (118,'Lesotho','english','LS','LSO','');

INSERT INTO emkt_regions VALUES(1919, 118, 'A', 'Maseru', 'english');
INSERT INTO emkt_regions VALUES(1920, 118, 'B', 'Butha-Buthe', 'english');
INSERT INTO emkt_regions VALUES(1921, 118, 'C', 'Leribe', 'english');
INSERT INTO emkt_regions VALUES(1922, 118, 'D', 'Berea', 'english');
INSERT INTO emkt_regions VALUES(1923, 118, 'E', 'Mafeteng', 'english');
INSERT INTO emkt_regions VALUES(1924, 118, 'F', 'Mohale\'s Hoek', 'english');
INSERT INTO emkt_regions VALUES(1925, 118, 'G', 'Quthing', 'english');
INSERT INTO emkt_regions VALUES(1926, 118, 'H', 'Qacha\'s Nek', 'english');
INSERT INTO emkt_regions VALUES(1927, 118, 'J', 'Mokhotlong', 'english');
INSERT INTO emkt_regions VALUES(1928, 118, 'K', 'Thaba-Tseka', 'english');

INSERT INTO emkt_countries VALUES (119,'Liberia','english','LR','LBR','');

INSERT INTO emkt_regions VALUES(1929, 119, 'BG', 'Bong', 'english');
INSERT INTO emkt_regions VALUES(1930, 119, 'BM', 'Bomi', 'english');
INSERT INTO emkt_regions VALUES(1931, 119, 'CM', 'Grand Cape Mount', 'english');
INSERT INTO emkt_regions VALUES(1932, 119, 'GB', 'Grand Bassa', 'english');
INSERT INTO emkt_regions VALUES(1933, 119, 'GG', 'Grand Gedeh', 'english');
INSERT INTO emkt_regions VALUES(1934, 119, 'GK', 'Grand Kru', 'english');
INSERT INTO emkt_regions VALUES(1935, 119, 'GP', 'Gbarpolu', 'english');
INSERT INTO emkt_regions VALUES(1936, 119, 'LO', 'Lofa', 'english');
INSERT INTO emkt_regions VALUES(1937, 119, 'MG', 'Margibi', 'english');
INSERT INTO emkt_regions VALUES(1938, 119, 'MO', 'Montserrado', 'english');
INSERT INTO emkt_regions VALUES(1939, 119, 'MY', 'Maryland', 'english');
INSERT INTO emkt_regions VALUES(1940, 119, 'NI', 'Nimba', 'english');
INSERT INTO emkt_regions VALUES(1941, 119, 'RG', 'River Gee', 'english');
INSERT INTO emkt_regions VALUES(1942, 119, 'RI', 'Rivercess', 'english');
INSERT INTO emkt_regions VALUES(1943, 119, 'SI', 'Sinoe', 'english');

INSERT INTO emkt_countries VALUES (120,'Libyan Arab Jamahiriya','english','LY','LBY','');

INSERT INTO emkt_regions VALUES(1944, 120, 'AJ', 'Ajdābiyā', 'english');
INSERT INTO emkt_regions VALUES(1945, 120, 'BA', 'Banghāzī', 'english');
INSERT INTO emkt_regions VALUES(1946, 120, 'BU', 'Al Buţnān', 'english');
INSERT INTO emkt_regions VALUES(1947, 120, 'BW', 'Banī Walīd', 'english');
INSERT INTO emkt_regions VALUES(1948, 120, 'DR', 'Darnah', 'english');
INSERT INTO emkt_regions VALUES(1949, 120, 'GD', 'Ghadāmis', 'english');
INSERT INTO emkt_regions VALUES(1950, 120, 'GR', 'Gharyān', 'english');
INSERT INTO emkt_regions VALUES(1951, 120, 'GT', 'Ghāt', 'english');
INSERT INTO emkt_regions VALUES(1952, 120, 'HZ', 'Al Ḩizām al Akhḑar', 'english');
INSERT INTO emkt_regions VALUES(1953, 120, 'JA', 'Al Jabal al Akhḑar', 'english');
INSERT INTO emkt_regions VALUES(1954, 120, 'JB', 'Jaghbūb', 'english');
INSERT INTO emkt_regions VALUES(1955, 120, 'JI', 'Al Jifārah', 'english');
INSERT INTO emkt_regions VALUES(1956, 120, 'JU', 'Al Jufrah', 'english');
INSERT INTO emkt_regions VALUES(1957, 120, 'KF', 'Al Kufrah', 'english');
INSERT INTO emkt_regions VALUES(1958, 120, 'MB', 'Al Marqab', 'english');
INSERT INTO emkt_regions VALUES(1959, 120, 'MI', 'Mişrātah', 'english');
INSERT INTO emkt_regions VALUES(1960, 120, 'MJ', 'Al Marj', 'english');
INSERT INTO emkt_regions VALUES(1961, 120, 'MQ', 'Murzuq', 'english');
INSERT INTO emkt_regions VALUES(1962, 120, 'MZ', 'Mizdah', 'english');
INSERT INTO emkt_regions VALUES(1963, 120, 'NL', 'Nālūt', 'english');
INSERT INTO emkt_regions VALUES(1964, 120, 'NQ', 'An Nuqaţ al Khams', 'english');
INSERT INTO emkt_regions VALUES(1965, 120, 'QB', 'Al Qubbah', 'english');
INSERT INTO emkt_regions VALUES(1966, 120, 'QT', 'Al Qaţrūn', 'english');
INSERT INTO emkt_regions VALUES(1967, 120, 'SB', 'Sabhā', 'english');
INSERT INTO emkt_regions VALUES(1968, 120, 'SH', 'Ash Shāţi', 'english');
INSERT INTO emkt_regions VALUES(1969, 120, 'SR', 'Surt', 'english');
INSERT INTO emkt_regions VALUES(1970, 120, 'SS', 'Şabrātah Şurmān', 'english');
INSERT INTO emkt_regions VALUES(1971, 120, 'TB', 'Ţarābulus', 'english');
INSERT INTO emkt_regions VALUES(1972, 120, 'TM', 'Tarhūnah-Masallātah', 'english');
INSERT INTO emkt_regions VALUES(1973, 120, 'TN', 'Tājūrā wa an Nawāḩī al Arbāʻ', 'english');
INSERT INTO emkt_regions VALUES(1974, 120, 'WA', 'Al Wāḩah', 'english');
INSERT INTO emkt_regions VALUES(1975, 120, 'WD', 'Wādī al Ḩayāt', 'english');
INSERT INTO emkt_regions VALUES(1976, 120, 'YJ', 'Yafran-Jādū', 'english');
INSERT INTO emkt_regions VALUES(1977, 120, 'ZA', 'Az Zāwiyah', 'english');

INSERT INTO emkt_countries VALUES (121,'Liechtenstein','english','LI','LIE','');

INSERT INTO emkt_regions VALUES(1978, 121, 'B', 'Balzers', 'english');
INSERT INTO emkt_regions VALUES(1979, 121, 'E', 'Eschen', 'english');
INSERT INTO emkt_regions VALUES(1980, 121, 'G', 'Gamprin', 'english');
INSERT INTO emkt_regions VALUES(1981, 121, 'M', 'Mauren', 'english');
INSERT INTO emkt_regions VALUES(1982, 121, 'P', 'Planken', 'english');
INSERT INTO emkt_regions VALUES(1983, 121, 'R', 'Ruggell', 'english');
INSERT INTO emkt_regions VALUES(1984, 121, 'A', 'Schaan', 'english');
INSERT INTO emkt_regions VALUES(1985, 121, 'L', 'Schellenberg', 'english');
INSERT INTO emkt_regions VALUES(1986, 121, 'N', 'Triesen', 'english');
INSERT INTO emkt_regions VALUES(1987, 121, 'T', 'Triesenberg', 'english');
INSERT INTO emkt_regions VALUES(1988, 121, 'V', 'Vaduz', 'english');

INSERT INTO emkt_countries VALUES (122,'Lithuania','english','LT','LTU','');

INSERT INTO emkt_regions VALUES(1989, 122, 'AL', 'Alytaus Apskritis', 'english');
INSERT INTO emkt_regions VALUES(1990, 122, 'KL', 'Klaipėdos Apskritis', 'english');
INSERT INTO emkt_regions VALUES(1991, 122, 'KU', 'Kauno Apskritis', 'english');
INSERT INTO emkt_regions VALUES(1992, 122, 'MR', 'Marijampolės Apskritis', 'english');
INSERT INTO emkt_regions VALUES(1993, 122, 'PN', 'Panevėžio Apskritis', 'english');
INSERT INTO emkt_regions VALUES(1994, 122, 'SA', 'Šiaulių Apskritis', 'english');
INSERT INTO emkt_regions VALUES(1995, 122, 'TA', 'Tauragės Apskritis', 'english');
INSERT INTO emkt_regions VALUES(1996, 122, 'TE', 'Telšių Apskritis', 'english');
INSERT INTO emkt_regions VALUES(1997, 122, 'UT', 'Utenos Apskritis', 'english');
INSERT INTO emkt_regions VALUES(1998, 122, 'VL', 'Vilniaus Apskritis', 'english');

INSERT INTO emkt_countries VALUES (123,'Luxembourg','english','LU','LUX','');

INSERT INTO emkt_regions VALUES(1999, 123, 'D', 'Diekirch', 'english');
INSERT INTO emkt_regions VALUES(2000, 123, 'G', 'Grevenmacher', 'english');
INSERT INTO emkt_regions VALUES(2001, 123, 'L', 'Luxemburg', 'english');

INSERT INTO emkt_countries VALUES (124,'Macau','english','MO','MAC','');

INSERT INTO emkt_regions VALUES(2002, 124, 'I', '海島市', 'english');
INSERT INTO emkt_regions VALUES(2003, 124, 'M', '澳門市', 'english');

INSERT INTO emkt_countries VALUES (125,'Macedonia','english','MK','MKD','');

INSERT INTO emkt_regions VALUES(2004, 125, 'BR', 'Berovo', 'english');
INSERT INTO emkt_regions VALUES(2005, 125, 'CH', 'Чешиново-Облешево', 'english');
INSERT INTO emkt_regions VALUES(2006, 125, 'DL', 'Делчево', 'english');
INSERT INTO emkt_regions VALUES(2007, 125, 'KB', 'Карбинци', 'english');
INSERT INTO emkt_regions VALUES(2008, 125, 'OC', 'Кочани', 'english');
INSERT INTO emkt_regions VALUES(2009, 125, 'LO', 'Лозово', 'english');
INSERT INTO emkt_regions VALUES(2010, 125, 'MK', 'Македонска каменица', 'english');
INSERT INTO emkt_regions VALUES(2011, 125, 'PH', 'Пехчево', 'english');
INSERT INTO emkt_regions VALUES(2012, 125, 'PT', 'Пробиштип', 'english');
INSERT INTO emkt_regions VALUES(2013, 125, 'ST', 'Штип', 'english');
INSERT INTO emkt_regions VALUES(2014, 125, 'SL', 'Свети Николе', 'english');
INSERT INTO emkt_regions VALUES(2015, 125, 'NI', 'Виница', 'english');
INSERT INTO emkt_regions VALUES(2016, 125, 'ZR', 'Зрновци', 'english');
INSERT INTO emkt_regions VALUES(2017, 125, 'KY', 'Кратово', 'english');
INSERT INTO emkt_regions VALUES(2018, 125, 'KZ', 'Крива Паланка', 'english');
INSERT INTO emkt_regions VALUES(2019, 125, 'UM', 'Куманово', 'english');
INSERT INTO emkt_regions VALUES(2020, 125, 'LI', 'Липково', 'english');
INSERT INTO emkt_regions VALUES(2021, 125, 'RN', 'Ранковце', 'english');
INSERT INTO emkt_regions VALUES(2022, 125, 'NA', 'Старо Нагоричане', 'english');
INSERT INTO emkt_regions VALUES(2023, 125, 'TL', 'Битола', 'english');
INSERT INTO emkt_regions VALUES(2024, 125, 'DM', 'Демир Хисар', 'english');
INSERT INTO emkt_regions VALUES(2025, 125, 'DE', 'Долнени', 'english');
INSERT INTO emkt_regions VALUES(2026, 125, 'KG', 'Кривогаштани', 'english');
INSERT INTO emkt_regions VALUES(2027, 125, 'KS', 'Крушево', 'english');
INSERT INTO emkt_regions VALUES(2028, 125, 'MG', 'Могила', 'english');
INSERT INTO emkt_regions VALUES(2029, 125, 'NV', 'Новаци', 'english');
INSERT INTO emkt_regions VALUES(2030, 125, 'PP', 'Прилеп', 'english');
INSERT INTO emkt_regions VALUES(2031, 125, 'RE', 'Ресен', 'english');
INSERT INTO emkt_regions VALUES(2032, 125, 'VJ', 'Боговиње', 'english');
INSERT INTO emkt_regions VALUES(2033, 125, 'BN', 'Брвеница', 'english');
INSERT INTO emkt_regions VALUES(2034, 125, 'GT', 'Гостивар', 'english');
INSERT INTO emkt_regions VALUES(2035, 125, 'JG', 'Јегуновце', 'english');
INSERT INTO emkt_regions VALUES(2036, 125, 'MR', 'Маврово и Ростуша', 'english');
INSERT INTO emkt_regions VALUES(2037, 125, 'TR', 'Теарце', 'english');
INSERT INTO emkt_regions VALUES(2038, 125, 'ET', 'Тетово', 'english');
INSERT INTO emkt_regions VALUES(2039, 125, 'VH', 'Врапчиште', 'english');
INSERT INTO emkt_regions VALUES(2040, 125, 'ZE', 'Желино', 'english');
INSERT INTO emkt_regions VALUES(2041, 125, 'AD', 'Аеродром', 'english');
INSERT INTO emkt_regions VALUES(2042, 125, 'AR', 'Арачиново', 'english');
INSERT INTO emkt_regions VALUES(2043, 125, 'BU', 'Бутел', 'english');
INSERT INTO emkt_regions VALUES(2044, 125, 'CI', 'Чаир', 'english');
INSERT INTO emkt_regions VALUES(2045, 125, 'CE', 'Центар', 'english');
INSERT INTO emkt_regions VALUES(2046, 125, 'CS', 'Чучер Сандево', 'english');
INSERT INTO emkt_regions VALUES(2047, 125, 'GB', 'Гази Баба', 'english');
INSERT INTO emkt_regions VALUES(2048, 125, 'GP', 'Ѓорче Петров', 'english');
INSERT INTO emkt_regions VALUES(2049, 125, 'IL', 'Илинден', 'english');
INSERT INTO emkt_regions VALUES(2050, 125, 'KX', 'Карпош', 'english');
INSERT INTO emkt_regions VALUES(2051, 125, 'VD', 'Кисела Вода', 'english');
INSERT INTO emkt_regions VALUES(2052, 125, 'PE', 'Петровец', 'english');
INSERT INTO emkt_regions VALUES(2053, 125, 'AJ', 'Сарај', 'english');
INSERT INTO emkt_regions VALUES(2054, 125, 'SS', 'Сопиште', 'english');
INSERT INTO emkt_regions VALUES(2055, 125, 'SU', 'Студеничани', 'english');
INSERT INTO emkt_regions VALUES(2056, 125, 'SO', 'Шуто Оризари', 'english');
INSERT INTO emkt_regions VALUES(2057, 125, 'ZK', 'Зелениково', 'english');
INSERT INTO emkt_regions VALUES(2058, 125, 'BG', 'Богданци', 'english');
INSERT INTO emkt_regions VALUES(2059, 125, 'BS', 'Босилово', 'english');
INSERT INTO emkt_regions VALUES(2060, 125, 'GV', 'Гевгелија', 'english');
INSERT INTO emkt_regions VALUES(2061, 125, 'KN', 'Конче', 'english');
INSERT INTO emkt_regions VALUES(2062, 125, 'NS', 'Ново Село', 'english');
INSERT INTO emkt_regions VALUES(2063, 125, 'RV', 'Радовиш', 'english');
INSERT INTO emkt_regions VALUES(2064, 125, 'SD', 'Стар Дојран', 'english');
INSERT INTO emkt_regions VALUES(2065, 125, 'RU', 'Струмица', 'english');
INSERT INTO emkt_regions VALUES(2066, 125, 'VA', 'Валандово', 'english');
INSERT INTO emkt_regions VALUES(2067, 125, 'VL', 'Василево', 'english');
INSERT INTO emkt_regions VALUES(2068, 125, 'CZ', 'Центар Жупа', 'english');
INSERT INTO emkt_regions VALUES(2069, 125, 'DB', 'Дебар', 'english');
INSERT INTO emkt_regions VALUES(2070, 125, 'DA', 'Дебарца', 'english');
INSERT INTO emkt_regions VALUES(2071, 125, 'DR', 'Другово', 'english');
INSERT INTO emkt_regions VALUES(2072, 125, 'KH', 'Кичево', 'english');
INSERT INTO emkt_regions VALUES(2073, 125, 'MD', 'Македонски Брод', 'english');
INSERT INTO emkt_regions VALUES(2074, 125, 'OD', 'Охрид', 'english');
INSERT INTO emkt_regions VALUES(2075, 125, 'OS', 'Осломеј', 'english');
INSERT INTO emkt_regions VALUES(2076, 125, 'PN', 'Пласница', 'english');
INSERT INTO emkt_regions VALUES(2077, 125, 'UG', 'Струга', 'english');
INSERT INTO emkt_regions VALUES(2078, 125, 'VV', 'Вевчани', 'english');
INSERT INTO emkt_regions VALUES(2079, 125, 'VC', 'Вранештица', 'english');
INSERT INTO emkt_regions VALUES(2080, 125, 'ZA', 'Зајас', 'english');
INSERT INTO emkt_regions VALUES(2081, 125, 'CA', 'Чашка', 'english');
INSERT INTO emkt_regions VALUES(2082, 125, 'DK', 'Демир Капија', 'english');
INSERT INTO emkt_regions VALUES(2083, 125, 'GR', 'Градско', 'english');
INSERT INTO emkt_regions VALUES(2084, 125, 'AV', 'Кавадарци', 'english');
INSERT INTO emkt_regions VALUES(2085, 125, 'NG', 'Неготино', 'english');
INSERT INTO emkt_regions VALUES(2086, 125, 'RM', 'Росоман', 'english');
INSERT INTO emkt_regions VALUES(2087, 125, 'VE', 'Велес', 'english');

INSERT INTO emkt_countries VALUES (126,'Madagascar','english','MG','MDG','');

INSERT INTO emkt_regions VALUES(2088, 126, 'A', 'Toamasina', 'english');
INSERT INTO emkt_regions VALUES(2089, 126, 'D', 'Antsiranana', 'english');
INSERT INTO emkt_regions VALUES(2090, 126, 'F', 'Fianarantsoa', 'english');
INSERT INTO emkt_regions VALUES(2091, 126, 'M', 'Mahajanga', 'english');
INSERT INTO emkt_regions VALUES(2092, 126, 'T', 'Antananarivo', 'english');
INSERT INTO emkt_regions VALUES(2093, 126, 'U', 'Toliara', 'english');

INSERT INTO emkt_countries VALUES (127,'Malawi','english','MW','MWI','');

INSERT INTO emkt_regions VALUES(2094, 127, 'BA', 'Balaka', 'english');
INSERT INTO emkt_regions VALUES(2095, 127, 'BL', 'Blantyre', 'english');
INSERT INTO emkt_regions VALUES(2096, 127, 'C', 'Central', 'english');
INSERT INTO emkt_regions VALUES(2097, 127, 'CK', 'Chikwawa', 'english');
INSERT INTO emkt_regions VALUES(2098, 127, 'CR', 'Chiradzulu', 'english');
INSERT INTO emkt_regions VALUES(2099, 127, 'CT', 'Chitipa', 'english');
INSERT INTO emkt_regions VALUES(2100, 127, 'DE', 'Dedza', 'english');
INSERT INTO emkt_regions VALUES(2101, 127, 'DO', 'Dowa', 'english');
INSERT INTO emkt_regions VALUES(2102, 127, 'KR', 'Karonga', 'english');
INSERT INTO emkt_regions VALUES(2103, 127, 'KS', 'Kasungu', 'english');
INSERT INTO emkt_regions VALUES(2104, 127, 'LK', 'Likoma Island', 'english');
INSERT INTO emkt_regions VALUES(2105, 127, 'LI', 'Lilongwe', 'english');
INSERT INTO emkt_regions VALUES(2106, 127, 'MH', 'Machinga', 'english');
INSERT INTO emkt_regions VALUES(2107, 127, 'MG', 'Mangochi', 'english');
INSERT INTO emkt_regions VALUES(2108, 127, 'MC', 'Mchinji', 'english');
INSERT INTO emkt_regions VALUES(2109, 127, 'MU', 'Mulanje', 'english');
INSERT INTO emkt_regions VALUES(2110, 127, 'MW', 'Mwanza', 'english');
INSERT INTO emkt_regions VALUES(2111, 127, 'MZ', 'Mzimba', 'english');
INSERT INTO emkt_regions VALUES(2112, 127, 'N', 'Northern', 'english');
INSERT INTO emkt_regions VALUES(2113, 127, 'NB', 'Nkhata', 'english');
INSERT INTO emkt_regions VALUES(2114, 127, 'NK', 'Nkhotakota', 'english');
INSERT INTO emkt_regions VALUES(2115, 127, 'NS', 'Nsanje', 'english');
INSERT INTO emkt_regions VALUES(2116, 127, 'NU', 'Ntcheu', 'english');
INSERT INTO emkt_regions VALUES(2117, 127, 'NI', 'Ntchisi', 'english');
INSERT INTO emkt_regions VALUES(2118, 127, 'PH', 'Phalombe', 'english');
INSERT INTO emkt_regions VALUES(2119, 127, 'RU', 'Rumphi', 'english');
INSERT INTO emkt_regions VALUES(2120, 127, 'S', 'Southern', 'english');
INSERT INTO emkt_regions VALUES(2121, 127, 'SA', 'Salima', 'english');
INSERT INTO emkt_regions VALUES(2122, 127, 'TH', 'Thyolo', 'english');
INSERT INTO emkt_regions VALUES(2123, 127, 'ZO', 'Zomba', 'english');

INSERT INTO emkt_countries VALUES (128,'Malaysia','english','MY','MYS','');

INSERT INTO emkt_regions VALUES(2124, 128, '01', 'Johor Darul Takzim', 'english');
INSERT INTO emkt_regions VALUES(2125, 128, '02', 'Kedah Darul Aman', 'english');
INSERT INTO emkt_regions VALUES(2126, 128, '03', 'Kelantan Darul Naim', 'english');
INSERT INTO emkt_regions VALUES(2127, 128, '04', 'Melaka Negeri Bersejarah', 'english');
INSERT INTO emkt_regions VALUES(2128, 128, '05', 'Negeri Sembilan Darul Khusus', 'english');
INSERT INTO emkt_regions VALUES(2129, 128, '06', 'Pahang Darul Makmur', 'english');
INSERT INTO emkt_regions VALUES(2130, 128, '07', 'Pulau Pinang', 'english');
INSERT INTO emkt_regions VALUES(2131, 128, '08', 'Perak Darul Ridzuan', 'english');
INSERT INTO emkt_regions VALUES(2132, 128, '09', 'Perlis Indera Kayangan', 'english');
INSERT INTO emkt_regions VALUES(2133, 128, '10', 'Selangor Darul Ehsan', 'english');
INSERT INTO emkt_regions VALUES(2134, 128, '11', 'Terengganu Darul Iman', 'english');
INSERT INTO emkt_regions VALUES(2135, 128, '12', 'Sabah Negeri Di Bawah Bayu', 'english');
INSERT INTO emkt_regions VALUES(2136, 128, '13', 'Sarawak Bumi Kenyalang', 'english');
INSERT INTO emkt_regions VALUES(2137, 128, '14', 'Wilayah Persekutuan Kuala Lumpur', 'english');
INSERT INTO emkt_regions VALUES(2138, 128, '15', 'Wilayah Persekutuan Labuan', 'english');
INSERT INTO emkt_regions VALUES(2139, 128, '16', 'Wilayah Persekutuan Putrajaya', 'english');

INSERT INTO emkt_countries VALUES (129,'Maldives','english','MV','MDV','');

INSERT INTO emkt_regions VALUES(2140, 129, 'THU', 'Thiladhunmathi Uthuru', 'english');
INSERT INTO emkt_regions VALUES(2141, 129, 'THD', 'Thiladhunmathi Dhekunu', 'english');
INSERT INTO emkt_regions VALUES(2142, 129, 'MLU', 'Miladhunmadulu Uthuru', 'english');
INSERT INTO emkt_regions VALUES(2143, 129, 'MLD', 'Miladhunmadulu Dhekunu', 'english');
INSERT INTO emkt_regions VALUES(2144, 129, 'MAU', 'Maalhosmadulu Uthuru', 'english');
INSERT INTO emkt_regions VALUES(2145, 129, 'MAD', 'Maalhosmadulu Dhekunu', 'english');
INSERT INTO emkt_regions VALUES(2146, 129, 'FAA', 'Faadhippolhu', 'english');
INSERT INTO emkt_regions VALUES(2147, 129, 'MAA', 'Male Atoll', 'english');
INSERT INTO emkt_regions VALUES(2148, 129, 'AAU', 'Ari Atoll Uthuru', 'english');
INSERT INTO emkt_regions VALUES(2149, 129, 'AAD', 'Ari Atoll Dheknu', 'english');
INSERT INTO emkt_regions VALUES(2150, 129, 'FEA', 'Felidhe Atoll', 'english');
INSERT INTO emkt_regions VALUES(2151, 129, 'MUA', 'Mulaku Atoll', 'english');
INSERT INTO emkt_regions VALUES(2152, 129, 'NAU', 'Nilandhe Atoll Uthuru', 'english');
INSERT INTO emkt_regions VALUES(2153, 129, 'NAD', 'Nilandhe Atoll Dhekunu', 'english');
INSERT INTO emkt_regions VALUES(2154, 129, 'KLH', 'Kolhumadulu', 'english');
INSERT INTO emkt_regions VALUES(2155, 129, 'HDH', 'Hadhdhunmathi', 'english');
INSERT INTO emkt_regions VALUES(2156, 129, 'HAU', 'Huvadhu Atoll Uthuru', 'english');
INSERT INTO emkt_regions VALUES(2157, 129, 'HAD', 'Huvadhu Atoll Dhekunu', 'english');
INSERT INTO emkt_regions VALUES(2158, 129, 'FMU', 'Fua Mulaku', 'english');
INSERT INTO emkt_regions VALUES(2159, 129, 'ADD', 'Addu', 'english');

INSERT INTO emkt_countries VALUES (130,'Mali','english','ML','MLI','');

INSERT INTO emkt_regions VALUES(2160, 130, '1', 'Kayes', 'english');
INSERT INTO emkt_regions VALUES(2161, 130, '2', 'Koulikoro', 'english');
INSERT INTO emkt_regions VALUES(2162, 130, '3', 'Sikasso', 'english');
INSERT INTO emkt_regions VALUES(2163, 130, '4', 'Ségou', 'english');
INSERT INTO emkt_regions VALUES(2164, 130, '5', 'Mopti', 'english');
INSERT INTO emkt_regions VALUES(2165, 130, '6', 'Tombouctou', 'english');
INSERT INTO emkt_regions VALUES(2166, 130, '7', 'Gao', 'english');
INSERT INTO emkt_regions VALUES(2167, 130, '8', 'Kidal', 'english');
INSERT INTO emkt_regions VALUES(2168, 130, 'BK0', 'Bamako', 'english');

INSERT INTO emkt_countries VALUES (131,'Malta','english','MT','MLT','');

INSERT INTO emkt_regions VALUES(2169, 131, 'ATT', 'Attard', 'english');
INSERT INTO emkt_regions VALUES(2170, 131, 'BAL', 'Balzan', 'english');
INSERT INTO emkt_regions VALUES(2171, 131, 'BGU', 'Birgu', 'english');
INSERT INTO emkt_regions VALUES(2172, 131, 'BKK', 'Birkirkara', 'english');
INSERT INTO emkt_regions VALUES(2173, 131, 'BRZ', 'Birzebbuga', 'english');
INSERT INTO emkt_regions VALUES(2174, 131, 'BOR', 'Bormla', 'english');
INSERT INTO emkt_regions VALUES(2175, 131, 'DIN', 'Dingli', 'english');
INSERT INTO emkt_regions VALUES(2176, 131, 'FGU', 'Fgura', 'english');
INSERT INTO emkt_regions VALUES(2177, 131, 'FLO', 'Floriana', 'english');
INSERT INTO emkt_regions VALUES(2178, 131, 'GDJ', 'Gudja', 'english');
INSERT INTO emkt_regions VALUES(2179, 131, 'GZR', 'Gzira', 'english');
INSERT INTO emkt_regions VALUES(2180, 131, 'GRG', 'Gargur', 'english');
INSERT INTO emkt_regions VALUES(2181, 131, 'GXQ', 'Gaxaq', 'english');
INSERT INTO emkt_regions VALUES(2182, 131, 'HMR', 'Hamrun', 'english');
INSERT INTO emkt_regions VALUES(2183, 131, 'IKL', 'Iklin', 'english');
INSERT INTO emkt_regions VALUES(2184, 131, 'ISL', 'Isla', 'english');
INSERT INTO emkt_regions VALUES(2185, 131, 'KLK', 'Kalkara', 'english');
INSERT INTO emkt_regions VALUES(2186, 131, 'KRK', 'Kirkop', 'english');
INSERT INTO emkt_regions VALUES(2187, 131, 'LIJ', 'Lija', 'english');
INSERT INTO emkt_regions VALUES(2188, 131, 'LUQ', 'Luqa', 'english');
INSERT INTO emkt_regions VALUES(2189, 131, 'MRS', 'Marsa', 'english');
INSERT INTO emkt_regions VALUES(2190, 131, 'MKL', 'Marsaskala', 'english');
INSERT INTO emkt_regions VALUES(2191, 131, 'MXL', 'Marsaxlokk', 'english');
INSERT INTO emkt_regions VALUES(2192, 131, 'MDN', 'Mdina', 'english');
INSERT INTO emkt_regions VALUES(2193, 131, 'MEL', 'Melliea', 'english');
INSERT INTO emkt_regions VALUES(2194, 131, 'MGR', 'Mgarr', 'english');
INSERT INTO emkt_regions VALUES(2195, 131, 'MST', 'Mosta', 'english');
INSERT INTO emkt_regions VALUES(2196, 131, 'MQA', 'Mqabba', 'english');
INSERT INTO emkt_regions VALUES(2197, 131, 'MSI', 'Msida', 'english');
INSERT INTO emkt_regions VALUES(2198, 131, 'MTF', 'Mtarfa', 'english');
INSERT INTO emkt_regions VALUES(2199, 131, 'NAX', 'Naxxar', 'english');
INSERT INTO emkt_regions VALUES(2200, 131, 'PAO', 'Paola', 'english');
INSERT INTO emkt_regions VALUES(2201, 131, 'PEM', 'Pembroke', 'english');
INSERT INTO emkt_regions VALUES(2202, 131, 'PIE', 'Pieta', 'english');
INSERT INTO emkt_regions VALUES(2203, 131, 'QOR', 'Qormi', 'english');
INSERT INTO emkt_regions VALUES(2204, 131, 'QRE', 'Qrendi', 'english');
INSERT INTO emkt_regions VALUES(2205, 131, 'RAB', 'Rabat', 'english');
INSERT INTO emkt_regions VALUES(2206, 131, 'SAF', 'Safi', 'english');
INSERT INTO emkt_regions VALUES(2207, 131, 'SGI', 'San Giljan', 'english');
INSERT INTO emkt_regions VALUES(2208, 131, 'SLU', 'Santa Lucija', 'english');
INSERT INTO emkt_regions VALUES(2209, 131, 'SPB', 'San Pawl il-Bahar', 'english');
INSERT INTO emkt_regions VALUES(2210, 131, 'SGW', 'San Gwann', 'english');
INSERT INTO emkt_regions VALUES(2211, 131, 'SVE', 'Santa Venera', 'english');
INSERT INTO emkt_regions VALUES(2212, 131, 'SIG', 'Siggiewi', 'english');
INSERT INTO emkt_regions VALUES(2213, 131, 'SLM', 'Sliema', 'english');
INSERT INTO emkt_regions VALUES(2214, 131, 'SWQ', 'Swieqi', 'english');
INSERT INTO emkt_regions VALUES(2215, 131, 'TXB', 'Ta Xbiex', 'english');
INSERT INTO emkt_regions VALUES(2216, 131, 'TRX', 'Tarxien', 'english');
INSERT INTO emkt_regions VALUES(2217, 131, 'VLT', 'Valletta', 'english');
INSERT INTO emkt_regions VALUES(2218, 131, 'XGJ', 'Xgajra', 'english');
INSERT INTO emkt_regions VALUES(2219, 131, 'ZBR', 'Zabbar', 'english');
INSERT INTO emkt_regions VALUES(2220, 131, 'ZBG', 'Zebbug', 'english');
INSERT INTO emkt_regions VALUES(2221, 131, 'ZJT', 'Zejtun', 'english');
INSERT INTO emkt_regions VALUES(2222, 131, 'ZRQ', 'Zurrieq', 'english');
INSERT INTO emkt_regions VALUES(2223, 131, 'FNT', 'Fontana', 'english');
INSERT INTO emkt_regions VALUES(2224, 131, 'GHJ', 'Ghajnsielem', 'english');
INSERT INTO emkt_regions VALUES(2225, 131, 'GHR', 'Gharb', 'english');
INSERT INTO emkt_regions VALUES(2226, 131, 'GHS', 'Ghasri', 'english');
INSERT INTO emkt_regions VALUES(2227, 131, 'KRC', 'Kercem', 'english');
INSERT INTO emkt_regions VALUES(2228, 131, 'MUN', 'Munxar', 'english');
INSERT INTO emkt_regions VALUES(2229, 131, 'NAD', 'Nadur', 'english');
INSERT INTO emkt_regions VALUES(2230, 131, 'QAL', 'Qala', 'english');
INSERT INTO emkt_regions VALUES(2231, 131, 'VIC', 'Victoria', 'english');
INSERT INTO emkt_regions VALUES(2232, 131, 'SLA', 'San Lawrenz', 'english');
INSERT INTO emkt_regions VALUES(2233, 131, 'SNT', 'Sannat', 'english');
INSERT INTO emkt_regions VALUES(2234, 131, 'ZAG', 'Xagra', 'english');
INSERT INTO emkt_regions VALUES(2235, 131, 'XEW', 'Xewkija', 'english');
INSERT INTO emkt_regions VALUES(2236, 131, 'ZEB', 'Zebbug', 'english');

INSERT INTO emkt_countries VALUES (132,'Marshall Islands','english','MH','MHL','');

INSERT INTO emkt_regions VALUES(2237, 132, 'ALK', 'Ailuk', 'english');
INSERT INTO emkt_regions VALUES(2238, 132, 'ALL', 'Ailinglapalap', 'english');
INSERT INTO emkt_regions VALUES(2239, 132, 'ARN', 'Arno', 'english');
INSERT INTO emkt_regions VALUES(2240, 132, 'AUR', 'Aur', 'english');
INSERT INTO emkt_regions VALUES(2241, 132, 'EBO', 'Ebon', 'english');
INSERT INTO emkt_regions VALUES(2242, 132, 'ENI', 'Eniwetok', 'english');
INSERT INTO emkt_regions VALUES(2243, 132, 'JAB', 'Jabat', 'english');
INSERT INTO emkt_regions VALUES(2244, 132, 'JAL', 'Jaluit', 'english');
INSERT INTO emkt_regions VALUES(2245, 132, 'KIL', 'Kili', 'english');
INSERT INTO emkt_regions VALUES(2246, 132, 'KWA', 'Kwajalein', 'english');
INSERT INTO emkt_regions VALUES(2247, 132, 'LAE', 'Lae', 'english');
INSERT INTO emkt_regions VALUES(2248, 132, 'LIB', 'Lib', 'english');
INSERT INTO emkt_regions VALUES(2249, 132, 'LIK', 'Likiep', 'english');
INSERT INTO emkt_regions VALUES(2250, 132, 'MAJ', 'Majuro', 'english');
INSERT INTO emkt_regions VALUES(2251, 132, 'MAL', 'Maloelap', 'english');
INSERT INTO emkt_regions VALUES(2252, 132, 'MEJ', 'Mejit', 'english');
INSERT INTO emkt_regions VALUES(2253, 132, 'MIL', 'Mili', 'english');
INSERT INTO emkt_regions VALUES(2254, 132, 'NMK', 'Namorik', 'english');
INSERT INTO emkt_regions VALUES(2255, 132, 'NMU', 'Namu', 'english');
INSERT INTO emkt_regions VALUES(2256, 132, 'RON', 'Rongelap', 'english');
INSERT INTO emkt_regions VALUES(2257, 132, 'UJA', 'Ujae', 'english');
INSERT INTO emkt_regions VALUES(2258, 132, 'UJL', 'Ujelang', 'english');
INSERT INTO emkt_regions VALUES(2259, 132, 'UTI', 'Utirik', 'english');
INSERT INTO emkt_regions VALUES(2260, 132, 'WTJ', 'Wotje', 'english');
INSERT INTO emkt_regions VALUES(2261, 132, 'WTN', 'Wotho', 'english');

INSERT INTO emkt_countries VALUES (133,'Martinique','english','MQ','MTQ','');

INSERT INTO emkt_regions VALUES(4264, 133, 'NOCODE', 'Martinique', 'english');

INSERT INTO emkt_countries VALUES (134,'Mauritania','english','MR','MRT','');

INSERT INTO emkt_regions VALUES(2262, 134, '01', 'ولاية الحوض الشرقي', 'english');
INSERT INTO emkt_regions VALUES(2263, 134, '02', 'ولاية الحوض الغربي', 'english');
INSERT INTO emkt_regions VALUES(2264, 134, '03', 'ولاية العصابة', 'english');
INSERT INTO emkt_regions VALUES(2265, 134, '04', 'ولاية كركول', 'english');
INSERT INTO emkt_regions VALUES(2266, 134, '05', 'ولاية البراكنة', 'english');
INSERT INTO emkt_regions VALUES(2267, 134, '06', 'ولاية الترارزة', 'english');
INSERT INTO emkt_regions VALUES(2268, 134, '07', 'ولاية آدرار', 'english');
INSERT INTO emkt_regions VALUES(2269, 134, '08', 'ولاية داخلت نواذيبو', 'english');
INSERT INTO emkt_regions VALUES(2270, 134, '09', 'ولاية تكانت', 'english');
INSERT INTO emkt_regions VALUES(2271, 134, '10', 'ولاية كيدي ماغة', 'english');
INSERT INTO emkt_regions VALUES(2272, 134, '11', 'ولاية تيرس زمور', 'english');
INSERT INTO emkt_regions VALUES(2273, 134, '12', 'ولاية إينشيري', 'english');
INSERT INTO emkt_regions VALUES(2274, 134, 'NKC', 'نواكشوط', 'english');

INSERT INTO emkt_countries VALUES (135,'Mauritius','english','MU','MUS','');

INSERT INTO emkt_regions VALUES(2275, 135, 'AG', 'Agalega Islands', 'english');
INSERT INTO emkt_regions VALUES(2276, 135, 'BL', 'Black River', 'english');
INSERT INTO emkt_regions VALUES(2277, 135, 'BR', 'Beau Bassin-Rose Hill', 'english');
INSERT INTO emkt_regions VALUES(2278, 135, 'CC', 'Cargados Carajos Shoals', 'english');
INSERT INTO emkt_regions VALUES(2279, 135, 'CU', 'Curepipe', 'english');
INSERT INTO emkt_regions VALUES(2280, 135, 'FL', 'Flacq', 'english');
INSERT INTO emkt_regions VALUES(2281, 135, 'GP', 'Grand Port', 'english');
INSERT INTO emkt_regions VALUES(2282, 135, 'MO', 'Moka', 'english');
INSERT INTO emkt_regions VALUES(2283, 135, 'PA', 'Pamplemousses', 'english');
INSERT INTO emkt_regions VALUES(2284, 135, 'PL', 'Port Louis', 'english');
INSERT INTO emkt_regions VALUES(2285, 135, 'PU', 'Port Louis City', 'english');
INSERT INTO emkt_regions VALUES(2286, 135, 'PW', 'Plaines Wilhems', 'english');
INSERT INTO emkt_regions VALUES(2287, 135, 'QB', 'Quatre Bornes', 'english');
INSERT INTO emkt_regions VALUES(2288, 135, 'RO', 'Rodrigues', 'english');
INSERT INTO emkt_regions VALUES(2289, 135, 'RR', 'Riviere du Rempart', 'english');
INSERT INTO emkt_regions VALUES(2290, 135, 'SA', 'Savanne', 'english');
INSERT INTO emkt_regions VALUES(2291, 135, 'VP', 'Vacoas-Phoenix', 'english');

INSERT INTO emkt_countries VALUES (136,'Mayotte','english','YT','MYT','');

INSERT INTO emkt_regions VALUES(4265, 136, 'NOCODE', 'Mayotte', 'english');

INSERT INTO emkt_countries VALUES (137,'Mexico','english','MX','MEX','');

INSERT INTO emkt_regions VALUES(2292, 137, 'AGU', 'Aguascalientes', 'english');
INSERT INTO emkt_regions VALUES(2293, 137, 'BCN', 'Baja California', 'english');
INSERT INTO emkt_regions VALUES(2294, 137, 'BCS', 'Baja California Sur', 'english');
INSERT INTO emkt_regions VALUES(2295, 137, 'CAM', 'Campeche', 'english');
INSERT INTO emkt_regions VALUES(2296, 137, 'CHH', 'Chihuahua', 'english');
INSERT INTO emkt_regions VALUES(2297, 137, 'CHP', 'Chiapas', 'english');
INSERT INTO emkt_regions VALUES(2298, 137, 'COA', 'Coahuila', 'english');
INSERT INTO emkt_regions VALUES(2299, 137, 'COL', 'Colima', 'english');
INSERT INTO emkt_regions VALUES(2300, 137, 'DIF', 'Distrito Federal', 'english');
INSERT INTO emkt_regions VALUES(2301, 137, 'DUR', 'Durango', 'english');
INSERT INTO emkt_regions VALUES(2302, 137, 'GRO', 'Guerrero', 'english');
INSERT INTO emkt_regions VALUES(2303, 137, 'GUA', 'Guanajuato', 'english');
INSERT INTO emkt_regions VALUES(2304, 137, 'HID', 'Hidalgo', 'english');
INSERT INTO emkt_regions VALUES(2305, 137, 'JAL', 'Jalisco', 'english');
INSERT INTO emkt_regions VALUES(2306, 137, 'MEX', 'Mexico', 'english');
INSERT INTO emkt_regions VALUES(2307, 137, 'MIC', 'Michoacán', 'english');
INSERT INTO emkt_regions VALUES(2308, 137, 'MOR', 'Morelos', 'english');
INSERT INTO emkt_regions VALUES(2309, 137, 'NAY', 'Nayarit', 'english');
INSERT INTO emkt_regions VALUES(2310, 137, 'NLE', 'Nuevo León', 'english');
INSERT INTO emkt_regions VALUES(2311, 137, 'OAX', 'Oaxaca', 'english');
INSERT INTO emkt_regions VALUES(2312, 137, 'PUE', 'Puebla', 'english');
INSERT INTO emkt_regions VALUES(2313, 137, 'QUE', 'Querétaro', 'english');
INSERT INTO emkt_regions VALUES(2314, 137, 'ROO', 'Quintana Roo', 'english');
INSERT INTO emkt_regions VALUES(2315, 137, 'SIN', 'Sinaloa', 'english');
INSERT INTO emkt_regions VALUES(2316, 137, 'SLP', 'San Luis Potosí', 'english');
INSERT INTO emkt_regions VALUES(2317, 137, 'SON', 'Sonora', 'english');
INSERT INTO emkt_regions VALUES(2318, 137, 'TAB', 'Tabasco', 'english');
INSERT INTO emkt_regions VALUES(2319, 137, 'TAM', 'Tamaulipas', 'english');
INSERT INTO emkt_regions VALUES(2320, 137, 'TLA', 'Tlaxcala', 'english');
INSERT INTO emkt_regions VALUES(2321, 137, 'VER', 'Veracruz', 'english');
INSERT INTO emkt_regions VALUES(2322, 137, 'YUC', 'Yucatan', 'english');
INSERT INTO emkt_regions VALUES(2323, 137, 'ZAC', 'Zacatecas', 'english');

INSERT INTO emkt_countries VALUES (138,'Micronesia','english','FM','FSM','');

INSERT INTO emkt_regions VALUES(2324, 138, 'KSA', 'Kosrae', 'english');
INSERT INTO emkt_regions VALUES(2325, 138, 'PNI', 'Pohnpei', 'english');
INSERT INTO emkt_regions VALUES(2326, 138, 'TRK', 'Chuuk', 'english');
INSERT INTO emkt_regions VALUES(2327, 138, 'YAP', 'Yap', 'english');

INSERT INTO emkt_countries VALUES (139,'Moldova','english','MD','MDA','');

INSERT INTO emkt_regions VALUES(2328, 139, 'BA', 'Bălţi', 'english');
INSERT INTO emkt_regions VALUES(2329, 139, 'CA', 'Cahul', 'english');
INSERT INTO emkt_regions VALUES(2330, 139, 'CU', 'Chişinău', 'english');
INSERT INTO emkt_regions VALUES(2331, 139, 'ED', 'Edineţ', 'english');
INSERT INTO emkt_regions VALUES(2332, 139, 'GA', 'Găgăuzia', 'english');
INSERT INTO emkt_regions VALUES(2333, 139, 'LA', 'Lăpuşna', 'english');
INSERT INTO emkt_regions VALUES(2334, 139, 'OR', 'Orhei', 'english');
INSERT INTO emkt_regions VALUES(2335, 139, 'SN', 'Stânga Nistrului', 'english');
INSERT INTO emkt_regions VALUES(2336, 139, 'SO', 'Soroca', 'english');
INSERT INTO emkt_regions VALUES(2337, 139, 'TI', 'Tighina', 'english');
INSERT INTO emkt_regions VALUES(2338, 139, 'UN', 'Ungheni', 'english');

INSERT INTO emkt_countries VALUES (140,'Monaco','english','MC','MCO','');

INSERT INTO emkt_regions VALUES(2339, 140, 'MC', 'Monte Carlo', 'english');
INSERT INTO emkt_regions VALUES(2340, 140, 'LR', 'La Rousse', 'english');
INSERT INTO emkt_regions VALUES(2341, 140, 'LA', 'Larvotto', 'english');
INSERT INTO emkt_regions VALUES(2342, 140, 'MV', 'Monaco Ville', 'english');
INSERT INTO emkt_regions VALUES(2343, 140, 'SM', 'Saint Michel', 'english');
INSERT INTO emkt_regions VALUES(2344, 140, 'CO', 'Condamine', 'english');
INSERT INTO emkt_regions VALUES(2345, 140, 'LC', 'La Colle', 'english');
INSERT INTO emkt_regions VALUES(2346, 140, 'RE', 'Les Révoires', 'english');
INSERT INTO emkt_regions VALUES(2347, 140, 'MO', 'Moneghetti', 'english');
INSERT INTO emkt_regions VALUES(2348, 140, 'FV', 'Fontvieille', 'english');

INSERT INTO emkt_countries VALUES (141,'Mongolia','english','MN','MNG','');

INSERT INTO emkt_regions VALUES(2349, 141, '1', 'Улаанбаатар', 'english');
INSERT INTO emkt_regions VALUES(2350, 141, '035', 'Орхон аймаг', 'english');
INSERT INTO emkt_regions VALUES(2351, 141, '037', 'Дархан-Уул аймаг', 'english');
INSERT INTO emkt_regions VALUES(2352, 141, '039', 'Хэнтий аймаг', 'english');
INSERT INTO emkt_regions VALUES(2353, 141, '041', 'Хөвсгөл аймаг', 'english');
INSERT INTO emkt_regions VALUES(2354, 141, '043', 'Ховд аймаг', 'english');
INSERT INTO emkt_regions VALUES(2355, 141, '046', 'Увс аймаг', 'english');
INSERT INTO emkt_regions VALUES(2356, 141, '047', 'Төв аймаг', 'english');
INSERT INTO emkt_regions VALUES(2357, 141, '049', 'Сэлэнгэ аймаг', 'english');
INSERT INTO emkt_regions VALUES(2358, 141, '051', 'Сүхбаатар аймаг', 'english');
INSERT INTO emkt_regions VALUES(2359, 141, '053', 'Өмнөговь аймаг', 'english');
INSERT INTO emkt_regions VALUES(2360, 141, '055', 'Өвөрхангай аймаг', 'english');
INSERT INTO emkt_regions VALUES(2361, 141, '057', 'Завхан аймаг', 'english');
INSERT INTO emkt_regions VALUES(2362, 141, '059', 'Дундговь аймаг', 'english');
INSERT INTO emkt_regions VALUES(2363, 141, '061', 'Дорнод аймаг', 'english');
INSERT INTO emkt_regions VALUES(2364, 141, '063', 'Дорноговь аймаг', 'english');
INSERT INTO emkt_regions VALUES(2365, 141, '064', 'Говьсүмбэр аймаг', 'english');
INSERT INTO emkt_regions VALUES(2366, 141, '065', 'Говь-Алтай аймаг', 'english');
INSERT INTO emkt_regions VALUES(2367, 141, '067', 'Булган аймаг', 'english');
INSERT INTO emkt_regions VALUES(2368, 141, '069', 'Баянхонгор аймаг', 'english');
INSERT INTO emkt_regions VALUES(2369, 141, '071', 'Баян Өлгий аймаг', 'english');
INSERT INTO emkt_regions VALUES(2370, 141, '073', 'Архангай аймаг', 'english');

INSERT INTO emkt_countries VALUES (142,'Montserrat','english','MS','MSR','');

INSERT INTO emkt_regions VALUES(2371, 142, 'A', 'Saint Anthony', 'english');
INSERT INTO emkt_regions VALUES(2372, 142, 'G', 'Saint Georges', 'english');
INSERT INTO emkt_regions VALUES(2373, 142, 'P', 'Saint Peter', 'english');

INSERT INTO emkt_countries VALUES (143,'Morocco','english','MA','MAR','');

INSERT INTO emkt_regions VALUES(4266, 143, 'NOCODE', 'Morocco', 'english');

INSERT INTO emkt_countries VALUES (144,'Mozambique','english','MZ','MOZ','');

INSERT INTO emkt_regions VALUES(2374, 144, 'A', 'Niassa', 'english');
INSERT INTO emkt_regions VALUES(2375, 144, 'B', 'Manica', 'english');
INSERT INTO emkt_regions VALUES(2376, 144, 'G', 'Gaza', 'english');
INSERT INTO emkt_regions VALUES(2377, 144, 'I', 'Inhambane', 'english');
INSERT INTO emkt_regions VALUES(2378, 144, 'L', 'Maputo', 'english');
INSERT INTO emkt_regions VALUES(2379, 144, 'MPM', 'Maputo cidade', 'english');
INSERT INTO emkt_regions VALUES(2380, 144, 'N', 'Nampula', 'english');
INSERT INTO emkt_regions VALUES(2381, 144, 'P', 'Cabo Delgado', 'english');
INSERT INTO emkt_regions VALUES(2382, 144, 'Q', 'Zambézia', 'english');
INSERT INTO emkt_regions VALUES(2383, 144, 'S', 'Sofala', 'english');
INSERT INTO emkt_regions VALUES(2384, 144, 'T', 'Tete', 'english');

INSERT INTO emkt_countries VALUES (145,'Myanmar','english','MM','MMR','');

INSERT INTO emkt_regions VALUES(2385, 145, 'AY', 'ဧရာ၀တီတိုင္‌း', 'english');
INSERT INTO emkt_regions VALUES(2386, 145, 'BG', 'ပဲခူးတုိင္‌း', 'english');
INSERT INTO emkt_regions VALUES(2387, 145, 'MG', 'မကေ္ဝးတိုင္‌း', 'english');
INSERT INTO emkt_regions VALUES(2388, 145, 'MD', 'မန္တလေးတုိင္‌း', 'english');
INSERT INTO emkt_regions VALUES(2389, 145, 'SG', 'စစ္‌ကုိင္‌း‌တုိင္‌း', 'english');
INSERT INTO emkt_regions VALUES(2390, 145, 'TN', 'တနင္သာရိတုိင္‌း', 'english');
INSERT INTO emkt_regions VALUES(2391, 145, 'YG', 'ရန္‌ကုန္‌တုိင္‌း', 'english');
INSERT INTO emkt_regions VALUES(2392, 145, 'CH', 'ခ္ယင္‌းပ္ရည္‌နယ္‌', 'english');
INSERT INTO emkt_regions VALUES(2393, 145, 'KC', 'ကခ္ယင္‌ပ္ရည္‌နယ္‌', 'english');
INSERT INTO emkt_regions VALUES(2394, 145, 'KH', 'ကယား‌ပ္ရည္‌နယ္‌', 'english');
INSERT INTO emkt_regions VALUES(2395, 145, 'KN', 'ကရင္‌‌ပ္ရည္‌နယ္‌', 'english');
INSERT INTO emkt_regions VALUES(2396, 145, 'MN', 'မ္ဝန္‌ပ္ရည္‌နယ္‌', 'english');
INSERT INTO emkt_regions VALUES(2397, 145, 'RK', 'ရခုိင္‌ပ္ရည္‌နယ္‌', 'english');
INSERT INTO emkt_regions VALUES(2398, 145, 'SH', 'ရုမ္‌းပ္ရည္‌နယ္‌', 'english');

INSERT INTO emkt_countries VALUES (146,'Namibia','english','NA','NAM','');

INSERT INTO emkt_regions VALUES(2399, 146, 'CA', 'Caprivi', 'english');
INSERT INTO emkt_regions VALUES(2400, 146, 'ER', 'Erongo', 'english');
INSERT INTO emkt_regions VALUES(2401, 146, 'HA', 'Hardap', 'english');
INSERT INTO emkt_regions VALUES(2402, 146, 'KA', 'Karas', 'english');
INSERT INTO emkt_regions VALUES(2403, 146, 'KH', 'Khomas', 'english');
INSERT INTO emkt_regions VALUES(2404, 146, 'KU', 'Kunene', 'english');
INSERT INTO emkt_regions VALUES(2405, 146, 'OD', 'Otjozondjupa', 'english');
INSERT INTO emkt_regions VALUES(2406, 146, 'OH', 'Omaheke', 'english');
INSERT INTO emkt_regions VALUES(2407, 146, 'OK', 'Okavango', 'english');
INSERT INTO emkt_regions VALUES(2408, 146, 'ON', 'Oshana', 'english');
INSERT INTO emkt_regions VALUES(2409, 146, 'OS', 'Omusati', 'english');
INSERT INTO emkt_regions VALUES(2410, 146, 'OT', 'Oshikoto', 'english');
INSERT INTO emkt_regions VALUES(2411, 146, 'OW', 'Ohangwena', 'english');

INSERT INTO emkt_countries VALUES (147,'Nauru','english','NR','NRU','');

INSERT INTO emkt_regions VALUES(2412, 147, 'AO', 'Aiwo', 'english');
INSERT INTO emkt_regions VALUES(2413, 147, 'AA', 'Anabar', 'english');
INSERT INTO emkt_regions VALUES(2414, 147, 'AT', 'Anetan', 'english');
INSERT INTO emkt_regions VALUES(2415, 147, 'AI', 'Anibare', 'english');
INSERT INTO emkt_regions VALUES(2416, 147, 'BA', 'Baiti', 'english');
INSERT INTO emkt_regions VALUES(2417, 147, 'BO', 'Boe', 'english');
INSERT INTO emkt_regions VALUES(2418, 147, 'BU', 'Buada', 'english');
INSERT INTO emkt_regions VALUES(2419, 147, 'DE', 'Denigomodu', 'english');
INSERT INTO emkt_regions VALUES(2420, 147, 'EW', 'Ewa', 'english');
INSERT INTO emkt_regions VALUES(2421, 147, 'IJ', 'Ijuw', 'english');
INSERT INTO emkt_regions VALUES(2422, 147, 'ME', 'Meneng', 'english');
INSERT INTO emkt_regions VALUES(2423, 147, 'NI', 'Nibok', 'english');
INSERT INTO emkt_regions VALUES(2424, 147, 'UA', 'Uaboe', 'english');
INSERT INTO emkt_regions VALUES(2425, 147, 'YA', 'Yaren', 'english');

INSERT INTO emkt_countries VALUES (148,'Nepal','english','NP','NPL','');

INSERT INTO emkt_regions VALUES(2426, 148, 'BA', 'Bagmati', 'english');
INSERT INTO emkt_regions VALUES(2427, 148, 'BH', 'Bheri', 'english');
INSERT INTO emkt_regions VALUES(2428, 148, 'DH', 'Dhawalagiri', 'english');
INSERT INTO emkt_regions VALUES(2429, 148, 'GA', 'Gandaki', 'english');
INSERT INTO emkt_regions VALUES(2430, 148, 'JA', 'Janakpur', 'english');
INSERT INTO emkt_regions VALUES(2431, 148, 'KA', 'Karnali', 'english');
INSERT INTO emkt_regions VALUES(2432, 148, 'KO', 'Kosi', 'english');
INSERT INTO emkt_regions VALUES(2433, 148, 'LU', 'Lumbini', 'english');
INSERT INTO emkt_regions VALUES(2434, 148, 'MA', 'Mahakali', 'english');
INSERT INTO emkt_regions VALUES(2435, 148, 'ME', 'Mechi', 'english');
INSERT INTO emkt_regions VALUES(2436, 148, 'NA', 'Narayani', 'english');
INSERT INTO emkt_regions VALUES(2437, 148, 'RA', 'Rapti', 'english');
INSERT INTO emkt_regions VALUES(2438, 148, 'SA', 'Sagarmatha', 'english');
INSERT INTO emkt_regions VALUES(2439, 148, 'SE', 'Seti', 'english');

INSERT INTO emkt_countries VALUES (149,'Netherlands','english','NL','NLD','');

INSERT INTO emkt_regions VALUES(2440, 149, 'DR', 'Drenthe', 'english');
INSERT INTO emkt_regions VALUES(2441, 149, 'FL', 'Flevoland', 'english');
INSERT INTO emkt_regions VALUES(2442, 149, 'FR', 'Friesland', 'english');
INSERT INTO emkt_regions VALUES(2443, 149, 'GE', 'Gelderland', 'english');
INSERT INTO emkt_regions VALUES(2444, 149, 'GR', 'Groningen', 'english');
INSERT INTO emkt_regions VALUES(2445, 149, 'LI', 'Limburg', 'english');
INSERT INTO emkt_regions VALUES(2446, 149, 'NB', 'Noord-Brabant', 'english');
INSERT INTO emkt_regions VALUES(2447, 149, 'NH', 'Noord-Holland', 'english');
INSERT INTO emkt_regions VALUES(2448, 149, 'OV', 'Overijssel', 'english');
INSERT INTO emkt_regions VALUES(2449, 149, 'UT', 'Utrecht', 'english');
INSERT INTO emkt_regions VALUES(2450, 149, 'ZE', 'Zeeland', 'english');
INSERT INTO emkt_regions VALUES(2451, 149, 'ZH', 'Zuid-Holland', 'english');

INSERT INTO emkt_countries VALUES (150,'Netherlands Antilles','english','AN','ANT','');

INSERT INTO emkt_regions VALUES(4267, 150, 'NOCODE', 'Netherlands Antilles', 'english');

INSERT INTO emkt_countries VALUES (151,'New Caledonia','english','NC','NCL','');

INSERT INTO emkt_regions VALUES(2452, 151, 'L', 'Province des Îles', 'english');
INSERT INTO emkt_regions VALUES(2453, 151, 'N', 'Province Nord', 'english');
INSERT INTO emkt_regions VALUES(2454, 151, 'S', 'Province Sud', 'english');

INSERT INTO emkt_countries VALUES (152,'New Zealand','english','NZ','NZL','');

INSERT INTO emkt_regions VALUES(2455, 152, 'AUK', 'Auckland', 'english');
INSERT INTO emkt_regions VALUES(2456, 152, 'BOP', 'Bay of Plenty', 'english');
INSERT INTO emkt_regions VALUES(2457, 152, 'CAN', 'Canterbury', 'english');
INSERT INTO emkt_regions VALUES(2458, 152, 'GIS', 'Gisborne', 'english');
INSERT INTO emkt_regions VALUES(2459, 152, 'HKB', 'Hawke\'s Bay', 'english');
INSERT INTO emkt_regions VALUES(2460, 152, 'MBH', 'Marlborough', 'english');
INSERT INTO emkt_regions VALUES(2461, 152, 'MWT', 'Manawatu-Wanganui', 'english');
INSERT INTO emkt_regions VALUES(2462, 152, 'NSN', 'Nelson', 'english');
INSERT INTO emkt_regions VALUES(2463, 152, 'NTL', 'Northland', 'english');
INSERT INTO emkt_regions VALUES(2464, 152, 'OTA', 'Otago', 'english');
INSERT INTO emkt_regions VALUES(2465, 152, 'STL', 'Southland', 'english');
INSERT INTO emkt_regions VALUES(2466, 152, 'TAS', 'Tasman', 'english');
INSERT INTO emkt_regions VALUES(2467, 152, 'TKI', 'Taranaki', 'english');
INSERT INTO emkt_regions VALUES(2468, 152, 'WGN', 'Wellington', 'english');
INSERT INTO emkt_regions VALUES(2469, 152, 'WKO', 'Waikato', 'english');
INSERT INTO emkt_regions VALUES(2470, 152, 'WTC', 'West Coast', 'english');

INSERT INTO emkt_countries VALUES (153,'Nicaragua','english','NI','NIC','');

INSERT INTO emkt_regions VALUES(2471, 153, 'AN', 'Atlántico Norte', 'english');
INSERT INTO emkt_regions VALUES(2472, 153, 'AS', 'Atlántico Sur', 'english');
INSERT INTO emkt_regions VALUES(2473, 153, 'BO', 'Boaco', 'english');
INSERT INTO emkt_regions VALUES(2474, 153, 'CA', 'Carazo', 'english');
INSERT INTO emkt_regions VALUES(2475, 153, 'CI', 'Chinandega', 'english');
INSERT INTO emkt_regions VALUES(2476, 153, 'CO', 'Chontales', 'english');
INSERT INTO emkt_regions VALUES(2477, 153, 'ES', 'Estelí', 'english');
INSERT INTO emkt_regions VALUES(2478, 153, 'GR', 'Granada', 'english');
INSERT INTO emkt_regions VALUES(2479, 153, 'JI', 'Jinotega', 'english');
INSERT INTO emkt_regions VALUES(2480, 153, 'LE', 'León', 'english');
INSERT INTO emkt_regions VALUES(2481, 153, 'MD', 'Madriz', 'english');
INSERT INTO emkt_regions VALUES(2482, 153, 'MN', 'Managua', 'english');
INSERT INTO emkt_regions VALUES(2483, 153, 'MS', 'Masaya', 'english');
INSERT INTO emkt_regions VALUES(2484, 153, 'MT', 'Matagalpa', 'english');
INSERT INTO emkt_regions VALUES(2485, 153, 'NS', 'Nueva Segovia', 'english');
INSERT INTO emkt_regions VALUES(2486, 153, 'RI', 'Rivas', 'english');
INSERT INTO emkt_regions VALUES(2487, 153, 'SJ', 'Río San Juan', 'english');

INSERT INTO emkt_countries VALUES (154,'Niger','english','NE','NER','');

INSERT INTO emkt_regions VALUES(2488, 154, '1', 'Agadez', 'english');
INSERT INTO emkt_regions VALUES(2489, 154, '2', 'Daffa', 'english');
INSERT INTO emkt_regions VALUES(2490, 154, '3', 'Dosso', 'english');
INSERT INTO emkt_regions VALUES(2491, 154, '4', 'Maradi', 'english');
INSERT INTO emkt_regions VALUES(2492, 154, '5', 'Tahoua', 'english');
INSERT INTO emkt_regions VALUES(2493, 154, '6', 'Tillabéry', 'english');
INSERT INTO emkt_regions VALUES(2494, 154, '7', 'Zinder', 'english');
INSERT INTO emkt_regions VALUES(2495, 154, '8', 'Niamey', 'english');

INSERT INTO emkt_countries VALUES (155,'Nigeria','english','NG','NGA','');

INSERT INTO emkt_regions VALUES(2496, 155, 'AB', 'Abia State', 'english');
INSERT INTO emkt_regions VALUES(2497, 155, 'AD', 'Adamawa State', 'english');
INSERT INTO emkt_regions VALUES(2498, 155, 'AK', 'Akwa Ibom State', 'english');
INSERT INTO emkt_regions VALUES(2499, 155, 'AN', 'Anambra State', 'english');
INSERT INTO emkt_regions VALUES(2500, 155, 'BA', 'Bauchi State', 'english');
INSERT INTO emkt_regions VALUES(2501, 155, 'BE', 'Benue State', 'english');
INSERT INTO emkt_regions VALUES(2502, 155, 'BO', 'Borno State', 'english');
INSERT INTO emkt_regions VALUES(2503, 155, 'BY', 'Bayelsa State', 'english');
INSERT INTO emkt_regions VALUES(2504, 155, 'CR', 'Cross River State', 'english');
INSERT INTO emkt_regions VALUES(2505, 155, 'DE', 'Delta State', 'english');
INSERT INTO emkt_regions VALUES(2506, 155, 'EB', 'Ebonyi State', 'english');
INSERT INTO emkt_regions VALUES(2507, 155, 'ED', 'Edo State', 'english');
INSERT INTO emkt_regions VALUES(2508, 155, 'EK', 'Ekiti State', 'english');
INSERT INTO emkt_regions VALUES(2509, 155, 'EN', 'Enugu State', 'english');
INSERT INTO emkt_regions VALUES(2510, 155, 'GO', 'Gombe State', 'english');
INSERT INTO emkt_regions VALUES(2511, 155, 'IM', 'Imo State', 'english');
INSERT INTO emkt_regions VALUES(2512, 155, 'JI', 'Jigawa State', 'english');
INSERT INTO emkt_regions VALUES(2513, 155, 'KB', 'Kebbi State', 'english');
INSERT INTO emkt_regions VALUES(2514, 155, 'KD', 'Kaduna State', 'english');
INSERT INTO emkt_regions VALUES(2515, 155, 'KN', 'Kano State', 'english');
INSERT INTO emkt_regions VALUES(2516, 155, 'KO', 'Kogi State', 'english');
INSERT INTO emkt_regions VALUES(2517, 155, 'KT', 'Katsina State', 'english');
INSERT INTO emkt_regions VALUES(2518, 155, 'KW', 'Kwara State', 'english');
INSERT INTO emkt_regions VALUES(2519, 155, 'LA', 'Lagos State', 'english');
INSERT INTO emkt_regions VALUES(2520, 155, 'NA', 'Nassarawa State', 'english');
INSERT INTO emkt_regions VALUES(2521, 155, 'NI', 'Niger State', 'english');
INSERT INTO emkt_regions VALUES(2522, 155, 'OG', 'Ogun State', 'english');
INSERT INTO emkt_regions VALUES(2523, 155, 'ON', 'Ondo State', 'english');
INSERT INTO emkt_regions VALUES(2524, 155, 'OS', 'Osun State', 'english');
INSERT INTO emkt_regions VALUES(2525, 155, 'OY', 'Oyo State', 'english');
INSERT INTO emkt_regions VALUES(2526, 155, 'PL', 'Plateau State', 'english');
INSERT INTO emkt_regions VALUES(2527, 155, 'RI', 'Rivers State', 'english');
INSERT INTO emkt_regions VALUES(2528, 155, 'SO', 'Sokoto State', 'english');
INSERT INTO emkt_regions VALUES(2529, 155, 'TA', 'Taraba State', 'english');
INSERT INTO emkt_regions VALUES(2530, 155, 'ZA', 'Zamfara State', 'english');

INSERT INTO emkt_countries VALUES (156,'Niue','english','NU','NIU','');

INSERT INTO emkt_regions VALUES(4268, 156, 'NOCODE', 'Niue', 'english');

INSERT INTO emkt_countries VALUES (157,'Norfolk Island','english','NF','NFK','');

INSERT INTO emkt_regions VALUES(4269, 157, 'NOCODE', 'Norfolk Island', 'english');

INSERT INTO emkt_countries VALUES (158,'Northern Mariana Islands','english','MP','MNP','');

INSERT INTO emkt_regions VALUES(2531, 158, 'N', 'Northern Islands', 'english');
INSERT INTO emkt_regions VALUES(2532, 158, 'R', 'Rota', 'english');
INSERT INTO emkt_regions VALUES(2533, 158, 'S', 'Saipan', 'english');
INSERT INTO emkt_regions VALUES(2534, 158, 'T', 'Tinian', 'english');

INSERT INTO emkt_countries VALUES (159,'Norway','english','NO','NOR','');

INSERT INTO emkt_regions VALUES(2535, 159, '01', 'Østfold fylke', 'english');
INSERT INTO emkt_regions VALUES(2536, 159, '02', 'Akershus fylke', 'english');
INSERT INTO emkt_regions VALUES(2537, 159, '03', 'Oslo fylke', 'english');
INSERT INTO emkt_regions VALUES(2538, 159, '04', 'Hedmark fylke', 'english');
INSERT INTO emkt_regions VALUES(2539, 159, '05', 'Oppland fylke', 'english');
INSERT INTO emkt_regions VALUES(2540, 159, '06', 'Buskerud fylke', 'english');
INSERT INTO emkt_regions VALUES(2541, 159, '07', 'Vestfold fylke', 'english');
INSERT INTO emkt_regions VALUES(2542, 159, '08', 'Telemark fylke', 'english');
INSERT INTO emkt_regions VALUES(2543, 159, '09', 'Aust-Agder fylke', 'english');
INSERT INTO emkt_regions VALUES(2544, 159, '10', 'Vest-Agder fylke', 'english');
INSERT INTO emkt_regions VALUES(2545, 159, '11', 'Rogaland fylke', 'english');
INSERT INTO emkt_regions VALUES(2546, 159, '12', 'Hordaland fylke', 'english');
INSERT INTO emkt_regions VALUES(2547, 159, '14', 'Sogn og Fjordane fylke', 'english');
INSERT INTO emkt_regions VALUES(2548, 159, '15', 'Møre og Romsdal fylke', 'english');
INSERT INTO emkt_regions VALUES(2549, 159, '16', 'Sør-Trøndelag fylke', 'english');
INSERT INTO emkt_regions VALUES(2550, 159, '17', 'Nord-Trøndelag fylke', 'english');
INSERT INTO emkt_regions VALUES(2551, 159, '18', 'Nordland fylke', 'english');
INSERT INTO emkt_regions VALUES(2552, 159, '19', 'Troms fylke', 'english');
INSERT INTO emkt_regions VALUES(2553, 159, '20', 'Finnmark fylke', 'english');

INSERT INTO emkt_countries VALUES (160,'Oman','english','OM','OMN','');

INSERT INTO emkt_regions VALUES(2554, 160, 'BA', 'الباطنة', 'english');
INSERT INTO emkt_regions VALUES(2555, 160, 'DA', 'الداخلية', 'english');
INSERT INTO emkt_regions VALUES(2556, 160, 'DH', 'ظفار', 'english');
INSERT INTO emkt_regions VALUES(2557, 160, 'MA', 'مسقط', 'english');
INSERT INTO emkt_regions VALUES(2558, 160, 'MU', 'مسندم', 'english');
INSERT INTO emkt_regions VALUES(2559, 160, 'SH', 'الشرقية', 'english');
INSERT INTO emkt_regions VALUES(2560, 160, 'WU', 'الوسطى', 'english');
INSERT INTO emkt_regions VALUES(2561, 160, 'ZA', 'الظاهرة', 'english');

INSERT INTO emkt_countries VALUES (161,'Pakistan','english','PK','PAK','');

INSERT INTO emkt_regions VALUES(2562, 161, 'BA', 'بلوچستان', 'english');
INSERT INTO emkt_regions VALUES(2563, 161, 'IS', 'وفاقی دارالحکومت', 'english');
INSERT INTO emkt_regions VALUES(2564, 161, 'JK', 'آزاد کشمیر', 'english');
INSERT INTO emkt_regions VALUES(2565, 161, 'NA', 'شمالی علاقہ جات', 'english');
INSERT INTO emkt_regions VALUES(2566, 161, 'NW', 'شمال مغربی سرحدی صوبہ', 'english');
INSERT INTO emkt_regions VALUES(2567, 161, 'PB', 'پنجاب', 'english');
INSERT INTO emkt_regions VALUES(2568, 161, 'SD', 'سندھ', 'english');
INSERT INTO emkt_regions VALUES(2569, 161, 'TA', 'وفاقی قبائلی علاقہ جات', 'english');

INSERT INTO emkt_countries VALUES (162,'Palau','english','PW','PLW','');

INSERT INTO emkt_regions VALUES(2570, 162, 'AM', 'Aimeliik', 'english');
INSERT INTO emkt_regions VALUES(2571, 162, 'AR', 'Airai', 'english');
INSERT INTO emkt_regions VALUES(2572, 162, 'AN', 'Angaur', 'english');
INSERT INTO emkt_regions VALUES(2573, 162, 'HA', 'Hatohobei', 'english');
INSERT INTO emkt_regions VALUES(2574, 162, 'KA', 'Kayangel', 'english');
INSERT INTO emkt_regions VALUES(2575, 162, 'KO', 'Koror', 'english');
INSERT INTO emkt_regions VALUES(2576, 162, 'ME', 'Melekeok', 'english');
INSERT INTO emkt_regions VALUES(2577, 162, 'NA', 'Ngaraard', 'english');
INSERT INTO emkt_regions VALUES(2578, 162, 'NG', 'Ngarchelong', 'english');
INSERT INTO emkt_regions VALUES(2579, 162, 'ND', 'Ngardmau', 'english');
INSERT INTO emkt_regions VALUES(2580, 162, 'NT', 'Ngatpang', 'english');
INSERT INTO emkt_regions VALUES(2581, 162, 'NC', 'Ngchesar', 'english');
INSERT INTO emkt_regions VALUES(2582, 162, 'NR', 'Ngeremlengui', 'english');
INSERT INTO emkt_regions VALUES(2583, 162, 'NW', 'Ngiwal', 'english');
INSERT INTO emkt_regions VALUES(2584, 162, 'PE', 'Peleliu', 'english');
INSERT INTO emkt_regions VALUES(2585, 162, 'SO', 'Sonsorol', 'english');

INSERT INTO emkt_countries VALUES (163,'Panama','english','PA','PAN','');

INSERT INTO emkt_regions VALUES(2586, 163, '1', 'Bocas del Toro', 'english');
INSERT INTO emkt_regions VALUES(2587, 163, '2', 'Coclé', 'english');
INSERT INTO emkt_regions VALUES(2588, 163, '3', 'Colón', 'english');
INSERT INTO emkt_regions VALUES(2589, 163, '4', 'Chiriquí', 'english');
INSERT INTO emkt_regions VALUES(2590, 163, '5', 'Darién', 'english');
INSERT INTO emkt_regions VALUES(2591, 163, '6', 'Herrera', 'english');
INSERT INTO emkt_regions VALUES(2592, 163, '7', 'Los Santos', 'english');
INSERT INTO emkt_regions VALUES(2593, 163, '8', 'Panamá', 'english');
INSERT INTO emkt_regions VALUES(2594, 163, '9', 'Veraguas', 'english');
INSERT INTO emkt_regions VALUES(2595, 163, 'Q', 'Kuna Yala', 'english');

INSERT INTO emkt_countries VALUES (164,'Papua New Guinea','english','PG','PNG','');

INSERT INTO emkt_regions VALUES(2596, 164, 'CPK', 'Chimbu', 'english');
INSERT INTO emkt_regions VALUES(2597, 164, 'CPM', 'Central', 'english');
INSERT INTO emkt_regions VALUES(2598, 164, 'EBR', 'East New Britain', 'english');
INSERT INTO emkt_regions VALUES(2599, 164, 'EHG', 'Eastern Highlands', 'english');
INSERT INTO emkt_regions VALUES(2600, 164, 'EPW', 'Enga', 'english');
INSERT INTO emkt_regions VALUES(2601, 164, 'ESW', 'East Sepik', 'english');
INSERT INTO emkt_regions VALUES(2602, 164, 'GPK', 'Gulf', 'english');
INSERT INTO emkt_regions VALUES(2603, 164, 'MBA', 'Milne Bay', 'english');
INSERT INTO emkt_regions VALUES(2604, 164, 'MPL', 'Morobe', 'english');
INSERT INTO emkt_regions VALUES(2605, 164, 'MPM', 'Madang', 'english');
INSERT INTO emkt_regions VALUES(2606, 164, 'MRL', 'Manus', 'english');
INSERT INTO emkt_regions VALUES(2607, 164, 'NCD', 'National Capital District', 'english');
INSERT INTO emkt_regions VALUES(2608, 164, 'NIK', 'New Ireland', 'english');
INSERT INTO emkt_regions VALUES(2609, 164, 'NPP', 'Northern', 'english');
INSERT INTO emkt_regions VALUES(2610, 164, 'NSA', 'North Solomons', 'english');
INSERT INTO emkt_regions VALUES(2611, 164, 'SAN', 'Sandaun', 'english');
INSERT INTO emkt_regions VALUES(2612, 164, 'SHM', 'Southern Highlands', 'english');
INSERT INTO emkt_regions VALUES(2613, 164, 'WBK', 'West New Britain', 'english');
INSERT INTO emkt_regions VALUES(2614, 164, 'WHM', 'Western Highlands', 'english');
INSERT INTO emkt_regions VALUES(2615, 164, 'WPD', 'Western', 'english');

INSERT INTO emkt_countries VALUES (165,'Paraguay','english','PY','PRY','');

INSERT INTO emkt_regions VALUES(2616, 165, '1', 'Concepción', 'english');
INSERT INTO emkt_regions VALUES(2617, 165, '2', 'San Pedro', 'english');
INSERT INTO emkt_regions VALUES(2618, 165, '3', 'Cordillera', 'english');
INSERT INTO emkt_regions VALUES(2619, 165, '4', 'Guairá', 'english');
INSERT INTO emkt_regions VALUES(2620, 165, '5', 'Caaguazú', 'english');
INSERT INTO emkt_regions VALUES(2621, 165, '6', 'Caazapá', 'english');
INSERT INTO emkt_regions VALUES(2622, 165, '7', 'Itapúa', 'english');
INSERT INTO emkt_regions VALUES(2623, 165, '8', 'Misiones', 'english');
INSERT INTO emkt_regions VALUES(2624, 165, '9', 'Paraguarí', 'english');
INSERT INTO emkt_regions VALUES(2625, 165, '10', 'Alto Paraná', 'english');
INSERT INTO emkt_regions VALUES(2626, 165, '11', 'Central', 'english');
INSERT INTO emkt_regions VALUES(2627, 165, '12', 'Ñeembucú', 'english');
INSERT INTO emkt_regions VALUES(2628, 165, '13', 'Amambay', 'english');
INSERT INTO emkt_regions VALUES(2629, 165, '14', 'Canindeyú', 'english');
INSERT INTO emkt_regions VALUES(2630, 165, '15', 'Presidente Hayes', 'english');
INSERT INTO emkt_regions VALUES(2631, 165, '16', 'Alto Paraguay', 'english');
INSERT INTO emkt_regions VALUES(2632, 165, '19', 'Boquerón', 'english');
INSERT INTO emkt_regions VALUES(2633, 165, 'ASU', 'Asunción', 'english');

INSERT INTO emkt_countries VALUES (166,'Peru','english','PE','PER','');

INSERT INTO emkt_regions VALUES(2634, 166, 'AMA', 'Amazonas', 'english');
INSERT INTO emkt_regions VALUES(2635, 166, 'ANC', 'Ancash', 'english');
INSERT INTO emkt_regions VALUES(2636, 166, 'APU', 'Apurímac', 'english');
INSERT INTO emkt_regions VALUES(2637, 166, 'ARE', 'Arequipa', 'english');
INSERT INTO emkt_regions VALUES(2638, 166, 'AYA', 'Ayacucho', 'english');
INSERT INTO emkt_regions VALUES(2639, 166, 'CAJ', 'Cajamarca', 'english');
INSERT INTO emkt_regions VALUES(2640, 166, 'CAL', 'Callao', 'english');
INSERT INTO emkt_regions VALUES(2641, 166, 'CUS', 'Cuzco', 'english');
INSERT INTO emkt_regions VALUES(2642, 166, 'HUC', 'Huánuco', 'english');
INSERT INTO emkt_regions VALUES(2643, 166, 'HUV', 'Huancavelica', 'english');
INSERT INTO emkt_regions VALUES(2644, 166, 'ICA', 'Ica', 'english');
INSERT INTO emkt_regions VALUES(2645, 166, 'JUN', 'Junín', 'english');
INSERT INTO emkt_regions VALUES(2646, 166, 'LAL', 'La Libertad', 'english');
INSERT INTO emkt_regions VALUES(2647, 166, 'LAM', 'Lambayeque', 'english');
INSERT INTO emkt_regions VALUES(2648, 166, 'LIM', 'Lima', 'english');
INSERT INTO emkt_regions VALUES(2649, 166, 'LOR', 'Loreto', 'english');
INSERT INTO emkt_regions VALUES(2650, 166, 'MDD', 'Madre de Dios', 'english');
INSERT INTO emkt_regions VALUES(2651, 166, 'MOQ', 'Moquegua', 'english');
INSERT INTO emkt_regions VALUES(2652, 166, 'PAS', 'Pasco', 'english');
INSERT INTO emkt_regions VALUES(2653, 166, 'PIU', 'Piura', 'english');
INSERT INTO emkt_regions VALUES(2654, 166, 'PUN', 'Puno', 'english');
INSERT INTO emkt_regions VALUES(2655, 166, 'SAM', 'San Martín', 'english');
INSERT INTO emkt_regions VALUES(2656, 166, 'TAC', 'Tacna', 'english');
INSERT INTO emkt_regions VALUES(2657, 166, 'TUM', 'Tumbes', 'english');
INSERT INTO emkt_regions VALUES(2658, 166, 'UCA', 'Ucayali', 'english');

INSERT INTO emkt_countries VALUES (167,'Philippines','english','PH','PHL','');

INSERT INTO emkt_regions VALUES(2659, 167, 'ABR', 'Abra', 'english');
INSERT INTO emkt_regions VALUES(2660, 167, 'AGN', 'Agusan del Norte', 'english');
INSERT INTO emkt_regions VALUES(2661, 167, 'AGS', 'Agusan del Sur', 'english');
INSERT INTO emkt_regions VALUES(2662, 167, 'AKL', 'Aklan', 'english');
INSERT INTO emkt_regions VALUES(2663, 167, 'ALB', 'Albay', 'english');
INSERT INTO emkt_regions VALUES(2664, 167, 'ANT', 'Antique', 'english');
INSERT INTO emkt_regions VALUES(2665, 167, 'APA', 'Apayao', 'english');
INSERT INTO emkt_regions VALUES(2666, 167, 'AUR', 'Aurora', 'english');
INSERT INTO emkt_regions VALUES(2667, 167, 'BAN', 'Bataan', 'english');
INSERT INTO emkt_regions VALUES(2668, 167, 'BAS', 'Basilan', 'english');
INSERT INTO emkt_regions VALUES(2669, 167, 'BEN', 'Benguet', 'english');
INSERT INTO emkt_regions VALUES(2670, 167, 'BIL', 'Biliran', 'english');
INSERT INTO emkt_regions VALUES(2671, 167, 'BOH', 'Bohol', 'english');
INSERT INTO emkt_regions VALUES(2672, 167, 'BTG', 'Batangas', 'english');
INSERT INTO emkt_regions VALUES(2673, 167, 'BTN', 'Batanes', 'english');
INSERT INTO emkt_regions VALUES(2674, 167, 'BUK', 'Bukidnon', 'english');
INSERT INTO emkt_regions VALUES(2675, 167, 'BUL', 'Bulacan', 'english');
INSERT INTO emkt_regions VALUES(2676, 167, 'CAG', 'Cagayan', 'english');
INSERT INTO emkt_regions VALUES(2677, 167, 'CAM', 'Camiguin', 'english');
INSERT INTO emkt_regions VALUES(2678, 167, 'CAN', 'Camarines Norte', 'english');
INSERT INTO emkt_regions VALUES(2679, 167, 'CAP', 'Capiz', 'english');
INSERT INTO emkt_regions VALUES(2680, 167, 'CAS', 'Camarines Sur', 'english');
INSERT INTO emkt_regions VALUES(2681, 167, 'CAT', 'Catanduanes', 'english');
INSERT INTO emkt_regions VALUES(2682, 167, 'CAV', 'Cavite', 'english');
INSERT INTO emkt_regions VALUES(2683, 167, 'CEB', 'Cebu', 'english');
INSERT INTO emkt_regions VALUES(2684, 167, 'COM', 'Compostela Valley', 'english');
INSERT INTO emkt_regions VALUES(2685, 167, 'DAO', 'Davao Oriental', 'english');
INSERT INTO emkt_regions VALUES(2686, 167, 'DAS', 'Davao del Sur', 'english');
INSERT INTO emkt_regions VALUES(2687, 167, 'DAV', 'Davao del Norte', 'english');
INSERT INTO emkt_regions VALUES(2688, 167, 'EAS', 'Eastern Samar', 'english');
INSERT INTO emkt_regions VALUES(2689, 167, 'GUI', 'Guimaras', 'english');
INSERT INTO emkt_regions VALUES(2690, 167, 'IFU', 'Ifugao', 'english');
INSERT INTO emkt_regions VALUES(2691, 167, 'ILI', 'Iloilo', 'english');
INSERT INTO emkt_regions VALUES(2692, 167, 'ILN', 'Ilocos Norte', 'english');
INSERT INTO emkt_regions VALUES(2693, 167, 'ILS', 'Ilocos Sur', 'english');
INSERT INTO emkt_regions VALUES(2694, 167, 'ISA', 'Isabela', 'english');
INSERT INTO emkt_regions VALUES(2695, 167, 'KAL', 'Kalinga', 'english');
INSERT INTO emkt_regions VALUES(2696, 167, 'LAG', 'Laguna', 'english');
INSERT INTO emkt_regions VALUES(2697, 167, 'LAN', 'Lanao del Norte', 'english');
INSERT INTO emkt_regions VALUES(2698, 167, 'LAS', 'Lanao del Sur', 'english');
INSERT INTO emkt_regions VALUES(2699, 167, 'LEY', 'Leyte', 'english');
INSERT INTO emkt_regions VALUES(2700, 167, 'LUN', 'La Union', 'english');
INSERT INTO emkt_regions VALUES(2701, 167, 'MAD', 'Marinduque', 'english');
INSERT INTO emkt_regions VALUES(2702, 167, 'MAG', 'Maguindanao', 'english');
INSERT INTO emkt_regions VALUES(2703, 167, 'MAS', 'Masbate', 'english');
INSERT INTO emkt_regions VALUES(2704, 167, 'MDC', 'Mindoro Occidental', 'english');
INSERT INTO emkt_regions VALUES(2705, 167, 'MDR', 'Mindoro Oriental', 'english');
INSERT INTO emkt_regions VALUES(2706, 167, 'MOU', 'Mountain Province', 'english');
INSERT INTO emkt_regions VALUES(2707, 167, 'MSC', 'Misamis Occidental', 'english');
INSERT INTO emkt_regions VALUES(2708, 167, 'MSR', 'Misamis Oriental', 'english');
INSERT INTO emkt_regions VALUES(2709, 167, 'NCO', 'Cotabato', 'english');
INSERT INTO emkt_regions VALUES(2710, 167, 'NSA', 'Northern Samar', 'english');
INSERT INTO emkt_regions VALUES(2711, 167, 'NEC', 'Negros Occidental', 'english');
INSERT INTO emkt_regions VALUES(2712, 167, 'NER', 'Negros Oriental', 'english');
INSERT INTO emkt_regions VALUES(2713, 167, 'NUE', 'Nueva Ecija', 'english');
INSERT INTO emkt_regions VALUES(2714, 167, 'NUV', 'Nueva Vizcaya', 'english');
INSERT INTO emkt_regions VALUES(2715, 167, 'PAM', 'Pampanga', 'english');
INSERT INTO emkt_regions VALUES(2716, 167, 'PAN', 'Pangasinan', 'english');
INSERT INTO emkt_regions VALUES(2717, 167, 'PLW', 'Palawan', 'english');
INSERT INTO emkt_regions VALUES(2718, 167, 'QUE', 'Quezon', 'english');
INSERT INTO emkt_regions VALUES(2719, 167, 'QUI', 'Quirino', 'english');
INSERT INTO emkt_regions VALUES(2720, 167, 'RIZ', 'Rizal', 'english');
INSERT INTO emkt_regions VALUES(2721, 167, 'ROM', 'Romblon', 'english');
INSERT INTO emkt_regions VALUES(2722, 167, 'SAR', 'Sarangani', 'english');
INSERT INTO emkt_regions VALUES(2723, 167, 'SCO', 'South Cotabato', 'english');
INSERT INTO emkt_regions VALUES(2724, 167, 'SIG', 'Siquijor', 'english');
INSERT INTO emkt_regions VALUES(2725, 167, 'SLE', 'Southern Leyte', 'english');
INSERT INTO emkt_regions VALUES(2726, 167, 'SLU', 'Sulu', 'english');
INSERT INTO emkt_regions VALUES(2727, 167, 'SOR', 'Sorsogon', 'english');
INSERT INTO emkt_regions VALUES(2728, 167, 'SUK', 'Sultan Kudarat', 'english');
INSERT INTO emkt_regions VALUES(2729, 167, 'SUN', 'Surigao del Norte', 'english');
INSERT INTO emkt_regions VALUES(2730, 167, 'SUR', 'Surigao del Sur', 'english');
INSERT INTO emkt_regions VALUES(2731, 167, 'TAR', 'Tarlac', 'english');
INSERT INTO emkt_regions VALUES(2732, 167, 'TAW', 'Tawi-Tawi', 'english');
INSERT INTO emkt_regions VALUES(2733, 167, 'WSA', 'Samar', 'english');
INSERT INTO emkt_regions VALUES(2734, 167, 'ZAN', 'Zamboanga del Norte', 'english');
INSERT INTO emkt_regions VALUES(2735, 167, 'ZAS', 'Zamboanga del Sur', 'english');
INSERT INTO emkt_regions VALUES(2736, 167, 'ZMB', 'Zambales', 'english');
INSERT INTO emkt_regions VALUES(2737, 167, 'ZSI', 'Zamboanga Sibugay', 'english');

INSERT INTO emkt_countries VALUES (168,'Pitcairn','english','PN','PCN','');

INSERT INTO emkt_regions VALUES(4270, 168, 'NOCODE', 'Pitcairn', 'english');

INSERT INTO emkt_countries VALUES (169,'Poland','english','PL','POL','');

INSERT INTO emkt_regions VALUES(2738, 169, 'DS', 'Dolnośląskie', 'english');
INSERT INTO emkt_regions VALUES(2739, 169, 'KP', 'Kujawsko-Pomorskie', 'english');
INSERT INTO emkt_regions VALUES(2740, 169, 'LU', 'Lubelskie', 'english');
INSERT INTO emkt_regions VALUES(2741, 169, 'LB', 'Lubuskie', 'english');
INSERT INTO emkt_regions VALUES(2742, 169, 'LD', 'Łódzkie', 'english');
INSERT INTO emkt_regions VALUES(2743, 169, 'MA', 'Małopolskie', 'english');
INSERT INTO emkt_regions VALUES(2744, 169, 'MZ', 'Mazowieckie', 'english');
INSERT INTO emkt_regions VALUES(2745, 169, 'OP', 'Opolskie', 'english');
INSERT INTO emkt_regions VALUES(2746, 169, 'PK', 'Podkarpackie', 'english');
INSERT INTO emkt_regions VALUES(2747, 169, 'PD', 'Podlaskie', 'english');
INSERT INTO emkt_regions VALUES(2748, 169, 'PM', 'Pomorskie', 'english');
INSERT INTO emkt_regions VALUES(2749, 169, 'SL', 'Śląskie', 'english');
INSERT INTO emkt_regions VALUES(2750, 169, 'SK', 'Świętokrzyskie', 'english');
INSERT INTO emkt_regions VALUES(2751, 169, 'WN', 'Warmińsko-Mazurskie', 'english');
INSERT INTO emkt_regions VALUES(2752, 169, 'WP', 'Wielkopolskie', 'english');
INSERT INTO emkt_regions VALUES(2753, 169, 'ZP', 'Zachodniopomorskie', 'english');

INSERT INTO emkt_countries VALUES (170,'Portugal','english','PT','PRT','');

INSERT INTO emkt_regions VALUES(2754, 170, '01', 'Aveiro', 'english');
INSERT INTO emkt_regions VALUES(2755, 170, '02', 'Beja', 'english');
INSERT INTO emkt_regions VALUES(2756, 170, '03', 'Braga', 'english');
INSERT INTO emkt_regions VALUES(2757, 170, '04', 'Bragança', 'english');
INSERT INTO emkt_regions VALUES(2758, 170, '05', 'Castelo Branco', 'english');
INSERT INTO emkt_regions VALUES(2759, 170, '06', 'Coimbra', 'english');
INSERT INTO emkt_regions VALUES(2760, 170, '07', 'Évora', 'english');
INSERT INTO emkt_regions VALUES(2761, 170, '08', 'Faro', 'english');
INSERT INTO emkt_regions VALUES(2762, 170, '09', 'Guarda', 'english');
INSERT INTO emkt_regions VALUES(2763, 170, '10', 'Leiria', 'english');
INSERT INTO emkt_regions VALUES(2764, 170, '11', 'Lisboa', 'english');
INSERT INTO emkt_regions VALUES(2765, 170, '12', 'Portalegre', 'english');
INSERT INTO emkt_regions VALUES(2766, 170, '13', 'Porto', 'english');
INSERT INTO emkt_regions VALUES(2767, 170, '14', 'Santarém', 'english');
INSERT INTO emkt_regions VALUES(2768, 170, '15', 'Setúbal', 'english');
INSERT INTO emkt_regions VALUES(2769, 170, '16', 'Viana do Castelo', 'english');
INSERT INTO emkt_regions VALUES(2770, 170, '17', 'Vila Real', 'english');
INSERT INTO emkt_regions VALUES(2771, 170, '18', 'Viseu', 'english');
INSERT INTO emkt_regions VALUES(2772, 170, '20', 'Região Autónoma dos Açores', 'english');
INSERT INTO emkt_regions VALUES(2773, 170, '30', 'Região Autónoma da Madeira', 'english');

INSERT INTO emkt_countries VALUES (171,'Puerto Rico','english','PR','PRI','');

INSERT INTO emkt_regions VALUES(4271, 171, 'NOCODE', 'Puerto Rico', 'english');

INSERT INTO emkt_countries VALUES (172,'Qatar','english','QA','QAT','');

INSERT INTO emkt_regions VALUES(2774, 172, 'DA', 'الدوحة', 'english');
INSERT INTO emkt_regions VALUES(2775, 172, 'GH', 'الغويرية', 'english');
INSERT INTO emkt_regions VALUES(2776, 172, 'JB', 'جريان الباطنة', 'english');
INSERT INTO emkt_regions VALUES(2777, 172, 'JU', 'الجميلية', 'english');
INSERT INTO emkt_regions VALUES(2778, 172, 'KH', 'الخور', 'english');
INSERT INTO emkt_regions VALUES(2779, 172, 'ME', 'مسيعيد', 'english');
INSERT INTO emkt_regions VALUES(2780, 172, 'MS', 'الشمال', 'english');
INSERT INTO emkt_regions VALUES(2781, 172, 'RA', 'الريان', 'english');
INSERT INTO emkt_regions VALUES(2782, 172, 'US', 'أم صلال', 'english');
INSERT INTO emkt_regions VALUES(2783, 172, 'WA', 'الوكرة', 'english');

INSERT INTO emkt_countries VALUES (173,'Reunion','english','RE','REU','');

INSERT INTO emkt_regions VALUES(4272, 173, 'NOCODE', 'Reunion', 'english');

INSERT INTO emkt_countries VALUES (174,'Romania','english','RO','ROM','');

INSERT INTO emkt_regions VALUES(2784, 174, 'AB', 'Alba', 'english');
INSERT INTO emkt_regions VALUES(2785, 174, 'AG', 'Argeş', 'english');
INSERT INTO emkt_regions VALUES(2786, 174, 'AR', 'Arad', 'english');
INSERT INTO emkt_regions VALUES(2787, 174, 'B', 'Bucureşti', 'english');
INSERT INTO emkt_regions VALUES(2788, 174, 'BC', 'Bacău', 'english');
INSERT INTO emkt_regions VALUES(2789, 174, 'BH', 'Bihor', 'english');
INSERT INTO emkt_regions VALUES(2790, 174, 'BN', 'Bistriţa-Năsăud', 'english');
INSERT INTO emkt_regions VALUES(2791, 174, 'BR', 'Brăila', 'english');
INSERT INTO emkt_regions VALUES(2792, 174, 'BT', 'Botoşani', 'english');
INSERT INTO emkt_regions VALUES(2793, 174, 'BV', 'Braşov', 'english');
INSERT INTO emkt_regions VALUES(2794, 174, 'BZ', 'Buzău', 'english');
INSERT INTO emkt_regions VALUES(2795, 174, 'CJ', 'Cluj', 'english');
INSERT INTO emkt_regions VALUES(2796, 174, 'CL', 'Călăraşi', 'english');
INSERT INTO emkt_regions VALUES(2797, 174, 'CS', 'Caraş-Severin', 'english');
INSERT INTO emkt_regions VALUES(2798, 174, 'CT', 'Constanţa', 'english');
INSERT INTO emkt_regions VALUES(2799, 174, 'CV', 'Covasna', 'english');
INSERT INTO emkt_regions VALUES(2800, 174, 'DB', 'Dâmboviţa', 'english');
INSERT INTO emkt_regions VALUES(2801, 174, 'DJ', 'Dolj', 'english');
INSERT INTO emkt_regions VALUES(2802, 174, 'GJ', 'Gorj', 'english');
INSERT INTO emkt_regions VALUES(2803, 174, 'GL', 'Galaţi', 'english');
INSERT INTO emkt_regions VALUES(2804, 174, 'GR', 'Giurgiu', 'english');
INSERT INTO emkt_regions VALUES(2805, 174, 'HD', 'Hunedoara', 'english');
INSERT INTO emkt_regions VALUES(2806, 174, 'HG', 'Harghita', 'english');
INSERT INTO emkt_regions VALUES(2807, 174, 'IF', 'Ilfov', 'english');
INSERT INTO emkt_regions VALUES(2808, 174, 'IL', 'Ialomiţa', 'english');
INSERT INTO emkt_regions VALUES(2809, 174, 'IS', 'Iaşi', 'english');
INSERT INTO emkt_regions VALUES(2810, 174, 'MH', 'Mehedinţi', 'english');
INSERT INTO emkt_regions VALUES(2811, 174, 'MM', 'Maramureş', 'english');
INSERT INTO emkt_regions VALUES(2812, 174, 'MS', 'Mureş', 'english');
INSERT INTO emkt_regions VALUES(2813, 174, 'NT', 'Neamţ', 'english');
INSERT INTO emkt_regions VALUES(2814, 174, 'OT', 'Olt', 'english');
INSERT INTO emkt_regions VALUES(2815, 174, 'PH', 'Prahova', 'english');
INSERT INTO emkt_regions VALUES(2816, 174, 'SB', 'Sibiu', 'english');
INSERT INTO emkt_regions VALUES(2817, 174, 'SJ', 'Sălaj', 'english');
INSERT INTO emkt_regions VALUES(2818, 174, 'SM', 'Satu Mare', 'english');
INSERT INTO emkt_regions VALUES(2819, 174, 'SV', 'Suceava', 'english');
INSERT INTO emkt_regions VALUES(2820, 174, 'TL', 'Tulcea', 'english');
INSERT INTO emkt_regions VALUES(2821, 174, 'TM', 'Timiş', 'english');
INSERT INTO emkt_regions VALUES(2822, 174, 'TR', 'Teleorman', 'english');
INSERT INTO emkt_regions VALUES(2823, 174, 'VL', 'Vâlcea', 'english');
INSERT INTO emkt_regions VALUES(2824, 174, 'VN', 'Vrancea', 'english');
INSERT INTO emkt_regions VALUES(2825, 174, 'VS', 'Vaslui', 'english');

INSERT INTO emkt_countries VALUES (175,'Russian Federation','english','RU','RUS','');

INSERT INTO emkt_regions VALUES(2826, 175, 'AD', 'Республика Адыгея', 'english');
INSERT INTO emkt_regions VALUES(2827, 175, 'AL', 'Республика Алтай', 'english');
INSERT INTO emkt_regions VALUES(2828, 175, 'ALT', 'Алтайский край', 'english');
INSERT INTO emkt_regions VALUES(2829, 175, 'AMU', 'Амурская область', 'english');
INSERT INTO emkt_regions VALUES(2830, 175, 'ARK', 'Архангельская область', 'english');
INSERT INTO emkt_regions VALUES(2831, 175, 'AST', 'Астраханская область', 'english');
INSERT INTO emkt_regions VALUES(2832, 175, 'BA', 'Республика Башкортостан', 'english');
INSERT INTO emkt_regions VALUES(2833, 175, 'BEL', 'Белгородская область', 'english');
INSERT INTO emkt_regions VALUES(2834, 175, 'BRY', 'Брянская область', 'english');
INSERT INTO emkt_regions VALUES(2835, 175, 'BU', 'Республика Бурятия', 'english');
INSERT INTO emkt_regions VALUES(2836, 175, 'CE', 'Чеченская Республика', 'english');
INSERT INTO emkt_regions VALUES(2837, 175, 'CHE', 'Челябинская область', 'english');
INSERT INTO emkt_regions VALUES(2838, 175, 'ZAB', 'Забайкальский край', 'english');
INSERT INTO emkt_regions VALUES(2839, 175, 'CHU', 'Чукотский автономный округ', 'english');
INSERT INTO emkt_regions VALUES(2840, 175, 'CU', 'Чувашская Республика', 'english');
INSERT INTO emkt_regions VALUES(2841, 175, 'DA', 'Республика Дагестан', 'english');
INSERT INTO emkt_regions VALUES(2842, 175, 'IN', 'Республика Ингушетия', 'english');
INSERT INTO emkt_regions VALUES(2843, 175, 'IRK', 'Иркутская область', 'english');
INSERT INTO emkt_regions VALUES(2844, 175, 'IVA', 'Ивановская область', 'english');
INSERT INTO emkt_regions VALUES(2845, 175, 'KAM', 'Камчатский край', 'english');
INSERT INTO emkt_regions VALUES(2846, 175, 'KB', 'Кабардино-Балкарская Республика', 'english');
INSERT INTO emkt_regions VALUES(2847, 175, 'KC', 'Карачаево-Черкесская Республика', 'english');
INSERT INTO emkt_regions VALUES(2848, 175, 'KDA', 'Краснодарский край', 'english');
INSERT INTO emkt_regions VALUES(2849, 175, 'KEM', 'Кемеровская область', 'english');
INSERT INTO emkt_regions VALUES(2850, 175, 'KGD', 'Калининградская область', 'english');
INSERT INTO emkt_regions VALUES(2851, 175, 'KGN', 'Курганская область', 'english');
INSERT INTO emkt_regions VALUES(2852, 175, 'KHA', 'Хабаровский край', 'english');
INSERT INTO emkt_regions VALUES(2853, 175, 'KHM', 'Ханты-Мансийский автономный округ—Югра', 'english');
INSERT INTO emkt_regions VALUES(2854, 175, 'KIA', 'Красноярский край', 'english');
INSERT INTO emkt_regions VALUES(2855, 175, 'KIR', 'Кировская область', 'english');
INSERT INTO emkt_regions VALUES(2856, 175, 'KK', 'Республика Хакасия', 'english');
INSERT INTO emkt_regions VALUES(2857, 175, 'KL', 'Республика Калмыкия', 'english');
INSERT INTO emkt_regions VALUES(2858, 175, 'KLU', 'Калужская область', 'english');
INSERT INTO emkt_regions VALUES(2859, 175, 'KO', 'Республика Коми', 'english');
INSERT INTO emkt_regions VALUES(2860, 175, 'KOS', 'Костромская область', 'english');
INSERT INTO emkt_regions VALUES(2861, 175, 'KR', 'Республика Карелия', 'english');
INSERT INTO emkt_regions VALUES(2862, 175, 'KRS', 'Курская область', 'english');
INSERT INTO emkt_regions VALUES(2863, 175, 'LEN', 'Ленинградская область', 'english');
INSERT INTO emkt_regions VALUES(2864, 175, 'LIP', 'Липецкая область', 'english');
INSERT INTO emkt_regions VALUES(2865, 175, 'MAG', 'Магаданская область', 'english');
INSERT INTO emkt_regions VALUES(2866, 175, 'ME', 'Республика Марий Эл', 'english');
INSERT INTO emkt_regions VALUES(2867, 175, 'MO', 'Республика Мордовия', 'english');
INSERT INTO emkt_regions VALUES(2868, 175, 'MOS', 'Московская область', 'english');
INSERT INTO emkt_regions VALUES(2869, 175, 'MOW', 'Москва', 'english');
INSERT INTO emkt_regions VALUES(2870, 175, 'MUR', 'Мурманская область', 'english');
INSERT INTO emkt_regions VALUES(2871, 175, 'NEN', 'Ненецкий автономный округ', 'english');
INSERT INTO emkt_regions VALUES(2872, 175, 'NGR', 'Новгородская область', 'english');
INSERT INTO emkt_regions VALUES(2873, 175, 'NIZ', 'Нижегородская область', 'english');
INSERT INTO emkt_regions VALUES(2874, 175, 'NVS', 'Новосибирская область', 'english');
INSERT INTO emkt_regions VALUES(2875, 175, 'OMS', 'Омская область', 'english');
INSERT INTO emkt_regions VALUES(2876, 175, 'ORE', 'Оренбургская область', 'english');
INSERT INTO emkt_regions VALUES(2877, 175, 'ORL', 'Орловская область', 'english');
INSERT INTO emkt_regions VALUES(2878, 175, 'PNZ', 'Пензенская область', 'english');
INSERT INTO emkt_regions VALUES(2879, 175, 'PRI', 'Приморский край', 'english');
INSERT INTO emkt_regions VALUES(2880, 175, 'PSK', 'Псковская область', 'english');
INSERT INTO emkt_regions VALUES(2881, 175, 'ROS', 'Ростовская область', 'english');
INSERT INTO emkt_regions VALUES(2882, 175, 'RYA', 'Рязанская область', 'english');
INSERT INTO emkt_regions VALUES(2883, 175, 'SA', 'Республика Саха (Якутия)', 'english');
INSERT INTO emkt_regions VALUES(2884, 175, 'SAK', 'Сахалинская область', 'english');
INSERT INTO emkt_regions VALUES(2885, 175, 'SAM', 'Самарская область', 'english');
INSERT INTO emkt_regions VALUES(2886, 175, 'SAR', 'Саратовская область', 'english');
INSERT INTO emkt_regions VALUES(2887, 175, 'SE', 'Республика Северная Осетия–Алания', 'english');
INSERT INTO emkt_regions VALUES(2888, 175, 'SMO', 'Смоленская область', 'english');
INSERT INTO emkt_regions VALUES(2889, 175, 'SPE', 'Санкт-Петербург', 'english');
INSERT INTO emkt_regions VALUES(2890, 175, 'STA', 'Ставропольский край', 'english');
INSERT INTO emkt_regions VALUES(2891, 175, 'SVE', 'Свердловская область', 'english');
INSERT INTO emkt_regions VALUES(2892, 175, 'TA', 'Республика Татарстан', 'english');
INSERT INTO emkt_regions VALUES(2893, 175, 'TAM', 'Тамбовская область', 'english');
INSERT INTO emkt_regions VALUES(2894, 175, 'TOM', 'Томская область', 'english');
INSERT INTO emkt_regions VALUES(2895, 175, 'TUL', 'Тульская область', 'english');
INSERT INTO emkt_regions VALUES(2896, 175, 'TVE', 'Тверская область', 'english');
INSERT INTO emkt_regions VALUES(2897, 175, 'TY', 'Республика Тыва', 'english');
INSERT INTO emkt_regions VALUES(2898, 175, 'TYU', 'Тюменская область', 'english');
INSERT INTO emkt_regions VALUES(2899, 175, 'UD', 'Удмуртская Республика', 'english');
INSERT INTO emkt_regions VALUES(2900, 175, 'ULY', 'Ульяновская область', 'english');
INSERT INTO emkt_regions VALUES(2901, 175, 'VGG', 'Волгоградская область', 'english');
INSERT INTO emkt_regions VALUES(2902, 175, 'VLA', 'Владимирская область', 'english');
INSERT INTO emkt_regions VALUES(2903, 175, 'VLG', 'Вологодская область', 'english');
INSERT INTO emkt_regions VALUES(2904, 175, 'VOR', 'Воронежская область', 'english');
INSERT INTO emkt_regions VALUES(2905, 175, 'PER', 'Пермский край', 'english');
INSERT INTO emkt_regions VALUES(2906, 175, 'YAN', 'Ямало-Ненецкий автономный округ', 'english');
INSERT INTO emkt_regions VALUES(2907, 175, 'YAR', 'Ярославская область', 'english');
INSERT INTO emkt_regions VALUES(2908, 175, 'YEV', 'Еврейская автономная область', 'english');

INSERT INTO emkt_countries VALUES (176,'Rwanda','english','RW','RWA','');

INSERT INTO emkt_regions VALUES(2909, 176, 'N', 'Nord', 'english');
INSERT INTO emkt_regions VALUES(2910, 176, 'E', 'Est', 'english');
INSERT INTO emkt_regions VALUES(2911, 176, 'S', 'Sud', 'english');
INSERT INTO emkt_regions VALUES(2912, 176, 'O', 'Ouest', 'english');
INSERT INTO emkt_regions VALUES(2913, 176, 'K', 'Kigali', 'english');

INSERT INTO emkt_countries VALUES (177,'Saint Kitts and Nevis','english','KN','KNA','');

INSERT INTO emkt_regions VALUES(2914, 177, 'K', 'Saint Kitts', 'english');
INSERT INTO emkt_regions VALUES(2915, 177, 'N', 'Nevis', 'english');

INSERT INTO emkt_countries VALUES (178,'Saint Lucia','english','LC','LCA','');

INSERT INTO emkt_regions VALUES(2916, 178, 'AR', 'Anse-la-Raye', 'english');
INSERT INTO emkt_regions VALUES(2917, 178, 'CA', 'Castries', 'english');
INSERT INTO emkt_regions VALUES(2918, 178, 'CH', 'Choiseul', 'english');
INSERT INTO emkt_regions VALUES(2919, 178, 'DA', 'Dauphin', 'english');
INSERT INTO emkt_regions VALUES(2920, 178, 'DE', 'Dennery', 'english');
INSERT INTO emkt_regions VALUES(2921, 178, 'GI', 'Gros-Islet', 'english');
INSERT INTO emkt_regions VALUES(2922, 178, 'LA', 'Laborie', 'english');
INSERT INTO emkt_regions VALUES(2923, 178, 'MI', 'Micoud', 'english');
INSERT INTO emkt_regions VALUES(2924, 178, 'PR', 'Praslin', 'english');
INSERT INTO emkt_regions VALUES(2925, 178, 'SO', 'Soufriere', 'english');
INSERT INTO emkt_regions VALUES(2926, 178, 'VF', 'Vieux-Fort', 'english');

INSERT INTO emkt_countries VALUES (179,'Saint Vincent and the Grenadines','english','VC','VCT','');

INSERT INTO emkt_regions VALUES(2927, 179, 'C', 'Charlotte', 'english');
INSERT INTO emkt_regions VALUES(2928, 179, 'R', 'Grenadines', 'english');
INSERT INTO emkt_regions VALUES(2929, 179, 'A', 'Saint Andrew', 'english');
INSERT INTO emkt_regions VALUES(2930, 179, 'D', 'Saint David', 'english');
INSERT INTO emkt_regions VALUES(2931, 179, 'G', 'Saint George', 'english');
INSERT INTO emkt_regions VALUES(2932, 179, 'P', 'Saint Patrick', 'english');

INSERT INTO emkt_countries VALUES (180,'Samoa','english','WS','WSM','');

INSERT INTO emkt_regions VALUES(2933, 180, 'AA', 'A\'ana', 'english');
INSERT INTO emkt_regions VALUES(2934, 180, 'AL', 'Aiga-i-le-Tai', 'english');
INSERT INTO emkt_regions VALUES(2935, 180, 'AT', 'Atua', 'english');
INSERT INTO emkt_regions VALUES(2936, 180, 'FA', 'Fa\'asaleleaga', 'english');
INSERT INTO emkt_regions VALUES(2937, 180, 'GE', 'Gaga\'emauga', 'english');
INSERT INTO emkt_regions VALUES(2938, 180, 'GI', 'Gaga\'ifomauga', 'english');
INSERT INTO emkt_regions VALUES(2939, 180, 'PA', 'Palauli', 'english');
INSERT INTO emkt_regions VALUES(2940, 180, 'SA', 'Satupa\'itea', 'english');
INSERT INTO emkt_regions VALUES(2941, 180, 'TU', 'Tuamasaga', 'english');
INSERT INTO emkt_regions VALUES(2942, 180, 'VF', 'Va\'a-o-Fonoti', 'english');
INSERT INTO emkt_regions VALUES(2943, 180, 'VS', 'Vaisigano', 'english');

INSERT INTO emkt_countries VALUES (181,'San Marino','english','SM','SMR','');

INSERT INTO emkt_regions VALUES(2944, 181, 'AC', 'Acquaviva', 'english');
INSERT INTO emkt_regions VALUES(2945, 181, 'BM', 'Borgo Maggiore', 'english');
INSERT INTO emkt_regions VALUES(2946, 181, 'CH', 'Chiesanuova', 'english');
INSERT INTO emkt_regions VALUES(2947, 181, 'DO', 'Domagnano', 'english');
INSERT INTO emkt_regions VALUES(2948, 181, 'FA', 'Faetano', 'english');
INSERT INTO emkt_regions VALUES(2949, 181, 'FI', 'Fiorentino', 'english');
INSERT INTO emkt_regions VALUES(2950, 181, 'MO', 'Montegiardino', 'english');
INSERT INTO emkt_regions VALUES(2951, 181, 'SM', 'Citta di San Marino', 'english');
INSERT INTO emkt_regions VALUES(2952, 181, 'SE', 'Serravalle', 'english');

INSERT INTO emkt_countries VALUES (182,'Sao Tome and Principe','english','ST','STP','');

INSERT INTO emkt_regions VALUES(2953, 182, 'P', 'Príncipe', 'english');
INSERT INTO emkt_regions VALUES(2954, 182, 'S', 'São Tomé', 'english');

INSERT INTO emkt_countries VALUES (183,'Saudi Arabia','english','SA','SAU','');

INSERT INTO emkt_regions VALUES(2955, 183, '01', 'الرياض', 'english');
INSERT INTO emkt_regions VALUES(2956, 183, '02', 'مكة المكرمة', 'english');
INSERT INTO emkt_regions VALUES(2957, 183, '03', 'المدينه', 'english');
INSERT INTO emkt_regions VALUES(2958, 183, '04', 'الشرقية', 'english');
INSERT INTO emkt_regions VALUES(2959, 183, '05', 'القصيم', 'english');
INSERT INTO emkt_regions VALUES(2960, 183, '06', 'حائل', 'english');
INSERT INTO emkt_regions VALUES(2961, 183, '07', 'تبوك', 'english');
INSERT INTO emkt_regions VALUES(2962, 183, '08', 'الحدود الشمالية', 'english');
INSERT INTO emkt_regions VALUES(2963, 183, '09', 'جيزان', 'english');
INSERT INTO emkt_regions VALUES(2964, 183, '10', 'نجران', 'english');
INSERT INTO emkt_regions VALUES(2965, 183, '11', 'الباحة', 'english');
INSERT INTO emkt_regions VALUES(2966, 183, '12', 'الجوف', 'english');
INSERT INTO emkt_regions VALUES(2967, 183, '14', 'عسير', 'english');

INSERT INTO emkt_countries VALUES (184,'Senegal','english','SN','SEN','');

INSERT INTO emkt_regions VALUES(2968, 184, 'DA', 'Dakar', 'english');
INSERT INTO emkt_regions VALUES(2969, 184, 'DI', 'Diourbel', 'english');
INSERT INTO emkt_regions VALUES(2970, 184, 'FA', 'Fatick', 'english');
INSERT INTO emkt_regions VALUES(2971, 184, 'KA', 'Kaolack', 'english');
INSERT INTO emkt_regions VALUES(2972, 184, 'KO', 'Kolda', 'english');
INSERT INTO emkt_regions VALUES(2973, 184, 'LO', 'Louga', 'english');
INSERT INTO emkt_regions VALUES(2974, 184, 'MA', 'Matam', 'english');
INSERT INTO emkt_regions VALUES(2975, 184, 'SL', 'Saint-Louis', 'english');
INSERT INTO emkt_regions VALUES(2976, 184, 'TA', 'Tambacounda', 'english');
INSERT INTO emkt_regions VALUES(2977, 184, 'TH', 'Thies', 'english');
INSERT INTO emkt_regions VALUES(2978, 184, 'ZI', 'Ziguinchor', 'english');

INSERT INTO emkt_countries VALUES (185,'Seychelles','english','SC','SYC','');

INSERT INTO emkt_regions VALUES(2979, 185, 'AP', 'Anse aux Pins', 'english');
INSERT INTO emkt_regions VALUES(2980, 185, 'AB', 'Anse Boileau', 'english');
INSERT INTO emkt_regions VALUES(2981, 185, 'AE', 'Anse Etoile', 'english');
INSERT INTO emkt_regions VALUES(2982, 185, 'AL', 'Anse Louis', 'english');
INSERT INTO emkt_regions VALUES(2983, 185, 'AR', 'Anse Royale', 'english');
INSERT INTO emkt_regions VALUES(2984, 185, 'BL', 'Baie Lazare', 'english');
INSERT INTO emkt_regions VALUES(2985, 185, 'BS', 'Baie Sainte Anne', 'english');
INSERT INTO emkt_regions VALUES(2986, 185, 'BV', 'Beau Vallon', 'english');
INSERT INTO emkt_regions VALUES(2987, 185, 'BA', 'Bel Air', 'english');
INSERT INTO emkt_regions VALUES(2988, 185, 'BO', 'Bel Ombre', 'english');
INSERT INTO emkt_regions VALUES(2989, 185, 'CA', 'Cascade', 'english');
INSERT INTO emkt_regions VALUES(2990, 185, 'GL', 'Glacis', 'english');
INSERT INTO emkt_regions VALUES(2991, 185, 'GM', 'Grand\' Anse (on Mahe)', 'english');
INSERT INTO emkt_regions VALUES(2992, 185, 'GP', 'Grand\' Anse (on Praslin)', 'english');
INSERT INTO emkt_regions VALUES(2993, 185, 'DG', 'La Digue', 'english');
INSERT INTO emkt_regions VALUES(2994, 185, 'RA', 'La Riviere Anglaise', 'english');
INSERT INTO emkt_regions VALUES(2995, 185, 'MB', 'Mont Buxton', 'english');
INSERT INTO emkt_regions VALUES(2996, 185, 'MF', 'Mont Fleuri', 'english');
INSERT INTO emkt_regions VALUES(2997, 185, 'PL', 'Plaisance', 'english');
INSERT INTO emkt_regions VALUES(2998, 185, 'PR', 'Pointe La Rue', 'english');
INSERT INTO emkt_regions VALUES(2999, 185, 'PG', 'Port Glaud', 'english');
INSERT INTO emkt_regions VALUES(3000, 185, 'SL', 'Saint Louis', 'english');
INSERT INTO emkt_regions VALUES(3001, 185, 'TA', 'Takamaka', 'english');

INSERT INTO emkt_countries VALUES (186,'Sierra Leone','english','SL','SLE','');

INSERT INTO emkt_regions VALUES(3002, 186, 'E', 'Eastern', 'english');
INSERT INTO emkt_regions VALUES(3003, 186, 'N', 'Northern', 'english');
INSERT INTO emkt_regions VALUES(3004, 186, 'S', 'Southern', 'english');
INSERT INTO emkt_regions VALUES(3005, 186, 'W', 'Western', 'english');

INSERT INTO emkt_countries VALUES (187,'Singapore','english','SG','SGP','');

INSERT INTO emkt_regions VALUES(4273, 187, 'NOCODE', 'Singapore', 'english');

INSERT INTO emkt_countries VALUES (188,'Slovakia','english','SK','SVK','');

INSERT INTO emkt_regions VALUES(3006, 188, 'BC', 'Banskobystrický kraj', 'english');
INSERT INTO emkt_regions VALUES(3007, 188, 'BL', 'Bratislavský kraj', 'english');
INSERT INTO emkt_regions VALUES(3008, 188, 'KI', 'Košický kraj', 'english');
INSERT INTO emkt_regions VALUES(3009, 188, 'NJ', 'Nitrianský kraj', 'english');
INSERT INTO emkt_regions VALUES(3010, 188, 'PV', 'Prešovský kraj', 'english');
INSERT INTO emkt_regions VALUES(3011, 188, 'TA', 'Trnavský kraj', 'english');
INSERT INTO emkt_regions VALUES(3012, 188, 'TC', 'Trenčianský kraj', 'english');
INSERT INTO emkt_regions VALUES(3013, 188, 'ZI', 'Žilinský kraj', 'english');

INSERT INTO emkt_countries VALUES (189,'Slovenia','english','SI','SVN','');

INSERT INTO emkt_regions VALUES(3014, 189, '001', 'Ajdovščina', 'english');
INSERT INTO emkt_regions VALUES(3015, 189, '002', 'Beltinci', 'english');
INSERT INTO emkt_regions VALUES(3016, 189, '003', 'Bled', 'english');
INSERT INTO emkt_regions VALUES(3017, 189, '004', 'Bohinj', 'english');
INSERT INTO emkt_regions VALUES(3018, 189, '005', 'Borovnica', 'english');
INSERT INTO emkt_regions VALUES(3019, 189, '006', 'Bovec', 'english');
INSERT INTO emkt_regions VALUES(3020, 189, '007', 'Brda', 'english');
INSERT INTO emkt_regions VALUES(3021, 189, '008', 'Brezovica', 'english');
INSERT INTO emkt_regions VALUES(3022, 189, '009', 'Brežice', 'english');
INSERT INTO emkt_regions VALUES(3023, 189, '010', 'Tišina', 'english');
INSERT INTO emkt_regions VALUES(3024, 189, '011', 'Celje', 'english');
INSERT INTO emkt_regions VALUES(3025, 189, '012', 'Cerklje na Gorenjskem', 'english');
INSERT INTO emkt_regions VALUES(3026, 189, '013', 'Cerknica', 'english');
INSERT INTO emkt_regions VALUES(3027, 189, '014', 'Cerkno', 'english');
INSERT INTO emkt_regions VALUES(3028, 189, '015', 'Črenšovci', 'english');
INSERT INTO emkt_regions VALUES(3029, 189, '016', 'Črna na Koroškem', 'english');
INSERT INTO emkt_regions VALUES(3030, 189, '017', 'Črnomelj', 'english');
INSERT INTO emkt_regions VALUES(3031, 189, '018', 'Destrnik', 'english');
INSERT INTO emkt_regions VALUES(3032, 189, '019', 'Divača', 'english');
INSERT INTO emkt_regions VALUES(3033, 189, '020', 'Dobrepolje', 'english');
INSERT INTO emkt_regions VALUES(3034, 189, '021', 'Dobrova-Polhov Gradec', 'english');
INSERT INTO emkt_regions VALUES(3035, 189, '022', 'Dol pri Ljubljani', 'english');
INSERT INTO emkt_regions VALUES(3036, 189, '023', 'Domžale', 'english');
INSERT INTO emkt_regions VALUES(3037, 189, '024', 'Dornava', 'english');
INSERT INTO emkt_regions VALUES(3038, 189, '025', 'Dravograd', 'english');
INSERT INTO emkt_regions VALUES(3039, 189, '026', 'Duplek', 'english');
INSERT INTO emkt_regions VALUES(3040, 189, '027', 'Gorenja vas-Poljane', 'english');
INSERT INTO emkt_regions VALUES(3041, 189, '028', 'Gorišnica', 'english');
INSERT INTO emkt_regions VALUES(3042, 189, '029', 'Gornja Radgona', 'english');
INSERT INTO emkt_regions VALUES(3043, 189, '030', 'Gornji Grad', 'english');
INSERT INTO emkt_regions VALUES(3044, 189, '031', 'Gornji Petrovci', 'english');
INSERT INTO emkt_regions VALUES(3045, 189, '032', 'Grosuplje', 'english');
INSERT INTO emkt_regions VALUES(3046, 189, '033', 'Šalovci', 'english');
INSERT INTO emkt_regions VALUES(3047, 189, '034', 'Hrastnik', 'english');
INSERT INTO emkt_regions VALUES(3048, 189, '035', 'Hrpelje-Kozina', 'english');
INSERT INTO emkt_regions VALUES(3049, 189, '036', 'Idrija', 'english');
INSERT INTO emkt_regions VALUES(3050, 189, '037', 'Ig', 'english');
INSERT INTO emkt_regions VALUES(3051, 189, '038', 'Ilirska Bistrica', 'english');
INSERT INTO emkt_regions VALUES(3052, 189, '039', 'Ivančna Gorica', 'english');
INSERT INTO emkt_regions VALUES(3053, 189, '040', 'Izola', 'english');
INSERT INTO emkt_regions VALUES(3054, 189, '041', 'Jesenice', 'english');
INSERT INTO emkt_regions VALUES(3055, 189, '042', 'Juršinci', 'english');
INSERT INTO emkt_regions VALUES(3056, 189, '043', 'Kamnik', 'english');
INSERT INTO emkt_regions VALUES(3057, 189, '044', 'Kanal ob Soči', 'english');
INSERT INTO emkt_regions VALUES(3058, 189, '045', 'Kidričevo', 'english');
INSERT INTO emkt_regions VALUES(3059, 189, '046', 'Kobarid', 'english');
INSERT INTO emkt_regions VALUES(3060, 189, '047', 'Kobilje', 'english');
INSERT INTO emkt_regions VALUES(3061, 189, '048', 'Kočevje', 'english');
INSERT INTO emkt_regions VALUES(3062, 189, '049', 'Komen', 'english');
INSERT INTO emkt_regions VALUES(3063, 189, '050', 'Koper', 'english');
INSERT INTO emkt_regions VALUES(3064, 189, '051', 'Kozje', 'english');
INSERT INTO emkt_regions VALUES(3065, 189, '052', 'Kranj', 'english');
INSERT INTO emkt_regions VALUES(3066, 189, '053', 'Kranjska Gora', 'english');
INSERT INTO emkt_regions VALUES(3067, 189, '054', 'Krško', 'english');
INSERT INTO emkt_regions VALUES(3068, 189, '055', 'Kungota', 'english');
INSERT INTO emkt_regions VALUES(3069, 189, '056', 'Kuzma', 'english');
INSERT INTO emkt_regions VALUES(3070, 189, '057', 'Laško', 'english');
INSERT INTO emkt_regions VALUES(3071, 189, '058', 'Lenart', 'english');
INSERT INTO emkt_regions VALUES(3072, 189, '059', 'Lendava', 'english');
INSERT INTO emkt_regions VALUES(3073, 189, '060', 'Litija', 'english');
INSERT INTO emkt_regions VALUES(3074, 189, '061', 'Ljubljana', 'english');
INSERT INTO emkt_regions VALUES(3075, 189, '062', 'Ljubno', 'english');
INSERT INTO emkt_regions VALUES(3076, 189, '063', 'Ljutomer', 'english');
INSERT INTO emkt_regions VALUES(3077, 189, '064', 'Logatec', 'english');
INSERT INTO emkt_regions VALUES(3078, 189, '065', 'Loška Dolina', 'english');
INSERT INTO emkt_regions VALUES(3079, 189, '066', 'Loški Potok', 'english');
INSERT INTO emkt_regions VALUES(3080, 189, '067', 'Luče', 'english');
INSERT INTO emkt_regions VALUES(3081, 189, '068', 'Lukovica', 'english');
INSERT INTO emkt_regions VALUES(3082, 189, '069', 'Majšperk', 'english');
INSERT INTO emkt_regions VALUES(3083, 189, '070', 'Maribor', 'english');
INSERT INTO emkt_regions VALUES(3084, 189, '071', 'Medvode', 'english');
INSERT INTO emkt_regions VALUES(3085, 189, '072', 'Mengeš', 'english');
INSERT INTO emkt_regions VALUES(3086, 189, '073', 'Metlika', 'english');
INSERT INTO emkt_regions VALUES(3087, 189, '074', 'Mežica', 'english');
INSERT INTO emkt_regions VALUES(3088, 189, '075', 'Miren-Kostanjevica', 'english');
INSERT INTO emkt_regions VALUES(3089, 189, '076', 'Mislinja', 'english');
INSERT INTO emkt_regions VALUES(3090, 189, '077', 'Moravče', 'english');
INSERT INTO emkt_regions VALUES(3091, 189, '078', 'Moravske Toplice', 'english');
INSERT INTO emkt_regions VALUES(3092, 189, '079', 'Mozirje', 'english');
INSERT INTO emkt_regions VALUES(3093, 189, '080', 'Murska Sobota', 'english');
INSERT INTO emkt_regions VALUES(3094, 189, '081', 'Muta', 'english');
INSERT INTO emkt_regions VALUES(3095, 189, '082', 'Naklo', 'english');
INSERT INTO emkt_regions VALUES(3096, 189, '083', 'Nazarje', 'english');
INSERT INTO emkt_regions VALUES(3097, 189, '084', 'Nova Gorica', 'english');
INSERT INTO emkt_regions VALUES(3098, 189, '085', 'Novo mesto', 'english');
INSERT INTO emkt_regions VALUES(3099, 189, '086', 'Odranci', 'english');
INSERT INTO emkt_regions VALUES(3100, 189, '087', 'Ormož', 'english');
INSERT INTO emkt_regions VALUES(3101, 189, '088', 'Osilnica', 'english');
INSERT INTO emkt_regions VALUES(3102, 189, '089', 'Pesnica', 'english');
INSERT INTO emkt_regions VALUES(3103, 189, '090', 'Piran', 'english');
INSERT INTO emkt_regions VALUES(3104, 189, '091', 'Pivka', 'english');
INSERT INTO emkt_regions VALUES(3105, 189, '092', 'Podčetrtek', 'english');
INSERT INTO emkt_regions VALUES(3106, 189, '093', 'Podvelka', 'english');
INSERT INTO emkt_regions VALUES(3107, 189, '094', 'Postojna', 'english');
INSERT INTO emkt_regions VALUES(3108, 189, '095', 'Preddvor', 'english');
INSERT INTO emkt_regions VALUES(3109, 189, '096', 'Ptuj', 'english');
INSERT INTO emkt_regions VALUES(3110, 189, '097', 'Puconci', 'english');
INSERT INTO emkt_regions VALUES(3111, 189, '098', 'Rače-Fram', 'english');
INSERT INTO emkt_regions VALUES(3112, 189, '099', 'Radeče', 'english');
INSERT INTO emkt_regions VALUES(3113, 189, '100', 'Radenci', 'english');
INSERT INTO emkt_regions VALUES(3114, 189, '101', 'Radlje ob Dravi', 'english');
INSERT INTO emkt_regions VALUES(3115, 189, '102', 'Radovljica', 'english');
INSERT INTO emkt_regions VALUES(3116, 189, '103', 'Ravne na Koroškem', 'english');
INSERT INTO emkt_regions VALUES(3117, 189, '104', 'Ribnica', 'english');
INSERT INTO emkt_regions VALUES(3118, 189, '106', 'Rogaška Slatina', 'english');
INSERT INTO emkt_regions VALUES(3119, 189, '105', 'Rogašovci', 'english');
INSERT INTO emkt_regions VALUES(3120, 189, '107', 'Rogatec', 'english');
INSERT INTO emkt_regions VALUES(3121, 189, '108', 'Ruše', 'english');
INSERT INTO emkt_regions VALUES(3122, 189, '109', 'Semič', 'english');
INSERT INTO emkt_regions VALUES(3123, 189, '110', 'Sevnica', 'english');
INSERT INTO emkt_regions VALUES(3124, 189, '111', 'Sežana', 'english');
INSERT INTO emkt_regions VALUES(3125, 189, '112', 'Slovenj Gradec', 'english');
INSERT INTO emkt_regions VALUES(3126, 189, '113', 'Slovenska Bistrica', 'english');
INSERT INTO emkt_regions VALUES(3127, 189, '114', 'Slovenske Konjice', 'english');
INSERT INTO emkt_regions VALUES(3128, 189, '115', 'Starše', 'english');
INSERT INTO emkt_regions VALUES(3129, 189, '116', 'Sveti Jurij', 'english');
INSERT INTO emkt_regions VALUES(3130, 189, '117', 'Šenčur', 'english');
INSERT INTO emkt_regions VALUES(3131, 189, '118', 'Šentilj', 'english');
INSERT INTO emkt_regions VALUES(3132, 189, '119', 'Šentjernej', 'english');
INSERT INTO emkt_regions VALUES(3133, 189, '120', 'Šentjur pri Celju', 'english');
INSERT INTO emkt_regions VALUES(3134, 189, '121', 'Škocjan', 'english');
INSERT INTO emkt_regions VALUES(3135, 189, '122', 'Škofja Loka', 'english');
INSERT INTO emkt_regions VALUES(3136, 189, '123', 'Škofljica', 'english');
INSERT INTO emkt_regions VALUES(3137, 189, '124', 'Šmarje pri Jelšah', 'english');
INSERT INTO emkt_regions VALUES(3138, 189, '125', 'Šmartno ob Paki', 'english');
INSERT INTO emkt_regions VALUES(3139, 189, '126', 'Šoštanj', 'english');
INSERT INTO emkt_regions VALUES(3140, 189, '127', 'Štore', 'english');
INSERT INTO emkt_regions VALUES(3141, 189, '128', 'Tolmin', 'english');
INSERT INTO emkt_regions VALUES(3142, 189, '129', 'Trbovlje', 'english');
INSERT INTO emkt_regions VALUES(3143, 189, '130', 'Trebnje', 'english');
INSERT INTO emkt_regions VALUES(3144, 189, '131', 'Tržič', 'english');
INSERT INTO emkt_regions VALUES(3145, 189, '132', 'Turnišče', 'english');
INSERT INTO emkt_regions VALUES(3146, 189, '133', 'Velenje', 'english');
INSERT INTO emkt_regions VALUES(3147, 189, '134', 'Velike Lašče', 'english');
INSERT INTO emkt_regions VALUES(3148, 189, '135', 'Videm', 'english');
INSERT INTO emkt_regions VALUES(3149, 189, '136', 'Vipava', 'english');
INSERT INTO emkt_regions VALUES(3150, 189, '137', 'Vitanje', 'english');
INSERT INTO emkt_regions VALUES(3151, 189, '138', 'Vodice', 'english');
INSERT INTO emkt_regions VALUES(3152, 189, '139', 'Vojnik', 'english');
INSERT INTO emkt_regions VALUES(3153, 189, '140', 'Vrhnika', 'english');
INSERT INTO emkt_regions VALUES(3154, 189, '141', 'Vuzenica', 'english');
INSERT INTO emkt_regions VALUES(3155, 189, '142', 'Zagorje ob Savi', 'english');
INSERT INTO emkt_regions VALUES(3156, 189, '143', 'Zavrč', 'english');
INSERT INTO emkt_regions VALUES(3157, 189, '144', 'Zreče', 'english');
INSERT INTO emkt_regions VALUES(3158, 189, '146', 'Železniki', 'english');
INSERT INTO emkt_regions VALUES(3159, 189, '147', 'Žiri', 'english');
INSERT INTO emkt_regions VALUES(3160, 189, '148', 'Benedikt', 'english');
INSERT INTO emkt_regions VALUES(3161, 189, '149', 'Bistrica ob Sotli', 'english');
INSERT INTO emkt_regions VALUES(3162, 189, '150', 'Bloke', 'english');
INSERT INTO emkt_regions VALUES(3163, 189, '151', 'Braslovče', 'english');
INSERT INTO emkt_regions VALUES(3164, 189, '152', 'Cankova', 'english');
INSERT INTO emkt_regions VALUES(3165, 189, '153', 'Cerkvenjak', 'english');
INSERT INTO emkt_regions VALUES(3166, 189, '154', 'Dobje', 'english');
INSERT INTO emkt_regions VALUES(3167, 189, '155', 'Dobrna', 'english');
INSERT INTO emkt_regions VALUES(3168, 189, '156', 'Dobrovnik', 'english');
INSERT INTO emkt_regions VALUES(3169, 189, '157', 'Dolenjske Toplice', 'english');
INSERT INTO emkt_regions VALUES(3170, 189, '158', 'Grad', 'english');
INSERT INTO emkt_regions VALUES(3171, 189, '159', 'Hajdina', 'english');
INSERT INTO emkt_regions VALUES(3172, 189, '160', 'Hoče-Slivnica', 'english');
INSERT INTO emkt_regions VALUES(3173, 189, '161', 'Hodoš', 'english');
INSERT INTO emkt_regions VALUES(3174, 189, '162', 'Horjul', 'english');
INSERT INTO emkt_regions VALUES(3175, 189, '163', 'Jezersko', 'english');
INSERT INTO emkt_regions VALUES(3176, 189, '164', 'Komenda', 'english');
INSERT INTO emkt_regions VALUES(3177, 189, '165', 'Kostel', 'english');
INSERT INTO emkt_regions VALUES(3178, 189, '166', 'Križevci', 'english');
INSERT INTO emkt_regions VALUES(3179, 189, '167', 'Lovrenc na Pohorju', 'english');
INSERT INTO emkt_regions VALUES(3180, 189, '168', 'Markovci', 'english');
INSERT INTO emkt_regions VALUES(3181, 189, '169', 'Miklavž na Dravskem polju', 'english');
INSERT INTO emkt_regions VALUES(3182, 189, '170', 'Mirna Peč', 'english');
INSERT INTO emkt_regions VALUES(3183, 189, '171', 'Oplotnica', 'english');
INSERT INTO emkt_regions VALUES(3184, 189, '172', 'Podlehnik', 'english');
INSERT INTO emkt_regions VALUES(3185, 189, '173', 'Polzela', 'english');
INSERT INTO emkt_regions VALUES(3186, 189, '174', 'Prebold', 'english');
INSERT INTO emkt_regions VALUES(3187, 189, '175', 'Prevalje', 'english');
INSERT INTO emkt_regions VALUES(3188, 189, '176', 'Razkrižje', 'english');
INSERT INTO emkt_regions VALUES(3189, 189, '177', 'Ribnica na Pohorju', 'english');
INSERT INTO emkt_regions VALUES(3190, 189, '178', 'Selnica ob Dravi', 'english');
INSERT INTO emkt_regions VALUES(3191, 189, '179', 'Sodražica', 'english');
INSERT INTO emkt_regions VALUES(3192, 189, '180', 'Solčava', 'english');
INSERT INTO emkt_regions VALUES(3193, 189, '181', 'Sveta Ana', 'english');
INSERT INTO emkt_regions VALUES(3194, 189, '182', 'Sveti Andraž v Slovenskih goricah', 'english');
INSERT INTO emkt_regions VALUES(3195, 189, '183', 'Šempeter-Vrtojba', 'english');
INSERT INTO emkt_regions VALUES(3196, 189, '184', 'Tabor', 'english');
INSERT INTO emkt_regions VALUES(3197, 189, '185', 'Trnovska vas', 'english');
INSERT INTO emkt_regions VALUES(3198, 189, '186', 'Trzin', 'english');
INSERT INTO emkt_regions VALUES(3199, 189, '187', 'Velika Polana', 'english');
INSERT INTO emkt_regions VALUES(3200, 189, '188', 'Veržej', 'english');
INSERT INTO emkt_regions VALUES(3201, 189, '189', 'Vransko', 'english');
INSERT INTO emkt_regions VALUES(3202, 189, '190', 'Žalec', 'english');
INSERT INTO emkt_regions VALUES(3203, 189, '191', 'Žetale', 'english');
INSERT INTO emkt_regions VALUES(3204, 189, '192', 'Žirovnica', 'english');
INSERT INTO emkt_regions VALUES(3205, 189, '193', 'Žužemberk', 'english');
INSERT INTO emkt_regions VALUES(3206, 189, '194', 'Šmartno pri Litiji', 'english');

INSERT INTO emkt_countries VALUES (190,'Solomon Islands','english','SB','SLB','');

INSERT INTO emkt_regions VALUES(3207, 190, 'CE', 'Central', 'english');
INSERT INTO emkt_regions VALUES(3208, 190, 'CH', 'Choiseul', 'english');
INSERT INTO emkt_regions VALUES(3209, 190, 'GC', 'Guadalcanal', 'english');
INSERT INTO emkt_regions VALUES(3210, 190, 'HO', 'Honiara', 'english');
INSERT INTO emkt_regions VALUES(3211, 190, 'IS', 'Isabel', 'english');
INSERT INTO emkt_regions VALUES(3212, 190, 'MK', 'Makira', 'english');
INSERT INTO emkt_regions VALUES(3213, 190, 'ML', 'Malaita', 'english');
INSERT INTO emkt_regions VALUES(3214, 190, 'RB', 'Rennell and Bellona', 'english');
INSERT INTO emkt_regions VALUES(3215, 190, 'TM', 'Temotu', 'english');
INSERT INTO emkt_regions VALUES(3216, 190, 'WE', 'Western', 'english');

INSERT INTO emkt_countries VALUES (191,'Somalia','english','SO','SOM','');

INSERT INTO emkt_regions VALUES(3217, 191, 'AD', 'Awdal', 'english');
INSERT INTO emkt_regions VALUES(3218, 191, 'BK', 'Bakool', 'english');
INSERT INTO emkt_regions VALUES(3219, 191, 'BN', 'Banaadir', 'english');
INSERT INTO emkt_regions VALUES(3220, 191, 'BR', 'Bari', 'english');
INSERT INTO emkt_regions VALUES(3221, 191, 'BY', 'Bay', 'english');
INSERT INTO emkt_regions VALUES(3222, 191, 'GD', 'Gedo', 'english');
INSERT INTO emkt_regions VALUES(3223, 191, 'GG', 'Galguduud', 'english');
INSERT INTO emkt_regions VALUES(3224, 191, 'HR', 'Hiiraan', 'english');
INSERT INTO emkt_regions VALUES(3225, 191, 'JD', 'Jubbada Dhexe', 'english');
INSERT INTO emkt_regions VALUES(3226, 191, 'JH', 'Jubbada Hoose', 'english');
INSERT INTO emkt_regions VALUES(3227, 191, 'MD', 'Mudug', 'english');
INSERT INTO emkt_regions VALUES(3228, 191, 'NG', 'Nugaal', 'english');
INSERT INTO emkt_regions VALUES(3229, 191, 'SD', 'Shabeellaha Dhexe', 'english');
INSERT INTO emkt_regions VALUES(3230, 191, 'SG', 'Sanaag', 'english');
INSERT INTO emkt_regions VALUES(3231, 191, 'SH', 'Shabeellaha Hoose', 'english');
INSERT INTO emkt_regions VALUES(3232, 191, 'SL', 'Sool', 'english');
INSERT INTO emkt_regions VALUES(3233, 191, 'TG', 'Togdheer', 'english');
INSERT INTO emkt_regions VALUES(3234, 191, 'WG', 'Woqooyi Galbeed', 'english');

INSERT INTO emkt_countries VALUES (192,'South Africa','english','ZA','ZAF','');

INSERT INTO emkt_regions VALUES(3235, 192, 'EC', 'Eastern Cape', 'english');
INSERT INTO emkt_regions VALUES(3236, 192, 'FS', 'Free State', 'english');
INSERT INTO emkt_regions VALUES(3237, 192, 'GT', 'Gauteng', 'english');
INSERT INTO emkt_regions VALUES(3238, 192, 'LP', 'Limpopo', 'english');
INSERT INTO emkt_regions VALUES(3239, 192, 'MP', 'Mpumalanga', 'english');
INSERT INTO emkt_regions VALUES(3240, 192, 'NC', 'Northern Cape', 'english');
INSERT INTO emkt_regions VALUES(3241, 192, 'NL', 'KwaZulu-Natal', 'english');
INSERT INTO emkt_regions VALUES(3242, 192, 'NW', 'North-West', 'english');
INSERT INTO emkt_regions VALUES(3243, 192, 'WC', 'Western Cape', 'english');

INSERT INTO emkt_countries VALUES (193,'South Georgia and the South Sandwich Islands','english','GS','SGS','');

INSERT INTO emkt_regions VALUES(4274, 193, 'NOCODE', 'South Georgia and the South Sandwich Islands', 'english');

INSERT INTO emkt_countries VALUES (194,'Spain','english','ES','ESP','');

INSERT INTO emkt_regions VALUES(3244, 194, 'AN', 'Andalucía', 'english');
INSERT INTO emkt_regions VALUES(3245, 194, 'AR', 'Aragón', 'english');
INSERT INTO emkt_regions VALUES(3246, 194, 'A', 'Alicante', 'english');
INSERT INTO emkt_regions VALUES(3247, 194, 'AB', 'Albacete', 'english');
INSERT INTO emkt_regions VALUES(3248, 194, 'AL', 'Almería', 'english');
INSERT INTO emkt_regions VALUES(3249, 194, 'AN', 'Andalucía', 'english');
INSERT INTO emkt_regions VALUES(3250, 194, 'AV', 'Ávila', 'english');
INSERT INTO emkt_regions VALUES(3251, 194, 'B', 'Barcelona', 'english');
INSERT INTO emkt_regions VALUES(3252, 194, 'BA', 'Badajoz', 'english');
INSERT INTO emkt_regions VALUES(3253, 194, 'BI', 'Vizcaya', 'english');
INSERT INTO emkt_regions VALUES(3254, 194, 'BU', 'Burgos', 'english');
INSERT INTO emkt_regions VALUES(3255, 194, 'C', 'A Coruña', 'english');
INSERT INTO emkt_regions VALUES(3256, 194, 'CA', 'Cádiz', 'english');
INSERT INTO emkt_regions VALUES(3257, 194, 'CC', 'Cáceres', 'english');
INSERT INTO emkt_regions VALUES(3258, 194, 'CE', 'Ceuta', 'english');
INSERT INTO emkt_regions VALUES(3259, 194, 'CL', 'Castilla y León', 'english');
INSERT INTO emkt_regions VALUES(3260, 194, 'CM', 'Castilla-La Mancha', 'english');
INSERT INTO emkt_regions VALUES(3261, 194, 'CN', 'Islas Canarias', 'english');
INSERT INTO emkt_regions VALUES(3262, 194, 'CO', 'Córdoba', 'english');
INSERT INTO emkt_regions VALUES(3263, 194, 'CR', 'Ciudad Real', 'english');
INSERT INTO emkt_regions VALUES(3264, 194, 'CS', 'Castellón', 'english');
INSERT INTO emkt_regions VALUES(3265, 194, 'CT', 'Catalonia', 'english');
INSERT INTO emkt_regions VALUES(3266, 194, 'CU', 'Cuenca', 'english');
INSERT INTO emkt_regions VALUES(3267, 194, 'EX', 'Extremadura', 'english');
INSERT INTO emkt_regions VALUES(3268, 194, 'GA', 'Galicia', 'english');
INSERT INTO emkt_regions VALUES(3269, 194, 'GC', 'Las Palmas', 'english');
INSERT INTO emkt_regions VALUES(3270, 194, 'GI', 'Girona', 'english');
INSERT INTO emkt_regions VALUES(3271, 194, 'GR', 'Granada', 'english');
INSERT INTO emkt_regions VALUES(3272, 194, 'GU', 'Guadalajara', 'english');
INSERT INTO emkt_regions VALUES(3273, 194, 'H', 'Huelva', 'english');
INSERT INTO emkt_regions VALUES(3274, 194, 'HU', 'Huesca', 'english');
INSERT INTO emkt_regions VALUES(3275, 194, 'IB', 'Islas Baleares', 'english');
INSERT INTO emkt_regions VALUES(3276, 194, 'J', 'Jaén', 'english');
INSERT INTO emkt_regions VALUES(3277, 194, 'L', 'Lleida', 'english');
INSERT INTO emkt_regions VALUES(3278, 194, 'LE', 'León', 'english');
INSERT INTO emkt_regions VALUES(3279, 194, 'LO', 'La Rioja', 'english');
INSERT INTO emkt_regions VALUES(3280, 194, 'LU', 'Lugo', 'english');
INSERT INTO emkt_regions VALUES(3281, 194, 'M', 'Madrid', 'english');
INSERT INTO emkt_regions VALUES(3282, 194, 'MA', 'Málaga', 'english');
INSERT INTO emkt_regions VALUES(3283, 194, 'ML', 'Melilla', 'english');
INSERT INTO emkt_regions VALUES(3284, 194, 'MU', 'Murcia', 'english');
INSERT INTO emkt_regions VALUES(3285, 194, 'NA', 'Navarre', 'english');
INSERT INTO emkt_regions VALUES(3286, 194, 'O', 'Asturias', 'english');
INSERT INTO emkt_regions VALUES(3287, 194, 'OR', 'Ourense', 'english');
INSERT INTO emkt_regions VALUES(3288, 194, 'P', 'Palencia', 'english');
INSERT INTO emkt_regions VALUES(3289, 194, 'PM', 'Baleares', 'english');
INSERT INTO emkt_regions VALUES(3290, 194, 'PO', 'Pontevedra', 'english');
INSERT INTO emkt_regions VALUES(3291, 194, 'PV', 'Basque Euskadi', 'english');
INSERT INTO emkt_regions VALUES(3292, 194, 'S', 'Cantabria', 'english');
INSERT INTO emkt_regions VALUES(3293, 194, 'SA', 'Salamanca', 'english');
INSERT INTO emkt_regions VALUES(3294, 194, 'SE', 'Seville', 'english');
INSERT INTO emkt_regions VALUES(3295, 194, 'SG', 'Segovia', 'english');
INSERT INTO emkt_regions VALUES(3296, 194, 'SO', 'Soria', 'english');
INSERT INTO emkt_regions VALUES(3297, 194, 'SS', 'Guipúzcoa', 'english');
INSERT INTO emkt_regions VALUES(3298, 194, 'T', 'Tarragona', 'english');
INSERT INTO emkt_regions VALUES(3299, 194, 'TE', 'Teruel', 'english');
INSERT INTO emkt_regions VALUES(3300, 194, 'TF', 'Santa Cruz De Tenerife', 'english');
INSERT INTO emkt_regions VALUES(3301, 194, 'TO', 'Toledo', 'english');
INSERT INTO emkt_regions VALUES(3302, 194, 'V', 'Valencia', 'english');
INSERT INTO emkt_regions VALUES(3303, 194, 'VA', 'Valladolid', 'english');
INSERT INTO emkt_regions VALUES(3304, 194, 'VI', 'Álava', 'english');
INSERT INTO emkt_regions VALUES(3305, 194, 'Z', 'Zaragoza', 'english');
INSERT INTO emkt_regions VALUES(3306, 194, 'ZA', 'Zamora', 'english');

INSERT INTO emkt_countries VALUES (195,'Sri Lanka','english','LK','LKA','');

INSERT INTO emkt_regions VALUES(3307, 195, 'CE', 'Central', 'english');
INSERT INTO emkt_regions VALUES(3308, 195, 'NC', 'North Central', 'english');
INSERT INTO emkt_regions VALUES(3309, 195, 'NO', 'North', 'english');
INSERT INTO emkt_regions VALUES(3310, 195, 'EA', 'Eastern', 'english');
INSERT INTO emkt_regions VALUES(3311, 195, 'NW', 'North Western', 'english');
INSERT INTO emkt_regions VALUES(3312, 195, 'SO', 'Southern', 'english');
INSERT INTO emkt_regions VALUES(3313, 195, 'UV', 'Uva', 'english');
INSERT INTO emkt_regions VALUES(3314, 195, 'SA', 'Sabaragamuwa', 'english');
INSERT INTO emkt_regions VALUES(3315, 195, 'WE', 'Western', 'english');

INSERT INTO emkt_countries VALUES (196,'St. Helena','english','SH','SHN','');

INSERT INTO emkt_regions VALUES(4275, 196, 'NOCODE', 'St. Helena', 'english');

INSERT INTO emkt_countries VALUES (197,'St. Pierre and Miquelon','english','PM','SPM','');

INSERT INTO emkt_regions VALUES(4276, 197, 'NOCODE', 'St. Pierre and Miquelon', 'english');

INSERT INTO emkt_countries VALUES (198,'Sudan','english','SD','SDN','');

INSERT INTO emkt_regions VALUES(3316, 198, 'ANL', 'أعالي النيل', 'english');
INSERT INTO emkt_regions VALUES(3317, 198, 'BAM', 'البحر الأحمر', 'english');
INSERT INTO emkt_regions VALUES(3318, 198, 'BRT', 'البحيرات', 'english');
INSERT INTO emkt_regions VALUES(3319, 198, 'JZR', 'ولاية الجزيرة', 'english');
INSERT INTO emkt_regions VALUES(3320, 198, 'KRT', 'الخرطوم', 'english');
INSERT INTO emkt_regions VALUES(3321, 198, 'QDR', 'القضارف', 'english');
INSERT INTO emkt_regions VALUES(3322, 198, 'WDH', 'الوحدة', 'english');
INSERT INTO emkt_regions VALUES(3323, 198, 'ANB', 'النيل الأبيض', 'english');
INSERT INTO emkt_regions VALUES(3324, 198, 'ANZ', 'النيل الأزرق', 'english');
INSERT INTO emkt_regions VALUES(3325, 198, 'ASH', 'الشمالية', 'english');
INSERT INTO emkt_regions VALUES(3326, 198, 'BJA', 'الاستوائية الوسطى', 'english');
INSERT INTO emkt_regions VALUES(3327, 198, 'GIS', 'غرب الاستوائية', 'english');
INSERT INTO emkt_regions VALUES(3328, 198, 'GBG', 'غرب بحر الغزال', 'english');
INSERT INTO emkt_regions VALUES(3329, 198, 'GDA', 'غرب دارفور', 'english');
INSERT INTO emkt_regions VALUES(3330, 198, 'GKU', 'غرب كردفان', 'english');
INSERT INTO emkt_regions VALUES(3331, 198, 'JDA', 'جنوب دارفور', 'english');
INSERT INTO emkt_regions VALUES(3332, 198, 'JKU', 'جنوب كردفان', 'english');
INSERT INTO emkt_regions VALUES(3333, 198, 'JQL', 'جونقلي', 'english');
INSERT INTO emkt_regions VALUES(3334, 198, 'KSL', 'كسلا', 'english');
INSERT INTO emkt_regions VALUES(3335, 198, 'NNL', 'ولاية نهر النيل', 'english');
INSERT INTO emkt_regions VALUES(3336, 198, 'SBG', 'شمال بحر الغزال', 'english');
INSERT INTO emkt_regions VALUES(3337, 198, 'SDA', 'شمال دارفور', 'english');
INSERT INTO emkt_regions VALUES(3338, 198, 'SKU', 'شمال كردفان', 'english');
INSERT INTO emkt_regions VALUES(3339, 198, 'SIS', 'شرق الاستوائية', 'english');
INSERT INTO emkt_regions VALUES(3340, 198, 'SNR', 'سنار', 'english');
INSERT INTO emkt_regions VALUES(3341, 198, 'WRB', 'واراب', 'english');

INSERT INTO emkt_countries VALUES (199,'Suriname','english','SR','SUR','');

INSERT INTO emkt_regions VALUES(3342, 199, 'BR', 'Brokopondo', 'english');
INSERT INTO emkt_regions VALUES(3343, 199, 'CM', 'Commewijne', 'english');
INSERT INTO emkt_regions VALUES(3344, 199, 'CR', 'Coronie', 'english');
INSERT INTO emkt_regions VALUES(3345, 199, 'MA', 'Marowijne', 'english');
INSERT INTO emkt_regions VALUES(3346, 199, 'NI', 'Nickerie', 'english');
INSERT INTO emkt_regions VALUES(3347, 199, 'PM', 'Paramaribo', 'english');
INSERT INTO emkt_regions VALUES(3348, 199, 'PR', 'Para', 'english');
INSERT INTO emkt_regions VALUES(3349, 199, 'SA', 'Saramacca', 'english');
INSERT INTO emkt_regions VALUES(3350, 199, 'SI', 'Sipaliwini', 'english');
INSERT INTO emkt_regions VALUES(3351, 199, 'WA', 'Wanica', 'english');

INSERT INTO emkt_countries VALUES (200,'Svalbard and Jan Mayen Islands','english','SJ','SJM','');

INSERT INTO emkt_regions VALUES(4277, 200, 'NOCODE', 'Svalbard and Jan Mayen Islands', 'english');

INSERT INTO emkt_countries VALUES (201,'Swaziland','english','SZ','SWZ','');

INSERT INTO emkt_regions VALUES(3352, 201, 'HH', 'Hhohho', 'english');
INSERT INTO emkt_regions VALUES(3353, 201, 'LU', 'Lubombo', 'english');
INSERT INTO emkt_regions VALUES(3354, 201, 'MA', 'Manzini', 'english');
INSERT INTO emkt_regions VALUES(3355, 201, 'SH', 'Shiselweni', 'english');

INSERT INTO emkt_countries VALUES (202,'Sweden','english','SE','SWE','');

INSERT INTO emkt_regions VALUES(3356, 202, 'AB', 'Stockholms län', 'english');
INSERT INTO emkt_regions VALUES(3357, 202, 'C', 'Uppsala län', 'english');
INSERT INTO emkt_regions VALUES(3358, 202, 'D', 'Södermanlands län', 'english');
INSERT INTO emkt_regions VALUES(3359, 202, 'E', 'Östergötlands län', 'english');
INSERT INTO emkt_regions VALUES(3360, 202, 'F', 'Jönköpings län', 'english');
INSERT INTO emkt_regions VALUES(3361, 202, 'G', 'Kronobergs län', 'english');
INSERT INTO emkt_regions VALUES(3362, 202, 'H', 'Kalmar län', 'english');
INSERT INTO emkt_regions VALUES(3363, 202, 'I', 'Gotlands län', 'english');
INSERT INTO emkt_regions VALUES(3364, 202, 'K', 'Blekinge län', 'english');
INSERT INTO emkt_regions VALUES(3365, 202, 'M', 'Skåne län', 'english');
INSERT INTO emkt_regions VALUES(3366, 202, 'N', 'Hallands län', 'english');
INSERT INTO emkt_regions VALUES(3367, 202, 'O', 'Västra Götalands län', 'english');
INSERT INTO emkt_regions VALUES(3368, 202, 'S', 'Värmlands län;', 'english');
INSERT INTO emkt_regions VALUES(3369, 202, 'T', 'Örebro län', 'english');
INSERT INTO emkt_regions VALUES(3370, 202, 'U', 'Västmanlands län;', 'english');
INSERT INTO emkt_regions VALUES(3371, 202, 'W', 'Dalarnas län', 'english');
INSERT INTO emkt_regions VALUES(3372, 202, 'X', 'Gävleborgs län', 'english');
INSERT INTO emkt_regions VALUES(3373, 202, 'Y', 'Västernorrlands län', 'english');
INSERT INTO emkt_regions VALUES(3374, 202, 'Z', 'Jämtlands län', 'english');
INSERT INTO emkt_regions VALUES(3375, 202, 'AC', 'Västerbottens län', 'english');
INSERT INTO emkt_regions VALUES(3376, 202, 'BD', 'Norrbottens län', 'english');

INSERT INTO emkt_countries VALUES (203,'Switzerland','english','CH','CHE','');

INSERT INTO emkt_regions VALUES(3377, 203, 'ZH', 'Zürich', 'english');
INSERT INTO emkt_regions VALUES(3378, 203, 'BE', 'Bern', 'english');
INSERT INTO emkt_regions VALUES(3379, 203, 'LU', 'Luzern', 'english');
INSERT INTO emkt_regions VALUES(3380, 203, 'UR', 'Uri', 'english');
INSERT INTO emkt_regions VALUES(3381, 203, 'SZ', 'Schwyz', 'english');
INSERT INTO emkt_regions VALUES(3382, 203, 'OW', 'Obwalden', 'english');
INSERT INTO emkt_regions VALUES(3383, 203, 'NW', 'Nidwalden', 'english');
INSERT INTO emkt_regions VALUES(3384, 203, 'GL', 'Glasrus', 'english');
INSERT INTO emkt_regions VALUES(3385, 203, 'ZG', 'Zug', 'english');
INSERT INTO emkt_regions VALUES(3386, 203, 'FR', 'Fribourg', 'english');
INSERT INTO emkt_regions VALUES(3387, 203, 'SO', 'Solothurn', 'english');
INSERT INTO emkt_regions VALUES(3388, 203, 'BS', 'Basel-Stadt', 'english');
INSERT INTO emkt_regions VALUES(3389, 203, 'BL', 'Basel-Landschaft', 'english');
INSERT INTO emkt_regions VALUES(3390, 203, 'SH', 'Schaffhausen', 'english');
INSERT INTO emkt_regions VALUES(3391, 203, 'AR', 'Appenzell Ausserrhoden', 'english');
INSERT INTO emkt_regions VALUES(3392, 203, 'AI', 'Appenzell Innerrhoden', 'english');
INSERT INTO emkt_regions VALUES(3393, 203, 'SG', 'Saint Gallen', 'english');
INSERT INTO emkt_regions VALUES(3394, 203, 'GR', 'Graubünden', 'english');
INSERT INTO emkt_regions VALUES(3395, 203, 'AG', 'Aargau', 'english');
INSERT INTO emkt_regions VALUES(3396, 203, 'TG', 'Thurgau', 'english');
INSERT INTO emkt_regions VALUES(3397, 203, 'TI', 'Ticino', 'english');
INSERT INTO emkt_regions VALUES(3398, 203, 'VD', 'Vaud', 'english');
INSERT INTO emkt_regions VALUES(3399, 203, 'VS', 'Valais', 'english');
INSERT INTO emkt_regions VALUES(3400, 203, 'NE', 'Nuechâtel', 'english');
INSERT INTO emkt_regions VALUES(3401, 203, 'GE', 'Genève', 'english');
INSERT INTO emkt_regions VALUES(3402, 203, 'JU', 'Jura', 'english');

INSERT INTO emkt_countries VALUES (204,'Syrian Arab Republic','english','SY','SYR','');

INSERT INTO emkt_regions VALUES(3403, 204, 'DI', 'دمشق', 'english');
INSERT INTO emkt_regions VALUES(3404, 204, 'DR', 'درعا', 'english');
INSERT INTO emkt_regions VALUES(3405, 204, 'DZ', 'دير الزور', 'english');
INSERT INTO emkt_regions VALUES(3406, 204, 'HA', 'الحسكة', 'english');
INSERT INTO emkt_regions VALUES(3407, 204, 'HI', 'حمص', 'english');
INSERT INTO emkt_regions VALUES(3408, 204, 'HL', 'حلب', 'english');
INSERT INTO emkt_regions VALUES(3409, 204, 'HM', 'حماه', 'english');
INSERT INTO emkt_regions VALUES(3410, 204, 'ID', 'ادلب', 'english');
INSERT INTO emkt_regions VALUES(3411, 204, 'LA', 'اللاذقية', 'english');
INSERT INTO emkt_regions VALUES(3412, 204, 'QU', 'القنيطرة', 'english');
INSERT INTO emkt_regions VALUES(3413, 204, 'RA', 'الرقة', 'english');
INSERT INTO emkt_regions VALUES(3414, 204, 'RD', 'ریف دمشق', 'english');
INSERT INTO emkt_regions VALUES(3415, 204, 'SU', 'السويداء', 'english');
INSERT INTO emkt_regions VALUES(3416, 204, 'TA', 'طرطوس', 'english');

INSERT INTO emkt_countries VALUES (205,'Taiwan','english','TW','TWN','');

INSERT INTO emkt_regions VALUES(3417, 205, 'CHA', '彰化縣', 'english');
INSERT INTO emkt_regions VALUES(3418, 205, 'CYI', '嘉義市', 'english');
INSERT INTO emkt_regions VALUES(3419, 205, 'CYQ', '嘉義縣', 'english');
INSERT INTO emkt_regions VALUES(3420, 205, 'HSQ', '新竹縣', 'english');
INSERT INTO emkt_regions VALUES(3421, 205, 'HSZ', '新竹市', 'english');
INSERT INTO emkt_regions VALUES(3422, 205, 'HUA', '花蓮縣', 'english');
INSERT INTO emkt_regions VALUES(3423, 205, 'ILA', '宜蘭縣', 'english');
INSERT INTO emkt_regions VALUES(3424, 205, 'KEE', '基隆市', 'english');
INSERT INTO emkt_regions VALUES(3425, 205, 'KHH', '高雄市', 'english');
INSERT INTO emkt_regions VALUES(3426, 205, 'KHQ', '高雄縣', 'english');
INSERT INTO emkt_regions VALUES(3427, 205, 'MIA', '苗栗縣', 'english');
INSERT INTO emkt_regions VALUES(3428, 205, 'NAN', '南投縣', 'english');
INSERT INTO emkt_regions VALUES(3429, 205, 'PEN', '澎湖縣', 'english');
INSERT INTO emkt_regions VALUES(3430, 205, 'PIF', '屏東縣', 'english');
INSERT INTO emkt_regions VALUES(3431, 205, 'TAO', '桃源县', 'english');
INSERT INTO emkt_regions VALUES(3432, 205, 'TNN', '台南市', 'english');
INSERT INTO emkt_regions VALUES(3433, 205, 'TNQ', '台南縣', 'english');
INSERT INTO emkt_regions VALUES(3434, 205, 'TPE', '臺北市', 'english');
INSERT INTO emkt_regions VALUES(3435, 205, 'TPQ', '臺北縣', 'english');
INSERT INTO emkt_regions VALUES(3436, 205, 'TTT', '台東縣', 'english');
INSERT INTO emkt_regions VALUES(3437, 205, 'TXG', '台中市', 'english');
INSERT INTO emkt_regions VALUES(3438, 205, 'TXQ', '台中縣', 'english');
INSERT INTO emkt_regions VALUES(3439, 205, 'YUN', '雲林縣', 'english');

INSERT INTO emkt_countries VALUES (206,'Tajikistan','english','TJ','TJK','');

INSERT INTO emkt_regions VALUES(3440, 206, 'GB', 'کوهستان بدخشان', 'english');
INSERT INTO emkt_regions VALUES(3441, 206, 'KT', 'ختلان', 'english');
INSERT INTO emkt_regions VALUES(3442, 206, 'SU', 'سغد', 'english');

INSERT INTO emkt_countries VALUES (207,'Tanzania','english','TZ','TZA','');

INSERT INTO emkt_regions VALUES(3443, 207, '01', 'Arusha', 'english');
INSERT INTO emkt_regions VALUES(3444, 207, '02', 'Dar es Salaam', 'english');
INSERT INTO emkt_regions VALUES(3445, 207, '03', 'Dodoma', 'english');
INSERT INTO emkt_regions VALUES(3446, 207, '04', 'Iringa', 'english');
INSERT INTO emkt_regions VALUES(3447, 207, '05', 'Kagera', 'english');
INSERT INTO emkt_regions VALUES(3448, 207, '06', 'Pemba Sever', 'english');
INSERT INTO emkt_regions VALUES(3449, 207, '07', 'Zanzibar Sever', 'english');
INSERT INTO emkt_regions VALUES(3450, 207, '08', 'Kigoma', 'english');
INSERT INTO emkt_regions VALUES(3451, 207, '09', 'Kilimanjaro', 'english');
INSERT INTO emkt_regions VALUES(3452, 207, '10', 'Pemba Jih', 'english');
INSERT INTO emkt_regions VALUES(3453, 207, '11', 'Zanzibar Jih', 'english');
INSERT INTO emkt_regions VALUES(3454, 207, '12', 'Lindi', 'english');
INSERT INTO emkt_regions VALUES(3455, 207, '13', 'Mara', 'english');
INSERT INTO emkt_regions VALUES(3456, 207, '14', 'Mbeya', 'english');
INSERT INTO emkt_regions VALUES(3457, 207, '15', 'Zanzibar Západ', 'english');
INSERT INTO emkt_regions VALUES(3458, 207, '16', 'Morogoro', 'english');
INSERT INTO emkt_regions VALUES(3459, 207, '17', 'Mtwara', 'english');
INSERT INTO emkt_regions VALUES(3460, 207, '18', 'Mwanza', 'english');
INSERT INTO emkt_regions VALUES(3461, 207, '19', 'Pwani', 'english');
INSERT INTO emkt_regions VALUES(3462, 207, '20', 'Rukwa', 'english');
INSERT INTO emkt_regions VALUES(3463, 207, '21', 'Ruvuma', 'english');
INSERT INTO emkt_regions VALUES(3464, 207, '22', 'Shinyanga', 'english');
INSERT INTO emkt_regions VALUES(3465, 207, '23', 'Singida', 'english');
INSERT INTO emkt_regions VALUES(3466, 207, '24', 'Tabora', 'english');
INSERT INTO emkt_regions VALUES(3467, 207, '25', 'Tanga', 'english');
INSERT INTO emkt_regions VALUES(3468, 207, '26', 'Manyara', 'english');

INSERT INTO emkt_countries VALUES (208,'Thailand','english','TH','THA','');

INSERT INTO emkt_regions VALUES(3469, 208, 'TH-10', 'กรุงเทพมหานคร', 'english');
INSERT INTO emkt_regions VALUES(3470, 208, 'TH-11', 'สมุทรปราการ', 'english');
INSERT INTO emkt_regions VALUES(3471, 208, 'TH-12', 'นนทบุรี', 'english');
INSERT INTO emkt_regions VALUES(3472, 208, 'TH-13', 'ปทุมธานี', 'english');
INSERT INTO emkt_regions VALUES(3473, 208, 'TH-14', 'พระนครศรีอยุธยา', 'english');
INSERT INTO emkt_regions VALUES(3474, 208, 'TH-15', 'อ่างทอง', 'english');
INSERT INTO emkt_regions VALUES(3475, 208, 'TH-16', 'ลพบุรี', 'english');
INSERT INTO emkt_regions VALUES(3476, 208, 'TH-17', 'สิงห์บุรี', 'english');
INSERT INTO emkt_regions VALUES(3477, 208, 'TH-18', 'ชัยนาท', 'english');
INSERT INTO emkt_regions VALUES(3478, 208, 'TH-19', 'สระบุรี', 'english');
INSERT INTO emkt_regions VALUES(3479, 208, 'TH-20', 'ชลบุรี', 'english');
INSERT INTO emkt_regions VALUES(3480, 208, 'TH-21', 'ระยอง', 'english');
INSERT INTO emkt_regions VALUES(3481, 208, 'TH-22', 'จันทบุรี', 'english');
INSERT INTO emkt_regions VALUES(3482, 208, 'TH-23', 'ตราด', 'english');
INSERT INTO emkt_regions VALUES(3483, 208, 'TH-24', 'ฉะเชิงเทรา', 'english');
INSERT INTO emkt_regions VALUES(3484, 208, 'TH-25', 'ปราจีนบุรี', 'english');
INSERT INTO emkt_regions VALUES(3485, 208, 'TH-26', 'นครนายก', 'english');
INSERT INTO emkt_regions VALUES(3486, 208, 'TH-27', 'สระแก้ว', 'english');
INSERT INTO emkt_regions VALUES(3487, 208, 'TH-30', 'นครราชสีมา', 'english');
INSERT INTO emkt_regions VALUES(3488, 208, 'TH-31', 'บุรีรัมย์', 'english');
INSERT INTO emkt_regions VALUES(3489, 208, 'TH-32', 'สุรินทร์', 'english');
INSERT INTO emkt_regions VALUES(3490, 208, 'TH-33', 'ศรีสะเกษ', 'english');
INSERT INTO emkt_regions VALUES(3491, 208, 'TH-34', 'อุบลราชธานี', 'english');
INSERT INTO emkt_regions VALUES(3492, 208, 'TH-35', 'ยโสธร', 'english');
INSERT INTO emkt_regions VALUES(3493, 208, 'TH-36', 'ชัยภูมิ', 'english');
INSERT INTO emkt_regions VALUES(3494, 208, 'TH-37', 'อำนาจเจริญ', 'english');
INSERT INTO emkt_regions VALUES(3495, 208, 'TH-39', 'หนองบัวลำภู', 'english');
INSERT INTO emkt_regions VALUES(3496, 208, 'TH-40', 'ขอนแก่น', 'english');
INSERT INTO emkt_regions VALUES(3497, 208, 'TH-41', 'อุดรธานี', 'english');
INSERT INTO emkt_regions VALUES(3498, 208, 'TH-42', 'เลย', 'english');
INSERT INTO emkt_regions VALUES(3499, 208, 'TH-43', 'หนองคาย', 'english');
INSERT INTO emkt_regions VALUES(3500, 208, 'TH-44', 'มหาสารคาม', 'english');
INSERT INTO emkt_regions VALUES(3501, 208, 'TH-45', 'ร้อยเอ็ด', 'english');
INSERT INTO emkt_regions VALUES(3502, 208, 'TH-46', 'กาฬสินธุ์', 'english');
INSERT INTO emkt_regions VALUES(3503, 208, 'TH-47', 'สกลนคร', 'english');
INSERT INTO emkt_regions VALUES(3504, 208, 'TH-48', 'นครพนม', 'english');
INSERT INTO emkt_regions VALUES(3505, 208, 'TH-49', 'มุกดาหาร', 'english');
INSERT INTO emkt_regions VALUES(3506, 208, 'TH-50', 'เชียงใหม่', 'english');
INSERT INTO emkt_regions VALUES(3507, 208, 'TH-51', 'ลำพูน', 'english');
INSERT INTO emkt_regions VALUES(3508, 208, 'TH-52', 'ลำปาง', 'english');
INSERT INTO emkt_regions VALUES(3509, 208, 'TH-53', 'อุตรดิตถ์', 'english');
INSERT INTO emkt_regions VALUES(3510, 208, 'TH-55', 'น่าน', 'english');
INSERT INTO emkt_regions VALUES(3511, 208, 'TH-56', 'พะเยา', 'english');
INSERT INTO emkt_regions VALUES(3512, 208, 'TH-57', 'เชียงราย', 'english');
INSERT INTO emkt_regions VALUES(3513, 208, 'TH-58', 'แม่ฮ่องสอน', 'english');
INSERT INTO emkt_regions VALUES(3514, 208, 'TH-60', 'นครสวรรค์', 'english');
INSERT INTO emkt_regions VALUES(3515, 208, 'TH-61', 'อุทัยธานี', 'english');
INSERT INTO emkt_regions VALUES(3516, 208, 'TH-62', 'กำแพงเพชร', 'english');
INSERT INTO emkt_regions VALUES(3517, 208, 'TH-63', 'ตาก', 'english');
INSERT INTO emkt_regions VALUES(3518, 208, 'TH-64', 'สุโขทัย', 'english');
INSERT INTO emkt_regions VALUES(3519, 208, 'TH-66', 'ชุมพร', 'english');
INSERT INTO emkt_regions VALUES(3520, 208, 'TH-67', 'พิจิตร', 'english');
INSERT INTO emkt_regions VALUES(3521, 208, 'TH-70', 'ราชบุรี', 'english');
INSERT INTO emkt_regions VALUES(3522, 208, 'TH-71', 'กาญจนบุรี', 'english');
INSERT INTO emkt_regions VALUES(3523, 208, 'TH-72', 'สุพรรณบุรี', 'english');
INSERT INTO emkt_regions VALUES(3524, 208, 'TH-73', 'นครปฐม', 'english');
INSERT INTO emkt_regions VALUES(3525, 208, 'TH-74', 'สมุทรสาคร', 'english');
INSERT INTO emkt_regions VALUES(3526, 208, 'TH-75', 'สมุทรสงคราม', 'english');
INSERT INTO emkt_regions VALUES(3527, 208, 'TH-76', 'เพชรบุรี', 'english');
INSERT INTO emkt_regions VALUES(3528, 208, 'TH-77', 'ประจวบคีรีขันธ์', 'english');
INSERT INTO emkt_regions VALUES(3529, 208, 'TH-80', 'นครศรีธรรมราช', 'english');
INSERT INTO emkt_regions VALUES(3530, 208, 'TH-81', 'กระบี่', 'english');
INSERT INTO emkt_regions VALUES(3531, 208, 'TH-82', 'พังงา', 'english');
INSERT INTO emkt_regions VALUES(3532, 208, 'TH-83', 'ภูเก็ต', 'english');
INSERT INTO emkt_regions VALUES(3533, 208, 'TH-84', 'สุราษฎร์ธานี', 'english');
INSERT INTO emkt_regions VALUES(3534, 208, 'TH-85', 'ระนอง', 'english');
INSERT INTO emkt_regions VALUES(3535, 208, 'TH-86', 'ชุมพร', 'english');
INSERT INTO emkt_regions VALUES(3536, 208, 'TH-90', 'สงขลา', 'english');
INSERT INTO emkt_regions VALUES(3537, 208, 'TH-91', 'สตูล', 'english');
INSERT INTO emkt_regions VALUES(3538, 208, 'TH-92', 'ตรัง', 'english');
INSERT INTO emkt_regions VALUES(3539, 208, 'TH-93', 'พัทลุง', 'english');
INSERT INTO emkt_regions VALUES(3540, 208, 'TH-94', 'ปัตตานี', 'english');
INSERT INTO emkt_regions VALUES(3541, 208, 'TH-95', 'ยะลา', 'english');
INSERT INTO emkt_regions VALUES(3542, 208, 'TH-96', 'นราธิวาส', 'english');

INSERT INTO emkt_countries VALUES (209,'Togo','english','TG','TGO','');

INSERT INTO emkt_regions VALUES(3543, 209, 'C', 'Centrale', 'english');
INSERT INTO emkt_regions VALUES(3544, 209, 'K', 'Kara', 'english');
INSERT INTO emkt_regions VALUES(3545, 209, 'M', 'Maritime', 'english');
INSERT INTO emkt_regions VALUES(3546, 209, 'P', 'Plateaux', 'english');
INSERT INTO emkt_regions VALUES(3547, 209, 'S', 'Savanes', 'english');

INSERT INTO emkt_countries VALUES (210,'Tokelau','english','TK','TKL','');

INSERT INTO emkt_regions VALUES(3548, 210, 'A', 'Atafu', 'english');
INSERT INTO emkt_regions VALUES(3549, 210, 'F', 'Fakaofo', 'english');
INSERT INTO emkt_regions VALUES(3550, 210, 'N', 'Nukunonu', 'english');

INSERT INTO emkt_countries VALUES (211,'Tonga','english','TO','TON','');

INSERT INTO emkt_regions VALUES(3551, 211, 'H', 'Ha\'apai', 'english');
INSERT INTO emkt_regions VALUES(3552, 211, 'T', 'Tongatapu', 'english');
INSERT INTO emkt_regions VALUES(3553, 211, 'V', 'Vava\'u', 'english');

INSERT INTO emkt_countries VALUES (212,'Trinidad and Tobago','english','TT','TTO','');

INSERT INTO emkt_regions VALUES(3554, 212, 'ARI', 'Arima', 'english');
INSERT INTO emkt_regions VALUES(3555, 212, 'CHA', 'Chaguanas', 'english');
INSERT INTO emkt_regions VALUES(3556, 212, 'CTT', 'Couva-Tabaquite-Talparo', 'english');
INSERT INTO emkt_regions VALUES(3557, 212, 'DMN', 'Diego Martin', 'english');
INSERT INTO emkt_regions VALUES(3558, 212, 'ETO', 'Eastern Tobago', 'english');
INSERT INTO emkt_regions VALUES(3559, 212, 'RCM', 'Rio Claro-Mayaro', 'english');
INSERT INTO emkt_regions VALUES(3560, 212, 'PED', 'Penal-Debe', 'english');
INSERT INTO emkt_regions VALUES(3561, 212, 'PTF', 'Point Fortin', 'english');
INSERT INTO emkt_regions VALUES(3562, 212, 'POS', 'Port of Spain', 'english');
INSERT INTO emkt_regions VALUES(3563, 212, 'PRT', 'Princes Town', 'english');
INSERT INTO emkt_regions VALUES(3564, 212, 'SFO', 'San Fernando', 'english');
INSERT INTO emkt_regions VALUES(3565, 212, 'SGE', 'Sangre Grande', 'english');
INSERT INTO emkt_regions VALUES(3566, 212, 'SJL', 'San Juan-Laventille', 'english');
INSERT INTO emkt_regions VALUES(3567, 212, 'SIP', 'Siparia', 'english');
INSERT INTO emkt_regions VALUES(3568, 212, 'TUP', 'Tunapuna-Piarco', 'english');
INSERT INTO emkt_regions VALUES(3569, 212, 'WTO', 'Western Tobago', 'english');

INSERT INTO emkt_countries VALUES (213,'Tunisia','english','TN','TUN','');

INSERT INTO emkt_regions VALUES(3570, 213, '11', 'ولاية تونس', 'english');
INSERT INTO emkt_regions VALUES(3571, 213, '12', 'ولاية أريانة', 'english');
INSERT INTO emkt_regions VALUES(3572, 213, '13', 'ولاية بن عروس', 'english');
INSERT INTO emkt_regions VALUES(3573, 213, '14', 'ولاية منوبة', 'english');
INSERT INTO emkt_regions VALUES(3574, 213, '21', 'ولاية نابل', 'english');
INSERT INTO emkt_regions VALUES(3575, 213, '22', 'ولاية زغوان', 'english');
INSERT INTO emkt_regions VALUES(3576, 213, '23', 'ولاية بنزرت', 'english');
INSERT INTO emkt_regions VALUES(3577, 213, '31', 'ولاية باجة', 'english');
INSERT INTO emkt_regions VALUES(3578, 213, '32', 'ولاية جندوبة', 'english');
INSERT INTO emkt_regions VALUES(3579, 213, '33', 'ولاية الكاف', 'english');
INSERT INTO emkt_regions VALUES(3580, 213, '34', 'ولاية سليانة', 'english');
INSERT INTO emkt_regions VALUES(3581, 213, '41', 'ولاية القيروان', 'english');
INSERT INTO emkt_regions VALUES(3582, 213, '42', 'ولاية القصرين', 'english');
INSERT INTO emkt_regions VALUES(3583, 213, '43', 'ولاية سيدي بوزيد', 'english');
INSERT INTO emkt_regions VALUES(3584, 213, '51', 'ولاية سوسة', 'english');
INSERT INTO emkt_regions VALUES(3585, 213, '52', 'ولاية المنستير', 'english');
INSERT INTO emkt_regions VALUES(3586, 213, '53', 'ولاية المهدية', 'english');
INSERT INTO emkt_regions VALUES(3587, 213, '61', 'ولاية صفاقس', 'english');
INSERT INTO emkt_regions VALUES(3588, 213, '71', 'ولاية قفصة', 'english');
INSERT INTO emkt_regions VALUES(3589, 213, '72', 'ولاية توزر', 'english');
INSERT INTO emkt_regions VALUES(3590, 213, '73', 'ولاية قبلي', 'english');
INSERT INTO emkt_regions VALUES(3591, 213, '81', 'ولاية قابس', 'english');
INSERT INTO emkt_regions VALUES(3592, 213, '82', 'ولاية مدنين', 'english');
INSERT INTO emkt_regions VALUES(3593, 213, '83', 'ولاية تطاوين', 'english');

INSERT INTO emkt_countries VALUES (214,'Turkey','english','TR','TUR','');

INSERT INTO emkt_regions VALUES(3594, 214, '01', 'Adana', 'english');
INSERT INTO emkt_regions VALUES(3595, 214, '02', 'Adıyaman', 'english');
INSERT INTO emkt_regions VALUES(3596, 214, '03', 'Afyonkarahisar', 'english');
INSERT INTO emkt_regions VALUES(3597, 214, '04', 'Ağrı', 'english');
INSERT INTO emkt_regions VALUES(3598, 214, '05', 'Amasya', 'english');
INSERT INTO emkt_regions VALUES(3599, 214, '06', 'Ankara', 'english');
INSERT INTO emkt_regions VALUES(3600, 214, '07', 'Antalya', 'english');
INSERT INTO emkt_regions VALUES(3601, 214, '08', 'Artvin', 'english');
INSERT INTO emkt_regions VALUES(3602, 214, '09', 'Aydın', 'english');
INSERT INTO emkt_regions VALUES(3603, 214, '10', 'Balıkesir', 'english');
INSERT INTO emkt_regions VALUES(3604, 214, '11', 'Bilecik', 'english');
INSERT INTO emkt_regions VALUES(3605, 214, '12', 'Bingöl', 'english');
INSERT INTO emkt_regions VALUES(3606, 214, '13', 'Bitlis', 'english');
INSERT INTO emkt_regions VALUES(3607, 214, '14', 'Bolu', 'english');
INSERT INTO emkt_regions VALUES(3608, 214, '15', 'Burdur', 'english');
INSERT INTO emkt_regions VALUES(3609, 214, '16', 'Bursa', 'english');
INSERT INTO emkt_regions VALUES(3610, 214, '17', 'Çanakkale', 'english');
INSERT INTO emkt_regions VALUES(3611, 214, '18', 'Çankırı', 'english');
INSERT INTO emkt_regions VALUES(3612, 214, '19', 'Çorum', 'english');
INSERT INTO emkt_regions VALUES(3613, 214, '20', 'Denizli', 'english');
INSERT INTO emkt_regions VALUES(3614, 214, '21', 'Diyarbakır', 'english');
INSERT INTO emkt_regions VALUES(3615, 214, '22', 'Edirne', 'english');
INSERT INTO emkt_regions VALUES(3616, 214, '23', 'Elazığ', 'english');
INSERT INTO emkt_regions VALUES(3617, 214, '24', 'Erzincan', 'english');
INSERT INTO emkt_regions VALUES(3618, 214, '25', 'Erzurum', 'english');
INSERT INTO emkt_regions VALUES(3619, 214, '26', 'Eskişehir', 'english');
INSERT INTO emkt_regions VALUES(3620, 214, '27', 'Gaziantep', 'english');
INSERT INTO emkt_regions VALUES(3621, 214, '28', 'Giresun', 'english');
INSERT INTO emkt_regions VALUES(3622, 214, '29', 'Gümüşhane', 'english');
INSERT INTO emkt_regions VALUES(3623, 214, '30', 'Hakkari', 'english');
INSERT INTO emkt_regions VALUES(3624, 214, '31', 'Hatay', 'english');
INSERT INTO emkt_regions VALUES(3625, 214, '32', 'Isparta', 'english');
INSERT INTO emkt_regions VALUES(3626, 214, '33', 'Mersin', 'english');
INSERT INTO emkt_regions VALUES(3627, 214, '34', 'İstanbul', 'english');
INSERT INTO emkt_regions VALUES(3628, 214, '35', 'İzmir', 'english');
INSERT INTO emkt_regions VALUES(3629, 214, '36', 'Kars', 'english');
INSERT INTO emkt_regions VALUES(3630, 214, '37', 'Kastamonu', 'english');
INSERT INTO emkt_regions VALUES(3631, 214, '38', 'Kayseri', 'english');
INSERT INTO emkt_regions VALUES(3632, 214, '39', 'Kırklareli', 'english');
INSERT INTO emkt_regions VALUES(3633, 214, '40', 'Kırşehir', 'english');
INSERT INTO emkt_regions VALUES(3634, 214, '41', 'Kocaeli', 'english');
INSERT INTO emkt_regions VALUES(3635, 214, '42', 'Konya', 'english');
INSERT INTO emkt_regions VALUES(3636, 214, '43', 'Kütahya', 'english');
INSERT INTO emkt_regions VALUES(3637, 214, '44', 'Malatya', 'english');
INSERT INTO emkt_regions VALUES(3638, 214, '45', 'Manisa', 'english');
INSERT INTO emkt_regions VALUES(3639, 214, '46', 'Kahramanmaraş', 'english');
INSERT INTO emkt_regions VALUES(3640, 214, '47', 'Mardin', 'english');
INSERT INTO emkt_regions VALUES(3641, 214, '48', 'Muğla', 'english');
INSERT INTO emkt_regions VALUES(3642, 214, '49', 'Muş', 'english');
INSERT INTO emkt_regions VALUES(3643, 214, '50', 'Nevşehir', 'english');
INSERT INTO emkt_regions VALUES(3644, 214, '51', 'Niğde', 'english');
INSERT INTO emkt_regions VALUES(3645, 214, '52', 'Ordu', 'english');
INSERT INTO emkt_regions VALUES(3646, 214, '53', 'Rize', 'english');
INSERT INTO emkt_regions VALUES(3647, 214, '54', 'Sakarya', 'english');
INSERT INTO emkt_regions VALUES(3648, 214, '55', 'Samsun', 'english');
INSERT INTO emkt_regions VALUES(3649, 214, '56', 'Siirt', 'english');
INSERT INTO emkt_regions VALUES(3650, 214, '57', 'Sinop', 'english');
INSERT INTO emkt_regions VALUES(3651, 214, '58', 'Sivas', 'english');
INSERT INTO emkt_regions VALUES(3652, 214, '59', 'Tekirdağ', 'english');
INSERT INTO emkt_regions VALUES(3653, 214, '60', 'Tokat', 'english');
INSERT INTO emkt_regions VALUES(3654, 214, '61', 'Trabzon', 'english');
INSERT INTO emkt_regions VALUES(3655, 214, '62', 'Tunceli', 'english');
INSERT INTO emkt_regions VALUES(3656, 214, '63', 'Şanlıurfa', 'english');
INSERT INTO emkt_regions VALUES(3657, 214, '64', 'Uşak', 'english');
INSERT INTO emkt_regions VALUES(3658, 214, '65', 'Van', 'english');
INSERT INTO emkt_regions VALUES(3659, 214, '66', 'Yozgat', 'english');
INSERT INTO emkt_regions VALUES(3660, 214, '67', 'Zonguldak', 'english');
INSERT INTO emkt_regions VALUES(3661, 214, '68', 'Aksaray', 'english');
INSERT INTO emkt_regions VALUES(3662, 214, '69', 'Bayburt', 'english');
INSERT INTO emkt_regions VALUES(3663, 214, '70', 'Karaman', 'english');
INSERT INTO emkt_regions VALUES(3664, 214, '71', 'Kırıkkale', 'english');
INSERT INTO emkt_regions VALUES(3665, 214, '72', 'Batman', 'english');
INSERT INTO emkt_regions VALUES(3666, 214, '73', 'Şırnak', 'english');
INSERT INTO emkt_regions VALUES(3667, 214, '74', 'Bartın', 'english');
INSERT INTO emkt_regions VALUES(3668, 214, '75', 'Ardahan', 'english');
INSERT INTO emkt_regions VALUES(3669, 214, '76', 'Iğdır', 'english');
INSERT INTO emkt_regions VALUES(3670, 214, '77', 'Yalova', 'english');
INSERT INTO emkt_regions VALUES(3671, 214, '78', 'Karabük', 'english');
INSERT INTO emkt_regions VALUES(3672, 214, '79', 'Kilis', 'english');
INSERT INTO emkt_regions VALUES(3673, 214, '80', 'Osmaniye', 'english');
INSERT INTO emkt_regions VALUES(3674, 214, '81', 'Düzce', 'english');

INSERT INTO emkt_countries VALUES (215,'Turkmenistan','english','TM','TKM','');

INSERT INTO emkt_regions VALUES(3675, 215, 'A', 'Ahal welaýaty', 'english');
INSERT INTO emkt_regions VALUES(3676, 215, 'B', 'Balkan welaýaty', 'english');
INSERT INTO emkt_regions VALUES(3677, 215, 'D', 'Daşoguz welaýaty', 'english');
INSERT INTO emkt_regions VALUES(3678, 215, 'L', 'Lebap welaýaty', 'english');
INSERT INTO emkt_regions VALUES(3679, 215, 'M', 'Mary welaýaty', 'english');

INSERT INTO emkt_countries VALUES (216,'Turks and Caicos Islands','english','TC','TCA','');

INSERT INTO emkt_regions VALUES(3680, 216, 'AC', 'Ambergris Cays', 'english');
INSERT INTO emkt_regions VALUES(3681, 216, 'DC', 'Dellis Cay', 'english');
INSERT INTO emkt_regions VALUES(3682, 216, 'FC', 'French Cay', 'english');
INSERT INTO emkt_regions VALUES(3683, 216, 'LW', 'Little Water Cay', 'english');
INSERT INTO emkt_regions VALUES(3684, 216, 'RC', 'Parrot Cay', 'english');
INSERT INTO emkt_regions VALUES(3685, 216, 'PN', 'Pine Cay', 'english');
INSERT INTO emkt_regions VALUES(3686, 216, 'SL', 'Salt Cay', 'english');
INSERT INTO emkt_regions VALUES(3687, 216, 'GT', 'Grand Turk', 'english');
INSERT INTO emkt_regions VALUES(3688, 216, 'SC', 'South Caicos', 'english');
INSERT INTO emkt_regions VALUES(3689, 216, 'EC', 'East Caicos', 'english');
INSERT INTO emkt_regions VALUES(3690, 216, 'MC', 'Middle Caicos', 'english');
INSERT INTO emkt_regions VALUES(3691, 216, 'NC', 'North Caicos', 'english');
INSERT INTO emkt_regions VALUES(3692, 216, 'PR', 'Providenciales', 'english');
INSERT INTO emkt_regions VALUES(3693, 216, 'WC', 'West Caicos', 'english');

INSERT INTO emkt_countries VALUES (217,'Tuvalu','english','TV','TUV','');

INSERT INTO emkt_regions VALUES(3694, 217, 'FUN', 'Funafuti', 'english');
INSERT INTO emkt_regions VALUES(3695, 217, 'NMA', 'Nanumea', 'english');
INSERT INTO emkt_regions VALUES(3696, 217, 'NMG', 'Nanumanga', 'english');
INSERT INTO emkt_regions VALUES(3697, 217, 'NIT', 'Niutao', 'english');
INSERT INTO emkt_regions VALUES(3698, 217, 'NIU', 'Nui', 'english');
INSERT INTO emkt_regions VALUES(3699, 217, 'NKF', 'Nukufetau', 'english');
INSERT INTO emkt_regions VALUES(3700, 217, 'NKL', 'Nukulaelae', 'english');
INSERT INTO emkt_regions VALUES(3701, 217, 'VAI', 'Vaitupu', 'english');

INSERT INTO emkt_countries VALUES (218,'Uganda','english','UG','UGA','');

INSERT INTO emkt_regions VALUES(3702, 218, '101', 'Kalangala', 'english');
INSERT INTO emkt_regions VALUES(3703, 218, '102', 'Kampala', 'english');
INSERT INTO emkt_regions VALUES(3704, 218, '103', 'Kiboga', 'english');
INSERT INTO emkt_regions VALUES(3705, 218, '104', 'Luwero', 'english');
INSERT INTO emkt_regions VALUES(3706, 218, '105', 'Masaka', 'english');
INSERT INTO emkt_regions VALUES(3707, 218, '106', 'Mpigi', 'english');
INSERT INTO emkt_regions VALUES(3708, 218, '107', 'Mubende', 'english');
INSERT INTO emkt_regions VALUES(3709, 218, '108', 'Mukono', 'english');
INSERT INTO emkt_regions VALUES(3710, 218, '109', 'Nakasongola', 'english');
INSERT INTO emkt_regions VALUES(3711, 218, '110', 'Rakai', 'english');
INSERT INTO emkt_regions VALUES(3712, 218, '111', 'Sembabule', 'english');
INSERT INTO emkt_regions VALUES(3713, 218, '112', 'Kayunga', 'english');
INSERT INTO emkt_regions VALUES(3714, 218, '113', 'Wakiso', 'english');
INSERT INTO emkt_regions VALUES(3715, 218, '201', 'Bugiri', 'english');
INSERT INTO emkt_regions VALUES(3716, 218, '202', 'Busia', 'english');
INSERT INTO emkt_regions VALUES(3717, 218, '203', 'Iganga', 'english');
INSERT INTO emkt_regions VALUES(3718, 218, '204', 'Jinja', 'english');
INSERT INTO emkt_regions VALUES(3719, 218, '205', 'Kamuli', 'english');
INSERT INTO emkt_regions VALUES(3720, 218, '206', 'Kapchorwa', 'english');
INSERT INTO emkt_regions VALUES(3721, 218, '207', 'Katakwi', 'english');
INSERT INTO emkt_regions VALUES(3722, 218, '208', 'Kumi', 'english');
INSERT INTO emkt_regions VALUES(3723, 218, '209', 'Mbale', 'english');
INSERT INTO emkt_regions VALUES(3724, 218, '210', 'Pallisa', 'english');
INSERT INTO emkt_regions VALUES(3725, 218, '211', 'Soroti', 'english');
INSERT INTO emkt_regions VALUES(3726, 218, '212', 'Tororo', 'english');
INSERT INTO emkt_regions VALUES(3727, 218, '213', 'Kaberamaido', 'english');
INSERT INTO emkt_regions VALUES(3728, 218, '214', 'Mayuge', 'english');
INSERT INTO emkt_regions VALUES(3729, 218, '215', 'Sironko', 'english');
INSERT INTO emkt_regions VALUES(3730, 218, '301', 'Adjumani', 'english');
INSERT INTO emkt_regions VALUES(3731, 218, '302', 'Apac', 'english');
INSERT INTO emkt_regions VALUES(3732, 218, '303', 'Arua', 'english');
INSERT INTO emkt_regions VALUES(3733, 218, '304', 'Gulu', 'english');
INSERT INTO emkt_regions VALUES(3734, 218, '305', 'Kitgum', 'english');
INSERT INTO emkt_regions VALUES(3735, 218, '306', 'Kotido', 'english');
INSERT INTO emkt_regions VALUES(3736, 218, '307', 'Lira', 'english');
INSERT INTO emkt_regions VALUES(3737, 218, '308', 'Moroto', 'english');
INSERT INTO emkt_regions VALUES(3738, 218, '309', 'Moyo', 'english');
INSERT INTO emkt_regions VALUES(3739, 218, '310', 'Nebbi', 'english');
INSERT INTO emkt_regions VALUES(3740, 218, '311', 'Nakapiripirit', 'english');
INSERT INTO emkt_regions VALUES(3741, 218, '312', 'Pader', 'english');
INSERT INTO emkt_regions VALUES(3742, 218, '313', 'Yumbe', 'english');
INSERT INTO emkt_regions VALUES(3743, 218, '401', 'Bundibugyo', 'english');
INSERT INTO emkt_regions VALUES(3744, 218, '402', 'Bushenyi', 'english');
INSERT INTO emkt_regions VALUES(3745, 218, '403', 'Hoima', 'english');
INSERT INTO emkt_regions VALUES(3746, 218, '404', 'Kabale', 'english');
INSERT INTO emkt_regions VALUES(3747, 218, '405', 'Kabarole', 'english');
INSERT INTO emkt_regions VALUES(3748, 218, '406', 'Kasese', 'english');
INSERT INTO emkt_regions VALUES(3749, 218, '407', 'Kibale', 'english');
INSERT INTO emkt_regions VALUES(3750, 218, '408', 'Kisoro', 'english');
INSERT INTO emkt_regions VALUES(3751, 218, '409', 'Masindi', 'english');
INSERT INTO emkt_regions VALUES(3752, 218, '410', 'Mbarara', 'english');
INSERT INTO emkt_regions VALUES(3753, 218, '411', 'Ntungamo', 'english');
INSERT INTO emkt_regions VALUES(3754, 218, '412', 'Rukungiri', 'english');
INSERT INTO emkt_regions VALUES(3755, 218, '413', 'Kamwenge', 'english');
INSERT INTO emkt_regions VALUES(3756, 218, '414', 'Kanungu', 'english');
INSERT INTO emkt_regions VALUES(3757, 218, '415', 'Kyenjojo', 'english');

INSERT INTO emkt_countries VALUES (219,'Ukraine','english','UA','UKR','');

INSERT INTO emkt_regions VALUES(3758, 219, '05', 'Вінницька область', 'english');
INSERT INTO emkt_regions VALUES(3759, 219, '07', 'Волинська область', 'english');
INSERT INTO emkt_regions VALUES(3760, 219, '09', 'Луганська область', 'english');
INSERT INTO emkt_regions VALUES(3761, 219, '12', 'Дніпропетровська область', 'english');
INSERT INTO emkt_regions VALUES(3762, 219, '14', 'Донецька область', 'english');
INSERT INTO emkt_regions VALUES(3763, 219, '18', 'Житомирська область', 'english');
INSERT INTO emkt_regions VALUES(3764, 219, '19', 'Рівненська область', 'english');
INSERT INTO emkt_regions VALUES(3765, 219, '21', 'Закарпатська область', 'english');
INSERT INTO emkt_regions VALUES(3766, 219, '23', 'Запорізька область', 'english');
INSERT INTO emkt_regions VALUES(3767, 219, '26', 'Івано-Франківська область', 'english');
INSERT INTO emkt_regions VALUES(3768, 219, '30', 'Київ', 'english');
INSERT INTO emkt_regions VALUES(3769, 219, '32', 'Київська область', 'english');
INSERT INTO emkt_regions VALUES(3770, 219, '35', 'Кіровоградська область', 'english');
INSERT INTO emkt_regions VALUES(3771, 219, '46', 'Львівська область', 'english');
INSERT INTO emkt_regions VALUES(3772, 219, '48', 'Миколаївська область', 'english');
INSERT INTO emkt_regions VALUES(3773, 219, '51', 'Одеська область', 'english');
INSERT INTO emkt_regions VALUES(3774, 219, '53', 'Полтавська область', 'english');
INSERT INTO emkt_regions VALUES(3775, 219, '59', 'Сумська область', 'english');
INSERT INTO emkt_regions VALUES(3776, 219, '61', 'Тернопільська область', 'english');
INSERT INTO emkt_regions VALUES(3777, 219, '63', 'Харківська область', 'english');
INSERT INTO emkt_regions VALUES(3778, 219, '65', 'Херсонська область', 'english');
INSERT INTO emkt_regions VALUES(3779, 219, '68', 'Хмельницька область', 'english');
INSERT INTO emkt_regions VALUES(3780, 219, '71', 'Черкаська область', 'english');
INSERT INTO emkt_regions VALUES(3781, 219, '74', 'Чернігівська область', 'english');
INSERT INTO emkt_regions VALUES(3782, 219, '77', 'Чернівецька область', 'english');

INSERT INTO emkt_countries VALUES (220,'United Arab Emirates','english','AE','ARE','');

INSERT INTO emkt_regions VALUES(4278, 220, 'NOCODE', 'United Arab Emirates', 'english');

INSERT INTO emkt_countries VALUES (221,'United Kingdom','english','GB','GBR','');

INSERT INTO emkt_regions VALUES(3783, 221, 'ABD', 'Aberdeenshire', 'english');
INSERT INTO emkt_regions VALUES(3784, 221, 'ABE', 'Aberdeen', 'english');
INSERT INTO emkt_regions VALUES(3785, 221, 'AGB', 'Argyll and Bute', 'english');
INSERT INTO emkt_regions VALUES(3786, 221, 'AGY', 'Isle of Anglesey', 'english');
INSERT INTO emkt_regions VALUES(3787, 221, 'ANS', 'Angus', 'english');
INSERT INTO emkt_regions VALUES(3788, 221, 'ANT', 'Antrim', 'english');
INSERT INTO emkt_regions VALUES(3789, 221, 'ARD', 'Ards', 'english');
INSERT INTO emkt_regions VALUES(3790, 221, 'ARM', 'Armagh', 'english');
INSERT INTO emkt_regions VALUES(3791, 221, 'BAS', 'Bath and North East Somerset', 'english');
INSERT INTO emkt_regions VALUES(3792, 221, 'BBD', 'Blackburn with Darwen', 'english');
INSERT INTO emkt_regions VALUES(3793, 221, 'BDF', 'Bedfordshire', 'english');
INSERT INTO emkt_regions VALUES(3794, 221, 'BDG', 'Barking and Dagenham', 'english');
INSERT INTO emkt_regions VALUES(3795, 221, 'BEN', 'Brent', 'english');
INSERT INTO emkt_regions VALUES(3796, 221, 'BEX', 'Bexley', 'english');
INSERT INTO emkt_regions VALUES(3797, 221, 'BFS', 'Belfast', 'english');
INSERT INTO emkt_regions VALUES(3798, 221, 'BGE', 'Bridgend', 'english');
INSERT INTO emkt_regions VALUES(3799, 221, 'BGW', 'Blaenau Gwent', 'english');
INSERT INTO emkt_regions VALUES(3800, 221, 'BIR', 'Birmingham', 'english');
INSERT INTO emkt_regions VALUES(3801, 221, 'BKM', 'Buckinghamshire', 'english');
INSERT INTO emkt_regions VALUES(3802, 221, 'BLA', 'Ballymena', 'english');
INSERT INTO emkt_regions VALUES(3803, 221, 'BLY', 'Ballymoney', 'english');
INSERT INTO emkt_regions VALUES(3804, 221, 'BMH', 'Bournemouth', 'english');
INSERT INTO emkt_regions VALUES(3805, 221, 'BNB', 'Banbridge', 'english');
INSERT INTO emkt_regions VALUES(3806, 221, 'BNE', 'Barnet', 'english');
INSERT INTO emkt_regions VALUES(3807, 221, 'BNH', 'Brighton and Hove', 'english');
INSERT INTO emkt_regions VALUES(3808, 221, 'BNS', 'Barnsley', 'english');
INSERT INTO emkt_regions VALUES(3809, 221, 'BOL', 'Bolton', 'english');
INSERT INTO emkt_regions VALUES(3810, 221, 'BPL', 'Blackpool', 'english');
INSERT INTO emkt_regions VALUES(3811, 221, 'BRC', 'Bracknell', 'english');
INSERT INTO emkt_regions VALUES(3812, 221, 'BRD', 'Bradford', 'english');
INSERT INTO emkt_regions VALUES(3813, 221, 'BRY', 'Bromley', 'english');
INSERT INTO emkt_regions VALUES(3814, 221, 'BST', 'Bristol', 'english');
INSERT INTO emkt_regions VALUES(3815, 221, 'BUR', 'Bury', 'english');
INSERT INTO emkt_regions VALUES(3816, 221, 'CAM', 'Cambridgeshire', 'english');
INSERT INTO emkt_regions VALUES(3817, 221, 'CAY', 'Caerphilly', 'english');
INSERT INTO emkt_regions VALUES(3818, 221, 'CGN', 'Ceredigion', 'english');
INSERT INTO emkt_regions VALUES(3819, 221, 'CGV', 'Craigavon', 'english');
INSERT INTO emkt_regions VALUES(3820, 221, 'CHS', 'Cheshire', 'english');
INSERT INTO emkt_regions VALUES(3821, 221, 'CKF', 'Carrickfergus', 'english');
INSERT INTO emkt_regions VALUES(3822, 221, 'CKT', 'Cookstown', 'english');
INSERT INTO emkt_regions VALUES(3823, 221, 'CLD', 'Calderdale', 'english');
INSERT INTO emkt_regions VALUES(3824, 221, 'CLK', 'Clackmannanshire', 'english');
INSERT INTO emkt_regions VALUES(3825, 221, 'CLR', 'Coleraine', 'english');
INSERT INTO emkt_regions VALUES(3826, 221, 'CMA', 'Cumbria', 'english');
INSERT INTO emkt_regions VALUES(3827, 221, 'CMD', 'Camden', 'english');
INSERT INTO emkt_regions VALUES(3828, 221, 'CMN', 'Carmarthenshire', 'english');
INSERT INTO emkt_regions VALUES(3829, 221, 'CON', 'Cornwall', 'english');
INSERT INTO emkt_regions VALUES(3830, 221, 'COV', 'Coventry', 'english');
INSERT INTO emkt_regions VALUES(3831, 221, 'CRF', 'Cardiff', 'english');
INSERT INTO emkt_regions VALUES(3832, 221, 'CRY', 'Croydon', 'english');
INSERT INTO emkt_regions VALUES(3833, 221, 'CSR', 'Castlereagh', 'english');
INSERT INTO emkt_regions VALUES(3834, 221, 'CWY', 'Conwy', 'english');
INSERT INTO emkt_regions VALUES(3835, 221, 'DAL', 'Darlington', 'english');
INSERT INTO emkt_regions VALUES(3836, 221, 'DBY', 'Derbyshire', 'english');
INSERT INTO emkt_regions VALUES(3837, 221, 'DEN', 'Denbighshire', 'english');
INSERT INTO emkt_regions VALUES(3838, 221, 'DER', 'Derby', 'english');
INSERT INTO emkt_regions VALUES(3839, 221, 'DEV', 'Devon', 'english');
INSERT INTO emkt_regions VALUES(3840, 221, 'DGN', 'Dungannon and South Tyrone', 'english');
INSERT INTO emkt_regions VALUES(3841, 221, 'DGY', 'Dumfries and Galloway', 'english');
INSERT INTO emkt_regions VALUES(3842, 221, 'DNC', 'Doncaster', 'english');
INSERT INTO emkt_regions VALUES(3843, 221, 'DND', 'Dundee', 'english');
INSERT INTO emkt_regions VALUES(3844, 221, 'DOR', 'Dorset', 'english');
INSERT INTO emkt_regions VALUES(3845, 221, 'DOW', 'Down', 'english');
INSERT INTO emkt_regions VALUES(3846, 221, 'DRY', 'Derry', 'english');
INSERT INTO emkt_regions VALUES(3847, 221, 'DUD', 'Dudley', 'english');
INSERT INTO emkt_regions VALUES(3848, 221, 'DUR', 'Durham', 'english');
INSERT INTO emkt_regions VALUES(3849, 221, 'EAL', 'Ealing', 'english');
INSERT INTO emkt_regions VALUES(3850, 221, 'EAY', 'East Ayrshire', 'english');
INSERT INTO emkt_regions VALUES(3851, 221, 'EDH', 'Edinburgh', 'english');
INSERT INTO emkt_regions VALUES(3852, 221, 'EDU', 'East Dunbartonshire', 'english');
INSERT INTO emkt_regions VALUES(3853, 221, 'ELN', 'East Lothian', 'english');
INSERT INTO emkt_regions VALUES(3854, 221, 'ELS', 'Eilean Siar', 'english');
INSERT INTO emkt_regions VALUES(3855, 221, 'ENF', 'Enfield', 'english');
INSERT INTO emkt_regions VALUES(3856, 221, 'ERW', 'East Renfrewshire', 'english');
INSERT INTO emkt_regions VALUES(3857, 221, 'ERY', 'East Riding of Yorkshire', 'english');
INSERT INTO emkt_regions VALUES(3858, 221, 'ESS', 'Essex', 'english');
INSERT INTO emkt_regions VALUES(3859, 221, 'ESX', 'East Sussex', 'english');
INSERT INTO emkt_regions VALUES(3860, 221, 'FAL', 'Falkirk', 'english');
INSERT INTO emkt_regions VALUES(3861, 221, 'FER', 'Fermanagh', 'english');
INSERT INTO emkt_regions VALUES(3862, 221, 'FIF', 'Fife', 'english');
INSERT INTO emkt_regions VALUES(3863, 221, 'FLN', 'Flintshire', 'english');
INSERT INTO emkt_regions VALUES(3864, 221, 'GAT', 'Gateshead', 'english');
INSERT INTO emkt_regions VALUES(3865, 221, 'GLG', 'Glasgow', 'english');
INSERT INTO emkt_regions VALUES(3866, 221, 'GLS', 'Gloucestershire', 'english');
INSERT INTO emkt_regions VALUES(3867, 221, 'GRE', 'Greenwich', 'english');
INSERT INTO emkt_regions VALUES(3868, 221, 'GSY', 'Guernsey', 'english');
INSERT INTO emkt_regions VALUES(3869, 221, 'GWN', 'Gwynedd', 'english');
INSERT INTO emkt_regions VALUES(3870, 221, 'HAL', 'Halton', 'english');
INSERT INTO emkt_regions VALUES(3871, 221, 'HAM', 'Hampshire', 'english');
INSERT INTO emkt_regions VALUES(3872, 221, 'HAV', 'Havering', 'english');
INSERT INTO emkt_regions VALUES(3873, 221, 'HCK', 'Hackney', 'english');
INSERT INTO emkt_regions VALUES(3874, 221, 'HEF', 'Herefordshire', 'english');
INSERT INTO emkt_regions VALUES(3875, 221, 'HIL', 'Hillingdon', 'english');
INSERT INTO emkt_regions VALUES(3876, 221, 'HLD', 'Highland', 'english');
INSERT INTO emkt_regions VALUES(3877, 221, 'HMF', 'Hammersmith and Fulham', 'english');
INSERT INTO emkt_regions VALUES(3878, 221, 'HNS', 'Hounslow', 'english');
INSERT INTO emkt_regions VALUES(3879, 221, 'HPL', 'Hartlepool', 'english');
INSERT INTO emkt_regions VALUES(3880, 221, 'HRT', 'Hertfordshire', 'english');
INSERT INTO emkt_regions VALUES(3881, 221, 'HRW', 'Harrow', 'english');
INSERT INTO emkt_regions VALUES(3882, 221, 'HRY', 'Haringey', 'english');
INSERT INTO emkt_regions VALUES(3883, 221, 'IOS', 'Isles of Scilly', 'english');
INSERT INTO emkt_regions VALUES(3884, 221, 'IOW', 'Isle of Wight', 'english');
INSERT INTO emkt_regions VALUES(3885, 221, 'ISL', 'Islington', 'english');
INSERT INTO emkt_regions VALUES(3886, 221, 'IVC', 'Inverclyde', 'english');
INSERT INTO emkt_regions VALUES(3887, 221, 'JSY', 'Jersey', 'english');
INSERT INTO emkt_regions VALUES(3888, 221, 'KEC', 'Kensington and Chelsea', 'english');
INSERT INTO emkt_regions VALUES(3889, 221, 'KEN', 'Kent', 'english');
INSERT INTO emkt_regions VALUES(3890, 221, 'KHL', 'Kingston upon Hull', 'english');
INSERT INTO emkt_regions VALUES(3891, 221, 'KIR', 'Kirklees', 'english');
INSERT INTO emkt_regions VALUES(3892, 221, 'KTT', 'Kingston upon Thames', 'english');
INSERT INTO emkt_regions VALUES(3893, 221, 'KWL', 'Knowsley', 'english');
INSERT INTO emkt_regions VALUES(3894, 221, 'LAN', 'Lancashire', 'english');
INSERT INTO emkt_regions VALUES(3895, 221, 'LBH', 'Lambeth', 'english');
INSERT INTO emkt_regions VALUES(3896, 221, 'LCE', 'Leicester', 'english');
INSERT INTO emkt_regions VALUES(3897, 221, 'LDS', 'Leeds', 'english');
INSERT INTO emkt_regions VALUES(3898, 221, 'LEC', 'Leicestershire', 'english');
INSERT INTO emkt_regions VALUES(3899, 221, 'LEW', 'Lewisham', 'english');
INSERT INTO emkt_regions VALUES(3900, 221, 'LIN', 'Lincolnshire', 'english');
INSERT INTO emkt_regions VALUES(3901, 221, 'LIV', 'Liverpool', 'english');
INSERT INTO emkt_regions VALUES(3902, 221, 'LMV', 'Limavady', 'english');
INSERT INTO emkt_regions VALUES(3903, 221, 'LND', 'London', 'english');
INSERT INTO emkt_regions VALUES(3904, 221, 'LRN', 'Larne', 'english');
INSERT INTO emkt_regions VALUES(3905, 221, 'LSB', 'Lisburn', 'english');
INSERT INTO emkt_regions VALUES(3906, 221, 'LUT', 'Luton', 'english');
INSERT INTO emkt_regions VALUES(3907, 221, 'MAN', 'Manchester', 'english');
INSERT INTO emkt_regions VALUES(3908, 221, 'MDB', 'Middlesbrough', 'english');
INSERT INTO emkt_regions VALUES(3909, 221, 'MDW', 'Medway', 'english');
INSERT INTO emkt_regions VALUES(3910, 221, 'MFT', 'Magherafelt', 'english');
INSERT INTO emkt_regions VALUES(3911, 221, 'MIK', 'Milton Keynes', 'english');
INSERT INTO emkt_regions VALUES(3912, 221, 'MLN', 'Midlothian', 'english');
INSERT INTO emkt_regions VALUES(3913, 221, 'MON', 'Monmouthshire', 'english');
INSERT INTO emkt_regions VALUES(3914, 221, 'MRT', 'Merton', 'english');
INSERT INTO emkt_regions VALUES(3915, 221, 'MRY', 'Moray', 'english');
INSERT INTO emkt_regions VALUES(3916, 221, 'MTY', 'Merthyr Tydfil', 'english');
INSERT INTO emkt_regions VALUES(3917, 221, 'MYL', 'Moyle', 'english');
INSERT INTO emkt_regions VALUES(3918, 221, 'NAY', 'North Ayrshire', 'english');
INSERT INTO emkt_regions VALUES(3919, 221, 'NBL', 'Northumberland', 'english');
INSERT INTO emkt_regions VALUES(3920, 221, 'NDN', 'North Down', 'english');
INSERT INTO emkt_regions VALUES(3921, 221, 'NEL', 'North East Lincolnshire', 'english');
INSERT INTO emkt_regions VALUES(3922, 221, 'NET', 'Newcastle upon Tyne', 'english');
INSERT INTO emkt_regions VALUES(3923, 221, 'NFK', 'Norfolk', 'english');
INSERT INTO emkt_regions VALUES(3924, 221, 'NGM', 'Nottingham', 'english');
INSERT INTO emkt_regions VALUES(3925, 221, 'NLK', 'North Lanarkshire', 'english');
INSERT INTO emkt_regions VALUES(3926, 221, 'NLN', 'North Lincolnshire', 'english');
INSERT INTO emkt_regions VALUES(3927, 221, 'NSM', 'North Somerset', 'english');
INSERT INTO emkt_regions VALUES(3928, 221, 'NTA', 'Newtownabbey', 'english');
INSERT INTO emkt_regions VALUES(3929, 221, 'NTH', 'Northamptonshire', 'english');
INSERT INTO emkt_regions VALUES(3930, 221, 'NTL', 'Neath Port Talbot', 'english');
INSERT INTO emkt_regions VALUES(3931, 221, 'NTT', 'Nottinghamshire', 'english');
INSERT INTO emkt_regions VALUES(3932, 221, 'NTY', 'North Tyneside', 'english');
INSERT INTO emkt_regions VALUES(3933, 221, 'NWM', 'Newham', 'english');
INSERT INTO emkt_regions VALUES(3934, 221, 'NWP', 'Newport', 'english');
INSERT INTO emkt_regions VALUES(3935, 221, 'NYK', 'North Yorkshire', 'english');
INSERT INTO emkt_regions VALUES(3936, 221, 'NYM', 'Newry and Mourne', 'english');
INSERT INTO emkt_regions VALUES(3937, 221, 'OLD', 'Oldham', 'english');
INSERT INTO emkt_regions VALUES(3938, 221, 'OMH', 'Omagh', 'english');
INSERT INTO emkt_regions VALUES(3939, 221, 'ORK', 'Orkney Islands', 'english');
INSERT INTO emkt_regions VALUES(3940, 221, 'OXF', 'Oxfordshire', 'english');
INSERT INTO emkt_regions VALUES(3941, 221, 'PEM', 'Pembrokeshire', 'english');
INSERT INTO emkt_regions VALUES(3942, 221, 'PKN', 'Perth and Kinross', 'english');
INSERT INTO emkt_regions VALUES(3943, 221, 'PLY', 'Plymouth', 'english');
INSERT INTO emkt_regions VALUES(3944, 221, 'POL', 'Poole', 'english');
INSERT INTO emkt_regions VALUES(3945, 221, 'POR', 'Portsmouth', 'english');
INSERT INTO emkt_regions VALUES(3946, 221, 'POW', 'Powys', 'english');
INSERT INTO emkt_regions VALUES(3947, 221, 'PTE', 'Peterborough', 'english');
INSERT INTO emkt_regions VALUES(3948, 221, 'RCC', 'Redcar and Cleveland', 'english');
INSERT INTO emkt_regions VALUES(3949, 221, 'RCH', 'Rochdale', 'english');
INSERT INTO emkt_regions VALUES(3950, 221, 'RCT', 'Rhondda Cynon Taf', 'english');
INSERT INTO emkt_regions VALUES(3951, 221, 'RDB', 'Redbridge', 'english');
INSERT INTO emkt_regions VALUES(3952, 221, 'RDG', 'Reading', 'english');
INSERT INTO emkt_regions VALUES(3953, 221, 'RFW', 'Renfrewshire', 'english');
INSERT INTO emkt_regions VALUES(3954, 221, 'RIC', 'Richmond upon Thames', 'english');
INSERT INTO emkt_regions VALUES(3955, 221, 'ROT', 'Rotherham', 'english');
INSERT INTO emkt_regions VALUES(3956, 221, 'RUT', 'Rutland', 'english');
INSERT INTO emkt_regions VALUES(3957, 221, 'SAW', 'Sandwell', 'english');
INSERT INTO emkt_regions VALUES(3958, 221, 'SAY', 'South Ayrshire', 'english');
INSERT INTO emkt_regions VALUES(3959, 221, 'SCB', 'Scottish Borders', 'english');
INSERT INTO emkt_regions VALUES(3960, 221, 'SFK', 'Suffolk', 'english');
INSERT INTO emkt_regions VALUES(3961, 221, 'SFT', 'Sefton', 'english');
INSERT INTO emkt_regions VALUES(3962, 221, 'SGC', 'South Gloucestershire', 'english');
INSERT INTO emkt_regions VALUES(3963, 221, 'SHF', 'Sheffield', 'english');
INSERT INTO emkt_regions VALUES(3964, 221, 'SHN', 'Saint Helens', 'english');
INSERT INTO emkt_regions VALUES(3965, 221, 'SHR', 'Shropshire', 'english');
INSERT INTO emkt_regions VALUES(3966, 221, 'SKP', 'Stockport', 'english');
INSERT INTO emkt_regions VALUES(3967, 221, 'SLF', 'Salford', 'english');
INSERT INTO emkt_regions VALUES(3968, 221, 'SLG', 'Slough', 'english');
INSERT INTO emkt_regions VALUES(3969, 221, 'SLK', 'South Lanarkshire', 'english');
INSERT INTO emkt_regions VALUES(3970, 221, 'SND', 'Sunderland', 'english');
INSERT INTO emkt_regions VALUES(3971, 221, 'SOL', 'Solihull', 'english');
INSERT INTO emkt_regions VALUES(3972, 221, 'SOM', 'Somerset', 'english');
INSERT INTO emkt_regions VALUES(3973, 221, 'SOS', 'Southend-on-Sea', 'english');
INSERT INTO emkt_regions VALUES(3974, 221, 'SRY', 'Surrey', 'english');
INSERT INTO emkt_regions VALUES(3975, 221, 'STB', 'Strabane', 'english');
INSERT INTO emkt_regions VALUES(3976, 221, 'STE', 'Stoke-on-Trent', 'english');
INSERT INTO emkt_regions VALUES(3977, 221, 'STG', 'Stirling', 'english');
INSERT INTO emkt_regions VALUES(3978, 221, 'STH', 'Southampton', 'english');
INSERT INTO emkt_regions VALUES(3979, 221, 'STN', 'Sutton', 'english');
INSERT INTO emkt_regions VALUES(3980, 221, 'STS', 'Staffordshire', 'english');
INSERT INTO emkt_regions VALUES(3981, 221, 'STT', 'Stockton-on-Tees', 'english');
INSERT INTO emkt_regions VALUES(3982, 221, 'STY', 'South Tyneside', 'english');
INSERT INTO emkt_regions VALUES(3983, 221, 'SWA', 'Swansea', 'english');
INSERT INTO emkt_regions VALUES(3984, 221, 'SWD', 'Swindon', 'english');
INSERT INTO emkt_regions VALUES(3985, 221, 'SWK', 'Southwark', 'english');
INSERT INTO emkt_regions VALUES(3986, 221, 'TAM', 'Tameside', 'english');
INSERT INTO emkt_regions VALUES(3987, 221, 'TFW', 'Telford and Wrekin', 'english');
INSERT INTO emkt_regions VALUES(3988, 221, 'THR', 'Thurrock', 'english');
INSERT INTO emkt_regions VALUES(3989, 221, 'TOB', 'Torbay', 'english');
INSERT INTO emkt_regions VALUES(3990, 221, 'TOF', 'Torfaen', 'english');
INSERT INTO emkt_regions VALUES(3991, 221, 'TRF', 'Trafford', 'english');
INSERT INTO emkt_regions VALUES(3992, 221, 'TWH', 'Tower Hamlets', 'english');
INSERT INTO emkt_regions VALUES(3993, 221, 'VGL', 'Vale of Glamorgan', 'english');
INSERT INTO emkt_regions VALUES(3994, 221, 'WAR', 'Warwickshire', 'english');
INSERT INTO emkt_regions VALUES(3995, 221, 'WBK', 'West Berkshire', 'english');
INSERT INTO emkt_regions VALUES(3996, 221, 'WDU', 'West Dunbartonshire', 'english');
INSERT INTO emkt_regions VALUES(3997, 221, 'WFT', 'Waltham Forest', 'english');
INSERT INTO emkt_regions VALUES(3998, 221, 'WGN', 'Wigan', 'english');
INSERT INTO emkt_regions VALUES(3999, 221, 'WIL', 'Wiltshire', 'english');
INSERT INTO emkt_regions VALUES(4000, 221, 'WKF', 'Wakefield', 'english');
INSERT INTO emkt_regions VALUES(4001, 221, 'WLL', 'Walsall', 'english');
INSERT INTO emkt_regions VALUES(4002, 221, 'WLN', 'West Lothian', 'english');
INSERT INTO emkt_regions VALUES(4003, 221, 'WLV', 'Wolverhampton', 'english');
INSERT INTO emkt_regions VALUES(4004, 221, 'WNM', 'Windsor and Maidenhead', 'english');
INSERT INTO emkt_regions VALUES(4005, 221, 'WOK', 'Wokingham', 'english');
INSERT INTO emkt_regions VALUES(4006, 221, 'WOR', 'Worcestershire', 'english');
INSERT INTO emkt_regions VALUES(4007, 221, 'WRL', 'Wirral', 'english');
INSERT INTO emkt_regions VALUES(4008, 221, 'WRT', 'Warrington', 'english');
INSERT INTO emkt_regions VALUES(4009, 221, 'WRX', 'Wrexham', 'english');
INSERT INTO emkt_regions VALUES(4010, 221, 'WSM', 'Westminster', 'english');
INSERT INTO emkt_regions VALUES(4011, 221, 'WSX', 'West Sussex', 'english');
INSERT INTO emkt_regions VALUES(4012, 221, 'YOR', 'York', 'english');
INSERT INTO emkt_regions VALUES(4013, 221, 'ZET', 'Shetland Islands', 'english');

INSERT INTO emkt_countries VALUES (222,'United States of America','english','US','USA','');

INSERT INTO emkt_regions VALUES(4014, 222, 'AK', 'Alaska', 'english');
INSERT INTO emkt_regions VALUES(4015, 222, 'AL', 'Alabama', 'english');
INSERT INTO emkt_regions VALUES(4016, 222, 'AS', 'American Samoa', 'english');
INSERT INTO emkt_regions VALUES(4017, 222, 'AR', 'Arkansas', 'english');
INSERT INTO emkt_regions VALUES(4018, 222, 'AZ', 'Arizona', 'english');
INSERT INTO emkt_regions VALUES(4019, 222, 'CA', 'California', 'english');
INSERT INTO emkt_regions VALUES(4020, 222, 'CO', 'Colorado', 'english');
INSERT INTO emkt_regions VALUES(4021, 222, 'CT', 'Connecticut', 'english');
INSERT INTO emkt_regions VALUES(4022, 222, 'DC', 'District of Columbia', 'english');
INSERT INTO emkt_regions VALUES(4023, 222, 'DE', 'Delaware', 'english');
INSERT INTO emkt_regions VALUES(4024, 222, 'FL', 'Florida', 'english');
INSERT INTO emkt_regions VALUES(4025, 222, 'GA', 'Georgia', 'english');
INSERT INTO emkt_regions VALUES(4026, 222, 'GU', 'Guam', 'english');
INSERT INTO emkt_regions VALUES(4027, 222, 'HI', 'Hawaii', 'english');
INSERT INTO emkt_regions VALUES(4028, 222, 'IA', 'Iowa', 'english');
INSERT INTO emkt_regions VALUES(4029, 222, 'ID', 'Idaho', 'english');
INSERT INTO emkt_regions VALUES(4030, 222, 'IL', 'Illinois', 'english');
INSERT INTO emkt_regions VALUES(4031, 222, 'IN', 'Indiana', 'english');
INSERT INTO emkt_regions VALUES(4032, 222, 'KS', 'Kansas', 'english');
INSERT INTO emkt_regions VALUES(4033, 222, 'KY', 'Kentucky', 'english');
INSERT INTO emkt_regions VALUES(4034, 222, 'LA', 'Louisiana', 'english');
INSERT INTO emkt_regions VALUES(4035, 222, 'MA', 'Massachusetts', 'english');
INSERT INTO emkt_regions VALUES(4036, 222, 'MD', 'Maryland', 'english');
INSERT INTO emkt_regions VALUES(4037, 222, 'ME', 'Maine', 'english');
INSERT INTO emkt_regions VALUES(4038, 222, 'MI', 'Michigan', 'english');
INSERT INTO emkt_regions VALUES(4039, 222, 'MN', 'Minnesota', 'english');
INSERT INTO emkt_regions VALUES(4040, 222, 'MO', 'Missouri', 'english');
INSERT INTO emkt_regions VALUES(4041, 222, 'MS', 'Mississippi', 'english');
INSERT INTO emkt_regions VALUES(4042, 222, 'MT', 'Montana', 'english');
INSERT INTO emkt_regions VALUES(4043, 222, 'NC', 'North Carolina', 'english');
INSERT INTO emkt_regions VALUES(4044, 222, 'ND', 'North Dakota', 'english');
INSERT INTO emkt_regions VALUES(4045, 222, 'NE', 'Nebraska', 'english');
INSERT INTO emkt_regions VALUES(4046, 222, 'NH', 'New Hampshire', 'english');
INSERT INTO emkt_regions VALUES(4047, 222, 'NJ', 'New Jersey', 'english');
INSERT INTO emkt_regions VALUES(4048, 222, 'NM', 'New Mexico', 'english');
INSERT INTO emkt_regions VALUES(4049, 222, 'NV', 'Nevada', 'english');
INSERT INTO emkt_regions VALUES(4050, 222, 'NY', 'New York', 'english');
INSERT INTO emkt_regions VALUES(4051, 222, 'MP', 'Northern Mariana Islands', 'english');
INSERT INTO emkt_regions VALUES(4052, 222, 'OH', 'Ohio', 'english');
INSERT INTO emkt_regions VALUES(4053, 222, 'OK', 'Oklahoma', 'english');
INSERT INTO emkt_regions VALUES(4054, 222, 'OR', 'Oregon', 'english');
INSERT INTO emkt_regions VALUES(4055, 222, 'PA', 'Pennsylvania', 'english');
INSERT INTO emkt_regions VALUES(4056, 222, 'PR', 'Puerto Rico', 'english');
INSERT INTO emkt_regions VALUES(4057, 222, 'RI', 'Rhode Island', 'english');
INSERT INTO emkt_regions VALUES(4058, 222, 'SC', 'South Carolina', 'english');
INSERT INTO emkt_regions VALUES(4059, 222, 'SD', 'South Dakota', 'english');
INSERT INTO emkt_regions VALUES(4060, 222, 'TN', 'Tennessee', 'english');
INSERT INTO emkt_regions VALUES(4061, 222, 'TX', 'Texas', 'english');
INSERT INTO emkt_regions VALUES(4062, 222, 'UM', 'U.S. Minor Outlying Islands', 'english');
INSERT INTO emkt_regions VALUES(4063, 222, 'UT', 'Utah', 'english');
INSERT INTO emkt_regions VALUES(4064, 222, 'VA', 'Virginia', 'english');
INSERT INTO emkt_regions VALUES(4065, 222, 'VI', 'Virgin Islands of the U.S.', 'english');
INSERT INTO emkt_regions VALUES(4066, 222, 'VT', 'Vermont', 'english');
INSERT INTO emkt_regions VALUES(4067, 222, 'WA', 'Washington', 'english');
INSERT INTO emkt_regions VALUES(4068, 222, 'WI', 'Wisconsin', 'english');
INSERT INTO emkt_regions VALUES(4069, 222, 'WV', 'West Virginia', 'english');
INSERT INTO emkt_regions VALUES(4070, 222, 'WY', 'Wyoming', 'english');

INSERT INTO emkt_countries VALUES (223,'United States Minor Outlying Islands','english','UM','UMI','');

INSERT INTO emkt_regions VALUES(4071, 223, 'BI', 'Baker Island', 'english');
INSERT INTO emkt_regions VALUES(4072, 223, 'HI', 'Howland Island', 'english');
INSERT INTO emkt_regions VALUES(4073, 223, 'JI', 'Jarvis Island', 'english');
INSERT INTO emkt_regions VALUES(4074, 223, 'JA', 'Johnston Atoll', 'english');
INSERT INTO emkt_regions VALUES(4075, 223, 'KR', 'Kingman Reef', 'english');
INSERT INTO emkt_regions VALUES(4076, 223, 'MA', 'Midway Atoll', 'english');
INSERT INTO emkt_regions VALUES(4077, 223, 'NI', 'Navassa Island', 'english');
INSERT INTO emkt_regions VALUES(4078, 223, 'PA', 'Palmyra Atoll', 'english');
INSERT INTO emkt_regions VALUES(4079, 223, 'WI', 'Wake Island', 'english');

INSERT INTO emkt_countries VALUES (224,'Uruguay','english','UY','URY','');

INSERT INTO emkt_regions VALUES(4080, 224, 'AR', 'Artigas', 'english');
INSERT INTO emkt_regions VALUES(4081, 224, 'CA', 'Canelones', 'english');
INSERT INTO emkt_regions VALUES(4082, 224, 'CL', 'Cerro Largo', 'english');
INSERT INTO emkt_regions VALUES(4083, 224, 'CO', 'Colonia', 'english');
INSERT INTO emkt_regions VALUES(4084, 224, 'DU', 'Durazno', 'english');
INSERT INTO emkt_regions VALUES(4085, 224, 'FD', 'Florida', 'english');
INSERT INTO emkt_regions VALUES(4086, 224, 'FS', 'Flores', 'english');
INSERT INTO emkt_regions VALUES(4087, 224, 'LA', 'Lavalleja', 'english');
INSERT INTO emkt_regions VALUES(4088, 224, 'MA', 'Maldonado', 'english');
INSERT INTO emkt_regions VALUES(4089, 224, 'MO', 'Montevideo', 'english');
INSERT INTO emkt_regions VALUES(4090, 224, 'PA', 'Paysandu', 'english');
INSERT INTO emkt_regions VALUES(4091, 224, 'RN', 'Río Negro', 'english');
INSERT INTO emkt_regions VALUES(4092, 224, 'RO', 'Rocha', 'english');
INSERT INTO emkt_regions VALUES(4093, 224, 'RV', 'Rivera', 'english');
INSERT INTO emkt_regions VALUES(4094, 224, 'SA', 'Salto', 'english');
INSERT INTO emkt_regions VALUES(4095, 224, 'SJ', 'San José', 'english');
INSERT INTO emkt_regions VALUES(4096, 224, 'SO', 'Soriano', 'english');
INSERT INTO emkt_regions VALUES(4097, 224, 'TA', 'Tacuarembó', 'english');
INSERT INTO emkt_regions VALUES(4098, 224, 'TT', 'Treinta y Tres', 'english');

INSERT INTO emkt_countries VALUES (225,'Uzbekistan','english','UZ','UZB','');

INSERT INTO emkt_regions VALUES(4099, 225, 'AN', 'Andijon viloyati', 'english');
INSERT INTO emkt_regions VALUES(4100, 225, 'BU', 'Buxoro viloyati', 'english');
INSERT INTO emkt_regions VALUES(4101, 225, 'FA', 'Farg\'ona viloyati', 'english');
INSERT INTO emkt_regions VALUES(4102, 225, 'JI', 'Jizzax viloyati', 'english');
INSERT INTO emkt_regions VALUES(4103, 225, 'NG', 'Namangan viloyati', 'english');
INSERT INTO emkt_regions VALUES(4104, 225, 'NW', 'Navoiy viloyati', 'english');
INSERT INTO emkt_regions VALUES(4105, 225, 'QA', 'Qashqadaryo viloyati', 'english');
INSERT INTO emkt_regions VALUES(4106, 225, 'QR', 'Qoraqalpog\'iston Respublikasi', 'english');
INSERT INTO emkt_regions VALUES(4107, 225, 'SA', 'Samarqand viloyati', 'english');
INSERT INTO emkt_regions VALUES(4108, 225, 'SI', 'Sirdaryo viloyati', 'english');
INSERT INTO emkt_regions VALUES(4109, 225, 'SU', 'Surxondaryo viloyati', 'english');
INSERT INTO emkt_regions VALUES(4110, 225, 'TK', 'Toshkent', 'english');
INSERT INTO emkt_regions VALUES(4111, 225, 'TO', 'Toshkent viloyati', 'english');
INSERT INTO emkt_regions VALUES(4112, 225, 'XO', 'Xorazm viloyati', 'english');

INSERT INTO emkt_countries VALUES (226,'Vanuatu','english','VU','VUT','');

INSERT INTO emkt_regions VALUES(4113, 226, 'MAP', 'Malampa', 'english');
INSERT INTO emkt_regions VALUES(4114, 226, 'PAM', 'Pénama', 'english');
INSERT INTO emkt_regions VALUES(4115, 226, 'SAM', 'Sanma', 'english');
INSERT INTO emkt_regions VALUES(4116, 226, 'SEE', 'Shéfa', 'english');
INSERT INTO emkt_regions VALUES(4117, 226, 'TAE', 'Taféa', 'english');
INSERT INTO emkt_regions VALUES(4118, 226, 'TOB', 'Torba', 'english');

INSERT INTO emkt_countries VALUES (227,'Vatican City State (Holy See)','english','VA','VAT','');

INSERT INTO emkt_regions VALUES(4279, 227, 'NOCODE', 'Vatican City State (Holy See)', 'english');

INSERT INTO emkt_countries VALUES (228,'Venezuela','english','VE','VEN','');

INSERT INTO emkt_regions VALUES(4119, 228, 'A', 'Distrito Capital', 'english');
INSERT INTO emkt_regions VALUES(4120, 228, 'B', 'Anzoátegui', 'english');
INSERT INTO emkt_regions VALUES(4121, 228, 'C', 'Apure', 'english');
INSERT INTO emkt_regions VALUES(4122, 228, 'D', 'Aragua', 'english');
INSERT INTO emkt_regions VALUES(4123, 228, 'E', 'Barinas', 'english');
INSERT INTO emkt_regions VALUES(4124, 228, 'F', 'Bolívar', 'english');
INSERT INTO emkt_regions VALUES(4125, 228, 'G', 'Carabobo', 'english');
INSERT INTO emkt_regions VALUES(4126, 228, 'H', 'Cojedes', 'english');
INSERT INTO emkt_regions VALUES(4127, 228, 'I', 'Falcón', 'english');
INSERT INTO emkt_regions VALUES(4128, 228, 'J', 'Guárico', 'english');
INSERT INTO emkt_regions VALUES(4129, 228, 'K', 'Lara', 'english');
INSERT INTO emkt_regions VALUES(4130, 228, 'L', 'Mérida', 'english');
INSERT INTO emkt_regions VALUES(4131, 228, 'M', 'Miranda', 'english');
INSERT INTO emkt_regions VALUES(4132, 228, 'N', 'Monagas', 'english');
INSERT INTO emkt_regions VALUES(4133, 228, 'O', 'Nueva Esparta', 'english');
INSERT INTO emkt_regions VALUES(4134, 228, 'P', 'Portuguesa', 'english');
INSERT INTO emkt_regions VALUES(4135, 228, 'R', 'Sucre', 'english');
INSERT INTO emkt_regions VALUES(4136, 228, 'S', 'Tachira', 'english');
INSERT INTO emkt_regions VALUES(4137, 228, 'T', 'Trujillo', 'english');
INSERT INTO emkt_regions VALUES(4138, 228, 'U', 'Yaracuy', 'english');
INSERT INTO emkt_regions VALUES(4139, 228, 'V', 'Zulia', 'english');
INSERT INTO emkt_regions VALUES(4140, 228, 'W', 'Capital Dependencia', 'english');
INSERT INTO emkt_regions VALUES(4141, 228, 'X', 'Vargas', 'english');
INSERT INTO emkt_regions VALUES(4142, 228, 'Y', 'Delta Amacuro', 'english');
INSERT INTO emkt_regions VALUES(4143, 228, 'Z', 'Amazonas', 'english');

INSERT INTO emkt_countries VALUES (229,'Vietnam','english','VN','VNM','');

INSERT INTO emkt_regions VALUES(4144, 229, '01', 'Lai Châu', 'english');
INSERT INTO emkt_regions VALUES(4145, 229, '02', 'Lào Cai', 'english');
INSERT INTO emkt_regions VALUES(4146, 229, '03', 'Hà Giang', 'english');
INSERT INTO emkt_regions VALUES(4147, 229, '04', 'Cao Bằng', 'english');
INSERT INTO emkt_regions VALUES(4148, 229, '05', 'Sơn La', 'english');
INSERT INTO emkt_regions VALUES(4149, 229, '06', 'Yên Bái', 'english');
INSERT INTO emkt_regions VALUES(4150, 229, '07', 'Tuyên Quang', 'english');
INSERT INTO emkt_regions VALUES(4151, 229, '09', 'Lạng Sơn', 'english');
INSERT INTO emkt_regions VALUES(4152, 229, '13', 'Quảng Ninh', 'english');
INSERT INTO emkt_regions VALUES(4153, 229, '14', 'Hòa Bình', 'english');
INSERT INTO emkt_regions VALUES(4154, 229, '15', 'Hà Tây', 'english');
INSERT INTO emkt_regions VALUES(4155, 229, '18', 'Ninh Bình', 'english');
INSERT INTO emkt_regions VALUES(4156, 229, '20', 'Thái Bình', 'english');
INSERT INTO emkt_regions VALUES(4157, 229, '21', 'Thanh Hóa', 'english');
INSERT INTO emkt_regions VALUES(4158, 229, '22', 'Nghệ An', 'english');
INSERT INTO emkt_regions VALUES(4159, 229, '23', 'Hà Tĩnh', 'english');
INSERT INTO emkt_regions VALUES(4160, 229, '24', 'Quảng Bình', 'english');
INSERT INTO emkt_regions VALUES(4161, 229, '25', 'Quảng Trị', 'english');
INSERT INTO emkt_regions VALUES(4162, 229, '26', 'Thừa Thiên-Huế', 'english');
INSERT INTO emkt_regions VALUES(4163, 229, '27', 'Quảng Nam', 'english');
INSERT INTO emkt_regions VALUES(4164, 229, '28', 'Kon Tum', 'english');
INSERT INTO emkt_regions VALUES(4165, 229, '29', 'Quảng Ngãi', 'english');
INSERT INTO emkt_regions VALUES(4166, 229, '30', 'Gia Lai', 'english');
INSERT INTO emkt_regions VALUES(4167, 229, '31', 'Bình Định', 'english');
INSERT INTO emkt_regions VALUES(4168, 229, '32', 'Phú Yên', 'english');
INSERT INTO emkt_regions VALUES(4169, 229, '33', 'Đắk Lắk', 'english');
INSERT INTO emkt_regions VALUES(4170, 229, '34', 'Khánh Hòa', 'english');
INSERT INTO emkt_regions VALUES(4171, 229, '35', 'Lâm Đồng', 'english');
INSERT INTO emkt_regions VALUES(4172, 229, '36', 'Ninh Thuận', 'english');
INSERT INTO emkt_regions VALUES(4173, 229, '37', 'Tây Ninh', 'english');
INSERT INTO emkt_regions VALUES(4174, 229, '39', 'Đồng Nai', 'english');
INSERT INTO emkt_regions VALUES(4175, 229, '40', 'Bình Thuận', 'english');
INSERT INTO emkt_regions VALUES(4176, 229, '41', 'Long An', 'english');
INSERT INTO emkt_regions VALUES(4177, 229, '43', 'Bà Rịa-Vũng Tàu', 'english');
INSERT INTO emkt_regions VALUES(4178, 229, '44', 'An Giang', 'english');
INSERT INTO emkt_regions VALUES(4179, 229, '45', 'Đồng Tháp', 'english');
INSERT INTO emkt_regions VALUES(4180, 229, '46', 'Tiền Giang', 'english');
INSERT INTO emkt_regions VALUES(4181, 229, '47', 'Kiên Giang', 'english');
INSERT INTO emkt_regions VALUES(4182, 229, '48', 'Cần Thơ', 'english');
INSERT INTO emkt_regions VALUES(4183, 229, '49', 'Vĩnh Long', 'english');
INSERT INTO emkt_regions VALUES(4184, 229, '50', 'Bến Tre', 'english');
INSERT INTO emkt_regions VALUES(4185, 229, '51', 'Trà Vinh', 'english');
INSERT INTO emkt_regions VALUES(4186, 229, '52', 'Sóc Trăng', 'english');
INSERT INTO emkt_regions VALUES(4187, 229, '53', 'Bắc Kạn', 'english');
INSERT INTO emkt_regions VALUES(4188, 229, '54', 'Bắc Giang', 'english');
INSERT INTO emkt_regions VALUES(4189, 229, '55', 'Bạc Liêu', 'english');
INSERT INTO emkt_regions VALUES(4190, 229, '56', 'Bắc Ninh', 'english');
INSERT INTO emkt_regions VALUES(4191, 229, '57', 'Bình Dương', 'english');
INSERT INTO emkt_regions VALUES(4192, 229, '58', 'Bình Phước', 'english');
INSERT INTO emkt_regions VALUES(4193, 229, '59', 'Cà Mau', 'english');
INSERT INTO emkt_regions VALUES(4194, 229, '60', 'Đà Nẵng', 'english');
INSERT INTO emkt_regions VALUES(4195, 229, '61', 'Hải Dương', 'english');
INSERT INTO emkt_regions VALUES(4196, 229, '62', 'Hải Phòng', 'english');
INSERT INTO emkt_regions VALUES(4197, 229, '63', 'Hà Nam', 'english');
INSERT INTO emkt_regions VALUES(4198, 229, '64', 'Hà Nội', 'english');
INSERT INTO emkt_regions VALUES(4199, 229, '65', 'Sài Gòn', 'english');
INSERT INTO emkt_regions VALUES(4200, 229, '66', 'Hưng Yên', 'english');
INSERT INTO emkt_regions VALUES(4201, 229, '67', 'Nam Định', 'english');
INSERT INTO emkt_regions VALUES(4202, 229, '68', 'Phú Thọ', 'english');
INSERT INTO emkt_regions VALUES(4203, 229, '69', 'Thái Nguyên', 'english');
INSERT INTO emkt_regions VALUES(4204, 229, '70', 'Vĩnh Phúc', 'english');
INSERT INTO emkt_regions VALUES(4205, 229, '71', 'Điện Biên', 'english');
INSERT INTO emkt_regions VALUES(4206, 229, '72', 'Đắk Nông', 'english');
INSERT INTO emkt_regions VALUES(4207, 229, '73', 'Hậu Giang', 'english');

INSERT INTO emkt_countries VALUES (230,'Virgin Islands (British)','english','VG','VGB','');

INSERT INTO emkt_regions VALUES(4280, 230, 'NOCODE', 'Virgin Islands (British)', 'english');

INSERT INTO emkt_countries VALUES (231,'Virgin Islands (U.S.)','english','VI','VIR','');

INSERT INTO emkt_regions VALUES(4208, 231, 'C', 'Saint Croix', 'english');
INSERT INTO emkt_regions VALUES(4209, 231, 'J', 'Saint John', 'english');
INSERT INTO emkt_regions VALUES(4210, 231, 'T', 'Saint Thomas', 'english');

INSERT INTO emkt_countries VALUES (232,'Wallis and Futuna Islands','english','WF','WLF','');

INSERT INTO emkt_regions VALUES(4211, 232, 'A', 'Alo', 'english');
INSERT INTO emkt_regions VALUES(4212, 232, 'S', 'Sigave', 'english');
INSERT INTO emkt_regions VALUES(4213, 232, 'W', 'Wallis', 'english');

INSERT INTO emkt_countries VALUES (233,'Western Sahara','english','EH','ESH','');

INSERT INTO emkt_regions VALUES(4281, 233, 'NOCODE', 'Western Sahara', 'english');

INSERT INTO emkt_countries VALUES (234,'Yemen','english','YE','YEM','');

INSERT INTO emkt_regions VALUES(4214, 234, 'AB', 'أبين‎', 'english');
INSERT INTO emkt_regions VALUES(4215, 234, 'AD', 'عدن', 'english');
INSERT INTO emkt_regions VALUES(4216, 234, 'AM', 'عمران', 'english');
INSERT INTO emkt_regions VALUES(4217, 234, 'BA', 'البيضاء', 'english');
INSERT INTO emkt_regions VALUES(4218, 234, 'DA', 'الضالع', 'english');
INSERT INTO emkt_regions VALUES(4219, 234, 'DH', 'ذمار', 'english');
INSERT INTO emkt_regions VALUES(4220, 234, 'HD', 'حضرموت', 'english');
INSERT INTO emkt_regions VALUES(4221, 234, 'HJ', 'حجة', 'english');
INSERT INTO emkt_regions VALUES(4222, 234, 'HU', 'الحديدة', 'english');
INSERT INTO emkt_regions VALUES(4223, 234, 'IB', 'إب', 'english');
INSERT INTO emkt_regions VALUES(4224, 234, 'JA', 'الجوف', 'english');
INSERT INTO emkt_regions VALUES(4225, 234, 'LA', 'لحج', 'english');
INSERT INTO emkt_regions VALUES(4226, 234, 'MA', 'مأرب', 'english');
INSERT INTO emkt_regions VALUES(4227, 234, 'MR', 'المهرة', 'english');
INSERT INTO emkt_regions VALUES(4228, 234, 'MW', 'المحويت', 'english');
INSERT INTO emkt_regions VALUES(4229, 234, 'SD', 'صعدة', 'english');
INSERT INTO emkt_regions VALUES(4230, 234, 'SN', 'صنعاء', 'english');
INSERT INTO emkt_regions VALUES(4231, 234, 'SH', 'شبوة', 'english');
INSERT INTO emkt_regions VALUES(4232, 234, 'TA', 'تعز', 'english');

INSERT INTO emkt_countries VALUES (235,'Yugoslavia','english','YU','YUG','');

INSERT INTO emkt_regions VALUES(4282, 235, 'NOCODE', 'Yugoslavia', 'english');

INSERT INTO emkt_countries VALUES (236,'Zaire','english','ZR','ZAR','');

INSERT INTO emkt_regions VALUES(4283, 236, 'NOCODE', 'Zaire', 'english');

INSERT INTO emkt_countries VALUES (237,'Zambia','english','ZM','ZMB','');

INSERT INTO emkt_regions VALUES(4233, 237, '01', 'Western', 'english');
INSERT INTO emkt_regions VALUES(4234, 237, '02', 'Central', 'english');
INSERT INTO emkt_regions VALUES(4235, 237, '03', 'Eastern', 'english');
INSERT INTO emkt_regions VALUES(4236, 237, '04', 'Luapula', 'english');
INSERT INTO emkt_regions VALUES(4237, 237, '05', 'Northern', 'english');
INSERT INTO emkt_regions VALUES(4238, 237, '06', 'North-Western', 'english');
INSERT INTO emkt_regions VALUES(4239, 237, '07', 'Southern', 'english');
INSERT INTO emkt_regions VALUES(4240, 237, '08', 'Copperbelt', 'english');
INSERT INTO emkt_regions VALUES(4241, 237, '09', 'Lusaka', 'english');

INSERT INTO emkt_countries VALUES (238,'Zimbabwe','english','ZW','ZWE','');

INSERT INTO emkt_regions VALUES(4242, 238, 'MA', 'Manicaland', 'english');
INSERT INTO emkt_regions VALUES(4243, 238, 'MC', 'Mashonaland Central', 'english');
INSERT INTO emkt_regions VALUES(4244, 238, 'ME', 'Mashonaland East', 'english');
INSERT INTO emkt_regions VALUES(4245, 238, 'MI', 'Midlands', 'english');
INSERT INTO emkt_regions VALUES(4246, 238, 'MN', 'Matabeleland North', 'english');
INSERT INTO emkt_regions VALUES(4247, 238, 'MS', 'Matabeleland South', 'english');
INSERT INTO emkt_regions VALUES(4248, 238, 'MV', 'Masvingo', 'english');
INSERT INTO emkt_regions VALUES(4249, 238, 'MW', 'Mashonaland West', 'english');

/* Basic Settings */
INSERT INTO emkt_basic_settings VALUES (1, 20, 60, 0, 'smtp.mail.ru', 'login', 'password', 'ssl', 465, 0, 0, 'sale@localhost.ru', 'eMarket', '');

/* Zones */
INSERT INTO emkt_zones VALUES (1, 'Moskow', null, 'english');
INSERT INTO emkt_zones VALUES (1, 'Москва', null, 'russian');

/* Zones value */
INSERT INTO emkt_zones_value VALUES (1, 175, 2869, 1);

/* Taxes */
INSERT INTO emkt_taxes VALUES (1, 'VAT', 'english', '20.00', '1', '1', '1', '1');
INSERT INTO emkt_taxes VALUES (1, 'НДС', 'russian', '20.00', '1', '1', '1', '1');

/* Length */
INSERT INTO emkt_length VALUES (1, 'Meter', 'm.', 'english', '1.0000000', '1');
INSERT INTO emkt_length VALUES (1, 'Метр', 'м.', 'russian', '1.0000000', '1');
INSERT INTO emkt_length VALUES (2, 'Centimeter', 'cm.', 'english', '0.0100000', '0');
INSERT INTO emkt_length VALUES (2, 'Сантиметр', 'см.', 'russian', '0.0100000', '0');
INSERT INTO emkt_length VALUES (3, 'Millimeter', 'mm.', 'english', '0.0010000', '0');
INSERT INTO emkt_length VALUES (3, 'Миллиметр', 'мм.', 'russian', '0.0010000', '0');
INSERT INTO emkt_length VALUES (4, 'Inch', 'in.', 'english', '0.0254000', '0');
INSERT INTO emkt_length VALUES (4, 'Дюйм', 'д.', 'russian', '0.0254000', '0');
INSERT INTO emkt_length VALUES (5, 'Foot', 'ft.', 'english', '0.3048000', '0');
INSERT INTO emkt_length VALUES (5, 'Фут', 'ф.', 'russian', '0.3048000', '0');

/* Weight */
INSERT INTO emkt_weight VALUES (1, 'Kilogram', 'kg.', 'english', '1.0000000', '1');
INSERT INTO emkt_weight VALUES (1, 'Килограмм', 'кг', 'russian', '1.0000000', '1');
INSERT INTO emkt_weight VALUES (2, 'Gram', 'g.', 'english', '0.0010000', '0');
INSERT INTO emkt_weight VALUES (2, 'Грамм', 'г.', 'russian', '0.0010000', '0');
INSERT INTO emkt_weight VALUES (3, 'Ounce', 'oz.', 'english', '0.0283500', '0');
INSERT INTO emkt_weight VALUES (3, 'Унция', 'ун.', 'russian', '0.0283500', '0');

/* Vendor codes */
INSERT INTO emkt_vendor_codes VALUES (1, 'SCU', 'english', '', '1');
INSERT INTO emkt_vendor_codes VALUES (1, 'Артикул', 'russian', '', '1');
INSERT INTO emkt_vendor_codes VALUES (2, 'UPC', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (2, 'UPC', 'russian', '', '0');
INSERT INTO emkt_vendor_codes VALUES (3, 'EAN', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (3, 'EAN', 'russian', '', '0');
INSERT INTO emkt_vendor_codes VALUES (4, 'JAN', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (4, 'JAN', 'russian', '', '0');
INSERT INTO emkt_vendor_codes VALUES (5, 'ISBN', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (5, 'ISBN', 'russian', '', '0');
INSERT INTO emkt_vendor_codes VALUES (6, 'MPN', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (6, 'MPN', 'russian', '', '0');

/* Units */
INSERT INTO emkt_units VALUES (1, 'Pieces', 'english', 'pcs.', '1');
INSERT INTO emkt_units VALUES (1, 'Штука', 'russian', 'шт.', '1');
INSERT INTO emkt_units VALUES (2, 'Packing', 'english', 'pkg.', '0');
INSERT INTO emkt_units VALUES (2, 'Упаковка', 'russian', 'уп.', '0');

/* Statuses */
INSERT INTO emkt_order_status VALUES (1, 'Refund', 'english', '0', '1');
INSERT INTO emkt_order_status VALUES (1, 'Возврат', 'russian', '0', '1');
INSERT INTO emkt_order_status VALUES (2, 'Delivered', 'english', '0', '2');
INSERT INTO emkt_order_status VALUES (2, 'Доставлен', 'russian', '0', '2');
INSERT INTO emkt_order_status VALUES (3, 'Processing', 'english', '0', '3');
INSERT INTO emkt_order_status VALUES (3, 'Обрабатывается', 'russian', '0', '3');
INSERT INTO emkt_order_status VALUES (4, 'Paid', 'english', '0', '4');
INSERT INTO emkt_order_status VALUES (4, 'Оплачен', 'russian', '0', '4');
INSERT INTO emkt_order_status VALUES (5, 'Pending payment', 'english', '1', '5');
INSERT INTO emkt_order_status VALUES (5, 'Ожидает оплаты', 'russian', '1', '5');

/* Currencies */
INSERT INTO emkt_currencies VALUES (1, 'Russian Rouble', 'rub.', 'RUB', 'english', '1.0000000000', '1', ' ₽', 'right', '2', NULL);
INSERT INTO emkt_currencies VALUES (1, 'Рубль РФ', 'руб.', 'RUB', 'russian', '1.0000000000', '1', ' ₽', 'right', '2', NULL);
INSERT INTO emkt_currencies VALUES (2, 'Dollar USA', '$', 'USD', 'english', '0.0147000000', '0', '$', 'left', '2', NULL);
INSERT INTO emkt_currencies VALUES (2, 'Доллар США', 'долл.', 'USD', 'russian', '0.0147000000', '0', '$', 'left', '2', NULL);

/* Template constructor */
/* ADMIN */
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/admin/header.php', 'admin', 'header', 'all', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/admin/footer.php', 'admin', 'footer', 'all', 'default', '0');
/* INSTALL */
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/install/footer.php', 'install', 'footer', 'all', 'default', '0');
/* CATALOG ALL PAGES */
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/navbar.php', 'catalog', 'header', 'all', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/logo_search.php', 'catalog', 'header', 'all', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/breadcrumb.php', 'catalog', 'header', 'all', 'default', '2');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/slide_show.php', 'catalog', 'header', 'all', 'default', '3');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/copyright.php', 'catalog', 'footer', 'all', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories.php', 'catalog', 'boxes-left', 'all', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/welcome.php', 'catalog', 'content-basket', 'all', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_listing.php', 'catalog', 'content-basket', 'all', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/new_products.php', 'catalog', 'content-basket', 'all', 'default', '2');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_index.php', 'catalog', 'content-basket', 'all', 'default', '3');
/* CATALOG */
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/navbar.php', 'catalog', 'header', 'catalog', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/logo_search.php', 'catalog', 'header', 'catalog', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/breadcrumb.php', 'catalog', 'header', 'catalog', 'default', '2');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/slide_show.php', 'catalog', 'header', 'catalog', 'default', '3');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/copyright.php', 'catalog', 'footer', 'catalog', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories.php', 'catalog', 'boxes-left', 'catalog', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/welcome.php', 'catalog', 'content', 'catalog', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_index.php', 'catalog', 'content-basket', 'catalog', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_listing.php', 'catalog', 'content-basket', 'catalog', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/new_products.php', 'catalog', 'content', 'catalog', 'default', '2');
/* LISTING */
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/navbar.php', 'catalog', 'header', 'listing', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/logo_search.php', 'catalog', 'header', 'listing', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/breadcrumb.php', 'catalog', 'header', 'listing', 'default', '2');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/slide_show.php', 'catalog', 'header', 'listing', 'default', '3');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/copyright.php', 'catalog', 'footer', 'listing', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories.php', 'catalog', 'boxes-left', 'listing', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/welcome.php', 'catalog', 'content-basket', 'listing', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/new_products.php', 'catalog', 'content-basket', 'listing', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_index.php', 'catalog', 'content-basket', 'listing', 'default', '2');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_listing.php', 'catalog', 'content', 'listing', 'default', '1');
/* SLIDESHOW PREF */
INSERT INTO emkt_slideshow_pref (id, show_interval, mouse_stop, autostart, cicles, indicators, navigation) VALUES ('1', '2000', '0', '1', '0', '0', '0');
/* SAMPLES */
INSERT INTO emkt_categories (id, name, language, parent_id, logo, date_added, last_modified, sort_category, status, logo_general, attributes) VALUES
(2, 'Notebooks', 'english', 0, '[]', '2019-10-08 23:22:18', '2019-10-09 00:04:05', 2, 1, '[]', '[]'),
(2, 'Ноутбуки', 'russian', 0, '[]', '2019-10-08 23:22:18', '2019-10-09 00:04:05', 2, 1, '[]', '[]');

INSERT INTO emkt_manufacturers (id, name, language, logo, logo_general, site) VALUES
(1, 'HP', 'english', '["1570567320_HP_New_Logo_2D-svg.png"]', '1570567320_HP_New_Logo_2D-svg.png', 'http://www.hp.com'),
(1, 'HP', 'russian', '["1570567320_HP_New_Logo_2D-svg.png"]', '1570567320_HP_New_Logo_2D-svg.png', 'http://www.hp.com');

INSERT INTO emkt_products (id, name, description, language, status, parent_id, logo, logo_general, date_added, last_modified, keyword, tags, price, currency, tax, quantity, unit, model, date_available, manufacturer, barcode, barcode_value, vendor_code, vendor_code_value, weight, weight_value, min_quantity, dimension, length, width, height, type, ordered, viewed, download_file, downloads_stat, discount, attributes) VALUES
(1, 'HP EliteBook 840 G6', '<div _ngcontent-c7=\"\" class=\"hp-sub-title-lowercase feature-label\"><b><span style=\"font-size: 18px;\">Brilliant design</span></b></div><p _ngcontent-c7=\"\" class=\"hp-default-text feature-description\">\r\n Balance design, power, and mobility with this ultraslim distinctively \r\ndesigned aluminum laptop with a narrow border display. This light and \r\ncompact PC is built for the professional who requires top performance \r\nwhile on the go. </p><div _ngcontent-c7=\"\" class=\"hp-sub-title-lowercase feature-label\"><b><span style=\"font-size: 18px;\">Built on a secure foundation</span></b></div><p _ngcontent-c7=\"\" class=\"hp-default-text feature-description\">\r\n Protect your PC against the evolving malware threats of the future, \r\nwith self-healing, hardware-enforced, manageable security solutions from\r\n HP. From the BIOS to the browser HP Sure Start Gen5 and HP Sure \r\nClick help secure your PC. </p><div _ngcontent-c7=\"\" class=\"hp-sub-title-lowercase feature-label\"><b><span style=\"font-size: 18px;\">Crystal-clear collaboration</span></b></div><p _ngcontent-c7=\"\" class=\"hp-default-text feature-description\">\r\n Calls sound clear and crisp with advanced collaboration features like \r\nHP Noise Cancellation. Loud top-firing speakers produce rich sound. The \r\nworld-facing third microphone and collaboration keys help make PC calls \r\nproductive. </p>', 'english', 1, 2, '["1570568968_NBKHNB4496528__1.jpg","1570568968_NBKHNB4496528__2.jpg","1570568968_NBKHNB4496528__3.jpg","1570568968_NBKHNB4496528__4.jpg","1570568968_NBKHNB4496528__5.jpg"]', '1570568968_NBKHNB4496528__1.jpg', '2019-10-09 00:09:28', NULL, '', '', '30000.00', 1, 1, 10, 1, '', NULL, 1, NULL, NULL, '1', '', 1, '1.48', NULL, 2, '23.43', '32.60', '2.50', NULL, 0, 0, NULL, 0, '[]', '[]'),
(1, 'HP EliteBook 840 G6', '<div _ngcontent-c7=\"\" class=\"hp-sub-title-lowercase feature-label\"><b><span style=\"font-size: 18px;\">Великолепный дизайн</span></b></div><p _ngcontent-c7=\"\" class=\"hp-default-text feature-description\">\r\n Этот сверхтонкий ноутбук в алюминиевом корпусе, оснащенный экраном с \r\nузкими рамками, сочетает в себе оригинальный дизайн, мощность и \r\nмобильность. Этот легкий и компактный ПК создан для специалистов, \r\nкоторым требуется высокая производительность в пути. </p><div _ngcontent-c7=\"\" class=\"hp-sub-title-lowercase feature-label\"><b><span style=\"font-size: 18px;\">Создан для безопасности</span></b></div><p _ngcontent-c7=\"\" class=\"hp-default-text feature-description\">\r\n Администрируемые аппаратные решения для обеспечения безопасности HP с \r\nфункцией автоматического восстановления обеспечат защиту ПК от постоянно\r\n развивающегося вредоносного ПО. Технологии HP Sure Start Gen5 и HP \r\nSure Click гарантируют полную безопасность ПК на всех уровнях — от \r\nсистемы BIOS до браузера. </p><div _ngcontent-c7=\"\" class=\"hp-sub-title-lowercase feature-label\"><b><span style=\"font-size: 18px;\">Отличное качество звука</span></b></div><p _ngcontent-c7=\"\" class=\"hp-default-text feature-description\">\r\n Чистый и четкий звук во время телеконференций благодаря расширенным \r\nсредствам совместной работы, таким как система шумоподавления HP Noise \r\nCancellation. Громкие, направленные вверх динамики обеспечивают \r\nнасыщенное звучание. Направленный наружу микрофон и клавиши для \r\nсовместной работы позволят проводить виртуальные встречи более \r\nэффективно. </p>', 'russian', 1, 2, '["1570568968_NBKHNB4496528__1.jpg","1570568968_NBKHNB4496528__2.jpg","1570568968_NBKHNB4496528__3.jpg","1570568968_NBKHNB4496528__4.jpg","1570568968_NBKHNB4496528__5.jpg"]', '1570568968_NBKHNB4496528__1.jpg', '2019-10-09 00:09:28', NULL, '', '', '30000.00', 1, 1, 10, 1, '', NULL, 1, NULL, NULL, '1', '', 1, '1.48', NULL, 2, '23.43', '32.60', '2.50', NULL, 0, 0, NULL, 0, '[]', '[]');
