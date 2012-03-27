<?php include_once 'header.tpl.php'; ?>
<?php Utils::show_message('user', 'div'); ?>


<?php include_once 'header.tpl.php'; ?>
            <div id="contentArea">
                <div id="sidebar">
                    <?php include 'sidebar.tpl.php'; ?>
                </div>
                <div id="content">
                <?php if ($_action == 'index')
                {
                ?>
                    <table class="dataTable">
                        <thead>
                        <tr class="tableHeader">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        foreach ($_data['user_list'] as $this_user)
                        {
                            $remark_trimmed = Utils::trim_text($this_user['remarks'], 50);
                            if ($this_user['status'] == '1')
                            {
                                $status_icon = "<img src='images/active.png' alt='Active' title='This account is active' />";
                            }
                            else
                            {
                                $status_icon = "<img src='images/inactive.png' alt='Inactive' title='This account is disabled' />";
                            }
                            echo "<tr class='dataRow'>";
                                echo "<td class='oddCol'>{$this_user['name']}</td>";
                                echo "<td class='evenCol'>{$this_user['email']}</td>";
                                echo "<td class='oddCol'>{$this_user['country']}</td>";
                                echo "<td class='evenCol'><a style='cursor: help;' title='{$this_user['remarks']}'>$remark_trimmed</a></td>";
                                echo "<td class='oddCol'>{$status_icon}</td>";
                                echo "<td class='evenCol'>
                                        <a href='manage_users.php?action=user&user={$this_user['id']}'><img src='images/edit.png' alt='Edit' title='Edit' /></a>
                                        <a href='manage_users.php?action=delete_user&user={$this_user['id']}' onclick='return rufs(\"Delete this user\")'>
                                            <img src='images/delete.png' alt='Delete' title='Delete' />
                                        </a>
                                      </td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>

                    <a href="manage_users.php?start=<?php echo $_data['paging_start']-USER_PAGING_LIMIT; ?>">Prev</a>
                    <a href="manage_users.php?start=<?php echo $_data['paging_start']+USER_PAGING_LIMIT; ?>">Next</a>
                <?php
                }
                elseif ($_action == 'user')
                {
                ?>
                <?php Utils::show_message('user', 'div'); ?>
                    
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" name="userForm" method="post">
                    <input type="hidden" name="action" value="save_user" />
                    <?php
                        if (isset($_GET['user']))
                        {
                            echo '<input type="hidden" name="user" value="'.$_REQUEST['user'].'" />';
                        }
                    ?>
                    <table>
                        <tr>
                            <td>Name</td>
                            <td><input type="text" name="name" value="<?php echo $_data['user_data']['name']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><input type="text" name="email" value="<?php echo $_data['user_data']['email']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td><input type="text" name="country" value="<?php echo $_data['user_data']['country']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <label for="statusActive">Active</label>
                                <input type="radio" name="status" value="1" id="statusActive" <?php if ($_data['user_data']['status'] == 1) { echo 'checked="true"'; } ?> />
                                <label for="statusInctive">Inactive</label>
                                <input type="radio" name="status" value="0" id="statusInctive" <?php if ($_data['user_data']['status'] == 0) { echo 'checked="true"'; } ?> />
                            </td>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td><textarea name="remarks" ><?php echo $_data['user_data']['remarks']; ?></textarea></td>
                        </tr>
                       <tr>
                            <td></td>
                            <td><input type="submit" name="save" value="Save" /></td>
                        </tr>
                    </table>
                </form>
                <?php
                }
                ?>
                </div>
            </div>
<?php include_once 'footer.tpl.php'; ?>