#!/usr/bin/env bash

if [ -z "$1" ]
  then
  echo "- No version is given. Use as ./release.sh 1.0.0";
  exit 1
fi

echo "- Clean up SVN";
rm -rf fetchwitter

echo "- Checkout from SVN remote";
svn co http://plugins.svn.wordpress.org/fetchwitter/ svn

echo "- Clean up SVN trunk";
rm -rf fetchwitter/trunk/*

echo "- Copy latest code to SVN trunk";
cp -r inc lib *.php *.md *.txt fetchwitter/trunk/
svn add fetchwitter/trunk/*

echo "- Create new SVN tag";
svn cp fetchwitter/trunk "fetchwitter/tags/$1"

echo "- Release to SVN remote";
cd fetchwitter/
svn ci -m "Release version $1" --username jabranr
