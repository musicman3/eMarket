/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* Создание таблиц */

DROP TABLE IF EXISTS emkt_administrators;
CREATE TABLE emkt_administrators (
	login varchar(128) binary NOT NULL,
	password varchar(256) NOT NULL,
	language varchar(64) NOT NULL,
	permission varchar(20) NOT NULL,
	note varchar(256),
	status int DEFAULT '0' NOT NULL,
PRIMARY KEY (login))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_basic_settings;
CREATE TABLE emkt_basic_settings (
	id int NOT NULL auto_increment,
	lines_on_page int DEFAULT '20' NOT NULL,
        session_expr_time int DEFAULT '60' NOT NULL,
        debug int DEFAULT '0' NOT NULL,
        host_email varchar(128) DEFAULT 'smtp.localhost' NOT NULL,
        username_email varchar(128) DEFAULT 'login' NOT NULL,
        password_email varchar(128) DEFAULT 'password' NOT NULL,
        smtp_secure varchar(64) DEFAULT 'tsl' NOT NULL,
        smtp_port int DEFAULT '587' NOT NULL,
        smtp_auth int DEFAULT '0' NOT NULL,
        smtp_status int DEFAULT '0' NOT NULL,
        email varchar(128) DEFAULT 'sale@localhost' NOT NULL,
        email_name varchar(128) DEFAULT 'eMarket' NOT NULL,
PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_categories;
CREATE TABLE emkt_categories (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
	parent_id int DEFAULT '0' NOT NULL,
        logo varchar(1024),
	date_added datetime,
	last_modified datetime,
	sort_category int DEFAULT '0' NOT NULL,
	status int,
        logo_general varchar(128),
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_countries;
CREATE TABLE emkt_countries (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        alpha_2 varchar(2),
        alpha_3 varchar(3),
        address_format varchar(256) NULL,
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

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
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_customers;
CREATE TABLE emkt_customers (
        id int NOT NULL auto_increment,
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
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_customers_activation;
CREATE TABLE emkt_customers_activation (
        id int NOT NULL,
        activation_code varchar(64),
PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_length;
CREATE TABLE emkt_length (
	id int NOT NULL,
	name varchar(64),
        code varchar(8),
	language varchar(64),
        value_length decimal(14,7),
        default_length int NOT NULL,
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_manufacturers;
CREATE TABLE emkt_manufacturers (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        logo varchar(1024),
        logo_general varchar(128),
        site varchar(256),
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_products;
CREATE TABLE emkt_products (
	id int DEFAULT '0' NOT NULL,
        name varchar(256),
        description text,
        language varchar(64),
        status int DEFAULT '1' NOT NULL,
	parent_id int DEFAULT '0' NOT NULL,
	logo varchar(1024),
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
        lenght decimal(12,2),
        width decimal(12,2),
        height decimal(12,2),
        type int,
        ordered int default '0',
        viewed int default '0',
        download_file varchar(256),
        downloads_stat int default '0',
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_regions;
CREATE TABLE emkt_regions (
	id int NOT NULL,
        country_id int NOT NULL,
        region_code varchar(8),
	name varchar(256),
	language varchar(64),
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_taxes;
CREATE TABLE emkt_taxes (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        rate decimal(4,2),
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_template_constructor;
CREATE TABLE emkt_template_constructor (
        id int NOT NULL auto_increment,
	url varchar(256),
        group_id varchar(32),
        value varchar(32),
        page varchar(256),
        template_name varchar(256),
        sort int NOT NULL,
	PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_units;
CREATE TABLE emkt_units (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        unit varchar(256),
        default_unit int NOT NULL,
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_vendor_codes;
CREATE TABLE emkt_vendor_codes (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        vendor_code varchar(256),
        default_vendor_code int NOT NULL,
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_weight;
CREATE TABLE emkt_weight (
	id int NOT NULL,
	name varchar(64),
        code varchar(8),
	language varchar(64),
        value_weight decimal(14,7),
        default_weight int NOT NULL,
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_zones;
CREATE TABLE emkt_zones (
	id int NOT NULL,
	name varchar(256),
        note varchar(256),
	language varchar(64),
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_zones_value;
CREATE TABLE emkt_zones_value (
	id int NOT NULL auto_increment,
        country_id int NOT NULL,
        regions_id int NOT NULL,
        zones_id int NOT NULL,
	PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


/* Загрузка первоначальных данных в таблицу стран */
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
INSERT INTO emkt_regions VALUES(449, 25, '32', 'Trongsa', 'Russian');
INSERT INTO emkt_regions VALUES(450, 25, '33', 'Bumthang', 'Russian');
INSERT INTO emkt_regions VALUES(451, 25, '34', 'Zhemgang', 'Russian');
INSERT INTO emkt_regions VALUES(452, 25, '41', 'Trashigang', 'Russian');
INSERT INTO emkt_regions VALUES(453, 25, '42', 'Mongar', 'Russian');
INSERT INTO emkt_regions VALUES(454, 25, '43', 'Pemagatshel', 'Russian');
INSERT INTO emkt_regions VALUES(455, 25, '44', 'Luentse', 'Russian');
INSERT INTO emkt_regions VALUES(456, 25, '45', 'Samdrup Jongkhar', 'Russian');
INSERT INTO emkt_regions VALUES(457, 25, 'GA', 'Gasa', 'Russian');
INSERT INTO emkt_regions VALUES(458, 25, 'TY', 'Trashiyangse', 'Russian');

INSERT INTO emkt_countries VALUES (26,'Боливия','Russian','BO','BOL','');

INSERT INTO emkt_regions VALUES(459, 26, 'B', 'El Beni', 'Russian');
INSERT INTO emkt_regions VALUES(460, 26, 'C', 'Cochabamba', 'Russian');
INSERT INTO emkt_regions VALUES(461, 26, 'H', 'Chuquisaca', 'Russian');
INSERT INTO emkt_regions VALUES(462, 26, 'L', 'La Paz', 'Russian');
INSERT INTO emkt_regions VALUES(463, 26, 'N', 'Pando', 'Russian');
INSERT INTO emkt_regions VALUES(464, 26, 'O', 'Oruro', 'Russian');
INSERT INTO emkt_regions VALUES(465, 26, 'P', 'Potosí', 'Russian');
INSERT INTO emkt_regions VALUES(466, 26, 'S', 'Santa Cruz', 'Russian');
INSERT INTO emkt_regions VALUES(467, 26, 'T', 'Tarija', 'Russian');

INSERT INTO emkt_countries VALUES (27,'Босния и Герцеговина','Russian','BA','BIH','');

INSERT INTO emkt_regions VALUES(4253, 27, 'NOCODE', 'Bosnia and Herzegowina', 'Russian');

INSERT INTO emkt_countries VALUES (28,'Ботсвана','Russian','BW','BWA','');

INSERT INTO emkt_regions VALUES(468, 28, 'CE', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(469, 28, 'GH', 'Ghanzi', 'Russian');
INSERT INTO emkt_regions VALUES(470, 28, 'KG', 'Kgalagadi', 'Russian');
INSERT INTO emkt_regions VALUES(471, 28, 'KL', 'Kgatleng', 'Russian');
INSERT INTO emkt_regions VALUES(472, 28, 'KW', 'Kweneng', 'Russian');
INSERT INTO emkt_regions VALUES(473, 28, 'NE', 'North-East', 'Russian');
INSERT INTO emkt_regions VALUES(474, 28, 'NW', 'North-West', 'Russian');
INSERT INTO emkt_regions VALUES(475, 28, 'SE', 'South-East', 'Russian');
INSERT INTO emkt_regions VALUES(476, 28, 'SO', 'Southern', 'Russian');

INSERT INTO emkt_countries VALUES (29,'Остров Буве','Russian','BV','BVT','');

INSERT INTO emkt_regions VALUES(4254, 29, 'NOCODE', 'Bouvet Island', 'Russian');

INSERT INTO emkt_countries VALUES (30,'Бразилия','Russian','BR','BRA','');

INSERT INTO emkt_regions VALUES(477, 30, 'AC', 'Acre', 'Russian');
INSERT INTO emkt_regions VALUES(478, 30, 'AL', 'Alagoas', 'Russian');
INSERT INTO emkt_regions VALUES(479, 30, 'AM', 'Amazônia', 'Russian');
INSERT INTO emkt_regions VALUES(480, 30, 'AP', 'Amapá', 'Russian');
INSERT INTO emkt_regions VALUES(481, 30, 'BA', 'Bahia', 'Russian');
INSERT INTO emkt_regions VALUES(482, 30, 'CE', 'Ceará', 'Russian');
INSERT INTO emkt_regions VALUES(483, 30, 'DF', 'Distrito Federal', 'Russian');
INSERT INTO emkt_regions VALUES(484, 30, 'ES', 'Espírito Santo', 'Russian');
INSERT INTO emkt_regions VALUES(485, 30, 'GO', 'Goiás', 'Russian');
INSERT INTO emkt_regions VALUES(486, 30, 'MA', 'Maranhão', 'Russian');
INSERT INTO emkt_regions VALUES(487, 30, 'MG', 'Minas Gerais', 'Russian');
INSERT INTO emkt_regions VALUES(488, 30, 'MS', 'Mato Grosso do Sul', 'Russian');
INSERT INTO emkt_regions VALUES(489, 30, 'MT', 'Mato Grosso', 'Russian');
INSERT INTO emkt_regions VALUES(490, 30, 'PA', 'Pará', 'Russian');
INSERT INTO emkt_regions VALUES(491, 30, 'PB', 'Paraíba', 'Russian');
INSERT INTO emkt_regions VALUES(492, 30, 'PE', 'Pernambuco', 'Russian');
INSERT INTO emkt_regions VALUES(493, 30, 'PI', 'Piauí', 'Russian');
INSERT INTO emkt_regions VALUES(494, 30, 'PR', 'Paraná', 'Russian');
INSERT INTO emkt_regions VALUES(495, 30, 'RJ', 'Rio de Janeiro', 'Russian');
INSERT INTO emkt_regions VALUES(496, 30, 'RN', 'Rio Grande do Norte', 'Russian');
INSERT INTO emkt_regions VALUES(497, 30, 'RO', 'Rondônia', 'Russian');
INSERT INTO emkt_regions VALUES(498, 30, 'RR', 'Roraima', 'Russian');
INSERT INTO emkt_regions VALUES(499, 30, 'RS', 'Rio Grande do Sul', 'Russian');
INSERT INTO emkt_regions VALUES(500, 30, 'SC', 'Santa Catarina', 'Russian');
INSERT INTO emkt_regions VALUES(501, 30, 'SE', 'Sergipe', 'Russian');
INSERT INTO emkt_regions VALUES(502, 30, 'SP', 'São Paulo', 'Russian');
INSERT INTO emkt_regions VALUES(503, 30, 'TO', 'Tocantins', 'Russian');

INSERT INTO emkt_countries VALUES (31,'Британская Территория в Индийском Океане','Russian','IO','IOT','');

INSERT INTO emkt_regions VALUES(504, 31, 'PB', 'Peros Banhos', 'Russian');
INSERT INTO emkt_regions VALUES(505, 31, 'SI', 'Salomon Islands', 'Russian');
INSERT INTO emkt_regions VALUES(506, 31, 'NI', 'Nelsons Island', 'Russian');
INSERT INTO emkt_regions VALUES(507, 31, 'TB', 'Three Brothers', 'Russian');
INSERT INTO emkt_regions VALUES(508, 31, 'EA', 'Eagle Islands', 'Russian');
INSERT INTO emkt_regions VALUES(509, 31, 'DI', 'Danger Island', 'Russian');
INSERT INTO emkt_regions VALUES(510, 31, 'EG', 'Egmont Islands', 'Russian');
INSERT INTO emkt_regions VALUES(511, 31, 'DG', 'Diego Garcia', 'Russian');

INSERT INTO emkt_countries VALUES (32,'Бруней','Russian','BN','BRN','');

INSERT INTO emkt_regions VALUES(512, 32, 'BE', 'Belait', 'Russian');
INSERT INTO emkt_regions VALUES(513, 32, 'BM', 'Brunei-Muara', 'Russian');
INSERT INTO emkt_regions VALUES(514, 32, 'TE', 'Temburong', 'Russian');
INSERT INTO emkt_regions VALUES(515, 32, 'TU', 'Tutong', 'Russian');

INSERT INTO emkt_countries VALUES (33,'Болгария','Russian','BG','BGR','');

INSERT INTO emkt_regions VALUES(516, 33, '01', 'Blagoevgrad', 'Russian');
INSERT INTO emkt_regions VALUES(517, 33, '02', 'Burgas', 'Russian');
INSERT INTO emkt_regions VALUES(518, 33, '03', 'Varna', 'Russian');
INSERT INTO emkt_regions VALUES(519, 33, '04', 'Veliko Tarnovo', 'Russian');
INSERT INTO emkt_regions VALUES(520, 33, '05', 'Vidin', 'Russian');
INSERT INTO emkt_regions VALUES(521, 33, '06', 'Vratsa', 'Russian');
INSERT INTO emkt_regions VALUES(522, 33, '07', 'Gabrovo', 'Russian');
INSERT INTO emkt_regions VALUES(523, 33, '08', 'Dobrich', 'Russian');
INSERT INTO emkt_regions VALUES(524, 33, '09', 'Kardzhali', 'Russian');
INSERT INTO emkt_regions VALUES(525, 33, '10', 'Kyustendil', 'Russian');
INSERT INTO emkt_regions VALUES(526, 33, '11', 'Lovech', 'Russian');
INSERT INTO emkt_regions VALUES(527, 33, '12', 'Montana', 'Russian');
INSERT INTO emkt_regions VALUES(528, 33, '13', 'Pazardzhik', 'Russian');
INSERT INTO emkt_regions VALUES(529, 33, '14', 'Pernik', 'Russian');
INSERT INTO emkt_regions VALUES(530, 33, '15', 'Pleven', 'Russian');
INSERT INTO emkt_regions VALUES(531, 33, '16', 'Plovdiv', 'Russian');
INSERT INTO emkt_regions VALUES(532, 33, '17', 'Razgrad', 'Russian');
INSERT INTO emkt_regions VALUES(533, 33, '18', 'Ruse', 'Russian');
INSERT INTO emkt_regions VALUES(534, 33, '19', 'Silistra', 'Russian');
INSERT INTO emkt_regions VALUES(535, 33, '20', 'Sliven', 'Russian');
INSERT INTO emkt_regions VALUES(536, 33, '21', 'Smolyan', 'Russian');
INSERT INTO emkt_regions VALUES(537, 33, '23', 'Sofia', 'Russian');
INSERT INTO emkt_regions VALUES(538, 33, '22', 'Sofia Province', 'Russian');
INSERT INTO emkt_regions VALUES(539, 33, '24', 'Stara Zagora', 'Russian');
INSERT INTO emkt_regions VALUES(540, 33, '25', 'Targovishte', 'Russian');
INSERT INTO emkt_regions VALUES(541, 33, '26', 'Haskovo', 'Russian');
INSERT INTO emkt_regions VALUES(542, 33, '27', 'Shumen', 'Russian');
INSERT INTO emkt_regions VALUES(543, 33, '28', 'Yambol', 'Russian');

INSERT INTO emkt_countries VALUES (34,'Буркина-Фасо','Russian','BF','BFA','');

INSERT INTO emkt_regions VALUES(544, 34, 'BAL', 'Balé', 'Russian');
INSERT INTO emkt_regions VALUES(545, 34, 'BAM', 'Bam', 'Russian');
INSERT INTO emkt_regions VALUES(546, 34, 'BAN', 'Banwa', 'Russian');
INSERT INTO emkt_regions VALUES(547, 34, 'BAZ', 'Bazèga', 'Russian');
INSERT INTO emkt_regions VALUES(548, 34, 'BGR', 'Bougouriba', 'Russian');
INSERT INTO emkt_regions VALUES(549, 34, 'BLG', 'Boulgou', 'Russian');
INSERT INTO emkt_regions VALUES(550, 34, 'BLK', 'Boulkiemdé', 'Russian');
INSERT INTO emkt_regions VALUES(551, 34, 'COM', 'Komoé', 'Russian');
INSERT INTO emkt_regions VALUES(552, 34, 'GAN', 'Ganzourgou', 'Russian');
INSERT INTO emkt_regions VALUES(553, 34, 'GNA', 'Gnagna', 'Russian');
INSERT INTO emkt_regions VALUES(554, 34, 'GOU', 'Gourma', 'Russian');
INSERT INTO emkt_regions VALUES(555, 34, 'HOU', 'Houet', 'Russian');
INSERT INTO emkt_regions VALUES(556, 34, 'IOB', 'Ioba', 'Russian');
INSERT INTO emkt_regions VALUES(557, 34, 'KAD', 'Kadiogo', 'Russian');
INSERT INTO emkt_regions VALUES(558, 34, 'KEN', 'Kénédougou', 'Russian');
INSERT INTO emkt_regions VALUES(559, 34, 'KMD', 'Komondjari', 'Russian');
INSERT INTO emkt_regions VALUES(560, 34, 'KMP', 'Kompienga', 'Russian');
INSERT INTO emkt_regions VALUES(561, 34, 'KOP', 'Koulpélogo', 'Russian');
INSERT INTO emkt_regions VALUES(562, 34, 'KOS', 'Kossi', 'Russian');
INSERT INTO emkt_regions VALUES(563, 34, 'KOT', 'Kouritenga', 'Russian');
INSERT INTO emkt_regions VALUES(564, 34, 'KOW', 'Kourwéogo', 'Russian');
INSERT INTO emkt_regions VALUES(565, 34, 'LER', 'Léraba', 'Russian');
INSERT INTO emkt_regions VALUES(566, 34, 'LOR', 'Loroum', 'Russian');
INSERT INTO emkt_regions VALUES(567, 34, 'MOU', 'Mouhoun', 'Russian');
INSERT INTO emkt_regions VALUES(568, 34, 'NAM', 'Namentenga', 'Russian');
INSERT INTO emkt_regions VALUES(569, 34, 'NAO', 'Naouri', 'Russian');
INSERT INTO emkt_regions VALUES(570, 34, 'NAY', 'Nayala', 'Russian');
INSERT INTO emkt_regions VALUES(571, 34, 'NOU', 'Noumbiel', 'Russian');
INSERT INTO emkt_regions VALUES(572, 34, 'OUB', 'Oubritenga', 'Russian');
INSERT INTO emkt_regions VALUES(573, 34, 'OUD', 'Oudalan', 'Russian');
INSERT INTO emkt_regions VALUES(574, 34, 'PAS', 'Passoré', 'Russian');
INSERT INTO emkt_regions VALUES(575, 34, 'PON', 'Poni', 'Russian');
INSERT INTO emkt_regions VALUES(576, 34, 'SEN', 'Séno', 'Russian');
INSERT INTO emkt_regions VALUES(577, 34, 'SIS', 'Sissili', 'Russian');
INSERT INTO emkt_regions VALUES(578, 34, 'SMT', 'Sanmatenga', 'Russian');
INSERT INTO emkt_regions VALUES(579, 34, 'SNG', 'Sanguié', 'Russian');
INSERT INTO emkt_regions VALUES(580, 34, 'SOM', 'Soum', 'Russian');
INSERT INTO emkt_regions VALUES(581, 34, 'SOR', 'Sourou', 'Russian');
INSERT INTO emkt_regions VALUES(582, 34, 'TAP', 'Tapoa', 'Russian');
INSERT INTO emkt_regions VALUES(583, 34, 'TUI', 'Tui', 'Russian');
INSERT INTO emkt_regions VALUES(584, 34, 'YAG', 'Yagha', 'Russian');
INSERT INTO emkt_regions VALUES(585, 34, 'YAT', 'Yatenga', 'Russian');
INSERT INTO emkt_regions VALUES(586, 34, 'ZIR', 'Ziro', 'Russian');
INSERT INTO emkt_regions VALUES(587, 34, 'ZON', 'Zondoma', 'Russian');
INSERT INTO emkt_regions VALUES(588, 34, 'ZOU', 'Zoundwéogo', 'Russian');

INSERT INTO emkt_countries VALUES (35,'Бурунди','Russian','BI','BDI','');

INSERT INTO emkt_regions VALUES(589, 35, 'BB', 'Bubanza', 'Russian');
INSERT INTO emkt_regions VALUES(590, 35, 'BJ', 'Bujumbura Mairie', 'Russian');
INSERT INTO emkt_regions VALUES(591, 35, 'BR', 'Bururi', 'Russian');
INSERT INTO emkt_regions VALUES(592, 35, 'CA', 'Cankuzo', 'Russian');
INSERT INTO emkt_regions VALUES(593, 35, 'CI', 'Cibitoke', 'Russian');
INSERT INTO emkt_regions VALUES(594, 35, 'GI', 'Gitega', 'Russian');
INSERT INTO emkt_regions VALUES(595, 35, 'KR', 'Karuzi', 'Russian');
INSERT INTO emkt_regions VALUES(596, 35, 'KY', 'Kayanza', 'Russian');
INSERT INTO emkt_regions VALUES(597, 35, 'KI', 'Kirundo', 'Russian');
INSERT INTO emkt_regions VALUES(598, 35, 'MA', 'Makamba', 'Russian');
INSERT INTO emkt_regions VALUES(599, 35, 'MU', 'Muramvya', 'Russian');
INSERT INTO emkt_regions VALUES(600, 35, 'MY', 'Muyinga', 'Russian');
INSERT INTO emkt_regions VALUES(601, 35, 'MW', 'Mwaro', 'Russian');
INSERT INTO emkt_regions VALUES(602, 35, 'NG', 'Ngozi', 'Russian');
INSERT INTO emkt_regions VALUES(603, 35, 'RT', 'Rutana', 'Russian');
INSERT INTO emkt_regions VALUES(604, 35, 'RY', 'Ruyigi', 'Russian');

INSERT INTO emkt_countries VALUES (36,'Камбоджа','Russian','KH','KHM','');

INSERT INTO emkt_regions VALUES(4255, 36, 'NOCODE', 'Cambodia', 'Russian');

INSERT INTO emkt_countries VALUES (37,'Камерун','Russian','CM','CMR','');

INSERT INTO emkt_regions VALUES(605, 37, 'AD', 'Adamaoua', 'Russian');
INSERT INTO emkt_regions VALUES(606, 37, 'CE', 'Centre', 'Russian');
INSERT INTO emkt_regions VALUES(607, 37, 'EN', 'Extrême-Nord', 'Russian');
INSERT INTO emkt_regions VALUES(608, 37, 'ES', 'Est', 'Russian');
INSERT INTO emkt_regions VALUES(609, 37, 'LT', 'Littoral', 'Russian');
INSERT INTO emkt_regions VALUES(610, 37, 'NO', 'Nord', 'Russian');
INSERT INTO emkt_regions VALUES(611, 37, 'NW', 'Nord-Ouest', 'Russian');
INSERT INTO emkt_regions VALUES(612, 37, 'OU', 'Ouest', 'Russian');
INSERT INTO emkt_regions VALUES(613, 37, 'SU', 'Sud', 'Russian');
INSERT INTO emkt_regions VALUES(614, 37, 'SW', 'Sud-Ouest', 'Russian');

INSERT INTO emkt_countries VALUES (38,'Канада','Russian','CA','CAN','');

INSERT INTO emkt_regions VALUES(615, 38, 'AB', 'Alberta', 'Russian');
INSERT INTO emkt_regions VALUES(616, 38, 'BC', 'British Columbia', 'Russian');
INSERT INTO emkt_regions VALUES(617, 38, 'MB', 'Manitoba', 'Russian');
INSERT INTO emkt_regions VALUES(618, 38, 'NB', 'New Brunswick', 'Russian');
INSERT INTO emkt_regions VALUES(619, 38, 'NL', 'Newfoundland and Labrador', 'Russian');
INSERT INTO emkt_regions VALUES(620, 38, 'NS', 'Nova Scotia', 'Russian');
INSERT INTO emkt_regions VALUES(621, 38, 'NT', 'Northwest Territories', 'Russian');
INSERT INTO emkt_regions VALUES(622, 38, 'NU', 'Nunavut', 'Russian');
INSERT INTO emkt_regions VALUES(623, 38, 'ON', 'Ontario', 'Russian');
INSERT INTO emkt_regions VALUES(624, 38, 'PE', 'Prince Edward Island', 'Russian');
INSERT INTO emkt_regions VALUES(625, 38, 'QC', 'Quebec', 'Russian');
INSERT INTO emkt_regions VALUES(626, 38, 'SK', 'Saskatchewan', 'Russian');
INSERT INTO emkt_regions VALUES(627, 38, 'YT', 'Yukon Territory', 'Russian');

INSERT INTO emkt_countries VALUES (39,'Кабо-Верде','Russian','CV','CPV','');

INSERT INTO emkt_regions VALUES(628, 39, 'BR', 'Brava', 'Russian');
INSERT INTO emkt_regions VALUES(629, 39, 'BV', 'Boa Vista', 'Russian');
INSERT INTO emkt_regions VALUES(630, 39, 'CA', 'Santa Catarina', 'Russian');
INSERT INTO emkt_regions VALUES(631, 39, 'CR', 'Santa Cruz', 'Russian');
INSERT INTO emkt_regions VALUES(632, 39, 'CS', 'Calheta de São Miguel', 'Russian');
INSERT INTO emkt_regions VALUES(633, 39, 'MA', 'Maio', 'Russian');
INSERT INTO emkt_regions VALUES(634, 39, 'MO', 'Mosteiros', 'Russian');
INSERT INTO emkt_regions VALUES(635, 39, 'PA', 'Paúl', 'Russian');
INSERT INTO emkt_regions VALUES(636, 39, 'PN', 'Porto Novo', 'Russian');
INSERT INTO emkt_regions VALUES(637, 39, 'PR', 'Praia', 'Russian');
INSERT INTO emkt_regions VALUES(638, 39, 'RG', 'Ribeira Grande', 'Russian');
INSERT INTO emkt_regions VALUES(639, 39, 'SD', 'São Domingos', 'Russian');
INSERT INTO emkt_regions VALUES(640, 39, 'SF', 'São Filipe', 'Russian');
INSERT INTO emkt_regions VALUES(641, 39, 'SL', 'Sal', 'Russian');
INSERT INTO emkt_regions VALUES(642, 39, 'SN', 'São Nicolau', 'Russian');
INSERT INTO emkt_regions VALUES(643, 39, 'SV', 'São Vicente', 'Russian');
INSERT INTO emkt_regions VALUES(644, 39, 'TA', 'Tarrafal', 'Russian');

INSERT INTO emkt_countries VALUES (40,'Острова Кайман','Russian','KY','CYM','');

INSERT INTO emkt_regions VALUES(645, 40, 'CR', 'Creek', 'Russian');
INSERT INTO emkt_regions VALUES(646, 40, 'EA', 'Eastern', 'Russian');
INSERT INTO emkt_regions VALUES(647, 40, 'MI', 'Midland', 'Russian');
INSERT INTO emkt_regions VALUES(648, 40, 'SO', 'South Town', 'Russian');
INSERT INTO emkt_regions VALUES(649, 40, 'SP', 'Spot Bay', 'Russian');
INSERT INTO emkt_regions VALUES(650, 40, 'ST', 'Stake Bay', 'Russian');
INSERT INTO emkt_regions VALUES(651, 40, 'WD', 'West End', 'Russian');
INSERT INTO emkt_regions VALUES(652, 40, 'WN', 'Western', 'Russian');

INSERT INTO emkt_countries VALUES (41,'Центральноафриканская Республика','Russian','CF','CAF','');

INSERT INTO emkt_regions VALUES(653, 41, 'AC ', 'Ouham', 'Russian');
INSERT INTO emkt_regions VALUES(654, 41, 'BB ', 'Bamingui-Bangoran', 'Russian');
INSERT INTO emkt_regions VALUES(655, 41, 'BGF', 'Bangui', 'Russian');
INSERT INTO emkt_regions VALUES(656, 41, 'BK ', 'Basse-Kotto', 'Russian');
INSERT INTO emkt_regions VALUES(657, 41, 'HK ', 'Haute-Kotto', 'Russian');
INSERT INTO emkt_regions VALUES(658, 41, 'HM ', 'Haut-Mbomou', 'Russian');
INSERT INTO emkt_regions VALUES(659, 41, 'HS ', 'Mambéré-Kadéï', 'Russian');
INSERT INTO emkt_regions VALUES(660, 41, 'KB ', 'Nana-Grébizi', 'Russian');
INSERT INTO emkt_regions VALUES(661, 41, 'KG ', 'Kémo', 'Russian');
INSERT INTO emkt_regions VALUES(662, 41, 'LB ', 'Lobaye', 'Russian');
INSERT INTO emkt_regions VALUES(663, 41, 'MB ', 'Mbomou', 'Russian');
INSERT INTO emkt_regions VALUES(664, 41, 'MP ', 'Ombella-M\'Poko', 'Russian');
INSERT INTO emkt_regions VALUES(665, 41, 'NM ', 'Nana-Mambéré', 'Russian');
INSERT INTO emkt_regions VALUES(666, 41, 'OP ', 'Ouham-Pendé', 'Russian');
INSERT INTO emkt_regions VALUES(667, 41, 'SE ', 'Sangha-Mbaéré', 'Russian');
INSERT INTO emkt_regions VALUES(668, 41, 'UK ', 'Ouaka', 'Russian');
INSERT INTO emkt_regions VALUES(669, 41, 'VR ', 'Vakaga', 'Russian');

INSERT INTO emkt_countries VALUES (42,'Чад','Russian','TD','TCD','');

INSERT INTO emkt_regions VALUES(670, 42, 'BA ', 'Batha', 'Russian');
INSERT INTO emkt_regions VALUES(671, 42, 'BET', 'Borkou-Ennedi-Tibesti', 'Russian');
INSERT INTO emkt_regions VALUES(672, 42, 'BI ', 'Biltine', 'Russian');
INSERT INTO emkt_regions VALUES(673, 42, 'CB ', 'Chari-Baguirmi', 'Russian');
INSERT INTO emkt_regions VALUES(674, 42, 'GR ', 'Guéra', 'Russian');
INSERT INTO emkt_regions VALUES(675, 42, 'KA ', 'Kanem', 'Russian');
INSERT INTO emkt_regions VALUES(676, 42, 'LC ', 'Lac', 'Russian');
INSERT INTO emkt_regions VALUES(677, 42, 'LR ', 'Logone-Oriental', 'Russian');
INSERT INTO emkt_regions VALUES(678, 42, 'LO ', 'Logone-Occidental', 'Russian');
INSERT INTO emkt_regions VALUES(679, 42, 'MC ', 'Moyen-Chari', 'Russian');
INSERT INTO emkt_regions VALUES(680, 42, 'MK ', 'Mayo-Kébbi', 'Russian');
INSERT INTO emkt_regions VALUES(681, 42, 'OD ', 'Ouaddaï', 'Russian');
INSERT INTO emkt_regions VALUES(682, 42, 'SA ', 'Salamat', 'Russian');
INSERT INTO emkt_regions VALUES(683, 42, 'TA ', 'Tandjilé', 'Russian');

INSERT INTO emkt_countries VALUES (43,'Чили','Russian','CL','CHL','');

INSERT INTO emkt_regions VALUES(684, 43, 'AI', 'Aisén del General Carlos Ibañez', 'Russian');
INSERT INTO emkt_regions VALUES(685, 43, 'AN', 'Antofagasta', 'Russian');
INSERT INTO emkt_regions VALUES(686, 43, 'AR', 'La Araucanía', 'Russian');
INSERT INTO emkt_regions VALUES(687, 43, 'AT', 'Atacama', 'Russian');
INSERT INTO emkt_regions VALUES(688, 43, 'BI', 'Biobío', 'Russian');
INSERT INTO emkt_regions VALUES(689, 43, 'CO', 'Coquimbo', 'Russian');
INSERT INTO emkt_regions VALUES(690, 43, 'LI', 'Libertador Bernardo O\'Higgins', 'Russian');
INSERT INTO emkt_regions VALUES(691, 43, 'LL', 'Los Lagos', 'Russian');
INSERT INTO emkt_regions VALUES(692, 43, 'MA', 'Magallanes y de la Antartica', 'Russian');
INSERT INTO emkt_regions VALUES(693, 43, 'ML', 'Maule', 'Russian');
INSERT INTO emkt_regions VALUES(694, 43, 'RM', 'Metropolitana de Santiago', 'Russian');
INSERT INTO emkt_regions VALUES(695, 43, 'TA', 'Tarapacá', 'Russian');
INSERT INTO emkt_regions VALUES(696, 43, 'VS', 'Valparaíso', 'Russian');

INSERT INTO emkt_countries VALUES (44,'Китайская Народная Республика','Russian','CN','CHN','');

INSERT INTO emkt_regions VALUES(697, 44, '11', '北京', 'Russian');
INSERT INTO emkt_regions VALUES(698, 44, '12', '天津', 'Russian');
INSERT INTO emkt_regions VALUES(699, 44, '13', '河北', 'Russian');
INSERT INTO emkt_regions VALUES(700, 44, '14', '山西', 'Russian');
INSERT INTO emkt_regions VALUES(701, 44, '15', '内蒙古自治区', 'Russian');
INSERT INTO emkt_regions VALUES(702, 44, '21', '辽宁', 'Russian');
INSERT INTO emkt_regions VALUES(703, 44, '22', '吉林', 'Russian');
INSERT INTO emkt_regions VALUES(704, 44, '23', '黑龙江省', 'Russian');
INSERT INTO emkt_regions VALUES(705, 44, '31', '上海', 'Russian');
INSERT INTO emkt_regions VALUES(706, 44, '32', '江苏', 'Russian');
INSERT INTO emkt_regions VALUES(707, 44, '33', '浙江', 'Russian');
INSERT INTO emkt_regions VALUES(708, 44, '34', '安徽', 'Russian');
INSERT INTO emkt_regions VALUES(709, 44, '35', '福建', 'Russian');
INSERT INTO emkt_regions VALUES(710, 44, '36', '江西', 'Russian');
INSERT INTO emkt_regions VALUES(711, 44, '37', '山东', 'Russian');
INSERT INTO emkt_regions VALUES(712, 44, '41', '河南', 'Russian');
INSERT INTO emkt_regions VALUES(713, 44, '42', '湖北', 'Russian');
INSERT INTO emkt_regions VALUES(714, 44, '43', '湖南', 'Russian');
INSERT INTO emkt_regions VALUES(715, 44, '44', '广东', 'Russian');
INSERT INTO emkt_regions VALUES(716, 44, '45', '广西壮族自治区', 'Russian');
INSERT INTO emkt_regions VALUES(717, 44, '46', '海南', 'Russian');
INSERT INTO emkt_regions VALUES(718, 44, '50', '重庆', 'Russian');
INSERT INTO emkt_regions VALUES(719, 44, '51', '四川', 'Russian');
INSERT INTO emkt_regions VALUES(720, 44, '52', '贵州', 'Russian');
INSERT INTO emkt_regions VALUES(721, 44, '53', '云南', 'Russian');
INSERT INTO emkt_regions VALUES(722, 44, '54', '西藏自治区', 'Russian');
INSERT INTO emkt_regions VALUES(723, 44, '61', '陕西', 'Russian');
INSERT INTO emkt_regions VALUES(724, 44, '62', '甘肃', 'Russian');
INSERT INTO emkt_regions VALUES(725, 44, '63', '青海', 'Russian');
INSERT INTO emkt_regions VALUES(726, 44, '64', '宁夏', 'Russian');
INSERT INTO emkt_regions VALUES(727, 44, '65', '新疆', 'Russian');
INSERT INTO emkt_regions VALUES(728, 44, '71', '臺灣', 'Russian');
INSERT INTO emkt_regions VALUES(729, 44, '91', '香港', 'Russian');
INSERT INTO emkt_regions VALUES(730, 44, '92', '澳門', 'Russian');

INSERT INTO emkt_countries VALUES (45,'Остров Рождества','Russian','CX','CXR','');

INSERT INTO emkt_regions VALUES(4256, 45, 'NOCODE', 'Christmas Island', 'Russian');

INSERT INTO emkt_countries VALUES (46,'Кокосовые острова','Russian','CC','CCK','');

INSERT INTO emkt_regions VALUES(731, 46, 'D', 'Direction Island', 'Russian');
INSERT INTO emkt_regions VALUES(732, 46, 'H', 'Home Island', 'Russian');
INSERT INTO emkt_regions VALUES(733, 46, 'O', 'Horsburgh Island', 'Russian');
INSERT INTO emkt_regions VALUES(734, 46, 'S', 'South Island', 'Russian');
INSERT INTO emkt_regions VALUES(735, 46, 'W', 'West Island', 'Russian');

INSERT INTO emkt_countries VALUES (47,'Колумбия','Russian','CO','COL','');

INSERT INTO emkt_regions VALUES(736, 47, 'AMA', 'Amazonas', 'Russian');
INSERT INTO emkt_regions VALUES(737, 47, 'ANT', 'Antioquia', 'Russian');
INSERT INTO emkt_regions VALUES(738, 47, 'ARA', 'Arauca', 'Russian');
INSERT INTO emkt_regions VALUES(739, 47, 'ATL', 'Atlántico', 'Russian');
INSERT INTO emkt_regions VALUES(740, 47, 'BOL', 'Bolívar', 'Russian');
INSERT INTO emkt_regions VALUES(741, 47, 'BOY', 'Boyacá', 'Russian');
INSERT INTO emkt_regions VALUES(742, 47, 'CAL', 'Caldas', 'Russian');
INSERT INTO emkt_regions VALUES(743, 47, 'CAQ', 'Caquetá', 'Russian');
INSERT INTO emkt_regions VALUES(744, 47, 'CAS', 'Casanare', 'Russian');
INSERT INTO emkt_regions VALUES(745, 47, 'CAU', 'Cauca', 'Russian');
INSERT INTO emkt_regions VALUES(746, 47, 'CES', 'Cesar', 'Russian');
INSERT INTO emkt_regions VALUES(747, 47, 'CHO', 'Chocó', 'Russian');
INSERT INTO emkt_regions VALUES(748, 47, 'COR', 'Córdoba', 'Russian');
INSERT INTO emkt_regions VALUES(749, 47, 'CUN', 'Cundinamarca', 'Russian');
INSERT INTO emkt_regions VALUES(750, 47, 'DC', 'Bogotá Distrito Capital', 'Russian');
INSERT INTO emkt_regions VALUES(751, 47, 'GUA', 'Guainía', 'Russian');
INSERT INTO emkt_regions VALUES(752, 47, 'GUV', 'Guaviare', 'Russian');
INSERT INTO emkt_regions VALUES(753, 47, 'HUI', 'Huila', 'Russian');
INSERT INTO emkt_regions VALUES(754, 47, 'LAG', 'La Guajira', 'Russian');
INSERT INTO emkt_regions VALUES(755, 47, 'MAG', 'Magdalena', 'Russian');
INSERT INTO emkt_regions VALUES(756, 47, 'MET', 'Meta', 'Russian');
INSERT INTO emkt_regions VALUES(757, 47, 'NAR', 'Nariño', 'Russian');
INSERT INTO emkt_regions VALUES(758, 47, 'NSA', 'Norte de Santander', 'Russian');
INSERT INTO emkt_regions VALUES(759, 47, 'PUT', 'Putumayo', 'Russian');
INSERT INTO emkt_regions VALUES(760, 47, 'QUI', 'Quindío', 'Russian');
INSERT INTO emkt_regions VALUES(761, 47, 'RIS', 'Risaralda', 'Russian');
INSERT INTO emkt_regions VALUES(762, 47, 'SAN', 'Santander', 'Russian');
INSERT INTO emkt_regions VALUES(763, 47, 'SAP', 'San Andrés y Providencia', 'Russian');
INSERT INTO emkt_regions VALUES(764, 47, 'SUC', 'Sucre', 'Russian');
INSERT INTO emkt_regions VALUES(765, 47, 'TOL', 'Tolima', 'Russian');
INSERT INTO emkt_regions VALUES(766, 47, 'VAC', 'Valle del Cauca', 'Russian');
INSERT INTO emkt_regions VALUES(767, 47, 'VAU', 'Vaupés', 'Russian');
INSERT INTO emkt_regions VALUES(768, 47, 'VID', 'Vichada', 'Russian');

INSERT INTO emkt_countries VALUES (48,'Коморы','Russian','KM','COM','');

INSERT INTO emkt_regions VALUES(769, 48, 'A', 'Anjouan', 'Russian');
INSERT INTO emkt_regions VALUES(770, 48, 'G', 'Grande Comore', 'Russian');
INSERT INTO emkt_regions VALUES(771, 48, 'M', 'Mohéli', 'Russian');

INSERT INTO emkt_countries VALUES (49,'Конго','Russian','CG','COG','');

INSERT INTO emkt_regions VALUES(772, 49, 'BC', 'Congo-Central', 'Russian');
INSERT INTO emkt_regions VALUES(773, 49, 'BN', 'Bandundu', 'Russian');
INSERT INTO emkt_regions VALUES(774, 49, 'EQ', 'Équateur', 'Russian');
INSERT INTO emkt_regions VALUES(775, 49, 'KA', 'Katanga', 'Russian');
INSERT INTO emkt_regions VALUES(776, 49, 'KE', 'Kasai-Oriental', 'Russian');
INSERT INTO emkt_regions VALUES(777, 49, 'KN', 'Kinshasa', 'Russian');
INSERT INTO emkt_regions VALUES(778, 49, 'KW', 'Kasai-Occidental', 'Russian');
INSERT INTO emkt_regions VALUES(779, 49, 'MA', 'Maniema', 'Russian');
INSERT INTO emkt_regions VALUES(780, 49, 'NK', 'Nord-Kivu', 'Russian');
INSERT INTO emkt_regions VALUES(781, 49, 'OR', 'Orientale', 'Russian');
INSERT INTO emkt_regions VALUES(782, 49, 'SK', 'Sud-Kivu', 'Russian');

INSERT INTO emkt_countries VALUES (50,'Острова Кука','Russian','CK','COK','');

INSERT INTO emkt_regions VALUES(783, 50, 'PU', 'Pukapuka', 'Russian');
INSERT INTO emkt_regions VALUES(784, 50, 'RK', 'Rakahanga', 'Russian');
INSERT INTO emkt_regions VALUES(785, 50, 'MK', 'Manihiki', 'Russian');
INSERT INTO emkt_regions VALUES(786, 50, 'PE', 'Penrhyn', 'Russian');
INSERT INTO emkt_regions VALUES(787, 50, 'NI', 'Nassau Island', 'Russian');
INSERT INTO emkt_regions VALUES(788, 50, 'SU', 'Surwarrow', 'Russian');
INSERT INTO emkt_regions VALUES(789, 50, 'PA', 'Palmerston', 'Russian');
INSERT INTO emkt_regions VALUES(790, 50, 'AI', 'Aitutaki', 'Russian');
INSERT INTO emkt_regions VALUES(791, 50, 'MA', 'Manuae', 'Russian');
INSERT INTO emkt_regions VALUES(792, 50, 'TA', 'Takutea', 'Russian');
INSERT INTO emkt_regions VALUES(793, 50, 'MT', 'Mitiaro', 'Russian');
INSERT INTO emkt_regions VALUES(794, 50, 'AT', 'Atiu', 'Russian');
INSERT INTO emkt_regions VALUES(795, 50, 'MU', 'Mauke', 'Russian');
INSERT INTO emkt_regions VALUES(796, 50, 'RR', 'Rarotonga', 'Russian');
INSERT INTO emkt_regions VALUES(797, 50, 'MG', 'Mangaia', 'Russian');

INSERT INTO emkt_countries VALUES (51,'Коста-Рика','Russian','CR','CRI','');

INSERT INTO emkt_regions VALUES(798, 51, 'A', 'Alajuela', 'Russian');
INSERT INTO emkt_regions VALUES(799, 51, 'C', 'Cartago', 'Russian');
INSERT INTO emkt_regions VALUES(800, 51, 'G', 'Guanacaste', 'Russian');
INSERT INTO emkt_regions VALUES(801, 51, 'H', 'Heredia', 'Russian');
INSERT INTO emkt_regions VALUES(802, 51, 'L', 'Limón', 'Russian');
INSERT INTO emkt_regions VALUES(803, 51, 'P', 'Puntarenas', 'Russian');
INSERT INTO emkt_regions VALUES(804, 51, 'SJ', 'San José', 'Russian');

INSERT INTO emkt_countries VALUES (52,'Кот-Д\'Ивуар','Russian','CI','CIV','');

INSERT INTO emkt_regions VALUES(805, 52, '01', 'Lagunes', 'Russian');
INSERT INTO emkt_regions VALUES(806, 52, '02', 'Haut-Sassandra', 'Russian');
INSERT INTO emkt_regions VALUES(807, 52, '03', 'Savanes', 'Russian');
INSERT INTO emkt_regions VALUES(808, 52, '04', 'Vallée du Bandama', 'Russian');
INSERT INTO emkt_regions VALUES(809, 52, '05', 'Moyen-Comoé', 'Russian');
INSERT INTO emkt_regions VALUES(810, 52, '06', 'Dix-Huit', 'Russian');
INSERT INTO emkt_regions VALUES(811, 52, '07', 'Lacs', 'Russian');
INSERT INTO emkt_regions VALUES(812, 52, '08', 'Zanzan', 'Russian');
INSERT INTO emkt_regions VALUES(813, 52, '09', 'Bas-Sassandra', 'Russian');
INSERT INTO emkt_regions VALUES(814, 52, '10', 'Denguélé', 'Russian');
INSERT INTO emkt_regions VALUES(815, 52, '11', 'N\'zi-Comoé', 'Russian');
INSERT INTO emkt_regions VALUES(816, 52, '12', 'Marahoué', 'Russian');
INSERT INTO emkt_regions VALUES(817, 52, '13', 'Sud-Comoé', 'Russian');
INSERT INTO emkt_regions VALUES(818, 52, '14', 'Worodouqou', 'Russian');
INSERT INTO emkt_regions VALUES(819, 52, '15', 'Sud-Bandama', 'Russian');
INSERT INTO emkt_regions VALUES(820, 52, '16', 'Agnébi', 'Russian');
INSERT INTO emkt_regions VALUES(821, 52, '17', 'Bafing', 'Russian');
INSERT INTO emkt_regions VALUES(822, 52, '18', 'Fromager', 'Russian');
INSERT INTO emkt_regions VALUES(823, 52, '19', 'Moyen-Cavally', 'Russian');

INSERT INTO emkt_countries VALUES (53,'Хорватия','Russian','HR','HRV','');

INSERT INTO emkt_regions VALUES(824, 53, '01', 'Zagrebačka županija', 'Russian');
INSERT INTO emkt_regions VALUES(825, 53, '02', 'Krapinsko-zagorska županija', 'Russian');
INSERT INTO emkt_regions VALUES(826, 53, '03', 'Sisačko-moslavačka županija', 'Russian');
INSERT INTO emkt_regions VALUES(827, 53, '04', 'Karlovačka županija', 'Russian');
INSERT INTO emkt_regions VALUES(828, 53, '05', 'Varaždinska županija', 'Russian');
INSERT INTO emkt_regions VALUES(829, 53, '06', 'Koprivničko-križevačka županija', 'Russian');
INSERT INTO emkt_regions VALUES(830, 53, '07', 'Bjelovarsko-bilogorska županija', 'Russian');
INSERT INTO emkt_regions VALUES(831, 53, '08', 'Primorsko-goranska županija', 'Russian');
INSERT INTO emkt_regions VALUES(832, 53, '09', 'Ličko-senjska županija', 'Russian');
INSERT INTO emkt_regions VALUES(833, 53, '10', 'Virovitičko-podravska županija', 'Russian');
INSERT INTO emkt_regions VALUES(834, 53, '11', 'Požeško-slavonska županija', 'Russian');
INSERT INTO emkt_regions VALUES(835, 53, '12', 'Brodsko-posavska županija', 'Russian');
INSERT INTO emkt_regions VALUES(836, 53, '13', 'Zadarska županija', 'Russian');
INSERT INTO emkt_regions VALUES(837, 53, '14', 'Osječko-baranjska županija', 'Russian');
INSERT INTO emkt_regions VALUES(838, 53, '15', 'Šibensko-kninska županija', 'Russian');
INSERT INTO emkt_regions VALUES(839, 53, '16', 'Vukovarsko-srijemska županija', 'Russian');
INSERT INTO emkt_regions VALUES(840, 53, '17', 'Splitsko-dalmatinska županija', 'Russian');
INSERT INTO emkt_regions VALUES(841, 53, '18', 'Istarska županija', 'Russian');
INSERT INTO emkt_regions VALUES(842, 53, '19', 'Dubrovačko-neretvanska županija', 'Russian');
INSERT INTO emkt_regions VALUES(843, 53, '20', 'Međimurska županija', 'Russian');
INSERT INTO emkt_regions VALUES(844, 53, '21', 'Zagreb', 'Russian');

INSERT INTO emkt_countries VALUES (54,'Куба','Russian','CU','CUB','');

INSERT INTO emkt_regions VALUES(845, 54, '01', 'Pinar del Río', 'Russian');
INSERT INTO emkt_regions VALUES(846, 54, '02', 'La Habana', 'Russian');
INSERT INTO emkt_regions VALUES(847, 54, '03', 'Ciudad de La Habana', 'Russian');
INSERT INTO emkt_regions VALUES(848, 54, '04', 'Matanzas', 'Russian');
INSERT INTO emkt_regions VALUES(849, 54, '05', 'Villa Clara', 'Russian');
INSERT INTO emkt_regions VALUES(850, 54, '06', 'Cienfuegos', 'Russian');
INSERT INTO emkt_regions VALUES(851, 54, '07', 'Sancti Spíritus', 'Russian');
INSERT INTO emkt_regions VALUES(852, 54, '08', 'Ciego de Ávila', 'Russian');
INSERT INTO emkt_regions VALUES(853, 54, '09', 'Camagüey', 'Russian');
INSERT INTO emkt_regions VALUES(854, 54, '10', 'Las Tunas', 'Russian');
INSERT INTO emkt_regions VALUES(855, 54, '11', 'Holguín', 'Russian');
INSERT INTO emkt_regions VALUES(856, 54, '12', 'Granma', 'Russian');
INSERT INTO emkt_regions VALUES(857, 54, '13', 'Santiago de Cuba', 'Russian');
INSERT INTO emkt_regions VALUES(858, 54, '14', 'Guantánamo', 'Russian');
INSERT INTO emkt_regions VALUES(859, 54, '99', 'Isla de la Juventud', 'Russian');

INSERT INTO emkt_countries VALUES (55,'Республика Кипр','Russian','CY','CYP','');

INSERT INTO emkt_regions VALUES(860, 55, '01', 'Κερύvεια', 'Russian');
INSERT INTO emkt_regions VALUES(861, 55, '02', 'Λευκωσία', 'Russian');
INSERT INTO emkt_regions VALUES(862, 55, '03', 'Αμμόχωστος', 'Russian');
INSERT INTO emkt_regions VALUES(863, 55, '04', 'Λάρνακα', 'Russian');
INSERT INTO emkt_regions VALUES(864, 55, '05', 'Λεμεσός', 'Russian');
INSERT INTO emkt_regions VALUES(865, 55, '06', 'Πάφος', 'Russian');

INSERT INTO emkt_countries VALUES (56,'Чешская Республика','Russian','CZ','CZE','');

INSERT INTO emkt_regions VALUES(866, 56, 'JC', 'Jihočeský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(867, 56, 'JM', 'Jihomoravský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(868, 56, 'KA', 'Karlovarský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(869, 56, 'VY', 'Vysočina kraj', 'Russian');
INSERT INTO emkt_regions VALUES(870, 56, 'KR', 'Královéhradecký kraj', 'Russian');
INSERT INTO emkt_regions VALUES(871, 56, 'LI', 'Liberecký kraj', 'Russian');
INSERT INTO emkt_regions VALUES(872, 56, 'MO', 'Moravskoslezský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(873, 56, 'OL', 'Olomoucký kraj', 'Russian');
INSERT INTO emkt_regions VALUES(874, 56, 'PA', 'Pardubický kraj', 'Russian');
INSERT INTO emkt_regions VALUES(875, 56, 'PL', 'Plzeňský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(876, 56, 'PR', 'Hlavní město Praha', 'Russian');
INSERT INTO emkt_regions VALUES(877, 56, 'ST', 'Středočeský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(878, 56, 'US', 'Ústecký kraj', 'Russian');
INSERT INTO emkt_regions VALUES(879, 56, 'ZL', 'Zlínský kraj', 'Russian');

INSERT INTO emkt_countries VALUES (57,'Дания','Russian','DK','DNK','');

INSERT INTO emkt_regions VALUES(880, 57, '040', 'Bornholms Regionskommune', 'Russian');
INSERT INTO emkt_regions VALUES(881, 57, '101', 'København', 'Russian');
INSERT INTO emkt_regions VALUES(882, 57, '147', 'Frederiksberg', 'Russian');
INSERT INTO emkt_regions VALUES(883, 57, '070', 'Århus Amt', 'Russian');
INSERT INTO emkt_regions VALUES(884, 57, '015', 'Københavns Amt', 'Russian');
INSERT INTO emkt_regions VALUES(885, 57, '020', 'Frederiksborg Amt', 'Russian');
INSERT INTO emkt_regions VALUES(886, 57, '042', 'Fyns Amt', 'Russian');
INSERT INTO emkt_regions VALUES(887, 57, '080', 'Nordjyllands Amt', 'Russian');
INSERT INTO emkt_regions VALUES(888, 57, '055', 'Ribe Amt', 'Russian');
INSERT INTO emkt_regions VALUES(889, 57, '065', 'Ringkjøbing Amt', 'Russian');
INSERT INTO emkt_regions VALUES(890, 57, '025', 'Roskilde Amt', 'Russian');
INSERT INTO emkt_regions VALUES(891, 57, '050', 'Sønderjyllands Amt', 'Russian');
INSERT INTO emkt_regions VALUES(892, 57, '035', 'Storstrøms Amt', 'Russian');
INSERT INTO emkt_regions VALUES(893, 57, '060', 'Vejle Amt', 'Russian');
INSERT INTO emkt_regions VALUES(894, 57, '030', 'Vestsjællands Amt', 'Russian');
INSERT INTO emkt_regions VALUES(895, 57, '076', 'Viborg Amt', 'Russian');

INSERT INTO emkt_countries VALUES (58,'Джибути','Russian','DJ','DJI','');

INSERT INTO emkt_regions VALUES(896, 58, 'AS', 'Region d\'Ali Sabieh', 'Russian');
INSERT INTO emkt_regions VALUES(897, 58, 'AR', 'Region d\'Arta', 'Russian');
INSERT INTO emkt_regions VALUES(898, 58, 'DI', 'Region de Dikhil', 'Russian');
INSERT INTO emkt_regions VALUES(899, 58, 'DJ', 'Ville de Djibouti', 'Russian');
INSERT INTO emkt_regions VALUES(900, 58, 'OB', 'Region d\'Obock', 'Russian');
INSERT INTO emkt_regions VALUES(901, 58, 'TA', 'Region de Tadjourah', 'Russian');

INSERT INTO emkt_countries VALUES (59,'Доминика','Russian','DM','DMA','');

INSERT INTO emkt_regions VALUES(902, 59, 'AND', 'Saint Andrew Parish', 'Russian');
INSERT INTO emkt_regions VALUES(903, 59, 'DAV', 'Saint David Parish', 'Russian');
INSERT INTO emkt_regions VALUES(904, 59, 'GEO', 'Saint George Parish', 'Russian');
INSERT INTO emkt_regions VALUES(905, 59, 'JOH', 'Saint John Parish', 'Russian');
INSERT INTO emkt_regions VALUES(906, 59, 'JOS', 'Saint Joseph Parish', 'Russian');
INSERT INTO emkt_regions VALUES(907, 59, 'LUK', 'Saint Luke Parish', 'Russian');
INSERT INTO emkt_regions VALUES(908, 59, 'MAR', 'Saint Mark Parish', 'Russian');
INSERT INTO emkt_regions VALUES(909, 59, 'PAT', 'Saint Patrick Parish', 'Russian');
INSERT INTO emkt_regions VALUES(910, 59, 'PAU', 'Saint Paul Parish', 'Russian');
INSERT INTO emkt_regions VALUES(911, 59, 'PET', 'Saint Peter Parish', 'Russian');

INSERT INTO emkt_countries VALUES (60,'Доминиканская Республика','Russian','DO','DOM','');

INSERT INTO emkt_regions VALUES(912, 60, '01', 'Distrito Nacional', 'Russian');
INSERT INTO emkt_regions VALUES(913, 60, '02', 'Ázua', 'Russian');
INSERT INTO emkt_regions VALUES(914, 60, '03', 'Baoruco', 'Russian');
INSERT INTO emkt_regions VALUES(915, 60, '04', 'Barahona', 'Russian');
INSERT INTO emkt_regions VALUES(916, 60, '05', 'Dajabón', 'Russian');
INSERT INTO emkt_regions VALUES(917, 60, '06', 'Duarte', 'Russian');
INSERT INTO emkt_regions VALUES(918, 60, '07', 'Elías Piña', 'Russian');
INSERT INTO emkt_regions VALUES(919, 60, '08', 'El Seibo', 'Russian');
INSERT INTO emkt_regions VALUES(920, 60, '09', 'Espaillat', 'Russian');
INSERT INTO emkt_regions VALUES(921, 60, '10', 'Independencia', 'Russian');
INSERT INTO emkt_regions VALUES(922, 60, '11', 'La Altagracia', 'Russian');
INSERT INTO emkt_regions VALUES(923, 60, '12', 'La Romana', 'Russian');
INSERT INTO emkt_regions VALUES(924, 60, '13', 'La Vega', 'Russian');
INSERT INTO emkt_regions VALUES(925, 60, '14', 'María Trinidad Sánchez', 'Russian');
INSERT INTO emkt_regions VALUES(926, 60, '15', 'Monte Cristi', 'Russian');
INSERT INTO emkt_regions VALUES(927, 60, '16', 'Pedernales', 'Russian');
INSERT INTO emkt_regions VALUES(928, 60, '17', 'Peravia', 'Russian');
INSERT INTO emkt_regions VALUES(929, 60, '18', 'Puerto Plata', 'Russian');
INSERT INTO emkt_regions VALUES(930, 60, '19', 'Salcedo', 'Russian');
INSERT INTO emkt_regions VALUES(931, 60, '20', 'Samaná', 'Russian');
INSERT INTO emkt_regions VALUES(932, 60, '21', 'San Cristóbal', 'Russian');
INSERT INTO emkt_regions VALUES(933, 60, '22', 'San Juan', 'Russian');
INSERT INTO emkt_regions VALUES(934, 60, '23', 'San Pedro de Macorís', 'Russian');
INSERT INTO emkt_regions VALUES(935, 60, '24', 'Sánchez Ramírez', 'Russian');
INSERT INTO emkt_regions VALUES(936, 60, '25', 'Santiago', 'Russian');
INSERT INTO emkt_regions VALUES(937, 60, '26', 'Santiago Rodríguez', 'Russian');
INSERT INTO emkt_regions VALUES(938, 60, '27', 'Valverde', 'Russian');
INSERT INTO emkt_regions VALUES(939, 60, '28', 'Monseñor Nouel', 'Russian');
INSERT INTO emkt_regions VALUES(940, 60, '29', 'Monte Plata', 'Russian');
INSERT INTO emkt_regions VALUES(941, 60, '30', 'Hato Mayor', 'Russian');

INSERT INTO emkt_countries VALUES (61,'Восточный Тимор','Russian','TP','TMP','');

INSERT INTO emkt_regions VALUES(942, 61, 'AL', 'Aileu', 'Russian');
INSERT INTO emkt_regions VALUES(943, 61, 'AN', 'Ainaro', 'Russian');
INSERT INTO emkt_regions VALUES(944, 61, 'BA', 'Baucau', 'Russian');
INSERT INTO emkt_regions VALUES(945, 61, 'BO', 'Bobonaro', 'Russian');
INSERT INTO emkt_regions VALUES(946, 61, 'CO', 'Cova-Lima', 'Russian');
INSERT INTO emkt_regions VALUES(947, 61, 'DI', 'Dili', 'Russian');
INSERT INTO emkt_regions VALUES(948, 61, 'ER', 'Ermera', 'Russian');
INSERT INTO emkt_regions VALUES(949, 61, 'LA', 'Lautem', 'Russian');
INSERT INTO emkt_regions VALUES(950, 61, 'LI', 'Liquiçá', 'Russian');
INSERT INTO emkt_regions VALUES(951, 61, 'MF', 'Manufahi', 'Russian');
INSERT INTO emkt_regions VALUES(952, 61, 'MT', 'Manatuto', 'Russian');
INSERT INTO emkt_regions VALUES(953, 61, 'OE', 'Oecussi', 'Russian');
INSERT INTO emkt_regions VALUES(954, 61, 'VI', 'Viqueque', 'Russian');

INSERT INTO emkt_countries VALUES (62,'Эквадор','Russian','EC','ECU','');

INSERT INTO emkt_regions VALUES(955, 62, 'A', 'Azuay', 'Russian');
INSERT INTO emkt_regions VALUES(956, 62, 'B', 'Bolívar', 'Russian');
INSERT INTO emkt_regions VALUES(957, 62, 'C', 'Carchi', 'Russian');
INSERT INTO emkt_regions VALUES(958, 62, 'D', 'Orellana', 'Russian');
INSERT INTO emkt_regions VALUES(959, 62, 'E', 'Esmeraldas', 'Russian');
INSERT INTO emkt_regions VALUES(960, 62, 'F', 'Cañar', 'Russian');
INSERT INTO emkt_regions VALUES(961, 62, 'G', 'Guayas', 'Russian');
INSERT INTO emkt_regions VALUES(962, 62, 'H', 'Chimborazo', 'Russian');
INSERT INTO emkt_regions VALUES(963, 62, 'I', 'Imbabura', 'Russian');
INSERT INTO emkt_regions VALUES(964, 62, 'L', 'Loja', 'Russian');
INSERT INTO emkt_regions VALUES(965, 62, 'M', 'Manabí', 'Russian');
INSERT INTO emkt_regions VALUES(966, 62, 'N', 'Napo', 'Russian');
INSERT INTO emkt_regions VALUES(967, 62, 'O', 'El Oro', 'Russian');
INSERT INTO emkt_regions VALUES(968, 62, 'P', 'Pichincha', 'Russian');
INSERT INTO emkt_regions VALUES(969, 62, 'R', 'Los Ríos', 'Russian');
INSERT INTO emkt_regions VALUES(970, 62, 'S', 'Morona-Santiago', 'Russian');
INSERT INTO emkt_regions VALUES(971, 62, 'T', 'Tungurahua', 'Russian');
INSERT INTO emkt_regions VALUES(972, 62, 'U', 'Sucumbíos', 'Russian');
INSERT INTO emkt_regions VALUES(973, 62, 'W', 'Galápagos', 'Russian');
INSERT INTO emkt_regions VALUES(974, 62, 'X', 'Cotopaxi', 'Russian');
INSERT INTO emkt_regions VALUES(975, 62, 'Y', 'Pastaza', 'Russian');
INSERT INTO emkt_regions VALUES(976, 62, 'Z', 'Zamora-Chinchipe', 'Russian');

INSERT INTO emkt_countries VALUES (63,'Египет','Russian','EG','EGY','');

INSERT INTO emkt_regions VALUES(977, 63, 'ALX', 'الإسكندرية', 'Russian');
INSERT INTO emkt_regions VALUES(978, 63, 'ASN', 'أسوان', 'Russian');
INSERT INTO emkt_regions VALUES(979, 63, 'AST', 'أسيوط', 'Russian');
INSERT INTO emkt_regions VALUES(980, 63, 'BA', 'البحر الأحمر', 'Russian');
INSERT INTO emkt_regions VALUES(981, 63, 'BH', 'البحيرة', 'Russian');
INSERT INTO emkt_regions VALUES(982, 63, 'BNS', 'بني سويف', 'Russian');
INSERT INTO emkt_regions VALUES(983, 63, 'C', 'القاهرة', 'Russian');
INSERT INTO emkt_regions VALUES(984, 63, 'DK', 'الدقهلية', 'Russian');
INSERT INTO emkt_regions VALUES(985, 63, 'DT', 'دمياط', 'Russian');
INSERT INTO emkt_regions VALUES(986, 63, 'FYM', 'الفيوم', 'Russian');
INSERT INTO emkt_regions VALUES(987, 63, 'GH', 'الغربية', 'Russian');
INSERT INTO emkt_regions VALUES(988, 63, 'GZ', 'الجيزة', 'Russian');
INSERT INTO emkt_regions VALUES(989, 63, 'IS', 'الإسماعيلية', 'Russian');
INSERT INTO emkt_regions VALUES(990, 63, 'JS', 'جنوب سيناء', 'Russian');
INSERT INTO emkt_regions VALUES(991, 63, 'KB', 'القليوبية', 'Russian');
INSERT INTO emkt_regions VALUES(992, 63, 'KFS', 'كفر الشيخ', 'Russian');
INSERT INTO emkt_regions VALUES(993, 63, 'KN', 'قنا', 'Russian');
INSERT INTO emkt_regions VALUES(994, 63, 'MN', 'محافظة المنيا', 'Russian');
INSERT INTO emkt_regions VALUES(995, 63, 'MNF', 'المنوفية', 'Russian');
INSERT INTO emkt_regions VALUES(996, 63, 'MT', 'مطروح', 'Russian');
INSERT INTO emkt_regions VALUES(997, 63, 'PTS', 'محافظة بور سعيد', 'Russian');
INSERT INTO emkt_regions VALUES(998, 63, 'SHG', 'محافظة سوهاج', 'Russian');
INSERT INTO emkt_regions VALUES(999, 63, 'SHR', 'المحافظة الشرقيّة', 'Russian');
INSERT INTO emkt_regions VALUES(1000, 63, 'SIN', 'شمال سيناء', 'Russian');
INSERT INTO emkt_regions VALUES(1001, 63, 'SUZ', 'السويس', 'Russian');
INSERT INTO emkt_regions VALUES(1002, 63, 'WAD', 'الوادى الجديد', 'Russian');

INSERT INTO emkt_countries VALUES (64,'Сальвадор','Russian','SV','SLV','');

INSERT INTO emkt_regions VALUES(1003, 64, 'AH', 'Ahuachapán', 'Russian');
INSERT INTO emkt_regions VALUES(1004, 64, 'CA', 'Cabañas', 'Russian');
INSERT INTO emkt_regions VALUES(1005, 64, 'CH', 'Chalatenango', 'Russian');
INSERT INTO emkt_regions VALUES(1006, 64, 'CU', 'Cuscatlán', 'Russian');
INSERT INTO emkt_regions VALUES(1007, 64, 'LI', 'La Libertad', 'Russian');
INSERT INTO emkt_regions VALUES(1008, 64, 'MO', 'Morazán', 'Russian');
INSERT INTO emkt_regions VALUES(1009, 64, 'PA', 'La Paz', 'Russian');
INSERT INTO emkt_regions VALUES(1010, 64, 'SA', 'Santa Ana', 'Russian');
INSERT INTO emkt_regions VALUES(1011, 64, 'SM', 'San Miguel', 'Russian');
INSERT INTO emkt_regions VALUES(1012, 64, 'SO', 'Sonsonate', 'Russian');
INSERT INTO emkt_regions VALUES(1013, 64, 'SS', 'San Salvador', 'Russian');
INSERT INTO emkt_regions VALUES(1014, 64, 'SV', 'San Vicente', 'Russian');
INSERT INTO emkt_regions VALUES(1015, 64, 'UN', 'La Unión', 'Russian');
INSERT INTO emkt_regions VALUES(1016, 64, 'US', 'Usulután', 'Russian');

INSERT INTO emkt_countries VALUES (65,'Экваториальная Гвинея','Russian','GQ','GNQ','');

INSERT INTO emkt_regions VALUES(1017, 65, 'AN', 'Annobón', 'Russian');
INSERT INTO emkt_regions VALUES(1018, 65, 'BN', 'Bioko Norte', 'Russian');
INSERT INTO emkt_regions VALUES(1019, 65, 'BS', 'Bioko Sur', 'Russian');
INSERT INTO emkt_regions VALUES(1020, 65, 'CS', 'Centro Sur', 'Russian');
INSERT INTO emkt_regions VALUES(1021, 65, 'KN', 'Kié-Ntem', 'Russian');
INSERT INTO emkt_regions VALUES(1022, 65, 'LI', 'Litoral', 'Russian');
INSERT INTO emkt_regions VALUES(1023, 65, 'WN', 'Wele-Nzas', 'Russian');

INSERT INTO emkt_countries VALUES (66,'Эритрея','Russian','ER','ERI','');

INSERT INTO emkt_regions VALUES(1024, 66, 'AN', 'Zoba Anseba', 'Russian');
INSERT INTO emkt_regions VALUES(1025, 66, 'DK', 'Zoba Debubawi Keyih Bahri', 'Russian');
INSERT INTO emkt_regions VALUES(1026, 66, 'DU', 'Zoba Debub', 'Russian');
INSERT INTO emkt_regions VALUES(1027, 66, 'GB', 'Zoba Gash-Barka', 'Russian');
INSERT INTO emkt_regions VALUES(1028, 66, 'MA', 'Zoba Ma\'akel', 'Russian');
INSERT INTO emkt_regions VALUES(1029, 66, 'SK', 'Zoba Semienawi Keyih Bahri', 'Russian');

INSERT INTO emkt_countries VALUES (67,'Эстония','Russian','EE','EST','');

INSERT INTO emkt_regions VALUES(1030, 67, '37', 'Harju maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1031, 67, '39', 'Hiiu maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1032, 67, '44', 'Ida-Viru maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1033, 67, '49', 'Jõgeva maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1034, 67, '51', 'Järva maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1035, 67, '57', 'Lääne maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1036, 67, '59', 'Lääne-Viru maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1037, 67, '65', 'Põlva maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1038, 67, '67', 'Pärnu maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1039, 67, '70', 'Rapla maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1040, 67, '74', 'Saare maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1041, 67, '78', 'Tartu maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1042, 67, '82', 'Valga maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1043, 67, '84', 'Viljandi maakond', 'Russian');
INSERT INTO emkt_regions VALUES(1044, 67, '86', 'Võru maakond', 'Russian');

INSERT INTO emkt_countries VALUES (68,'Эфиопия','Russian','ET','ETH','');

INSERT INTO emkt_regions VALUES(1045, 68, 'AA', 'አዲስ አበባ', 'Russian');
INSERT INTO emkt_regions VALUES(1046, 68, 'AF', 'አፋር', 'Russian');
INSERT INTO emkt_regions VALUES(1047, 68, 'AH', 'አማራ', 'Russian');
INSERT INTO emkt_regions VALUES(1048, 68, 'BG', 'ቤንሻንጉል-ጉምዝ', 'Russian');
INSERT INTO emkt_regions VALUES(1049, 68, 'DD', 'ድሬዳዋ', 'Russian');
INSERT INTO emkt_regions VALUES(1050, 68, 'GB', 'ጋምቤላ ሕዝቦች', 'Russian');
INSERT INTO emkt_regions VALUES(1051, 68, 'HR', 'ሀረሪ ሕዝብ', 'Russian');
INSERT INTO emkt_regions VALUES(1052, 68, 'OR', 'ኦሮሚያ', 'Russian');
INSERT INTO emkt_regions VALUES(1053, 68, 'SM', 'ሶማሌ', 'Russian');
INSERT INTO emkt_regions VALUES(1054, 68, 'SN', 'ደቡብ ብሔሮች ብሔረሰቦችና ሕዝቦች', 'Russian');
INSERT INTO emkt_regions VALUES(1055, 68, 'TG', 'ትግራይ', 'Russian');

INSERT INTO emkt_countries VALUES (69,'Фолклендские острова','Russian','FK','FLK','');

INSERT INTO emkt_regions VALUES(4257, 69, 'NOCODE', 'Falkland Islands (Malvinas)', 'Russian');

INSERT INTO emkt_countries VALUES (70,'Фарерские острова','Russian','FO','FRO','');

INSERT INTO emkt_regions VALUES(4258, 70, 'NOCODE', 'Faroe Islands', 'Russian');

INSERT INTO emkt_countries VALUES (71,'Фиджи','Russian','FJ','FJI','');

INSERT INTO emkt_regions VALUES(1056, 71, 'C', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(1057, 71, 'E', 'Northern', 'Russian');
INSERT INTO emkt_regions VALUES(1058, 71, 'N', 'Eastern', 'Russian');
INSERT INTO emkt_regions VALUES(1059, 71, 'R', 'Rotuma', 'Russian');
INSERT INTO emkt_regions VALUES(1060, 71, 'W', 'Western', 'Russian');

INSERT INTO emkt_countries VALUES (72,'Финляндия','Russian','FI','FIN','');

INSERT INTO emkt_regions VALUES(1061, 72, 'AL', 'Ahvenanmaan maakunta', 'Russian');
INSERT INTO emkt_regions VALUES(1062, 72, 'ES', 'Etelä-Suomen lääni', 'Russian');
INSERT INTO emkt_regions VALUES(1063, 72, 'IS', 'Itä-Suomen lääni', 'Russian');
INSERT INTO emkt_regions VALUES(1064, 72, 'LL', 'Lapin lääni', 'Russian');
INSERT INTO emkt_regions VALUES(1065, 72, 'LS', 'Länsi-Suomen lääni', 'Russian');
INSERT INTO emkt_regions VALUES(1066, 72, 'OL', 'Oulun lääni', 'Russian');

INSERT INTO emkt_countries VALUES (73,'Франция','Russian','FR','FRA','');

INSERT INTO emkt_regions VALUES(1067, 73, '01', 'Ain', 'Russian');
INSERT INTO emkt_regions VALUES(1068, 73, '02', 'Aisne', 'Russian');
INSERT INTO emkt_regions VALUES(1069, 73, '03', 'Allier', 'Russian');
INSERT INTO emkt_regions VALUES(1070, 73, '04', 'Alpes-de-Haute-Provence', 'Russian');
INSERT INTO emkt_regions VALUES(1071, 73, '05', 'Hautes-Alpes', 'Russian');
INSERT INTO emkt_regions VALUES(1072, 73, '06', 'Alpes-Maritimes', 'Russian');
INSERT INTO emkt_regions VALUES(1073, 73, '07', 'Ardèche', 'Russian');
INSERT INTO emkt_regions VALUES(1074, 73, '08', 'Ardennes', 'Russian');
INSERT INTO emkt_regions VALUES(1075, 73, '09', 'Ariège', 'Russian');
INSERT INTO emkt_regions VALUES(1076, 73, '10', 'Aube', 'Russian');
INSERT INTO emkt_regions VALUES(1077, 73, '11', 'Aude', 'Russian');
INSERT INTO emkt_regions VALUES(1078, 73, '12', 'Aveyron', 'Russian');
INSERT INTO emkt_regions VALUES(1079, 73, '13', 'Bouches-du-Rhône', 'Russian');
INSERT INTO emkt_regions VALUES(1080, 73, '14', 'Calvados', 'Russian');
INSERT INTO emkt_regions VALUES(1081, 73, '15', 'Cantal', 'Russian');
INSERT INTO emkt_regions VALUES(1082, 73, '16', 'Charente', 'Russian');
INSERT INTO emkt_regions VALUES(1083, 73, '17', 'Charente-Maritime', 'Russian');
INSERT INTO emkt_regions VALUES(1084, 73, '18', 'Cher', 'Russian');
INSERT INTO emkt_regions VALUES(1085, 73, '19', 'Corrèze', 'Russian');
INSERT INTO emkt_regions VALUES(1086, 73, '21', 'Côte-d\'Or', 'Russian');
INSERT INTO emkt_regions VALUES(1087, 73, '22', 'Côtes-d\'Armor', 'Russian');
INSERT INTO emkt_regions VALUES(1088, 73, '23', 'Creuse', 'Russian');
INSERT INTO emkt_regions VALUES(1089, 73, '24', 'Dordogne', 'Russian');
INSERT INTO emkt_regions VALUES(1090, 73, '25', 'Doubs', 'Russian');
INSERT INTO emkt_regions VALUES(1091, 73, '26', 'Drôme', 'Russian');
INSERT INTO emkt_regions VALUES(1092, 73, '27', 'Eure', 'Russian');
INSERT INTO emkt_regions VALUES(1093, 73, '28', 'Eure-et-Loir', 'Russian');
INSERT INTO emkt_regions VALUES(1094, 73, '29', 'Finistère', 'Russian');
INSERT INTO emkt_regions VALUES(1095, 73, '2A', 'Corse-du-Sud', 'Russian');
INSERT INTO emkt_regions VALUES(1096, 73, '2B', 'Haute-Corse', 'Russian');
INSERT INTO emkt_regions VALUES(1097, 73, '30', 'Gard', 'Russian');
INSERT INTO emkt_regions VALUES(1098, 73, '31', 'Haute-Garonne', 'Russian');
INSERT INTO emkt_regions VALUES(1099, 73, '32', 'Gers', 'Russian');
INSERT INTO emkt_regions VALUES(1100, 73, '33', 'Gironde', 'Russian');
INSERT INTO emkt_regions VALUES(1101, 73, '34', 'Hérault', 'Russian');
INSERT INTO emkt_regions VALUES(1102, 73, '35', 'Ille-et-Vilaine', 'Russian');
INSERT INTO emkt_regions VALUES(1103, 73, '36', 'Indre', 'Russian');
INSERT INTO emkt_regions VALUES(1104, 73, '37', 'Indre-et-Loire', 'Russian');
INSERT INTO emkt_regions VALUES(1105, 73, '38', 'Isère', 'Russian');
INSERT INTO emkt_regions VALUES(1106, 73, '39', 'Jura', 'Russian');
INSERT INTO emkt_regions VALUES(1107, 73, '40', 'Landes', 'Russian');
INSERT INTO emkt_regions VALUES(1108, 73, '41', 'Loir-et-Cher', 'Russian');
INSERT INTO emkt_regions VALUES(1109, 73, '42', 'Loire', 'Russian');
INSERT INTO emkt_regions VALUES(1110, 73, '43', 'Haute-Loire', 'Russian');
INSERT INTO emkt_regions VALUES(1111, 73, '44', 'Loire-Atlantique', 'Russian');
INSERT INTO emkt_regions VALUES(1112, 73, '45', 'Loiret', 'Russian');
INSERT INTO emkt_regions VALUES(1113, 73, '46', 'Lot', 'Russian');
INSERT INTO emkt_regions VALUES(1114, 73, '47', 'Lot-et-Garonne', 'Russian');
INSERT INTO emkt_regions VALUES(1115, 73, '48', 'Lozère', 'Russian');
INSERT INTO emkt_regions VALUES(1116, 73, '49', 'Maine-et-Loire', 'Russian');
INSERT INTO emkt_regions VALUES(1117, 73, '50', 'Manche', 'Russian');
INSERT INTO emkt_regions VALUES(1118, 73, '51', 'Marne', 'Russian');
INSERT INTO emkt_regions VALUES(1119, 73, '52', 'Haute-Marne', 'Russian');
INSERT INTO emkt_regions VALUES(1120, 73, '53', 'Mayenne', 'Russian');
INSERT INTO emkt_regions VALUES(1121, 73, '54', 'Meurthe-et-Moselle', 'Russian');
INSERT INTO emkt_regions VALUES(1122, 73, '55', 'Meuse', 'Russian');
INSERT INTO emkt_regions VALUES(1123, 73, '56', 'Morbihan', 'Russian');
INSERT INTO emkt_regions VALUES(1124, 73, '57', 'Moselle', 'Russian');
INSERT INTO emkt_regions VALUES(1125, 73, '58', 'Nièvre', 'Russian');
INSERT INTO emkt_regions VALUES(1126, 73, '59', 'Nord', 'Russian');
INSERT INTO emkt_regions VALUES(1127, 73, '60', 'Oise', 'Russian');
INSERT INTO emkt_regions VALUES(1128, 73, '61', 'Orne', 'Russian');
INSERT INTO emkt_regions VALUES(1129, 73, '62', 'Pas-de-Calais', 'Russian');
INSERT INTO emkt_regions VALUES(1130, 73, '63', 'Puy-de-Dôme', 'Russian');
INSERT INTO emkt_regions VALUES(1131, 73, '64', 'Pyrénées-Atlantiques', 'Russian');
INSERT INTO emkt_regions VALUES(1132, 73, '65', 'Hautes-Pyrénées', 'Russian');
INSERT INTO emkt_regions VALUES(1133, 73, '66', 'Pyrénées-Orientales', 'Russian');
INSERT INTO emkt_regions VALUES(1134, 73, '67', 'Bas-Rhin', 'Russian');
INSERT INTO emkt_regions VALUES(1135, 73, '68', 'Haut-Rhin', 'Russian');
INSERT INTO emkt_regions VALUES(1136, 73, '69', 'Rhône', 'Russian');
INSERT INTO emkt_regions VALUES(1137, 73, '70', 'Haute-Saône', 'Russian');
INSERT INTO emkt_regions VALUES(1138, 73, '71', 'Saône-et-Loire', 'Russian');
INSERT INTO emkt_regions VALUES(1139, 73, '72', 'Sarthe', 'Russian');
INSERT INTO emkt_regions VALUES(1140, 73, '73', 'Savoie', 'Russian');
INSERT INTO emkt_regions VALUES(1141, 73, '74', 'Haute-Savoie', 'Russian');
INSERT INTO emkt_regions VALUES(1142, 73, '75', 'Paris', 'Russian');
INSERT INTO emkt_regions VALUES(1143, 73, '76', 'Seine-Maritime', 'Russian');
INSERT INTO emkt_regions VALUES(1144, 73, '77', 'Seine-et-Marne', 'Russian');
INSERT INTO emkt_regions VALUES(1145, 73, '78', 'Yvelines', 'Russian');
INSERT INTO emkt_regions VALUES(1146, 73, '79', 'Deux-Sèvres', 'Russian');
INSERT INTO emkt_regions VALUES(1147, 73, '80', 'Somme', 'Russian');
INSERT INTO emkt_regions VALUES(1148, 73, '81', 'Tarn', 'Russian');
INSERT INTO emkt_regions VALUES(1149, 73, '82', 'Tarn-et-Garonne', 'Russian');
INSERT INTO emkt_regions VALUES(1150, 73, '83', 'Var', 'Russian');
INSERT INTO emkt_regions VALUES(1151, 73, '84', 'Vaucluse', 'Russian');
INSERT INTO emkt_regions VALUES(1152, 73, '85', 'Vendée', 'Russian');
INSERT INTO emkt_regions VALUES(1153, 73, '86', 'Vienne', 'Russian');
INSERT INTO emkt_regions VALUES(1154, 73, '87', 'Haute-Vienne', 'Russian');
INSERT INTO emkt_regions VALUES(1155, 73, '88', 'Vosges', 'Russian');
INSERT INTO emkt_regions VALUES(1156, 73, '89', 'Yonne', 'Russian');
INSERT INTO emkt_regions VALUES(1157, 73, '90', 'Territoire de Belfort', 'Russian');
INSERT INTO emkt_regions VALUES(1158, 73, '91', 'Essonne', 'Russian');
INSERT INTO emkt_regions VALUES(1159, 73, '92', 'Hauts-de-Seine', 'Russian');
INSERT INTO emkt_regions VALUES(1160, 73, '93', 'Seine-Saint-Denis', 'Russian');
INSERT INTO emkt_regions VALUES(1161, 73, '94', 'Val-de-Marne', 'Russian');
INSERT INTO emkt_regions VALUES(1162, 73, '95', 'Val-d\'Oise', 'Russian');
INSERT INTO emkt_regions VALUES(1163, 73, 'NC', 'Territoire des Nouvelle-Calédonie et Dependances', 'Russian');
INSERT INTO emkt_regions VALUES(1164, 73, 'PF', 'Polynésie Française', 'Russian');
INSERT INTO emkt_regions VALUES(1165, 73, 'PM', 'Saint-Pierre et Miquelon', 'Russian');
INSERT INTO emkt_regions VALUES(1166, 73, 'TF', 'Terres australes et antarctiques françaises', 'Russian');
INSERT INTO emkt_regions VALUES(1167, 73, 'YT', 'Mayotte', 'Russian');
INSERT INTO emkt_regions VALUES(1168, 73, 'WF', 'Territoire des îles Wallis et Futuna', 'Russian');

INSERT INTO emkt_countries VALUES (74,'Французская Гвиана','Russian','GF','GUF','');

INSERT INTO emkt_regions VALUES(4259, 74, 'NOCODE', 'French Guiana', 'Russian');

INSERT INTO emkt_countries VALUES (75,'Французская Полинезия','Russian','PF','PYF','');

INSERT INTO emkt_regions VALUES(1169, 75, 'M', 'Archipel des Marquises', 'Russian');
INSERT INTO emkt_regions VALUES(1170, 75, 'T', 'Archipel des Tuamotu', 'Russian');
INSERT INTO emkt_regions VALUES(1171, 75, 'I', 'Archipel des Tubuai', 'Russian');
INSERT INTO emkt_regions VALUES(1172, 75, 'V', 'Iles du Vent', 'Russian');
INSERT INTO emkt_regions VALUES(1173, 75, 'S', 'Iles Sous-le-Vent', 'Russian');

INSERT INTO emkt_countries VALUES (76,'Французские Южные и Антарктические территории','Russian','TF','ATF','');

INSERT INTO emkt_regions VALUES(1174, 76, 'C', 'Iles Crozet', 'Russian');
INSERT INTO emkt_regions VALUES(1175, 76, 'K', 'Iles Kerguelen', 'Russian');
INSERT INTO emkt_regions VALUES(1176, 76, 'A', 'Ile Amsterdam', 'Russian');
INSERT INTO emkt_regions VALUES(1177, 76, 'P', 'Ile Saint-Paul', 'Russian');
INSERT INTO emkt_regions VALUES(1178, 76, 'D', 'Adelie Land', 'Russian');

INSERT INTO emkt_countries VALUES (77,'Габон','Russian','GA','GAB','');

INSERT INTO emkt_regions VALUES(1179, 77, 'ES', 'Estuaire', 'Russian');
INSERT INTO emkt_regions VALUES(1180, 77, 'HO', 'Haut-Ogooue', 'Russian');
INSERT INTO emkt_regions VALUES(1181, 77, 'MO', 'Moyen-Ogooue', 'Russian');
INSERT INTO emkt_regions VALUES(1182, 77, 'NG', 'Ngounie', 'Russian');
INSERT INTO emkt_regions VALUES(1183, 77, 'NY', 'Nyanga', 'Russian');
INSERT INTO emkt_regions VALUES(1184, 77, 'OI', 'Ogooue-Ivindo', 'Russian');
INSERT INTO emkt_regions VALUES(1185, 77, 'OL', 'Ogooue-Lolo', 'Russian');
INSERT INTO emkt_regions VALUES(1186, 77, 'OM', 'Ogooue-Maritime', 'Russian');
INSERT INTO emkt_regions VALUES(1187, 77, 'WN', 'Woleu-Ntem', 'Russian');

INSERT INTO emkt_countries VALUES (78,'Гамбия','Russian','GM','GMB','');

INSERT INTO emkt_regions VALUES(1188, 78, 'AH', 'Ashanti', 'Russian');
INSERT INTO emkt_regions VALUES(1189, 78, 'BA', 'Brong-Ahafo', 'Russian');
INSERT INTO emkt_regions VALUES(1190, 78, 'CP', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(1191, 78, 'EP', 'Eastern', 'Russian');
INSERT INTO emkt_regions VALUES(1192, 78, 'AA', 'Greater Accra', 'Russian');
INSERT INTO emkt_regions VALUES(1193, 78, 'NP', 'Northern', 'Russian');
INSERT INTO emkt_regions VALUES(1194, 78, 'UE', 'Upper East', 'Russian');
INSERT INTO emkt_regions VALUES(1195, 78, 'UW', 'Upper West', 'Russian');
INSERT INTO emkt_regions VALUES(1196, 78, 'TV', 'Volta', 'Russian');
INSERT INTO emkt_regions VALUES(1197, 78, 'WP', 'Western', 'Russian');

INSERT INTO emkt_countries VALUES (79,'Грузия','Russian','GE','GEO','');

INSERT INTO emkt_regions VALUES(1198, 79, 'AB', 'აფხაზეთი', 'Russian');
INSERT INTO emkt_regions VALUES(1199, 79, 'AJ', 'აჭარა', 'Russian');
INSERT INTO emkt_regions VALUES(1200, 79, 'GU', 'გურია', 'Russian');
INSERT INTO emkt_regions VALUES(1201, 79, 'IM', 'იმერეთი', 'Russian');
INSERT INTO emkt_regions VALUES(1202, 79, 'KA', 'კახეთი', 'Russian');
INSERT INTO emkt_regions VALUES(1203, 79, 'KK', 'ქვემო ქართლი', 'Russian');
INSERT INTO emkt_regions VALUES(1204, 79, 'MM', 'მცხეთა-მთიანეთი', 'Russian');
INSERT INTO emkt_regions VALUES(1205, 79, 'RL', 'რაჭა-ლეჩხუმი და ქვემო სვანეთი', 'Russian');
INSERT INTO emkt_regions VALUES(1206, 79, 'SJ', 'სამცხე-ჯავახეთი', 'Russian');
INSERT INTO emkt_regions VALUES(1207, 79, 'SK', 'შიდა ქართლი', 'Russian');
INSERT INTO emkt_regions VALUES(1208, 79, 'SZ', 'სამეგრელო-ზემო სვანეთი', 'Russian');
INSERT INTO emkt_regions VALUES(1209, 79, 'TB', 'თბილისი', 'Russian');

INSERT INTO emkt_countries VALUES (80,'Германия','Russian','DE','DEU','');

INSERT INTO emkt_regions VALUES(1210, 80, 'BE', 'Berlin', 'Russian');
INSERT INTO emkt_regions VALUES(1211, 80, 'BR', 'Brandenburg', 'Russian');
INSERT INTO emkt_regions VALUES(1212, 80, 'BW', 'Baden-Württemberg', 'Russian');
INSERT INTO emkt_regions VALUES(1213, 80, 'BY', 'Bayern', 'Russian');
INSERT INTO emkt_regions VALUES(1214, 80, 'HB', 'Bremen', 'Russian');
INSERT INTO emkt_regions VALUES(1215, 80, 'HE', 'Hessen', 'Russian');
INSERT INTO emkt_regions VALUES(1216, 80, 'HH', 'Hamburg', 'Russian');
INSERT INTO emkt_regions VALUES(1217, 80, 'MV', 'Mecklenburg-Vorpommern', 'Russian');
INSERT INTO emkt_regions VALUES(1218, 80, 'NI', 'Niedersachsen', 'Russian');
INSERT INTO emkt_regions VALUES(1219, 80, 'NW', 'Nordrhein-Westfalen', 'Russian');
INSERT INTO emkt_regions VALUES(1220, 80, 'RP', 'Rheinland-Pfalz', 'Russian');
INSERT INTO emkt_regions VALUES(1221, 80, 'SH', 'Schleswig-Holstein', 'Russian');
INSERT INTO emkt_regions VALUES(1222, 80, 'SL', 'Saarland', 'Russian');
INSERT INTO emkt_regions VALUES(1223, 80, 'SN', 'Sachsen', 'Russian');
INSERT INTO emkt_regions VALUES(1224, 80, 'ST', 'Sachsen-Anhalt', 'Russian');
INSERT INTO emkt_regions VALUES(1225, 80, 'TH', 'Thüringen', 'Russian');

INSERT INTO emkt_countries VALUES (81,'Гана','Russian','GH','GHA','');

INSERT INTO emkt_regions VALUES(1226, 81, 'AA', 'Greater Accra', 'Russian');
INSERT INTO emkt_regions VALUES(1227, 81, 'AH', 'Ashanti', 'Russian');
INSERT INTO emkt_regions VALUES(1228, 81, 'BA', 'Brong-Ahafo', 'Russian');
INSERT INTO emkt_regions VALUES(1229, 81, 'CP', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(1230, 81, 'EP', 'Eastern', 'Russian');
INSERT INTO emkt_regions VALUES(1231, 81, 'NP', 'Northern', 'Russian');
INSERT INTO emkt_regions VALUES(1232, 81, 'TV', 'Volta', 'Russian');
INSERT INTO emkt_regions VALUES(1233, 81, 'UE', 'Upper East', 'Russian');
INSERT INTO emkt_regions VALUES(1234, 81, 'UW', 'Upper West', 'Russian');
INSERT INTO emkt_regions VALUES(1235, 81, 'WP', 'Western', 'Russian');

INSERT INTO emkt_countries VALUES (82,'Гибралтар','Russian','GI','GIB','');

INSERT INTO emkt_regions VALUES(4260, 82, 'NOCODE', 'Gibraltar', 'Russian');

INSERT INTO emkt_countries VALUES (83,'Греция','Russian','GR','GRC','');

INSERT INTO emkt_regions VALUES(1236, 83, '01', 'Αιτωλοακαρνανία', 'Russian');
INSERT INTO emkt_regions VALUES(1237, 83, '03', 'Βοιωτία', 'Russian');
INSERT INTO emkt_regions VALUES(1238, 83, '04', 'Εύβοια', 'Russian');
INSERT INTO emkt_regions VALUES(1239, 83, '05', 'Ευρυτανία', 'Russian');
INSERT INTO emkt_regions VALUES(1240, 83, '06', 'Φθιώτιδα', 'Russian');
INSERT INTO emkt_regions VALUES(1241, 83, '07', 'Φωκίδα', 'Russian');
INSERT INTO emkt_regions VALUES(1242, 83, '11', 'Αργολίδα', 'Russian');
INSERT INTO emkt_regions VALUES(1243, 83, '12', 'Αρκαδία', 'Russian');
INSERT INTO emkt_regions VALUES(1244, 83, '13', 'Ἀχαΐα', 'Russian');
INSERT INTO emkt_regions VALUES(1245, 83, '14', 'Ηλεία', 'Russian');
INSERT INTO emkt_regions VALUES(1246, 83, '15', 'Κορινθία', 'Russian');
INSERT INTO emkt_regions VALUES(1247, 83, '16', 'Λακωνία', 'Russian');
INSERT INTO emkt_regions VALUES(1248, 83, '17', 'Μεσσηνία', 'Russian');
INSERT INTO emkt_regions VALUES(1249, 83, '21', 'Ζάκυνθος', 'Russian');
INSERT INTO emkt_regions VALUES(1250, 83, '22', 'Κέρκυρα', 'Russian');
INSERT INTO emkt_regions VALUES(1251, 83, '23', 'Κεφαλλονιά', 'Russian');
INSERT INTO emkt_regions VALUES(1252, 83, '24', 'Λευκάδα', 'Russian');
INSERT INTO emkt_regions VALUES(1253, 83, '31', 'Άρτα', 'Russian');
INSERT INTO emkt_regions VALUES(1254, 83, '32', 'Θεσπρωτία', 'Russian');
INSERT INTO emkt_regions VALUES(1255, 83, '33', 'Ιωάννινα', 'Russian');
INSERT INTO emkt_regions VALUES(1256, 83, '34', 'Πρεβεζα', 'Russian');
INSERT INTO emkt_regions VALUES(1257, 83, '41', 'Καρδίτσα', 'Russian');
INSERT INTO emkt_regions VALUES(1258, 83, '42', 'Λάρισα', 'Russian');
INSERT INTO emkt_regions VALUES(1259, 83, '43', 'Μαγνησία', 'Russian');
INSERT INTO emkt_regions VALUES(1260, 83, '44', 'Τρίκαλα', 'Russian');
INSERT INTO emkt_regions VALUES(1261, 83, '51', 'Γρεβενά', 'Russian');
INSERT INTO emkt_regions VALUES(1262, 83, '52', 'Δράμα', 'Russian');
INSERT INTO emkt_regions VALUES(1263, 83, '53', 'Ημαθία', 'Russian');
INSERT INTO emkt_regions VALUES(1264, 83, '54', 'Θεσσαλονίκη', 'Russian');
INSERT INTO emkt_regions VALUES(1265, 83, '55', 'Καβάλα', 'Russian');
INSERT INTO emkt_regions VALUES(1266, 83, '56', 'Καστοριά', 'Russian');
INSERT INTO emkt_regions VALUES(1267, 83, '57', 'Κιλκίς', 'Russian');
INSERT INTO emkt_regions VALUES(1268, 83, '58', 'Κοζάνη', 'Russian');
INSERT INTO emkt_regions VALUES(1269, 83, '59', 'Πέλλα', 'Russian');
INSERT INTO emkt_regions VALUES(1270, 83, '61', 'Πιερία', 'Russian');
INSERT INTO emkt_regions VALUES(1271, 83, '62', 'Σερρών', 'Russian');
INSERT INTO emkt_regions VALUES(1272, 83, '63', 'Φλώρινα', 'Russian');
INSERT INTO emkt_regions VALUES(1273, 83, '64', 'Χαλκιδική', 'Russian');
INSERT INTO emkt_regions VALUES(1274, 83, '69', 'Όρος Άθως', 'Russian');
INSERT INTO emkt_regions VALUES(1275, 83, '71', 'Έβρος', 'Russian');
INSERT INTO emkt_regions VALUES(1276, 83, '72', 'Ξάνθη', 'Russian');
INSERT INTO emkt_regions VALUES(1277, 83, '73', 'Ροδόπη', 'Russian');
INSERT INTO emkt_regions VALUES(1278, 83, '81', 'Δωδεκάνησα', 'Russian');
INSERT INTO emkt_regions VALUES(1279, 83, '82', 'Κυκλάδες', 'Russian');
INSERT INTO emkt_regions VALUES(1280, 83, '83', 'Λέσβου', 'Russian');
INSERT INTO emkt_regions VALUES(1281, 83, '84', 'Σάμος', 'Russian');
INSERT INTO emkt_regions VALUES(1282, 83, '85', 'Χίος', 'Russian');
INSERT INTO emkt_regions VALUES(1283, 83, '91', 'Ηράκλειο', 'Russian');
INSERT INTO emkt_regions VALUES(1284, 83, '92', 'Λασίθι', 'Russian');
INSERT INTO emkt_regions VALUES(1285, 83, '93', 'Ρεθύμνο', 'Russian');
INSERT INTO emkt_regions VALUES(1286, 83, '94', 'Χανίων', 'Russian');
INSERT INTO emkt_regions VALUES(1287, 83, 'A1', 'Αττική', 'Russian');

INSERT INTO emkt_countries VALUES (84,'Гренландия','Russian','GL','GRL','');

INSERT INTO emkt_regions VALUES(1288, 84, 'A', 'Avannaa', 'Russian');
INSERT INTO emkt_regions VALUES(1289, 84, 'T', 'Tunu ', 'Russian');
INSERT INTO emkt_regions VALUES(1290, 84, 'K', 'Kitaa', 'Russian');

INSERT INTO emkt_countries VALUES (85,'Гренада','Russian','GD','GRD','');

INSERT INTO emkt_regions VALUES(1291, 85, 'A', 'Saint Andrew', 'Russian');
INSERT INTO emkt_regions VALUES(1292, 85, 'D', 'Saint David', 'Russian');
INSERT INTO emkt_regions VALUES(1293, 85, 'G', 'Saint George', 'Russian');
INSERT INTO emkt_regions VALUES(1294, 85, 'J', 'Saint John', 'Russian');
INSERT INTO emkt_regions VALUES(1295, 85, 'M', 'Saint Mark', 'Russian');
INSERT INTO emkt_regions VALUES(1296, 85, 'P', 'Saint Patrick', 'Russian');

INSERT INTO emkt_countries VALUES (86,'Гваделупа','Russian','GP','GLP','');

INSERT INTO emkt_regions VALUES(4261, 86, 'NOCODE', 'Guadeloupe', 'Russian');

INSERT INTO emkt_countries VALUES (87,'Гуам','Russian','GU','GUM','');

INSERT INTO emkt_regions VALUES(4262, 87, 'NOCODE', 'Guam', 'Russian');

INSERT INTO emkt_countries VALUES (88,'Гватемала','Russian','GT','GTM','');

INSERT INTO emkt_regions VALUES(1297, 88, 'AV', 'Alta Verapaz', 'Russian');
INSERT INTO emkt_regions VALUES(1298, 88, 'BV', 'Baja Verapaz', 'Russian');
INSERT INTO emkt_regions VALUES(1299, 88, 'CM', 'Chimaltenango', 'Russian');
INSERT INTO emkt_regions VALUES(1300, 88, 'CQ', 'Chiquimula', 'Russian');
INSERT INTO emkt_regions VALUES(1301, 88, 'ES', 'Escuintla', 'Russian');
INSERT INTO emkt_regions VALUES(1302, 88, 'GU', 'Guatemala', 'Russian');
INSERT INTO emkt_regions VALUES(1303, 88, 'HU', 'Huehuetenango', 'Russian');
INSERT INTO emkt_regions VALUES(1304, 88, 'IZ', 'Izabal', 'Russian');
INSERT INTO emkt_regions VALUES(1305, 88, 'JA', 'Jalapa', 'Russian');
INSERT INTO emkt_regions VALUES(1306, 88, 'JU', 'Jutiapa', 'Russian');
INSERT INTO emkt_regions VALUES(1307, 88, 'PE', 'El Petén', 'Russian');
INSERT INTO emkt_regions VALUES(1308, 88, 'PR', 'El Progreso', 'Russian');
INSERT INTO emkt_regions VALUES(1309, 88, 'QC', 'El Quiché', 'Russian');
INSERT INTO emkt_regions VALUES(1310, 88, 'QZ', 'Quetzaltenango', 'Russian');
INSERT INTO emkt_regions VALUES(1311, 88, 'RE', 'Retalhuleu', 'Russian');
INSERT INTO emkt_regions VALUES(1312, 88, 'SA', 'Sacatepéquez', 'Russian');
INSERT INTO emkt_regions VALUES(1313, 88, 'SM', 'San Marcos', 'Russian');
INSERT INTO emkt_regions VALUES(1314, 88, 'SO', 'Sololá', 'Russian');
INSERT INTO emkt_regions VALUES(1315, 88, 'SR', 'Santa Rosa', 'Russian');
INSERT INTO emkt_regions VALUES(1316, 88, 'SU', 'Suchitepéquez', 'Russian');
INSERT INTO emkt_regions VALUES(1317, 88, 'TO', 'Totonicapán', 'Russian');
INSERT INTO emkt_regions VALUES(1318, 88, 'ZA', 'Zacapa', 'Russian');

INSERT INTO emkt_countries VALUES (89,'Гвинея','Russian','GN','GIN','');

INSERT INTO emkt_regions VALUES(1319, 89, 'BE', 'Beyla', 'Russian');
INSERT INTO emkt_regions VALUES(1320, 89, 'BF', 'Boffa', 'Russian');
INSERT INTO emkt_regions VALUES(1321, 89, 'BK', 'Boké', 'Russian');
INSERT INTO emkt_regions VALUES(1322, 89, 'CO', 'Coyah', 'Russian');
INSERT INTO emkt_regions VALUES(1323, 89, 'DB', 'Dabola', 'Russian');
INSERT INTO emkt_regions VALUES(1324, 89, 'DI', 'Dinguiraye', 'Russian');
INSERT INTO emkt_regions VALUES(1325, 89, 'DL', 'Dalaba', 'Russian');
INSERT INTO emkt_regions VALUES(1326, 89, 'DU', 'Dubréka', 'Russian');
INSERT INTO emkt_regions VALUES(1327, 89, 'FA', 'Faranah', 'Russian');
INSERT INTO emkt_regions VALUES(1328, 89, 'FO', 'Forécariah', 'Russian');
INSERT INTO emkt_regions VALUES(1329, 89, 'FR', 'Fria', 'Russian');
INSERT INTO emkt_regions VALUES(1330, 89, 'GA', 'Gaoual', 'Russian');
INSERT INTO emkt_regions VALUES(1331, 89, 'GU', 'Guékédou', 'Russian');
INSERT INTO emkt_regions VALUES(1332, 89, 'KA', 'Kankan', 'Russian');
INSERT INTO emkt_regions VALUES(1333, 89, 'KB', 'Koubia', 'Russian');
INSERT INTO emkt_regions VALUES(1334, 89, 'KD', 'Kindia', 'Russian');
INSERT INTO emkt_regions VALUES(1335, 89, 'KE', 'Kérouané', 'Russian');
INSERT INTO emkt_regions VALUES(1336, 89, 'KN', 'Koundara', 'Russian');
INSERT INTO emkt_regions VALUES(1337, 89, 'KO', 'Kouroussa', 'Russian');
INSERT INTO emkt_regions VALUES(1338, 89, 'KS', 'Kissidougou', 'Russian');
INSERT INTO emkt_regions VALUES(1339, 89, 'LA', 'Labé', 'Russian');
INSERT INTO emkt_regions VALUES(1340, 89, 'LE', 'Lélouma', 'Russian');
INSERT INTO emkt_regions VALUES(1341, 89, 'LO', 'Lola', 'Russian');
INSERT INTO emkt_regions VALUES(1342, 89, 'MC', 'Macenta', 'Russian');
INSERT INTO emkt_regions VALUES(1343, 89, 'MD', 'Mandiana', 'Russian');
INSERT INTO emkt_regions VALUES(1344, 89, 'ML', 'Mali', 'Russian');
INSERT INTO emkt_regions VALUES(1345, 89, 'MM', 'Mamou', 'Russian');
INSERT INTO emkt_regions VALUES(1346, 89, 'NZ', 'Nzérékoré', 'Russian');
INSERT INTO emkt_regions VALUES(1347, 89, 'PI', 'Pita', 'Russian');
INSERT INTO emkt_regions VALUES(1348, 89, 'SI', 'Siguiri', 'Russian');
INSERT INTO emkt_regions VALUES(1349, 89, 'TE', 'Télimélé', 'Russian');
INSERT INTO emkt_regions VALUES(1350, 89, 'TO', 'Tougué', 'Russian');
INSERT INTO emkt_regions VALUES(1351, 89, 'YO', 'Yomou', 'Russian');

INSERT INTO emkt_countries VALUES (90,'Гвинея-Бисау','Russian','GW','GNB','');

INSERT INTO emkt_regions VALUES(1352, 90, 'BF', 'Bafata', 'Russian');
INSERT INTO emkt_regions VALUES(1353, 90, 'BB', 'Biombo', 'Russian');
INSERT INTO emkt_regions VALUES(1354, 90, 'BS', 'Bissau', 'Russian');
INSERT INTO emkt_regions VALUES(1355, 90, 'BL', 'Bolama', 'Russian');
INSERT INTO emkt_regions VALUES(1356, 90, 'CA', 'Cacheu', 'Russian');
INSERT INTO emkt_regions VALUES(1357, 90, 'GA', 'Gabu', 'Russian');
INSERT INTO emkt_regions VALUES(1358, 90, 'OI', 'Oio', 'Russian');
INSERT INTO emkt_regions VALUES(1359, 90, 'QU', 'Quinara', 'Russian');
INSERT INTO emkt_regions VALUES(1360, 90, 'TO', 'Tombali', 'Russian');

INSERT INTO emkt_countries VALUES (91,'Гайана','Russian','GY','GUY','');

INSERT INTO emkt_regions VALUES(1361, 91, 'BA', 'Barima-Waini', 'Russian');
INSERT INTO emkt_regions VALUES(1362, 91, 'CU', 'Cuyuni-Mazaruni', 'Russian');
INSERT INTO emkt_regions VALUES(1363, 91, 'DE', 'Demerara-Mahaica', 'Russian');
INSERT INTO emkt_regions VALUES(1364, 91, 'EB', 'East Berbice-Corentyne', 'Russian');
INSERT INTO emkt_regions VALUES(1365, 91, 'ES', 'Essequibo Islands-West Demerara', 'Russian');
INSERT INTO emkt_regions VALUES(1366, 91, 'MA', 'Mahaica-Berbice', 'Russian');
INSERT INTO emkt_regions VALUES(1367, 91, 'PM', 'Pomeroon-Supenaam', 'Russian');
INSERT INTO emkt_regions VALUES(1368, 91, 'PT', 'Potaro-Siparuni', 'Russian');
INSERT INTO emkt_regions VALUES(1369, 91, 'UD', 'Upper Demerara-Berbice', 'Russian');
INSERT INTO emkt_regions VALUES(1370, 91, 'UT', 'Upper Takutu-Upper Essequibo', 'Russian');

INSERT INTO emkt_countries VALUES (92,'Гаити','Russian','HT','HTI','');

INSERT INTO emkt_regions VALUES(1371, 92, 'AR', 'Artibonite', 'Russian');
INSERT INTO emkt_regions VALUES(1372, 92, 'CE', 'Centre', 'Russian');
INSERT INTO emkt_regions VALUES(1373, 92, 'GA', 'Grand\'Anse', 'Russian');
INSERT INTO emkt_regions VALUES(1374, 92, 'NI', 'Nippes', 'Russian');
INSERT INTO emkt_regions VALUES(1375, 92, 'ND', 'Nord', 'Russian');
INSERT INTO emkt_regions VALUES(1376, 92, 'NE', 'Nord-Est', 'Russian');
INSERT INTO emkt_regions VALUES(1377, 92, 'NO', 'Nord-Ouest', 'Russian');
INSERT INTO emkt_regions VALUES(1378, 92, 'OU', 'Ouest', 'Russian');
INSERT INTO emkt_regions VALUES(1379, 92, 'SD', 'Sud', 'Russian');
INSERT INTO emkt_regions VALUES(1380, 92, 'SE', 'Sud-Est', 'Russian');

INSERT INTO emkt_countries VALUES (93,'Остров Херд и острова Макдональд','Russian','HM','HMD','');

INSERT INTO emkt_regions VALUES(1381, 93, 'F', 'Flat Island', 'Russian');
INSERT INTO emkt_regions VALUES(1382, 93, 'M', 'McDonald Island', 'Russian');
INSERT INTO emkt_regions VALUES(1383, 93, 'S', 'Shag Island', 'Russian');
INSERT INTO emkt_regions VALUES(1384, 93, 'H', 'Heard Island', 'Russian');

INSERT INTO emkt_countries VALUES (94,'Гондурас','Russian','HN','HND','');

INSERT INTO emkt_regions VALUES(1385, 94, 'AT', 'Atlántida', 'Russian');
INSERT INTO emkt_regions VALUES(1386, 94, 'CH', 'Choluteca', 'Russian');
INSERT INTO emkt_regions VALUES(1387, 94, 'CL', 'Colón', 'Russian');
INSERT INTO emkt_regions VALUES(1388, 94, 'CM', 'Comayagua', 'Russian');
INSERT INTO emkt_regions VALUES(1389, 94, 'CP', 'Copán', 'Russian');
INSERT INTO emkt_regions VALUES(1390, 94, 'CR', 'Cortés', 'Russian');
INSERT INTO emkt_regions VALUES(1391, 94, 'EP', 'El Paraíso', 'Russian');
INSERT INTO emkt_regions VALUES(1392, 94, 'FM', 'Francisco Morazán', 'Russian');
INSERT INTO emkt_regions VALUES(1393, 94, 'GD', 'Gracias a Dios', 'Russian');
INSERT INTO emkt_regions VALUES(1394, 94, 'IB', 'Islas de la Bahía', 'Russian');
INSERT INTO emkt_regions VALUES(1395, 94, 'IN', 'Intibucá', 'Russian');
INSERT INTO emkt_regions VALUES(1396, 94, 'LE', 'Lempira', 'Russian');
INSERT INTO emkt_regions VALUES(1397, 94, 'LP', 'La Paz', 'Russian');
INSERT INTO emkt_regions VALUES(1398, 94, 'OC', 'Ocotepeque', 'Russian');
INSERT INTO emkt_regions VALUES(1399, 94, 'OL', 'Olancho', 'Russian');
INSERT INTO emkt_regions VALUES(1400, 94, 'SB', 'Santa Bárbara', 'Russian');
INSERT INTO emkt_regions VALUES(1401, 94, 'VA', 'Valle', 'Russian');
INSERT INTO emkt_regions VALUES(1402, 94, 'YO', 'Yoro', 'Russian');

INSERT INTO emkt_countries VALUES (95,'Гонконг','Russian','HK','HKG','');

INSERT INTO emkt_regions VALUES(1403, 95, 'HCW', '中西區', 'Russian');
INSERT INTO emkt_regions VALUES(1404, 95, 'HEA', '東區', 'Russian');
INSERT INTO emkt_regions VALUES(1405, 95, 'HSO', '南區', 'Russian');
INSERT INTO emkt_regions VALUES(1406, 95, 'HWC', '灣仔區', 'Russian');
INSERT INTO emkt_regions VALUES(1407, 95, 'KKC', '九龍城區', 'Russian');
INSERT INTO emkt_regions VALUES(1408, 95, 'KKT', '觀塘區', 'Russian');
INSERT INTO emkt_regions VALUES(1409, 95, 'KSS', '深水埗區', 'Russian');
INSERT INTO emkt_regions VALUES(1410, 95, 'KWT', '黃大仙區', 'Russian');
INSERT INTO emkt_regions VALUES(1411, 95, 'KYT', '油尖旺區', 'Russian');
INSERT INTO emkt_regions VALUES(1412, 95, 'NIS', '離島區', 'Russian');
INSERT INTO emkt_regions VALUES(1413, 95, 'NKT', '葵青區', 'Russian');
INSERT INTO emkt_regions VALUES(1414, 95, 'NNO', '北區', 'Russian');
INSERT INTO emkt_regions VALUES(1415, 95, 'NSK', '西貢區', 'Russian');
INSERT INTO emkt_regions VALUES(1416, 95, 'NST', '沙田區', 'Russian');
INSERT INTO emkt_regions VALUES(1417, 95, 'NTP', '大埔區', 'Russian');
INSERT INTO emkt_regions VALUES(1418, 95, 'NTW', '荃灣區', 'Russian');
INSERT INTO emkt_regions VALUES(1419, 95, 'NTM', '屯門區', 'Russian');
INSERT INTO emkt_regions VALUES(1420, 95, 'NYL', '元朗區', 'Russian');

INSERT INTO emkt_countries VALUES (96,'Венгрия','Russian','HU','HUN','');

INSERT INTO emkt_regions VALUES(1421, 96, 'BA', 'Baranja megye', 'Russian');
INSERT INTO emkt_regions VALUES(1422, 96, 'BC', 'Békéscsaba', 'Russian');
INSERT INTO emkt_regions VALUES(1423, 96, 'BE', 'Békés megye', 'Russian');
INSERT INTO emkt_regions VALUES(1424, 96, 'BK', 'Bács-Kiskun megye', 'Russian');
INSERT INTO emkt_regions VALUES(1425, 96, 'BU', 'Budapest', 'Russian');
INSERT INTO emkt_regions VALUES(1426, 96, 'BZ', 'Borsod-Abaúj-Zemplén megye', 'Russian');
INSERT INTO emkt_regions VALUES(1427, 96, 'CS', 'Csongrád megye', 'Russian');
INSERT INTO emkt_regions VALUES(1428, 96, 'DE', 'Debrecen', 'Russian');
INSERT INTO emkt_regions VALUES(1429, 96, 'DU', 'Dunaújváros', 'Russian');
INSERT INTO emkt_regions VALUES(1430, 96, 'EG', 'Eger', 'Russian');
INSERT INTO emkt_regions VALUES(1431, 96, 'FE', 'Fejér megye', 'Russian');
INSERT INTO emkt_regions VALUES(1432, 96, 'GS', 'Győr-Moson-Sopron megye', 'Russian');
INSERT INTO emkt_regions VALUES(1433, 96, 'GY', 'Győr', 'Russian');
INSERT INTO emkt_regions VALUES(1434, 96, 'HB', 'Hajdú-Bihar megye', 'Russian');
INSERT INTO emkt_regions VALUES(1435, 96, 'HE', 'Heves megye', 'Russian');
INSERT INTO emkt_regions VALUES(1436, 96, 'HV', 'Hódmezővásárhely', 'Russian');
INSERT INTO emkt_regions VALUES(1437, 96, 'JN', 'Jász-Nagykun-Szolnok megye', 'Russian');
INSERT INTO emkt_regions VALUES(1438, 96, 'KE', 'Komárom-Esztergom megye', 'Russian');
INSERT INTO emkt_regions VALUES(1439, 96, 'KM', 'Kecskemét', 'Russian');
INSERT INTO emkt_regions VALUES(1440, 96, 'KV', 'Kaposvár', 'Russian');
INSERT INTO emkt_regions VALUES(1441, 96, 'MI', 'Miskolc', 'Russian');
INSERT INTO emkt_regions VALUES(1442, 96, 'NK', 'Nagykanizsa', 'Russian');
INSERT INTO emkt_regions VALUES(1443, 96, 'NO', 'Nógrád megye', 'Russian');
INSERT INTO emkt_regions VALUES(1444, 96, 'NY', 'Nyíregyháza', 'Russian');
INSERT INTO emkt_regions VALUES(1445, 96, 'PE', 'Pest megye', 'Russian');
INSERT INTO emkt_regions VALUES(1446, 96, 'PS', 'Pécs', 'Russian');
INSERT INTO emkt_regions VALUES(1447, 96, 'SD', 'Szeged', 'Russian');
INSERT INTO emkt_regions VALUES(1448, 96, 'SF', 'Székesfehérvár', 'Russian');
INSERT INTO emkt_regions VALUES(1449, 96, 'SH', 'Szombathely', 'Russian');
INSERT INTO emkt_regions VALUES(1450, 96, 'SK', 'Szolnok', 'Russian');
INSERT INTO emkt_regions VALUES(1451, 96, 'SN', 'Sopron', 'Russian');
INSERT INTO emkt_regions VALUES(1452, 96, 'SO', 'Somogy megye', 'Russian');
INSERT INTO emkt_regions VALUES(1453, 96, 'SS', 'Szekszárd', 'Russian');
INSERT INTO emkt_regions VALUES(1454, 96, 'ST', 'Salgótarján', 'Russian');
INSERT INTO emkt_regions VALUES(1455, 96, 'SZ', 'Szabolcs-Szatmár-Bereg megye', 'Russian');
INSERT INTO emkt_regions VALUES(1456, 96, 'TB', 'Tatabánya', 'Russian');
INSERT INTO emkt_regions VALUES(1457, 96, 'TO', 'Tolna megye', 'Russian');
INSERT INTO emkt_regions VALUES(1458, 96, 'VA', 'Vas megye', 'Russian');
INSERT INTO emkt_regions VALUES(1459, 96, 'VE', 'Veszprém megye', 'Russian');
INSERT INTO emkt_regions VALUES(1460, 96, 'VM', 'Veszprém', 'Russian');
INSERT INTO emkt_regions VALUES(1461, 96, 'ZA', 'Zala megye', 'Russian');
INSERT INTO emkt_regions VALUES(1462, 96, 'ZE', 'Zalaegerszeg', 'Russian');

INSERT INTO emkt_countries VALUES (97,'Исландия','Russian','IS','ISL','');

INSERT INTO emkt_regions VALUES(1463, 97, '1', 'Höfuðborgarsvæðið', 'Russian');
INSERT INTO emkt_regions VALUES(1464, 97, '2', 'Suðurnes', 'Russian');
INSERT INTO emkt_regions VALUES(1465, 97, '3', 'Vesturland', 'Russian');
INSERT INTO emkt_regions VALUES(1466, 97, '4', 'Vestfirðir', 'Russian');
INSERT INTO emkt_regions VALUES(1467, 97, '5', 'Norðurland vestra', 'Russian');
INSERT INTO emkt_regions VALUES(1468, 97, '6', 'Norðurland eystra', 'Russian');
INSERT INTO emkt_regions VALUES(1469, 97, '7', 'Austfirðir', 'Russian');
INSERT INTO emkt_regions VALUES(1470, 97, '8', 'Suðurland', 'Russian');

INSERT INTO emkt_countries VALUES (98,'Индия','Russian','IN','IND','');

INSERT INTO emkt_regions VALUES(1471, 98, 'IN-AN', 'अंडमान और निकोबार द्वीप', 'Russian');
INSERT INTO emkt_regions VALUES(1472, 98, 'IN-AP', 'ఆంధ్ర ప్రదేశ్', 'Russian');
INSERT INTO emkt_regions VALUES(1473, 98, 'IN-AR', 'अरुणाचल प्रदेश', 'Russian');
INSERT INTO emkt_regions VALUES(1474, 98, 'IN-AS', 'অসম', 'Russian');
INSERT INTO emkt_regions VALUES(1475, 98, 'IN-BR', 'बिहार', 'Russian');
INSERT INTO emkt_regions VALUES(1476, 98, 'IN-CH', 'चंडीगढ़', 'Russian');
INSERT INTO emkt_regions VALUES(1477, 98, 'IN-CT', 'छत्तीसगढ़', 'Russian');
INSERT INTO emkt_regions VALUES(1478, 98, 'IN-DD', 'દમણ અને દિવ', 'Russian');
INSERT INTO emkt_regions VALUES(1479, 98, 'IN-DL', 'दिल्ली', 'Russian');
INSERT INTO emkt_regions VALUES(1480, 98, 'IN-DN', 'દાદરા અને નગર હવેલી', 'Russian');
INSERT INTO emkt_regions VALUES(1481, 98, 'IN-GA', 'गोंय', 'Russian');
INSERT INTO emkt_regions VALUES(1482, 98, 'IN-GJ', 'ગુજરાત', 'Russian');
INSERT INTO emkt_regions VALUES(1483, 98, 'IN-HP', 'हिमाचल प्रदेश', 'Russian');
INSERT INTO emkt_regions VALUES(1484, 98, 'IN-HR', 'हरियाणा', 'Russian');
INSERT INTO emkt_regions VALUES(1485, 98, 'IN-JH', 'झारखंड', 'Russian');
INSERT INTO emkt_regions VALUES(1486, 98, 'IN-JK', 'जम्मू और कश्मीर', 'Russian');
INSERT INTO emkt_regions VALUES(1487, 98, 'IN-KA', 'ಕನಾ೯ಟಕ', 'Russian');
INSERT INTO emkt_regions VALUES(1488, 98, 'IN-KL', 'കേരളം', 'Russian');
INSERT INTO emkt_regions VALUES(1489, 98, 'IN-LD', 'ലക്ഷദ്വീപ്', 'Russian');
INSERT INTO emkt_regions VALUES(1490, 98, 'IN-ML', 'मेघालय', 'Russian');
INSERT INTO emkt_regions VALUES(1491, 98, 'IN-MH', 'महाराष्ट्र', 'Russian');
INSERT INTO emkt_regions VALUES(1492, 98, 'IN-MN', 'मणिपुर', 'Russian');
INSERT INTO emkt_regions VALUES(1493, 98, 'IN-MP', 'मध्य प्रदेश', 'Russian');
INSERT INTO emkt_regions VALUES(1494, 98, 'IN-MZ', 'मिज़ोरम', 'Russian');
INSERT INTO emkt_regions VALUES(1495, 98, 'IN-NL', 'नागालैंड', 'Russian');
INSERT INTO emkt_regions VALUES(1496, 98, 'IN-OR', 'उड़ीसा', 'Russian');
INSERT INTO emkt_regions VALUES(1497, 98, 'IN-PB', 'ਪੰਜਾਬ', 'Russian');
INSERT INTO emkt_regions VALUES(1498, 98, 'IN-PY', 'புதுச்சேரி', 'Russian');
INSERT INTO emkt_regions VALUES(1499, 98, 'IN-RJ', 'राजस्थान', 'Russian');
INSERT INTO emkt_regions VALUES(1500, 98, 'IN-SK', 'सिक्किम', 'Russian');
INSERT INTO emkt_regions VALUES(1501, 98, 'IN-TN', 'தமிழ் நாடு', 'Russian');
INSERT INTO emkt_regions VALUES(1502, 98, 'IN-TR', 'ত্রিপুরা', 'Russian');
INSERT INTO emkt_regions VALUES(1503, 98, 'IN-UL', 'उत्तरांचल', 'Russian');
INSERT INTO emkt_regions VALUES(1504, 98, 'IN-UP', 'उत्तर प्रदेश', 'Russian');
INSERT INTO emkt_regions VALUES(1505, 98, 'IN-WB', 'পশ্চিমবঙ্গ', 'Russian');

INSERT INTO emkt_countries VALUES (99,'Индонезия','Russian','ID','IDN','');

INSERT INTO emkt_regions VALUES(1506, 99, 'AC', 'Aceh', 'Russian');
INSERT INTO emkt_regions VALUES(1507, 99, 'BA', 'Bali', 'Russian');
INSERT INTO emkt_regions VALUES(1508, 99, 'BB', 'Bangka-Belitung', 'Russian');
INSERT INTO emkt_regions VALUES(1509, 99, 'BE', 'Bengkulu', 'Russian');
INSERT INTO emkt_regions VALUES(1510, 99, 'BT', 'Banten', 'Russian');
INSERT INTO emkt_regions VALUES(1511, 99, 'GO', 'Gorontalo', 'Russian');
INSERT INTO emkt_regions VALUES(1512, 99, 'IJ', 'Papua', 'Russian');
INSERT INTO emkt_regions VALUES(1513, 99, 'JA', 'Jambi', 'Russian');
INSERT INTO emkt_regions VALUES(1514, 99, 'JI', 'Jawa Timur', 'Russian');
INSERT INTO emkt_regions VALUES(1515, 99, 'JK', 'Jakarta Raya', 'Russian');
INSERT INTO emkt_regions VALUES(1516, 99, 'JR', 'Jawa Barat', 'Russian');
INSERT INTO emkt_regions VALUES(1517, 99, 'JT', 'Jawa Tengah', 'Russian');
INSERT INTO emkt_regions VALUES(1518, 99, 'KB', 'Kalimantan Barat', 'Russian');
INSERT INTO emkt_regions VALUES(1519, 99, 'KI', 'Kalimantan Timur', 'Russian');
INSERT INTO emkt_regions VALUES(1520, 99, 'KS', 'Kalimantan Selatan', 'Russian');
INSERT INTO emkt_regions VALUES(1521, 99, 'KT', 'Kalimantan Tengah', 'Russian');
INSERT INTO emkt_regions VALUES(1522, 99, 'LA', 'Lampung', 'Russian');
INSERT INTO emkt_regions VALUES(1523, 99, 'MA', 'Maluku', 'Russian');
INSERT INTO emkt_regions VALUES(1524, 99, 'MU', 'Maluku Utara', 'Russian');
INSERT INTO emkt_regions VALUES(1525, 99, 'NB', 'Nusa Tenggara Barat', 'Russian');
INSERT INTO emkt_regions VALUES(1526, 99, 'NT', 'Nusa Tenggara Timur', 'Russian');
INSERT INTO emkt_regions VALUES(1527, 99, 'RI', 'Riau', 'Russian');
INSERT INTO emkt_regions VALUES(1528, 99, 'SB', 'Sumatera Barat', 'Russian');
INSERT INTO emkt_regions VALUES(1529, 99, 'SG', 'Sulawesi Tenggara', 'Russian');
INSERT INTO emkt_regions VALUES(1530, 99, 'SL', 'Sumatera Selatan', 'Russian');
INSERT INTO emkt_regions VALUES(1531, 99, 'SN', 'Sulawesi Selatan', 'Russian');
INSERT INTO emkt_regions VALUES(1532, 99, 'ST', 'Sulawesi Tengah', 'Russian');
INSERT INTO emkt_regions VALUES(1533, 99, 'SW', 'Sulawesi Utara', 'Russian');
INSERT INTO emkt_regions VALUES(1534, 99, 'SU', 'Sumatera Utara', 'Russian');
INSERT INTO emkt_regions VALUES(1535, 99, 'YO', 'Yogyakarta', 'Russian');

INSERT INTO emkt_countries VALUES (100,'Иран','Russian','IR','IRN','');

INSERT INTO emkt_regions VALUES(1536, 100, '01', 'محافظة آذربایجان شرقي', 'Russian');
INSERT INTO emkt_regions VALUES(1537, 100, '02', 'محافظة آذربایجان غربي', 'Russian');
INSERT INTO emkt_regions VALUES(1538, 100, '03', 'محافظة اردبیل', 'Russian');
INSERT INTO emkt_regions VALUES(1539, 100, '04', 'محافظة اصفهان', 'Russian');
INSERT INTO emkt_regions VALUES(1540, 100, '05', 'محافظة ایلام', 'Russian');
INSERT INTO emkt_regions VALUES(1541, 100, '06', 'محافظة بوشهر', 'Russian');
INSERT INTO emkt_regions VALUES(1542, 100, '07', 'محافظة طهران', 'Russian');
INSERT INTO emkt_regions VALUES(1543, 100, '08', 'محافظة چهارمحل و بختیاري', 'Russian');
INSERT INTO emkt_regions VALUES(1544, 100, '09', 'محافظة خراسان رضوي', 'Russian');
INSERT INTO emkt_regions VALUES(1545, 100, '10', 'محافظة خوزستان', 'Russian');
INSERT INTO emkt_regions VALUES(1546, 100, '11', 'محافظة زنجان', 'Russian');
INSERT INTO emkt_regions VALUES(1547, 100, '12', 'محافظة سمنان', 'Russian');
INSERT INTO emkt_regions VALUES(1548, 100, '13', 'محافظة سيستان وبلوتشستان', 'Russian');
INSERT INTO emkt_regions VALUES(1549, 100, '14', 'محافظة فارس', 'Russian');
INSERT INTO emkt_regions VALUES(1550, 100, '15', 'محافظة کرمان', 'Russian');
INSERT INTO emkt_regions VALUES(1551, 100, '16', 'محافظة کردستان', 'Russian');
INSERT INTO emkt_regions VALUES(1552, 100, '17', 'محافظة کرمانشاه', 'Russian');
INSERT INTO emkt_regions VALUES(1553, 100, '18', 'محافظة کهکیلویه و بویر أحمد', 'Russian');
INSERT INTO emkt_regions VALUES(1554, 100, '19', 'محافظة گیلان', 'Russian');
INSERT INTO emkt_regions VALUES(1555, 100, '20', 'محافظة لرستان', 'Russian');
INSERT INTO emkt_regions VALUES(1556, 100, '21', 'محافظة مازندران', 'Russian');
INSERT INTO emkt_regions VALUES(1557, 100, '22', 'محافظة مرکزي', 'Russian');
INSERT INTO emkt_regions VALUES(1558, 100, '23', 'محافظة هرمزگان', 'Russian');
INSERT INTO emkt_regions VALUES(1559, 100, '24', 'محافظة همدان', 'Russian');
INSERT INTO emkt_regions VALUES(1560, 100, '25', 'محافظة یزد', 'Russian');
INSERT INTO emkt_regions VALUES(1561, 100, '26', 'محافظة قم', 'Russian');
INSERT INTO emkt_regions VALUES(1562, 100, '27', 'محافظة گلستان', 'Russian');
INSERT INTO emkt_regions VALUES(1563, 100, '28', 'محافظة قزوين', 'Russian');

INSERT INTO emkt_countries VALUES (101,'Ирак','Russian','IQ','IRQ','');

INSERT INTO emkt_regions VALUES(1564, 101, 'AN', 'محافظة الأنبار', 'Russian');
INSERT INTO emkt_regions VALUES(1565, 101, 'AR', 'أربيل', 'Russian');
INSERT INTO emkt_regions VALUES(1566, 101, 'BA', 'محافظة البصرة', 'Russian');
INSERT INTO emkt_regions VALUES(1567, 101, 'BB', 'بابل', 'Russian');
INSERT INTO emkt_regions VALUES(1568, 101, 'BG', 'محافظة بغداد', 'Russian');
INSERT INTO emkt_regions VALUES(1569, 101, 'DA', 'دهوك', 'Russian');
INSERT INTO emkt_regions VALUES(1570, 101, 'DI', 'ديالى', 'Russian');
INSERT INTO emkt_regions VALUES(1571, 101, 'DQ', 'ذي قار', 'Russian');
INSERT INTO emkt_regions VALUES(1572, 101, 'KA', 'كربلاء', 'Russian');
INSERT INTO emkt_regions VALUES(1573, 101, 'MA', 'ميسان', 'Russian');
INSERT INTO emkt_regions VALUES(1574, 101, 'MU', 'المثنى', 'Russian');
INSERT INTO emkt_regions VALUES(1575, 101, 'NA', 'النجف', 'Russian');
INSERT INTO emkt_regions VALUES(1576, 101, 'NI', 'نینوى', 'Russian');
INSERT INTO emkt_regions VALUES(1577, 101, 'QA', 'القادسية', 'Russian');
INSERT INTO emkt_regions VALUES(1578, 101, 'SD', 'صلاح الدين', 'Russian');
INSERT INTO emkt_regions VALUES(1579, 101, 'SW', 'محافظة السليمانية', 'Russian');
INSERT INTO emkt_regions VALUES(1580, 101, 'TS', 'التأمیم', 'Russian');
INSERT INTO emkt_regions VALUES(1581, 101, 'WA', 'واسط', 'Russian');

INSERT INTO emkt_countries VALUES (102,'Ирландия','Russian','IE','IRL','');

INSERT INTO emkt_regions VALUES(1582, 102, 'C', 'Corcaigh', 'Russian');
INSERT INTO emkt_regions VALUES(1583, 102, 'CE', 'Contae an Chláir', 'Russian');
INSERT INTO emkt_regions VALUES(1584, 102, 'CN', 'An Cabhán', 'Russian');
INSERT INTO emkt_regions VALUES(1585, 102, 'CW', 'Ceatharlach', 'Russian');
INSERT INTO emkt_regions VALUES(1586, 102, 'D', 'Baile Átha Cliath', 'Russian');
INSERT INTO emkt_regions VALUES(1587, 102, 'DL', 'Dún na nGall', 'Russian');
INSERT INTO emkt_regions VALUES(1588, 102, 'G', 'Gaillimh', 'Russian');
INSERT INTO emkt_regions VALUES(1589, 102, 'KE', 'Cill Dara', 'Russian');
INSERT INTO emkt_regions VALUES(1590, 102, 'KK', 'Cill Chainnigh', 'Russian');
INSERT INTO emkt_regions VALUES(1591, 102, 'KY', 'Contae Chiarraí', 'Russian');
INSERT INTO emkt_regions VALUES(1592, 102, 'LD', 'An Longfort', 'Russian');
INSERT INTO emkt_regions VALUES(1593, 102, 'LH', 'Contae Lú', 'Russian');
INSERT INTO emkt_regions VALUES(1594, 102, 'LK', 'Luimneach', 'Russian');
INSERT INTO emkt_regions VALUES(1595, 102, 'LM', 'Contae Liatroma', 'Russian');
INSERT INTO emkt_regions VALUES(1596, 102, 'LS', 'Contae Laoise', 'Russian');
INSERT INTO emkt_regions VALUES(1597, 102, 'MH', 'Contae na Mí', 'Russian');
INSERT INTO emkt_regions VALUES(1598, 102, 'MN', 'Muineachán', 'Russian');
INSERT INTO emkt_regions VALUES(1599, 102, 'MO', 'Contae Mhaigh Eo', 'Russian');
INSERT INTO emkt_regions VALUES(1600, 102, 'OY', 'Contae Uíbh Fhailí', 'Russian');
INSERT INTO emkt_regions VALUES(1601, 102, 'RN', 'Ros Comáin', 'Russian');
INSERT INTO emkt_regions VALUES(1602, 102, 'SO', 'Sligeach', 'Russian');
INSERT INTO emkt_regions VALUES(1603, 102, 'TA', 'Tiobraid Árann', 'Russian');
INSERT INTO emkt_regions VALUES(1604, 102, 'WD', 'Port Lairge', 'Russian');
INSERT INTO emkt_regions VALUES(1605, 102, 'WH', 'Contae na hIarmhí', 'Russian');
INSERT INTO emkt_regions VALUES(1606, 102, 'WW', 'Cill Mhantáin', 'Russian');
INSERT INTO emkt_regions VALUES(1607, 102, 'WX', 'Loch Garman', 'Russian');

INSERT INTO emkt_countries VALUES (103,'Израиль','Russian','IL','ISR','');

INSERT INTO emkt_regions VALUES(1608, 103, 'D ', 'מחוז הדרום', 'Russian');
INSERT INTO emkt_regions VALUES(1609, 103, 'HA', 'מחוז חיפה', 'Russian');
INSERT INTO emkt_regions VALUES(1610, 103, 'JM', 'ירושלים', 'Russian');
INSERT INTO emkt_regions VALUES(1611, 103, 'M ', 'מחוז המרכז', 'Russian');
INSERT INTO emkt_regions VALUES(1612, 103, 'TA', 'תל אביב-יפו', 'Russian');
INSERT INTO emkt_regions VALUES(1613, 103, 'Z ', 'מחוז הצפון', 'Russian');

INSERT INTO emkt_countries VALUES (104,'Италия','Russian','IT','ITA','');

INSERT INTO emkt_regions VALUES(1614, 104, 'AG', 'Agrigento', 'Russian');
INSERT INTO emkt_regions VALUES(1615, 104, 'AL', 'Alessandria', 'Russian');
INSERT INTO emkt_regions VALUES(1616, 104, 'AN', 'Ancona', 'Russian');
INSERT INTO emkt_regions VALUES(1617, 104, 'AO', 'Valle d\'Aosta', 'Russian');
INSERT INTO emkt_regions VALUES(1618, 104, 'AP', 'Ascoli Piceno', 'Russian');
INSERT INTO emkt_regions VALUES(1619, 104, 'AQ', 'L\'Aquila', 'Russian');
INSERT INTO emkt_regions VALUES(1620, 104, 'AR', 'Arezzo', 'Russian');
INSERT INTO emkt_regions VALUES(1621, 104, 'AT', 'Asti', 'Russian');
INSERT INTO emkt_regions VALUES(1622, 104, 'AV', 'Avellino', 'Russian');
INSERT INTO emkt_regions VALUES(1623, 104, 'BA', 'Bari', 'Russian');
INSERT INTO emkt_regions VALUES(1624, 104, 'BG', 'Bergamo', 'Russian');
INSERT INTO emkt_regions VALUES(1625, 104, 'BI', 'Biella', 'Russian');
INSERT INTO emkt_regions VALUES(1626, 104, 'BL', 'Belluno', 'Russian');
INSERT INTO emkt_regions VALUES(1627, 104, 'BN', 'Benevento', 'Russian');
INSERT INTO emkt_regions VALUES(1628, 104, 'BO', 'Bologna', 'Russian');
INSERT INTO emkt_regions VALUES(1629, 104, 'BR', 'Brindisi', 'Russian');
INSERT INTO emkt_regions VALUES(1630, 104, 'BS', 'Brescia', 'Russian');
INSERT INTO emkt_regions VALUES(1631, 104, 'BT', 'Barletta-Andria-Trani', 'Russian');
INSERT INTO emkt_regions VALUES(1632, 104, 'BZ', 'Alto Adige', 'Russian');
INSERT INTO emkt_regions VALUES(1633, 104, 'CA', 'Cagliari', 'Russian');
INSERT INTO emkt_regions VALUES(1634, 104, 'CB', 'Campobasso', 'Russian');
INSERT INTO emkt_regions VALUES(1635, 104, 'CE', 'Caserta', 'Russian');
INSERT INTO emkt_regions VALUES(1636, 104, 'CH', 'Chieti', 'Russian');
INSERT INTO emkt_regions VALUES(1637, 104, 'CI', 'Carbonia-Iglesias', 'Russian');
INSERT INTO emkt_regions VALUES(1638, 104, 'CL', 'Caltanissetta', 'Russian');
INSERT INTO emkt_regions VALUES(1639, 104, 'CN', 'Cuneo', 'Russian');
INSERT INTO emkt_regions VALUES(1640, 104, 'CO', 'Como', 'Russian');
INSERT INTO emkt_regions VALUES(1641, 104, 'CR', 'Cremona', 'Russian');
INSERT INTO emkt_regions VALUES(1642, 104, 'CS', 'Cosenza', 'Russian');
INSERT INTO emkt_regions VALUES(1643, 104, 'CT', 'Catania', 'Russian');
INSERT INTO emkt_regions VALUES(1644, 104, 'CZ', 'Catanzaro', 'Russian');
INSERT INTO emkt_regions VALUES(1645, 104, 'EN', 'Enna', 'Russian');
INSERT INTO emkt_regions VALUES(1646, 104, 'FE', 'Ferrara', 'Russian');
INSERT INTO emkt_regions VALUES(1647, 104, 'FG', 'Foggia', 'Russian');
INSERT INTO emkt_regions VALUES(1648, 104, 'FI', 'Firenze', 'Russian');
INSERT INTO emkt_regions VALUES(1649, 104, 'FM', 'Fermo', 'Russian');
INSERT INTO emkt_regions VALUES(1650, 104, 'FO', 'Forlì-Cesena', 'Russian');
INSERT INTO emkt_regions VALUES(1651, 104, 'FR', 'Frosinone', 'Russian');
INSERT INTO emkt_regions VALUES(1652, 104, 'GE', 'Genova', 'Russian');
INSERT INTO emkt_regions VALUES(1653, 104, 'GO', 'Gorizia', 'Russian');
INSERT INTO emkt_regions VALUES(1654, 104, 'GR', 'Grosseto', 'Russian');
INSERT INTO emkt_regions VALUES(1655, 104, 'IM', 'Imperia', 'Russian');
INSERT INTO emkt_regions VALUES(1656, 104, 'IS', 'Isernia', 'Russian');
INSERT INTO emkt_regions VALUES(1657, 104, 'KR', 'Crotone', 'Russian');
INSERT INTO emkt_regions VALUES(1658, 104, 'LC', 'Lecco', 'Russian');
INSERT INTO emkt_regions VALUES(1659, 104, 'LE', 'Lecce', 'Russian');
INSERT INTO emkt_regions VALUES(1660, 104, 'LI', 'Livorno', 'Russian');
INSERT INTO emkt_regions VALUES(1661, 104, 'LO', 'Lodi', 'Russian');
INSERT INTO emkt_regions VALUES(1662, 104, 'LT', 'Latina', 'Russian');
INSERT INTO emkt_regions VALUES(1663, 104, 'LU', 'Lucca', 'Russian');
INSERT INTO emkt_regions VALUES(1664, 104, 'MC', 'Macerata', 'Russian');
INSERT INTO emkt_regions VALUES(1665, 104, 'MD', 'Medio Campidano', 'Russian');
INSERT INTO emkt_regions VALUES(1666, 104, 'ME', 'Messina', 'Russian');
INSERT INTO emkt_regions VALUES(1667, 104, 'MI', 'Milano', 'Russian');
INSERT INTO emkt_regions VALUES(1668, 104, 'MN', 'Mantova', 'Russian');
INSERT INTO emkt_regions VALUES(1669, 104, 'MO', 'Modena', 'Russian');
INSERT INTO emkt_regions VALUES(1670, 104, 'MS', 'Massa-Carrara', 'Russian');
INSERT INTO emkt_regions VALUES(1671, 104, 'MT', 'Matera', 'Russian');
INSERT INTO emkt_regions VALUES(1672, 104, 'MZ', 'Monza e Brianza', 'Russian');
INSERT INTO emkt_regions VALUES(1673, 104, 'NA', 'Napoli', 'Russian');
INSERT INTO emkt_regions VALUES(1674, 104, 'NO', 'Novara', 'Russian');
INSERT INTO emkt_regions VALUES(1675, 104, 'NU', 'Nuoro', 'Russian');
INSERT INTO emkt_regions VALUES(1676, 104, 'OG', 'Ogliastra', 'Russian');
INSERT INTO emkt_regions VALUES(1677, 104, 'OR', 'Oristano', 'Russian');
INSERT INTO emkt_regions VALUES(1678, 104, 'OT', 'Olbia-Tempio', 'Russian');
INSERT INTO emkt_regions VALUES(1679, 104, 'PA', 'Palermo', 'Russian');
INSERT INTO emkt_regions VALUES(1680, 104, 'PC', 'Piacenza', 'Russian');
INSERT INTO emkt_regions VALUES(1681, 104, 'PD', 'Padova', 'Russian');
INSERT INTO emkt_regions VALUES(1682, 104, 'PE', 'Pescara', 'Russian');
INSERT INTO emkt_regions VALUES(1683, 104, 'PG', 'Perugia', 'Russian');
INSERT INTO emkt_regions VALUES(1684, 104, 'PI', 'Pisa', 'Russian');
INSERT INTO emkt_regions VALUES(1685, 104, 'PN', 'Pordenone', 'Russian');
INSERT INTO emkt_regions VALUES(1686, 104, 'PO', 'Prato', 'Russian');
INSERT INTO emkt_regions VALUES(1687, 104, 'PR', 'Parma', 'Russian');
INSERT INTO emkt_regions VALUES(1688, 104, 'PS', 'Pesaro e Urbino', 'Russian');
INSERT INTO emkt_regions VALUES(1689, 104, 'PT', 'Pistoia', 'Russian');
INSERT INTO emkt_regions VALUES(1690, 104, 'PV', 'Pavia', 'Russian');
INSERT INTO emkt_regions VALUES(1691, 104, 'PZ', 'Potenza', 'Russian');
INSERT INTO emkt_regions VALUES(1692, 104, 'RA', 'Ravenna', 'Russian');
INSERT INTO emkt_regions VALUES(1693, 104, 'RC', 'Reggio Calabria', 'Russian');
INSERT INTO emkt_regions VALUES(1694, 104, 'RE', 'Reggio Emilia', 'Russian');
INSERT INTO emkt_regions VALUES(1695, 104, 'RG', 'Ragusa', 'Russian');
INSERT INTO emkt_regions VALUES(1696, 104, 'RI', 'Rieti', 'Russian');
INSERT INTO emkt_regions VALUES(1697, 104, 'RM', 'Roma', 'Russian');
INSERT INTO emkt_regions VALUES(1698, 104, 'RN', 'Rimini', 'Russian');
INSERT INTO emkt_regions VALUES(1699, 104, 'RO', 'Rovigo', 'Russian');
INSERT INTO emkt_regions VALUES(1700, 104, 'SA', 'Salerno', 'Russian');
INSERT INTO emkt_regions VALUES(1701, 104, 'SI', 'Siena', 'Russian');
INSERT INTO emkt_regions VALUES(1702, 104, 'SO', 'Sondrio', 'Russian');
INSERT INTO emkt_regions VALUES(1703, 104, 'SP', 'La Spezia', 'Russian');
INSERT INTO emkt_regions VALUES(1704, 104, 'SR', 'Siracusa', 'Russian');
INSERT INTO emkt_regions VALUES(1705, 104, 'SS', 'Sassari', 'Russian');
INSERT INTO emkt_regions VALUES(1706, 104, 'SV', 'Savona', 'Russian');
INSERT INTO emkt_regions VALUES(1707, 104, 'TA', 'Taranto', 'Russian');
INSERT INTO emkt_regions VALUES(1708, 104, 'TE', 'Teramo', 'Russian');
INSERT INTO emkt_regions VALUES(1709, 104, 'TN', 'Trento', 'Russian');
INSERT INTO emkt_regions VALUES(1710, 104, 'TO', 'Torino', 'Russian');
INSERT INTO emkt_regions VALUES(1711, 104, 'TP', 'Trapani', 'Russian');
INSERT INTO emkt_regions VALUES(1712, 104, 'TR', 'Terni', 'Russian');
INSERT INTO emkt_regions VALUES(1713, 104, 'TS', 'Trieste', 'Russian');
INSERT INTO emkt_regions VALUES(1714, 104, 'TV', 'Treviso', 'Russian');
INSERT INTO emkt_regions VALUES(1715, 104, 'UD', 'Udine', 'Russian');
INSERT INTO emkt_regions VALUES(1716, 104, 'VA', 'Varese', 'Russian');
INSERT INTO emkt_regions VALUES(1717, 104, 'VB', 'Verbano-Cusio-Ossola', 'Russian');
INSERT INTO emkt_regions VALUES(1718, 104, 'VC', 'Vercelli', 'Russian');
INSERT INTO emkt_regions VALUES(1719, 104, 'VE', 'Venezia', 'Russian');
INSERT INTO emkt_regions VALUES(1720, 104, 'VI', 'Vicenza', 'Russian');
INSERT INTO emkt_regions VALUES(1721, 104, 'VR', 'Verona', 'Russian');
INSERT INTO emkt_regions VALUES(1722, 104, 'VT', 'Viterbo', 'Russian');
INSERT INTO emkt_regions VALUES(1723, 104, 'VV', 'Vibo Valentia', 'Russian');

INSERT INTO emkt_countries VALUES (105,'Ямайка','Russian','JM','JAM','');

INSERT INTO emkt_regions VALUES(1724, 105, '01', 'Kingston', 'Russian');
INSERT INTO emkt_regions VALUES(1725, 105, '02', 'Half Way Tree', 'Russian');
INSERT INTO emkt_regions VALUES(1726, 105, '03', 'Morant Bay', 'Russian');
INSERT INTO emkt_regions VALUES(1727, 105, '04', 'Port Antonio', 'Russian');
INSERT INTO emkt_regions VALUES(1728, 105, '05', 'Port Maria', 'Russian');
INSERT INTO emkt_regions VALUES(1729, 105, '06', 'Saint Ann\'s Bay', 'Russian');
INSERT INTO emkt_regions VALUES(1730, 105, '07', 'Falmouth', 'Russian');
INSERT INTO emkt_regions VALUES(1731, 105, '08', 'Montego Bay', 'Russian');
INSERT INTO emkt_regions VALUES(1732, 105, '09', 'Lucea', 'Russian');
INSERT INTO emkt_regions VALUES(1733, 105, '10', 'Savanna-la-Mar', 'Russian');
INSERT INTO emkt_regions VALUES(1734, 105, '11', 'Black River', 'Russian');
INSERT INTO emkt_regions VALUES(1735, 105, '12', 'Mandeville', 'Russian');
INSERT INTO emkt_regions VALUES(1736, 105, '13', 'May Pen', 'Russian');
INSERT INTO emkt_regions VALUES(1737, 105, '14', 'Spanish Town', 'Russian');

INSERT INTO emkt_countries VALUES (106,'Япония','Russian','JP','JPN','');

INSERT INTO emkt_regions VALUES(1738, 106, '01', '北海道', 'Russian');
INSERT INTO emkt_regions VALUES(1739, 106, '02', '青森', 'Russian');
INSERT INTO emkt_regions VALUES(1740, 106, '03', '岩手', 'Russian');
INSERT INTO emkt_regions VALUES(1741, 106, '04', '宮城', 'Russian');
INSERT INTO emkt_regions VALUES(1742, 106, '05', '秋田', 'Russian');
INSERT INTO emkt_regions VALUES(1743, 106, '06', '山形', 'Russian');
INSERT INTO emkt_regions VALUES(1744, 106, '07', '福島', 'Russian');
INSERT INTO emkt_regions VALUES(1745, 106, '08', '茨城', 'Russian');
INSERT INTO emkt_regions VALUES(1746, 106, '09', '栃木', 'Russian');
INSERT INTO emkt_regions VALUES(1747, 106, '10', '群馬', 'Russian');
INSERT INTO emkt_regions VALUES(1748, 106, '11', '埼玉', 'Russian');
INSERT INTO emkt_regions VALUES(1749, 106, '12', '千葉', 'Russian');
INSERT INTO emkt_regions VALUES(1750, 106, '13', '東京', 'Russian');
INSERT INTO emkt_regions VALUES(1751, 106, '14', '神奈川', 'Russian');
INSERT INTO emkt_regions VALUES(1752, 106, '15', '新潟', 'Russian');
INSERT INTO emkt_regions VALUES(1753, 106, '16', '富山', 'Russian');
INSERT INTO emkt_regions VALUES(1754, 106, '17', '石川', 'Russian');
INSERT INTO emkt_regions VALUES(1755, 106, '18', '福井', 'Russian');
INSERT INTO emkt_regions VALUES(1756, 106, '19', '山梨', 'Russian');
INSERT INTO emkt_regions VALUES(1757, 106, '20', '長野', 'Russian');
INSERT INTO emkt_regions VALUES(1758, 106, '21', '岐阜', 'Russian');
INSERT INTO emkt_regions VALUES(1759, 106, '22', '静岡', 'Russian');
INSERT INTO emkt_regions VALUES(1760, 106, '23', '愛知', 'Russian');
INSERT INTO emkt_regions VALUES(1761, 106, '24', '三重', 'Russian');
INSERT INTO emkt_regions VALUES(1762, 106, '25', '滋賀', 'Russian');
INSERT INTO emkt_regions VALUES(1763, 106, '26', '京都', 'Russian');
INSERT INTO emkt_regions VALUES(1764, 106, '27', '大阪', 'Russian');
INSERT INTO emkt_regions VALUES(1765, 106, '28', '兵庫', 'Russian');
INSERT INTO emkt_regions VALUES(1766, 106, '29', '奈良', 'Russian');
INSERT INTO emkt_regions VALUES(1767, 106, '30', '和歌山', 'Russian');
INSERT INTO emkt_regions VALUES(1768, 106, '31', '鳥取', 'Russian');
INSERT INTO emkt_regions VALUES(1769, 106, '32', '島根', 'Russian');
INSERT INTO emkt_regions VALUES(1770, 106, '33', '岡山', 'Russian');
INSERT INTO emkt_regions VALUES(1771, 106, '34', '広島', 'Russian');
INSERT INTO emkt_regions VALUES(1772, 106, '35', '山口', 'Russian');
INSERT INTO emkt_regions VALUES(1773, 106, '36', '徳島', 'Russian');
INSERT INTO emkt_regions VALUES(1774, 106, '37', '香川', 'Russian');
INSERT INTO emkt_regions VALUES(1775, 106, '38', '愛媛', 'Russian');
INSERT INTO emkt_regions VALUES(1776, 106, '39', '高知', 'Russian');
INSERT INTO emkt_regions VALUES(1777, 106, '40', '福岡', 'Russian');
INSERT INTO emkt_regions VALUES(1778, 106, '41', '佐賀', 'Russian');
INSERT INTO emkt_regions VALUES(1779, 106, '42', '長崎', 'Russian');
INSERT INTO emkt_regions VALUES(1780, 106, '43', '熊本', 'Russian');
INSERT INTO emkt_regions VALUES(1781, 106, '44', '大分', 'Russian');
INSERT INTO emkt_regions VALUES(1782, 106, '45', '宮崎', 'Russian');
INSERT INTO emkt_regions VALUES(1783, 106, '46', '鹿児島', 'Russian');
INSERT INTO emkt_regions VALUES(1784, 106, '47', '沖縄', 'Russian');

INSERT INTO emkt_countries VALUES (107,'Иордания','Russian','JO','JOR','');

INSERT INTO emkt_regions VALUES(1785, 107, 'AJ', 'محافظة عجلون', 'Russian');
INSERT INTO emkt_regions VALUES(1786, 107, 'AM', 'محافظة العاصمة', 'Russian');
INSERT INTO emkt_regions VALUES(1787, 107, 'AQ', 'محافظة العقبة', 'Russian');
INSERT INTO emkt_regions VALUES(1788, 107, 'AT', 'محافظة الطفيلة', 'Russian');
INSERT INTO emkt_regions VALUES(1789, 107, 'AZ', 'محافظة الزرقاء', 'Russian');
INSERT INTO emkt_regions VALUES(1790, 107, 'BA', 'محافظة البلقاء', 'Russian');
INSERT INTO emkt_regions VALUES(1791, 107, 'JA', 'محافظة جرش', 'Russian');
INSERT INTO emkt_regions VALUES(1792, 107, 'JR', 'محافظة إربد', 'Russian');
INSERT INTO emkt_regions VALUES(1793, 107, 'KA', 'محافظة الكرك', 'Russian');
INSERT INTO emkt_regions VALUES(1794, 107, 'MA', 'محافظة المفرق', 'Russian');
INSERT INTO emkt_regions VALUES(1795, 107, 'MD', 'محافظة مادبا', 'Russian');
INSERT INTO emkt_regions VALUES(1796, 107, 'MN', 'محافظة معان', 'Russian');

INSERT INTO emkt_countries VALUES (108,'Казахстан','Russian','KZ','KAZ','');

INSERT INTO emkt_regions VALUES(1797, 108, 'AL', 'Алматы', 'Russian');
INSERT INTO emkt_regions VALUES(1798, 108, 'AC', 'Almaty City', 'Russian');
INSERT INTO emkt_regions VALUES(1799, 108, 'AM', 'Ақмола', 'Russian');
INSERT INTO emkt_regions VALUES(1800, 108, 'AQ', 'Ақтөбе', 'Russian');
INSERT INTO emkt_regions VALUES(1801, 108, 'AS', 'Астана', 'Russian');
INSERT INTO emkt_regions VALUES(1802, 108, 'AT', 'Атырау', 'Russian');
INSERT INTO emkt_regions VALUES(1803, 108, 'BA', 'Батыс Қазақстан', 'Russian');
INSERT INTO emkt_regions VALUES(1804, 108, 'BY', 'Байқоңыр', 'Russian');
INSERT INTO emkt_regions VALUES(1805, 108, 'MA', 'Маңғыстау', 'Russian');
INSERT INTO emkt_regions VALUES(1806, 108, 'ON', 'Оңтүстік Қазақстан', 'Russian');
INSERT INTO emkt_regions VALUES(1807, 108, 'PA', 'Павлодар', 'Russian');
INSERT INTO emkt_regions VALUES(1808, 108, 'QA', 'Қарағанды', 'Russian');
INSERT INTO emkt_regions VALUES(1809, 108, 'QO', 'Қостанай', 'Russian');
INSERT INTO emkt_regions VALUES(1810, 108, 'QY', 'Қызылорда', 'Russian');
INSERT INTO emkt_regions VALUES(1811, 108, 'SH', 'Шығыс Қазақстан', 'Russian');
INSERT INTO emkt_regions VALUES(1812, 108, 'SO', 'Солтүстік Қазақстан', 'Russian');
INSERT INTO emkt_regions VALUES(1813, 108, 'ZH', 'Жамбыл', 'Russian');

INSERT INTO emkt_countries VALUES (109,'Кения','Russian','KE','KEN','');

INSERT INTO emkt_regions VALUES(1814, 109, '110', 'Nairobi', 'Russian');
INSERT INTO emkt_regions VALUES(1815, 109, '200', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(1816, 109, '300', 'Mombasa', 'Russian');
INSERT INTO emkt_regions VALUES(1817, 109, '400', 'Eastern', 'Russian');
INSERT INTO emkt_regions VALUES(1818, 109, '500', 'North Eastern', 'Russian');
INSERT INTO emkt_regions VALUES(1819, 109, '600', 'Nyanza', 'Russian');
INSERT INTO emkt_regions VALUES(1820, 109, '700', 'Rift Valley', 'Russian');
INSERT INTO emkt_regions VALUES(1821, 109, '900', 'Western', 'Russian');

INSERT INTO emkt_countries VALUES (110,'Кирибати','Russian','KI','KIR','');

INSERT INTO emkt_regions VALUES(1822, 110, 'G', 'Gilbert Islands', 'Russian');
INSERT INTO emkt_regions VALUES(1823, 110, 'L', 'Line Islands', 'Russian');
INSERT INTO emkt_regions VALUES(1824, 110, 'P', 'Phoenix Islands', 'Russian');

INSERT INTO emkt_countries VALUES (111,'Корейская Народно-Демократическая Республика','Russian','KP','PRK','');

INSERT INTO emkt_regions VALUES(1825, 111, 'CHA', '자강도', 'Russian');
INSERT INTO emkt_regions VALUES(1826, 111, 'HAB', '함경 북도', 'Russian');
INSERT INTO emkt_regions VALUES(1827, 111, 'HAN', '함경 남도', 'Russian');
INSERT INTO emkt_regions VALUES(1828, 111, 'HWB', '황해 북도', 'Russian');
INSERT INTO emkt_regions VALUES(1829, 111, 'HWN', '황해 남도', 'Russian');
INSERT INTO emkt_regions VALUES(1830, 111, 'KAN', '강원도', 'Russian');
INSERT INTO emkt_regions VALUES(1831, 111, 'KAE', '개성시', 'Russian');
INSERT INTO emkt_regions VALUES(1832, 111, 'NAJ', '라선 직할시', 'Russian');
INSERT INTO emkt_regions VALUES(1833, 111, 'NAM', '남포 특급시', 'Russian');
INSERT INTO emkt_regions VALUES(1834, 111, 'PYB', '평안 북도', 'Russian');
INSERT INTO emkt_regions VALUES(1835, 111, 'PYN', '평안 남도', 'Russian');
INSERT INTO emkt_regions VALUES(1836, 111, 'PYO', '평양 직할시', 'Russian');
INSERT INTO emkt_regions VALUES(1837, 111, 'YAN', '량강도', 'Russian');

INSERT INTO emkt_countries VALUES (112,'Республика Корея','Russian','KR','KOR','');

INSERT INTO emkt_regions VALUES(1838, 112, '11', '서울특별시', 'Russian');
INSERT INTO emkt_regions VALUES(1839, 112, '26', '부산 광역시', 'Russian');
INSERT INTO emkt_regions VALUES(1840, 112, '27', '대구 광역시', 'Russian');
INSERT INTO emkt_regions VALUES(1841, 112, '28', '인천광역시', 'Russian');
INSERT INTO emkt_regions VALUES(1842, 112, '29', '광주 광역시', 'Russian');
INSERT INTO emkt_regions VALUES(1843, 112, '30', '대전 광역시', 'Russian');
INSERT INTO emkt_regions VALUES(1844, 112, '31', '울산 광역시', 'Russian');
INSERT INTO emkt_regions VALUES(1845, 112, '41', '경기도', 'Russian');
INSERT INTO emkt_regions VALUES(1846, 112, '42', '강원도', 'Russian');
INSERT INTO emkt_regions VALUES(1847, 112, '43', '충청 북도', 'Russian');
INSERT INTO emkt_regions VALUES(1848, 112, '44', '충청 남도', 'Russian');
INSERT INTO emkt_regions VALUES(1849, 112, '45', '전라 북도', 'Russian');
INSERT INTO emkt_regions VALUES(1850, 112, '46', '전라 남도', 'Russian');
INSERT INTO emkt_regions VALUES(1851, 112, '47', '경상 북도', 'Russian');
INSERT INTO emkt_regions VALUES(1852, 112, '48', '경상 남도', 'Russian');
INSERT INTO emkt_regions VALUES(1853, 112, '49', '제주특별자치도', 'Russian');

INSERT INTO emkt_countries VALUES (113,'Кувейт','Russian','KW','KWT','');

INSERT INTO emkt_regions VALUES(1854, 113, 'AH', 'الاحمدي', 'Russian');
INSERT INTO emkt_regions VALUES(1855, 113, 'FA', 'الفروانية', 'Russian');
INSERT INTO emkt_regions VALUES(1856, 113, 'JA', 'الجهراء', 'Russian');
INSERT INTO emkt_regions VALUES(1857, 113, 'KU', 'ألعاصمه', 'Russian');
INSERT INTO emkt_regions VALUES(1858, 113, 'HW', 'حولي', 'Russian');
INSERT INTO emkt_regions VALUES(1859, 113, 'MU', 'مبارك الكبير', 'Russian');

INSERT INTO emkt_countries VALUES (114,'Киргистан','Russian','KG','KGZ','');

INSERT INTO emkt_regions VALUES(1860, 114, 'B', 'Баткен областы', 'Russian');
INSERT INTO emkt_regions VALUES(1861, 114, 'C', 'Чүй областы', 'Russian');
INSERT INTO emkt_regions VALUES(1862, 114, 'GB', 'Бишкек', 'Russian');
INSERT INTO emkt_regions VALUES(1863, 114, 'J', 'Жалал-Абад областы', 'Russian');
INSERT INTO emkt_regions VALUES(1864, 114, 'N', 'Нарын областы', 'Russian');
INSERT INTO emkt_regions VALUES(1865, 114, 'O', 'Ош областы', 'Russian');
INSERT INTO emkt_regions VALUES(1866, 114, 'T', 'Талас областы', 'Russian');
INSERT INTO emkt_regions VALUES(1867, 114, 'Y', 'Ысык-Көл областы', 'Russian');

INSERT INTO emkt_countries VALUES (115,'Лаос','Russian','LA','LAO','');

INSERT INTO emkt_regions VALUES(1868, 115, 'AT', 'ອັດຕະປື', 'Russian');
INSERT INTO emkt_regions VALUES(1869, 115, 'BK', 'ບໍ່ແກ້ວ', 'Russian');
INSERT INTO emkt_regions VALUES(1870, 115, 'BL', 'ບໍລິຄໍາໄຊ', 'Russian');
INSERT INTO emkt_regions VALUES(1871, 115, 'CH', 'ຈໍາປາສັກ', 'Russian');
INSERT INTO emkt_regions VALUES(1872, 115, 'HO', 'ຫົວພັນ', 'Russian');
INSERT INTO emkt_regions VALUES(1873, 115, 'KH', 'ຄໍາມ່ວນ', 'Russian');
INSERT INTO emkt_regions VALUES(1874, 115, 'LM', 'ຫລວງນໍ້າທາ', 'Russian');
INSERT INTO emkt_regions VALUES(1875, 115, 'LP', 'ຫລວງພະບາງ', 'Russian');
INSERT INTO emkt_regions VALUES(1876, 115, 'OU', 'ອຸດົມໄຊ', 'Russian');
INSERT INTO emkt_regions VALUES(1877, 115, 'PH', 'ຜົງສາລີ', 'Russian');
INSERT INTO emkt_regions VALUES(1878, 115, 'SL', 'ສາລະວັນ', 'Russian');
INSERT INTO emkt_regions VALUES(1879, 115, 'SV', 'ສະຫວັນນະເຂດ', 'Russian');
INSERT INTO emkt_regions VALUES(1880, 115, 'VI', 'ວຽງຈັນ', 'Russian');
INSERT INTO emkt_regions VALUES(1881, 115, 'VT', 'ວຽງຈັນ', 'Russian');
INSERT INTO emkt_regions VALUES(1882, 115, 'XA', 'ໄຊຍະບູລີ', 'Russian');
INSERT INTO emkt_regions VALUES(1883, 115, 'XE', 'ເຊກອງ', 'Russian');
INSERT INTO emkt_regions VALUES(1884, 115, 'XI', 'ຊຽງຂວາງ', 'Russian');
INSERT INTO emkt_regions VALUES(1885, 115, 'XN', 'ໄຊສົມບູນ', 'Russian');

INSERT INTO emkt_countries VALUES (116,'Латвия','Russian','LV','LVA','');

INSERT INTO emkt_regions VALUES(1886, 116, 'AI', 'Aizkraukles rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1887, 116, 'AL', 'Alūksnes rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1888, 116, 'BL', 'Balvu rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1889, 116, 'BU', 'Bauskas rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1890, 116, 'CE', 'Cēsu rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1891, 116, 'DA', 'Daugavpils rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1892, 116, 'DGV', 'Daugpilis', 'Russian');
INSERT INTO emkt_regions VALUES(1893, 116, 'DO', 'Dobeles rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1894, 116, 'GU', 'Gulbenes rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1895, 116, 'JEL', 'Jelgava', 'Russian');
INSERT INTO emkt_regions VALUES(1896, 116, 'JK', 'Jēkabpils rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1897, 116, 'JL', 'Jelgavas rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1898, 116, 'JUR', 'Jūrmala', 'Russian');
INSERT INTO emkt_regions VALUES(1899, 116, 'KR', 'Krāslavas rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1900, 116, 'KU', 'Kuldīgas rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1901, 116, 'LE', 'Liepājas rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1902, 116, 'LM', 'Limbažu rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1903, 116, 'LPX', 'Liepoja', 'Russian');
INSERT INTO emkt_regions VALUES(1904, 116, 'LU', 'Ludzas rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1905, 116, 'MA', 'Madonas rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1906, 116, 'OG', 'Ogres rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1907, 116, 'PR', 'Preiļu rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1908, 116, 'RE', 'Rēzeknes rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1909, 116, 'REZ', 'Rēzekne', 'Russian');
INSERT INTO emkt_regions VALUES(1910, 116, 'RI', 'Rīgas rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1911, 116, 'RIX', 'Rīga', 'Russian');
INSERT INTO emkt_regions VALUES(1912, 116, 'SA', 'Saldus rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1913, 116, 'TA', 'Talsu rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1914, 116, 'TU', 'Tukuma rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1915, 116, 'VE', 'Ventspils rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1916, 116, 'VEN', 'Ventspils', 'Russian');
INSERT INTO emkt_regions VALUES(1917, 116, 'VK', 'Valkas rajons', 'Russian');
INSERT INTO emkt_regions VALUES(1918, 116, 'VM', 'Valmieras rajons', 'Russian');

INSERT INTO emkt_countries VALUES (117,'Ливан','Russian','LB','LBN','');

INSERT INTO emkt_regions VALUES(4263, 117, 'NOCODE', 'Lebanon', 'Russian');

INSERT INTO emkt_countries VALUES (118,'Лесото','Russian','LS','LSO','');

INSERT INTO emkt_regions VALUES(1919, 118, 'A', 'Maseru', 'Russian');
INSERT INTO emkt_regions VALUES(1920, 118, 'B', 'Butha-Buthe', 'Russian');
INSERT INTO emkt_regions VALUES(1921, 118, 'C', 'Leribe', 'Russian');
INSERT INTO emkt_regions VALUES(1922, 118, 'D', 'Berea', 'Russian');
INSERT INTO emkt_regions VALUES(1923, 118, 'E', 'Mafeteng', 'Russian');
INSERT INTO emkt_regions VALUES(1924, 118, 'F', 'Mohale\'s Hoek', 'Russian');
INSERT INTO emkt_regions VALUES(1925, 118, 'G', 'Quthing', 'Russian');
INSERT INTO emkt_regions VALUES(1926, 118, 'H', 'Qacha\'s Nek', 'Russian');
INSERT INTO emkt_regions VALUES(1927, 118, 'J', 'Mokhotlong', 'Russian');
INSERT INTO emkt_regions VALUES(1928, 118, 'K', 'Thaba-Tseka', 'Russian');

INSERT INTO emkt_countries VALUES (119,'Либерия','Russian','LR','LBR','');

INSERT INTO emkt_regions VALUES(1929, 119, 'BG', 'Bong', 'Russian');
INSERT INTO emkt_regions VALUES(1930, 119, 'BM', 'Bomi', 'Russian');
INSERT INTO emkt_regions VALUES(1931, 119, 'CM', 'Grand Cape Mount', 'Russian');
INSERT INTO emkt_regions VALUES(1932, 119, 'GB', 'Grand Bassa', 'Russian');
INSERT INTO emkt_regions VALUES(1933, 119, 'GG', 'Grand Gedeh', 'Russian');
INSERT INTO emkt_regions VALUES(1934, 119, 'GK', 'Grand Kru', 'Russian');
INSERT INTO emkt_regions VALUES(1935, 119, 'GP', 'Gbarpolu', 'Russian');
INSERT INTO emkt_regions VALUES(1936, 119, 'LO', 'Lofa', 'Russian');
INSERT INTO emkt_regions VALUES(1937, 119, 'MG', 'Margibi', 'Russian');
INSERT INTO emkt_regions VALUES(1938, 119, 'MO', 'Montserrado', 'Russian');
INSERT INTO emkt_regions VALUES(1939, 119, 'MY', 'Maryland', 'Russian');
INSERT INTO emkt_regions VALUES(1940, 119, 'NI', 'Nimba', 'Russian');
INSERT INTO emkt_regions VALUES(1941, 119, 'RG', 'River Gee', 'Russian');
INSERT INTO emkt_regions VALUES(1942, 119, 'RI', 'Rivercess', 'Russian');
INSERT INTO emkt_regions VALUES(1943, 119, 'SI', 'Sinoe', 'Russian');

INSERT INTO emkt_countries VALUES (120,'Ливия','Russian','LY','LBY','');

INSERT INTO emkt_regions VALUES(1944, 120, 'AJ', 'Ajdābiyā', 'Russian');
INSERT INTO emkt_regions VALUES(1945, 120, 'BA', 'Banghāzī', 'Russian');
INSERT INTO emkt_regions VALUES(1946, 120, 'BU', 'Al Buţnān', 'Russian');
INSERT INTO emkt_regions VALUES(1947, 120, 'BW', 'Banī Walīd', 'Russian');
INSERT INTO emkt_regions VALUES(1948, 120, 'DR', 'Darnah', 'Russian');
INSERT INTO emkt_regions VALUES(1949, 120, 'GD', 'Ghadāmis', 'Russian');
INSERT INTO emkt_regions VALUES(1950, 120, 'GR', 'Gharyān', 'Russian');
INSERT INTO emkt_regions VALUES(1951, 120, 'GT', 'Ghāt', 'Russian');
INSERT INTO emkt_regions VALUES(1952, 120, 'HZ', 'Al Ḩizām al Akhḑar', 'Russian');
INSERT INTO emkt_regions VALUES(1953, 120, 'JA', 'Al Jabal al Akhḑar', 'Russian');
INSERT INTO emkt_regions VALUES(1954, 120, 'JB', 'Jaghbūb', 'Russian');
INSERT INTO emkt_regions VALUES(1955, 120, 'JI', 'Al Jifārah', 'Russian');
INSERT INTO emkt_regions VALUES(1956, 120, 'JU', 'Al Jufrah', 'Russian');
INSERT INTO emkt_regions VALUES(1957, 120, 'KF', 'Al Kufrah', 'Russian');
INSERT INTO emkt_regions VALUES(1958, 120, 'MB', 'Al Marqab', 'Russian');
INSERT INTO emkt_regions VALUES(1959, 120, 'MI', 'Mişrātah', 'Russian');
INSERT INTO emkt_regions VALUES(1960, 120, 'MJ', 'Al Marj', 'Russian');
INSERT INTO emkt_regions VALUES(1961, 120, 'MQ', 'Murzuq', 'Russian');
INSERT INTO emkt_regions VALUES(1962, 120, 'MZ', 'Mizdah', 'Russian');
INSERT INTO emkt_regions VALUES(1963, 120, 'NL', 'Nālūt', 'Russian');
INSERT INTO emkt_regions VALUES(1964, 120, 'NQ', 'An Nuqaţ al Khams', 'Russian');
INSERT INTO emkt_regions VALUES(1965, 120, 'QB', 'Al Qubbah', 'Russian');
INSERT INTO emkt_regions VALUES(1966, 120, 'QT', 'Al Qaţrūn', 'Russian');
INSERT INTO emkt_regions VALUES(1967, 120, 'SB', 'Sabhā', 'Russian');
INSERT INTO emkt_regions VALUES(1968, 120, 'SH', 'Ash Shāţi', 'Russian');
INSERT INTO emkt_regions VALUES(1969, 120, 'SR', 'Surt', 'Russian');
INSERT INTO emkt_regions VALUES(1970, 120, 'SS', 'Şabrātah Şurmān', 'Russian');
INSERT INTO emkt_regions VALUES(1971, 120, 'TB', 'Ţarābulus', 'Russian');
INSERT INTO emkt_regions VALUES(1972, 120, 'TM', 'Tarhūnah-Masallātah', 'Russian');
INSERT INTO emkt_regions VALUES(1973, 120, 'TN', 'Tājūrā wa an Nawāḩī al Arbāʻ', 'Russian');
INSERT INTO emkt_regions VALUES(1974, 120, 'WA', 'Al Wāḩah', 'Russian');
INSERT INTO emkt_regions VALUES(1975, 120, 'WD', 'Wādī al Ḩayāt', 'Russian');
INSERT INTO emkt_regions VALUES(1976, 120, 'YJ', 'Yafran-Jādū', 'Russian');
INSERT INTO emkt_regions VALUES(1977, 120, 'ZA', 'Az Zāwiyah', 'Russian');

INSERT INTO emkt_countries VALUES (121,'Лихтенштейн','Russian','LI','LIE','');

INSERT INTO emkt_regions VALUES(1978, 121, 'B', 'Balzers', 'Russian');
INSERT INTO emkt_regions VALUES(1979, 121, 'E', 'Eschen', 'Russian');
INSERT INTO emkt_regions VALUES(1980, 121, 'G', 'Gamprin', 'Russian');
INSERT INTO emkt_regions VALUES(1981, 121, 'M', 'Mauren', 'Russian');
INSERT INTO emkt_regions VALUES(1982, 121, 'P', 'Planken', 'Russian');
INSERT INTO emkt_regions VALUES(1983, 121, 'R', 'Ruggell', 'Russian');
INSERT INTO emkt_regions VALUES(1984, 121, 'A', 'Schaan', 'Russian');
INSERT INTO emkt_regions VALUES(1985, 121, 'L', 'Schellenberg', 'Russian');
INSERT INTO emkt_regions VALUES(1986, 121, 'N', 'Triesen', 'Russian');
INSERT INTO emkt_regions VALUES(1987, 121, 'T', 'Triesenberg', 'Russian');
INSERT INTO emkt_regions VALUES(1988, 121, 'V', 'Vaduz', 'Russian');

INSERT INTO emkt_countries VALUES (122,'Литва','Russian','LT','LTU','');

INSERT INTO emkt_regions VALUES(1989, 122, 'AL', 'Alytaus Apskritis', 'Russian');
INSERT INTO emkt_regions VALUES(1990, 122, 'KL', 'Klaipėdos Apskritis', 'Russian');
INSERT INTO emkt_regions VALUES(1991, 122, 'KU', 'Kauno Apskritis', 'Russian');
INSERT INTO emkt_regions VALUES(1992, 122, 'MR', 'Marijampolės Apskritis', 'Russian');
INSERT INTO emkt_regions VALUES(1993, 122, 'PN', 'Panevėžio Apskritis', 'Russian');
INSERT INTO emkt_regions VALUES(1994, 122, 'SA', 'Šiaulių Apskritis', 'Russian');
INSERT INTO emkt_regions VALUES(1995, 122, 'TA', 'Tauragės Apskritis', 'Russian');
INSERT INTO emkt_regions VALUES(1996, 122, 'TE', 'Telšių Apskritis', 'Russian');
INSERT INTO emkt_regions VALUES(1997, 122, 'UT', 'Utenos Apskritis', 'Russian');
INSERT INTO emkt_regions VALUES(1998, 122, 'VL', 'Vilniaus Apskritis', 'Russian');

INSERT INTO emkt_countries VALUES (123,'Люксембург','Russian','LU','LUX','');

INSERT INTO emkt_regions VALUES(1999, 123, 'D', 'Diekirch', 'Russian');
INSERT INTO emkt_regions VALUES(2000, 123, 'G', 'Grevenmacher', 'Russian');
INSERT INTO emkt_regions VALUES(2001, 123, 'L', 'Luxemburg', 'Russian');

INSERT INTO emkt_countries VALUES (124,'Макао','Russian','MO','MAC','');

INSERT INTO emkt_regions VALUES(2002, 124, 'I', '海島市', 'Russian');
INSERT INTO emkt_regions VALUES(2003, 124, 'M', '澳門市', 'Russian');

INSERT INTO emkt_countries VALUES (125,'Македония','Russian','MK','MKD','');

INSERT INTO emkt_regions VALUES(2004, 125, 'BR', 'Berovo', 'Russian');
INSERT INTO emkt_regions VALUES(2005, 125, 'CH', 'Чешиново-Облешево', 'Russian');
INSERT INTO emkt_regions VALUES(2006, 125, 'DL', 'Делчево', 'Russian');
INSERT INTO emkt_regions VALUES(2007, 125, 'KB', 'Карбинци', 'Russian');
INSERT INTO emkt_regions VALUES(2008, 125, 'OC', 'Кочани', 'Russian');
INSERT INTO emkt_regions VALUES(2009, 125, 'LO', 'Лозово', 'Russian');
INSERT INTO emkt_regions VALUES(2010, 125, 'MK', 'Македонска каменица', 'Russian');
INSERT INTO emkt_regions VALUES(2011, 125, 'PH', 'Пехчево', 'Russian');
INSERT INTO emkt_regions VALUES(2012, 125, 'PT', 'Пробиштип', 'Russian');
INSERT INTO emkt_regions VALUES(2013, 125, 'ST', 'Штип', 'Russian');
INSERT INTO emkt_regions VALUES(2014, 125, 'SL', 'Свети Николе', 'Russian');
INSERT INTO emkt_regions VALUES(2015, 125, 'NI', 'Виница', 'Russian');
INSERT INTO emkt_regions VALUES(2016, 125, 'ZR', 'Зрновци', 'Russian');
INSERT INTO emkt_regions VALUES(2017, 125, 'KY', 'Кратово', 'Russian');
INSERT INTO emkt_regions VALUES(2018, 125, 'KZ', 'Крива Паланка', 'Russian');
INSERT INTO emkt_regions VALUES(2019, 125, 'UM', 'Куманово', 'Russian');
INSERT INTO emkt_regions VALUES(2020, 125, 'LI', 'Липково', 'Russian');
INSERT INTO emkt_regions VALUES(2021, 125, 'RN', 'Ранковце', 'Russian');
INSERT INTO emkt_regions VALUES(2022, 125, 'NA', 'Старо Нагоричане', 'Russian');
INSERT INTO emkt_regions VALUES(2023, 125, 'TL', 'Битола', 'Russian');
INSERT INTO emkt_regions VALUES(2024, 125, 'DM', 'Демир Хисар', 'Russian');
INSERT INTO emkt_regions VALUES(2025, 125, 'DE', 'Долнени', 'Russian');
INSERT INTO emkt_regions VALUES(2026, 125, 'KG', 'Кривогаштани', 'Russian');
INSERT INTO emkt_regions VALUES(2027, 125, 'KS', 'Крушево', 'Russian');
INSERT INTO emkt_regions VALUES(2028, 125, 'MG', 'Могила', 'Russian');
INSERT INTO emkt_regions VALUES(2029, 125, 'NV', 'Новаци', 'Russian');
INSERT INTO emkt_regions VALUES(2030, 125, 'PP', 'Прилеп', 'Russian');
INSERT INTO emkt_regions VALUES(2031, 125, 'RE', 'Ресен', 'Russian');
INSERT INTO emkt_regions VALUES(2032, 125, 'VJ', 'Боговиње', 'Russian');
INSERT INTO emkt_regions VALUES(2033, 125, 'BN', 'Брвеница', 'Russian');
INSERT INTO emkt_regions VALUES(2034, 125, 'GT', 'Гостивар', 'Russian');
INSERT INTO emkt_regions VALUES(2035, 125, 'JG', 'Јегуновце', 'Russian');
INSERT INTO emkt_regions VALUES(2036, 125, 'MR', 'Маврово и Ростуша', 'Russian');
INSERT INTO emkt_regions VALUES(2037, 125, 'TR', 'Теарце', 'Russian');
INSERT INTO emkt_regions VALUES(2038, 125, 'ET', 'Тетово', 'Russian');
INSERT INTO emkt_regions VALUES(2039, 125, 'VH', 'Врапчиште', 'Russian');
INSERT INTO emkt_regions VALUES(2040, 125, 'ZE', 'Желино', 'Russian');
INSERT INTO emkt_regions VALUES(2041, 125, 'AD', 'Аеродром', 'Russian');
INSERT INTO emkt_regions VALUES(2042, 125, 'AR', 'Арачиново', 'Russian');
INSERT INTO emkt_regions VALUES(2043, 125, 'BU', 'Бутел', 'Russian');
INSERT INTO emkt_regions VALUES(2044, 125, 'CI', 'Чаир', 'Russian');
INSERT INTO emkt_regions VALUES(2045, 125, 'CE', 'Центар', 'Russian');
INSERT INTO emkt_regions VALUES(2046, 125, 'CS', 'Чучер Сандево', 'Russian');
INSERT INTO emkt_regions VALUES(2047, 125, 'GB', 'Гази Баба', 'Russian');
INSERT INTO emkt_regions VALUES(2048, 125, 'GP', 'Ѓорче Петров', 'Russian');
INSERT INTO emkt_regions VALUES(2049, 125, 'IL', 'Илинден', 'Russian');
INSERT INTO emkt_regions VALUES(2050, 125, 'KX', 'Карпош', 'Russian');
INSERT INTO emkt_regions VALUES(2051, 125, 'VD', 'Кисела Вода', 'Russian');
INSERT INTO emkt_regions VALUES(2052, 125, 'PE', 'Петровец', 'Russian');
INSERT INTO emkt_regions VALUES(2053, 125, 'AJ', 'Сарај', 'Russian');
INSERT INTO emkt_regions VALUES(2054, 125, 'SS', 'Сопиште', 'Russian');
INSERT INTO emkt_regions VALUES(2055, 125, 'SU', 'Студеничани', 'Russian');
INSERT INTO emkt_regions VALUES(2056, 125, 'SO', 'Шуто Оризари', 'Russian');
INSERT INTO emkt_regions VALUES(2057, 125, 'ZK', 'Зелениково', 'Russian');
INSERT INTO emkt_regions VALUES(2058, 125, 'BG', 'Богданци', 'Russian');
INSERT INTO emkt_regions VALUES(2059, 125, 'BS', 'Босилово', 'Russian');
INSERT INTO emkt_regions VALUES(2060, 125, 'GV', 'Гевгелија', 'Russian');
INSERT INTO emkt_regions VALUES(2061, 125, 'KN', 'Конче', 'Russian');
INSERT INTO emkt_regions VALUES(2062, 125, 'NS', 'Ново Село', 'Russian');
INSERT INTO emkt_regions VALUES(2063, 125, 'RV', 'Радовиш', 'Russian');
INSERT INTO emkt_regions VALUES(2064, 125, 'SD', 'Стар Дојран', 'Russian');
INSERT INTO emkt_regions VALUES(2065, 125, 'RU', 'Струмица', 'Russian');
INSERT INTO emkt_regions VALUES(2066, 125, 'VA', 'Валандово', 'Russian');
INSERT INTO emkt_regions VALUES(2067, 125, 'VL', 'Василево', 'Russian');
INSERT INTO emkt_regions VALUES(2068, 125, 'CZ', 'Центар Жупа', 'Russian');
INSERT INTO emkt_regions VALUES(2069, 125, 'DB', 'Дебар', 'Russian');
INSERT INTO emkt_regions VALUES(2070, 125, 'DA', 'Дебарца', 'Russian');
INSERT INTO emkt_regions VALUES(2071, 125, 'DR', 'Другово', 'Russian');
INSERT INTO emkt_regions VALUES(2072, 125, 'KH', 'Кичево', 'Russian');
INSERT INTO emkt_regions VALUES(2073, 125, 'MD', 'Македонски Брод', 'Russian');
INSERT INTO emkt_regions VALUES(2074, 125, 'OD', 'Охрид', 'Russian');
INSERT INTO emkt_regions VALUES(2075, 125, 'OS', 'Осломеј', 'Russian');
INSERT INTO emkt_regions VALUES(2076, 125, 'PN', 'Пласница', 'Russian');
INSERT INTO emkt_regions VALUES(2077, 125, 'UG', 'Струга', 'Russian');
INSERT INTO emkt_regions VALUES(2078, 125, 'VV', 'Вевчани', 'Russian');
INSERT INTO emkt_regions VALUES(2079, 125, 'VC', 'Вранештица', 'Russian');
INSERT INTO emkt_regions VALUES(2080, 125, 'ZA', 'Зајас', 'Russian');
INSERT INTO emkt_regions VALUES(2081, 125, 'CA', 'Чашка', 'Russian');
INSERT INTO emkt_regions VALUES(2082, 125, 'DK', 'Демир Капија', 'Russian');
INSERT INTO emkt_regions VALUES(2083, 125, 'GR', 'Градско', 'Russian');
INSERT INTO emkt_regions VALUES(2084, 125, 'AV', 'Кавадарци', 'Russian');
INSERT INTO emkt_regions VALUES(2085, 125, 'NG', 'Неготино', 'Russian');
INSERT INTO emkt_regions VALUES(2086, 125, 'RM', 'Росоман', 'Russian');
INSERT INTO emkt_regions VALUES(2087, 125, 'VE', 'Велес', 'Russian');

INSERT INTO emkt_countries VALUES (126,'Мадагаскар','Russian','MG','MDG','');

INSERT INTO emkt_regions VALUES(2088, 126, 'A', 'Toamasina', 'Russian');
INSERT INTO emkt_regions VALUES(2089, 126, 'D', 'Antsiranana', 'Russian');
INSERT INTO emkt_regions VALUES(2090, 126, 'F', 'Fianarantsoa', 'Russian');
INSERT INTO emkt_regions VALUES(2091, 126, 'M', 'Mahajanga', 'Russian');
INSERT INTO emkt_regions VALUES(2092, 126, 'T', 'Antananarivo', 'Russian');
INSERT INTO emkt_regions VALUES(2093, 126, 'U', 'Toliara', 'Russian');

INSERT INTO emkt_countries VALUES (127,'Малави','Russian','MW','MWI','');

INSERT INTO emkt_regions VALUES(2094, 127, 'BA', 'Balaka', 'Russian');
INSERT INTO emkt_regions VALUES(2095, 127, 'BL', 'Blantyre', 'Russian');
INSERT INTO emkt_regions VALUES(2096, 127, 'C', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(2097, 127, 'CK', 'Chikwawa', 'Russian');
INSERT INTO emkt_regions VALUES(2098, 127, 'CR', 'Chiradzulu', 'Russian');
INSERT INTO emkt_regions VALUES(2099, 127, 'CT', 'Chitipa', 'Russian');
INSERT INTO emkt_regions VALUES(2100, 127, 'DE', 'Dedza', 'Russian');
INSERT INTO emkt_regions VALUES(2101, 127, 'DO', 'Dowa', 'Russian');
INSERT INTO emkt_regions VALUES(2102, 127, 'KR', 'Karonga', 'Russian');
INSERT INTO emkt_regions VALUES(2103, 127, 'KS', 'Kasungu', 'Russian');
INSERT INTO emkt_regions VALUES(2104, 127, 'LK', 'Likoma Island', 'Russian');
INSERT INTO emkt_regions VALUES(2105, 127, 'LI', 'Lilongwe', 'Russian');
INSERT INTO emkt_regions VALUES(2106, 127, 'MH', 'Machinga', 'Russian');
INSERT INTO emkt_regions VALUES(2107, 127, 'MG', 'Mangochi', 'Russian');
INSERT INTO emkt_regions VALUES(2108, 127, 'MC', 'Mchinji', 'Russian');
INSERT INTO emkt_regions VALUES(2109, 127, 'MU', 'Mulanje', 'Russian');
INSERT INTO emkt_regions VALUES(2110, 127, 'MW', 'Mwanza', 'Russian');
INSERT INTO emkt_regions VALUES(2111, 127, 'MZ', 'Mzimba', 'Russian');
INSERT INTO emkt_regions VALUES(2112, 127, 'N', 'Northern', 'Russian');
INSERT INTO emkt_regions VALUES(2113, 127, 'NB', 'Nkhata', 'Russian');
INSERT INTO emkt_regions VALUES(2114, 127, 'NK', 'Nkhotakota', 'Russian');
INSERT INTO emkt_regions VALUES(2115, 127, 'NS', 'Nsanje', 'Russian');
INSERT INTO emkt_regions VALUES(2116, 127, 'NU', 'Ntcheu', 'Russian');
INSERT INTO emkt_regions VALUES(2117, 127, 'NI', 'Ntchisi', 'Russian');
INSERT INTO emkt_regions VALUES(2118, 127, 'PH', 'Phalombe', 'Russian');
INSERT INTO emkt_regions VALUES(2119, 127, 'RU', 'Rumphi', 'Russian');
INSERT INTO emkt_regions VALUES(2120, 127, 'S', 'Southern', 'Russian');
INSERT INTO emkt_regions VALUES(2121, 127, 'SA', 'Salima', 'Russian');
INSERT INTO emkt_regions VALUES(2122, 127, 'TH', 'Thyolo', 'Russian');
INSERT INTO emkt_regions VALUES(2123, 127, 'ZO', 'Zomba', 'Russian');

INSERT INTO emkt_countries VALUES (128,'Малайзия','Russian','MY','MYS','');

INSERT INTO emkt_regions VALUES(2124, 128, '01', 'Johor Darul Takzim', 'Russian');
INSERT INTO emkt_regions VALUES(2125, 128, '02', 'Kedah Darul Aman', 'Russian');
INSERT INTO emkt_regions VALUES(2126, 128, '03', 'Kelantan Darul Naim', 'Russian');
INSERT INTO emkt_regions VALUES(2127, 128, '04', 'Melaka Negeri Bersejarah', 'Russian');
INSERT INTO emkt_regions VALUES(2128, 128, '05', 'Negeri Sembilan Darul Khusus', 'Russian');
INSERT INTO emkt_regions VALUES(2129, 128, '06', 'Pahang Darul Makmur', 'Russian');
INSERT INTO emkt_regions VALUES(2130, 128, '07', 'Pulau Pinang', 'Russian');
INSERT INTO emkt_regions VALUES(2131, 128, '08', 'Perak Darul Ridzuan', 'Russian');
INSERT INTO emkt_regions VALUES(2132, 128, '09', 'Perlis Indera Kayangan', 'Russian');
INSERT INTO emkt_regions VALUES(2133, 128, '10', 'Selangor Darul Ehsan', 'Russian');
INSERT INTO emkt_regions VALUES(2134, 128, '11', 'Terengganu Darul Iman', 'Russian');
INSERT INTO emkt_regions VALUES(2135, 128, '12', 'Sabah Negeri Di Bawah Bayu', 'Russian');
INSERT INTO emkt_regions VALUES(2136, 128, '13', 'Sarawak Bumi Kenyalang', 'Russian');
INSERT INTO emkt_regions VALUES(2137, 128, '14', 'Wilayah Persekutuan Kuala Lumpur', 'Russian');
INSERT INTO emkt_regions VALUES(2138, 128, '15', 'Wilayah Persekutuan Labuan', 'Russian');
INSERT INTO emkt_regions VALUES(2139, 128, '16', 'Wilayah Persekutuan Putrajaya', 'Russian');

INSERT INTO emkt_countries VALUES (129,'Мальдивы','Russian','MV','MDV','');

INSERT INTO emkt_regions VALUES(2140, 129, 'THU', 'Thiladhunmathi Uthuru', 'Russian');
INSERT INTO emkt_regions VALUES(2141, 129, 'THD', 'Thiladhunmathi Dhekunu', 'Russian');
INSERT INTO emkt_regions VALUES(2142, 129, 'MLU', 'Miladhunmadulu Uthuru', 'Russian');
INSERT INTO emkt_regions VALUES(2143, 129, 'MLD', 'Miladhunmadulu Dhekunu', 'Russian');
INSERT INTO emkt_regions VALUES(2144, 129, 'MAU', 'Maalhosmadulu Uthuru', 'Russian');
INSERT INTO emkt_regions VALUES(2145, 129, 'MAD', 'Maalhosmadulu Dhekunu', 'Russian');
INSERT INTO emkt_regions VALUES(2146, 129, 'FAA', 'Faadhippolhu', 'Russian');
INSERT INTO emkt_regions VALUES(2147, 129, 'MAA', 'Male Atoll', 'Russian');
INSERT INTO emkt_regions VALUES(2148, 129, 'AAU', 'Ari Atoll Uthuru', 'Russian');
INSERT INTO emkt_regions VALUES(2149, 129, 'AAD', 'Ari Atoll Dheknu', 'Russian');
INSERT INTO emkt_regions VALUES(2150, 129, 'FEA', 'Felidhe Atoll', 'Russian');
INSERT INTO emkt_regions VALUES(2151, 129, 'MUA', 'Mulaku Atoll', 'Russian');
INSERT INTO emkt_regions VALUES(2152, 129, 'NAU', 'Nilandhe Atoll Uthuru', 'Russian');
INSERT INTO emkt_regions VALUES(2153, 129, 'NAD', 'Nilandhe Atoll Dhekunu', 'Russian');
INSERT INTO emkt_regions VALUES(2154, 129, 'KLH', 'Kolhumadulu', 'Russian');
INSERT INTO emkt_regions VALUES(2155, 129, 'HDH', 'Hadhdhunmathi', 'Russian');
INSERT INTO emkt_regions VALUES(2156, 129, 'HAU', 'Huvadhu Atoll Uthuru', 'Russian');
INSERT INTO emkt_regions VALUES(2157, 129, 'HAD', 'Huvadhu Atoll Dhekunu', 'Russian');
INSERT INTO emkt_regions VALUES(2158, 129, 'FMU', 'Fua Mulaku', 'Russian');
INSERT INTO emkt_regions VALUES(2159, 129, 'ADD', 'Addu', 'Russian');

INSERT INTO emkt_countries VALUES (130,'Мали','Russian','ML','MLI','');

INSERT INTO emkt_regions VALUES(2160, 130, '1', 'Kayes', 'Russian');
INSERT INTO emkt_regions VALUES(2161, 130, '2', 'Koulikoro', 'Russian');
INSERT INTO emkt_regions VALUES(2162, 130, '3', 'Sikasso', 'Russian');
INSERT INTO emkt_regions VALUES(2163, 130, '4', 'Ségou', 'Russian');
INSERT INTO emkt_regions VALUES(2164, 130, '5', 'Mopti', 'Russian');
INSERT INTO emkt_regions VALUES(2165, 130, '6', 'Tombouctou', 'Russian');
INSERT INTO emkt_regions VALUES(2166, 130, '7', 'Gao', 'Russian');
INSERT INTO emkt_regions VALUES(2167, 130, '8', 'Kidal', 'Russian');
INSERT INTO emkt_regions VALUES(2168, 130, 'BK0', 'Bamako', 'Russian');

INSERT INTO emkt_countries VALUES (131,'Мальта','Russian','MT','MLT','');

INSERT INTO emkt_regions VALUES(2169, 131, 'ATT', 'Attard', 'Russian');
INSERT INTO emkt_regions VALUES(2170, 131, 'BAL', 'Balzan', 'Russian');
INSERT INTO emkt_regions VALUES(2171, 131, 'BGU', 'Birgu', 'Russian');
INSERT INTO emkt_regions VALUES(2172, 131, 'BKK', 'Birkirkara', 'Russian');
INSERT INTO emkt_regions VALUES(2173, 131, 'BRZ', 'Birzebbuga', 'Russian');
INSERT INTO emkt_regions VALUES(2174, 131, 'BOR', 'Bormla', 'Russian');
INSERT INTO emkt_regions VALUES(2175, 131, 'DIN', 'Dingli', 'Russian');
INSERT INTO emkt_regions VALUES(2176, 131, 'FGU', 'Fgura', 'Russian');
INSERT INTO emkt_regions VALUES(2177, 131, 'FLO', 'Floriana', 'Russian');
INSERT INTO emkt_regions VALUES(2178, 131, 'GDJ', 'Gudja', 'Russian');
INSERT INTO emkt_regions VALUES(2179, 131, 'GZR', 'Gzira', 'Russian');
INSERT INTO emkt_regions VALUES(2180, 131, 'GRG', 'Gargur', 'Russian');
INSERT INTO emkt_regions VALUES(2181, 131, 'GXQ', 'Gaxaq', 'Russian');
INSERT INTO emkt_regions VALUES(2182, 131, 'HMR', 'Hamrun', 'Russian');
INSERT INTO emkt_regions VALUES(2183, 131, 'IKL', 'Iklin', 'Russian');
INSERT INTO emkt_regions VALUES(2184, 131, 'ISL', 'Isla', 'Russian');
INSERT INTO emkt_regions VALUES(2185, 131, 'KLK', 'Kalkara', 'Russian');
INSERT INTO emkt_regions VALUES(2186, 131, 'KRK', 'Kirkop', 'Russian');
INSERT INTO emkt_regions VALUES(2187, 131, 'LIJ', 'Lija', 'Russian');
INSERT INTO emkt_regions VALUES(2188, 131, 'LUQ', 'Luqa', 'Russian');
INSERT INTO emkt_regions VALUES(2189, 131, 'MRS', 'Marsa', 'Russian');
INSERT INTO emkt_regions VALUES(2190, 131, 'MKL', 'Marsaskala', 'Russian');
INSERT INTO emkt_regions VALUES(2191, 131, 'MXL', 'Marsaxlokk', 'Russian');
INSERT INTO emkt_regions VALUES(2192, 131, 'MDN', 'Mdina', 'Russian');
INSERT INTO emkt_regions VALUES(2193, 131, 'MEL', 'Melliea', 'Russian');
INSERT INTO emkt_regions VALUES(2194, 131, 'MGR', 'Mgarr', 'Russian');
INSERT INTO emkt_regions VALUES(2195, 131, 'MST', 'Mosta', 'Russian');
INSERT INTO emkt_regions VALUES(2196, 131, 'MQA', 'Mqabba', 'Russian');
INSERT INTO emkt_regions VALUES(2197, 131, 'MSI', 'Msida', 'Russian');
INSERT INTO emkt_regions VALUES(2198, 131, 'MTF', 'Mtarfa', 'Russian');
INSERT INTO emkt_regions VALUES(2199, 131, 'NAX', 'Naxxar', 'Russian');
INSERT INTO emkt_regions VALUES(2200, 131, 'PAO', 'Paola', 'Russian');
INSERT INTO emkt_regions VALUES(2201, 131, 'PEM', 'Pembroke', 'Russian');
INSERT INTO emkt_regions VALUES(2202, 131, 'PIE', 'Pieta', 'Russian');
INSERT INTO emkt_regions VALUES(2203, 131, 'QOR', 'Qormi', 'Russian');
INSERT INTO emkt_regions VALUES(2204, 131, 'QRE', 'Qrendi', 'Russian');
INSERT INTO emkt_regions VALUES(2205, 131, 'RAB', 'Rabat', 'Russian');
INSERT INTO emkt_regions VALUES(2206, 131, 'SAF', 'Safi', 'Russian');
INSERT INTO emkt_regions VALUES(2207, 131, 'SGI', 'San Giljan', 'Russian');
INSERT INTO emkt_regions VALUES(2208, 131, 'SLU', 'Santa Lucija', 'Russian');
INSERT INTO emkt_regions VALUES(2209, 131, 'SPB', 'San Pawl il-Bahar', 'Russian');
INSERT INTO emkt_regions VALUES(2210, 131, 'SGW', 'San Gwann', 'Russian');
INSERT INTO emkt_regions VALUES(2211, 131, 'SVE', 'Santa Venera', 'Russian');
INSERT INTO emkt_regions VALUES(2212, 131, 'SIG', 'Siggiewi', 'Russian');
INSERT INTO emkt_regions VALUES(2213, 131, 'SLM', 'Sliema', 'Russian');
INSERT INTO emkt_regions VALUES(2214, 131, 'SWQ', 'Swieqi', 'Russian');
INSERT INTO emkt_regions VALUES(2215, 131, 'TXB', 'Ta Xbiex', 'Russian');
INSERT INTO emkt_regions VALUES(2216, 131, 'TRX', 'Tarxien', 'Russian');
INSERT INTO emkt_regions VALUES(2217, 131, 'VLT', 'Valletta', 'Russian');
INSERT INTO emkt_regions VALUES(2218, 131, 'XGJ', 'Xgajra', 'Russian');
INSERT INTO emkt_regions VALUES(2219, 131, 'ZBR', 'Zabbar', 'Russian');
INSERT INTO emkt_regions VALUES(2220, 131, 'ZBG', 'Zebbug', 'Russian');
INSERT INTO emkt_regions VALUES(2221, 131, 'ZJT', 'Zejtun', 'Russian');
INSERT INTO emkt_regions VALUES(2222, 131, 'ZRQ', 'Zurrieq', 'Russian');
INSERT INTO emkt_regions VALUES(2223, 131, 'FNT', 'Fontana', 'Russian');
INSERT INTO emkt_regions VALUES(2224, 131, 'GHJ', 'Ghajnsielem', 'Russian');
INSERT INTO emkt_regions VALUES(2225, 131, 'GHR', 'Gharb', 'Russian');
INSERT INTO emkt_regions VALUES(2226, 131, 'GHS', 'Ghasri', 'Russian');
INSERT INTO emkt_regions VALUES(2227, 131, 'KRC', 'Kercem', 'Russian');
INSERT INTO emkt_regions VALUES(2228, 131, 'MUN', 'Munxar', 'Russian');
INSERT INTO emkt_regions VALUES(2229, 131, 'NAD', 'Nadur', 'Russian');
INSERT INTO emkt_regions VALUES(2230, 131, 'QAL', 'Qala', 'Russian');
INSERT INTO emkt_regions VALUES(2231, 131, 'VIC', 'Victoria', 'Russian');
INSERT INTO emkt_regions VALUES(2232, 131, 'SLA', 'San Lawrenz', 'Russian');
INSERT INTO emkt_regions VALUES(2233, 131, 'SNT', 'Sannat', 'Russian');
INSERT INTO emkt_regions VALUES(2234, 131, 'ZAG', 'Xagra', 'Russian');
INSERT INTO emkt_regions VALUES(2235, 131, 'XEW', 'Xewkija', 'Russian');
INSERT INTO emkt_regions VALUES(2236, 131, 'ZEB', 'Zebbug', 'Russian');

INSERT INTO emkt_countries VALUES (132,'Маршалловы Острова','Russian','MH','MHL','');

INSERT INTO emkt_regions VALUES(2237, 132, 'ALK', 'Ailuk', 'Russian');
INSERT INTO emkt_regions VALUES(2238, 132, 'ALL', 'Ailinglapalap', 'Russian');
INSERT INTO emkt_regions VALUES(2239, 132, 'ARN', 'Arno', 'Russian');
INSERT INTO emkt_regions VALUES(2240, 132, 'AUR', 'Aur', 'Russian');
INSERT INTO emkt_regions VALUES(2241, 132, 'EBO', 'Ebon', 'Russian');
INSERT INTO emkt_regions VALUES(2242, 132, 'ENI', 'Eniwetok', 'Russian');
INSERT INTO emkt_regions VALUES(2243, 132, 'JAB', 'Jabat', 'Russian');
INSERT INTO emkt_regions VALUES(2244, 132, 'JAL', 'Jaluit', 'Russian');
INSERT INTO emkt_regions VALUES(2245, 132, 'KIL', 'Kili', 'Russian');
INSERT INTO emkt_regions VALUES(2246, 132, 'KWA', 'Kwajalein', 'Russian');
INSERT INTO emkt_regions VALUES(2247, 132, 'LAE', 'Lae', 'Russian');
INSERT INTO emkt_regions VALUES(2248, 132, 'LIB', 'Lib', 'Russian');
INSERT INTO emkt_regions VALUES(2249, 132, 'LIK', 'Likiep', 'Russian');
INSERT INTO emkt_regions VALUES(2250, 132, 'MAJ', 'Majuro', 'Russian');
INSERT INTO emkt_regions VALUES(2251, 132, 'MAL', 'Maloelap', 'Russian');
INSERT INTO emkt_regions VALUES(2252, 132, 'MEJ', 'Mejit', 'Russian');
INSERT INTO emkt_regions VALUES(2253, 132, 'MIL', 'Mili', 'Russian');
INSERT INTO emkt_regions VALUES(2254, 132, 'NMK', 'Namorik', 'Russian');
INSERT INTO emkt_regions VALUES(2255, 132, 'NMU', 'Namu', 'Russian');
INSERT INTO emkt_regions VALUES(2256, 132, 'RON', 'Rongelap', 'Russian');
INSERT INTO emkt_regions VALUES(2257, 132, 'UJA', 'Ujae', 'Russian');
INSERT INTO emkt_regions VALUES(2258, 132, 'UJL', 'Ujelang', 'Russian');
INSERT INTO emkt_regions VALUES(2259, 132, 'UTI', 'Utirik', 'Russian');
INSERT INTO emkt_regions VALUES(2260, 132, 'WTJ', 'Wotje', 'Russian');
INSERT INTO emkt_regions VALUES(2261, 132, 'WTN', 'Wotho', 'Russian');

INSERT INTO emkt_countries VALUES (133,'Мартиника','Russian','MQ','MTQ','');

INSERT INTO emkt_regions VALUES(4264, 133, 'NOCODE', 'Martinique', 'Russian');

INSERT INTO emkt_countries VALUES (134,'Мавритания','Russian','MR','MRT','');

INSERT INTO emkt_regions VALUES(2262, 134, '01', 'ولاية الحوض الشرقي', 'Russian');
INSERT INTO emkt_regions VALUES(2263, 134, '02', 'ولاية الحوض الغربي', 'Russian');
INSERT INTO emkt_regions VALUES(2264, 134, '03', 'ولاية العصابة', 'Russian');
INSERT INTO emkt_regions VALUES(2265, 134, '04', 'ولاية كركول', 'Russian');
INSERT INTO emkt_regions VALUES(2266, 134, '05', 'ولاية البراكنة', 'Russian');
INSERT INTO emkt_regions VALUES(2267, 134, '06', 'ولاية الترارزة', 'Russian');
INSERT INTO emkt_regions VALUES(2268, 134, '07', 'ولاية آدرار', 'Russian');
INSERT INTO emkt_regions VALUES(2269, 134, '08', 'ولاية داخلت نواذيبو', 'Russian');
INSERT INTO emkt_regions VALUES(2270, 134, '09', 'ولاية تكانت', 'Russian');
INSERT INTO emkt_regions VALUES(2271, 134, '10', 'ولاية كيدي ماغة', 'Russian');
INSERT INTO emkt_regions VALUES(2272, 134, '11', 'ولاية تيرس زمور', 'Russian');
INSERT INTO emkt_regions VALUES(2273, 134, '12', 'ولاية إينشيري', 'Russian');
INSERT INTO emkt_regions VALUES(2274, 134, 'NKC', 'نواكشوط', 'Russian');

INSERT INTO emkt_countries VALUES (135,'Маврикий','Russian','MU','MUS','');

INSERT INTO emkt_regions VALUES(2275, 135, 'AG', 'Agalega Islands', 'Russian');
INSERT INTO emkt_regions VALUES(2276, 135, 'BL', 'Black River', 'Russian');
INSERT INTO emkt_regions VALUES(2277, 135, 'BR', 'Beau Bassin-Rose Hill', 'Russian');
INSERT INTO emkt_regions VALUES(2278, 135, 'CC', 'Cargados Carajos Shoals', 'Russian');
INSERT INTO emkt_regions VALUES(2279, 135, 'CU', 'Curepipe', 'Russian');
INSERT INTO emkt_regions VALUES(2280, 135, 'FL', 'Flacq', 'Russian');
INSERT INTO emkt_regions VALUES(2281, 135, 'GP', 'Grand Port', 'Russian');
INSERT INTO emkt_regions VALUES(2282, 135, 'MO', 'Moka', 'Russian');
INSERT INTO emkt_regions VALUES(2283, 135, 'PA', 'Pamplemousses', 'Russian');
INSERT INTO emkt_regions VALUES(2284, 135, 'PL', 'Port Louis', 'Russian');
INSERT INTO emkt_regions VALUES(2285, 135, 'PU', 'Port Louis City', 'Russian');
INSERT INTO emkt_regions VALUES(2286, 135, 'PW', 'Plaines Wilhems', 'Russian');
INSERT INTO emkt_regions VALUES(2287, 135, 'QB', 'Quatre Bornes', 'Russian');
INSERT INTO emkt_regions VALUES(2288, 135, 'RO', 'Rodrigues', 'Russian');
INSERT INTO emkt_regions VALUES(2289, 135, 'RR', 'Riviere du Rempart', 'Russian');
INSERT INTO emkt_regions VALUES(2290, 135, 'SA', 'Savanne', 'Russian');
INSERT INTO emkt_regions VALUES(2291, 135, 'VP', 'Vacoas-Phoenix', 'Russian');

INSERT INTO emkt_countries VALUES (136,'Майотта','Russian','YT','MYT','');

INSERT INTO emkt_regions VALUES(4265, 136, 'NOCODE', 'Mayotte', 'Russian');

INSERT INTO emkt_countries VALUES (137,'Мексика','Russian','MX','MEX','');

INSERT INTO emkt_regions VALUES(2292, 137, 'AGU', 'Aguascalientes', 'Russian');
INSERT INTO emkt_regions VALUES(2293, 137, 'BCN', 'Baja California', 'Russian');
INSERT INTO emkt_regions VALUES(2294, 137, 'BCS', 'Baja California Sur', 'Russian');
INSERT INTO emkt_regions VALUES(2295, 137, 'CAM', 'Campeche', 'Russian');
INSERT INTO emkt_regions VALUES(2296, 137, 'CHH', 'Chihuahua', 'Russian');
INSERT INTO emkt_regions VALUES(2297, 137, 'CHP', 'Chiapas', 'Russian');
INSERT INTO emkt_regions VALUES(2298, 137, 'COA', 'Coahuila', 'Russian');
INSERT INTO emkt_regions VALUES(2299, 137, 'COL', 'Colima', 'Russian');
INSERT INTO emkt_regions VALUES(2300, 137, 'DIF', 'Distrito Federal', 'Russian');
INSERT INTO emkt_regions VALUES(2301, 137, 'DUR', 'Durango', 'Russian');
INSERT INTO emkt_regions VALUES(2302, 137, 'GRO', 'Guerrero', 'Russian');
INSERT INTO emkt_regions VALUES(2303, 137, 'GUA', 'Guanajuato', 'Russian');
INSERT INTO emkt_regions VALUES(2304, 137, 'HID', 'Hidalgo', 'Russian');
INSERT INTO emkt_regions VALUES(2305, 137, 'JAL', 'Jalisco', 'Russian');
INSERT INTO emkt_regions VALUES(2306, 137, 'MEX', 'Mexico', 'Russian');
INSERT INTO emkt_regions VALUES(2307, 137, 'MIC', 'Michoacán', 'Russian');
INSERT INTO emkt_regions VALUES(2308, 137, 'MOR', 'Morelos', 'Russian');
INSERT INTO emkt_regions VALUES(2309, 137, 'NAY', 'Nayarit', 'Russian');
INSERT INTO emkt_regions VALUES(2310, 137, 'NLE', 'Nuevo León', 'Russian');
INSERT INTO emkt_regions VALUES(2311, 137, 'OAX', 'Oaxaca', 'Russian');
INSERT INTO emkt_regions VALUES(2312, 137, 'PUE', 'Puebla', 'Russian');
INSERT INTO emkt_regions VALUES(2313, 137, 'QUE', 'Querétaro', 'Russian');
INSERT INTO emkt_regions VALUES(2314, 137, 'ROO', 'Quintana Roo', 'Russian');
INSERT INTO emkt_regions VALUES(2315, 137, 'SIN', 'Sinaloa', 'Russian');
INSERT INTO emkt_regions VALUES(2316, 137, 'SLP', 'San Luis Potosí', 'Russian');
INSERT INTO emkt_regions VALUES(2317, 137, 'SON', 'Sonora', 'Russian');
INSERT INTO emkt_regions VALUES(2318, 137, 'TAB', 'Tabasco', 'Russian');
INSERT INTO emkt_regions VALUES(2319, 137, 'TAM', 'Tamaulipas', 'Russian');
INSERT INTO emkt_regions VALUES(2320, 137, 'TLA', 'Tlaxcala', 'Russian');
INSERT INTO emkt_regions VALUES(2321, 137, 'VER', 'Veracruz', 'Russian');
INSERT INTO emkt_regions VALUES(2322, 137, 'YUC', 'Yucatan', 'Russian');
INSERT INTO emkt_regions VALUES(2323, 137, 'ZAC', 'Zacatecas', 'Russian');

INSERT INTO emkt_countries VALUES (138,'Федеративные Штаты Микронезии','Russian','FM','FSM','');

INSERT INTO emkt_regions VALUES(2324, 138, 'KSA', 'Kosrae', 'Russian');
INSERT INTO emkt_regions VALUES(2325, 138, 'PNI', 'Pohnpei', 'Russian');
INSERT INTO emkt_regions VALUES(2326, 138, 'TRK', 'Chuuk', 'Russian');
INSERT INTO emkt_regions VALUES(2327, 138, 'YAP', 'Yap', 'Russian');

INSERT INTO emkt_countries VALUES (139,'Молдавия','Russian','MD','MDA','');

INSERT INTO emkt_regions VALUES(2328, 139, 'BA', 'Bălţi', 'Russian');
INSERT INTO emkt_regions VALUES(2329, 139, 'CA', 'Cahul', 'Russian');
INSERT INTO emkt_regions VALUES(2330, 139, 'CU', 'Chişinău', 'Russian');
INSERT INTO emkt_regions VALUES(2331, 139, 'ED', 'Edineţ', 'Russian');
INSERT INTO emkt_regions VALUES(2332, 139, 'GA', 'Găgăuzia', 'Russian');
INSERT INTO emkt_regions VALUES(2333, 139, 'LA', 'Lăpuşna', 'Russian');
INSERT INTO emkt_regions VALUES(2334, 139, 'OR', 'Orhei', 'Russian');
INSERT INTO emkt_regions VALUES(2335, 139, 'SN', 'Stânga Nistrului', 'Russian');
INSERT INTO emkt_regions VALUES(2336, 139, 'SO', 'Soroca', 'Russian');
INSERT INTO emkt_regions VALUES(2337, 139, 'TI', 'Tighina', 'Russian');
INSERT INTO emkt_regions VALUES(2338, 139, 'UN', 'Ungheni', 'Russian');

INSERT INTO emkt_countries VALUES (140,'Монако','Russian','MC','MCO','');

INSERT INTO emkt_regions VALUES(2339, 140, 'MC', 'Monte Carlo', 'Russian');
INSERT INTO emkt_regions VALUES(2340, 140, 'LR', 'La Rousse', 'Russian');
INSERT INTO emkt_regions VALUES(2341, 140, 'LA', 'Larvotto', 'Russian');
INSERT INTO emkt_regions VALUES(2342, 140, 'MV', 'Monaco Ville', 'Russian');
INSERT INTO emkt_regions VALUES(2343, 140, 'SM', 'Saint Michel', 'Russian');
INSERT INTO emkt_regions VALUES(2344, 140, 'CO', 'Condamine', 'Russian');
INSERT INTO emkt_regions VALUES(2345, 140, 'LC', 'La Colle', 'Russian');
INSERT INTO emkt_regions VALUES(2346, 140, 'RE', 'Les Révoires', 'Russian');
INSERT INTO emkt_regions VALUES(2347, 140, 'MO', 'Moneghetti', 'Russian');
INSERT INTO emkt_regions VALUES(2348, 140, 'FV', 'Fontvieille', 'Russian');

INSERT INTO emkt_countries VALUES (141,'Монголия','Russian','MN','MNG','');

INSERT INTO emkt_regions VALUES(2349, 141, '1', 'Улаанбаатар', 'Russian');
INSERT INTO emkt_regions VALUES(2350, 141, '035', 'Орхон аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2351, 141, '037', 'Дархан-Уул аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2352, 141, '039', 'Хэнтий аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2353, 141, '041', 'Хөвсгөл аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2354, 141, '043', 'Ховд аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2355, 141, '046', 'Увс аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2356, 141, '047', 'Төв аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2357, 141, '049', 'Сэлэнгэ аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2358, 141, '051', 'Сүхбаатар аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2359, 141, '053', 'Өмнөговь аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2360, 141, '055', 'Өвөрхангай аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2361, 141, '057', 'Завхан аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2362, 141, '059', 'Дундговь аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2363, 141, '061', 'Дорнод аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2364, 141, '063', 'Дорноговь аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2365, 141, '064', 'Говьсүмбэр аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2366, 141, '065', 'Говь-Алтай аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2367, 141, '067', 'Булган аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2368, 141, '069', 'Баянхонгор аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2369, 141, '071', 'Баян Өлгий аймаг', 'Russian');
INSERT INTO emkt_regions VALUES(2370, 141, '073', 'Архангай аймаг', 'Russian');

INSERT INTO emkt_countries VALUES (142,'Монтсеррат','Russian','MS','MSR','');

INSERT INTO emkt_regions VALUES(2371, 142, 'A', 'Saint Anthony', 'Russian');
INSERT INTO emkt_regions VALUES(2372, 142, 'G', 'Saint Georges', 'Russian');
INSERT INTO emkt_regions VALUES(2373, 142, 'P', 'Saint Peter', 'Russian');

INSERT INTO emkt_countries VALUES (143,'Марокко','Russian','MA','MAR','');

INSERT INTO emkt_regions VALUES(4266, 143, 'NOCODE', 'Morocco', 'Russian');

INSERT INTO emkt_countries VALUES (144,'Мозамбик','Russian','MZ','MOZ','');

INSERT INTO emkt_regions VALUES(2374, 144, 'A', 'Niassa', 'Russian');
INSERT INTO emkt_regions VALUES(2375, 144, 'B', 'Manica', 'Russian');
INSERT INTO emkt_regions VALUES(2376, 144, 'G', 'Gaza', 'Russian');
INSERT INTO emkt_regions VALUES(2377, 144, 'I', 'Inhambane', 'Russian');
INSERT INTO emkt_regions VALUES(2378, 144, 'L', 'Maputo', 'Russian');
INSERT INTO emkt_regions VALUES(2379, 144, 'MPM', 'Maputo cidade', 'Russian');
INSERT INTO emkt_regions VALUES(2380, 144, 'N', 'Nampula', 'Russian');
INSERT INTO emkt_regions VALUES(2381, 144, 'P', 'Cabo Delgado', 'Russian');
INSERT INTO emkt_regions VALUES(2382, 144, 'Q', 'Zambézia', 'Russian');
INSERT INTO emkt_regions VALUES(2383, 144, 'S', 'Sofala', 'Russian');
INSERT INTO emkt_regions VALUES(2384, 144, 'T', 'Tete', 'Russian');

INSERT INTO emkt_countries VALUES (145,'Мьянма','Russian','MM','MMR','');

INSERT INTO emkt_regions VALUES(2385, 145, 'AY', 'ဧရာ၀တီတိုင္‌း', 'Russian');
INSERT INTO emkt_regions VALUES(2386, 145, 'BG', 'ပဲခူးတုိင္‌း', 'Russian');
INSERT INTO emkt_regions VALUES(2387, 145, 'MG', 'မကေ္ဝးတိုင္‌း', 'Russian');
INSERT INTO emkt_regions VALUES(2388, 145, 'MD', 'မန္တလေးတုိင္‌း', 'Russian');
INSERT INTO emkt_regions VALUES(2389, 145, 'SG', 'စစ္‌ကုိင္‌း‌တုိင္‌း', 'Russian');
INSERT INTO emkt_regions VALUES(2390, 145, 'TN', 'တနင္သာရိတုိင္‌း', 'Russian');
INSERT INTO emkt_regions VALUES(2391, 145, 'YG', 'ရန္‌ကုန္‌တုိင္‌း', 'Russian');
INSERT INTO emkt_regions VALUES(2392, 145, 'CH', 'ခ္ယင္‌းပ္ရည္‌နယ္‌', 'Russian');
INSERT INTO emkt_regions VALUES(2393, 145, 'KC', 'ကခ္ယင္‌ပ္ရည္‌နယ္‌', 'Russian');
INSERT INTO emkt_regions VALUES(2394, 145, 'KH', 'ကယား‌ပ္ရည္‌နယ္‌', 'Russian');
INSERT INTO emkt_regions VALUES(2395, 145, 'KN', 'ကရင္‌‌ပ္ရည္‌နယ္‌', 'Russian');
INSERT INTO emkt_regions VALUES(2396, 145, 'MN', 'မ္ဝန္‌ပ္ရည္‌နယ္‌', 'Russian');
INSERT INTO emkt_regions VALUES(2397, 145, 'RK', 'ရခုိင္‌ပ္ရည္‌နယ္‌', 'Russian');
INSERT INTO emkt_regions VALUES(2398, 145, 'SH', 'ရုမ္‌းပ္ရည္‌နယ္‌', 'Russian');

INSERT INTO emkt_countries VALUES (146,'Намибия','Russian','NA','NAM','');

INSERT INTO emkt_regions VALUES(2399, 146, 'CA', 'Caprivi', 'Russian');
INSERT INTO emkt_regions VALUES(2400, 146, 'ER', 'Erongo', 'Russian');
INSERT INTO emkt_regions VALUES(2401, 146, 'HA', 'Hardap', 'Russian');
INSERT INTO emkt_regions VALUES(2402, 146, 'KA', 'Karas', 'Russian');
INSERT INTO emkt_regions VALUES(2403, 146, 'KH', 'Khomas', 'Russian');
INSERT INTO emkt_regions VALUES(2404, 146, 'KU', 'Kunene', 'Russian');
INSERT INTO emkt_regions VALUES(2405, 146, 'OD', 'Otjozondjupa', 'Russian');
INSERT INTO emkt_regions VALUES(2406, 146, 'OH', 'Omaheke', 'Russian');
INSERT INTO emkt_regions VALUES(2407, 146, 'OK', 'Okavango', 'Russian');
INSERT INTO emkt_regions VALUES(2408, 146, 'ON', 'Oshana', 'Russian');
INSERT INTO emkt_regions VALUES(2409, 146, 'OS', 'Omusati', 'Russian');
INSERT INTO emkt_regions VALUES(2410, 146, 'OT', 'Oshikoto', 'Russian');
INSERT INTO emkt_regions VALUES(2411, 146, 'OW', 'Ohangwena', 'Russian');

INSERT INTO emkt_countries VALUES (147,'Науру','Russian','NR','NRU','');

INSERT INTO emkt_regions VALUES(2412, 147, 'AO', 'Aiwo', 'Russian');
INSERT INTO emkt_regions VALUES(2413, 147, 'AA', 'Anabar', 'Russian');
INSERT INTO emkt_regions VALUES(2414, 147, 'AT', 'Anetan', 'Russian');
INSERT INTO emkt_regions VALUES(2415, 147, 'AI', 'Anibare', 'Russian');
INSERT INTO emkt_regions VALUES(2416, 147, 'BA', 'Baiti', 'Russian');
INSERT INTO emkt_regions VALUES(2417, 147, 'BO', 'Boe', 'Russian');
INSERT INTO emkt_regions VALUES(2418, 147, 'BU', 'Buada', 'Russian');
INSERT INTO emkt_regions VALUES(2419, 147, 'DE', 'Denigomodu', 'Russian');
INSERT INTO emkt_regions VALUES(2420, 147, 'EW', 'Ewa', 'Russian');
INSERT INTO emkt_regions VALUES(2421, 147, 'IJ', 'Ijuw', 'Russian');
INSERT INTO emkt_regions VALUES(2422, 147, 'ME', 'Meneng', 'Russian');
INSERT INTO emkt_regions VALUES(2423, 147, 'NI', 'Nibok', 'Russian');
INSERT INTO emkt_regions VALUES(2424, 147, 'UA', 'Uaboe', 'Russian');
INSERT INTO emkt_regions VALUES(2425, 147, 'YA', 'Yaren', 'Russian');

INSERT INTO emkt_countries VALUES (148,'Непал','Russian','NP','NPL','');

INSERT INTO emkt_regions VALUES(2426, 148, 'BA', 'Bagmati', 'Russian');
INSERT INTO emkt_regions VALUES(2427, 148, 'BH', 'Bheri', 'Russian');
INSERT INTO emkt_regions VALUES(2428, 148, 'DH', 'Dhawalagiri', 'Russian');
INSERT INTO emkt_regions VALUES(2429, 148, 'GA', 'Gandaki', 'Russian');
INSERT INTO emkt_regions VALUES(2430, 148, 'JA', 'Janakpur', 'Russian');
INSERT INTO emkt_regions VALUES(2431, 148, 'KA', 'Karnali', 'Russian');
INSERT INTO emkt_regions VALUES(2432, 148, 'KO', 'Kosi', 'Russian');
INSERT INTO emkt_regions VALUES(2433, 148, 'LU', 'Lumbini', 'Russian');
INSERT INTO emkt_regions VALUES(2434, 148, 'MA', 'Mahakali', 'Russian');
INSERT INTO emkt_regions VALUES(2435, 148, 'ME', 'Mechi', 'Russian');
INSERT INTO emkt_regions VALUES(2436, 148, 'NA', 'Narayani', 'Russian');
INSERT INTO emkt_regions VALUES(2437, 148, 'RA', 'Rapti', 'Russian');
INSERT INTO emkt_regions VALUES(2438, 148, 'SA', 'Sagarmatha', 'Russian');
INSERT INTO emkt_regions VALUES(2439, 148, 'SE', 'Seti', 'Russian');

INSERT INTO emkt_countries VALUES (149,'Нидерланды','Russian','NL','NLD','');

INSERT INTO emkt_regions VALUES(2440, 149, 'DR', 'Drenthe', 'Russian');
INSERT INTO emkt_regions VALUES(2441, 149, 'FL', 'Flevoland', 'Russian');
INSERT INTO emkt_regions VALUES(2442, 149, 'FR', 'Friesland', 'Russian');
INSERT INTO emkt_regions VALUES(2443, 149, 'GE', 'Gelderland', 'Russian');
INSERT INTO emkt_regions VALUES(2444, 149, 'GR', 'Groningen', 'Russian');
INSERT INTO emkt_regions VALUES(2445, 149, 'LI', 'Limburg', 'Russian');
INSERT INTO emkt_regions VALUES(2446, 149, 'NB', 'Noord-Brabant', 'Russian');
INSERT INTO emkt_regions VALUES(2447, 149, 'NH', 'Noord-Holland', 'Russian');
INSERT INTO emkt_regions VALUES(2448, 149, 'OV', 'Overijssel', 'Russian');
INSERT INTO emkt_regions VALUES(2449, 149, 'UT', 'Utrecht', 'Russian');
INSERT INTO emkt_regions VALUES(2450, 149, 'ZE', 'Zeeland', 'Russian');
INSERT INTO emkt_regions VALUES(2451, 149, 'ZH', 'Zuid-Holland', 'Russian');

INSERT INTO emkt_countries VALUES (150,'Нидерландские Антильские острова','Russian','AN','ANT','');

INSERT INTO emkt_regions VALUES(4267, 150, 'NOCODE', 'Netherlands Antilles', 'Russian');

INSERT INTO emkt_countries VALUES (151,'Новая Каледония','Russian','NC','NCL','');

INSERT INTO emkt_regions VALUES(2452, 151, 'L', 'Province des Îles', 'Russian');
INSERT INTO emkt_regions VALUES(2453, 151, 'N', 'Province Nord', 'Russian');
INSERT INTO emkt_regions VALUES(2454, 151, 'S', 'Province Sud', 'Russian');

INSERT INTO emkt_countries VALUES (152,'Новая Зеландия','Russian','NZ','NZL','');

INSERT INTO emkt_regions VALUES(2455, 152, 'AUK', 'Auckland', 'Russian');
INSERT INTO emkt_regions VALUES(2456, 152, 'BOP', 'Bay of Plenty', 'Russian');
INSERT INTO emkt_regions VALUES(2457, 152, 'CAN', 'Canterbury', 'Russian');
INSERT INTO emkt_regions VALUES(2458, 152, 'GIS', 'Gisborne', 'Russian');
INSERT INTO emkt_regions VALUES(2459, 152, 'HKB', 'Hawke\'s Bay', 'Russian');
INSERT INTO emkt_regions VALUES(2460, 152, 'MBH', 'Marlborough', 'Russian');
INSERT INTO emkt_regions VALUES(2461, 152, 'MWT', 'Manawatu-Wanganui', 'Russian');
INSERT INTO emkt_regions VALUES(2462, 152, 'NSN', 'Nelson', 'Russian');
INSERT INTO emkt_regions VALUES(2463, 152, 'NTL', 'Northland', 'Russian');
INSERT INTO emkt_regions VALUES(2464, 152, 'OTA', 'Otago', 'Russian');
INSERT INTO emkt_regions VALUES(2465, 152, 'STL', 'Southland', 'Russian');
INSERT INTO emkt_regions VALUES(2466, 152, 'TAS', 'Tasman', 'Russian');
INSERT INTO emkt_regions VALUES(2467, 152, 'TKI', 'Taranaki', 'Russian');
INSERT INTO emkt_regions VALUES(2468, 152, 'WGN', 'Wellington', 'Russian');
INSERT INTO emkt_regions VALUES(2469, 152, 'WKO', 'Waikato', 'Russian');
INSERT INTO emkt_regions VALUES(2470, 152, 'WTC', 'West Coast', 'Russian');

INSERT INTO emkt_countries VALUES (153,'Никарагуа','Russian','NI','NIC','');

INSERT INTO emkt_regions VALUES(2471, 153, 'AN', 'Atlántico Norte', 'Russian');
INSERT INTO emkt_regions VALUES(2472, 153, 'AS', 'Atlántico Sur', 'Russian');
INSERT INTO emkt_regions VALUES(2473, 153, 'BO', 'Boaco', 'Russian');
INSERT INTO emkt_regions VALUES(2474, 153, 'CA', 'Carazo', 'Russian');
INSERT INTO emkt_regions VALUES(2475, 153, 'CI', 'Chinandega', 'Russian');
INSERT INTO emkt_regions VALUES(2476, 153, 'CO', 'Chontales', 'Russian');
INSERT INTO emkt_regions VALUES(2477, 153, 'ES', 'Estelí', 'Russian');
INSERT INTO emkt_regions VALUES(2478, 153, 'GR', 'Granada', 'Russian');
INSERT INTO emkt_regions VALUES(2479, 153, 'JI', 'Jinotega', 'Russian');
INSERT INTO emkt_regions VALUES(2480, 153, 'LE', 'León', 'Russian');
INSERT INTO emkt_regions VALUES(2481, 153, 'MD', 'Madriz', 'Russian');
INSERT INTO emkt_regions VALUES(2482, 153, 'MN', 'Managua', 'Russian');
INSERT INTO emkt_regions VALUES(2483, 153, 'MS', 'Masaya', 'Russian');
INSERT INTO emkt_regions VALUES(2484, 153, 'MT', 'Matagalpa', 'Russian');
INSERT INTO emkt_regions VALUES(2485, 153, 'NS', 'Nueva Segovia', 'Russian');
INSERT INTO emkt_regions VALUES(2486, 153, 'RI', 'Rivas', 'Russian');
INSERT INTO emkt_regions VALUES(2487, 153, 'SJ', 'Río San Juan', 'Russian');

INSERT INTO emkt_countries VALUES (154,'Республика Нигер','Russian','NE','NER','');

INSERT INTO emkt_regions VALUES(2488, 154, '1', 'Agadez', 'Russian');
INSERT INTO emkt_regions VALUES(2489, 154, '2', 'Daffa', 'Russian');
INSERT INTO emkt_regions VALUES(2490, 154, '3', 'Dosso', 'Russian');
INSERT INTO emkt_regions VALUES(2491, 154, '4', 'Maradi', 'Russian');
INSERT INTO emkt_regions VALUES(2492, 154, '5', 'Tahoua', 'Russian');
INSERT INTO emkt_regions VALUES(2493, 154, '6', 'Tillabéry', 'Russian');
INSERT INTO emkt_regions VALUES(2494, 154, '7', 'Zinder', 'Russian');
INSERT INTO emkt_regions VALUES(2495, 154, '8', 'Niamey', 'Russian');

INSERT INTO emkt_countries VALUES (155,'Нигерия','Russian','NG','NGA','');

INSERT INTO emkt_regions VALUES(2496, 155, 'AB', 'Abia State', 'Russian');
INSERT INTO emkt_regions VALUES(2497, 155, 'AD', 'Adamawa State', 'Russian');
INSERT INTO emkt_regions VALUES(2498, 155, 'AK', 'Akwa Ibom State', 'Russian');
INSERT INTO emkt_regions VALUES(2499, 155, 'AN', 'Anambra State', 'Russian');
INSERT INTO emkt_regions VALUES(2500, 155, 'BA', 'Bauchi State', 'Russian');
INSERT INTO emkt_regions VALUES(2501, 155, 'BE', 'Benue State', 'Russian');
INSERT INTO emkt_regions VALUES(2502, 155, 'BO', 'Borno State', 'Russian');
INSERT INTO emkt_regions VALUES(2503, 155, 'BY', 'Bayelsa State', 'Russian');
INSERT INTO emkt_regions VALUES(2504, 155, 'CR', 'Cross River State', 'Russian');
INSERT INTO emkt_regions VALUES(2505, 155, 'DE', 'Delta State', 'Russian');
INSERT INTO emkt_regions VALUES(2506, 155, 'EB', 'Ebonyi State', 'Russian');
INSERT INTO emkt_regions VALUES(2507, 155, 'ED', 'Edo State', 'Russian');
INSERT INTO emkt_regions VALUES(2508, 155, 'EK', 'Ekiti State', 'Russian');
INSERT INTO emkt_regions VALUES(2509, 155, 'EN', 'Enugu State', 'Russian');
INSERT INTO emkt_regions VALUES(2510, 155, 'GO', 'Gombe State', 'Russian');
INSERT INTO emkt_regions VALUES(2511, 155, 'IM', 'Imo State', 'Russian');
INSERT INTO emkt_regions VALUES(2512, 155, 'JI', 'Jigawa State', 'Russian');
INSERT INTO emkt_regions VALUES(2513, 155, 'KB', 'Kebbi State', 'Russian');
INSERT INTO emkt_regions VALUES(2514, 155, 'KD', 'Kaduna State', 'Russian');
INSERT INTO emkt_regions VALUES(2515, 155, 'KN', 'Kano State', 'Russian');
INSERT INTO emkt_regions VALUES(2516, 155, 'KO', 'Kogi State', 'Russian');
INSERT INTO emkt_regions VALUES(2517, 155, 'KT', 'Katsina State', 'Russian');
INSERT INTO emkt_regions VALUES(2518, 155, 'KW', 'Kwara State', 'Russian');
INSERT INTO emkt_regions VALUES(2519, 155, 'LA', 'Lagos State', 'Russian');
INSERT INTO emkt_regions VALUES(2520, 155, 'NA', 'Nassarawa State', 'Russian');
INSERT INTO emkt_regions VALUES(2521, 155, 'NI', 'Niger State', 'Russian');
INSERT INTO emkt_regions VALUES(2522, 155, 'OG', 'Ogun State', 'Russian');
INSERT INTO emkt_regions VALUES(2523, 155, 'ON', 'Ondo State', 'Russian');
INSERT INTO emkt_regions VALUES(2524, 155, 'OS', 'Osun State', 'Russian');
INSERT INTO emkt_regions VALUES(2525, 155, 'OY', 'Oyo State', 'Russian');
INSERT INTO emkt_regions VALUES(2526, 155, 'PL', 'Plateau State', 'Russian');
INSERT INTO emkt_regions VALUES(2527, 155, 'RI', 'Rivers State', 'Russian');
INSERT INTO emkt_regions VALUES(2528, 155, 'SO', 'Sokoto State', 'Russian');
INSERT INTO emkt_regions VALUES(2529, 155, 'TA', 'Taraba State', 'Russian');
INSERT INTO emkt_regions VALUES(2530, 155, 'ZA', 'Zamfara State', 'Russian');

INSERT INTO emkt_countries VALUES (156,'Ниуэ','Russian','NU','NIU','');

INSERT INTO emkt_regions VALUES(4268, 156, 'NOCODE', 'Niue', 'Russian');

INSERT INTO emkt_countries VALUES (157,'Остров Норфолк','Russian','NF','NFK','');

INSERT INTO emkt_regions VALUES(4269, 157, 'NOCODE', 'Norfolk Island', 'Russian');

INSERT INTO emkt_countries VALUES (158,'Северные Марианские Острова','Russian','MP','MNP','');

INSERT INTO emkt_regions VALUES(2531, 158, 'N', 'Northern Islands', 'Russian');
INSERT INTO emkt_regions VALUES(2532, 158, 'R', 'Rota', 'Russian');
INSERT INTO emkt_regions VALUES(2533, 158, 'S', 'Saipan', 'Russian');
INSERT INTO emkt_regions VALUES(2534, 158, 'T', 'Tinian', 'Russian');

INSERT INTO emkt_countries VALUES (159,'Норвегия','Russian','NO','NOR','');

INSERT INTO emkt_regions VALUES(2535, 159, '01', 'Østfold fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2536, 159, '02', 'Akershus fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2537, 159, '03', 'Oslo fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2538, 159, '04', 'Hedmark fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2539, 159, '05', 'Oppland fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2540, 159, '06', 'Buskerud fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2541, 159, '07', 'Vestfold fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2542, 159, '08', 'Telemark fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2543, 159, '09', 'Aust-Agder fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2544, 159, '10', 'Vest-Agder fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2545, 159, '11', 'Rogaland fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2546, 159, '12', 'Hordaland fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2547, 159, '14', 'Sogn og Fjordane fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2548, 159, '15', 'Møre og Romsdal fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2549, 159, '16', 'Sør-Trøndelag fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2550, 159, '17', 'Nord-Trøndelag fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2551, 159, '18', 'Nordland fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2552, 159, '19', 'Troms fylke', 'Russian');
INSERT INTO emkt_regions VALUES(2553, 159, '20', 'Finnmark fylke', 'Russian');

INSERT INTO emkt_countries VALUES (160,'Оман','Russian','OM','OMN','');

INSERT INTO emkt_regions VALUES(2554, 160, 'BA', 'الباطنة', 'Russian');
INSERT INTO emkt_regions VALUES(2555, 160, 'DA', 'الداخلية', 'Russian');
INSERT INTO emkt_regions VALUES(2556, 160, 'DH', 'ظفار', 'Russian');
INSERT INTO emkt_regions VALUES(2557, 160, 'MA', 'مسقط', 'Russian');
INSERT INTO emkt_regions VALUES(2558, 160, 'MU', 'مسندم', 'Russian');
INSERT INTO emkt_regions VALUES(2559, 160, 'SH', 'الشرقية', 'Russian');
INSERT INTO emkt_regions VALUES(2560, 160, 'WU', 'الوسطى', 'Russian');
INSERT INTO emkt_regions VALUES(2561, 160, 'ZA', 'الظاهرة', 'Russian');

INSERT INTO emkt_countries VALUES (161,'Пакистан','Russian','PK','PAK','');

INSERT INTO emkt_regions VALUES(2562, 161, 'BA', 'بلوچستان', 'Russian');
INSERT INTO emkt_regions VALUES(2563, 161, 'IS', 'وفاقی دارالحکومت', 'Russian');
INSERT INTO emkt_regions VALUES(2564, 161, 'JK', 'آزاد کشمیر', 'Russian');
INSERT INTO emkt_regions VALUES(2565, 161, 'NA', 'شمالی علاقہ جات', 'Russian');
INSERT INTO emkt_regions VALUES(2566, 161, 'NW', 'شمال مغربی سرحدی صوبہ', 'Russian');
INSERT INTO emkt_regions VALUES(2567, 161, 'PB', 'پنجاب', 'Russian');
INSERT INTO emkt_regions VALUES(2568, 161, 'SD', 'سندھ', 'Russian');
INSERT INTO emkt_regions VALUES(2569, 161, 'TA', 'وفاقی قبائلی علاقہ جات', 'Russian');

INSERT INTO emkt_countries VALUES (162,'Палау','Russian','PW','PLW','');

INSERT INTO emkt_regions VALUES(2570, 162, 'AM', 'Aimeliik', 'Russian');
INSERT INTO emkt_regions VALUES(2571, 162, 'AR', 'Airai', 'Russian');
INSERT INTO emkt_regions VALUES(2572, 162, 'AN', 'Angaur', 'Russian');
INSERT INTO emkt_regions VALUES(2573, 162, 'HA', 'Hatohobei', 'Russian');
INSERT INTO emkt_regions VALUES(2574, 162, 'KA', 'Kayangel', 'Russian');
INSERT INTO emkt_regions VALUES(2575, 162, 'KO', 'Koror', 'Russian');
INSERT INTO emkt_regions VALUES(2576, 162, 'ME', 'Melekeok', 'Russian');
INSERT INTO emkt_regions VALUES(2577, 162, 'NA', 'Ngaraard', 'Russian');
INSERT INTO emkt_regions VALUES(2578, 162, 'NG', 'Ngarchelong', 'Russian');
INSERT INTO emkt_regions VALUES(2579, 162, 'ND', 'Ngardmau', 'Russian');
INSERT INTO emkt_regions VALUES(2580, 162, 'NT', 'Ngatpang', 'Russian');
INSERT INTO emkt_regions VALUES(2581, 162, 'NC', 'Ngchesar', 'Russian');
INSERT INTO emkt_regions VALUES(2582, 162, 'NR', 'Ngeremlengui', 'Russian');
INSERT INTO emkt_regions VALUES(2583, 162, 'NW', 'Ngiwal', 'Russian');
INSERT INTO emkt_regions VALUES(2584, 162, 'PE', 'Peleliu', 'Russian');
INSERT INTO emkt_regions VALUES(2585, 162, 'SO', 'Sonsorol', 'Russian');

INSERT INTO emkt_countries VALUES (163,'Панама','Russian','PA','PAN','');

INSERT INTO emkt_regions VALUES(2586, 163, '1', 'Bocas del Toro', 'Russian');
INSERT INTO emkt_regions VALUES(2587, 163, '2', 'Coclé', 'Russian');
INSERT INTO emkt_regions VALUES(2588, 163, '3', 'Colón', 'Russian');
INSERT INTO emkt_regions VALUES(2589, 163, '4', 'Chiriquí', 'Russian');
INSERT INTO emkt_regions VALUES(2590, 163, '5', 'Darién', 'Russian');
INSERT INTO emkt_regions VALUES(2591, 163, '6', 'Herrera', 'Russian');
INSERT INTO emkt_regions VALUES(2592, 163, '7', 'Los Santos', 'Russian');
INSERT INTO emkt_regions VALUES(2593, 163, '8', 'Panamá', 'Russian');
INSERT INTO emkt_regions VALUES(2594, 163, '9', 'Veraguas', 'Russian');
INSERT INTO emkt_regions VALUES(2595, 163, 'Q', 'Kuna Yala', 'Russian');

INSERT INTO emkt_countries VALUES (164,'Папуа-Новая Гвинея','Russian','PG','PNG','');

INSERT INTO emkt_regions VALUES(2596, 164, 'CPK', 'Chimbu', 'Russian');
INSERT INTO emkt_regions VALUES(2597, 164, 'CPM', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(2598, 164, 'EBR', 'East New Britain', 'Russian');
INSERT INTO emkt_regions VALUES(2599, 164, 'EHG', 'Eastern Highlands', 'Russian');
INSERT INTO emkt_regions VALUES(2600, 164, 'EPW', 'Enga', 'Russian');
INSERT INTO emkt_regions VALUES(2601, 164, 'ESW', 'East Sepik', 'Russian');
INSERT INTO emkt_regions VALUES(2602, 164, 'GPK', 'Gulf', 'Russian');
INSERT INTO emkt_regions VALUES(2603, 164, 'MBA', 'Milne Bay', 'Russian');
INSERT INTO emkt_regions VALUES(2604, 164, 'MPL', 'Morobe', 'Russian');
INSERT INTO emkt_regions VALUES(2605, 164, 'MPM', 'Madang', 'Russian');
INSERT INTO emkt_regions VALUES(2606, 164, 'MRL', 'Manus', 'Russian');
INSERT INTO emkt_regions VALUES(2607, 164, 'NCD', 'National Capital District', 'Russian');
INSERT INTO emkt_regions VALUES(2608, 164, 'NIK', 'New Ireland', 'Russian');
INSERT INTO emkt_regions VALUES(2609, 164, 'NPP', 'Northern', 'Russian');
INSERT INTO emkt_regions VALUES(2610, 164, 'NSA', 'North Solomons', 'Russian');
INSERT INTO emkt_regions VALUES(2611, 164, 'SAN', 'Sandaun', 'Russian');
INSERT INTO emkt_regions VALUES(2612, 164, 'SHM', 'Southern Highlands', 'Russian');
INSERT INTO emkt_regions VALUES(2613, 164, 'WBK', 'West New Britain', 'Russian');
INSERT INTO emkt_regions VALUES(2614, 164, 'WHM', 'Western Highlands', 'Russian');
INSERT INTO emkt_regions VALUES(2615, 164, 'WPD', 'Western', 'Russian');

INSERT INTO emkt_countries VALUES (165,'Парагвай','Russian','PY','PRY','');

INSERT INTO emkt_regions VALUES(2616, 165, '1', 'Concepción', 'Russian');
INSERT INTO emkt_regions VALUES(2617, 165, '2', 'San Pedro', 'Russian');
INSERT INTO emkt_regions VALUES(2618, 165, '3', 'Cordillera', 'Russian');
INSERT INTO emkt_regions VALUES(2619, 165, '4', 'Guairá', 'Russian');
INSERT INTO emkt_regions VALUES(2620, 165, '5', 'Caaguazú', 'Russian');
INSERT INTO emkt_regions VALUES(2621, 165, '6', 'Caazapá', 'Russian');
INSERT INTO emkt_regions VALUES(2622, 165, '7', 'Itapúa', 'Russian');
INSERT INTO emkt_regions VALUES(2623, 165, '8', 'Misiones', 'Russian');
INSERT INTO emkt_regions VALUES(2624, 165, '9', 'Paraguarí', 'Russian');
INSERT INTO emkt_regions VALUES(2625, 165, '10', 'Alto Paraná', 'Russian');
INSERT INTO emkt_regions VALUES(2626, 165, '11', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(2627, 165, '12', 'Ñeembucú', 'Russian');
INSERT INTO emkt_regions VALUES(2628, 165, '13', 'Amambay', 'Russian');
INSERT INTO emkt_regions VALUES(2629, 165, '14', 'Canindeyú', 'Russian');
INSERT INTO emkt_regions VALUES(2630, 165, '15', 'Presidente Hayes', 'Russian');
INSERT INTO emkt_regions VALUES(2631, 165, '16', 'Alto Paraguay', 'Russian');
INSERT INTO emkt_regions VALUES(2632, 165, '19', 'Boquerón', 'Russian');
INSERT INTO emkt_regions VALUES(2633, 165, 'ASU', 'Asunción', 'Russian');

INSERT INTO emkt_countries VALUES (166,'Перу','Russian','PE','PER','');

INSERT INTO emkt_regions VALUES(2634, 166, 'AMA', 'Amazonas', 'Russian');
INSERT INTO emkt_regions VALUES(2635, 166, 'ANC', 'Ancash', 'Russian');
INSERT INTO emkt_regions VALUES(2636, 166, 'APU', 'Apurímac', 'Russian');
INSERT INTO emkt_regions VALUES(2637, 166, 'ARE', 'Arequipa', 'Russian');
INSERT INTO emkt_regions VALUES(2638, 166, 'AYA', 'Ayacucho', 'Russian');
INSERT INTO emkt_regions VALUES(2639, 166, 'CAJ', 'Cajamarca', 'Russian');
INSERT INTO emkt_regions VALUES(2640, 166, 'CAL', 'Callao', 'Russian');
INSERT INTO emkt_regions VALUES(2641, 166, 'CUS', 'Cuzco', 'Russian');
INSERT INTO emkt_regions VALUES(2642, 166, 'HUC', 'Huánuco', 'Russian');
INSERT INTO emkt_regions VALUES(2643, 166, 'HUV', 'Huancavelica', 'Russian');
INSERT INTO emkt_regions VALUES(2644, 166, 'ICA', 'Ica', 'Russian');
INSERT INTO emkt_regions VALUES(2645, 166, 'JUN', 'Junín', 'Russian');
INSERT INTO emkt_regions VALUES(2646, 166, 'LAL', 'La Libertad', 'Russian');
INSERT INTO emkt_regions VALUES(2647, 166, 'LAM', 'Lambayeque', 'Russian');
INSERT INTO emkt_regions VALUES(2648, 166, 'LIM', 'Lima', 'Russian');
INSERT INTO emkt_regions VALUES(2649, 166, 'LOR', 'Loreto', 'Russian');
INSERT INTO emkt_regions VALUES(2650, 166, 'MDD', 'Madre de Dios', 'Russian');
INSERT INTO emkt_regions VALUES(2651, 166, 'MOQ', 'Moquegua', 'Russian');
INSERT INTO emkt_regions VALUES(2652, 166, 'PAS', 'Pasco', 'Russian');
INSERT INTO emkt_regions VALUES(2653, 166, 'PIU', 'Piura', 'Russian');
INSERT INTO emkt_regions VALUES(2654, 166, 'PUN', 'Puno', 'Russian');
INSERT INTO emkt_regions VALUES(2655, 166, 'SAM', 'San Martín', 'Russian');
INSERT INTO emkt_regions VALUES(2656, 166, 'TAC', 'Tacna', 'Russian');
INSERT INTO emkt_regions VALUES(2657, 166, 'TUM', 'Tumbes', 'Russian');
INSERT INTO emkt_regions VALUES(2658, 166, 'UCA', 'Ucayali', 'Russian');

INSERT INTO emkt_countries VALUES (167,'Филиппины','Russian','PH','PHL','');

INSERT INTO emkt_regions VALUES(2659, 167, 'ABR', 'Abra', 'Russian');
INSERT INTO emkt_regions VALUES(2660, 167, 'AGN', 'Agusan del Norte', 'Russian');
INSERT INTO emkt_regions VALUES(2661, 167, 'AGS', 'Agusan del Sur', 'Russian');
INSERT INTO emkt_regions VALUES(2662, 167, 'AKL', 'Aklan', 'Russian');
INSERT INTO emkt_regions VALUES(2663, 167, 'ALB', 'Albay', 'Russian');
INSERT INTO emkt_regions VALUES(2664, 167, 'ANT', 'Antique', 'Russian');
INSERT INTO emkt_regions VALUES(2665, 167, 'APA', 'Apayao', 'Russian');
INSERT INTO emkt_regions VALUES(2666, 167, 'AUR', 'Aurora', 'Russian');
INSERT INTO emkt_regions VALUES(2667, 167, 'BAN', 'Bataan', 'Russian');
INSERT INTO emkt_regions VALUES(2668, 167, 'BAS', 'Basilan', 'Russian');
INSERT INTO emkt_regions VALUES(2669, 167, 'BEN', 'Benguet', 'Russian');
INSERT INTO emkt_regions VALUES(2670, 167, 'BIL', 'Biliran', 'Russian');
INSERT INTO emkt_regions VALUES(2671, 167, 'BOH', 'Bohol', 'Russian');
INSERT INTO emkt_regions VALUES(2672, 167, 'BTG', 'Batangas', 'Russian');
INSERT INTO emkt_regions VALUES(2673, 167, 'BTN', 'Batanes', 'Russian');
INSERT INTO emkt_regions VALUES(2674, 167, 'BUK', 'Bukidnon', 'Russian');
INSERT INTO emkt_regions VALUES(2675, 167, 'BUL', 'Bulacan', 'Russian');
INSERT INTO emkt_regions VALUES(2676, 167, 'CAG', 'Cagayan', 'Russian');
INSERT INTO emkt_regions VALUES(2677, 167, 'CAM', 'Camiguin', 'Russian');
INSERT INTO emkt_regions VALUES(2678, 167, 'CAN', 'Camarines Norte', 'Russian');
INSERT INTO emkt_regions VALUES(2679, 167, 'CAP', 'Capiz', 'Russian');
INSERT INTO emkt_regions VALUES(2680, 167, 'CAS', 'Camarines Sur', 'Russian');
INSERT INTO emkt_regions VALUES(2681, 167, 'CAT', 'Catanduanes', 'Russian');
INSERT INTO emkt_regions VALUES(2682, 167, 'CAV', 'Cavite', 'Russian');
INSERT INTO emkt_regions VALUES(2683, 167, 'CEB', 'Cebu', 'Russian');
INSERT INTO emkt_regions VALUES(2684, 167, 'COM', 'Compostela Valley', 'Russian');
INSERT INTO emkt_regions VALUES(2685, 167, 'DAO', 'Davao Oriental', 'Russian');
INSERT INTO emkt_regions VALUES(2686, 167, 'DAS', 'Davao del Sur', 'Russian');
INSERT INTO emkt_regions VALUES(2687, 167, 'DAV', 'Davao del Norte', 'Russian');
INSERT INTO emkt_regions VALUES(2688, 167, 'EAS', 'Eastern Samar', 'Russian');
INSERT INTO emkt_regions VALUES(2689, 167, 'GUI', 'Guimaras', 'Russian');
INSERT INTO emkt_regions VALUES(2690, 167, 'IFU', 'Ifugao', 'Russian');
INSERT INTO emkt_regions VALUES(2691, 167, 'ILI', 'Iloilo', 'Russian');
INSERT INTO emkt_regions VALUES(2692, 167, 'ILN', 'Ilocos Norte', 'Russian');
INSERT INTO emkt_regions VALUES(2693, 167, 'ILS', 'Ilocos Sur', 'Russian');
INSERT INTO emkt_regions VALUES(2694, 167, 'ISA', 'Isabela', 'Russian');
INSERT INTO emkt_regions VALUES(2695, 167, 'KAL', 'Kalinga', 'Russian');
INSERT INTO emkt_regions VALUES(2696, 167, 'LAG', 'Laguna', 'Russian');
INSERT INTO emkt_regions VALUES(2697, 167, 'LAN', 'Lanao del Norte', 'Russian');
INSERT INTO emkt_regions VALUES(2698, 167, 'LAS', 'Lanao del Sur', 'Russian');
INSERT INTO emkt_regions VALUES(2699, 167, 'LEY', 'Leyte', 'Russian');
INSERT INTO emkt_regions VALUES(2700, 167, 'LUN', 'La Union', 'Russian');
INSERT INTO emkt_regions VALUES(2701, 167, 'MAD', 'Marinduque', 'Russian');
INSERT INTO emkt_regions VALUES(2702, 167, 'MAG', 'Maguindanao', 'Russian');
INSERT INTO emkt_regions VALUES(2703, 167, 'MAS', 'Masbate', 'Russian');
INSERT INTO emkt_regions VALUES(2704, 167, 'MDC', 'Mindoro Occidental', 'Russian');
INSERT INTO emkt_regions VALUES(2705, 167, 'MDR', 'Mindoro Oriental', 'Russian');
INSERT INTO emkt_regions VALUES(2706, 167, 'MOU', 'Mountain Province', 'Russian');
INSERT INTO emkt_regions VALUES(2707, 167, 'MSC', 'Misamis Occidental', 'Russian');
INSERT INTO emkt_regions VALUES(2708, 167, 'MSR', 'Misamis Oriental', 'Russian');
INSERT INTO emkt_regions VALUES(2709, 167, 'NCO', 'Cotabato', 'Russian');
INSERT INTO emkt_regions VALUES(2710, 167, 'NSA', 'Northern Samar', 'Russian');
INSERT INTO emkt_regions VALUES(2711, 167, 'NEC', 'Negros Occidental', 'Russian');
INSERT INTO emkt_regions VALUES(2712, 167, 'NER', 'Negros Oriental', 'Russian');
INSERT INTO emkt_regions VALUES(2713, 167, 'NUE', 'Nueva Ecija', 'Russian');
INSERT INTO emkt_regions VALUES(2714, 167, 'NUV', 'Nueva Vizcaya', 'Russian');
INSERT INTO emkt_regions VALUES(2715, 167, 'PAM', 'Pampanga', 'Russian');
INSERT INTO emkt_regions VALUES(2716, 167, 'PAN', 'Pangasinan', 'Russian');
INSERT INTO emkt_regions VALUES(2717, 167, 'PLW', 'Palawan', 'Russian');
INSERT INTO emkt_regions VALUES(2718, 167, 'QUE', 'Quezon', 'Russian');
INSERT INTO emkt_regions VALUES(2719, 167, 'QUI', 'Quirino', 'Russian');
INSERT INTO emkt_regions VALUES(2720, 167, 'RIZ', 'Rizal', 'Russian');
INSERT INTO emkt_regions VALUES(2721, 167, 'ROM', 'Romblon', 'Russian');
INSERT INTO emkt_regions VALUES(2722, 167, 'SAR', 'Sarangani', 'Russian');
INSERT INTO emkt_regions VALUES(2723, 167, 'SCO', 'South Cotabato', 'Russian');
INSERT INTO emkt_regions VALUES(2724, 167, 'SIG', 'Siquijor', 'Russian');
INSERT INTO emkt_regions VALUES(2725, 167, 'SLE', 'Southern Leyte', 'Russian');
INSERT INTO emkt_regions VALUES(2726, 167, 'SLU', 'Sulu', 'Russian');
INSERT INTO emkt_regions VALUES(2727, 167, 'SOR', 'Sorsogon', 'Russian');
INSERT INTO emkt_regions VALUES(2728, 167, 'SUK', 'Sultan Kudarat', 'Russian');
INSERT INTO emkt_regions VALUES(2729, 167, 'SUN', 'Surigao del Norte', 'Russian');
INSERT INTO emkt_regions VALUES(2730, 167, 'SUR', 'Surigao del Sur', 'Russian');
INSERT INTO emkt_regions VALUES(2731, 167, 'TAR', 'Tarlac', 'Russian');
INSERT INTO emkt_regions VALUES(2732, 167, 'TAW', 'Tawi-Tawi', 'Russian');
INSERT INTO emkt_regions VALUES(2733, 167, 'WSA', 'Samar', 'Russian');
INSERT INTO emkt_regions VALUES(2734, 167, 'ZAN', 'Zamboanga del Norte', 'Russian');
INSERT INTO emkt_regions VALUES(2735, 167, 'ZAS', 'Zamboanga del Sur', 'Russian');
INSERT INTO emkt_regions VALUES(2736, 167, 'ZMB', 'Zambales', 'Russian');
INSERT INTO emkt_regions VALUES(2737, 167, 'ZSI', 'Zamboanga Sibugay', 'Russian');

INSERT INTO emkt_countries VALUES (168,'Острова Питкэрн','Russian','PN','PCN','');

INSERT INTO emkt_regions VALUES(4270, 168, 'NOCODE', 'Pitcairn', 'Russian');

INSERT INTO emkt_countries VALUES (169,'Польша','Russian','PL','POL','');

INSERT INTO emkt_regions VALUES(2738, 169, 'DS', 'Dolnośląskie', 'Russian');
INSERT INTO emkt_regions VALUES(2739, 169, 'KP', 'Kujawsko-Pomorskie', 'Russian');
INSERT INTO emkt_regions VALUES(2740, 169, 'LU', 'Lubelskie', 'Russian');
INSERT INTO emkt_regions VALUES(2741, 169, 'LB', 'Lubuskie', 'Russian');
INSERT INTO emkt_regions VALUES(2742, 169, 'LD', 'Łódzkie', 'Russian');
INSERT INTO emkt_regions VALUES(2743, 169, 'MA', 'Małopolskie', 'Russian');
INSERT INTO emkt_regions VALUES(2744, 169, 'MZ', 'Mazowieckie', 'Russian');
INSERT INTO emkt_regions VALUES(2745, 169, 'OP', 'Opolskie', 'Russian');
INSERT INTO emkt_regions VALUES(2746, 169, 'PK', 'Podkarpackie', 'Russian');
INSERT INTO emkt_regions VALUES(2747, 169, 'PD', 'Podlaskie', 'Russian');
INSERT INTO emkt_regions VALUES(2748, 169, 'PM', 'Pomorskie', 'Russian');
INSERT INTO emkt_regions VALUES(2749, 169, 'SL', 'Śląskie', 'Russian');
INSERT INTO emkt_regions VALUES(2750, 169, 'SK', 'Świętokrzyskie', 'Russian');
INSERT INTO emkt_regions VALUES(2751, 169, 'WN', 'Warmińsko-Mazurskie', 'Russian');
INSERT INTO emkt_regions VALUES(2752, 169, 'WP', 'Wielkopolskie', 'Russian');
INSERT INTO emkt_regions VALUES(2753, 169, 'ZP', 'Zachodniopomorskie', 'Russian');

INSERT INTO emkt_countries VALUES (170,'Португалия','Russian','PT','PRT','');

INSERT INTO emkt_regions VALUES(2754, 170, '01', 'Aveiro', 'Russian');
INSERT INTO emkt_regions VALUES(2755, 170, '02', 'Beja', 'Russian');
INSERT INTO emkt_regions VALUES(2756, 170, '03', 'Braga', 'Russian');
INSERT INTO emkt_regions VALUES(2757, 170, '04', 'Bragança', 'Russian');
INSERT INTO emkt_regions VALUES(2758, 170, '05', 'Castelo Branco', 'Russian');
INSERT INTO emkt_regions VALUES(2759, 170, '06', 'Coimbra', 'Russian');
INSERT INTO emkt_regions VALUES(2760, 170, '07', 'Évora', 'Russian');
INSERT INTO emkt_regions VALUES(2761, 170, '08', 'Faro', 'Russian');
INSERT INTO emkt_regions VALUES(2762, 170, '09', 'Guarda', 'Russian');
INSERT INTO emkt_regions VALUES(2763, 170, '10', 'Leiria', 'Russian');
INSERT INTO emkt_regions VALUES(2764, 170, '11', 'Lisboa', 'Russian');
INSERT INTO emkt_regions VALUES(2765, 170, '12', 'Portalegre', 'Russian');
INSERT INTO emkt_regions VALUES(2766, 170, '13', 'Porto', 'Russian');
INSERT INTO emkt_regions VALUES(2767, 170, '14', 'Santarém', 'Russian');
INSERT INTO emkt_regions VALUES(2768, 170, '15', 'Setúbal', 'Russian');
INSERT INTO emkt_regions VALUES(2769, 170, '16', 'Viana do Castelo', 'Russian');
INSERT INTO emkt_regions VALUES(2770, 170, '17', 'Vila Real', 'Russian');
INSERT INTO emkt_regions VALUES(2771, 170, '18', 'Viseu', 'Russian');
INSERT INTO emkt_regions VALUES(2772, 170, '20', 'Região Autónoma dos Açores', 'Russian');
INSERT INTO emkt_regions VALUES(2773, 170, '30', 'Região Autónoma da Madeira', 'Russian');

INSERT INTO emkt_countries VALUES (171,'Пуэрто-Рико','Russian','PR','PRI','');

INSERT INTO emkt_regions VALUES(4271, 171, 'NOCODE', 'Puerto Rico', 'Russian');

INSERT INTO emkt_countries VALUES (172,'Катар','Russian','QA','QAT','');

INSERT INTO emkt_regions VALUES(2774, 172, 'DA', 'الدوحة', 'Russian');
INSERT INTO emkt_regions VALUES(2775, 172, 'GH', 'الغويرية', 'Russian');
INSERT INTO emkt_regions VALUES(2776, 172, 'JB', 'جريان الباطنة', 'Russian');
INSERT INTO emkt_regions VALUES(2777, 172, 'JU', 'الجميلية', 'Russian');
INSERT INTO emkt_regions VALUES(2778, 172, 'KH', 'الخور', 'Russian');
INSERT INTO emkt_regions VALUES(2779, 172, 'ME', 'مسيعيد', 'Russian');
INSERT INTO emkt_regions VALUES(2780, 172, 'MS', 'الشمال', 'Russian');
INSERT INTO emkt_regions VALUES(2781, 172, 'RA', 'الريان', 'Russian');
INSERT INTO emkt_regions VALUES(2782, 172, 'US', 'أم صلال', 'Russian');
INSERT INTO emkt_regions VALUES(2783, 172, 'WA', 'الوكرة', 'Russian');

INSERT INTO emkt_countries VALUES (173,'Реюньон','Russian','RE','REU','');

INSERT INTO emkt_regions VALUES(4272, 173, 'NOCODE', 'Reunion', 'Russian');

INSERT INTO emkt_countries VALUES (174,'Румыния','Russian','RO','ROM','');

INSERT INTO emkt_regions VALUES(2784, 174, 'AB', 'Alba', 'Russian');
INSERT INTO emkt_regions VALUES(2785, 174, 'AG', 'Argeş', 'Russian');
INSERT INTO emkt_regions VALUES(2786, 174, 'AR', 'Arad', 'Russian');
INSERT INTO emkt_regions VALUES(2787, 174, 'B', 'Bucureşti', 'Russian');
INSERT INTO emkt_regions VALUES(2788, 174, 'BC', 'Bacău', 'Russian');
INSERT INTO emkt_regions VALUES(2789, 174, 'BH', 'Bihor', 'Russian');
INSERT INTO emkt_regions VALUES(2790, 174, 'BN', 'Bistriţa-Năsăud', 'Russian');
INSERT INTO emkt_regions VALUES(2791, 174, 'BR', 'Brăila', 'Russian');
INSERT INTO emkt_regions VALUES(2792, 174, 'BT', 'Botoşani', 'Russian');
INSERT INTO emkt_regions VALUES(2793, 174, 'BV', 'Braşov', 'Russian');
INSERT INTO emkt_regions VALUES(2794, 174, 'BZ', 'Buzău', 'Russian');
INSERT INTO emkt_regions VALUES(2795, 174, 'CJ', 'Cluj', 'Russian');
INSERT INTO emkt_regions VALUES(2796, 174, 'CL', 'Călăraşi', 'Russian');
INSERT INTO emkt_regions VALUES(2797, 174, 'CS', 'Caraş-Severin', 'Russian');
INSERT INTO emkt_regions VALUES(2798, 174, 'CT', 'Constanţa', 'Russian');
INSERT INTO emkt_regions VALUES(2799, 174, 'CV', 'Covasna', 'Russian');
INSERT INTO emkt_regions VALUES(2800, 174, 'DB', 'Dâmboviţa', 'Russian');
INSERT INTO emkt_regions VALUES(2801, 174, 'DJ', 'Dolj', 'Russian');
INSERT INTO emkt_regions VALUES(2802, 174, 'GJ', 'Gorj', 'Russian');
INSERT INTO emkt_regions VALUES(2803, 174, 'GL', 'Galaţi', 'Russian');
INSERT INTO emkt_regions VALUES(2804, 174, 'GR', 'Giurgiu', 'Russian');
INSERT INTO emkt_regions VALUES(2805, 174, 'HD', 'Hunedoara', 'Russian');
INSERT INTO emkt_regions VALUES(2806, 174, 'HG', 'Harghita', 'Russian');
INSERT INTO emkt_regions VALUES(2807, 174, 'IF', 'Ilfov', 'Russian');
INSERT INTO emkt_regions VALUES(2808, 174, 'IL', 'Ialomiţa', 'Russian');
INSERT INTO emkt_regions VALUES(2809, 174, 'IS', 'Iaşi', 'Russian');
INSERT INTO emkt_regions VALUES(2810, 174, 'MH', 'Mehedinţi', 'Russian');
INSERT INTO emkt_regions VALUES(2811, 174, 'MM', 'Maramureş', 'Russian');
INSERT INTO emkt_regions VALUES(2812, 174, 'MS', 'Mureş', 'Russian');
INSERT INTO emkt_regions VALUES(2813, 174, 'NT', 'Neamţ', 'Russian');
INSERT INTO emkt_regions VALUES(2814, 174, 'OT', 'Olt', 'Russian');
INSERT INTO emkt_regions VALUES(2815, 174, 'PH', 'Prahova', 'Russian');
INSERT INTO emkt_regions VALUES(2816, 174, 'SB', 'Sibiu', 'Russian');
INSERT INTO emkt_regions VALUES(2817, 174, 'SJ', 'Sălaj', 'Russian');
INSERT INTO emkt_regions VALUES(2818, 174, 'SM', 'Satu Mare', 'Russian');
INSERT INTO emkt_regions VALUES(2819, 174, 'SV', 'Suceava', 'Russian');
INSERT INTO emkt_regions VALUES(2820, 174, 'TL', 'Tulcea', 'Russian');
INSERT INTO emkt_regions VALUES(2821, 174, 'TM', 'Timiş', 'Russian');
INSERT INTO emkt_regions VALUES(2822, 174, 'TR', 'Teleorman', 'Russian');
INSERT INTO emkt_regions VALUES(2823, 174, 'VL', 'Vâlcea', 'Russian');
INSERT INTO emkt_regions VALUES(2824, 174, 'VN', 'Vrancea', 'Russian');
INSERT INTO emkt_regions VALUES(2825, 174, 'VS', 'Vaslui', 'Russian');

INSERT INTO emkt_countries VALUES (175,'Российская Федерация','Russian','RU','RUS','');

INSERT INTO emkt_regions VALUES(2826, 175, 'AD', 'Республика Адыгея', 'Russian');
INSERT INTO emkt_regions VALUES(2827, 175, 'AL', 'Республика Алтай', 'Russian');
INSERT INTO emkt_regions VALUES(2828, 175, 'ALT', 'Алтайский край', 'Russian');
INSERT INTO emkt_regions VALUES(2829, 175, 'AMU', 'Амурская область', 'Russian');
INSERT INTO emkt_regions VALUES(2830, 175, 'ARK', 'Архангельская область', 'Russian');
INSERT INTO emkt_regions VALUES(2831, 175, 'AST', 'Астраханская область', 'Russian');
INSERT INTO emkt_regions VALUES(2832, 175, 'BA', 'Республика Башкортостан', 'Russian');
INSERT INTO emkt_regions VALUES(2833, 175, 'BEL', 'Белгородская область', 'Russian');
INSERT INTO emkt_regions VALUES(2834, 175, 'BRY', 'Брянская область', 'Russian');
INSERT INTO emkt_regions VALUES(2835, 175, 'BU', 'Республика Бурятия', 'Russian');
INSERT INTO emkt_regions VALUES(2836, 175, 'CE', 'Чеченская Республика', 'Russian');
INSERT INTO emkt_regions VALUES(2837, 175, 'CHE', 'Челябинская область', 'Russian');
INSERT INTO emkt_regions VALUES(2838, 175, 'ZAB', 'Забайкальский край', 'Russian');
INSERT INTO emkt_regions VALUES(2839, 175, 'CHU', 'Чукотский автономный округ', 'Russian');
INSERT INTO emkt_regions VALUES(2840, 175, 'CU', 'Чувашская Республика', 'Russian');
INSERT INTO emkt_regions VALUES(2841, 175, 'DA', 'Республика Дагестан', 'Russian');
INSERT INTO emkt_regions VALUES(2842, 175, 'IN', 'Республика Ингушетия', 'Russian');
INSERT INTO emkt_regions VALUES(2843, 175, 'IRK', 'Иркутская область', 'Russian');
INSERT INTO emkt_regions VALUES(2844, 175, 'IVA', 'Ивановская область', 'Russian');
INSERT INTO emkt_regions VALUES(2845, 175, 'KAM', 'Камчатский край', 'Russian');
INSERT INTO emkt_regions VALUES(2846, 175, 'KB', 'Кабардино-Балкарская Республика', 'Russian');
INSERT INTO emkt_regions VALUES(2847, 175, 'KC', 'Карачаево-Черкесская Республика', 'Russian');
INSERT INTO emkt_regions VALUES(2848, 175, 'KDA', 'Краснодарский край', 'Russian');
INSERT INTO emkt_regions VALUES(2849, 175, 'KEM', 'Кемеровская область', 'Russian');
INSERT INTO emkt_regions VALUES(2850, 175, 'KGD', 'Калининградская область', 'Russian');
INSERT INTO emkt_regions VALUES(2851, 175, 'KGN', 'Курганская область', 'Russian');
INSERT INTO emkt_regions VALUES(2852, 175, 'KHA', 'Хабаровский край', 'Russian');
INSERT INTO emkt_regions VALUES(2853, 175, 'KHM', 'Ханты-Мансийский автономный округ—Югра', 'Russian');
INSERT INTO emkt_regions VALUES(2854, 175, 'KIA', 'Красноярский край', 'Russian');
INSERT INTO emkt_regions VALUES(2855, 175, 'KIR', 'Кировская область', 'Russian');
INSERT INTO emkt_regions VALUES(2856, 175, 'KK', 'Республика Хакасия', 'Russian');
INSERT INTO emkt_regions VALUES(2857, 175, 'KL', 'Республика Калмыкия', 'Russian');
INSERT INTO emkt_regions VALUES(2858, 175, 'KLU', 'Калужская область', 'Russian');
INSERT INTO emkt_regions VALUES(2859, 175, 'KO', 'Республика Коми', 'Russian');
INSERT INTO emkt_regions VALUES(2860, 175, 'KOS', 'Костромская область', 'Russian');
INSERT INTO emkt_regions VALUES(2861, 175, 'KR', 'Республика Карелия', 'Russian');
INSERT INTO emkt_regions VALUES(2862, 175, 'KRS', 'Курская область', 'Russian');
INSERT INTO emkt_regions VALUES(2863, 175, 'LEN', 'Ленинградская область', 'Russian');
INSERT INTO emkt_regions VALUES(2864, 175, 'LIP', 'Липецкая область', 'Russian');
INSERT INTO emkt_regions VALUES(2865, 175, 'MAG', 'Магаданская область', 'Russian');
INSERT INTO emkt_regions VALUES(2866, 175, 'ME', 'Республика Марий Эл', 'Russian');
INSERT INTO emkt_regions VALUES(2867, 175, 'MO', 'Республика Мордовия', 'Russian');
INSERT INTO emkt_regions VALUES(2868, 175, 'MOS', 'Московская область', 'Russian');
INSERT INTO emkt_regions VALUES(2869, 175, 'MOW', 'Москва', 'Russian');
INSERT INTO emkt_regions VALUES(2870, 175, 'MUR', 'Мурманская область', 'Russian');
INSERT INTO emkt_regions VALUES(2871, 175, 'NEN', 'Ненецкий автономный округ', 'Russian');
INSERT INTO emkt_regions VALUES(2872, 175, 'NGR', 'Новгородская область', 'Russian');
INSERT INTO emkt_regions VALUES(2873, 175, 'NIZ', 'Нижегородская область', 'Russian');
INSERT INTO emkt_regions VALUES(2874, 175, 'NVS', 'Новосибирская область', 'Russian');
INSERT INTO emkt_regions VALUES(2875, 175, 'OMS', 'Омская область', 'Russian');
INSERT INTO emkt_regions VALUES(2876, 175, 'ORE', 'Оренбургская область', 'Russian');
INSERT INTO emkt_regions VALUES(2877, 175, 'ORL', 'Орловская область', 'Russian');
INSERT INTO emkt_regions VALUES(2878, 175, 'PNZ', 'Пензенская область', 'Russian');
INSERT INTO emkt_regions VALUES(2879, 175, 'PRI', 'Приморский край', 'Russian');
INSERT INTO emkt_regions VALUES(2880, 175, 'PSK', 'Псковская область', 'Russian');
INSERT INTO emkt_regions VALUES(2881, 175, 'ROS', 'Ростовская область', 'Russian');
INSERT INTO emkt_regions VALUES(2882, 175, 'RYA', 'Рязанская область', 'Russian');
INSERT INTO emkt_regions VALUES(2883, 175, 'SA', 'Республика Саха (Якутия)', 'Russian');
INSERT INTO emkt_regions VALUES(2884, 175, 'SAK', 'Сахалинская область', 'Russian');
INSERT INTO emkt_regions VALUES(2885, 175, 'SAM', 'Самарская область', 'Russian');
INSERT INTO emkt_regions VALUES(2886, 175, 'SAR', 'Саратовская область', 'Russian');
INSERT INTO emkt_regions VALUES(2887, 175, 'SE', 'Республика Северная Осетия–Алания', 'Russian');
INSERT INTO emkt_regions VALUES(2888, 175, 'SMO', 'Смоленская область', 'Russian');
INSERT INTO emkt_regions VALUES(2889, 175, 'SPE', 'Санкт-Петербург', 'Russian');
INSERT INTO emkt_regions VALUES(2890, 175, 'STA', 'Ставропольский край', 'Russian');
INSERT INTO emkt_regions VALUES(2891, 175, 'SVE', 'Свердловская область', 'Russian');
INSERT INTO emkt_regions VALUES(2892, 175, 'TA', 'Республика Татарстан', 'Russian');
INSERT INTO emkt_regions VALUES(2893, 175, 'TAM', 'Тамбовская область', 'Russian');
INSERT INTO emkt_regions VALUES(2894, 175, 'TOM', 'Томская область', 'Russian');
INSERT INTO emkt_regions VALUES(2895, 175, 'TUL', 'Тульская область', 'Russian');
INSERT INTO emkt_regions VALUES(2896, 175, 'TVE', 'Тверская область', 'Russian');
INSERT INTO emkt_regions VALUES(2897, 175, 'TY', 'Республика Тыва', 'Russian');
INSERT INTO emkt_regions VALUES(2898, 175, 'TYU', 'Тюменская область', 'Russian');
INSERT INTO emkt_regions VALUES(2899, 175, 'UD', 'Удмуртская Республика', 'Russian');
INSERT INTO emkt_regions VALUES(2900, 175, 'ULY', 'Ульяновская область', 'Russian');
INSERT INTO emkt_regions VALUES(2901, 175, 'VGG', 'Волгоградская область', 'Russian');
INSERT INTO emkt_regions VALUES(2902, 175, 'VLA', 'Владимирская область', 'Russian');
INSERT INTO emkt_regions VALUES(2903, 175, 'VLG', 'Вологодская область', 'Russian');
INSERT INTO emkt_regions VALUES(2904, 175, 'VOR', 'Воронежская область', 'Russian');
INSERT INTO emkt_regions VALUES(2905, 175, 'PER', 'Пермский край', 'Russian');
INSERT INTO emkt_regions VALUES(2906, 175, 'YAN', 'Ямало-Ненецкий автономный округ', 'Russian');
INSERT INTO emkt_regions VALUES(2907, 175, 'YAR', 'Ярославская область', 'Russian');
INSERT INTO emkt_regions VALUES(2908, 175, 'YEV', 'Еврейская автономная область', 'Russian');

INSERT INTO emkt_countries VALUES (176,'Руанда','Russian','RW','RWA','');

INSERT INTO emkt_regions VALUES(2909, 176, 'N', 'Nord', 'Russian');
INSERT INTO emkt_regions VALUES(2910, 176, 'E', 'Est', 'Russian');
INSERT INTO emkt_regions VALUES(2911, 176, 'S', 'Sud', 'Russian');
INSERT INTO emkt_regions VALUES(2912, 176, 'O', 'Ouest', 'Russian');
INSERT INTO emkt_regions VALUES(2913, 176, 'K', 'Kigali', 'Russian');

INSERT INTO emkt_countries VALUES (177,'Сент-Китс и Невис','Russian','KN','KNA','');

INSERT INTO emkt_regions VALUES(2914, 177, 'K', 'Saint Kitts', 'Russian');
INSERT INTO emkt_regions VALUES(2915, 177, 'N', 'Nevis', 'Russian');

INSERT INTO emkt_countries VALUES (178,'Сент-Люсия','Russian','LC','LCA','');

INSERT INTO emkt_regions VALUES(2916, 178, 'AR', 'Anse-la-Raye', 'Russian');
INSERT INTO emkt_regions VALUES(2917, 178, 'CA', 'Castries', 'Russian');
INSERT INTO emkt_regions VALUES(2918, 178, 'CH', 'Choiseul', 'Russian');
INSERT INTO emkt_regions VALUES(2919, 178, 'DA', 'Dauphin', 'Russian');
INSERT INTO emkt_regions VALUES(2920, 178, 'DE', 'Dennery', 'Russian');
INSERT INTO emkt_regions VALUES(2921, 178, 'GI', 'Gros-Islet', 'Russian');
INSERT INTO emkt_regions VALUES(2922, 178, 'LA', 'Laborie', 'Russian');
INSERT INTO emkt_regions VALUES(2923, 178, 'MI', 'Micoud', 'Russian');
INSERT INTO emkt_regions VALUES(2924, 178, 'PR', 'Praslin', 'Russian');
INSERT INTO emkt_regions VALUES(2925, 178, 'SO', 'Soufriere', 'Russian');
INSERT INTO emkt_regions VALUES(2926, 178, 'VF', 'Vieux-Fort', 'Russian');

INSERT INTO emkt_countries VALUES (179,'Сент-Винсент и Гренадины','Russian','VC','VCT','');

INSERT INTO emkt_regions VALUES(2927, 179, 'C', 'Charlotte', 'Russian');
INSERT INTO emkt_regions VALUES(2928, 179, 'R', 'Grenadines', 'Russian');
INSERT INTO emkt_regions VALUES(2929, 179, 'A', 'Saint Andrew', 'Russian');
INSERT INTO emkt_regions VALUES(2930, 179, 'D', 'Saint David', 'Russian');
INSERT INTO emkt_regions VALUES(2931, 179, 'G', 'Saint George', 'Russian');
INSERT INTO emkt_regions VALUES(2932, 179, 'P', 'Saint Patrick', 'Russian');

INSERT INTO emkt_countries VALUES (180,'Самоа','Russian','WS','WSM','');

INSERT INTO emkt_regions VALUES(2933, 180, 'AA', 'A\'ana', 'Russian');
INSERT INTO emkt_regions VALUES(2934, 180, 'AL', 'Aiga-i-le-Tai', 'Russian');
INSERT INTO emkt_regions VALUES(2935, 180, 'AT', 'Atua', 'Russian');
INSERT INTO emkt_regions VALUES(2936, 180, 'FA', 'Fa\'asaleleaga', 'Russian');
INSERT INTO emkt_regions VALUES(2937, 180, 'GE', 'Gaga\'emauga', 'Russian');
INSERT INTO emkt_regions VALUES(2938, 180, 'GI', 'Gaga\'ifomauga', 'Russian');
INSERT INTO emkt_regions VALUES(2939, 180, 'PA', 'Palauli', 'Russian');
INSERT INTO emkt_regions VALUES(2940, 180, 'SA', 'Satupa\'itea', 'Russian');
INSERT INTO emkt_regions VALUES(2941, 180, 'TU', 'Tuamasaga', 'Russian');
INSERT INTO emkt_regions VALUES(2942, 180, 'VF', 'Va\'a-o-Fonoti', 'Russian');
INSERT INTO emkt_regions VALUES(2943, 180, 'VS', 'Vaisigano', 'Russian');

INSERT INTO emkt_countries VALUES (181,'Сан-Марино','Russian','SM','SMR','');

INSERT INTO emkt_regions VALUES(2944, 181, 'AC', 'Acquaviva', 'Russian');
INSERT INTO emkt_regions VALUES(2945, 181, 'BM', 'Borgo Maggiore', 'Russian');
INSERT INTO emkt_regions VALUES(2946, 181, 'CH', 'Chiesanuova', 'Russian');
INSERT INTO emkt_regions VALUES(2947, 181, 'DO', 'Domagnano', 'Russian');
INSERT INTO emkt_regions VALUES(2948, 181, 'FA', 'Faetano', 'Russian');
INSERT INTO emkt_regions VALUES(2949, 181, 'FI', 'Fiorentino', 'Russian');
INSERT INTO emkt_regions VALUES(2950, 181, 'MO', 'Montegiardino', 'Russian');
INSERT INTO emkt_regions VALUES(2951, 181, 'SM', 'Citta di San Marino', 'Russian');
INSERT INTO emkt_regions VALUES(2952, 181, 'SE', 'Serravalle', 'Russian');

INSERT INTO emkt_countries VALUES (182,'Сан-Томе и Принсипи','Russian','ST','STP','');

INSERT INTO emkt_regions VALUES(2953, 182, 'P', 'Príncipe', 'Russian');
INSERT INTO emkt_regions VALUES(2954, 182, 'S', 'São Tomé', 'Russian');

INSERT INTO emkt_countries VALUES (183,'Саудовская Аравия','Russian','SA','SAU','');

INSERT INTO emkt_regions VALUES(2955, 183, '01', 'الرياض', 'Russian');
INSERT INTO emkt_regions VALUES(2956, 183, '02', 'مكة المكرمة', 'Russian');
INSERT INTO emkt_regions VALUES(2957, 183, '03', 'المدينه', 'Russian');
INSERT INTO emkt_regions VALUES(2958, 183, '04', 'الشرقية', 'Russian');
INSERT INTO emkt_regions VALUES(2959, 183, '05', 'القصيم', 'Russian');
INSERT INTO emkt_regions VALUES(2960, 183, '06', 'حائل', 'Russian');
INSERT INTO emkt_regions VALUES(2961, 183, '07', 'تبوك', 'Russian');
INSERT INTO emkt_regions VALUES(2962, 183, '08', 'الحدود الشمالية', 'Russian');
INSERT INTO emkt_regions VALUES(2963, 183, '09', 'جيزان', 'Russian');
INSERT INTO emkt_regions VALUES(2964, 183, '10', 'نجران', 'Russian');
INSERT INTO emkt_regions VALUES(2965, 183, '11', 'الباحة', 'Russian');
INSERT INTO emkt_regions VALUES(2966, 183, '12', 'الجوف', 'Russian');
INSERT INTO emkt_regions VALUES(2967, 183, '14', 'عسير', 'Russian');

INSERT INTO emkt_countries VALUES (184,'Сенегал','Russian','SN','SEN','');

INSERT INTO emkt_regions VALUES(2968, 184, 'DA', 'Dakar', 'Russian');
INSERT INTO emkt_regions VALUES(2969, 184, 'DI', 'Diourbel', 'Russian');
INSERT INTO emkt_regions VALUES(2970, 184, 'FA', 'Fatick', 'Russian');
INSERT INTO emkt_regions VALUES(2971, 184, 'KA', 'Kaolack', 'Russian');
INSERT INTO emkt_regions VALUES(2972, 184, 'KO', 'Kolda', 'Russian');
INSERT INTO emkt_regions VALUES(2973, 184, 'LO', 'Louga', 'Russian');
INSERT INTO emkt_regions VALUES(2974, 184, 'MA', 'Matam', 'Russian');
INSERT INTO emkt_regions VALUES(2975, 184, 'SL', 'Saint-Louis', 'Russian');
INSERT INTO emkt_regions VALUES(2976, 184, 'TA', 'Tambacounda', 'Russian');
INSERT INTO emkt_regions VALUES(2977, 184, 'TH', 'Thies', 'Russian');
INSERT INTO emkt_regions VALUES(2978, 184, 'ZI', 'Ziguinchor', 'Russian');

INSERT INTO emkt_countries VALUES (185,'Сейшельские Острова','Russian','SC','SYC','');

INSERT INTO emkt_regions VALUES(2979, 185, 'AP', 'Anse aux Pins', 'Russian');
INSERT INTO emkt_regions VALUES(2980, 185, 'AB', 'Anse Boileau', 'Russian');
INSERT INTO emkt_regions VALUES(2981, 185, 'AE', 'Anse Etoile', 'Russian');
INSERT INTO emkt_regions VALUES(2982, 185, 'AL', 'Anse Louis', 'Russian');
INSERT INTO emkt_regions VALUES(2983, 185, 'AR', 'Anse Royale', 'Russian');
INSERT INTO emkt_regions VALUES(2984, 185, 'BL', 'Baie Lazare', 'Russian');
INSERT INTO emkt_regions VALUES(2985, 185, 'BS', 'Baie Sainte Anne', 'Russian');
INSERT INTO emkt_regions VALUES(2986, 185, 'BV', 'Beau Vallon', 'Russian');
INSERT INTO emkt_regions VALUES(2987, 185, 'BA', 'Bel Air', 'Russian');
INSERT INTO emkt_regions VALUES(2988, 185, 'BO', 'Bel Ombre', 'Russian');
INSERT INTO emkt_regions VALUES(2989, 185, 'CA', 'Cascade', 'Russian');
INSERT INTO emkt_regions VALUES(2990, 185, 'GL', 'Glacis', 'Russian');
INSERT INTO emkt_regions VALUES(2991, 185, 'GM', 'Grand\' Anse (on Mahe)', 'Russian');
INSERT INTO emkt_regions VALUES(2992, 185, 'GP', 'Grand\' Anse (on Praslin)', 'Russian');
INSERT INTO emkt_regions VALUES(2993, 185, 'DG', 'La Digue', 'Russian');
INSERT INTO emkt_regions VALUES(2994, 185, 'RA', 'La Riviere Anglaise', 'Russian');
INSERT INTO emkt_regions VALUES(2995, 185, 'MB', 'Mont Buxton', 'Russian');
INSERT INTO emkt_regions VALUES(2996, 185, 'MF', 'Mont Fleuri', 'Russian');
INSERT INTO emkt_regions VALUES(2997, 185, 'PL', 'Plaisance', 'Russian');
INSERT INTO emkt_regions VALUES(2998, 185, 'PR', 'Pointe La Rue', 'Russian');
INSERT INTO emkt_regions VALUES(2999, 185, 'PG', 'Port Glaud', 'Russian');
INSERT INTO emkt_regions VALUES(3000, 185, 'SL', 'Saint Louis', 'Russian');
INSERT INTO emkt_regions VALUES(3001, 185, 'TA', 'Takamaka', 'Russian');

INSERT INTO emkt_countries VALUES (186,'Сьерра-Леоне','Russian','SL','SLE','');

INSERT INTO emkt_regions VALUES(3002, 186, 'E', 'Eastern', 'Russian');
INSERT INTO emkt_regions VALUES(3003, 186, 'N', 'Northern', 'Russian');
INSERT INTO emkt_regions VALUES(3004, 186, 'S', 'Southern', 'Russian');
INSERT INTO emkt_regions VALUES(3005, 186, 'W', 'Western', 'Russian');

INSERT INTO emkt_countries VALUES (187,'Сингапур','Russian','SG','SGP','');

INSERT INTO emkt_regions VALUES(4273, 187, 'NOCODE', 'Singapore', 'Russian');

INSERT INTO emkt_countries VALUES (188,'Словакия','Russian','SK','SVK','');

INSERT INTO emkt_regions VALUES(3006, 188, 'BC', 'Banskobystrický kraj', 'Russian');
INSERT INTO emkt_regions VALUES(3007, 188, 'BL', 'Bratislavský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(3008, 188, 'KI', 'Košický kraj', 'Russian');
INSERT INTO emkt_regions VALUES(3009, 188, 'NJ', 'Nitrianský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(3010, 188, 'PV', 'Prešovský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(3011, 188, 'TA', 'Trnavský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(3012, 188, 'TC', 'Trenčianský kraj', 'Russian');
INSERT INTO emkt_regions VALUES(3013, 188, 'ZI', 'Žilinský kraj', 'Russian');

INSERT INTO emkt_countries VALUES (189,'Словения','Russian','SI','SVN','');

INSERT INTO emkt_regions VALUES(3014, 189, '001', 'Ajdovščina', 'Russian');
INSERT INTO emkt_regions VALUES(3015, 189, '002', 'Beltinci', 'Russian');
INSERT INTO emkt_regions VALUES(3016, 189, '003', 'Bled', 'Russian');
INSERT INTO emkt_regions VALUES(3017, 189, '004', 'Bohinj', 'Russian');
INSERT INTO emkt_regions VALUES(3018, 189, '005', 'Borovnica', 'Russian');
INSERT INTO emkt_regions VALUES(3019, 189, '006', 'Bovec', 'Russian');
INSERT INTO emkt_regions VALUES(3020, 189, '007', 'Brda', 'Russian');
INSERT INTO emkt_regions VALUES(3021, 189, '008', 'Brezovica', 'Russian');
INSERT INTO emkt_regions VALUES(3022, 189, '009', 'Brežice', 'Russian');
INSERT INTO emkt_regions VALUES(3023, 189, '010', 'Tišina', 'Russian');
INSERT INTO emkt_regions VALUES(3024, 189, '011', 'Celje', 'Russian');
INSERT INTO emkt_regions VALUES(3025, 189, '012', 'Cerklje na Gorenjskem', 'Russian');
INSERT INTO emkt_regions VALUES(3026, 189, '013', 'Cerknica', 'Russian');
INSERT INTO emkt_regions VALUES(3027, 189, '014', 'Cerkno', 'Russian');
INSERT INTO emkt_regions VALUES(3028, 189, '015', 'Črenšovci', 'Russian');
INSERT INTO emkt_regions VALUES(3029, 189, '016', 'Črna na Koroškem', 'Russian');
INSERT INTO emkt_regions VALUES(3030, 189, '017', 'Črnomelj', 'Russian');
INSERT INTO emkt_regions VALUES(3031, 189, '018', 'Destrnik', 'Russian');
INSERT INTO emkt_regions VALUES(3032, 189, '019', 'Divača', 'Russian');
INSERT INTO emkt_regions VALUES(3033, 189, '020', 'Dobrepolje', 'Russian');
INSERT INTO emkt_regions VALUES(3034, 189, '021', 'Dobrova-Polhov Gradec', 'Russian');
INSERT INTO emkt_regions VALUES(3035, 189, '022', 'Dol pri Ljubljani', 'Russian');
INSERT INTO emkt_regions VALUES(3036, 189, '023', 'Domžale', 'Russian');
INSERT INTO emkt_regions VALUES(3037, 189, '024', 'Dornava', 'Russian');
INSERT INTO emkt_regions VALUES(3038, 189, '025', 'Dravograd', 'Russian');
INSERT INTO emkt_regions VALUES(3039, 189, '026', 'Duplek', 'Russian');
INSERT INTO emkt_regions VALUES(3040, 189, '027', 'Gorenja vas-Poljane', 'Russian');
INSERT INTO emkt_regions VALUES(3041, 189, '028', 'Gorišnica', 'Russian');
INSERT INTO emkt_regions VALUES(3042, 189, '029', 'Gornja Radgona', 'Russian');
INSERT INTO emkt_regions VALUES(3043, 189, '030', 'Gornji Grad', 'Russian');
INSERT INTO emkt_regions VALUES(3044, 189, '031', 'Gornji Petrovci', 'Russian');
INSERT INTO emkt_regions VALUES(3045, 189, '032', 'Grosuplje', 'Russian');
INSERT INTO emkt_regions VALUES(3046, 189, '033', 'Šalovci', 'Russian');
INSERT INTO emkt_regions VALUES(3047, 189, '034', 'Hrastnik', 'Russian');
INSERT INTO emkt_regions VALUES(3048, 189, '035', 'Hrpelje-Kozina', 'Russian');
INSERT INTO emkt_regions VALUES(3049, 189, '036', 'Idrija', 'Russian');
INSERT INTO emkt_regions VALUES(3050, 189, '037', 'Ig', 'Russian');
INSERT INTO emkt_regions VALUES(3051, 189, '038', 'Ilirska Bistrica', 'Russian');
INSERT INTO emkt_regions VALUES(3052, 189, '039', 'Ivančna Gorica', 'Russian');
INSERT INTO emkt_regions VALUES(3053, 189, '040', 'Izola', 'Russian');
INSERT INTO emkt_regions VALUES(3054, 189, '041', 'Jesenice', 'Russian');
INSERT INTO emkt_regions VALUES(3055, 189, '042', 'Juršinci', 'Russian');
INSERT INTO emkt_regions VALUES(3056, 189, '043', 'Kamnik', 'Russian');
INSERT INTO emkt_regions VALUES(3057, 189, '044', 'Kanal ob Soči', 'Russian');
INSERT INTO emkt_regions VALUES(3058, 189, '045', 'Kidričevo', 'Russian');
INSERT INTO emkt_regions VALUES(3059, 189, '046', 'Kobarid', 'Russian');
INSERT INTO emkt_regions VALUES(3060, 189, '047', 'Kobilje', 'Russian');
INSERT INTO emkt_regions VALUES(3061, 189, '048', 'Kočevje', 'Russian');
INSERT INTO emkt_regions VALUES(3062, 189, '049', 'Komen', 'Russian');
INSERT INTO emkt_regions VALUES(3063, 189, '050', 'Koper', 'Russian');
INSERT INTO emkt_regions VALUES(3064, 189, '051', 'Kozje', 'Russian');
INSERT INTO emkt_regions VALUES(3065, 189, '052', 'Kranj', 'Russian');
INSERT INTO emkt_regions VALUES(3066, 189, '053', 'Kranjska Gora', 'Russian');
INSERT INTO emkt_regions VALUES(3067, 189, '054', 'Krško', 'Russian');
INSERT INTO emkt_regions VALUES(3068, 189, '055', 'Kungota', 'Russian');
INSERT INTO emkt_regions VALUES(3069, 189, '056', 'Kuzma', 'Russian');
INSERT INTO emkt_regions VALUES(3070, 189, '057', 'Laško', 'Russian');
INSERT INTO emkt_regions VALUES(3071, 189, '058', 'Lenart', 'Russian');
INSERT INTO emkt_regions VALUES(3072, 189, '059', 'Lendava', 'Russian');
INSERT INTO emkt_regions VALUES(3073, 189, '060', 'Litija', 'Russian');
INSERT INTO emkt_regions VALUES(3074, 189, '061', 'Ljubljana', 'Russian');
INSERT INTO emkt_regions VALUES(3075, 189, '062', 'Ljubno', 'Russian');
INSERT INTO emkt_regions VALUES(3076, 189, '063', 'Ljutomer', 'Russian');
INSERT INTO emkt_regions VALUES(3077, 189, '064', 'Logatec', 'Russian');
INSERT INTO emkt_regions VALUES(3078, 189, '065', 'Loška Dolina', 'Russian');
INSERT INTO emkt_regions VALUES(3079, 189, '066', 'Loški Potok', 'Russian');
INSERT INTO emkt_regions VALUES(3080, 189, '067', 'Luče', 'Russian');
INSERT INTO emkt_regions VALUES(3081, 189, '068', 'Lukovica', 'Russian');
INSERT INTO emkt_regions VALUES(3082, 189, '069', 'Majšperk', 'Russian');
INSERT INTO emkt_regions VALUES(3083, 189, '070', 'Maribor', 'Russian');
INSERT INTO emkt_regions VALUES(3084, 189, '071', 'Medvode', 'Russian');
INSERT INTO emkt_regions VALUES(3085, 189, '072', 'Mengeš', 'Russian');
INSERT INTO emkt_regions VALUES(3086, 189, '073', 'Metlika', 'Russian');
INSERT INTO emkt_regions VALUES(3087, 189, '074', 'Mežica', 'Russian');
INSERT INTO emkt_regions VALUES(3088, 189, '075', 'Miren-Kostanjevica', 'Russian');
INSERT INTO emkt_regions VALUES(3089, 189, '076', 'Mislinja', 'Russian');
INSERT INTO emkt_regions VALUES(3090, 189, '077', 'Moravče', 'Russian');
INSERT INTO emkt_regions VALUES(3091, 189, '078', 'Moravske Toplice', 'Russian');
INSERT INTO emkt_regions VALUES(3092, 189, '079', 'Mozirje', 'Russian');
INSERT INTO emkt_regions VALUES(3093, 189, '080', 'Murska Sobota', 'Russian');
INSERT INTO emkt_regions VALUES(3094, 189, '081', 'Muta', 'Russian');
INSERT INTO emkt_regions VALUES(3095, 189, '082', 'Naklo', 'Russian');
INSERT INTO emkt_regions VALUES(3096, 189, '083', 'Nazarje', 'Russian');
INSERT INTO emkt_regions VALUES(3097, 189, '084', 'Nova Gorica', 'Russian');
INSERT INTO emkt_regions VALUES(3098, 189, '085', 'Novo mesto', 'Russian');
INSERT INTO emkt_regions VALUES(3099, 189, '086', 'Odranci', 'Russian');
INSERT INTO emkt_regions VALUES(3100, 189, '087', 'Ormož', 'Russian');
INSERT INTO emkt_regions VALUES(3101, 189, '088', 'Osilnica', 'Russian');
INSERT INTO emkt_regions VALUES(3102, 189, '089', 'Pesnica', 'Russian');
INSERT INTO emkt_regions VALUES(3103, 189, '090', 'Piran', 'Russian');
INSERT INTO emkt_regions VALUES(3104, 189, '091', 'Pivka', 'Russian');
INSERT INTO emkt_regions VALUES(3105, 189, '092', 'Podčetrtek', 'Russian');
INSERT INTO emkt_regions VALUES(3106, 189, '093', 'Podvelka', 'Russian');
INSERT INTO emkt_regions VALUES(3107, 189, '094', 'Postojna', 'Russian');
INSERT INTO emkt_regions VALUES(3108, 189, '095', 'Preddvor', 'Russian');
INSERT INTO emkt_regions VALUES(3109, 189, '096', 'Ptuj', 'Russian');
INSERT INTO emkt_regions VALUES(3110, 189, '097', 'Puconci', 'Russian');
INSERT INTO emkt_regions VALUES(3111, 189, '098', 'Rače-Fram', 'Russian');
INSERT INTO emkt_regions VALUES(3112, 189, '099', 'Radeče', 'Russian');
INSERT INTO emkt_regions VALUES(3113, 189, '100', 'Radenci', 'Russian');
INSERT INTO emkt_regions VALUES(3114, 189, '101', 'Radlje ob Dravi', 'Russian');
INSERT INTO emkt_regions VALUES(3115, 189, '102', 'Radovljica', 'Russian');
INSERT INTO emkt_regions VALUES(3116, 189, '103', 'Ravne na Koroškem', 'Russian');
INSERT INTO emkt_regions VALUES(3117, 189, '104', 'Ribnica', 'Russian');
INSERT INTO emkt_regions VALUES(3118, 189, '106', 'Rogaška Slatina', 'Russian');
INSERT INTO emkt_regions VALUES(3119, 189, '105', 'Rogašovci', 'Russian');
INSERT INTO emkt_regions VALUES(3120, 189, '107', 'Rogatec', 'Russian');
INSERT INTO emkt_regions VALUES(3121, 189, '108', 'Ruše', 'Russian');
INSERT INTO emkt_regions VALUES(3122, 189, '109', 'Semič', 'Russian');
INSERT INTO emkt_regions VALUES(3123, 189, '110', 'Sevnica', 'Russian');
INSERT INTO emkt_regions VALUES(3124, 189, '111', 'Sežana', 'Russian');
INSERT INTO emkt_regions VALUES(3125, 189, '112', 'Slovenj Gradec', 'Russian');
INSERT INTO emkt_regions VALUES(3126, 189, '113', 'Slovenska Bistrica', 'Russian');
INSERT INTO emkt_regions VALUES(3127, 189, '114', 'Slovenske Konjice', 'Russian');
INSERT INTO emkt_regions VALUES(3128, 189, '115', 'Starše', 'Russian');
INSERT INTO emkt_regions VALUES(3129, 189, '116', 'Sveti Jurij', 'Russian');
INSERT INTO emkt_regions VALUES(3130, 189, '117', 'Šenčur', 'Russian');
INSERT INTO emkt_regions VALUES(3131, 189, '118', 'Šentilj', 'Russian');
INSERT INTO emkt_regions VALUES(3132, 189, '119', 'Šentjernej', 'Russian');
INSERT INTO emkt_regions VALUES(3133, 189, '120', 'Šentjur pri Celju', 'Russian');
INSERT INTO emkt_regions VALUES(3134, 189, '121', 'Škocjan', 'Russian');
INSERT INTO emkt_regions VALUES(3135, 189, '122', 'Škofja Loka', 'Russian');
INSERT INTO emkt_regions VALUES(3136, 189, '123', 'Škofljica', 'Russian');
INSERT INTO emkt_regions VALUES(3137, 189, '124', 'Šmarje pri Jelšah', 'Russian');
INSERT INTO emkt_regions VALUES(3138, 189, '125', 'Šmartno ob Paki', 'Russian');
INSERT INTO emkt_regions VALUES(3139, 189, '126', 'Šoštanj', 'Russian');
INSERT INTO emkt_regions VALUES(3140, 189, '127', 'Štore', 'Russian');
INSERT INTO emkt_regions VALUES(3141, 189, '128', 'Tolmin', 'Russian');
INSERT INTO emkt_regions VALUES(3142, 189, '129', 'Trbovlje', 'Russian');
INSERT INTO emkt_regions VALUES(3143, 189, '130', 'Trebnje', 'Russian');
INSERT INTO emkt_regions VALUES(3144, 189, '131', 'Tržič', 'Russian');
INSERT INTO emkt_regions VALUES(3145, 189, '132', 'Turnišče', 'Russian');
INSERT INTO emkt_regions VALUES(3146, 189, '133', 'Velenje', 'Russian');
INSERT INTO emkt_regions VALUES(3147, 189, '134', 'Velike Lašče', 'Russian');
INSERT INTO emkt_regions VALUES(3148, 189, '135', 'Videm', 'Russian');
INSERT INTO emkt_regions VALUES(3149, 189, '136', 'Vipava', 'Russian');
INSERT INTO emkt_regions VALUES(3150, 189, '137', 'Vitanje', 'Russian');
INSERT INTO emkt_regions VALUES(3151, 189, '138', 'Vodice', 'Russian');
INSERT INTO emkt_regions VALUES(3152, 189, '139', 'Vojnik', 'Russian');
INSERT INTO emkt_regions VALUES(3153, 189, '140', 'Vrhnika', 'Russian');
INSERT INTO emkt_regions VALUES(3154, 189, '141', 'Vuzenica', 'Russian');
INSERT INTO emkt_regions VALUES(3155, 189, '142', 'Zagorje ob Savi', 'Russian');
INSERT INTO emkt_regions VALUES(3156, 189, '143', 'Zavrč', 'Russian');
INSERT INTO emkt_regions VALUES(3157, 189, '144', 'Zreče', 'Russian');
INSERT INTO emkt_regions VALUES(3158, 189, '146', 'Železniki', 'Russian');
INSERT INTO emkt_regions VALUES(3159, 189, '147', 'Žiri', 'Russian');
INSERT INTO emkt_regions VALUES(3160, 189, '148', 'Benedikt', 'Russian');
INSERT INTO emkt_regions VALUES(3161, 189, '149', 'Bistrica ob Sotli', 'Russian');
INSERT INTO emkt_regions VALUES(3162, 189, '150', 'Bloke', 'Russian');
INSERT INTO emkt_regions VALUES(3163, 189, '151', 'Braslovče', 'Russian');
INSERT INTO emkt_regions VALUES(3164, 189, '152', 'Cankova', 'Russian');
INSERT INTO emkt_regions VALUES(3165, 189, '153', 'Cerkvenjak', 'Russian');
INSERT INTO emkt_regions VALUES(3166, 189, '154', 'Dobje', 'Russian');
INSERT INTO emkt_regions VALUES(3167, 189, '155', 'Dobrna', 'Russian');
INSERT INTO emkt_regions VALUES(3168, 189, '156', 'Dobrovnik', 'Russian');
INSERT INTO emkt_regions VALUES(3169, 189, '157', 'Dolenjske Toplice', 'Russian');
INSERT INTO emkt_regions VALUES(3170, 189, '158', 'Grad', 'Russian');
INSERT INTO emkt_regions VALUES(3171, 189, '159', 'Hajdina', 'Russian');
INSERT INTO emkt_regions VALUES(3172, 189, '160', 'Hoče-Slivnica', 'Russian');
INSERT INTO emkt_regions VALUES(3173, 189, '161', 'Hodoš', 'Russian');
INSERT INTO emkt_regions VALUES(3174, 189, '162', 'Horjul', 'Russian');
INSERT INTO emkt_regions VALUES(3175, 189, '163', 'Jezersko', 'Russian');
INSERT INTO emkt_regions VALUES(3176, 189, '164', 'Komenda', 'Russian');
INSERT INTO emkt_regions VALUES(3177, 189, '165', 'Kostel', 'Russian');
INSERT INTO emkt_regions VALUES(3178, 189, '166', 'Križevci', 'Russian');
INSERT INTO emkt_regions VALUES(3179, 189, '167', 'Lovrenc na Pohorju', 'Russian');
INSERT INTO emkt_regions VALUES(3180, 189, '168', 'Markovci', 'Russian');
INSERT INTO emkt_regions VALUES(3181, 189, '169', 'Miklavž na Dravskem polju', 'Russian');
INSERT INTO emkt_regions VALUES(3182, 189, '170', 'Mirna Peč', 'Russian');
INSERT INTO emkt_regions VALUES(3183, 189, '171', 'Oplotnica', 'Russian');
INSERT INTO emkt_regions VALUES(3184, 189, '172', 'Podlehnik', 'Russian');
INSERT INTO emkt_regions VALUES(3185, 189, '173', 'Polzela', 'Russian');
INSERT INTO emkt_regions VALUES(3186, 189, '174', 'Prebold', 'Russian');
INSERT INTO emkt_regions VALUES(3187, 189, '175', 'Prevalje', 'Russian');
INSERT INTO emkt_regions VALUES(3188, 189, '176', 'Razkrižje', 'Russian');
INSERT INTO emkt_regions VALUES(3189, 189, '177', 'Ribnica na Pohorju', 'Russian');
INSERT INTO emkt_regions VALUES(3190, 189, '178', 'Selnica ob Dravi', 'Russian');
INSERT INTO emkt_regions VALUES(3191, 189, '179', 'Sodražica', 'Russian');
INSERT INTO emkt_regions VALUES(3192, 189, '180', 'Solčava', 'Russian');
INSERT INTO emkt_regions VALUES(3193, 189, '181', 'Sveta Ana', 'Russian');
INSERT INTO emkt_regions VALUES(3194, 189, '182', 'Sveti Andraž v Slovenskih goricah', 'Russian');
INSERT INTO emkt_regions VALUES(3195, 189, '183', 'Šempeter-Vrtojba', 'Russian');
INSERT INTO emkt_regions VALUES(3196, 189, '184', 'Tabor', 'Russian');
INSERT INTO emkt_regions VALUES(3197, 189, '185', 'Trnovska vas', 'Russian');
INSERT INTO emkt_regions VALUES(3198, 189, '186', 'Trzin', 'Russian');
INSERT INTO emkt_regions VALUES(3199, 189, '187', 'Velika Polana', 'Russian');
INSERT INTO emkt_regions VALUES(3200, 189, '188', 'Veržej', 'Russian');
INSERT INTO emkt_regions VALUES(3201, 189, '189', 'Vransko', 'Russian');
INSERT INTO emkt_regions VALUES(3202, 189, '190', 'Žalec', 'Russian');
INSERT INTO emkt_regions VALUES(3203, 189, '191', 'Žetale', 'Russian');
INSERT INTO emkt_regions VALUES(3204, 189, '192', 'Žirovnica', 'Russian');
INSERT INTO emkt_regions VALUES(3205, 189, '193', 'Žužemberk', 'Russian');
INSERT INTO emkt_regions VALUES(3206, 189, '194', 'Šmartno pri Litiji', 'Russian');

INSERT INTO emkt_countries VALUES (190,'Соломоновы Острова','Russian','SB','SLB','');

INSERT INTO emkt_regions VALUES(3207, 190, 'CE', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(3208, 190, 'CH', 'Choiseul', 'Russian');
INSERT INTO emkt_regions VALUES(3209, 190, 'GC', 'Guadalcanal', 'Russian');
INSERT INTO emkt_regions VALUES(3210, 190, 'HO', 'Honiara', 'Russian');
INSERT INTO emkt_regions VALUES(3211, 190, 'IS', 'Isabel', 'Russian');
INSERT INTO emkt_regions VALUES(3212, 190, 'MK', 'Makira', 'Russian');
INSERT INTO emkt_regions VALUES(3213, 190, 'ML', 'Malaita', 'Russian');
INSERT INTO emkt_regions VALUES(3214, 190, 'RB', 'Rennell and Bellona', 'Russian');
INSERT INTO emkt_regions VALUES(3215, 190, 'TM', 'Temotu', 'Russian');
INSERT INTO emkt_regions VALUES(3216, 190, 'WE', 'Western', 'Russian');

INSERT INTO emkt_countries VALUES (191,'Сомали','Russian','SO','SOM','');

INSERT INTO emkt_regions VALUES(3217, 191, 'AD', 'Awdal', 'Russian');
INSERT INTO emkt_regions VALUES(3218, 191, 'BK', 'Bakool', 'Russian');
INSERT INTO emkt_regions VALUES(3219, 191, 'BN', 'Banaadir', 'Russian');
INSERT INTO emkt_regions VALUES(3220, 191, 'BR', 'Bari', 'Russian');
INSERT INTO emkt_regions VALUES(3221, 191, 'BY', 'Bay', 'Russian');
INSERT INTO emkt_regions VALUES(3222, 191, 'GD', 'Gedo', 'Russian');
INSERT INTO emkt_regions VALUES(3223, 191, 'GG', 'Galguduud', 'Russian');
INSERT INTO emkt_regions VALUES(3224, 191, 'HR', 'Hiiraan', 'Russian');
INSERT INTO emkt_regions VALUES(3225, 191, 'JD', 'Jubbada Dhexe', 'Russian');
INSERT INTO emkt_regions VALUES(3226, 191, 'JH', 'Jubbada Hoose', 'Russian');
INSERT INTO emkt_regions VALUES(3227, 191, 'MD', 'Mudug', 'Russian');
INSERT INTO emkt_regions VALUES(3228, 191, 'NG', 'Nugaal', 'Russian');
INSERT INTO emkt_regions VALUES(3229, 191, 'SD', 'Shabeellaha Dhexe', 'Russian');
INSERT INTO emkt_regions VALUES(3230, 191, 'SG', 'Sanaag', 'Russian');
INSERT INTO emkt_regions VALUES(3231, 191, 'SH', 'Shabeellaha Hoose', 'Russian');
INSERT INTO emkt_regions VALUES(3232, 191, 'SL', 'Sool', 'Russian');
INSERT INTO emkt_regions VALUES(3233, 191, 'TG', 'Togdheer', 'Russian');
INSERT INTO emkt_regions VALUES(3234, 191, 'WG', 'Woqooyi Galbeed', 'Russian');

INSERT INTO emkt_countries VALUES (192,'Южно-Африканская Республика','Russian','ZA','ZAF','');

INSERT INTO emkt_regions VALUES(3235, 192, 'EC', 'Eastern Cape', 'Russian');
INSERT INTO emkt_regions VALUES(3236, 192, 'FS', 'Free State', 'Russian');
INSERT INTO emkt_regions VALUES(3237, 192, 'GT', 'Gauteng', 'Russian');
INSERT INTO emkt_regions VALUES(3238, 192, 'LP', 'Limpopo', 'Russian');
INSERT INTO emkt_regions VALUES(3239, 192, 'MP', 'Mpumalanga', 'Russian');
INSERT INTO emkt_regions VALUES(3240, 192, 'NC', 'Northern Cape', 'Russian');
INSERT INTO emkt_regions VALUES(3241, 192, 'NL', 'KwaZulu-Natal', 'Russian');
INSERT INTO emkt_regions VALUES(3242, 192, 'NW', 'North-West', 'Russian');
INSERT INTO emkt_regions VALUES(3243, 192, 'WC', 'Western Cape', 'Russian');

INSERT INTO emkt_countries VALUES (193,'Южная Георгия и Южные Сандвичевы Острова','Russian','GS','SGS','');

INSERT INTO emkt_regions VALUES(4274, 193, 'NOCODE', 'South Georgia and the South Sandwich Islands', 'Russian');

INSERT INTO emkt_countries VALUES (194,'Испания','Russian','ES','ESP','');

INSERT INTO emkt_regions VALUES(3244, 194, 'AN', 'Andalucía', 'Russian');
INSERT INTO emkt_regions VALUES(3245, 194, 'AR', 'Aragón', 'Russian');
INSERT INTO emkt_regions VALUES(3246, 194, 'A', 'Alicante', 'Russian');
INSERT INTO emkt_regions VALUES(3247, 194, 'AB', 'Albacete', 'Russian');
INSERT INTO emkt_regions VALUES(3248, 194, 'AL', 'Almería', 'Russian');
INSERT INTO emkt_regions VALUES(3249, 194, 'AN', 'Andalucía', 'Russian');
INSERT INTO emkt_regions VALUES(3250, 194, 'AV', 'Ávila', 'Russian');
INSERT INTO emkt_regions VALUES(3251, 194, 'B', 'Barcelona', 'Russian');
INSERT INTO emkt_regions VALUES(3252, 194, 'BA', 'Badajoz', 'Russian');
INSERT INTO emkt_regions VALUES(3253, 194, 'BI', 'Vizcaya', 'Russian');
INSERT INTO emkt_regions VALUES(3254, 194, 'BU', 'Burgos', 'Russian');
INSERT INTO emkt_regions VALUES(3255, 194, 'C', 'A Coruña', 'Russian');
INSERT INTO emkt_regions VALUES(3256, 194, 'CA', 'Cádiz', 'Russian');
INSERT INTO emkt_regions VALUES(3257, 194, 'CC', 'Cáceres', 'Russian');
INSERT INTO emkt_regions VALUES(3258, 194, 'CE', 'Ceuta', 'Russian');
INSERT INTO emkt_regions VALUES(3259, 194, 'CL', 'Castilla y León', 'Russian');
INSERT INTO emkt_regions VALUES(3260, 194, 'CM', 'Castilla-La Mancha', 'Russian');
INSERT INTO emkt_regions VALUES(3261, 194, 'CN', 'Islas Canarias', 'Russian');
INSERT INTO emkt_regions VALUES(3262, 194, 'CO', 'Córdoba', 'Russian');
INSERT INTO emkt_regions VALUES(3263, 194, 'CR', 'Ciudad Real', 'Russian');
INSERT INTO emkt_regions VALUES(3264, 194, 'CS', 'Castellón', 'Russian');
INSERT INTO emkt_regions VALUES(3265, 194, 'CT', 'Catalonia', 'Russian');
INSERT INTO emkt_regions VALUES(3266, 194, 'CU', 'Cuenca', 'Russian');
INSERT INTO emkt_regions VALUES(3267, 194, 'EX', 'Extremadura', 'Russian');
INSERT INTO emkt_regions VALUES(3268, 194, 'GA', 'Galicia', 'Russian');
INSERT INTO emkt_regions VALUES(3269, 194, 'GC', 'Las Palmas', 'Russian');
INSERT INTO emkt_regions VALUES(3270, 194, 'GI', 'Girona', 'Russian');
INSERT INTO emkt_regions VALUES(3271, 194, 'GR', 'Granada', 'Russian');
INSERT INTO emkt_regions VALUES(3272, 194, 'GU', 'Guadalajara', 'Russian');
INSERT INTO emkt_regions VALUES(3273, 194, 'H', 'Huelva', 'Russian');
INSERT INTO emkt_regions VALUES(3274, 194, 'HU', 'Huesca', 'Russian');
INSERT INTO emkt_regions VALUES(3275, 194, 'IB', 'Islas Baleares', 'Russian');
INSERT INTO emkt_regions VALUES(3276, 194, 'J', 'Jaén', 'Russian');
INSERT INTO emkt_regions VALUES(3277, 194, 'L', 'Lleida', 'Russian');
INSERT INTO emkt_regions VALUES(3278, 194, 'LE', 'León', 'Russian');
INSERT INTO emkt_regions VALUES(3279, 194, 'LO', 'La Rioja', 'Russian');
INSERT INTO emkt_regions VALUES(3280, 194, 'LU', 'Lugo', 'Russian');
INSERT INTO emkt_regions VALUES(3281, 194, 'M', 'Madrid', 'Russian');
INSERT INTO emkt_regions VALUES(3282, 194, 'MA', 'Málaga', 'Russian');
INSERT INTO emkt_regions VALUES(3283, 194, 'ML', 'Melilla', 'Russian');
INSERT INTO emkt_regions VALUES(3284, 194, 'MU', 'Murcia', 'Russian');
INSERT INTO emkt_regions VALUES(3285, 194, 'NA', 'Navarre', 'Russian');
INSERT INTO emkt_regions VALUES(3286, 194, 'O', 'Asturias', 'Russian');
INSERT INTO emkt_regions VALUES(3287, 194, 'OR', 'Ourense', 'Russian');
INSERT INTO emkt_regions VALUES(3288, 194, 'P', 'Palencia', 'Russian');
INSERT INTO emkt_regions VALUES(3289, 194, 'PM', 'Baleares', 'Russian');
INSERT INTO emkt_regions VALUES(3290, 194, 'PO', 'Pontevedra', 'Russian');
INSERT INTO emkt_regions VALUES(3291, 194, 'PV', 'Basque Euskadi', 'Russian');
INSERT INTO emkt_regions VALUES(3292, 194, 'S', 'Cantabria', 'Russian');
INSERT INTO emkt_regions VALUES(3293, 194, 'SA', 'Salamanca', 'Russian');
INSERT INTO emkt_regions VALUES(3294, 194, 'SE', 'Seville', 'Russian');
INSERT INTO emkt_regions VALUES(3295, 194, 'SG', 'Segovia', 'Russian');
INSERT INTO emkt_regions VALUES(3296, 194, 'SO', 'Soria', 'Russian');
INSERT INTO emkt_regions VALUES(3297, 194, 'SS', 'Guipúzcoa', 'Russian');
INSERT INTO emkt_regions VALUES(3298, 194, 'T', 'Tarragona', 'Russian');
INSERT INTO emkt_regions VALUES(3299, 194, 'TE', 'Teruel', 'Russian');
INSERT INTO emkt_regions VALUES(3300, 194, 'TF', 'Santa Cruz De Tenerife', 'Russian');
INSERT INTO emkt_regions VALUES(3301, 194, 'TO', 'Toledo', 'Russian');
INSERT INTO emkt_regions VALUES(3302, 194, 'V', 'Valencia', 'Russian');
INSERT INTO emkt_regions VALUES(3303, 194, 'VA', 'Valladolid', 'Russian');
INSERT INTO emkt_regions VALUES(3304, 194, 'VI', 'Álava', 'Russian');
INSERT INTO emkt_regions VALUES(3305, 194, 'Z', 'Zaragoza', 'Russian');
INSERT INTO emkt_regions VALUES(3306, 194, 'ZA', 'Zamora', 'Russian');

INSERT INTO emkt_countries VALUES (195,'Шри-Ланка','Russian','LK','LKA','');

INSERT INTO emkt_regions VALUES(3307, 195, 'CE', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(3308, 195, 'NC', 'North Central', 'Russian');
INSERT INTO emkt_regions VALUES(3309, 195, 'NO', 'North', 'Russian');
INSERT INTO emkt_regions VALUES(3310, 195, 'EA', 'Eastern', 'Russian');
INSERT INTO emkt_regions VALUES(3311, 195, 'NW', 'North Western', 'Russian');
INSERT INTO emkt_regions VALUES(3312, 195, 'SO', 'Southern', 'Russian');
INSERT INTO emkt_regions VALUES(3313, 195, 'UV', 'Uva', 'Russian');
INSERT INTO emkt_regions VALUES(3314, 195, 'SA', 'Sabaragamuwa', 'Russian');
INSERT INTO emkt_regions VALUES(3315, 195, 'WE', 'Western', 'Russian');

INSERT INTO emkt_countries VALUES (196,'Остров Святой Елены','Russian','SH','SHN','');

INSERT INTO emkt_regions VALUES(4275, 196, 'NOCODE', 'St. Helena', 'Russian');

INSERT INTO emkt_countries VALUES (197,'Сен-Пьер и Микелон','Russian','PM','SPM','');

INSERT INTO emkt_regions VALUES(4276, 197, 'NOCODE', 'St. Pierre and Miquelon', 'Russian');

INSERT INTO emkt_countries VALUES (198,'Судан','Russian','SD','SDN','');

INSERT INTO emkt_regions VALUES(3316, 198, 'ANL', 'أعالي النيل', 'Russian');
INSERT INTO emkt_regions VALUES(3317, 198, 'BAM', 'البحر الأحمر', 'Russian');
INSERT INTO emkt_regions VALUES(3318, 198, 'BRT', 'البحيرات', 'Russian');
INSERT INTO emkt_regions VALUES(3319, 198, 'JZR', 'ولاية الجزيرة', 'Russian');
INSERT INTO emkt_regions VALUES(3320, 198, 'KRT', 'الخرطوم', 'Russian');
INSERT INTO emkt_regions VALUES(3321, 198, 'QDR', 'القضارف', 'Russian');
INSERT INTO emkt_regions VALUES(3322, 198, 'WDH', 'الوحدة', 'Russian');
INSERT INTO emkt_regions VALUES(3323, 198, 'ANB', 'النيل الأبيض', 'Russian');
INSERT INTO emkt_regions VALUES(3324, 198, 'ANZ', 'النيل الأزرق', 'Russian');
INSERT INTO emkt_regions VALUES(3325, 198, 'ASH', 'الشمالية', 'Russian');
INSERT INTO emkt_regions VALUES(3326, 198, 'BJA', 'الاستوائية الوسطى', 'Russian');
INSERT INTO emkt_regions VALUES(3327, 198, 'GIS', 'غرب الاستوائية', 'Russian');
INSERT INTO emkt_regions VALUES(3328, 198, 'GBG', 'غرب بحر الغزال', 'Russian');
INSERT INTO emkt_regions VALUES(3329, 198, 'GDA', 'غرب دارفور', 'Russian');
INSERT INTO emkt_regions VALUES(3330, 198, 'GKU', 'غرب كردفان', 'Russian');
INSERT INTO emkt_regions VALUES(3331, 198, 'JDA', 'جنوب دارفور', 'Russian');
INSERT INTO emkt_regions VALUES(3332, 198, 'JKU', 'جنوب كردفان', 'Russian');
INSERT INTO emkt_regions VALUES(3333, 198, 'JQL', 'جونقلي', 'Russian');
INSERT INTO emkt_regions VALUES(3334, 198, 'KSL', 'كسلا', 'Russian');
INSERT INTO emkt_regions VALUES(3335, 198, 'NNL', 'ولاية نهر النيل', 'Russian');
INSERT INTO emkt_regions VALUES(3336, 198, 'SBG', 'شمال بحر الغزال', 'Russian');
INSERT INTO emkt_regions VALUES(3337, 198, 'SDA', 'شمال دارفور', 'Russian');
INSERT INTO emkt_regions VALUES(3338, 198, 'SKU', 'شمال كردفان', 'Russian');
INSERT INTO emkt_regions VALUES(3339, 198, 'SIS', 'شرق الاستوائية', 'Russian');
INSERT INTO emkt_regions VALUES(3340, 198, 'SNR', 'سنار', 'Russian');
INSERT INTO emkt_regions VALUES(3341, 198, 'WRB', 'واراب', 'Russian');

INSERT INTO emkt_countries VALUES (199,'Суринам','Russian','SR','SUR','');

INSERT INTO emkt_regions VALUES(3342, 199, 'BR', 'Brokopondo', 'Russian');
INSERT INTO emkt_regions VALUES(3343, 199, 'CM', 'Commewijne', 'Russian');
INSERT INTO emkt_regions VALUES(3344, 199, 'CR', 'Coronie', 'Russian');
INSERT INTO emkt_regions VALUES(3345, 199, 'MA', 'Marowijne', 'Russian');
INSERT INTO emkt_regions VALUES(3346, 199, 'NI', 'Nickerie', 'Russian');
INSERT INTO emkt_regions VALUES(3347, 199, 'PM', 'Paramaribo', 'Russian');
INSERT INTO emkt_regions VALUES(3348, 199, 'PR', 'Para', 'Russian');
INSERT INTO emkt_regions VALUES(3349, 199, 'SA', 'Saramacca', 'Russian');
INSERT INTO emkt_regions VALUES(3350, 199, 'SI', 'Sipaliwini', 'Russian');
INSERT INTO emkt_regions VALUES(3351, 199, 'WA', 'Wanica', 'Russian');

INSERT INTO emkt_countries VALUES (200,'Шпицберген и Ян-Майен','Russian','SJ','SJM','');

INSERT INTO emkt_regions VALUES(4277, 200, 'NOCODE', 'Svalbard and Jan Mayen Islands', 'Russian');

INSERT INTO emkt_countries VALUES (201,'Свазиленд','Russian','SZ','SWZ','');

INSERT INTO emkt_regions VALUES(3352, 201, 'HH', 'Hhohho', 'Russian');
INSERT INTO emkt_regions VALUES(3353, 201, 'LU', 'Lubombo', 'Russian');
INSERT INTO emkt_regions VALUES(3354, 201, 'MA', 'Manzini', 'Russian');
INSERT INTO emkt_regions VALUES(3355, 201, 'SH', 'Shiselweni', 'Russian');

INSERT INTO emkt_countries VALUES (202,'Швеция','Russian','SE','SWE','');

INSERT INTO emkt_regions VALUES(3356, 202, 'AB', 'Stockholms län', 'Russian');
INSERT INTO emkt_regions VALUES(3357, 202, 'C', 'Uppsala län', 'Russian');
INSERT INTO emkt_regions VALUES(3358, 202, 'D', 'Södermanlands län', 'Russian');
INSERT INTO emkt_regions VALUES(3359, 202, 'E', 'Östergötlands län', 'Russian');
INSERT INTO emkt_regions VALUES(3360, 202, 'F', 'Jönköpings län', 'Russian');
INSERT INTO emkt_regions VALUES(3361, 202, 'G', 'Kronobergs län', 'Russian');
INSERT INTO emkt_regions VALUES(3362, 202, 'H', 'Kalmar län', 'Russian');
INSERT INTO emkt_regions VALUES(3363, 202, 'I', 'Gotlands län', 'Russian');
INSERT INTO emkt_regions VALUES(3364, 202, 'K', 'Blekinge län', 'Russian');
INSERT INTO emkt_regions VALUES(3365, 202, 'M', 'Skåne län', 'Russian');
INSERT INTO emkt_regions VALUES(3366, 202, 'N', 'Hallands län', 'Russian');
INSERT INTO emkt_regions VALUES(3367, 202, 'O', 'Västra Götalands län', 'Russian');
INSERT INTO emkt_regions VALUES(3368, 202, 'S', 'Värmlands län;', 'Russian');
INSERT INTO emkt_regions VALUES(3369, 202, 'T', 'Örebro län', 'Russian');
INSERT INTO emkt_regions VALUES(3370, 202, 'U', 'Västmanlands län;', 'Russian');
INSERT INTO emkt_regions VALUES(3371, 202, 'W', 'Dalarnas län', 'Russian');
INSERT INTO emkt_regions VALUES(3372, 202, 'X', 'Gävleborgs län', 'Russian');
INSERT INTO emkt_regions VALUES(3373, 202, 'Y', 'Västernorrlands län', 'Russian');
INSERT INTO emkt_regions VALUES(3374, 202, 'Z', 'Jämtlands län', 'Russian');
INSERT INTO emkt_regions VALUES(3375, 202, 'AC', 'Västerbottens län', 'Russian');
INSERT INTO emkt_regions VALUES(3376, 202, 'BD', 'Norrbottens län', 'Russian');

INSERT INTO emkt_countries VALUES (203,'Швейцария','Russian','CH','CHE','');

INSERT INTO emkt_regions VALUES(3377, 203, 'ZH', 'Zürich', 'Russian');
INSERT INTO emkt_regions VALUES(3378, 203, 'BE', 'Bern', 'Russian');
INSERT INTO emkt_regions VALUES(3379, 203, 'LU', 'Luzern', 'Russian');
INSERT INTO emkt_regions VALUES(3380, 203, 'UR', 'Uri', 'Russian');
INSERT INTO emkt_regions VALUES(3381, 203, 'SZ', 'Schwyz', 'Russian');
INSERT INTO emkt_regions VALUES(3382, 203, 'OW', 'Obwalden', 'Russian');
INSERT INTO emkt_regions VALUES(3383, 203, 'NW', 'Nidwalden', 'Russian');
INSERT INTO emkt_regions VALUES(3384, 203, 'GL', 'Glasrus', 'Russian');
INSERT INTO emkt_regions VALUES(3385, 203, 'ZG', 'Zug', 'Russian');
INSERT INTO emkt_regions VALUES(3386, 203, 'FR', 'Fribourg', 'Russian');
INSERT INTO emkt_regions VALUES(3387, 203, 'SO', 'Solothurn', 'Russian');
INSERT INTO emkt_regions VALUES(3388, 203, 'BS', 'Basel-Stadt', 'Russian');
INSERT INTO emkt_regions VALUES(3389, 203, 'BL', 'Basel-Landschaft', 'Russian');
INSERT INTO emkt_regions VALUES(3390, 203, 'SH', 'Schaffhausen', 'Russian');
INSERT INTO emkt_regions VALUES(3391, 203, 'AR', 'Appenzell Ausserrhoden', 'Russian');
INSERT INTO emkt_regions VALUES(3392, 203, 'AI', 'Appenzell Innerrhoden', 'Russian');
INSERT INTO emkt_regions VALUES(3393, 203, 'SG', 'Saint Gallen', 'Russian');
INSERT INTO emkt_regions VALUES(3394, 203, 'GR', 'Graubünden', 'Russian');
INSERT INTO emkt_regions VALUES(3395, 203, 'AG', 'Aargau', 'Russian');
INSERT INTO emkt_regions VALUES(3396, 203, 'TG', 'Thurgau', 'Russian');
INSERT INTO emkt_regions VALUES(3397, 203, 'TI', 'Ticino', 'Russian');
INSERT INTO emkt_regions VALUES(3398, 203, 'VD', 'Vaud', 'Russian');
INSERT INTO emkt_regions VALUES(3399, 203, 'VS', 'Valais', 'Russian');
INSERT INTO emkt_regions VALUES(3400, 203, 'NE', 'Nuechâtel', 'Russian');
INSERT INTO emkt_regions VALUES(3401, 203, 'GE', 'Genève', 'Russian');
INSERT INTO emkt_regions VALUES(3402, 203, 'JU', 'Jura', 'Russian');

INSERT INTO emkt_countries VALUES (204,'Сирийская Арабская Республика','Russian','SY','SYR','');

INSERT INTO emkt_regions VALUES(3403, 204, 'DI', 'دمشق', 'Russian');
INSERT INTO emkt_regions VALUES(3404, 204, 'DR', 'درعا', 'Russian');
INSERT INTO emkt_regions VALUES(3405, 204, 'DZ', 'دير الزور', 'Russian');
INSERT INTO emkt_regions VALUES(3406, 204, 'HA', 'الحسكة', 'Russian');
INSERT INTO emkt_regions VALUES(3407, 204, 'HI', 'حمص', 'Russian');
INSERT INTO emkt_regions VALUES(3408, 204, 'HL', 'حلب', 'Russian');
INSERT INTO emkt_regions VALUES(3409, 204, 'HM', 'حماه', 'Russian');
INSERT INTO emkt_regions VALUES(3410, 204, 'ID', 'ادلب', 'Russian');
INSERT INTO emkt_regions VALUES(3411, 204, 'LA', 'اللاذقية', 'Russian');
INSERT INTO emkt_regions VALUES(3412, 204, 'QU', 'القنيطرة', 'Russian');
INSERT INTO emkt_regions VALUES(3413, 204, 'RA', 'الرقة', 'Russian');
INSERT INTO emkt_regions VALUES(3414, 204, 'RD', 'ریف دمشق', 'Russian');
INSERT INTO emkt_regions VALUES(3415, 204, 'SU', 'السويداء', 'Russian');
INSERT INTO emkt_regions VALUES(3416, 204, 'TA', 'طرطوس', 'Russian');

INSERT INTO emkt_countries VALUES (205,'Тайвань','Russian','TW','TWN','');

INSERT INTO emkt_regions VALUES(3417, 205, 'CHA', '彰化縣', 'Russian');
INSERT INTO emkt_regions VALUES(3418, 205, 'CYI', '嘉義市', 'Russian');
INSERT INTO emkt_regions VALUES(3419, 205, 'CYQ', '嘉義縣', 'Russian');
INSERT INTO emkt_regions VALUES(3420, 205, 'HSQ', '新竹縣', 'Russian');
INSERT INTO emkt_regions VALUES(3421, 205, 'HSZ', '新竹市', 'Russian');
INSERT INTO emkt_regions VALUES(3422, 205, 'HUA', '花蓮縣', 'Russian');
INSERT INTO emkt_regions VALUES(3423, 205, 'ILA', '宜蘭縣', 'Russian');
INSERT INTO emkt_regions VALUES(3424, 205, 'KEE', '基隆市', 'Russian');
INSERT INTO emkt_regions VALUES(3425, 205, 'KHH', '高雄市', 'Russian');
INSERT INTO emkt_regions VALUES(3426, 205, 'KHQ', '高雄縣', 'Russian');
INSERT INTO emkt_regions VALUES(3427, 205, 'MIA', '苗栗縣', 'Russian');
INSERT INTO emkt_regions VALUES(3428, 205, 'NAN', '南投縣', 'Russian');
INSERT INTO emkt_regions VALUES(3429, 205, 'PEN', '澎湖縣', 'Russian');
INSERT INTO emkt_regions VALUES(3430, 205, 'PIF', '屏東縣', 'Russian');
INSERT INTO emkt_regions VALUES(3431, 205, 'TAO', '桃源县', 'Russian');
INSERT INTO emkt_regions VALUES(3432, 205, 'TNN', '台南市', 'Russian');
INSERT INTO emkt_regions VALUES(3433, 205, 'TNQ', '台南縣', 'Russian');
INSERT INTO emkt_regions VALUES(3434, 205, 'TPE', '臺北市', 'Russian');
INSERT INTO emkt_regions VALUES(3435, 205, 'TPQ', '臺北縣', 'Russian');
INSERT INTO emkt_regions VALUES(3436, 205, 'TTT', '台東縣', 'Russian');
INSERT INTO emkt_regions VALUES(3437, 205, 'TXG', '台中市', 'Russian');
INSERT INTO emkt_regions VALUES(3438, 205, 'TXQ', '台中縣', 'Russian');
INSERT INTO emkt_regions VALUES(3439, 205, 'YUN', '雲林縣', 'Russian');

INSERT INTO emkt_countries VALUES (206,'Таджикистан','Russian','TJ','TJK','');

INSERT INTO emkt_regions VALUES(3440, 206, 'GB', 'کوهستان بدخشان', 'Russian');
INSERT INTO emkt_regions VALUES(3441, 206, 'KT', 'ختلان', 'Russian');
INSERT INTO emkt_regions VALUES(3442, 206, 'SU', 'سغد', 'Russian');

INSERT INTO emkt_countries VALUES (207,'Танзания','Russian','TZ','TZA','');

INSERT INTO emkt_regions VALUES(3443, 207, '01', 'Arusha', 'Russian');
INSERT INTO emkt_regions VALUES(3444, 207, '02', 'Dar es Salaam', 'Russian');
INSERT INTO emkt_regions VALUES(3445, 207, '03', 'Dodoma', 'Russian');
INSERT INTO emkt_regions VALUES(3446, 207, '04', 'Iringa', 'Russian');
INSERT INTO emkt_regions VALUES(3447, 207, '05', 'Kagera', 'Russian');
INSERT INTO emkt_regions VALUES(3448, 207, '06', 'Pemba Sever', 'Russian');
INSERT INTO emkt_regions VALUES(3449, 207, '07', 'Zanzibar Sever', 'Russian');
INSERT INTO emkt_regions VALUES(3450, 207, '08', 'Kigoma', 'Russian');
INSERT INTO emkt_regions VALUES(3451, 207, '09', 'Kilimanjaro', 'Russian');
INSERT INTO emkt_regions VALUES(3452, 207, '10', 'Pemba Jih', 'Russian');
INSERT INTO emkt_regions VALUES(3453, 207, '11', 'Zanzibar Jih', 'Russian');
INSERT INTO emkt_regions VALUES(3454, 207, '12', 'Lindi', 'Russian');
INSERT INTO emkt_regions VALUES(3455, 207, '13', 'Mara', 'Russian');
INSERT INTO emkt_regions VALUES(3456, 207, '14', 'Mbeya', 'Russian');
INSERT INTO emkt_regions VALUES(3457, 207, '15', 'Zanzibar Západ', 'Russian');
INSERT INTO emkt_regions VALUES(3458, 207, '16', 'Morogoro', 'Russian');
INSERT INTO emkt_regions VALUES(3459, 207, '17', 'Mtwara', 'Russian');
INSERT INTO emkt_regions VALUES(3460, 207, '18', 'Mwanza', 'Russian');
INSERT INTO emkt_regions VALUES(3461, 207, '19', 'Pwani', 'Russian');
INSERT INTO emkt_regions VALUES(3462, 207, '20', 'Rukwa', 'Russian');
INSERT INTO emkt_regions VALUES(3463, 207, '21', 'Ruvuma', 'Russian');
INSERT INTO emkt_regions VALUES(3464, 207, '22', 'Shinyanga', 'Russian');
INSERT INTO emkt_regions VALUES(3465, 207, '23', 'Singida', 'Russian');
INSERT INTO emkt_regions VALUES(3466, 207, '24', 'Tabora', 'Russian');
INSERT INTO emkt_regions VALUES(3467, 207, '25', 'Tanga', 'Russian');
INSERT INTO emkt_regions VALUES(3468, 207, '26', 'Manyara', 'Russian');

INSERT INTO emkt_countries VALUES (208,'Таиланд','Russian','TH','THA','');

INSERT INTO emkt_regions VALUES(3469, 208, 'TH-10', 'กรุงเทพมหานคร', 'Russian');
INSERT INTO emkt_regions VALUES(3470, 208, 'TH-11', 'สมุทรปราการ', 'Russian');
INSERT INTO emkt_regions VALUES(3471, 208, 'TH-12', 'นนทบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3472, 208, 'TH-13', 'ปทุมธานี', 'Russian');
INSERT INTO emkt_regions VALUES(3473, 208, 'TH-14', 'พระนครศรีอยุธยา', 'Russian');
INSERT INTO emkt_regions VALUES(3474, 208, 'TH-15', 'อ่างทอง', 'Russian');
INSERT INTO emkt_regions VALUES(3475, 208, 'TH-16', 'ลพบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3476, 208, 'TH-17', 'สิงห์บุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3477, 208, 'TH-18', 'ชัยนาท', 'Russian');
INSERT INTO emkt_regions VALUES(3478, 208, 'TH-19', 'สระบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3479, 208, 'TH-20', 'ชลบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3480, 208, 'TH-21', 'ระยอง', 'Russian');
INSERT INTO emkt_regions VALUES(3481, 208, 'TH-22', 'จันทบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3482, 208, 'TH-23', 'ตราด', 'Russian');
INSERT INTO emkt_regions VALUES(3483, 208, 'TH-24', 'ฉะเชิงเทรา', 'Russian');
INSERT INTO emkt_regions VALUES(3484, 208, 'TH-25', 'ปราจีนบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3485, 208, 'TH-26', 'นครนายก', 'Russian');
INSERT INTO emkt_regions VALUES(3486, 208, 'TH-27', 'สระแก้ว', 'Russian');
INSERT INTO emkt_regions VALUES(3487, 208, 'TH-30', 'นครราชสีมา', 'Russian');
INSERT INTO emkt_regions VALUES(3488, 208, 'TH-31', 'บุรีรัมย์', 'Russian');
INSERT INTO emkt_regions VALUES(3489, 208, 'TH-32', 'สุรินทร์', 'Russian');
INSERT INTO emkt_regions VALUES(3490, 208, 'TH-33', 'ศรีสะเกษ', 'Russian');
INSERT INTO emkt_regions VALUES(3491, 208, 'TH-34', 'อุบลราชธานี', 'Russian');
INSERT INTO emkt_regions VALUES(3492, 208, 'TH-35', 'ยโสธร', 'Russian');
INSERT INTO emkt_regions VALUES(3493, 208, 'TH-36', 'ชัยภูมิ', 'Russian');
INSERT INTO emkt_regions VALUES(3494, 208, 'TH-37', 'อำนาจเจริญ', 'Russian');
INSERT INTO emkt_regions VALUES(3495, 208, 'TH-39', 'หนองบัวลำภู', 'Russian');
INSERT INTO emkt_regions VALUES(3496, 208, 'TH-40', 'ขอนแก่น', 'Russian');
INSERT INTO emkt_regions VALUES(3497, 208, 'TH-41', 'อุดรธานี', 'Russian');
INSERT INTO emkt_regions VALUES(3498, 208, 'TH-42', 'เลย', 'Russian');
INSERT INTO emkt_regions VALUES(3499, 208, 'TH-43', 'หนองคาย', 'Russian');
INSERT INTO emkt_regions VALUES(3500, 208, 'TH-44', 'มหาสารคาม', 'Russian');
INSERT INTO emkt_regions VALUES(3501, 208, 'TH-45', 'ร้อยเอ็ด', 'Russian');
INSERT INTO emkt_regions VALUES(3502, 208, 'TH-46', 'กาฬสินธุ์', 'Russian');
INSERT INTO emkt_regions VALUES(3503, 208, 'TH-47', 'สกลนคร', 'Russian');
INSERT INTO emkt_regions VALUES(3504, 208, 'TH-48', 'นครพนม', 'Russian');
INSERT INTO emkt_regions VALUES(3505, 208, 'TH-49', 'มุกดาหาร', 'Russian');
INSERT INTO emkt_regions VALUES(3506, 208, 'TH-50', 'เชียงใหม่', 'Russian');
INSERT INTO emkt_regions VALUES(3507, 208, 'TH-51', 'ลำพูน', 'Russian');
INSERT INTO emkt_regions VALUES(3508, 208, 'TH-52', 'ลำปาง', 'Russian');
INSERT INTO emkt_regions VALUES(3509, 208, 'TH-53', 'อุตรดิตถ์', 'Russian');
INSERT INTO emkt_regions VALUES(3510, 208, 'TH-55', 'น่าน', 'Russian');
INSERT INTO emkt_regions VALUES(3511, 208, 'TH-56', 'พะเยา', 'Russian');
INSERT INTO emkt_regions VALUES(3512, 208, 'TH-57', 'เชียงราย', 'Russian');
INSERT INTO emkt_regions VALUES(3513, 208, 'TH-58', 'แม่ฮ่องสอน', 'Russian');
INSERT INTO emkt_regions VALUES(3514, 208, 'TH-60', 'นครสวรรค์', 'Russian');
INSERT INTO emkt_regions VALUES(3515, 208, 'TH-61', 'อุทัยธานี', 'Russian');
INSERT INTO emkt_regions VALUES(3516, 208, 'TH-62', 'กำแพงเพชร', 'Russian');
INSERT INTO emkt_regions VALUES(3517, 208, 'TH-63', 'ตาก', 'Russian');
INSERT INTO emkt_regions VALUES(3518, 208, 'TH-64', 'สุโขทัย', 'Russian');
INSERT INTO emkt_regions VALUES(3519, 208, 'TH-66', 'ชุมพร', 'Russian');
INSERT INTO emkt_regions VALUES(3520, 208, 'TH-67', 'พิจิตร', 'Russian');
INSERT INTO emkt_regions VALUES(3521, 208, 'TH-70', 'ราชบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3522, 208, 'TH-71', 'กาญจนบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3523, 208, 'TH-72', 'สุพรรณบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3524, 208, 'TH-73', 'นครปฐม', 'Russian');
INSERT INTO emkt_regions VALUES(3525, 208, 'TH-74', 'สมุทรสาคร', 'Russian');
INSERT INTO emkt_regions VALUES(3526, 208, 'TH-75', 'สมุทรสงคราม', 'Russian');
INSERT INTO emkt_regions VALUES(3527, 208, 'TH-76', 'เพชรบุรี', 'Russian');
INSERT INTO emkt_regions VALUES(3528, 208, 'TH-77', 'ประจวบคีรีขันธ์', 'Russian');
INSERT INTO emkt_regions VALUES(3529, 208, 'TH-80', 'นครศรีธรรมราช', 'Russian');
INSERT INTO emkt_regions VALUES(3530, 208, 'TH-81', 'กระบี่', 'Russian');
INSERT INTO emkt_regions VALUES(3531, 208, 'TH-82', 'พังงา', 'Russian');
INSERT INTO emkt_regions VALUES(3532, 208, 'TH-83', 'ภูเก็ต', 'Russian');
INSERT INTO emkt_regions VALUES(3533, 208, 'TH-84', 'สุราษฎร์ธานี', 'Russian');
INSERT INTO emkt_regions VALUES(3534, 208, 'TH-85', 'ระนอง', 'Russian');
INSERT INTO emkt_regions VALUES(3535, 208, 'TH-86', 'ชุมพร', 'Russian');
INSERT INTO emkt_regions VALUES(3536, 208, 'TH-90', 'สงขลา', 'Russian');
INSERT INTO emkt_regions VALUES(3537, 208, 'TH-91', 'สตูล', 'Russian');
INSERT INTO emkt_regions VALUES(3538, 208, 'TH-92', 'ตรัง', 'Russian');
INSERT INTO emkt_regions VALUES(3539, 208, 'TH-93', 'พัทลุง', 'Russian');
INSERT INTO emkt_regions VALUES(3540, 208, 'TH-94', 'ปัตตานี', 'Russian');
INSERT INTO emkt_regions VALUES(3541, 208, 'TH-95', 'ยะลา', 'Russian');
INSERT INTO emkt_regions VALUES(3542, 208, 'TH-96', 'นราธิวาส', 'Russian');

INSERT INTO emkt_countries VALUES (209,'Того','Russian','TG','TGO','');

INSERT INTO emkt_regions VALUES(3543, 209, 'C', 'Centrale', 'Russian');
INSERT INTO emkt_regions VALUES(3544, 209, 'K', 'Kara', 'Russian');
INSERT INTO emkt_regions VALUES(3545, 209, 'M', 'Maritime', 'Russian');
INSERT INTO emkt_regions VALUES(3546, 209, 'P', 'Plateaux', 'Russian');
INSERT INTO emkt_regions VALUES(3547, 209, 'S', 'Savanes', 'Russian');

INSERT INTO emkt_countries VALUES (210,'Токелау','Russian','TK','TKL','');

INSERT INTO emkt_regions VALUES(3548, 210, 'A', 'Atafu', 'Russian');
INSERT INTO emkt_regions VALUES(3549, 210, 'F', 'Fakaofo', 'Russian');
INSERT INTO emkt_regions VALUES(3550, 210, 'N', 'Nukunonu', 'Russian');

INSERT INTO emkt_countries VALUES (211,'Тонга','Russian','TO','TON','');

INSERT INTO emkt_regions VALUES(3551, 211, 'H', 'Ha\'apai', 'Russian');
INSERT INTO emkt_regions VALUES(3552, 211, 'T', 'Tongatapu', 'Russian');
INSERT INTO emkt_regions VALUES(3553, 211, 'V', 'Vava\'u', 'Russian');

INSERT INTO emkt_countries VALUES (212,'Тринидад и Тобаго','Russian','TT','TTO','');

INSERT INTO emkt_regions VALUES(3554, 212, 'ARI', 'Arima', 'Russian');
INSERT INTO emkt_regions VALUES(3555, 212, 'CHA', 'Chaguanas', 'Russian');
INSERT INTO emkt_regions VALUES(3556, 212, 'CTT', 'Couva-Tabaquite-Talparo', 'Russian');
INSERT INTO emkt_regions VALUES(3557, 212, 'DMN', 'Diego Martin', 'Russian');
INSERT INTO emkt_regions VALUES(3558, 212, 'ETO', 'Eastern Tobago', 'Russian');
INSERT INTO emkt_regions VALUES(3559, 212, 'RCM', 'Rio Claro-Mayaro', 'Russian');
INSERT INTO emkt_regions VALUES(3560, 212, 'PED', 'Penal-Debe', 'Russian');
INSERT INTO emkt_regions VALUES(3561, 212, 'PTF', 'Point Fortin', 'Russian');
INSERT INTO emkt_regions VALUES(3562, 212, 'POS', 'Port of Spain', 'Russian');
INSERT INTO emkt_regions VALUES(3563, 212, 'PRT', 'Princes Town', 'Russian');
INSERT INTO emkt_regions VALUES(3564, 212, 'SFO', 'San Fernando', 'Russian');
INSERT INTO emkt_regions VALUES(3565, 212, 'SGE', 'Sangre Grande', 'Russian');
INSERT INTO emkt_regions VALUES(3566, 212, 'SJL', 'San Juan-Laventille', 'Russian');
INSERT INTO emkt_regions VALUES(3567, 212, 'SIP', 'Siparia', 'Russian');
INSERT INTO emkt_regions VALUES(3568, 212, 'TUP', 'Tunapuna-Piarco', 'Russian');
INSERT INTO emkt_regions VALUES(3569, 212, 'WTO', 'Western Tobago', 'Russian');

INSERT INTO emkt_countries VALUES (213,'Тунис','Russian','TN','TUN','');

INSERT INTO emkt_regions VALUES(3570, 213, '11', 'ولاية تونس', 'Russian');
INSERT INTO emkt_regions VALUES(3571, 213, '12', 'ولاية أريانة', 'Russian');
INSERT INTO emkt_regions VALUES(3572, 213, '13', 'ولاية بن عروس', 'Russian');
INSERT INTO emkt_regions VALUES(3573, 213, '14', 'ولاية منوبة', 'Russian');
INSERT INTO emkt_regions VALUES(3574, 213, '21', 'ولاية نابل', 'Russian');
INSERT INTO emkt_regions VALUES(3575, 213, '22', 'ولاية زغوان', 'Russian');
INSERT INTO emkt_regions VALUES(3576, 213, '23', 'ولاية بنزرت', 'Russian');
INSERT INTO emkt_regions VALUES(3577, 213, '31', 'ولاية باجة', 'Russian');
INSERT INTO emkt_regions VALUES(3578, 213, '32', 'ولاية جندوبة', 'Russian');
INSERT INTO emkt_regions VALUES(3579, 213, '33', 'ولاية الكاف', 'Russian');
INSERT INTO emkt_regions VALUES(3580, 213, '34', 'ولاية سليانة', 'Russian');
INSERT INTO emkt_regions VALUES(3581, 213, '41', 'ولاية القيروان', 'Russian');
INSERT INTO emkt_regions VALUES(3582, 213, '42', 'ولاية القصرين', 'Russian');
INSERT INTO emkt_regions VALUES(3583, 213, '43', 'ولاية سيدي بوزيد', 'Russian');
INSERT INTO emkt_regions VALUES(3584, 213, '51', 'ولاية سوسة', 'Russian');
INSERT INTO emkt_regions VALUES(3585, 213, '52', 'ولاية المنستير', 'Russian');
INSERT INTO emkt_regions VALUES(3586, 213, '53', 'ولاية المهدية', 'Russian');
INSERT INTO emkt_regions VALUES(3587, 213, '61', 'ولاية صفاقس', 'Russian');
INSERT INTO emkt_regions VALUES(3588, 213, '71', 'ولاية قفصة', 'Russian');
INSERT INTO emkt_regions VALUES(3589, 213, '72', 'ولاية توزر', 'Russian');
INSERT INTO emkt_regions VALUES(3590, 213, '73', 'ولاية قبلي', 'Russian');
INSERT INTO emkt_regions VALUES(3591, 213, '81', 'ولاية قابس', 'Russian');
INSERT INTO emkt_regions VALUES(3592, 213, '82', 'ولاية مدنين', 'Russian');
INSERT INTO emkt_regions VALUES(3593, 213, '83', 'ولاية تطاوين', 'Russian');

INSERT INTO emkt_countries VALUES (214,'Турция','Russian','TR','TUR','');

INSERT INTO emkt_regions VALUES(3594, 214, '01', 'Adana', 'Russian');
INSERT INTO emkt_regions VALUES(3595, 214, '02', 'Adıyaman', 'Russian');
INSERT INTO emkt_regions VALUES(3596, 214, '03', 'Afyonkarahisar', 'Russian');
INSERT INTO emkt_regions VALUES(3597, 214, '04', 'Ağrı', 'Russian');
INSERT INTO emkt_regions VALUES(3598, 214, '05', 'Amasya', 'Russian');
INSERT INTO emkt_regions VALUES(3599, 214, '06', 'Ankara', 'Russian');
INSERT INTO emkt_regions VALUES(3600, 214, '07', 'Antalya', 'Russian');
INSERT INTO emkt_regions VALUES(3601, 214, '08', 'Artvin', 'Russian');
INSERT INTO emkt_regions VALUES(3602, 214, '09', 'Aydın', 'Russian');
INSERT INTO emkt_regions VALUES(3603, 214, '10', 'Balıkesir', 'Russian');
INSERT INTO emkt_regions VALUES(3604, 214, '11', 'Bilecik', 'Russian');
INSERT INTO emkt_regions VALUES(3605, 214, '12', 'Bingöl', 'Russian');
INSERT INTO emkt_regions VALUES(3606, 214, '13', 'Bitlis', 'Russian');
INSERT INTO emkt_regions VALUES(3607, 214, '14', 'Bolu', 'Russian');
INSERT INTO emkt_regions VALUES(3608, 214, '15', 'Burdur', 'Russian');
INSERT INTO emkt_regions VALUES(3609, 214, '16', 'Bursa', 'Russian');
INSERT INTO emkt_regions VALUES(3610, 214, '17', 'Çanakkale', 'Russian');
INSERT INTO emkt_regions VALUES(3611, 214, '18', 'Çankırı', 'Russian');
INSERT INTO emkt_regions VALUES(3612, 214, '19', 'Çorum', 'Russian');
INSERT INTO emkt_regions VALUES(3613, 214, '20', 'Denizli', 'Russian');
INSERT INTO emkt_regions VALUES(3614, 214, '21', 'Diyarbakır', 'Russian');
INSERT INTO emkt_regions VALUES(3615, 214, '22', 'Edirne', 'Russian');
INSERT INTO emkt_regions VALUES(3616, 214, '23', 'Elazığ', 'Russian');
INSERT INTO emkt_regions VALUES(3617, 214, '24', 'Erzincan', 'Russian');
INSERT INTO emkt_regions VALUES(3618, 214, '25', 'Erzurum', 'Russian');
INSERT INTO emkt_regions VALUES(3619, 214, '26', 'Eskişehir', 'Russian');
INSERT INTO emkt_regions VALUES(3620, 214, '27', 'Gaziantep', 'Russian');
INSERT INTO emkt_regions VALUES(3621, 214, '28', 'Giresun', 'Russian');
INSERT INTO emkt_regions VALUES(3622, 214, '29', 'Gümüşhane', 'Russian');
INSERT INTO emkt_regions VALUES(3623, 214, '30', 'Hakkari', 'Russian');
INSERT INTO emkt_regions VALUES(3624, 214, '31', 'Hatay', 'Russian');
INSERT INTO emkt_regions VALUES(3625, 214, '32', 'Isparta', 'Russian');
INSERT INTO emkt_regions VALUES(3626, 214, '33', 'Mersin', 'Russian');
INSERT INTO emkt_regions VALUES(3627, 214, '34', 'İstanbul', 'Russian');
INSERT INTO emkt_regions VALUES(3628, 214, '35', 'İzmir', 'Russian');
INSERT INTO emkt_regions VALUES(3629, 214, '36', 'Kars', 'Russian');
INSERT INTO emkt_regions VALUES(3630, 214, '37', 'Kastamonu', 'Russian');
INSERT INTO emkt_regions VALUES(3631, 214, '38', 'Kayseri', 'Russian');
INSERT INTO emkt_regions VALUES(3632, 214, '39', 'Kırklareli', 'Russian');
INSERT INTO emkt_regions VALUES(3633, 214, '40', 'Kırşehir', 'Russian');
INSERT INTO emkt_regions VALUES(3634, 214, '41', 'Kocaeli', 'Russian');
INSERT INTO emkt_regions VALUES(3635, 214, '42', 'Konya', 'Russian');
INSERT INTO emkt_regions VALUES(3636, 214, '43', 'Kütahya', 'Russian');
INSERT INTO emkt_regions VALUES(3637, 214, '44', 'Malatya', 'Russian');
INSERT INTO emkt_regions VALUES(3638, 214, '45', 'Manisa', 'Russian');
INSERT INTO emkt_regions VALUES(3639, 214, '46', 'Kahramanmaraş', 'Russian');
INSERT INTO emkt_regions VALUES(3640, 214, '47', 'Mardin', 'Russian');
INSERT INTO emkt_regions VALUES(3641, 214, '48', 'Muğla', 'Russian');
INSERT INTO emkt_regions VALUES(3642, 214, '49', 'Muş', 'Russian');
INSERT INTO emkt_regions VALUES(3643, 214, '50', 'Nevşehir', 'Russian');
INSERT INTO emkt_regions VALUES(3644, 214, '51', 'Niğde', 'Russian');
INSERT INTO emkt_regions VALUES(3645, 214, '52', 'Ordu', 'Russian');
INSERT INTO emkt_regions VALUES(3646, 214, '53', 'Rize', 'Russian');
INSERT INTO emkt_regions VALUES(3647, 214, '54', 'Sakarya', 'Russian');
INSERT INTO emkt_regions VALUES(3648, 214, '55', 'Samsun', 'Russian');
INSERT INTO emkt_regions VALUES(3649, 214, '56', 'Siirt', 'Russian');
INSERT INTO emkt_regions VALUES(3650, 214, '57', 'Sinop', 'Russian');
INSERT INTO emkt_regions VALUES(3651, 214, '58', 'Sivas', 'Russian');
INSERT INTO emkt_regions VALUES(3652, 214, '59', 'Tekirdağ', 'Russian');
INSERT INTO emkt_regions VALUES(3653, 214, '60', 'Tokat', 'Russian');
INSERT INTO emkt_regions VALUES(3654, 214, '61', 'Trabzon', 'Russian');
INSERT INTO emkt_regions VALUES(3655, 214, '62', 'Tunceli', 'Russian');
INSERT INTO emkt_regions VALUES(3656, 214, '63', 'Şanlıurfa', 'Russian');
INSERT INTO emkt_regions VALUES(3657, 214, '64', 'Uşak', 'Russian');
INSERT INTO emkt_regions VALUES(3658, 214, '65', 'Van', 'Russian');
INSERT INTO emkt_regions VALUES(3659, 214, '66', 'Yozgat', 'Russian');
INSERT INTO emkt_regions VALUES(3660, 214, '67', 'Zonguldak', 'Russian');
INSERT INTO emkt_regions VALUES(3661, 214, '68', 'Aksaray', 'Russian');
INSERT INTO emkt_regions VALUES(3662, 214, '69', 'Bayburt', 'Russian');
INSERT INTO emkt_regions VALUES(3663, 214, '70', 'Karaman', 'Russian');
INSERT INTO emkt_regions VALUES(3664, 214, '71', 'Kırıkkale', 'Russian');
INSERT INTO emkt_regions VALUES(3665, 214, '72', 'Batman', 'Russian');
INSERT INTO emkt_regions VALUES(3666, 214, '73', 'Şırnak', 'Russian');
INSERT INTO emkt_regions VALUES(3667, 214, '74', 'Bartın', 'Russian');
INSERT INTO emkt_regions VALUES(3668, 214, '75', 'Ardahan', 'Russian');
INSERT INTO emkt_regions VALUES(3669, 214, '76', 'Iğdır', 'Russian');
INSERT INTO emkt_regions VALUES(3670, 214, '77', 'Yalova', 'Russian');
INSERT INTO emkt_regions VALUES(3671, 214, '78', 'Karabük', 'Russian');
INSERT INTO emkt_regions VALUES(3672, 214, '79', 'Kilis', 'Russian');
INSERT INTO emkt_regions VALUES(3673, 214, '80', 'Osmaniye', 'Russian');
INSERT INTO emkt_regions VALUES(3674, 214, '81', 'Düzce', 'Russian');

INSERT INTO emkt_countries VALUES (215,'Туркменистан','Russian','TM','TKM','');

INSERT INTO emkt_regions VALUES(3675, 215, 'A', 'Ahal welaýaty', 'Russian');
INSERT INTO emkt_regions VALUES(3676, 215, 'B', 'Balkan welaýaty', 'Russian');
INSERT INTO emkt_regions VALUES(3677, 215, 'D', 'Daşoguz welaýaty', 'Russian');
INSERT INTO emkt_regions VALUES(3678, 215, 'L', 'Lebap welaýaty', 'Russian');
INSERT INTO emkt_regions VALUES(3679, 215, 'M', 'Mary welaýaty', 'Russian');

INSERT INTO emkt_countries VALUES (216,'Теркс и Кайкос','Russian','TC','TCA','');

INSERT INTO emkt_regions VALUES(3680, 216, 'AC', 'Ambergris Cays', 'Russian');
INSERT INTO emkt_regions VALUES(3681, 216, 'DC', 'Dellis Cay', 'Russian');
INSERT INTO emkt_regions VALUES(3682, 216, 'FC', 'French Cay', 'Russian');
INSERT INTO emkt_regions VALUES(3683, 216, 'LW', 'Little Water Cay', 'Russian');
INSERT INTO emkt_regions VALUES(3684, 216, 'RC', 'Parrot Cay', 'Russian');
INSERT INTO emkt_regions VALUES(3685, 216, 'PN', 'Pine Cay', 'Russian');
INSERT INTO emkt_regions VALUES(3686, 216, 'SL', 'Salt Cay', 'Russian');
INSERT INTO emkt_regions VALUES(3687, 216, 'GT', 'Grand Turk', 'Russian');
INSERT INTO emkt_regions VALUES(3688, 216, 'SC', 'South Caicos', 'Russian');
INSERT INTO emkt_regions VALUES(3689, 216, 'EC', 'East Caicos', 'Russian');
INSERT INTO emkt_regions VALUES(3690, 216, 'MC', 'Middle Caicos', 'Russian');
INSERT INTO emkt_regions VALUES(3691, 216, 'NC', 'North Caicos', 'Russian');
INSERT INTO emkt_regions VALUES(3692, 216, 'PR', 'Providenciales', 'Russian');
INSERT INTO emkt_regions VALUES(3693, 216, 'WC', 'West Caicos', 'Russian');

INSERT INTO emkt_countries VALUES (217,'Тувалу','Russian','TV','TUV','');

INSERT INTO emkt_regions VALUES(3694, 217, 'FUN', 'Funafuti', 'Russian');
INSERT INTO emkt_regions VALUES(3695, 217, 'NMA', 'Nanumea', 'Russian');
INSERT INTO emkt_regions VALUES(3696, 217, 'NMG', 'Nanumanga', 'Russian');
INSERT INTO emkt_regions VALUES(3697, 217, 'NIT', 'Niutao', 'Russian');
INSERT INTO emkt_regions VALUES(3698, 217, 'NIU', 'Nui', 'Russian');
INSERT INTO emkt_regions VALUES(3699, 217, 'NKF', 'Nukufetau', 'Russian');
INSERT INTO emkt_regions VALUES(3700, 217, 'NKL', 'Nukulaelae', 'Russian');
INSERT INTO emkt_regions VALUES(3701, 217, 'VAI', 'Vaitupu', 'Russian');

INSERT INTO emkt_countries VALUES (218,'Уганда','Russian','UG','UGA','');

INSERT INTO emkt_regions VALUES(3702, 218, '101', 'Kalangala', 'Russian');
INSERT INTO emkt_regions VALUES(3703, 218, '102', 'Kampala', 'Russian');
INSERT INTO emkt_regions VALUES(3704, 218, '103', 'Kiboga', 'Russian');
INSERT INTO emkt_regions VALUES(3705, 218, '104', 'Luwero', 'Russian');
INSERT INTO emkt_regions VALUES(3706, 218, '105', 'Masaka', 'Russian');
INSERT INTO emkt_regions VALUES(3707, 218, '106', 'Mpigi', 'Russian');
INSERT INTO emkt_regions VALUES(3708, 218, '107', 'Mubende', 'Russian');
INSERT INTO emkt_regions VALUES(3709, 218, '108', 'Mukono', 'Russian');
INSERT INTO emkt_regions VALUES(3710, 218, '109', 'Nakasongola', 'Russian');
INSERT INTO emkt_regions VALUES(3711, 218, '110', 'Rakai', 'Russian');
INSERT INTO emkt_regions VALUES(3712, 218, '111', 'Sembabule', 'Russian');
INSERT INTO emkt_regions VALUES(3713, 218, '112', 'Kayunga', 'Russian');
INSERT INTO emkt_regions VALUES(3714, 218, '113', 'Wakiso', 'Russian');
INSERT INTO emkt_regions VALUES(3715, 218, '201', 'Bugiri', 'Russian');
INSERT INTO emkt_regions VALUES(3716, 218, '202', 'Busia', 'Russian');
INSERT INTO emkt_regions VALUES(3717, 218, '203', 'Iganga', 'Russian');
INSERT INTO emkt_regions VALUES(3718, 218, '204', 'Jinja', 'Russian');
INSERT INTO emkt_regions VALUES(3719, 218, '205', 'Kamuli', 'Russian');
INSERT INTO emkt_regions VALUES(3720, 218, '206', 'Kapchorwa', 'Russian');
INSERT INTO emkt_regions VALUES(3721, 218, '207', 'Katakwi', 'Russian');
INSERT INTO emkt_regions VALUES(3722, 218, '208', 'Kumi', 'Russian');
INSERT INTO emkt_regions VALUES(3723, 218, '209', 'Mbale', 'Russian');
INSERT INTO emkt_regions VALUES(3724, 218, '210', 'Pallisa', 'Russian');
INSERT INTO emkt_regions VALUES(3725, 218, '211', 'Soroti', 'Russian');
INSERT INTO emkt_regions VALUES(3726, 218, '212', 'Tororo', 'Russian');
INSERT INTO emkt_regions VALUES(3727, 218, '213', 'Kaberamaido', 'Russian');
INSERT INTO emkt_regions VALUES(3728, 218, '214', 'Mayuge', 'Russian');
INSERT INTO emkt_regions VALUES(3729, 218, '215', 'Sironko', 'Russian');
INSERT INTO emkt_regions VALUES(3730, 218, '301', 'Adjumani', 'Russian');
INSERT INTO emkt_regions VALUES(3731, 218, '302', 'Apac', 'Russian');
INSERT INTO emkt_regions VALUES(3732, 218, '303', 'Arua', 'Russian');
INSERT INTO emkt_regions VALUES(3733, 218, '304', 'Gulu', 'Russian');
INSERT INTO emkt_regions VALUES(3734, 218, '305', 'Kitgum', 'Russian');
INSERT INTO emkt_regions VALUES(3735, 218, '306', 'Kotido', 'Russian');
INSERT INTO emkt_regions VALUES(3736, 218, '307', 'Lira', 'Russian');
INSERT INTO emkt_regions VALUES(3737, 218, '308', 'Moroto', 'Russian');
INSERT INTO emkt_regions VALUES(3738, 218, '309', 'Moyo', 'Russian');
INSERT INTO emkt_regions VALUES(3739, 218, '310', 'Nebbi', 'Russian');
INSERT INTO emkt_regions VALUES(3740, 218, '311', 'Nakapiripirit', 'Russian');
INSERT INTO emkt_regions VALUES(3741, 218, '312', 'Pader', 'Russian');
INSERT INTO emkt_regions VALUES(3742, 218, '313', 'Yumbe', 'Russian');
INSERT INTO emkt_regions VALUES(3743, 218, '401', 'Bundibugyo', 'Russian');
INSERT INTO emkt_regions VALUES(3744, 218, '402', 'Bushenyi', 'Russian');
INSERT INTO emkt_regions VALUES(3745, 218, '403', 'Hoima', 'Russian');
INSERT INTO emkt_regions VALUES(3746, 218, '404', 'Kabale', 'Russian');
INSERT INTO emkt_regions VALUES(3747, 218, '405', 'Kabarole', 'Russian');
INSERT INTO emkt_regions VALUES(3748, 218, '406', 'Kasese', 'Russian');
INSERT INTO emkt_regions VALUES(3749, 218, '407', 'Kibale', 'Russian');
INSERT INTO emkt_regions VALUES(3750, 218, '408', 'Kisoro', 'Russian');
INSERT INTO emkt_regions VALUES(3751, 218, '409', 'Masindi', 'Russian');
INSERT INTO emkt_regions VALUES(3752, 218, '410', 'Mbarara', 'Russian');
INSERT INTO emkt_regions VALUES(3753, 218, '411', 'Ntungamo', 'Russian');
INSERT INTO emkt_regions VALUES(3754, 218, '412', 'Rukungiri', 'Russian');
INSERT INTO emkt_regions VALUES(3755, 218, '413', 'Kamwenge', 'Russian');
INSERT INTO emkt_regions VALUES(3756, 218, '414', 'Kanungu', 'Russian');
INSERT INTO emkt_regions VALUES(3757, 218, '415', 'Kyenjojo', 'Russian');

INSERT INTO emkt_countries VALUES (219,'Украина','Russian','UA','UKR','');

INSERT INTO emkt_regions VALUES(3758, 219, '05', 'Вінницька область', 'Russian');
INSERT INTO emkt_regions VALUES(3759, 219, '07', 'Волинська область', 'Russian');
INSERT INTO emkt_regions VALUES(3760, 219, '09', 'Луганська область', 'Russian');
INSERT INTO emkt_regions VALUES(3761, 219, '12', 'Дніпропетровська область', 'Russian');
INSERT INTO emkt_regions VALUES(3762, 219, '14', 'Донецька область', 'Russian');
INSERT INTO emkt_regions VALUES(3763, 219, '18', 'Житомирська область', 'Russian');
INSERT INTO emkt_regions VALUES(3764, 219, '19', 'Рівненська область', 'Russian');
INSERT INTO emkt_regions VALUES(3765, 219, '21', 'Закарпатська область', 'Russian');
INSERT INTO emkt_regions VALUES(3766, 219, '23', 'Запорізька область', 'Russian');
INSERT INTO emkt_regions VALUES(3767, 219, '26', 'Івано-Франківська область', 'Russian');
INSERT INTO emkt_regions VALUES(3768, 219, '30', 'Київ', 'Russian');
INSERT INTO emkt_regions VALUES(3769, 219, '32', 'Київська область', 'Russian');
INSERT INTO emkt_regions VALUES(3770, 219, '35', 'Кіровоградська область', 'Russian');
INSERT INTO emkt_regions VALUES(3771, 219, '46', 'Львівська область', 'Russian');
INSERT INTO emkt_regions VALUES(3772, 219, '48', 'Миколаївська область', 'Russian');
INSERT INTO emkt_regions VALUES(3773, 219, '51', 'Одеська область', 'Russian');
INSERT INTO emkt_regions VALUES(3774, 219, '53', 'Полтавська область', 'Russian');
INSERT INTO emkt_regions VALUES(3775, 219, '59', 'Сумська область', 'Russian');
INSERT INTO emkt_regions VALUES(3776, 219, '61', 'Тернопільська область', 'Russian');
INSERT INTO emkt_regions VALUES(3777, 219, '63', 'Харківська область', 'Russian');
INSERT INTO emkt_regions VALUES(3778, 219, '65', 'Херсонська область', 'Russian');
INSERT INTO emkt_regions VALUES(3779, 219, '68', 'Хмельницька область', 'Russian');
INSERT INTO emkt_regions VALUES(3780, 219, '71', 'Черкаська область', 'Russian');
INSERT INTO emkt_regions VALUES(3781, 219, '74', 'Чернігівська область', 'Russian');
INSERT INTO emkt_regions VALUES(3782, 219, '77', 'Чернівецька область', 'Russian');

INSERT INTO emkt_countries VALUES (220,'Объединённые Арабские Эмираты','Russian','AE','ARE','');

INSERT INTO emkt_regions VALUES(4278, 220, 'NOCODE', 'United Arab Emirates', 'Russian');

INSERT INTO emkt_countries VALUES (221,'Великобритания','Russian','GB','GBR','');

INSERT INTO emkt_regions VALUES(3783, 221, 'ABD', 'Aberdeenshire', 'Russian');
INSERT INTO emkt_regions VALUES(3784, 221, 'ABE', 'Aberdeen', 'Russian');
INSERT INTO emkt_regions VALUES(3785, 221, 'AGB', 'Argyll and Bute', 'Russian');
INSERT INTO emkt_regions VALUES(3786, 221, 'AGY', 'Isle of Anglesey', 'Russian');
INSERT INTO emkt_regions VALUES(3787, 221, 'ANS', 'Angus', 'Russian');
INSERT INTO emkt_regions VALUES(3788, 221, 'ANT', 'Antrim', 'Russian');
INSERT INTO emkt_regions VALUES(3789, 221, 'ARD', 'Ards', 'Russian');
INSERT INTO emkt_regions VALUES(3790, 221, 'ARM', 'Armagh', 'Russian');
INSERT INTO emkt_regions VALUES(3791, 221, 'BAS', 'Bath and North East Somerset', 'Russian');
INSERT INTO emkt_regions VALUES(3792, 221, 'BBD', 'Blackburn with Darwen', 'Russian');
INSERT INTO emkt_regions VALUES(3793, 221, 'BDF', 'Bedfordshire', 'Russian');
INSERT INTO emkt_regions VALUES(3794, 221, 'BDG', 'Barking and Dagenham', 'Russian');
INSERT INTO emkt_regions VALUES(3795, 221, 'BEN', 'Brent', 'Russian');
INSERT INTO emkt_regions VALUES(3796, 221, 'BEX', 'Bexley', 'Russian');
INSERT INTO emkt_regions VALUES(3797, 221, 'BFS', 'Belfast', 'Russian');
INSERT INTO emkt_regions VALUES(3798, 221, 'BGE', 'Bridgend', 'Russian');
INSERT INTO emkt_regions VALUES(3799, 221, 'BGW', 'Blaenau Gwent', 'Russian');
INSERT INTO emkt_regions VALUES(3800, 221, 'BIR', 'Birmingham', 'Russian');
INSERT INTO emkt_regions VALUES(3801, 221, 'BKM', 'Buckinghamshire', 'Russian');
INSERT INTO emkt_regions VALUES(3802, 221, 'BLA', 'Ballymena', 'Russian');
INSERT INTO emkt_regions VALUES(3803, 221, 'BLY', 'Ballymoney', 'Russian');
INSERT INTO emkt_regions VALUES(3804, 221, 'BMH', 'Bournemouth', 'Russian');
INSERT INTO emkt_regions VALUES(3805, 221, 'BNB', 'Banbridge', 'Russian');
INSERT INTO emkt_regions VALUES(3806, 221, 'BNE', 'Barnet', 'Russian');
INSERT INTO emkt_regions VALUES(3807, 221, 'BNH', 'Brighton and Hove', 'Russian');
INSERT INTO emkt_regions VALUES(3808, 221, 'BNS', 'Barnsley', 'Russian');
INSERT INTO emkt_regions VALUES(3809, 221, 'BOL', 'Bolton', 'Russian');
INSERT INTO emkt_regions VALUES(3810, 221, 'BPL', 'Blackpool', 'Russian');
INSERT INTO emkt_regions VALUES(3811, 221, 'BRC', 'Bracknell', 'Russian');
INSERT INTO emkt_regions VALUES(3812, 221, 'BRD', 'Bradford', 'Russian');
INSERT INTO emkt_regions VALUES(3813, 221, 'BRY', 'Bromley', 'Russian');
INSERT INTO emkt_regions VALUES(3814, 221, 'BST', 'Bristol', 'Russian');
INSERT INTO emkt_regions VALUES(3815, 221, 'BUR', 'Bury', 'Russian');
INSERT INTO emkt_regions VALUES(3816, 221, 'CAM', 'Cambridgeshire', 'Russian');
INSERT INTO emkt_regions VALUES(3817, 221, 'CAY', 'Caerphilly', 'Russian');
INSERT INTO emkt_regions VALUES(3818, 221, 'CGN', 'Ceredigion', 'Russian');
INSERT INTO emkt_regions VALUES(3819, 221, 'CGV', 'Craigavon', 'Russian');
INSERT INTO emkt_regions VALUES(3820, 221, 'CHS', 'Cheshire', 'Russian');
INSERT INTO emkt_regions VALUES(3821, 221, 'CKF', 'Carrickfergus', 'Russian');
INSERT INTO emkt_regions VALUES(3822, 221, 'CKT', 'Cookstown', 'Russian');
INSERT INTO emkt_regions VALUES(3823, 221, 'CLD', 'Calderdale', 'Russian');
INSERT INTO emkt_regions VALUES(3824, 221, 'CLK', 'Clackmannanshire', 'Russian');
INSERT INTO emkt_regions VALUES(3825, 221, 'CLR', 'Coleraine', 'Russian');
INSERT INTO emkt_regions VALUES(3826, 221, 'CMA', 'Cumbria', 'Russian');
INSERT INTO emkt_regions VALUES(3827, 221, 'CMD', 'Camden', 'Russian');
INSERT INTO emkt_regions VALUES(3828, 221, 'CMN', 'Carmarthenshire', 'Russian');
INSERT INTO emkt_regions VALUES(3829, 221, 'CON', 'Cornwall', 'Russian');
INSERT INTO emkt_regions VALUES(3830, 221, 'COV', 'Coventry', 'Russian');
INSERT INTO emkt_regions VALUES(3831, 221, 'CRF', 'Cardiff', 'Russian');
INSERT INTO emkt_regions VALUES(3832, 221, 'CRY', 'Croydon', 'Russian');
INSERT INTO emkt_regions VALUES(3833, 221, 'CSR', 'Castlereagh', 'Russian');
INSERT INTO emkt_regions VALUES(3834, 221, 'CWY', 'Conwy', 'Russian');
INSERT INTO emkt_regions VALUES(3835, 221, 'DAL', 'Darlington', 'Russian');
INSERT INTO emkt_regions VALUES(3836, 221, 'DBY', 'Derbyshire', 'Russian');
INSERT INTO emkt_regions VALUES(3837, 221, 'DEN', 'Denbighshire', 'Russian');
INSERT INTO emkt_regions VALUES(3838, 221, 'DER', 'Derby', 'Russian');
INSERT INTO emkt_regions VALUES(3839, 221, 'DEV', 'Devon', 'Russian');
INSERT INTO emkt_regions VALUES(3840, 221, 'DGN', 'Dungannon and South Tyrone', 'Russian');
INSERT INTO emkt_regions VALUES(3841, 221, 'DGY', 'Dumfries and Galloway', 'Russian');
INSERT INTO emkt_regions VALUES(3842, 221, 'DNC', 'Doncaster', 'Russian');
INSERT INTO emkt_regions VALUES(3843, 221, 'DND', 'Dundee', 'Russian');
INSERT INTO emkt_regions VALUES(3844, 221, 'DOR', 'Dorset', 'Russian');
INSERT INTO emkt_regions VALUES(3845, 221, 'DOW', 'Down', 'Russian');
INSERT INTO emkt_regions VALUES(3846, 221, 'DRY', 'Derry', 'Russian');
INSERT INTO emkt_regions VALUES(3847, 221, 'DUD', 'Dudley', 'Russian');
INSERT INTO emkt_regions VALUES(3848, 221, 'DUR', 'Durham', 'Russian');
INSERT INTO emkt_regions VALUES(3849, 221, 'EAL', 'Ealing', 'Russian');
INSERT INTO emkt_regions VALUES(3850, 221, 'EAY', 'East Ayrshire', 'Russian');
INSERT INTO emkt_regions VALUES(3851, 221, 'EDH', 'Edinburgh', 'Russian');
INSERT INTO emkt_regions VALUES(3852, 221, 'EDU', 'East Dunbartonshire', 'Russian');
INSERT INTO emkt_regions VALUES(3853, 221, 'ELN', 'East Lothian', 'Russian');
INSERT INTO emkt_regions VALUES(3854, 221, 'ELS', 'Eilean Siar', 'Russian');
INSERT INTO emkt_regions VALUES(3855, 221, 'ENF', 'Enfield', 'Russian');
INSERT INTO emkt_regions VALUES(3856, 221, 'ERW', 'East Renfrewshire', 'Russian');
INSERT INTO emkt_regions VALUES(3857, 221, 'ERY', 'East Riding of Yorkshire', 'Russian');
INSERT INTO emkt_regions VALUES(3858, 221, 'ESS', 'Essex', 'Russian');
INSERT INTO emkt_regions VALUES(3859, 221, 'ESX', 'East Sussex', 'Russian');
INSERT INTO emkt_regions VALUES(3860, 221, 'FAL', 'Falkirk', 'Russian');
INSERT INTO emkt_regions VALUES(3861, 221, 'FER', 'Fermanagh', 'Russian');
INSERT INTO emkt_regions VALUES(3862, 221, 'FIF', 'Fife', 'Russian');
INSERT INTO emkt_regions VALUES(3863, 221, 'FLN', 'Flintshire', 'Russian');
INSERT INTO emkt_regions VALUES(3864, 221, 'GAT', 'Gateshead', 'Russian');
INSERT INTO emkt_regions VALUES(3865, 221, 'GLG', 'Glasgow', 'Russian');
INSERT INTO emkt_regions VALUES(3866, 221, 'GLS', 'Gloucestershire', 'Russian');
INSERT INTO emkt_regions VALUES(3867, 221, 'GRE', 'Greenwich', 'Russian');
INSERT INTO emkt_regions VALUES(3868, 221, 'GSY', 'Guernsey', 'Russian');
INSERT INTO emkt_regions VALUES(3869, 221, 'GWN', 'Gwynedd', 'Russian');
INSERT INTO emkt_regions VALUES(3870, 221, 'HAL', 'Halton', 'Russian');
INSERT INTO emkt_regions VALUES(3871, 221, 'HAM', 'Hampshire', 'Russian');
INSERT INTO emkt_regions VALUES(3872, 221, 'HAV', 'Havering', 'Russian');
INSERT INTO emkt_regions VALUES(3873, 221, 'HCK', 'Hackney', 'Russian');
INSERT INTO emkt_regions VALUES(3874, 221, 'HEF', 'Herefordshire', 'Russian');
INSERT INTO emkt_regions VALUES(3875, 221, 'HIL', 'Hillingdon', 'Russian');
INSERT INTO emkt_regions VALUES(3876, 221, 'HLD', 'Highland', 'Russian');
INSERT INTO emkt_regions VALUES(3877, 221, 'HMF', 'Hammersmith and Fulham', 'Russian');
INSERT INTO emkt_regions VALUES(3878, 221, 'HNS', 'Hounslow', 'Russian');
INSERT INTO emkt_regions VALUES(3879, 221, 'HPL', 'Hartlepool', 'Russian');
INSERT INTO emkt_regions VALUES(3880, 221, 'HRT', 'Hertfordshire', 'Russian');
INSERT INTO emkt_regions VALUES(3881, 221, 'HRW', 'Harrow', 'Russian');
INSERT INTO emkt_regions VALUES(3882, 221, 'HRY', 'Haringey', 'Russian');
INSERT INTO emkt_regions VALUES(3883, 221, 'IOS', 'Isles of Scilly', 'Russian');
INSERT INTO emkt_regions VALUES(3884, 221, 'IOW', 'Isle of Wight', 'Russian');
INSERT INTO emkt_regions VALUES(3885, 221, 'ISL', 'Islington', 'Russian');
INSERT INTO emkt_regions VALUES(3886, 221, 'IVC', 'Inverclyde', 'Russian');
INSERT INTO emkt_regions VALUES(3887, 221, 'JSY', 'Jersey', 'Russian');
INSERT INTO emkt_regions VALUES(3888, 221, 'KEC', 'Kensington and Chelsea', 'Russian');
INSERT INTO emkt_regions VALUES(3889, 221, 'KEN', 'Kent', 'Russian');
INSERT INTO emkt_regions VALUES(3890, 221, 'KHL', 'Kingston upon Hull', 'Russian');
INSERT INTO emkt_regions VALUES(3891, 221, 'KIR', 'Kirklees', 'Russian');
INSERT INTO emkt_regions VALUES(3892, 221, 'KTT', 'Kingston upon Thames', 'Russian');
INSERT INTO emkt_regions VALUES(3893, 221, 'KWL', 'Knowsley', 'Russian');
INSERT INTO emkt_regions VALUES(3894, 221, 'LAN', 'Lancashire', 'Russian');
INSERT INTO emkt_regions VALUES(3895, 221, 'LBH', 'Lambeth', 'Russian');
INSERT INTO emkt_regions VALUES(3896, 221, 'LCE', 'Leicester', 'Russian');
INSERT INTO emkt_regions VALUES(3897, 221, 'LDS', 'Leeds', 'Russian');
INSERT INTO emkt_regions VALUES(3898, 221, 'LEC', 'Leicestershire', 'Russian');
INSERT INTO emkt_regions VALUES(3899, 221, 'LEW', 'Lewisham', 'Russian');
INSERT INTO emkt_regions VALUES(3900, 221, 'LIN', 'Lincolnshire', 'Russian');
INSERT INTO emkt_regions VALUES(3901, 221, 'LIV', 'Liverpool', 'Russian');
INSERT INTO emkt_regions VALUES(3902, 221, 'LMV', 'Limavady', 'Russian');
INSERT INTO emkt_regions VALUES(3903, 221, 'LND', 'London', 'Russian');
INSERT INTO emkt_regions VALUES(3904, 221, 'LRN', 'Larne', 'Russian');
INSERT INTO emkt_regions VALUES(3905, 221, 'LSB', 'Lisburn', 'Russian');
INSERT INTO emkt_regions VALUES(3906, 221, 'LUT', 'Luton', 'Russian');
INSERT INTO emkt_regions VALUES(3907, 221, 'MAN', 'Manchester', 'Russian');
INSERT INTO emkt_regions VALUES(3908, 221, 'MDB', 'Middlesbrough', 'Russian');
INSERT INTO emkt_regions VALUES(3909, 221, 'MDW', 'Medway', 'Russian');
INSERT INTO emkt_regions VALUES(3910, 221, 'MFT', 'Magherafelt', 'Russian');
INSERT INTO emkt_regions VALUES(3911, 221, 'MIK', 'Milton Keynes', 'Russian');
INSERT INTO emkt_regions VALUES(3912, 221, 'MLN', 'Midlothian', 'Russian');
INSERT INTO emkt_regions VALUES(3913, 221, 'MON', 'Monmouthshire', 'Russian');
INSERT INTO emkt_regions VALUES(3914, 221, 'MRT', 'Merton', 'Russian');
INSERT INTO emkt_regions VALUES(3915, 221, 'MRY', 'Moray', 'Russian');
INSERT INTO emkt_regions VALUES(3916, 221, 'MTY', 'Merthyr Tydfil', 'Russian');
INSERT INTO emkt_regions VALUES(3917, 221, 'MYL', 'Moyle', 'Russian');
INSERT INTO emkt_regions VALUES(3918, 221, 'NAY', 'North Ayrshire', 'Russian');
INSERT INTO emkt_regions VALUES(3919, 221, 'NBL', 'Northumberland', 'Russian');
INSERT INTO emkt_regions VALUES(3920, 221, 'NDN', 'North Down', 'Russian');
INSERT INTO emkt_regions VALUES(3921, 221, 'NEL', 'North East Lincolnshire', 'Russian');
INSERT INTO emkt_regions VALUES(3922, 221, 'NET', 'Newcastle upon Tyne', 'Russian');
INSERT INTO emkt_regions VALUES(3923, 221, 'NFK', 'Norfolk', 'Russian');
INSERT INTO emkt_regions VALUES(3924, 221, 'NGM', 'Nottingham', 'Russian');
INSERT INTO emkt_regions VALUES(3925, 221, 'NLK', 'North Lanarkshire', 'Russian');
INSERT INTO emkt_regions VALUES(3926, 221, 'NLN', 'North Lincolnshire', 'Russian');
INSERT INTO emkt_regions VALUES(3927, 221, 'NSM', 'North Somerset', 'Russian');
INSERT INTO emkt_regions VALUES(3928, 221, 'NTA', 'Newtownabbey', 'Russian');
INSERT INTO emkt_regions VALUES(3929, 221, 'NTH', 'Northamptonshire', 'Russian');
INSERT INTO emkt_regions VALUES(3930, 221, 'NTL', 'Neath Port Talbot', 'Russian');
INSERT INTO emkt_regions VALUES(3931, 221, 'NTT', 'Nottinghamshire', 'Russian');
INSERT INTO emkt_regions VALUES(3932, 221, 'NTY', 'North Tyneside', 'Russian');
INSERT INTO emkt_regions VALUES(3933, 221, 'NWM', 'Newham', 'Russian');
INSERT INTO emkt_regions VALUES(3934, 221, 'NWP', 'Newport', 'Russian');
INSERT INTO emkt_regions VALUES(3935, 221, 'NYK', 'North Yorkshire', 'Russian');
INSERT INTO emkt_regions VALUES(3936, 221, 'NYM', 'Newry and Mourne', 'Russian');
INSERT INTO emkt_regions VALUES(3937, 221, 'OLD', 'Oldham', 'Russian');
INSERT INTO emkt_regions VALUES(3938, 221, 'OMH', 'Omagh', 'Russian');
INSERT INTO emkt_regions VALUES(3939, 221, 'ORK', 'Orkney Islands', 'Russian');
INSERT INTO emkt_regions VALUES(3940, 221, 'OXF', 'Oxfordshire', 'Russian');
INSERT INTO emkt_regions VALUES(3941, 221, 'PEM', 'Pembrokeshire', 'Russian');
INSERT INTO emkt_regions VALUES(3942, 221, 'PKN', 'Perth and Kinross', 'Russian');
INSERT INTO emkt_regions VALUES(3943, 221, 'PLY', 'Plymouth', 'Russian');
INSERT INTO emkt_regions VALUES(3944, 221, 'POL', 'Poole', 'Russian');
INSERT INTO emkt_regions VALUES(3945, 221, 'POR', 'Portsmouth', 'Russian');
INSERT INTO emkt_regions VALUES(3946, 221, 'POW', 'Powys', 'Russian');
INSERT INTO emkt_regions VALUES(3947, 221, 'PTE', 'Peterborough', 'Russian');
INSERT INTO emkt_regions VALUES(3948, 221, 'RCC', 'Redcar and Cleveland', 'Russian');
INSERT INTO emkt_regions VALUES(3949, 221, 'RCH', 'Rochdale', 'Russian');
INSERT INTO emkt_regions VALUES(3950, 221, 'RCT', 'Rhondda Cynon Taf', 'Russian');
INSERT INTO emkt_regions VALUES(3951, 221, 'RDB', 'Redbridge', 'Russian');
INSERT INTO emkt_regions VALUES(3952, 221, 'RDG', 'Reading', 'Russian');
INSERT INTO emkt_regions VALUES(3953, 221, 'RFW', 'Renfrewshire', 'Russian');
INSERT INTO emkt_regions VALUES(3954, 221, 'RIC', 'Richmond upon Thames', 'Russian');
INSERT INTO emkt_regions VALUES(3955, 221, 'ROT', 'Rotherham', 'Russian');
INSERT INTO emkt_regions VALUES(3956, 221, 'RUT', 'Rutland', 'Russian');
INSERT INTO emkt_regions VALUES(3957, 221, 'SAW', 'Sandwell', 'Russian');
INSERT INTO emkt_regions VALUES(3958, 221, 'SAY', 'South Ayrshire', 'Russian');
INSERT INTO emkt_regions VALUES(3959, 221, 'SCB', 'Scottish Borders', 'Russian');
INSERT INTO emkt_regions VALUES(3960, 221, 'SFK', 'Suffolk', 'Russian');
INSERT INTO emkt_regions VALUES(3961, 221, 'SFT', 'Sefton', 'Russian');
INSERT INTO emkt_regions VALUES(3962, 221, 'SGC', 'South Gloucestershire', 'Russian');
INSERT INTO emkt_regions VALUES(3963, 221, 'SHF', 'Sheffield', 'Russian');
INSERT INTO emkt_regions VALUES(3964, 221, 'SHN', 'Saint Helens', 'Russian');
INSERT INTO emkt_regions VALUES(3965, 221, 'SHR', 'Shropshire', 'Russian');
INSERT INTO emkt_regions VALUES(3966, 221, 'SKP', 'Stockport', 'Russian');
INSERT INTO emkt_regions VALUES(3967, 221, 'SLF', 'Salford', 'Russian');
INSERT INTO emkt_regions VALUES(3968, 221, 'SLG', 'Slough', 'Russian');
INSERT INTO emkt_regions VALUES(3969, 221, 'SLK', 'South Lanarkshire', 'Russian');
INSERT INTO emkt_regions VALUES(3970, 221, 'SND', 'Sunderland', 'Russian');
INSERT INTO emkt_regions VALUES(3971, 221, 'SOL', 'Solihull', 'Russian');
INSERT INTO emkt_regions VALUES(3972, 221, 'SOM', 'Somerset', 'Russian');
INSERT INTO emkt_regions VALUES(3973, 221, 'SOS', 'Southend-on-Sea', 'Russian');
INSERT INTO emkt_regions VALUES(3974, 221, 'SRY', 'Surrey', 'Russian');
INSERT INTO emkt_regions VALUES(3975, 221, 'STB', 'Strabane', 'Russian');
INSERT INTO emkt_regions VALUES(3976, 221, 'STE', 'Stoke-on-Trent', 'Russian');
INSERT INTO emkt_regions VALUES(3977, 221, 'STG', 'Stirling', 'Russian');
INSERT INTO emkt_regions VALUES(3978, 221, 'STH', 'Southampton', 'Russian');
INSERT INTO emkt_regions VALUES(3979, 221, 'STN', 'Sutton', 'Russian');
INSERT INTO emkt_regions VALUES(3980, 221, 'STS', 'Staffordshire', 'Russian');
INSERT INTO emkt_regions VALUES(3981, 221, 'STT', 'Stockton-on-Tees', 'Russian');
INSERT INTO emkt_regions VALUES(3982, 221, 'STY', 'South Tyneside', 'Russian');
INSERT INTO emkt_regions VALUES(3983, 221, 'SWA', 'Swansea', 'Russian');
INSERT INTO emkt_regions VALUES(3984, 221, 'SWD', 'Swindon', 'Russian');
INSERT INTO emkt_regions VALUES(3985, 221, 'SWK', 'Southwark', 'Russian');
INSERT INTO emkt_regions VALUES(3986, 221, 'TAM', 'Tameside', 'Russian');
INSERT INTO emkt_regions VALUES(3987, 221, 'TFW', 'Telford and Wrekin', 'Russian');
INSERT INTO emkt_regions VALUES(3988, 221, 'THR', 'Thurrock', 'Russian');
INSERT INTO emkt_regions VALUES(3989, 221, 'TOB', 'Torbay', 'Russian');
INSERT INTO emkt_regions VALUES(3990, 221, 'TOF', 'Torfaen', 'Russian');
INSERT INTO emkt_regions VALUES(3991, 221, 'TRF', 'Trafford', 'Russian');
INSERT INTO emkt_regions VALUES(3992, 221, 'TWH', 'Tower Hamlets', 'Russian');
INSERT INTO emkt_regions VALUES(3993, 221, 'VGL', 'Vale of Glamorgan', 'Russian');
INSERT INTO emkt_regions VALUES(3994, 221, 'WAR', 'Warwickshire', 'Russian');
INSERT INTO emkt_regions VALUES(3995, 221, 'WBK', 'West Berkshire', 'Russian');
INSERT INTO emkt_regions VALUES(3996, 221, 'WDU', 'West Dunbartonshire', 'Russian');
INSERT INTO emkt_regions VALUES(3997, 221, 'WFT', 'Waltham Forest', 'Russian');
INSERT INTO emkt_regions VALUES(3998, 221, 'WGN', 'Wigan', 'Russian');
INSERT INTO emkt_regions VALUES(3999, 221, 'WIL', 'Wiltshire', 'Russian');
INSERT INTO emkt_regions VALUES(4000, 221, 'WKF', 'Wakefield', 'Russian');
INSERT INTO emkt_regions VALUES(4001, 221, 'WLL', 'Walsall', 'Russian');
INSERT INTO emkt_regions VALUES(4002, 221, 'WLN', 'West Lothian', 'Russian');
INSERT INTO emkt_regions VALUES(4003, 221, 'WLV', 'Wolverhampton', 'Russian');
INSERT INTO emkt_regions VALUES(4004, 221, 'WNM', 'Windsor and Maidenhead', 'Russian');
INSERT INTO emkt_regions VALUES(4005, 221, 'WOK', 'Wokingham', 'Russian');
INSERT INTO emkt_regions VALUES(4006, 221, 'WOR', 'Worcestershire', 'Russian');
INSERT INTO emkt_regions VALUES(4007, 221, 'WRL', 'Wirral', 'Russian');
INSERT INTO emkt_regions VALUES(4008, 221, 'WRT', 'Warrington', 'Russian');
INSERT INTO emkt_regions VALUES(4009, 221, 'WRX', 'Wrexham', 'Russian');
INSERT INTO emkt_regions VALUES(4010, 221, 'WSM', 'Westminster', 'Russian');
INSERT INTO emkt_regions VALUES(4011, 221, 'WSX', 'West Sussex', 'Russian');
INSERT INTO emkt_regions VALUES(4012, 221, 'YOR', 'York', 'Russian');
INSERT INTO emkt_regions VALUES(4013, 221, 'ZET', 'Shetland Islands', 'Russian');

INSERT INTO emkt_countries VALUES (222,'Соединённые Штаты Америки','Russian','US','USA','');

INSERT INTO emkt_regions VALUES(4014, 222, 'AK', 'Alaska', 'Russian');
INSERT INTO emkt_regions VALUES(4015, 222, 'AL', 'Alabama', 'Russian');
INSERT INTO emkt_regions VALUES(4016, 222, 'AS', 'American Samoa', 'Russian');
INSERT INTO emkt_regions VALUES(4017, 222, 'AR', 'Arkansas', 'Russian');
INSERT INTO emkt_regions VALUES(4018, 222, 'AZ', 'Arizona', 'Russian');
INSERT INTO emkt_regions VALUES(4019, 222, 'CA', 'California', 'Russian');
INSERT INTO emkt_regions VALUES(4020, 222, 'CO', 'Colorado', 'Russian');
INSERT INTO emkt_regions VALUES(4021, 222, 'CT', 'Connecticut', 'Russian');
INSERT INTO emkt_regions VALUES(4022, 222, 'DC', 'District of Columbia', 'Russian');
INSERT INTO emkt_regions VALUES(4023, 222, 'DE', 'Delaware', 'Russian');
INSERT INTO emkt_regions VALUES(4024, 222, 'FL', 'Florida', 'Russian');
INSERT INTO emkt_regions VALUES(4025, 222, 'GA', 'Georgia', 'Russian');
INSERT INTO emkt_regions VALUES(4026, 222, 'GU', 'Guam', 'Russian');
INSERT INTO emkt_regions VALUES(4027, 222, 'HI', 'Hawaii', 'Russian');
INSERT INTO emkt_regions VALUES(4028, 222, 'IA', 'Iowa', 'Russian');
INSERT INTO emkt_regions VALUES(4029, 222, 'ID', 'Idaho', 'Russian');
INSERT INTO emkt_regions VALUES(4030, 222, 'IL', 'Illinois', 'Russian');
INSERT INTO emkt_regions VALUES(4031, 222, 'IN', 'Indiana', 'Russian');
INSERT INTO emkt_regions VALUES(4032, 222, 'KS', 'Kansas', 'Russian');
INSERT INTO emkt_regions VALUES(4033, 222, 'KY', 'Kentucky', 'Russian');
INSERT INTO emkt_regions VALUES(4034, 222, 'LA', 'Louisiana', 'Russian');
INSERT INTO emkt_regions VALUES(4035, 222, 'MA', 'Massachusetts', 'Russian');
INSERT INTO emkt_regions VALUES(4036, 222, 'MD', 'Maryland', 'Russian');
INSERT INTO emkt_regions VALUES(4037, 222, 'ME', 'Maine', 'Russian');
INSERT INTO emkt_regions VALUES(4038, 222, 'MI', 'Michigan', 'Russian');
INSERT INTO emkt_regions VALUES(4039, 222, 'MN', 'Minnesota', 'Russian');
INSERT INTO emkt_regions VALUES(4040, 222, 'MO', 'Missouri', 'Russian');
INSERT INTO emkt_regions VALUES(4041, 222, 'MS', 'Mississippi', 'Russian');
INSERT INTO emkt_regions VALUES(4042, 222, 'MT', 'Montana', 'Russian');
INSERT INTO emkt_regions VALUES(4043, 222, 'NC', 'North Carolina', 'Russian');
INSERT INTO emkt_regions VALUES(4044, 222, 'ND', 'North Dakota', 'Russian');
INSERT INTO emkt_regions VALUES(4045, 222, 'NE', 'Nebraska', 'Russian');
INSERT INTO emkt_regions VALUES(4046, 222, 'NH', 'New Hampshire', 'Russian');
INSERT INTO emkt_regions VALUES(4047, 222, 'NJ', 'New Jersey', 'Russian');
INSERT INTO emkt_regions VALUES(4048, 222, 'NM', 'New Mexico', 'Russian');
INSERT INTO emkt_regions VALUES(4049, 222, 'NV', 'Nevada', 'Russian');
INSERT INTO emkt_regions VALUES(4050, 222, 'NY', 'New York', 'Russian');
INSERT INTO emkt_regions VALUES(4051, 222, 'MP', 'Northern Mariana Islands', 'Russian');
INSERT INTO emkt_regions VALUES(4052, 222, 'OH', 'Ohio', 'Russian');
INSERT INTO emkt_regions VALUES(4053, 222, 'OK', 'Oklahoma', 'Russian');
INSERT INTO emkt_regions VALUES(4054, 222, 'OR', 'Oregon', 'Russian');
INSERT INTO emkt_regions VALUES(4055, 222, 'PA', 'Pennsylvania', 'Russian');
INSERT INTO emkt_regions VALUES(4056, 222, 'PR', 'Puerto Rico', 'Russian');
INSERT INTO emkt_regions VALUES(4057, 222, 'RI', 'Rhode Island', 'Russian');
INSERT INTO emkt_regions VALUES(4058, 222, 'SC', 'South Carolina', 'Russian');
INSERT INTO emkt_regions VALUES(4059, 222, 'SD', 'South Dakota', 'Russian');
INSERT INTO emkt_regions VALUES(4060, 222, 'TN', 'Tennessee', 'Russian');
INSERT INTO emkt_regions VALUES(4061, 222, 'TX', 'Texas', 'Russian');
INSERT INTO emkt_regions VALUES(4062, 222, 'UM', 'U.S. Minor Outlying Islands', 'Russian');
INSERT INTO emkt_regions VALUES(4063, 222, 'UT', 'Utah', 'Russian');
INSERT INTO emkt_regions VALUES(4064, 222, 'VA', 'Virginia', 'Russian');
INSERT INTO emkt_regions VALUES(4065, 222, 'VI', 'Virgin Islands of the U.S.', 'Russian');
INSERT INTO emkt_regions VALUES(4066, 222, 'VT', 'Vermont', 'Russian');
INSERT INTO emkt_regions VALUES(4067, 222, 'WA', 'Washington', 'Russian');
INSERT INTO emkt_regions VALUES(4068, 222, 'WI', 'Wisconsin', 'Russian');
INSERT INTO emkt_regions VALUES(4069, 222, 'WV', 'West Virginia', 'Russian');
INSERT INTO emkt_regions VALUES(4070, 222, 'WY', 'Wyoming', 'Russian');

INSERT INTO emkt_countries VALUES (223,'Внешние малые острова США','Russian','UM','UMI','');

INSERT INTO emkt_regions VALUES(4071, 223, 'BI', 'Baker Island', 'Russian');
INSERT INTO emkt_regions VALUES(4072, 223, 'HI', 'Howland Island', 'Russian');
INSERT INTO emkt_regions VALUES(4073, 223, 'JI', 'Jarvis Island', 'Russian');
INSERT INTO emkt_regions VALUES(4074, 223, 'JA', 'Johnston Atoll', 'Russian');
INSERT INTO emkt_regions VALUES(4075, 223, 'KR', 'Kingman Reef', 'Russian');
INSERT INTO emkt_regions VALUES(4076, 223, 'MA', 'Midway Atoll', 'Russian');
INSERT INTO emkt_regions VALUES(4077, 223, 'NI', 'Navassa Island', 'Russian');
INSERT INTO emkt_regions VALUES(4078, 223, 'PA', 'Palmyra Atoll', 'Russian');
INSERT INTO emkt_regions VALUES(4079, 223, 'WI', 'Wake Island', 'Russian');

INSERT INTO emkt_countries VALUES (224,'Уругвай','Russian','UY','URY','');

INSERT INTO emkt_regions VALUES(4080, 224, 'AR', 'Artigas', 'Russian');
INSERT INTO emkt_regions VALUES(4081, 224, 'CA', 'Canelones', 'Russian');
INSERT INTO emkt_regions VALUES(4082, 224, 'CL', 'Cerro Largo', 'Russian');
INSERT INTO emkt_regions VALUES(4083, 224, 'CO', 'Colonia', 'Russian');
INSERT INTO emkt_regions VALUES(4084, 224, 'DU', 'Durazno', 'Russian');
INSERT INTO emkt_regions VALUES(4085, 224, 'FD', 'Florida', 'Russian');
INSERT INTO emkt_regions VALUES(4086, 224, 'FS', 'Flores', 'Russian');
INSERT INTO emkt_regions VALUES(4087, 224, 'LA', 'Lavalleja', 'Russian');
INSERT INTO emkt_regions VALUES(4088, 224, 'MA', 'Maldonado', 'Russian');
INSERT INTO emkt_regions VALUES(4089, 224, 'MO', 'Montevideo', 'Russian');
INSERT INTO emkt_regions VALUES(4090, 224, 'PA', 'Paysandu', 'Russian');
INSERT INTO emkt_regions VALUES(4091, 224, 'RN', 'Río Negro', 'Russian');
INSERT INTO emkt_regions VALUES(4092, 224, 'RO', 'Rocha', 'Russian');
INSERT INTO emkt_regions VALUES(4093, 224, 'RV', 'Rivera', 'Russian');
INSERT INTO emkt_regions VALUES(4094, 224, 'SA', 'Salto', 'Russian');
INSERT INTO emkt_regions VALUES(4095, 224, 'SJ', 'San José', 'Russian');
INSERT INTO emkt_regions VALUES(4096, 224, 'SO', 'Soriano', 'Russian');
INSERT INTO emkt_regions VALUES(4097, 224, 'TA', 'Tacuarembó', 'Russian');
INSERT INTO emkt_regions VALUES(4098, 224, 'TT', 'Treinta y Tres', 'Russian');

INSERT INTO emkt_countries VALUES (225,'Узбекистан','Russian','UZ','UZB','');

INSERT INTO emkt_regions VALUES(4099, 225, 'AN', 'Andijon viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4100, 225, 'BU', 'Buxoro viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4101, 225, 'FA', 'Farg\'ona viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4102, 225, 'JI', 'Jizzax viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4103, 225, 'NG', 'Namangan viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4104, 225, 'NW', 'Navoiy viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4105, 225, 'QA', 'Qashqadaryo viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4106, 225, 'QR', 'Qoraqalpog\'iston Respublikasi', 'Russian');
INSERT INTO emkt_regions VALUES(4107, 225, 'SA', 'Samarqand viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4108, 225, 'SI', 'Sirdaryo viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4109, 225, 'SU', 'Surxondaryo viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4110, 225, 'TK', 'Toshkent', 'Russian');
INSERT INTO emkt_regions VALUES(4111, 225, 'TO', 'Toshkent viloyati', 'Russian');
INSERT INTO emkt_regions VALUES(4112, 225, 'XO', 'Xorazm viloyati', 'Russian');

INSERT INTO emkt_countries VALUES (226,'Вануату','Russian','VU','VUT','');

INSERT INTO emkt_regions VALUES(4113, 226, 'MAP', 'Malampa', 'Russian');
INSERT INTO emkt_regions VALUES(4114, 226, 'PAM', 'Pénama', 'Russian');
INSERT INTO emkt_regions VALUES(4115, 226, 'SAM', 'Sanma', 'Russian');
INSERT INTO emkt_regions VALUES(4116, 226, 'SEE', 'Shéfa', 'Russian');
INSERT INTO emkt_regions VALUES(4117, 226, 'TAE', 'Taféa', 'Russian');
INSERT INTO emkt_regions VALUES(4118, 226, 'TOB', 'Torba', 'Russian');

INSERT INTO emkt_countries VALUES (227,'Ватикан','Russian','VA','VAT','');

INSERT INTO emkt_regions VALUES(4279, 227, 'NOCODE', 'Vatican City State (Holy See)', 'Russian');

INSERT INTO emkt_countries VALUES (228,'Венесуэла','Russian','VE','VEN','');

INSERT INTO emkt_regions VALUES(4119, 228, 'A', 'Distrito Capital', 'Russian');
INSERT INTO emkt_regions VALUES(4120, 228, 'B', 'Anzoátegui', 'Russian');
INSERT INTO emkt_regions VALUES(4121, 228, 'C', 'Apure', 'Russian');
INSERT INTO emkt_regions VALUES(4122, 228, 'D', 'Aragua', 'Russian');
INSERT INTO emkt_regions VALUES(4123, 228, 'E', 'Barinas', 'Russian');
INSERT INTO emkt_regions VALUES(4124, 228, 'F', 'Bolívar', 'Russian');
INSERT INTO emkt_regions VALUES(4125, 228, 'G', 'Carabobo', 'Russian');
INSERT INTO emkt_regions VALUES(4126, 228, 'H', 'Cojedes', 'Russian');
INSERT INTO emkt_regions VALUES(4127, 228, 'I', 'Falcón', 'Russian');
INSERT INTO emkt_regions VALUES(4128, 228, 'J', 'Guárico', 'Russian');
INSERT INTO emkt_regions VALUES(4129, 228, 'K', 'Lara', 'Russian');
INSERT INTO emkt_regions VALUES(4130, 228, 'L', 'Mérida', 'Russian');
INSERT INTO emkt_regions VALUES(4131, 228, 'M', 'Miranda', 'Russian');
INSERT INTO emkt_regions VALUES(4132, 228, 'N', 'Monagas', 'Russian');
INSERT INTO emkt_regions VALUES(4133, 228, 'O', 'Nueva Esparta', 'Russian');
INSERT INTO emkt_regions VALUES(4134, 228, 'P', 'Portuguesa', 'Russian');
INSERT INTO emkt_regions VALUES(4135, 228, 'R', 'Sucre', 'Russian');
INSERT INTO emkt_regions VALUES(4136, 228, 'S', 'Tachira', 'Russian');
INSERT INTO emkt_regions VALUES(4137, 228, 'T', 'Trujillo', 'Russian');
INSERT INTO emkt_regions VALUES(4138, 228, 'U', 'Yaracuy', 'Russian');
INSERT INTO emkt_regions VALUES(4139, 228, 'V', 'Zulia', 'Russian');
INSERT INTO emkt_regions VALUES(4140, 228, 'W', 'Capital Dependencia', 'Russian');
INSERT INTO emkt_regions VALUES(4141, 228, 'X', 'Vargas', 'Russian');
INSERT INTO emkt_regions VALUES(4142, 228, 'Y', 'Delta Amacuro', 'Russian');
INSERT INTO emkt_regions VALUES(4143, 228, 'Z', 'Amazonas', 'Russian');

INSERT INTO emkt_countries VALUES (229,'Вьетнам','Russian','VN','VNM','');

INSERT INTO emkt_regions VALUES(4144, 229, '01', 'Lai Châu', 'Russian');
INSERT INTO emkt_regions VALUES(4145, 229, '02', 'Lào Cai', 'Russian');
INSERT INTO emkt_regions VALUES(4146, 229, '03', 'Hà Giang', 'Russian');
INSERT INTO emkt_regions VALUES(4147, 229, '04', 'Cao Bằng', 'Russian');
INSERT INTO emkt_regions VALUES(4148, 229, '05', 'Sơn La', 'Russian');
INSERT INTO emkt_regions VALUES(4149, 229, '06', 'Yên Bái', 'Russian');
INSERT INTO emkt_regions VALUES(4150, 229, '07', 'Tuyên Quang', 'Russian');
INSERT INTO emkt_regions VALUES(4151, 229, '09', 'Lạng Sơn', 'Russian');
INSERT INTO emkt_regions VALUES(4152, 229, '13', 'Quảng Ninh', 'Russian');
INSERT INTO emkt_regions VALUES(4153, 229, '14', 'Hòa Bình', 'Russian');
INSERT INTO emkt_regions VALUES(4154, 229, '15', 'Hà Tây', 'Russian');
INSERT INTO emkt_regions VALUES(4155, 229, '18', 'Ninh Bình', 'Russian');
INSERT INTO emkt_regions VALUES(4156, 229, '20', 'Thái Bình', 'Russian');
INSERT INTO emkt_regions VALUES(4157, 229, '21', 'Thanh Hóa', 'Russian');
INSERT INTO emkt_regions VALUES(4158, 229, '22', 'Nghệ An', 'Russian');
INSERT INTO emkt_regions VALUES(4159, 229, '23', 'Hà Tĩnh', 'Russian');
INSERT INTO emkt_regions VALUES(4160, 229, '24', 'Quảng Bình', 'Russian');
INSERT INTO emkt_regions VALUES(4161, 229, '25', 'Quảng Trị', 'Russian');
INSERT INTO emkt_regions VALUES(4162, 229, '26', 'Thừa Thiên-Huế', 'Russian');
INSERT INTO emkt_regions VALUES(4163, 229, '27', 'Quảng Nam', 'Russian');
INSERT INTO emkt_regions VALUES(4164, 229, '28', 'Kon Tum', 'Russian');
INSERT INTO emkt_regions VALUES(4165, 229, '29', 'Quảng Ngãi', 'Russian');
INSERT INTO emkt_regions VALUES(4166, 229, '30', 'Gia Lai', 'Russian');
INSERT INTO emkt_regions VALUES(4167, 229, '31', 'Bình Định', 'Russian');
INSERT INTO emkt_regions VALUES(4168, 229, '32', 'Phú Yên', 'Russian');
INSERT INTO emkt_regions VALUES(4169, 229, '33', 'Đắk Lắk', 'Russian');
INSERT INTO emkt_regions VALUES(4170, 229, '34', 'Khánh Hòa', 'Russian');
INSERT INTO emkt_regions VALUES(4171, 229, '35', 'Lâm Đồng', 'Russian');
INSERT INTO emkt_regions VALUES(4172, 229, '36', 'Ninh Thuận', 'Russian');
INSERT INTO emkt_regions VALUES(4173, 229, '37', 'Tây Ninh', 'Russian');
INSERT INTO emkt_regions VALUES(4174, 229, '39', 'Đồng Nai', 'Russian');
INSERT INTO emkt_regions VALUES(4175, 229, '40', 'Bình Thuận', 'Russian');
INSERT INTO emkt_regions VALUES(4176, 229, '41', 'Long An', 'Russian');
INSERT INTO emkt_regions VALUES(4177, 229, '43', 'Bà Rịa-Vũng Tàu', 'Russian');
INSERT INTO emkt_regions VALUES(4178, 229, '44', 'An Giang', 'Russian');
INSERT INTO emkt_regions VALUES(4179, 229, '45', 'Đồng Tháp', 'Russian');
INSERT INTO emkt_regions VALUES(4180, 229, '46', 'Tiền Giang', 'Russian');
INSERT INTO emkt_regions VALUES(4181, 229, '47', 'Kiên Giang', 'Russian');
INSERT INTO emkt_regions VALUES(4182, 229, '48', 'Cần Thơ', 'Russian');
INSERT INTO emkt_regions VALUES(4183, 229, '49', 'Vĩnh Long', 'Russian');
INSERT INTO emkt_regions VALUES(4184, 229, '50', 'Bến Tre', 'Russian');
INSERT INTO emkt_regions VALUES(4185, 229, '51', 'Trà Vinh', 'Russian');
INSERT INTO emkt_regions VALUES(4186, 229, '52', 'Sóc Trăng', 'Russian');
INSERT INTO emkt_regions VALUES(4187, 229, '53', 'Bắc Kạn', 'Russian');
INSERT INTO emkt_regions VALUES(4188, 229, '54', 'Bắc Giang', 'Russian');
INSERT INTO emkt_regions VALUES(4189, 229, '55', 'Bạc Liêu', 'Russian');
INSERT INTO emkt_regions VALUES(4190, 229, '56', 'Bắc Ninh', 'Russian');
INSERT INTO emkt_regions VALUES(4191, 229, '57', 'Bình Dương', 'Russian');
INSERT INTO emkt_regions VALUES(4192, 229, '58', 'Bình Phước', 'Russian');
INSERT INTO emkt_regions VALUES(4193, 229, '59', 'Cà Mau', 'Russian');
INSERT INTO emkt_regions VALUES(4194, 229, '60', 'Đà Nẵng', 'Russian');
INSERT INTO emkt_regions VALUES(4195, 229, '61', 'Hải Dương', 'Russian');
INSERT INTO emkt_regions VALUES(4196, 229, '62', 'Hải Phòng', 'Russian');
INSERT INTO emkt_regions VALUES(4197, 229, '63', 'Hà Nam', 'Russian');
INSERT INTO emkt_regions VALUES(4198, 229, '64', 'Hà Nội', 'Russian');
INSERT INTO emkt_regions VALUES(4199, 229, '65', 'Sài Gòn', 'Russian');
INSERT INTO emkt_regions VALUES(4200, 229, '66', 'Hưng Yên', 'Russian');
INSERT INTO emkt_regions VALUES(4201, 229, '67', 'Nam Định', 'Russian');
INSERT INTO emkt_regions VALUES(4202, 229, '68', 'Phú Thọ', 'Russian');
INSERT INTO emkt_regions VALUES(4203, 229, '69', 'Thái Nguyên', 'Russian');
INSERT INTO emkt_regions VALUES(4204, 229, '70', 'Vĩnh Phúc', 'Russian');
INSERT INTO emkt_regions VALUES(4205, 229, '71', 'Điện Biên', 'Russian');
INSERT INTO emkt_regions VALUES(4206, 229, '72', 'Đắk Nông', 'Russian');
INSERT INTO emkt_regions VALUES(4207, 229, '73', 'Hậu Giang', 'Russian');

INSERT INTO emkt_countries VALUES (230,'Британские Виргинские острова','Russian','VG','VGB','');

INSERT INTO emkt_regions VALUES(4280, 230, 'NOCODE', 'Virgin Islands (British)', 'Russian');

INSERT INTO emkt_countries VALUES (231,'Американские Виргинские острова','Russian','VI','VIR','');

INSERT INTO emkt_regions VALUES(4208, 231, 'C', 'Saint Croix', 'Russian');
INSERT INTO emkt_regions VALUES(4209, 231, 'J', 'Saint John', 'Russian');
INSERT INTO emkt_regions VALUES(4210, 231, 'T', 'Saint Thomas', 'Russian');

INSERT INTO emkt_countries VALUES (232,'Уоллис и Футуна','Russian','WF','WLF','');

INSERT INTO emkt_regions VALUES(4211, 232, 'A', 'Alo', 'Russian');
INSERT INTO emkt_regions VALUES(4212, 232, 'S', 'Sigave', 'Russian');
INSERT INTO emkt_regions VALUES(4213, 232, 'W', 'Wallis', 'Russian');

INSERT INTO emkt_countries VALUES (233,'Западная Сахара','Russian','EH','ESH','');

INSERT INTO emkt_regions VALUES(4281, 233, 'NOCODE', 'Western Sahara', 'Russian');

INSERT INTO emkt_countries VALUES (234,'Йемен','Russian','YE','YEM','');

INSERT INTO emkt_regions VALUES(4214, 234, 'AB', 'أبين‎', 'Russian');
INSERT INTO emkt_regions VALUES(4215, 234, 'AD', 'عدن', 'Russian');
INSERT INTO emkt_regions VALUES(4216, 234, 'AM', 'عمران', 'Russian');
INSERT INTO emkt_regions VALUES(4217, 234, 'BA', 'البيضاء', 'Russian');
INSERT INTO emkt_regions VALUES(4218, 234, 'DA', 'الضالع', 'Russian');
INSERT INTO emkt_regions VALUES(4219, 234, 'DH', 'ذمار', 'Russian');
INSERT INTO emkt_regions VALUES(4220, 234, 'HD', 'حضرموت', 'Russian');
INSERT INTO emkt_regions VALUES(4221, 234, 'HJ', 'حجة', 'Russian');
INSERT INTO emkt_regions VALUES(4222, 234, 'HU', 'الحديدة', 'Russian');
INSERT INTO emkt_regions VALUES(4223, 234, 'IB', 'إب', 'Russian');
INSERT INTO emkt_regions VALUES(4224, 234, 'JA', 'الجوف', 'Russian');
INSERT INTO emkt_regions VALUES(4225, 234, 'LA', 'لحج', 'Russian');
INSERT INTO emkt_regions VALUES(4226, 234, 'MA', 'مأرب', 'Russian');
INSERT INTO emkt_regions VALUES(4227, 234, 'MR', 'المهرة', 'Russian');
INSERT INTO emkt_regions VALUES(4228, 234, 'MW', 'المحويت', 'Russian');
INSERT INTO emkt_regions VALUES(4229, 234, 'SD', 'صعدة', 'Russian');
INSERT INTO emkt_regions VALUES(4230, 234, 'SN', 'صنعاء', 'Russian');
INSERT INTO emkt_regions VALUES(4231, 234, 'SH', 'شبوة', 'Russian');
INSERT INTO emkt_regions VALUES(4232, 234, 'TA', 'تعز', 'Russian');

INSERT INTO emkt_countries VALUES (235,'Югославия','Russian','YU','YUG','');

INSERT INTO emkt_regions VALUES(4282, 235, 'NOCODE', 'Yugoslavia', 'Russian');

INSERT INTO emkt_countries VALUES (236,'Заир','Russian','ZR','ZAR','');

INSERT INTO emkt_regions VALUES(4283, 236, 'NOCODE', 'Zaire', 'Russian');

INSERT INTO emkt_countries VALUES (237,'Замбия','Russian','ZM','ZMB','');

INSERT INTO emkt_regions VALUES(4233, 237, '01', 'Western', 'Russian');
INSERT INTO emkt_regions VALUES(4234, 237, '02', 'Central', 'Russian');
INSERT INTO emkt_regions VALUES(4235, 237, '03', 'Eastern', 'Russian');
INSERT INTO emkt_regions VALUES(4236, 237, '04', 'Luapula', 'Russian');
INSERT INTO emkt_regions VALUES(4237, 237, '05', 'Northern', 'Russian');
INSERT INTO emkt_regions VALUES(4238, 237, '06', 'North-Western', 'Russian');
INSERT INTO emkt_regions VALUES(4239, 237, '07', 'Southern', 'Russian');
INSERT INTO emkt_regions VALUES(4240, 237, '08', 'Copperbelt', 'Russian');
INSERT INTO emkt_regions VALUES(4241, 237, '09', 'Lusaka', 'Russian');

INSERT INTO emkt_countries VALUES (238,'Зимбабве','Russian','ZW','ZWE','');

INSERT INTO emkt_regions VALUES(4242, 238, 'MA', 'Manicaland', 'Russian');
INSERT INTO emkt_regions VALUES(4243, 238, 'MC', 'Mashonaland Central', 'Russian');
INSERT INTO emkt_regions VALUES(4244, 238, 'ME', 'Mashonaland East', 'Russian');
INSERT INTO emkt_regions VALUES(4245, 238, 'MI', 'Midlands', 'Russian');
INSERT INTO emkt_regions VALUES(4246, 238, 'MN', 'Matabeleland North', 'Russian');
INSERT INTO emkt_regions VALUES(4247, 238, 'MS', 'Matabeleland South', 'Russian');
INSERT INTO emkt_regions VALUES(4248, 238, 'MV', 'Masvingo', 'Russian');
INSERT INTO emkt_regions VALUES(4249, 238, 'MW', 'Mashonaland West', 'Russian');

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
INSERT INTO emkt_regions VALUES(448, 25, '31', 'Sarpang', 'English');
INSERT INTO emkt_regions VALUES(449, 25, '32', 'Trongsa', 'English');
INSERT INTO emkt_regions VALUES(450, 25, '33', 'Bumthang', 'English');
INSERT INTO emkt_regions VALUES(451, 25, '34', 'Zhemgang', 'English');
INSERT INTO emkt_regions VALUES(452, 25, '41', 'Trashigang', 'English');
INSERT INTO emkt_regions VALUES(453, 25, '42', 'Mongar', 'English');
INSERT INTO emkt_regions VALUES(454, 25, '43', 'Pemagatshel', 'English');
INSERT INTO emkt_regions VALUES(455, 25, '44', 'Luentse', 'English');
INSERT INTO emkt_regions VALUES(456, 25, '45', 'Samdrup Jongkhar', 'English');
INSERT INTO emkt_regions VALUES(457, 25, 'GA', 'Gasa', 'English');
INSERT INTO emkt_regions VALUES(458, 25, 'TY', 'Trashiyangse', 'English');

INSERT INTO emkt_countries VALUES (26,'Bolivia','English','BO','BOL','');

INSERT INTO emkt_regions VALUES(459, 26, 'B', 'El Beni', 'English');
INSERT INTO emkt_regions VALUES(460, 26, 'C', 'Cochabamba', 'English');
INSERT INTO emkt_regions VALUES(461, 26, 'H', 'Chuquisaca', 'English');
INSERT INTO emkt_regions VALUES(462, 26, 'L', 'La Paz', 'English');
INSERT INTO emkt_regions VALUES(463, 26, 'N', 'Pando', 'English');
INSERT INTO emkt_regions VALUES(464, 26, 'O', 'Oruro', 'English');
INSERT INTO emkt_regions VALUES(465, 26, 'P', 'Potosí', 'English');
INSERT INTO emkt_regions VALUES(466, 26, 'S', 'Santa Cruz', 'English');
INSERT INTO emkt_regions VALUES(467, 26, 'T', 'Tarija', 'English');

INSERT INTO emkt_countries VALUES (27,'Bosnia and Herzegowina','English','BA','BIH','');

INSERT INTO emkt_regions VALUES(4253, 27, 'NOCODE', 'Bosnia and Herzegowina', 'English');

INSERT INTO emkt_countries VALUES (28,'Botswana','English','BW','BWA','');

INSERT INTO emkt_regions VALUES(468, 28, 'CE', 'Central', 'English');
INSERT INTO emkt_regions VALUES(469, 28, 'GH', 'Ghanzi', 'English');
INSERT INTO emkt_regions VALUES(470, 28, 'KG', 'Kgalagadi', 'English');
INSERT INTO emkt_regions VALUES(471, 28, 'KL', 'Kgatleng', 'English');
INSERT INTO emkt_regions VALUES(472, 28, 'KW', 'Kweneng', 'English');
INSERT INTO emkt_regions VALUES(473, 28, 'NE', 'North-East', 'English');
INSERT INTO emkt_regions VALUES(474, 28, 'NW', 'North-West', 'English');
INSERT INTO emkt_regions VALUES(475, 28, 'SE', 'South-East', 'English');
INSERT INTO emkt_regions VALUES(476, 28, 'SO', 'Southern', 'English');

INSERT INTO emkt_countries VALUES (29,'Bouvet Island','English','BV','BVT','');

INSERT INTO emkt_regions VALUES(4254, 29, 'NOCODE', 'Bouvet Island', 'English');

INSERT INTO emkt_countries VALUES (30,'Brazil','English','BR','BRA','');

INSERT INTO emkt_regions VALUES(477, 30, 'AC', 'Acre', 'English');
INSERT INTO emkt_regions VALUES(478, 30, 'AL', 'Alagoas', 'English');
INSERT INTO emkt_regions VALUES(479, 30, 'AM', 'Amazônia', 'English');
INSERT INTO emkt_regions VALUES(480, 30, 'AP', 'Amapá', 'English');
INSERT INTO emkt_regions VALUES(481, 30, 'BA', 'Bahia', 'English');
INSERT INTO emkt_regions VALUES(482, 30, 'CE', 'Ceará', 'English');
INSERT INTO emkt_regions VALUES(483, 30, 'DF', 'Distrito Federal', 'English');
INSERT INTO emkt_regions VALUES(484, 30, 'ES', 'Espírito Santo', 'English');
INSERT INTO emkt_regions VALUES(485, 30, 'GO', 'Goiás', 'English');
INSERT INTO emkt_regions VALUES(486, 30, 'MA', 'Maranhão', 'English');
INSERT INTO emkt_regions VALUES(487, 30, 'MG', 'Minas Gerais', 'English');
INSERT INTO emkt_regions VALUES(488, 30, 'MS', 'Mato Grosso do Sul', 'English');
INSERT INTO emkt_regions VALUES(489, 30, 'MT', 'Mato Grosso', 'English');
INSERT INTO emkt_regions VALUES(490, 30, 'PA', 'Pará', 'English');
INSERT INTO emkt_regions VALUES(491, 30, 'PB', 'Paraíba', 'English');
INSERT INTO emkt_regions VALUES(492, 30, 'PE', 'Pernambuco', 'English');
INSERT INTO emkt_regions VALUES(493, 30, 'PI', 'Piauí', 'English');
INSERT INTO emkt_regions VALUES(494, 30, 'PR', 'Paraná', 'English');
INSERT INTO emkt_regions VALUES(495, 30, 'RJ', 'Rio de Janeiro', 'English');
INSERT INTO emkt_regions VALUES(496, 30, 'RN', 'Rio Grande do Norte', 'English');
INSERT INTO emkt_regions VALUES(497, 30, 'RO', 'Rondônia', 'English');
INSERT INTO emkt_regions VALUES(498, 30, 'RR', 'Roraima', 'English');
INSERT INTO emkt_regions VALUES(499, 30, 'RS', 'Rio Grande do Sul', 'English');
INSERT INTO emkt_regions VALUES(500, 30, 'SC', 'Santa Catarina', 'English');
INSERT INTO emkt_regions VALUES(501, 30, 'SE', 'Sergipe', 'English');
INSERT INTO emkt_regions VALUES(502, 30, 'SP', 'São Paulo', 'English');
INSERT INTO emkt_regions VALUES(503, 30, 'TO', 'Tocantins', 'English');

INSERT INTO emkt_countries VALUES (31,'British Indian Ocean Territory','English','IO','IOT','');

INSERT INTO emkt_regions VALUES(504, 31, 'PB', 'Peros Banhos', 'English');
INSERT INTO emkt_regions VALUES(505, 31, 'SI', 'Salomon Islands', 'English');
INSERT INTO emkt_regions VALUES(506, 31, 'NI', 'Nelsons Island', 'English');
INSERT INTO emkt_regions VALUES(507, 31, 'TB', 'Three Brothers', 'English');
INSERT INTO emkt_regions VALUES(508, 31, 'EA', 'Eagle Islands', 'English');
INSERT INTO emkt_regions VALUES(509, 31, 'DI', 'Danger Island', 'English');
INSERT INTO emkt_regions VALUES(510, 31, 'EG', 'Egmont Islands', 'English');
INSERT INTO emkt_regions VALUES(511, 31, 'DG', 'Diego Garcia', 'English');

INSERT INTO emkt_countries VALUES (32,'Brunei Darussalam','English','BN','BRN','');

INSERT INTO emkt_regions VALUES(512, 32, 'BE', 'Belait', 'English');
INSERT INTO emkt_regions VALUES(513, 32, 'BM', 'Brunei-Muara', 'English');
INSERT INTO emkt_regions VALUES(514, 32, 'TE', 'Temburong', 'English');
INSERT INTO emkt_regions VALUES(515, 32, 'TU', 'Tutong', 'English');

INSERT INTO emkt_countries VALUES (33,'Bulgaria','English','BG','BGR','');

INSERT INTO emkt_regions VALUES(516, 33, '01', 'Blagoevgrad', 'English');
INSERT INTO emkt_regions VALUES(517, 33, '02', 'Burgas', 'English');
INSERT INTO emkt_regions VALUES(518, 33, '03', 'Varna', 'English');
INSERT INTO emkt_regions VALUES(519, 33, '04', 'Veliko Tarnovo', 'English');
INSERT INTO emkt_regions VALUES(520, 33, '05', 'Vidin', 'English');
INSERT INTO emkt_regions VALUES(521, 33, '06', 'Vratsa', 'English');
INSERT INTO emkt_regions VALUES(522, 33, '07', 'Gabrovo', 'English');
INSERT INTO emkt_regions VALUES(523, 33, '08', 'Dobrich', 'English');
INSERT INTO emkt_regions VALUES(524, 33, '09', 'Kardzhali', 'English');
INSERT INTO emkt_regions VALUES(525, 33, '10', 'Kyustendil', 'English');
INSERT INTO emkt_regions VALUES(526, 33, '11', 'Lovech', 'English');
INSERT INTO emkt_regions VALUES(527, 33, '12', 'Montana', 'English');
INSERT INTO emkt_regions VALUES(528, 33, '13', 'Pazardzhik', 'English');
INSERT INTO emkt_regions VALUES(529, 33, '14', 'Pernik', 'English');
INSERT INTO emkt_regions VALUES(530, 33, '15', 'Pleven', 'English');
INSERT INTO emkt_regions VALUES(531, 33, '16', 'Plovdiv', 'English');
INSERT INTO emkt_regions VALUES(532, 33, '17', 'Razgrad', 'English');
INSERT INTO emkt_regions VALUES(533, 33, '18', 'Ruse', 'English');
INSERT INTO emkt_regions VALUES(534, 33, '19', 'Silistra', 'English');
INSERT INTO emkt_regions VALUES(535, 33, '20', 'Sliven', 'English');
INSERT INTO emkt_regions VALUES(536, 33, '21', 'Smolyan', 'English');
INSERT INTO emkt_regions VALUES(537, 33, '23', 'Sofia', 'English');
INSERT INTO emkt_regions VALUES(538, 33, '22', 'Sofia Province', 'English');
INSERT INTO emkt_regions VALUES(539, 33, '24', 'Stara Zagora', 'English');
INSERT INTO emkt_regions VALUES(540, 33, '25', 'Targovishte', 'English');
INSERT INTO emkt_regions VALUES(541, 33, '26', 'Haskovo', 'English');
INSERT INTO emkt_regions VALUES(542, 33, '27', 'Shumen', 'English');
INSERT INTO emkt_regions VALUES(543, 33, '28', 'Yambol', 'English');

INSERT INTO emkt_countries VALUES (34,'Burkina Faso','English','BF','BFA','');

INSERT INTO emkt_regions VALUES(544, 34, 'BAL', 'Balé', 'English');
INSERT INTO emkt_regions VALUES(545, 34, 'BAM', 'Bam', 'English');
INSERT INTO emkt_regions VALUES(546, 34, 'BAN', 'Banwa', 'English');
INSERT INTO emkt_regions VALUES(547, 34, 'BAZ', 'Bazèga', 'English');
INSERT INTO emkt_regions VALUES(548, 34, 'BGR', 'Bougouriba', 'English');
INSERT INTO emkt_regions VALUES(549, 34, 'BLG', 'Boulgou', 'English');
INSERT INTO emkt_regions VALUES(550, 34, 'BLK', 'Boulkiemdé', 'English');
INSERT INTO emkt_regions VALUES(551, 34, 'COM', 'Komoé', 'English');
INSERT INTO emkt_regions VALUES(552, 34, 'GAN', 'Ganzourgou', 'English');
INSERT INTO emkt_regions VALUES(553, 34, 'GNA', 'Gnagna', 'English');
INSERT INTO emkt_regions VALUES(554, 34, 'GOU', 'Gourma', 'English');
INSERT INTO emkt_regions VALUES(555, 34, 'HOU', 'Houet', 'English');
INSERT INTO emkt_regions VALUES(556, 34, 'IOB', 'Ioba', 'English');
INSERT INTO emkt_regions VALUES(557, 34, 'KAD', 'Kadiogo', 'English');
INSERT INTO emkt_regions VALUES(558, 34, 'KEN', 'Kénédougou', 'English');
INSERT INTO emkt_regions VALUES(559, 34, 'KMD', 'Komondjari', 'English');
INSERT INTO emkt_regions VALUES(560, 34, 'KMP', 'Kompienga', 'English');
INSERT INTO emkt_regions VALUES(561, 34, 'KOP', 'Koulpélogo', 'English');
INSERT INTO emkt_regions VALUES(562, 34, 'KOS', 'Kossi', 'English');
INSERT INTO emkt_regions VALUES(563, 34, 'KOT', 'Kouritenga', 'English');
INSERT INTO emkt_regions VALUES(564, 34, 'KOW', 'Kourwéogo', 'English');
INSERT INTO emkt_regions VALUES(565, 34, 'LER', 'Léraba', 'English');
INSERT INTO emkt_regions VALUES(566, 34, 'LOR', 'Loroum', 'English');
INSERT INTO emkt_regions VALUES(567, 34, 'MOU', 'Mouhoun', 'English');
INSERT INTO emkt_regions VALUES(568, 34, 'NAM', 'Namentenga', 'English');
INSERT INTO emkt_regions VALUES(569, 34, 'NAO', 'Naouri', 'English');
INSERT INTO emkt_regions VALUES(570, 34, 'NAY', 'Nayala', 'English');
INSERT INTO emkt_regions VALUES(571, 34, 'NOU', 'Noumbiel', 'English');
INSERT INTO emkt_regions VALUES(572, 34, 'OUB', 'Oubritenga', 'English');
INSERT INTO emkt_regions VALUES(573, 34, 'OUD', 'Oudalan', 'English');
INSERT INTO emkt_regions VALUES(574, 34, 'PAS', 'Passoré', 'English');
INSERT INTO emkt_regions VALUES(575, 34, 'PON', 'Poni', 'English');
INSERT INTO emkt_regions VALUES(576, 34, 'SEN', 'Séno', 'English');
INSERT INTO emkt_regions VALUES(577, 34, 'SIS', 'Sissili', 'English');
INSERT INTO emkt_regions VALUES(578, 34, 'SMT', 'Sanmatenga', 'English');
INSERT INTO emkt_regions VALUES(579, 34, 'SNG', 'Sanguié', 'English');
INSERT INTO emkt_regions VALUES(580, 34, 'SOM', 'Soum', 'English');
INSERT INTO emkt_regions VALUES(581, 34, 'SOR', 'Sourou', 'English');
INSERT INTO emkt_regions VALUES(582, 34, 'TAP', 'Tapoa', 'English');
INSERT INTO emkt_regions VALUES(583, 34, 'TUI', 'Tui', 'English');
INSERT INTO emkt_regions VALUES(584, 34, 'YAG', 'Yagha', 'English');
INSERT INTO emkt_regions VALUES(585, 34, 'YAT', 'Yatenga', 'English');
INSERT INTO emkt_regions VALUES(586, 34, 'ZIR', 'Ziro', 'English');
INSERT INTO emkt_regions VALUES(587, 34, 'ZON', 'Zondoma', 'English');
INSERT INTO emkt_regions VALUES(588, 34, 'ZOU', 'Zoundwéogo', 'English');

INSERT INTO emkt_countries VALUES (35,'Burundi','English','BI','BDI','');

INSERT INTO emkt_regions VALUES(589, 35, 'BB', 'Bubanza', 'English');
INSERT INTO emkt_regions VALUES(590, 35, 'BJ', 'Bujumbura Mairie', 'English');
INSERT INTO emkt_regions VALUES(591, 35, 'BR', 'Bururi', 'English');
INSERT INTO emkt_regions VALUES(592, 35, 'CA', 'Cankuzo', 'English');
INSERT INTO emkt_regions VALUES(593, 35, 'CI', 'Cibitoke', 'English');
INSERT INTO emkt_regions VALUES(594, 35, 'GI', 'Gitega', 'English');
INSERT INTO emkt_regions VALUES(595, 35, 'KR', 'Karuzi', 'English');
INSERT INTO emkt_regions VALUES(596, 35, 'KY', 'Kayanza', 'English');
INSERT INTO emkt_regions VALUES(597, 35, 'KI', 'Kirundo', 'English');
INSERT INTO emkt_regions VALUES(598, 35, 'MA', 'Makamba', 'English');
INSERT INTO emkt_regions VALUES(599, 35, 'MU', 'Muramvya', 'English');
INSERT INTO emkt_regions VALUES(600, 35, 'MY', 'Muyinga', 'English');
INSERT INTO emkt_regions VALUES(601, 35, 'MW', 'Mwaro', 'English');
INSERT INTO emkt_regions VALUES(602, 35, 'NG', 'Ngozi', 'English');
INSERT INTO emkt_regions VALUES(603, 35, 'RT', 'Rutana', 'English');
INSERT INTO emkt_regions VALUES(604, 35, 'RY', 'Ruyigi', 'English');

INSERT INTO emkt_countries VALUES (36,'Cambodia','English','KH','KHM','');

INSERT INTO emkt_regions VALUES(4255, 36, 'NOCODE', 'Cambodia', 'English');

INSERT INTO emkt_countries VALUES (37,'Cameroon','English','CM','CMR','');

INSERT INTO emkt_regions VALUES(605, 37, 'AD', 'Adamaoua', 'English');
INSERT INTO emkt_regions VALUES(606, 37, 'CE', 'Centre', 'English');
INSERT INTO emkt_regions VALUES(607, 37, 'EN', 'Extrême-Nord', 'English');
INSERT INTO emkt_regions VALUES(608, 37, 'ES', 'Est', 'English');
INSERT INTO emkt_regions VALUES(609, 37, 'LT', 'Littoral', 'English');
INSERT INTO emkt_regions VALUES(610, 37, 'NO', 'Nord', 'English');
INSERT INTO emkt_regions VALUES(611, 37, 'NW', 'Nord-Ouest', 'English');
INSERT INTO emkt_regions VALUES(612, 37, 'OU', 'Ouest', 'English');
INSERT INTO emkt_regions VALUES(613, 37, 'SU', 'Sud', 'English');
INSERT INTO emkt_regions VALUES(614, 37, 'SW', 'Sud-Ouest', 'English');

INSERT INTO emkt_countries VALUES (38,'Canada','English','CA','CAN','');

INSERT INTO emkt_regions VALUES(615, 38, 'AB', 'Alberta', 'English');
INSERT INTO emkt_regions VALUES(616, 38, 'BC', 'British Columbia', 'English');
INSERT INTO emkt_regions VALUES(617, 38, 'MB', 'Manitoba', 'English');
INSERT INTO emkt_regions VALUES(618, 38, 'NB', 'New Brunswick', 'English');
INSERT INTO emkt_regions VALUES(619, 38, 'NL', 'Newfoundland and Labrador', 'English');
INSERT INTO emkt_regions VALUES(620, 38, 'NS', 'Nova Scotia', 'English');
INSERT INTO emkt_regions VALUES(621, 38, 'NT', 'Northwest Territories', 'English');
INSERT INTO emkt_regions VALUES(622, 38, 'NU', 'Nunavut', 'English');
INSERT INTO emkt_regions VALUES(623, 38, 'ON', 'Ontario', 'English');
INSERT INTO emkt_regions VALUES(624, 38, 'PE', 'Prince Edward Island', 'English');
INSERT INTO emkt_regions VALUES(625, 38, 'QC', 'Quebec', 'English');
INSERT INTO emkt_regions VALUES(626, 38, 'SK', 'Saskatchewan', 'English');
INSERT INTO emkt_regions VALUES(627, 38, 'YT', 'Yukon Territory', 'English');

INSERT INTO emkt_countries VALUES (39,'Cape Verde','English','CV','CPV','');

INSERT INTO emkt_regions VALUES(628, 39, 'BR', 'Brava', 'English');
INSERT INTO emkt_regions VALUES(629, 39, 'BV', 'Boa Vista', 'English');
INSERT INTO emkt_regions VALUES(630, 39, 'CA', 'Santa Catarina', 'English');
INSERT INTO emkt_regions VALUES(631, 39, 'CR', 'Santa Cruz', 'English');
INSERT INTO emkt_regions VALUES(632, 39, 'CS', 'Calheta de São Miguel', 'English');
INSERT INTO emkt_regions VALUES(633, 39, 'MA', 'Maio', 'English');
INSERT INTO emkt_regions VALUES(634, 39, 'MO', 'Mosteiros', 'English');
INSERT INTO emkt_regions VALUES(635, 39, 'PA', 'Paúl', 'English');
INSERT INTO emkt_regions VALUES(636, 39, 'PN', 'Porto Novo', 'English');
INSERT INTO emkt_regions VALUES(637, 39, 'PR', 'Praia', 'English');
INSERT INTO emkt_regions VALUES(638, 39, 'RG', 'Ribeira Grande', 'English');
INSERT INTO emkt_regions VALUES(639, 39, 'SD', 'São Domingos', 'English');
INSERT INTO emkt_regions VALUES(640, 39, 'SF', 'São Filipe', 'English');
INSERT INTO emkt_regions VALUES(641, 39, 'SL', 'Sal', 'English');
INSERT INTO emkt_regions VALUES(642, 39, 'SN', 'São Nicolau', 'English');
INSERT INTO emkt_regions VALUES(643, 39, 'SV', 'São Vicente', 'English');
INSERT INTO emkt_regions VALUES(644, 39, 'TA', 'Tarrafal', 'English');

INSERT INTO emkt_countries VALUES (40,'Cayman Islands','English','KY','CYM','');

INSERT INTO emkt_regions VALUES(645, 40, 'CR', 'Creek', 'English');
INSERT INTO emkt_regions VALUES(646, 40, 'EA', 'Eastern', 'English');
INSERT INTO emkt_regions VALUES(647, 40, 'MI', 'Midland', 'English');
INSERT INTO emkt_regions VALUES(648, 40, 'SO', 'South Town', 'English');
INSERT INTO emkt_regions VALUES(649, 40, 'SP', 'Spot Bay', 'English');
INSERT INTO emkt_regions VALUES(650, 40, 'ST', 'Stake Bay', 'English');
INSERT INTO emkt_regions VALUES(651, 40, 'WD', 'West End', 'English');
INSERT INTO emkt_regions VALUES(652, 40, 'WN', 'Western', 'English');

INSERT INTO emkt_countries VALUES (41,'Central African Republic','English','CF','CAF','');

INSERT INTO emkt_regions VALUES(653, 41, 'AC ', 'Ouham', 'English');
INSERT INTO emkt_regions VALUES(654, 41, 'BB ', 'Bamingui-Bangoran', 'English');
INSERT INTO emkt_regions VALUES(655, 41, 'BGF', 'Bangui', 'English');
INSERT INTO emkt_regions VALUES(656, 41, 'BK ', 'Basse-Kotto', 'English');
INSERT INTO emkt_regions VALUES(657, 41, 'HK ', 'Haute-Kotto', 'English');
INSERT INTO emkt_regions VALUES(658, 41, 'HM ', 'Haut-Mbomou', 'English');
INSERT INTO emkt_regions VALUES(659, 41, 'HS ', 'Mambéré-Kadéï', 'English');
INSERT INTO emkt_regions VALUES(660, 41, 'KB ', 'Nana-Grébizi', 'English');
INSERT INTO emkt_regions VALUES(661, 41, 'KG ', 'Kémo', 'English');
INSERT INTO emkt_regions VALUES(662, 41, 'LB ', 'Lobaye', 'English');
INSERT INTO emkt_regions VALUES(663, 41, 'MB ', 'Mbomou', 'English');
INSERT INTO emkt_regions VALUES(664, 41, 'MP ', 'Ombella-M\'Poko', 'English');
INSERT INTO emkt_regions VALUES(665, 41, 'NM ', 'Nana-Mambéré', 'English');
INSERT INTO emkt_regions VALUES(666, 41, 'OP ', 'Ouham-Pendé', 'English');
INSERT INTO emkt_regions VALUES(667, 41, 'SE ', 'Sangha-Mbaéré', 'English');
INSERT INTO emkt_regions VALUES(668, 41, 'UK ', 'Ouaka', 'English');
INSERT INTO emkt_regions VALUES(669, 41, 'VR ', 'Vakaga', 'English');

INSERT INTO emkt_countries VALUES (42,'Chad','English','TD','TCD','');

INSERT INTO emkt_regions VALUES(670, 42, 'BA ', 'Batha', 'English');
INSERT INTO emkt_regions VALUES(671, 42, 'BET', 'Borkou-Ennedi-Tibesti', 'English');
INSERT INTO emkt_regions VALUES(672, 42, 'BI ', 'Biltine', 'English');
INSERT INTO emkt_regions VALUES(673, 42, 'CB ', 'Chari-Baguirmi', 'English');
INSERT INTO emkt_regions VALUES(674, 42, 'GR ', 'Guéra', 'English');
INSERT INTO emkt_regions VALUES(675, 42, 'KA ', 'Kanem', 'English');
INSERT INTO emkt_regions VALUES(676, 42, 'LC ', 'Lac', 'English');
INSERT INTO emkt_regions VALUES(677, 42, 'LR ', 'Logone-Oriental', 'English');
INSERT INTO emkt_regions VALUES(678, 42, 'LO ', 'Logone-Occidental', 'English');
INSERT INTO emkt_regions VALUES(679, 42, 'MC ', 'Moyen-Chari', 'English');
INSERT INTO emkt_regions VALUES(680, 42, 'MK ', 'Mayo-Kébbi', 'English');
INSERT INTO emkt_regions VALUES(681, 42, 'OD ', 'Ouaddaï', 'English');
INSERT INTO emkt_regions VALUES(682, 42, 'SA ', 'Salamat', 'English');
INSERT INTO emkt_regions VALUES(683, 42, 'TA ', 'Tandjilé', 'English');

INSERT INTO emkt_countries VALUES (43,'Chile','English','CL','CHL','');

INSERT INTO emkt_regions VALUES(684, 43, 'AI', 'Aisén del General Carlos Ibañez', 'English');
INSERT INTO emkt_regions VALUES(685, 43, 'AN', 'Antofagasta', 'English');
INSERT INTO emkt_regions VALUES(686, 43, 'AR', 'La Araucanía', 'English');
INSERT INTO emkt_regions VALUES(687, 43, 'AT', 'Atacama', 'English');
INSERT INTO emkt_regions VALUES(688, 43, 'BI', 'Biobío', 'English');
INSERT INTO emkt_regions VALUES(689, 43, 'CO', 'Coquimbo', 'English');
INSERT INTO emkt_regions VALUES(690, 43, 'LI', 'Libertador Bernardo O\'Higgins', 'English');
INSERT INTO emkt_regions VALUES(691, 43, 'LL', 'Los Lagos', 'English');
INSERT INTO emkt_regions VALUES(692, 43, 'MA', 'Magallanes y de la Antartica', 'English');
INSERT INTO emkt_regions VALUES(693, 43, 'ML', 'Maule', 'English');
INSERT INTO emkt_regions VALUES(694, 43, 'RM', 'Metropolitana de Santiago', 'English');
INSERT INTO emkt_regions VALUES(695, 43, 'TA', 'Tarapacá', 'English');
INSERT INTO emkt_regions VALUES(696, 43, 'VS', 'Valparaíso', 'English');

INSERT INTO emkt_countries VALUES (44,'China','English','CN','CHN','');

INSERT INTO emkt_regions VALUES(697, 44, '11', '北京', 'English');
INSERT INTO emkt_regions VALUES(698, 44, '12', '天津', 'English');
INSERT INTO emkt_regions VALUES(699, 44, '13', '河北', 'English');
INSERT INTO emkt_regions VALUES(700, 44, '14', '山西', 'English');
INSERT INTO emkt_regions VALUES(701, 44, '15', '内蒙古自治区', 'English');
INSERT INTO emkt_regions VALUES(702, 44, '21', '辽宁', 'English');
INSERT INTO emkt_regions VALUES(703, 44, '22', '吉林', 'English');
INSERT INTO emkt_regions VALUES(704, 44, '23', '黑龙江省', 'English');
INSERT INTO emkt_regions VALUES(705, 44, '31', '上海', 'English');
INSERT INTO emkt_regions VALUES(706, 44, '32', '江苏', 'English');
INSERT INTO emkt_regions VALUES(707, 44, '33', '浙江', 'English');
INSERT INTO emkt_regions VALUES(708, 44, '34', '安徽', 'English');
INSERT INTO emkt_regions VALUES(709, 44, '35', '福建', 'English');
INSERT INTO emkt_regions VALUES(710, 44, '36', '江西', 'English');
INSERT INTO emkt_regions VALUES(711, 44, '37', '山东', 'English');
INSERT INTO emkt_regions VALUES(712, 44, '41', '河南', 'English');
INSERT INTO emkt_regions VALUES(713, 44, '42', '湖北', 'English');
INSERT INTO emkt_regions VALUES(714, 44, '43', '湖南', 'English');
INSERT INTO emkt_regions VALUES(715, 44, '44', '广东', 'English');
INSERT INTO emkt_regions VALUES(716, 44, '45', '广西壮族自治区', 'English');
INSERT INTO emkt_regions VALUES(717, 44, '46', '海南', 'English');
INSERT INTO emkt_regions VALUES(718, 44, '50', '重庆', 'English');
INSERT INTO emkt_regions VALUES(719, 44, '51', '四川', 'English');
INSERT INTO emkt_regions VALUES(720, 44, '52', '贵州', 'English');
INSERT INTO emkt_regions VALUES(721, 44, '53', '云南', 'English');
INSERT INTO emkt_regions VALUES(722, 44, '54', '西藏自治区', 'English');
INSERT INTO emkt_regions VALUES(723, 44, '61', '陕西', 'English');
INSERT INTO emkt_regions VALUES(724, 44, '62', '甘肃', 'English');
INSERT INTO emkt_regions VALUES(725, 44, '63', '青海', 'English');
INSERT INTO emkt_regions VALUES(726, 44, '64', '宁夏', 'English');
INSERT INTO emkt_regions VALUES(727, 44, '65', '新疆', 'English');
INSERT INTO emkt_regions VALUES(728, 44, '71', '臺灣', 'English');
INSERT INTO emkt_regions VALUES(729, 44, '91', '香港', 'English');
INSERT INTO emkt_regions VALUES(730, 44, '92', '澳門', 'English');

INSERT INTO emkt_countries VALUES (45,'Christmas Island','English','CX','CXR','');

INSERT INTO emkt_regions VALUES(4256, 45, 'NOCODE', 'Christmas Island', 'English');

INSERT INTO emkt_countries VALUES (46,'Cocos (Keeling) Islands','English','CC','CCK','');

INSERT INTO emkt_regions VALUES(731, 46, 'D', 'Direction Island', 'English');
INSERT INTO emkt_regions VALUES(732, 46, 'H', 'Home Island', 'English');
INSERT INTO emkt_regions VALUES(733, 46, 'O', 'Horsburgh Island', 'English');
INSERT INTO emkt_regions VALUES(734, 46, 'S', 'South Island', 'English');
INSERT INTO emkt_regions VALUES(735, 46, 'W', 'West Island', 'English');

INSERT INTO emkt_countries VALUES (47,'Colombia','English','CO','COL','');

INSERT INTO emkt_regions VALUES(736, 47, 'AMA', 'Amazonas', 'English');
INSERT INTO emkt_regions VALUES(737, 47, 'ANT', 'Antioquia', 'English');
INSERT INTO emkt_regions VALUES(738, 47, 'ARA', 'Arauca', 'English');
INSERT INTO emkt_regions VALUES(739, 47, 'ATL', 'Atlántico', 'English');
INSERT INTO emkt_regions VALUES(740, 47, 'BOL', 'Bolívar', 'English');
INSERT INTO emkt_regions VALUES(741, 47, 'BOY', 'Boyacá', 'English');
INSERT INTO emkt_regions VALUES(742, 47, 'CAL', 'Caldas', 'English');
INSERT INTO emkt_regions VALUES(743, 47, 'CAQ', 'Caquetá', 'English');
INSERT INTO emkt_regions VALUES(744, 47, 'CAS', 'Casanare', 'English');
INSERT INTO emkt_regions VALUES(745, 47, 'CAU', 'Cauca', 'English');
INSERT INTO emkt_regions VALUES(746, 47, 'CES', 'Cesar', 'English');
INSERT INTO emkt_regions VALUES(747, 47, 'CHO', 'Chocó', 'English');
INSERT INTO emkt_regions VALUES(748, 47, 'COR', 'Córdoba', 'English');
INSERT INTO emkt_regions VALUES(749, 47, 'CUN', 'Cundinamarca', 'English');
INSERT INTO emkt_regions VALUES(750, 47, 'DC', 'Bogotá Distrito Capital', 'English');
INSERT INTO emkt_regions VALUES(751, 47, 'GUA', 'Guainía', 'English');
INSERT INTO emkt_regions VALUES(752, 47, 'GUV', 'Guaviare', 'English');
INSERT INTO emkt_regions VALUES(753, 47, 'HUI', 'Huila', 'English');
INSERT INTO emkt_regions VALUES(754, 47, 'LAG', 'La Guajira', 'English');
INSERT INTO emkt_regions VALUES(755, 47, 'MAG', 'Magdalena', 'English');
INSERT INTO emkt_regions VALUES(756, 47, 'MET', 'Meta', 'English');
INSERT INTO emkt_regions VALUES(757, 47, 'NAR', 'Nariño', 'English');
INSERT INTO emkt_regions VALUES(758, 47, 'NSA', 'Norte de Santander', 'English');
INSERT INTO emkt_regions VALUES(759, 47, 'PUT', 'Putumayo', 'English');
INSERT INTO emkt_regions VALUES(760, 47, 'QUI', 'Quindío', 'English');
INSERT INTO emkt_regions VALUES(761, 47, 'RIS', 'Risaralda', 'English');
INSERT INTO emkt_regions VALUES(762, 47, 'SAN', 'Santander', 'English');
INSERT INTO emkt_regions VALUES(763, 47, 'SAP', 'San Andrés y Providencia', 'English');
INSERT INTO emkt_regions VALUES(764, 47, 'SUC', 'Sucre', 'English');
INSERT INTO emkt_regions VALUES(765, 47, 'TOL', 'Tolima', 'English');
INSERT INTO emkt_regions VALUES(766, 47, 'VAC', 'Valle del Cauca', 'English');
INSERT INTO emkt_regions VALUES(767, 47, 'VAU', 'Vaupés', 'English');
INSERT INTO emkt_regions VALUES(768, 47, 'VID', 'Vichada', 'English');

INSERT INTO emkt_countries VALUES (48,'Comoros','English','KM','COM','');

INSERT INTO emkt_regions VALUES(769, 48, 'A', 'Anjouan', 'English');
INSERT INTO emkt_regions VALUES(770, 48, 'G', 'Grande Comore', 'English');
INSERT INTO emkt_regions VALUES(771, 48, 'M', 'Mohéli', 'English');

INSERT INTO emkt_countries VALUES (49,'Congo','English','CG','COG','');

INSERT INTO emkt_regions VALUES(772, 49, 'BC', 'Congo-Central', 'English');
INSERT INTO emkt_regions VALUES(773, 49, 'BN', 'Bandundu', 'English');
INSERT INTO emkt_regions VALUES(774, 49, 'EQ', 'Équateur', 'English');
INSERT INTO emkt_regions VALUES(775, 49, 'KA', 'Katanga', 'English');
INSERT INTO emkt_regions VALUES(776, 49, 'KE', 'Kasai-Oriental', 'English');
INSERT INTO emkt_regions VALUES(777, 49, 'KN', 'Kinshasa', 'English');
INSERT INTO emkt_regions VALUES(778, 49, 'KW', 'Kasai-Occidental', 'English');
INSERT INTO emkt_regions VALUES(779, 49, 'MA', 'Maniema', 'English');
INSERT INTO emkt_regions VALUES(780, 49, 'NK', 'Nord-Kivu', 'English');
INSERT INTO emkt_regions VALUES(781, 49, 'OR', 'Orientale', 'English');
INSERT INTO emkt_regions VALUES(782, 49, 'SK', 'Sud-Kivu', 'English');

INSERT INTO emkt_countries VALUES (50,'Cook Islands','English','CK','COK','');

INSERT INTO emkt_regions VALUES(783, 50, 'PU', 'Pukapuka', 'English');
INSERT INTO emkt_regions VALUES(784, 50, 'RK', 'Rakahanga', 'English');
INSERT INTO emkt_regions VALUES(785, 50, 'MK', 'Manihiki', 'English');
INSERT INTO emkt_regions VALUES(786, 50, 'PE', 'Penrhyn', 'English');
INSERT INTO emkt_regions VALUES(787, 50, 'NI', 'Nassau Island', 'English');
INSERT INTO emkt_regions VALUES(788, 50, 'SU', 'Surwarrow', 'English');
INSERT INTO emkt_regions VALUES(789, 50, 'PA', 'Palmerston', 'English');
INSERT INTO emkt_regions VALUES(790, 50, 'AI', 'Aitutaki', 'English');
INSERT INTO emkt_regions VALUES(791, 50, 'MA', 'Manuae', 'English');
INSERT INTO emkt_regions VALUES(792, 50, 'TA', 'Takutea', 'English');
INSERT INTO emkt_regions VALUES(793, 50, 'MT', 'Mitiaro', 'English');
INSERT INTO emkt_regions VALUES(794, 50, 'AT', 'Atiu', 'English');
INSERT INTO emkt_regions VALUES(795, 50, 'MU', 'Mauke', 'English');
INSERT INTO emkt_regions VALUES(796, 50, 'RR', 'Rarotonga', 'English');
INSERT INTO emkt_regions VALUES(797, 50, 'MG', 'Mangaia', 'English');

INSERT INTO emkt_countries VALUES (51,'Costa Rica','English','CR','CRI','');

INSERT INTO emkt_regions VALUES(798, 51, 'A', 'Alajuela', 'English');
INSERT INTO emkt_regions VALUES(799, 51, 'C', 'Cartago', 'English');
INSERT INTO emkt_regions VALUES(800, 51, 'G', 'Guanacaste', 'English');
INSERT INTO emkt_regions VALUES(801, 51, 'H', 'Heredia', 'English');
INSERT INTO emkt_regions VALUES(802, 51, 'L', 'Limón', 'English');
INSERT INTO emkt_regions VALUES(803, 51, 'P', 'Puntarenas', 'English');
INSERT INTO emkt_regions VALUES(804, 51, 'SJ', 'San José', 'English');

INSERT INTO emkt_countries VALUES (52,'Cote D\'Ivoire','English','CI','CIV','');

INSERT INTO emkt_regions VALUES(805, 52, '01', 'Lagunes', 'English');
INSERT INTO emkt_regions VALUES(806, 52, '02', 'Haut-Sassandra', 'English');
INSERT INTO emkt_regions VALUES(807, 52, '03', 'Savanes', 'English');
INSERT INTO emkt_regions VALUES(808, 52, '04', 'Vallée du Bandama', 'English');
INSERT INTO emkt_regions VALUES(809, 52, '05', 'Moyen-Comoé', 'English');
INSERT INTO emkt_regions VALUES(810, 52, '06', 'Dix-Huit', 'English');
INSERT INTO emkt_regions VALUES(811, 52, '07', 'Lacs', 'English');
INSERT INTO emkt_regions VALUES(812, 52, '08', 'Zanzan', 'English');
INSERT INTO emkt_regions VALUES(813, 52, '09', 'Bas-Sassandra', 'English');
INSERT INTO emkt_regions VALUES(814, 52, '10', 'Denguélé', 'English');
INSERT INTO emkt_regions VALUES(815, 52, '11', 'N\'zi-Comoé', 'English');
INSERT INTO emkt_regions VALUES(816, 52, '12', 'Marahoué', 'English');
INSERT INTO emkt_regions VALUES(817, 52, '13', 'Sud-Comoé', 'English');
INSERT INTO emkt_regions VALUES(818, 52, '14', 'Worodouqou', 'English');
INSERT INTO emkt_regions VALUES(819, 52, '15', 'Sud-Bandama', 'English');
INSERT INTO emkt_regions VALUES(820, 52, '16', 'Agnébi', 'English');
INSERT INTO emkt_regions VALUES(821, 52, '17', 'Bafing', 'English');
INSERT INTO emkt_regions VALUES(822, 52, '18', 'Fromager', 'English');
INSERT INTO emkt_regions VALUES(823, 52, '19', 'Moyen-Cavally', 'English');

INSERT INTO emkt_countries VALUES (53,'Croatia','English','HR','HRV','');

INSERT INTO emkt_regions VALUES(824, 53, '01', 'Zagrebačka županija', 'English');
INSERT INTO emkt_regions VALUES(825, 53, '02', 'Krapinsko-zagorska županija', 'English');
INSERT INTO emkt_regions VALUES(826, 53, '03', 'Sisačko-moslavačka županija', 'English');
INSERT INTO emkt_regions VALUES(827, 53, '04', 'Karlovačka županija', 'English');
INSERT INTO emkt_regions VALUES(828, 53, '05', 'Varaždinska županija', 'English');
INSERT INTO emkt_regions VALUES(829, 53, '06', 'Koprivničko-križevačka županija', 'English');
INSERT INTO emkt_regions VALUES(830, 53, '07', 'Bjelovarsko-bilogorska županija', 'English');
INSERT INTO emkt_regions VALUES(831, 53, '08', 'Primorsko-goranska županija', 'English');
INSERT INTO emkt_regions VALUES(832, 53, '09', 'Ličko-senjska županija', 'English');
INSERT INTO emkt_regions VALUES(833, 53, '10', 'Virovitičko-podravska županija', 'English');
INSERT INTO emkt_regions VALUES(834, 53, '11', 'Požeško-slavonska županija', 'English');
INSERT INTO emkt_regions VALUES(835, 53, '12', 'Brodsko-posavska županija', 'English');
INSERT INTO emkt_regions VALUES(836, 53, '13', 'Zadarska županija', 'English');
INSERT INTO emkt_regions VALUES(837, 53, '14', 'Osječko-baranjska županija', 'English');
INSERT INTO emkt_regions VALUES(838, 53, '15', 'Šibensko-kninska županija', 'English');
INSERT INTO emkt_regions VALUES(839, 53, '16', 'Vukovarsko-srijemska županija', 'English');
INSERT INTO emkt_regions VALUES(840, 53, '17', 'Splitsko-dalmatinska županija', 'English');
INSERT INTO emkt_regions VALUES(841, 53, '18', 'Istarska županija', 'English');
INSERT INTO emkt_regions VALUES(842, 53, '19', 'Dubrovačko-neretvanska županija', 'English');
INSERT INTO emkt_regions VALUES(843, 53, '20', 'Međimurska županija', 'English');
INSERT INTO emkt_regions VALUES(844, 53, '21', 'Zagreb', 'English');

INSERT INTO emkt_countries VALUES (54,'Cuba','English','CU','CUB','');

INSERT INTO emkt_regions VALUES(845, 54, '01', 'Pinar del Río', 'English');
INSERT INTO emkt_regions VALUES(846, 54, '02', 'La Habana', 'English');
INSERT INTO emkt_regions VALUES(847, 54, '03', 'Ciudad de La Habana', 'English');
INSERT INTO emkt_regions VALUES(848, 54, '04', 'Matanzas', 'English');
INSERT INTO emkt_regions VALUES(849, 54, '05', 'Villa Clara', 'English');
INSERT INTO emkt_regions VALUES(850, 54, '06', 'Cienfuegos', 'English');
INSERT INTO emkt_regions VALUES(851, 54, '07', 'Sancti Spíritus', 'English');
INSERT INTO emkt_regions VALUES(852, 54, '08', 'Ciego de Ávila', 'English');
INSERT INTO emkt_regions VALUES(853, 54, '09', 'Camagüey', 'English');
INSERT INTO emkt_regions VALUES(854, 54, '10', 'Las Tunas', 'English');
INSERT INTO emkt_regions VALUES(855, 54, '11', 'Holguín', 'English');
INSERT INTO emkt_regions VALUES(856, 54, '12', 'Granma', 'English');
INSERT INTO emkt_regions VALUES(857, 54, '13', 'Santiago de Cuba', 'English');
INSERT INTO emkt_regions VALUES(858, 54, '14', 'Guantánamo', 'English');
INSERT INTO emkt_regions VALUES(859, 54, '99', 'Isla de la Juventud', 'English');

INSERT INTO emkt_countries VALUES (55,'Cyprus','English','CY','CYP','');

INSERT INTO emkt_regions VALUES(860, 55, '01', 'Κερύvεια', 'English');
INSERT INTO emkt_regions VALUES(861, 55, '02', 'Λευκωσία', 'English');
INSERT INTO emkt_regions VALUES(862, 55, '03', 'Αμμόχωστος', 'English');
INSERT INTO emkt_regions VALUES(863, 55, '04', 'Λάρνακα', 'English');
INSERT INTO emkt_regions VALUES(864, 55, '05', 'Λεμεσός', 'English');
INSERT INTO emkt_regions VALUES(865, 55, '06', 'Πάφος', 'English');

INSERT INTO emkt_countries VALUES (56,'Czech Republic','English','CZ','CZE','');

INSERT INTO emkt_regions VALUES(866, 56, 'JC', 'Jihočeský kraj', 'English');
INSERT INTO emkt_regions VALUES(867, 56, 'JM', 'Jihomoravský kraj', 'English');
INSERT INTO emkt_regions VALUES(868, 56, 'KA', 'Karlovarský kraj', 'English');
INSERT INTO emkt_regions VALUES(869, 56, 'VY', 'Vysočina kraj', 'English');
INSERT INTO emkt_regions VALUES(870, 56, 'KR', 'Královéhradecký kraj', 'English');
INSERT INTO emkt_regions VALUES(871, 56, 'LI', 'Liberecký kraj', 'English');
INSERT INTO emkt_regions VALUES(872, 56, 'MO', 'Moravskoslezský kraj', 'English');
INSERT INTO emkt_regions VALUES(873, 56, 'OL', 'Olomoucký kraj', 'English');
INSERT INTO emkt_regions VALUES(874, 56, 'PA', 'Pardubický kraj', 'English');
INSERT INTO emkt_regions VALUES(875, 56, 'PL', 'Plzeňský kraj', 'English');
INSERT INTO emkt_regions VALUES(876, 56, 'PR', 'Hlavní město Praha', 'English');
INSERT INTO emkt_regions VALUES(877, 56, 'ST', 'Středočeský kraj', 'English');
INSERT INTO emkt_regions VALUES(878, 56, 'US', 'Ústecký kraj', 'English');
INSERT INTO emkt_regions VALUES(879, 56, 'ZL', 'Zlínský kraj', 'English');

INSERT INTO emkt_countries VALUES (57,'Denmark','English','DK','DNK','');

INSERT INTO emkt_regions VALUES(880, 57, '040', 'Bornholms Regionskommune', 'English');
INSERT INTO emkt_regions VALUES(881, 57, '101', 'København', 'English');
INSERT INTO emkt_regions VALUES(882, 57, '147', 'Frederiksberg', 'English');
INSERT INTO emkt_regions VALUES(883, 57, '070', 'Århus Amt', 'English');
INSERT INTO emkt_regions VALUES(884, 57, '015', 'Københavns Amt', 'English');
INSERT INTO emkt_regions VALUES(885, 57, '020', 'Frederiksborg Amt', 'English');
INSERT INTO emkt_regions VALUES(886, 57, '042', 'Fyns Amt', 'English');
INSERT INTO emkt_regions VALUES(887, 57, '080', 'Nordjyllands Amt', 'English');
INSERT INTO emkt_regions VALUES(888, 57, '055', 'Ribe Amt', 'English');
INSERT INTO emkt_regions VALUES(889, 57, '065', 'Ringkjøbing Amt', 'English');
INSERT INTO emkt_regions VALUES(890, 57, '025', 'Roskilde Amt', 'English');
INSERT INTO emkt_regions VALUES(891, 57, '050', 'Sønderjyllands Amt', 'English');
INSERT INTO emkt_regions VALUES(892, 57, '035', 'Storstrøms Amt', 'English');
INSERT INTO emkt_regions VALUES(893, 57, '060', 'Vejle Amt', 'English');
INSERT INTO emkt_regions VALUES(894, 57, '030', 'Vestsjællands Amt', 'English');
INSERT INTO emkt_regions VALUES(895, 57, '076', 'Viborg Amt', 'English');

INSERT INTO emkt_countries VALUES (58,'Djibouti','English','DJ','DJI','');

INSERT INTO emkt_regions VALUES(896, 58, 'AS', 'Region d\'Ali Sabieh', 'English');
INSERT INTO emkt_regions VALUES(897, 58, 'AR', 'Region d\'Arta', 'English');
INSERT INTO emkt_regions VALUES(898, 58, 'DI', 'Region de Dikhil', 'English');
INSERT INTO emkt_regions VALUES(899, 58, 'DJ', 'Ville de Djibouti', 'English');
INSERT INTO emkt_regions VALUES(900, 58, 'OB', 'Region d\'Obock', 'English');
INSERT INTO emkt_regions VALUES(901, 58, 'TA', 'Region de Tadjourah', 'English');

INSERT INTO emkt_countries VALUES (59,'Dominica','English','DM','DMA','');

INSERT INTO emkt_regions VALUES(902, 59, 'AND', 'Saint Andrew Parish', 'English');
INSERT INTO emkt_regions VALUES(903, 59, 'DAV', 'Saint David Parish', 'English');
INSERT INTO emkt_regions VALUES(904, 59, 'GEO', 'Saint George Parish', 'English');
INSERT INTO emkt_regions VALUES(905, 59, 'JOH', 'Saint John Parish', 'English');
INSERT INTO emkt_regions VALUES(906, 59, 'JOS', 'Saint Joseph Parish', 'English');
INSERT INTO emkt_regions VALUES(907, 59, 'LUK', 'Saint Luke Parish', 'English');
INSERT INTO emkt_regions VALUES(908, 59, 'MAR', 'Saint Mark Parish', 'English');
INSERT INTO emkt_regions VALUES(909, 59, 'PAT', 'Saint Patrick Parish', 'English');
INSERT INTO emkt_regions VALUES(910, 59, 'PAU', 'Saint Paul Parish', 'English');
INSERT INTO emkt_regions VALUES(911, 59, 'PET', 'Saint Peter Parish', 'English');

INSERT INTO emkt_countries VALUES (60,'Dominican Republic','English','DO','DOM','');

INSERT INTO emkt_regions VALUES(912, 60, '01', 'Distrito Nacional', 'English');
INSERT INTO emkt_regions VALUES(913, 60, '02', 'Ázua', 'English');
INSERT INTO emkt_regions VALUES(914, 60, '03', 'Baoruco', 'English');
INSERT INTO emkt_regions VALUES(915, 60, '04', 'Barahona', 'English');
INSERT INTO emkt_regions VALUES(916, 60, '05', 'Dajabón', 'English');
INSERT INTO emkt_regions VALUES(917, 60, '06', 'Duarte', 'English');
INSERT INTO emkt_regions VALUES(918, 60, '07', 'Elías Piña', 'English');
INSERT INTO emkt_regions VALUES(919, 60, '08', 'El Seibo', 'English');
INSERT INTO emkt_regions VALUES(920, 60, '09', 'Espaillat', 'English');
INSERT INTO emkt_regions VALUES(921, 60, '10', 'Independencia', 'English');
INSERT INTO emkt_regions VALUES(922, 60, '11', 'La Altagracia', 'English');
INSERT INTO emkt_regions VALUES(923, 60, '12', 'La Romana', 'English');
INSERT INTO emkt_regions VALUES(924, 60, '13', 'La Vega', 'English');
INSERT INTO emkt_regions VALUES(925, 60, '14', 'María Trinidad Sánchez', 'English');
INSERT INTO emkt_regions VALUES(926, 60, '15', 'Monte Cristi', 'English');
INSERT INTO emkt_regions VALUES(927, 60, '16', 'Pedernales', 'English');
INSERT INTO emkt_regions VALUES(928, 60, '17', 'Peravia', 'English');
INSERT INTO emkt_regions VALUES(929, 60, '18', 'Puerto Plata', 'English');
INSERT INTO emkt_regions VALUES(930, 60, '19', 'Salcedo', 'English');
INSERT INTO emkt_regions VALUES(931, 60, '20', 'Samaná', 'English');
INSERT INTO emkt_regions VALUES(932, 60, '21', 'San Cristóbal', 'English');
INSERT INTO emkt_regions VALUES(933, 60, '22', 'San Juan', 'English');
INSERT INTO emkt_regions VALUES(934, 60, '23', 'San Pedro de Macorís', 'English');
INSERT INTO emkt_regions VALUES(935, 60, '24', 'Sánchez Ramírez', 'English');
INSERT INTO emkt_regions VALUES(936, 60, '25', 'Santiago', 'English');
INSERT INTO emkt_regions VALUES(937, 60, '26', 'Santiago Rodríguez', 'English');
INSERT INTO emkt_regions VALUES(938, 60, '27', 'Valverde', 'English');
INSERT INTO emkt_regions VALUES(939, 60, '28', 'Monseñor Nouel', 'English');
INSERT INTO emkt_regions VALUES(940, 60, '29', 'Monte Plata', 'English');
INSERT INTO emkt_regions VALUES(941, 60, '30', 'Hato Mayor', 'English');

INSERT INTO emkt_countries VALUES (61,'East Timor','English','TP','TMP','');

INSERT INTO emkt_regions VALUES(942, 61, 'AL', 'Aileu', 'English');
INSERT INTO emkt_regions VALUES(943, 61, 'AN', 'Ainaro', 'English');
INSERT INTO emkt_regions VALUES(944, 61, 'BA', 'Baucau', 'English');
INSERT INTO emkt_regions VALUES(945, 61, 'BO', 'Bobonaro', 'English');
INSERT INTO emkt_regions VALUES(946, 61, 'CO', 'Cova-Lima', 'English');
INSERT INTO emkt_regions VALUES(947, 61, 'DI', 'Dili', 'English');
INSERT INTO emkt_regions VALUES(948, 61, 'ER', 'Ermera', 'English');
INSERT INTO emkt_regions VALUES(949, 61, 'LA', 'Lautem', 'English');
INSERT INTO emkt_regions VALUES(950, 61, 'LI', 'Liquiçá', 'English');
INSERT INTO emkt_regions VALUES(951, 61, 'MF', 'Manufahi', 'English');
INSERT INTO emkt_regions VALUES(952, 61, 'MT', 'Manatuto', 'English');
INSERT INTO emkt_regions VALUES(953, 61, 'OE', 'Oecussi', 'English');
INSERT INTO emkt_regions VALUES(954, 61, 'VI', 'Viqueque', 'English');

INSERT INTO emkt_countries VALUES (62,'Ecuador','English','EC','ECU','');

INSERT INTO emkt_regions VALUES(955, 62, 'A', 'Azuay', 'English');
INSERT INTO emkt_regions VALUES(956, 62, 'B', 'Bolívar', 'English');
INSERT INTO emkt_regions VALUES(957, 62, 'C', 'Carchi', 'English');
INSERT INTO emkt_regions VALUES(958, 62, 'D', 'Orellana', 'English');
INSERT INTO emkt_regions VALUES(959, 62, 'E', 'Esmeraldas', 'English');
INSERT INTO emkt_regions VALUES(960, 62, 'F', 'Cañar', 'English');
INSERT INTO emkt_regions VALUES(961, 62, 'G', 'Guayas', 'English');
INSERT INTO emkt_regions VALUES(962, 62, 'H', 'Chimborazo', 'English');
INSERT INTO emkt_regions VALUES(963, 62, 'I', 'Imbabura', 'English');
INSERT INTO emkt_regions VALUES(964, 62, 'L', 'Loja', 'English');
INSERT INTO emkt_regions VALUES(965, 62, 'M', 'Manabí', 'English');
INSERT INTO emkt_regions VALUES(966, 62, 'N', 'Napo', 'English');
INSERT INTO emkt_regions VALUES(967, 62, 'O', 'El Oro', 'English');
INSERT INTO emkt_regions VALUES(968, 62, 'P', 'Pichincha', 'English');
INSERT INTO emkt_regions VALUES(969, 62, 'R', 'Los Ríos', 'English');
INSERT INTO emkt_regions VALUES(970, 62, 'S', 'Morona-Santiago', 'English');
INSERT INTO emkt_regions VALUES(971, 62, 'T', 'Tungurahua', 'English');
INSERT INTO emkt_regions VALUES(972, 62, 'U', 'Sucumbíos', 'English');
INSERT INTO emkt_regions VALUES(973, 62, 'W', 'Galápagos', 'English');
INSERT INTO emkt_regions VALUES(974, 62, 'X', 'Cotopaxi', 'English');
INSERT INTO emkt_regions VALUES(975, 62, 'Y', 'Pastaza', 'English');
INSERT INTO emkt_regions VALUES(976, 62, 'Z', 'Zamora-Chinchipe', 'English');

INSERT INTO emkt_countries VALUES (63,'Egypt','English','EG','EGY','');

INSERT INTO emkt_regions VALUES(977, 63, 'ALX', 'الإسكندرية', 'English');
INSERT INTO emkt_regions VALUES(978, 63, 'ASN', 'أسوان', 'English');
INSERT INTO emkt_regions VALUES(979, 63, 'AST', 'أسيوط', 'English');
INSERT INTO emkt_regions VALUES(980, 63, 'BA', 'البحر الأحمر', 'English');
INSERT INTO emkt_regions VALUES(981, 63, 'BH', 'البحيرة', 'English');
INSERT INTO emkt_regions VALUES(982, 63, 'BNS', 'بني سويف', 'English');
INSERT INTO emkt_regions VALUES(983, 63, 'C', 'القاهرة', 'English');
INSERT INTO emkt_regions VALUES(984, 63, 'DK', 'الدقهلية', 'English');
INSERT INTO emkt_regions VALUES(985, 63, 'DT', 'دمياط', 'English');
INSERT INTO emkt_regions VALUES(986, 63, 'FYM', 'الفيوم', 'English');
INSERT INTO emkt_regions VALUES(987, 63, 'GH', 'الغربية', 'English');
INSERT INTO emkt_regions VALUES(988, 63, 'GZ', 'الجيزة', 'English');
INSERT INTO emkt_regions VALUES(989, 63, 'IS', 'الإسماعيلية', 'English');
INSERT INTO emkt_regions VALUES(990, 63, 'JS', 'جنوب سيناء', 'English');
INSERT INTO emkt_regions VALUES(991, 63, 'KB', 'القليوبية', 'English');
INSERT INTO emkt_regions VALUES(992, 63, 'KFS', 'كفر الشيخ', 'English');
INSERT INTO emkt_regions VALUES(993, 63, 'KN', 'قنا', 'English');
INSERT INTO emkt_regions VALUES(994, 63, 'MN', 'محافظة المنيا', 'English');
INSERT INTO emkt_regions VALUES(995, 63, 'MNF', 'المنوفية', 'English');
INSERT INTO emkt_regions VALUES(996, 63, 'MT', 'مطروح', 'English');
INSERT INTO emkt_regions VALUES(997, 63, 'PTS', 'محافظة بور سعيد', 'English');
INSERT INTO emkt_regions VALUES(998, 63, 'SHG', 'محافظة سوهاج', 'English');
INSERT INTO emkt_regions VALUES(999, 63, 'SHR', 'المحافظة الشرقيّة', 'English');
INSERT INTO emkt_regions VALUES(1000, 63, 'SIN', 'شمال سيناء', 'English');
INSERT INTO emkt_regions VALUES(1001, 63, 'SUZ', 'السويس', 'English');
INSERT INTO emkt_regions VALUES(1002, 63, 'WAD', 'الوادى الجديد', 'English');

INSERT INTO emkt_countries VALUES (64,'El Salvador','English','SV','SLV','');

INSERT INTO emkt_regions VALUES(1003, 64, 'AH', 'Ahuachapán', 'English');
INSERT INTO emkt_regions VALUES(1004, 64, 'CA', 'Cabañas', 'English');
INSERT INTO emkt_regions VALUES(1005, 64, 'CH', 'Chalatenango', 'English');
INSERT INTO emkt_regions VALUES(1006, 64, 'CU', 'Cuscatlán', 'English');
INSERT INTO emkt_regions VALUES(1007, 64, 'LI', 'La Libertad', 'English');
INSERT INTO emkt_regions VALUES(1008, 64, 'MO', 'Morazán', 'English');
INSERT INTO emkt_regions VALUES(1009, 64, 'PA', 'La Paz', 'English');
INSERT INTO emkt_regions VALUES(1010, 64, 'SA', 'Santa Ana', 'English');
INSERT INTO emkt_regions VALUES(1011, 64, 'SM', 'San Miguel', 'English');
INSERT INTO emkt_regions VALUES(1012, 64, 'SO', 'Sonsonate', 'English');
INSERT INTO emkt_regions VALUES(1013, 64, 'SS', 'San Salvador', 'English');
INSERT INTO emkt_regions VALUES(1014, 64, 'SV', 'San Vicente', 'English');
INSERT INTO emkt_regions VALUES(1015, 64, 'UN', 'La Unión', 'English');
INSERT INTO emkt_regions VALUES(1016, 64, 'US', 'Usulután', 'English');

INSERT INTO emkt_countries VALUES (65,'Equatorial Guinea','English','GQ','GNQ','');

INSERT INTO emkt_regions VALUES(1017, 65, 'AN', 'Annobón', 'English');
INSERT INTO emkt_regions VALUES(1018, 65, 'BN', 'Bioko Norte', 'English');
INSERT INTO emkt_regions VALUES(1019, 65, 'BS', 'Bioko Sur', 'English');
INSERT INTO emkt_regions VALUES(1020, 65, 'CS', 'Centro Sur', 'English');
INSERT INTO emkt_regions VALUES(1021, 65, 'KN', 'Kié-Ntem', 'English');
INSERT INTO emkt_regions VALUES(1022, 65, 'LI', 'Litoral', 'English');
INSERT INTO emkt_regions VALUES(1023, 65, 'WN', 'Wele-Nzas', 'English');

INSERT INTO emkt_countries VALUES (66,'Eritrea','English','ER','ERI','');

INSERT INTO emkt_regions VALUES(1024, 66, 'AN', 'Zoba Anseba', 'English');
INSERT INTO emkt_regions VALUES(1025, 66, 'DK', 'Zoba Debubawi Keyih Bahri', 'English');
INSERT INTO emkt_regions VALUES(1026, 66, 'DU', 'Zoba Debub', 'English');
INSERT INTO emkt_regions VALUES(1027, 66, 'GB', 'Zoba Gash-Barka', 'English');
INSERT INTO emkt_regions VALUES(1028, 66, 'MA', 'Zoba Ma\'akel', 'English');
INSERT INTO emkt_regions VALUES(1029, 66, 'SK', 'Zoba Semienawi Keyih Bahri', 'English');

INSERT INTO emkt_countries VALUES (67,'Estonia','English','EE','EST','');

INSERT INTO emkt_regions VALUES(1030, 67, '37', 'Harju maakond', 'English');
INSERT INTO emkt_regions VALUES(1031, 67, '39', 'Hiiu maakond', 'English');
INSERT INTO emkt_regions VALUES(1032, 67, '44', 'Ida-Viru maakond', 'English');
INSERT INTO emkt_regions VALUES(1033, 67, '49', 'Jõgeva maakond', 'English');
INSERT INTO emkt_regions VALUES(1034, 67, '51', 'Järva maakond', 'English');
INSERT INTO emkt_regions VALUES(1035, 67, '57', 'Lääne maakond', 'English');
INSERT INTO emkt_regions VALUES(1036, 67, '59', 'Lääne-Viru maakond', 'English');
INSERT INTO emkt_regions VALUES(1037, 67, '65', 'Põlva maakond', 'English');
INSERT INTO emkt_regions VALUES(1038, 67, '67', 'Pärnu maakond', 'English');
INSERT INTO emkt_regions VALUES(1039, 67, '70', 'Rapla maakond', 'English');
INSERT INTO emkt_regions VALUES(1040, 67, '74', 'Saare maakond', 'English');
INSERT INTO emkt_regions VALUES(1041, 67, '78', 'Tartu maakond', 'English');
INSERT INTO emkt_regions VALUES(1042, 67, '82', 'Valga maakond', 'English');
INSERT INTO emkt_regions VALUES(1043, 67, '84', 'Viljandi maakond', 'English');
INSERT INTO emkt_regions VALUES(1044, 67, '86', 'Võru maakond', 'English');

INSERT INTO emkt_countries VALUES (68,'Ethiopia','English','ET','ETH','');

INSERT INTO emkt_regions VALUES(1045, 68, 'AA', 'አዲስ አበባ', 'English');
INSERT INTO emkt_regions VALUES(1046, 68, 'AF', 'አፋር', 'English');
INSERT INTO emkt_regions VALUES(1047, 68, 'AH', 'አማራ', 'English');
INSERT INTO emkt_regions VALUES(1048, 68, 'BG', 'ቤንሻንጉል-ጉምዝ', 'English');
INSERT INTO emkt_regions VALUES(1049, 68, 'DD', 'ድሬዳዋ', 'English');
INSERT INTO emkt_regions VALUES(1050, 68, 'GB', 'ጋምቤላ ሕዝቦች', 'English');
INSERT INTO emkt_regions VALUES(1051, 68, 'HR', 'ሀረሪ ሕዝብ', 'English');
INSERT INTO emkt_regions VALUES(1052, 68, 'OR', 'ኦሮሚያ', 'English');
INSERT INTO emkt_regions VALUES(1053, 68, 'SM', 'ሶማሌ', 'English');
INSERT INTO emkt_regions VALUES(1054, 68, 'SN', 'ደቡብ ብሔሮች ብሔረሰቦችና ሕዝቦች', 'English');
INSERT INTO emkt_regions VALUES(1055, 68, 'TG', 'ትግራይ', 'English');

INSERT INTO emkt_countries VALUES (69,'Falkland Islands (Malvinas)','English','FK','FLK','');

INSERT INTO emkt_regions VALUES(4257, 69, 'NOCODE', 'Falkland Islands (Malvinas)', 'English');

INSERT INTO emkt_countries VALUES (70,'Faroe Islands','English','FO','FRO','');

INSERT INTO emkt_regions VALUES(4258, 70, 'NOCODE', 'Faroe Islands', 'English');

INSERT INTO emkt_countries VALUES (71,'Fiji','English','FJ','FJI','');

INSERT INTO emkt_regions VALUES(1056, 71, 'C', 'Central', 'English');
INSERT INTO emkt_regions VALUES(1057, 71, 'E', 'Northern', 'English');
INSERT INTO emkt_regions VALUES(1058, 71, 'N', 'Eastern', 'English');
INSERT INTO emkt_regions VALUES(1059, 71, 'R', 'Rotuma', 'English');
INSERT INTO emkt_regions VALUES(1060, 71, 'W', 'Western', 'English');

INSERT INTO emkt_countries VALUES (72,'Finland','English','FI','FIN','');

INSERT INTO emkt_regions VALUES(1061, 72, 'AL', 'Ahvenanmaan maakunta', 'English');
INSERT INTO emkt_regions VALUES(1062, 72, 'ES', 'Etelä-Suomen lääni', 'English');
INSERT INTO emkt_regions VALUES(1063, 72, 'IS', 'Itä-Suomen lääni', 'English');
INSERT INTO emkt_regions VALUES(1064, 72, 'LL', 'Lapin lääni', 'English');
INSERT INTO emkt_regions VALUES(1065, 72, 'LS', 'Länsi-Suomen lääni', 'English');
INSERT INTO emkt_regions VALUES(1066, 72, 'OL', 'Oulun lääni', 'English');

INSERT INTO emkt_countries VALUES (73,'France','English','FR','FRA','');

INSERT INTO emkt_regions VALUES(1067, 73, '01', 'Ain', 'English');
INSERT INTO emkt_regions VALUES(1068, 73, '02', 'Aisne', 'English');
INSERT INTO emkt_regions VALUES(1069, 73, '03', 'Allier', 'English');
INSERT INTO emkt_regions VALUES(1070, 73, '04', 'Alpes-de-Haute-Provence', 'English');
INSERT INTO emkt_regions VALUES(1071, 73, '05', 'Hautes-Alpes', 'English');
INSERT INTO emkt_regions VALUES(1072, 73, '06', 'Alpes-Maritimes', 'English');
INSERT INTO emkt_regions VALUES(1073, 73, '07', 'Ardèche', 'English');
INSERT INTO emkt_regions VALUES(1074, 73, '08', 'Ardennes', 'English');
INSERT INTO emkt_regions VALUES(1075, 73, '09', 'Ariège', 'English');
INSERT INTO emkt_regions VALUES(1076, 73, '10', 'Aube', 'English');
INSERT INTO emkt_regions VALUES(1077, 73, '11', 'Aude', 'English');
INSERT INTO emkt_regions VALUES(1078, 73, '12', 'Aveyron', 'English');
INSERT INTO emkt_regions VALUES(1079, 73, '13', 'Bouches-du-Rhône', 'English');
INSERT INTO emkt_regions VALUES(1080, 73, '14', 'Calvados', 'English');
INSERT INTO emkt_regions VALUES(1081, 73, '15', 'Cantal', 'English');
INSERT INTO emkt_regions VALUES(1082, 73, '16', 'Charente', 'English');
INSERT INTO emkt_regions VALUES(1083, 73, '17', 'Charente-Maritime', 'English');
INSERT INTO emkt_regions VALUES(1084, 73, '18', 'Cher', 'English');
INSERT INTO emkt_regions VALUES(1085, 73, '19', 'Corrèze', 'English');
INSERT INTO emkt_regions VALUES(1086, 73, '21', 'Côte-d\'Or', 'English');
INSERT INTO emkt_regions VALUES(1087, 73, '22', 'Côtes-d\'Armor', 'English');
INSERT INTO emkt_regions VALUES(1088, 73, '23', 'Creuse', 'English');
INSERT INTO emkt_regions VALUES(1089, 73, '24', 'Dordogne', 'English');
INSERT INTO emkt_regions VALUES(1090, 73, '25', 'Doubs', 'English');
INSERT INTO emkt_regions VALUES(1091, 73, '26', 'Drôme', 'English');
INSERT INTO emkt_regions VALUES(1092, 73, '27', 'Eure', 'English');
INSERT INTO emkt_regions VALUES(1093, 73, '28', 'Eure-et-Loir', 'English');
INSERT INTO emkt_regions VALUES(1094, 73, '29', 'Finistère', 'English');
INSERT INTO emkt_regions VALUES(1095, 73, '2A', 'Corse-du-Sud', 'English');
INSERT INTO emkt_regions VALUES(1096, 73, '2B', 'Haute-Corse', 'English');
INSERT INTO emkt_regions VALUES(1097, 73, '30', 'Gard', 'English');
INSERT INTO emkt_regions VALUES(1098, 73, '31', 'Haute-Garonne', 'English');
INSERT INTO emkt_regions VALUES(1099, 73, '32', 'Gers', 'English');
INSERT INTO emkt_regions VALUES(1100, 73, '33', 'Gironde', 'English');
INSERT INTO emkt_regions VALUES(1101, 73, '34', 'Hérault', 'English');
INSERT INTO emkt_regions VALUES(1102, 73, '35', 'Ille-et-Vilaine', 'English');
INSERT INTO emkt_regions VALUES(1103, 73, '36', 'Indre', 'English');
INSERT INTO emkt_regions VALUES(1104, 73, '37', 'Indre-et-Loire', 'English');
INSERT INTO emkt_regions VALUES(1105, 73, '38', 'Isère', 'English');
INSERT INTO emkt_regions VALUES(1106, 73, '39', 'Jura', 'English');
INSERT INTO emkt_regions VALUES(1107, 73, '40', 'Landes', 'English');
INSERT INTO emkt_regions VALUES(1108, 73, '41', 'Loir-et-Cher', 'English');
INSERT INTO emkt_regions VALUES(1109, 73, '42', 'Loire', 'English');
INSERT INTO emkt_regions VALUES(1110, 73, '43', 'Haute-Loire', 'English');
INSERT INTO emkt_regions VALUES(1111, 73, '44', 'Loire-Atlantique', 'English');
INSERT INTO emkt_regions VALUES(1112, 73, '45', 'Loiret', 'English');
INSERT INTO emkt_regions VALUES(1113, 73, '46', 'Lot', 'English');
INSERT INTO emkt_regions VALUES(1114, 73, '47', 'Lot-et-Garonne', 'English');
INSERT INTO emkt_regions VALUES(1115, 73, '48', 'Lozère', 'English');
INSERT INTO emkt_regions VALUES(1116, 73, '49', 'Maine-et-Loire', 'English');
INSERT INTO emkt_regions VALUES(1117, 73, '50', 'Manche', 'English');
INSERT INTO emkt_regions VALUES(1118, 73, '51', 'Marne', 'English');
INSERT INTO emkt_regions VALUES(1119, 73, '52', 'Haute-Marne', 'English');
INSERT INTO emkt_regions VALUES(1120, 73, '53', 'Mayenne', 'English');
INSERT INTO emkt_regions VALUES(1121, 73, '54', 'Meurthe-et-Moselle', 'English');
INSERT INTO emkt_regions VALUES(1122, 73, '55', 'Meuse', 'English');
INSERT INTO emkt_regions VALUES(1123, 73, '56', 'Morbihan', 'English');
INSERT INTO emkt_regions VALUES(1124, 73, '57', 'Moselle', 'English');
INSERT INTO emkt_regions VALUES(1125, 73, '58', 'Nièvre', 'English');
INSERT INTO emkt_regions VALUES(1126, 73, '59', 'Nord', 'English');
INSERT INTO emkt_regions VALUES(1127, 73, '60', 'Oise', 'English');
INSERT INTO emkt_regions VALUES(1128, 73, '61', 'Orne', 'English');
INSERT INTO emkt_regions VALUES(1129, 73, '62', 'Pas-de-Calais', 'English');
INSERT INTO emkt_regions VALUES(1130, 73, '63', 'Puy-de-Dôme', 'English');
INSERT INTO emkt_regions VALUES(1131, 73, '64', 'Pyrénées-Atlantiques', 'English');
INSERT INTO emkt_regions VALUES(1132, 73, '65', 'Hautes-Pyrénées', 'English');
INSERT INTO emkt_regions VALUES(1133, 73, '66', 'Pyrénées-Orientales', 'English');
INSERT INTO emkt_regions VALUES(1134, 73, '67', 'Bas-Rhin', 'English');
INSERT INTO emkt_regions VALUES(1135, 73, '68', 'Haut-Rhin', 'English');
INSERT INTO emkt_regions VALUES(1136, 73, '69', 'Rhône', 'English');
INSERT INTO emkt_regions VALUES(1137, 73, '70', 'Haute-Saône', 'English');
INSERT INTO emkt_regions VALUES(1138, 73, '71', 'Saône-et-Loire', 'English');
INSERT INTO emkt_regions VALUES(1139, 73, '72', 'Sarthe', 'English');
INSERT INTO emkt_regions VALUES(1140, 73, '73', 'Savoie', 'English');
INSERT INTO emkt_regions VALUES(1141, 73, '74', 'Haute-Savoie', 'English');
INSERT INTO emkt_regions VALUES(1142, 73, '75', 'Paris', 'English');
INSERT INTO emkt_regions VALUES(1143, 73, '76', 'Seine-Maritime', 'English');
INSERT INTO emkt_regions VALUES(1144, 73, '77', 'Seine-et-Marne', 'English');
INSERT INTO emkt_regions VALUES(1145, 73, '78', 'Yvelines', 'English');
INSERT INTO emkt_regions VALUES(1146, 73, '79', 'Deux-Sèvres', 'English');
INSERT INTO emkt_regions VALUES(1147, 73, '80', 'Somme', 'English');
INSERT INTO emkt_regions VALUES(1148, 73, '81', 'Tarn', 'English');
INSERT INTO emkt_regions VALUES(1149, 73, '82', 'Tarn-et-Garonne', 'English');
INSERT INTO emkt_regions VALUES(1150, 73, '83', 'Var', 'English');
INSERT INTO emkt_regions VALUES(1151, 73, '84', 'Vaucluse', 'English');
INSERT INTO emkt_regions VALUES(1152, 73, '85', 'Vendée', 'English');
INSERT INTO emkt_regions VALUES(1153, 73, '86', 'Vienne', 'English');
INSERT INTO emkt_regions VALUES(1154, 73, '87', 'Haute-Vienne', 'English');
INSERT INTO emkt_regions VALUES(1155, 73, '88', 'Vosges', 'English');
INSERT INTO emkt_regions VALUES(1156, 73, '89', 'Yonne', 'English');
INSERT INTO emkt_regions VALUES(1157, 73, '90', 'Territoire de Belfort', 'English');
INSERT INTO emkt_regions VALUES(1158, 73, '91', 'Essonne', 'English');
INSERT INTO emkt_regions VALUES(1159, 73, '92', 'Hauts-de-Seine', 'English');
INSERT INTO emkt_regions VALUES(1160, 73, '93', 'Seine-Saint-Denis', 'English');
INSERT INTO emkt_regions VALUES(1161, 73, '94', 'Val-de-Marne', 'English');
INSERT INTO emkt_regions VALUES(1162, 73, '95', 'Val-d\'Oise', 'English');
INSERT INTO emkt_regions VALUES(1163, 73, 'NC', 'Territoire des Nouvelle-Calédonie et Dependances', 'English');
INSERT INTO emkt_regions VALUES(1164, 73, 'PF', 'Polynésie Française', 'English');
INSERT INTO emkt_regions VALUES(1165, 73, 'PM', 'Saint-Pierre et Miquelon', 'English');
INSERT INTO emkt_regions VALUES(1166, 73, 'TF', 'Terres australes et antarctiques françaises', 'English');
INSERT INTO emkt_regions VALUES(1167, 73, 'YT', 'Mayotte', 'English');
INSERT INTO emkt_regions VALUES(1168, 73, 'WF', 'Territoire des îles Wallis et Futuna', 'English');

INSERT INTO emkt_countries VALUES (74,'French Guiana','English','GF','GUF','');

INSERT INTO emkt_regions VALUES(4259, 74, 'NOCODE', 'French Guiana', 'English');

INSERT INTO emkt_countries VALUES (75,'French Polynesia','English','PF','PYF','');

INSERT INTO emkt_regions VALUES(1169, 75, 'M', 'Archipel des Marquises', 'English');
INSERT INTO emkt_regions VALUES(1170, 75, 'T', 'Archipel des Tuamotu', 'English');
INSERT INTO emkt_regions VALUES(1171, 75, 'I', 'Archipel des Tubuai', 'English');
INSERT INTO emkt_regions VALUES(1172, 75, 'V', 'Iles du Vent', 'English');
INSERT INTO emkt_regions VALUES(1173, 75, 'S', 'Iles Sous-le-Vent', 'English');

INSERT INTO emkt_countries VALUES (76,'French Southern Territories','English','TF','ATF','');

INSERT INTO emkt_regions VALUES(1174, 76, 'C', 'Iles Crozet', 'English');
INSERT INTO emkt_regions VALUES(1175, 76, 'K', 'Iles Kerguelen', 'English');
INSERT INTO emkt_regions VALUES(1176, 76, 'A', 'Ile Amsterdam', 'English');
INSERT INTO emkt_regions VALUES(1177, 76, 'P', 'Ile Saint-Paul', 'English');
INSERT INTO emkt_regions VALUES(1178, 76, 'D', 'Adelie Land', 'English');

INSERT INTO emkt_countries VALUES (77,'Gabon','English','GA','GAB','');

INSERT INTO emkt_regions VALUES(1179, 77, 'ES', 'Estuaire', 'English');
INSERT INTO emkt_regions VALUES(1180, 77, 'HO', 'Haut-Ogooue', 'English');
INSERT INTO emkt_regions VALUES(1181, 77, 'MO', 'Moyen-Ogooue', 'English');
INSERT INTO emkt_regions VALUES(1182, 77, 'NG', 'Ngounie', 'English');
INSERT INTO emkt_regions VALUES(1183, 77, 'NY', 'Nyanga', 'English');
INSERT INTO emkt_regions VALUES(1184, 77, 'OI', 'Ogooue-Ivindo', 'English');
INSERT INTO emkt_regions VALUES(1185, 77, 'OL', 'Ogooue-Lolo', 'English');
INSERT INTO emkt_regions VALUES(1186, 77, 'OM', 'Ogooue-Maritime', 'English');
INSERT INTO emkt_regions VALUES(1187, 77, 'WN', 'Woleu-Ntem', 'English');

INSERT INTO emkt_countries VALUES (78,'Gambia','English','GM','GMB','');

INSERT INTO emkt_regions VALUES(1188, 78, 'AH', 'Ashanti', 'English');
INSERT INTO emkt_regions VALUES(1189, 78, 'BA', 'Brong-Ahafo', 'English');
INSERT INTO emkt_regions VALUES(1190, 78, 'CP', 'Central', 'English');
INSERT INTO emkt_regions VALUES(1191, 78, 'EP', 'Eastern', 'English');
INSERT INTO emkt_regions VALUES(1192, 78, 'AA', 'Greater Accra', 'English');
INSERT INTO emkt_regions VALUES(1193, 78, 'NP', 'Northern', 'English');
INSERT INTO emkt_regions VALUES(1194, 78, 'UE', 'Upper East', 'English');
INSERT INTO emkt_regions VALUES(1195, 78, 'UW', 'Upper West', 'English');
INSERT INTO emkt_regions VALUES(1196, 78, 'TV', 'Volta', 'English');
INSERT INTO emkt_regions VALUES(1197, 78, 'WP', 'Western', 'English');

INSERT INTO emkt_countries VALUES (79,'Georgia','English','GE','GEO','');

INSERT INTO emkt_regions VALUES(1198, 79, 'AB', 'აფხაზეთი', 'English');
INSERT INTO emkt_regions VALUES(1199, 79, 'AJ', 'აჭარა', 'English');
INSERT INTO emkt_regions VALUES(1200, 79, 'GU', 'გურია', 'English');
INSERT INTO emkt_regions VALUES(1201, 79, 'IM', 'იმერეთი', 'English');
INSERT INTO emkt_regions VALUES(1202, 79, 'KA', 'კახეთი', 'English');
INSERT INTO emkt_regions VALUES(1203, 79, 'KK', 'ქვემო ქართლი', 'English');
INSERT INTO emkt_regions VALUES(1204, 79, 'MM', 'მცხეთა-მთიანეთი', 'English');
INSERT INTO emkt_regions VALUES(1205, 79, 'RL', 'რაჭა-ლეჩხუმი და ქვემო სვანეთი', 'English');
INSERT INTO emkt_regions VALUES(1206, 79, 'SJ', 'სამცხე-ჯავახეთი', 'English');
INSERT INTO emkt_regions VALUES(1207, 79, 'SK', 'შიდა ქართლი', 'English');
INSERT INTO emkt_regions VALUES(1208, 79, 'SZ', 'სამეგრელო-ზემო სვანეთი', 'English');
INSERT INTO emkt_regions VALUES(1209, 79, 'TB', 'თბილისი', 'English');

INSERT INTO emkt_countries VALUES (80,'Germany','English','DE','DEU','');

INSERT INTO emkt_regions VALUES(1210, 80, 'BE', 'Berlin', 'English');
INSERT INTO emkt_regions VALUES(1211, 80, 'BR', 'Brandenburg', 'English');
INSERT INTO emkt_regions VALUES(1212, 80, 'BW', 'Baden-Württemberg', 'English');
INSERT INTO emkt_regions VALUES(1213, 80, 'BY', 'Bayern', 'English');
INSERT INTO emkt_regions VALUES(1214, 80, 'HB', 'Bremen', 'English');
INSERT INTO emkt_regions VALUES(1215, 80, 'HE', 'Hessen', 'English');
INSERT INTO emkt_regions VALUES(1216, 80, 'HH', 'Hamburg', 'English');
INSERT INTO emkt_regions VALUES(1217, 80, 'MV', 'Mecklenburg-Vorpommern', 'English');
INSERT INTO emkt_regions VALUES(1218, 80, 'NI', 'Niedersachsen', 'English');
INSERT INTO emkt_regions VALUES(1219, 80, 'NW', 'Nordrhein-Westfalen', 'English');
INSERT INTO emkt_regions VALUES(1220, 80, 'RP', 'Rheinland-Pfalz', 'English');
INSERT INTO emkt_regions VALUES(1221, 80, 'SH', 'Schleswig-Holstein', 'English');
INSERT INTO emkt_regions VALUES(1222, 80, 'SL', 'Saarland', 'English');
INSERT INTO emkt_regions VALUES(1223, 80, 'SN', 'Sachsen', 'English');
INSERT INTO emkt_regions VALUES(1224, 80, 'ST', 'Sachsen-Anhalt', 'English');
INSERT INTO emkt_regions VALUES(1225, 80, 'TH', 'Thüringen', 'English');

INSERT INTO emkt_countries VALUES (81,'Ghana','English','GH','GHA','');

INSERT INTO emkt_regions VALUES(1226, 81, 'AA', 'Greater Accra', 'English');
INSERT INTO emkt_regions VALUES(1227, 81, 'AH', 'Ashanti', 'English');
INSERT INTO emkt_regions VALUES(1228, 81, 'BA', 'Brong-Ahafo', 'English');
INSERT INTO emkt_regions VALUES(1229, 81, 'CP', 'Central', 'English');
INSERT INTO emkt_regions VALUES(1230, 81, 'EP', 'Eastern', 'English');
INSERT INTO emkt_regions VALUES(1231, 81, 'NP', 'Northern', 'English');
INSERT INTO emkt_regions VALUES(1232, 81, 'TV', 'Volta', 'English');
INSERT INTO emkt_regions VALUES(1233, 81, 'UE', 'Upper East', 'English');
INSERT INTO emkt_regions VALUES(1234, 81, 'UW', 'Upper West', 'English');
INSERT INTO emkt_regions VALUES(1235, 81, 'WP', 'Western', 'English');

INSERT INTO emkt_countries VALUES (82,'Gibraltar','English','GI','GIB','');

INSERT INTO emkt_regions VALUES(4260, 82, 'NOCODE', 'Gibraltar', 'English');

INSERT INTO emkt_countries VALUES (83,'Greece','English','GR','GRC','');

INSERT INTO emkt_regions VALUES(1236, 83, '01', 'Αιτωλοακαρνανία', 'English');
INSERT INTO emkt_regions VALUES(1237, 83, '03', 'Βοιωτία', 'English');
INSERT INTO emkt_regions VALUES(1238, 83, '04', 'Εύβοια', 'English');
INSERT INTO emkt_regions VALUES(1239, 83, '05', 'Ευρυτανία', 'English');
INSERT INTO emkt_regions VALUES(1240, 83, '06', 'Φθιώτιδα', 'English');
INSERT INTO emkt_regions VALUES(1241, 83, '07', 'Φωκίδα', 'English');
INSERT INTO emkt_regions VALUES(1242, 83, '11', 'Αργολίδα', 'English');
INSERT INTO emkt_regions VALUES(1243, 83, '12', 'Αρκαδία', 'English');
INSERT INTO emkt_regions VALUES(1244, 83, '13', 'Ἀχαΐα', 'English');
INSERT INTO emkt_regions VALUES(1245, 83, '14', 'Ηλεία', 'English');
INSERT INTO emkt_regions VALUES(1246, 83, '15', 'Κορινθία', 'English');
INSERT INTO emkt_regions VALUES(1247, 83, '16', 'Λακωνία', 'English');
INSERT INTO emkt_regions VALUES(1248, 83, '17', 'Μεσσηνία', 'English');
INSERT INTO emkt_regions VALUES(1249, 83, '21', 'Ζάκυνθος', 'English');
INSERT INTO emkt_regions VALUES(1250, 83, '22', 'Κέρκυρα', 'English');
INSERT INTO emkt_regions VALUES(1251, 83, '23', 'Κεφαλλονιά', 'English');
INSERT INTO emkt_regions VALUES(1252, 83, '24', 'Λευκάδα', 'English');
INSERT INTO emkt_regions VALUES(1253, 83, '31', 'Άρτα', 'English');
INSERT INTO emkt_regions VALUES(1254, 83, '32', 'Θεσπρωτία', 'English');
INSERT INTO emkt_regions VALUES(1255, 83, '33', 'Ιωάννινα', 'English');
INSERT INTO emkt_regions VALUES(1256, 83, '34', 'Πρεβεζα', 'English');
INSERT INTO emkt_regions VALUES(1257, 83, '41', 'Καρδίτσα', 'English');
INSERT INTO emkt_regions VALUES(1258, 83, '42', 'Λάρισα', 'English');
INSERT INTO emkt_regions VALUES(1259, 83, '43', 'Μαγνησία', 'English');
INSERT INTO emkt_regions VALUES(1260, 83, '44', 'Τρίκαλα', 'English');
INSERT INTO emkt_regions VALUES(1261, 83, '51', 'Γρεβενά', 'English');
INSERT INTO emkt_regions VALUES(1262, 83, '52', 'Δράμα', 'English');
INSERT INTO emkt_regions VALUES(1263, 83, '53', 'Ημαθία', 'English');
INSERT INTO emkt_regions VALUES(1264, 83, '54', 'Θεσσαλονίκη', 'English');
INSERT INTO emkt_regions VALUES(1265, 83, '55', 'Καβάλα', 'English');
INSERT INTO emkt_regions VALUES(1266, 83, '56', 'Καστοριά', 'English');
INSERT INTO emkt_regions VALUES(1267, 83, '57', 'Κιλκίς', 'English');
INSERT INTO emkt_regions VALUES(1268, 83, '58', 'Κοζάνη', 'English');
INSERT INTO emkt_regions VALUES(1269, 83, '59', 'Πέλλα', 'English');
INSERT INTO emkt_regions VALUES(1270, 83, '61', 'Πιερία', 'English');
INSERT INTO emkt_regions VALUES(1271, 83, '62', 'Σερρών', 'English');
INSERT INTO emkt_regions VALUES(1272, 83, '63', 'Φλώρινα', 'English');
INSERT INTO emkt_regions VALUES(1273, 83, '64', 'Χαλκιδική', 'English');
INSERT INTO emkt_regions VALUES(1274, 83, '69', 'Όρος Άθως', 'English');
INSERT INTO emkt_regions VALUES(1275, 83, '71', 'Έβρος', 'English');
INSERT INTO emkt_regions VALUES(1276, 83, '72', 'Ξάνθη', 'English');
INSERT INTO emkt_regions VALUES(1277, 83, '73', 'Ροδόπη', 'English');
INSERT INTO emkt_regions VALUES(1278, 83, '81', 'Δωδεκάνησα', 'English');
INSERT INTO emkt_regions VALUES(1279, 83, '82', 'Κυκλάδες', 'English');
INSERT INTO emkt_regions VALUES(1280, 83, '83', 'Λέσβου', 'English');
INSERT INTO emkt_regions VALUES(1281, 83, '84', 'Σάμος', 'English');
INSERT INTO emkt_regions VALUES(1282, 83, '85', 'Χίος', 'English');
INSERT INTO emkt_regions VALUES(1283, 83, '91', 'Ηράκλειο', 'English');
INSERT INTO emkt_regions VALUES(1284, 83, '92', 'Λασίθι', 'English');
INSERT INTO emkt_regions VALUES(1285, 83, '93', 'Ρεθύμνο', 'English');
INSERT INTO emkt_regions VALUES(1286, 83, '94', 'Χανίων', 'English');
INSERT INTO emkt_regions VALUES(1287, 83, 'A1', 'Αττική', 'English');

INSERT INTO emkt_countries VALUES (84,'Greenland','English','GL','GRL','');

INSERT INTO emkt_regions VALUES(1288, 84, 'A', 'Avannaa', 'English');
INSERT INTO emkt_regions VALUES(1289, 84, 'T', 'Tunu ', 'English');
INSERT INTO emkt_regions VALUES(1290, 84, 'K', 'Kitaa', 'English');

INSERT INTO emkt_countries VALUES (85,'Grenada','English','GD','GRD','');

INSERT INTO emkt_regions VALUES(1291, 85, 'A', 'Saint Andrew', 'English');
INSERT INTO emkt_regions VALUES(1292, 85, 'D', 'Saint David', 'English');
INSERT INTO emkt_regions VALUES(1293, 85, 'G', 'Saint George', 'English');
INSERT INTO emkt_regions VALUES(1294, 85, 'J', 'Saint John', 'English');
INSERT INTO emkt_regions VALUES(1295, 85, 'M', 'Saint Mark', 'English');
INSERT INTO emkt_regions VALUES(1296, 85, 'P', 'Saint Patrick', 'English');

INSERT INTO emkt_countries VALUES (86,'Guadeloupe','English','GP','GLP','');

INSERT INTO emkt_regions VALUES(4261, 86, 'NOCODE', 'Guadeloupe', 'English');

INSERT INTO emkt_countries VALUES (87,'Guam','English','GU','GUM','');

INSERT INTO emkt_regions VALUES(4262, 87, 'NOCODE', 'Guam', 'English');

INSERT INTO emkt_countries VALUES (88,'Guatemala','English','GT','GTM','');

INSERT INTO emkt_regions VALUES(1297, 88, 'AV', 'Alta Verapaz', 'English');
INSERT INTO emkt_regions VALUES(1298, 88, 'BV', 'Baja Verapaz', 'English');
INSERT INTO emkt_regions VALUES(1299, 88, 'CM', 'Chimaltenango', 'English');
INSERT INTO emkt_regions VALUES(1300, 88, 'CQ', 'Chiquimula', 'English');
INSERT INTO emkt_regions VALUES(1301, 88, 'ES', 'Escuintla', 'English');
INSERT INTO emkt_regions VALUES(1302, 88, 'GU', 'Guatemala', 'English');
INSERT INTO emkt_regions VALUES(1303, 88, 'HU', 'Huehuetenango', 'English');
INSERT INTO emkt_regions VALUES(1304, 88, 'IZ', 'Izabal', 'English');
INSERT INTO emkt_regions VALUES(1305, 88, 'JA', 'Jalapa', 'English');
INSERT INTO emkt_regions VALUES(1306, 88, 'JU', 'Jutiapa', 'English');
INSERT INTO emkt_regions VALUES(1307, 88, 'PE', 'El Petén', 'English');
INSERT INTO emkt_regions VALUES(1308, 88, 'PR', 'El Progreso', 'English');
INSERT INTO emkt_regions VALUES(1309, 88, 'QC', 'El Quiché', 'English');
INSERT INTO emkt_regions VALUES(1310, 88, 'QZ', 'Quetzaltenango', 'English');
INSERT INTO emkt_regions VALUES(1311, 88, 'RE', 'Retalhuleu', 'English');
INSERT INTO emkt_regions VALUES(1312, 88, 'SA', 'Sacatepéquez', 'English');
INSERT INTO emkt_regions VALUES(1313, 88, 'SM', 'San Marcos', 'English');
INSERT INTO emkt_regions VALUES(1314, 88, 'SO', 'Sololá', 'English');
INSERT INTO emkt_regions VALUES(1315, 88, 'SR', 'Santa Rosa', 'English');
INSERT INTO emkt_regions VALUES(1316, 88, 'SU', 'Suchitepéquez', 'English');
INSERT INTO emkt_regions VALUES(1317, 88, 'TO', 'Totonicapán', 'English');
INSERT INTO emkt_regions VALUES(1318, 88, 'ZA', 'Zacapa', 'English');

INSERT INTO emkt_countries VALUES (89,'Guinea','English','GN','GIN','');

INSERT INTO emkt_regions VALUES(1319, 89, 'BE', 'Beyla', 'English');
INSERT INTO emkt_regions VALUES(1320, 89, 'BF', 'Boffa', 'English');
INSERT INTO emkt_regions VALUES(1321, 89, 'BK', 'Boké', 'English');
INSERT INTO emkt_regions VALUES(1322, 89, 'CO', 'Coyah', 'English');
INSERT INTO emkt_regions VALUES(1323, 89, 'DB', 'Dabola', 'English');
INSERT INTO emkt_regions VALUES(1324, 89, 'DI', 'Dinguiraye', 'English');
INSERT INTO emkt_regions VALUES(1325, 89, 'DL', 'Dalaba', 'English');
INSERT INTO emkt_regions VALUES(1326, 89, 'DU', 'Dubréka', 'English');
INSERT INTO emkt_regions VALUES(1327, 89, 'FA', 'Faranah', 'English');
INSERT INTO emkt_regions VALUES(1328, 89, 'FO', 'Forécariah', 'English');
INSERT INTO emkt_regions VALUES(1329, 89, 'FR', 'Fria', 'English');
INSERT INTO emkt_regions VALUES(1330, 89, 'GA', 'Gaoual', 'English');
INSERT INTO emkt_regions VALUES(1331, 89, 'GU', 'Guékédou', 'English');
INSERT INTO emkt_regions VALUES(1332, 89, 'KA', 'Kankan', 'English');
INSERT INTO emkt_regions VALUES(1333, 89, 'KB', 'Koubia', 'English');
INSERT INTO emkt_regions VALUES(1334, 89, 'KD', 'Kindia', 'English');
INSERT INTO emkt_regions VALUES(1335, 89, 'KE', 'Kérouané', 'English');
INSERT INTO emkt_regions VALUES(1336, 89, 'KN', 'Koundara', 'English');
INSERT INTO emkt_regions VALUES(1337, 89, 'KO', 'Kouroussa', 'English');
INSERT INTO emkt_regions VALUES(1338, 89, 'KS', 'Kissidougou', 'English');
INSERT INTO emkt_regions VALUES(1339, 89, 'LA', 'Labé', 'English');
INSERT INTO emkt_regions VALUES(1340, 89, 'LE', 'Lélouma', 'English');
INSERT INTO emkt_regions VALUES(1341, 89, 'LO', 'Lola', 'English');
INSERT INTO emkt_regions VALUES(1342, 89, 'MC', 'Macenta', 'English');
INSERT INTO emkt_regions VALUES(1343, 89, 'MD', 'Mandiana', 'English');
INSERT INTO emkt_regions VALUES(1344, 89, 'ML', 'Mali', 'English');
INSERT INTO emkt_regions VALUES(1345, 89, 'MM', 'Mamou', 'English');
INSERT INTO emkt_regions VALUES(1346, 89, 'NZ', 'Nzérékoré', 'English');
INSERT INTO emkt_regions VALUES(1347, 89, 'PI', 'Pita', 'English');
INSERT INTO emkt_regions VALUES(1348, 89, 'SI', 'Siguiri', 'English');
INSERT INTO emkt_regions VALUES(1349, 89, 'TE', 'Télimélé', 'English');
INSERT INTO emkt_regions VALUES(1350, 89, 'TO', 'Tougué', 'English');
INSERT INTO emkt_regions VALUES(1351, 89, 'YO', 'Yomou', 'English');

INSERT INTO emkt_countries VALUES (90,'Guinea-Bissau','English','GW','GNB','');

INSERT INTO emkt_regions VALUES(1352, 90, 'BF', 'Bafata', 'English');
INSERT INTO emkt_regions VALUES(1353, 90, 'BB', 'Biombo', 'English');
INSERT INTO emkt_regions VALUES(1354, 90, 'BS', 'Bissau', 'English');
INSERT INTO emkt_regions VALUES(1355, 90, 'BL', 'Bolama', 'English');
INSERT INTO emkt_regions VALUES(1356, 90, 'CA', 'Cacheu', 'English');
INSERT INTO emkt_regions VALUES(1357, 90, 'GA', 'Gabu', 'English');
INSERT INTO emkt_regions VALUES(1358, 90, 'OI', 'Oio', 'English');
INSERT INTO emkt_regions VALUES(1359, 90, 'QU', 'Quinara', 'English');
INSERT INTO emkt_regions VALUES(1360, 90, 'TO', 'Tombali', 'English');

INSERT INTO emkt_countries VALUES (91,'Guyana','English','GY','GUY','');

INSERT INTO emkt_regions VALUES(1361, 91, 'BA', 'Barima-Waini', 'English');
INSERT INTO emkt_regions VALUES(1362, 91, 'CU', 'Cuyuni-Mazaruni', 'English');
INSERT INTO emkt_regions VALUES(1363, 91, 'DE', 'Demerara-Mahaica', 'English');
INSERT INTO emkt_regions VALUES(1364, 91, 'EB', 'East Berbice-Corentyne', 'English');
INSERT INTO emkt_regions VALUES(1365, 91, 'ES', 'Essequibo Islands-West Demerara', 'English');
INSERT INTO emkt_regions VALUES(1366, 91, 'MA', 'Mahaica-Berbice', 'English');
INSERT INTO emkt_regions VALUES(1367, 91, 'PM', 'Pomeroon-Supenaam', 'English');
INSERT INTO emkt_regions VALUES(1368, 91, 'PT', 'Potaro-Siparuni', 'English');
INSERT INTO emkt_regions VALUES(1369, 91, 'UD', 'Upper Demerara-Berbice', 'English');
INSERT INTO emkt_regions VALUES(1370, 91, 'UT', 'Upper Takutu-Upper Essequibo', 'English');

INSERT INTO emkt_countries VALUES (92,'Haiti','English','HT','HTI','');

INSERT INTO emkt_regions VALUES(1371, 92, 'AR', 'Artibonite', 'English');
INSERT INTO emkt_regions VALUES(1372, 92, 'CE', 'Centre', 'English');
INSERT INTO emkt_regions VALUES(1373, 92, 'GA', 'Grand\'Anse', 'English');
INSERT INTO emkt_regions VALUES(1374, 92, 'NI', 'Nippes', 'English');
INSERT INTO emkt_regions VALUES(1375, 92, 'ND', 'Nord', 'English');
INSERT INTO emkt_regions VALUES(1376, 92, 'NE', 'Nord-Est', 'English');
INSERT INTO emkt_regions VALUES(1377, 92, 'NO', 'Nord-Ouest', 'English');
INSERT INTO emkt_regions VALUES(1378, 92, 'OU', 'Ouest', 'English');
INSERT INTO emkt_regions VALUES(1379, 92, 'SD', 'Sud', 'English');
INSERT INTO emkt_regions VALUES(1380, 92, 'SE', 'Sud-Est', 'English');

INSERT INTO emkt_countries VALUES (93,'Heard and McDonald Islands','English','HM','HMD','');

INSERT INTO emkt_regions VALUES(1381, 93, 'F', 'Flat Island', 'English');
INSERT INTO emkt_regions VALUES(1382, 93, 'M', 'McDonald Island', 'English');
INSERT INTO emkt_regions VALUES(1383, 93, 'S', 'Shag Island', 'English');
INSERT INTO emkt_regions VALUES(1384, 93, 'H', 'Heard Island', 'English');

INSERT INTO emkt_countries VALUES (94,'Honduras','English','HN','HND','');

INSERT INTO emkt_regions VALUES(1385, 94, 'AT', 'Atlántida', 'English');
INSERT INTO emkt_regions VALUES(1386, 94, 'CH', 'Choluteca', 'English');
INSERT INTO emkt_regions VALUES(1387, 94, 'CL', 'Colón', 'English');
INSERT INTO emkt_regions VALUES(1388, 94, 'CM', 'Comayagua', 'English');
INSERT INTO emkt_regions VALUES(1389, 94, 'CP', 'Copán', 'English');
INSERT INTO emkt_regions VALUES(1390, 94, 'CR', 'Cortés', 'English');
INSERT INTO emkt_regions VALUES(1391, 94, 'EP', 'El Paraíso', 'English');
INSERT INTO emkt_regions VALUES(1392, 94, 'FM', 'Francisco Morazán', 'English');
INSERT INTO emkt_regions VALUES(1393, 94, 'GD', 'Gracias a Dios', 'English');
INSERT INTO emkt_regions VALUES(1394, 94, 'IB', 'Islas de la Bahía', 'English');
INSERT INTO emkt_regions VALUES(1395, 94, 'IN', 'Intibucá', 'English');
INSERT INTO emkt_regions VALUES(1396, 94, 'LE', 'Lempira', 'English');
INSERT INTO emkt_regions VALUES(1397, 94, 'LP', 'La Paz', 'English');
INSERT INTO emkt_regions VALUES(1398, 94, 'OC', 'Ocotepeque', 'English');
INSERT INTO emkt_regions VALUES(1399, 94, 'OL', 'Olancho', 'English');
INSERT INTO emkt_regions VALUES(1400, 94, 'SB', 'Santa Bárbara', 'English');
INSERT INTO emkt_regions VALUES(1401, 94, 'VA', 'Valle', 'English');
INSERT INTO emkt_regions VALUES(1402, 94, 'YO', 'Yoro', 'English');

INSERT INTO emkt_countries VALUES (95,'Hong Kong','English','HK','HKG','');

INSERT INTO emkt_regions VALUES(1403, 95, 'HCW', '中西區', 'English');
INSERT INTO emkt_regions VALUES(1404, 95, 'HEA', '東區', 'English');
INSERT INTO emkt_regions VALUES(1405, 95, 'HSO', '南區', 'English');
INSERT INTO emkt_regions VALUES(1406, 95, 'HWC', '灣仔區', 'English');
INSERT INTO emkt_regions VALUES(1407, 95, 'KKC', '九龍城區', 'English');
INSERT INTO emkt_regions VALUES(1408, 95, 'KKT', '觀塘區', 'English');
INSERT INTO emkt_regions VALUES(1409, 95, 'KSS', '深水埗區', 'English');
INSERT INTO emkt_regions VALUES(1410, 95, 'KWT', '黃大仙區', 'English');
INSERT INTO emkt_regions VALUES(1411, 95, 'KYT', '油尖旺區', 'English');
INSERT INTO emkt_regions VALUES(1412, 95, 'NIS', '離島區', 'English');
INSERT INTO emkt_regions VALUES(1413, 95, 'NKT', '葵青區', 'English');
INSERT INTO emkt_regions VALUES(1414, 95, 'NNO', '北區', 'English');
INSERT INTO emkt_regions VALUES(1415, 95, 'NSK', '西貢區', 'English');
INSERT INTO emkt_regions VALUES(1416, 95, 'NST', '沙田區', 'English');
INSERT INTO emkt_regions VALUES(1417, 95, 'NTP', '大埔區', 'English');
INSERT INTO emkt_regions VALUES(1418, 95, 'NTW', '荃灣區', 'English');
INSERT INTO emkt_regions VALUES(1419, 95, 'NTM', '屯門區', 'English');
INSERT INTO emkt_regions VALUES(1420, 95, 'NYL', '元朗區', 'English');

INSERT INTO emkt_countries VALUES (96,'Hungary','English','HU','HUN','');

INSERT INTO emkt_regions VALUES(1421, 96, 'BA', 'Baranja megye', 'English');
INSERT INTO emkt_regions VALUES(1422, 96, 'BC', 'Békéscsaba', 'English');
INSERT INTO emkt_regions VALUES(1423, 96, 'BE', 'Békés megye', 'English');
INSERT INTO emkt_regions VALUES(1424, 96, 'BK', 'Bács-Kiskun megye', 'English');
INSERT INTO emkt_regions VALUES(1425, 96, 'BU', 'Budapest', 'English');
INSERT INTO emkt_regions VALUES(1426, 96, 'BZ', 'Borsod-Abaúj-Zemplén megye', 'English');
INSERT INTO emkt_regions VALUES(1427, 96, 'CS', 'Csongrád megye', 'English');
INSERT INTO emkt_regions VALUES(1428, 96, 'DE', 'Debrecen', 'English');
INSERT INTO emkt_regions VALUES(1429, 96, 'DU', 'Dunaújváros', 'English');
INSERT INTO emkt_regions VALUES(1430, 96, 'EG', 'Eger', 'English');
INSERT INTO emkt_regions VALUES(1431, 96, 'FE', 'Fejér megye', 'English');
INSERT INTO emkt_regions VALUES(1432, 96, 'GS', 'Győr-Moson-Sopron megye', 'English');
INSERT INTO emkt_regions VALUES(1433, 96, 'GY', 'Győr', 'English');
INSERT INTO emkt_regions VALUES(1434, 96, 'HB', 'Hajdú-Bihar megye', 'English');
INSERT INTO emkt_regions VALUES(1435, 96, 'HE', 'Heves megye', 'English');
INSERT INTO emkt_regions VALUES(1436, 96, 'HV', 'Hódmezővásárhely', 'English');
INSERT INTO emkt_regions VALUES(1437, 96, 'JN', 'Jász-Nagykun-Szolnok megye', 'English');
INSERT INTO emkt_regions VALUES(1438, 96, 'KE', 'Komárom-Esztergom megye', 'English');
INSERT INTO emkt_regions VALUES(1439, 96, 'KM', 'Kecskemét', 'English');
INSERT INTO emkt_regions VALUES(1440, 96, 'KV', 'Kaposvár', 'English');
INSERT INTO emkt_regions VALUES(1441, 96, 'MI', 'Miskolc', 'English');
INSERT INTO emkt_regions VALUES(1442, 96, 'NK', 'Nagykanizsa', 'English');
INSERT INTO emkt_regions VALUES(1443, 96, 'NO', 'Nógrád megye', 'English');
INSERT INTO emkt_regions VALUES(1444, 96, 'NY', 'Nyíregyháza', 'English');
INSERT INTO emkt_regions VALUES(1445, 96, 'PE', 'Pest megye', 'English');
INSERT INTO emkt_regions VALUES(1446, 96, 'PS', 'Pécs', 'English');
INSERT INTO emkt_regions VALUES(1447, 96, 'SD', 'Szeged', 'English');
INSERT INTO emkt_regions VALUES(1448, 96, 'SF', 'Székesfehérvár', 'English');
INSERT INTO emkt_regions VALUES(1449, 96, 'SH', 'Szombathely', 'English');
INSERT INTO emkt_regions VALUES(1450, 96, 'SK', 'Szolnok', 'English');
INSERT INTO emkt_regions VALUES(1451, 96, 'SN', 'Sopron', 'English');
INSERT INTO emkt_regions VALUES(1452, 96, 'SO', 'Somogy megye', 'English');
INSERT INTO emkt_regions VALUES(1453, 96, 'SS', 'Szekszárd', 'English');
INSERT INTO emkt_regions VALUES(1454, 96, 'ST', 'Salgótarján', 'English');
INSERT INTO emkt_regions VALUES(1455, 96, 'SZ', 'Szabolcs-Szatmár-Bereg megye', 'English');
INSERT INTO emkt_regions VALUES(1456, 96, 'TB', 'Tatabánya', 'English');
INSERT INTO emkt_regions VALUES(1457, 96, 'TO', 'Tolna megye', 'English');
INSERT INTO emkt_regions VALUES(1458, 96, 'VA', 'Vas megye', 'English');
INSERT INTO emkt_regions VALUES(1459, 96, 'VE', 'Veszprém megye', 'English');
INSERT INTO emkt_regions VALUES(1460, 96, 'VM', 'Veszprém', 'English');
INSERT INTO emkt_regions VALUES(1461, 96, 'ZA', 'Zala megye', 'English');
INSERT INTO emkt_regions VALUES(1462, 96, 'ZE', 'Zalaegerszeg', 'English');

INSERT INTO emkt_countries VALUES (97,'Iceland','English','IS','ISL','');

INSERT INTO emkt_regions VALUES(1463, 97, '1', 'Höfuðborgarsvæðið', 'English');
INSERT INTO emkt_regions VALUES(1464, 97, '2', 'Suðurnes', 'English');
INSERT INTO emkt_regions VALUES(1465, 97, '3', 'Vesturland', 'English');
INSERT INTO emkt_regions VALUES(1466, 97, '4', 'Vestfirðir', 'English');
INSERT INTO emkt_regions VALUES(1467, 97, '5', 'Norðurland vestra', 'English');
INSERT INTO emkt_regions VALUES(1468, 97, '6', 'Norðurland eystra', 'English');
INSERT INTO emkt_regions VALUES(1469, 97, '7', 'Austfirðir', 'English');
INSERT INTO emkt_regions VALUES(1470, 97, '8', 'Suðurland', 'English');

INSERT INTO emkt_countries VALUES (98,'India','English','IN','IND','');

INSERT INTO emkt_regions VALUES(1471, 98, 'IN-AN', 'अंडमान और निकोबार द्वीप', 'English');
INSERT INTO emkt_regions VALUES(1472, 98, 'IN-AP', 'ఆంధ్ర ప్రదేశ్', 'English');
INSERT INTO emkt_regions VALUES(1473, 98, 'IN-AR', 'अरुणाचल प्रदेश', 'English');
INSERT INTO emkt_regions VALUES(1474, 98, 'IN-AS', 'অসম', 'English');
INSERT INTO emkt_regions VALUES(1475, 98, 'IN-BR', 'बिहार', 'English');
INSERT INTO emkt_regions VALUES(1476, 98, 'IN-CH', 'चंडीगढ़', 'English');
INSERT INTO emkt_regions VALUES(1477, 98, 'IN-CT', 'छत्तीसगढ़', 'English');
INSERT INTO emkt_regions VALUES(1478, 98, 'IN-DD', 'દમણ અને દિવ', 'English');
INSERT INTO emkt_regions VALUES(1479, 98, 'IN-DL', 'दिल्ली', 'English');
INSERT INTO emkt_regions VALUES(1480, 98, 'IN-DN', 'દાદરા અને નગર હવેલી', 'English');
INSERT INTO emkt_regions VALUES(1481, 98, 'IN-GA', 'गोंय', 'English');
INSERT INTO emkt_regions VALUES(1482, 98, 'IN-GJ', 'ગુજરાત', 'English');
INSERT INTO emkt_regions VALUES(1483, 98, 'IN-HP', 'हिमाचल प्रदेश', 'English');
INSERT INTO emkt_regions VALUES(1484, 98, 'IN-HR', 'हरियाणा', 'English');
INSERT INTO emkt_regions VALUES(1485, 98, 'IN-JH', 'झारखंड', 'English');
INSERT INTO emkt_regions VALUES(1486, 98, 'IN-JK', 'जम्मू और कश्मीर', 'English');
INSERT INTO emkt_regions VALUES(1487, 98, 'IN-KA', 'ಕನಾ೯ಟಕ', 'English');
INSERT INTO emkt_regions VALUES(1488, 98, 'IN-KL', 'കേരളം', 'English');
INSERT INTO emkt_regions VALUES(1489, 98, 'IN-LD', 'ലക്ഷദ്വീപ്', 'English');
INSERT INTO emkt_regions VALUES(1490, 98, 'IN-ML', 'मेघालय', 'English');
INSERT INTO emkt_regions VALUES(1491, 98, 'IN-MH', 'महाराष्ट्र', 'English');
INSERT INTO emkt_regions VALUES(1492, 98, 'IN-MN', 'मणिपुर', 'English');
INSERT INTO emkt_regions VALUES(1493, 98, 'IN-MP', 'मध्य प्रदेश', 'English');
INSERT INTO emkt_regions VALUES(1494, 98, 'IN-MZ', 'मिज़ोरम', 'English');
INSERT INTO emkt_regions VALUES(1495, 98, 'IN-NL', 'नागालैंड', 'English');
INSERT INTO emkt_regions VALUES(1496, 98, 'IN-OR', 'उड़ीसा', 'English');
INSERT INTO emkt_regions VALUES(1497, 98, 'IN-PB', 'ਪੰਜਾਬ', 'English');
INSERT INTO emkt_regions VALUES(1498, 98, 'IN-PY', 'புதுச்சேரி', 'English');
INSERT INTO emkt_regions VALUES(1499, 98, 'IN-RJ', 'राजस्थान', 'English');
INSERT INTO emkt_regions VALUES(1500, 98, 'IN-SK', 'सिक्किम', 'English');
INSERT INTO emkt_regions VALUES(1501, 98, 'IN-TN', 'தமிழ் நாடு', 'English');
INSERT INTO emkt_regions VALUES(1502, 98, 'IN-TR', 'ত্রিপুরা', 'English');
INSERT INTO emkt_regions VALUES(1503, 98, 'IN-UL', 'उत्तरांचल', 'English');
INSERT INTO emkt_regions VALUES(1504, 98, 'IN-UP', 'उत्तर प्रदेश', 'English');
INSERT INTO emkt_regions VALUES(1505, 98, 'IN-WB', 'পশ্চিমবঙ্গ', 'English');

INSERT INTO emkt_countries VALUES (99,'Indonesia','English','ID','IDN','');

INSERT INTO emkt_regions VALUES(1506, 99, 'AC', 'Aceh', 'English');
INSERT INTO emkt_regions VALUES(1507, 99, 'BA', 'Bali', 'English');
INSERT INTO emkt_regions VALUES(1508, 99, 'BB', 'Bangka-Belitung', 'English');
INSERT INTO emkt_regions VALUES(1509, 99, 'BE', 'Bengkulu', 'English');
INSERT INTO emkt_regions VALUES(1510, 99, 'BT', 'Banten', 'English');
INSERT INTO emkt_regions VALUES(1511, 99, 'GO', 'Gorontalo', 'English');
INSERT INTO emkt_regions VALUES(1512, 99, 'IJ', 'Papua', 'English');
INSERT INTO emkt_regions VALUES(1513, 99, 'JA', 'Jambi', 'English');
INSERT INTO emkt_regions VALUES(1514, 99, 'JI', 'Jawa Timur', 'English');
INSERT INTO emkt_regions VALUES(1515, 99, 'JK', 'Jakarta Raya', 'English');
INSERT INTO emkt_regions VALUES(1516, 99, 'JR', 'Jawa Barat', 'English');
INSERT INTO emkt_regions VALUES(1517, 99, 'JT', 'Jawa Tengah', 'English');
INSERT INTO emkt_regions VALUES(1518, 99, 'KB', 'Kalimantan Barat', 'English');
INSERT INTO emkt_regions VALUES(1519, 99, 'KI', 'Kalimantan Timur', 'English');
INSERT INTO emkt_regions VALUES(1520, 99, 'KS', 'Kalimantan Selatan', 'English');
INSERT INTO emkt_regions VALUES(1521, 99, 'KT', 'Kalimantan Tengah', 'English');
INSERT INTO emkt_regions VALUES(1522, 99, 'LA', 'Lampung', 'English');
INSERT INTO emkt_regions VALUES(1523, 99, 'MA', 'Maluku', 'English');
INSERT INTO emkt_regions VALUES(1524, 99, 'MU', 'Maluku Utara', 'English');
INSERT INTO emkt_regions VALUES(1525, 99, 'NB', 'Nusa Tenggara Barat', 'English');
INSERT INTO emkt_regions VALUES(1526, 99, 'NT', 'Nusa Tenggara Timur', 'English');
INSERT INTO emkt_regions VALUES(1527, 99, 'RI', 'Riau', 'English');
INSERT INTO emkt_regions VALUES(1528, 99, 'SB', 'Sumatera Barat', 'English');
INSERT INTO emkt_regions VALUES(1529, 99, 'SG', 'Sulawesi Tenggara', 'English');
INSERT INTO emkt_regions VALUES(1530, 99, 'SL', 'Sumatera Selatan', 'English');
INSERT INTO emkt_regions VALUES(1531, 99, 'SN', 'Sulawesi Selatan', 'English');
INSERT INTO emkt_regions VALUES(1532, 99, 'ST', 'Sulawesi Tengah', 'English');
INSERT INTO emkt_regions VALUES(1533, 99, 'SW', 'Sulawesi Utara', 'English');
INSERT INTO emkt_regions VALUES(1534, 99, 'SU', 'Sumatera Utara', 'English');
INSERT INTO emkt_regions VALUES(1535, 99, 'YO', 'Yogyakarta', 'English');

INSERT INTO emkt_countries VALUES (100,'Iran','English','IR','IRN','');

INSERT INTO emkt_regions VALUES(1536, 100, '01', 'محافظة آذربایجان شرقي', 'English');
INSERT INTO emkt_regions VALUES(1537, 100, '02', 'محافظة آذربایجان غربي', 'English');
INSERT INTO emkt_regions VALUES(1538, 100, '03', 'محافظة اردبیل', 'English');
INSERT INTO emkt_regions VALUES(1539, 100, '04', 'محافظة اصفهان', 'English');
INSERT INTO emkt_regions VALUES(1540, 100, '05', 'محافظة ایلام', 'English');
INSERT INTO emkt_regions VALUES(1541, 100, '06', 'محافظة بوشهر', 'English');
INSERT INTO emkt_regions VALUES(1542, 100, '07', 'محافظة طهران', 'English');
INSERT INTO emkt_regions VALUES(1543, 100, '08', 'محافظة چهارمحل و بختیاري', 'English');
INSERT INTO emkt_regions VALUES(1544, 100, '09', 'محافظة خراسان رضوي', 'English');
INSERT INTO emkt_regions VALUES(1545, 100, '10', 'محافظة خوزستان', 'English');
INSERT INTO emkt_regions VALUES(1546, 100, '11', 'محافظة زنجان', 'English');
INSERT INTO emkt_regions VALUES(1547, 100, '12', 'محافظة سمنان', 'English');
INSERT INTO emkt_regions VALUES(1548, 100, '13', 'محافظة سيستان وبلوتشستان', 'English');
INSERT INTO emkt_regions VALUES(1549, 100, '14', 'محافظة فارس', 'English');
INSERT INTO emkt_regions VALUES(1550, 100, '15', 'محافظة کرمان', 'English');
INSERT INTO emkt_regions VALUES(1551, 100, '16', 'محافظة کردستان', 'English');
INSERT INTO emkt_regions VALUES(1552, 100, '17', 'محافظة کرمانشاه', 'English');
INSERT INTO emkt_regions VALUES(1553, 100, '18', 'محافظة کهکیلویه و بویر أحمد', 'English');
INSERT INTO emkt_regions VALUES(1554, 100, '19', 'محافظة گیلان', 'English');
INSERT INTO emkt_regions VALUES(1555, 100, '20', 'محافظة لرستان', 'English');
INSERT INTO emkt_regions VALUES(1556, 100, '21', 'محافظة مازندران', 'English');
INSERT INTO emkt_regions VALUES(1557, 100, '22', 'محافظة مرکزي', 'English');
INSERT INTO emkt_regions VALUES(1558, 100, '23', 'محافظة هرمزگان', 'English');
INSERT INTO emkt_regions VALUES(1559, 100, '24', 'محافظة همدان', 'English');
INSERT INTO emkt_regions VALUES(1560, 100, '25', 'محافظة یزد', 'English');
INSERT INTO emkt_regions VALUES(1561, 100, '26', 'محافظة قم', 'English');
INSERT INTO emkt_regions VALUES(1562, 100, '27', 'محافظة گلستان', 'English');
INSERT INTO emkt_regions VALUES(1563, 100, '28', 'محافظة قزوين', 'English');

INSERT INTO emkt_countries VALUES (101,'Iraq','English','IQ','IRQ','');

INSERT INTO emkt_regions VALUES(1564, 101, 'AN', 'محافظة الأنبار', 'English');
INSERT INTO emkt_regions VALUES(1565, 101, 'AR', 'أربيل', 'English');
INSERT INTO emkt_regions VALUES(1566, 101, 'BA', 'محافظة البصرة', 'English');
INSERT INTO emkt_regions VALUES(1567, 101, 'BB', 'بابل', 'English');
INSERT INTO emkt_regions VALUES(1568, 101, 'BG', 'محافظة بغداد', 'English');
INSERT INTO emkt_regions VALUES(1569, 101, 'DA', 'دهوك', 'English');
INSERT INTO emkt_regions VALUES(1570, 101, 'DI', 'ديالى', 'English');
INSERT INTO emkt_regions VALUES(1571, 101, 'DQ', 'ذي قار', 'English');
INSERT INTO emkt_regions VALUES(1572, 101, 'KA', 'كربلاء', 'English');
INSERT INTO emkt_regions VALUES(1573, 101, 'MA', 'ميسان', 'English');
INSERT INTO emkt_regions VALUES(1574, 101, 'MU', 'المثنى', 'English');
INSERT INTO emkt_regions VALUES(1575, 101, 'NA', 'النجف', 'English');
INSERT INTO emkt_regions VALUES(1576, 101, 'NI', 'نینوى', 'English');
INSERT INTO emkt_regions VALUES(1577, 101, 'QA', 'القادسية', 'English');
INSERT INTO emkt_regions VALUES(1578, 101, 'SD', 'صلاح الدين', 'English');
INSERT INTO emkt_regions VALUES(1579, 101, 'SW', 'محافظة السليمانية', 'English');
INSERT INTO emkt_regions VALUES(1580, 101, 'TS', 'التأمیم', 'English');
INSERT INTO emkt_regions VALUES(1581, 101, 'WA', 'واسط', 'English');

INSERT INTO emkt_countries VALUES (102,'Ireland','English','IE','IRL','');

INSERT INTO emkt_regions VALUES(1582, 102, 'C', 'Corcaigh', 'English');
INSERT INTO emkt_regions VALUES(1583, 102, 'CE', 'Contae an Chláir', 'English');
INSERT INTO emkt_regions VALUES(1584, 102, 'CN', 'An Cabhán', 'English');
INSERT INTO emkt_regions VALUES(1585, 102, 'CW', 'Ceatharlach', 'English');
INSERT INTO emkt_regions VALUES(1586, 102, 'D', 'Baile Átha Cliath', 'English');
INSERT INTO emkt_regions VALUES(1587, 102, 'DL', 'Dún na nGall', 'English');
INSERT INTO emkt_regions VALUES(1588, 102, 'G', 'Gaillimh', 'English');
INSERT INTO emkt_regions VALUES(1589, 102, 'KE', 'Cill Dara', 'English');
INSERT INTO emkt_regions VALUES(1590, 102, 'KK', 'Cill Chainnigh', 'English');
INSERT INTO emkt_regions VALUES(1591, 102, 'KY', 'Contae Chiarraí', 'English');
INSERT INTO emkt_regions VALUES(1592, 102, 'LD', 'An Longfort', 'English');
INSERT INTO emkt_regions VALUES(1593, 102, 'LH', 'Contae Lú', 'English');
INSERT INTO emkt_regions VALUES(1594, 102, 'LK', 'Luimneach', 'English');
INSERT INTO emkt_regions VALUES(1595, 102, 'LM', 'Contae Liatroma', 'English');
INSERT INTO emkt_regions VALUES(1596, 102, 'LS', 'Contae Laoise', 'English');
INSERT INTO emkt_regions VALUES(1597, 102, 'MH', 'Contae na Mí', 'English');
INSERT INTO emkt_regions VALUES(1598, 102, 'MN', 'Muineachán', 'English');
INSERT INTO emkt_regions VALUES(1599, 102, 'MO', 'Contae Mhaigh Eo', 'English');
INSERT INTO emkt_regions VALUES(1600, 102, 'OY', 'Contae Uíbh Fhailí', 'English');
INSERT INTO emkt_regions VALUES(1601, 102, 'RN', 'Ros Comáin', 'English');
INSERT INTO emkt_regions VALUES(1602, 102, 'SO', 'Sligeach', 'English');
INSERT INTO emkt_regions VALUES(1603, 102, 'TA', 'Tiobraid Árann', 'English');
INSERT INTO emkt_regions VALUES(1604, 102, 'WD', 'Port Lairge', 'English');
INSERT INTO emkt_regions VALUES(1605, 102, 'WH', 'Contae na hIarmhí', 'English');
INSERT INTO emkt_regions VALUES(1606, 102, 'WW', 'Cill Mhantáin', 'English');
INSERT INTO emkt_regions VALUES(1607, 102, 'WX', 'Loch Garman', 'English');

INSERT INTO emkt_countries VALUES (103,'Israel','English','IL','ISR','');

INSERT INTO emkt_regions VALUES(1608, 103, 'D ', 'מחוז הדרום', 'English');
INSERT INTO emkt_regions VALUES(1609, 103, 'HA', 'מחוז חיפה', 'English');
INSERT INTO emkt_regions VALUES(1610, 103, 'JM', 'ירושלים', 'English');
INSERT INTO emkt_regions VALUES(1611, 103, 'M ', 'מחוז המרכז', 'English');
INSERT INTO emkt_regions VALUES(1612, 103, 'TA', 'תל אביב-יפו', 'English');
INSERT INTO emkt_regions VALUES(1613, 103, 'Z ', 'מחוז הצפון', 'English');

INSERT INTO emkt_countries VALUES (104,'Italy','English','IT','ITA','');

INSERT INTO emkt_regions VALUES(1614, 104, 'AG', 'Agrigento', 'English');
INSERT INTO emkt_regions VALUES(1615, 104, 'AL', 'Alessandria', 'English');
INSERT INTO emkt_regions VALUES(1616, 104, 'AN', 'Ancona', 'English');
INSERT INTO emkt_regions VALUES(1617, 104, 'AO', 'Valle d\'Aosta', 'English');
INSERT INTO emkt_regions VALUES(1618, 104, 'AP', 'Ascoli Piceno', 'English');
INSERT INTO emkt_regions VALUES(1619, 104, 'AQ', 'L\'Aquila', 'English');
INSERT INTO emkt_regions VALUES(1620, 104, 'AR', 'Arezzo', 'English');
INSERT INTO emkt_regions VALUES(1621, 104, 'AT', 'Asti', 'English');
INSERT INTO emkt_regions VALUES(1622, 104, 'AV', 'Avellino', 'English');
INSERT INTO emkt_regions VALUES(1623, 104, 'BA', 'Bari', 'English');
INSERT INTO emkt_regions VALUES(1624, 104, 'BG', 'Bergamo', 'English');
INSERT INTO emkt_regions VALUES(1625, 104, 'BI', 'Biella', 'English');
INSERT INTO emkt_regions VALUES(1626, 104, 'BL', 'Belluno', 'English');
INSERT INTO emkt_regions VALUES(1627, 104, 'BN', 'Benevento', 'English');
INSERT INTO emkt_regions VALUES(1628, 104, 'BO', 'Bologna', 'English');
INSERT INTO emkt_regions VALUES(1629, 104, 'BR', 'Brindisi', 'English');
INSERT INTO emkt_regions VALUES(1630, 104, 'BS', 'Brescia', 'English');
INSERT INTO emkt_regions VALUES(1631, 104, 'BT', 'Barletta-Andria-Trani', 'English');
INSERT INTO emkt_regions VALUES(1632, 104, 'BZ', 'Alto Adige', 'English');
INSERT INTO emkt_regions VALUES(1633, 104, 'CA', 'Cagliari', 'English');
INSERT INTO emkt_regions VALUES(1634, 104, 'CB', 'Campobasso', 'English');
INSERT INTO emkt_regions VALUES(1635, 104, 'CE', 'Caserta', 'English');
INSERT INTO emkt_regions VALUES(1636, 104, 'CH', 'Chieti', 'English');
INSERT INTO emkt_regions VALUES(1637, 104, 'CI', 'Carbonia-Iglesias', 'English');
INSERT INTO emkt_regions VALUES(1638, 104, 'CL', 'Caltanissetta', 'English');
INSERT INTO emkt_regions VALUES(1639, 104, 'CN', 'Cuneo', 'English');
INSERT INTO emkt_regions VALUES(1640, 104, 'CO', 'Como', 'English');
INSERT INTO emkt_regions VALUES(1641, 104, 'CR', 'Cremona', 'English');
INSERT INTO emkt_regions VALUES(1642, 104, 'CS', 'Cosenza', 'English');
INSERT INTO emkt_regions VALUES(1643, 104, 'CT', 'Catania', 'English');
INSERT INTO emkt_regions VALUES(1644, 104, 'CZ', 'Catanzaro', 'English');
INSERT INTO emkt_regions VALUES(1645, 104, 'EN', 'Enna', 'English');
INSERT INTO emkt_regions VALUES(1646, 104, 'FE', 'Ferrara', 'English');
INSERT INTO emkt_regions VALUES(1647, 104, 'FG', 'Foggia', 'English');
INSERT INTO emkt_regions VALUES(1648, 104, 'FI', 'Firenze', 'English');
INSERT INTO emkt_regions VALUES(1649, 104, 'FM', 'Fermo', 'English');
INSERT INTO emkt_regions VALUES(1650, 104, 'FO', 'Forlì-Cesena', 'English');
INSERT INTO emkt_regions VALUES(1651, 104, 'FR', 'Frosinone', 'English');
INSERT INTO emkt_regions VALUES(1652, 104, 'GE', 'Genova', 'English');
INSERT INTO emkt_regions VALUES(1653, 104, 'GO', 'Gorizia', 'English');
INSERT INTO emkt_regions VALUES(1654, 104, 'GR', 'Grosseto', 'English');
INSERT INTO emkt_regions VALUES(1655, 104, 'IM', 'Imperia', 'English');
INSERT INTO emkt_regions VALUES(1656, 104, 'IS', 'Isernia', 'English');
INSERT INTO emkt_regions VALUES(1657, 104, 'KR', 'Crotone', 'English');
INSERT INTO emkt_regions VALUES(1658, 104, 'LC', 'Lecco', 'English');
INSERT INTO emkt_regions VALUES(1659, 104, 'LE', 'Lecce', 'English');
INSERT INTO emkt_regions VALUES(1660, 104, 'LI', 'Livorno', 'English');
INSERT INTO emkt_regions VALUES(1661, 104, 'LO', 'Lodi', 'English');
INSERT INTO emkt_regions VALUES(1662, 104, 'LT', 'Latina', 'English');
INSERT INTO emkt_regions VALUES(1663, 104, 'LU', 'Lucca', 'English');
INSERT INTO emkt_regions VALUES(1664, 104, 'MC', 'Macerata', 'English');
INSERT INTO emkt_regions VALUES(1665, 104, 'MD', 'Medio Campidano', 'English');
INSERT INTO emkt_regions VALUES(1666, 104, 'ME', 'Messina', 'English');
INSERT INTO emkt_regions VALUES(1667, 104, 'MI', 'Milano', 'English');
INSERT INTO emkt_regions VALUES(1668, 104, 'MN', 'Mantova', 'English');
INSERT INTO emkt_regions VALUES(1669, 104, 'MO', 'Modena', 'English');
INSERT INTO emkt_regions VALUES(1670, 104, 'MS', 'Massa-Carrara', 'English');
INSERT INTO emkt_regions VALUES(1671, 104, 'MT', 'Matera', 'English');
INSERT INTO emkt_regions VALUES(1672, 104, 'MZ', 'Monza e Brianza', 'English');
INSERT INTO emkt_regions VALUES(1673, 104, 'NA', 'Napoli', 'English');
INSERT INTO emkt_regions VALUES(1674, 104, 'NO', 'Novara', 'English');
INSERT INTO emkt_regions VALUES(1675, 104, 'NU', 'Nuoro', 'English');
INSERT INTO emkt_regions VALUES(1676, 104, 'OG', 'Ogliastra', 'English');
INSERT INTO emkt_regions VALUES(1677, 104, 'OR', 'Oristano', 'English');
INSERT INTO emkt_regions VALUES(1678, 104, 'OT', 'Olbia-Tempio', 'English');
INSERT INTO emkt_regions VALUES(1679, 104, 'PA', 'Palermo', 'English');
INSERT INTO emkt_regions VALUES(1680, 104, 'PC', 'Piacenza', 'English');
INSERT INTO emkt_regions VALUES(1681, 104, 'PD', 'Padova', 'English');
INSERT INTO emkt_regions VALUES(1682, 104, 'PE', 'Pescara', 'English');
INSERT INTO emkt_regions VALUES(1683, 104, 'PG', 'Perugia', 'English');
INSERT INTO emkt_regions VALUES(1684, 104, 'PI', 'Pisa', 'English');
INSERT INTO emkt_regions VALUES(1685, 104, 'PN', 'Pordenone', 'English');
INSERT INTO emkt_regions VALUES(1686, 104, 'PO', 'Prato', 'English');
INSERT INTO emkt_regions VALUES(1687, 104, 'PR', 'Parma', 'English');
INSERT INTO emkt_regions VALUES(1688, 104, 'PS', 'Pesaro e Urbino', 'English');
INSERT INTO emkt_regions VALUES(1689, 104, 'PT', 'Pistoia', 'English');
INSERT INTO emkt_regions VALUES(1690, 104, 'PV', 'Pavia', 'English');
INSERT INTO emkt_regions VALUES(1691, 104, 'PZ', 'Potenza', 'English');
INSERT INTO emkt_regions VALUES(1692, 104, 'RA', 'Ravenna', 'English');
INSERT INTO emkt_regions VALUES(1693, 104, 'RC', 'Reggio Calabria', 'English');
INSERT INTO emkt_regions VALUES(1694, 104, 'RE', 'Reggio Emilia', 'English');
INSERT INTO emkt_regions VALUES(1695, 104, 'RG', 'Ragusa', 'English');
INSERT INTO emkt_regions VALUES(1696, 104, 'RI', 'Rieti', 'English');
INSERT INTO emkt_regions VALUES(1697, 104, 'RM', 'Roma', 'English');
INSERT INTO emkt_regions VALUES(1698, 104, 'RN', 'Rimini', 'English');
INSERT INTO emkt_regions VALUES(1699, 104, 'RO', 'Rovigo', 'English');
INSERT INTO emkt_regions VALUES(1700, 104, 'SA', 'Salerno', 'English');
INSERT INTO emkt_regions VALUES(1701, 104, 'SI', 'Siena', 'English');
INSERT INTO emkt_regions VALUES(1702, 104, 'SO', 'Sondrio', 'English');
INSERT INTO emkt_regions VALUES(1703, 104, 'SP', 'La Spezia', 'English');
INSERT INTO emkt_regions VALUES(1704, 104, 'SR', 'Siracusa', 'English');
INSERT INTO emkt_regions VALUES(1705, 104, 'SS', 'Sassari', 'English');
INSERT INTO emkt_regions VALUES(1706, 104, 'SV', 'Savona', 'English');
INSERT INTO emkt_regions VALUES(1707, 104, 'TA', 'Taranto', 'English');
INSERT INTO emkt_regions VALUES(1708, 104, 'TE', 'Teramo', 'English');
INSERT INTO emkt_regions VALUES(1709, 104, 'TN', 'Trento', 'English');
INSERT INTO emkt_regions VALUES(1710, 104, 'TO', 'Torino', 'English');
INSERT INTO emkt_regions VALUES(1711, 104, 'TP', 'Trapani', 'English');
INSERT INTO emkt_regions VALUES(1712, 104, 'TR', 'Terni', 'English');
INSERT INTO emkt_regions VALUES(1713, 104, 'TS', 'Trieste', 'English');
INSERT INTO emkt_regions VALUES(1714, 104, 'TV', 'Treviso', 'English');
INSERT INTO emkt_regions VALUES(1715, 104, 'UD', 'Udine', 'English');
INSERT INTO emkt_regions VALUES(1716, 104, 'VA', 'Varese', 'English');
INSERT INTO emkt_regions VALUES(1717, 104, 'VB', 'Verbano-Cusio-Ossola', 'English');
INSERT INTO emkt_regions VALUES(1718, 104, 'VC', 'Vercelli', 'English');
INSERT INTO emkt_regions VALUES(1719, 104, 'VE', 'Venezia', 'English');
INSERT INTO emkt_regions VALUES(1720, 104, 'VI', 'Vicenza', 'English');
INSERT INTO emkt_regions VALUES(1721, 104, 'VR', 'Verona', 'English');
INSERT INTO emkt_regions VALUES(1722, 104, 'VT', 'Viterbo', 'English');
INSERT INTO emkt_regions VALUES(1723, 104, 'VV', 'Vibo Valentia', 'English');

INSERT INTO emkt_countries VALUES (105,'Jamaica','English','JM','JAM','');

INSERT INTO emkt_regions VALUES(1724, 105, '01', 'Kingston', 'English');
INSERT INTO emkt_regions VALUES(1725, 105, '02', 'Half Way Tree', 'English');
INSERT INTO emkt_regions VALUES(1726, 105, '03', 'Morant Bay', 'English');
INSERT INTO emkt_regions VALUES(1727, 105, '04', 'Port Antonio', 'English');
INSERT INTO emkt_regions VALUES(1728, 105, '05', 'Port Maria', 'English');
INSERT INTO emkt_regions VALUES(1729, 105, '06', 'Saint Ann\'s Bay', 'English');
INSERT INTO emkt_regions VALUES(1730, 105, '07', 'Falmouth', 'English');
INSERT INTO emkt_regions VALUES(1731, 105, '08', 'Montego Bay', 'English');
INSERT INTO emkt_regions VALUES(1732, 105, '09', 'Lucea', 'English');
INSERT INTO emkt_regions VALUES(1733, 105, '10', 'Savanna-la-Mar', 'English');
INSERT INTO emkt_regions VALUES(1734, 105, '11', 'Black River', 'English');
INSERT INTO emkt_regions VALUES(1735, 105, '12', 'Mandeville', 'English');
INSERT INTO emkt_regions VALUES(1736, 105, '13', 'May Pen', 'English');
INSERT INTO emkt_regions VALUES(1737, 105, '14', 'Spanish Town', 'English');

INSERT INTO emkt_countries VALUES (106,'Japan','English','JP','JPN','');

INSERT INTO emkt_regions VALUES(1738, 106, '01', '北海道', 'English');
INSERT INTO emkt_regions VALUES(1739, 106, '02', '青森', 'English');
INSERT INTO emkt_regions VALUES(1740, 106, '03', '岩手', 'English');
INSERT INTO emkt_regions VALUES(1741, 106, '04', '宮城', 'English');
INSERT INTO emkt_regions VALUES(1742, 106, '05', '秋田', 'English');
INSERT INTO emkt_regions VALUES(1743, 106, '06', '山形', 'English');
INSERT INTO emkt_regions VALUES(1744, 106, '07', '福島', 'English');
INSERT INTO emkt_regions VALUES(1745, 106, '08', '茨城', 'English');
INSERT INTO emkt_regions VALUES(1746, 106, '09', '栃木', 'English');
INSERT INTO emkt_regions VALUES(1747, 106, '10', '群馬', 'English');
INSERT INTO emkt_regions VALUES(1748, 106, '11', '埼玉', 'English');
INSERT INTO emkt_regions VALUES(1749, 106, '12', '千葉', 'English');
INSERT INTO emkt_regions VALUES(1750, 106, '13', '東京', 'English');
INSERT INTO emkt_regions VALUES(1751, 106, '14', '神奈川', 'English');
INSERT INTO emkt_regions VALUES(1752, 106, '15', '新潟', 'English');
INSERT INTO emkt_regions VALUES(1753, 106, '16', '富山', 'English');
INSERT INTO emkt_regions VALUES(1754, 106, '17', '石川', 'English');
INSERT INTO emkt_regions VALUES(1755, 106, '18', '福井', 'English');
INSERT INTO emkt_regions VALUES(1756, 106, '19', '山梨', 'English');
INSERT INTO emkt_regions VALUES(1757, 106, '20', '長野', 'English');
INSERT INTO emkt_regions VALUES(1758, 106, '21', '岐阜', 'English');
INSERT INTO emkt_regions VALUES(1759, 106, '22', '静岡', 'English');
INSERT INTO emkt_regions VALUES(1760, 106, '23', '愛知', 'English');
INSERT INTO emkt_regions VALUES(1761, 106, '24', '三重', 'English');
INSERT INTO emkt_regions VALUES(1762, 106, '25', '滋賀', 'English');
INSERT INTO emkt_regions VALUES(1763, 106, '26', '京都', 'English');
INSERT INTO emkt_regions VALUES(1764, 106, '27', '大阪', 'English');
INSERT INTO emkt_regions VALUES(1765, 106, '28', '兵庫', 'English');
INSERT INTO emkt_regions VALUES(1766, 106, '29', '奈良', 'English');
INSERT INTO emkt_regions VALUES(1767, 106, '30', '和歌山', 'English');
INSERT INTO emkt_regions VALUES(1768, 106, '31', '鳥取', 'English');
INSERT INTO emkt_regions VALUES(1769, 106, '32', '島根', 'English');
INSERT INTO emkt_regions VALUES(1770, 106, '33', '岡山', 'English');
INSERT INTO emkt_regions VALUES(1771, 106, '34', '広島', 'English');
INSERT INTO emkt_regions VALUES(1772, 106, '35', '山口', 'English');
INSERT INTO emkt_regions VALUES(1773, 106, '36', '徳島', 'English');
INSERT INTO emkt_regions VALUES(1774, 106, '37', '香川', 'English');
INSERT INTO emkt_regions VALUES(1775, 106, '38', '愛媛', 'English');
INSERT INTO emkt_regions VALUES(1776, 106, '39', '高知', 'English');
INSERT INTO emkt_regions VALUES(1777, 106, '40', '福岡', 'English');
INSERT INTO emkt_regions VALUES(1778, 106, '41', '佐賀', 'English');
INSERT INTO emkt_regions VALUES(1779, 106, '42', '長崎', 'English');
INSERT INTO emkt_regions VALUES(1780, 106, '43', '熊本', 'English');
INSERT INTO emkt_regions VALUES(1781, 106, '44', '大分', 'English');
INSERT INTO emkt_regions VALUES(1782, 106, '45', '宮崎', 'English');
INSERT INTO emkt_regions VALUES(1783, 106, '46', '鹿児島', 'English');
INSERT INTO emkt_regions VALUES(1784, 106, '47', '沖縄', 'English');

INSERT INTO emkt_countries VALUES (107,'Jordan','English','JO','JOR','');

INSERT INTO emkt_regions VALUES(1785, 107, 'AJ', 'محافظة عجلون', 'English');
INSERT INTO emkt_regions VALUES(1786, 107, 'AM', 'محافظة العاصمة', 'English');
INSERT INTO emkt_regions VALUES(1787, 107, 'AQ', 'محافظة العقبة', 'English');
INSERT INTO emkt_regions VALUES(1788, 107, 'AT', 'محافظة الطفيلة', 'English');
INSERT INTO emkt_regions VALUES(1789, 107, 'AZ', 'محافظة الزرقاء', 'English');
INSERT INTO emkt_regions VALUES(1790, 107, 'BA', 'محافظة البلقاء', 'English');
INSERT INTO emkt_regions VALUES(1791, 107, 'JA', 'محافظة جرش', 'English');
INSERT INTO emkt_regions VALUES(1792, 107, 'JR', 'محافظة إربد', 'English');
INSERT INTO emkt_regions VALUES(1793, 107, 'KA', 'محافظة الكرك', 'English');
INSERT INTO emkt_regions VALUES(1794, 107, 'MA', 'محافظة المفرق', 'English');
INSERT INTO emkt_regions VALUES(1795, 107, 'MD', 'محافظة مادبا', 'English');
INSERT INTO emkt_regions VALUES(1796, 107, 'MN', 'محافظة معان', 'English');

INSERT INTO emkt_countries VALUES (108,'Kazakhstan','English','KZ','KAZ','');

INSERT INTO emkt_regions VALUES(1797, 108, 'AL', 'Алматы', 'English');
INSERT INTO emkt_regions VALUES(1798, 108, 'AC', 'Almaty City', 'English');
INSERT INTO emkt_regions VALUES(1799, 108, 'AM', 'Ақмола', 'English');
INSERT INTO emkt_regions VALUES(1800, 108, 'AQ', 'Ақтөбе', 'English');
INSERT INTO emkt_regions VALUES(1801, 108, 'AS', 'Астана', 'English');
INSERT INTO emkt_regions VALUES(1802, 108, 'AT', 'Атырау', 'English');
INSERT INTO emkt_regions VALUES(1803, 108, 'BA', 'Батыс Қазақстан', 'English');
INSERT INTO emkt_regions VALUES(1804, 108, 'BY', 'Байқоңыр', 'English');
INSERT INTO emkt_regions VALUES(1805, 108, 'MA', 'Маңғыстау', 'English');
INSERT INTO emkt_regions VALUES(1806, 108, 'ON', 'Оңтүстік Қазақстан', 'English');
INSERT INTO emkt_regions VALUES(1807, 108, 'PA', 'Павлодар', 'English');
INSERT INTO emkt_regions VALUES(1808, 108, 'QA', 'Қарағанды', 'English');
INSERT INTO emkt_regions VALUES(1809, 108, 'QO', 'Қостанай', 'English');
INSERT INTO emkt_regions VALUES(1810, 108, 'QY', 'Қызылорда', 'English');
INSERT INTO emkt_regions VALUES(1811, 108, 'SH', 'Шығыс Қазақстан', 'English');
INSERT INTO emkt_regions VALUES(1812, 108, 'SO', 'Солтүстік Қазақстан', 'English');
INSERT INTO emkt_regions VALUES(1813, 108, 'ZH', 'Жамбыл', 'English');

INSERT INTO emkt_countries VALUES (109,'Kenya','English','KE','KEN','');

INSERT INTO emkt_regions VALUES(1814, 109, '110', 'Nairobi', 'English');
INSERT INTO emkt_regions VALUES(1815, 109, '200', 'Central', 'English');
INSERT INTO emkt_regions VALUES(1816, 109, '300', 'Mombasa', 'English');
INSERT INTO emkt_regions VALUES(1817, 109, '400', 'Eastern', 'English');
INSERT INTO emkt_regions VALUES(1818, 109, '500', 'North Eastern', 'English');
INSERT INTO emkt_regions VALUES(1819, 109, '600', 'Nyanza', 'English');
INSERT INTO emkt_regions VALUES(1820, 109, '700', 'Rift Valley', 'English');
INSERT INTO emkt_regions VALUES(1821, 109, '900', 'Western', 'English');

INSERT INTO emkt_countries VALUES (110,'Kiribati','English','KI','KIR','');

INSERT INTO emkt_regions VALUES(1822, 110, 'G', 'Gilbert Islands', 'English');
INSERT INTO emkt_regions VALUES(1823, 110, 'L', 'Line Islands', 'English');
INSERT INTO emkt_regions VALUES(1824, 110, 'P', 'Phoenix Islands', 'English');

INSERT INTO emkt_countries VALUES (111,'Korea, North','English','KP','PRK','');

INSERT INTO emkt_regions VALUES(1825, 111, 'CHA', '자강도', 'English');
INSERT INTO emkt_regions VALUES(1826, 111, 'HAB', '함경 북도', 'English');
INSERT INTO emkt_regions VALUES(1827, 111, 'HAN', '함경 남도', 'English');
INSERT INTO emkt_regions VALUES(1828, 111, 'HWB', '황해 북도', 'English');
INSERT INTO emkt_regions VALUES(1829, 111, 'HWN', '황해 남도', 'English');
INSERT INTO emkt_regions VALUES(1830, 111, 'KAN', '강원도', 'English');
INSERT INTO emkt_regions VALUES(1831, 111, 'KAE', '개성시', 'English');
INSERT INTO emkt_regions VALUES(1832, 111, 'NAJ', '라선 직할시', 'English');
INSERT INTO emkt_regions VALUES(1833, 111, 'NAM', '남포 특급시', 'English');
INSERT INTO emkt_regions VALUES(1834, 111, 'PYB', '평안 북도', 'English');
INSERT INTO emkt_regions VALUES(1835, 111, 'PYN', '평안 남도', 'English');
INSERT INTO emkt_regions VALUES(1836, 111, 'PYO', '평양 직할시', 'English');
INSERT INTO emkt_regions VALUES(1837, 111, 'YAN', '량강도', 'English');

INSERT INTO emkt_countries VALUES (112,'Korea, South','English','KR','KOR','');

INSERT INTO emkt_regions VALUES(1838, 112, '11', '서울특별시', 'English');
INSERT INTO emkt_regions VALUES(1839, 112, '26', '부산 광역시', 'English');
INSERT INTO emkt_regions VALUES(1840, 112, '27', '대구 광역시', 'English');
INSERT INTO emkt_regions VALUES(1841, 112, '28', '인천광역시', 'English');
INSERT INTO emkt_regions VALUES(1842, 112, '29', '광주 광역시', 'English');
INSERT INTO emkt_regions VALUES(1843, 112, '30', '대전 광역시', 'English');
INSERT INTO emkt_regions VALUES(1844, 112, '31', '울산 광역시', 'English');
INSERT INTO emkt_regions VALUES(1845, 112, '41', '경기도', 'English');
INSERT INTO emkt_regions VALUES(1846, 112, '42', '강원도', 'English');
INSERT INTO emkt_regions VALUES(1847, 112, '43', '충청 북도', 'English');
INSERT INTO emkt_regions VALUES(1848, 112, '44', '충청 남도', 'English');
INSERT INTO emkt_regions VALUES(1849, 112, '45', '전라 북도', 'English');
INSERT INTO emkt_regions VALUES(1850, 112, '46', '전라 남도', 'English');
INSERT INTO emkt_regions VALUES(1851, 112, '47', '경상 북도', 'English');
INSERT INTO emkt_regions VALUES(1852, 112, '48', '경상 남도', 'English');
INSERT INTO emkt_regions VALUES(1853, 112, '49', '제주특별자치도', 'English');

INSERT INTO emkt_countries VALUES (113,'Kuwait','English','KW','KWT','');

INSERT INTO emkt_regions VALUES(1854, 113, 'AH', 'الاحمدي', 'English');
INSERT INTO emkt_regions VALUES(1855, 113, 'FA', 'الفروانية', 'English');
INSERT INTO emkt_regions VALUES(1856, 113, 'JA', 'الجهراء', 'English');
INSERT INTO emkt_regions VALUES(1857, 113, 'KU', 'ألعاصمه', 'English');
INSERT INTO emkt_regions VALUES(1858, 113, 'HW', 'حولي', 'English');
INSERT INTO emkt_regions VALUES(1859, 113, 'MU', 'مبارك الكبير', 'English');

INSERT INTO emkt_countries VALUES (114,'Kyrgyzstan','English','KG','KGZ','');

INSERT INTO emkt_regions VALUES(1860, 114, 'B', 'Баткен областы', 'English');
INSERT INTO emkt_regions VALUES(1861, 114, 'C', 'Чүй областы', 'English');
INSERT INTO emkt_regions VALUES(1862, 114, 'GB', 'Бишкек', 'English');
INSERT INTO emkt_regions VALUES(1863, 114, 'J', 'Жалал-Абад областы', 'English');
INSERT INTO emkt_regions VALUES(1864, 114, 'N', 'Нарын областы', 'English');
INSERT INTO emkt_regions VALUES(1865, 114, 'O', 'Ош областы', 'English');
INSERT INTO emkt_regions VALUES(1866, 114, 'T', 'Талас областы', 'English');
INSERT INTO emkt_regions VALUES(1867, 114, 'Y', 'Ысык-Көл областы', 'English');

INSERT INTO emkt_countries VALUES (115,'Laos','English','LA','LAO','');

INSERT INTO emkt_regions VALUES(1868, 115, 'AT', 'ອັດຕະປື', 'English');
INSERT INTO emkt_regions VALUES(1869, 115, 'BK', 'ບໍ່ແກ້ວ', 'English');
INSERT INTO emkt_regions VALUES(1870, 115, 'BL', 'ບໍລິຄໍາໄຊ', 'English');
INSERT INTO emkt_regions VALUES(1871, 115, 'CH', 'ຈໍາປາສັກ', 'English');
INSERT INTO emkt_regions VALUES(1872, 115, 'HO', 'ຫົວພັນ', 'English');
INSERT INTO emkt_regions VALUES(1873, 115, 'KH', 'ຄໍາມ່ວນ', 'English');
INSERT INTO emkt_regions VALUES(1874, 115, 'LM', 'ຫລວງນໍ້າທາ', 'English');
INSERT INTO emkt_regions VALUES(1875, 115, 'LP', 'ຫລວງພະບາງ', 'English');
INSERT INTO emkt_regions VALUES(1876, 115, 'OU', 'ອຸດົມໄຊ', 'English');
INSERT INTO emkt_regions VALUES(1877, 115, 'PH', 'ຜົງສາລີ', 'English');
INSERT INTO emkt_regions VALUES(1878, 115, 'SL', 'ສາລະວັນ', 'English');
INSERT INTO emkt_regions VALUES(1879, 115, 'SV', 'ສະຫວັນນະເຂດ', 'English');
INSERT INTO emkt_regions VALUES(1880, 115, 'VI', 'ວຽງຈັນ', 'English');
INSERT INTO emkt_regions VALUES(1881, 115, 'VT', 'ວຽງຈັນ', 'English');
INSERT INTO emkt_regions VALUES(1882, 115, 'XA', 'ໄຊຍະບູລີ', 'English');
INSERT INTO emkt_regions VALUES(1883, 115, 'XE', 'ເຊກອງ', 'English');
INSERT INTO emkt_regions VALUES(1884, 115, 'XI', 'ຊຽງຂວາງ', 'English');
INSERT INTO emkt_regions VALUES(1885, 115, 'XN', 'ໄຊສົມບູນ', 'English');

INSERT INTO emkt_countries VALUES (116,'Latvia','English','LV','LVA','');

INSERT INTO emkt_regions VALUES(1886, 116, 'AI', 'Aizkraukles rajons', 'English');
INSERT INTO emkt_regions VALUES(1887, 116, 'AL', 'Alūksnes rajons', 'English');
INSERT INTO emkt_regions VALUES(1888, 116, 'BL', 'Balvu rajons', 'English');
INSERT INTO emkt_regions VALUES(1889, 116, 'BU', 'Bauskas rajons', 'English');
INSERT INTO emkt_regions VALUES(1890, 116, 'CE', 'Cēsu rajons', 'English');
INSERT INTO emkt_regions VALUES(1891, 116, 'DA', 'Daugavpils rajons', 'English');
INSERT INTO emkt_regions VALUES(1892, 116, 'DGV', 'Daugpilis', 'English');
INSERT INTO emkt_regions VALUES(1893, 116, 'DO', 'Dobeles rajons', 'English');
INSERT INTO emkt_regions VALUES(1894, 116, 'GU', 'Gulbenes rajons', 'English');
INSERT INTO emkt_regions VALUES(1895, 116, 'JEL', 'Jelgava', 'English');
INSERT INTO emkt_regions VALUES(1896, 116, 'JK', 'Jēkabpils rajons', 'English');
INSERT INTO emkt_regions VALUES(1897, 116, 'JL', 'Jelgavas rajons', 'English');
INSERT INTO emkt_regions VALUES(1898, 116, 'JUR', 'Jūrmala', 'English');
INSERT INTO emkt_regions VALUES(1899, 116, 'KR', 'Krāslavas rajons', 'English');
INSERT INTO emkt_regions VALUES(1900, 116, 'KU', 'Kuldīgas rajons', 'English');
INSERT INTO emkt_regions VALUES(1901, 116, 'LE', 'Liepājas rajons', 'English');
INSERT INTO emkt_regions VALUES(1902, 116, 'LM', 'Limbažu rajons', 'English');
INSERT INTO emkt_regions VALUES(1903, 116, 'LPX', 'Liepoja', 'English');
INSERT INTO emkt_regions VALUES(1904, 116, 'LU', 'Ludzas rajons', 'English');
INSERT INTO emkt_regions VALUES(1905, 116, 'MA', 'Madonas rajons', 'English');
INSERT INTO emkt_regions VALUES(1906, 116, 'OG', 'Ogres rajons', 'English');
INSERT INTO emkt_regions VALUES(1907, 116, 'PR', 'Preiļu rajons', 'English');
INSERT INTO emkt_regions VALUES(1908, 116, 'RE', 'Rēzeknes rajons', 'English');
INSERT INTO emkt_regions VALUES(1909, 116, 'REZ', 'Rēzekne', 'English');
INSERT INTO emkt_regions VALUES(1910, 116, 'RI', 'Rīgas rajons', 'English');
INSERT INTO emkt_regions VALUES(1911, 116, 'RIX', 'Rīga', 'English');
INSERT INTO emkt_regions VALUES(1912, 116, 'SA', 'Saldus rajons', 'English');
INSERT INTO emkt_regions VALUES(1913, 116, 'TA', 'Talsu rajons', 'English');
INSERT INTO emkt_regions VALUES(1914, 116, 'TU', 'Tukuma rajons', 'English');
INSERT INTO emkt_regions VALUES(1915, 116, 'VE', 'Ventspils rajons', 'English');
INSERT INTO emkt_regions VALUES(1916, 116, 'VEN', 'Ventspils', 'English');
INSERT INTO emkt_regions VALUES(1917, 116, 'VK', 'Valkas rajons', 'English');
INSERT INTO emkt_regions VALUES(1918, 116, 'VM', 'Valmieras rajons', 'English');

INSERT INTO emkt_countries VALUES (117,'Lebanon','English','LB','LBN','');

INSERT INTO emkt_regions VALUES(4263, 117, 'NOCODE', 'Lebanon', 'English');

INSERT INTO emkt_countries VALUES (118,'Lesotho','English','LS','LSO','');

INSERT INTO emkt_regions VALUES(1919, 118, 'A', 'Maseru', 'English');
INSERT INTO emkt_regions VALUES(1920, 118, 'B', 'Butha-Buthe', 'English');
INSERT INTO emkt_regions VALUES(1921, 118, 'C', 'Leribe', 'English');
INSERT INTO emkt_regions VALUES(1922, 118, 'D', 'Berea', 'English');
INSERT INTO emkt_regions VALUES(1923, 118, 'E', 'Mafeteng', 'English');
INSERT INTO emkt_regions VALUES(1924, 118, 'F', 'Mohale\'s Hoek', 'English');
INSERT INTO emkt_regions VALUES(1925, 118, 'G', 'Quthing', 'English');
INSERT INTO emkt_regions VALUES(1926, 118, 'H', 'Qacha\'s Nek', 'English');
INSERT INTO emkt_regions VALUES(1927, 118, 'J', 'Mokhotlong', 'English');
INSERT INTO emkt_regions VALUES(1928, 118, 'K', 'Thaba-Tseka', 'English');

INSERT INTO emkt_countries VALUES (119,'Liberia','English','LR','LBR','');

INSERT INTO emkt_regions VALUES(1929, 119, 'BG', 'Bong', 'English');
INSERT INTO emkt_regions VALUES(1930, 119, 'BM', 'Bomi', 'English');
INSERT INTO emkt_regions VALUES(1931, 119, 'CM', 'Grand Cape Mount', 'English');
INSERT INTO emkt_regions VALUES(1932, 119, 'GB', 'Grand Bassa', 'English');
INSERT INTO emkt_regions VALUES(1933, 119, 'GG', 'Grand Gedeh', 'English');
INSERT INTO emkt_regions VALUES(1934, 119, 'GK', 'Grand Kru', 'English');
INSERT INTO emkt_regions VALUES(1935, 119, 'GP', 'Gbarpolu', 'English');
INSERT INTO emkt_regions VALUES(1936, 119, 'LO', 'Lofa', 'English');
INSERT INTO emkt_regions VALUES(1937, 119, 'MG', 'Margibi', 'English');
INSERT INTO emkt_regions VALUES(1938, 119, 'MO', 'Montserrado', 'English');
INSERT INTO emkt_regions VALUES(1939, 119, 'MY', 'Maryland', 'English');
INSERT INTO emkt_regions VALUES(1940, 119, 'NI', 'Nimba', 'English');
INSERT INTO emkt_regions VALUES(1941, 119, 'RG', 'River Gee', 'English');
INSERT INTO emkt_regions VALUES(1942, 119, 'RI', 'Rivercess', 'English');
INSERT INTO emkt_regions VALUES(1943, 119, 'SI', 'Sinoe', 'English');

INSERT INTO emkt_countries VALUES (120,'Libyan Arab Jamahiriya','English','LY','LBY','');

INSERT INTO emkt_regions VALUES(1944, 120, 'AJ', 'Ajdābiyā', 'English');
INSERT INTO emkt_regions VALUES(1945, 120, 'BA', 'Banghāzī', 'English');
INSERT INTO emkt_regions VALUES(1946, 120, 'BU', 'Al Buţnān', 'English');
INSERT INTO emkt_regions VALUES(1947, 120, 'BW', 'Banī Walīd', 'English');
INSERT INTO emkt_regions VALUES(1948, 120, 'DR', 'Darnah', 'English');
INSERT INTO emkt_regions VALUES(1949, 120, 'GD', 'Ghadāmis', 'English');
INSERT INTO emkt_regions VALUES(1950, 120, 'GR', 'Gharyān', 'English');
INSERT INTO emkt_regions VALUES(1951, 120, 'GT', 'Ghāt', 'English');
INSERT INTO emkt_regions VALUES(1952, 120, 'HZ', 'Al Ḩizām al Akhḑar', 'English');
INSERT INTO emkt_regions VALUES(1953, 120, 'JA', 'Al Jabal al Akhḑar', 'English');
INSERT INTO emkt_regions VALUES(1954, 120, 'JB', 'Jaghbūb', 'English');
INSERT INTO emkt_regions VALUES(1955, 120, 'JI', 'Al Jifārah', 'English');
INSERT INTO emkt_regions VALUES(1956, 120, 'JU', 'Al Jufrah', 'English');
INSERT INTO emkt_regions VALUES(1957, 120, 'KF', 'Al Kufrah', 'English');
INSERT INTO emkt_regions VALUES(1958, 120, 'MB', 'Al Marqab', 'English');
INSERT INTO emkt_regions VALUES(1959, 120, 'MI', 'Mişrātah', 'English');
INSERT INTO emkt_regions VALUES(1960, 120, 'MJ', 'Al Marj', 'English');
INSERT INTO emkt_regions VALUES(1961, 120, 'MQ', 'Murzuq', 'English');
INSERT INTO emkt_regions VALUES(1962, 120, 'MZ', 'Mizdah', 'English');
INSERT INTO emkt_regions VALUES(1963, 120, 'NL', 'Nālūt', 'English');
INSERT INTO emkt_regions VALUES(1964, 120, 'NQ', 'An Nuqaţ al Khams', 'English');
INSERT INTO emkt_regions VALUES(1965, 120, 'QB', 'Al Qubbah', 'English');
INSERT INTO emkt_regions VALUES(1966, 120, 'QT', 'Al Qaţrūn', 'English');
INSERT INTO emkt_regions VALUES(1967, 120, 'SB', 'Sabhā', 'English');
INSERT INTO emkt_regions VALUES(1968, 120, 'SH', 'Ash Shāţi', 'English');
INSERT INTO emkt_regions VALUES(1969, 120, 'SR', 'Surt', 'English');
INSERT INTO emkt_regions VALUES(1970, 120, 'SS', 'Şabrātah Şurmān', 'English');
INSERT INTO emkt_regions VALUES(1971, 120, 'TB', 'Ţarābulus', 'English');
INSERT INTO emkt_regions VALUES(1972, 120, 'TM', 'Tarhūnah-Masallātah', 'English');
INSERT INTO emkt_regions VALUES(1973, 120, 'TN', 'Tājūrā wa an Nawāḩī al Arbāʻ', 'English');
INSERT INTO emkt_regions VALUES(1974, 120, 'WA', 'Al Wāḩah', 'English');
INSERT INTO emkt_regions VALUES(1975, 120, 'WD', 'Wādī al Ḩayāt', 'English');
INSERT INTO emkt_regions VALUES(1976, 120, 'YJ', 'Yafran-Jādū', 'English');
INSERT INTO emkt_regions VALUES(1977, 120, 'ZA', 'Az Zāwiyah', 'English');

INSERT INTO emkt_countries VALUES (121,'Liechtenstein','English','LI','LIE','');

INSERT INTO emkt_regions VALUES(1978, 121, 'B', 'Balzers', 'English');
INSERT INTO emkt_regions VALUES(1979, 121, 'E', 'Eschen', 'English');
INSERT INTO emkt_regions VALUES(1980, 121, 'G', 'Gamprin', 'English');
INSERT INTO emkt_regions VALUES(1981, 121, 'M', 'Mauren', 'English');
INSERT INTO emkt_regions VALUES(1982, 121, 'P', 'Planken', 'English');
INSERT INTO emkt_regions VALUES(1983, 121, 'R', 'Ruggell', 'English');
INSERT INTO emkt_regions VALUES(1984, 121, 'A', 'Schaan', 'English');
INSERT INTO emkt_regions VALUES(1985, 121, 'L', 'Schellenberg', 'English');
INSERT INTO emkt_regions VALUES(1986, 121, 'N', 'Triesen', 'English');
INSERT INTO emkt_regions VALUES(1987, 121, 'T', 'Triesenberg', 'English');
INSERT INTO emkt_regions VALUES(1988, 121, 'V', 'Vaduz', 'English');

INSERT INTO emkt_countries VALUES (122,'Lithuania','English','LT','LTU','');

INSERT INTO emkt_regions VALUES(1989, 122, 'AL', 'Alytaus Apskritis', 'English');
INSERT INTO emkt_regions VALUES(1990, 122, 'KL', 'Klaipėdos Apskritis', 'English');
INSERT INTO emkt_regions VALUES(1991, 122, 'KU', 'Kauno Apskritis', 'English');
INSERT INTO emkt_regions VALUES(1992, 122, 'MR', 'Marijampolės Apskritis', 'English');
INSERT INTO emkt_regions VALUES(1993, 122, 'PN', 'Panevėžio Apskritis', 'English');
INSERT INTO emkt_regions VALUES(1994, 122, 'SA', 'Šiaulių Apskritis', 'English');
INSERT INTO emkt_regions VALUES(1995, 122, 'TA', 'Tauragės Apskritis', 'English');
INSERT INTO emkt_regions VALUES(1996, 122, 'TE', 'Telšių Apskritis', 'English');
INSERT INTO emkt_regions VALUES(1997, 122, 'UT', 'Utenos Apskritis', 'English');
INSERT INTO emkt_regions VALUES(1998, 122, 'VL', 'Vilniaus Apskritis', 'English');

INSERT INTO emkt_countries VALUES (123,'Luxembourg','English','LU','LUX','');

INSERT INTO emkt_regions VALUES(1999, 123, 'D', 'Diekirch', 'English');
INSERT INTO emkt_regions VALUES(2000, 123, 'G', 'Grevenmacher', 'English');
INSERT INTO emkt_regions VALUES(2001, 123, 'L', 'Luxemburg', 'English');

INSERT INTO emkt_countries VALUES (124,'Macau','English','MO','MAC','');

INSERT INTO emkt_regions VALUES(2002, 124, 'I', '海島市', 'English');
INSERT INTO emkt_regions VALUES(2003, 124, 'M', '澳門市', 'English');

INSERT INTO emkt_countries VALUES (125,'Macedonia','English','MK','MKD','');

INSERT INTO emkt_regions VALUES(2004, 125, 'BR', 'Berovo', 'English');
INSERT INTO emkt_regions VALUES(2005, 125, 'CH', 'Чешиново-Облешево', 'English');
INSERT INTO emkt_regions VALUES(2006, 125, 'DL', 'Делчево', 'English');
INSERT INTO emkt_regions VALUES(2007, 125, 'KB', 'Карбинци', 'English');
INSERT INTO emkt_regions VALUES(2008, 125, 'OC', 'Кочани', 'English');
INSERT INTO emkt_regions VALUES(2009, 125, 'LO', 'Лозово', 'English');
INSERT INTO emkt_regions VALUES(2010, 125, 'MK', 'Македонска каменица', 'English');
INSERT INTO emkt_regions VALUES(2011, 125, 'PH', 'Пехчево', 'English');
INSERT INTO emkt_regions VALUES(2012, 125, 'PT', 'Пробиштип', 'English');
INSERT INTO emkt_regions VALUES(2013, 125, 'ST', 'Штип', 'English');
INSERT INTO emkt_regions VALUES(2014, 125, 'SL', 'Свети Николе', 'English');
INSERT INTO emkt_regions VALUES(2015, 125, 'NI', 'Виница', 'English');
INSERT INTO emkt_regions VALUES(2016, 125, 'ZR', 'Зрновци', 'English');
INSERT INTO emkt_regions VALUES(2017, 125, 'KY', 'Кратово', 'English');
INSERT INTO emkt_regions VALUES(2018, 125, 'KZ', 'Крива Паланка', 'English');
INSERT INTO emkt_regions VALUES(2019, 125, 'UM', 'Куманово', 'English');
INSERT INTO emkt_regions VALUES(2020, 125, 'LI', 'Липково', 'English');
INSERT INTO emkt_regions VALUES(2021, 125, 'RN', 'Ранковце', 'English');
INSERT INTO emkt_regions VALUES(2022, 125, 'NA', 'Старо Нагоричане', 'English');
INSERT INTO emkt_regions VALUES(2023, 125, 'TL', 'Битола', 'English');
INSERT INTO emkt_regions VALUES(2024, 125, 'DM', 'Демир Хисар', 'English');
INSERT INTO emkt_regions VALUES(2025, 125, 'DE', 'Долнени', 'English');
INSERT INTO emkt_regions VALUES(2026, 125, 'KG', 'Кривогаштани', 'English');
INSERT INTO emkt_regions VALUES(2027, 125, 'KS', 'Крушево', 'English');
INSERT INTO emkt_regions VALUES(2028, 125, 'MG', 'Могила', 'English');
INSERT INTO emkt_regions VALUES(2029, 125, 'NV', 'Новаци', 'English');
INSERT INTO emkt_regions VALUES(2030, 125, 'PP', 'Прилеп', 'English');
INSERT INTO emkt_regions VALUES(2031, 125, 'RE', 'Ресен', 'English');
INSERT INTO emkt_regions VALUES(2032, 125, 'VJ', 'Боговиње', 'English');
INSERT INTO emkt_regions VALUES(2033, 125, 'BN', 'Брвеница', 'English');
INSERT INTO emkt_regions VALUES(2034, 125, 'GT', 'Гостивар', 'English');
INSERT INTO emkt_regions VALUES(2035, 125, 'JG', 'Јегуновце', 'English');
INSERT INTO emkt_regions VALUES(2036, 125, 'MR', 'Маврово и Ростуша', 'English');
INSERT INTO emkt_regions VALUES(2037, 125, 'TR', 'Теарце', 'English');
INSERT INTO emkt_regions VALUES(2038, 125, 'ET', 'Тетово', 'English');
INSERT INTO emkt_regions VALUES(2039, 125, 'VH', 'Врапчиште', 'English');
INSERT INTO emkt_regions VALUES(2040, 125, 'ZE', 'Желино', 'English');
INSERT INTO emkt_regions VALUES(2041, 125, 'AD', 'Аеродром', 'English');
INSERT INTO emkt_regions VALUES(2042, 125, 'AR', 'Арачиново', 'English');
INSERT INTO emkt_regions VALUES(2043, 125, 'BU', 'Бутел', 'English');
INSERT INTO emkt_regions VALUES(2044, 125, 'CI', 'Чаир', 'English');
INSERT INTO emkt_regions VALUES(2045, 125, 'CE', 'Центар', 'English');
INSERT INTO emkt_regions VALUES(2046, 125, 'CS', 'Чучер Сандево', 'English');
INSERT INTO emkt_regions VALUES(2047, 125, 'GB', 'Гази Баба', 'English');
INSERT INTO emkt_regions VALUES(2048, 125, 'GP', 'Ѓорче Петров', 'English');
INSERT INTO emkt_regions VALUES(2049, 125, 'IL', 'Илинден', 'English');
INSERT INTO emkt_regions VALUES(2050, 125, 'KX', 'Карпош', 'English');
INSERT INTO emkt_regions VALUES(2051, 125, 'VD', 'Кисела Вода', 'English');
INSERT INTO emkt_regions VALUES(2052, 125, 'PE', 'Петровец', 'English');
INSERT INTO emkt_regions VALUES(2053, 125, 'AJ', 'Сарај', 'English');
INSERT INTO emkt_regions VALUES(2054, 125, 'SS', 'Сопиште', 'English');
INSERT INTO emkt_regions VALUES(2055, 125, 'SU', 'Студеничани', 'English');
INSERT INTO emkt_regions VALUES(2056, 125, 'SO', 'Шуто Оризари', 'English');
INSERT INTO emkt_regions VALUES(2057, 125, 'ZK', 'Зелениково', 'English');
INSERT INTO emkt_regions VALUES(2058, 125, 'BG', 'Богданци', 'English');
INSERT INTO emkt_regions VALUES(2059, 125, 'BS', 'Босилово', 'English');
INSERT INTO emkt_regions VALUES(2060, 125, 'GV', 'Гевгелија', 'English');
INSERT INTO emkt_regions VALUES(2061, 125, 'KN', 'Конче', 'English');
INSERT INTO emkt_regions VALUES(2062, 125, 'NS', 'Ново Село', 'English');
INSERT INTO emkt_regions VALUES(2063, 125, 'RV', 'Радовиш', 'English');
INSERT INTO emkt_regions VALUES(2064, 125, 'SD', 'Стар Дојран', 'English');
INSERT INTO emkt_regions VALUES(2065, 125, 'RU', 'Струмица', 'English');
INSERT INTO emkt_regions VALUES(2066, 125, 'VA', 'Валандово', 'English');
INSERT INTO emkt_regions VALUES(2067, 125, 'VL', 'Василево', 'English');
INSERT INTO emkt_regions VALUES(2068, 125, 'CZ', 'Центар Жупа', 'English');
INSERT INTO emkt_regions VALUES(2069, 125, 'DB', 'Дебар', 'English');
INSERT INTO emkt_regions VALUES(2070, 125, 'DA', 'Дебарца', 'English');
INSERT INTO emkt_regions VALUES(2071, 125, 'DR', 'Другово', 'English');
INSERT INTO emkt_regions VALUES(2072, 125, 'KH', 'Кичево', 'English');
INSERT INTO emkt_regions VALUES(2073, 125, 'MD', 'Македонски Брод', 'English');
INSERT INTO emkt_regions VALUES(2074, 125, 'OD', 'Охрид', 'English');
INSERT INTO emkt_regions VALUES(2075, 125, 'OS', 'Осломеј', 'English');
INSERT INTO emkt_regions VALUES(2076, 125, 'PN', 'Пласница', 'English');
INSERT INTO emkt_regions VALUES(2077, 125, 'UG', 'Струга', 'English');
INSERT INTO emkt_regions VALUES(2078, 125, 'VV', 'Вевчани', 'English');
INSERT INTO emkt_regions VALUES(2079, 125, 'VC', 'Вранештица', 'English');
INSERT INTO emkt_regions VALUES(2080, 125, 'ZA', 'Зајас', 'English');
INSERT INTO emkt_regions VALUES(2081, 125, 'CA', 'Чашка', 'English');
INSERT INTO emkt_regions VALUES(2082, 125, 'DK', 'Демир Капија', 'English');
INSERT INTO emkt_regions VALUES(2083, 125, 'GR', 'Градско', 'English');
INSERT INTO emkt_regions VALUES(2084, 125, 'AV', 'Кавадарци', 'English');
INSERT INTO emkt_regions VALUES(2085, 125, 'NG', 'Неготино', 'English');
INSERT INTO emkt_regions VALUES(2086, 125, 'RM', 'Росоман', 'English');
INSERT INTO emkt_regions VALUES(2087, 125, 'VE', 'Велес', 'English');

INSERT INTO emkt_countries VALUES (126,'Madagascar','English','MG','MDG','');

INSERT INTO emkt_regions VALUES(2088, 126, 'A', 'Toamasina', 'English');
INSERT INTO emkt_regions VALUES(2089, 126, 'D', 'Antsiranana', 'English');
INSERT INTO emkt_regions VALUES(2090, 126, 'F', 'Fianarantsoa', 'English');
INSERT INTO emkt_regions VALUES(2091, 126, 'M', 'Mahajanga', 'English');
INSERT INTO emkt_regions VALUES(2092, 126, 'T', 'Antananarivo', 'English');
INSERT INTO emkt_regions VALUES(2093, 126, 'U', 'Toliara', 'English');

INSERT INTO emkt_countries VALUES (127,'Malawi','English','MW','MWI','');

INSERT INTO emkt_regions VALUES(2094, 127, 'BA', 'Balaka', 'English');
INSERT INTO emkt_regions VALUES(2095, 127, 'BL', 'Blantyre', 'English');
INSERT INTO emkt_regions VALUES(2096, 127, 'C', 'Central', 'English');
INSERT INTO emkt_regions VALUES(2097, 127, 'CK', 'Chikwawa', 'English');
INSERT INTO emkt_regions VALUES(2098, 127, 'CR', 'Chiradzulu', 'English');
INSERT INTO emkt_regions VALUES(2099, 127, 'CT', 'Chitipa', 'English');
INSERT INTO emkt_regions VALUES(2100, 127, 'DE', 'Dedza', 'English');
INSERT INTO emkt_regions VALUES(2101, 127, 'DO', 'Dowa', 'English');
INSERT INTO emkt_regions VALUES(2102, 127, 'KR', 'Karonga', 'English');
INSERT INTO emkt_regions VALUES(2103, 127, 'KS', 'Kasungu', 'English');
INSERT INTO emkt_regions VALUES(2104, 127, 'LK', 'Likoma Island', 'English');
INSERT INTO emkt_regions VALUES(2105, 127, 'LI', 'Lilongwe', 'English');
INSERT INTO emkt_regions VALUES(2106, 127, 'MH', 'Machinga', 'English');
INSERT INTO emkt_regions VALUES(2107, 127, 'MG', 'Mangochi', 'English');
INSERT INTO emkt_regions VALUES(2108, 127, 'MC', 'Mchinji', 'English');
INSERT INTO emkt_regions VALUES(2109, 127, 'MU', 'Mulanje', 'English');
INSERT INTO emkt_regions VALUES(2110, 127, 'MW', 'Mwanza', 'English');
INSERT INTO emkt_regions VALUES(2111, 127, 'MZ', 'Mzimba', 'English');
INSERT INTO emkt_regions VALUES(2112, 127, 'N', 'Northern', 'English');
INSERT INTO emkt_regions VALUES(2113, 127, 'NB', 'Nkhata', 'English');
INSERT INTO emkt_regions VALUES(2114, 127, 'NK', 'Nkhotakota', 'English');
INSERT INTO emkt_regions VALUES(2115, 127, 'NS', 'Nsanje', 'English');
INSERT INTO emkt_regions VALUES(2116, 127, 'NU', 'Ntcheu', 'English');
INSERT INTO emkt_regions VALUES(2117, 127, 'NI', 'Ntchisi', 'English');
INSERT INTO emkt_regions VALUES(2118, 127, 'PH', 'Phalombe', 'English');
INSERT INTO emkt_regions VALUES(2119, 127, 'RU', 'Rumphi', 'English');
INSERT INTO emkt_regions VALUES(2120, 127, 'S', 'Southern', 'English');
INSERT INTO emkt_regions VALUES(2121, 127, 'SA', 'Salima', 'English');
INSERT INTO emkt_regions VALUES(2122, 127, 'TH', 'Thyolo', 'English');
INSERT INTO emkt_regions VALUES(2123, 127, 'ZO', 'Zomba', 'English');

INSERT INTO emkt_countries VALUES (128,'Malaysia','English','MY','MYS','');

INSERT INTO emkt_regions VALUES(2124, 128, '01', 'Johor Darul Takzim', 'English');
INSERT INTO emkt_regions VALUES(2125, 128, '02', 'Kedah Darul Aman', 'English');
INSERT INTO emkt_regions VALUES(2126, 128, '03', 'Kelantan Darul Naim', 'English');
INSERT INTO emkt_regions VALUES(2127, 128, '04', 'Melaka Negeri Bersejarah', 'English');
INSERT INTO emkt_regions VALUES(2128, 128, '05', 'Negeri Sembilan Darul Khusus', 'English');
INSERT INTO emkt_regions VALUES(2129, 128, '06', 'Pahang Darul Makmur', 'English');
INSERT INTO emkt_regions VALUES(2130, 128, '07', 'Pulau Pinang', 'English');
INSERT INTO emkt_regions VALUES(2131, 128, '08', 'Perak Darul Ridzuan', 'English');
INSERT INTO emkt_regions VALUES(2132, 128, '09', 'Perlis Indera Kayangan', 'English');
INSERT INTO emkt_regions VALUES(2133, 128, '10', 'Selangor Darul Ehsan', 'English');
INSERT INTO emkt_regions VALUES(2134, 128, '11', 'Terengganu Darul Iman', 'English');
INSERT INTO emkt_regions VALUES(2135, 128, '12', 'Sabah Negeri Di Bawah Bayu', 'English');
INSERT INTO emkt_regions VALUES(2136, 128, '13', 'Sarawak Bumi Kenyalang', 'English');
INSERT INTO emkt_regions VALUES(2137, 128, '14', 'Wilayah Persekutuan Kuala Lumpur', 'English');
INSERT INTO emkt_regions VALUES(2138, 128, '15', 'Wilayah Persekutuan Labuan', 'English');
INSERT INTO emkt_regions VALUES(2139, 128, '16', 'Wilayah Persekutuan Putrajaya', 'English');

INSERT INTO emkt_countries VALUES (129,'Maldives','English','MV','MDV','');

INSERT INTO emkt_regions VALUES(2140, 129, 'THU', 'Thiladhunmathi Uthuru', 'English');
INSERT INTO emkt_regions VALUES(2141, 129, 'THD', 'Thiladhunmathi Dhekunu', 'English');
INSERT INTO emkt_regions VALUES(2142, 129, 'MLU', 'Miladhunmadulu Uthuru', 'English');
INSERT INTO emkt_regions VALUES(2143, 129, 'MLD', 'Miladhunmadulu Dhekunu', 'English');
INSERT INTO emkt_regions VALUES(2144, 129, 'MAU', 'Maalhosmadulu Uthuru', 'English');
INSERT INTO emkt_regions VALUES(2145, 129, 'MAD', 'Maalhosmadulu Dhekunu', 'English');
INSERT INTO emkt_regions VALUES(2146, 129, 'FAA', 'Faadhippolhu', 'English');
INSERT INTO emkt_regions VALUES(2147, 129, 'MAA', 'Male Atoll', 'English');
INSERT INTO emkt_regions VALUES(2148, 129, 'AAU', 'Ari Atoll Uthuru', 'English');
INSERT INTO emkt_regions VALUES(2149, 129, 'AAD', 'Ari Atoll Dheknu', 'English');
INSERT INTO emkt_regions VALUES(2150, 129, 'FEA', 'Felidhe Atoll', 'English');
INSERT INTO emkt_regions VALUES(2151, 129, 'MUA', 'Mulaku Atoll', 'English');
INSERT INTO emkt_regions VALUES(2152, 129, 'NAU', 'Nilandhe Atoll Uthuru', 'English');
INSERT INTO emkt_regions VALUES(2153, 129, 'NAD', 'Nilandhe Atoll Dhekunu', 'English');
INSERT INTO emkt_regions VALUES(2154, 129, 'KLH', 'Kolhumadulu', 'English');
INSERT INTO emkt_regions VALUES(2155, 129, 'HDH', 'Hadhdhunmathi', 'English');
INSERT INTO emkt_regions VALUES(2156, 129, 'HAU', 'Huvadhu Atoll Uthuru', 'English');
INSERT INTO emkt_regions VALUES(2157, 129, 'HAD', 'Huvadhu Atoll Dhekunu', 'English');
INSERT INTO emkt_regions VALUES(2158, 129, 'FMU', 'Fua Mulaku', 'English');
INSERT INTO emkt_regions VALUES(2159, 129, 'ADD', 'Addu', 'English');

INSERT INTO emkt_countries VALUES (130,'Mali','English','ML','MLI','');

INSERT INTO emkt_regions VALUES(2160, 130, '1', 'Kayes', 'English');
INSERT INTO emkt_regions VALUES(2161, 130, '2', 'Koulikoro', 'English');
INSERT INTO emkt_regions VALUES(2162, 130, '3', 'Sikasso', 'English');
INSERT INTO emkt_regions VALUES(2163, 130, '4', 'Ségou', 'English');
INSERT INTO emkt_regions VALUES(2164, 130, '5', 'Mopti', 'English');
INSERT INTO emkt_regions VALUES(2165, 130, '6', 'Tombouctou', 'English');
INSERT INTO emkt_regions VALUES(2166, 130, '7', 'Gao', 'English');
INSERT INTO emkt_regions VALUES(2167, 130, '8', 'Kidal', 'English');
INSERT INTO emkt_regions VALUES(2168, 130, 'BK0', 'Bamako', 'English');

INSERT INTO emkt_countries VALUES (131,'Malta','English','MT','MLT','');

INSERT INTO emkt_regions VALUES(2169, 131, 'ATT', 'Attard', 'English');
INSERT INTO emkt_regions VALUES(2170, 131, 'BAL', 'Balzan', 'English');
INSERT INTO emkt_regions VALUES(2171, 131, 'BGU', 'Birgu', 'English');
INSERT INTO emkt_regions VALUES(2172, 131, 'BKK', 'Birkirkara', 'English');
INSERT INTO emkt_regions VALUES(2173, 131, 'BRZ', 'Birzebbuga', 'English');
INSERT INTO emkt_regions VALUES(2174, 131, 'BOR', 'Bormla', 'English');
INSERT INTO emkt_regions VALUES(2175, 131, 'DIN', 'Dingli', 'English');
INSERT INTO emkt_regions VALUES(2176, 131, 'FGU', 'Fgura', 'English');
INSERT INTO emkt_regions VALUES(2177, 131, 'FLO', 'Floriana', 'English');
INSERT INTO emkt_regions VALUES(2178, 131, 'GDJ', 'Gudja', 'English');
INSERT INTO emkt_regions VALUES(2179, 131, 'GZR', 'Gzira', 'English');
INSERT INTO emkt_regions VALUES(2180, 131, 'GRG', 'Gargur', 'English');
INSERT INTO emkt_regions VALUES(2181, 131, 'GXQ', 'Gaxaq', 'English');
INSERT INTO emkt_regions VALUES(2182, 131, 'HMR', 'Hamrun', 'English');
INSERT INTO emkt_regions VALUES(2183, 131, 'IKL', 'Iklin', 'English');
INSERT INTO emkt_regions VALUES(2184, 131, 'ISL', 'Isla', 'English');
INSERT INTO emkt_regions VALUES(2185, 131, 'KLK', 'Kalkara', 'English');
INSERT INTO emkt_regions VALUES(2186, 131, 'KRK', 'Kirkop', 'English');
INSERT INTO emkt_regions VALUES(2187, 131, 'LIJ', 'Lija', 'English');
INSERT INTO emkt_regions VALUES(2188, 131, 'LUQ', 'Luqa', 'English');
INSERT INTO emkt_regions VALUES(2189, 131, 'MRS', 'Marsa', 'English');
INSERT INTO emkt_regions VALUES(2190, 131, 'MKL', 'Marsaskala', 'English');
INSERT INTO emkt_regions VALUES(2191, 131, 'MXL', 'Marsaxlokk', 'English');
INSERT INTO emkt_regions VALUES(2192, 131, 'MDN', 'Mdina', 'English');
INSERT INTO emkt_regions VALUES(2193, 131, 'MEL', 'Melliea', 'English');
INSERT INTO emkt_regions VALUES(2194, 131, 'MGR', 'Mgarr', 'English');
INSERT INTO emkt_regions VALUES(2195, 131, 'MST', 'Mosta', 'English');
INSERT INTO emkt_regions VALUES(2196, 131, 'MQA', 'Mqabba', 'English');
INSERT INTO emkt_regions VALUES(2197, 131, 'MSI', 'Msida', 'English');
INSERT INTO emkt_regions VALUES(2198, 131, 'MTF', 'Mtarfa', 'English');
INSERT INTO emkt_regions VALUES(2199, 131, 'NAX', 'Naxxar', 'English');
INSERT INTO emkt_regions VALUES(2200, 131, 'PAO', 'Paola', 'English');
INSERT INTO emkt_regions VALUES(2201, 131, 'PEM', 'Pembroke', 'English');
INSERT INTO emkt_regions VALUES(2202, 131, 'PIE', 'Pieta', 'English');
INSERT INTO emkt_regions VALUES(2203, 131, 'QOR', 'Qormi', 'English');
INSERT INTO emkt_regions VALUES(2204, 131, 'QRE', 'Qrendi', 'English');
INSERT INTO emkt_regions VALUES(2205, 131, 'RAB', 'Rabat', 'English');
INSERT INTO emkt_regions VALUES(2206, 131, 'SAF', 'Safi', 'English');
INSERT INTO emkt_regions VALUES(2207, 131, 'SGI', 'San Giljan', 'English');
INSERT INTO emkt_regions VALUES(2208, 131, 'SLU', 'Santa Lucija', 'English');
INSERT INTO emkt_regions VALUES(2209, 131, 'SPB', 'San Pawl il-Bahar', 'English');
INSERT INTO emkt_regions VALUES(2210, 131, 'SGW', 'San Gwann', 'English');
INSERT INTO emkt_regions VALUES(2211, 131, 'SVE', 'Santa Venera', 'English');
INSERT INTO emkt_regions VALUES(2212, 131, 'SIG', 'Siggiewi', 'English');
INSERT INTO emkt_regions VALUES(2213, 131, 'SLM', 'Sliema', 'English');
INSERT INTO emkt_regions VALUES(2214, 131, 'SWQ', 'Swieqi', 'English');
INSERT INTO emkt_regions VALUES(2215, 131, 'TXB', 'Ta Xbiex', 'English');
INSERT INTO emkt_regions VALUES(2216, 131, 'TRX', 'Tarxien', 'English');
INSERT INTO emkt_regions VALUES(2217, 131, 'VLT', 'Valletta', 'English');
INSERT INTO emkt_regions VALUES(2218, 131, 'XGJ', 'Xgajra', 'English');
INSERT INTO emkt_regions VALUES(2219, 131, 'ZBR', 'Zabbar', 'English');
INSERT INTO emkt_regions VALUES(2220, 131, 'ZBG', 'Zebbug', 'English');
INSERT INTO emkt_regions VALUES(2221, 131, 'ZJT', 'Zejtun', 'English');
INSERT INTO emkt_regions VALUES(2222, 131, 'ZRQ', 'Zurrieq', 'English');
INSERT INTO emkt_regions VALUES(2223, 131, 'FNT', 'Fontana', 'English');
INSERT INTO emkt_regions VALUES(2224, 131, 'GHJ', 'Ghajnsielem', 'English');
INSERT INTO emkt_regions VALUES(2225, 131, 'GHR', 'Gharb', 'English');
INSERT INTO emkt_regions VALUES(2226, 131, 'GHS', 'Ghasri', 'English');
INSERT INTO emkt_regions VALUES(2227, 131, 'KRC', 'Kercem', 'English');
INSERT INTO emkt_regions VALUES(2228, 131, 'MUN', 'Munxar', 'English');
INSERT INTO emkt_regions VALUES(2229, 131, 'NAD', 'Nadur', 'English');
INSERT INTO emkt_regions VALUES(2230, 131, 'QAL', 'Qala', 'English');
INSERT INTO emkt_regions VALUES(2231, 131, 'VIC', 'Victoria', 'English');
INSERT INTO emkt_regions VALUES(2232, 131, 'SLA', 'San Lawrenz', 'English');
INSERT INTO emkt_regions VALUES(2233, 131, 'SNT', 'Sannat', 'English');
INSERT INTO emkt_regions VALUES(2234, 131, 'ZAG', 'Xagra', 'English');
INSERT INTO emkt_regions VALUES(2235, 131, 'XEW', 'Xewkija', 'English');
INSERT INTO emkt_regions VALUES(2236, 131, 'ZEB', 'Zebbug', 'English');

INSERT INTO emkt_countries VALUES (132,'Marshall Islands','English','MH','MHL','');

INSERT INTO emkt_regions VALUES(2237, 132, 'ALK', 'Ailuk', 'English');
INSERT INTO emkt_regions VALUES(2238, 132, 'ALL', 'Ailinglapalap', 'English');
INSERT INTO emkt_regions VALUES(2239, 132, 'ARN', 'Arno', 'English');
INSERT INTO emkt_regions VALUES(2240, 132, 'AUR', 'Aur', 'English');
INSERT INTO emkt_regions VALUES(2241, 132, 'EBO', 'Ebon', 'English');
INSERT INTO emkt_regions VALUES(2242, 132, 'ENI', 'Eniwetok', 'English');
INSERT INTO emkt_regions VALUES(2243, 132, 'JAB', 'Jabat', 'English');
INSERT INTO emkt_regions VALUES(2244, 132, 'JAL', 'Jaluit', 'English');
INSERT INTO emkt_regions VALUES(2245, 132, 'KIL', 'Kili', 'English');
INSERT INTO emkt_regions VALUES(2246, 132, 'KWA', 'Kwajalein', 'English');
INSERT INTO emkt_regions VALUES(2247, 132, 'LAE', 'Lae', 'English');
INSERT INTO emkt_regions VALUES(2248, 132, 'LIB', 'Lib', 'English');
INSERT INTO emkt_regions VALUES(2249, 132, 'LIK', 'Likiep', 'English');
INSERT INTO emkt_regions VALUES(2250, 132, 'MAJ', 'Majuro', 'English');
INSERT INTO emkt_regions VALUES(2251, 132, 'MAL', 'Maloelap', 'English');
INSERT INTO emkt_regions VALUES(2252, 132, 'MEJ', 'Mejit', 'English');
INSERT INTO emkt_regions VALUES(2253, 132, 'MIL', 'Mili', 'English');
INSERT INTO emkt_regions VALUES(2254, 132, 'NMK', 'Namorik', 'English');
INSERT INTO emkt_regions VALUES(2255, 132, 'NMU', 'Namu', 'English');
INSERT INTO emkt_regions VALUES(2256, 132, 'RON', 'Rongelap', 'English');
INSERT INTO emkt_regions VALUES(2257, 132, 'UJA', 'Ujae', 'English');
INSERT INTO emkt_regions VALUES(2258, 132, 'UJL', 'Ujelang', 'English');
INSERT INTO emkt_regions VALUES(2259, 132, 'UTI', 'Utirik', 'English');
INSERT INTO emkt_regions VALUES(2260, 132, 'WTJ', 'Wotje', 'English');
INSERT INTO emkt_regions VALUES(2261, 132, 'WTN', 'Wotho', 'English');

INSERT INTO emkt_countries VALUES (133,'Martinique','English','MQ','MTQ','');

INSERT INTO emkt_regions VALUES(4264, 133, 'NOCODE', 'Martinique', 'English');

INSERT INTO emkt_countries VALUES (134,'Mauritania','English','MR','MRT','');

INSERT INTO emkt_regions VALUES(2262, 134, '01', 'ولاية الحوض الشرقي', 'English');
INSERT INTO emkt_regions VALUES(2263, 134, '02', 'ولاية الحوض الغربي', 'English');
INSERT INTO emkt_regions VALUES(2264, 134, '03', 'ولاية العصابة', 'English');
INSERT INTO emkt_regions VALUES(2265, 134, '04', 'ولاية كركول', 'English');
INSERT INTO emkt_regions VALUES(2266, 134, '05', 'ولاية البراكنة', 'English');
INSERT INTO emkt_regions VALUES(2267, 134, '06', 'ولاية الترارزة', 'English');
INSERT INTO emkt_regions VALUES(2268, 134, '07', 'ولاية آدرار', 'English');
INSERT INTO emkt_regions VALUES(2269, 134, '08', 'ولاية داخلت نواذيبو', 'English');
INSERT INTO emkt_regions VALUES(2270, 134, '09', 'ولاية تكانت', 'English');
INSERT INTO emkt_regions VALUES(2271, 134, '10', 'ولاية كيدي ماغة', 'English');
INSERT INTO emkt_regions VALUES(2272, 134, '11', 'ولاية تيرس زمور', 'English');
INSERT INTO emkt_regions VALUES(2273, 134, '12', 'ولاية إينشيري', 'English');
INSERT INTO emkt_regions VALUES(2274, 134, 'NKC', 'نواكشوط', 'English');

INSERT INTO emkt_countries VALUES (135,'Mauritius','English','MU','MUS','');

INSERT INTO emkt_regions VALUES(2275, 135, 'AG', 'Agalega Islands', 'English');
INSERT INTO emkt_regions VALUES(2276, 135, 'BL', 'Black River', 'English');
INSERT INTO emkt_regions VALUES(2277, 135, 'BR', 'Beau Bassin-Rose Hill', 'English');
INSERT INTO emkt_regions VALUES(2278, 135, 'CC', 'Cargados Carajos Shoals', 'English');
INSERT INTO emkt_regions VALUES(2279, 135, 'CU', 'Curepipe', 'English');
INSERT INTO emkt_regions VALUES(2280, 135, 'FL', 'Flacq', 'English');
INSERT INTO emkt_regions VALUES(2281, 135, 'GP', 'Grand Port', 'English');
INSERT INTO emkt_regions VALUES(2282, 135, 'MO', 'Moka', 'English');
INSERT INTO emkt_regions VALUES(2283, 135, 'PA', 'Pamplemousses', 'English');
INSERT INTO emkt_regions VALUES(2284, 135, 'PL', 'Port Louis', 'English');
INSERT INTO emkt_regions VALUES(2285, 135, 'PU', 'Port Louis City', 'English');
INSERT INTO emkt_regions VALUES(2286, 135, 'PW', 'Plaines Wilhems', 'English');
INSERT INTO emkt_regions VALUES(2287, 135, 'QB', 'Quatre Bornes', 'English');
INSERT INTO emkt_regions VALUES(2288, 135, 'RO', 'Rodrigues', 'English');
INSERT INTO emkt_regions VALUES(2289, 135, 'RR', 'Riviere du Rempart', 'English');
INSERT INTO emkt_regions VALUES(2290, 135, 'SA', 'Savanne', 'English');
INSERT INTO emkt_regions VALUES(2291, 135, 'VP', 'Vacoas-Phoenix', 'English');

INSERT INTO emkt_countries VALUES (136,'Mayotte','English','YT','MYT','');

INSERT INTO emkt_regions VALUES(4265, 136, 'NOCODE', 'Mayotte', 'English');

INSERT INTO emkt_countries VALUES (137,'Mexico','English','MX','MEX','');

INSERT INTO emkt_regions VALUES(2292, 137, 'AGU', 'Aguascalientes', 'English');
INSERT INTO emkt_regions VALUES(2293, 137, 'BCN', 'Baja California', 'English');
INSERT INTO emkt_regions VALUES(2294, 137, 'BCS', 'Baja California Sur', 'English');
INSERT INTO emkt_regions VALUES(2295, 137, 'CAM', 'Campeche', 'English');
INSERT INTO emkt_regions VALUES(2296, 137, 'CHH', 'Chihuahua', 'English');
INSERT INTO emkt_regions VALUES(2297, 137, 'CHP', 'Chiapas', 'English');
INSERT INTO emkt_regions VALUES(2298, 137, 'COA', 'Coahuila', 'English');
INSERT INTO emkt_regions VALUES(2299, 137, 'COL', 'Colima', 'English');
INSERT INTO emkt_regions VALUES(2300, 137, 'DIF', 'Distrito Federal', 'English');
INSERT INTO emkt_regions VALUES(2301, 137, 'DUR', 'Durango', 'English');
INSERT INTO emkt_regions VALUES(2302, 137, 'GRO', 'Guerrero', 'English');
INSERT INTO emkt_regions VALUES(2303, 137, 'GUA', 'Guanajuato', 'English');
INSERT INTO emkt_regions VALUES(2304, 137, 'HID', 'Hidalgo', 'English');
INSERT INTO emkt_regions VALUES(2305, 137, 'JAL', 'Jalisco', 'English');
INSERT INTO emkt_regions VALUES(2306, 137, 'MEX', 'Mexico', 'English');
INSERT INTO emkt_regions VALUES(2307, 137, 'MIC', 'Michoacán', 'English');
INSERT INTO emkt_regions VALUES(2308, 137, 'MOR', 'Morelos', 'English');
INSERT INTO emkt_regions VALUES(2309, 137, 'NAY', 'Nayarit', 'English');
INSERT INTO emkt_regions VALUES(2310, 137, 'NLE', 'Nuevo León', 'English');
INSERT INTO emkt_regions VALUES(2311, 137, 'OAX', 'Oaxaca', 'English');
INSERT INTO emkt_regions VALUES(2312, 137, 'PUE', 'Puebla', 'English');
INSERT INTO emkt_regions VALUES(2313, 137, 'QUE', 'Querétaro', 'English');
INSERT INTO emkt_regions VALUES(2314, 137, 'ROO', 'Quintana Roo', 'English');
INSERT INTO emkt_regions VALUES(2315, 137, 'SIN', 'Sinaloa', 'English');
INSERT INTO emkt_regions VALUES(2316, 137, 'SLP', 'San Luis Potosí', 'English');
INSERT INTO emkt_regions VALUES(2317, 137, 'SON', 'Sonora', 'English');
INSERT INTO emkt_regions VALUES(2318, 137, 'TAB', 'Tabasco', 'English');
INSERT INTO emkt_regions VALUES(2319, 137, 'TAM', 'Tamaulipas', 'English');
INSERT INTO emkt_regions VALUES(2320, 137, 'TLA', 'Tlaxcala', 'English');
INSERT INTO emkt_regions VALUES(2321, 137, 'VER', 'Veracruz', 'English');
INSERT INTO emkt_regions VALUES(2322, 137, 'YUC', 'Yucatan', 'English');
INSERT INTO emkt_regions VALUES(2323, 137, 'ZAC', 'Zacatecas', 'English');

INSERT INTO emkt_countries VALUES (138,'Micronesia','English','FM','FSM','');

INSERT INTO emkt_regions VALUES(2324, 138, 'KSA', 'Kosrae', 'English');
INSERT INTO emkt_regions VALUES(2325, 138, 'PNI', 'Pohnpei', 'English');
INSERT INTO emkt_regions VALUES(2326, 138, 'TRK', 'Chuuk', 'English');
INSERT INTO emkt_regions VALUES(2327, 138, 'YAP', 'Yap', 'English');

INSERT INTO emkt_countries VALUES (139,'Moldova','English','MD','MDA','');

INSERT INTO emkt_regions VALUES(2328, 139, 'BA', 'Bălţi', 'English');
INSERT INTO emkt_regions VALUES(2329, 139, 'CA', 'Cahul', 'English');
INSERT INTO emkt_regions VALUES(2330, 139, 'CU', 'Chişinău', 'English');
INSERT INTO emkt_regions VALUES(2331, 139, 'ED', 'Edineţ', 'English');
INSERT INTO emkt_regions VALUES(2332, 139, 'GA', 'Găgăuzia', 'English');
INSERT INTO emkt_regions VALUES(2333, 139, 'LA', 'Lăpuşna', 'English');
INSERT INTO emkt_regions VALUES(2334, 139, 'OR', 'Orhei', 'English');
INSERT INTO emkt_regions VALUES(2335, 139, 'SN', 'Stânga Nistrului', 'English');
INSERT INTO emkt_regions VALUES(2336, 139, 'SO', 'Soroca', 'English');
INSERT INTO emkt_regions VALUES(2337, 139, 'TI', 'Tighina', 'English');
INSERT INTO emkt_regions VALUES(2338, 139, 'UN', 'Ungheni', 'English');

INSERT INTO emkt_countries VALUES (140,'Monaco','English','MC','MCO','');

INSERT INTO emkt_regions VALUES(2339, 140, 'MC', 'Monte Carlo', 'English');
INSERT INTO emkt_regions VALUES(2340, 140, 'LR', 'La Rousse', 'English');
INSERT INTO emkt_regions VALUES(2341, 140, 'LA', 'Larvotto', 'English');
INSERT INTO emkt_regions VALUES(2342, 140, 'MV', 'Monaco Ville', 'English');
INSERT INTO emkt_regions VALUES(2343, 140, 'SM', 'Saint Michel', 'English');
INSERT INTO emkt_regions VALUES(2344, 140, 'CO', 'Condamine', 'English');
INSERT INTO emkt_regions VALUES(2345, 140, 'LC', 'La Colle', 'English');
INSERT INTO emkt_regions VALUES(2346, 140, 'RE', 'Les Révoires', 'English');
INSERT INTO emkt_regions VALUES(2347, 140, 'MO', 'Moneghetti', 'English');
INSERT INTO emkt_regions VALUES(2348, 140, 'FV', 'Fontvieille', 'English');

INSERT INTO emkt_countries VALUES (141,'Mongolia','English','MN','MNG','');

INSERT INTO emkt_regions VALUES(2349, 141, '1', 'Улаанбаатар', 'English');
INSERT INTO emkt_regions VALUES(2350, 141, '035', 'Орхон аймаг', 'English');
INSERT INTO emkt_regions VALUES(2351, 141, '037', 'Дархан-Уул аймаг', 'English');
INSERT INTO emkt_regions VALUES(2352, 141, '039', 'Хэнтий аймаг', 'English');
INSERT INTO emkt_regions VALUES(2353, 141, '041', 'Хөвсгөл аймаг', 'English');
INSERT INTO emkt_regions VALUES(2354, 141, '043', 'Ховд аймаг', 'English');
INSERT INTO emkt_regions VALUES(2355, 141, '046', 'Увс аймаг', 'English');
INSERT INTO emkt_regions VALUES(2356, 141, '047', 'Төв аймаг', 'English');
INSERT INTO emkt_regions VALUES(2357, 141, '049', 'Сэлэнгэ аймаг', 'English');
INSERT INTO emkt_regions VALUES(2358, 141, '051', 'Сүхбаатар аймаг', 'English');
INSERT INTO emkt_regions VALUES(2359, 141, '053', 'Өмнөговь аймаг', 'English');
INSERT INTO emkt_regions VALUES(2360, 141, '055', 'Өвөрхангай аймаг', 'English');
INSERT INTO emkt_regions VALUES(2361, 141, '057', 'Завхан аймаг', 'English');
INSERT INTO emkt_regions VALUES(2362, 141, '059', 'Дундговь аймаг', 'English');
INSERT INTO emkt_regions VALUES(2363, 141, '061', 'Дорнод аймаг', 'English');
INSERT INTO emkt_regions VALUES(2364, 141, '063', 'Дорноговь аймаг', 'English');
INSERT INTO emkt_regions VALUES(2365, 141, '064', 'Говьсүмбэр аймаг', 'English');
INSERT INTO emkt_regions VALUES(2366, 141, '065', 'Говь-Алтай аймаг', 'English');
INSERT INTO emkt_regions VALUES(2367, 141, '067', 'Булган аймаг', 'English');
INSERT INTO emkt_regions VALUES(2368, 141, '069', 'Баянхонгор аймаг', 'English');
INSERT INTO emkt_regions VALUES(2369, 141, '071', 'Баян Өлгий аймаг', 'English');
INSERT INTO emkt_regions VALUES(2370, 141, '073', 'Архангай аймаг', 'English');

INSERT INTO emkt_countries VALUES (142,'Montserrat','English','MS','MSR','');

INSERT INTO emkt_regions VALUES(2371, 142, 'A', 'Saint Anthony', 'English');
INSERT INTO emkt_regions VALUES(2372, 142, 'G', 'Saint Georges', 'English');
INSERT INTO emkt_regions VALUES(2373, 142, 'P', 'Saint Peter', 'English');

INSERT INTO emkt_countries VALUES (143,'Morocco','English','MA','MAR','');

INSERT INTO emkt_regions VALUES(4266, 143, 'NOCODE', 'Morocco', 'English');

INSERT INTO emkt_countries VALUES (144,'Mozambique','English','MZ','MOZ','');

INSERT INTO emkt_regions VALUES(2374, 144, 'A', 'Niassa', 'English');
INSERT INTO emkt_regions VALUES(2375, 144, 'B', 'Manica', 'English');
INSERT INTO emkt_regions VALUES(2376, 144, 'G', 'Gaza', 'English');
INSERT INTO emkt_regions VALUES(2377, 144, 'I', 'Inhambane', 'English');
INSERT INTO emkt_regions VALUES(2378, 144, 'L', 'Maputo', 'English');
INSERT INTO emkt_regions VALUES(2379, 144, 'MPM', 'Maputo cidade', 'English');
INSERT INTO emkt_regions VALUES(2380, 144, 'N', 'Nampula', 'English');
INSERT INTO emkt_regions VALUES(2381, 144, 'P', 'Cabo Delgado', 'English');
INSERT INTO emkt_regions VALUES(2382, 144, 'Q', 'Zambézia', 'English');
INSERT INTO emkt_regions VALUES(2383, 144, 'S', 'Sofala', 'English');
INSERT INTO emkt_regions VALUES(2384, 144, 'T', 'Tete', 'English');

INSERT INTO emkt_countries VALUES (145,'Myanmar','English','MM','MMR','');

INSERT INTO emkt_regions VALUES(2385, 145, 'AY', 'ဧရာ၀တီတိုင္‌း', 'English');
INSERT INTO emkt_regions VALUES(2386, 145, 'BG', 'ပဲခူးတုိင္‌း', 'English');
INSERT INTO emkt_regions VALUES(2387, 145, 'MG', 'မကေ္ဝးတိုင္‌း', 'English');
INSERT INTO emkt_regions VALUES(2388, 145, 'MD', 'မန္တလေးတုိင္‌း', 'English');
INSERT INTO emkt_regions VALUES(2389, 145, 'SG', 'စစ္‌ကုိင္‌း‌တုိင္‌း', 'English');
INSERT INTO emkt_regions VALUES(2390, 145, 'TN', 'တနင္သာရိတုိင္‌း', 'English');
INSERT INTO emkt_regions VALUES(2391, 145, 'YG', 'ရန္‌ကုန္‌တုိင္‌း', 'English');
INSERT INTO emkt_regions VALUES(2392, 145, 'CH', 'ခ္ယင္‌းပ္ရည္‌နယ္‌', 'English');
INSERT INTO emkt_regions VALUES(2393, 145, 'KC', 'ကခ္ယင္‌ပ္ရည္‌နယ္‌', 'English');
INSERT INTO emkt_regions VALUES(2394, 145, 'KH', 'ကယား‌ပ္ရည္‌နယ္‌', 'English');
INSERT INTO emkt_regions VALUES(2395, 145, 'KN', 'ကရင္‌‌ပ္ရည္‌နယ္‌', 'English');
INSERT INTO emkt_regions VALUES(2396, 145, 'MN', 'မ္ဝန္‌ပ္ရည္‌နယ္‌', 'English');
INSERT INTO emkt_regions VALUES(2397, 145, 'RK', 'ရခုိင္‌ပ္ရည္‌နယ္‌', 'English');
INSERT INTO emkt_regions VALUES(2398, 145, 'SH', 'ရုမ္‌းပ္ရည္‌နယ္‌', 'English');

INSERT INTO emkt_countries VALUES (146,'Namibia','English','NA','NAM','');

INSERT INTO emkt_regions VALUES(2399, 146, 'CA', 'Caprivi', 'English');
INSERT INTO emkt_regions VALUES(2400, 146, 'ER', 'Erongo', 'English');
INSERT INTO emkt_regions VALUES(2401, 146, 'HA', 'Hardap', 'English');
INSERT INTO emkt_regions VALUES(2402, 146, 'KA', 'Karas', 'English');
INSERT INTO emkt_regions VALUES(2403, 146, 'KH', 'Khomas', 'English');
INSERT INTO emkt_regions VALUES(2404, 146, 'KU', 'Kunene', 'English');
INSERT INTO emkt_regions VALUES(2405, 146, 'OD', 'Otjozondjupa', 'English');
INSERT INTO emkt_regions VALUES(2406, 146, 'OH', 'Omaheke', 'English');
INSERT INTO emkt_regions VALUES(2407, 146, 'OK', 'Okavango', 'English');
INSERT INTO emkt_regions VALUES(2408, 146, 'ON', 'Oshana', 'English');
INSERT INTO emkt_regions VALUES(2409, 146, 'OS', 'Omusati', 'English');
INSERT INTO emkt_regions VALUES(2410, 146, 'OT', 'Oshikoto', 'English');
INSERT INTO emkt_regions VALUES(2411, 146, 'OW', 'Ohangwena', 'English');

INSERT INTO emkt_countries VALUES (147,'Nauru','English','NR','NRU','');

INSERT INTO emkt_regions VALUES(2412, 147, 'AO', 'Aiwo', 'English');
INSERT INTO emkt_regions VALUES(2413, 147, 'AA', 'Anabar', 'English');
INSERT INTO emkt_regions VALUES(2414, 147, 'AT', 'Anetan', 'English');
INSERT INTO emkt_regions VALUES(2415, 147, 'AI', 'Anibare', 'English');
INSERT INTO emkt_regions VALUES(2416, 147, 'BA', 'Baiti', 'English');
INSERT INTO emkt_regions VALUES(2417, 147, 'BO', 'Boe', 'English');
INSERT INTO emkt_regions VALUES(2418, 147, 'BU', 'Buada', 'English');
INSERT INTO emkt_regions VALUES(2419, 147, 'DE', 'Denigomodu', 'English');
INSERT INTO emkt_regions VALUES(2420, 147, 'EW', 'Ewa', 'English');
INSERT INTO emkt_regions VALUES(2421, 147, 'IJ', 'Ijuw', 'English');
INSERT INTO emkt_regions VALUES(2422, 147, 'ME', 'Meneng', 'English');
INSERT INTO emkt_regions VALUES(2423, 147, 'NI', 'Nibok', 'English');
INSERT INTO emkt_regions VALUES(2424, 147, 'UA', 'Uaboe', 'English');
INSERT INTO emkt_regions VALUES(2425, 147, 'YA', 'Yaren', 'English');

INSERT INTO emkt_countries VALUES (148,'Nepal','English','NP','NPL','');

INSERT INTO emkt_regions VALUES(2426, 148, 'BA', 'Bagmati', 'English');
INSERT INTO emkt_regions VALUES(2427, 148, 'BH', 'Bheri', 'English');
INSERT INTO emkt_regions VALUES(2428, 148, 'DH', 'Dhawalagiri', 'English');
INSERT INTO emkt_regions VALUES(2429, 148, 'GA', 'Gandaki', 'English');
INSERT INTO emkt_regions VALUES(2430, 148, 'JA', 'Janakpur', 'English');
INSERT INTO emkt_regions VALUES(2431, 148, 'KA', 'Karnali', 'English');
INSERT INTO emkt_regions VALUES(2432, 148, 'KO', 'Kosi', 'English');
INSERT INTO emkt_regions VALUES(2433, 148, 'LU', 'Lumbini', 'English');
INSERT INTO emkt_regions VALUES(2434, 148, 'MA', 'Mahakali', 'English');
INSERT INTO emkt_regions VALUES(2435, 148, 'ME', 'Mechi', 'English');
INSERT INTO emkt_regions VALUES(2436, 148, 'NA', 'Narayani', 'English');
INSERT INTO emkt_regions VALUES(2437, 148, 'RA', 'Rapti', 'English');
INSERT INTO emkt_regions VALUES(2438, 148, 'SA', 'Sagarmatha', 'English');
INSERT INTO emkt_regions VALUES(2439, 148, 'SE', 'Seti', 'English');

INSERT INTO emkt_countries VALUES (149,'Netherlands','English','NL','NLD','');

INSERT INTO emkt_regions VALUES(2440, 149, 'DR', 'Drenthe', 'English');
INSERT INTO emkt_regions VALUES(2441, 149, 'FL', 'Flevoland', 'English');
INSERT INTO emkt_regions VALUES(2442, 149, 'FR', 'Friesland', 'English');
INSERT INTO emkt_regions VALUES(2443, 149, 'GE', 'Gelderland', 'English');
INSERT INTO emkt_regions VALUES(2444, 149, 'GR', 'Groningen', 'English');
INSERT INTO emkt_regions VALUES(2445, 149, 'LI', 'Limburg', 'English');
INSERT INTO emkt_regions VALUES(2446, 149, 'NB', 'Noord-Brabant', 'English');
INSERT INTO emkt_regions VALUES(2447, 149, 'NH', 'Noord-Holland', 'English');
INSERT INTO emkt_regions VALUES(2448, 149, 'OV', 'Overijssel', 'English');
INSERT INTO emkt_regions VALUES(2449, 149, 'UT', 'Utrecht', 'English');
INSERT INTO emkt_regions VALUES(2450, 149, 'ZE', 'Zeeland', 'English');
INSERT INTO emkt_regions VALUES(2451, 149, 'ZH', 'Zuid-Holland', 'English');

INSERT INTO emkt_countries VALUES (150,'Netherlands Antilles','English','AN','ANT','');

INSERT INTO emkt_regions VALUES(4267, 150, 'NOCODE', 'Netherlands Antilles', 'English');

INSERT INTO emkt_countries VALUES (151,'New Caledonia','English','NC','NCL','');

INSERT INTO emkt_regions VALUES(2452, 151, 'L', 'Province des Îles', 'English');
INSERT INTO emkt_regions VALUES(2453, 151, 'N', 'Province Nord', 'English');
INSERT INTO emkt_regions VALUES(2454, 151, 'S', 'Province Sud', 'English');

INSERT INTO emkt_countries VALUES (152,'New Zealand','English','NZ','NZL','');

INSERT INTO emkt_regions VALUES(2455, 152, 'AUK', 'Auckland', 'English');
INSERT INTO emkt_regions VALUES(2456, 152, 'BOP', 'Bay of Plenty', 'English');
INSERT INTO emkt_regions VALUES(2457, 152, 'CAN', 'Canterbury', 'English');
INSERT INTO emkt_regions VALUES(2458, 152, 'GIS', 'Gisborne', 'English');
INSERT INTO emkt_regions VALUES(2459, 152, 'HKB', 'Hawke\'s Bay', 'English');
INSERT INTO emkt_regions VALUES(2460, 152, 'MBH', 'Marlborough', 'English');
INSERT INTO emkt_regions VALUES(2461, 152, 'MWT', 'Manawatu-Wanganui', 'English');
INSERT INTO emkt_regions VALUES(2462, 152, 'NSN', 'Nelson', 'English');
INSERT INTO emkt_regions VALUES(2463, 152, 'NTL', 'Northland', 'English');
INSERT INTO emkt_regions VALUES(2464, 152, 'OTA', 'Otago', 'English');
INSERT INTO emkt_regions VALUES(2465, 152, 'STL', 'Southland', 'English');
INSERT INTO emkt_regions VALUES(2466, 152, 'TAS', 'Tasman', 'English');
INSERT INTO emkt_regions VALUES(2467, 152, 'TKI', 'Taranaki', 'English');
INSERT INTO emkt_regions VALUES(2468, 152, 'WGN', 'Wellington', 'English');
INSERT INTO emkt_regions VALUES(2469, 152, 'WKO', 'Waikato', 'English');
INSERT INTO emkt_regions VALUES(2470, 152, 'WTC', 'West Coast', 'English');

INSERT INTO emkt_countries VALUES (153,'Nicaragua','English','NI','NIC','');

INSERT INTO emkt_regions VALUES(2471, 153, 'AN', 'Atlántico Norte', 'English');
INSERT INTO emkt_regions VALUES(2472, 153, 'AS', 'Atlántico Sur', 'English');
INSERT INTO emkt_regions VALUES(2473, 153, 'BO', 'Boaco', 'English');
INSERT INTO emkt_regions VALUES(2474, 153, 'CA', 'Carazo', 'English');
INSERT INTO emkt_regions VALUES(2475, 153, 'CI', 'Chinandega', 'English');
INSERT INTO emkt_regions VALUES(2476, 153, 'CO', 'Chontales', 'English');
INSERT INTO emkt_regions VALUES(2477, 153, 'ES', 'Estelí', 'English');
INSERT INTO emkt_regions VALUES(2478, 153, 'GR', 'Granada', 'English');
INSERT INTO emkt_regions VALUES(2479, 153, 'JI', 'Jinotega', 'English');
INSERT INTO emkt_regions VALUES(2480, 153, 'LE', 'León', 'English');
INSERT INTO emkt_regions VALUES(2481, 153, 'MD', 'Madriz', 'English');
INSERT INTO emkt_regions VALUES(2482, 153, 'MN', 'Managua', 'English');
INSERT INTO emkt_regions VALUES(2483, 153, 'MS', 'Masaya', 'English');
INSERT INTO emkt_regions VALUES(2484, 153, 'MT', 'Matagalpa', 'English');
INSERT INTO emkt_regions VALUES(2485, 153, 'NS', 'Nueva Segovia', 'English');
INSERT INTO emkt_regions VALUES(2486, 153, 'RI', 'Rivas', 'English');
INSERT INTO emkt_regions VALUES(2487, 153, 'SJ', 'Río San Juan', 'English');

INSERT INTO emkt_countries VALUES (154,'Niger','English','NE','NER','');

INSERT INTO emkt_regions VALUES(2488, 154, '1', 'Agadez', 'English');
INSERT INTO emkt_regions VALUES(2489, 154, '2', 'Daffa', 'English');
INSERT INTO emkt_regions VALUES(2490, 154, '3', 'Dosso', 'English');
INSERT INTO emkt_regions VALUES(2491, 154, '4', 'Maradi', 'English');
INSERT INTO emkt_regions VALUES(2492, 154, '5', 'Tahoua', 'English');
INSERT INTO emkt_regions VALUES(2493, 154, '6', 'Tillabéry', 'English');
INSERT INTO emkt_regions VALUES(2494, 154, '7', 'Zinder', 'English');
INSERT INTO emkt_regions VALUES(2495, 154, '8', 'Niamey', 'English');

INSERT INTO emkt_countries VALUES (155,'Nigeria','English','NG','NGA','');

INSERT INTO emkt_regions VALUES(2496, 155, 'AB', 'Abia State', 'English');
INSERT INTO emkt_regions VALUES(2497, 155, 'AD', 'Adamawa State', 'English');
INSERT INTO emkt_regions VALUES(2498, 155, 'AK', 'Akwa Ibom State', 'English');
INSERT INTO emkt_regions VALUES(2499, 155, 'AN', 'Anambra State', 'English');
INSERT INTO emkt_regions VALUES(2500, 155, 'BA', 'Bauchi State', 'English');
INSERT INTO emkt_regions VALUES(2501, 155, 'BE', 'Benue State', 'English');
INSERT INTO emkt_regions VALUES(2502, 155, 'BO', 'Borno State', 'English');
INSERT INTO emkt_regions VALUES(2503, 155, 'BY', 'Bayelsa State', 'English');
INSERT INTO emkt_regions VALUES(2504, 155, 'CR', 'Cross River State', 'English');
INSERT INTO emkt_regions VALUES(2505, 155, 'DE', 'Delta State', 'English');
INSERT INTO emkt_regions VALUES(2506, 155, 'EB', 'Ebonyi State', 'English');
INSERT INTO emkt_regions VALUES(2507, 155, 'ED', 'Edo State', 'English');
INSERT INTO emkt_regions VALUES(2508, 155, 'EK', 'Ekiti State', 'English');
INSERT INTO emkt_regions VALUES(2509, 155, 'EN', 'Enugu State', 'English');
INSERT INTO emkt_regions VALUES(2510, 155, 'GO', 'Gombe State', 'English');
INSERT INTO emkt_regions VALUES(2511, 155, 'IM', 'Imo State', 'English');
INSERT INTO emkt_regions VALUES(2512, 155, 'JI', 'Jigawa State', 'English');
INSERT INTO emkt_regions VALUES(2513, 155, 'KB', 'Kebbi State', 'English');
INSERT INTO emkt_regions VALUES(2514, 155, 'KD', 'Kaduna State', 'English');
INSERT INTO emkt_regions VALUES(2515, 155, 'KN', 'Kano State', 'English');
INSERT INTO emkt_regions VALUES(2516, 155, 'KO', 'Kogi State', 'English');
INSERT INTO emkt_regions VALUES(2517, 155, 'KT', 'Katsina State', 'English');
INSERT INTO emkt_regions VALUES(2518, 155, 'KW', 'Kwara State', 'English');
INSERT INTO emkt_regions VALUES(2519, 155, 'LA', 'Lagos State', 'English');
INSERT INTO emkt_regions VALUES(2520, 155, 'NA', 'Nassarawa State', 'English');
INSERT INTO emkt_regions VALUES(2521, 155, 'NI', 'Niger State', 'English');
INSERT INTO emkt_regions VALUES(2522, 155, 'OG', 'Ogun State', 'English');
INSERT INTO emkt_regions VALUES(2523, 155, 'ON', 'Ondo State', 'English');
INSERT INTO emkt_regions VALUES(2524, 155, 'OS', 'Osun State', 'English');
INSERT INTO emkt_regions VALUES(2525, 155, 'OY', 'Oyo State', 'English');
INSERT INTO emkt_regions VALUES(2526, 155, 'PL', 'Plateau State', 'English');
INSERT INTO emkt_regions VALUES(2527, 155, 'RI', 'Rivers State', 'English');
INSERT INTO emkt_regions VALUES(2528, 155, 'SO', 'Sokoto State', 'English');
INSERT INTO emkt_regions VALUES(2529, 155, 'TA', 'Taraba State', 'English');
INSERT INTO emkt_regions VALUES(2530, 155, 'ZA', 'Zamfara State', 'English');

INSERT INTO emkt_countries VALUES (156,'Niue','English','NU','NIU','');

INSERT INTO emkt_regions VALUES(4268, 156, 'NOCODE', 'Niue', 'English');

INSERT INTO emkt_countries VALUES (157,'Norfolk Island','English','NF','NFK','');

INSERT INTO emkt_regions VALUES(4269, 157, 'NOCODE', 'Norfolk Island', 'English');

INSERT INTO emkt_countries VALUES (158,'Northern Mariana Islands','English','MP','MNP','');

INSERT INTO emkt_regions VALUES(2531, 158, 'N', 'Northern Islands', 'English');
INSERT INTO emkt_regions VALUES(2532, 158, 'R', 'Rota', 'English');
INSERT INTO emkt_regions VALUES(2533, 158, 'S', 'Saipan', 'English');
INSERT INTO emkt_regions VALUES(2534, 158, 'T', 'Tinian', 'English');

INSERT INTO emkt_countries VALUES (159,'Norway','English','NO','NOR','');

INSERT INTO emkt_regions VALUES(2535, 159, '01', 'Østfold fylke', 'English');
INSERT INTO emkt_regions VALUES(2536, 159, '02', 'Akershus fylke', 'English');
INSERT INTO emkt_regions VALUES(2537, 159, '03', 'Oslo fylke', 'English');
INSERT INTO emkt_regions VALUES(2538, 159, '04', 'Hedmark fylke', 'English');
INSERT INTO emkt_regions VALUES(2539, 159, '05', 'Oppland fylke', 'English');
INSERT INTO emkt_regions VALUES(2540, 159, '06', 'Buskerud fylke', 'English');
INSERT INTO emkt_regions VALUES(2541, 159, '07', 'Vestfold fylke', 'English');
INSERT INTO emkt_regions VALUES(2542, 159, '08', 'Telemark fylke', 'English');
INSERT INTO emkt_regions VALUES(2543, 159, '09', 'Aust-Agder fylke', 'English');
INSERT INTO emkt_regions VALUES(2544, 159, '10', 'Vest-Agder fylke', 'English');
INSERT INTO emkt_regions VALUES(2545, 159, '11', 'Rogaland fylke', 'English');
INSERT INTO emkt_regions VALUES(2546, 159, '12', 'Hordaland fylke', 'English');
INSERT INTO emkt_regions VALUES(2547, 159, '14', 'Sogn og Fjordane fylke', 'English');
INSERT INTO emkt_regions VALUES(2548, 159, '15', 'Møre og Romsdal fylke', 'English');
INSERT INTO emkt_regions VALUES(2549, 159, '16', 'Sør-Trøndelag fylke', 'English');
INSERT INTO emkt_regions VALUES(2550, 159, '17', 'Nord-Trøndelag fylke', 'English');
INSERT INTO emkt_regions VALUES(2551, 159, '18', 'Nordland fylke', 'English');
INSERT INTO emkt_regions VALUES(2552, 159, '19', 'Troms fylke', 'English');
INSERT INTO emkt_regions VALUES(2553, 159, '20', 'Finnmark fylke', 'English');

INSERT INTO emkt_countries VALUES (160,'Oman','English','OM','OMN','');

INSERT INTO emkt_regions VALUES(2554, 160, 'BA', 'الباطنة', 'English');
INSERT INTO emkt_regions VALUES(2555, 160, 'DA', 'الداخلية', 'English');
INSERT INTO emkt_regions VALUES(2556, 160, 'DH', 'ظفار', 'English');
INSERT INTO emkt_regions VALUES(2557, 160, 'MA', 'مسقط', 'English');
INSERT INTO emkt_regions VALUES(2558, 160, 'MU', 'مسندم', 'English');
INSERT INTO emkt_regions VALUES(2559, 160, 'SH', 'الشرقية', 'English');
INSERT INTO emkt_regions VALUES(2560, 160, 'WU', 'الوسطى', 'English');
INSERT INTO emkt_regions VALUES(2561, 160, 'ZA', 'الظاهرة', 'English');

INSERT INTO emkt_countries VALUES (161,'Pakistan','English','PK','PAK','');

INSERT INTO emkt_regions VALUES(2562, 161, 'BA', 'بلوچستان', 'English');
INSERT INTO emkt_regions VALUES(2563, 161, 'IS', 'وفاقی دارالحکومت', 'English');
INSERT INTO emkt_regions VALUES(2564, 161, 'JK', 'آزاد کشمیر', 'English');
INSERT INTO emkt_regions VALUES(2565, 161, 'NA', 'شمالی علاقہ جات', 'English');
INSERT INTO emkt_regions VALUES(2566, 161, 'NW', 'شمال مغربی سرحدی صوبہ', 'English');
INSERT INTO emkt_regions VALUES(2567, 161, 'PB', 'پنجاب', 'English');
INSERT INTO emkt_regions VALUES(2568, 161, 'SD', 'سندھ', 'English');
INSERT INTO emkt_regions VALUES(2569, 161, 'TA', 'وفاقی قبائلی علاقہ جات', 'English');

INSERT INTO emkt_countries VALUES (162,'Palau','English','PW','PLW','');

INSERT INTO emkt_regions VALUES(2570, 162, 'AM', 'Aimeliik', 'English');
INSERT INTO emkt_regions VALUES(2571, 162, 'AR', 'Airai', 'English');
INSERT INTO emkt_regions VALUES(2572, 162, 'AN', 'Angaur', 'English');
INSERT INTO emkt_regions VALUES(2573, 162, 'HA', 'Hatohobei', 'English');
INSERT INTO emkt_regions VALUES(2574, 162, 'KA', 'Kayangel', 'English');
INSERT INTO emkt_regions VALUES(2575, 162, 'KO', 'Koror', 'English');
INSERT INTO emkt_regions VALUES(2576, 162, 'ME', 'Melekeok', 'English');
INSERT INTO emkt_regions VALUES(2577, 162, 'NA', 'Ngaraard', 'English');
INSERT INTO emkt_regions VALUES(2578, 162, 'NG', 'Ngarchelong', 'English');
INSERT INTO emkt_regions VALUES(2579, 162, 'ND', 'Ngardmau', 'English');
INSERT INTO emkt_regions VALUES(2580, 162, 'NT', 'Ngatpang', 'English');
INSERT INTO emkt_regions VALUES(2581, 162, 'NC', 'Ngchesar', 'English');
INSERT INTO emkt_regions VALUES(2582, 162, 'NR', 'Ngeremlengui', 'English');
INSERT INTO emkt_regions VALUES(2583, 162, 'NW', 'Ngiwal', 'English');
INSERT INTO emkt_regions VALUES(2584, 162, 'PE', 'Peleliu', 'English');
INSERT INTO emkt_regions VALUES(2585, 162, 'SO', 'Sonsorol', 'English');

INSERT INTO emkt_countries VALUES (163,'Panama','English','PA','PAN','');

INSERT INTO emkt_regions VALUES(2586, 163, '1', 'Bocas del Toro', 'English');
INSERT INTO emkt_regions VALUES(2587, 163, '2', 'Coclé', 'English');
INSERT INTO emkt_regions VALUES(2588, 163, '3', 'Colón', 'English');
INSERT INTO emkt_regions VALUES(2589, 163, '4', 'Chiriquí', 'English');
INSERT INTO emkt_regions VALUES(2590, 163, '5', 'Darién', 'English');
INSERT INTO emkt_regions VALUES(2591, 163, '6', 'Herrera', 'English');
INSERT INTO emkt_regions VALUES(2592, 163, '7', 'Los Santos', 'English');
INSERT INTO emkt_regions VALUES(2593, 163, '8', 'Panamá', 'English');
INSERT INTO emkt_regions VALUES(2594, 163, '9', 'Veraguas', 'English');
INSERT INTO emkt_regions VALUES(2595, 163, 'Q', 'Kuna Yala', 'English');

INSERT INTO emkt_countries VALUES (164,'Papua New Guinea','English','PG','PNG','');

INSERT INTO emkt_regions VALUES(2596, 164, 'CPK', 'Chimbu', 'English');
INSERT INTO emkt_regions VALUES(2597, 164, 'CPM', 'Central', 'English');
INSERT INTO emkt_regions VALUES(2598, 164, 'EBR', 'East New Britain', 'English');
INSERT INTO emkt_regions VALUES(2599, 164, 'EHG', 'Eastern Highlands', 'English');
INSERT INTO emkt_regions VALUES(2600, 164, 'EPW', 'Enga', 'English');
INSERT INTO emkt_regions VALUES(2601, 164, 'ESW', 'East Sepik', 'English');
INSERT INTO emkt_regions VALUES(2602, 164, 'GPK', 'Gulf', 'English');
INSERT INTO emkt_regions VALUES(2603, 164, 'MBA', 'Milne Bay', 'English');
INSERT INTO emkt_regions VALUES(2604, 164, 'MPL', 'Morobe', 'English');
INSERT INTO emkt_regions VALUES(2605, 164, 'MPM', 'Madang', 'English');
INSERT INTO emkt_regions VALUES(2606, 164, 'MRL', 'Manus', 'English');
INSERT INTO emkt_regions VALUES(2607, 164, 'NCD', 'National Capital District', 'English');
INSERT INTO emkt_regions VALUES(2608, 164, 'NIK', 'New Ireland', 'English');
INSERT INTO emkt_regions VALUES(2609, 164, 'NPP', 'Northern', 'English');
INSERT INTO emkt_regions VALUES(2610, 164, 'NSA', 'North Solomons', 'English');
INSERT INTO emkt_regions VALUES(2611, 164, 'SAN', 'Sandaun', 'English');
INSERT INTO emkt_regions VALUES(2612, 164, 'SHM', 'Southern Highlands', 'English');
INSERT INTO emkt_regions VALUES(2613, 164, 'WBK', 'West New Britain', 'English');
INSERT INTO emkt_regions VALUES(2614, 164, 'WHM', 'Western Highlands', 'English');
INSERT INTO emkt_regions VALUES(2615, 164, 'WPD', 'Western', 'English');

INSERT INTO emkt_countries VALUES (165,'Paraguay','English','PY','PRY','');

INSERT INTO emkt_regions VALUES(2616, 165, '1', 'Concepción', 'English');
INSERT INTO emkt_regions VALUES(2617, 165, '2', 'San Pedro', 'English');
INSERT INTO emkt_regions VALUES(2618, 165, '3', 'Cordillera', 'English');
INSERT INTO emkt_regions VALUES(2619, 165, '4', 'Guairá', 'English');
INSERT INTO emkt_regions VALUES(2620, 165, '5', 'Caaguazú', 'English');
INSERT INTO emkt_regions VALUES(2621, 165, '6', 'Caazapá', 'English');
INSERT INTO emkt_regions VALUES(2622, 165, '7', 'Itapúa', 'English');
INSERT INTO emkt_regions VALUES(2623, 165, '8', 'Misiones', 'English');
INSERT INTO emkt_regions VALUES(2624, 165, '9', 'Paraguarí', 'English');
INSERT INTO emkt_regions VALUES(2625, 165, '10', 'Alto Paraná', 'English');
INSERT INTO emkt_regions VALUES(2626, 165, '11', 'Central', 'English');
INSERT INTO emkt_regions VALUES(2627, 165, '12', 'Ñeembucú', 'English');
INSERT INTO emkt_regions VALUES(2628, 165, '13', 'Amambay', 'English');
INSERT INTO emkt_regions VALUES(2629, 165, '14', 'Canindeyú', 'English');
INSERT INTO emkt_regions VALUES(2630, 165, '15', 'Presidente Hayes', 'English');
INSERT INTO emkt_regions VALUES(2631, 165, '16', 'Alto Paraguay', 'English');
INSERT INTO emkt_regions VALUES(2632, 165, '19', 'Boquerón', 'English');
INSERT INTO emkt_regions VALUES(2633, 165, 'ASU', 'Asunción', 'English');

INSERT INTO emkt_countries VALUES (166,'Peru','English','PE','PER','');

INSERT INTO emkt_regions VALUES(2634, 166, 'AMA', 'Amazonas', 'English');
INSERT INTO emkt_regions VALUES(2635, 166, 'ANC', 'Ancash', 'English');
INSERT INTO emkt_regions VALUES(2636, 166, 'APU', 'Apurímac', 'English');
INSERT INTO emkt_regions VALUES(2637, 166, 'ARE', 'Arequipa', 'English');
INSERT INTO emkt_regions VALUES(2638, 166, 'AYA', 'Ayacucho', 'English');
INSERT INTO emkt_regions VALUES(2639, 166, 'CAJ', 'Cajamarca', 'English');
INSERT INTO emkt_regions VALUES(2640, 166, 'CAL', 'Callao', 'English');
INSERT INTO emkt_regions VALUES(2641, 166, 'CUS', 'Cuzco', 'English');
INSERT INTO emkt_regions VALUES(2642, 166, 'HUC', 'Huánuco', 'English');
INSERT INTO emkt_regions VALUES(2643, 166, 'HUV', 'Huancavelica', 'English');
INSERT INTO emkt_regions VALUES(2644, 166, 'ICA', 'Ica', 'English');
INSERT INTO emkt_regions VALUES(2645, 166, 'JUN', 'Junín', 'English');
INSERT INTO emkt_regions VALUES(2646, 166, 'LAL', 'La Libertad', 'English');
INSERT INTO emkt_regions VALUES(2647, 166, 'LAM', 'Lambayeque', 'English');
INSERT INTO emkt_regions VALUES(2648, 166, 'LIM', 'Lima', 'English');
INSERT INTO emkt_regions VALUES(2649, 166, 'LOR', 'Loreto', 'English');
INSERT INTO emkt_regions VALUES(2650, 166, 'MDD', 'Madre de Dios', 'English');
INSERT INTO emkt_regions VALUES(2651, 166, 'MOQ', 'Moquegua', 'English');
INSERT INTO emkt_regions VALUES(2652, 166, 'PAS', 'Pasco', 'English');
INSERT INTO emkt_regions VALUES(2653, 166, 'PIU', 'Piura', 'English');
INSERT INTO emkt_regions VALUES(2654, 166, 'PUN', 'Puno', 'English');
INSERT INTO emkt_regions VALUES(2655, 166, 'SAM', 'San Martín', 'English');
INSERT INTO emkt_regions VALUES(2656, 166, 'TAC', 'Tacna', 'English');
INSERT INTO emkt_regions VALUES(2657, 166, 'TUM', 'Tumbes', 'English');
INSERT INTO emkt_regions VALUES(2658, 166, 'UCA', 'Ucayali', 'English');

INSERT INTO emkt_countries VALUES (167,'Philippines','English','PH','PHL','');

INSERT INTO emkt_regions VALUES(2659, 167, 'ABR', 'Abra', 'English');
INSERT INTO emkt_regions VALUES(2660, 167, 'AGN', 'Agusan del Norte', 'English');
INSERT INTO emkt_regions VALUES(2661, 167, 'AGS', 'Agusan del Sur', 'English');
INSERT INTO emkt_regions VALUES(2662, 167, 'AKL', 'Aklan', 'English');
INSERT INTO emkt_regions VALUES(2663, 167, 'ALB', 'Albay', 'English');
INSERT INTO emkt_regions VALUES(2664, 167, 'ANT', 'Antique', 'English');
INSERT INTO emkt_regions VALUES(2665, 167, 'APA', 'Apayao', 'English');
INSERT INTO emkt_regions VALUES(2666, 167, 'AUR', 'Aurora', 'English');
INSERT INTO emkt_regions VALUES(2667, 167, 'BAN', 'Bataan', 'English');
INSERT INTO emkt_regions VALUES(2668, 167, 'BAS', 'Basilan', 'English');
INSERT INTO emkt_regions VALUES(2669, 167, 'BEN', 'Benguet', 'English');
INSERT INTO emkt_regions VALUES(2670, 167, 'BIL', 'Biliran', 'English');
INSERT INTO emkt_regions VALUES(2671, 167, 'BOH', 'Bohol', 'English');
INSERT INTO emkt_regions VALUES(2672, 167, 'BTG', 'Batangas', 'English');
INSERT INTO emkt_regions VALUES(2673, 167, 'BTN', 'Batanes', 'English');
INSERT INTO emkt_regions VALUES(2674, 167, 'BUK', 'Bukidnon', 'English');
INSERT INTO emkt_regions VALUES(2675, 167, 'BUL', 'Bulacan', 'English');
INSERT INTO emkt_regions VALUES(2676, 167, 'CAG', 'Cagayan', 'English');
INSERT INTO emkt_regions VALUES(2677, 167, 'CAM', 'Camiguin', 'English');
INSERT INTO emkt_regions VALUES(2678, 167, 'CAN', 'Camarines Norte', 'English');
INSERT INTO emkt_regions VALUES(2679, 167, 'CAP', 'Capiz', 'English');
INSERT INTO emkt_regions VALUES(2680, 167, 'CAS', 'Camarines Sur', 'English');
INSERT INTO emkt_regions VALUES(2681, 167, 'CAT', 'Catanduanes', 'English');
INSERT INTO emkt_regions VALUES(2682, 167, 'CAV', 'Cavite', 'English');
INSERT INTO emkt_regions VALUES(2683, 167, 'CEB', 'Cebu', 'English');
INSERT INTO emkt_regions VALUES(2684, 167, 'COM', 'Compostela Valley', 'English');
INSERT INTO emkt_regions VALUES(2685, 167, 'DAO', 'Davao Oriental', 'English');
INSERT INTO emkt_regions VALUES(2686, 167, 'DAS', 'Davao del Sur', 'English');
INSERT INTO emkt_regions VALUES(2687, 167, 'DAV', 'Davao del Norte', 'English');
INSERT INTO emkt_regions VALUES(2688, 167, 'EAS', 'Eastern Samar', 'English');
INSERT INTO emkt_regions VALUES(2689, 167, 'GUI', 'Guimaras', 'English');
INSERT INTO emkt_regions VALUES(2690, 167, 'IFU', 'Ifugao', 'English');
INSERT INTO emkt_regions VALUES(2691, 167, 'ILI', 'Iloilo', 'English');
INSERT INTO emkt_regions VALUES(2692, 167, 'ILN', 'Ilocos Norte', 'English');
INSERT INTO emkt_regions VALUES(2693, 167, 'ILS', 'Ilocos Sur', 'English');
INSERT INTO emkt_regions VALUES(2694, 167, 'ISA', 'Isabela', 'English');
INSERT INTO emkt_regions VALUES(2695, 167, 'KAL', 'Kalinga', 'English');
INSERT INTO emkt_regions VALUES(2696, 167, 'LAG', 'Laguna', 'English');
INSERT INTO emkt_regions VALUES(2697, 167, 'LAN', 'Lanao del Norte', 'English');
INSERT INTO emkt_regions VALUES(2698, 167, 'LAS', 'Lanao del Sur', 'English');
INSERT INTO emkt_regions VALUES(2699, 167, 'LEY', 'Leyte', 'English');
INSERT INTO emkt_regions VALUES(2700, 167, 'LUN', 'La Union', 'English');
INSERT INTO emkt_regions VALUES(2701, 167, 'MAD', 'Marinduque', 'English');
INSERT INTO emkt_regions VALUES(2702, 167, 'MAG', 'Maguindanao', 'English');
INSERT INTO emkt_regions VALUES(2703, 167, 'MAS', 'Masbate', 'English');
INSERT INTO emkt_regions VALUES(2704, 167, 'MDC', 'Mindoro Occidental', 'English');
INSERT INTO emkt_regions VALUES(2705, 167, 'MDR', 'Mindoro Oriental', 'English');
INSERT INTO emkt_regions VALUES(2706, 167, 'MOU', 'Mountain Province', 'English');
INSERT INTO emkt_regions VALUES(2707, 167, 'MSC', 'Misamis Occidental', 'English');
INSERT INTO emkt_regions VALUES(2708, 167, 'MSR', 'Misamis Oriental', 'English');
INSERT INTO emkt_regions VALUES(2709, 167, 'NCO', 'Cotabato', 'English');
INSERT INTO emkt_regions VALUES(2710, 167, 'NSA', 'Northern Samar', 'English');
INSERT INTO emkt_regions VALUES(2711, 167, 'NEC', 'Negros Occidental', 'English');
INSERT INTO emkt_regions VALUES(2712, 167, 'NER', 'Negros Oriental', 'English');
INSERT INTO emkt_regions VALUES(2713, 167, 'NUE', 'Nueva Ecija', 'English');
INSERT INTO emkt_regions VALUES(2714, 167, 'NUV', 'Nueva Vizcaya', 'English');
INSERT INTO emkt_regions VALUES(2715, 167, 'PAM', 'Pampanga', 'English');
INSERT INTO emkt_regions VALUES(2716, 167, 'PAN', 'Pangasinan', 'English');
INSERT INTO emkt_regions VALUES(2717, 167, 'PLW', 'Palawan', 'English');
INSERT INTO emkt_regions VALUES(2718, 167, 'QUE', 'Quezon', 'English');
INSERT INTO emkt_regions VALUES(2719, 167, 'QUI', 'Quirino', 'English');
INSERT INTO emkt_regions VALUES(2720, 167, 'RIZ', 'Rizal', 'English');
INSERT INTO emkt_regions VALUES(2721, 167, 'ROM', 'Romblon', 'English');
INSERT INTO emkt_regions VALUES(2722, 167, 'SAR', 'Sarangani', 'English');
INSERT INTO emkt_regions VALUES(2723, 167, 'SCO', 'South Cotabato', 'English');
INSERT INTO emkt_regions VALUES(2724, 167, 'SIG', 'Siquijor', 'English');
INSERT INTO emkt_regions VALUES(2725, 167, 'SLE', 'Southern Leyte', 'English');
INSERT INTO emkt_regions VALUES(2726, 167, 'SLU', 'Sulu', 'English');
INSERT INTO emkt_regions VALUES(2727, 167, 'SOR', 'Sorsogon', 'English');
INSERT INTO emkt_regions VALUES(2728, 167, 'SUK', 'Sultan Kudarat', 'English');
INSERT INTO emkt_regions VALUES(2729, 167, 'SUN', 'Surigao del Norte', 'English');
INSERT INTO emkt_regions VALUES(2730, 167, 'SUR', 'Surigao del Sur', 'English');
INSERT INTO emkt_regions VALUES(2731, 167, 'TAR', 'Tarlac', 'English');
INSERT INTO emkt_regions VALUES(2732, 167, 'TAW', 'Tawi-Tawi', 'English');
INSERT INTO emkt_regions VALUES(2733, 167, 'WSA', 'Samar', 'English');
INSERT INTO emkt_regions VALUES(2734, 167, 'ZAN', 'Zamboanga del Norte', 'English');
INSERT INTO emkt_regions VALUES(2735, 167, 'ZAS', 'Zamboanga del Sur', 'English');
INSERT INTO emkt_regions VALUES(2736, 167, 'ZMB', 'Zambales', 'English');
INSERT INTO emkt_regions VALUES(2737, 167, 'ZSI', 'Zamboanga Sibugay', 'English');

INSERT INTO emkt_countries VALUES (168,'Pitcairn','English','PN','PCN','');

INSERT INTO emkt_regions VALUES(4270, 168, 'NOCODE', 'Pitcairn', 'English');

INSERT INTO emkt_countries VALUES (169,'Poland','English','PL','POL','');

INSERT INTO emkt_regions VALUES(2738, 169, 'DS', 'Dolnośląskie', 'English');
INSERT INTO emkt_regions VALUES(2739, 169, 'KP', 'Kujawsko-Pomorskie', 'English');
INSERT INTO emkt_regions VALUES(2740, 169, 'LU', 'Lubelskie', 'English');
INSERT INTO emkt_regions VALUES(2741, 169, 'LB', 'Lubuskie', 'English');
INSERT INTO emkt_regions VALUES(2742, 169, 'LD', 'Łódzkie', 'English');
INSERT INTO emkt_regions VALUES(2743, 169, 'MA', 'Małopolskie', 'English');
INSERT INTO emkt_regions VALUES(2744, 169, 'MZ', 'Mazowieckie', 'English');
INSERT INTO emkt_regions VALUES(2745, 169, 'OP', 'Opolskie', 'English');
INSERT INTO emkt_regions VALUES(2746, 169, 'PK', 'Podkarpackie', 'English');
INSERT INTO emkt_regions VALUES(2747, 169, 'PD', 'Podlaskie', 'English');
INSERT INTO emkt_regions VALUES(2748, 169, 'PM', 'Pomorskie', 'English');
INSERT INTO emkt_regions VALUES(2749, 169, 'SL', 'Śląskie', 'English');
INSERT INTO emkt_regions VALUES(2750, 169, 'SK', 'Świętokrzyskie', 'English');
INSERT INTO emkt_regions VALUES(2751, 169, 'WN', 'Warmińsko-Mazurskie', 'English');
INSERT INTO emkt_regions VALUES(2752, 169, 'WP', 'Wielkopolskie', 'English');
INSERT INTO emkt_regions VALUES(2753, 169, 'ZP', 'Zachodniopomorskie', 'English');

INSERT INTO emkt_countries VALUES (170,'Portugal','English','PT','PRT','');

INSERT INTO emkt_regions VALUES(2754, 170, '01', 'Aveiro', 'English');
INSERT INTO emkt_regions VALUES(2755, 170, '02', 'Beja', 'English');
INSERT INTO emkt_regions VALUES(2756, 170, '03', 'Braga', 'English');
INSERT INTO emkt_regions VALUES(2757, 170, '04', 'Bragança', 'English');
INSERT INTO emkt_regions VALUES(2758, 170, '05', 'Castelo Branco', 'English');
INSERT INTO emkt_regions VALUES(2759, 170, '06', 'Coimbra', 'English');
INSERT INTO emkt_regions VALUES(2760, 170, '07', 'Évora', 'English');
INSERT INTO emkt_regions VALUES(2761, 170, '08', 'Faro', 'English');
INSERT INTO emkt_regions VALUES(2762, 170, '09', 'Guarda', 'English');
INSERT INTO emkt_regions VALUES(2763, 170, '10', 'Leiria', 'English');
INSERT INTO emkt_regions VALUES(2764, 170, '11', 'Lisboa', 'English');
INSERT INTO emkt_regions VALUES(2765, 170, '12', 'Portalegre', 'English');
INSERT INTO emkt_regions VALUES(2766, 170, '13', 'Porto', 'English');
INSERT INTO emkt_regions VALUES(2767, 170, '14', 'Santarém', 'English');
INSERT INTO emkt_regions VALUES(2768, 170, '15', 'Setúbal', 'English');
INSERT INTO emkt_regions VALUES(2769, 170, '16', 'Viana do Castelo', 'English');
INSERT INTO emkt_regions VALUES(2770, 170, '17', 'Vila Real', 'English');
INSERT INTO emkt_regions VALUES(2771, 170, '18', 'Viseu', 'English');
INSERT INTO emkt_regions VALUES(2772, 170, '20', 'Região Autónoma dos Açores', 'English');
INSERT INTO emkt_regions VALUES(2773, 170, '30', 'Região Autónoma da Madeira', 'English');

INSERT INTO emkt_countries VALUES (171,'Puerto Rico','English','PR','PRI','');

INSERT INTO emkt_regions VALUES(4271, 171, 'NOCODE', 'Puerto Rico', 'English');

INSERT INTO emkt_countries VALUES (172,'Qatar','English','QA','QAT','');

INSERT INTO emkt_regions VALUES(2774, 172, 'DA', 'الدوحة', 'English');
INSERT INTO emkt_regions VALUES(2775, 172, 'GH', 'الغويرية', 'English');
INSERT INTO emkt_regions VALUES(2776, 172, 'JB', 'جريان الباطنة', 'English');
INSERT INTO emkt_regions VALUES(2777, 172, 'JU', 'الجميلية', 'English');
INSERT INTO emkt_regions VALUES(2778, 172, 'KH', 'الخور', 'English');
INSERT INTO emkt_regions VALUES(2779, 172, 'ME', 'مسيعيد', 'English');
INSERT INTO emkt_regions VALUES(2780, 172, 'MS', 'الشمال', 'English');
INSERT INTO emkt_regions VALUES(2781, 172, 'RA', 'الريان', 'English');
INSERT INTO emkt_regions VALUES(2782, 172, 'US', 'أم صلال', 'English');
INSERT INTO emkt_regions VALUES(2783, 172, 'WA', 'الوكرة', 'English');

INSERT INTO emkt_countries VALUES (173,'Reunion','English','RE','REU','');

INSERT INTO emkt_regions VALUES(4272, 173, 'NOCODE', 'Reunion', 'English');

INSERT INTO emkt_countries VALUES (174,'Romania','English','RO','ROM','');

INSERT INTO emkt_regions VALUES(2784, 174, 'AB', 'Alba', 'English');
INSERT INTO emkt_regions VALUES(2785, 174, 'AG', 'Argeş', 'English');
INSERT INTO emkt_regions VALUES(2786, 174, 'AR', 'Arad', 'English');
INSERT INTO emkt_regions VALUES(2787, 174, 'B', 'Bucureşti', 'English');
INSERT INTO emkt_regions VALUES(2788, 174, 'BC', 'Bacău', 'English');
INSERT INTO emkt_regions VALUES(2789, 174, 'BH', 'Bihor', 'English');
INSERT INTO emkt_regions VALUES(2790, 174, 'BN', 'Bistriţa-Năsăud', 'English');
INSERT INTO emkt_regions VALUES(2791, 174, 'BR', 'Brăila', 'English');
INSERT INTO emkt_regions VALUES(2792, 174, 'BT', 'Botoşani', 'English');
INSERT INTO emkt_regions VALUES(2793, 174, 'BV', 'Braşov', 'English');
INSERT INTO emkt_regions VALUES(2794, 174, 'BZ', 'Buzău', 'English');
INSERT INTO emkt_regions VALUES(2795, 174, 'CJ', 'Cluj', 'English');
INSERT INTO emkt_regions VALUES(2796, 174, 'CL', 'Călăraşi', 'English');
INSERT INTO emkt_regions VALUES(2797, 174, 'CS', 'Caraş-Severin', 'English');
INSERT INTO emkt_regions VALUES(2798, 174, 'CT', 'Constanţa', 'English');
INSERT INTO emkt_regions VALUES(2799, 174, 'CV', 'Covasna', 'English');
INSERT INTO emkt_regions VALUES(2800, 174, 'DB', 'Dâmboviţa', 'English');
INSERT INTO emkt_regions VALUES(2801, 174, 'DJ', 'Dolj', 'English');
INSERT INTO emkt_regions VALUES(2802, 174, 'GJ', 'Gorj', 'English');
INSERT INTO emkt_regions VALUES(2803, 174, 'GL', 'Galaţi', 'English');
INSERT INTO emkt_regions VALUES(2804, 174, 'GR', 'Giurgiu', 'English');
INSERT INTO emkt_regions VALUES(2805, 174, 'HD', 'Hunedoara', 'English');
INSERT INTO emkt_regions VALUES(2806, 174, 'HG', 'Harghita', 'English');
INSERT INTO emkt_regions VALUES(2807, 174, 'IF', 'Ilfov', 'English');
INSERT INTO emkt_regions VALUES(2808, 174, 'IL', 'Ialomiţa', 'English');
INSERT INTO emkt_regions VALUES(2809, 174, 'IS', 'Iaşi', 'English');
INSERT INTO emkt_regions VALUES(2810, 174, 'MH', 'Mehedinţi', 'English');
INSERT INTO emkt_regions VALUES(2811, 174, 'MM', 'Maramureş', 'English');
INSERT INTO emkt_regions VALUES(2812, 174, 'MS', 'Mureş', 'English');
INSERT INTO emkt_regions VALUES(2813, 174, 'NT', 'Neamţ', 'English');
INSERT INTO emkt_regions VALUES(2814, 174, 'OT', 'Olt', 'English');
INSERT INTO emkt_regions VALUES(2815, 174, 'PH', 'Prahova', 'English');
INSERT INTO emkt_regions VALUES(2816, 174, 'SB', 'Sibiu', 'English');
INSERT INTO emkt_regions VALUES(2817, 174, 'SJ', 'Sălaj', 'English');
INSERT INTO emkt_regions VALUES(2818, 174, 'SM', 'Satu Mare', 'English');
INSERT INTO emkt_regions VALUES(2819, 174, 'SV', 'Suceava', 'English');
INSERT INTO emkt_regions VALUES(2820, 174, 'TL', 'Tulcea', 'English');
INSERT INTO emkt_regions VALUES(2821, 174, 'TM', 'Timiş', 'English');
INSERT INTO emkt_regions VALUES(2822, 174, 'TR', 'Teleorman', 'English');
INSERT INTO emkt_regions VALUES(2823, 174, 'VL', 'Vâlcea', 'English');
INSERT INTO emkt_regions VALUES(2824, 174, 'VN', 'Vrancea', 'English');
INSERT INTO emkt_regions VALUES(2825, 174, 'VS', 'Vaslui', 'English');

INSERT INTO emkt_countries VALUES (175,'Russian Federation','English','RU','RUS','');

INSERT INTO emkt_regions VALUES(2826, 175, 'AD', 'Республика Адыгея', 'English');
INSERT INTO emkt_regions VALUES(2827, 175, 'AL', 'Республика Алтай', 'English');
INSERT INTO emkt_regions VALUES(2828, 175, 'ALT', 'Алтайский край', 'English');
INSERT INTO emkt_regions VALUES(2829, 175, 'AMU', 'Амурская область', 'English');
INSERT INTO emkt_regions VALUES(2830, 175, 'ARK', 'Архангельская область', 'English');
INSERT INTO emkt_regions VALUES(2831, 175, 'AST', 'Астраханская область', 'English');
INSERT INTO emkt_regions VALUES(2832, 175, 'BA', 'Республика Башкортостан', 'English');
INSERT INTO emkt_regions VALUES(2833, 175, 'BEL', 'Белгородская область', 'English');
INSERT INTO emkt_regions VALUES(2834, 175, 'BRY', 'Брянская область', 'English');
INSERT INTO emkt_regions VALUES(2835, 175, 'BU', 'Республика Бурятия', 'English');
INSERT INTO emkt_regions VALUES(2836, 175, 'CE', 'Чеченская Республика', 'English');
INSERT INTO emkt_regions VALUES(2837, 175, 'CHE', 'Челябинская область', 'English');
INSERT INTO emkt_regions VALUES(2838, 175, 'ZAB', 'Забайкальский край', 'English');
INSERT INTO emkt_regions VALUES(2839, 175, 'CHU', 'Чукотский автономный округ', 'English');
INSERT INTO emkt_regions VALUES(2840, 175, 'CU', 'Чувашская Республика', 'English');
INSERT INTO emkt_regions VALUES(2841, 175, 'DA', 'Республика Дагестан', 'English');
INSERT INTO emkt_regions VALUES(2842, 175, 'IN', 'Республика Ингушетия', 'English');
INSERT INTO emkt_regions VALUES(2843, 175, 'IRK', 'Иркутская область', 'English');
INSERT INTO emkt_regions VALUES(2844, 175, 'IVA', 'Ивановская область', 'English');
INSERT INTO emkt_regions VALUES(2845, 175, 'KAM', 'Камчатский край', 'English');
INSERT INTO emkt_regions VALUES(2846, 175, 'KB', 'Кабардино-Балкарская Республика', 'English');
INSERT INTO emkt_regions VALUES(2847, 175, 'KC', 'Карачаево-Черкесская Республика', 'English');
INSERT INTO emkt_regions VALUES(2848, 175, 'KDA', 'Краснодарский край', 'English');
INSERT INTO emkt_regions VALUES(2849, 175, 'KEM', 'Кемеровская область', 'English');
INSERT INTO emkt_regions VALUES(2850, 175, 'KGD', 'Калининградская область', 'English');
INSERT INTO emkt_regions VALUES(2851, 175, 'KGN', 'Курганская область', 'English');
INSERT INTO emkt_regions VALUES(2852, 175, 'KHA', 'Хабаровский край', 'English');
INSERT INTO emkt_regions VALUES(2853, 175, 'KHM', 'Ханты-Мансийский автономный округ—Югра', 'English');
INSERT INTO emkt_regions VALUES(2854, 175, 'KIA', 'Красноярский край', 'English');
INSERT INTO emkt_regions VALUES(2855, 175, 'KIR', 'Кировская область', 'English');
INSERT INTO emkt_regions VALUES(2856, 175, 'KK', 'Республика Хакасия', 'English');
INSERT INTO emkt_regions VALUES(2857, 175, 'KL', 'Республика Калмыкия', 'English');
INSERT INTO emkt_regions VALUES(2858, 175, 'KLU', 'Калужская область', 'English');
INSERT INTO emkt_regions VALUES(2859, 175, 'KO', 'Республика Коми', 'English');
INSERT INTO emkt_regions VALUES(2860, 175, 'KOS', 'Костромская область', 'English');
INSERT INTO emkt_regions VALUES(2861, 175, 'KR', 'Республика Карелия', 'English');
INSERT INTO emkt_regions VALUES(2862, 175, 'KRS', 'Курская область', 'English');
INSERT INTO emkt_regions VALUES(2863, 175, 'LEN', 'Ленинградская область', 'English');
INSERT INTO emkt_regions VALUES(2864, 175, 'LIP', 'Липецкая область', 'English');
INSERT INTO emkt_regions VALUES(2865, 175, 'MAG', 'Магаданская область', 'English');
INSERT INTO emkt_regions VALUES(2866, 175, 'ME', 'Республика Марий Эл', 'English');
INSERT INTO emkt_regions VALUES(2867, 175, 'MO', 'Республика Мордовия', 'English');
INSERT INTO emkt_regions VALUES(2868, 175, 'MOS', 'Московская область', 'English');
INSERT INTO emkt_regions VALUES(2869, 175, 'MOW', 'Москва', 'English');
INSERT INTO emkt_regions VALUES(2870, 175, 'MUR', 'Мурманская область', 'English');
INSERT INTO emkt_regions VALUES(2871, 175, 'NEN', 'Ненецкий автономный округ', 'English');
INSERT INTO emkt_regions VALUES(2872, 175, 'NGR', 'Новгородская область', 'English');
INSERT INTO emkt_regions VALUES(2873, 175, 'NIZ', 'Нижегородская область', 'English');
INSERT INTO emkt_regions VALUES(2874, 175, 'NVS', 'Новосибирская область', 'English');
INSERT INTO emkt_regions VALUES(2875, 175, 'OMS', 'Омская область', 'English');
INSERT INTO emkt_regions VALUES(2876, 175, 'ORE', 'Оренбургская область', 'English');
INSERT INTO emkt_regions VALUES(2877, 175, 'ORL', 'Орловская область', 'English');
INSERT INTO emkt_regions VALUES(2878, 175, 'PNZ', 'Пензенская область', 'English');
INSERT INTO emkt_regions VALUES(2879, 175, 'PRI', 'Приморский край', 'English');
INSERT INTO emkt_regions VALUES(2880, 175, 'PSK', 'Псковская область', 'English');
INSERT INTO emkt_regions VALUES(2881, 175, 'ROS', 'Ростовская область', 'English');
INSERT INTO emkt_regions VALUES(2882, 175, 'RYA', 'Рязанская область', 'English');
INSERT INTO emkt_regions VALUES(2883, 175, 'SA', 'Республика Саха (Якутия)', 'English');
INSERT INTO emkt_regions VALUES(2884, 175, 'SAK', 'Сахалинская область', 'English');
INSERT INTO emkt_regions VALUES(2885, 175, 'SAM', 'Самарская область', 'English');
INSERT INTO emkt_regions VALUES(2886, 175, 'SAR', 'Саратовская область', 'English');
INSERT INTO emkt_regions VALUES(2887, 175, 'SE', 'Республика Северная Осетия–Алания', 'English');
INSERT INTO emkt_regions VALUES(2888, 175, 'SMO', 'Смоленская область', 'English');
INSERT INTO emkt_regions VALUES(2889, 175, 'SPE', 'Санкт-Петербург', 'English');
INSERT INTO emkt_regions VALUES(2890, 175, 'STA', 'Ставропольский край', 'English');
INSERT INTO emkt_regions VALUES(2891, 175, 'SVE', 'Свердловская область', 'English');
INSERT INTO emkt_regions VALUES(2892, 175, 'TA', 'Республика Татарстан', 'English');
INSERT INTO emkt_regions VALUES(2893, 175, 'TAM', 'Тамбовская область', 'English');
INSERT INTO emkt_regions VALUES(2894, 175, 'TOM', 'Томская область', 'English');
INSERT INTO emkt_regions VALUES(2895, 175, 'TUL', 'Тульская область', 'English');
INSERT INTO emkt_regions VALUES(2896, 175, 'TVE', 'Тверская область', 'English');
INSERT INTO emkt_regions VALUES(2897, 175, 'TY', 'Республика Тыва', 'English');
INSERT INTO emkt_regions VALUES(2898, 175, 'TYU', 'Тюменская область', 'English');
INSERT INTO emkt_regions VALUES(2899, 175, 'UD', 'Удмуртская Республика', 'English');
INSERT INTO emkt_regions VALUES(2900, 175, 'ULY', 'Ульяновская область', 'English');
INSERT INTO emkt_regions VALUES(2901, 175, 'VGG', 'Волгоградская область', 'English');
INSERT INTO emkt_regions VALUES(2902, 175, 'VLA', 'Владимирская область', 'English');
INSERT INTO emkt_regions VALUES(2903, 175, 'VLG', 'Вологодская область', 'English');
INSERT INTO emkt_regions VALUES(2904, 175, 'VOR', 'Воронежская область', 'English');
INSERT INTO emkt_regions VALUES(2905, 175, 'PER', 'Пермский край', 'English');
INSERT INTO emkt_regions VALUES(2906, 175, 'YAN', 'Ямало-Ненецкий автономный округ', 'English');
INSERT INTO emkt_regions VALUES(2907, 175, 'YAR', 'Ярославская область', 'English');
INSERT INTO emkt_regions VALUES(2908, 175, 'YEV', 'Еврейская автономная область', 'English');

INSERT INTO emkt_countries VALUES (176,'Rwanda','English','RW','RWA','');

INSERT INTO emkt_regions VALUES(2909, 176, 'N', 'Nord', 'English');
INSERT INTO emkt_regions VALUES(2910, 176, 'E', 'Est', 'English');
INSERT INTO emkt_regions VALUES(2911, 176, 'S', 'Sud', 'English');
INSERT INTO emkt_regions VALUES(2912, 176, 'O', 'Ouest', 'English');
INSERT INTO emkt_regions VALUES(2913, 176, 'K', 'Kigali', 'English');

INSERT INTO emkt_countries VALUES (177,'Saint Kitts and Nevis','English','KN','KNA','');

INSERT INTO emkt_regions VALUES(2914, 177, 'K', 'Saint Kitts', 'English');
INSERT INTO emkt_regions VALUES(2915, 177, 'N', 'Nevis', 'English');

INSERT INTO emkt_countries VALUES (178,'Saint Lucia','English','LC','LCA','');

INSERT INTO emkt_regions VALUES(2916, 178, 'AR', 'Anse-la-Raye', 'English');
INSERT INTO emkt_regions VALUES(2917, 178, 'CA', 'Castries', 'English');
INSERT INTO emkt_regions VALUES(2918, 178, 'CH', 'Choiseul', 'English');
INSERT INTO emkt_regions VALUES(2919, 178, 'DA', 'Dauphin', 'English');
INSERT INTO emkt_regions VALUES(2920, 178, 'DE', 'Dennery', 'English');
INSERT INTO emkt_regions VALUES(2921, 178, 'GI', 'Gros-Islet', 'English');
INSERT INTO emkt_regions VALUES(2922, 178, 'LA', 'Laborie', 'English');
INSERT INTO emkt_regions VALUES(2923, 178, 'MI', 'Micoud', 'English');
INSERT INTO emkt_regions VALUES(2924, 178, 'PR', 'Praslin', 'English');
INSERT INTO emkt_regions VALUES(2925, 178, 'SO', 'Soufriere', 'English');
INSERT INTO emkt_regions VALUES(2926, 178, 'VF', 'Vieux-Fort', 'English');

INSERT INTO emkt_countries VALUES (179,'Saint Vincent and the Grenadines','English','VC','VCT','');

INSERT INTO emkt_regions VALUES(2927, 179, 'C', 'Charlotte', 'English');
INSERT INTO emkt_regions VALUES(2928, 179, 'R', 'Grenadines', 'English');
INSERT INTO emkt_regions VALUES(2929, 179, 'A', 'Saint Andrew', 'English');
INSERT INTO emkt_regions VALUES(2930, 179, 'D', 'Saint David', 'English');
INSERT INTO emkt_regions VALUES(2931, 179, 'G', 'Saint George', 'English');
INSERT INTO emkt_regions VALUES(2932, 179, 'P', 'Saint Patrick', 'English');

INSERT INTO emkt_countries VALUES (180,'Samoa','English','WS','WSM','');

INSERT INTO emkt_regions VALUES(2933, 180, 'AA', 'A\'ana', 'English');
INSERT INTO emkt_regions VALUES(2934, 180, 'AL', 'Aiga-i-le-Tai', 'English');
INSERT INTO emkt_regions VALUES(2935, 180, 'AT', 'Atua', 'English');
INSERT INTO emkt_regions VALUES(2936, 180, 'FA', 'Fa\'asaleleaga', 'English');
INSERT INTO emkt_regions VALUES(2937, 180, 'GE', 'Gaga\'emauga', 'English');
INSERT INTO emkt_regions VALUES(2938, 180, 'GI', 'Gaga\'ifomauga', 'English');
INSERT INTO emkt_regions VALUES(2939, 180, 'PA', 'Palauli', 'English');
INSERT INTO emkt_regions VALUES(2940, 180, 'SA', 'Satupa\'itea', 'English');
INSERT INTO emkt_regions VALUES(2941, 180, 'TU', 'Tuamasaga', 'English');
INSERT INTO emkt_regions VALUES(2942, 180, 'VF', 'Va\'a-o-Fonoti', 'English');
INSERT INTO emkt_regions VALUES(2943, 180, 'VS', 'Vaisigano', 'English');

INSERT INTO emkt_countries VALUES (181,'San Marino','English','SM','SMR','');

INSERT INTO emkt_regions VALUES(2944, 181, 'AC', 'Acquaviva', 'English');
INSERT INTO emkt_regions VALUES(2945, 181, 'BM', 'Borgo Maggiore', 'English');
INSERT INTO emkt_regions VALUES(2946, 181, 'CH', 'Chiesanuova', 'English');
INSERT INTO emkt_regions VALUES(2947, 181, 'DO', 'Domagnano', 'English');
INSERT INTO emkt_regions VALUES(2948, 181, 'FA', 'Faetano', 'English');
INSERT INTO emkt_regions VALUES(2949, 181, 'FI', 'Fiorentino', 'English');
INSERT INTO emkt_regions VALUES(2950, 181, 'MO', 'Montegiardino', 'English');
INSERT INTO emkt_regions VALUES(2951, 181, 'SM', 'Citta di San Marino', 'English');
INSERT INTO emkt_regions VALUES(2952, 181, 'SE', 'Serravalle', 'English');

INSERT INTO emkt_countries VALUES (182,'Sao Tome and Principe','English','ST','STP','');

INSERT INTO emkt_regions VALUES(2953, 182, 'P', 'Príncipe', 'English');
INSERT INTO emkt_regions VALUES(2954, 182, 'S', 'São Tomé', 'English');

INSERT INTO emkt_countries VALUES (183,'Saudi Arabia','English','SA','SAU','');

INSERT INTO emkt_regions VALUES(2955, 183, '01', 'الرياض', 'English');
INSERT INTO emkt_regions VALUES(2956, 183, '02', 'مكة المكرمة', 'English');
INSERT INTO emkt_regions VALUES(2957, 183, '03', 'المدينه', 'English');
INSERT INTO emkt_regions VALUES(2958, 183, '04', 'الشرقية', 'English');
INSERT INTO emkt_regions VALUES(2959, 183, '05', 'القصيم', 'English');
INSERT INTO emkt_regions VALUES(2960, 183, '06', 'حائل', 'English');
INSERT INTO emkt_regions VALUES(2961, 183, '07', 'تبوك', 'English');
INSERT INTO emkt_regions VALUES(2962, 183, '08', 'الحدود الشمالية', 'English');
INSERT INTO emkt_regions VALUES(2963, 183, '09', 'جيزان', 'English');
INSERT INTO emkt_regions VALUES(2964, 183, '10', 'نجران', 'English');
INSERT INTO emkt_regions VALUES(2965, 183, '11', 'الباحة', 'English');
INSERT INTO emkt_regions VALUES(2966, 183, '12', 'الجوف', 'English');
INSERT INTO emkt_regions VALUES(2967, 183, '14', 'عسير', 'English');

INSERT INTO emkt_countries VALUES (184,'Senegal','English','SN','SEN','');

INSERT INTO emkt_regions VALUES(2968, 184, 'DA', 'Dakar', 'English');
INSERT INTO emkt_regions VALUES(2969, 184, 'DI', 'Diourbel', 'English');
INSERT INTO emkt_regions VALUES(2970, 184, 'FA', 'Fatick', 'English');
INSERT INTO emkt_regions VALUES(2971, 184, 'KA', 'Kaolack', 'English');
INSERT INTO emkt_regions VALUES(2972, 184, 'KO', 'Kolda', 'English');
INSERT INTO emkt_regions VALUES(2973, 184, 'LO', 'Louga', 'English');
INSERT INTO emkt_regions VALUES(2974, 184, 'MA', 'Matam', 'English');
INSERT INTO emkt_regions VALUES(2975, 184, 'SL', 'Saint-Louis', 'English');
INSERT INTO emkt_regions VALUES(2976, 184, 'TA', 'Tambacounda', 'English');
INSERT INTO emkt_regions VALUES(2977, 184, 'TH', 'Thies', 'English');
INSERT INTO emkt_regions VALUES(2978, 184, 'ZI', 'Ziguinchor', 'English');

INSERT INTO emkt_countries VALUES (185,'Seychelles','English','SC','SYC','');

INSERT INTO emkt_regions VALUES(2979, 185, 'AP', 'Anse aux Pins', 'English');
INSERT INTO emkt_regions VALUES(2980, 185, 'AB', 'Anse Boileau', 'English');
INSERT INTO emkt_regions VALUES(2981, 185, 'AE', 'Anse Etoile', 'English');
INSERT INTO emkt_regions VALUES(2982, 185, 'AL', 'Anse Louis', 'English');
INSERT INTO emkt_regions VALUES(2983, 185, 'AR', 'Anse Royale', 'English');
INSERT INTO emkt_regions VALUES(2984, 185, 'BL', 'Baie Lazare', 'English');
INSERT INTO emkt_regions VALUES(2985, 185, 'BS', 'Baie Sainte Anne', 'English');
INSERT INTO emkt_regions VALUES(2986, 185, 'BV', 'Beau Vallon', 'English');
INSERT INTO emkt_regions VALUES(2987, 185, 'BA', 'Bel Air', 'English');
INSERT INTO emkt_regions VALUES(2988, 185, 'BO', 'Bel Ombre', 'English');
INSERT INTO emkt_regions VALUES(2989, 185, 'CA', 'Cascade', 'English');
INSERT INTO emkt_regions VALUES(2990, 185, 'GL', 'Glacis', 'English');
INSERT INTO emkt_regions VALUES(2991, 185, 'GM', 'Grand\' Anse (on Mahe)', 'English');
INSERT INTO emkt_regions VALUES(2992, 185, 'GP', 'Grand\' Anse (on Praslin)', 'English');
INSERT INTO emkt_regions VALUES(2993, 185, 'DG', 'La Digue', 'English');
INSERT INTO emkt_regions VALUES(2994, 185, 'RA', 'La Riviere Anglaise', 'English');
INSERT INTO emkt_regions VALUES(2995, 185, 'MB', 'Mont Buxton', 'English');
INSERT INTO emkt_regions VALUES(2996, 185, 'MF', 'Mont Fleuri', 'English');
INSERT INTO emkt_regions VALUES(2997, 185, 'PL', 'Plaisance', 'English');
INSERT INTO emkt_regions VALUES(2998, 185, 'PR', 'Pointe La Rue', 'English');
INSERT INTO emkt_regions VALUES(2999, 185, 'PG', 'Port Glaud', 'English');
INSERT INTO emkt_regions VALUES(3000, 185, 'SL', 'Saint Louis', 'English');
INSERT INTO emkt_regions VALUES(3001, 185, 'TA', 'Takamaka', 'English');

INSERT INTO emkt_countries VALUES (186,'Sierra Leone','English','SL','SLE','');

INSERT INTO emkt_regions VALUES(3002, 186, 'E', 'Eastern', 'English');
INSERT INTO emkt_regions VALUES(3003, 186, 'N', 'Northern', 'English');
INSERT INTO emkt_regions VALUES(3004, 186, 'S', 'Southern', 'English');
INSERT INTO emkt_regions VALUES(3005, 186, 'W', 'Western', 'English');

INSERT INTO emkt_countries VALUES (187,'Singapore','English','SG','SGP','');

INSERT INTO emkt_regions VALUES(4273, 187, 'NOCODE', 'Singapore', 'English');

INSERT INTO emkt_countries VALUES (188,'Slovakia','English','SK','SVK','');

INSERT INTO emkt_regions VALUES(3006, 188, 'BC', 'Banskobystrický kraj', 'English');
INSERT INTO emkt_regions VALUES(3007, 188, 'BL', 'Bratislavský kraj', 'English');
INSERT INTO emkt_regions VALUES(3008, 188, 'KI', 'Košický kraj', 'English');
INSERT INTO emkt_regions VALUES(3009, 188, 'NJ', 'Nitrianský kraj', 'English');
INSERT INTO emkt_regions VALUES(3010, 188, 'PV', 'Prešovský kraj', 'English');
INSERT INTO emkt_regions VALUES(3011, 188, 'TA', 'Trnavský kraj', 'English');
INSERT INTO emkt_regions VALUES(3012, 188, 'TC', 'Trenčianský kraj', 'English');
INSERT INTO emkt_regions VALUES(3013, 188, 'ZI', 'Žilinský kraj', 'English');

INSERT INTO emkt_countries VALUES (189,'Slovenia','English','SI','SVN','');

INSERT INTO emkt_regions VALUES(3014, 189, '001', 'Ajdovščina', 'English');
INSERT INTO emkt_regions VALUES(3015, 189, '002', 'Beltinci', 'English');
INSERT INTO emkt_regions VALUES(3016, 189, '003', 'Bled', 'English');
INSERT INTO emkt_regions VALUES(3017, 189, '004', 'Bohinj', 'English');
INSERT INTO emkt_regions VALUES(3018, 189, '005', 'Borovnica', 'English');
INSERT INTO emkt_regions VALUES(3019, 189, '006', 'Bovec', 'English');
INSERT INTO emkt_regions VALUES(3020, 189, '007', 'Brda', 'English');
INSERT INTO emkt_regions VALUES(3021, 189, '008', 'Brezovica', 'English');
INSERT INTO emkt_regions VALUES(3022, 189, '009', 'Brežice', 'English');
INSERT INTO emkt_regions VALUES(3023, 189, '010', 'Tišina', 'English');
INSERT INTO emkt_regions VALUES(3024, 189, '011', 'Celje', 'English');
INSERT INTO emkt_regions VALUES(3025, 189, '012', 'Cerklje na Gorenjskem', 'English');
INSERT INTO emkt_regions VALUES(3026, 189, '013', 'Cerknica', 'English');
INSERT INTO emkt_regions VALUES(3027, 189, '014', 'Cerkno', 'English');
INSERT INTO emkt_regions VALUES(3028, 189, '015', 'Črenšovci', 'English');
INSERT INTO emkt_regions VALUES(3029, 189, '016', 'Črna na Koroškem', 'English');
INSERT INTO emkt_regions VALUES(3030, 189, '017', 'Črnomelj', 'English');
INSERT INTO emkt_regions VALUES(3031, 189, '018', 'Destrnik', 'English');
INSERT INTO emkt_regions VALUES(3032, 189, '019', 'Divača', 'English');
INSERT INTO emkt_regions VALUES(3033, 189, '020', 'Dobrepolje', 'English');
INSERT INTO emkt_regions VALUES(3034, 189, '021', 'Dobrova-Polhov Gradec', 'English');
INSERT INTO emkt_regions VALUES(3035, 189, '022', 'Dol pri Ljubljani', 'English');
INSERT INTO emkt_regions VALUES(3036, 189, '023', 'Domžale', 'English');
INSERT INTO emkt_regions VALUES(3037, 189, '024', 'Dornava', 'English');
INSERT INTO emkt_regions VALUES(3038, 189, '025', 'Dravograd', 'English');
INSERT INTO emkt_regions VALUES(3039, 189, '026', 'Duplek', 'English');
INSERT INTO emkt_regions VALUES(3040, 189, '027', 'Gorenja vas-Poljane', 'English');
INSERT INTO emkt_regions VALUES(3041, 189, '028', 'Gorišnica', 'English');
INSERT INTO emkt_regions VALUES(3042, 189, '029', 'Gornja Radgona', 'English');
INSERT INTO emkt_regions VALUES(3043, 189, '030', 'Gornji Grad', 'English');
INSERT INTO emkt_regions VALUES(3044, 189, '031', 'Gornji Petrovci', 'English');
INSERT INTO emkt_regions VALUES(3045, 189, '032', 'Grosuplje', 'English');
INSERT INTO emkt_regions VALUES(3046, 189, '033', 'Šalovci', 'English');
INSERT INTO emkt_regions VALUES(3047, 189, '034', 'Hrastnik', 'English');
INSERT INTO emkt_regions VALUES(3048, 189, '035', 'Hrpelje-Kozina', 'English');
INSERT INTO emkt_regions VALUES(3049, 189, '036', 'Idrija', 'English');
INSERT INTO emkt_regions VALUES(3050, 189, '037', 'Ig', 'English');
INSERT INTO emkt_regions VALUES(3051, 189, '038', 'Ilirska Bistrica', 'English');
INSERT INTO emkt_regions VALUES(3052, 189, '039', 'Ivančna Gorica', 'English');
INSERT INTO emkt_regions VALUES(3053, 189, '040', 'Izola', 'English');
INSERT INTO emkt_regions VALUES(3054, 189, '041', 'Jesenice', 'English');
INSERT INTO emkt_regions VALUES(3055, 189, '042', 'Juršinci', 'English');
INSERT INTO emkt_regions VALUES(3056, 189, '043', 'Kamnik', 'English');
INSERT INTO emkt_regions VALUES(3057, 189, '044', 'Kanal ob Soči', 'English');
INSERT INTO emkt_regions VALUES(3058, 189, '045', 'Kidričevo', 'English');
INSERT INTO emkt_regions VALUES(3059, 189, '046', 'Kobarid', 'English');
INSERT INTO emkt_regions VALUES(3060, 189, '047', 'Kobilje', 'English');
INSERT INTO emkt_regions VALUES(3061, 189, '048', 'Kočevje', 'English');
INSERT INTO emkt_regions VALUES(3062, 189, '049', 'Komen', 'English');
INSERT INTO emkt_regions VALUES(3063, 189, '050', 'Koper', 'English');
INSERT INTO emkt_regions VALUES(3064, 189, '051', 'Kozje', 'English');
INSERT INTO emkt_regions VALUES(3065, 189, '052', 'Kranj', 'English');
INSERT INTO emkt_regions VALUES(3066, 189, '053', 'Kranjska Gora', 'English');
INSERT INTO emkt_regions VALUES(3067, 189, '054', 'Krško', 'English');
INSERT INTO emkt_regions VALUES(3068, 189, '055', 'Kungota', 'English');
INSERT INTO emkt_regions VALUES(3069, 189, '056', 'Kuzma', 'English');
INSERT INTO emkt_regions VALUES(3070, 189, '057', 'Laško', 'English');
INSERT INTO emkt_regions VALUES(3071, 189, '058', 'Lenart', 'English');
INSERT INTO emkt_regions VALUES(3072, 189, '059', 'Lendava', 'English');
INSERT INTO emkt_regions VALUES(3073, 189, '060', 'Litija', 'English');
INSERT INTO emkt_regions VALUES(3074, 189, '061', 'Ljubljana', 'English');
INSERT INTO emkt_regions VALUES(3075, 189, '062', 'Ljubno', 'English');
INSERT INTO emkt_regions VALUES(3076, 189, '063', 'Ljutomer', 'English');
INSERT INTO emkt_regions VALUES(3077, 189, '064', 'Logatec', 'English');
INSERT INTO emkt_regions VALUES(3078, 189, '065', 'Loška Dolina', 'English');
INSERT INTO emkt_regions VALUES(3079, 189, '066', 'Loški Potok', 'English');
INSERT INTO emkt_regions VALUES(3080, 189, '067', 'Luče', 'English');
INSERT INTO emkt_regions VALUES(3081, 189, '068', 'Lukovica', 'English');
INSERT INTO emkt_regions VALUES(3082, 189, '069', 'Majšperk', 'English');
INSERT INTO emkt_regions VALUES(3083, 189, '070', 'Maribor', 'English');
INSERT INTO emkt_regions VALUES(3084, 189, '071', 'Medvode', 'English');
INSERT INTO emkt_regions VALUES(3085, 189, '072', 'Mengeš', 'English');
INSERT INTO emkt_regions VALUES(3086, 189, '073', 'Metlika', 'English');
INSERT INTO emkt_regions VALUES(3087, 189, '074', 'Mežica', 'English');
INSERT INTO emkt_regions VALUES(3088, 189, '075', 'Miren-Kostanjevica', 'English');
INSERT INTO emkt_regions VALUES(3089, 189, '076', 'Mislinja', 'English');
INSERT INTO emkt_regions VALUES(3090, 189, '077', 'Moravče', 'English');
INSERT INTO emkt_regions VALUES(3091, 189, '078', 'Moravske Toplice', 'English');
INSERT INTO emkt_regions VALUES(3092, 189, '079', 'Mozirje', 'English');
INSERT INTO emkt_regions VALUES(3093, 189, '080', 'Murska Sobota', 'English');
INSERT INTO emkt_regions VALUES(3094, 189, '081', 'Muta', 'English');
INSERT INTO emkt_regions VALUES(3095, 189, '082', 'Naklo', 'English');
INSERT INTO emkt_regions VALUES(3096, 189, '083', 'Nazarje', 'English');
INSERT INTO emkt_regions VALUES(3097, 189, '084', 'Nova Gorica', 'English');
INSERT INTO emkt_regions VALUES(3098, 189, '085', 'Novo mesto', 'English');
INSERT INTO emkt_regions VALUES(3099, 189, '086', 'Odranci', 'English');
INSERT INTO emkt_regions VALUES(3100, 189, '087', 'Ormož', 'English');
INSERT INTO emkt_regions VALUES(3101, 189, '088', 'Osilnica', 'English');
INSERT INTO emkt_regions VALUES(3102, 189, '089', 'Pesnica', 'English');
INSERT INTO emkt_regions VALUES(3103, 189, '090', 'Piran', 'English');
INSERT INTO emkt_regions VALUES(3104, 189, '091', 'Pivka', 'English');
INSERT INTO emkt_regions VALUES(3105, 189, '092', 'Podčetrtek', 'English');
INSERT INTO emkt_regions VALUES(3106, 189, '093', 'Podvelka', 'English');
INSERT INTO emkt_regions VALUES(3107, 189, '094', 'Postojna', 'English');
INSERT INTO emkt_regions VALUES(3108, 189, '095', 'Preddvor', 'English');
INSERT INTO emkt_regions VALUES(3109, 189, '096', 'Ptuj', 'English');
INSERT INTO emkt_regions VALUES(3110, 189, '097', 'Puconci', 'English');
INSERT INTO emkt_regions VALUES(3111, 189, '098', 'Rače-Fram', 'English');
INSERT INTO emkt_regions VALUES(3112, 189, '099', 'Radeče', 'English');
INSERT INTO emkt_regions VALUES(3113, 189, '100', 'Radenci', 'English');
INSERT INTO emkt_regions VALUES(3114, 189, '101', 'Radlje ob Dravi', 'English');
INSERT INTO emkt_regions VALUES(3115, 189, '102', 'Radovljica', 'English');
INSERT INTO emkt_regions VALUES(3116, 189, '103', 'Ravne na Koroškem', 'English');
INSERT INTO emkt_regions VALUES(3117, 189, '104', 'Ribnica', 'English');
INSERT INTO emkt_regions VALUES(3118, 189, '106', 'Rogaška Slatina', 'English');
INSERT INTO emkt_regions VALUES(3119, 189, '105', 'Rogašovci', 'English');
INSERT INTO emkt_regions VALUES(3120, 189, '107', 'Rogatec', 'English');
INSERT INTO emkt_regions VALUES(3121, 189, '108', 'Ruše', 'English');
INSERT INTO emkt_regions VALUES(3122, 189, '109', 'Semič', 'English');
INSERT INTO emkt_regions VALUES(3123, 189, '110', 'Sevnica', 'English');
INSERT INTO emkt_regions VALUES(3124, 189, '111', 'Sežana', 'English');
INSERT INTO emkt_regions VALUES(3125, 189, '112', 'Slovenj Gradec', 'English');
INSERT INTO emkt_regions VALUES(3126, 189, '113', 'Slovenska Bistrica', 'English');
INSERT INTO emkt_regions VALUES(3127, 189, '114', 'Slovenske Konjice', 'English');
INSERT INTO emkt_regions VALUES(3128, 189, '115', 'Starše', 'English');
INSERT INTO emkt_regions VALUES(3129, 189, '116', 'Sveti Jurij', 'English');
INSERT INTO emkt_regions VALUES(3130, 189, '117', 'Šenčur', 'English');
INSERT INTO emkt_regions VALUES(3131, 189, '118', 'Šentilj', 'English');
INSERT INTO emkt_regions VALUES(3132, 189, '119', 'Šentjernej', 'English');
INSERT INTO emkt_regions VALUES(3133, 189, '120', 'Šentjur pri Celju', 'English');
INSERT INTO emkt_regions VALUES(3134, 189, '121', 'Škocjan', 'English');
INSERT INTO emkt_regions VALUES(3135, 189, '122', 'Škofja Loka', 'English');
INSERT INTO emkt_regions VALUES(3136, 189, '123', 'Škofljica', 'English');
INSERT INTO emkt_regions VALUES(3137, 189, '124', 'Šmarje pri Jelšah', 'English');
INSERT INTO emkt_regions VALUES(3138, 189, '125', 'Šmartno ob Paki', 'English');
INSERT INTO emkt_regions VALUES(3139, 189, '126', 'Šoštanj', 'English');
INSERT INTO emkt_regions VALUES(3140, 189, '127', 'Štore', 'English');
INSERT INTO emkt_regions VALUES(3141, 189, '128', 'Tolmin', 'English');
INSERT INTO emkt_regions VALUES(3142, 189, '129', 'Trbovlje', 'English');
INSERT INTO emkt_regions VALUES(3143, 189, '130', 'Trebnje', 'English');
INSERT INTO emkt_regions VALUES(3144, 189, '131', 'Tržič', 'English');
INSERT INTO emkt_regions VALUES(3145, 189, '132', 'Turnišče', 'English');
INSERT INTO emkt_regions VALUES(3146, 189, '133', 'Velenje', 'English');
INSERT INTO emkt_regions VALUES(3147, 189, '134', 'Velike Lašče', 'English');
INSERT INTO emkt_regions VALUES(3148, 189, '135', 'Videm', 'English');
INSERT INTO emkt_regions VALUES(3149, 189, '136', 'Vipava', 'English');
INSERT INTO emkt_regions VALUES(3150, 189, '137', 'Vitanje', 'English');
INSERT INTO emkt_regions VALUES(3151, 189, '138', 'Vodice', 'English');
INSERT INTO emkt_regions VALUES(3152, 189, '139', 'Vojnik', 'English');
INSERT INTO emkt_regions VALUES(3153, 189, '140', 'Vrhnika', 'English');
INSERT INTO emkt_regions VALUES(3154, 189, '141', 'Vuzenica', 'English');
INSERT INTO emkt_regions VALUES(3155, 189, '142', 'Zagorje ob Savi', 'English');
INSERT INTO emkt_regions VALUES(3156, 189, '143', 'Zavrč', 'English');
INSERT INTO emkt_regions VALUES(3157, 189, '144', 'Zreče', 'English');
INSERT INTO emkt_regions VALUES(3158, 189, '146', 'Železniki', 'English');
INSERT INTO emkt_regions VALUES(3159, 189, '147', 'Žiri', 'English');
INSERT INTO emkt_regions VALUES(3160, 189, '148', 'Benedikt', 'English');
INSERT INTO emkt_regions VALUES(3161, 189, '149', 'Bistrica ob Sotli', 'English');
INSERT INTO emkt_regions VALUES(3162, 189, '150', 'Bloke', 'English');
INSERT INTO emkt_regions VALUES(3163, 189, '151', 'Braslovče', 'English');
INSERT INTO emkt_regions VALUES(3164, 189, '152', 'Cankova', 'English');
INSERT INTO emkt_regions VALUES(3165, 189, '153', 'Cerkvenjak', 'English');
INSERT INTO emkt_regions VALUES(3166, 189, '154', 'Dobje', 'English');
INSERT INTO emkt_regions VALUES(3167, 189, '155', 'Dobrna', 'English');
INSERT INTO emkt_regions VALUES(3168, 189, '156', 'Dobrovnik', 'English');
INSERT INTO emkt_regions VALUES(3169, 189, '157', 'Dolenjske Toplice', 'English');
INSERT INTO emkt_regions VALUES(3170, 189, '158', 'Grad', 'English');
INSERT INTO emkt_regions VALUES(3171, 189, '159', 'Hajdina', 'English');
INSERT INTO emkt_regions VALUES(3172, 189, '160', 'Hoče-Slivnica', 'English');
INSERT INTO emkt_regions VALUES(3173, 189, '161', 'Hodoš', 'English');
INSERT INTO emkt_regions VALUES(3174, 189, '162', 'Horjul', 'English');
INSERT INTO emkt_regions VALUES(3175, 189, '163', 'Jezersko', 'English');
INSERT INTO emkt_regions VALUES(3176, 189, '164', 'Komenda', 'English');
INSERT INTO emkt_regions VALUES(3177, 189, '165', 'Kostel', 'English');
INSERT INTO emkt_regions VALUES(3178, 189, '166', 'Križevci', 'English');
INSERT INTO emkt_regions VALUES(3179, 189, '167', 'Lovrenc na Pohorju', 'English');
INSERT INTO emkt_regions VALUES(3180, 189, '168', 'Markovci', 'English');
INSERT INTO emkt_regions VALUES(3181, 189, '169', 'Miklavž na Dravskem polju', 'English');
INSERT INTO emkt_regions VALUES(3182, 189, '170', 'Mirna Peč', 'English');
INSERT INTO emkt_regions VALUES(3183, 189, '171', 'Oplotnica', 'English');
INSERT INTO emkt_regions VALUES(3184, 189, '172', 'Podlehnik', 'English');
INSERT INTO emkt_regions VALUES(3185, 189, '173', 'Polzela', 'English');
INSERT INTO emkt_regions VALUES(3186, 189, '174', 'Prebold', 'English');
INSERT INTO emkt_regions VALUES(3187, 189, '175', 'Prevalje', 'English');
INSERT INTO emkt_regions VALUES(3188, 189, '176', 'Razkrižje', 'English');
INSERT INTO emkt_regions VALUES(3189, 189, '177', 'Ribnica na Pohorju', 'English');
INSERT INTO emkt_regions VALUES(3190, 189, '178', 'Selnica ob Dravi', 'English');
INSERT INTO emkt_regions VALUES(3191, 189, '179', 'Sodražica', 'English');
INSERT INTO emkt_regions VALUES(3192, 189, '180', 'Solčava', 'English');
INSERT INTO emkt_regions VALUES(3193, 189, '181', 'Sveta Ana', 'English');
INSERT INTO emkt_regions VALUES(3194, 189, '182', 'Sveti Andraž v Slovenskih goricah', 'English');
INSERT INTO emkt_regions VALUES(3195, 189, '183', 'Šempeter-Vrtojba', 'English');
INSERT INTO emkt_regions VALUES(3196, 189, '184', 'Tabor', 'English');
INSERT INTO emkt_regions VALUES(3197, 189, '185', 'Trnovska vas', 'English');
INSERT INTO emkt_regions VALUES(3198, 189, '186', 'Trzin', 'English');
INSERT INTO emkt_regions VALUES(3199, 189, '187', 'Velika Polana', 'English');
INSERT INTO emkt_regions VALUES(3200, 189, '188', 'Veržej', 'English');
INSERT INTO emkt_regions VALUES(3201, 189, '189', 'Vransko', 'English');
INSERT INTO emkt_regions VALUES(3202, 189, '190', 'Žalec', 'English');
INSERT INTO emkt_regions VALUES(3203, 189, '191', 'Žetale', 'English');
INSERT INTO emkt_regions VALUES(3204, 189, '192', 'Žirovnica', 'English');
INSERT INTO emkt_regions VALUES(3205, 189, '193', 'Žužemberk', 'English');
INSERT INTO emkt_regions VALUES(3206, 189, '194', 'Šmartno pri Litiji', 'English');

INSERT INTO emkt_countries VALUES (190,'Solomon Islands','English','SB','SLB','');

INSERT INTO emkt_regions VALUES(3207, 190, 'CE', 'Central', 'English');
INSERT INTO emkt_regions VALUES(3208, 190, 'CH', 'Choiseul', 'English');
INSERT INTO emkt_regions VALUES(3209, 190, 'GC', 'Guadalcanal', 'English');
INSERT INTO emkt_regions VALUES(3210, 190, 'HO', 'Honiara', 'English');
INSERT INTO emkt_regions VALUES(3211, 190, 'IS', 'Isabel', 'English');
INSERT INTO emkt_regions VALUES(3212, 190, 'MK', 'Makira', 'English');
INSERT INTO emkt_regions VALUES(3213, 190, 'ML', 'Malaita', 'English');
INSERT INTO emkt_regions VALUES(3214, 190, 'RB', 'Rennell and Bellona', 'English');
INSERT INTO emkt_regions VALUES(3215, 190, 'TM', 'Temotu', 'English');
INSERT INTO emkt_regions VALUES(3216, 190, 'WE', 'Western', 'English');

INSERT INTO emkt_countries VALUES (191,'Somalia','English','SO','SOM','');

INSERT INTO emkt_regions VALUES(3217, 191, 'AD', 'Awdal', 'English');
INSERT INTO emkt_regions VALUES(3218, 191, 'BK', 'Bakool', 'English');
INSERT INTO emkt_regions VALUES(3219, 191, 'BN', 'Banaadir', 'English');
INSERT INTO emkt_regions VALUES(3220, 191, 'BR', 'Bari', 'English');
INSERT INTO emkt_regions VALUES(3221, 191, 'BY', 'Bay', 'English');
INSERT INTO emkt_regions VALUES(3222, 191, 'GD', 'Gedo', 'English');
INSERT INTO emkt_regions VALUES(3223, 191, 'GG', 'Galguduud', 'English');
INSERT INTO emkt_regions VALUES(3224, 191, 'HR', 'Hiiraan', 'English');
INSERT INTO emkt_regions VALUES(3225, 191, 'JD', 'Jubbada Dhexe', 'English');
INSERT INTO emkt_regions VALUES(3226, 191, 'JH', 'Jubbada Hoose', 'English');
INSERT INTO emkt_regions VALUES(3227, 191, 'MD', 'Mudug', 'English');
INSERT INTO emkt_regions VALUES(3228, 191, 'NG', 'Nugaal', 'English');
INSERT INTO emkt_regions VALUES(3229, 191, 'SD', 'Shabeellaha Dhexe', 'English');
INSERT INTO emkt_regions VALUES(3230, 191, 'SG', 'Sanaag', 'English');
INSERT INTO emkt_regions VALUES(3231, 191, 'SH', 'Shabeellaha Hoose', 'English');
INSERT INTO emkt_regions VALUES(3232, 191, 'SL', 'Sool', 'English');
INSERT INTO emkt_regions VALUES(3233, 191, 'TG', 'Togdheer', 'English');
INSERT INTO emkt_regions VALUES(3234, 191, 'WG', 'Woqooyi Galbeed', 'English');

INSERT INTO emkt_countries VALUES (192,'South Africa','English','ZA','ZAF','');

INSERT INTO emkt_regions VALUES(3235, 192, 'EC', 'Eastern Cape', 'English');
INSERT INTO emkt_regions VALUES(3236, 192, 'FS', 'Free State', 'English');
INSERT INTO emkt_regions VALUES(3237, 192, 'GT', 'Gauteng', 'English');
INSERT INTO emkt_regions VALUES(3238, 192, 'LP', 'Limpopo', 'English');
INSERT INTO emkt_regions VALUES(3239, 192, 'MP', 'Mpumalanga', 'English');
INSERT INTO emkt_regions VALUES(3240, 192, 'NC', 'Northern Cape', 'English');
INSERT INTO emkt_regions VALUES(3241, 192, 'NL', 'KwaZulu-Natal', 'English');
INSERT INTO emkt_regions VALUES(3242, 192, 'NW', 'North-West', 'English');
INSERT INTO emkt_regions VALUES(3243, 192, 'WC', 'Western Cape', 'English');

INSERT INTO emkt_countries VALUES (193,'South Georgia and the South Sandwich Islands','English','GS','SGS','');

INSERT INTO emkt_regions VALUES(4274, 193, 'NOCODE', 'South Georgia and the South Sandwich Islands', 'English');

INSERT INTO emkt_countries VALUES (194,'Spain','English','ES','ESP','');

INSERT INTO emkt_regions VALUES(3244, 194, 'AN', 'Andalucía', 'English');
INSERT INTO emkt_regions VALUES(3245, 194, 'AR', 'Aragón', 'English');
INSERT INTO emkt_regions VALUES(3246, 194, 'A', 'Alicante', 'English');
INSERT INTO emkt_regions VALUES(3247, 194, 'AB', 'Albacete', 'English');
INSERT INTO emkt_regions VALUES(3248, 194, 'AL', 'Almería', 'English');
INSERT INTO emkt_regions VALUES(3249, 194, 'AN', 'Andalucía', 'English');
INSERT INTO emkt_regions VALUES(3250, 194, 'AV', 'Ávila', 'English');
INSERT INTO emkt_regions VALUES(3251, 194, 'B', 'Barcelona', 'English');
INSERT INTO emkt_regions VALUES(3252, 194, 'BA', 'Badajoz', 'English');
INSERT INTO emkt_regions VALUES(3253, 194, 'BI', 'Vizcaya', 'English');
INSERT INTO emkt_regions VALUES(3254, 194, 'BU', 'Burgos', 'English');
INSERT INTO emkt_regions VALUES(3255, 194, 'C', 'A Coruña', 'English');
INSERT INTO emkt_regions VALUES(3256, 194, 'CA', 'Cádiz', 'English');
INSERT INTO emkt_regions VALUES(3257, 194, 'CC', 'Cáceres', 'English');
INSERT INTO emkt_regions VALUES(3258, 194, 'CE', 'Ceuta', 'English');
INSERT INTO emkt_regions VALUES(3259, 194, 'CL', 'Castilla y León', 'English');
INSERT INTO emkt_regions VALUES(3260, 194, 'CM', 'Castilla-La Mancha', 'English');
INSERT INTO emkt_regions VALUES(3261, 194, 'CN', 'Islas Canarias', 'English');
INSERT INTO emkt_regions VALUES(3262, 194, 'CO', 'Córdoba', 'English');
INSERT INTO emkt_regions VALUES(3263, 194, 'CR', 'Ciudad Real', 'English');
INSERT INTO emkt_regions VALUES(3264, 194, 'CS', 'Castellón', 'English');
INSERT INTO emkt_regions VALUES(3265, 194, 'CT', 'Catalonia', 'English');
INSERT INTO emkt_regions VALUES(3266, 194, 'CU', 'Cuenca', 'English');
INSERT INTO emkt_regions VALUES(3267, 194, 'EX', 'Extremadura', 'English');
INSERT INTO emkt_regions VALUES(3268, 194, 'GA', 'Galicia', 'English');
INSERT INTO emkt_regions VALUES(3269, 194, 'GC', 'Las Palmas', 'English');
INSERT INTO emkt_regions VALUES(3270, 194, 'GI', 'Girona', 'English');
INSERT INTO emkt_regions VALUES(3271, 194, 'GR', 'Granada', 'English');
INSERT INTO emkt_regions VALUES(3272, 194, 'GU', 'Guadalajara', 'English');
INSERT INTO emkt_regions VALUES(3273, 194, 'H', 'Huelva', 'English');
INSERT INTO emkt_regions VALUES(3274, 194, 'HU', 'Huesca', 'English');
INSERT INTO emkt_regions VALUES(3275, 194, 'IB', 'Islas Baleares', 'English');
INSERT INTO emkt_regions VALUES(3276, 194, 'J', 'Jaén', 'English');
INSERT INTO emkt_regions VALUES(3277, 194, 'L', 'Lleida', 'English');
INSERT INTO emkt_regions VALUES(3278, 194, 'LE', 'León', 'English');
INSERT INTO emkt_regions VALUES(3279, 194, 'LO', 'La Rioja', 'English');
INSERT INTO emkt_regions VALUES(3280, 194, 'LU', 'Lugo', 'English');
INSERT INTO emkt_regions VALUES(3281, 194, 'M', 'Madrid', 'English');
INSERT INTO emkt_regions VALUES(3282, 194, 'MA', 'Málaga', 'English');
INSERT INTO emkt_regions VALUES(3283, 194, 'ML', 'Melilla', 'English');
INSERT INTO emkt_regions VALUES(3284, 194, 'MU', 'Murcia', 'English');
INSERT INTO emkt_regions VALUES(3285, 194, 'NA', 'Navarre', 'English');
INSERT INTO emkt_regions VALUES(3286, 194, 'O', 'Asturias', 'English');
INSERT INTO emkt_regions VALUES(3287, 194, 'OR', 'Ourense', 'English');
INSERT INTO emkt_regions VALUES(3288, 194, 'P', 'Palencia', 'English');
INSERT INTO emkt_regions VALUES(3289, 194, 'PM', 'Baleares', 'English');
INSERT INTO emkt_regions VALUES(3290, 194, 'PO', 'Pontevedra', 'English');
INSERT INTO emkt_regions VALUES(3291, 194, 'PV', 'Basque Euskadi', 'English');
INSERT INTO emkt_regions VALUES(3292, 194, 'S', 'Cantabria', 'English');
INSERT INTO emkt_regions VALUES(3293, 194, 'SA', 'Salamanca', 'English');
INSERT INTO emkt_regions VALUES(3294, 194, 'SE', 'Seville', 'English');
INSERT INTO emkt_regions VALUES(3295, 194, 'SG', 'Segovia', 'English');
INSERT INTO emkt_regions VALUES(3296, 194, 'SO', 'Soria', 'English');
INSERT INTO emkt_regions VALUES(3297, 194, 'SS', 'Guipúzcoa', 'English');
INSERT INTO emkt_regions VALUES(3298, 194, 'T', 'Tarragona', 'English');
INSERT INTO emkt_regions VALUES(3299, 194, 'TE', 'Teruel', 'English');
INSERT INTO emkt_regions VALUES(3300, 194, 'TF', 'Santa Cruz De Tenerife', 'English');
INSERT INTO emkt_regions VALUES(3301, 194, 'TO', 'Toledo', 'English');
INSERT INTO emkt_regions VALUES(3302, 194, 'V', 'Valencia', 'English');
INSERT INTO emkt_regions VALUES(3303, 194, 'VA', 'Valladolid', 'English');
INSERT INTO emkt_regions VALUES(3304, 194, 'VI', 'Álava', 'English');
INSERT INTO emkt_regions VALUES(3305, 194, 'Z', 'Zaragoza', 'English');
INSERT INTO emkt_regions VALUES(3306, 194, 'ZA', 'Zamora', 'English');

INSERT INTO emkt_countries VALUES (195,'Sri Lanka','English','LK','LKA','');

INSERT INTO emkt_regions VALUES(3307, 195, 'CE', 'Central', 'English');
INSERT INTO emkt_regions VALUES(3308, 195, 'NC', 'North Central', 'English');
INSERT INTO emkt_regions VALUES(3309, 195, 'NO', 'North', 'English');
INSERT INTO emkt_regions VALUES(3310, 195, 'EA', 'Eastern', 'English');
INSERT INTO emkt_regions VALUES(3311, 195, 'NW', 'North Western', 'English');
INSERT INTO emkt_regions VALUES(3312, 195, 'SO', 'Southern', 'English');
INSERT INTO emkt_regions VALUES(3313, 195, 'UV', 'Uva', 'English');
INSERT INTO emkt_regions VALUES(3314, 195, 'SA', 'Sabaragamuwa', 'English');
INSERT INTO emkt_regions VALUES(3315, 195, 'WE', 'Western', 'English');

INSERT INTO emkt_countries VALUES (196,'St. Helena','English','SH','SHN','');

INSERT INTO emkt_regions VALUES(4275, 196, 'NOCODE', 'St. Helena', 'English');

INSERT INTO emkt_countries VALUES (197,'St. Pierre and Miquelon','English','PM','SPM','');

INSERT INTO emkt_regions VALUES(4276, 197, 'NOCODE', 'St. Pierre and Miquelon', 'English');

INSERT INTO emkt_countries VALUES (198,'Sudan','English','SD','SDN','');

INSERT INTO emkt_regions VALUES(3316, 198, 'ANL', 'أعالي النيل', 'English');
INSERT INTO emkt_regions VALUES(3317, 198, 'BAM', 'البحر الأحمر', 'English');
INSERT INTO emkt_regions VALUES(3318, 198, 'BRT', 'البحيرات', 'English');
INSERT INTO emkt_regions VALUES(3319, 198, 'JZR', 'ولاية الجزيرة', 'English');
INSERT INTO emkt_regions VALUES(3320, 198, 'KRT', 'الخرطوم', 'English');
INSERT INTO emkt_regions VALUES(3321, 198, 'QDR', 'القضارف', 'English');
INSERT INTO emkt_regions VALUES(3322, 198, 'WDH', 'الوحدة', 'English');
INSERT INTO emkt_regions VALUES(3323, 198, 'ANB', 'النيل الأبيض', 'English');
INSERT INTO emkt_regions VALUES(3324, 198, 'ANZ', 'النيل الأزرق', 'English');
INSERT INTO emkt_regions VALUES(3325, 198, 'ASH', 'الشمالية', 'English');
INSERT INTO emkt_regions VALUES(3326, 198, 'BJA', 'الاستوائية الوسطى', 'English');
INSERT INTO emkt_regions VALUES(3327, 198, 'GIS', 'غرب الاستوائية', 'English');
INSERT INTO emkt_regions VALUES(3328, 198, 'GBG', 'غرب بحر الغزال', 'English');
INSERT INTO emkt_regions VALUES(3329, 198, 'GDA', 'غرب دارفور', 'English');
INSERT INTO emkt_regions VALUES(3330, 198, 'GKU', 'غرب كردفان', 'English');
INSERT INTO emkt_regions VALUES(3331, 198, 'JDA', 'جنوب دارفور', 'English');
INSERT INTO emkt_regions VALUES(3332, 198, 'JKU', 'جنوب كردفان', 'English');
INSERT INTO emkt_regions VALUES(3333, 198, 'JQL', 'جونقلي', 'English');
INSERT INTO emkt_regions VALUES(3334, 198, 'KSL', 'كسلا', 'English');
INSERT INTO emkt_regions VALUES(3335, 198, 'NNL', 'ولاية نهر النيل', 'English');
INSERT INTO emkt_regions VALUES(3336, 198, 'SBG', 'شمال بحر الغزال', 'English');
INSERT INTO emkt_regions VALUES(3337, 198, 'SDA', 'شمال دارفور', 'English');
INSERT INTO emkt_regions VALUES(3338, 198, 'SKU', 'شمال كردفان', 'English');
INSERT INTO emkt_regions VALUES(3339, 198, 'SIS', 'شرق الاستوائية', 'English');
INSERT INTO emkt_regions VALUES(3340, 198, 'SNR', 'سنار', 'English');
INSERT INTO emkt_regions VALUES(3341, 198, 'WRB', 'واراب', 'English');

INSERT INTO emkt_countries VALUES (199,'Suriname','English','SR','SUR','');

INSERT INTO emkt_regions VALUES(3342, 199, 'BR', 'Brokopondo', 'English');
INSERT INTO emkt_regions VALUES(3343, 199, 'CM', 'Commewijne', 'English');
INSERT INTO emkt_regions VALUES(3344, 199, 'CR', 'Coronie', 'English');
INSERT INTO emkt_regions VALUES(3345, 199, 'MA', 'Marowijne', 'English');
INSERT INTO emkt_regions VALUES(3346, 199, 'NI', 'Nickerie', 'English');
INSERT INTO emkt_regions VALUES(3347, 199, 'PM', 'Paramaribo', 'English');
INSERT INTO emkt_regions VALUES(3348, 199, 'PR', 'Para', 'English');
INSERT INTO emkt_regions VALUES(3349, 199, 'SA', 'Saramacca', 'English');
INSERT INTO emkt_regions VALUES(3350, 199, 'SI', 'Sipaliwini', 'English');
INSERT INTO emkt_regions VALUES(3351, 199, 'WA', 'Wanica', 'English');

INSERT INTO emkt_countries VALUES (200,'Svalbard and Jan Mayen Islands','English','SJ','SJM','');

INSERT INTO emkt_regions VALUES(4277, 200, 'NOCODE', 'Svalbard and Jan Mayen Islands', 'English');

INSERT INTO emkt_countries VALUES (201,'Swaziland','English','SZ','SWZ','');

INSERT INTO emkt_regions VALUES(3352, 201, 'HH', 'Hhohho', 'English');
INSERT INTO emkt_regions VALUES(3353, 201, 'LU', 'Lubombo', 'English');
INSERT INTO emkt_regions VALUES(3354, 201, 'MA', 'Manzini', 'English');
INSERT INTO emkt_regions VALUES(3355, 201, 'SH', 'Shiselweni', 'English');

INSERT INTO emkt_countries VALUES (202,'Sweden','English','SE','SWE','');

INSERT INTO emkt_regions VALUES(3356, 202, 'AB', 'Stockholms län', 'English');
INSERT INTO emkt_regions VALUES(3357, 202, 'C', 'Uppsala län', 'English');
INSERT INTO emkt_regions VALUES(3358, 202, 'D', 'Södermanlands län', 'English');
INSERT INTO emkt_regions VALUES(3359, 202, 'E', 'Östergötlands län', 'English');
INSERT INTO emkt_regions VALUES(3360, 202, 'F', 'Jönköpings län', 'English');
INSERT INTO emkt_regions VALUES(3361, 202, 'G', 'Kronobergs län', 'English');
INSERT INTO emkt_regions VALUES(3362, 202, 'H', 'Kalmar län', 'English');
INSERT INTO emkt_regions VALUES(3363, 202, 'I', 'Gotlands län', 'English');
INSERT INTO emkt_regions VALUES(3364, 202, 'K', 'Blekinge län', 'English');
INSERT INTO emkt_regions VALUES(3365, 202, 'M', 'Skåne län', 'English');
INSERT INTO emkt_regions VALUES(3366, 202, 'N', 'Hallands län', 'English');
INSERT INTO emkt_regions VALUES(3367, 202, 'O', 'Västra Götalands län', 'English');
INSERT INTO emkt_regions VALUES(3368, 202, 'S', 'Värmlands län;', 'English');
INSERT INTO emkt_regions VALUES(3369, 202, 'T', 'Örebro län', 'English');
INSERT INTO emkt_regions VALUES(3370, 202, 'U', 'Västmanlands län;', 'English');
INSERT INTO emkt_regions VALUES(3371, 202, 'W', 'Dalarnas län', 'English');
INSERT INTO emkt_regions VALUES(3372, 202, 'X', 'Gävleborgs län', 'English');
INSERT INTO emkt_regions VALUES(3373, 202, 'Y', 'Västernorrlands län', 'English');
INSERT INTO emkt_regions VALUES(3374, 202, 'Z', 'Jämtlands län', 'English');
INSERT INTO emkt_regions VALUES(3375, 202, 'AC', 'Västerbottens län', 'English');
INSERT INTO emkt_regions VALUES(3376, 202, 'BD', 'Norrbottens län', 'English');

INSERT INTO emkt_countries VALUES (203,'Switzerland','English','CH','CHE','');

INSERT INTO emkt_regions VALUES(3377, 203, 'ZH', 'Zürich', 'English');
INSERT INTO emkt_regions VALUES(3378, 203, 'BE', 'Bern', 'English');
INSERT INTO emkt_regions VALUES(3379, 203, 'LU', 'Luzern', 'English');
INSERT INTO emkt_regions VALUES(3380, 203, 'UR', 'Uri', 'English');
INSERT INTO emkt_regions VALUES(3381, 203, 'SZ', 'Schwyz', 'English');
INSERT INTO emkt_regions VALUES(3382, 203, 'OW', 'Obwalden', 'English');
INSERT INTO emkt_regions VALUES(3383, 203, 'NW', 'Nidwalden', 'English');
INSERT INTO emkt_regions VALUES(3384, 203, 'GL', 'Glasrus', 'English');
INSERT INTO emkt_regions VALUES(3385, 203, 'ZG', 'Zug', 'English');
INSERT INTO emkt_regions VALUES(3386, 203, 'FR', 'Fribourg', 'English');
INSERT INTO emkt_regions VALUES(3387, 203, 'SO', 'Solothurn', 'English');
INSERT INTO emkt_regions VALUES(3388, 203, 'BS', 'Basel-Stadt', 'English');
INSERT INTO emkt_regions VALUES(3389, 203, 'BL', 'Basel-Landschaft', 'English');
INSERT INTO emkt_regions VALUES(3390, 203, 'SH', 'Schaffhausen', 'English');
INSERT INTO emkt_regions VALUES(3391, 203, 'AR', 'Appenzell Ausserrhoden', 'English');
INSERT INTO emkt_regions VALUES(3392, 203, 'AI', 'Appenzell Innerrhoden', 'English');
INSERT INTO emkt_regions VALUES(3393, 203, 'SG', 'Saint Gallen', 'English');
INSERT INTO emkt_regions VALUES(3394, 203, 'GR', 'Graubünden', 'English');
INSERT INTO emkt_regions VALUES(3395, 203, 'AG', 'Aargau', 'English');
INSERT INTO emkt_regions VALUES(3396, 203, 'TG', 'Thurgau', 'English');
INSERT INTO emkt_regions VALUES(3397, 203, 'TI', 'Ticino', 'English');
INSERT INTO emkt_regions VALUES(3398, 203, 'VD', 'Vaud', 'English');
INSERT INTO emkt_regions VALUES(3399, 203, 'VS', 'Valais', 'English');
INSERT INTO emkt_regions VALUES(3400, 203, 'NE', 'Nuechâtel', 'English');
INSERT INTO emkt_regions VALUES(3401, 203, 'GE', 'Genève', 'English');
INSERT INTO emkt_regions VALUES(3402, 203, 'JU', 'Jura', 'English');

INSERT INTO emkt_countries VALUES (204,'Syrian Arab Republic','English','SY','SYR','');

INSERT INTO emkt_regions VALUES(3403, 204, 'DI', 'دمشق', 'English');
INSERT INTO emkt_regions VALUES(3404, 204, 'DR', 'درعا', 'English');
INSERT INTO emkt_regions VALUES(3405, 204, 'DZ', 'دير الزور', 'English');
INSERT INTO emkt_regions VALUES(3406, 204, 'HA', 'الحسكة', 'English');
INSERT INTO emkt_regions VALUES(3407, 204, 'HI', 'حمص', 'English');
INSERT INTO emkt_regions VALUES(3408, 204, 'HL', 'حلب', 'English');
INSERT INTO emkt_regions VALUES(3409, 204, 'HM', 'حماه', 'English');
INSERT INTO emkt_regions VALUES(3410, 204, 'ID', 'ادلب', 'English');
INSERT INTO emkt_regions VALUES(3411, 204, 'LA', 'اللاذقية', 'English');
INSERT INTO emkt_regions VALUES(3412, 204, 'QU', 'القنيطرة', 'English');
INSERT INTO emkt_regions VALUES(3413, 204, 'RA', 'الرقة', 'English');
INSERT INTO emkt_regions VALUES(3414, 204, 'RD', 'ریف دمشق', 'English');
INSERT INTO emkt_regions VALUES(3415, 204, 'SU', 'السويداء', 'English');
INSERT INTO emkt_regions VALUES(3416, 204, 'TA', 'طرطوس', 'English');

INSERT INTO emkt_countries VALUES (205,'Taiwan','English','TW','TWN','');

INSERT INTO emkt_regions VALUES(3417, 205, 'CHA', '彰化縣', 'English');
INSERT INTO emkt_regions VALUES(3418, 205, 'CYI', '嘉義市', 'English');
INSERT INTO emkt_regions VALUES(3419, 205, 'CYQ', '嘉義縣', 'English');
INSERT INTO emkt_regions VALUES(3420, 205, 'HSQ', '新竹縣', 'English');
INSERT INTO emkt_regions VALUES(3421, 205, 'HSZ', '新竹市', 'English');
INSERT INTO emkt_regions VALUES(3422, 205, 'HUA', '花蓮縣', 'English');
INSERT INTO emkt_regions VALUES(3423, 205, 'ILA', '宜蘭縣', 'English');
INSERT INTO emkt_regions VALUES(3424, 205, 'KEE', '基隆市', 'English');
INSERT INTO emkt_regions VALUES(3425, 205, 'KHH', '高雄市', 'English');
INSERT INTO emkt_regions VALUES(3426, 205, 'KHQ', '高雄縣', 'English');
INSERT INTO emkt_regions VALUES(3427, 205, 'MIA', '苗栗縣', 'English');
INSERT INTO emkt_regions VALUES(3428, 205, 'NAN', '南投縣', 'English');
INSERT INTO emkt_regions VALUES(3429, 205, 'PEN', '澎湖縣', 'English');
INSERT INTO emkt_regions VALUES(3430, 205, 'PIF', '屏東縣', 'English');
INSERT INTO emkt_regions VALUES(3431, 205, 'TAO', '桃源县', 'English');
INSERT INTO emkt_regions VALUES(3432, 205, 'TNN', '台南市', 'English');
INSERT INTO emkt_regions VALUES(3433, 205, 'TNQ', '台南縣', 'English');
INSERT INTO emkt_regions VALUES(3434, 205, 'TPE', '臺北市', 'English');
INSERT INTO emkt_regions VALUES(3435, 205, 'TPQ', '臺北縣', 'English');
INSERT INTO emkt_regions VALUES(3436, 205, 'TTT', '台東縣', 'English');
INSERT INTO emkt_regions VALUES(3437, 205, 'TXG', '台中市', 'English');
INSERT INTO emkt_regions VALUES(3438, 205, 'TXQ', '台中縣', 'English');
INSERT INTO emkt_regions VALUES(3439, 205, 'YUN', '雲林縣', 'English');

INSERT INTO emkt_countries VALUES (206,'Tajikistan','English','TJ','TJK','');

INSERT INTO emkt_regions VALUES(3440, 206, 'GB', 'کوهستان بدخشان', 'English');
INSERT INTO emkt_regions VALUES(3441, 206, 'KT', 'ختلان', 'English');
INSERT INTO emkt_regions VALUES(3442, 206, 'SU', 'سغد', 'English');

INSERT INTO emkt_countries VALUES (207,'Tanzania','English','TZ','TZA','');

INSERT INTO emkt_regions VALUES(3443, 207, '01', 'Arusha', 'English');
INSERT INTO emkt_regions VALUES(3444, 207, '02', 'Dar es Salaam', 'English');
INSERT INTO emkt_regions VALUES(3445, 207, '03', 'Dodoma', 'English');
INSERT INTO emkt_regions VALUES(3446, 207, '04', 'Iringa', 'English');
INSERT INTO emkt_regions VALUES(3447, 207, '05', 'Kagera', 'English');
INSERT INTO emkt_regions VALUES(3448, 207, '06', 'Pemba Sever', 'English');
INSERT INTO emkt_regions VALUES(3449, 207, '07', 'Zanzibar Sever', 'English');
INSERT INTO emkt_regions VALUES(3450, 207, '08', 'Kigoma', 'English');
INSERT INTO emkt_regions VALUES(3451, 207, '09', 'Kilimanjaro', 'English');
INSERT INTO emkt_regions VALUES(3452, 207, '10', 'Pemba Jih', 'English');
INSERT INTO emkt_regions VALUES(3453, 207, '11', 'Zanzibar Jih', 'English');
INSERT INTO emkt_regions VALUES(3454, 207, '12', 'Lindi', 'English');
INSERT INTO emkt_regions VALUES(3455, 207, '13', 'Mara', 'English');
INSERT INTO emkt_regions VALUES(3456, 207, '14', 'Mbeya', 'English');
INSERT INTO emkt_regions VALUES(3457, 207, '15', 'Zanzibar Západ', 'English');
INSERT INTO emkt_regions VALUES(3458, 207, '16', 'Morogoro', 'English');
INSERT INTO emkt_regions VALUES(3459, 207, '17', 'Mtwara', 'English');
INSERT INTO emkt_regions VALUES(3460, 207, '18', 'Mwanza', 'English');
INSERT INTO emkt_regions VALUES(3461, 207, '19', 'Pwani', 'English');
INSERT INTO emkt_regions VALUES(3462, 207, '20', 'Rukwa', 'English');
INSERT INTO emkt_regions VALUES(3463, 207, '21', 'Ruvuma', 'English');
INSERT INTO emkt_regions VALUES(3464, 207, '22', 'Shinyanga', 'English');
INSERT INTO emkt_regions VALUES(3465, 207, '23', 'Singida', 'English');
INSERT INTO emkt_regions VALUES(3466, 207, '24', 'Tabora', 'English');
INSERT INTO emkt_regions VALUES(3467, 207, '25', 'Tanga', 'English');
INSERT INTO emkt_regions VALUES(3468, 207, '26', 'Manyara', 'English');

INSERT INTO emkt_countries VALUES (208,'Thailand','English','TH','THA','');

INSERT INTO emkt_regions VALUES(3469, 208, 'TH-10', 'กรุงเทพมหานคร', 'English');
INSERT INTO emkt_regions VALUES(3470, 208, 'TH-11', 'สมุทรปราการ', 'English');
INSERT INTO emkt_regions VALUES(3471, 208, 'TH-12', 'นนทบุรี', 'English');
INSERT INTO emkt_regions VALUES(3472, 208, 'TH-13', 'ปทุมธานี', 'English');
INSERT INTO emkt_regions VALUES(3473, 208, 'TH-14', 'พระนครศรีอยุธยา', 'English');
INSERT INTO emkt_regions VALUES(3474, 208, 'TH-15', 'อ่างทอง', 'English');
INSERT INTO emkt_regions VALUES(3475, 208, 'TH-16', 'ลพบุรี', 'English');
INSERT INTO emkt_regions VALUES(3476, 208, 'TH-17', 'สิงห์บุรี', 'English');
INSERT INTO emkt_regions VALUES(3477, 208, 'TH-18', 'ชัยนาท', 'English');
INSERT INTO emkt_regions VALUES(3478, 208, 'TH-19', 'สระบุรี', 'English');
INSERT INTO emkt_regions VALUES(3479, 208, 'TH-20', 'ชลบุรี', 'English');
INSERT INTO emkt_regions VALUES(3480, 208, 'TH-21', 'ระยอง', 'English');
INSERT INTO emkt_regions VALUES(3481, 208, 'TH-22', 'จันทบุรี', 'English');
INSERT INTO emkt_regions VALUES(3482, 208, 'TH-23', 'ตราด', 'English');
INSERT INTO emkt_regions VALUES(3483, 208, 'TH-24', 'ฉะเชิงเทรา', 'English');
INSERT INTO emkt_regions VALUES(3484, 208, 'TH-25', 'ปราจีนบุรี', 'English');
INSERT INTO emkt_regions VALUES(3485, 208, 'TH-26', 'นครนายก', 'English');
INSERT INTO emkt_regions VALUES(3486, 208, 'TH-27', 'สระแก้ว', 'English');
INSERT INTO emkt_regions VALUES(3487, 208, 'TH-30', 'นครราชสีมา', 'English');
INSERT INTO emkt_regions VALUES(3488, 208, 'TH-31', 'บุรีรัมย์', 'English');
INSERT INTO emkt_regions VALUES(3489, 208, 'TH-32', 'สุรินทร์', 'English');
INSERT INTO emkt_regions VALUES(3490, 208, 'TH-33', 'ศรีสะเกษ', 'English');
INSERT INTO emkt_regions VALUES(3491, 208, 'TH-34', 'อุบลราชธานี', 'English');
INSERT INTO emkt_regions VALUES(3492, 208, 'TH-35', 'ยโสธร', 'English');
INSERT INTO emkt_regions VALUES(3493, 208, 'TH-36', 'ชัยภูมิ', 'English');
INSERT INTO emkt_regions VALUES(3494, 208, 'TH-37', 'อำนาจเจริญ', 'English');
INSERT INTO emkt_regions VALUES(3495, 208, 'TH-39', 'หนองบัวลำภู', 'English');
INSERT INTO emkt_regions VALUES(3496, 208, 'TH-40', 'ขอนแก่น', 'English');
INSERT INTO emkt_regions VALUES(3497, 208, 'TH-41', 'อุดรธานี', 'English');
INSERT INTO emkt_regions VALUES(3498, 208, 'TH-42', 'เลย', 'English');
INSERT INTO emkt_regions VALUES(3499, 208, 'TH-43', 'หนองคาย', 'English');
INSERT INTO emkt_regions VALUES(3500, 208, 'TH-44', 'มหาสารคาม', 'English');
INSERT INTO emkt_regions VALUES(3501, 208, 'TH-45', 'ร้อยเอ็ด', 'English');
INSERT INTO emkt_regions VALUES(3502, 208, 'TH-46', 'กาฬสินธุ์', 'English');
INSERT INTO emkt_regions VALUES(3503, 208, 'TH-47', 'สกลนคร', 'English');
INSERT INTO emkt_regions VALUES(3504, 208, 'TH-48', 'นครพนม', 'English');
INSERT INTO emkt_regions VALUES(3505, 208, 'TH-49', 'มุกดาหาร', 'English');
INSERT INTO emkt_regions VALUES(3506, 208, 'TH-50', 'เชียงใหม่', 'English');
INSERT INTO emkt_regions VALUES(3507, 208, 'TH-51', 'ลำพูน', 'English');
INSERT INTO emkt_regions VALUES(3508, 208, 'TH-52', 'ลำปาง', 'English');
INSERT INTO emkt_regions VALUES(3509, 208, 'TH-53', 'อุตรดิตถ์', 'English');
INSERT INTO emkt_regions VALUES(3510, 208, 'TH-55', 'น่าน', 'English');
INSERT INTO emkt_regions VALUES(3511, 208, 'TH-56', 'พะเยา', 'English');
INSERT INTO emkt_regions VALUES(3512, 208, 'TH-57', 'เชียงราย', 'English');
INSERT INTO emkt_regions VALUES(3513, 208, 'TH-58', 'แม่ฮ่องสอน', 'English');
INSERT INTO emkt_regions VALUES(3514, 208, 'TH-60', 'นครสวรรค์', 'English');
INSERT INTO emkt_regions VALUES(3515, 208, 'TH-61', 'อุทัยธานี', 'English');
INSERT INTO emkt_regions VALUES(3516, 208, 'TH-62', 'กำแพงเพชร', 'English');
INSERT INTO emkt_regions VALUES(3517, 208, 'TH-63', 'ตาก', 'English');
INSERT INTO emkt_regions VALUES(3518, 208, 'TH-64', 'สุโขทัย', 'English');
INSERT INTO emkt_regions VALUES(3519, 208, 'TH-66', 'ชุมพร', 'English');
INSERT INTO emkt_regions VALUES(3520, 208, 'TH-67', 'พิจิตร', 'English');
INSERT INTO emkt_regions VALUES(3521, 208, 'TH-70', 'ราชบุรี', 'English');
INSERT INTO emkt_regions VALUES(3522, 208, 'TH-71', 'กาญจนบุรี', 'English');
INSERT INTO emkt_regions VALUES(3523, 208, 'TH-72', 'สุพรรณบุรี', 'English');
INSERT INTO emkt_regions VALUES(3524, 208, 'TH-73', 'นครปฐม', 'English');
INSERT INTO emkt_regions VALUES(3525, 208, 'TH-74', 'สมุทรสาคร', 'English');
INSERT INTO emkt_regions VALUES(3526, 208, 'TH-75', 'สมุทรสงคราม', 'English');
INSERT INTO emkt_regions VALUES(3527, 208, 'TH-76', 'เพชรบุรี', 'English');
INSERT INTO emkt_regions VALUES(3528, 208, 'TH-77', 'ประจวบคีรีขันธ์', 'English');
INSERT INTO emkt_regions VALUES(3529, 208, 'TH-80', 'นครศรีธรรมราช', 'English');
INSERT INTO emkt_regions VALUES(3530, 208, 'TH-81', 'กระบี่', 'English');
INSERT INTO emkt_regions VALUES(3531, 208, 'TH-82', 'พังงา', 'English');
INSERT INTO emkt_regions VALUES(3532, 208, 'TH-83', 'ภูเก็ต', 'English');
INSERT INTO emkt_regions VALUES(3533, 208, 'TH-84', 'สุราษฎร์ธานี', 'English');
INSERT INTO emkt_regions VALUES(3534, 208, 'TH-85', 'ระนอง', 'English');
INSERT INTO emkt_regions VALUES(3535, 208, 'TH-86', 'ชุมพร', 'English');
INSERT INTO emkt_regions VALUES(3536, 208, 'TH-90', 'สงขลา', 'English');
INSERT INTO emkt_regions VALUES(3537, 208, 'TH-91', 'สตูล', 'English');
INSERT INTO emkt_regions VALUES(3538, 208, 'TH-92', 'ตรัง', 'English');
INSERT INTO emkt_regions VALUES(3539, 208, 'TH-93', 'พัทลุง', 'English');
INSERT INTO emkt_regions VALUES(3540, 208, 'TH-94', 'ปัตตานี', 'English');
INSERT INTO emkt_regions VALUES(3541, 208, 'TH-95', 'ยะลา', 'English');
INSERT INTO emkt_regions VALUES(3542, 208, 'TH-96', 'นราธิวาส', 'English');

INSERT INTO emkt_countries VALUES (209,'Togo','English','TG','TGO','');

INSERT INTO emkt_regions VALUES(3543, 209, 'C', 'Centrale', 'English');
INSERT INTO emkt_regions VALUES(3544, 209, 'K', 'Kara', 'English');
INSERT INTO emkt_regions VALUES(3545, 209, 'M', 'Maritime', 'English');
INSERT INTO emkt_regions VALUES(3546, 209, 'P', 'Plateaux', 'English');
INSERT INTO emkt_regions VALUES(3547, 209, 'S', 'Savanes', 'English');

INSERT INTO emkt_countries VALUES (210,'Tokelau','English','TK','TKL','');

INSERT INTO emkt_regions VALUES(3548, 210, 'A', 'Atafu', 'English');
INSERT INTO emkt_regions VALUES(3549, 210, 'F', 'Fakaofo', 'English');
INSERT INTO emkt_regions VALUES(3550, 210, 'N', 'Nukunonu', 'English');

INSERT INTO emkt_countries VALUES (211,'Tonga','English','TO','TON','');

INSERT INTO emkt_regions VALUES(3551, 211, 'H', 'Ha\'apai', 'English');
INSERT INTO emkt_regions VALUES(3552, 211, 'T', 'Tongatapu', 'English');
INSERT INTO emkt_regions VALUES(3553, 211, 'V', 'Vava\'u', 'English');

INSERT INTO emkt_countries VALUES (212,'Trinidad and Tobago','English','TT','TTO','');

INSERT INTO emkt_regions VALUES(3554, 212, 'ARI', 'Arima', 'English');
INSERT INTO emkt_regions VALUES(3555, 212, 'CHA', 'Chaguanas', 'English');
INSERT INTO emkt_regions VALUES(3556, 212, 'CTT', 'Couva-Tabaquite-Talparo', 'English');
INSERT INTO emkt_regions VALUES(3557, 212, 'DMN', 'Diego Martin', 'English');
INSERT INTO emkt_regions VALUES(3558, 212, 'ETO', 'Eastern Tobago', 'English');
INSERT INTO emkt_regions VALUES(3559, 212, 'RCM', 'Rio Claro-Mayaro', 'English');
INSERT INTO emkt_regions VALUES(3560, 212, 'PED', 'Penal-Debe', 'English');
INSERT INTO emkt_regions VALUES(3561, 212, 'PTF', 'Point Fortin', 'English');
INSERT INTO emkt_regions VALUES(3562, 212, 'POS', 'Port of Spain', 'English');
INSERT INTO emkt_regions VALUES(3563, 212, 'PRT', 'Princes Town', 'English');
INSERT INTO emkt_regions VALUES(3564, 212, 'SFO', 'San Fernando', 'English');
INSERT INTO emkt_regions VALUES(3565, 212, 'SGE', 'Sangre Grande', 'English');
INSERT INTO emkt_regions VALUES(3566, 212, 'SJL', 'San Juan-Laventille', 'English');
INSERT INTO emkt_regions VALUES(3567, 212, 'SIP', 'Siparia', 'English');
INSERT INTO emkt_regions VALUES(3568, 212, 'TUP', 'Tunapuna-Piarco', 'English');
INSERT INTO emkt_regions VALUES(3569, 212, 'WTO', 'Western Tobago', 'English');

INSERT INTO emkt_countries VALUES (213,'Tunisia','English','TN','TUN','');

INSERT INTO emkt_regions VALUES(3570, 213, '11', 'ولاية تونس', 'English');
INSERT INTO emkt_regions VALUES(3571, 213, '12', 'ولاية أريانة', 'English');
INSERT INTO emkt_regions VALUES(3572, 213, '13', 'ولاية بن عروس', 'English');
INSERT INTO emkt_regions VALUES(3573, 213, '14', 'ولاية منوبة', 'English');
INSERT INTO emkt_regions VALUES(3574, 213, '21', 'ولاية نابل', 'English');
INSERT INTO emkt_regions VALUES(3575, 213, '22', 'ولاية زغوان', 'English');
INSERT INTO emkt_regions VALUES(3576, 213, '23', 'ولاية بنزرت', 'English');
INSERT INTO emkt_regions VALUES(3577, 213, '31', 'ولاية باجة', 'English');
INSERT INTO emkt_regions VALUES(3578, 213, '32', 'ولاية جندوبة', 'English');
INSERT INTO emkt_regions VALUES(3579, 213, '33', 'ولاية الكاف', 'English');
INSERT INTO emkt_regions VALUES(3580, 213, '34', 'ولاية سليانة', 'English');
INSERT INTO emkt_regions VALUES(3581, 213, '41', 'ولاية القيروان', 'English');
INSERT INTO emkt_regions VALUES(3582, 213, '42', 'ولاية القصرين', 'English');
INSERT INTO emkt_regions VALUES(3583, 213, '43', 'ولاية سيدي بوزيد', 'English');
INSERT INTO emkt_regions VALUES(3584, 213, '51', 'ولاية سوسة', 'English');
INSERT INTO emkt_regions VALUES(3585, 213, '52', 'ولاية المنستير', 'English');
INSERT INTO emkt_regions VALUES(3586, 213, '53', 'ولاية المهدية', 'English');
INSERT INTO emkt_regions VALUES(3587, 213, '61', 'ولاية صفاقس', 'English');
INSERT INTO emkt_regions VALUES(3588, 213, '71', 'ولاية قفصة', 'English');
INSERT INTO emkt_regions VALUES(3589, 213, '72', 'ولاية توزر', 'English');
INSERT INTO emkt_regions VALUES(3590, 213, '73', 'ولاية قبلي', 'English');
INSERT INTO emkt_regions VALUES(3591, 213, '81', 'ولاية قابس', 'English');
INSERT INTO emkt_regions VALUES(3592, 213, '82', 'ولاية مدنين', 'English');
INSERT INTO emkt_regions VALUES(3593, 213, '83', 'ولاية تطاوين', 'English');

INSERT INTO emkt_countries VALUES (214,'Turkey','English','TR','TUR','');

INSERT INTO emkt_regions VALUES(3594, 214, '01', 'Adana', 'English');
INSERT INTO emkt_regions VALUES(3595, 214, '02', 'Adıyaman', 'English');
INSERT INTO emkt_regions VALUES(3596, 214, '03', 'Afyonkarahisar', 'English');
INSERT INTO emkt_regions VALUES(3597, 214, '04', 'Ağrı', 'English');
INSERT INTO emkt_regions VALUES(3598, 214, '05', 'Amasya', 'English');
INSERT INTO emkt_regions VALUES(3599, 214, '06', 'Ankara', 'English');
INSERT INTO emkt_regions VALUES(3600, 214, '07', 'Antalya', 'English');
INSERT INTO emkt_regions VALUES(3601, 214, '08', 'Artvin', 'English');
INSERT INTO emkt_regions VALUES(3602, 214, '09', 'Aydın', 'English');
INSERT INTO emkt_regions VALUES(3603, 214, '10', 'Balıkesir', 'English');
INSERT INTO emkt_regions VALUES(3604, 214, '11', 'Bilecik', 'English');
INSERT INTO emkt_regions VALUES(3605, 214, '12', 'Bingöl', 'English');
INSERT INTO emkt_regions VALUES(3606, 214, '13', 'Bitlis', 'English');
INSERT INTO emkt_regions VALUES(3607, 214, '14', 'Bolu', 'English');
INSERT INTO emkt_regions VALUES(3608, 214, '15', 'Burdur', 'English');
INSERT INTO emkt_regions VALUES(3609, 214, '16', 'Bursa', 'English');
INSERT INTO emkt_regions VALUES(3610, 214, '17', 'Çanakkale', 'English');
INSERT INTO emkt_regions VALUES(3611, 214, '18', 'Çankırı', 'English');
INSERT INTO emkt_regions VALUES(3612, 214, '19', 'Çorum', 'English');
INSERT INTO emkt_regions VALUES(3613, 214, '20', 'Denizli', 'English');
INSERT INTO emkt_regions VALUES(3614, 214, '21', 'Diyarbakır', 'English');
INSERT INTO emkt_regions VALUES(3615, 214, '22', 'Edirne', 'English');
INSERT INTO emkt_regions VALUES(3616, 214, '23', 'Elazığ', 'English');
INSERT INTO emkt_regions VALUES(3617, 214, '24', 'Erzincan', 'English');
INSERT INTO emkt_regions VALUES(3618, 214, '25', 'Erzurum', 'English');
INSERT INTO emkt_regions VALUES(3619, 214, '26', 'Eskişehir', 'English');
INSERT INTO emkt_regions VALUES(3620, 214, '27', 'Gaziantep', 'English');
INSERT INTO emkt_regions VALUES(3621, 214, '28', 'Giresun', 'English');
INSERT INTO emkt_regions VALUES(3622, 214, '29', 'Gümüşhane', 'English');
INSERT INTO emkt_regions VALUES(3623, 214, '30', 'Hakkari', 'English');
INSERT INTO emkt_regions VALUES(3624, 214, '31', 'Hatay', 'English');
INSERT INTO emkt_regions VALUES(3625, 214, '32', 'Isparta', 'English');
INSERT INTO emkt_regions VALUES(3626, 214, '33', 'Mersin', 'English');
INSERT INTO emkt_regions VALUES(3627, 214, '34', 'İstanbul', 'English');
INSERT INTO emkt_regions VALUES(3628, 214, '35', 'İzmir', 'English');
INSERT INTO emkt_regions VALUES(3629, 214, '36', 'Kars', 'English');
INSERT INTO emkt_regions VALUES(3630, 214, '37', 'Kastamonu', 'English');
INSERT INTO emkt_regions VALUES(3631, 214, '38', 'Kayseri', 'English');
INSERT INTO emkt_regions VALUES(3632, 214, '39', 'Kırklareli', 'English');
INSERT INTO emkt_regions VALUES(3633, 214, '40', 'Kırşehir', 'English');
INSERT INTO emkt_regions VALUES(3634, 214, '41', 'Kocaeli', 'English');
INSERT INTO emkt_regions VALUES(3635, 214, '42', 'Konya', 'English');
INSERT INTO emkt_regions VALUES(3636, 214, '43', 'Kütahya', 'English');
INSERT INTO emkt_regions VALUES(3637, 214, '44', 'Malatya', 'English');
INSERT INTO emkt_regions VALUES(3638, 214, '45', 'Manisa', 'English');
INSERT INTO emkt_regions VALUES(3639, 214, '46', 'Kahramanmaraş', 'English');
INSERT INTO emkt_regions VALUES(3640, 214, '47', 'Mardin', 'English');
INSERT INTO emkt_regions VALUES(3641, 214, '48', 'Muğla', 'English');
INSERT INTO emkt_regions VALUES(3642, 214, '49', 'Muş', 'English');
INSERT INTO emkt_regions VALUES(3643, 214, '50', 'Nevşehir', 'English');
INSERT INTO emkt_regions VALUES(3644, 214, '51', 'Niğde', 'English');
INSERT INTO emkt_regions VALUES(3645, 214, '52', 'Ordu', 'English');
INSERT INTO emkt_regions VALUES(3646, 214, '53', 'Rize', 'English');
INSERT INTO emkt_regions VALUES(3647, 214, '54', 'Sakarya', 'English');
INSERT INTO emkt_regions VALUES(3648, 214, '55', 'Samsun', 'English');
INSERT INTO emkt_regions VALUES(3649, 214, '56', 'Siirt', 'English');
INSERT INTO emkt_regions VALUES(3650, 214, '57', 'Sinop', 'English');
INSERT INTO emkt_regions VALUES(3651, 214, '58', 'Sivas', 'English');
INSERT INTO emkt_regions VALUES(3652, 214, '59', 'Tekirdağ', 'English');
INSERT INTO emkt_regions VALUES(3653, 214, '60', 'Tokat', 'English');
INSERT INTO emkt_regions VALUES(3654, 214, '61', 'Trabzon', 'English');
INSERT INTO emkt_regions VALUES(3655, 214, '62', 'Tunceli', 'English');
INSERT INTO emkt_regions VALUES(3656, 214, '63', 'Şanlıurfa', 'English');
INSERT INTO emkt_regions VALUES(3657, 214, '64', 'Uşak', 'English');
INSERT INTO emkt_regions VALUES(3658, 214, '65', 'Van', 'English');
INSERT INTO emkt_regions VALUES(3659, 214, '66', 'Yozgat', 'English');
INSERT INTO emkt_regions VALUES(3660, 214, '67', 'Zonguldak', 'English');
INSERT INTO emkt_regions VALUES(3661, 214, '68', 'Aksaray', 'English');
INSERT INTO emkt_regions VALUES(3662, 214, '69', 'Bayburt', 'English');
INSERT INTO emkt_regions VALUES(3663, 214, '70', 'Karaman', 'English');
INSERT INTO emkt_regions VALUES(3664, 214, '71', 'Kırıkkale', 'English');
INSERT INTO emkt_regions VALUES(3665, 214, '72', 'Batman', 'English');
INSERT INTO emkt_regions VALUES(3666, 214, '73', 'Şırnak', 'English');
INSERT INTO emkt_regions VALUES(3667, 214, '74', 'Bartın', 'English');
INSERT INTO emkt_regions VALUES(3668, 214, '75', 'Ardahan', 'English');
INSERT INTO emkt_regions VALUES(3669, 214, '76', 'Iğdır', 'English');
INSERT INTO emkt_regions VALUES(3670, 214, '77', 'Yalova', 'English');
INSERT INTO emkt_regions VALUES(3671, 214, '78', 'Karabük', 'English');
INSERT INTO emkt_regions VALUES(3672, 214, '79', 'Kilis', 'English');
INSERT INTO emkt_regions VALUES(3673, 214, '80', 'Osmaniye', 'English');
INSERT INTO emkt_regions VALUES(3674, 214, '81', 'Düzce', 'English');

INSERT INTO emkt_countries VALUES (215,'Turkmenistan','English','TM','TKM','');

INSERT INTO emkt_regions VALUES(3675, 215, 'A', 'Ahal welaýaty', 'English');
INSERT INTO emkt_regions VALUES(3676, 215, 'B', 'Balkan welaýaty', 'English');
INSERT INTO emkt_regions VALUES(3677, 215, 'D', 'Daşoguz welaýaty', 'English');
INSERT INTO emkt_regions VALUES(3678, 215, 'L', 'Lebap welaýaty', 'English');
INSERT INTO emkt_regions VALUES(3679, 215, 'M', 'Mary welaýaty', 'English');

INSERT INTO emkt_countries VALUES (216,'Turks and Caicos Islands','English','TC','TCA','');

INSERT INTO emkt_regions VALUES(3680, 216, 'AC', 'Ambergris Cays', 'English');
INSERT INTO emkt_regions VALUES(3681, 216, 'DC', 'Dellis Cay', 'English');
INSERT INTO emkt_regions VALUES(3682, 216, 'FC', 'French Cay', 'English');
INSERT INTO emkt_regions VALUES(3683, 216, 'LW', 'Little Water Cay', 'English');
INSERT INTO emkt_regions VALUES(3684, 216, 'RC', 'Parrot Cay', 'English');
INSERT INTO emkt_regions VALUES(3685, 216, 'PN', 'Pine Cay', 'English');
INSERT INTO emkt_regions VALUES(3686, 216, 'SL', 'Salt Cay', 'English');
INSERT INTO emkt_regions VALUES(3687, 216, 'GT', 'Grand Turk', 'English');
INSERT INTO emkt_regions VALUES(3688, 216, 'SC', 'South Caicos', 'English');
INSERT INTO emkt_regions VALUES(3689, 216, 'EC', 'East Caicos', 'English');
INSERT INTO emkt_regions VALUES(3690, 216, 'MC', 'Middle Caicos', 'English');
INSERT INTO emkt_regions VALUES(3691, 216, 'NC', 'North Caicos', 'English');
INSERT INTO emkt_regions VALUES(3692, 216, 'PR', 'Providenciales', 'English');
INSERT INTO emkt_regions VALUES(3693, 216, 'WC', 'West Caicos', 'English');

INSERT INTO emkt_countries VALUES (217,'Tuvalu','English','TV','TUV','');

INSERT INTO emkt_regions VALUES(3694, 217, 'FUN', 'Funafuti', 'English');
INSERT INTO emkt_regions VALUES(3695, 217, 'NMA', 'Nanumea', 'English');
INSERT INTO emkt_regions VALUES(3696, 217, 'NMG', 'Nanumanga', 'English');
INSERT INTO emkt_regions VALUES(3697, 217, 'NIT', 'Niutao', 'English');
INSERT INTO emkt_regions VALUES(3698, 217, 'NIU', 'Nui', 'English');
INSERT INTO emkt_regions VALUES(3699, 217, 'NKF', 'Nukufetau', 'English');
INSERT INTO emkt_regions VALUES(3700, 217, 'NKL', 'Nukulaelae', 'English');
INSERT INTO emkt_regions VALUES(3701, 217, 'VAI', 'Vaitupu', 'English');

INSERT INTO emkt_countries VALUES (218,'Uganda','English','UG','UGA','');

INSERT INTO emkt_regions VALUES(3702, 218, '101', 'Kalangala', 'English');
INSERT INTO emkt_regions VALUES(3703, 218, '102', 'Kampala', 'English');
INSERT INTO emkt_regions VALUES(3704, 218, '103', 'Kiboga', 'English');
INSERT INTO emkt_regions VALUES(3705, 218, '104', 'Luwero', 'English');
INSERT INTO emkt_regions VALUES(3706, 218, '105', 'Masaka', 'English');
INSERT INTO emkt_regions VALUES(3707, 218, '106', 'Mpigi', 'English');
INSERT INTO emkt_regions VALUES(3708, 218, '107', 'Mubende', 'English');
INSERT INTO emkt_regions VALUES(3709, 218, '108', 'Mukono', 'English');
INSERT INTO emkt_regions VALUES(3710, 218, '109', 'Nakasongola', 'English');
INSERT INTO emkt_regions VALUES(3711, 218, '110', 'Rakai', 'English');
INSERT INTO emkt_regions VALUES(3712, 218, '111', 'Sembabule', 'English');
INSERT INTO emkt_regions VALUES(3713, 218, '112', 'Kayunga', 'English');
INSERT INTO emkt_regions VALUES(3714, 218, '113', 'Wakiso', 'English');
INSERT INTO emkt_regions VALUES(3715, 218, '201', 'Bugiri', 'English');
INSERT INTO emkt_regions VALUES(3716, 218, '202', 'Busia', 'English');
INSERT INTO emkt_regions VALUES(3717, 218, '203', 'Iganga', 'English');
INSERT INTO emkt_regions VALUES(3718, 218, '204', 'Jinja', 'English');
INSERT INTO emkt_regions VALUES(3719, 218, '205', 'Kamuli', 'English');
INSERT INTO emkt_regions VALUES(3720, 218, '206', 'Kapchorwa', 'English');
INSERT INTO emkt_regions VALUES(3721, 218, '207', 'Katakwi', 'English');
INSERT INTO emkt_regions VALUES(3722, 218, '208', 'Kumi', 'English');
INSERT INTO emkt_regions VALUES(3723, 218, '209', 'Mbale', 'English');
INSERT INTO emkt_regions VALUES(3724, 218, '210', 'Pallisa', 'English');
INSERT INTO emkt_regions VALUES(3725, 218, '211', 'Soroti', 'English');
INSERT INTO emkt_regions VALUES(3726, 218, '212', 'Tororo', 'English');
INSERT INTO emkt_regions VALUES(3727, 218, '213', 'Kaberamaido', 'English');
INSERT INTO emkt_regions VALUES(3728, 218, '214', 'Mayuge', 'English');
INSERT INTO emkt_regions VALUES(3729, 218, '215', 'Sironko', 'English');
INSERT INTO emkt_regions VALUES(3730, 218, '301', 'Adjumani', 'English');
INSERT INTO emkt_regions VALUES(3731, 218, '302', 'Apac', 'English');
INSERT INTO emkt_regions VALUES(3732, 218, '303', 'Arua', 'English');
INSERT INTO emkt_regions VALUES(3733, 218, '304', 'Gulu', 'English');
INSERT INTO emkt_regions VALUES(3734, 218, '305', 'Kitgum', 'English');
INSERT INTO emkt_regions VALUES(3735, 218, '306', 'Kotido', 'English');
INSERT INTO emkt_regions VALUES(3736, 218, '307', 'Lira', 'English');
INSERT INTO emkt_regions VALUES(3737, 218, '308', 'Moroto', 'English');
INSERT INTO emkt_regions VALUES(3738, 218, '309', 'Moyo', 'English');
INSERT INTO emkt_regions VALUES(3739, 218, '310', 'Nebbi', 'English');
INSERT INTO emkt_regions VALUES(3740, 218, '311', 'Nakapiripirit', 'English');
INSERT INTO emkt_regions VALUES(3741, 218, '312', 'Pader', 'English');
INSERT INTO emkt_regions VALUES(3742, 218, '313', 'Yumbe', 'English');
INSERT INTO emkt_regions VALUES(3743, 218, '401', 'Bundibugyo', 'English');
INSERT INTO emkt_regions VALUES(3744, 218, '402', 'Bushenyi', 'English');
INSERT INTO emkt_regions VALUES(3745, 218, '403', 'Hoima', 'English');
INSERT INTO emkt_regions VALUES(3746, 218, '404', 'Kabale', 'English');
INSERT INTO emkt_regions VALUES(3747, 218, '405', 'Kabarole', 'English');
INSERT INTO emkt_regions VALUES(3748, 218, '406', 'Kasese', 'English');
INSERT INTO emkt_regions VALUES(3749, 218, '407', 'Kibale', 'English');
INSERT INTO emkt_regions VALUES(3750, 218, '408', 'Kisoro', 'English');
INSERT INTO emkt_regions VALUES(3751, 218, '409', 'Masindi', 'English');
INSERT INTO emkt_regions VALUES(3752, 218, '410', 'Mbarara', 'English');
INSERT INTO emkt_regions VALUES(3753, 218, '411', 'Ntungamo', 'English');
INSERT INTO emkt_regions VALUES(3754, 218, '412', 'Rukungiri', 'English');
INSERT INTO emkt_regions VALUES(3755, 218, '413', 'Kamwenge', 'English');
INSERT INTO emkt_regions VALUES(3756, 218, '414', 'Kanungu', 'English');
INSERT INTO emkt_regions VALUES(3757, 218, '415', 'Kyenjojo', 'English');

INSERT INTO emkt_countries VALUES (219,'Ukraine','English','UA','UKR','');

INSERT INTO emkt_regions VALUES(3758, 219, '05', 'Вінницька область', 'English');
INSERT INTO emkt_regions VALUES(3759, 219, '07', 'Волинська область', 'English');
INSERT INTO emkt_regions VALUES(3760, 219, '09', 'Луганська область', 'English');
INSERT INTO emkt_regions VALUES(3761, 219, '12', 'Дніпропетровська область', 'English');
INSERT INTO emkt_regions VALUES(3762, 219, '14', 'Донецька область', 'English');
INSERT INTO emkt_regions VALUES(3763, 219, '18', 'Житомирська область', 'English');
INSERT INTO emkt_regions VALUES(3764, 219, '19', 'Рівненська область', 'English');
INSERT INTO emkt_regions VALUES(3765, 219, '21', 'Закарпатська область', 'English');
INSERT INTO emkt_regions VALUES(3766, 219, '23', 'Запорізька область', 'English');
INSERT INTO emkt_regions VALUES(3767, 219, '26', 'Івано-Франківська область', 'English');
INSERT INTO emkt_regions VALUES(3768, 219, '30', 'Київ', 'English');
INSERT INTO emkt_regions VALUES(3769, 219, '32', 'Київська область', 'English');
INSERT INTO emkt_regions VALUES(3770, 219, '35', 'Кіровоградська область', 'English');
INSERT INTO emkt_regions VALUES(3771, 219, '46', 'Львівська область', 'English');
INSERT INTO emkt_regions VALUES(3772, 219, '48', 'Миколаївська область', 'English');
INSERT INTO emkt_regions VALUES(3773, 219, '51', 'Одеська область', 'English');
INSERT INTO emkt_regions VALUES(3774, 219, '53', 'Полтавська область', 'English');
INSERT INTO emkt_regions VALUES(3775, 219, '59', 'Сумська область', 'English');
INSERT INTO emkt_regions VALUES(3776, 219, '61', 'Тернопільська область', 'English');
INSERT INTO emkt_regions VALUES(3777, 219, '63', 'Харківська область', 'English');
INSERT INTO emkt_regions VALUES(3778, 219, '65', 'Херсонська область', 'English');
INSERT INTO emkt_regions VALUES(3779, 219, '68', 'Хмельницька область', 'English');
INSERT INTO emkt_regions VALUES(3780, 219, '71', 'Черкаська область', 'English');
INSERT INTO emkt_regions VALUES(3781, 219, '74', 'Чернігівська область', 'English');
INSERT INTO emkt_regions VALUES(3782, 219, '77', 'Чернівецька область', 'English');

INSERT INTO emkt_countries VALUES (220,'United Arab Emirates','English','AE','ARE','');

INSERT INTO emkt_regions VALUES(4278, 220, 'NOCODE', 'United Arab Emirates', 'English');

INSERT INTO emkt_countries VALUES (221,'United Kingdom','English','GB','GBR','');

INSERT INTO emkt_regions VALUES(3783, 221, 'ABD', 'Aberdeenshire', 'English');
INSERT INTO emkt_regions VALUES(3784, 221, 'ABE', 'Aberdeen', 'English');
INSERT INTO emkt_regions VALUES(3785, 221, 'AGB', 'Argyll and Bute', 'English');
INSERT INTO emkt_regions VALUES(3786, 221, 'AGY', 'Isle of Anglesey', 'English');
INSERT INTO emkt_regions VALUES(3787, 221, 'ANS', 'Angus', 'English');
INSERT INTO emkt_regions VALUES(3788, 221, 'ANT', 'Antrim', 'English');
INSERT INTO emkt_regions VALUES(3789, 221, 'ARD', 'Ards', 'English');
INSERT INTO emkt_regions VALUES(3790, 221, 'ARM', 'Armagh', 'English');
INSERT INTO emkt_regions VALUES(3791, 221, 'BAS', 'Bath and North East Somerset', 'English');
INSERT INTO emkt_regions VALUES(3792, 221, 'BBD', 'Blackburn with Darwen', 'English');
INSERT INTO emkt_regions VALUES(3793, 221, 'BDF', 'Bedfordshire', 'English');
INSERT INTO emkt_regions VALUES(3794, 221, 'BDG', 'Barking and Dagenham', 'English');
INSERT INTO emkt_regions VALUES(3795, 221, 'BEN', 'Brent', 'English');
INSERT INTO emkt_regions VALUES(3796, 221, 'BEX', 'Bexley', 'English');
INSERT INTO emkt_regions VALUES(3797, 221, 'BFS', 'Belfast', 'English');
INSERT INTO emkt_regions VALUES(3798, 221, 'BGE', 'Bridgend', 'English');
INSERT INTO emkt_regions VALUES(3799, 221, 'BGW', 'Blaenau Gwent', 'English');
INSERT INTO emkt_regions VALUES(3800, 221, 'BIR', 'Birmingham', 'English');
INSERT INTO emkt_regions VALUES(3801, 221, 'BKM', 'Buckinghamshire', 'English');
INSERT INTO emkt_regions VALUES(3802, 221, 'BLA', 'Ballymena', 'English');
INSERT INTO emkt_regions VALUES(3803, 221, 'BLY', 'Ballymoney', 'English');
INSERT INTO emkt_regions VALUES(3804, 221, 'BMH', 'Bournemouth', 'English');
INSERT INTO emkt_regions VALUES(3805, 221, 'BNB', 'Banbridge', 'English');
INSERT INTO emkt_regions VALUES(3806, 221, 'BNE', 'Barnet', 'English');
INSERT INTO emkt_regions VALUES(3807, 221, 'BNH', 'Brighton and Hove', 'English');
INSERT INTO emkt_regions VALUES(3808, 221, 'BNS', 'Barnsley', 'English');
INSERT INTO emkt_regions VALUES(3809, 221, 'BOL', 'Bolton', 'English');
INSERT INTO emkt_regions VALUES(3810, 221, 'BPL', 'Blackpool', 'English');
INSERT INTO emkt_regions VALUES(3811, 221, 'BRC', 'Bracknell', 'English');
INSERT INTO emkt_regions VALUES(3812, 221, 'BRD', 'Bradford', 'English');
INSERT INTO emkt_regions VALUES(3813, 221, 'BRY', 'Bromley', 'English');
INSERT INTO emkt_regions VALUES(3814, 221, 'BST', 'Bristol', 'English');
INSERT INTO emkt_regions VALUES(3815, 221, 'BUR', 'Bury', 'English');
INSERT INTO emkt_regions VALUES(3816, 221, 'CAM', 'Cambridgeshire', 'English');
INSERT INTO emkt_regions VALUES(3817, 221, 'CAY', 'Caerphilly', 'English');
INSERT INTO emkt_regions VALUES(3818, 221, 'CGN', 'Ceredigion', 'English');
INSERT INTO emkt_regions VALUES(3819, 221, 'CGV', 'Craigavon', 'English');
INSERT INTO emkt_regions VALUES(3820, 221, 'CHS', 'Cheshire', 'English');
INSERT INTO emkt_regions VALUES(3821, 221, 'CKF', 'Carrickfergus', 'English');
INSERT INTO emkt_regions VALUES(3822, 221, 'CKT', 'Cookstown', 'English');
INSERT INTO emkt_regions VALUES(3823, 221, 'CLD', 'Calderdale', 'English');
INSERT INTO emkt_regions VALUES(3824, 221, 'CLK', 'Clackmannanshire', 'English');
INSERT INTO emkt_regions VALUES(3825, 221, 'CLR', 'Coleraine', 'English');
INSERT INTO emkt_regions VALUES(3826, 221, 'CMA', 'Cumbria', 'English');
INSERT INTO emkt_regions VALUES(3827, 221, 'CMD', 'Camden', 'English');
INSERT INTO emkt_regions VALUES(3828, 221, 'CMN', 'Carmarthenshire', 'English');
INSERT INTO emkt_regions VALUES(3829, 221, 'CON', 'Cornwall', 'English');
INSERT INTO emkt_regions VALUES(3830, 221, 'COV', 'Coventry', 'English');
INSERT INTO emkt_regions VALUES(3831, 221, 'CRF', 'Cardiff', 'English');
INSERT INTO emkt_regions VALUES(3832, 221, 'CRY', 'Croydon', 'English');
INSERT INTO emkt_regions VALUES(3833, 221, 'CSR', 'Castlereagh', 'English');
INSERT INTO emkt_regions VALUES(3834, 221, 'CWY', 'Conwy', 'English');
INSERT INTO emkt_regions VALUES(3835, 221, 'DAL', 'Darlington', 'English');
INSERT INTO emkt_regions VALUES(3836, 221, 'DBY', 'Derbyshire', 'English');
INSERT INTO emkt_regions VALUES(3837, 221, 'DEN', 'Denbighshire', 'English');
INSERT INTO emkt_regions VALUES(3838, 221, 'DER', 'Derby', 'English');
INSERT INTO emkt_regions VALUES(3839, 221, 'DEV', 'Devon', 'English');
INSERT INTO emkt_regions VALUES(3840, 221, 'DGN', 'Dungannon and South Tyrone', 'English');
INSERT INTO emkt_regions VALUES(3841, 221, 'DGY', 'Dumfries and Galloway', 'English');
INSERT INTO emkt_regions VALUES(3842, 221, 'DNC', 'Doncaster', 'English');
INSERT INTO emkt_regions VALUES(3843, 221, 'DND', 'Dundee', 'English');
INSERT INTO emkt_regions VALUES(3844, 221, 'DOR', 'Dorset', 'English');
INSERT INTO emkt_regions VALUES(3845, 221, 'DOW', 'Down', 'English');
INSERT INTO emkt_regions VALUES(3846, 221, 'DRY', 'Derry', 'English');
INSERT INTO emkt_regions VALUES(3847, 221, 'DUD', 'Dudley', 'English');
INSERT INTO emkt_regions VALUES(3848, 221, 'DUR', 'Durham', 'English');
INSERT INTO emkt_regions VALUES(3849, 221, 'EAL', 'Ealing', 'English');
INSERT INTO emkt_regions VALUES(3850, 221, 'EAY', 'East Ayrshire', 'English');
INSERT INTO emkt_regions VALUES(3851, 221, 'EDH', 'Edinburgh', 'English');
INSERT INTO emkt_regions VALUES(3852, 221, 'EDU', 'East Dunbartonshire', 'English');
INSERT INTO emkt_regions VALUES(3853, 221, 'ELN', 'East Lothian', 'English');
INSERT INTO emkt_regions VALUES(3854, 221, 'ELS', 'Eilean Siar', 'English');
INSERT INTO emkt_regions VALUES(3855, 221, 'ENF', 'Enfield', 'English');
INSERT INTO emkt_regions VALUES(3856, 221, 'ERW', 'East Renfrewshire', 'English');
INSERT INTO emkt_regions VALUES(3857, 221, 'ERY', 'East Riding of Yorkshire', 'English');
INSERT INTO emkt_regions VALUES(3858, 221, 'ESS', 'Essex', 'English');
INSERT INTO emkt_regions VALUES(3859, 221, 'ESX', 'East Sussex', 'English');
INSERT INTO emkt_regions VALUES(3860, 221, 'FAL', 'Falkirk', 'English');
INSERT INTO emkt_regions VALUES(3861, 221, 'FER', 'Fermanagh', 'English');
INSERT INTO emkt_regions VALUES(3862, 221, 'FIF', 'Fife', 'English');
INSERT INTO emkt_regions VALUES(3863, 221, 'FLN', 'Flintshire', 'English');
INSERT INTO emkt_regions VALUES(3864, 221, 'GAT', 'Gateshead', 'English');
INSERT INTO emkt_regions VALUES(3865, 221, 'GLG', 'Glasgow', 'English');
INSERT INTO emkt_regions VALUES(3866, 221, 'GLS', 'Gloucestershire', 'English');
INSERT INTO emkt_regions VALUES(3867, 221, 'GRE', 'Greenwich', 'English');
INSERT INTO emkt_regions VALUES(3868, 221, 'GSY', 'Guernsey', 'English');
INSERT INTO emkt_regions VALUES(3869, 221, 'GWN', 'Gwynedd', 'English');
INSERT INTO emkt_regions VALUES(3870, 221, 'HAL', 'Halton', 'English');
INSERT INTO emkt_regions VALUES(3871, 221, 'HAM', 'Hampshire', 'English');
INSERT INTO emkt_regions VALUES(3872, 221, 'HAV', 'Havering', 'English');
INSERT INTO emkt_regions VALUES(3873, 221, 'HCK', 'Hackney', 'English');
INSERT INTO emkt_regions VALUES(3874, 221, 'HEF', 'Herefordshire', 'English');
INSERT INTO emkt_regions VALUES(3875, 221, 'HIL', 'Hillingdon', 'English');
INSERT INTO emkt_regions VALUES(3876, 221, 'HLD', 'Highland', 'English');
INSERT INTO emkt_regions VALUES(3877, 221, 'HMF', 'Hammersmith and Fulham', 'English');
INSERT INTO emkt_regions VALUES(3878, 221, 'HNS', 'Hounslow', 'English');
INSERT INTO emkt_regions VALUES(3879, 221, 'HPL', 'Hartlepool', 'English');
INSERT INTO emkt_regions VALUES(3880, 221, 'HRT', 'Hertfordshire', 'English');
INSERT INTO emkt_regions VALUES(3881, 221, 'HRW', 'Harrow', 'English');
INSERT INTO emkt_regions VALUES(3882, 221, 'HRY', 'Haringey', 'English');
INSERT INTO emkt_regions VALUES(3883, 221, 'IOS', 'Isles of Scilly', 'English');
INSERT INTO emkt_regions VALUES(3884, 221, 'IOW', 'Isle of Wight', 'English');
INSERT INTO emkt_regions VALUES(3885, 221, 'ISL', 'Islington', 'English');
INSERT INTO emkt_regions VALUES(3886, 221, 'IVC', 'Inverclyde', 'English');
INSERT INTO emkt_regions VALUES(3887, 221, 'JSY', 'Jersey', 'English');
INSERT INTO emkt_regions VALUES(3888, 221, 'KEC', 'Kensington and Chelsea', 'English');
INSERT INTO emkt_regions VALUES(3889, 221, 'KEN', 'Kent', 'English');
INSERT INTO emkt_regions VALUES(3890, 221, 'KHL', 'Kingston upon Hull', 'English');
INSERT INTO emkt_regions VALUES(3891, 221, 'KIR', 'Kirklees', 'English');
INSERT INTO emkt_regions VALUES(3892, 221, 'KTT', 'Kingston upon Thames', 'English');
INSERT INTO emkt_regions VALUES(3893, 221, 'KWL', 'Knowsley', 'English');
INSERT INTO emkt_regions VALUES(3894, 221, 'LAN', 'Lancashire', 'English');
INSERT INTO emkt_regions VALUES(3895, 221, 'LBH', 'Lambeth', 'English');
INSERT INTO emkt_regions VALUES(3896, 221, 'LCE', 'Leicester', 'English');
INSERT INTO emkt_regions VALUES(3897, 221, 'LDS', 'Leeds', 'English');
INSERT INTO emkt_regions VALUES(3898, 221, 'LEC', 'Leicestershire', 'English');
INSERT INTO emkt_regions VALUES(3899, 221, 'LEW', 'Lewisham', 'English');
INSERT INTO emkt_regions VALUES(3900, 221, 'LIN', 'Lincolnshire', 'English');
INSERT INTO emkt_regions VALUES(3901, 221, 'LIV', 'Liverpool', 'English');
INSERT INTO emkt_regions VALUES(3902, 221, 'LMV', 'Limavady', 'English');
INSERT INTO emkt_regions VALUES(3903, 221, 'LND', 'London', 'English');
INSERT INTO emkt_regions VALUES(3904, 221, 'LRN', 'Larne', 'English');
INSERT INTO emkt_regions VALUES(3905, 221, 'LSB', 'Lisburn', 'English');
INSERT INTO emkt_regions VALUES(3906, 221, 'LUT', 'Luton', 'English');
INSERT INTO emkt_regions VALUES(3907, 221, 'MAN', 'Manchester', 'English');
INSERT INTO emkt_regions VALUES(3908, 221, 'MDB', 'Middlesbrough', 'English');
INSERT INTO emkt_regions VALUES(3909, 221, 'MDW', 'Medway', 'English');
INSERT INTO emkt_regions VALUES(3910, 221, 'MFT', 'Magherafelt', 'English');
INSERT INTO emkt_regions VALUES(3911, 221, 'MIK', 'Milton Keynes', 'English');
INSERT INTO emkt_regions VALUES(3912, 221, 'MLN', 'Midlothian', 'English');
INSERT INTO emkt_regions VALUES(3913, 221, 'MON', 'Monmouthshire', 'English');
INSERT INTO emkt_regions VALUES(3914, 221, 'MRT', 'Merton', 'English');
INSERT INTO emkt_regions VALUES(3915, 221, 'MRY', 'Moray', 'English');
INSERT INTO emkt_regions VALUES(3916, 221, 'MTY', 'Merthyr Tydfil', 'English');
INSERT INTO emkt_regions VALUES(3917, 221, 'MYL', 'Moyle', 'English');
INSERT INTO emkt_regions VALUES(3918, 221, 'NAY', 'North Ayrshire', 'English');
INSERT INTO emkt_regions VALUES(3919, 221, 'NBL', 'Northumberland', 'English');
INSERT INTO emkt_regions VALUES(3920, 221, 'NDN', 'North Down', 'English');
INSERT INTO emkt_regions VALUES(3921, 221, 'NEL', 'North East Lincolnshire', 'English');
INSERT INTO emkt_regions VALUES(3922, 221, 'NET', 'Newcastle upon Tyne', 'English');
INSERT INTO emkt_regions VALUES(3923, 221, 'NFK', 'Norfolk', 'English');
INSERT INTO emkt_regions VALUES(3924, 221, 'NGM', 'Nottingham', 'English');
INSERT INTO emkt_regions VALUES(3925, 221, 'NLK', 'North Lanarkshire', 'English');
INSERT INTO emkt_regions VALUES(3926, 221, 'NLN', 'North Lincolnshire', 'English');
INSERT INTO emkt_regions VALUES(3927, 221, 'NSM', 'North Somerset', 'English');
INSERT INTO emkt_regions VALUES(3928, 221, 'NTA', 'Newtownabbey', 'English');
INSERT INTO emkt_regions VALUES(3929, 221, 'NTH', 'Northamptonshire', 'English');
INSERT INTO emkt_regions VALUES(3930, 221, 'NTL', 'Neath Port Talbot', 'English');
INSERT INTO emkt_regions VALUES(3931, 221, 'NTT', 'Nottinghamshire', 'English');
INSERT INTO emkt_regions VALUES(3932, 221, 'NTY', 'North Tyneside', 'English');
INSERT INTO emkt_regions VALUES(3933, 221, 'NWM', 'Newham', 'English');
INSERT INTO emkt_regions VALUES(3934, 221, 'NWP', 'Newport', 'English');
INSERT INTO emkt_regions VALUES(3935, 221, 'NYK', 'North Yorkshire', 'English');
INSERT INTO emkt_regions VALUES(3936, 221, 'NYM', 'Newry and Mourne', 'English');
INSERT INTO emkt_regions VALUES(3937, 221, 'OLD', 'Oldham', 'English');
INSERT INTO emkt_regions VALUES(3938, 221, 'OMH', 'Omagh', 'English');
INSERT INTO emkt_regions VALUES(3939, 221, 'ORK', 'Orkney Islands', 'English');
INSERT INTO emkt_regions VALUES(3940, 221, 'OXF', 'Oxfordshire', 'English');
INSERT INTO emkt_regions VALUES(3941, 221, 'PEM', 'Pembrokeshire', 'English');
INSERT INTO emkt_regions VALUES(3942, 221, 'PKN', 'Perth and Kinross', 'English');
INSERT INTO emkt_regions VALUES(3943, 221, 'PLY', 'Plymouth', 'English');
INSERT INTO emkt_regions VALUES(3944, 221, 'POL', 'Poole', 'English');
INSERT INTO emkt_regions VALUES(3945, 221, 'POR', 'Portsmouth', 'English');
INSERT INTO emkt_regions VALUES(3946, 221, 'POW', 'Powys', 'English');
INSERT INTO emkt_regions VALUES(3947, 221, 'PTE', 'Peterborough', 'English');
INSERT INTO emkt_regions VALUES(3948, 221, 'RCC', 'Redcar and Cleveland', 'English');
INSERT INTO emkt_regions VALUES(3949, 221, 'RCH', 'Rochdale', 'English');
INSERT INTO emkt_regions VALUES(3950, 221, 'RCT', 'Rhondda Cynon Taf', 'English');
INSERT INTO emkt_regions VALUES(3951, 221, 'RDB', 'Redbridge', 'English');
INSERT INTO emkt_regions VALUES(3952, 221, 'RDG', 'Reading', 'English');
INSERT INTO emkt_regions VALUES(3953, 221, 'RFW', 'Renfrewshire', 'English');
INSERT INTO emkt_regions VALUES(3954, 221, 'RIC', 'Richmond upon Thames', 'English');
INSERT INTO emkt_regions VALUES(3955, 221, 'ROT', 'Rotherham', 'English');
INSERT INTO emkt_regions VALUES(3956, 221, 'RUT', 'Rutland', 'English');
INSERT INTO emkt_regions VALUES(3957, 221, 'SAW', 'Sandwell', 'English');
INSERT INTO emkt_regions VALUES(3958, 221, 'SAY', 'South Ayrshire', 'English');
INSERT INTO emkt_regions VALUES(3959, 221, 'SCB', 'Scottish Borders', 'English');
INSERT INTO emkt_regions VALUES(3960, 221, 'SFK', 'Suffolk', 'English');
INSERT INTO emkt_regions VALUES(3961, 221, 'SFT', 'Sefton', 'English');
INSERT INTO emkt_regions VALUES(3962, 221, 'SGC', 'South Gloucestershire', 'English');
INSERT INTO emkt_regions VALUES(3963, 221, 'SHF', 'Sheffield', 'English');
INSERT INTO emkt_regions VALUES(3964, 221, 'SHN', 'Saint Helens', 'English');
INSERT INTO emkt_regions VALUES(3965, 221, 'SHR', 'Shropshire', 'English');
INSERT INTO emkt_regions VALUES(3966, 221, 'SKP', 'Stockport', 'English');
INSERT INTO emkt_regions VALUES(3967, 221, 'SLF', 'Salford', 'English');
INSERT INTO emkt_regions VALUES(3968, 221, 'SLG', 'Slough', 'English');
INSERT INTO emkt_regions VALUES(3969, 221, 'SLK', 'South Lanarkshire', 'English');
INSERT INTO emkt_regions VALUES(3970, 221, 'SND', 'Sunderland', 'English');
INSERT INTO emkt_regions VALUES(3971, 221, 'SOL', 'Solihull', 'English');
INSERT INTO emkt_regions VALUES(3972, 221, 'SOM', 'Somerset', 'English');
INSERT INTO emkt_regions VALUES(3973, 221, 'SOS', 'Southend-on-Sea', 'English');
INSERT INTO emkt_regions VALUES(3974, 221, 'SRY', 'Surrey', 'English');
INSERT INTO emkt_regions VALUES(3975, 221, 'STB', 'Strabane', 'English');
INSERT INTO emkt_regions VALUES(3976, 221, 'STE', 'Stoke-on-Trent', 'English');
INSERT INTO emkt_regions VALUES(3977, 221, 'STG', 'Stirling', 'English');
INSERT INTO emkt_regions VALUES(3978, 221, 'STH', 'Southampton', 'English');
INSERT INTO emkt_regions VALUES(3979, 221, 'STN', 'Sutton', 'English');
INSERT INTO emkt_regions VALUES(3980, 221, 'STS', 'Staffordshire', 'English');
INSERT INTO emkt_regions VALUES(3981, 221, 'STT', 'Stockton-on-Tees', 'English');
INSERT INTO emkt_regions VALUES(3982, 221, 'STY', 'South Tyneside', 'English');
INSERT INTO emkt_regions VALUES(3983, 221, 'SWA', 'Swansea', 'English');
INSERT INTO emkt_regions VALUES(3984, 221, 'SWD', 'Swindon', 'English');
INSERT INTO emkt_regions VALUES(3985, 221, 'SWK', 'Southwark', 'English');
INSERT INTO emkt_regions VALUES(3986, 221, 'TAM', 'Tameside', 'English');
INSERT INTO emkt_regions VALUES(3987, 221, 'TFW', 'Telford and Wrekin', 'English');
INSERT INTO emkt_regions VALUES(3988, 221, 'THR', 'Thurrock', 'English');
INSERT INTO emkt_regions VALUES(3989, 221, 'TOB', 'Torbay', 'English');
INSERT INTO emkt_regions VALUES(3990, 221, 'TOF', 'Torfaen', 'English');
INSERT INTO emkt_regions VALUES(3991, 221, 'TRF', 'Trafford', 'English');
INSERT INTO emkt_regions VALUES(3992, 221, 'TWH', 'Tower Hamlets', 'English');
INSERT INTO emkt_regions VALUES(3993, 221, 'VGL', 'Vale of Glamorgan', 'English');
INSERT INTO emkt_regions VALUES(3994, 221, 'WAR', 'Warwickshire', 'English');
INSERT INTO emkt_regions VALUES(3995, 221, 'WBK', 'West Berkshire', 'English');
INSERT INTO emkt_regions VALUES(3996, 221, 'WDU', 'West Dunbartonshire', 'English');
INSERT INTO emkt_regions VALUES(3997, 221, 'WFT', 'Waltham Forest', 'English');
INSERT INTO emkt_regions VALUES(3998, 221, 'WGN', 'Wigan', 'English');
INSERT INTO emkt_regions VALUES(3999, 221, 'WIL', 'Wiltshire', 'English');
INSERT INTO emkt_regions VALUES(4000, 221, 'WKF', 'Wakefield', 'English');
INSERT INTO emkt_regions VALUES(4001, 221, 'WLL', 'Walsall', 'English');
INSERT INTO emkt_regions VALUES(4002, 221, 'WLN', 'West Lothian', 'English');
INSERT INTO emkt_regions VALUES(4003, 221, 'WLV', 'Wolverhampton', 'English');
INSERT INTO emkt_regions VALUES(4004, 221, 'WNM', 'Windsor and Maidenhead', 'English');
INSERT INTO emkt_regions VALUES(4005, 221, 'WOK', 'Wokingham', 'English');
INSERT INTO emkt_regions VALUES(4006, 221, 'WOR', 'Worcestershire', 'English');
INSERT INTO emkt_regions VALUES(4007, 221, 'WRL', 'Wirral', 'English');
INSERT INTO emkt_regions VALUES(4008, 221, 'WRT', 'Warrington', 'English');
INSERT INTO emkt_regions VALUES(4009, 221, 'WRX', 'Wrexham', 'English');
INSERT INTO emkt_regions VALUES(4010, 221, 'WSM', 'Westminster', 'English');
INSERT INTO emkt_regions VALUES(4011, 221, 'WSX', 'West Sussex', 'English');
INSERT INTO emkt_regions VALUES(4012, 221, 'YOR', 'York', 'English');
INSERT INTO emkt_regions VALUES(4013, 221, 'ZET', 'Shetland Islands', 'English');

INSERT INTO emkt_countries VALUES (222,'United States of America','English','US','USA','');

INSERT INTO emkt_regions VALUES(4014, 222, 'AK', 'Alaska', 'English');
INSERT INTO emkt_regions VALUES(4015, 222, 'AL', 'Alabama', 'English');
INSERT INTO emkt_regions VALUES(4016, 222, 'AS', 'American Samoa', 'English');
INSERT INTO emkt_regions VALUES(4017, 222, 'AR', 'Arkansas', 'English');
INSERT INTO emkt_regions VALUES(4018, 222, 'AZ', 'Arizona', 'English');
INSERT INTO emkt_regions VALUES(4019, 222, 'CA', 'California', 'English');
INSERT INTO emkt_regions VALUES(4020, 222, 'CO', 'Colorado', 'English');
INSERT INTO emkt_regions VALUES(4021, 222, 'CT', 'Connecticut', 'English');
INSERT INTO emkt_regions VALUES(4022, 222, 'DC', 'District of Columbia', 'English');
INSERT INTO emkt_regions VALUES(4023, 222, 'DE', 'Delaware', 'English');
INSERT INTO emkt_regions VALUES(4024, 222, 'FL', 'Florida', 'English');
INSERT INTO emkt_regions VALUES(4025, 222, 'GA', 'Georgia', 'English');
INSERT INTO emkt_regions VALUES(4026, 222, 'GU', 'Guam', 'English');
INSERT INTO emkt_regions VALUES(4027, 222, 'HI', 'Hawaii', 'English');
INSERT INTO emkt_regions VALUES(4028, 222, 'IA', 'Iowa', 'English');
INSERT INTO emkt_regions VALUES(4029, 222, 'ID', 'Idaho', 'English');
INSERT INTO emkt_regions VALUES(4030, 222, 'IL', 'Illinois', 'English');
INSERT INTO emkt_regions VALUES(4031, 222, 'IN', 'Indiana', 'English');
INSERT INTO emkt_regions VALUES(4032, 222, 'KS', 'Kansas', 'English');
INSERT INTO emkt_regions VALUES(4033, 222, 'KY', 'Kentucky', 'English');
INSERT INTO emkt_regions VALUES(4034, 222, 'LA', 'Louisiana', 'English');
INSERT INTO emkt_regions VALUES(4035, 222, 'MA', 'Massachusetts', 'English');
INSERT INTO emkt_regions VALUES(4036, 222, 'MD', 'Maryland', 'English');
INSERT INTO emkt_regions VALUES(4037, 222, 'ME', 'Maine', 'English');
INSERT INTO emkt_regions VALUES(4038, 222, 'MI', 'Michigan', 'English');
INSERT INTO emkt_regions VALUES(4039, 222, 'MN', 'Minnesota', 'English');
INSERT INTO emkt_regions VALUES(4040, 222, 'MO', 'Missouri', 'English');
INSERT INTO emkt_regions VALUES(4041, 222, 'MS', 'Mississippi', 'English');
INSERT INTO emkt_regions VALUES(4042, 222, 'MT', 'Montana', 'English');
INSERT INTO emkt_regions VALUES(4043, 222, 'NC', 'North Carolina', 'English');
INSERT INTO emkt_regions VALUES(4044, 222, 'ND', 'North Dakota', 'English');
INSERT INTO emkt_regions VALUES(4045, 222, 'NE', 'Nebraska', 'English');
INSERT INTO emkt_regions VALUES(4046, 222, 'NH', 'New Hampshire', 'English');
INSERT INTO emkt_regions VALUES(4047, 222, 'NJ', 'New Jersey', 'English');
INSERT INTO emkt_regions VALUES(4048, 222, 'NM', 'New Mexico', 'English');
INSERT INTO emkt_regions VALUES(4049, 222, 'NV', 'Nevada', 'English');
INSERT INTO emkt_regions VALUES(4050, 222, 'NY', 'New York', 'English');
INSERT INTO emkt_regions VALUES(4051, 222, 'MP', 'Northern Mariana Islands', 'English');
INSERT INTO emkt_regions VALUES(4052, 222, 'OH', 'Ohio', 'English');
INSERT INTO emkt_regions VALUES(4053, 222, 'OK', 'Oklahoma', 'English');
INSERT INTO emkt_regions VALUES(4054, 222, 'OR', 'Oregon', 'English');
INSERT INTO emkt_regions VALUES(4055, 222, 'PA', 'Pennsylvania', 'English');
INSERT INTO emkt_regions VALUES(4056, 222, 'PR', 'Puerto Rico', 'English');
INSERT INTO emkt_regions VALUES(4057, 222, 'RI', 'Rhode Island', 'English');
INSERT INTO emkt_regions VALUES(4058, 222, 'SC', 'South Carolina', 'English');
INSERT INTO emkt_regions VALUES(4059, 222, 'SD', 'South Dakota', 'English');
INSERT INTO emkt_regions VALUES(4060, 222, 'TN', 'Tennessee', 'English');
INSERT INTO emkt_regions VALUES(4061, 222, 'TX', 'Texas', 'English');
INSERT INTO emkt_regions VALUES(4062, 222, 'UM', 'U.S. Minor Outlying Islands', 'English');
INSERT INTO emkt_regions VALUES(4063, 222, 'UT', 'Utah', 'English');
INSERT INTO emkt_regions VALUES(4064, 222, 'VA', 'Virginia', 'English');
INSERT INTO emkt_regions VALUES(4065, 222, 'VI', 'Virgin Islands of the U.S.', 'English');
INSERT INTO emkt_regions VALUES(4066, 222, 'VT', 'Vermont', 'English');
INSERT INTO emkt_regions VALUES(4067, 222, 'WA', 'Washington', 'English');
INSERT INTO emkt_regions VALUES(4068, 222, 'WI', 'Wisconsin', 'English');
INSERT INTO emkt_regions VALUES(4069, 222, 'WV', 'West Virginia', 'English');
INSERT INTO emkt_regions VALUES(4070, 222, 'WY', 'Wyoming', 'English');

INSERT INTO emkt_countries VALUES (223,'United States Minor Outlying Islands','English','UM','UMI','');

INSERT INTO emkt_regions VALUES(4071, 223, 'BI', 'Baker Island', 'English');
INSERT INTO emkt_regions VALUES(4072, 223, 'HI', 'Howland Island', 'English');
INSERT INTO emkt_regions VALUES(4073, 223, 'JI', 'Jarvis Island', 'English');
INSERT INTO emkt_regions VALUES(4074, 223, 'JA', 'Johnston Atoll', 'English');
INSERT INTO emkt_regions VALUES(4075, 223, 'KR', 'Kingman Reef', 'English');
INSERT INTO emkt_regions VALUES(4076, 223, 'MA', 'Midway Atoll', 'English');
INSERT INTO emkt_regions VALUES(4077, 223, 'NI', 'Navassa Island', 'English');
INSERT INTO emkt_regions VALUES(4078, 223, 'PA', 'Palmyra Atoll', 'English');
INSERT INTO emkt_regions VALUES(4079, 223, 'WI', 'Wake Island', 'English');

INSERT INTO emkt_countries VALUES (224,'Uruguay','English','UY','URY','');

INSERT INTO emkt_regions VALUES(4080, 224, 'AR', 'Artigas', 'English');
INSERT INTO emkt_regions VALUES(4081, 224, 'CA', 'Canelones', 'English');
INSERT INTO emkt_regions VALUES(4082, 224, 'CL', 'Cerro Largo', 'English');
INSERT INTO emkt_regions VALUES(4083, 224, 'CO', 'Colonia', 'English');
INSERT INTO emkt_regions VALUES(4084, 224, 'DU', 'Durazno', 'English');
INSERT INTO emkt_regions VALUES(4085, 224, 'FD', 'Florida', 'English');
INSERT INTO emkt_regions VALUES(4086, 224, 'FS', 'Flores', 'English');
INSERT INTO emkt_regions VALUES(4087, 224, 'LA', 'Lavalleja', 'English');
INSERT INTO emkt_regions VALUES(4088, 224, 'MA', 'Maldonado', 'English');
INSERT INTO emkt_regions VALUES(4089, 224, 'MO', 'Montevideo', 'English');
INSERT INTO emkt_regions VALUES(4090, 224, 'PA', 'Paysandu', 'English');
INSERT INTO emkt_regions VALUES(4091, 224, 'RN', 'Río Negro', 'English');
INSERT INTO emkt_regions VALUES(4092, 224, 'RO', 'Rocha', 'English');
INSERT INTO emkt_regions VALUES(4093, 224, 'RV', 'Rivera', 'English');
INSERT INTO emkt_regions VALUES(4094, 224, 'SA', 'Salto', 'English');
INSERT INTO emkt_regions VALUES(4095, 224, 'SJ', 'San José', 'English');
INSERT INTO emkt_regions VALUES(4096, 224, 'SO', 'Soriano', 'English');
INSERT INTO emkt_regions VALUES(4097, 224, 'TA', 'Tacuarembó', 'English');
INSERT INTO emkt_regions VALUES(4098, 224, 'TT', 'Treinta y Tres', 'English');

INSERT INTO emkt_countries VALUES (225,'Uzbekistan','English','UZ','UZB','');

INSERT INTO emkt_regions VALUES(4099, 225, 'AN', 'Andijon viloyati', 'English');
INSERT INTO emkt_regions VALUES(4100, 225, 'BU', 'Buxoro viloyati', 'English');
INSERT INTO emkt_regions VALUES(4101, 225, 'FA', 'Farg\'ona viloyati', 'English');
INSERT INTO emkt_regions VALUES(4102, 225, 'JI', 'Jizzax viloyati', 'English');
INSERT INTO emkt_regions VALUES(4103, 225, 'NG', 'Namangan viloyati', 'English');
INSERT INTO emkt_regions VALUES(4104, 225, 'NW', 'Navoiy viloyati', 'English');
INSERT INTO emkt_regions VALUES(4105, 225, 'QA', 'Qashqadaryo viloyati', 'English');
INSERT INTO emkt_regions VALUES(4106, 225, 'QR', 'Qoraqalpog\'iston Respublikasi', 'English');
INSERT INTO emkt_regions VALUES(4107, 225, 'SA', 'Samarqand viloyati', 'English');
INSERT INTO emkt_regions VALUES(4108, 225, 'SI', 'Sirdaryo viloyati', 'English');
INSERT INTO emkt_regions VALUES(4109, 225, 'SU', 'Surxondaryo viloyati', 'English');
INSERT INTO emkt_regions VALUES(4110, 225, 'TK', 'Toshkent', 'English');
INSERT INTO emkt_regions VALUES(4111, 225, 'TO', 'Toshkent viloyati', 'English');
INSERT INTO emkt_regions VALUES(4112, 225, 'XO', 'Xorazm viloyati', 'English');

INSERT INTO emkt_countries VALUES (226,'Vanuatu','English','VU','VUT','');

INSERT INTO emkt_regions VALUES(4113, 226, 'MAP', 'Malampa', 'English');
INSERT INTO emkt_regions VALUES(4114, 226, 'PAM', 'Pénama', 'English');
INSERT INTO emkt_regions VALUES(4115, 226, 'SAM', 'Sanma', 'English');
INSERT INTO emkt_regions VALUES(4116, 226, 'SEE', 'Shéfa', 'English');
INSERT INTO emkt_regions VALUES(4117, 226, 'TAE', 'Taféa', 'English');
INSERT INTO emkt_regions VALUES(4118, 226, 'TOB', 'Torba', 'English');

INSERT INTO emkt_countries VALUES (227,'Vatican City State (Holy See)','English','VA','VAT','');

INSERT INTO emkt_regions VALUES(4279, 227, 'NOCODE', 'Vatican City State (Holy See)', 'English');

INSERT INTO emkt_countries VALUES (228,'Venezuela','English','VE','VEN','');

INSERT INTO emkt_regions VALUES(4119, 228, 'A', 'Distrito Capital', 'English');
INSERT INTO emkt_regions VALUES(4120, 228, 'B', 'Anzoátegui', 'English');
INSERT INTO emkt_regions VALUES(4121, 228, 'C', 'Apure', 'English');
INSERT INTO emkt_regions VALUES(4122, 228, 'D', 'Aragua', 'English');
INSERT INTO emkt_regions VALUES(4123, 228, 'E', 'Barinas', 'English');
INSERT INTO emkt_regions VALUES(4124, 228, 'F', 'Bolívar', 'English');
INSERT INTO emkt_regions VALUES(4125, 228, 'G', 'Carabobo', 'English');
INSERT INTO emkt_regions VALUES(4126, 228, 'H', 'Cojedes', 'English');
INSERT INTO emkt_regions VALUES(4127, 228, 'I', 'Falcón', 'English');
INSERT INTO emkt_regions VALUES(4128, 228, 'J', 'Guárico', 'English');
INSERT INTO emkt_regions VALUES(4129, 228, 'K', 'Lara', 'English');
INSERT INTO emkt_regions VALUES(4130, 228, 'L', 'Mérida', 'English');
INSERT INTO emkt_regions VALUES(4131, 228, 'M', 'Miranda', 'English');
INSERT INTO emkt_regions VALUES(4132, 228, 'N', 'Monagas', 'English');
INSERT INTO emkt_regions VALUES(4133, 228, 'O', 'Nueva Esparta', 'English');
INSERT INTO emkt_regions VALUES(4134, 228, 'P', 'Portuguesa', 'English');
INSERT INTO emkt_regions VALUES(4135, 228, 'R', 'Sucre', 'English');
INSERT INTO emkt_regions VALUES(4136, 228, 'S', 'Tachira', 'English');
INSERT INTO emkt_regions VALUES(4137, 228, 'T', 'Trujillo', 'English');
INSERT INTO emkt_regions VALUES(4138, 228, 'U', 'Yaracuy', 'English');
INSERT INTO emkt_regions VALUES(4139, 228, 'V', 'Zulia', 'English');
INSERT INTO emkt_regions VALUES(4140, 228, 'W', 'Capital Dependencia', 'English');
INSERT INTO emkt_regions VALUES(4141, 228, 'X', 'Vargas', 'English');
INSERT INTO emkt_regions VALUES(4142, 228, 'Y', 'Delta Amacuro', 'English');
INSERT INTO emkt_regions VALUES(4143, 228, 'Z', 'Amazonas', 'English');

INSERT INTO emkt_countries VALUES (229,'Vietnam','English','VN','VNM','');

INSERT INTO emkt_regions VALUES(4144, 229, '01', 'Lai Châu', 'English');
INSERT INTO emkt_regions VALUES(4145, 229, '02', 'Lào Cai', 'English');
INSERT INTO emkt_regions VALUES(4146, 229, '03', 'Hà Giang', 'English');
INSERT INTO emkt_regions VALUES(4147, 229, '04', 'Cao Bằng', 'English');
INSERT INTO emkt_regions VALUES(4148, 229, '05', 'Sơn La', 'English');
INSERT INTO emkt_regions VALUES(4149, 229, '06', 'Yên Bái', 'English');
INSERT INTO emkt_regions VALUES(4150, 229, '07', 'Tuyên Quang', 'English');
INSERT INTO emkt_regions VALUES(4151, 229, '09', 'Lạng Sơn', 'English');
INSERT INTO emkt_regions VALUES(4152, 229, '13', 'Quảng Ninh', 'English');
INSERT INTO emkt_regions VALUES(4153, 229, '14', 'Hòa Bình', 'English');
INSERT INTO emkt_regions VALUES(4154, 229, '15', 'Hà Tây', 'English');
INSERT INTO emkt_regions VALUES(4155, 229, '18', 'Ninh Bình', 'English');
INSERT INTO emkt_regions VALUES(4156, 229, '20', 'Thái Bình', 'English');
INSERT INTO emkt_regions VALUES(4157, 229, '21', 'Thanh Hóa', 'English');
INSERT INTO emkt_regions VALUES(4158, 229, '22', 'Nghệ An', 'English');
INSERT INTO emkt_regions VALUES(4159, 229, '23', 'Hà Tĩnh', 'English');
INSERT INTO emkt_regions VALUES(4160, 229, '24', 'Quảng Bình', 'English');
INSERT INTO emkt_regions VALUES(4161, 229, '25', 'Quảng Trị', 'English');
INSERT INTO emkt_regions VALUES(4162, 229, '26', 'Thừa Thiên-Huế', 'English');
INSERT INTO emkt_regions VALUES(4163, 229, '27', 'Quảng Nam', 'English');
INSERT INTO emkt_regions VALUES(4164, 229, '28', 'Kon Tum', 'English');
INSERT INTO emkt_regions VALUES(4165, 229, '29', 'Quảng Ngãi', 'English');
INSERT INTO emkt_regions VALUES(4166, 229, '30', 'Gia Lai', 'English');
INSERT INTO emkt_regions VALUES(4167, 229, '31', 'Bình Định', 'English');
INSERT INTO emkt_regions VALUES(4168, 229, '32', 'Phú Yên', 'English');
INSERT INTO emkt_regions VALUES(4169, 229, '33', 'Đắk Lắk', 'English');
INSERT INTO emkt_regions VALUES(4170, 229, '34', 'Khánh Hòa', 'English');
INSERT INTO emkt_regions VALUES(4171, 229, '35', 'Lâm Đồng', 'English');
INSERT INTO emkt_regions VALUES(4172, 229, '36', 'Ninh Thuận', 'English');
INSERT INTO emkt_regions VALUES(4173, 229, '37', 'Tây Ninh', 'English');
INSERT INTO emkt_regions VALUES(4174, 229, '39', 'Đồng Nai', 'English');
INSERT INTO emkt_regions VALUES(4175, 229, '40', 'Bình Thuận', 'English');
INSERT INTO emkt_regions VALUES(4176, 229, '41', 'Long An', 'English');
INSERT INTO emkt_regions VALUES(4177, 229, '43', 'Bà Rịa-Vũng Tàu', 'English');
INSERT INTO emkt_regions VALUES(4178, 229, '44', 'An Giang', 'English');
INSERT INTO emkt_regions VALUES(4179, 229, '45', 'Đồng Tháp', 'English');
INSERT INTO emkt_regions VALUES(4180, 229, '46', 'Tiền Giang', 'English');
INSERT INTO emkt_regions VALUES(4181, 229, '47', 'Kiên Giang', 'English');
INSERT INTO emkt_regions VALUES(4182, 229, '48', 'Cần Thơ', 'English');
INSERT INTO emkt_regions VALUES(4183, 229, '49', 'Vĩnh Long', 'English');
INSERT INTO emkt_regions VALUES(4184, 229, '50', 'Bến Tre', 'English');
INSERT INTO emkt_regions VALUES(4185, 229, '51', 'Trà Vinh', 'English');
INSERT INTO emkt_regions VALUES(4186, 229, '52', 'Sóc Trăng', 'English');
INSERT INTO emkt_regions VALUES(4187, 229, '53', 'Bắc Kạn', 'English');
INSERT INTO emkt_regions VALUES(4188, 229, '54', 'Bắc Giang', 'English');
INSERT INTO emkt_regions VALUES(4189, 229, '55', 'Bạc Liêu', 'English');
INSERT INTO emkt_regions VALUES(4190, 229, '56', 'Bắc Ninh', 'English');
INSERT INTO emkt_regions VALUES(4191, 229, '57', 'Bình Dương', 'English');
INSERT INTO emkt_regions VALUES(4192, 229, '58', 'Bình Phước', 'English');
INSERT INTO emkt_regions VALUES(4193, 229, '59', 'Cà Mau', 'English');
INSERT INTO emkt_regions VALUES(4194, 229, '60', 'Đà Nẵng', 'English');
INSERT INTO emkt_regions VALUES(4195, 229, '61', 'Hải Dương', 'English');
INSERT INTO emkt_regions VALUES(4196, 229, '62', 'Hải Phòng', 'English');
INSERT INTO emkt_regions VALUES(4197, 229, '63', 'Hà Nam', 'English');
INSERT INTO emkt_regions VALUES(4198, 229, '64', 'Hà Nội', 'English');
INSERT INTO emkt_regions VALUES(4199, 229, '65', 'Sài Gòn', 'English');
INSERT INTO emkt_regions VALUES(4200, 229, '66', 'Hưng Yên', 'English');
INSERT INTO emkt_regions VALUES(4201, 229, '67', 'Nam Định', 'English');
INSERT INTO emkt_regions VALUES(4202, 229, '68', 'Phú Thọ', 'English');
INSERT INTO emkt_regions VALUES(4203, 229, '69', 'Thái Nguyên', 'English');
INSERT INTO emkt_regions VALUES(4204, 229, '70', 'Vĩnh Phúc', 'English');
INSERT INTO emkt_regions VALUES(4205, 229, '71', 'Điện Biên', 'English');
INSERT INTO emkt_regions VALUES(4206, 229, '72', 'Đắk Nông', 'English');
INSERT INTO emkt_regions VALUES(4207, 229, '73', 'Hậu Giang', 'English');

INSERT INTO emkt_countries VALUES (230,'Virgin Islands (British)','English','VG','VGB','');

INSERT INTO emkt_regions VALUES(4280, 230, 'NOCODE', 'Virgin Islands (British)', 'English');

INSERT INTO emkt_countries VALUES (231,'Virgin Islands (U.S.)','English','VI','VIR','');

INSERT INTO emkt_regions VALUES(4208, 231, 'C', 'Saint Croix', 'English');
INSERT INTO emkt_regions VALUES(4209, 231, 'J', 'Saint John', 'English');
INSERT INTO emkt_regions VALUES(4210, 231, 'T', 'Saint Thomas', 'English');

INSERT INTO emkt_countries VALUES (232,'Wallis and Futuna Islands','English','WF','WLF','');

INSERT INTO emkt_regions VALUES(4211, 232, 'A', 'Alo', 'English');
INSERT INTO emkt_regions VALUES(4212, 232, 'S', 'Sigave', 'English');
INSERT INTO emkt_regions VALUES(4213, 232, 'W', 'Wallis', 'English');

INSERT INTO emkt_countries VALUES (233,'Western Sahara','English','EH','ESH','');

INSERT INTO emkt_regions VALUES(4281, 233, 'NOCODE', 'Western Sahara', 'English');

INSERT INTO emkt_countries VALUES (234,'Yemen','English','YE','YEM','');

INSERT INTO emkt_regions VALUES(4214, 234, 'AB', 'أبين‎', 'English');
INSERT INTO emkt_regions VALUES(4215, 234, 'AD', 'عدن', 'English');
INSERT INTO emkt_regions VALUES(4216, 234, 'AM', 'عمران', 'English');
INSERT INTO emkt_regions VALUES(4217, 234, 'BA', 'البيضاء', 'English');
INSERT INTO emkt_regions VALUES(4218, 234, 'DA', 'الضالع', 'English');
INSERT INTO emkt_regions VALUES(4219, 234, 'DH', 'ذمار', 'English');
INSERT INTO emkt_regions VALUES(4220, 234, 'HD', 'حضرموت', 'English');
INSERT INTO emkt_regions VALUES(4221, 234, 'HJ', 'حجة', 'English');
INSERT INTO emkt_regions VALUES(4222, 234, 'HU', 'الحديدة', 'English');
INSERT INTO emkt_regions VALUES(4223, 234, 'IB', 'إب', 'English');
INSERT INTO emkt_regions VALUES(4224, 234, 'JA', 'الجوف', 'English');
INSERT INTO emkt_regions VALUES(4225, 234, 'LA', 'لحج', 'English');
INSERT INTO emkt_regions VALUES(4226, 234, 'MA', 'مأرب', 'English');
INSERT INTO emkt_regions VALUES(4227, 234, 'MR', 'المهرة', 'English');
INSERT INTO emkt_regions VALUES(4228, 234, 'MW', 'المحويت', 'English');
INSERT INTO emkt_regions VALUES(4229, 234, 'SD', 'صعدة', 'English');
INSERT INTO emkt_regions VALUES(4230, 234, 'SN', 'صنعاء', 'English');
INSERT INTO emkt_regions VALUES(4231, 234, 'SH', 'شبوة', 'English');
INSERT INTO emkt_regions VALUES(4232, 234, 'TA', 'تعز', 'English');

INSERT INTO emkt_countries VALUES (235,'Yugoslavia','English','YU','YUG','');

INSERT INTO emkt_regions VALUES(4282, 235, 'NOCODE', 'Yugoslavia', 'English');

INSERT INTO emkt_countries VALUES (236,'Zaire','English','ZR','ZAR','');

INSERT INTO emkt_regions VALUES(4283, 236, 'NOCODE', 'Zaire', 'English');

INSERT INTO emkt_countries VALUES (237,'Zambia','English','ZM','ZMB','');

INSERT INTO emkt_regions VALUES(4233, 237, '01', 'Western', 'English');
INSERT INTO emkt_regions VALUES(4234, 237, '02', 'Central', 'English');
INSERT INTO emkt_regions VALUES(4235, 237, '03', 'Eastern', 'English');
INSERT INTO emkt_regions VALUES(4236, 237, '04', 'Luapula', 'English');
INSERT INTO emkt_regions VALUES(4237, 237, '05', 'Northern', 'English');
INSERT INTO emkt_regions VALUES(4238, 237, '06', 'North-Western', 'English');
INSERT INTO emkt_regions VALUES(4239, 237, '07', 'Southern', 'English');
INSERT INTO emkt_regions VALUES(4240, 237, '08', 'Copperbelt', 'English');
INSERT INTO emkt_regions VALUES(4241, 237, '09', 'Lusaka', 'English');

INSERT INTO emkt_countries VALUES (238,'Zimbabwe','English','ZW','ZWE','');

INSERT INTO emkt_regions VALUES(4242, 238, 'MA', 'Manicaland', 'English');
INSERT INTO emkt_regions VALUES(4243, 238, 'MC', 'Mashonaland Central', 'English');
INSERT INTO emkt_regions VALUES(4244, 238, 'ME', 'Mashonaland East', 'English');
INSERT INTO emkt_regions VALUES(4245, 238, 'MI', 'Midlands', 'English');
INSERT INTO emkt_regions VALUES(4246, 238, 'MN', 'Matabeleland North', 'English');
INSERT INTO emkt_regions VALUES(4247, 238, 'MS', 'Matabeleland South', 'English');
INSERT INTO emkt_regions VALUES(4248, 238, 'MV', 'Masvingo', 'English');
INSERT INTO emkt_regions VALUES(4249, 238, 'MW', 'Mashonaland West', 'English');

/* ЗАГРУЗКА НАСТРОЕК */
INSERT INTO emkt_basic_settings VALUES (1, 20, 60, 0, 'smtp.localhost', 'login', 'password', 'tsl', 587, 0, 0, 'sale@localhost', 'eMarket');

/* ЗАГРУЗКА ЗОН */
INSERT INTO emkt_zones VALUES (1, 'Moskow', null, 'english');
INSERT INTO emkt_zones VALUES (1, 'Москва', null, 'russian');

/* ЗАГРУЗКА ЗНАЧЕНИЙ ЗОН */
INSERT INTO emkt_zones_value VALUES (1, 175, 29, 1);

/* ЗАГРУЗКА НАЛОГОВ */
INSERT INTO emkt_taxes VALUES (1, 'VAT', 'english', '20.00');
INSERT INTO emkt_taxes VALUES (1, 'НДС', 'russian', '20.00');

/* ЗАГРУЗКА ДЛИНЫ */
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

/* ЗАГРУЗКА ВЕСА */
INSERT INTO emkt_weight VALUES (1, 'Kilogramm', 'kg.', 'english', '1.0000000', '1');
INSERT INTO emkt_weight VALUES (1, 'Килограмм', 'кг', 'russian', '1.0000000', '1');
INSERT INTO emkt_weight VALUES (2, 'Gramm', 'g.', 'english', '0.0010000', '0');
INSERT INTO emkt_weight VALUES (2, 'Грамм', 'г.', 'russian', '0.0010000', '0');
INSERT INTO emkt_weight VALUES (3, 'Ounce', 'oz.', 'english', '0.0283500', '0');
INSERT INTO emkt_weight VALUES (3, 'Унция', 'ун.', 'russian', '0.0283500', '0');

/* ЗАГРУЗКА ИДЕНТИФИКАТОРОВ ТОВАРА */
INSERT INTO emkt_vendor_codes VALUES (1, 'Articul', 'english', '', '1');
INSERT INTO emkt_vendor_codes VALUES (1, 'Артикул', 'russian', '', '1');
INSERT INTO emkt_vendor_codes VALUES (2, 'SCU', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (2, 'SCU', 'russian', '', '0');
INSERT INTO emkt_vendor_codes VALUES (3, 'UPC', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (3, 'UPC', 'russian', '', '0');
INSERT INTO emkt_vendor_codes VALUES (4, 'EAN', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (4, 'EAN', 'russian', '', '0');
INSERT INTO emkt_vendor_codes VALUES (5, 'JAN', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (5, 'JAN', 'russian', '', '0');
INSERT INTO emkt_vendor_codes VALUES (6, 'ISBN', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (6, 'ISBN', 'russian', '', '0');
INSERT INTO emkt_vendor_codes VALUES (7, 'MPN', 'english', '', '0');
INSERT INTO emkt_vendor_codes VALUES (7, 'MPN', 'russian', '', '0');

/* ЗАГРУЗКА ЕДИНИЦ ИЗМЕРЕНИЯ */
INSERT INTO emkt_units VALUES (1, 'Pieces', 'english', 'pcs.', '1');
INSERT INTO emkt_units VALUES (1, 'Штука', 'russian', 'шт.', '1');
INSERT INTO emkt_units VALUES (2, 'Packing', 'english', 'pkg.', '0');
INSERT INTO emkt_units VALUES (2, 'Упаковка', 'russian', 'уп.', '0');

/* ЗАГРУЗКА ВАЛЮТ */
INSERT INTO emkt_currencies VALUES (1, 'Russian Rouble', 'rub.', 'RUB', 'english', '1.0000000000', '1', '₽', 'right', '2', NULL);
INSERT INTO emkt_currencies VALUES (1, 'Рубль РФ', 'руб.', 'RUB', 'russian', '1.0000000000', '1', '₽', 'right', '2', NULL);
INSERT INTO emkt_currencies VALUES (2, 'Dollar USA', 'doll.', 'USD', 'english', '0.0147000000', '0', '$', 'left', '2', NULL);
INSERT INTO emkt_currencies VALUES (2, 'Доллар США', 'долл.', 'USD', 'russian', '0.0147000000', '0', '$', 'left', '2', NULL);

/* ЗАГРУЗКА КОМПОНОВКИ ШАБЛОНОВ */
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
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/welcome.php', 'catalog', 'content', 'all', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_listing.php', 'catalog', 'content', 'all', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/new_products.php', 'catalog', 'content', 'all', 'default', '2');
/* CATALOG */
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/navbar.php', 'catalog', 'header', 'catalog', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/logo_search.php', 'catalog', 'header', 'catalog', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/breadcrumb.php', 'catalog', 'header', 'catalog', 'default', '2');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/slide_show.php', 'catalog', 'header', 'catalog', 'default', '3');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/copyright.php', 'catalog', 'footer', 'catalog', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories.php', 'catalog', 'boxes-left', 'catalog', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/welcome.php', 'catalog', 'content', 'catalog', 'default', '0');
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
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_listing.php', 'catalog', 'content', 'listing', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/new_products.php', 'catalog', 'content-basket', 'listing', 'default', '2');
/* PRODUCTS */
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/navbar.php', 'catalog', 'header', 'products', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/logo_search.php', 'catalog', 'header', 'products', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/breadcrumb.php', 'catalog', 'header', 'products', 'default', '2');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/slide_show.php', 'catalog', 'header', 'products', 'default', '3');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/copyright.php', 'catalog', 'footer', 'products', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories.php', 'catalog', 'boxes-left', 'products', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/welcome.php', 'catalog', 'content-basket', 'products', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_listing.php', 'catalog', 'content-basket', 'products', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/new_products.php', 'catalog', 'content-basket', 'products', 'default', '2');
/* CART */
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/navbar.php', 'catalog', 'header', 'cart', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/logo_search.php', 'catalog', 'header', 'cart', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/breadcrumb.php', 'catalog', 'header', 'cart', 'default', '2');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/slide_show.php', 'catalog', 'header', 'cart', 'default', '3');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/copyright.php', 'catalog', 'footer', 'cart', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories.php', 'catalog', 'boxes-left', 'cart', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/welcome.php', 'catalog', 'content-basket', 'cart', 'default', '0');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/categories_listing.php', 'catalog', 'content-basket', 'cart', 'default', '1');
INSERT INTO emkt_template_constructor (url, group_id, value, page, template_name, sort) VALUES ('/controller/catalog/layouts/new_products.php', 'catalog', 'content-basket', 'cart', 'default', '2');