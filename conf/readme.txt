1. Gesla za uvoz certifikatov: ep (za vse certifikate)
2. Uporabniška imena in gesla za administratorja, prodajalce in stranke:
3. Dodatni koraki,ki so potrebni, da se implementacije zažene:
- Certifikati:
	 + Iz mape certifikati datoteke epca-cacert.pem, epca-crl.pem, webmaster@localhost-cert.pem
	   ter webmaster@localhost-key.pem premaknemo v mapo /etc/apache2/ssl
	 + Iz varnostnih razlogov je dobro, da dostop do ustvarjene datoteke omejimo zgolj na uporabnika root:
	   - sudo chmod go-rwx epca-cacert.pem
	 + Certifikat agencije epca uvozimo v brskalnik kot zaupanja vredno entiteto za identifikacijo
	   spletnih strani. Uvozimo tudi vse ostale certifikate.
	 + sudo a2ensite default-ssl.conf, sudo service apache2 restart
	 + 