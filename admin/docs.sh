#! /bin/bash 
###########################################
#
###########################################

# constants
baseDir=$(cd `dirname "$0"`;pwd)
# functions

# main 
[ -z "${BASH_SOURCE[0]}" -o "${BASH_SOURCE[0]}" = "$0" ] || return
cd $baseDir/..
if [ -d docs ]; then
    rm -rf docs
fi
$baseDir/../vendor/bin/phpdoc -d ./src -t ./docs --template="clean"
