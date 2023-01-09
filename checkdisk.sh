#!/bin/bash

# Script for checking disk usage with threshold and report to telegram

TOKEN="xxxxxxxxxxxxxxxx"
CHATID="-xxxxxxxxxxxxxx"
THRESHOLD=90
DATE=$(date "+%d-%m-%Y %H:%M")

df -PkH | grep -vE '^Filesystem|tmpfs|cdrom|media' | awk '{ print $5 " " $6 }' | while read output;
do
  usep=$(echo $output | awk '{ print $1}' | cut -d'%' -f1 )
  partition=$(echo $output | awk '{print $2}' )
  if [[ $usep -ge $THRESHOLD ]]; then
    MESSAGE="🚨 Superado el $THRESHOLD% de uso en \"$partition ($usep%)\" en $(hostname) : $DATE" 
    URL="https://api.telegram.org/bot$TOKEN/sendMessage?chat_id=$CHATID&text=$MESSAGE"
    curl -s --data "text=$MESSAGE" --data "chat_id=$CHATID" https://api.telegram.org/bot$TOKEN/sendMessage

 fi
done
