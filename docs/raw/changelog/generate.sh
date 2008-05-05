#!/bin/sh

#  @package concerto.docs
#  
#  @copyright Copyright &copy; 2005, Middlebury College
#  @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
#  
#  @version $Id: generate.sh,v 1.5 2007/10/09 18:39:03 adamfranco Exp $

progdir=`dirname $0`
cd $progdir

xsltproc ../xslt/changelog-simplehtml.xsl changelog.xml | sed -e 's/<?xml.*?>//' > ../../changelog.html
xsltproc ../xslt/changelog-plaintext.xsl changelog.xml | sed -e 's/<?xml.*?>//' > ../../changelog.txt
xsltproc ../xslt/releaseNotes-plaintext.xsl changelog.xml | sed -e 's/<?xml.*?>//' > ../../release_notes.txt

