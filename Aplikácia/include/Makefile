all:	sha1sums.php

sha1sums.php: ../script/main.js.sha1 ../style/main.css.sha1
	{ echo "<?php \$$sha1sums = array("; \
	  cat $^ | sed 's/^\([0-9a-f]*\)\s*\(.*\/\)\?\(.*\)/\t"\3" => "\1",/'; \
	  echo ");"; } > '$@'

%.sha1: %
	sha1sum '$<' > '$@'
