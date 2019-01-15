#!/usr/bin/env bash

ext_name=`find ./ -maxdepth 1 -type f | grep .xml | sed 's/.xml//' | sed 's/.\///'`

mkdir -p $ext_name
for directory in $(find ./ -type d | grep -vE ".git|$ext_name" | sed 's/.\///'); do
    if [ ! -z "$directory" ]; then
        mkdir -p $ext_name/$directory
    fi
done

for file in $(find ./ -type f | grep -E "css$|php$|html$|ini$|xml$|sql$"); do
    cp -r $file $ext_name/$file
done

zip -r $ext_name.zip $ext_name
rm -rf $ext_name