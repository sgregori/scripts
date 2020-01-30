# OpenVPN road warrior en contenedor LXC

if ! [ -c /dev/net/tun ]; then
 mkdir -p /dev/net
 mknod -m 666 /dev/net/tun c 10 200
fi

wget https://git.io/vpn1604 -O openvpn-install.sh && bash openvpn-install.sh

# seguir los pasos y a volar
