mysql -e 'drop database sendatruck;'
mysql -e 'create database sendatruck;'
mysql sendatruck < /vagrant/provision/database.sql
