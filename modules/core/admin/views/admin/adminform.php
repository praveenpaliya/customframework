<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('admin/saveAdmin'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo!empty($this->adminData) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('User'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="button" onclick="window.location = '<?php echo mainframe::__adminBuildUrl('admin/adminList'); ?>';" value="new" name="exit" class="btn btn-warning"><i class="icon-angle-left"></i> <?php echo $this->__aT('Back'); ?></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

        <div class="col-xs-12 innerbox">
            <fieldset>

                <div class="form-group">
                    <label><?php echo $this->__aT('Name'); ?></label>
                    <input type="text" class="form-control" name="md_name" value="<?php echo $this->adminData->name; ?>"/>
                </div>
                <div class="form-group">
                    <label><?php echo $this->__aT('Email'); ?></label>
                    <input type="text" class="form-control" name="md_email" value="<?php echo $this->adminData->email; ?>"/>
                </div>
                <div class="form-group">
                    <label><?php echo $this->__aT('Date of Birth'); ?></label>
                    <input type="text" data-attr="dob" class="form-control datepicker hasDatepicker" name="md_dob"  value="<?php echo $this->adminData->dob; ?>"/>
                </div>
                <?php if (empty($this->adminData->password)): ?>
                    <div class="form-group">
                        <label><?php echo $this->__aT('Password'); ?></label>
                        <input type="password" class="form-control" name="md_password" value="<?php echo $this->adminData->password; ?>"/>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label><?php echo $this->__aT('Contact'); ?></label>
                    <input type="text" class="form-control" name="md_phone" value="<?php echo $this->adminData->phone; ?>"/>
                </div>
                <div class="form-group">
                    <label class="col-md-2 nopadding control-label"><?php echo $this->__aT("Image"); ?></label> 
                    <div class="col-md-10">
                        <input type="file" data-style="fileinput" name="db_image"/>
                        <?php
                        if ($this->adminData->image != "") {
                            ?>
                            <img src="<?php echo SITE_URL . 'var/' . SITE_THEME . '/images/' . $this->adminData->image; ?>" style="height:150px;">
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Web mail'); ?></label>
                    <input type="text" class="form-control" name="db_webmail_link" placeholder="https://" value="<?php echo $this->adminData->webmail_link; ?>"/>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Address'); ?></label>
                    <textarea  class="form-control" name="md_address" ><?php echo $this->adminData->address; ?></textarea>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Status'); ?></label>
                    <select class="form-control" name="md_status">
                        <option value="1" <?php echo ($this->adminData->status == '1') ? 'selected' : '' ?>><?php echo $this->__aT('Active'); ?></option>
                        <option value="0" <?php echo ($this->adminData->status == '0') ? 'selected' : '' ?>><?php echo $this->__aT('In-active'); ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Admin Note'); ?></label>
                    <textarea  class="form-control" name="db_admin_note" ><?php echo $this->adminData->admin_note; ?></textarea>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Valid ID Proof'); ?></label>
                    <input type="text"  name="md_id_proof"  class="form-control" value="<?php echo $this->adminData->id_proof; ?>"/>
                </div>
                <div class="form-group">
                    <label><?php echo $this->__aT('SSN'); ?></label>
                    <input type="text"  name="md_ssn"  class="form-control" value="<?php echo $this->adminData->ssn; ?>"/>
                </div>
                <div class="form-group">
                    <label><?php echo (!empty($this->adminData->cv)) ? $this->__aT('Update CV') : $this->__aT('CV'); ?></label>
                    <input type="file"  name="db_cv"  class="form-control" value="<?php echo $this->adminData->cv; ?>"/>
                    <?php if (!empty($this->adminData->cv)): ?>
                        <a href="<?php echo SITE_URL . SITE_UPLOADPATH . $this->adminData->cv ?>"><?php echo $this->adminData->cv ?></a>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><?php echo $this->__aT('Documents'); ?></label>
                    <div>
                        <?php
                        if (!empty($this->adminData->doc)) {
                            $docs = json_decode($this->adminData->doc);
                            foreach ($docs as $doc) {
                                echo "<div>";
                                echo '<a href="' . SITE_URL . SITE_UPLOADPATH . $doc . '">' . $doc . '</a> &nbsp;&nbsp;';
                                echo '<i class="fa fa-remove" style="color:#ff6666" onclick="removeElement(this);" title="Remove file"></i>'."<br>";
                                echo '<input type="hidden" name="oldDoc[]" value="'.$doc.'">';
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div id="document" >
                        <input type="file"  name="doc[]"  class="form-control"/>
                    </div>
                    <br>
                    <a href="javasccript:void(0);" onclick="addDoc();" class="btn btn-info"> &plus; Add Document</a>
                </div>

                <?php if (!empty($this->adminData->password)): ?>
                    <div class="form-group">
                        <label><?php echo $this->__aT('Change Password'); ?></label>
                        <input type="password" class="form-control" name="cng_password"/>
                    </div>
                <?php endif; ?>

            </fieldset>
            <div>
                <input type="hidden" name="id" value="<?php echo $this->adminData->id; ?>">
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>
            </div>
        </div>	
    </div>
</form>



<script>
    function addDoc() {
        var element = '<div>'
                + '<div class="col-md-11" style="padding-left:0px;padding-right: 0px;">'
                + '<input type="file"  name="doc[]"  class="form-control"/>'
                + '</div>'
                + '<i class="fa fa-remove" style="color:#ff6666;position:relative;left: 0px;top: 14px;" onclick="removeElement(this);" title="Remove"></i>'
                + '</div>';
        $('#document').append(element);
    }

    function removeElement(ev) {
        $(ev).parent().remove();
    }
</script>