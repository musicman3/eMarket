/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

/* Создание таблиц */

DROP TABLE IF EXISTS emkt_administrators;
CREATE TABLE emkt_administrators (
	login varchar(128) binary NOT NULL,
	password varchar(64) NOT NULL,
	language varchar(64) NOT NULL,
	permission varchar(20) NOT NULL,
	note varchar(256),
	status int DEFAULT '0' NOT NULL,
PRIMARY KEY (login))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_categories;
CREATE TABLE emkt_categories (
	id int NOT NULL,
	name varchar(256) NOT NULL,
	language varchar(64),
	parent_id int DEFAULT '0' NOT NULL,
        image varchar(256),
	date_added datetime,
	last_modified datetime,
	sort_category int DEFAULT '0' NOT NULL,
	status int,
	PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_countries;
CREATE TABLE emkt_countries (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        alpha_2 varchar(2),
        alpha_3 varchar(3),
        address_format varchar(256) NULL,
	PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_products;
CREATE TABLE emkt_products (
	id int DEFAULT '0' NOT NULL,
        name varchar(256) NOT NULL,
        language varchar(64),
	parent_id int DEFAULT '0' NOT NULL,
	images varchar(1024),
	date_added datetime,
	last_modified datetime,
        date_available date,
        model varchar(64), 
        type varchar(256),
        vendor_code varchar(64),
        code varchar(256),
        product_code varchar(256),
        product_code_value varchar(256),
        manufacturer int,
        price decimal(12,2),
        quantity int,
        min_quantity int,
        unit varchar(256),
        weight decimal(5,2),
        weight_class int,
        tax_class int,
        ordered int default '0',
        download_file varchar(256),
        keyword varchar(256),
        tags varchar(256),
        url varchar(256),
        unit_lenght varchar(256),
        lenght decimal(12,2),
        width decimal(12,2),
        height decimal(12,2),
        viewed int default '0',
        description text,
	sort int DEFAULT '0',
        status int,
	PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_regions;
CREATE TABLE emkt_regions (
	id int NOT NULL auto_increment,
        country_id int NOT NULL,
        region_code varchar(8),
	name varchar(256),
	language varchar(64),
	PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_taxes;
CREATE TABLE emkt_taxes (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        rate decimal(4,2),
	PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_units;
CREATE TABLE emkt_units (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        unit varchar(256),
	PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS emkt_vendor_codes;
CREATE TABLE emkt_vendor_codes (
	id int NOT NULL,
	name varchar(256),
	language varchar(64),
        vendor_code varchar(256),
	PRIMARY KEY (id, language))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


/* Загрузка первоначальных данных в таблицу стран */
/* Russian */
INSERT INTO emkt_countries VALUES (1,'Афганистан','Russian','AF','AFG','');
INSERT INTO emkt_countries VALUES (2,'Албания','Russian','AL','ALB','');
INSERT INTO emkt_countries VALUES (3,'Алжир','Russian','DZ','DZA','');
INSERT INTO emkt_countries VALUES (4,'Американское Самоа','Russian','AS','ASM','');
INSERT INTO emkt_countries VALUES (5,'Андорра','Russian','AD','AND','');
INSERT INTO emkt_countries VALUES (6,'Ангола','Russian','AO','AGO','');
INSERT INTO emkt_countries VALUES (7,'Ангилья','Russian','AI','AIA','');
INSERT INTO emkt_countries VALUES (8,'Антарктида','Russian','AQ','ATA','');
INSERT INTO emkt_countries VALUES (9,'Антигуа и Барбуда','Russian','AG','ATG','');
INSERT INTO emkt_countries VALUES (10,'Аргентина','Russian','AR','ARG','');
INSERT INTO emkt_countries VALUES (11,'Армения','Russian','AM','ARM','');
INSERT INTO emkt_countries VALUES (12,'Аруба','Russian','AW','ABW','');
INSERT INTO emkt_countries VALUES (13,'Австралия','Russian','AU','AUS','');
INSERT INTO emkt_countries VALUES (14,'Австрия','Russian','AT','AUT','');
INSERT INTO emkt_countries VALUES (15,'Азербайджан','Russian','AZ','AZE','');
INSERT INTO emkt_countries VALUES (16,'Багамские Острова','Russian','BS','BHS','');
INSERT INTO emkt_countries VALUES (17,'Бахрейн','Russian','BH','BHR','');
INSERT INTO emkt_countries VALUES (18,'Бангладеш','Russian','BD','BGD','');
INSERT INTO emkt_countries VALUES (19,'Барбадос','Russian','BB','BRB','');
INSERT INTO emkt_countries VALUES (20,'Беларусь','Russian','BY','BLR','');
INSERT INTO emkt_countries VALUES (21,'Бельгия','Russian','BE','BEL','');
INSERT INTO emkt_countries VALUES (22,'Белиз','Russian','BZ','BLZ','');
INSERT INTO emkt_countries VALUES (23,'Бенин','Russian','BJ','BEN','');
INSERT INTO emkt_countries VALUES (24,'Бермудские Острова','Russian','BM','BMU','');
INSERT INTO emkt_countries VALUES (25,'Бутан','Russian','BT','BTN','');
INSERT INTO emkt_countries VALUES (26,'Боливия','Russian','BO','BOL','');
INSERT INTO emkt_countries VALUES (27,'Босния и Герцеговина','Russian','BA','BIH','');
INSERT INTO emkt_countries VALUES (28,'Ботсвана','Russian','BW','BWA','');
INSERT INTO emkt_countries VALUES (29,'Остров Буве','Russian','BV','BVT','');
INSERT INTO emkt_countries VALUES (30,'Бразилия','Russian','BR','BRA','');
INSERT INTO emkt_countries VALUES (31,'Британская Территория в Индийском Океане','Russian','IO','IOT','');
INSERT INTO emkt_countries VALUES (32,'Бруней','Russian','BN','BRN','');
INSERT INTO emkt_countries VALUES (33,'Болгария','Russian','BG','BGR','');
INSERT INTO emkt_countries VALUES (34,'Буркина-Фасо','Russian','BF','BFA','');
INSERT INTO emkt_countries VALUES (35,'Бурунди','Russian','BI','BDI','');
INSERT INTO emkt_countries VALUES (36,'Камбоджа','Russian','KH','KHM','');
INSERT INTO emkt_countries VALUES (37,'Камерун','Russian','CM','CMR','');
INSERT INTO emkt_countries VALUES (38,'Канада','Russian','CA','CAN','');
INSERT INTO emkt_countries VALUES (39,'Кабо-Верде','Russian','CV','CPV','');
INSERT INTO emkt_countries VALUES (40,'Острова Кайман','Russian','KY','CYM','');
INSERT INTO emkt_countries VALUES (41,'Центральноафриканская Республика','Russian','CF','CAF','');
INSERT INTO emkt_countries VALUES (42,'Чад','Russian','TD','TCD','');
INSERT INTO emkt_countries VALUES (43,'Чили','Russian','CL','CHL','');
INSERT INTO emkt_countries VALUES (44,'Китайская Народная Республика','Russian','CN','CHN','');
INSERT INTO emkt_countries VALUES (45,'Остров Рождества','Russian','CX','CXR','');
INSERT INTO emkt_countries VALUES (46,'Кокосовые острова','Russian','CC','CCK','');
INSERT INTO emkt_countries VALUES (47,'Колумбия','Russian','CO','COL','');
INSERT INTO emkt_countries VALUES (48,'Коморы','Russian','KM','COM','');
INSERT INTO emkt_countries VALUES (49,'Конго','Russian','CG','COG','');
INSERT INTO emkt_countries VALUES (50,'Острова Кука','Russian','CK','COK','');
INSERT INTO emkt_countries VALUES (51,'Коста-Рика','Russian','CR','CRI','');
INSERT INTO emkt_countries VALUES (52,'Кот-Д\'Ивуар','Russian','CI','CIV','');
INSERT INTO emkt_countries VALUES (53,'Хорватия','Russian','HR','HRV','');
INSERT INTO emkt_countries VALUES (54,'Куба','Russian','CU','CUB','');
INSERT INTO emkt_countries VALUES (55,'Республика Кипр','Russian','CY','CYP','');
INSERT INTO emkt_countries VALUES (56,'Чешская Республика','Russian','CZ','CZE','');
INSERT INTO emkt_countries VALUES (57,'Дания','Russian','DK','DNK','');
INSERT INTO emkt_countries VALUES (58,'Джибути','Russian','DJ','DJI','');
INSERT INTO emkt_countries VALUES (59,'Доминика','Russian','DM','DMA','');
INSERT INTO emkt_countries VALUES (60,'Доминиканская Республика','Russian','DO','DOM','');
INSERT INTO emkt_countries VALUES (61,'Восточный Тимор','Russian','TP','TMP','');
INSERT INTO emkt_countries VALUES (62,'Эквадор','Russian','EC','ECU','');
INSERT INTO emkt_countries VALUES (63,'Египет','Russian','EG','EGY','');
INSERT INTO emkt_countries VALUES (64,'Сальвадор','Russian','SV','SLV','');
INSERT INTO emkt_countries VALUES (65,'Экваториальная Гвинея','Russian','GQ','GNQ','');
INSERT INTO emkt_countries VALUES (66,'Эритрея','Russian','ER','ERI','');
INSERT INTO emkt_countries VALUES (67,'Эстония','Russian','EE','EST','');
INSERT INTO emkt_countries VALUES (68,'Эфиопия','Russian','ET','ETH','');
INSERT INTO emkt_countries VALUES (69,'Фолклендские острова','Russian','FK','FLK','');
INSERT INTO emkt_countries VALUES (70,'Фарерские острова','Russian','FO','FRO','');
INSERT INTO emkt_countries VALUES (71,'Фиджи','Russian','FJ','FJI','');
INSERT INTO emkt_countries VALUES (72,'Финляндия','Russian','FI','FIN','');
INSERT INTO emkt_countries VALUES (73,'Франция','Russian','FR','FRA','');
INSERT INTO emkt_countries VALUES (74,'Французская Гвиана','Russian','GF','GUF','');
INSERT INTO emkt_countries VALUES (75,'Французская Полинезия','Russian','PF','PYF','');
INSERT INTO emkt_countries VALUES (76,'Французские Южные и Антарктические территории','Russian','TF','ATF','');
INSERT INTO emkt_countries VALUES (77,'Габон','Russian','GA','GAB','');
INSERT INTO emkt_countries VALUES (78,'Гамбия','Russian','GM','GMB','');
INSERT INTO emkt_countries VALUES (79,'Грузия','Russian','GE','GEO','');
INSERT INTO emkt_countries VALUES (80,'Германия','Russian','DE','DEU','');
INSERT INTO emkt_countries VALUES (81,'Гана','Russian','GH','GHA','');
INSERT INTO emkt_countries VALUES (82,'Гибралтар','Russian','GI','GIB','');
INSERT INTO emkt_countries VALUES (83,'Греция','Russian','GR','GRC','');
INSERT INTO emkt_countries VALUES (84,'Гренландия','Russian','GL','GRL','');
INSERT INTO emkt_countries VALUES (85,'Гренада','Russian','GD','GRD','');
INSERT INTO emkt_countries VALUES (86,'Гваделупа','Russian','GP','GLP','');
INSERT INTO emkt_countries VALUES (87,'Гуам','Russian','GU','GUM','');
INSERT INTO emkt_countries VALUES (88,'Гватемала','Russian','GT','GTM','');
INSERT INTO emkt_countries VALUES (89,'Гвинея','Russian','GN','GIN','');
INSERT INTO emkt_countries VALUES (90,'Гвинея-Бисау','Russian','GW','GNB','');
INSERT INTO emkt_countries VALUES (91,'Гайана','Russian','GY','GUY','');
INSERT INTO emkt_countries VALUES (92,'Гаити','Russian','HT','HTI','');
INSERT INTO emkt_countries VALUES (93,'Остров Херд и острова Макдональд','Russian','HM','HMD','');
INSERT INTO emkt_countries VALUES (94,'Гондурас','Russian','HN','HND','');
INSERT INTO emkt_countries VALUES (95,'Гонконг','Russian','HK','HKG','');
INSERT INTO emkt_countries VALUES (96,'Венгрия','Russian','HU','HUN','');
INSERT INTO emkt_countries VALUES (97,'Исландия','Russian','IS','ISL','');
INSERT INTO emkt_countries VALUES (98,'Индия','Russian','IN','IND','');
INSERT INTO emkt_countries VALUES (99,'Индонезия','Russian','ID','IDN','');
INSERT INTO emkt_countries VALUES (100,'Иран','Russian','IR','IRN','');
INSERT INTO emkt_countries VALUES (101,'Ирак','Russian','IQ','IRQ','');
INSERT INTO emkt_countries VALUES (102,'Ирландия','Russian','IE','IRL','');
INSERT INTO emkt_countries VALUES (103,'Израиль','Russian','IL','ISR','');
INSERT INTO emkt_countries VALUES (104,'Италия','Russian','IT','ITA','');
INSERT INTO emkt_countries VALUES (105,'Ямайка','Russian','JM','JAM','');
INSERT INTO emkt_countries VALUES (106,'Япония','Russian','JP','JPN','');
INSERT INTO emkt_countries VALUES (107,'Иордания','Russian','JO','JOR','');
INSERT INTO emkt_countries VALUES (108,'Казахстан','Russian','KZ','KAZ','');
INSERT INTO emkt_countries VALUES (109,'Кения','Russian','KE','KEN','');
INSERT INTO emkt_countries VALUES (110,'Кирибати','Russian','KI','KIR','');
INSERT INTO emkt_countries VALUES (111,'Корейская Народно-Демократическая Республика','Russian','KP','PRK','');
INSERT INTO emkt_countries VALUES (112,'Республика Корея','Russian','KR','KOR','');
INSERT INTO emkt_countries VALUES (113,'Кувейт','Russian','KW','KWT','');
INSERT INTO emkt_countries VALUES (114,'Киргизия','Russian','KG','KGZ','');
INSERT INTO emkt_countries VALUES (115,'Лаос','Russian','LA','LAO','');
INSERT INTO emkt_countries VALUES (116,'Латвия','Russian','LV','LVA','');
INSERT INTO emkt_countries VALUES (117,'Ливан','Russian','LB','LBN','');
INSERT INTO emkt_countries VALUES (118,'Лесото','Russian','LS','LSO','');
INSERT INTO emkt_countries VALUES (119,'Либерия','Russian','LR','LBR','');
INSERT INTO emkt_countries VALUES (120,'Ливия','Russian','LY','LBY','');
INSERT INTO emkt_countries VALUES (121,'Лихтенштейн','Russian','LI','LIE','');
INSERT INTO emkt_countries VALUES (122,'Литва','Russian','LT','LTU','');
INSERT INTO emkt_countries VALUES (123,'Люксембург','Russian','LU','LUX','');
INSERT INTO emkt_countries VALUES (124,'Макао','Russian','MO','MAC','');
INSERT INTO emkt_countries VALUES (125,'Македония','Russian','MK','MKD','');
INSERT INTO emkt_countries VALUES (126,'Мадагаскар','Russian','MG','MDG','');
INSERT INTO emkt_countries VALUES (127,'Малави','Russian','MW','MWI','');
INSERT INTO emkt_countries VALUES (128,'Малайзия','Russian','MY','MYS','');
INSERT INTO emkt_countries VALUES (129,'Мальдивы','Russian','MV','MDV','');
INSERT INTO emkt_countries VALUES (130,'Мали','Russian','ML','MLI','');
INSERT INTO emkt_countries VALUES (131,'Мальта','Russian','MT','MLT','');
INSERT INTO emkt_countries VALUES (132,'Маршалловы Острова','Russian','MH','MHL','');
INSERT INTO emkt_countries VALUES (133,'Мартиника','Russian','MQ','MTQ','');
INSERT INTO emkt_countries VALUES (134,'Мавритания','Russian','MR','MRT','');
INSERT INTO emkt_countries VALUES (135,'Маврикий','Russian','MU','MUS','');
INSERT INTO emkt_countries VALUES (136,'Майотта','Russian','YT','MYT','');
INSERT INTO emkt_countries VALUES (137,'Мексика','Russian','MX','MEX','');
INSERT INTO emkt_countries VALUES (138,'Федеративные Штаты Микронезии','Russian','FM','FSM','');
INSERT INTO emkt_countries VALUES (139,'Молдавия','Russian','MD','MDA','');
INSERT INTO emkt_countries VALUES (140,'Монако','Russian','MC','MCO','');
INSERT INTO emkt_countries VALUES (141,'Монголия','Russian','MN','MNG','');
INSERT INTO emkt_countries VALUES (142,'Монтсеррат','Russian','MS','MSR','');
INSERT INTO emkt_countries VALUES (143,'Марокко','Russian','MA','MAR','');
INSERT INTO emkt_countries VALUES (144,'Мозамбик','Russian','MZ','MOZ','');
INSERT INTO emkt_countries VALUES (145,'Мьянма','Russian','MM','MMR','');
INSERT INTO emkt_countries VALUES (146,'Намибия','Russian','NA','NAM','');
INSERT INTO emkt_countries VALUES (147,'Науру','Russian','NR','NRU','');
INSERT INTO emkt_countries VALUES (148,'Непал','Russian','NP','NPL','');
INSERT INTO emkt_countries VALUES (149,'Нидерланды','Russian','NL','NLD','');
INSERT INTO emkt_countries VALUES (150,'Нидерландские Антильские острова','Russian','AN','ANT','');
INSERT INTO emkt_countries VALUES (151,'Новая Каледония','Russian','NC','NCL','');
INSERT INTO emkt_countries VALUES (152,'Новая Зеландия','Russian','NZ','NZL','');
INSERT INTO emkt_countries VALUES (153,'Никарагуа','Russian','NI','NIC','');
INSERT INTO emkt_countries VALUES (154,'Республика Нигер','Russian','NE','NER','');
INSERT INTO emkt_countries VALUES (155,'Нигерия','Russian','NG','NGA','');
INSERT INTO emkt_countries VALUES (156,'Ниуэ','Russian','NU','NIU','');
INSERT INTO emkt_countries VALUES (157,'Остров Норфолк','Russian','NF','NFK','');
INSERT INTO emkt_countries VALUES (158,'Северные Марианские Острова','Russian','MP','MNP','');
INSERT INTO emkt_countries VALUES (159,'Норвегия','Russian','NO','NOR','');
INSERT INTO emkt_countries VALUES (160,'Оман','Russian','OM','OMN','');
INSERT INTO emkt_countries VALUES (161,'Пакистан','Russian','PK','PAK','');
INSERT INTO emkt_countries VALUES (162,'Палау','Russian','PW','PLW','');
INSERT INTO emkt_countries VALUES (163,'Панама','Russian','PA','PAN','');
INSERT INTO emkt_countries VALUES (164,'Папуа-Новая Гвинея','Russian','PG','PNG','');
INSERT INTO emkt_countries VALUES (165,'Парагвай','Russian','PY','PRY','');
INSERT INTO emkt_countries VALUES (166,'Перу','Russian','PE','PER','');
INSERT INTO emkt_countries VALUES (167,'Филиппины','Russian','PH','PHL','');
INSERT INTO emkt_countries VALUES (168,'Острова Питкэрн','Russian','PN','PCN','');
INSERT INTO emkt_countries VALUES (169,'Польша','Russian','PL','POL','');
INSERT INTO emkt_countries VALUES (170,'Португалия','Russian','PT','PRT','');
INSERT INTO emkt_countries VALUES (171,'Пуэрто-Рико','Russian','PR','PRI','');
INSERT INTO emkt_countries VALUES (172,'Катар','Russian','QA','QAT','');
INSERT INTO emkt_countries VALUES (173,'Реюньон','Russian','RE','REU','');
INSERT INTO emkt_countries VALUES (174,'Румыния','Russian','RO','ROM','');

INSERT INTO emkt_countries VALUES (175,'Российская Федерация','Russian','RU','RUS','');

INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'AD','Республика Адыгея','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'AL','Республика Алтай','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ALT','Алтайский край','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'AMU','Амурская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ARK','Архангельская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'AST','Астраханская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'BA','Республика Башкортостан','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'BEL','Белгородская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'BRY','Брянская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'BU','Республика Бурятия','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'CE','Чеченская Республика','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'CHE','Челябинская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ZAB','Забайкальский край','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'CHU','Чукотский автономный округ','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'CU','Чувашская Республика','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'DA','Республика Дагестан','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'IN','Республика Ингушетия','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'IRK','Иркутская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'IVA','Ивановская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KAM','Камчатский край','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KB','Кабардино-Балкарская Республика','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KC','Карачаево-Черкесская Республика','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KDA','Краснодарский край','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KEM','Кемеровская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KGD','Калининградская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KGN','Курганская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KHA','Хабаровский край','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KHM','Ханты-Мансийский автономный округ—Югра','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KIA','Красноярский край','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KIR','Кировская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KK','Республика Хакасия','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KL','Республика Калмыкия','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KLU','Калужская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KO','Республика Коми','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KOS','Костромская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KR','Республика Карелия','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KRS','Курская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'LEN','Ленинградская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'LIP','Липецкая область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MAG','Магаданская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ME','Республика Марий Эл','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MO','Республика Мордовия','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MOS','Московская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MOW','Москва','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MUR','Мурманская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'NEN','Ненецкий автономный округ','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'NGR','Новгородская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'NIZ','Нижегородская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'NVS','Новосибирская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'OMS','Омская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ORE','Оренбургская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ORL','Орловская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'PNZ','Пензенская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'PRI','Приморский край','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'PSK','Псковская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ROS','Ростовская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'RYA','Рязанская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SA','Республика Саха (Якутия)','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SAK','Сахалинская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SAM','Самарская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SAR','Саратовская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SE','Республика Северная Осетия–Алания','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SMO','Смоленская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SPE','Санкт-Петербург','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'STA','Ставропольский край','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SVE','Свердловская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TA','Республика Татарстан','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TAM','Тамбовская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TOM','Томская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TUL','Тульская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TVE','Тверская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TY','Республика Тыва','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TYU','Тюменская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'UD','Удмуртская Республика','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ULY','Ульяновская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'VGG','Волгоградская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'VLA','Владимирская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'VLG','Вологодская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'VOR','Воронежская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'PER','Пермский край','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'YAN','Ямало-Ненецкий автономный округ','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'YAR','Ярославская область','Russian');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'YEV','Еврейская автономная область','Russian');

INSERT INTO emkt_countries VALUES (176,'Руанда','Russian','RW','RWA','');
INSERT INTO emkt_countries VALUES (177,'Сент-Китс и Невис','Russian','KN','KNA','');
INSERT INTO emkt_countries VALUES (178,'Сент-Люсия','Russian','LC','LCA','');
INSERT INTO emkt_countries VALUES (179,'Сент-Винсент и Гренадины','Russian','VC','VCT','');
INSERT INTO emkt_countries VALUES (180,'Самоа','Russian','WS','WSM','');
INSERT INTO emkt_countries VALUES (181,'Сан-Марино','Russian','SM','SMR','');
INSERT INTO emkt_countries VALUES (182,'Сан-Томе и Принсипи','Russian','ST','STP','');
INSERT INTO emkt_countries VALUES (183,'Саудовская Аравия','Russian','SA','SAU','');
INSERT INTO emkt_countries VALUES (184,'Сенегал','Russian','SN','SEN','');
INSERT INTO emkt_countries VALUES (185,'Сейшельские Острова','Russian','SC','SYC','');
INSERT INTO emkt_countries VALUES (186,'Сьерра-Леоне','Russian','SL','SLE','');
INSERT INTO emkt_countries VALUES (187,'Сингапур','Russian','SG','SGP','');
INSERT INTO emkt_countries VALUES (188,'Словакия','Russian','SK','SVK','');
INSERT INTO emkt_countries VALUES (189,'Словения','Russian','SI','SVN','');
INSERT INTO emkt_countries VALUES (190,'Соломоновы Острова','Russian','SB','SLB','');
INSERT INTO emkt_countries VALUES (191,'Сомали','Russian','SO','SOM','');
INSERT INTO emkt_countries VALUES (192,'Южно-Африканская Республика','Russian','ZA','ZAF','');
INSERT INTO emkt_countries VALUES (193,'Южная Георгия и Южные Сандвичевы Острова','Russian','GS','SGS','');
INSERT INTO emkt_countries VALUES (194,'Испания','Russian','ES','ESP','');
INSERT INTO emkt_countries VALUES (195,'Шри-Ланка','Russian','LK','LKA','');
INSERT INTO emkt_countries VALUES (196,'Остров Святой Елены','Russian','SH','SHN','');
INSERT INTO emkt_countries VALUES (197,'Сен-Пьер и Микелон','Russian','PM','SPM','');
INSERT INTO emkt_countries VALUES (198,'Судан','Russian','SD','SDN','');
INSERT INTO emkt_countries VALUES (199,'Суринам','Russian','SR','SUR','');
INSERT INTO emkt_countries VALUES (200,'Шпицберген и Ян-Майен','Russian','SJ','SJM','');
INSERT INTO emkt_countries VALUES (201,'Свазиленд','Russian','SZ','SWZ','');
INSERT INTO emkt_countries VALUES (202,'Швеция','Russian','SE','SWE','');
INSERT INTO emkt_countries VALUES (203,'Швейцария','Russian','CH','CHE','');
INSERT INTO emkt_countries VALUES (204,'Сирийская Арабская Республика','Russian','SY','SYR','');
INSERT INTO emkt_countries VALUES (205,'Тайвань','Russian','TW','TWN','');
INSERT INTO emkt_countries VALUES (206,'Таджикистан','Russian','TJ','TJK','');
INSERT INTO emkt_countries VALUES (207,'Танзания','Russian','TZ','TZA','');
INSERT INTO emkt_countries VALUES (208,'Таиланд','Russian','TH','THA','');
INSERT INTO emkt_countries VALUES (209,'Того','Russian','TG','TGO','');
INSERT INTO emkt_countries VALUES (210,'Токелау','Russian','TK','TKL','');
INSERT INTO emkt_countries VALUES (211,'Тонга','Russian','TO','TON','');
INSERT INTO emkt_countries VALUES (212,'Тринидад и Тобаго','Russian','TT','TTO','');
INSERT INTO emkt_countries VALUES (213,'Тунис','Russian','TN','TUN','');
INSERT INTO emkt_countries VALUES (214,'Турция','Russian','TR','TUR','');
INSERT INTO emkt_countries VALUES (215,'Туркменистан','Russian','TM','TKM','');
INSERT INTO emkt_countries VALUES (216,'Теркс и Кайкос','Russian','TC','TCA','');
INSERT INTO emkt_countries VALUES (217,'Тувалу','Russian','TV','TUV','');
INSERT INTO emkt_countries VALUES (218,'Уганда','Russian','UG','UGA','');
INSERT INTO emkt_countries VALUES (219,'Украина','Russian','UA','UKR','');
INSERT INTO emkt_countries VALUES (220,'Объединённые Арабские Эмираты','Russian','AE','ARE','');
INSERT INTO emkt_countries VALUES (221,'Великобритания','Russian','GB','GBR','');
INSERT INTO emkt_countries VALUES (222,'Соединённые Штаты Америки','Russian','US','USA','');
INSERT INTO emkt_countries VALUES (223,'Внешние малые острова США','Russian','UM','UMI','');
INSERT INTO emkt_countries VALUES (224,'Уругвай','Russian','UY','URY','');
INSERT INTO emkt_countries VALUES (225,'Узбекистан','Russian','UZ','UZB','');
INSERT INTO emkt_countries VALUES (226,'Вануату','Russian','VU','VUT','');
INSERT INTO emkt_countries VALUES (227,'Ватикан','Russian','VA','VAT','');
INSERT INTO emkt_countries VALUES (228,'Венесуэла','Russian','VE','VEN','');
INSERT INTO emkt_countries VALUES (229,'Вьетнам','Russian','VN','VNM','');
INSERT INTO emkt_countries VALUES (230,'Британские Виргинские острова','Russian','VG','VGB','');
INSERT INTO emkt_countries VALUES (231,'Американские Виргинские острова','Russian','VI','VIR','');
INSERT INTO emkt_countries VALUES (232,'Уоллис и Футуна','Russian','WF','WLF','');
INSERT INTO emkt_countries VALUES (233,'Западная Сахара','Russian','EH','ESH','');
INSERT INTO emkt_countries VALUES (234,'Йемен','Russian','YE','YEM','');
INSERT INTO emkt_countries VALUES (235,'Югославия','Russian','YU','YUG','');
INSERT INTO emkt_countries VALUES (236,'Заир','Russian','ZR','ZAR','');
INSERT INTO emkt_countries VALUES (237,'Замбия','Russian','ZM','ZMB','');
INSERT INTO emkt_countries VALUES (238,'Зимбабве','Russian','ZW','ZWE','');

/* English */
INSERT INTO emkt_countries VALUES (1,'Afghanistan','English','AF','AFG','');
INSERT INTO emkt_countries VALUES (2,'Albania','English','AL','ALB','');
INSERT INTO emkt_countries VALUES (3,'Algeria','English','DZ','DZA','');
INSERT INTO emkt_countries VALUES (4,'American Samoa','English','AS','ASM','');
INSERT INTO emkt_countries VALUES (5,'Andorra','English','AD','AND','');
INSERT INTO emkt_countries VALUES (6,'Angola','English','AO','AGO','');
INSERT INTO emkt_countries VALUES (7,'Anguilla','English','AI','AIA','');
INSERT INTO emkt_countries VALUES (8,'Antarctica','English','AQ','ATA','');
INSERT INTO emkt_countries VALUES (9,'Antigua and Barbuda','English','AG','ATG','');
INSERT INTO emkt_countries VALUES (10,'Argentina','English','AR','ARG','');
INSERT INTO emkt_countries VALUES (11,'Armenia','English','AM','ARM','');
INSERT INTO emkt_countries VALUES (12,'Aruba','English','AW','ABW','');
INSERT INTO emkt_countries VALUES (13,'Australia','English','AU','AUS','');
INSERT INTO emkt_countries VALUES (14,'Austria','English','AT','AUT','');
INSERT INTO emkt_countries VALUES (15,'Azerbaijan','English','AZ','AZE','');
INSERT INTO emkt_countries VALUES (16,'Bahamas','English','BS','BHS','');
INSERT INTO emkt_countries VALUES (17,'Bahrain','English','BH','BHR','');
INSERT INTO emkt_countries VALUES (18,'Bangladesh','English','BD','BGD','');
INSERT INTO emkt_countries VALUES (19,'Barbados','English','BB','BRB','');
INSERT INTO emkt_countries VALUES (20,'Belarus','English','BY','BLR','');
INSERT INTO emkt_countries VALUES (21,'Belgium','English','BE','BEL','');
INSERT INTO emkt_countries VALUES (22,'Belize','English','BZ','BLZ','');
INSERT INTO emkt_countries VALUES (23,'Benin','English','BJ','BEN','');
INSERT INTO emkt_countries VALUES (24,'Bermuda','English','BM','BMU','');
INSERT INTO emkt_countries VALUES (25,'Bhutan','English','BT','BTN','');
INSERT INTO emkt_countries VALUES (26,'Bolivia','English','BO','BOL','');
INSERT INTO emkt_countries VALUES (27,'Bosnia and Herzegowina','English','BA','BIH','');
INSERT INTO emkt_countries VALUES (28,'Botswana','English','BW','BWA','');
INSERT INTO emkt_countries VALUES (29,'Bouvet Island','English','BV','BVT','');
INSERT INTO emkt_countries VALUES (30,'Brazil','English','BR','BRA','');
INSERT INTO emkt_countries VALUES (31,'British Indian Ocean Territory','English','IO','IOT','');
INSERT INTO emkt_countries VALUES (32,'Brunei Darussalam','English','BN','BRN','');
INSERT INTO emkt_countries VALUES (33,'Bulgaria','English','BG','BGR','');
INSERT INTO emkt_countries VALUES (34,'Burkina Faso','English','BF','BFA','');
INSERT INTO emkt_countries VALUES (35,'Burundi','English','BI','BDI','');
INSERT INTO emkt_countries VALUES (36,'Cambodia','English','KH','KHM','');
INSERT INTO emkt_countries VALUES (37,'Cameroon','English','CM','CMR','');
INSERT INTO emkt_countries VALUES (38,'Canada','English','CA','CAN','');
INSERT INTO emkt_countries VALUES (39,'Cape Verde','English','CV','CPV','');
INSERT INTO emkt_countries VALUES (40,'Cayman Islands','English','KY','CYM','');
INSERT INTO emkt_countries VALUES (41,'Central African Republic','English','CF','CAF','');
INSERT INTO emkt_countries VALUES (42,'Chad','English','TD','TCD','');
INSERT INTO emkt_countries VALUES (43,'Chile','English','CL','CHL','');
INSERT INTO emkt_countries VALUES (44,'China','English','CN','CHN','');
INSERT INTO emkt_countries VALUES (45,'Christmas Island','English','CX','CXR','');
INSERT INTO emkt_countries VALUES (46,'Cocos (Keeling) Islands','English','CC','CCK','');
INSERT INTO emkt_countries VALUES (47,'Colombia','English','CO','COL','');
INSERT INTO emkt_countries VALUES (48,'Comoros','English','KM','COM','');
INSERT INTO emkt_countries VALUES (49,'Congo','English','CG','COG','');
INSERT INTO emkt_countries VALUES (50,'Cook Islands','English','CK','COK','');
INSERT INTO emkt_countries VALUES (51,'Costa Rica','English','CR','CRI','');
INSERT INTO emkt_countries VALUES (52,'Cote D\'Ivoire','English','CI','CIV','');
INSERT INTO emkt_countries VALUES (53,'Croatia','English','HR','HRV','');
INSERT INTO emkt_countries VALUES (54,'Cuba','English','CU','CUB','');
INSERT INTO emkt_countries VALUES (55,'Cyprus','English','CY','CYP','');
INSERT INTO emkt_countries VALUES (56,'Czech Republic','English','CZ','CZE','');
INSERT INTO emkt_countries VALUES (57,'Denmark','English','DK','DNK','');
INSERT INTO emkt_countries VALUES (58,'Djibouti','English','DJ','DJI','');
INSERT INTO emkt_countries VALUES (59,'Dominica','English','DM','DMA','');
INSERT INTO emkt_countries VALUES (60,'Dominican Republic','English','DO','DOM','');
INSERT INTO emkt_countries VALUES (61,'East Timor','English','TP','TMP','');
INSERT INTO emkt_countries VALUES (62,'Ecuador','English','EC','ECU','');
INSERT INTO emkt_countries VALUES (63,'Egypt','English','EG','EGY','');
INSERT INTO emkt_countries VALUES (64,'El Salvador','English','SV','SLV','');
INSERT INTO emkt_countries VALUES (65,'Equatorial Guinea','English','GQ','GNQ','');
INSERT INTO emkt_countries VALUES (66,'Eritrea','English','ER','ERI','');
INSERT INTO emkt_countries VALUES (67,'Estonia','English','EE','EST','');
INSERT INTO emkt_countries VALUES (68,'Ethiopia','English','ET','ETH','');
INSERT INTO emkt_countries VALUES (69,'Falkland Islands (Malvinas)','English','FK','FLK','');
INSERT INTO emkt_countries VALUES (70,'Faroe Islands','English','FO','FRO','');
INSERT INTO emkt_countries VALUES (71,'Fiji','English','FJ','FJI','');
INSERT INTO emkt_countries VALUES (72,'Finland','English','FI','FIN','');
INSERT INTO emkt_countries VALUES (73,'France','English','FR','FRA','');
INSERT INTO emkt_countries VALUES (74,'French Guiana','English','GF','GUF','');
INSERT INTO emkt_countries VALUES (75,'French Polynesia','English','PF','PYF','');
INSERT INTO emkt_countries VALUES (76,'French Southern Territories','English','TF','ATF','');
INSERT INTO emkt_countries VALUES (77,'Gabon','English','GA','GAB','');
INSERT INTO emkt_countries VALUES (78,'Gambia','English','GM','GMB','');
INSERT INTO emkt_countries VALUES (79,'Georgia','English','GE','GEO','');
INSERT INTO emkt_countries VALUES (80,'Germany','English','DE','DEU','');
INSERT INTO emkt_countries VALUES (81,'Ghana','English','GH','GHA','');
INSERT INTO emkt_countries VALUES (82,'Gibraltar','English','GI','GIB','');
INSERT INTO emkt_countries VALUES (83,'Greece','English','GR','GRC','');
INSERT INTO emkt_countries VALUES (84,'Greenland','English','GL','GRL','');
INSERT INTO emkt_countries VALUES (85,'Grenada','English','GD','GRD','');
INSERT INTO emkt_countries VALUES (86,'Guadeloupe','English','GP','GLP','');
INSERT INTO emkt_countries VALUES (87,'Guam','English','GU','GUM','');
INSERT INTO emkt_countries VALUES (88,'Guatemala','English','GT','GTM','');
INSERT INTO emkt_countries VALUES (89,'Guinea','English','GN','GIN','');
INSERT INTO emkt_countries VALUES (90,'Guinea-Bissau','English','GW','GNB','');
INSERT INTO emkt_countries VALUES (91,'Guyana','English','GY','GUY','');
INSERT INTO emkt_countries VALUES (92,'Haiti','English','HT','HTI','');
INSERT INTO emkt_countries VALUES (93,'Heard and McDonald Islands','English','HM','HMD','');
INSERT INTO emkt_countries VALUES (94,'Honduras','English','HN','HND','');
INSERT INTO emkt_countries VALUES (95,'Hong Kong','English','HK','HKG','');
INSERT INTO emkt_countries VALUES (96,'Hungary','English','HU','HUN','');
INSERT INTO emkt_countries VALUES (97,'Iceland','English','IS','ISL','');
INSERT INTO emkt_countries VALUES (98,'India','English','IN','IND','');
INSERT INTO emkt_countries VALUES (99,'Indonesia','English','ID','IDN','');
INSERT INTO emkt_countries VALUES (100,'Iran','English','IR','IRN','');
INSERT INTO emkt_countries VALUES (101,'Iraq','English','IQ','IRQ','');
INSERT INTO emkt_countries VALUES (102,'Ireland','English','IE','IRL','');
INSERT INTO emkt_countries VALUES (103,'Israel','English','IL','ISR','');
INSERT INTO emkt_countries VALUES (104,'Italy','English','IT','ITA','');
INSERT INTO emkt_countries VALUES (105,'Jamaica','English','JM','JAM','');
INSERT INTO emkt_countries VALUES (106,'Japan','English','JP','JPN','');
INSERT INTO emkt_countries VALUES (107,'Jordan','English','JO','JOR','');
INSERT INTO emkt_countries VALUES (108,'Kazakhstan','English','KZ','KAZ','');
INSERT INTO emkt_countries VALUES (109,'Kenya','English','KE','KEN','');
INSERT INTO emkt_countries VALUES (110,'Kiribati','English','KI','KIR','');
INSERT INTO emkt_countries VALUES (111,'Korea, North','English','KP','PRK','');
INSERT INTO emkt_countries VALUES (112,'Korea, South','English','KR','KOR','');
INSERT INTO emkt_countries VALUES (113,'Kuwait','English','KW','KWT','');
INSERT INTO emkt_countries VALUES (114,'Kyrgyzstan','English','KG','KGZ','');
INSERT INTO emkt_countries VALUES (115,'Laos','English','LA','LAO','');
INSERT INTO emkt_countries VALUES (116,'Latvia','English','LV','LVA','');
INSERT INTO emkt_countries VALUES (117,'Lebanon','English','LB','LBN','');
INSERT INTO emkt_countries VALUES (118,'Lesotho','English','LS','LSO','');
INSERT INTO emkt_countries VALUES (119,'Liberia','English','LR','LBR','');
INSERT INTO emkt_countries VALUES (120,'Libyan Arab Jamahiriya','English','LY','LBY','');
INSERT INTO emkt_countries VALUES (121,'Liechtenstein','English','LI','LIE','');
INSERT INTO emkt_countries VALUES (122,'Lithuania','English','LT','LTU','');
INSERT INTO emkt_countries VALUES (123,'Luxembourg','English','LU','LUX','');
INSERT INTO emkt_countries VALUES (124,'Macau','English','MO','MAC','');
INSERT INTO emkt_countries VALUES (125,'Macedonia','English','MK','MKD','');
INSERT INTO emkt_countries VALUES (126,'Madagascar','English','MG','MDG','');
INSERT INTO emkt_countries VALUES (127,'Malawi','English','MW','MWI','');
INSERT INTO emkt_countries VALUES (128,'Malaysia','English','MY','MYS','');
INSERT INTO emkt_countries VALUES (129,'Maldives','English','MV','MDV','');
INSERT INTO emkt_countries VALUES (130,'Mali','English','ML','MLI','');
INSERT INTO emkt_countries VALUES (131,'Malta','English','MT','MLT','');
INSERT INTO emkt_countries VALUES (132,'Marshall Islands','English','MH','MHL','');
INSERT INTO emkt_countries VALUES (133,'Martinique','English','MQ','MTQ','');
INSERT INTO emkt_countries VALUES (134,'Mauritania','English','MR','MRT','');
INSERT INTO emkt_countries VALUES (135,'Mauritius','English','MU','MUS','');
INSERT INTO emkt_countries VALUES (136,'Mayotte','English','YT','MYT','');
INSERT INTO emkt_countries VALUES (137,'Mexico','English','MX','MEX','');
INSERT INTO emkt_countries VALUES (138,'Micronesia','English','FM','FSM','');
INSERT INTO emkt_countries VALUES (139,'Moldova','English','MD','MDA','');
INSERT INTO emkt_countries VALUES (140,'Monaco','English','MC','MCO','');
INSERT INTO emkt_countries VALUES (141,'Mongolia','English','MN','MNG','');
INSERT INTO emkt_countries VALUES (142,'Montserrat','English','MS','MSR','');
INSERT INTO emkt_countries VALUES (143,'Morocco','English','MA','MAR','');
INSERT INTO emkt_countries VALUES (144,'Mozambique','English','MZ','MOZ','');
INSERT INTO emkt_countries VALUES (145,'Myanmar','English','MM','MMR','');
INSERT INTO emkt_countries VALUES (146,'Namibia','English','NA','NAM','');
INSERT INTO emkt_countries VALUES (147,'Nauru','English','NR','NRU','');
INSERT INTO emkt_countries VALUES (148,'Nepal','English','NP','NPL','');
INSERT INTO emkt_countries VALUES (149,'Netherlands','English','NL','NLD','');
INSERT INTO emkt_countries VALUES (150,'Netherlands Antilles','English','AN','ANT','');
INSERT INTO emkt_countries VALUES (151,'New Caledonia','English','NC','NCL','');
INSERT INTO emkt_countries VALUES (152,'New Zealand','English','NZ','NZL','');
INSERT INTO emkt_countries VALUES (153,'Nicaragua','English','NI','NIC','');
INSERT INTO emkt_countries VALUES (154,'Niger','English','NE','NER','');
INSERT INTO emkt_countries VALUES (155,'Nigeria','English','NG','NGA','');
INSERT INTO emkt_countries VALUES (156,'Niue','English','NU','NIU','');
INSERT INTO emkt_countries VALUES (157,'Norfolk Island','English','NF','NFK','');
INSERT INTO emkt_countries VALUES (158,'Northern Mariana Islands','English','MP','MNP','');
INSERT INTO emkt_countries VALUES (159,'Norway','English','NO','NOR','');
INSERT INTO emkt_countries VALUES (160,'Oman','English','OM','OMN','');
INSERT INTO emkt_countries VALUES (161,'Pakistan','English','PK','PAK','');
INSERT INTO emkt_countries VALUES (162,'Palau','English','PW','PLW','');
INSERT INTO emkt_countries VALUES (163,'Panama','English','PA','PAN','');
INSERT INTO emkt_countries VALUES (164,'Papua New Guinea','English','PG','PNG','');
INSERT INTO emkt_countries VALUES (165,'Paraguay','English','PY','PRY','');
INSERT INTO emkt_countries VALUES (166,'Peru','English','PE','PER','');
INSERT INTO emkt_countries VALUES (167,'Philippines','English','PH','PHL','');
INSERT INTO emkt_countries VALUES (168,'Pitcairn','English','PN','PCN','');
INSERT INTO emkt_countries VALUES (169,'Poland','English','PL','POL','');
INSERT INTO emkt_countries VALUES (170,'Portugal','English','PT','PRT','');
INSERT INTO emkt_countries VALUES (171,'Puerto Rico','English','PR','PRI','');
INSERT INTO emkt_countries VALUES (172,'Qatar','English','QA','QAT','');
INSERT INTO emkt_countries VALUES (173,'Reunion','English','RE','REU','');
INSERT INTO emkt_countries VALUES (174,'Romania','English','RO','ROM','');

INSERT INTO emkt_countries VALUES (175,'Russian Federation','English','RU','RUS','');

INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'AD','Республика Адыгея','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'AL','Республика Алтай','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ALT','Алтайский край','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'AMU','Амурская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ARK','Архангельская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'AST','Астраханская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'BA','Республика Башкортостан','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'BEL','Белгородская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'BRY','Брянская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'BU','Республика Бурятия','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'CE','Чеченская Республика','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'CHE','Челябинская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ZAB','Забайкальский край','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'CHU','Чукотский автономный округ','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'CU','Чувашская Республика','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'DA','Республика Дагестан','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'IN','Республика Ингушетия','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'IRK','Иркутская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'IVA','Ивановская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KAM','Камчатский край','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KB','Кабардино-Балкарская Республика','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KC','Карачаево-Черкесская Республика','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KDA','Краснодарский край','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KEM','Кемеровская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KGD','Калининградская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KGN','Курганская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KHA','Хабаровский край','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KHM','Ханты-Мансийский автономный округ—Югра','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KIA','Красноярский край','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KIR','Кировская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KK','Республика Хакасия','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KL','Республика Калмыкия','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KLU','Калужская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KO','Республика Коми','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KOS','Костромская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KR','Республика Карелия','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'KRS','Курская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'LEN','Ленинградская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'LIP','Липецкая область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MAG','Магаданская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ME','Республика Марий Эл','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MO','Республика Мордовия','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MOS','Московская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MOW','Москва','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'MUR','Мурманская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'NEN','Ненецкий автономный округ','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'NGR','Новгородская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'NIZ','Нижегородская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'NVS','Новосибирская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'OMS','Омская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ORE','Оренбургская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ORL','Орловская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'PNZ','Пензенская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'PRI','Приморский край','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'PSK','Псковская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ROS','Ростовская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'RYA','Рязанская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SA','Республика Саха (Якутия)','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SAK','Сахалинская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SAM','Самарская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SAR','Саратовская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SE','Республика Северная Осетия–Алания','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SMO','Смоленская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SPE','Санкт-Петербург','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'STA','Ставропольский край','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'SVE','Свердловская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TA','Республика Татарстан','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TAM','Тамбовская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TOM','Томская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TUL','Тульская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TVE','Тверская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TY','Республика Тыва','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'TYU','Тюменская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'UD','Удмуртская Республика','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'ULY','Ульяновская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'VGG','Волгоградская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'VLA','Владимирская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'VLG','Вологодская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'VOR','Воронежская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'PER','Пермский край','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'YAN','Ямало-Ненецкий автономный округ','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'YAR','Ярославская область','English');
INSERT INTO emkt_regions (country_id, region_code, name, language) VALUES (175,'YEV','Еврейская автономная область','English');

INSERT INTO emkt_countries VALUES (176,'Rwanda','English','RW','RWA','');
INSERT INTO emkt_countries VALUES (177,'Saint Kitts and Nevis','English','KN','KNA','');
INSERT INTO emkt_countries VALUES (178,'Saint Lucia','English','LC','LCA','');
INSERT INTO emkt_countries VALUES (179,'Saint Vincent and the Grenadines','English','VC','VCT','');
INSERT INTO emkt_countries VALUES (180,'Samoa','English','WS','WSM','');
INSERT INTO emkt_countries VALUES (181,'San Marino','English','SM','SMR','');
INSERT INTO emkt_countries VALUES (182,'Sao Tome and Principe','English','ST','STP','');
INSERT INTO emkt_countries VALUES (183,'Saudi Arabia','English','SA','SAU','');
INSERT INTO emkt_countries VALUES (184,'Senegal','English','SN','SEN','');
INSERT INTO emkt_countries VALUES (185,'Seychelles','English','SC','SYC','');
INSERT INTO emkt_countries VALUES (186,'Sierra Leone','English','SL','SLE','');
INSERT INTO emkt_countries VALUES (187,'Singapore','English','SG','SGP','');
INSERT INTO emkt_countries VALUES (188,'Slovakia','English','SK','SVK','');
INSERT INTO emkt_countries VALUES (189,'Slovenia','English','SI','SVN','');
INSERT INTO emkt_countries VALUES (190,'Solomon Islands','English','SB','SLB','');
INSERT INTO emkt_countries VALUES (191,'Somalia','English','SO','SOM','');
INSERT INTO emkt_countries VALUES (192,'South Africa','English','ZA','ZAF','');
INSERT INTO emkt_countries VALUES (193,'South Georgia and the South Sandwich Islands','English','GS','SGS','');
INSERT INTO emkt_countries VALUES (194,'Spain','English','ES','ESP','');
INSERT INTO emkt_countries VALUES (195,'Sri Lanka','English','LK','LKA','');
INSERT INTO emkt_countries VALUES (196,'St. Helena','English','SH','SHN','');
INSERT INTO emkt_countries VALUES (197,'St. Pierre and Miquelon','English','PM','SPM','');
INSERT INTO emkt_countries VALUES (198,'Sudan','English','SD','SDN','');
INSERT INTO emkt_countries VALUES (199,'Suriname','English','SR','SUR','');
INSERT INTO emkt_countries VALUES (200,'Svalbard and Jan Mayen Islands','English','SJ','SJM','');
INSERT INTO emkt_countries VALUES (201,'Swaziland','English','SZ','SWZ','');
INSERT INTO emkt_countries VALUES (202,'Sweden','English','SE','SWE','');
INSERT INTO emkt_countries VALUES (203,'Switzerland','English','CH','CHE','');
INSERT INTO emkt_countries VALUES (204,'Syrian Arab Republic','English','SY','SYR','');
INSERT INTO emkt_countries VALUES (205,'Taiwan','English','TW','TWN','');
INSERT INTO emkt_countries VALUES (206,'Tajikistan','English','TJ','TJK','');
INSERT INTO emkt_countries VALUES (207,'Tanzania','English','TZ','TZA','');
INSERT INTO emkt_countries VALUES (208,'Thailand','English','TH','THA','');
INSERT INTO emkt_countries VALUES (209,'Togo','English','TG','TGO','');
INSERT INTO emkt_countries VALUES (210,'Tokelau','English','TK','TKL','');
INSERT INTO emkt_countries VALUES (211,'Tonga','English','TO','TON','');
INSERT INTO emkt_countries VALUES (212,'Trinidad and Tobago','English','TT','TTO','');
INSERT INTO emkt_countries VALUES (213,'Tunisia','English','TN','TUN','');
INSERT INTO emkt_countries VALUES (214,'Turkey','English','TR','TUR','');
INSERT INTO emkt_countries VALUES (215,'Turkmenistan','English','TM','TKM','');
INSERT INTO emkt_countries VALUES (216,'Turks and Caicos Islands','English','TC','TCA','');
INSERT INTO emkt_countries VALUES (217,'Tuvalu','English','TV','TUV','');
INSERT INTO emkt_countries VALUES (218,'Uganda','English','UG','UGA','');
INSERT INTO emkt_countries VALUES (219,'Ukraine','English','UA','UKR','');
INSERT INTO emkt_countries VALUES (220,'United Arab Emirates','English','AE','ARE','');
INSERT INTO emkt_countries VALUES (221,'United Kingdom','English','GB','GBR','');
INSERT INTO emkt_countries VALUES (222,'United States of America','English','US','USA','');
INSERT INTO emkt_countries VALUES (223,'United States Minor Outlying Islands','English','UM','UMI','');
INSERT INTO emkt_countries VALUES (224,'Uruguay','English','UY','URY','');
INSERT INTO emkt_countries VALUES (225,'Uzbekistan','English','UZ','UZB','');
INSERT INTO emkt_countries VALUES (226,'Vanuatu','English','VU','VUT','');
INSERT INTO emkt_countries VALUES (227,'Vatican City State (Holy See)','English','VA','VAT','');
INSERT INTO emkt_countries VALUES (228,'Venezuela','English','VE','VEN','');
INSERT INTO emkt_countries VALUES (229,'Vietnam','English','VN','VNM','');
INSERT INTO emkt_countries VALUES (230,'Virgin Islands (British)','English','VG','VGB','');
INSERT INTO emkt_countries VALUES (231,'Virgin Islands (U.S.)','English','VI','VIR','');
INSERT INTO emkt_countries VALUES (232,'Wallis and Futuna Islands','English','WF','WLF','');
INSERT INTO emkt_countries VALUES (233,'Western Sahara','English','EH','ESH','');
INSERT INTO emkt_countries VALUES (234,'Yemen','English','YE','YEM','');
INSERT INTO emkt_countries VALUES (235,'Yugoslavia','English','YU','YUG','');
INSERT INTO emkt_countries VALUES (236,'Zaire','English','ZR','ZAR','');
INSERT INTO emkt_countries VALUES (237,'Zambia','English','ZM','ZMB','');
INSERT INTO emkt_countries VALUES (238,'Zimbabwe','English','ZW','ZWE','');