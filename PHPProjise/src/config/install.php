<?php


class Install extends BaseDAL {
	public function index() {
		$db = $this->connection();
		$sql = 'SELECT count(*) FROM information_schema.tables WHERE TABLE_SCHEMA = :database';
		$params = array(':database' => Settings::$database);
		$query = $db->prepare($sql);
		$status = $query->execute($params);
		$tableCount = $query->fetch(PDO::FETCH_NUM);

		if ($tableCount[0] === '0') {
			$intitiated = $this->initDB();
			if ($initiated) {
				//redirect?
				return 'db initiated';
			} else {
				return 'Failed to initiate db<br />
				Check your settings and make sure you created the db';
			}
		} else {
			return 'db already exists';
		}
	}

	//This just silently fails on host, no idea why :(
	public function initDB() {
		try {
			$db = $this->connection();
			$sql = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
					SET time_zone = "+00:00";

					CREATE TABLE IF NOT EXISTS `projects` (
					  `projectId` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(50) NOT NULL,
					  `description` varchar(250) NOT NULL,
					  PRIMARY KEY (`projectId`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

					CREATE TABLE IF NOT EXISTS `story` (
					  `storyId` int(11) NOT NULL AUTO_INCREMENT,
					  `projectId` int(11) NOT NULL,
					  `name` varchar(50) NOT NULL,
					  `description` varchar(250) NOT NULL,
					  `storyStatusId` tinyint(4) NOT NULL,
					  PRIMARY KEY (`storyId`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

					CREATE TABLE IF NOT EXISTS `storyStatus` (
					  `storyStatusId` tinyint(4) NOT NULL AUTO_INCREMENT,
					  `status` varchar(50) NOT NULL,
					  PRIMARY KEY (`storyStatusId`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

					CREATE TABLE IF NOT EXISTS `userProjects` (
					  `userId` int(11) NOT NULL,
					  `projectId` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `users` (
					  `userId` int(11) NOT NULL AUTO_INCREMENT,
					  `username` varchar(50) NOT NULL,
					  `password` varchar(250) NOT NULL,
					  `salt` varchar(250) NOT NULL,
					  `userAgent` varchar(250) NOT NULL,
					  `token` varchar(250) NOT NULL,
					  `expiration` varchar(250) NOT NULL,
					  PRIMARY KEY (`userId`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;';
			
			$params = array(':dbName' => Settings::$database);
			$query = $db->prepare($sql);
			$status = $query->execute($params);
		} catch (PDOException $e) {
			echo '<pre>';
			var_dump($e);
			echo '</pre>';
		}

		return $status;
	}
}