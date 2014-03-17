DROP TABLE IF EXISTS hotspots;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  firstname varchar(255) NOT NULL,
  lastname varchar(255) NOT NULL,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY username (username),
  UNIQUE KEY email (email)
);

CREATE TABLE hotspots (
  id int(11) NOT NULL AUTO_INCREMENT,
  userid int(11) NOT NULL,
  name varchar(255) NOT NULL,
  address varchar(255) NOT NULL,
  date varchar(255) NOT NULL,
  hasplugs boolean,
  hascoffee boolean,
  haswifi boolean,
  PRIMARY KEY (id),
  FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE
);
