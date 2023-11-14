<?php
get_header();
?>

<br>
<br>
<br>
<br>
<br>
<br>
<main>
  test
  <pre><?php var_dump(get_user_meta(24)); ?></pre>
  <?php
  $CSVfp = fopen("https://bandhun.theprogressteam.com/wp-content/uploads/2023/08/Bandhun-CSV-Sheet1-1.csv", "r");
  if ($CSVfp !== FALSE) {
    ?>
    <div class="phppot-container">
      <table class="striped">
        <?php
        $row = 0;
        $meta_name = array();
        $meta_input = array();
        while (!feof($CSVfp)) {
          $data = fgetcsv($CSVfp, 1000, ",");
          if (!empty($data)) {
            if ($row == 0) {
              foreach ($data as $key => $d) {
                if ($d != 'categories') {
                  $meta_name[] = $d;
                }
              }
            }
            else {
              foreach ($data as $key => $d) {
                $meta_input[$meta_name[$key]] = $d;
              }
              $fname = preg_replace('/[^a-zA-Z0-9_.]/', '_', $meta_input['first_name']);
              $lname = preg_replace('/[^a-zA-Z0-9_.]/', '_', $meta_input['last_name']);
              $username = strtolower($fname . '_' . $lname);
              $password = 12345678;
              $email = $meta_input['user_email'];
              $user_id = create_new_vedor_user($username, $password, $email);
              $meta_input['user_id'] = $user_id;
              $new_post_id = create_new_vendor_post($data, $meta_input);
            }
            ?>
            <?php if ($row == 0) { ?>
              <thead>
                <tr class="head">
                  <?php foreach ($data as $key => $d) { ?>
                    <th><?php echo $d ?> [<?= $key ?>]</th>
                  <?php } ?>
                </tr>
              </thead>
            <?php }
            else { ?>
              <tr class="data">
                <?php foreach ($data as $d) { ?>
                  <td><?php echo $d ?></td>
                <?php } ?>
              </tr>
            <?php } ?>
          <?php } ?>
          <?php $row++; ?>
          <?php
        }
        ?>
      </table>
    </div>
    <?php
  }
  fclose($CSVfp);
  ?>
</main>
<?php
get_footer();
?>