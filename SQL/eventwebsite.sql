# eventwebsite.sql

# student 
CREATE TABLE student(
	s_id int(11) NOT NULL AUTO_INCREMENT,
	s_fname varchar(30) NOT NULL,
	s_lname varchar(30) NOT NULL,
	s_uname varchar(30),
	s_pw varchar(20),
	s_email varchar(30),
	u_id int(11) NOT NULL,
	PRIMARY KEY (s_id),
	FOREIGN KEY (u_id) REFERENCES university(u_id) ON DELETE CASCADE,
	UNIQUE (s_uname),
	UNIQUE (s_email)
);

# superadmin
CREATE TABLE superadmin(
	s_id int(11) NOT NULL,
	PRIMARY KEY (s_id),
	FOREIGN KEY (s_id) REFERENCES student(s_id) ON DELETE CASCADE
);

# admin 
CREATE TABLE admin(
	s_id int(11) NOT NULL,
	PRIMARY KEY (s_id),
	FOREIGN KEY (s_id) REFERENCES student(s_id) ON DELETE CASCADE
);

# university
# TODO: create trigger to update u_numstud whenever new student is created
# may change to DEFAULT 0 later
CREATE TABLE university(
	u_id int(11) NOT NULL AUTO_INCREMENT,
	u_name varchar(30) NOT NULL,
	u_numstud int(11) NOT NULL DEFAULT 0 , 
	u_location varchar(50),
	u_description varchar(255),
	u_emaildomain varchar(20) NOT NULL,
	PRIMARY KEY (u_id),
	UNIQUE (u_emaildomain)
);

# su_affliation (student-university)
CREATE TABLE su_affiliation(
	s_id int(11) NOT NULL,
	u_id int(11) NOT NULL,
	PRIMARY KEY (s_id),
	FOREIGN KEY (s_id) REFERENCES student(s_id) ON DELETE CASCADE,
	FOREIGN KEY (u_id) REFERENCES university(u_id) ON DELETE CASCADE
);

# rso
CREATE TABLE rso(
	r_id int(11) NOT NULL AUTO_INCREMENT,
	r_name varchar(50) NOT NULL,
	r_location varchar(50) NOT NULL,
	r_description varchar(255),
	owner_id int(11) NOT NULL,
	PRIMARY KEY (r_id),
	FOREIGN KEY (owner_id) REFERENCES admin(s_id) ON DELETE CASCADE
);

# rso_member
CREATE TABLE rso_member(
	s_id int(11),
	r_id int(11) NOT NULL,
	PRIMARY KEY (s_id,r_id),
	FOREIGN KEY (s_id) REFERENCES student(s_id) ON DELETE CASCADE,
	FOREIGN KEY (r_id) REFERENCES rso(r_id) ON DELETE CASCADE
);

# event
CREATE TABLE event(
	e_id int(11) NOT NULL AUTO_INCREMENT,
	e_name varchar(50) NOT NULL,
	e_description varchar(255),
	e_phone varchar(20),
	e_email varchar(50),
	e_public boolean,
	e_private boolean,
	e_rso int(11),
	s_id int(11) NOT NULL,
	PRIMARY KEY (e_id),
	FOREIGN KEY (s_id) REFERENCES admin(s_id) ON DELETE CASCADE
);

# location
CREATE TABLE location(
	l_id int(11) NOT NULL AUTO_INCREMENT,
	l_name varchar(50) NOT NULL,
	l_longitude varchar(20),
	l_latitude varchar(20),
	PRIMARY KEY (l_id)
);

# event_location
# add constraint to make sure all e_id and l_id tuple is unique for a given time
CREATE TABLE event_location(
	e_id int(11) NOT NULL,
	l_id int(11) NOT NULL,
	time datetime NOT NULL,
	PRIMARY KEY (e_id),
	FOREIGN KEY (l_id) REFERENCES location(l_id) ON DELETE CASCADE,
	FOREIGN KEY (e_id) REFERENCES event(e_id) ON DELETE CASCADE,
	CONSTRAINT loc_time UNIQUE (e_id,l_id,time)
);

# comment
CREATE TABLE comment(
	e_id int(11) NOT NULL,
	s_id int(11) NOT NULL,
	time datetime NOT NULL,
	description varchar(255) NOT NULL,
	PRIMARY KEY (e_id, s_id, time),
	FOREIGN KEY (e_id) REFERENCES event(e_id) ON DELETE CASCADE,
	FOREIGN KEY (s_id) REFERENCES student(s_id) ON DELETE CASCADE
);

# create_rso
# check to make sure at least 5 students with same email domain before creating (front-end check)
# creating student will become admin of the rso

CREATE TABLE create_rso(
	r_id int(11) NOT NULL,
	s_id int(11) NOT NULL,
	PRIMARY KEY (r_id),
	FOREIGN KEY (s_id) REFERENCES student(s_id) ON DELETE CASCADE
);

# join_rso
# add requests to a table and have the appropriate rso admins approve the them
CREATE TABLE join_rso(
	r_id int(11) NOT NULL,
	s_id int(11) NOT NULL,
	is_approved boolean NOT NULL DEFAULT 0,
	PRIMARY KEY (r_id,s_id),
	FOREIGN KEY (r_id) REFERENCES rso(r_id) ON DELETE CASCADE,
	FOREIGN KEY (s_id) REFERENCES student(s_id) ON DELETE CASCADE
);

# approve_pub
# create trigger to add event to events table if is_approved == 1
CREATE TABLE approve_pub(
	e_id int(11) NOT NULL,
	s_id int(11) NOT NULL,
	is_approved boolean NOT NULL DEFAULT 0,
	PRIMARY KEY (e_id,s_id),
	FOREIGN KEY (e_id) REFERENCES event(e_id) ON DELETE CASCADE,
	FOREIGN KEY (s_id) REFERENCES superadmin(s_id) ON DELETE CASCADE
);

# approve_pri
# create trigger to add event to events table if is_approved == 1
# once approved, add private event to events table
CREATE TABLE approve_pri(
	e_id int(11) NOT NULL,
	s_id int(11) NOT NULL,
	is_approved boolean NOT NULL DEFAULT 0,
	PRIMARY KEY (e_id,s_id),
	FOREIGN KEY (e_id) REFERENCES event(e_id) ON DELETE CASCADE,
	FOREIGN KEY (s_id) REFERENCES superadmin(s_id) ON DELETE CASCADE
);


