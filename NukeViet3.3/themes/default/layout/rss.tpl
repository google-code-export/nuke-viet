<!-- BEGIN: main --><?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{CHANNEL.title}</title>
        <link><![CDATA[{CHANNEL.link}]]></link>
        <atom:link href="{CHANNEL.atomlink}" rel="self" type="application/rss+xml" />
        <description><![CDATA[{CHANNEL.description}]]></description>
        <language>{CHANNEL.lang}</language>
        <copyright><![CDATA[{CHANNEL.copyright}]]></copyright>
        <docs><![CDATA[{CHANNEL.docs}]]></docs>
        <generator><![CDATA[{CHANNEL.generator}]]></generator>
        <!-- BEGIN: image --><image>
            <url><![CDATA[{IMAGE.src}]]></url>
            <title>{IMAGE.title}</title>
            <link><![CDATA[{IMAGE.link}]]></link>
            <width>{IMAGE.width}</width>
            <height>{IMAGE.height}</height>
        </image>
        <!-- END: image --><!-- BEGIN: item -->
        <item>
            <title>{ITEM.title}</title>
            <link><![CDATA[{ITEM.link}]]></link>
            <guid isPermaLink="false"><![CDATA[{ITEM.guid}]]></guid>
            <description><![CDATA[{ITEM.description}]]></description>
            <pubDate>{ITEM.pubdate}</pubDate>
        </item>
        <!-- END: item -->		
    </channel>
</rss>
<!-- END: main -->