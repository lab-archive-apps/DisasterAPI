CREATE TABLE disasters(
  id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),
  date VARCHAR(255),
  season VARCHAR(50),
  class VARCHAR(50),
  scale VARCHAR(255),
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp
)ENGINE=INNODB;

CREATE TABLE disaster_corresponds(
  id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  disaster_id integer(11),
  name VARCHAR(255),
  section VARCHAR(255),
  contents TEXT,
  comments TEXT,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp,
  FOREIGN KEY (disaster_id) REFERENCES disasters(id) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE todo_lists(
  id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp
)ENGINE=INNODB;

CREATE TABLE todo_lists_messages(
  id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  list_id INTEGER(11),
  message VARCHAR(255),
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp,
  FOREIGN KEY (list_id) REFERENCES todo_lists(id) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE prevention_plans(
  id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp
)ENGINE=INNODB;

CREATE TABLE prevention_plans_details(
  id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  plan_id INTEGER(11),
  title VARCHAR(255),
  phase VARCHAR(255),
  s_date VARCHAR(255),
  e_date VARCHAR(255),
  content TEXT,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp,
  FOREIGN KEY (plan_id) REFERENCES prevention_plans(id) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE files(
  id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  resource_id INTEGER,
  resource_type VARCHAR(255),
  path TEXT,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp
--   FOREIGN KEY (resource_id) REFERENCES lectures(id) ON DELETE CASCADE
)ENGINE=INNODB;
