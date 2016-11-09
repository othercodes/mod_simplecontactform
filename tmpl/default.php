<?php

/**
 * @package OtherCode.Joomla
 * @subpackage mod_simplecontactform
 * @copyright Copyright (C) 2016 OtherCode. All rights reserved.
 * @version 1.4.0
 * @license MIT
 */
defined('_JEXEC') or die('Restricted access');
?>

<div id="oc-simplecontactform" class="<?php echo $moduleclass_sfx ?>">

    <?php if (!empty($prevtext)) { ?>
        <div class="oc-prev-text"><?php echo $prevtext; ?></div>
    <?php } ?>

    <form id="oc-form" name="oc-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="send" value="<?php echo $instance; ?>">
        <?php echo JHtml::_('form.token'); ?>

        <?php if ($showemail === '1') { ?>
            <div class="form-group">
                <?php if ($labels === '1') { ?><label for="email"><?php echo JText::_('MOD_SIMPLECONTACTFORM_EMAIL'); ?></label><?php } ?>
                <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo JText::_('MOD_SIMPLECONTACTFORM_EMAIL'); ?>" required>
            </div>
        <?php } ?>
        <div class="form-group">
            <?php if ($labels === '1') { ?><label for="name"><?php echo JText::_('MOD_SIMPLECONTACTFORM_NAME'); ?></label><?php } ?>
            <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo JText::_('MOD_SIMPLECONTACTFORM_NAME'); ?>" required>
        </div>
        <?php if ($showsubject === '1') { ?>
            <div class="form-group">
                <?php if ($labels === '1') { ?><label for="subject"><?php echo JText::_('MOD_SIMPLECONTACTFORM_SUBJECT'); ?></label><?php } ?>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="<?php echo JText::_('MOD_SIMPLECONTACTFORM_SUBJECT'); ?>" required>
            </div>
        <?php } ?>
        <?php if ($showphone === '1') { ?>
            <div class="form-group">
                <?php if ($labels === '1') { ?><label for="phone"><?php echo JText::_('MOD_SIMPLECONTACTFORM_PHONE'); ?></label><?php } ?>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="<?php echo JText::_('MOD_SIMPLECONTACTFORM_PHONE'); ?>" required>
            </div>
        <?php } ?>
        <?php if ($showcontactdropdown === '1') { ?>
            <div class="form-group">
                <?php if ($labels === '1') { ?><label for="destiny"><?php echo JText::_('MOD_SIMPLECONTACTFORM_SUBJECT'); ?></label><?php } ?>
                <select class="form-control" id="destiny" name="destiny" required>
                    <?php foreach ($contactList as $item) { ?>
                        <option value="<?php echo $item->value; ?>"><?php echo $item->text; ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
        <?php if ($showupload === '1') { ?>
            <div class="form-group">
                <?php if ($labels === '1') { ?><label for="ufile"><?php echo JText::_('MOD_SIMPLECONTACTFORM_UPLOAD'); ?></label><?php } ?>
                <input type="file" class="form-control" id="ufile" name="ufile" accept="*/*" required>
            </div>
        <?php } ?>
        <?php if ($showcomment === '1') { ?>
            <div class="form-group">
                <?php if ($labels === '1') { ?><label for="comment"><?php echo JText::_('MOD_SIMPLECONTACTFORM_COMMENT'); ?></label><?php } ?>
                <textarea class="form-control" id="comment" name="comment" placeholder="<?php echo JText::_('MOD_SIMPLECONTACTFORM_COMMENT_DETAIL'); ?>" required></textarea>
            </div>
        <?php } ?>
        <?php if (!empty($nexttext)) { ?>
            <div class="oc-next-text"><?php echo $nexttext; ?></div>
        <?php } ?>

        <div class="button-group">
            <button type="submit" class="btn btn-default"><?php echo JText::_('MOD_SIMPLECONTACTFORM_SUBMIT'); ?></button>
            <?php if ($reset === '1') { ?>
                <button type="reset" class="btn btn-default"><?php echo JText::_('MOD_SIMPLECONTACTFORM_RESET'); ?></button>
            <?php } ?>
        </div>
    </form>

</div>
