<div class="adr">
<p class="street-address">
<?php print implode('<br />', array_filter(array(
    $address['thoroughfare'] . ', ' . $address['premise'],
    $address['sub_premise'],
    $address['dependent_locality'],
  )));
?>
</p>
<p>
<span class="locality"><?php print $address['locality'] ?></span>
<span class="administrative_area"><?php print $address['administrative_area'] ?></span>
<span class="postal-code"><?php print $address['postal_code'] ?></span>
</p>
<p><span class="country"><?php print $address['country'] ?></span></p>
</div>
