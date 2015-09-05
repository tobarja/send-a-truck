# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.network "private_network", ip: "192.168.25.2"
  config.vm.hostname = "ubuntu"
  config.vm.provision :shell, :path => "provision/bootstrap.sh"
  config.vm.synced_folder ".", "/var/www/site"
  config.vm.synced_folder ".", "/vagrant"
end
