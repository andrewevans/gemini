#!/bin/bash
echo "starting calder backup"
mysqldump --user=calder_mfaport -p -h masterworksfineart.com calder_masterworksnew artists artworks > calder_artists_artworks.sql 
echo "calder backup complete. starting gemini_calder upload"
mysql --user=harmony -p -h localhost gemini_calder < calder_artists_artworks.sql
echo "gemini_calder backup complete"

