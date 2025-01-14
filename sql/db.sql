/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS league_managerDB /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE league_managerDB;

CREATE TABLE IF NOT EXISTS equipes (
  id int(11) NOT NULL AUTO_INCREMENT,
  nom varchar(255) NOT NULL,
  description text DEFAULT NULL,
  score_total int(11) NOT NULL,
  logo varchar(255) DEFAULT NULL,
  wins int(11) DEFAULT 0,
  draws int(11) DEFAULT 0,
  losses int(11) DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO equipes (id, nom, description, score_total, logo, wins, draws, losses) VALUES
	(1, 'Real Madrid', 'best football team of all time', 133, 'uploads/logos/67868280c9f05-madrid.png', 0, 0, 0),
	(2, 'Manchester City', 'new club', 49, 'uploads/logos/6786832db49ff-city.png', 0, 0, 0),
	(3, 'FC Barcelona', 'one of the best teams in spain', 53, 'uploads/logos/678683ec5d5c6-barca.png', 0, 0, 0),
	(4, 'Bayern Munchen', '8-2', 64, 'uploads/logos/678693ab15bb4-FC_Bayern_München_Logo_2017.png', 0, 0, 0),
	(5, 'Liverpool FC', 'best english team of all time', 13, 'uploads/logos/67869c5083e28-lfc.png', 0, 0, 0),
	(6, 'Chelsea FC', 'one of the best teams in england', 27, 'uploads/logos/67869c6b59fd7-chelsea.png', 0, 0, 0),
	(7, 'Arsenal FC', 'one of the best teams in england', 26, 'uploads/logos/67869c90dbeda-arsenal.png', 0, 0, 0),
	(8, 'Atletico Madrid', 'one of the best teams in spain', 19, 'uploads/logos/67869cb37d924-atleti.png', 0, 0, 0),
	(9, 'Paris Saint Germain', 'best team in france', 17, 'uploads/logos/67869ccc1504d-Paris_Saint-Germain_F.C..svg.png', 0, 0, 0),
	(10, 'Juventus FC', 'one of the best teams in italy', 32, 'uploads/logos/67869cec3a2f4-pngwing.com.png', 0, 0, 0);

CREATE TABLE IF NOT EXISTS matches (
  id int(11) NOT NULL AUTO_INCREMENT,
  equipe1_id int(11) NOT NULL,
  equipe2_id int(11) NOT NULL,
  score_equipe1 int(11) NOT NULL,
  score_equipe2 int(11) NOT NULL,
  date_match date NOT NULL,
  PRIMARY KEY (id),
  KEY equipe1_id (equipe1_id),
  KEY equipe2_id (equipe2_id),
  CONSTRAINT matches_ibfk_1 FOREIGN KEY (equipe1_id) REFERENCES equipes (id),
  CONSTRAINT matches_ibfk_2 FOREIGN KEY (equipe2_id) REFERENCES equipes (id)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;