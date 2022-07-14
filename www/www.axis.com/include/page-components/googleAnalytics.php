<?php
$primary_contact_id = $session->getPrimaryContactId();
$googleAnalystical = <<<GoogleAnalaytic
 <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126116000-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('set', {'user_id': "$primary_contact_id"});
  gtag('config', 'UA-126116000-1');
</script>
GoogleAnalaytic;
?>
