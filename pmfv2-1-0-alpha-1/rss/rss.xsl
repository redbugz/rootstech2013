<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  version="1.0">
  
  <xsl:template match="/">
    <html>
      <head>
        <title><xsl:value-of select="//title" /></title>
        <style type="text/css" media="screen">@import url("/style.css");</style>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      </head>
      <body>
      <h2><xsl:value-of select="//title" /></h2>
                  
      <p><xsl:value-of select="//description" /></p>
	<p>RSS Feed For: <a href="#"><xsl:value-of select="//link" /></a></p>
      <h3 class="two fulltext">Recent items</h3>
      <ol>
         <xsl:apply-templates select="//item"/>
      </ol>
      </body>
    </html>
  </xsl:template>


  <xsl:template match="item">
    <li>
        <a href="{link}"><xsl:apply-templates select="title" /></a>
    </li>
  </xsl:template>


</xsl:stylesheet>
