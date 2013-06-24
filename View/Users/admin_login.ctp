
<div class="users form login">
	<?php echo $this->Form->create('User');?>
	    <fieldset>
	        <legend><?php echo __('Please sign in'); ?></legend>
	    <?php
	        echo $this->Form->input('email',array(
	        	'placeholder' => 'Email',
                        'class' => 'input-block-level'
	        ));
	        echo $this->Form->input('password',array(
	        	'placeholder' => 'Password',
                        'class' => 'input-block-level'
	        ));
	    ?>
	    </fieldset>
	    <?php echo $this->Form->end(__('Sign in'));?>
</div>

