<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = $this->UserInfo->getUserInfo(LOGGED_ID);

if((LOGGED_IN) && ($user['right'] == 1)) {
echo'<p class="text text-success">Page rendered in <strong>{elapsed_time}</strong> seconds!';
}
?>


<script>
  AOS.init();
</script>
<script src="/assets/js/library.js"></script>
</body>
</html>