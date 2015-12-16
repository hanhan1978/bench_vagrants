apt-get update
apt-get install software-properties-common -y
apt-add-repository ppa:ansible/ansible
apt-get update
apt-get install ansible -y

cd /vagrant
ansible-playbook playbook.yml