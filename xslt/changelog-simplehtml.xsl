<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!--
///////////////////////////////////////////////////////////////////////
// changelog
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="changelog">
    <div style="font-family: Verdana; font-size: 12px;">
        <b><xsl:value-of select="@name" /></b><br /><br />
        
        
        <xsl:for-each select="version">
        v. <xsl:value-of select="@number" /><xsl:if test="@date!=''"> (<xsl:value-of select="@date" />)</xsl:if><br />
        <hr />
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
	<xsl:if test="@ref">
		view log: 
		<a>
			<xsl:attribute name="href">
				http://sourceforge.net/tracker/index.php?func=detail&amp;aid=<xsl:value-of select="@ref" />&amp;group_id=82171&amp;atid=565234
			</xsl:attribute>
			<xsl:value-of select="@ref" />
		</a>
	</xsl:if>
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// change
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="change">
	<li /> Change: <xsl:call-template name="entry" />
	<xsl:if test="@ref">
		view log: 
		<a>
			<xsl:attribute name="href">
				http://sourceforge.net/tracker/index.php?func=detail&amp;aid=<xsl:value-of select="@ref" />&amp;group_id=82171&amp;atid=565234
			</xsl:attribute>
			<xsl:value-of select="@ref" />
		</a>
	</xsl:if>
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// new
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="new">
	<li /> New feature: <xsl:call-template name="entry" />
	<xsl:if test="@ref">
		view log: 
		<a>
			<xsl:attribute name="href">
				http://sourceforge.net/tracker/index.php?func=detail&amp;aid=<xsl:value-of select="@ref" />&amp;group_id=82171&amp;atid=565237
			</xsl:attribute>
			<xsl:value-of select="@ref" />
		</a>
	</xsl:if>
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// important
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="important">
	<li /> <span style='color: red'>*** IMPORTANT ***</span> Change: <xsl:call-template name="entry" />
	<xsl:if test="@ref">
		view log: 
		<a>
			<xsl:attribute name="href">
				http://sourceforge.net/tracker/index.php?func=detail&amp;aid=<xsl:value-of select="@ref" />&amp;group_id=82171&amp;atid=565237
			</xsl:attribute>
			<xsl:value-of select="@ref" />
		</a>
	</xsl:if>
</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// entry
///////////////////////////////////////////////////////////////////////
-->
<xsl:template name="entry">
	<xsl:value-of select="." />
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
