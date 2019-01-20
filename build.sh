#!/usr/bin/env bash

ext_path=`pwd`
ext_name=`find ./ -maxdepth 1 -type f | grep .xml | sed 's/.xml//' | sed 's/.\///'`
version="1.7.0"

echo "**********************"
echo "Building: "$ext_name
echo "Version: "$version
echo "**********************"
echo "Path: "$ext_path
echo "**********************"

echo "Cleaning..."
cd $ext_path
rm -rf $ext_path/_builds $ext_path/_builds/$ext_name
mkdir -p $ext_path/_builds $ext_path/_builds/$ext_name

echo "Building directories..."
for directory in $(find ./ -type d | grep -vE ".git|_builds|.idea|LICENSE|.md$" | sed 's/.\///'); do
    if [ ! -z "$directory" ]; then
        mkdir -p $ext_path/_builds/$ext_name/$directory
    fi
done

echo "Copying files..."
for file in $(find ./ -type f | grep -vE ".git|_builds|.idea|.sh$|LICENSE|.md$"); do
    cp -r $file $ext_path/_builds/$ext_name/$file
done

perl -pi -e 's/VERSION/'$version'/g' $ext_path/_builds/$ext_name/$ext_name.xml

echo "Building zip package..."
cd $ext_path/_builds
zip -rq $ext_path/_builds/$ext_name.zip $ext_name
rm -rf $ext_path/_builds/$ext_name

echo "Done!"