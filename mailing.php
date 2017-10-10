<?php
/**
 * Author: yamilelias
 * Author URI: <yamileliassoto@gmail.com>
 * Date: 6/10/17
 * Time: 01:29 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use Com\Detalhe\Core\Controllers\Mailer;

$mail = new Mailer();
$mail->send_mail();
?>
    <script>alert("Yep it opened")</script>
<!--    <script>window.location.replace("--><?php //get_site_url(); ?>//")</script>
<?php
