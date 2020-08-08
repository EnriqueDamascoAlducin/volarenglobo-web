-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `user` varchar(100) NOT NULL,
  `convid` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `class` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `archive`
--


-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(300) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files`
--


-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `transcript` int(11) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `leads`
--


-- --------------------------------------------------------

--
-- Table structure for table `loginlog`
--

CREATE TABLE `loginlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `fromwhere` varchar(255) DEFAULT NULL,
  `ip` char(15) NOT NULL,
  `usragent` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` smallint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `loginlog`
--


-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `message` varchar(3000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `responses`
--


-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(200) NOT NULL,
  `convid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `initiated` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `ended` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `answered` int(11) NOT NULL,
  `contact` varchar(3) NOT NULL DEFAULT 'no',
  `hide` varchar(3) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `varname` varchar(100) NOT NULL DEFAULT '',
  `groupname` varchar(50) DEFAULT NULL,
  `value` mediumtext,
  `defaultvalue` mediumtext,
  `optioncode` mediumtext,
  `datatype` enum('free','number','boolean','bitfield','username','integer','posint') NOT NULL DEFAULT 'free',
  `product` varchar(25) DEFAULT '',
  PRIMARY KEY (`varname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` VALUES('version', 'version', '1.4', '1.4', NULL, 'free', 'rhino');
INSERT INTO `setting` VALUES('thankyou_message', 'setting', 'Thank you for your message. We will be in touch as soon as possible!', 'Thank you for your message.  We will be in touch as soon as possible!', 'textarea', 'free', 'rhino');
INSERT INTO `setting` VALUES('title', 'setting', 'Live Support - Rhino', 'Live Support - Rhino', 'input', 'free', 'rhino');
INSERT INTO `setting` VALUES('captcha', 'setting', '1', '1', 'yesno', 'boolean', 'rhino');
INSERT INTO `setting` VALUES('captchachat', 'setting', '1', '1', 'yesno', 'boolean', 'rhino');
INSERT INTO `setting` VALUES('smilies', 'setting', '1', '1', 'yesno', 'boolean', 'rhino');
INSERT INTO `setting` VALUES('updated', 'setting', '1335340128', '1335340128', 'time', 'number', 'rhino');
INSERT INTO `setting` VALUES('client_refresh', 'setting', '5000', '5000', 'input', 'number', 'rhino');
INSERT INTO `setting` VALUES('email', 'setting', '', 'ls_rhino', 'input', 'free', 'rhino');
INSERT INTO `setting` VALUES('sitehttps', 'setting', '0', '0', 'yesno', 'boolean', 'rhino');
INSERT INTO `setting` VALUES('dateformat', 'setting', 'd.m.Y', 'd.m.Y', 'input', 'free', 'rhino');
INSERT INTO `setting` VALUES('timeformat', 'setting', ' - H:i', 'h:i A', 'input', 'free', 'rhino');
INSERT INTO `setting` VALUES('leave_message', 'setting', 'None of our representatives are currently available. Please use the form below to send us an email.', 'None of our representatives are currently available.  Please use the form below to send us an email.', 'textarea', 'free', 'rhino');
INSERT INTO `setting` VALUES('welcome_message', 'setting', 'Welcome, a representative will be with you shortly', 'Welcome, a representative will be with you shortly', 'textarea', 'free', 'rhino');
INSERT INTO `setting` VALUES('feedback_message', 'setting', 'Please rate the conversation and let us know what we can improve.', 'Please rate the conversation and let us know what we can improve.', 'textarea', 'free', 'rhino');
INSERT INTO `setting` VALUES('thankyou_feedback', 'setting', 'Thank you for taking the time to give us your feedback.', 'Thank you for taking the time to give us your feedback.', 'textarea', 'free', 'rhino');
INSERT INTO `setting` VALUES('timezoneserver', 'setting', 'Europe/Zurich', 'Europe/Zurich', 'select', 'free', 'rhino');
INSERT INTO `setting` VALUES('lang', 'setting', 'en', 'en', 'input', 'free', 'rhino');
INSERT INTO `setting` VALUES('useravatwidth', 'setting', '150', '150', 'input', 'free', 'rhino');
INSERT INTO `setting` VALUES('useravatheight', 'setting', '113', '113', 'input', 'free', 'rhino');
INSERT INTO `setting` VALUES('filepath', 'setting', '', '', 'input', 'free', 'rhino');
INSERT INTO `setting` VALUES('login_message', 'setting', 'Please type your name to begin. Entering your email address is optional, although if you would like to be contacted in the future, please add your email address and tick the checkbox before starting your session.', 'Please type your name to begin. Entering your email address is optional, although if you would like to be contacted in the future, please add your email address and tick the checkbox before starting your session.', 'textarea', 'free', 'rhino');
INSERT INTO `setting` VALUES('offline_message', 'setting', 'None of our representatives are available right now, although you are welcome to leave a message!', 'None of our representatives are available right now, although you are welcome to leave a message!', 'textarea', 'free', 'rhino');
INSERT INTO `setting` VALUES('inactiv', 'setting', '600', '600', 'input', 'number', 'rhino');
INSERT INTO `setting` VALUES('end_flush', 'setting', '300', '300', 'input', 'number', 'rhino');
INSERT INTO `setting` VALUES('conv_refresh', 'setting', '5000', '5000', 'number', 'number', 'rhino');
INSERT INTO `setting` VALUES('admin_refresh', 'setting', '3000', '3000', 'input', 'number', 'rhino');

-- --------------------------------------------------------

--
-- Table structure for table `transcript`
--

CREATE TABLE `transcript` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `user` varchar(100) NOT NULL,
  `convid` int(11) unsigned NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `class` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `transcript`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `available` smallint(1) unsigned NOT NULL DEFAULT '0',
  `username` varchar(100) DEFAULT NULL,
  `password` char(64) NOT NULL,
  `idhash` varchar(32) DEFAULT NULL,
  `session` varchar(32) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `picture` varchar(255) NOT NULL DEFAULT '/standard.png',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastactivity` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `access` smallint(1) unsigned NOT NULL DEFAULT '0',
  `forgot` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_stats`
--

CREATE TABLE `user_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL,
  `vote` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text,
  `support_time` int(10) unsigned NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
