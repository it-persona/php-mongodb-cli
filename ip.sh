#!/usr/bin/env bash

# find all these tokens variables
base_url_token="{{ base_url }}"
host_ip_token="{{ host_ip }}"

# replace with public url & host ip
base_url="mongocli"
host_ip="";
#host_ip=$(ifconfig | sed -En 's/127.0.0.1//;s/.*inet (addr:)?(([0-9]*\.){3}[0-9]*).*/\2/p' | awk '{print $NF;exit}');

if [[ -z ${host_ip} ]]; then
    host_ip=$(ip route get 1 | awk '{print $NF;exit}');
fi

# output
# ------
echo ${base_url_token} = ${base_url}
echo ${host_ip_token} = ${host_ip}

# process find & replace
# ----------------------
sed -e "s/${base_url_token}/${base_url}/g" \
    -e "s/${host_ip_token}/${host_ip}/g" \
    < docker-compose.tmpl \
    > docker-compose.yml

sudo sed -i "4i ${host_ip}    ${base_url}" /etc/hosts
