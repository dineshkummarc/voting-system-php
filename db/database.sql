
CREATE TABLE `user`(
    `user_id` int(11) NOT NULL ,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL
);
ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,AUTO_INCREMENT=1;

CREATE TABLE `position`(
    `position_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `position_name` varchar(255) NOT NULL,
    `time` datetime DEFAULT NOW()
);
INSERT INTO `position`(`position_name`) VALUES
('doctor'),
('web developer'),
('designer'),
('marketing manager');

ALTER TABLE `position` MODIFY `position_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,AUTO_INCREMENT=2;

CREATE TABLE `candidate`(
    `candidate_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `candidate_name` varchar(255) NOT NULL,
    `candidate_position` varchar(255) NOT NULL,
    `time` datetime DEFAULT NOW()
);
INSERT INTO `candidate`(`candidate_name`,`candidate_position`) VALUES
('john doe','designer'),
('aref faraji','prime-minister'),
('yadollah faraji','doctor'),
('maryam parvaneh','driver');

ALTER TABLE `user` ADD `is_admin` varchar(10) NOT NULL DEFAULT 'no';
ALTER TABLE `user` ADD `voted_for` varchar(255) NOT NULL DEFAULT '';
ALTER TABLE `candidate` ADD `votes` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `user` MODIFY `voted_for` varchar(400) NOT null DEFAULT '';
