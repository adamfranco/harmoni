<?xml version="1.0" encoding="ISO-8859-1"?>
<!-- 
 @package harmoni.docs
 @copyright Copyright &copy; 2005, Middlebury College
 @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 @version $Id: changelog-simplehtml.xsl,v 1.2 2005/04/07 16:33:50 adamfranco Exp $
 -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!--
///////////////////////////////////////////////////////////////////////
// changelog
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="changelog">
	<style type="text/css">
	h1, h2 {color: #005;}
	h1 {font-size: 18pt;}
	li {padding-bottom: 3px;}
	</style>
    <div style="font-family: Verdana; font-size: 12px;">
        <h1><xsl:value-of select="@name" /></h1>
        
        
        <xsl:for-each select="version">
        <h2>Version <xsl:value-of select="@number" /></h2>
		<xsl:if test="@date!=''"><h3><xsl:value-of select="@date" /></h3></xsl:if>

        <ul>
        	<xsl:apply-templates />
        </ul>
        <br />
        </xsl:for-each>
    </div>
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// fix
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="fix">
	<li /> Bug Fix:
	<xsl:call-template name="entry" />
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// change
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="change">
	<li /> Change: <xsl:call-template name="entry" />
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// new
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="new">
	<li /> New feature: <xsl:call-template name="entry" />
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// important
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="important">
	<li /> <span style='color: red'>*** IMPORTANT ***</span> Change: <xsl:call-template name="entry" />
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// entry
///////////////////////////////////////////////////////////////////////
-->
<xsl:template name="entry">
	<xsl:if test="@ref">
		<xsl:choose>
			<xsl:when test="@reftype">
				<xsl:variable name="reftype" select="@reftype" />
				<xsl:variable name="trackerid" select="//reftypes/reftype[@name = $reftype]" />
        		<a>
        			<xsl:attribute name="href">
        				http://sourceforge.net/tracker/index.php?func=detail&amp;aid=<xsl:value-of select="@ref" />&amp;group_id=<xsl:value-of select="//groupid" />&amp;atid=<xsl:value-of select="$trackerid" />
        			</xsl:attribute>
        			#<xsl:value-of select="@ref" />
        		</a>
			</xsl:when>
			<xsl:otherwise>
				#<xsl:value-of select="@ref" />
			</xsl:otherwise>
		</xsl:choose>
	</xsl:if>
	<xsl:text> </xsl:text><xsl:value-of select="." />
	<xsl:if test="@author">
		<xsl:variable name="short" select="@author"/>
		<xsl:text> (</xsl:text>
		<i>
			<xsl:value-of select="//authors/name[@short=$short]" />
		</i>
		<xsl:text>)</xsl:text>
	</xsl:if>
</xsl:template>

</xsl:stylesheet>
