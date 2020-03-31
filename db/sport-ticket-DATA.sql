# data for sport_ticket database
SET NAMES utf8mb4;

USE `sport_ticket`;

#--------------------------------- site data ---------------------------------
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('1', '奧林匹克體育中心(羽毛球場) OC', 'Centro Desportivo Olimpico');
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('2', '何東中葡小學綜合運動室', 'Ginasio Polidesportivo da Escola Primaria Oficial Luso-Chinesa Sir Robert Ho Tung');
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('3', '氹仔東北體育中心', 'Centro Desportivo do Nordeste da Taipa');
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('4', '澳門東亞運動會體育館', 'Nave Desportiva dos Jogos da Ásia Oriental de Macau');
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('5', '澳大綜合體育館', 'Complexo Desportivo da UM');
#------------------------------------------------------------------------------

#--------------------------------- court data ---------------------------------
# 澳門東亞運動會體育館 
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('4', '澳門東亞運動會體育館', 'B', '10.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('4', '澳門東亞運動會體育館', 'C', '10.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('4', '澳門東亞運動會體育館', 'F', '10.00', '20.00');


# 氹仔東北體育中心
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('3', '氹仔東北體育中心', 'I', '20.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('3', '氹仔東北體育中心', 'III', '20.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('3', '氹仔東北體育中心', 'V', '20.00', '20.00');

# 奧林匹克體育中心
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('1', '奧林匹克體育中心(羽毛球場) OC', '2', '20.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('1', '奧林匹克體育中心(羽毛球場) OC', '4', '20.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('1', '奧林匹克體育中心(羽毛球場) OC', '5', '20.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('1', '奧林匹克體育中心(羽毛球場) OC', '7', '20.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('1', '奧林匹克體育中心(羽毛球場) OC', '9', '20.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('1', '奧林匹克體育中心(羽毛球場) OC', '11', '20.00', '20.00');

# 何東中葡小學綜合運動室
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('2', '何東中葡小學綜合運動室', '2', '20.00', '20.00');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, fee_weekday, fee_weekend) VALUES ('2', '何東中葡小學綜合運動室', '3', '20.00', '20.00');

# 澳大綜合體育館
# no data
#------------------------------------------------------------------------------