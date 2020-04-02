
CREATE USER 'sportticket'@'localhost' IDENTIFIED BY 'password!';
GRANT ALL PRIVILEGES ON sport_ticket.* TO 'sportticket'@'localhost';
UPDATE mysql.user SET Password=PASSWORD('65QEcp?z') WHERE User='root';
——　 C:\xampp\phpMyAdmin\config.inc.php