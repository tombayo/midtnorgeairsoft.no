SET NAMES utf8;

CREATE TABLE IF NOT EXISTS webconfig (
  id int NOT NULL AUTO_INCREMENT,
  keyname varchar(255) NOT NULL UNIQUE,
  name varchar(255) NOT NULL,
  content varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS postplace (
  id int(4) NOT NULL,
  name varchar(64),
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
  address varchar(255) NOT NULL,
  postcode int(4) NOT NULL,
  country varchar(128) NOT NULL,
  phonenumber varchar(64) NOT NULL,
  accesslevel int(1) NOT NULL,
  password varchar(128),
  PRIMARY KEY (id),
  FOREIGN KEY(postcode) REFERENCES postplace(id),
  FOREIGN KEY(accesslevel) REFERENCES accessgroup(id)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

-- STANDARD VALUES: --
source postcodes.sql
source basicdata.sql
