<?php

if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<div class="comment list">
    <?php wp_list_comments( array( 'style' => 'div' ) ); ?>
	</div>

	<?php  comment_form();  ?>

</div><!-- #comments -->
