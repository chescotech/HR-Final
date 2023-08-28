

CREATE TABLE `allowances_tb` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `company_id` int(12) NOT NULL,
  `house_allowance` int(12) NOT NULL,
  `transport_allowance` int(12) NOT NULL,
  `lunch_allowance` int(12) NOT NULL,
  `emp_no` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

INSERT INTO allowances_tb VALUES("42","4","0","0","0","LMP03");
INSERT INTO allowances_tb VALUES("43","4","0","0","0","MART");



CREATE TABLE `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posting_id` int(11) NOT NULL,
  `name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `mobile` varchar(222) NOT NULL,
  `cover` varchar(222) NOT NULL,
  `cv` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(222) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO applications VALUES("4","3","choolwe ngandu","choolwe1992@gmail.com","0975704991","Order Receipt.pdf","Order Receipt.pdf","2022-02-01 17:57:42","Unread");
INSERT INTO applications VALUES("5","3","choolwe ngandu","choolwe1992@gmail.com","0975704991","Order Receipt.pdf","Order Receipt.pdf","2022-02-01 17:57:42","Rejected");



CREATE TABLE `appover_groups` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `work_flow_id` int(12) NOT NULL,
  `level` int(12) NOT NULL,
  `date_created` date NOT NULL,
  `empno` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

INSERT INTO appover_groups VALUES("27","1","1","0000-00-00","JIM01");



CREATE TABLE `ass_appraisals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empno` varchar(20) NOT NULL,
  `bossno` varchar(20) NOT NULL,
  `own_score` varchar(50) NOT NULL,
  `boss_score` varchar(50) NOT NULL,
  `total_score` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `params_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `factor_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO ass_appraisals VALUES("6","","LMP03","","","","","2022-02-18 20:34:42","1","1","1","35");
INSERT INTO ass_appraisals VALUES("7","","LMP03","","","","","2022-02-18 20:38:05","2","1","3","35");



CREATE TABLE `ass_factors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  `target` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO ass_factors VALUES("1","C1: Ability to resolve user / customer issues on time and effectively. ","10");
INSERT INTO ass_factors VALUES("2","C2: Ability to understand a customer or users requirements and provide a working solution. ","10");
INSERT INTO ass_factors VALUES("3","I1: Productivity i.e. ability to produce acceptable Software that meets userâ€™s expectations and meets deadlines.","30");
INSERT INTO ass_factors VALUES("4","I2: Knowledge and skills i.e. ability to perform the job thoroughly without major assistance. ","30");
INSERT INTO ass_factors VALUES("5","LG1: Ability to quickly understand and learn our current systems and adapt to new processes. ","5");
INSERT INTO ass_factors VALUES("6","Punctuality / Absenteeism  ","2");
INSERT INTO ass_factors VALUES("7"," LG2: Ability to quickly adapt and learn new technologies. ","5");
INSERT INTO ass_factors VALUES("8","Staff cooperatively with others: value working relationships","2");
INSERT INTO ass_factors VALUES("9","Creativity, the ability to come up with new ideas ","2");
INSERT INTO ass_factors VALUES("10","How well does the staff handle work pressure and seeks to solve it by constructive action at his/her own level","4");



CREATE TABLE `ass_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  `weight` varchar(222) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO ass_params VALUES("1","Customers","20");
INSERT INTO ass_params VALUES("2","Internal","60");
INSERT INTO ass_params VALUES("3","Learn & Growt","10");
INSERT INTO ass_params VALUES("4","Time Management","2");
INSERT INTO ass_params VALUES("5","Teamwork","2");
INSERT INTO ass_params VALUES("6","Innovation","2");
INSERT INTO ass_params VALUES("7","Ability to handle pressure","4");



CREATE TABLE `ass_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  `status` varchar(222) NOT NULL,
  `date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO ass_periods VALUES("1","Probation Period 1 Nov 2021 to 31 Jan 2022","Open","2022-02-18");
INSERT INTO ass_periods VALUES("2","Probation Period 2 Jan 2022 to 31 April 2022	","Closed","2022-02-18");



CREATE TABLE `attendance_logs` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `log_date` text NOT NULL,
  `login_time` text NOT NULL,
  `logout_time` text NOT NULL,
  `empno` text NOT NULL,
  `company_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO attendance_logs VALUES("14","2022/02/28","2022-02-28 09:59:24","2022-02-28 10:03:46","MART","4");
INSERT INTO attendance_logs VALUES("15","2022/03/01","2022-03-01 08:49:16","","MART","4");
INSERT INTO attendance_logs VALUES("16","2022/03/01","2022-03-01 11:47:54","","jim01","4");



