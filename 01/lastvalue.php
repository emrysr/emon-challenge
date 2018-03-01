<?php
/**
 * get the feed as plain text and output it without any modification
 */
echo file_get_contents('http://emoncms.org/feed/aget.json?id=166913');