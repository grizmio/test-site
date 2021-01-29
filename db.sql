create table users (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(200) NOT NULL,
  lastname varchar(256) NOT NULL,
  email varchar(256) NOT NULL,
  password varchar(60) NOT NULL,
  superuser TINYINT(1) DEFAULT 0,
  created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  logintimestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  prevlogintimestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT users_email UNIQUE (email)
);

INSERT INTO users (name, lastname, email, superuser,password)
  values ('admin', 'admin', 'admin@foo.com', 1, '$2y$10$Mr84q4Pw14kApox2F3zw8.2wgMAzYrPIW1EII9fpfUuI2WdpadNia');