CREATE TABLE `band_tb` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `top_band` int(12) NOT NULL,
  `band_percentage` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO band_tb VALUES("1","3000","0");
INSERT INTO band_tb VALUES("2","3800","0.25");
INSERT INTO band_tb VALUES("3","5900","0.3");
INSERT INTO band_tb VALUES("4","6000","0.35");



CREATE TABLE `certificates_tb` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `cv` text NOT NULL,
  `qualifications` text NOT NULL,
  `date_uploaded` text NOT NULL,
  `status` text NOT NULL,
  `empno` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO certificates_tb VALUES("4","ctl015-cv_choolwe_ngandu.pdf","ctl015-degree-choolwe-ngandu.pdf","2017-01-09","pending","CTL015");
INSERT INTO certificates_tb VALUES("5","ctl015-belina-inspire-brochure-zambia.pdf","ctl015-belina-time-control-brochure-zambia.pdf","2017-01-14","pending","CTL015");
INSERT INTO certificates_tb VALUES("6","ctl015-invoice.pdf","ctl015-invoice.pdf","2017-08-19","pending","CTL015");
INSERT INTO certificates_tb VALUES("7","ps-pending-cbf-issues.pdf","ps-pending-cbf-issues.pdf","2022-02-25","pending","ps");
INSERT INTO certificates_tb VALUES("8","mart-quotation.pdf","mart-quotation.pdf","2022-02-28","pending","MART");
INSERT INTO certificates_tb VALUES("9","mart-quotation.pdf","mart-quotation.pdf","2022-03-01","pending","MART");



