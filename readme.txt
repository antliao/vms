Install VMS in Ubuntu16.04
1. apt-get install mysql-server
2. enble https for apache2
	a. https://www.server-world.info/en/note?os=Ubuntu_16.04&p=httpd&f=8
	b. 
		1. vi /etc/apache2/sites-available/default-ssl.conf
			# line 3: change admin email
			ServerAdmin webmaster@srv.world
			# line 32,33: change to the one created above
			SSLCertificateFile /etc/ssl/private/server.crt
			SSLCertificateKeyFile /etc/ssl/private/server.key
		2. a2ensite default-ssl 
			
		3. a2enmod ssl 
		4. service apache2 restart

3. create table 'vms_db_tables.sql'
4. create user account(direct insert in mysql)
5. Warning!!! This initiation step only can be run that all the tables are just
   created.
   login vms and run vms_init.php to insert default data


20181103
1. class table, location table. for example, 台北 39 期
2. edit apache config to disable port 80
