#!/bin/sh

#  @package harmoni.docs
#
#  @copyright Copyright &copy; 2005, Middlebury College
#  @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
#
#  @version $Id: generate.sh,v 1.3 2005/04/07 16:33:49 adamfranco Exp $

xsltproc ../xslt/changelog-simplehtml.xsl changelog.xml | sed -e 's/<?xml.*?>//' > ../../changelog.html
xsltproc ../xslt/changelog-plaintext.xsl changelog.xml | sed -e 's/<?xml.*?>//' > ../../changelog.txt

