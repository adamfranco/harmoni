#!/bin/sh

xsltproc ../xslt/changelog-simplehtml.xsl changelog.xml | sed -e 's/<?xml.*?>//' > ../../changelog.html
xsltproc ../xslt/changelog-plaintext.xsl changelog.xml | sed -e 's/<?xml.*?>//' > ../../changelog.txt

