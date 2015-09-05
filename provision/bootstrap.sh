#!/bin/bash

apt-get update

apt-get install -y mysql-client

echo mysql-server mysql-server/root_password select vagrant | debconf-set-selections
echo mysql-server mysql-server/root_password_again select vagrant | debconf-set-selections

apt-get install -y apache2 mysql-server libapache2-mod-php5 php5-mysql

/vagrant/provision/database.sh

[ -f /home/vagrant/logs ] || mkdir -p /home/vagrant/logs
chown vagrant:vagrant /home/vagrant/logs
cp /vagrant/provision/httpd-sendatruck.conf /etc/apache2/sites-available/
a2ensite httpd-sendatruck
cp /vagrant/provision/vagrant-apache2.conf /etc/apache2/conf-available/
a2enconf vagrant-apache2
a2enmod rewrite
a2dissite 000-default
/etc/init.d/apache2 restart

[ -f /usr/local/bin/composer ] || (curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer)
su -l -c 'composer -d=/var/www/site install' vagrant
