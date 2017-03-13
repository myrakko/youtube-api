#!/bin/bash

cat1=$(cat $1)
sed "1d" $1 > $1.2
cat2=$(cat $1.2)

# for i in $cat2
# do
# #echo $i
# youtube-dl -f mp4 $i

# done
