#!/bin/bash
echo "starting gemini translation"
mysql --user=harmony --password=makeitrain -h localhost gemini <<"EOF"

truncate gemini.artists;
truncate gemini.artworks;
truncate gemini.artworks_descriptions;

INSERT INTO gemini.artworks (`id`, `artist_id`, `price`, `title`, `title_short`, `series`, `series_short`, `medium`, `medium_short`, `edition`, `edition_short`, `after`, `signature`, `condition`, size_img, size_sheet, size_framed, tagline, reference, framing, price_on_req, sold, hidden, onhold) (SELECT id, aId, price, `title`, `title_short`, `series`, `series`, `medium`, `medium_short`, `edition`, `edition_short`, `after`, `signature`, `condition`, imgsize, sheetsize, framedsize, tagline, reference, framing, priceonrequest, sold, hidden, onhold FROM gemini_calder.artworks order by id asc);

INSERT IGNORE INTO gemini.artworks_descriptions (`artwork_id`, `description`) (SELECT id, `description` FROM gemini_calder.artworks order by id asc);

INSERT IGNORE INTO gemini.artists (`id`, `first_name`, `last_name`, `slug`, `year_begin`, `year_end`, `meta_title`, `meta_description`) (SELECT aName, fName, lName, `folderName`, `yearBegin`, `yearEnd`, `metatitle`, `metadesc` FROM gemini_calder.artists order by aName asc);

update gemini.artists set alias = concat(first_name, ' ', last_name);

update gemini.artists set url_slug = concat(lower(replace(alias, ' ', '-')));
exit

echo "gemini translation complete"

EOF

