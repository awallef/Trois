<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <?php foreach( $data as $row ){ ?>
	   <url>
	   		<loc><?php echo FULL_BASE_URL . $this->Html->url($row['loc']); ?></loc>
	   		<lastmod><?php echo (!empty($row['lastmod']))? $row['lastmod']: Date('Y-m-d', mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")) ); ?></lastmod>
	   		<changefreq><?php echo (!empty($row['changefreq']))? $row['changefreq']: 'monthly'; ?></changefreq>
	   		<priority><?php echo (!empty($row['priority']))? $row['priority']: 0.5; ?></priority>
	   </url>
   <?php } ?>   
</urlset> 
