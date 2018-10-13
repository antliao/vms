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
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `status` INT NOT NULL DEFAULT '1' , 
  `remark` TEXT NULL ,
    PRIMARY KEY (`id`),
    UNIQUE (`name`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci
  COMMENT = 'tasks type for vms system';


CREATE TABLE `vms_db`.`volun_man`
( `id` INT NOT NULL AUTO_INCREMENT , 
  `name` VARCHAR(30) NOT NULL , 
  `sex` INT NOT NULL DEFAULT '1' , 
  `location` VARCHAR(50) NOT NULL , 
  `class_num` INT NOT NULL , 
  `status` INT NOT NULL DEFAULT '1' , 
  `remark` TEXT NULL ,
    PRIMARY KEY (`id`),
    UNIQUE (`name`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci
  COMMENT = 'volunteers for vms system';


CREATE TABLE `vms_db`.`volun_atten`
( `id` INT NOT NULL AUTO_INCREMENT , 
  `date` date NOT NULL,
  `vtype_id` INT NOT NULL , 
  `vtype_name` VARCHAR(30) NOT NULL , 
  `volun_man_id` INT NOT NULL , 
  `volun_man_name` VARCHAR(30) NOT NULL , 
  `stime_h` INT NOT NULL , 
  `stime_m` INT NOT NULL , 
  `etime_h` INT NOT NULL , 
  `etime_m` INT NOT NULL , 
  `status` INT NOT NULL DEFAULT '1' , 
  `remark` TEXT NULL ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci
  COMMENT = 'attendency of volunteers for vms system';