CREATE TABLE `company` (
  `company_ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `address` varchar(90) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(20) NOT NULL,
  `logo` text NOT NULL,
  `date_registration` text NOT NULL,
  `status` text NOT NULL,
  `_key` text NOT NULL,
  PRIMARY KEY (`company_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO company VALUES("4","First Alliance Bank","lusaka","00","alliance@com","Samis","inn0v8","mobile_champ.PNG","2022-02-20","active","5913-1950-0012-0155-2702-2022");



CREATE TABLE `deductions` (
  `ded_id` int(6) NOT NULL AUTO_INCREMENT,
  `deduction_name` varchar(90) DEFAULT NULL,
  `company_ID` int(20) NOT NULL,
  PRIMARY KEY (`ded_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;




CREATE TABLE `department` (
  `dep_id` int(7) NOT NULL AUTO_INCREMENT,
  `department` varchar(50) NOT NULL,
  `company_ID` varchar(20) NOT NULL,
  PRIMARY KEY (`dep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

INSERT INTO department VALUES("35","ACCOUNTING","4");
INSERT INTO department VALUES("36","VISA","4");
INSERT INTO department VALUES("37","IT","4");



CREATE TABLE `earnings` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `earning_name` varchar(90) DEFAULT NULL,
  `company_ID` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO earnings VALUES("1","Basic Pay","4");
INSERT INTO earnings VALUES("2","Transport Allowance","4");
INSERT INTO earnings VALUES("3","Housing Allowance","4");
INSERT INTO earnings VALUES("4","Commission Earned","4");



CREATE TABLE `emp_edu_info_tb` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `emp_id` text NOT NULL,
  `highest_qualifications` text NOT NULL,
  `qualifications` text NOT NULL,
  `university` text NOT NULL,
  `secondary_school` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO emp_edu_info_tb VALUES("8","MART","Diploma","COMPUTER","UNZA","HIGHLAND","");
INSERT INTO emp_edu_info_tb VALUES("9","MART","Degree","COMPUTER","UNZA","HIGHLAND","");



CREATE TABLE `emp_history_tb` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `emp_id` text NOT NULL,
  `employer_one` text NOT NULL,
  `position_one` text NOT NULL,
  `date_start_one` text NOT NULL,
  `date_end_one` text NOT NULL,
  `employer_two` text NOT NULL,
  `position_two` text NOT NULL,
  `date_start_two` text NOT NULL,
  `date_end_two` text NOT NULL,
  `employer_three` text NOT NULL,
  `position_three` text NOT NULL,
  `date_start_three` text NOT NULL,
  `date_end_three` text NOT NULL,
  `employer_four` varchar(222) NOT NULL,
  `position_four` varchar(222) NOT NULL,
  `date_start_four` varchar(222) NOT NULL,
  `date_end_four` varchar(222) NOT NULL,
  `employer_five` varchar(222) NOT NULL,
  `position_five` varchar(222) NOT NULL,
  `date_start_five` varchar(222) NOT NULL,
  `date_end_five` varchar(222) NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO emp_history_tb VALUES("3","MART","CHESCO","IT","02/01/2022","02/24/2022","ZESCO","IT","11/03/2021","02/27/2022","ZAMTEL","IT","02/01/2022","02/25/2022","","","","","","","","","Pending");



CREATE TABLE `emp_info` (
  `id` int(90) NOT NULL AUTO_INCREMENT,
  `empno` varchar(90) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `init` varchar(1) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `bdate` date NOT NULL,
  `dept` varchar(30) NOT NULL,
  `position` varchar(45) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `personal_email` varchar(222) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `account` text NOT NULL,
  `date_joined` date NOT NULL,
  `date_left` text NOT NULL,
  `employee_grade` varchar(20) NOT NULL,
  `marital_status` varchar(10) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `leave_days` int(90) NOT NULL,
  `company_id` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `basic_pay` int(12) NOT NULL,
  `gross_pay` text NOT NULL,
  `nok_phone` varchar(222) NOT NULL,
  `nok_name` varchar(222) NOT NULL,
  `nok_relationship` varchar(222) NOT NULL,
  `nok_email` varchar(222) NOT NULL,
  `nok_address` varchar(222) NOT NULL,
  `NRC` text NOT NULL,
  `employment_type` text NOT NULL,
  `probation_deadline` text NOT NULL,
  `status` text NOT NULL,
  `employee_type` text NOT NULL,
  `social` text NOT NULL,
  `branch_code` text NOT NULL,
  `has_gratuity` text NOT NULL,
  `gatuity_amount` text NOT NULL,
  `leaveworkflow_id` int(12) NOT NULL,
  `nrc_file` text NOT NULL,
  `next_kin_phone` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=300 DEFAULT CHARSET=latin1;

INSERT INTO emp_info VALUES("299","MART","unnamed (1).png","mwenda","martin"," ","male","1998-02-28","37","    IT","+26097680981","LUSAKA","martin@chesco-tech.com","","First Alliance Bank","1701122001004","2022-02-02","2022-02-02","2","Married","BANK","0","4","bcbe3365e6ac95ea2c0343a2395834dd","5000","5000","Internship","brother","phir4i@gmail.com","MAKENI","09867657867","666666/10/1","MIKE","","","Full Time","    5746","001","--Is Employee Eligible for Gratuity ?--","","1","future-tech-main-1488909020.jpg","");
INSERT INTO emp_info VALUES("297","JIM01","unnamed.png","TEMBO","JIMMY"," ","male","1991-10-28","37","SUPERVISOR","260977655040","LUSAKA","JIMMY@GMAIL.COM","","First Alliance Bank","0010001368004343","2021-10-06","1970-01-01","2","Married","BANK","0","4","698d51a19d8a121ce581499d7b701668","5000","5000","Permanent","parent","james@gmail.com","MAKENI","0986765","9258664/11/1","james","","","Full Time","343344","001","--Is Employee Eligible for Gratuity ?--","","0","","");
INSERT INTO emp_info VALUES("298","LMP02","Interviewing-730x410.jpg","Phiri","Joseph"," ","male","2007-10-28","36","VISA/IT OFFICER","+26097680981","Farm 873A Kasupe Road ,Barlastone","josephp@fabank.co.zm","","First Alliance Bank","001368001","2019-07-28","1970-01-01","3","Married","BANK","0","4","310dcbbf4cce62f762a2aaa148d556bd","3000","3000","Permanent","brother","phiri@gmail.com","lusaKA","0986765657","70056046/11/1","phiri","","","Full Time","5657474","001","--Is Employee Eligible for Gratuity ?--","","0","","");



CREATE TABLE `employee` (
  `id` int(90) NOT NULL AUTO_INCREMENT,
  `empno` varchar(100) NOT NULL,
  `pay` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `dayswork` int(10) unsigned NOT NULL DEFAULT '0',
  `otrate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `othrs` int(10) unsigned NOT NULL DEFAULT '0',
  `allow` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `advances` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `insurance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `time` date NOT NULL,
  `comission` decimal(10,0) NOT NULL,
  `company_id` varchar(20) NOT NULL,
  `health_insurance` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

INSERT INTO employee VALUES("52","MART","5000.00","26","0.00","0","0.00","0.00","0.00","2022-03-31","0","4","50");
INSERT INTO employee VALUES("51","LMP02","3000.00","26","0.00","0","0.00","0.00","0.00","2022-02-28","0","4","30");
INSERT INTO employee VALUES("50","LMP01","5000.00","26","0.00","0","0.00","0.00","0.00","2022-02-28","0","4","50");



CREATE TABLE `employee_discplinary_records` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `empno` text NOT NULL,
  `date_charged` text NOT NULL,
  `charged_til` varchar(50) NOT NULL,
  `offence_commited` text NOT NULL,
  `case_status` text NOT NULL,
  `close_date` text NOT NULL,
  `punishment` text NOT NULL,
  `charged_by` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `employee_exits_tb` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `empno` text NOT NULL,
  `reason_for_exit` text NOT NULL,
  `date_of_exit` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `grade` (
  `grade_id` int(10) NOT NULL AUTO_INCREMENT,
  `grade` varchar(10) NOT NULL,
  `maximum` int(20) NOT NULL,
  `minimum` int(20) NOT NULL,
  `company_ID` varchar(20) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO grade VALUES("3","1","7999","3000","4");
INSERT INTO grade VALUES("4","2","2999","2000","4");
INSERT INTO grade VALUES("5","3","1999","1000","4");



CREATE TABLE `gratuity_settings_tb` (
  `grat_id` int(12) NOT NULL AUTO_INCREMENT,
  `rating` text NOT NULL,
  PRIMARY KEY (`grat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO gratuity_settings_tb VALUES("1","25");



CREATE TABLE `hod_tb` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `empno` text NOT NULL,
  `departmentId` text NOT NULL,
  `companyID` int(12) NOT NULL,
  `parent_supervisor` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO hod_tb VALUES("1","MART","35","4","LMP02");



CREATE TABLE `holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  `date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO holidays VALUES("4","New Year","*-01-01");
INSERT INTO holidays VALUES("5","International Womens Day","*-03-08");
INSERT INTO holidays VALUES("6","Youth Day","*-03-12");
INSERT INTO holidays VALUES("7","Good Friday","2022-02-22");
INSERT INTO holidays VALUES("8","Easter Monday","*-04-18");
INSERT INTO holidays VALUES("9","Labour Day","*-05-01");
INSERT INTO holidays VALUES("10","African Freedom Day","*-05-25");
INSERT INTO holidays VALUES("11","Heroes Day","*-07-04");
INSERT INTO holidays VALUES("12","Unity Day","*-07-05");
INSERT INTO holidays VALUES("13","Farmers Day","*-08-01");
INSERT INTO holidays VALUES("14","National Day of Prayer","*-10-18");
INSERT INTO holidays VALUES("15","Independence Day","*-10-24");
INSERT INTO holidays VALUES("16","Christmas Day","*-12-25");



CREATE TABLE `leave_application_levels` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `application_id` int(12) NOT NULL,
  `emp_no` text NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `leave_applications_tb` (
  `application_id` int(12) NOT NULL AUTO_INCREMENT,
  `leave_start_date` date NOT NULL,
  `leave_end_date` date NOT NULL,
  `leave_type` text NOT NULL,
  `reason_leave` text NOT NULL,
  `empno` text NOT NULL,
  `status` text NOT NULL,
  `contact` text NOT NULL,
  `contact_person` text NOT NULL,
  `address_on_leave` text NOT NULL,
  `file_proof` text NOT NULL,
  `parent_supervisor_notified` text NOT NULL,
  `application_date` text NOT NULL,
  `level` int(12) NOT NULL,
  `days` text NOT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO leave_applications_tb VALUES("3","2022-03-01","2022-03-30","Casual Leave","test
","MART","Approved","0000","mrs phiri","lusaka","","","2022-03-01","1","24");



CREATE TABLE `leave_days` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `available` int(90) DEFAULT NULL,
  `empno` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

INSERT INTO leave_days VALUES("1","22","LMP02");
INSERT INTO leave_days VALUES("4","22","LMP01");
INSERT INTO leave_days VALUES("33","-2","MART");
INSERT INTO leave_days VALUES("34","2","");



CREATE TABLE `leave_ratings_tb` (
  `grade_id` int(11) NOT NULL,
  `monthly_leave_days` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyID` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO leave_ratings_tb VALUES("1","2","4","4");
INSERT INTO leave_ratings_tb VALUES("2","2","5","4");
INSERT INTO leave_ratings_tb VALUES("3","2","6","4");



CREATE TABLE `leave_tb` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `leave_type` text NOT NULL,
  `max_leave_days` int(11) NOT NULL,
  `companyID` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO leave_tb VALUES("3","Maternity Leave","90","4");
INSERT INTO leave_tb VALUES("5","Casual Leave","10","4");
INSERT INTO leave_tb VALUES("6","Compassionate Leave","10","4");
INSERT INTO leave_tb VALUES("7","Study Leave","0","4");
INSERT INTO leave_tb VALUES("9","Sick Leave","12","4");
INSERT INTO leave_tb VALUES("12","Annual Leave","12","4");



CREATE TABLE `loan` (
  `LOAN_NO` int(6) NOT NULL AUTO_INCREMENT,
  `empno` varchar(90) NOT NULL,
  `loan_amt` int(200) NOT NULL,
  `monthly_deduct` text NOT NULL,
  `duration` int(200) NOT NULL,
  `company_ID` varchar(20) NOT NULL,
  `principle` int(20) NOT NULL,
  `interest_rate` float NOT NULL,
  `interest` int(20) NOT NULL,
  `loan_date` text NOT NULL,
  `date_completion` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`LOAN_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `nhima_tb` (
  `nhima_id` int(12) NOT NULL AUTO_INCREMENT,
  `amount` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` text NOT NULL,
  PRIMARY KEY (`nhima_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO nhima_tb VALUES("1","1","2021-01-28 15:16:45","Active");



CREATE TABLE `overtime` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `hours` int(90) DEFAULT NULL,
  `rate` int(90) DEFAULT NULL,
  `h_rate` int(90) DEFAULT NULL,
  `empno` int(90) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `payslip_uploads` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `empno` text NOT NULL,
  `payslip` text NOT NULL,
  `date_period` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `postings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(222) NOT NULL,
  `dep_id` int(11) NOT NULL,
  `vacancies` int(50) NOT NULL,
  `type` varchar(222) NOT NULL,
  `experience` varchar(222) NOT NULL,
  `salary` varchar(222) NOT NULL,
  `info` text NOT NULL,
  `qualifications` text NOT NULL,
  `status` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO postings VALUES("3","Software developer","35","1","Contract","3","NA","test Job","Degree Computer Science","Unpublished","2022-02-01 00:00:00","2022-02-28");



CREATE TABLE `prefix` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `prefix` varchar(20) NOT NULL,
  `company_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO prefix VALUES("1","LMP","4");



CREATE TABLE `sms_credits_tb` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `credit_balance` text NOT NULL,
  `company_id` int(12) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `tax` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `taxable_to_date` text,
  `tax_paid_to_date` text,
  `empno` text,
  `company_id` varchar(11) NOT NULL,
  `social` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;




CREATE TABLE `tax_bands` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `band_top1` text NOT NULL,
  `band_top2` text NOT NULL,
  `band_top3` text NOT NULL,
  `band_rate1` text NOT NULL,
  `band_rate2` text NOT NULL,
  `band_rate3` text NOT NULL,
  `band_rate4` text NOT NULL,
  `company_ID` varchar(20) NOT NULL,
  `napsa_ceiling` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO tax_bands VALUES("3","4001","4801","6901","1","251","301","37.51","4","1221.80");



CREATE TABLE `users_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` text NOT NULL,
  `password` text NOT NULL,
  `company_id` int(11) NOT NULL,
  `empno` text NOT NULL,
  `user_type` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email_address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

INSERT INTO users_tb VALUES("1","superadmin","21232f297a57a5a743894a0e4a801fc3","4","","superadmin","Choolwe","Ngandu","choolwe@crystaline.co.zm");
INSERT INTO users_tb VALUES("10","admin","21232f297a57a5a743894a0e4a801fc3","4","","HR Admin","Isabella","Mulima","choolwe1992@gmail.com");
INSERT INTO users_tb VALUES("16","adminlso","21232f297a57a5a743894a0e4a801fc3","5","","admin","Ngandu","Choolwe","choolwe1992@gmail.com");
INSERT INTO users_tb VALUES("20","admin@corp.com","21232f297a57a5a743894a0e4a801fc3","9","PSC01","HR Admin","Chilonda","Chilonda"," officemanager@psccorporatepark.com");
INSERT INTO users_tb VALUES("21","admin@ranch.com","21232f297a57a5a743894a0e4a801fc3","10","","HR Admin","Chilonda","Chilonda","reception4@psccorporatepark.com");
INSERT INTO users_tb VALUES("22","admin@corpmanager.com","21232f297a57a5a743894a0e4a801fc3","9","","HR Admin","Chilonda","Chilonda"," officemanager@psccorporatepark.com");
INSERT INTO users_tb VALUES("23","admin@ranchmanager.com","21232f297a57a5a743894a0e4a801fc3","10","","HR Admin","Chilonda","Chilonda","reception4@psccorporatepark.com");



CREATE TABLE `workflows` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO workflows VALUES("1","Information Technology");

