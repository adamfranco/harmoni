<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!--
///////////////////////////////////////////////////////////////////////
// changelog
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="changelog">
	<b><xsl:value-of select="@name" /></b><br /><br />


<xsl:for-each select="version">
v. <xsl:value-of select="@number" /><xsl:if test="@date!=''"> (<xsl:value-of select="@date" />)</xsl:if><br />
<hr />
<ul>
	<xsl:apply-templates />
</ul>
<br />
</xsl:for-each>

</xsl:template>

<!--
///////////////////////////////////////////////////////////////////////
// fix
///////////////////////////////////////////////////////////////////////
-->
<xsl:template match="fix">
	<li /> Bug Fix: <xsl:call-template name="entry" />
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