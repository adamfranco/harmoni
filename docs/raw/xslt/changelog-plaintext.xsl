<?xml version="1.0" encoding="ISO-8859-1"?>
<!-- 
 @package harmoni.docs
 @copyright Copyright &copy; 2005, Middlebury College
 @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 @version $Id: changelog-plaintext.xsl,v 1.2 2005/04/07 16:33:50 adamfranco Exp $
 -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output format="text" />
<xsl:strip-space elements="fix change new important" />

<!--
///////////////////////////////////////////////////////////////////////
// changelog
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="changelog">
Name: <xsl:value-of select="@name" />
<xsl:text>

</xsl:text>
	<xsl:for-each select="version">
v. <xsl:value-of select="@number" /><xsl:if test="@date!=''"> (<xsl:value-of select="@date" />)</xsl:if>
----------------------------------------------------<xsl:apply-templates />

	</xsl:for-each>
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// fix
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="fix">
	* Bug Fix: <xsl:call-template name="entry" />
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// change
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="change">
	* Change: <xsl:call-template name="entry" />
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// new
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="new">
	* New feature: <xsl:call-template name="entry" />
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// important
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="important">
	**** IMPORTANT *** Change: <xsl:call-template name="entry" />
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// entry
///////////////////////////////////////////////////////////////////////
-->
<xsl:template name="entry">
	<xsl:if test="@ref">#<xsl:value-of select="@ref" /><xsl:text> </xsl:text></xsl:if>
	<xsl:value-of select="normalize-space(translate(.,'&#10;',''))" />
	<xsl:if test="@author">
		<xsl:variable name="short" select="@author"/>
		<xsl:text> (</xsl:text>
		<xsl:value-of select="//authors/name[@short=$short]" />
		<xsl:text>)</xsl:text>
	</xsl:if>
</xsl:template>

</xsl:stylesheet>
