#!/bin/sh

xsltproc ../xslt/changelog-simplehtml.xsl changelog.xml > changelog.html
xsltproc ../xslt/changelog-plaintext.xsl changelog.xml > changelog.txt

