#!/bin/bash
echo "starting gemini backup"
mysqldump --user=harmony --password=makeitrain -h localhost gemini artists artworks artworks_descriptions > gemini_artists_artworks_artworksdescriptions.sql 
echo "gemini backup complete"

