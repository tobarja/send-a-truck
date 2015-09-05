#!/bin/bash
mysqldump --compact --skip-extended-insert --add-drop-table sendatruck > /vagrant/provision/database.sql
