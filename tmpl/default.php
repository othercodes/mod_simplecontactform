<?php

/**
 * @package OtherCode.Joomla.SimpleContactForm
 * @subpackage mod_simplecontactform
 * @copyright Copyright (C) 2016 OtherCode. All rights reserved.
 * @license MIT
 */
defined('_JEXEC') or die;
?>

<div id="oc-simplecontactform" class="<?php echo $moduleclass_sfx ?>">

    <?php if (!empty($prevtext)) { ?>
        <div class="oc-prev-text"><?php echo $prevtext; ?></div>
    <?php } ?>

    <form id="oc-form" name="oc-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="send" value="1">

        <div class="form-group">
            <?php if ($labels === '1') { ?><label for="email"><?php echo JText::_('MOD_SIMPLECONTACTFORM_EMAIL'); ?></label><?php } ?>
            <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo JText::_('MOD_SIMPLECONTACTFORM_EMAIL'); ?>" required>
        </div>
        <div class="form-group">
            <?php if ($labels === '1') { ?><label for="name"><?php echo JText::_('MOD_SIMPLECONTACTFORM_NAME'); ?></label><?php } ?>
            <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo JText::_('MOD_SIMPLECONTACTFORM_NAME'); ?>" required>
        </div>
        <div class="form-group">
            <?php if ($labels === '1') { ?><label for="subject"><?php echo JText::_('MOD_SIMPLECONTACTFORM_SUBJECT'); ?></label><?php } ?>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="<?php echo JText::_('MOD_SIMPLECONTACTFORM_SUBJECT'); ?>" required>
        </div>
        <div class="form-group">
            <?php if ($labels === '1') { ?><label for="comment"><?php echo JText::_('MOD_SIMPLECONTACTFORM_COMMENT'); ?></label><?php } ?>
            <textarea class="form-control" id="comment" name="comment" placeholder="<?php echo JText::_('MOD_SIMPLECONTACTFORM_COMMENT_DETAIL'); ?>" required></textarea>
        </div>

        <button type="submit" class="btn btn-default"><?php echo JText::_('MOD_SIMPLECONTACTFORM_SUBMIT'); ?></button>
        <button type="reset" class="btn btn-default"><?php echo JText::_('MOD_SIMPLECONTACTFORM_RESET'); ?></button>

    </form>

</div>
