#!/bin/bash

for f in $1/*; do ./generate.pl $f osid.`basename $f .tokens.txt` > $2/`basename $f .tokens.txt`.interface.php; done
