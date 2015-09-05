# Send A Truck

## Vagrant
This repo uses Vagrant for easy setup of a development environment.
Install Virtualbox and Vagrant, if you do not already have them.

### Basic Vagrant Commands
* Use `vagrant up` to start the virtual machine.
* Use `vagrant halt` to shut down the virtual machine.
* If you break your virtual machine, run `vagrant destroy` to remove it, and then `vagrant up` to recreate it.

After you have started the virtual machine, you can browse the site at: (http://192.168.25.2/).

### Other Useful commands
* `vagrant ssh -c 'composer -d=/var/www install'` Run this if the composer.json file changes.
* `vagrant ssh -c 'sudo tail -f /vagrant/logs/error.log'` Run this to see Apache/PHP errors in real time. Press `Ctrl-C` to stop.
