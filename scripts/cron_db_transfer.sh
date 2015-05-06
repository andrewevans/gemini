#!/bin/bash
echo "starting DB transfer..."
sudo ./calder_db_backup.sh && sudo ./gemini_db_backup.sh && sudo ./gemini_db_import.sh

