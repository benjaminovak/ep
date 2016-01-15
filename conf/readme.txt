1. Gesla za uvoz certifikatov: ep (za vse certifikate)
2. Uporabniška imena in gesla za administratorja, prodajalce in stranke:
+ administrator:
	- admin - admin
+ prodajalec
	- beni	- benjamin
	- naum	- naum
+ stranka
	- test  - testtest
	- ep    - epepep

3. Dodatni koraki,ki so potrebni, da se implementacije zažene:
- Certifikati:
	 + Iz mape certifikati datoteke epca-cacert.pem, epca-crl.pem, webmaster@localhost-cert.pem
	   ter webmaster@localhost-key.pem premaknemo v mapo /etc/apache2/ssl
	 + Iz varnostnih razlogov je dobro, da dostop do ustvarjene datoteke omejimo zgolj na uporabnika root:
	   - sudo chmod go-rwx epca-cacert.pem
	 + Certifikat agencije epca uvozimo v brskalnik kot zaupanja vredno entiteto za identifikacijo
	   spletnih strani. Uvozimo tudi vse ostale certifikate.
	 + sudo a2ensite default-ssl.conf, sudo service apache2 restart
- Knjižnice:
	+ sudo pear upgrade -Z pear/Archive_Tar
	+ sudo pear install HTML_QuickForm2_Captcha-0.1.2
	+ sudo pear install Services_ReCaptcha
	+ sudo apt-get install sendmail
	+ sudo sendmailconfig
	+ sprememba php.ini datoteke v direktoriju /etc/php5/apache2 -> 
		-> dodajanje vrstice: sendmail_path = /usr/sbin/sendmail -t -i
