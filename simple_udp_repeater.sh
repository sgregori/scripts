#!/bin/bash

echo "# SGREGORI SIMPLE UDP REPEATER: "

# uncomment the INTERACTIVE MODE or STANDALONE MODE:

# INTERACTIVE MODE:
# read -p 'Puerto UDP - ORIGEN: ' PUERTOORIGEN
# read -p 'Puerto UDP - DESTINO: ' PUERTODESTINO
# read -p 'IP DESTINO 1: ' IPDESTINO1
# read -p 'IP DESTINO 2: ' IPDESTINO2

# STANDALONE MODE:
# PUERTODESTINO="4444"
# PUERTOORIGEN="1111"
# IPDESTINO1="192.168.1.191"
# IPDESTINO2="127.0.0.1"

killall nc ; killall tail; echo " " > /tmp/temporal.txt

sleep 1

nc -u -l -k -p $PUERTOORIGEN >> /tmp/temporal.txt &

sleep 1

tail -f /tmp/temporal.txt | nc -u $IPDESTINO1 $PUERTODESTINO &

tail -f /tmp/temporal.txt | nc -u $IPDESTINO2 $PUERTODESTINO &

echo "# MENSAJES #"

tail -f /tmp/temporal.txt
