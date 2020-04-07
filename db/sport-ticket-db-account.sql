
CREATE USER 'sportticket'@'localhost' IDENTIFIED BY 'password!';
GRANT ALL PRIVILEGES ON sport_ticket.* TO 'sportticket'@'localhost';
-- UPDATE mysql.user SET Password=PASSWORD('65QEcp?z') WHERE User='root';
-- C:\xampp\phpMyAdmin\config.inc.php



-- remove dirty
select * from tb_order;
select * from tb_customer;
--delete from tb_order;
--ALTER TABLE tb_order AUTO_INCREMENT = 1;
--delete from tb_customer;
--ALTER TABLE tb_customer AUTO_INCREMENT = 1;


