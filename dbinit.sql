SET NAMES utf8;

CREATE TABLE IF NOT EXISTS webconfig (
  id int NOT NULL AUTO_INCREMENT,
  keyname varchar(255) NOT NULL UNIQUE,
  name varchar(255) NOT NULL,
  content varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS accessgroup (
  id int(1) NOT NULL,
  groupname varchar(64),
  PRIMARY KEY (id)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS person (
  id int(5) NOT NULL AUTO_INCREMENT,
  firstname varchar(128) NOT NULL,
  lastname varchar(128) NOT NULL,
  email varchar(255) NOT NULL,
  accesslevel int(1) NOT NULL,
  password varchar(128),
  PRIMARY KEY (id),
  FOREIGN KEY(accesslevel) REFERENCES accessgroup(id)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS voteleader2018candidates (
  id int(5) NOT NULL UNIQUE,
  PRIMARY KEY (id),
  FOREIGN KEY(id) REFERENCES person(id)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS voteleader2018voterid (
  id int(5) NOT NULL UNIQUE,
  hash varchar(128) NOT NULL UNIQUE,
  PRIMARY KEY (id),
  FOREIGN KEY(id) REFERENCES person(id)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS voteleader2018votes (
  cryptid varchar(128) NOT NULL UNIQUE,
  candidateid int(5) NOT NULL,
  PRIMARY KEY (cryptid),
  FOREIGN KEY(candidateid) REFERENCES voteleader2018candidates(id)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;