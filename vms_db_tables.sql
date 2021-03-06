CREATE TABLE `vms_db`.`vms_users`
( `id` INT NOT NULL AUTO_INCREMENT , 
  `name` VARCHAR(30) NOT NULL , 
  `pw` VARCHAR(30) NOT NULL , 
  `status` INT NOT NULL DEFAULT '1' , 
  `remark` TEXT NOT NULL ,
    PRIMARY KEY (`id`),
    UNIQUE (`name`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci
  COMMENT = 'account for vms system';


CREATE TABLE `vms_db`.`vtype`
( `id` INT NOT NULL AUTO_INCREMENT , 
  `name` VARCHAR(30) NOT NULL , 
  `sdate` date NULL,
  `edate` date NULL,
  `status` INT NOT NULL DEFAULT '1' , 
  `remark` TEXT NULL ,
    PRIMARY KEY (`id`),
    UNIQUE (`name`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci
  COMMENT = 'tasks type for vms system';


CREATE TABLE `vms_db`.`volun_man`
( `id` INT NOT NULL AUTO_INCREMENT , 
  `name` VARCHAR(30) NOT NULL , 
  `sex` INT NOT NULL DEFAULT '-1', 
  `location` INT NULL , 
  `class_num` INT NULL , 
  `status` INT NOT NULL DEFAULT '1' , 
  `remark` TEXT NULL ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci
  COMMENT = 'volunteers for vms system';


CREATE TABLE `vms_db`.`volun_atten`
( `id` INT NOT NULL AUTO_INCREMENT , 
  `date` date NOT NULL,
  `vtype_id` INT NOT NULL , 
  `volun_man_id` INT NOT NULL , 
  `stime_h` INT NULL , 
  `stime_m` INT NULL , 
  `etime_h` INT NULL , 
  `etime_m` INT NULL , 
  `status` INT NOT NULL DEFAULT '1' , 
  `remark` TEXT NULL ,
    PRIMARY KEY (`id`) ,
    FOREIGN KEY (`vtype_id`) REFERENCES vtype(`id`) ,
    FOREIGN KEY (`volun_man_id`) REFERENCES volun_man(`id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci
  COMMENT = 'attendency of volunteers for vms system';

CREATE TABLE `vms_db`.`class_location`
( `id` INT NOT NULL AUTO_INCREMENT , 
  `name` VARCHAR(30) NOT NULL , 
  `status` INT NOT NULL DEFAULT '1' , 
  `remark` TEXT NULL ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci
  COMMENT = 'class location';

CREATE TABLE `vms_db`.`class`
( `id` INT NOT NULL AUTO_INCREMENT , 
  `num` INT NOT NULL , 
  `loc_id` INT NOT NULL , 
  `start_date` date NULL ,
  `embrace_date` date NULL , 
  `status` INT NOT NULL DEFAULT '1' , 
  `remark` TEXT NULL ,
    UNIQUE (`id`) ,
    FOREIGN KEY (`loc_id`) REFERENCES class_location(`id`) ,
    CONSTRAINT loc_num PRIMARY KEY (num,loc_id)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci
  COMMENT = 'class location';
