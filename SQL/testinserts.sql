#test inserts
#add rsos
INSERT INTO rso (r_name,r_location,r_description,owner_id) VALUES ("SGA","Student Union","student govt association",6713628);
INSERT INTO rso (r_name,r_location,r_description,owner_id) VALUES ("PHI","Pegasus Ballroom","honors society",6713628);
INSERT INTO rso (r_name,r_location,r_description,owner_id) VALUES ("SEDS","Eng II","student space exploration",6713628);
INSERT INTO rso (r_name,r_location,r_description,owner_id) VALUES ("ALPHA","Harris","Engineering Club",6713628);

#add admins
INSERT INTO admin (s_id) VALUES (6713628);

#add students
INSERT INTO student (s_fname,s_lname,s_uname,s_pw,s_email,u_id);

#add to rso_member table
INSERT INTO rso_member (s_id,r_id) VALUES (6713628,2);
INSERT INTO rso_member (s_id,r_id) VALUES (6713628,3);
INSERT INTO rso_member (s_id,r_id) VALUES (6713628,4);
INSERT INTO rso_member (s_id,r_id) VALUES (6713628,5);
