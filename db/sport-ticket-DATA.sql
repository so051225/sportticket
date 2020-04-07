# data for sport_ticket database
SET NAMES utf8mb4;

USE `sport_ticket`;

#--------------------------------- site data ---------------------------------
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('1', '澳門東亞運動會體育館', 'Nave Desportiva dos Jogos da Ásia Oriental de Macau');
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('2', '氹仔東北體育中心', 'Centro Desportivo do Nordeste da Taipa');
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('3', '奧林匹克體育中心(羽毛球場) OC', 'Centro Desportivo Olimpico');
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('4', '何東中葡小學綜合運動室', 'Ginasio Polidesportivo da Escola Primaria Oficial Luso-Chinesa Sir Robert Ho Tung');
INSERT INTO sport_ticket.tb_site (sid, site_name_zh, site_name_pt) VALUES ('5', '澳大綜合體育館', 'Complexo Desportivo da UM');
#------------------------------------------------------------------------------

#--------------------------------- court data ---------------------------------
# 澳門東亞運動會體育館 
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('1', '澳門東亞運動會體育館', 'B', '0');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('1', '澳門東亞運動會體育館', 'C', '0');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('1', '澳門東亞運動會體育館', 'F', '1');


# 氹仔東北體育中心
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('2', '氹仔東北體育中心', 'I', '0');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('2', '氹仔東北體育中心', 'III', '0');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('2', '氹仔東北體育中心', 'V', '1');

# 奧林匹克體育中心
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('3', '奧林匹克體育中心(羽毛球場) OC', '2', '1');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('3', '奧林匹克體育中心(羽毛球場) OC', '4', '1');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('3', '奧林匹克體育中心(羽毛球場) OC', '5', '1');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('3', '奧林匹克體育中心(羽毛球場) OC', '7', '0');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('3', '奧林匹克體育中心(羽毛球場) OC', '9', '0');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('3', '奧林匹克體育中心(羽毛球場) OC', '11', '0');

# 何東中葡小學綜合運動室
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('4', '何東中葡小學綜合運動室', '2', '0');
INSERT INTO sport_ticket.tb_court (sid, display_name, court_no, is_reserved) VALUES ('4', '何東中葡小學綜合運動室', '3', '1');

# 澳大綜合體育館
# no data
#------------------------------------------------------------------------------