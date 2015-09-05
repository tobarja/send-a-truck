#!/bin/bash
cp /vagrant/provision/my.cnf /root/.my.cnf
cp /vagrant/provision/my.cnf /home/vagrant/.my.cnf

mysql -e 'drop database sendatruck;'
mysql -e 'create database sendatruck;'

/vagrant/provision/db_reload.sh
